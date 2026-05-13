<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori unik dari templates
        $realCategories = Template::select('category')->distinct()->pluck('category');

        // Query templates yang aktif
        $query = Template::where('is_active', true);
        
        // Filter berdasarkan pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('category', 'like', "%$search%");
            });
        }

        // Filter berdasarkan kategori jika ada
        if ($request->has('category') && $request->category != 'All') {
            $query->where('category', $request->category);
        }

        $templates = $query->get();
        
        // Ambil data pengantin yang sudah memilih template (Real Wedding examples)
        $invitations = \App\Models\Invitation::with(['template', 'galleries'])
            ->latest()
            ->take(12)
            ->get();
        
        // Format categories for the UI
        $categories = $realCategories->map(function($cat) {
            return [
                'name' => $cat,
                'count' => Template::where('category', $cat)->count() . '+',
                'img' => 'https://picsum.photos/seed/' . strtolower($cat) . '/400/300'
            ];
        });

        return view('index', compact('templates', 'categories', 'invitations'));
    }
}
