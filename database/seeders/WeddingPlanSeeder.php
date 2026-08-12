<?php

namespace Database\Seeders;

use App\Models\Invitation;
use App\Models\WeedingPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class WeddingPlanSeeder extends Seeder
{
    public function run(): void
    {
        $invitation = Invitation::first();

        if (! $invitation) {
            return;
        }

        $user = $invitation->user;

        if (! $user) {
            return;
        }

        $weddingDate = Carbon::parse($invitation->wedding_date)->startOfDay();

        $tasks = [
            [
                'task_name' => 'Tetapkan tanggal pernikahan',
                'description' => 'Diskusikan dan pilih tanggal pernikahan yang cocok dengan keluarga kedua belah pihak.',
                'category' => 'persiapan',
                'due_date' => $weddingDate->copy()->subMonths(12)->format('Y-m-d'),
                'status' => 'completed',
                'priority' => 'high',
                'notes' => 'Selesai pada minggu pertama',
                'completed_at' => $weddingDate->copy()->subMonths(12)->addDays(3),
            ],
            [
                'task_name' => 'Buat daftar tamu undangan',
                'description' => 'Rekam semua nama dan alamat tamu dari keluarga dan teman.',
                'category' => 'undangan',
                'due_date' => $weddingDate->copy()->subMonths(10)->format('Y-m-d'),
                'status' => 'completed',
                'priority' => 'high',
                'notes' => 'Sudah diverifikasi',
                'completed_at' => $weddingDate->copy()->subMonths(10)->addDays(5),
            ],
            [
                'task_name' => 'Pilih vendor fotografer',
                'description' => 'Bandingkan paket foto dan video dari beberapa vendor, lalu lakukan booking.',
                'category' => 'vendor',
                'due_date' => $weddingDate->copy()->subMonths(8)->format('Y-m-d'),
                'status' => 'completed',
                'priority' => 'high',
                'notes' => 'DP sudah dibayar',
                'completed_at' => $weddingDate->copy()->subMonths(8)->addDays(2),
            ],
            [
                'task_name' => 'Pilih tempat resepsi',
                'description' => 'Survey beberapa venue, cek kapasitas, harga, dan ketersediaan tanggal.',
                'category' => 'venue',
                'due_date' => $weddingDate->copy()->subMonths(9)->format('Y-m-d'),
                'status' => 'completed',
                'priority' => 'high',
                'notes' => 'Booking gedung ballroom',
                'completed_at' => $weddingDate->copy()->subMonths(9)->addDays(7),
            ],
            [
                'task_name' => 'Pilih busana pengantin',
                'description' => 'Kunjungi boutique atau desainer untuk fitting gaun dan jas pengantin.',
                'category' => 'persiapan',
                'due_date' => $weddingDate->copy()->subMonths(6)->format('Y-m-d'),
                'status' => 'completed',
                'priority' => 'medium',
                'notes' => 'Gaun pengantin sudah dipilih',
                'completed_at' => $weddingDate->copy()->subMonths(6)->addDays(4),
            ],
            [
                'task_name' => 'Buat daftar acara dan rundown',
                'description' => 'Susun rundown acara mulai dari akad, resepsi, sampai hiburan.',
                'category' => 'acara',
                'due_date' => $weddingDate->copy()->subMonths(3)->format('Y-m-d'),
                'status' => 'completed',
                'priority' => 'high',
                'notes' => 'Sudah didiskusikan dengan MC',
                'completed_at' => $weddingDate->copy()->subMonths(3)->addDays(1),
            ],
            [
                'task_name' => 'Kirim undangan digital',
                'description' => 'Kirim e-card undangan kepada seluruh tamu yang telah terdaftar.',
                'category' => 'undangan',
                'due_date' => $weddingDate->copy()->subMonths(2)->format('Y-m-d'),
                'status' => 'completed',
                'priority' => 'high',
                'notes' => 'Terverkirim ke 250 tamu',
                'completed_at' => $weddingDate->copy()->subMonths(2)->addDays(3),
            ],
            [
                'task_name' => 'Konfirmasi RSVP tamu',
                'description' => 'Pantau dan ikuti konfirmasi kehadiran tamu setiap hari.',
                'category' => 'undangan',
                'due_date' => $weddingDate->copy()->subWeeks(2)->format('Y-m-d'),
                'status' => 'in_progress',
                'priority' => 'high',
                'notes' => 'Sekarang 180 tamu sudah konfirmasi',
            ],
            [
                'task_name' => 'Koordinasi dengan catering',
                'description' => 'Finalisasi menu makanan, jumlah tamu, dan pengaturan waktu penyajian.',
                'category' => 'vendor',
                'due_date' => $weddingDate->copy()->subWeeks(3)->format('Y-m-d'),
                'status' => 'in_progress',
                'priority' => 'medium',
                'notes' => 'Menunggu konfirmasi jumlah tamu',
            ],
            [
                'task_name' => 'Siapkan seserahan dan souvenir',
                'description' => 'Pilih souvenir, packing seserahan, dan pastikan jumlah sesuai tamu.',
                'category' => 'persiapan',
                'due_date' => $weddingDate->copy()->subWeeks(2)->format('Y-m-d'),
                'status' => 'pending',
                'priority' => 'medium',
                'notes' => 'Sedang mencari vendor',
            ],
            [
                'task_name' => 'Koordinasi akad nikah',
                'description' => 'Pastikan kelengkapan administrasi, penataran, dan jadwal akad dengan keluarga.',
                'category' => 'acara',
                'due_date' => $weddingDate->copy()->subWeek()->format('Y-m-d'),
                'status' => 'pending',
                'priority' => 'high',
                'notes' => 'Belum final',
            ],
            [
                'task_name' => 'Rehearsal dan penataran acara',
                'description' => 'Lakukan latihan dengan MC, band, dan panitia untuk memastikan kelancaran acara.',
                'category' => 'acara',
                'due_date' => $weddingDate->copy()->subDays(2)->format('Y-m-d'),
                'status' => 'pending',
                'priority' => 'medium',
                'notes' => '',
            ],
            [
                'task_name' => 'Siapkan kamar tamu',
                'description' => 'Siapkan akomodasi untuk tamu dari luar kota.',
                'category' => 'persiapan',
                'due_date' => $weddingDate->copy()->subDays(3)->format('Y-m-d'),
                'status' => 'pending',
                'priority' => 'low',
                'notes' => 'Ada 3 kamar dari hotel',
            ],
            [
                'task_name' => 'Pemeriksaan akhir venue',
                'description' => 'Cek kembali setup venue, dekorasi, sound system, dan parking.',
                'category' => 'venue',
                'due_date' => $weddingDate->copy()->subDay()->format('Y-m-d'),
                'status' => 'pending',
                'priority' => 'high',
                'notes' => '',
            ],
        ];

        foreach ($tasks as $task) {
            WeedingPlan::create(array_merge($task, [
                'user_id' => $user->id,
                'invitation_id' => $invitation->id,
            ]));
        }
    }
}
