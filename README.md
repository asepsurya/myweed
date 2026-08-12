# MyWeed - Wedding Invitation SaaS

Aplikasi undangan pernikahan berbasis web yang dibangun dengan Laravel 12, dilengkapi sistem pembayaran, Google OAuth login, dan fitur keuangan pernikahan.

## Teknologi

- **Framework**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade Template, Bootstrap 5, AdminUIUX Theme
- **Database**: MySQL
- **Payment Gateway**: Midtrans, Mayar
- **Authentication**: Laravel Breeze + Laravel Socialite (Google OAuth)
- **Testing**: Pest PHP

## Prerequisites

Pastikan sistem Anda telah menginstall:

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL
- Git

## Instalasi

### 1. Clone Repository

```bash
git clone <repository-url> myweed
cd myweed
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan koneksi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=myweed
DB_USERNAME=root
DB_PASSWORD=
```

Buat database MySQL dengan nama `myweed` (atau sesuaikan dengan konfigurasi Anda).

### 5. Jalankan Migrasi & Seeder

```bash
php artisan migrate --seed
```

### 6. Build Asset

```bash
npm run build
```

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## Konfigurasi Integrasi

### Midtrans Payment Gateway

Midtrans digunakan untuk memproses pembayaran langganan pengguna.

#### Langkah Konfigurasi:

1. **Daftar di Midtrans**
   - Kunjungi https://midtrans.com/
   - Buat akun dan verifikasi merchant
   - Pilih environment: **Sandbox** (testing) atau **Production** (live)

2. **Dapatkan Kredensial**
   - Setelah login ke Dashboard Midtrans, buka menu **Settings** > **Access Keys**
   - Salin **Client Key** dan **Server Key**

3. **Tambahkan ke `.env`**
   ```env
   MIDTRANS_IS_PRODUCTION=false
   MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxx
   MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxx
   ```

4. **Atau melalui Dashboard Admin**
   - Login sebagai admin
   - Buka menu **Pengaturan .env**
   - Pilih tab **Gateway Midtrans**
   - Isi kredensial Midtrans dan simpan

#### Catatan:
- Gunakan `MIDTRANS_IS_PRODUCTION=false` untuk testing (Sandbox)
- Gunakan `MIDTRANS_IS_PRODUCTION=true` untuk production

### Google OAuth

Digunakan untuk fitur "Sign in with Google" pada halaman autentikasi.

#### Langkah Konfigurasi:

1. **Buat Project di Google Cloud Console**
   - Kunjungi https://console.cloud.google.com/
   - Buat project baru atau pilih project yang sudah ada

2. **Aktifkan Google+ API**
   - Di Google Cloud Console, buka **APIs & Services** > **Library**
   - Cari "Google People API" dan aktifkan

3. **Buat OAuth 2.0 Credentials**
   - Buka **APIs & Services** > **Credentials**
   - Klik **Create Credentials** > **OAuth 2.0 Client ID**
   - Pilih application type: **Web application**
   - Tambahkan Authorized Redirect URI: `http://localhost:8000/auth/google/callback` (untuk lokal) atau domain production Anda

4. **Tambahkan ke `.env`**
   ```env
   GOOGLE_CLIENT_ID=xxxxx.apps.googleusercontent.com
   GOOGLE_CLIENT_SECRET=xxxxx
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
   ```

5. **Atau melalui Dashboard Admin**
   - Login sebagai admin
   - Buka menu **Pengaturan .env**
   - Pilih tab **OAuth & AI**
   - Isi kredensial Google dan simpan

### Webhook Configuration

Webhook digunakan untuk menerima notifikasi status pembayaran secara real-time dari payment gateway.

#### 1. Midtrans Notification URL (Payment Notification)

Midtrans menggunakan **Notification URL** untuk mengirim status pembayaran secara real-time.

**Konfigurasi:**
1. Login ke Dashboard Midtrans
2. Buka **Settings** > **Configuration**
3. Pada bagian **Payment Notification**, isi URL:
   ```
   https://yourdomain.com/payment/notification
   ```
4. Atau bisa diatur di setiap transaksi Snap token

**Catatan:** Midtrans mengirim POST request ke URL ini dengan parameter `signature_key` untuk verifikasi keamanan.

#### 2. Mayar Webhook

Mayar menggunakan webhook untuk notifikasi status pembayaran.

**Route Webhook:**
```
POST /mayar/webhook
```

**Konfigurasi:**
1. Login ke dashboard Mayar
2. Buka pengaturan webhook
3. Set URL webhook:
   ```
   https://yourdomain.com/mayar/webhook
   ```
4. Webhook ini akan menerima notifikasi untuk status pembayaran (paid, failed, expire, cancel)

**Catatan Penting:**
- Webhook route sudah dikecualikan dari CSRF verification (lihat `app/Http/Middleware/VerifyCsrfToken.php`)
- Pastikan server production dapat menerima POST request dari eksternal
- Webhook Mayar akan mengembalikan JSON response

## Struktur Project

```
myweed/
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   ├── Services/
│   └── Notifications/
├── config/
│   └── midtrans.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
├── routes/
│   └── web.php
└── storage/
```

## Fitur Utama

- Undangan pernikahan digital dengan tema yang bisa dikustomisasi
- Sistem RSVP (Reservation)
- Manajemen pengguna & admin
- Sistem langganan (Free / Basic / Pro)
- Pembayaran otomatis via Midtrans & Mayar
- Google OAuth Login
- Manajemen budget pernikahan
- Tabungan bersama
- Integrasi AI untuk pembuatan template

## Perintah yang Berguna

```bash
composer dump-autoload
php artisan migrate:fresh --seed
./vendor/bin/pint --test
php artisan test
```

## Troubleshooting

### Error Koneksi Database
- Pastikan MySQL service berjalan
- Periksa kredensial database di file `.env`

### Midtrans Error 401
- Pastikan API Key (Client Key / Server Key) sesuai dengan environment (Sandbox/Production)
- Periksa `MIDTRANS_IS_PRODUCTION` sesuai dengan kredensial yang digunakan

### Google OAuth Error
- Pastikan Redirect URI di Google Cloud Console sama dengan yang ada di `.env`
- Periksa `GOOGLE_CLIENT_ID` dan `GOOGLE_CLIENT_SECRET` tidak kosong

### Webhook Tidak Terima Request
- Pastikan server dapat diakses publik (untuk production)
- Periksa server firewall/nginx proxy mengizinkan POST request
- Cek log aplikasi untuk error handling

## Testing

Jalankan test suite:

```bash
php artisan test
```

## Security Vulnerabilities

Jika menemukan celah keamanan, silakan hubungi tim development.

## License

Aplikasi ini bersifat proprietary.
