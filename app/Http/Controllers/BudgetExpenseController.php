<?php

namespace App\Http\Controllers;

use App\Models\BudgetCategory;
use App\Models\BudgetExpense;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BudgetExpenseController extends Controller
{
    private const PAYMENT_METHODS = ['cash', 'transfer', 'e-wallet', 'credit', 'card'];

    public function index(Request $request)
    {
        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);

        $expenses = BudgetExpense::where('invitation_id', $invitationId)
            ->where('user_id', $user->id)
            ->with('category')
            ->when($request->filled('category'), function ($q) use ($request) {
                $q->where('budget_category_id', $request->category);
            })
            ->when($request->filled('method'), function ($q) use ($request) {
                $q->where('payment_method', $request->method);
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('vendor_name', 'like', "%{$request->search}%")
                        ->orWhere('description', 'like', "%{$request->search}%");
                });
            })
            ->when($request->filled('date_from'), function ($q) use ($request) {
                $q->whereDate('expense_date', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($q) use ($request) {
                $q->whereDate('expense_date', '<=', $request->date_to);
            })
            ->latest('expense_date')
            ->paginate(20)
            ->withQueryString();

        $categories = BudgetCategory::whereHas('budget', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->pluck('name', 'id');

        return view('budget.expense.index', compact(
            'expenses',
            'categories',
            'invitationId'
        ));
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);
        $categories = $this->categoriesFor($user);

        return view('budget.expense.create', compact('categories', 'invitationId'));
    }

    public function store(Request $request)
    {
        if (! $request->user()->hasFeature('budget_expenses')) {
            return back()->with('warning', 'Pencatatan pengeluaran membutuhkan langganan Basic atau Pro.');
        }

        $validated = $request->validate([
            'budget_category_id' => ['required', 'exists:budget_categories,id'],
            'vendor_name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'expense_date' => ['required', 'date'],
            'payment_method' => ['required', Rule::in(self::PAYMENT_METHODS)],
            'description' => ['nullable', 'string'],
            'receipt' => ['nullable', 'image', 'max:2048'],
            'is_paid' => ['boolean'],
        ], [
            'budget_category_id.required' => 'Kategori anggaran wajib dipilih.',
            'budget_category_id.exists' => 'Kategori anggaran tidak valid.',
            'vendor_name.required' => 'Nama vendor wajib diisi.',
            'amount.required' => 'Jumlah pengeluaran wajib diisi.',
            'expense_date.required' => 'Tanggal pengeluaran wajib diisi.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        $validated['invitation_id'] = $this->resolveInvitationId($request, $request->user());
        $validated['user_id'] = $request->user()->id;

        $category = BudgetCategory::findOrFail($validated['budget_category_id']);
        if ($category->budget->user_id !== $request->user()->id && ! $request->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke kategori ini.');
        }

        if ($request->hasFile('receipt')) {
            $validated['receipt_path'] = $request->file('receipt')->store('budget_receipts', 'public');
        }

        BudgetExpense::create($validated);

        return redirect()->route('budget.expense.index')
            ->with('success', 'Pengeluaran berhasil dicatat 📝');
    }

    public function edit(BudgetExpense $expense)
    {
        $this->authorizeExpense($expense);
        $categories = $this->categoriesFor(auth()->user());

        return view('budget.expense.create', compact('expense', 'categories'));
    }

    public function update(Request $request, BudgetExpense $expense)
    {
        $this->authorizeExpense($expense);

        if (! $request->user()->hasFeature('budget_expenses')) {
            return back()->with('warning', 'Pencatatan pengeluaran membutuhkan langganan Basic atau Pro.');
        }

        $validated = $request->validate([
            'budget_category_id' => ['required', 'exists:budget_categories,id'],
            'vendor_name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'expense_date' => ['required', 'date'],
            'payment_method' => ['required', Rule::in(self::PAYMENT_METHODS)],
            'description' => ['nullable', 'string'],
            'receipt' => ['nullable', 'image', 'max:2048'],
            'is_paid' => ['boolean'],
        ]);

        if ($request->hasFile('receipt')) {
            if ($expense->receipt_path) {
                Storage::disk('public')->delete($expense->receipt_path);
            }
            $validated['receipt_path'] = $request->file('receipt')->store('budget_receipts', 'public');
        }

        $expense->update($validated);

        return redirect()->route('budget.expense.index')
            ->with('success', 'Pengeluaran berhasil diperbarui 📝');
    }

    public function destroy(BudgetExpense $expense)
    {
        $this->authorizeExpense($expense);

        if ($expense->receipt_path) {
            Storage::disk('public')->delete($expense->receipt_path);
        }

        $expense->delete();

        return back()->with('success', 'Pengeluaran berhasil dihapus 🗑️');
    }

    public function togglePaid(BudgetExpense $expense)
    {
        $this->authorizeExpense($expense);

        $expense->update(['is_paid' => ! $expense->is_paid]);

        return back()->with('success', 'Status pembayaran berhasil diubah.');
    }

    private function resolveInvitationId(Request $request, $user): int
    {
        $invitationId = $request->query('invitation_id') ?: $request->input('invitation_id');

        if ($invitationId) {
            return (int) $invitationId;
        }

        return $user->isAdmin()
            ? Invitation::first()->id
            : Invitation::where('user_id', $user->id)->value('id');
    }

    private function categoriesFor($user)
    {
        return BudgetCategory::whereHas('budget', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->pluck('name', 'id');
    }

    private function authorizeExpense(BudgetExpense $expense): void
    {
        if (! auth()->user()->canAccessInvitation($expense->invitation)) {
            abort(403, 'Anda tidak memiliki akses ke pengeluaran ini.');
        }
    }
}
