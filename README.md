# Pusat Kostum - Marketplace Kostum & Cosplay

**Pusat Kostum** adalah platform E-Commerce berbasis web yang menghubungkan penjual (maker/rental) kostum dengan pembeli. Aplikasi ini dirancang khusus untuk memfasilitasi transaksi jual beli kostum anime, superhero, pakaian adat, dan perlengkapan cosplay lainnya dengan sistem dompet digital (E-Wallet) terintegrasi.

---

## 👨‍💻 Anggota Kelompok

-   **Nama:** Achmad Rafli Delly Wahyudi
-   **NIM:** 225150607111006

---

## 🚀 Fitur Utama

Aplikasi ini memiliki 3 role pengguna dengan fungsionalitas yang berbeda:

### 1. Fitur Pembeli (Member)

-   **Katalog Produk:** Mencari dan melihat detail produk dengan galeri foto interaktif.
-   **E-Wallet:** Top-up saldo, belanja menggunakan saldo dompet, dan riwayat transaksi dompet.
-   **Checkout & Pembayaran:** Mendukung pembayaran via Saldo Dompet (Otomatis) dan Virtual Account (Simulasi).
-   **Riwayat Belanja:** Melihat status pesanan (Menunggu Bayar, Diproses, Dikirim, Selesai).
-   **Buka Toko:** Member dapat mendaftar sebagai penjual (Seller).

### 2. Fitur Penjual (Seller)

-   **Registrasi Toko:** Mengajukan pembukaan toko dengan upload logo dan data lengkap (Menunggu verifikasi Admin).
-   **Dashboard Seller:** Ringkasan pendapatan, pesanan baru, dan total produk.
-   **Manajemen Produk:** CRUD Produk (Tambah, Edit, Hapus) dengan dukungan **Multiple Images** dan penentuan Thumbnail.
-   **Manajemen Pesanan:** Update status pesanan (Diproses, Dikirim, Selesai) dan input Nomor Resi.
-   **Dompet Toko:** Melihat saldo aktif hasil penjualan dan riwayat mutasi (Pemasukan/Penarikan).
-   **Penarikan Dana (Withdrawal):** Mengajukan pencairan dana ke rekening bank (Validasi saldo real-time).

### 3. Fitur Admin

-   **Dashboard Admin:** Statistik total user, toko, dan transaksi.
-   **Verifikasi Toko:** Menerima atau menolak pengajuan buka toko dari member.
-   **Manajemen User:** Melihat daftar pengguna dan menghapus user bermasalah.
-   **Manajemen Penarikan:** Memvalidasi dan menyetujui permintaan penarikan dana dari penjual (Transfer manual & Approve system).

---

## 🛠️ Teknologi yang Digunakan

-   **Framework Backend:** Laravel 12
-   **Frontend:** Blade Templates
-   **Styling:** Tailwind CSS
-   **Interaktivitas:** Alpine.js (untuk Modal, Dropdown, Preview Image, Alert)
-   **Database:** MySQL

---

## ⚙️ Cara Instalasi & Menjalankan

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal:

1.  **Clone Repositori**

    ```bash
    git clone https://github.com/rafli967/Achmad-Rafli-Delly-Wahyudi_PEMWEB.git .
    cd nama_direktori
    ```

2.  **Install Dependensi PHP & JS**

    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment**

    -   Duplikat file `.env.example` menjadi `.env`.
    -   Atur koneksi database di file `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate Key**

    ```bash
    php artisan key:generate
    ```

5.  **Migrasi Database & Seeder (PENTING)**
    Perintah ini akan membuat tabel dan mengisi data dummy (Admin, Toko, Produk, Kategori).

    ```bash
    php artisan migrate:fresh --seed
    ```

    _Pastikan file gambar placeholder sudah ada di `public/assets/images/placeholder.png` dan `public/hero.png`._

6.  **Hubungkan Storage Gambar**
    Agar gambar produk dan logo toko bisa tampil.

    ```bash
    php artisan storage:link
    ```

7.  **Jalankan Aplikasi**
    Buka dua terminal berbeda:
    -   Terminal 1 (Backend):
        ```bash
        php artisan serve
        ```
    -   Terminal 2 (Frontend Build):
        ```bash
        npm run dev
        ```

---

## 🔑 Akun Demo (Seeder)

Gunakan akun berikut untuk pengujian:

| Role       | Email                | Password   | Keterangan                          |
| :--------- | :------------------- | :--------- | :---------------------------------- |
| **Admin**  | `admin@example.com`  | `password` | Akses penuh verifikasi & withdrawal |
| **Seller** | `seller@example.com` | `password` | Pemilik toko "Cosplay Universe"     |
| **Buyer**  | `buyer@example.com`  | `password` | Pembeli saldo 0 (bisa topup)        |

---

## 📸 Struktur Folder Penting

-   `app/Http/Controllers/Seller` - Logika khusus Penjual (Produk, Order, Saldo).
-   `app/Http/Controllers/AdminController.php` - Logika Admin.
-   `resources/views/layouts` - Layout utama (`frontend`, `seller`, `admin`).
-   `database/seeders` - Data dummy untuk testing.

---

Copyright © 2025 Achmad Rafli Delly Wahyudi. All Rights Reserved.
