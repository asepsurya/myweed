<?php

namespace App\Http\Controllers;

use App\Models\Invitation;

class WeddingController extends Controller
{
    public function show(string $slug)
    {
        $invitation = Invitation::with([
            'template',
            'category',
            'galleries',
            'rsvps',
            'musicPreset',
            'user.subscription.plan',
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

        $category = $invitation->category;
        $customData = $invitation->custom_data ?? [];
        if (is_string($customData)) {
            $customData = json_decode($customData, true) ?? [];
        }

        // Determine display names based on category type
        $primaryName = $invitation->groom_nickname ?? $invitation->groom_name
            ?? data_get($customData, 'groom_name')
            ?? data_get($customData, 'celebrant_name')
            ?? data_get($customData, 'child_name')
            ?? data_get($customData, 'graduate_name')
            ?? data_get($customData, 'event_name')
            ?? 'Mempelai';
        $secondaryName = $invitation->bride_nickname ?? $invitation->bride_name
            ?? data_get($customData, 'bride_name')
            ?? data_get($customData, 'parent_names')
            ?? data_get($customData, 'organizer');
        $eventDate = $invitation->wedding_date
            ?? data_get($customData, 'akad_date')
            ?? data_get($customData, 'event_date')
            ?? data_get($customData, 'birthday_date')
            ?? data_get($customData, 'graduation_date');

        $isWedding = ($invitation->invitation_type ?? 'wedding') === 'wedding' || ($category ? $category->slug === 'wedding' : false);

        if ($isWedding) {
            $seoTitle = "Undangan {$primaryName} & {$secondaryName} - RuangUndang";
            $seoDescription = "Undangan pernikahan digital untuk {$primaryName} dan {$secondaryName}.";
        } else {
            $seoTitle = "Undangan {$primaryName} - RuangUndang";
            $seoDescription = "Undangan digital untuk {$primaryName}.";
            if ($category && $category->name) {
                $seoDescription .= " Kategori: {$category->name}.";
            }
        }
        if ($eventDate) {
            $seoDescription .= ' Acara akan dilaksanakan pada '.date('d F Y', strtotime($eventDate)).'.';
        }
        $seoDescription .= ' Konfirmasi kehadiran Anda melalui tautan ini.';

        $pageImage = $invitation->galleries->first()
            ? storage_url_with_fallback($invitation->galleries->first()->image, asset('assets/og-image.png'), ($invitation->updated_at ?? now())->timestamp)
            : asset('assets/og-image.png');

        $jsonLd = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Event',
                'name' => $isWedding ? "Pernikahan {$primaryName} & {$secondaryName}" : "Acara {$primaryName}",
                'description' => $seoDescription,
                'startDate' => $eventDate,
                'eventStatus' => 'https://schema.org/EventScheduled',
                'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
                'organizer' => [
                    '@type' => 'Person',
                    'name' => $primaryName,
                ],
                'performer' => [
                    ['@type' => 'Person', 'name' => $primaryName],
                ],
                'url' => url()->current(),
            ],
        ];

        if ($isWedding && $secondaryName) {
            $jsonLd[0]['performer'][] = ['@type' => 'Person', 'name' => $secondaryName];
        }

        $location = $invitation->resepsi_location ?? $invitation->akad_location
            ?? data_get($customData, 'event_location')
            ?? data_get($customData, 'reception_location')
            ?? data_get($customData, 'akad_location');
        $address = $invitation->resepsi_address ?? $invitation->akad_address
            ?? data_get($customData, 'event_description');

        if ($location || $address) {
            $jsonLd[0]['location'] = [
                '@type' => 'Place',
                'name' => $location,
                'address' => $address ?? $location,
            ];
        }

        $canonicalUrl = route('invitation.show', $invitation->slug);
        $noIndex = ($invitation->status ?? 'published') !== 'published';

        view()->share('seoTitle', $seoTitle);
        view()->share('seoDescription', $seoDescription);
        view()->share('seoImage', $pageImage);
        view()->share('canonicalUrl', $canonicalUrl);
        view()->share('noIndex', $noIndex);
        view()->share('jsonLd', $jsonLd);

        $guestName = request()->query('penerima');
        $isOwner = auth()->check() && auth()->id() === $invitation->user_id;

        return view($templateView, compact('invitation', 'guestName', 'customData', 'category', 'isWedding'));
    }
}
