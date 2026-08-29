<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function personalLink(): string
    {
        $invitation = Invitation::where('user_id', $this->user_id)->first();
        $slug = $invitation ? $invitation->slug : 'undangan';
        $baseUrl = route('invitation.show', ['slug' => $slug]);
        return $baseUrl . '?penerima=' . urlencode($this->name);
    }

    public function whatsappLink(string $template = null): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone);

        if (!$template) {
            $template = "Halo {name}, undangan untuk Anda:\n\n{link}\n\nTerima kasih!";
        }

        $message = str_replace(
            ['{name}', '{link}'],
            [$this->name, $this->personalLink()],
            $template
        );

        $message = urlencode($message);

        return "https://wa.me/{$phone}?text={$message}";
    }
}
