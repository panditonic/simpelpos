

# SimpelPOS 🚀

SimpelPOS adalah aplikasi Point of Sale (POS) sederhana yang dikembangkan dengan kecepatan kilat menggunakan **Laravel v10**. Proyek ini dirancang dalam waktu hanya 4 hari, menyerupai keajaiban membangun candi dalam sehari semalam, namun tetap menghadirkan fitur-fitur modern dan andal untuk mendukung pengelolaan penjualan Anda! 🎉

**SimpelPOS** adalah aplikasi Point of Sale (POS) sederhana yang dibangun menggunakan **Laravel v10**. Aplikasi ini dirancang untuk memudahkan pengelolaan penjualan dengan antarmuka yang **responsif**, **gratis**, dan **open-source**. Bebas digunakan dan dimodifikasi sesuai kebutuhan Anda! 🎉

## ✨ Fitur Utama
- 🖥 **Tampilan Responsif**: Antarmuka yang menyesuaikan dengan perangkat apa pun, dari desktop hingga mobile.
- 🛠 **CRUD Lengkap**: Fitur Create, Read, Update, Delete untuk pengelolaan data yang mudah.
- 📊 **Analitik Visual**: Laporan penjualan dengan chart interaktif.
- 🔒 **Manajemen Login**: Sistem autentikasi yang aman dengan konfirmasi login/logout.
- ⚙ **Custom Filter**: Filter data yang fleksibel, tersedia dalam mode SPA dan non-SPA.
- 🆓 **Gratis & Open-Source**: Tanpa biaya, tanpa iklan, dan bebas dimodifikasi.

## 📸 Tampilan Aplikasi
Berikut adalah cuplikan tampilan SimpelPOS:

1. **🏠 Halaman Dasbor**  
   Dashboard yang memberikan gambaran umum aktivitas bisnis Anda.  
   ![Dasbor](/docs/dasbor.png)

2. **🔑 Halaman Login**  
   Antarmuka login yang aman dengan konfirmasi login dan logout.  
   ![Login](/docs/loginkonfirm.png)  
   ![Logout](/docs/logoutkonfirm.png)

3. **📈 Chart Analitik**  
   Visualisasi data penjualan untuk analisis yang lebih baik.  
   ![Analitik](/docs/analitik.png)

4. **🛠 CRUD Enrichment**  
   Fitur pengelolaan data dengan tambahan enrichment untuk pengalaman pengguna yang lebih baik.  
   ![CRUD Enrichment](/docs/crudenrichment.png)

5. **🔍 CRUD Custom Filter (SPA)**  
   Filter data dinamis dalam mode Single Page Application.  
   ![Custom Filter SPA](/docs/crudcustomfilter.png)

6. **🔍 CRUD Custom Filter (Non-SPA)**  
   Filter data dalam mode non-SPA untuk fleksibilitas lebih.  
   ![Custom Filter Non-SPA](/docs/crudcustomfilternospa.png)

7. **🛒 Penjualan**  
   Kelola transaksi penjualan dengan mudah dan cepat.  
   ![Penjualan](/docs/tpenjualan.png)  
   ![Penjualan Enrichment](/docs/tpenjualanenrichment.png)

## 🚀 Cara Instalasi
1. **Clone Repository**  
   ```bash
   git clone https://github.com/username/simpelpos.git
   ```
2. **Masuk ke Direktori**  
   ```bash
   cd simpelpos
   ```
3. **Install Dependencies**  
   ```bash
   composer install
   npm install
   ```
4. **Konfigurasi Environment**  
   Salin file `.env.example` ke `.env` dan sesuaikan pengaturan database.  
   ```bash
   cp .env.example .env
   ```
5. **Generate Key**  
   ```bash
   php artisan key:generate
   ```
6. **Jalankan Migrasi**  
   ```bash
   php artisan migrate
   ```
7. **Jalankan Aplikasi**  
   ```bash
   php artisan serve
   ```
   Buka di browser: `http://localhost:8000`

## 🛠 Prasyarat
- PHP >= 8.1
- Composer
- Node.js & NPM
- Database (MySQL/PostgreSQL/SQLite)
- Laravel v10

## 📝 Kontribusi
Kami sangat terbuka untuk kontribusi! Silakan fork repository ini, buat perubahan, dan kirimkan pull request. 💪  
1. Fork proyek
2. Buat branch fitur (`git checkout -b fitur-baru`)
3. Commit perubahan (`git commit -m 'Menambahkan fitur baru'`)
4. Push ke branch (`git push origin fitur-baru`)
5. Buat Pull Request

## 📜 Lisensi
SimpelPOS dilisensikan di bawah [MIT License](LICENSE). Bebas digunakan dan dimodifikasi tanpa batasan! 🥳

## 📬 Kontak
Ada pertanyaan atau saran? Hubungi kami melalui [email@example.com](mailto:email@example.com) atau buka issue di repository ini.

---

⭐ **Jangan lupa beri bintang di GitHub jika Anda menyukai proyek ini!** ⭐

