<?php

namespace App\Http\Controllers;

use App\Models\TemplateType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TemplateTypeController extends Controller
{
    public function index(Request $request)
    {
        $types = TemplateType::orderBy('name')->get();

        return response()->json($types);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:template_types,name',
        ]);

        $type = TemplateType::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'color' => $request->color ?? '#6c757d',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Template type berhasil ditambahkan.',
            'type' => $type,
        ]);
    }

    public function destroy(TemplateType $templateType)
    {
        $templateCount = $templateType->templates()->count();

        if ($templateCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Tipe template tidak bisa dihapus karena masih ada {$templateCount} template yang menggunakan tipe ini.",
            ], 422);
        }

        $templateType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tipe template berhasil dihapus.',
        ]);
    }
}
