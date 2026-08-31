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

        $groomName = $invitation->groom_nickname ?? $invitation->groom_name ?? 'Mempelai Pria';
        $brideName = $invitation->bride_nickname ?? $invitation->bride_name ?? 'Mempelai Wanita';
        $weddingDate = $invitation->wedding_date;

        $seoTitle = "Undangan {$groomName} & {$brideName} - RuangUndang";
        $seoDescription = "Undangan pernikahan digital untuk {$groomName} dan {$brideName}.";
        if ($weddingDate) {
            $seoDescription .= ' Acara akan dilaksanakan pada '.date('d F Y', strtotime($weddingDate)).'.';
        }
        $seoDescription .= ' Konfirmasi kehadiran Anda melalui tautan ini.';

        $pageImage = $invitation->galleries->first()
            ? storage_url_with_fallback($invitation->galleries->first()->image, asset('assets/og-image.png'), ($invitation->updated_at ?? now())->timestamp)
            : asset('assets/og-image.png');

        $jsonLd = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Event',
                'name' => "Pernikahan {$groomName} & {$brideName}",
                'description' => $seoDescription,
                'startDate' => $weddingDate,
                'eventStatus' => 'https://schema.org/EventScheduled',
                'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
                'organizer' => [
                    '@type' => 'Person',
                    'name' => $groomName,
                ],
                'performer' => [
                    ['@type' => 'Person', 'name' => $groomName],
                    ['@type' => 'Person', 'name' => $brideName],
                ],
                'url' => url()->current(),
            ],
        ];

        if ($invitation->akad_location || $invitation->resepsi_location) {
            $location = $invitation->resepsi_location ?? $invitation->akad_location;
            $address = $invitation->resepsi_address ?? $invitation->akad_address;
            $jsonLd[0]['location'] = [
                '@type' => 'Place',
                'name' => $location,
                'address' => $address ?? $location,
            ];
        }

        view()->share('seoTitle', $seoTitle);
        view()->share('seoDescription', $seoDescription);
        view()->share('seoImage', $pageImage);
        view()->share('jsonLd', $jsonLd);

        $guestName = request()->query('penerima');
        $isOwner = auth()->check() && auth()->id() === $invitation->user_id;

        return view($templateView, compact('invitation', 'guestName', 'isOwner'));
    }
}
