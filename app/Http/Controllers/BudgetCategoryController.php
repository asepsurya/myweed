<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetCategory;
use App\Models\Invitation;
use Illuminate\Http\Request;

class BudgetCategoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);

        $budget = Budget::firstOrCreate(
            ['invitation_id' => $invitationId, 'user_id' => $user->id],
            ['title' => 'Anggaran Pernikahan', 'total_amount' => 0]
        );

        $categories = $budget->categories()
            ->withCount('expenses')
            ->withSum('expenses', 'amount')
            ->orderBy('sort_order')
            ->get();

        return view('budget.category.index', compact('categories', 'budget', 'invitationId'));
    }

    public function store(Request $request)
    {
        if (! $request->user()->hasFeature('budget_management')) {
            return back()->with('warning', 'Fitur ini membutuhkan langganan yang lebih tinggi.');
        }

        $invitationId = $this->resolveInvitationId($request, $request->user());

        $budget = Budget::firstOrCreate(
            ['invitation_id' => $invitationId, 'user_id' => $request->user()->id],
            ['title' => 'Anggaran Pernikahan', 'total_amount' => 0]
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'colour' => ['nullable', 'string', 'max:7'],
            'allocated_amount' => ['required', 'numeric', 'min:0'],
            'note' => ['nullable', 'string'],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
        ]);

        $budget->categories()->create($validated);

        return redirect()->route('budget.category.index')
            ->with('success', 'Kategori anggaran berhasil ditambahkan 🎨');
    }

    public function edit(BudgetCategory $category)
    {
        $this->authorizeCategory($category);
        $budget = $category->budget;

        return view('budget.category.edit', compact('category', 'budget'));
    }

    public function update(Request $request, BudgetCategory $category)
    {
        $this->authorizeCategory($category);

        if (! $request->user()->hasFeature('budget_management')) {
            return back()->with('warning', 'Fitur ini membutuhkan langganan yang lebih tinggi.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'colour' => ['nullable', 'string', 'max:7'],
            'allocated_amount' => ['required', 'numeric', 'min:0'],
            'note' => ['nullable', 'string'],
        ]);

        $category->update($validated);

        return redirect()->route('budget.category.index', ['budget_id' => $category->budget_id])
            ->with('success', 'Kategori anggaran berhasil diperbarui 🎨');
    }

    public function destroy(BudgetCategory $category)
    {
        $this->authorizeCategory($category);

        $category->delete();

        return back()->with('success', 'Kategori anggaran berhasil dihapus 🗑️');
    }

    private function authorizeCategory(BudgetCategory $category): void
    {
        if ($category->budget->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kategori ini.');
        }
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
}
