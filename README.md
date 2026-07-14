# PureStrands 🌿
PureStrands adalah aplikasi web berbasis Laravel yang dirancang untuk memberikan solusi kesehatan dan perawatan rambut menyeluruh secara digital. Aplikasi ini menggabungkan e-commerce produk perawatan rambut, analisis kesehatan rambut interaktif berbasis AI, pemesanan sesi konsultasi dengan dokter spesialis, serta sistem keanggotaan (Subscription) dan loyalitas (PurePoints).
---
## 🛠️ Tech Stack & Arsitektur
- **Backend**: Laravel 11.x (PHP 8.2+)
- **Database**: MySQL / MariaDB
- **Frontend**: HTML5, Vanilla CSS, dan JavaScript modern (Vite)
- **UI/UX**: Responsive Mobile-First Design (dioptimalkan untuk tampilan desktop & mobile)
- **Icons**: FontAwesome 6 (Solid & Regular)
- **Fonts**: Outfit & Inter (Google Fonts)
---
## ✨ Fitur Utama saat ini
### 1. 🛍️ Product Marketplace
- Pencarian dan filter produk berdasarkan kategori (Shampoo, Serum, Scalp Care, dll).
- Pemilihan warna/shades produk menggunakan palet warna interaktif.
- Alur keranjang belanja (Cart) dan simulasi checkout.
### 2. 🤖 AI Hair Scan
- Kuisioner interaktif untuk mendiagnosis masalah rambut pengguna (kerontokan, ketombe, strand thickness).
- Rekomendasi produk PureStrands yang disesuaikan secara dinamis berdasarkan hasil diagnosis.
### 3. 👨‍⚕️ Konsultasi Dokter (PureConsult)
- Daftar dokter ahli (Dermatolog & Hair Stylist) lengkap dengan profil dan rating.
- Manajemen jadwal konsultasi dan alur booking slot tanggal/jam.
### 4. 🎟️ PurePoints & Voucher
- Sistem loyalitas dengan 3 tab navigasi: **Voucher** (tersedia), **Redeem** (aktif & siap pakai dengan kode QR/salin kode), dan **Expired** (riwayat penggunaan).
- Modul informasi cara mendapatkan poin yang terintegrasi dengan fitur Tanya AI.
### 5. 💎 Subscription Plans
- Pilihan paket Standard (Rp25K/bulan) dan Premium (Rp45K/bulan).
- Paket hemat 6 bulan & tahunan dengan diskon khusus.
### 6. 🔒 Admin Panel Control
- Dashboard admin khusus untuk mengelola data master: Kategori Produk, Produk, Dokter Ahli, Jadwal Dokter, dan mengonfirmasi status booking konsultasi pengguna.
---
## 🚀 Rencana Pengembangan Masa Depan (Roadmap)
1. **Payment Gateway Integration**: Menghubungkan Midtrans/Xendit untuk pembayaran subscription dan produk secara otomatis.
2. **Real-Time Teleconsultation**: Implementasi video call & chat interaktif langsung via WebRTC & WebSockets.
3. **Computer Vision AI Scan**: Deteksi masalah rambut berbasis analisis foto menggunakan Machine Learning.
4. **Automated PurePoints Engine**: Otomatisasi perolehan poin dari aktivitas belanja, review produk, dan check-in harian.
5. **E-Prescription & Notification System**: Integrasi resep dokter langsung ke checkout serta sistem pengingat jadwal via push notification.