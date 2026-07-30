# InstaApp - Aplikasi Web Clone Instagram

InstaApp adalah sebuah aplikasi web sederhana yang mensimulasikan fitur-fitur dasar dari media sosial Instagram. Dibangun untuk keperluan *Technical Test* dan *Portfolio*, aplikasi ini memungkinkan penggunanya untuk mendaftar akun, membagikan momen lewat foto dan teks, serta saling berinteraksi dengan menekan *like* atau memberikan komentar.

---

## 🛠️ Teknologi yang Digunakan (Tech Stack)

Aplikasi ini dibangun menggunakan arsitektur web modern yang tangguh:
- **Backend:** Laravel 11 (PHP Framework)
- **Frontend UI:** Tailwind CSS (Utility-first CSS Framework)
- **Authentication:** Laravel Breeze (Web) & Laravel Sanctum (API)
- **Database:** MySQL (Sistem Manajemen Basis Data Relasional standar industri)
- **Asset Bundler:** Vite (Terintegrasi dengan Laravel)

---

## 📁 Struktur Folder Utama

Berikut adalah gambaran struktur direktori proyek ini beserta fungsinya:

```text
InstaApp/
├── app/               # Logika inti aplikasi, berisi Controllers, Models, dan Policies.
├── bootstrap/         # File konfigurasi yang dijalankan saat aplikasi pertama kali dimuat.
├── config/            # Tempat seluruh file pengaturan aplikasi (database, session, auth, dll).
├── database/          # Migrasi tabel (Migrations) dan data palsu (Seeders/Factories).
├── public/            # File publik (index.php), gambar, dan aset yang dikompilasi (CSS/JS).
├── resources/         # Tempat file frontend (Tampilan Blade/HTML, CSS mentah, dan JS).
├── routes/            # Pengaturan rute URL (web.php untuk UI, api.php untuk RESTful API).
├── storage/           # Tempat penyimpanan foto/file hasil unggahan pengguna (app/public).
├── tests/             # File pengujian otomatis (Testing) untuk aplikasi.
├── .env               # File rahasia berisi konfigurasi environment (Database, API Keys).
└── README.md          # Dokumentasi proyek (File yang sedang Anda baca).
```

---

## ⚙️ Cara Instalasi & Menjalankan Aplikasi (Lokal)

Ikuti langkah-langkah berikut untuk menjalankan aplikasi ini di komputer Anda:

1. **Clone Repository Project**
   Buka terminal/CMD, lalu jalankan perintah ini untuk mengunduh kode aplikasi:
   ```bash
   git clone https://github.com/iqbalmusyaffa/InstaApp-tes.git
   cd InstaApp-tes
   ```

2. **Install Dependensi PHP (Vendor)**
   ```bash
   composer install
   ```

3. **Install Dependensi Node.js (Frontend)**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**
   Salin file konfigurasi bawaan Laravel:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan pastikan konfigurasi `DB_CONNECTION` diatur ke `mysql` serta nama `DB_DATABASE` disesuaikan. Buat database kosong di MySQL (contoh: `instaapp`) sebelum melanjutkan.

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database & Seeding (Data Awal)**
   Perintah ini akan membuat tabel dan mengisi akun contoh (dummy data):
   ```bash
   php artisan migrate --seed
   ```

7. **Tautkan Folder Penyimpanan Foto (Storage Link)**
   Sangat penting agar foto yang diunggah bisa ditampilkan di browser:
   ```bash
   php artisan storage:link
   ```

8. **Jalankan Vite Server untuk Frontend (Tailwind/CSS)**
   Buka terminal baru dan biarkan perintah ini berjalan di latar belakang:
   ```bash
   npm run dev
   ```

9. **Jalankan Server Lokal Laravel**
   Kembali ke terminal utama, jalankan:
   ```bash
   php artisan serve
   ```
   🎉 Aplikasi Anda sekarang berjalan! Buka browser dan akses: **http://localhost:8000**

---

## 🌍 Dokumentasi Web Routes (Browser UI)

Ini adalah daftar rute standar yang menggerakkan antarmuka visual InstaApp (diakses lewat *Browser*):

### 1. Halaman Publik & Autentikasi
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/` | Halaman utama (Welcome) sekaligus Login/Register |
| POST | `/login` | Memproses masuk akun |
| POST | `/register`| Mendaftarkan akun baru |
| POST | `/logout` | Keluar dari sesi (Logout) |
| GET/POST | `/forgot-password`| Mengurus lupa kata sandi (*Reset link*) |

### 2. Fitur Utama Postingan (Butuh Login)
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/dashboard` | Beranda (Timeline) & Form Upload Postingan |
| POST | `/posts` | Memproses unggahan foto baru |
| DELETE | `/posts/{id}` | Menghapus postingan (termasuk foto di `storage`) |
| POST | `/posts/{id}/like` | Menyukai sebuah postingan |
| DELETE | `/posts/{id}/like` | Batal menyukai (Unlike) |
| POST | `/posts/{id}/comments`| Mengirim komentar |
| DELETE | `/comments/{id}` | Menghapus komentar |

### 3. Profil Pengguna
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/user/{id}` | Halaman Profil Utama (Grid postingan user) |
| GET | `/profile` | Halaman Edit Profil & Ganti Password |
| PATCH | `/profile` | Menyimpan perubahan profil |
| DELETE | `/profile` | Menghapus akun pengguna permanen |

---

## 🌐 Dokumentasi RESTful API (Backend)

Selain versi Web, InstaApp memiliki dukungan API menggunakan **Laravel Sanctum**. Seluruh Endpoint (kecuali login) membutuhkan token Bearer di *header*. (Base URL: `http://localhost:8000/api`)

| Kategori | Method | Endpoint | Deskripsi |
|----------|--------|----------|-----------|
| **Auth** | POST | `/login` | Mendapatkan Token (Parameter: `email`, `password`) |
| **Auth** | GET | `/user` | Melihat profil dari token yang sedang aktif |
| **Posts**| GET | `/posts` | Daftar seluruh postingan |
| **Posts**| POST | `/posts` | Upload post baru via API (`caption`, `image`) |
| **Posts**| GET | `/posts/{id}` | Detail sebuah postingan |
| **Posts**| PUT | `/posts/{id}` | Edit caption postingan |
| **Posts**| DELETE | `/posts/{id}` | Hapus postingan beserta filenya |
| **Likes**| POST | `/posts/{id}/like` | Menyukai postingan via API |
| **Likes**| DELETE | `/posts/{id}/like`| Membatalkan like |
| **Comments**| GET | `/posts/{id}/comments` | Daftar komentar di satu postingan |
| **Comments**| POST | `/posts/{id}/comments` | Tambah komentar baru (`comment`) |
| **Comments**| DELETE | `/comments/{id}` | Hapus komentar |

---

## 🔒 Kebijakan Keamanan (Authorization)
InstaApp dilengkapi perlindungan hak akses (Policy):
- Anda **hanya bisa** menghapus Postingan dan Komentar yang Anda buat sendiri.
- Mencoba memaksa hapus (melalui modifikasi URL/API) terhadap postingan orang lain akan otomatis digagalkan oleh sistem (*403 Forbidden*).
- Menghapus postingan akan **secara otomatis** menghapus gambar fisik dari folder server untuk menghemat penyimpanan.han *Storage bloat*).
