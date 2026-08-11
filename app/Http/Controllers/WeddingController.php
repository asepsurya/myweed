<?php

namespace App\Http\Controllers;

use App\Models\Invitation;

class WeddingController extends Controller
{
    public function show(string $slug)
    {
        $invitation = Invitation::with([
            'template',
            'galleries',
            'rsvps',
            'musicPreset',
        ])
            ->where('slug', $slug)
            ->first();
        if (! $invitation) {
            abort(404);
        }

        if (! $invitation->template) {
            abort(404, 'Template tidak ditemukan');
        }

        $templateView = 'templates.'.$invitation->template->slug.'.index';

        if (! view()->exists($templateView)) {
            abort(404, 'Template tidak ditemukan');
        }

        return view($templateView, compact('invitation'));
    }
}
