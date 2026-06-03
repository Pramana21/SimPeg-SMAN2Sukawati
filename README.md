# SIPAD SMAN 2 Sukawati

Sistem Informasi Pengarsipan Dokumen (SIPAD) SMAN 2 Sukawati merupakan aplikasi berbasis Laravel yang digunakan untuk mengelola semua dokumen dari data pegawai, siswa, penyuratan, administrasi, inventaris, keuangan, agenda, serta manajemen pengguna dan hak akses dalam satu platform terintegrasi.

## Requirement

* PHP ^8.2
* Composer
* Node.js ^20.19.0 atau >=22.12.0
* NPM
* SQLite (default)

### PHP Extensions

```txt
ctype
date
dom
fileinfo
filter
hash
iconv
json
libxml
mbstring
openssl
pcre
phar
reflection
session
simplexml
tokenizer
xml
xmlwriter
```

## Technology Stack

| Technology   | Version          |
| ------------ | ---------------- |
| Laravel      | 12.53.0          |
| PHP          | ^8.2             |
| Tailwind CSS | 3.x              |
| Alpine.js    | 3.x              |
| Axios        | Latest           |
| Vite         | 7.x              |
| DomPDF       | 3.1.2            |
| SQLite       | Default Database |

## Features

* Authentication & Authorization
* Role & Permission Management
* User Management
* Employee Management
* Student Management
* Document Management
* Correspondence Management
* Financial Document Management
* Inventory Management
* Agenda Management
* Audit Log
* PDF Export
* CSV Export

## Installation

Clone repository:

```bash
git clone https://github.com/USERNAME/REPOSITORY.git #hanya contoh sesuaikan dengan repo yang asli

cd REPOSITORY
```

Install project:

```bash
composer setup
```

Script tersebut akan menjalankan:

```bash
composer install
php artisan key:generate
php artisan migrate --force
npm install
npm run build
```

## Development

Menjalankan environment development:

```bash
composer dev
```

Script tersebut akan menjalankan:

```bash
php artisan serve
php artisan queue:listen
npm run dev
```

## Migrations database dan seed

```bash
php artisan migrate --seed
```

## User Roles

* Super Admin
* Admin Kepegawaian
* Tamu
* Siswa

## Storage

Project menggunakan Laravel Filesystem.

Jika file upload tidak dapat diakses:

```bash
php artisan storage:link
```

## Queue, Cache & Session

| Component | Driver   |
| --------- | -------- |
| Queue     | Database |
| Cache     | Database |
| Session   | Database |

## Scheduler

Scheduler harian:

```bash
clean:audit-log
```

## Project Structure

```text
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
tests/
```

## Migration to Another Device

Pastikan file berikut ikut dipindahkan:

```text
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/

composer.json
composer.lock
package.json
package-lock.json
.env
```

Kemudian jalankan:

```bash
composer setup
composer dev
```

## License

Project ini dikembangkan untuk kebutuhan operasional dan administrasi SMAN 2 Sukawati.
