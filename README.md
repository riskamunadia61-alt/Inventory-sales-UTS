# Dior Boutique Management System
> **Integrated Laravel Project — UTS Web Programming 2**  
> System Management Inventaris, Transaksi Penjualan, dan Pembelian Barang Terintegrasi.

---

## 📋 Project Overview

**Dior Boutique Management System** adalah aplikasi web manajemen inventaris dan transaksi penjualan yang dirancang khusus untuk memodernisasi pencatatan stok dan laporan penjualan pada Dior Boutique. Aplikasi ini menyelesaikan permasalahan pencatatan manual seperti ketidaksesuaian stok, risiko *overselling* (menjual produk yang stoknya habis), keterbatasan penelusuran riwayat transaksi, serta kebutuhan pembatasan hak akses antara Pemilik (*Owner/Admin*) dan Staf Opsional (*Staff*).

### Tujuan Sistem
- Mengelola master data (Kategori, Produk dengan SKU unik, Pemasok, Pengguna).
- Memproses transaksi pembelian (*Purchase / Stock-in*) dan penjualan (*Sales / Stock-out*) secara konsisten dan terotomatisasi.
- Menjamin konsistensi stok produk secara real-time menggunakan *database transaction* (`DB::transaction`).
- Membatasi fungsi sensitif berdasarkan peran pengguna (*Role-Based Access Control*).
- Menyediakan dashboard ringkasan serta laporan penjualan dengan fitur pencarian, filter tanggal, dan paginasi.

---

## 🛠️ Requirements & Stack

- **PHP:** >= 8.2
- **Framework:** Laravel 11.x
- **Database:** MySQL / MariaDB
- **Web Server Host Local:** XAMPP / Laragon
- **Frontend:** Blade Templating, Tailwind CSS / Custom CSS
- **Tools & Environment:** Visual Studio Code, Git, Composer, Node.js & NPM

---

## 🚀 Installation & Reproducibility Guide

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek pada *environment* baru:

### 1. Clone Repository
```bash
git clone https://github.com/username/dior-store.git
cd dior-store
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment File
Salin file `.env.example` menjadi `.env` dan atur kunci aplikasi:
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Buka file `.env` di teks editor Anda, lalu sesuaikan pengaturan koneksi database MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dior_boutique_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migration & Database Seeding
Jalankan migrasi database dan pengisian data *seed* awal:
```bash
php artisan migrate --seed
```

### 6. Build Asset Frontend & Jalankan Server
```bash
npm run build
php artisan serve
```
Akses aplikasi melalui browser di: `http://127.0.0.1:8000`

---

## 🔑 Akun Demo (Demo Accounts)

Aplikasi dilengkapi dengan data awal (*seeder*) untuk mempermudah pengujian hak akses (*role-based access control*):

| Role | Email | Password | Hak Akses Utama |
| :--- | :--- | :--- | :--- |
| **Admin / Owner** | `riska@admin.com` | `password` | Akses penuh (Manajemen User, CRUD Master Data, Pembelian, Penjualan, Laporan, Dashboard) |
| **Staff** | `staff@dior.com` | `password` | Terbatas (Input Pembelian/Penjualan, Melihat Produk/Laporan dasar; *Dilarang mengelola User/Hapus Master Data*) |

> **Catatan:** Jangan gunakan data rahasia atau kredensial pribadi pada repositori publik.

---

## 🗄️ Data Model & Relasi Eloquent

### Structure ERD (Entity Relationship Diagram)
- **`users`**: `(id, name, email, password, role, timestamps)`
- **`categories`**: `(id, name, timestamps)`
- **`products`**: `(id, category_id, sku, name, purchase_price, selling_price, stock, minimum_stock, timestamps)`
- **`suppliers`**: `(id, name, phone, email, timestamps)`
- **`purchases`**: `(id, supplier_id, user_id, purchase_number, total, status, purchased_at, timestamps)`
- **`purchase_items`**: `(id, purchase_id, product_id, quantity, unit_cost, subtotal, timestamps)`
- **`sales`**: `(id, user_id, sale_number, total, status, sold_at, timestamps)`
- **`sale_items`**: `(id, sale_id, product_id, quantity, unit_price, subtotal, timestamps)`

### Relasi Eloquent
- `Category` **hasMany** `Product` | `Product` **belongsTo** `Category`
- `Supplier` **hasMany** `Purchase` | `Purchase` **belongsTo** `Supplier`
- `Purchase` **hasMany** `PurchaseItem` | `PurchaseItem` **belongsTo** `Purchase`
- `PurchaseItem` **belongsTo** `Product`
- `User` **hasMany** `Sale` | `Sale` **belongsTo** `User`
- `Sale` **hasMany** `SaleItem` | `SaleItem` **belongsTo** `Sale`
- `SaleItem` **belongsTo** `Product`
- `Product` **hasMany** `SaleItem` & `PurchaseItem`

---

## ⚙️ Key Business Rules & Logic Implementation

1. **Konsistensi Stok Atomis (`DB::transaction`):**
   Setiap transaksi penjualan dan pembelian dibungkus di dalam blok `DB::transaction()`. Jika salah satu detail barang gagal tersimpan atau stok tidak cukup, seluruh transaksi otomatis di-*rollback* tanpa menyisakan data setengah tersimpan.
2. **Pencegahan Overselling:**
   Saat penjualan diinput, sistem memvalidasi stok di tingkat server (`Product::lockForUpdate()`). Transaksi ditolak dengan pesan peringatan apabila kuantitas melebihi stok yang tersedia.
3. **Perhitungan Harga Server-Side:**
   Subtotal dan total transaksi dihitung murni di sisi server dari database untuk mencegah manipulasi data dari input browser (*client-side*).
4. **Keamanan & Otorisasi Server-Side:**
   Seluruh rute dilindungi oleh *Middleware* (`auth` dan `can`/`role`). Staf yang mencoba mengakses halaman khusus Admin melalui URL langsung akan diblokir (*HTTP 403 Forbidden / Redirect*).
5. **Integritas Data Master:**
   SKU produk dijamin unik di tingkat database (*unique constraint*) dan validasi controller. Produk yang sudah terhubung dengan transaksi tidak dapat dihapus secara *hard-delete*.

---

## 🧪 Automated Testing (Feature Test Minimum Scenario)

Aplikasi ini mencakup suite pengujian otomatis melalui file `tests/Feature/StoreTest.php` untuk memverifikasi seluruh skenario pengujian minimum UTS:

1. **Auth:** Guest diarahkan ke halaman login saat membuka dashboard.
2. **Product Validation:** SKU duplikat dan harga bernilai negatif ditolak oleh sistem.
3. **Purchase:** Transaksi pembelian yang sukses otomatis menambah stok produk.
4. **Sale:** Transaksi penjualan yang sukses otomatis mengurangi stok produk.
5. **Insufficient Stock:** Transaksi ditolak jika stok tidak mencukupi tanpa ada perubahan data pada database.
6. **Atomicity:** Kegagalan pada salah satu item transaksi akan me-*rollback* seluruh header dan item.
7. **Authorization:** Pengguna ber-role `staff` dilarang mengakses area manajemen Admin.
8. **Search & Pagination:** Pencarian, filter tanggal, dan paginasi laporan menghasilkan data yang akurat.

### Cara Menjalankan Testing di Terminal:
```bash
php artisan test
```
*Atau hanya untuk menguji skenario StoreTest:*
```bash
php artisan test --filter=StoreTest
```

---

## 📌 Features & Page Highlights

- **Authentication & Role Management:** Login/Logout, Password Hashing, Proteksi Rute.
- **Master Data Management:** CRUD Kategori, CRUD Produk (dengan peringatan stok rendah), CRUD Pemasok.
- **Transactions:**
  - Pembelian (*Stock-in*): Penambahan kuantitas stok otomatis.
  - Penjualan (*Stock-out*): Pengurangan kuantitas stok otomatis, validasi kecukupan stok, cetak struk transaksi.
- **Usability & Reports:**
  - Search & Filter: Pencarian fleksibel berdasarkan ID/Nama Pelanggan dan Filter Tanggal.
  - Pagination: Penanganan data besar tanpa *overloading* memori.
  - Dashboard: Statistik real-time total produk, total transaksi, total pendapatan, dan indikator produk stok rendah.

---

## ⚠️ Known Limitations

1. **Multi-Warehouse:** Aplikasi saat ini hanya mendukung 1 lokasi gudang utama (*single warehouse*).
2. **Mata Uang:** Transaksi saat ini dibatasi hanya dalam format mata uang tunggal (Rupiah / IDR).
3. **Pembatalan Transaksi Khusus:** Pembatalan transaksi kompleks atau pengembalian barang (*retur*) belum terhubung ke sistem jurnal akuntansi eksternal.

