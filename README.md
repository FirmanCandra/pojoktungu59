# 📰 Pojok Informasi

**Pojok Informasi** adalah portal informasi berbasis web yang dibangun menggunakan **Laravel 12**. Aplikasi ini dirancang untuk menyajikan artikel, program kerja, pengumuman, serta informasi visi & misi organisasi kepada publik. Dilengkapi dengan panel admin yang lengkap untuk mengelola seluruh konten secara dinamis.

---

## 📑 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Prasyarat](#-prasyarat)
- [Instalasi](#-instalasi)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Akun Admin Default](#-akun-admin-default)
- [Struktur Proyek](#-struktur-proyek)
- [Arsitektur Aplikasi](#-arsitektur-aplikasi)
- [Database & Model](#-database--model)
- [Rute (Routes)](#-rute-routes)
- [Middleware](#-middleware)
- [Fitur Detail](#-fitur-detail)
- [Deployment](#-deployment)
- [Lisensi](#-lisensi)

---

## ✨ Fitur Utama

### 🌐 Halaman Publik
- **Beranda** — Menampilkan ringkasan artikel terbaru, program kerja, dan pengumuman aktif
- **Artikel** — Daftar artikel dengan filter kategori, pencarian, dan dukungan upload PDF
- **Program Kerja** — Informasi program kerja organisasi dengan status (berjalan/selesai)
- **Visi & Misi** — Halaman khusus visi dan misi organisasi
- **Kontak** — Formulir kontak untuk pengunjung mengirim pesan

### 🔐 Panel Admin
- **Dashboard** — Statistik ringkasan (total artikel, program kerja, pesan, pengunjung) dengan grafik interaktif 6 bulan dan 7 hari terakhir
- **Manajemen Artikel** — CRUD artikel dengan thumbnail, upload PDF, kategori, dan status draft/published
- **Manajemen Program Kerja** — CRUD program kerja dengan kategori, gambar, dan status berjalan/selesai
- **Manajemen Pengumuman** — CRUD pengumuman dengan tipe (informasi, penting, peringatan, klarifikasi hoax)
- **Visi & Misi** — Edit visi dan misi organisasi (singleton)
- **Pesan Masuk** — Membaca dan mengelola pesan dari formulir kontak
- **Pengaturan Situs** — Konfigurasi pengaturan website secara dinamis
- **Tracking Pengunjung** — Pelacakan otomatis pengunjung unik berdasarkan IP

---

## 🛠 Tech Stack

| Komponen        | Teknologi                          |
| --------------- | ---------------------------------- |
| **Framework**   | Laravel 12 (PHP 8.2+)             |
| **Frontend**    | Blade Templates + Alpine.js        |
| **CSS**         | Tailwind CSS 3.x                   |
| **Build Tool**  | Vite 7.x                           |
| **Database**    | MySQL (production) / SQLite (dev)  |
| **Auth**        | Laravel Breeze                     |
| **Queue**       | Database Driver                    |
| **Session**     | Database Driver                    |
| **Cache**       | Database Driver                    |
| **Font**        | Figtree (Google Fonts)             |

---

## 📋 Prasyarat

Pastikan sistem Anda sudah terinstal:

- **PHP** >= 8.2
- **Composer** >= 2.x
- **Node.js** >= 18.x & **npm**
- **MySQL** >= 8.0 (atau SQLite untuk development)
- **Git**

Ekstensi PHP yang dibutuhkan:
- `pdo_mysql` (atau `pdo_sqlite`)
- `mbstring`
- `openssl`
- `tokenizer`
- `xml`
- `ctype`
- `json`
- `fileinfo`

---

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/FirmanCandra/pojoktungu59.git
cd pojoktungu59
```

### 2. Install Dependensi

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` sesuai konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pojok_informasi
DB_USERNAME=root
DB_PASSWORD=
```

> 💡 **Tip:** Untuk development cepat, Anda bisa menggunakan SQLite dengan mengubah `DB_CONNECTION=sqlite` dan menghapus konfigurasi `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.

### 4. Migrasi & Seeder Database

```bash
php artisan migrate --seed
```

Seeder akan membuat:
- **User Admin** — akun admin default
- **Artikel** — contoh data artikel
- **Program Kerja** — contoh program kerja
- **Visi & Misi** — data visi & misi default
- **Pengaturan Situs** — pengaturan default

### 5. Storage Link

```bash
php artisan storage:link
```

Perintah ini membuat symbolic link dari `public/storage` ke `storage/app/public` agar file upload (thumbnail, PDF) bisa diakses secara publik.

### 6. Build Frontend Assets

```bash
npm run build
```

---

## ▶️ Menjalankan Aplikasi

### Mode Development (Recommended)

Jalankan semua service sekaligus (server, queue, logs, vite):

```bash
composer dev
```

Perintah ini menjalankan secara bersamaan:
- `php artisan serve` — Laravel development server
- `php artisan queue:listen` — Queue worker
- `php artisan pail` — Real-time log viewer
- `npm run dev` — Vite HMR dev server

### Atau Jalankan Manual

```bash
# Terminal 1: Laravel Server
php artisan serve

# Terminal 2: Vite (hot reload)
npm run dev
```

Akses aplikasi di: **http://127.0.0.1:8000**

---

## 📁 Struktur Proyek

```
pojok-informasi/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                    # Controller panel admin
│   │   │   │   ├── AnnouncementController.php
│   │   │   │   ├── ArticleController.php
│   │   │   │   ├── ContactMessageController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── SiteSettingController.php
│   │   │   │   ├── VisionMissionController.php
│   │   │   │   └── WorkProgramController.php
│   │   │   ├── Public/                   # Controller halaman publik
│   │   │   │   ├── ArticleController.php
│   │   │   │   ├── ContactController.php
│   │   │   │   ├── HomeController.php
│   │   │   │   ├── VisionMissionController.php
│   │   │   │   └── WorkProgramController.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php       # Proteksi akses admin
│   │   │   └── TrackPageView.php         # Tracking pengunjung
│   │   └── Requests/                     # Form Request Validation
│   ├── Models/
│   │   ├── Announcement.php              # Pengumuman
│   │   ├── Article.php                   # Artikel
│   │   ├── ContactMessage.php            # Pesan kontak
│   │   ├── PageView.php                  # Data pengunjung
│   │   ├── SiteSetting.php               # Pengaturan situs
│   │   ├── User.php                      # Pengguna
│   │   ├── VisionMission.php             # Visi & Misi
│   │   └── WorkProgram.php               # Program Kerja
│   ├── Providers/
│   │   └── AppServiceProvider.php        # Force HTTPS di production
│   └── View/
├── database/
│   ├── migrations/                       # Skema database
│   └── seeders/                          # Data awal
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       ├── ArticleSeeder.php
│       ├── WorkProgramSeeder.php
│       ├── VisionMissionSeeder.php
│       ├── SiteSettingSeeder.php
│       └── AnnouncementSeeder.php
├── resources/
│   └── views/
│       ├── admin/                        # View panel admin
│       │   ├── articles/
│       │   ├── announcements/
│       │   ├── dashboard.blade.php
│       │   ├── messages/
│       │   ├── settings/
│       │   ├── vision-mission/
│       │   └── work-programs/
│       ├── layouts/
│       │   ├── admin.blade.php           # Layout admin panel
│       │   ├── public.blade.php          # Layout halaman publik
│       │   ├── app.blade.php             # Layout Breeze
│       │   ├── guest.blade.php           # Layout halaman tamu
│       │   └── navigation.blade.php
│       └── public/                       # View halaman publik
│           ├── articles/
│           ├── contact.blade.php
│           ├── home.blade.php
│           ├── vision-mission.blade.php
│           └── work-programs/
├── routes/
│   ├── web.php                           # Rute web utama
│   └── auth.php                          # Rute autentikasi (Breeze)
├── public/
│   └── images/
│       └── no-thumbnail.svg              # Placeholder gambar default
├── composer.json
├── package.json
├── tailwind.config.js
└── vite.config.js
```

---

## 🏗 Arsitektur Aplikasi

Aplikasi ini mengikuti pola arsitektur **MVC (Model-View-Controller)** standar Laravel dengan pemisahan yang jelas antara:

```
┌─────────────────────────────────────────────────┐
│                   ROUTES                         │
│         web.php  ·  auth.php                     │
└──────────────┬──────────────────────────────────┘
               │
     ┌─────────┴─────────┐
     ▼                   ▼
┌─────────┐        ┌──────────┐
│ PUBLIC  │        │  ADMIN   │
│ Routes  │        │  Routes  │
└────┬────┘        └────┬─────┘
     │                  │
     │          ┌───────┴───────┐
     │          │  Middleware   │
     │          │  auth + admin │
     │          └───────┬───────┘
     │                  │
     ▼                  ▼
┌──────────────────────────────────────┐
│           CONTROLLERS                │
│  Public/  ·  Admin/  ·  Auth/        │
└──────────────┬───────────────────────┘
               │
     ┌─────────┼─────────┐
     ▼         ▼         ▼
┌────────┐ ┌───────┐ ┌────────┐
│ MODELS │ │ VIEWS │ │REQUESTS│
│  (DB)  │ │(Blade)│ │(Valid.)│
└────────┘ └───────┘ └────────┘
```

---

## 🗄 Database & Model

### Tabel & Model

| Tabel              | Model             | Deskripsi                                      |
| ------------------ | ----------------- | ---------------------------------------------- |
| `users`            | `User`            | Data pengguna dengan role (`admin`/`user`)      |
| `articles`         | `Article`         | Artikel dengan thumbnail, PDF, kategori, status |
| `work_programs`    | `WorkProgram`     | Program kerja dengan gambar dan status          |
| `announcements`    | `Announcement`    | Pengumuman dengan tipe dan status aktif         |
| `vision_missions`  | `VisionMission`   | Visi & misi (singleton, satu record)            |
| `contact_messages` | `ContactMessage`  | Pesan dari formulir kontak                      |
| `site_settings`    | `SiteSetting`     | Pengaturan situs (key-value pair)               |
| `page_views`       | `PageView`        | Data tracking pengunjung                        |
| `sessions`         | —                 | Session storage                                 |
| `cache`            | —                 | Cache storage                                   |
| `jobs`             | —                 | Queue jobs                                      |

### Relasi Antar Model

```
User ──┐
       │ 1:N
       ▼
   Article (belongsTo User)

VisionMission (singleton — selalu 1 record)

SiteSetting (key-value store)
```

### Field Penting per Model

#### Article
| Field          | Tipe       | Keterangan                              |
| -------------- | ---------- | --------------------------------------- |
| `title`        | `string`   | Judul artikel (nullable, auto dari PDF) |
| `slug`         | `string`   | URL-friendly identifier (auto-generate) |
| `content`      | `text`     | Isi artikel (nullable)                  |
| `thumbnail`    | `string`   | Path gambar thumbnail                   |
| `pdf_file`     | `string`   | Path file PDF                           |
| `category`     | `string`   | Kategori artikel                        |
| `status`       | `string`   | `draft` atau `published`                |
| `published_at` | `datetime` | Tanggal publikasi                       |

#### WorkProgram
| Field        | Tipe     | Keterangan                       |
| ------------ | -------- | -------------------------------- |
| `title`      | `string` | Judul program kerja              |
| `slug`       | `string` | URL-friendly identifier          |
| `category`   | `string` | Kategori program                 |
| `description`| `text`   | Deskripsi program                |
| `image`      | `string` | Path gambar                      |
| `status`     | `string` | `berjalan` atau `selesai`        |
| `start_date` | `date`   | Tanggal mulai                    |
| `end_date`   | `date`   | Tanggal selesai                  |

#### Announcement
| Field       | Tipe      | Keterangan                                             |
| ----------- | --------- | ------------------------------------------------------ |
| `title`     | `string`  | Judul pengumuman                                       |
| `content`   | `text`    | Isi pengumuman                                         |
| `type`      | `string`  | `info`, `penting`, `warning`, `hoax`                   |
| `is_active` | `boolean` | Status aktif                                           |

---

## 🛣 Rute (Routes)

### Halaman Publik

| Method | URL                    | Nama Route            | Deskripsi                   |
| ------ | ---------------------- | --------------------- | --------------------------- |
| GET    | `/`                    | `home`                | Beranda                     |
| GET    | `/artikel`             | `articles.index`      | Daftar artikel              |
| GET    | `/artikel/{slug}`      | `articles.show`       | Detail artikel              |
| GET    | `/program-kerja`       | `work-programs.index` | Daftar program kerja        |
| GET    | `/program-kerja/{slug}`| `work-programs.show`  | Detail program kerja        |
| GET    | `/visi-misi`           | `vision-mission`      | Halaman visi & misi         |
| GET    | `/kontak`              | `contact`             | Formulir kontak             |
| POST   | `/kontak`              | `contact.store`       | Kirim pesan kontak          |

### Panel Admin (prefix: `/admin`, middleware: `auth` + `admin`)

| Method    | URL                         | Nama Route                    | Deskripsi                |
| --------- | --------------------------- | ----------------------------- | ------------------------ |
| GET       | `/admin/dashboard`          | `admin.dashboard`             | Dashboard statistik      |
| GET       | `/admin/stats-api`          | `admin.stats-api`             | API data statistik (JSON)|
| Resource  | `/admin/artikel`            | `admin.artikel.*`             | CRUD artikel             |
| Resource  | `/admin/program-kerja`      | `admin.program-kerja.*`       | CRUD program kerja       |
| Resource  | `/admin/pengumuman`         | `admin.pengumuman.*`          | CRUD pengumuman          |
| GET       | `/admin/visi-misi`          | `admin.vision-mission.edit`   | Edit visi & misi         |
| PUT       | `/admin/visi-misi`          | `admin.vision-mission.update` | Update visi & misi       |
| GET       | `/admin/pesan`              | `admin.messages.index`        | Daftar pesan masuk       |
| PATCH     | `/admin/pesan/{id}/read`    | `admin.messages.read`         | Tandai pesan dibaca      |
| DELETE    | `/admin/pesan/{id}`         | `admin.messages.destroy`      | Hapus pesan              |
| GET       | `/admin/pengaturan`         | `admin.settings.edit`         | Edit pengaturan situs    |
| PUT       | `/admin/pengaturan`         | `admin.settings.update`       | Update pengaturan situs  |

---

## 🛡 Middleware

### AdminMiddleware

```
App\Http\Middleware\AdminMiddleware
```

Memproteksi seluruh route admin. Hanya user yang sudah login **dan** memiliki `role = 'admin'` yang dapat mengakses panel admin. User lain akan mendapat error **403 Forbidden**.

### TrackPageView

```
App\Http\Middleware\TrackPageView
```

Mencatat setiap kunjungan halaman publik secara otomatis. Data yang dicatat:
- IP address pengunjung
- User agent (browser)
- URL yang dikunjungi
- Session ID

Path yang **dikecualikan** dari tracking: `admin`, `login`, `logout`, `register`, `password`, `api`, `storage`, `livewire`.

---

## 📝 Fitur Detail

### 📄 Upload Artikel PDF

Artikel mendukung upload file **PDF** sebagai lampiran. Fitur pintar yang tersedia:
- Jika judul artikel dikosongkan, judul otomatis diambil dari **nama file PDF**
- Konten artikel bersifat opsional (nullable)
- PDF dapat dihapus dari artikel yang sudah ada
- File disimpan di `storage/app/public/articles/pdf/`

### 📊 Dashboard Admin

Dashboard menampilkan:
- **Kartu Statistik**: Total artikel, artikel published/draft, program kerja, pesan belum dibaca, pengunjung
- **Grafik 6 Bulan**: Tren artikel dan pesan kontak per bulan
- **Grafik 7 Hari**: Pengunjung unik harian
- **Artikel Terbaru**: 5 artikel terakhir dengan quick-edit link
- **Auto-refresh**: Data dashboard dapat diperbarui via API endpoint `/admin/stats-api`

### 📢 Sistem Pengumuman

Pengumuman mendukung 4 tipe dengan visual badge berbeda:
- 🚫 **Klarifikasi Hoax** — Badge merah
- ⚠️ **Peringatan** — Badge kuning
- 📢 **Penting** — Badge ungu
- ℹ️ **Informasi** — Badge biru

### 🔗 Auto-Slug Generation

Semua model yang memiliki field `slug` (Article, WorkProgram) secara otomatis men-generate slug unik dari judul saat pembuatan. Jika slug sudah ada, akan ditambahkan suffix angka untuk memastikan keunikan.

### 👁 Visitor Tracking

Sistem tracking pengunjung yang ringan dan non-intrusif:
- Hanya melacak request `GET` (bukan POST/AJAX)
- Tidak pernah mengganggu performa situs (fail silently)
- Menghitung pengunjung unik berdasarkan IP
- Data tersedia di dashboard admin

---

## 🌐 Deployment

### Production (Hostinger / Shared Hosting)

Aplikasi sudah dikonfigurasi untuk deployment di **Hostinger**:

1. **HTTPS otomatis** — `AppServiceProvider` memaksa HTTPS di environment production untuk menghindari mixed content

2. Pastikan file `.env` di production menggunakan:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://domain-anda.com
   ```

3. Jalankan optimasi:
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   npm run build
   ```

---

## 🧪 Testing

```bash
# Jalankan semua test
php artisan test

# Atau menggunakan composer script
composer test
```

---

## 📌 Script Tersedia

| Script            | Perintah            | Deskripsi                                     |
| ----------------- | ------------------- | --------------------------------------------- |
| **Setup**         | `composer setup`    | Install semua dependensi, migrasi, build asset |
| **Development**   | `composer dev`      | Jalankan server, queue, logs, dan vite          |
| **Test**          | `composer test`     | Jalankan test suite                             |
| **Build**         | `npm run build`     | Build production assets                         |
| **Dev (Vite)**    | `npm run dev`       | Jalankan Vite dev server dengan HMR             |

---

## 📄 Lisensi

Project ini menggunakan framework Laravel yang berlisensi [MIT License](https://opensource.org/licenses/MIT).

---

## 👥 Kontributor

- **Firman Candra** — Developer Utama

---

<p align="center">
  Dibuat dengan ❤️ menggunakan <strong>Laravel 12</strong>
</p>
