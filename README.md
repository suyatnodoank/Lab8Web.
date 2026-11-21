# Lab8Web: PHP dan Database MySQL

Laporan Praktikum 8 mata kuliah **Pemrograman Web OBE**, Program Studi Teknik Informatika.

| | |
|---|---|
| **Nama** | `Suyatno` |
| **NIM** | `312510129` |
| **Kelas** | `I253C` |
| **Mata Kuliah** | Pemrograman Web |

---

## Tujuan Praktikum

1. Memahami konsep dasar database.
2. Memahami konsep dasar CRUD (*Create, Read, Update, Delete*) menggunakan PHP.
3. Membuat program CRUD sederhana menggunakan PHP dan MySQL.

## Lingkungan Praktikum

- Web server dan database: XAMPP (Apache dan MySQL/MariaDB)
- Text editor: Visual Studio Code
- Akses database: phpMyAdmin
- Direktori proyek: `htdocs/lab8_php_database`

## Struktur Proyek

```
lab8_php_database/
├── screenshots/          # folder penyimpanan gambar barang
├── koneksi.php      # koneksi ke database
├── index.php        # Read   : menampilkan data
├── tambah.php       # Create : menambah data
├── ubah.php         # Update : mengubah data
├── hapus.php        # Delete : menghapus data
└── style.css        # tampilan seluruh halaman
```

---

## Langkah-langkah Praktikum

### 1. Menjalankan MySQL Server

Modul **Apache** dan **MySQL** dijalankan melalui *XAMPP Control Panel* dengan menekan tombol **Start** pada masing-masing modul. Status modul yang aktif ditandai dengan warna hijau.

<img width="662" height="422" alt="1  Menjalankan Xampp" src="https://github.com/user-attachments/assets/c5acc30a-fa8b-4134-84a7-dcbc3a8a1fc6" />
### 2. Mengakses phpMyAdmin

Setelah Apache dan MySQL berjalan, phpMyAdmin dibuka melalui peramban pada alamat `http://localhost/phpmyadmin/`. Aplikasi ini digunakan sebagai klien untuk mengelola database.


### 3. Membuat Database dan Tabel

Database dengan nama `latihan1` dibuat terlebih dahulu, kemudian tabel `data_barang` dibuat di dalamnya.

```sql
CREATE DATABASE latihan1;

CREATE TABLE data_barang (
  id_barang   int(10) auto_increment Primary Key,
  kategori    varchar(30),
  nama        varchar(30),
  gambar      varchar(100),
  harga_beli  decimal(10,0),
  harga_jual  decimal(10,0),
  stok        int(4)
);
```
<img width="956" height="655" alt="2  Membuat database" src="https://github.com/user-attachments/assets/06d294d4-b038-48ee-bc9d-4ac58f3c522e" />


Kolom `id_barang` berfungsi sebagai *primary key* dengan *auto increment*, sehingga setiap data memiliki identitas unik yang dibuat otomatis.

<img width="960" height="762" alt="3  Membuat tabel" src="https://github.com/user-attachments/assets/40e810bc-9875-4c42-9da8-377d141b2860" />
### 4. Menambahkan Data Awal

Tiga data barang dimasukkan sebagai data awal menggunakan perintah `INSERT`.

```sql
INSERT INTO data_barang (kategori, nama, gambar, harga_beli, harga_jual, stok)
VALUES ('Elektronik', 'HP Samsung Android', 'hp_samsung.jpg', 2000000, 2400000, 5),
       ('Elektronik', 'HP Xiaomi Android',  'hp_xiaomi.jpg',  1000000, 1400000, 5),
       ('Elektronik', 'HP OPPO Android',    'hp_oppo.jpg',    1800000, 2300000, 5);
```

Hasilnya diverifikasi dengan `SELECT * FROM data_barang;`.

<img width="1239" height="932" alt="4  Menambahkan data" src="https://github.com/user-attachments/assets/0db669f9-ce38-474c-9b59-3624ef940f9d" />
### 5. Membuat Folder Proyek

Folder `lab8_php_database` dibuat pada direktori `htdocs` milik XAMPP, lalu diakses melalui `http://localhost/lab8_php_database/`.

<img width="1230" height="847" alt="5  Membuat dan mengakses direktori web server" src="https://github.com/user-attachments/assets/9c25b1f9-fd85-448b-b5d3-732cf6d581fa" />
### 6. Membuat File Koneksi (`koneksi.php`)

File ini menghubungkan PHP dengan database menggunakan fungsi `mysqli_connect()`. Apabila koneksi gagal, program menampilkan pesan kesalahan dan dihentikan dengan `die()`. File ini di-*include* oleh seluruh file CRUD.

```php
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "latihan1";

$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn == false) {
    echo "Koneksi ke server gagal.";
    die();
} #else echo "Koneksi berhasil";
?>
```

Pengujian dilakukan dengan menghilangkan komentar pada `echo "Koneksi berhasil";` lalu membuka `koneksi.php` pada peramban.

<img width="1074" height="770" alt="6 1 hasil kode php koneksi" src="https://github.com/user-attachments/assets/a151d470-da68-407d-8e97-289f800ed269" />
### 7. Menampilkan Data (*Read*): `index.php`

Halaman ini menjalankan query `SELECT * FROM data_barang`, kemudian menampilkan setiap baris hasilnya pada tabel HTML melalui perulangan `while`. Kolom **Aksi** berisi tautan **Ubah** dan **Hapus** yang membawa parameter `id` barang, serta terdapat tautan **Tambah Barang** di atas tabel.
<img width="1003" height="950" alt="7  Kode index php" src="https://github.com/user-attachments/assets/0ccf7731-a464-43a5-b16d-25b336ffb166" />

<img width="1204" height="898" alt="7 1 hasil Kode index php" src="https://github.com/user-attachments/assets/c53a9e83-2a85-4bfe-b68b-8368bb98c56c" />
### 8. Menambah Data (*Create*): `tambah.php`

Halaman berisi formulir dengan metode `POST` dan `enctype="multipart/form-data"` agar dapat mengunggah gambar. Setelah formulir dikirim, program:

1. membaca nilai input dari `$_POST` dan berkas dari `$_FILES`,
2. memindahkan gambar yang diunggah ke folder `gambar/` dengan `move_uploaded_file()`,
3. menyimpan data ke tabel dengan perintah `INSERT`,
4. mengalihkan pengguna kembali ke `index.php`.

<img width="1090" height="1028" alt="8  Kode tambah php" src="https://github.com/user-attachments/assets/b477dff4-ef87-4771-b4d8-3a656177b576" />

<img width="1165" height="697" alt="8 1 hasil Kode tambah php" src="https://github.com/user-attachments/assets/21d66d8d-810c-43fe-b440-409e8cc91691" />
### 9. Mengubah Data (*Update*): `ubah.php`

Halaman menerima `id` melalui parameter URL (`ubah.php?id=...`), mengambil data barang terkait, lalu menampilkannya pada formulir sebagai nilai awal. Saat formulir dikirim, data diperbarui dengan perintah `UPDATE ... WHERE id_barang = ...`. Kolom gambar hanya diperbarui apabila pengguna mengunggah berkas baru.

<img width="1317" height="998" alt="9  Kode ubah php" src="https://github.com/user-attachments/assets/a6184fa4-0892-4d20-b6c3-24c2dbb84856" />
### 10. Menghapus Data (*Delete*): `hapus.php`

File ini menerima `id` melalui parameter URL, menjalankan perintah `DELETE FROM data_barang WHERE id_barang = ...`, lalu mengalihkan pengguna ke `index.php`. Pada tampilan, tautan **Hapus** dilengkapi dialog konfirmasi sebelum penghapusan dilakukan.

<img width="1178" height="596" alt="10  apus php" src="https://github.com/user-attachments/assets/89d48177-c05e-4fa2-b11a-ef9ce8d9607c" />
### 11. Penataan Tampilan (`style.css`)

Seluruh halaman memakai satu berkas `style.css` yang mengatur tata letak kontainer, formulir, tombol aksi, dan tabel.

---

## Cara Menjalankan

1. Salin folder `lab8_php_database` ke `htdocs` XAMPP.
2. Jalankan **Apache** dan **MySQL** melalui XAMPP Control Panel.
3. Buat database `latihan1` dan tabel `data_barang` pada phpMyAdmin (SQL pada langkah 3).
4. Buat folder `gambar/` di dalam proyek, lalu letakkan berkas gambar data awal.
5. Buka `http://localhost/lab8_php_database/`.

## Kesimpulan

Praktikum ini menunjukkan alur lengkap aplikasi CRUD sederhana: PHP terhubung ke MySQL melalui `mysqli`, operasi *Create, Read, Update, Delete* masing-masing dipetakan ke perintah SQL `INSERT`, `SELECT`, `UPDATE`, dan `DELETE`, serta data dari formulir HTML dikirim ke server melalui `$_POST`, `$_GET`, dan `$_FILES`. Praktikum ini juga memperlihatkan pentingnya validasi input dan penggunaan *prepared statement* untuk mencegah kerentanan keamanan pada aplikasi web.
