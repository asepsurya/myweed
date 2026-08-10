<?php

namespace App\Http\Controllers;

use App\Models\WeedingPlan;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeedingPlanController extends Controller
{
    public function index(Request $request)
    {
        $query = WeedingPlan::where('user_id', auth()->id())
            ->with('invitation')
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('task_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $plans = $query->paginate(20);
        $invitations = Invitation::where('user_id', auth()->id())->get();

        $stats = [
            'total' => WeedingPlan::where('user_id', auth()->id())->count(),
            'pending' => WeedingPlan::where('user_id', auth()->id())->where('status', 'pending')->count(),
            'in_progress' => WeedingPlan::where('user_id', auth()->id())->where('status', 'in_progress')->count(),
            'completed' => WeedingPlan::where('user_id', auth()->id())->where('status', 'completed')->count(),
            'overdue' => WeedingPlan::where('user_id', auth()->id())
                ->where('status', '!=', 'completed')
                ->where('due_date', '<', now()->toDateString())
                ->count(),
        ];

        return view('weeding-plan.index', compact('plans', 'invitations', 'stats'));
    }

    public function create()
    {
        $invitations = Invitation::where('user_id', auth()->id())->get();
        return view('weeding-plan.create', compact('invitations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invitation_id' => 'nullable|exists:invitations,id',
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|in:akad,resepsi,persiapan,pakaian,kado,tamu,dokumentasi,lainnya',
            'due_date' => 'nullable|date|after:today',
            'priority' => 'required|in:low,medium,high',
            'notes' => 'nullable|string|max:1000',
        ], [
            'task_name.required' => 'Nama tugas wajib diisi.',
            'task_name.max' => 'Nama tugas tidak boleh melebihi 255 karakter.',
            'due_date.after' => 'Tanggal target harus di masa depan.',
            'category.required' => 'Kategori wajib dipilih.',
            'priority.required' => 'Prioritas wajib dipilih.',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        WeedingPlan::create($validated);

        return redirect()->route('weeding-plan.index')->with('success', 'Rencana weeding berhasil ditambahkan 💐');
    }

    public function edit(WeedingPlan $weedingPlan)
    {
        $this->authorizePlan($weedingPlan);
        $invitations = Invitation::where('user_id', auth()->id())->get();
        return view('weeding-plan.edit', compact('weedingPlan', 'invitations'));
    }

    public function update(Request $request, WeedingPlan $weedingPlan)
    {
        $this->authorizePlan($weedingPlan);

        $validated = $request->validate([
            'invitation_id' => 'nullable|exists:invitations,id',
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|in:akad,resepsi,persiapan,pakaian,kado,tamu,dokumentasi,lainnya',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($request->status === 'completed' && !$weedingPlan->completed_at) {
            $validated['completed_at'] = now();
        } elseif ($request->status !== 'completed') {
            $validated['completed_at'] = null;
        }

        $weedingPlan->update($validated);

        return redirect()->route('weeding-plan.index')->with('success', 'Rencana weeding berhasil diperbarui 💐');
    }

    public function destroy(WeedingPlan $weedingPlan)
    {
        $this->authorizePlan($weedingPlan);
        $weedingPlan->delete();

        return redirect()->route('weeding-plan.index')->with('success', 'Rencana weeding berhasil dihapus 🗑️');
    }

    public function toggleStatus(WeedingPlan $weedingPlan)
    {
        $this->authorizePlan($weedingPlan);

        $statuses = ['pending', 'in_progress', 'completed'];
        $currentIndex = array_search($weedingPlan->status, $statuses);
        $nextIndex = ($currentIndex + 1) % count($statuses);
        $newStatus = $statuses[$nextIndex];

        $updateData = ['status' => $newStatus];

        if ($newStatus === 'completed') {
            $updateData['completed_at'] = now();
        } else {
            $updateData['completed_at'] = null;
        }

        $weedingPlan->update($updateData);

        return back()->with('success', 'Status berhasil diubah menjadi ' . $this->getStatusLabel($newStatus));
    }

    private function authorizePlan(WeedingPlan $weedingPlan): void
    {
        if ($weedingPlan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke rencana ini.');
        }
    }

    private function getStatusLabel(string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu',
            'in_progress' => 'Sedang Dikerjakan',
            'completed' => 'Selesai',
            default => $status,
        };
    }
}
