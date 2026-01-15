<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class WeddingController extends Controller
{
    public function show(string $slug)
    {
        $invitation = Invitation::with([
                'template',
                'galleries',
                'rsvps'
            ])
            ->where('slug', $slug)
            ->first();
             if (!$invitation) {
                    abort(404); // <-- ini wajib
            }
        // Tentukan view template berdasarkan slug template
        $templateView = 'templates.' . $invitation->template->slug . '.index';

        // Jika template tidak ada (safety)
        if (!view()->exists($templateView)) {
            abort(404, 'Template tidak ditemukan');
        }

        return view($templateView, compact('invitation'));
    }
}
