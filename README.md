# 🛠️ IT Log & Ticketing System

Aplikasi manajemen log IT internal untuk mencatat dan melacak keluhan teknis staf/karyawan. Dibangun menggunakan framework **CodeIgniter 4** untuk performa yang cepat dan terstruktur.

## 📋 Fitur
- **Pencatatan Tiket**: Log laporan dari telepon atau tatap muka.
- **Manajemen Status**: Lacak progres tiket (Open, In Progress, Closed).
- **Skala Prioritas**: Pengaturan tingkat urgensi keluhan (Low, Medium, High).
- **Dashboard Statistik**: Ringkasan jumlah tiket yang masuk.

## 💻 Prasyarat Sistem
- **PHP**: Versi 7.4 atau 8.x
- **Web Server**: Apache (via XAMPP/Laragon)
- **Database**: MySQL / MariaDB
- **Ekstensi PHP**: `intl`, `mbstring`, `mysqli` (harus aktif di php.ini)

## 🚀 Langkah Pemasangan

### 1. Persiapan Database
1. Buka **phpMyAdmin**.
2. Buat database baru, misalnya dengan nama `ticketing_it_db`.
3. Impor file database yang disediakan:
   - Lokasi file: sudah tersedia di repo

### 2. Konfigurasi Environment
1. Di folder utama aplikasi, cari file bernama `env example`.
2. Ubah/Rename file tersebut menjadi `.env`.
3. Buka file `.env` menggunakan notepad atau VS Code, lalu sesuaikan konfigurasi anda
