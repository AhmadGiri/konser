# Ticket Box - Sistem Pemesanan Tiket Konser

Aplikasi web berbasis Laravel untuk melihat event, memesan tiket, dan mengelola data event serta pesanan melalui dashboard.

## Fitur

### Pelanggan
- Melihat katalog event/konser.
- Melihat event berdasarkan daftar yang tersedia.
- Memilih jumlah tiket yang ingin dipesan.
- Mengisi nama dan email pemesan.
- Melakukan checkout dan menyimpan pesanan.
- Melihat notifikasi hasil pemesanan.

### Pengelola
- Mengakses dashboard setelah login dan verifikasi email.
- Melihat rekap pesanan yang masuk.
- Mengelola data event: tambah, lihat, edit, dan hapus.
- Mengunggah poster event.
- Memperbarui status pesanan menjadi `Pending`, `Confirmed`, atau `Cancelled`.

## Teknologi

- PHP 8.3+
- Laravel 13
- MySQL/MariaDB
- Blade
- Tailwind CSS dan Vite
- Laravel Breeze untuk autentikasi

## Persyaratan

Pastikan perangkat sudah memiliki:
- PHP 8.3 atau versi yang sesuai dengan `composer.json`.
- Composer.
- Node.js dan npm.
- MySQL atau MariaDB.
- Git (opsional, jika project diambil dengan `git clone`).

## Instalasi

### 1. Ambil project

```bash
git clone https://github.com/AhmadGiri/konser.git
cd konser
```

Jika project sudah diunduh dalam bentuk ZIP, ekstrak ZIP lalu buka terminal pada folder project yang berisi file `artisan`.

### 2. Instal dependency PHP

```bash
composer install
```

### 3. Buat file konfigurasi

Salin `.env.example` menjadi `.env`.

Windows CMD:

```bat
copy .env.example .env
```

PowerShell:

```powershell
Copy-Item .env.example .env
```

Linux/macOS:

```bash
cp .env.example .env
```

### 4. Buat database

Buat database dengan nama:

```sql
CREATE DATABASE db_ticket_konser;
```

### 5. Atur koneksi database

Buka file `.env`, lalu sesuaikan bagian database untuk MySQL/MariaDB:

```env
APP_NAME="Ticket Box"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_ticket_konser
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan konfigurasi MySQL di komputer masing-masing. Pada instalasi lokal tertentu, akun `root` tidak menggunakan password, tetapi ikuti konfigurasi perangkat yang digunakan.

### 6. Buat application key

```bash
php artisan key:generate
```

### 7. Jalankan migration dan seeder

```bash
php artisan migrate --seed
```

Perintah tersebut membuat tabel aplikasi dan mengisi data awal event dari `EventSeeder`. Seeder menyediakan contoh event kategori Musik, Festival, dan Seminar.

Jika database sudah berisi data dan tidak ingin menghapusnya, jangan menjalankan `migrate:fresh` karena perintah itu menghapus seluruh tabel terlebih dahulu.

### 8. Instal dependency frontend dan build aset

```bash
npm install
npm run build
```

### 9. Siapkan penyimpanan poster

Jika aplikasi menggunakan disk `public` untuk poster, buat symbolic link storage:

```bash
php artisan storage:link
```

### 10. Jalankan aplikasi

```bash
php artisan serve
```

Buka alamat berikut di browser:

```text
http://127.0.0.1:8000
```

## Struktur Database

Aplikasi menggunakan tiga tabel transaksi utama:

### `events`
Menyimpan data event:
- `id`
- `title`
- `category` (`Musik`, `Festival`, atau `Seminar`)
- `ticket_price`
- `description`
- `image` (opsional)
- `created_at` dan `updated_at`

### `orders`
Menyimpan data utama pesanan:
- `id`
- `customer_name`
- `customer_email`
- `total_price`
- `status` (`Pending`, `Confirmed`, atau `Cancelled`)
- `created_at` dan `updated_at`

### `order_details`
Menyimpan detail tiket pada setiap pesanan:
- `id`
- `order_id` sebagai foreign key ke `orders`
- `event_id` sebagai foreign key ke `events`
- `quantity`
- `subtotal`
- `created_at` dan `updated_at`

Relasi foreign key digunakan untuk menghubungkan pesanan dengan event yang dipesan.

## Alur Penggunaan

1. Pelanggan membuka halaman utama dan melihat katalog event.
2. Pelanggan memilih jumlah tiket, lalu mengisi nama dan email.
3. Pelanggan melakukan checkout.
4. Sistem menghitung subtotal dan total harga, kemudian menyimpan data ke tabel `orders` dan `order_details` dalam transaksi database.
5. Pengelola login untuk melihat pesanan pada dashboard.
6. Pengelola dapat mengelola data event dan memperbarui status pesanan.

## Perintah Pengembangan

Menjalankan server Laravel:

```bash
php artisan serve
```

Menjalankan Vite dalam mode pengembangan:

```bash
npm run dev
```

Menjalankan test:

```bash
php artisan test
```

Memeriksa daftar route:

```bash
php artisan route:list
```

Membersihkan cache konfigurasi jika perubahan `.env` belum terbaca:

```bash
php artisan config:clear
```

## Catatan

- Jangan mengunggah file `.env` yang berisi kredensial atau `APP_KEY` ke repository publik.
- Pastikan dashboard dan endpoint pengelolaan event hanya dapat diakses oleh pengguna yang berwenang sebelum aplikasi digunakan secara publik.
- Untuk kebutuhan produksi, gunakan `APP_DEBUG=false` dan konfigurasi server yang sesuai.
- Panduan ini menjelaskan konfigurasi lokal; pengaturan hosting dapat berbeda.

## Lisensi

Project ini dibuat untuk latihan/pra-uji kompetensi pengembangan aplikasi web menggunakan Laravel.