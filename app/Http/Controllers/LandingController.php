<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Invitation;
use App\Models\SubscriptionPlan;
use App\Models\Template;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $realCategories = Category::orderBy('name')->get();

        $query = Template::where('is_active', true)
            ->with('category');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    });
            });
        }

        if ($request->has('category') && $request->category != 'All') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        $templates = $query->get();

        $invitations = Invitation::with(['template', 'galleries'])
            ->latest()
            ->take(12)
            ->get();

        $categories = $realCategories->map(function ($cat) {
            return [
                'name' => $cat->name,
                'count' => Template::where('id_category', $cat->id)->count().'+',
                'img' => 'https://picsum.photos/seed/'.strtolower($cat->name).'/400/300',
            ];
        });

        return view('index', compact('templates', 'categories', 'invitations'));
    }

    public function caraPemesanan()
    {
        return view('pages.cara-pemesanan');
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function syaratKetentuan()
    {
        return view('pages.syarat-ketentuan');
    }

    public function kebijakanPrivasi()
    {
        return view('pages.kebijakan-privasi');
    }

    public function cariTema(Request $request)
    {
        $realCategories = Category::orderBy('name')->get();

        $query = Template::where('is_active', true)
            ->with('category');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    });
            });
        }

        if ($request->has('category') && $request->category != 'All') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        $templates = $query->get();

        $categories = $realCategories->map(function ($cat) {
            return [
                'name' => $cat->name,
                'count' => Template::where('id_category', $cat->id)->count().'+',
            ];
        });

        return view('pages.cari-tema', compact('templates', 'categories'));
    }

    public function fitur()
    {
        return view('pages.fitur');
    }

    public function harga()
    {
        $plans = SubscriptionPlan::all();

        return view('pages.harga', compact('plans'));
    }

    public function bantuan()
    {
        return view('pages.bantuan');
    }
}
