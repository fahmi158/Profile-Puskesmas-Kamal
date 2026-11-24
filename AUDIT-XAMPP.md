# AUDIT KEAMANAN XAMPP & PHP

**Tanggal audit:** 4 November 2026
**Metode:** read-only (tanpa mengubah Apache, MySQL, PHP, atau file proyek)
**Auditor:** Senior PHP Infrastructure / Security Engineer
**Status:** Audit selesai - **migrasi SUDAH DIEKSEKUSI** (4 November 2026) dengan strategi *side-by-side*, dilanjutkan **hardening P0** (Apache hanya loopback, `.env`/`.git`/log diblokir, directory listing mati) dan **P1** (phpMyAdmin wajib login, DVWA dipindah, versi server disembunyikan, `local_infile=0`, MariaDB hanya loopback). Lihat §12 untuk hasil verifikasi.

---

## 1. Ringkasan Eksekutif

| Temuan utama | Dampak |
|---|---|
| **XAMPP yang terpasang adalah versi 8.1.25, bukan PHP 8.3.x** | Premis awal audit tidak sesuai fakta. PHP Apache saat ini **8.1.25** dan sudah **End of Life** sejak 31 Desember 2025. |
| **Proyek Laravel 13 tidak dapat berjalan di PHP XAMPP** | `C:\MAGANG\Puskesmas` mensyaratkan `php ^8.3`; PHP XAMPP 8.1.25 akan gagal saat bootstrap. |
| **PHP yang dipakai proyek adalah Laragon 8.3.31, bukan XAMPP** | Ada dua instalasi PHP berbeda. `php` di PATH menunjuk Laragon; Apache XAMPP memakai PHP lain. |
| **Apache 2.4.58 (Okt 2023) tertinggal 11 rilis** | 72 CVE telah diperbaiki pada rilis 2.4.59–2.4.69 (sumber: httpd.apache.org). |
| **MariaDB 10.4.32 sudah EOL (18 Juni 2024)** | Tidak ada patch keamanan lagi. |
| **DVWA + banyak aplikasi PHP lama berada di `htdocs`** | Apache `Listen 80/443` di semua interface dan berjalan sebagai `LocalSystem`. Berisiko bila host terekspos ke LAN. |
| **`.env` Laravel lama dapat diakses langsung di `htdocs`** | Kebocoran kredensial bila Apache melayani folder proyek tersebut. |
| **Konfigurasi PHP permisif** (`expose_php=On`, `display_errors=On`, `session.use_strict_mode=0`, cookie tanpa `HttpOnly`/`SameSite`) | Information disclosure dan pelemahan proteksi session. |
| **`session.upload_progress.enabled = On`** | Menambah permukaan serangan bila digabung dengan LFI/upload. Sebaiknya `Off`. |

> **Kesimpulan:** instalasi XAMPP ini **tidak layak** menjadi runtime produksi maupun pengembangan Laravel 13/Filament 5 dalam kondisi sekarang. Diperlukan migrasi PHP ke **8.3.36-1 (TS, x64)**, disusul pembaruan Apache, MariaDB, dan hardening konfigurasi.

---

## 2. Ruang Lingkup & Batasan

Yang **dilakukan**:
- Inspeksi versi, path, service, port, konfigurasi, dan daftar ekstensi.
- Pembacaan `composer.json` proyek dan `composer check-platform-reqs`.
- Verifikasi ketersediaan PHP target dari sumber resmi (`windows.php.net`, `php.net`).
- Pembuatan **salinan backup** `php.ini` dan konfigurasi Apache.
- Penyusunan rencana migrasi dan rollback.

Yang **TIDAK dilakukan**:
- Tidak mengubah/menghapus/memindahkan file atau folder instalasi.
- Tidak mengubah konfigurasi Apache, MySQL, maupun PHP yang aktif.
- Tidak menampilkan nilai password/secret dari `.env`.
- Tidak mengubah database.
- Tidak mengganti PHP.

---

## 3. Kondisi Instalasi

### 3.1 Lokasi XAMPP

| Item | Nilai |
|---|---|
| Lokasi | `C:\xampp` |
| Registry | `XAMPP 8.1.25-0`, `InstallLocation = C:\xampp` |
| Control Panel | `C:\xampp\xampp-control.exe` — versi file **3.3.0.0** |
| DocumentRoot | `C:/xampp/htdocs` |
| Service Apache | `Apache2.4` — **Running**, StartMode **Auto**, akun **LocalSystem** |
| Service MySQL | `mysql` — **Running**, StartMode **Auto**, akun **LocalSystem** |
| Konfigurasi Apache | `C:\xampp\apache\conf\httpd.conf` (21.814 bytes) |
| Konfigurasi PHP | `C:\xampp\php\php.ini` (76.551 bytes, 2025-05-24) |
| `httpd -t` | **Syntax OK** |

Catatan: `C:\xampp` dan `C:\XAMPP` adalah **folder yang sama** (Windows case-insensitive), bukan dua instalasi.

### 3.2 PHP: CLI vs Apache — DUA INSTALASI BERBEDA

| Konteks | Binary | Versi | Thread Safe | Arch |
|---|---|---|---|---|
| PHP di PATH / terminal | `C:\laragon\bin\php\php-8.3.31-Win32-vs16-x64\php.exe` | **8.3.31** | ZTS (TS) | 64-bit |
| PHP yang dipakai Apache XAMPP | `C:\xampp\php\php8apache2_4.dll` | **8.1.25** | ZTS (TS) | 64-bit |
| PHP proyek berjalan (port 8000) | `C:\laragon\bin\php\php-8.3.31-...\php.exe` (PID 25620) | **8.3.31** | ZTS | 64-bit |
| PHP lain di Laragon | `php-8.1.10`, `php-8.4.22`, `php-8.5.3` | — | — | 64-bit |

**Implikasi:** perintah `php -v`, `composer`, dan `php artisan` memakai **PHP 8.3.31 Laragon**, sedangkan Apache XAMPP memakai **PHP 8.1.25**. Ini adalah sumber kebingungan dan *version skew* yang serius.

### 3.3 Versi Seluruh Komponen

| Komponen | Versi terpasang | Rilis | Status |
|---|---|---|---|
| XAMPP | 8.1.25-0 | ~Nov 2023 | Usang |
| PHP (Apache) | **8.1.25** TS x64 | 25 Okt 2023 | **EOL 31-12-2025** |
| PHP (CLI/PATH) | **8.3.31** TS x64 | 2026 | Perlu patch ke 8.3.36 |
| Apache | **2.4.58** (Win64) Apache Lounge VS17 | 18 Okt 2023 | Usang (2.4.69 tersedia) |
| MariaDB | **10.4.32-MariaDB** Win64 | — | **EOL 18-06-2024** |
| phpMyAdmin | **5.2.1** | — | Perlu uji/upgrade untuk PHP 8.3 |
| OpenSSL bundled PHP XAMPP | **1.1.1w** (`libcrypto-1_1-x64.dll`) | — | **EOL Sep 2023** |
| OpenSSL Apache | **3.1.3** (`libcrypto-3-x64.dll`) | — | Usang |
| Visual C++ Redistributable x64 | 14.50.35719 | — | Memenuhi syarat PHP 8.3 (VS16) |
| Composer platform | PHP 8.3.31 | — | `check-platform-reqs`: semua **success** |

### 3.4 Lokasi `php.ini`

| Konteks | File |
|---|---|
| PHP XAMPP (Apache & CLI XAMPP) | `C:\xampp\php\php.ini` |
| PHP Laragon (CLI/PATH) | `C:\laragon\bin\php\php-8.3.31-Win32-vs16-x64\php.ini` |
| Template XAMPP | `C:\xampp\php\php.ini-development`, `php.ini-production` |

Tidak ada file `.ini` tambahan yang di-scan (`Additional .ini files parsed: none`).

### 3.5 Port & Proses

| Port | Proses | Keterangan |
|---|---|---|
| 80 | `httpd` PID 5032 | `Listen 80` di semua interface; saat audit berstatus **FIN_WAIT_1** (indikasi proses baru restart / koneksi menggantung) |
| 443 | `httpd` PID 5032 | **LISTENING** (mod_ssl aktif) |
| 3306 | `mysqld` PID 5288 | MariaDB XAMPP (`my.ini`: `port=3306`, `datadir=C:/xampp/mysql/data`) |
| 8000 | `php` PID 25620 | `php artisan serve` memakai PHP Laragon 8.3.31 |

Tidak ada konflik port 3306. Tidak ada service MySQL Laragon yang berjalan bersamaan.

### 3.6 Apache: modul & pengikatan PHP

```
mpm_winnt_module (static)
alias_module, env_module, headers_module, rewrite_module,
setenvif_module, ssl_module (shared)
php_module (shared)
```

`C:\xampp\apache\conf\extra\httpd-xampp.conf`:
```apache
LoadModule php_module "C:/xampp/php/php8apache2_4.dll"
PHPINIDir "C:/xampp/php"
```
PHP dijalankan sebagai **mod_php (Apache module)**, bukan CGI/FastCGI.

Akses dibatasi `Require local` untuk `/phpmyadmin`, `/webalizer`, dan `/xampp`. Namun **aplikasi di `htdocs` tetap dapat diakses dari interface jaringan** karena `Listen 80/443` dan tidak ada `Require local` global.

---

## 4. Inventaris Ekstensi PHP Aktif (XAMPP 8.1.25)

### 4.1 Dimuat saat runtime (39 modul)

```
bcmath, bz2, calendar, Core, ctype, curl, date, dom, exif, fileinfo,
filter, ftp, gettext, hash, iconv, json, libxml, mbstring, mysqli,
mysqlnd, openssl, pcre, PDO, pdo_mysql, pdo_sqlite, Phar, readline,
Reflection, session, SimpleXML, SPL, standard, tokenizer, xml,
xmlreader, xmlwriter, zip, zlib
```

Modul Zend: **tidak ada** — `opcache` **belum diaktifkan**.

### 4.2 Diaktifkan eksplisit via `php.ini`

```ini
extension=bz2
extension=curl
extension=fileinfo
extension=gettext
extension=mbstring
extension=exif
extension=mysqli
extension=pdo_mysql
extension=pdo_sqlite
extension=php_openssl.dll
extension=php_ftp.dll
```

Sisanya adalah ekstensi *built-in* atau dimuat otomatis oleh build XAMPP.

### 4.3 Tersedia tetapi BELUM aktif (DLL ada di `ext`)

`gd`, `intl`, `sodium`, `xsl`, `sqlite3`, `opcache`, `soap`, `sockets`, `ldap`, `imap`, `snmp`, `tidy`, `odbc`, `pgsql`, `pdo_pgsql`, `oci8_19`, `ffi`, `dba`, `enchant`, `com_dotnet`, `shmop`, `sysvshm`, `gmp`.

**Catatan penting:** `intl` dan `gd` **wajib** untuk Filament 5 / pengolahan gambar, tetapi **tidak aktif** di XAMPP.

### 4.4 Perbandingan dengan runtime Laragon 8.3.31 (baseline proyek)

Laragon memuat tambahan: **`gd`, `intl`, `sqlite3`, `xsl`**.
XAMPP 8.1.25 **tidak** memuat keempatnya. Jadi meskipun versi PHP dipaksa sama, XAMPP tetap tidak siap menjalankan Filament 5 tanpa aktivasi ekstensi.

---

## 5. `session.upload_progress`

| Direktif | Nilai runtime | Sumber |
|---|---|---|
| `session.upload_progress.enabled` | **On** | default (baris di `php.ini` dikomentari) |
| `session.upload_progress.cleanup` | On | default |
| `session.upload_progress.prefix` | `upload_progress_` | default |
| `session.upload_progress.name` | `PHP_SESSION_UPLOAD_PROGRESS` | default |
| `session.upload_progress.freq` | `1%` | default |
| `session.upload_progress.min_freq` | `1` | default |

**Risiko:** fitur ini menulis progres upload ke file session berdasarkan nama yang dikendalikan klien. Bila aplikasi memiliki celah **Local File Inclusion (LFI)** atau menulis file upload ke direktori yang dapat dieksekusi, penyerang dapat memanfaatkannya untuk menanam payload ke file session. Laravel secara umum memitigasi LFI, tetapi prinsip *least privilege* menyarankan fitur ini **Off** kecuali benar-benar dipakai.

---

## 6. Konfigurasi PHP Berisiko

| Direktif | Nilai | Risiko | Rekomendasi |
|---|---|---|---|
| `expose_php` | **On** | Header `X-Powered-By: PHP/8.1.25` membocorkan versi | `Off` |
| `display_errors` | **On (STDOUT)** | Stack trace/path bocor ke response | `Off` + `log_errors=On` |
| `display_startup_errors` | **On** | Detail kegagalan startup bocor | `Off` |
| `session.use_strict_mode` | **0** | Session fixation | `1` |
| `session.cookie_httponly` | *(kosong → 0)* | Cookie session dapat dibaca JavaScript (XSS) | `1` |
| `session.cookie_samesite` | *(kosong)* | Tidak ada proteksi CSRF berbasis cookie | `Lax` |
| `session.cookie_secure` | 0 | Cookie dikirim via HTTP | `1` setelah HTTPS |
| `open_basedir` | *(kosong)* | Tidak ada batas filesystem | Opsional, perlu pemetaan path |
| `disable_functions` | *(kosong)* | Semua fungsi berbahaya tersedia | Pertimbangkan untuk produksi |
| `allow_url_fopen` | On | SSRF/RFI via wrapper | Pertahankan hanya bila dibutuhkan |
| `cgi.fix_pathinfo` | *(default 1)* | Path confusion (hanya relevan CGI/FastCGI) | `0` |
| `mysqli.allow_local_infile` | Off | Baik | Pertahankan `Off` |
| `mariadb @@local_infile` | **1 (On)** | `LOAD DATA LOCAL INFILE` dapat membaca file klien | Set `local_infile=0` (perubahan DB, terpisah) |
| `opcache` | Nonaktif | Performa rendah | Aktifkan |
| `pdo_mysql.default_socket` | `"MySQL"` lalu di-override kosong | Konfigurasi janggal | Hapus/rapikan |
| `expose_php` + Apache `ServerTokens` | Default | Fingerprinting | `ServerTokens Prod`, `ServerSignature Off` |

### 6.1 Temuan tambahan di luar PHP

| Temuan | Detail | Dampak |
|---|---|---|
| **DVWA terpasang** | `C:\xampp\htdocs\dvwa` | Aplikasi sengaja rentan (SQLi/XSS/upload), kredensial default. Bila Apache terbuka ke LAN, host ini menjadi target. |
| **`.env` di htdocs** | `C:\xampp\htdocs\pendaftaran-pendakian-online-laravel-main\.env` | Dapat diunduh via HTTP → kebocoran kredensial. Isi tidak ditampilkan. |
| **`C:\xampp\passwords.txt`** | File bawaan XAMPP | Menyimpan kredensial default dalam plaintext. Isi tidak ditampilkan. |
| **Apache & MySQL sebagai LocalSystem** | Service `StartName = LocalSystem` | Dampak maksimal bila salah satu service dieksploitasi. |
| **Aplikasi EOL di htdocs** | Laravel 7 (`pendaftaran-pendakian...`, `PROJECT_AKHIR-main\laravel`) | Framework EOL, banyak CVE tidak dipatch. |
| **phpMyAdmin 5.2.1** | Versi lama | Perlu uji kompatibilitas PHP 8.3 dan pembaruan. |
| **Tidak ada TLS yang layak** | `httpd-ssl.conf` bawaan XAMPP (self-signed) | Jangan anggap HTTPS lokal sebagai produksi. |

---

## 7. Inventaris Proyek di `htdocs` (28 folder)

| Proyek | Jenis | PHP | Laravel |
|---|---|---|---|
| `pendaftaran-pendakian-online-laravel-main` | **Laravel** | `^7.2.5` | `^7.24` |
| `PROJECT_AKHIR-main\laravel` | **Laravel** | `^7.2.5` | `^7.0` |
| `pendakian-ciremai-master` | CodeIgniter | `>=5.3.7` | — |
| `simple-crud-main` | CodeIgniter | `>=5.3.7` | — |
| `PAW\rumahmakankita` | CodeIgniter | — | — |
| `dvwa` | Aplikasi rentan (latihan) | — | — |
| `dashboard`, `employee`, `fajar`, `fantastic-LegalSearchEngine-master`, `invoicing`, `koperasi`, `koperasi-app`, `Koperasi-Simpan-Pinjam-main`, `ksp-master`, `New`, `pay`, `Pemesanan-tiket-kereta-api-master`, `penjualan`, `penjualan1`, `rumahsakit`, `SI`, `UAS`, `web-sistem-informasi-kereta-api-transys-master`, `web_gunung` | PHP native / CI / campuran | bervariasi | — |
| `img`, `webalizer`, `xampp` | Aset/bawaan XAMPP | — | — |

Arsip duplikat juga ada: `koperasi-app.rar`, `koperasi-app.zip`, `pay.rar`.

**Proyek aktif yang sedang dikerjakan** berada **di luar htdocs**: `C:\MAGANG\Puskesmas` dan `C:\MAGANG\absensi-app`.

---

## 8. Persyaratan Proyek Laravel

### 8.1 `C:\MAGANG\Puskesmas\composer.json`

```json
"php": "^8.3",
"filament/filament": "^5.10",
"laravel/framework": "^13.17",
"laravel/tinker": "^3.0",
"maestroerror/php-heic-to-jpg": "1.0.8"
```

Versi terpasang: **Laravel 13.35.0**, **Filament 5.10.1**, **Livewire 4.4.7**.

### 8.2 Ekstensi yang dibutuhkan paket

| Paket | Ekstensi |
|---|---|
| `laravel/framework` | `ext-ctype`, `ext-filter`, `ext-hash`, `ext-mbstring`, `ext-openssl`, `ext-session`, `ext-tokenizer` |
| `filament/support` | **`ext-intl`** |
| Kebutuhan tidak langsung (Composer/Laravel/Excel) | `ext-dom`, `ext-xml`, `ext-xmlreader`, `ext-xmlwriter`, `ext-zip`, `ext-iconv`, `ext-fileinfo`, `ext-json`, `ext-libxml`, `ext-pcre`, `ext-phar`, `ext-pdo` |
| Kebutuhan operasional Filament (upload/gambar) | **`ext-gd`** (atau Imagick) |

### 8.3 Hasil `composer check-platform-reqs` (runtime 8.3.31)

Semua kebutuhan **success** pada PHP 8.3.31, termasuk `ext-intl`, `ext-zip`, `ext-dom`.

**Jika dijalankan pada PHP 8.1.25 XAMPP:** akan **gagal** pada `php (^8.3)` dan `ext-intl` (tidak aktif). Ini membuktikan XAMPP belum siap.

### 8.4 Konfigurasi aplikasi (bukan secret)

```
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=puskesmas
SESSION_DRIVER=database
SESSION_ENCRYPT=false
```

`APP_DEBUG=true` wajar untuk lokal, tetapi **wajib `false`** bila aplikasi diekspos.

---

## 9. Konflik Port & Instalasi PHP Ganda

| Konflik | Detail |
|---|---|
| **Dua runtime PHP** | XAMPP 8.1.25 (Apache) vs Laragon 8.3.31 (PATH, CLI, `artisan serve`) |
| **Empat versi PHP di Laragon** | 8.1.10, 8.3.31, 8.4.22, 8.5.3 |
| **Dua Apache** | XAMPP `httpd 2.4.58` (service, port 80/443) dan Laragon `httpd 2.4.54`/`2.4.66` (tidak berjalan) |
| **Dua MySQL** | XAMPP MariaDB 10.4.32 (port 3306, berjalan) dan Laragon MySQL 8.0.30 (client di PATH, service tidak berjalan) |
| **Port 80** | Hanya `httpd` XAMPP yang listen; status sempat `FIN_WAIT_1` → perlu pantau stabilitas |
| **Port 8000** | `php artisan serve` Laragon — bukan Apache |
| **Port 3306** | MariaDB XAMPP; tidak ada bentrok |
| **PATH precedence** | Laragon berada sebelum XAMPP (XAMPP bahkan tidak ada di PATH) |

**Risiko nyata:** pengembang menjalankan `php artisan`/`composer` dengan PHP 8.3.31, lalu menguji via Apache yang memakai 8.1.25. Perilaku bisa berbeda drastis dan sulit direproduksi.

---

## 10. Rekomendasi Pembaruan (berurutan Prioritas)

| Prioritas | Tindakan | Alasan |
|---|---|---|
| **P0** | Migrasi PHP Apache XAMPP **8.1.25 → 8.3.36-1 (TS, x64)** | 8.1 EOL; Laravel 13 butuh ≥8.3; intl/gd belum aktif |
| **P0** | Aktifkan `intl`, `gd`, `zip`, `sodium`, `sqlite3`, `xsl`, `opcache` | Kebutuhan Filament 5 & Laravel 13 |
| **P0** | Hardening `php.ini` (lihat §11.4) | Information disclosure, session, upload progress |
| **P1** | Batasi Apache ke `127.0.0.1:80` / `127.0.0.1:443` atau firewall | DVWA & `.env` di htdocs |
| **P1** | Hapus/isolasi DVWA dari htdocs dan amankan file `.env` | Mengurangi attack surface |
| **P1** | Set `local_infile=0` di MariaDB | Cegah pembacaan file via SQL |
| **P2** | Upgrade Apache 2.4.58 → 2.4.69 | 72 CVE diperbaiki sejak 2.4.58 |
| **P2** | Upgrade MariaDB 10.4.32 → 10.11 LTS | 10.4 sudah EOL |
| **P3** | Upgrade phpMyAdmin 5.2.1 → 5.2.2+ | Kompatibilitas PHP 8.3 |
| **P3** | Pisahkan runtime proyek dari XAMPP (gunakan Laragon/container) | Menghilangkan version skew |

---

## 11. Rencana Migrasi PHP yang Aman

> **Sudah dieksekusi pada 4 November 2026** (Fase 1–9 disetujui). Hasil verifikasi lengkap ada di §12.

### 11.1 Target

| Item | Nilai |
|---|---|
| Versi | **PHP 8.3.36** (Windows build: `8.3.36-1`) |
| Rilis | 21 Oktober 2026 — **security release** (sumber: php.net) |
| Build Windows | 26 Oktober 2026 |
| File | `php-8.3.36-1-Win32-vs16-x64.zip` |
| Ukuran | 32,75 MB |
| SHA-256 | `126dd3cc8c19df5085b9420b2bc74ed591de3d98528858c52fc42739b7bba92e` |
| Sumber resmi | `https://windows.php.net/downloads/releases/` |
| Thread Safe | **Ya (TS/ZTS)** — wajib untuk `mod_php` |
| Arsitektur | x64 |
| Toolset | VS16 (kompatibel dengan Apache VS17 — pernyataan resmi Apache Lounge) |
| VC++ Runtime | Terpasang 14.50.35719 (memenuhi) |

**Catatan:** nama file memiliki sufiks `-1` karena merupakan *re-release*; versi runtime tetap **8.3.36**.

### 11.2 Verifikasi Manual Sebelum Ekstrak

```powershell
# Unduh HANYA dari domain resmi php.net
Invoke-WebRequest `
  'https://windows.php.net/downloads/releases/php-8.3.36-1-Win32-vs16-x64.zip' `
  -OutFile "$env:TEMP\php-8.3.36-1-Win32-vs16-x64.zip"

Get-FileHash "$env:TEMP\php-8.3.36-1-Win32-vs16-x64.zip" -Algorithm SHA256
# Harus sama persis:
# 126DD3CC8C19DF5085B9420B2BC74ED591DE3D98528858C52FC42739B7BBA92E

Get-AuthenticodeSignature "$env:TEMP\php-8.3.36-1-Win32-vs16-x64.zip"
```

Jika hash berbeda → **batalkan**, jangan ekstrak.

### 11.3 Strategi: Side-by-Side (direkomendasikan)

```
C:\xampp\php              <- TETAP, PHP 8.1.25, tidak disentuh
C:\xampp\php-8.3.36      <- BARU, hasil ekstrak
```

Keuntungan:
- Tidak menghapus/memindahkan instalasi lama.
- Rollback = mengembalikan 2 baris konfigurasi Apache + restart (< 1 menit).
- Bisa diuji dengan `httpd -t`/`-M` sebelum service di-restart.

Alternatif in-place (rename `php` → `php-8.1.25`, ekstrak baru ke `php`) **tidak direkomendasikan** karena memindahkan folder dan membuat rollback lebih berisiko. Butuh persetujuan terpisah bila diinginkan.

### 11.4 Langkah Eksekusi (setelah disetujui)

| Fase | Aksi | Verifikasi |
|---|---|---|
| 0 | Konfirmasi jendela waktu; service Apache/MySQL tetap berjalan | — |
| 1 | Unduh + verifikasi SHA-256 | Hash cocok |
| 2 | Ekstrak ke `C:\xampp\php-8.3.36` (folder baru) | `php.exe -v` → 8.3.36 |
| 3 | Salin `php.ini-production` → `php-8.3.36\php.ini`, terapkan blok `staging\php.ini.append.txt` | `php --ini` menunjuk file baru |
| 4 | Uji CLI: `php -v`, `php -m`, `php -r "..."` | `intl`, `gd`, `zip`, `opcache` ada; TS=yes; 64-bit |
| 5 | Backup `httpd-xampp.conf` (sudah ada) lalu ubah 2 baris: `LoadModule` + `PHPINIDir` | `httpd.exe -t` → **Syntax OK** |
| 6 | `httpd.exe -M` cek `php_module` | Tidak ada error load DLL |
| 7 | Restart `Apache2.4` | Service Running |
| 8 | Smoke test Apache + phpMyAdmin | HTTP 200, tanpa error log |
| 9 | Uji Laravel 13 + Filament 5 (checklist §11.7) | Semua lulus |
| 10 | Observasi 24–72 jam, cek `php_error.log` & `apache\logs\error.log` | Tidak ada error berulang |
| 11 | (Opsional) jadikan permanen, dokumentasikan | — |

### 11.5 Perubahan Konfigurasi (yang benar-benar diterapkan)

**`C:\xampp\apache\conf\extra\httpd-xampp.conf`** — ternyata **5 baris**, bukan 2.
Baris 17–19 (`LoadFile`) adalah faktor penentu: bila dibiarkan menunjuk PHP lama,
`php8apache2_4.dll` baru akan memakai `php8ts.dll` versi 8.1.25 yang sudah lebih dulu
dimuat ke proses Apache dan gagal dengan *"The specified procedure could not be found"*.

```diff
- SetEnv PHPRC "\xampp\php"
+ SetEnv PHPRC "C:/xampp/php-8.3.36"

- LoadFile "C:/xampp/php/php8ts.dll"
- LoadFile "C:/xampp/php/libpq.dll"
- LoadFile "C:/xampp/php/libsqlite3.dll"
- LoadModule php_module "C:/xampp/php/php8apache2_4.dll"
+ LoadFile "C:/xampp/php-8.3.36/php8ts.dll"
+ LoadFile "C:/xampp/php-8.3.36/libpq.dll"
+ LoadFile "C:/xampp/php-8.3.36/libsqlite3.dll"
+ LoadModule php_module "C:/xampp/php-8.3.36/php8apache2_4.dll"

-     PHPINIDir "C:/xampp/php"
+     PHPINIDir "C:/xampp/php-8.3.36"
```

Tidak ada DLL Apache yang ditimpa. `apache\bin\libcrypto-3-x64.dll` (OpenSSL 3.1.3)
tetap asli dan tetap dipakai — PHP 8.3.36 (OpenSSL 3.0.22) berjalan di atasnya tanpa masalah.

**`php.ini` baru** — lihat `C:\xampp\_migration-2026-11-04\staging\php.ini.append.txt`.

Ringkasan blok:

```ini
extension_dir = "C:/xampp/php-8.3.36/ext"
; bcmath adalah built-in (tidak ada php_bcmath.dll) -> jangan pakai extension=
extension=curl
extension=exif
extension=fileinfo
extension=gd
extension=intl
extension=mbstring
extension=mysqli
extension=openssl
extension=pdo_mysql
extension=pdo_sqlite
extension=sqlite3
extension=sodium
extension=xsl
extension=zip
zend_extension=opcache

expose_php = Off
display_errors = Off
display_startup_errors = Off
log_errors = On
zend.exception_ignore_args = On

session.use_strict_mode = 1
session.cookie_httponly = 1
session.cookie_samesite = "Lax"
session.upload_progress.enabled = Off

cgi.fix_pathinfo = 0
mysqli.allow_local_infile = Off
```

### 11.6 Risiko Migrasi & Mitigasi

| Risiko | Kemungkinan | Mitigasi |
|---|---|---|
| `php8apache2_4.dll` gagal load karena bentrok `libcrypto-3-x64.dll` (Apache 3.1.3 vs PHP 8.3.36) | **Sedang** | Uji `httpd -t` & `-M` dulu; jika gagal, backup lalu salin DLL OpenSSL dari folder PHP baru ke `apache\bin`, atau pakai `mod_fcgid` |
| Ekstensi lama tidak tersedia (oci8, firebird, dll.) | Rendah | Tidak dipakai proyek Laravel; aktifkan hanya bila proyek htdocs membutuhkan |
| `open_basedir` memblokir proyek di luar htdocs | Sedang | Jangan aktifkan `open_basedir` pada fase ini |
| phpMyAdmin 5.2.1 bermasalah di PHP 8.3 | Sedang | Uji login; jika gagal, upgrade phpMyAdmin (terpisah) |
| Proyek lama (Laravel 7/CI) berperilaku berbeda di PHP 8.3 | Sedang | Uji per proyek; proyek lama tetap bisa diakses via PHP 8.1 selama rollback |
| Konfigurasi `disable_functions` memblokir Composer/Process | Rendah | Jangan aktifkan di lingkungan dev |
| Aplikasi masih diarahkan ke `localhost:8000` (artisan serve) bukan Apache | Tinggi | Perubahan ini tidak memengaruhi proyek sampai dipindahkan ke htdocs/vhost |

### 11.7 Checklist Pengujian Laravel 13 & Filament 5

**A. Runtime & Konfigurasi**
- [ ] `C:\xampp\php-8.3.36\php.exe -v` → PHP 8.3.36, **ZTS yes**, **64-bit**
- [ ] `php --ini` → `C:\xampp\php-8.3.36\php.ini`
- [ ] `php -m` → ada `intl`, `gd`, `zip`, `sodium`, `sqlite3`, `xsl`, `opcache`
- [ ] `php -r "var_dump(ini_get('session.upload_progress.enabled'));"` → `Off`
- [ ] `C:\xampp\apache\bin\httpd.exe -t` → Syntax OK
- [ ] `C:\xampp\apache\bin\httpd.exe -M` → `php_module (shared)`
- [ ] `php artisan about` (dengan binary 8.3.36) → environment terbaca
- [ ] `composer check-platform-reqs` → semua success

**B. Laravel 13**
- [ ] `php artisan config:clear && php artisan cache:clear`
- [ ] `php artisan route:list` tanpa error
- [ ] `php artisan migrate:status` (read-only) — koneksi DB OK
- [ ] `php artisan storage:link` (bila belum ada)
- [ ] Halaman login tampil, autentikasi berhasil
- [ ] Session bertahan setelah refresh; cookie punya `HttpOnly` + `SameSite`
- [ ] CSRF token valid pada form
- [ ] Queue/scheduler (bila dipakai) berjalan
- [ ] Log tidak menunjukkan deprecation/error PHP 8.3

**C. Filament 5**
- [ ] Panel admin terbuka, aset CSS/JS termuat
- [ ] CRUD resource: create, read, update, delete
- [ ] Tabel: sort, filter, search, pagination
- [ ] Form upload file/gambar (butuh `gd`/`fileinfo`)
- [ ] Avatar/image resize & preview
- [ ] Export Excel/CSV (butuh `zip`, `xml`, `dom`)
- [ ] QR code (butuh `gd`)
- [ ] Notifikasi & modal berfungsi
- [ ] Multi-role/permission (bila ada)

**D. Fitur spesifik proyek**
- [ ] Upload/konversi HEIC (`maestroerror/php-heic-to-jpg`) — cek dependensi binary/Imagick
- [ ] Cetak/PDF (bila ada)
- [ ] API/HTTP client (butuh `curl`, `openssl`)
- [ ] Koneksi ke MariaDB 10.4 (driver `pdo_mysql`)

**E. Apache & phpMyAdmin**
- [ ] `http://localhost/` → 200
- [ ] `https://localhost/` → sertifikat/handshake
- [ ] `http://localhost/phpmyadmin/` → login berhasil
- [ ] `apache\logs\error.log` bersih dari “Unable to load dynamic library”
- [ ] `C:\xampp\apache\logs\php_error.log` tidak banjir warning

### 11.8 Kriteria Rollback (trigger)

Batalkan migrasi jika salah satu terjadi:
- Apache gagal start atau `httpd -M` tidak memuat `php_module`.
- phpMyAdmin tidak dapat login.
- Laravel gagal bootstrap / 500 error massal.
- Ekstensi wajib (`intl`/`gd`) tidak dapat dimuat.
- Error log menunjukkan crash berulang dalam 30 menit pengujian.

### 11.9 Prosedur Rollback (≈2 menit)

```powershell
# 1. Hentikan Apache
net stop Apache2.4

# 2. Kembalikan konfigurasi Apache dari backup
Copy-Item 'C:\xampp\_migration-2026-11-04\backup\apache\extra\httpd-xampp.conf' `
          'C:\xampp\apache\conf\extra\httpd-xampp.conf' -Force

# 3. Verifikasi
& 'C:\xampp\apache\bin\httpd.exe' -t

# 4. Jalankan kembali
net start Apache2.4
```

Karena PHP lama **tidak pernah dihapus/dipindahkan**, rollback tidak memerlukan restore file PHP. Folder `C:\xampp\php-8.3.36` boleh dibiarkan atau diarsipkan setelah investigasi.

---

## 12. Hasil Eksekusi Migrasi (4 November 2026)

### 12.1 Ringkasan hasil

**Migrasi berhasil.** Apache `Apache2.4` sekarang menjalankan **PHP 8.3.36** sebagai `mod_php`,
dan PHP 8.1.25 lama tetap utuh di `C:\xampp\php` untuk rollback.

| Fase | Aksi | Hasil |
|---|---|---|
| 1 | Unduh `php-8.3.36-1-Win32-vs16-x64.zip` (34.336.709 byte) | **OK** |
| 1 | Verifikasi SHA-256 | **COCOK** (`126DD3CC…BBA92E`) |
| 2 | Ekstrak ke `C:\xampp\php-8.3.36` (side-by-side) | **OK** |
| 3 | `php.ini` dari `php.ini-production` + blok staging | **OK** (78.040 byte) |
| 4 | Uji CLI | **OK** — tanpa warning, semua ekstensi termuat |
| 5 | Patch `httpd-xampp.conf` + `httpd -t` | **Syntax OK** |
| 6 | `httpd -M` | **`php_module (shared)`** |
| 7 | Restart service `Apache2.4` | **Running** |
| 8 | Smoke test Apache / HTTPS / phpMyAdmin | **OK** |
| 9 | Uji Laravel 13 + Filament 5 | **OK** |

### 12.2 Kendala yang muncul (dan solusinya)

| Gejala | Penyebab sebenarnya | Solusi |
|---|---|---|
| `httpd -t` gagal: *"Cannot load php8apache2_4.dll … The specified procedure could not be found"* | **Bukan** bentrok OpenSSL seperti yang diperkirakan di §11.6. Baris 17–19 `httpd-xampp.conf` sudah memuat `php8ts.dll` **8.1.25** lebih dulu, sehingga modul 8.3.36 memakai simbol dari PHP lama. | Arahkan ketiga `LoadFile` ke folder baru. Setelah itu langsung `Syntax OK`. |
| Kekhawatiran `libcrypto-3-x64.dll` (Apache 3.1.3 vs PHP 8.3.36 3.0.22) | **Tidak terbukti masalah.** OpenSSL 3.x menjaga kompatibilitas ABI mayor. | Tidak ada DLL Apache yang ditimpa; backup DLL tetap dibuat sebagai jaring pengaman. |
| `php_bcmath.dll` tidak ada di folder `ext` | `bcmath` sudah **built-in** pada build resmi Windows. | Baris `extension=bcmath` dihapus dari template staging. |

### 12.3 Bukti verifikasi

**Runtime via Apache** (`http://localhost/dashboard/phpinfo.php`):

```
PHP Version            8.3.36
Server API             Apache 2.0 Handler
Thread Safety          enabled
PHP Extension Build    API20230831,TS,VS16
Architecture           x64
Loaded Configuration   C:\xampp\php-8.3.36\php.ini
extension_dir          C:/xampp/php-8.3.36/ext
```

**Direktif keamanan (runtime Apache):**

| Direktif | Sebelum (8.1.25) | Sesudah (8.3.36) |
|---|---|---|
| `expose_php` | On | **Off** |
| `display_errors` | On | **Off** |
| `display_startup_errors` | On | **Off** |
| `session.use_strict_mode` | 0 | **1** |
| `session.cookie_httponly` | *(kosong)* | **On** |
| `session.cookie_samesite` | *(kosong)* | **Lax** |
| `session.upload_progress.enabled` | On | **Off** |
| `mysqli.allow_local_infile` | Off | Off |
| `zend.exception_ignore_args` | Off | **On** |
| OPcache | tidak aktif | **aktif** |

**Uji fungsional ekstensi (bukan sekadar `php -m`):**

```
gd=OK intl=OK zip=OK sodium=OK sqlite3=OK xsl=OK pdo_mysql=OK opcache=OK fileinfo=OK
```

**Laravel 13.35.0 / Filament 5.10.1 dengan binary 8.3.36:**

| Pemeriksaan | Hasil |
|---|---|
| `php artisan about` | Laravel 13.35.0, **PHP 8.3.36** |
| `php artisan route:list --path=admin` | 42 route Filament |
| `php artisan migrate:status` | semua migrasi `Ran` (read-only, DB tidak diubah) |
| `composer check-platform-reqs` | semua `success` |
| `GET /admin/login` | **200**, halaman login tampil |
| `GET /admin` (tanpa login) | **302** → `/admin/login` |
| Cookie session Laravel | `httponly` + `samesite=lax` |
| 11 aset Filament (CSS/JS/font/Livewire) | **semua 200** |
| `https://localhost/` | **302** (redirect normal, TLS handshake OK) |
| `http://localhost/phpmyadmin/` | **200**, phpMyAdmin 5.2.1 berjalan di PHP 8.3.36 |

**Apache `error.log` setelah restart:** hanya `ssl:warn` lama tentang CN sertifikat
`www.example.com` (sudah ada sebelum migrasi). **Tidak ada** `Unable to load dynamic library`,
tidak ada `PHP Fatal error` baru.

Banner server juga tidak lagi membocorkan versi PHP:
`Apache/2.4.58 (Win64) OpenSSL/3.1.3` (sebelumnya berakhiran `PHP/8.1.25`).

### 12.4 Status akhir

| Item | Status |
|---|---|
| File konfigurasi live | **Diubah**: `httpd-xampp.conf` (migrasi) + `httpd.conf` & `httpd-ssl.conf` (P0) + `my.ini` & `phpMyAdmin/config.inc.php` (P1). Backup tersedia. |
| Instalasi PHP lama | **Utuh** di `C:\xampp\php` (8.1.25, `php.ini` hash tidak berubah) |
| Instalasi PHP baru | `C:\xampp\php-8.3.36` (8.3.36 TS x64) |
| Database | **Tidak disentuh** (tanpa migrasi/seed/DDL) |
| DLL Apache | **Tidak ada yang ditimpa** |
| Service | `Apache2.4` **Running** dengan PHP 8.3.36 |
| Folder | Tidak ada yang dihapus/dipindahkan |
| Backup | Lengkap (lihat §13) |

### 12.5 Catatan pasca-migrasi

1. **`C:\xampp\php` masih 8.1.25.** Apache tidak lagi memakainya, tetapi CLI XAMPP
   (`C:\xampp\php\php.exe`) juga masih 8.1.25. Jangan hapus sebelum masa observasi selesai.
2. **Proyek `C:\MAGANG\Puskesmas` tetap berjalan di Laragon 8.3.31** (`php artisan serve`,
   port 8000), bukan di Apache. Migrasi ini membuat Apache *siap*, bukan memindahkan proyek.
3. **Proyek lama di `htdocs`** (Laravel 7, CodeIgniter, PHP native) kini berjalan di PHP 8.3.
   Perilakunya belum diuji satu per satu — ini sumber regresi yang paling mungkin.
4. **`composer`/`php` di PATH masih Laragon.** Untuk konsistensi, panggil eksplisit:
   `C:\xampp\php-8.3.36\php.exe artisan ...`
5. **Temuan baru (belum diperbaiki):** `phpMyAdmin/config.inc.php` memakai
   `auth_type = 'config'` + `AllowNoPassword = true`, sehingga `/phpmyadmin/` **langsung
   masuk sebagai root tanpa login**. Akses dibatasi `Require local`, tetapi ini tetap
   berbahaya bila Apache pernah terekspos. Perbaikannya terpisah dari migrasi ini.
6. **Observasi 24–72 jam** tetap disarankan: pantau `apache\logs\error.log` dan
   `apache\logs\php_error.log`.

### 12.6 Hardening P0 (dieksekusi 4 November 2026, setelah migrasi)

Setelah migrasi, eksposur diuji langsung dan ditemukan **Apache terbuka ke seluruh
jaringan** (Wi-Fi `192.168.1.39`, ZeroTier `10.191.245.181`, VirtualBox `192.168.56.1`)
dengan **14 IP klien berbeda** tercatat di `error.log`. P0 ditutup dengan perubahan berikut.

**File yang diubah:**

| File | Perubahan |
|---|---|
| `conf/httpd.conf` | `Listen 80` → `Listen 127.0.0.1:80` + `Listen [::1]:80` |
| `conf/httpd.conf` | `Options Indexes FollowSymLinks…` → `Options FollowSymLinks…` (listing mati) |
| `conf/httpd.conf` | Blok hardening ditambahkan di akhir file |
| `conf/extra/httpd-ssl.conf` | `Listen 443` → `Listen 127.0.0.1:443` + `Listen [::1]:443` |

Hash akhir:
`httpd.conf = 3C4D988EAECE9094BDC807AB562CBDFEA54AE26975FE5842A196278AAB9E9E4F`
`httpd-ssl.conf = 08853175DB1AFC2A25A5BEB8D5BC459D264298FA38A69F4134A340D409A3DC27`

**Blok hardening yang ditambahkan:**

```apache
<IfModule alias_module>
    RedirectMatch 404 (?i)(^|/)\.git(/|$)
    RedirectMatch 404 (?i)(^|/)\.env($|\.)
    RedirectMatch 404 (?i)\.(log|sql|bak|old|swp)$
    RedirectMatch 404 (?i)(^|/)(composer\.(json|lock)|package(-lock)?\.json|web\.config)$
</IfModule>
<FilesMatch "(?i)^\.(env.*|git.*|ht.*)$">
    Require all denied
</FilesMatch>
```

**Hasil verifikasi:**

| Uji | Hasil |
|---|---|
| `http://127.0.0.1/`, `http://localhost/`, `http://[::1]/` | **200/302** (tetap normal) |
| `http://192.168.1.39/` (Wi-Fi) | **gagal konek** |
| `http://10.191.245.181/` (ZeroTier) | **gagal konek** |
| `http://192.168.56.1/` (VirtualBox) | **gagal konek** |
| `/.env`, `/.env.example` | **404** |
| `/.git/config`, `/.git/HEAD` | **404** |
| `/storage/logs/laravel.log` | **404** |
| `/composer.json`, `/composer.lock` | **404** |
| `/img/` (tanpa index) | **403** (listing mati) |
| `/phpmyadmin/` | **200** |
| `https://localhost/` | **302** |
| Aplikasi PHP lain di htdocs | **200** (tidak terganggu) |

**Efek samping yang perlu diketahui:**

- Folder tanpa `index.php`/`index.html` kini **403**, bukan daftar file. Dulu inilah
  jalur yang membuat `.env` bisa ditemukan. Ini perilaku yang diinginkan.
- `pendaftaran-pendakian-online-laravel-main/` (Laravel 7) mengembalikan 403 di root
  dan **500** di `/public/`. Penyebabnya **bukan** P0 maupun PHP 8.3: Laravel 7
  (`^7.24`, EOL) memakai `Illuminate\Support\Collection` tanpa `#[\ReturnTypeWillChange]`,
  yang sudah menjadi *fatal* sejak **PHP 8.1**. Log proyek itu terakhir aktif
  12 November 2024, jadi aplikasi ini memang sudah lama tidak dipakai.
- Setelah P0, `Require local` pada phpMyAdmin menjadi lapisan kedua, bukan satu-satunya.

### 12.7 Hardening P1 (dieksekusi 4 November 2026)

P1 menutup risiko **dampak**, yaitu apa yang terjadi bila suatu saat pintu terbuka
lagi (mis. laptop dibawa ke jaringan lain dan konfigurasi berubah).

**File yang diubah:**

| File | Perubahan |
|---|---|
| `C:\xampp\phpMyAdmin\config.inc.php` | `auth_type` `config` → **`cookie`**; `user`/`password` root dikomentari; `blowfish_secret` diganti 48 hex acak |
| `C:\xampp\apache\conf\httpd.conf` | Ditambahkan `ServerTokens Prod` + `ServerSignature Off` |
| `C:\xampp\mysql\bin\my.ini` | `local_infile=0` dan `bind-address="127.0.0.1"` di bawah `[mysqld]` |
| `C:\xampp\htdocs\dvwa` | **Dipindah** (bukan dihapus) ke `C:\xampp\_disabled\dvwa` |

Hash akhir:

```
httpd.conf               D8DF95ADE1BE84F3AAADF43D0B55E673347AE2636441245D42B9FD31BA43BF5B  (23151 bytes)
my.ini                   CBC086FF3048ADDADF8D411D49D4BC66E7D1E9D1E3F8A20072BF04D5EC2BD1AA  (6090 bytes)
phpMyAdmin/config.inc.php BFB300E98B43F9C72D0D72E430705F7D83AF184EEB30955063BB40571E1AE2CA  (2169 bytes)
```

**Catatan keputusan phpMyAdmin:** `AllowNoPassword` **tetap `true`** karena akun
`root` memang belum punya password. Mematikannya akan membuat phpMyAdmin tidak bisa
login sama sekali. `auth_type = cookie` sudah memaksa form login, dan akses tetap
dibatasi loopback. Menghapus `AllowNoPassword` harus dilakukan **bersamaan** dengan
rotasi password `root` (lihat sisa risiko).

**Hasil verifikasi:**

| Uji | Sebelum P1 | Sesudah P1 |
|---|---|---|
| `/phpmyadmin/` | **auto-login sebagai root** | **form login** (`pma_username`), tanpa tabel DB |
| Header `Server:` | `Apache/2.4.58 (Win64) OpenSSL/3.1.3` | **`Apache`** (versi hilang) |
| `/dvwa/` | 200 | **404** |
| `@@local_infile` | 1 | **0** |
| `@@bind_address` | `NULL` (semua interface) | **`127.0.0.1`** |
| `192.168.1.39:3306` (LAN) | TCP **terbuka** (auth ditolak, `ERROR 1130`) | **tertutup** (`TcpTestSucceeded = False`) |
| `127.0.0.1:3306`, `localhost:3306` | bisa | **bisa** |
| Puskesmas `artisan migrate:status` | OK | **OK** |
| `/admin/login` (Puskesmas :8000) | 200 | **200** |
| 5 aplikasi htdocs | 200 | **200** |
| `/`, `/phpmyadmin/`, phpinfo | normal | **normal** |
| `.env`, `.git`, listing | 404/404/403 | **tetap tertutup** |

Cold restart (`mysql` + `Apache2.4` stop → start) diulang: `bind_address=127.0.0.1`,
`local_infile=0`, port 3306 LAN tetap tertutup, tidak ada error baru di `error.log`.

**Kenapa `bind-address` penting meski autentikasi sudah menolak:** MariaDB 10.4
mendengarkan di semua interface. Penolakan `ERROR 1130` bergantung pada tabel user;
satu akun dengan host `%` saja sudah cukup untuk membuka akses database penuh dari
jaringan. Menutup socket-nya menghilangkan ketergantungan pada konfigurasi akun.

**Rollback P1 (≈2 menit):**

```powershell
net stop mysql
Copy-Item 'C:\xampp\_migration-2026-11-04\backup-p1\my.ini' 'C:\xampp\mysql\bin\my.ini' -Force
net start mysql
net stop Apache2.4
Copy-Item 'C:\xampp\_migration-2026-11-04\backup-p1\phpMyAdmin-config.inc.php' 'C:\xampp\phpMyAdmin\config.inc.php' -Force
Copy-Item 'C:\xampp\_migration-2026-11-04\backup-p0\httpd.conf' 'C:\xampp\apache\conf\httpd.conf' -Force
net start Apache2.4
# DVWA: Move-Item 'C:\xampp\_disabled\dvwa' 'C:\xampp\htdocs\dvwa'
```

Catatan: mengembalikan `httpd.conf` ke `backup-p0` **membuang** `ServerTokens Prod`
sekaligus hardening P0. Untuk membatalkan P1 saja, edit manual dua baris `ServerTokens`/
`ServerSignature` di akhir `httpd.conf`.

**Sisa risiko (P2 dan keputusan yang menunggu Anda):**

| Item | Status | Kenapa belum |
|---|---|---|
| `root` tanpa password (dipakai Puskesmas + proyek lama) | ⚠️ terbuka | Rotasi memutus semua aplikasi yang memakai `root`/kosong; perlu koordinasi |
| 28 proyek lama (Laravel 7/CI EOL) masih di `htdocs` | ⚠️ terbuka | Beberapa masih dipakai; perlu keputusan per proyek |
| Apache 2.4.58 → 2.4.6x | ⚠️ terbuka | Upgrade binary, di luar lingkup P1 |
| MariaDB 10.4.32 (EOL) → 10.11 | ⚠️ terbuka | Perlu dump/restore + uji aplikasi |
| phpMyAdmin 5.2.1 | ⚠️ terbuka | Perlu upgrade terpisah |
| Service berjalan sebagai `LocalSystem` | ⚠️ terbuka | Perlu akun service khusus + uji izin file |
| Kredensial `.env` proyek lama sempat dapat diunduh | ⚠️ terbuka | Perlu rotasi `APP_KEY`/DB/AWS oleh pemilik proyek |

### 12.8 Peta konsumen kredensial `root` tanpa password

Dipetakan 4 November 2026 sebelum merencanakan rotasi password. MariaDB memiliki
`root@localhost`, `root@127.0.0.1`, `root@::1` — semuanya **tanpa password**.
Yang memakainya:

**A. Proyek dengan database yang masih ada (rotasi password akan langsung memutus)**

| Proyek | Konfigurasi | Database | Status aplikasi |
|---|---|---|---|
| `C:\MAGANG\Puskesmas` | `.env` | `puskesmas` | aktif (port 8000) |
| `C:\MAGANG\absensi-app` | `.env` | `db_absensi` | terakhir diubah Jun 2026 |
| `C:\MAGANG\MBKM RISET\Rekam-Medis-Elektronik` | `.env` | `rmedb` | terakhir diubah Agu 2026 |
| `C:\laragon\www\Rekam-Medis-Elektronik` | `.env` | `rmedb` | salinan proyek di atas |
| `C:\laragon\www\laravel` | `.env` | `laravel` | terakhir diubah Mar 2026 |
| `htdocs\koperasi-app` | `config\db.php` | `koperasi_app` | 200 |
| `htdocs\Koperasi-Simpan-Pinjam-main` | `database.php` + 2 file admin | `dinkopum_base` | 200 |
| `htdocs\pay` | `config.php` | `pay` | 200, terakhir Mar 2026 |
| `htdocs\rumahsakit` | `koneksi.php` | `kasir_rumahsakit` | terakhir Jun 2025 |

**B. Proyek yang database-nya sudah tidak ada (sudah rusak sebelum isu ini)**

`employee` (`employee`), `invoicing` (`invoice`), `penjualan` & `penjualan1`
(`penjualan1`), `simple-crud-main` (`mahasiswa`), `pendakian-ciremai-master`
(`pendakian`), `web_gunung` (`pendakian`), `UAS` (`db_perpustakaan`), `SI` (`si_ta`),
`PAW` (`db_restoran`, `db_rmkita`, `tm5`, `tm8`, `penjualan`), dua proyek kereta api
(`kereta_api`), `web-sistem-informasi-kereta-api-transys-master` (`usertransys`),
`ksp-master` (`ksp`, password `root`), `pendaftaran-pendakian-online-laravel-main`
(`rival_db`), `C:\laragon\www\Laravel-Presensi` (`laravel_presensi`).

**C. Akun lain**

| Akun | Password | Hak akses |
|---|---|---|
| `pma@localhost` | kosong | `USAGE` + `SELECT/INSERT/UPDATE/DELETE` pada `phpmyadmin` saja (dipakai phpMyAdmin sebagai control user) |

**Jumlah total file yang menyebut `root` + password kosong:** 7 `.env` + ±30 file PHP
di 22 proyek. Rotasi `root` secara langsung berarti menyunting semuanya.

**Rekomendasi:** jangan rotasi `root` dulu. Buat **user MySQL khusus per aplikasi**
(hak akses hanya pada database-nya sendiri), alihkan 9 proyek aktif di tabel A ke user
tersebut, baru kunci `root`. Dengan cara ini `root` hanya dipakai untuk administrasi
(phpMyAdmin) dan kegagalan satu aplikasi tidak memaksa rollback global.

---

## 13. Lampiran: Backup & Bukti

### 13.1 Lokasi backup

```
C:\xampp\_migration-2026-11-04\
├── MANIFEST.txt
├── backup\
│   ├── php.ini                              (SHA-256 35C83844…9A70)
│   └── apache\
│       ├── httpd.conf                       (SHA-256 6FB3A369…BA10)
│       ├── bin\
│       │   ├── libcrypto-3-x64.dll          (OpenSSL 3.1.3, 8BB143F9…52E9)
│       │   └── libssl-3-x64.dll             (OpenSSL 3.1.3, CF0E4D00…4748)
│       └── extra\
│           ├── httpd-xampp.conf             (SHA-256 791876AB…524B)
│           ├── httpd-vhosts.conf            (SHA-256 FD5470D4…1361)
│           ├── httpd-ssl.conf               (SHA-256 91473E6B…D685)
│           └── httpd-mpm.conf               (SHA-256 B3C5972A…E554)
├── backup-p0\                               (kondisi sebelum hardening P0)
│   ├── httpd.conf
│   └── extra\
│       ├── httpd-ssl.conf
│       └── httpd-xampp.conf
├── backup-p1\                               (kondisi sebelum hardening P1)
│   ├── my.ini                               (SHA-256 E83D7BA5…602E)
│   └── phpMyAdmin-config.inc.php            (SHA-256 CCFDB90E…C668)
└── staging\
    ├── php.ini.append.txt                   (blok konfigurasi yang dipakai)
    └── apache-httpd-xampp.patch.txt         (catatan patch Apache)
```

Folder ini **di luar `htdocs`**, sehingga tidak dapat diakses via web.

### 13.2 Perintah audit utama (read-only)

```powershell
& 'C:\xampp\php\php.exe' -v
& 'C:\xampp\php\php.exe' --ini
& 'C:\xampp\php\php.exe' -m
& 'C:\xampp\php\php.exe' -i
& 'C:\xampp\apache\bin\httpd.exe' -v
& 'C:\xampp\apache\bin\httpd.exe' -M
& 'C:\xampp\apache\bin\httpd.exe' -t
& 'C:\xampp\mysql\bin\mysqld.exe' --version
Get-NetTCPConnection -State Listen
Get-CimInstance Win32_Service
Get-FileHash <file> -Algorithm SHA256
```

### 13.3 Sumber verifikasi versi

| Data | Sumber |
|---|---|
| PHP 8.3.36 & hash Windows | `https://windows.php.net/downloads/releases/releases.json` |
| Rilis 8.3.36 (security, 21 Okt 2026) | `https://www.php.net/releases/index.php?json&version=8.3` |
| Versi Apache terbaru & CVE | `https://httpd.apache.org/security/vulnerabilities_24.html` |
| Kompatibilitas VS16/VS17 | Apache Lounge (pernyataan resmi: “VS17 and VS16/15/14 are compatible”) |

---

**Akhir laporan. Migrasi PHP 8.1.25 → 8.3.36 selesai dan terverifikasi pada 4 November 2026.
Rollback tersedia (§11.9) tanpa perlu memulihkan file PHP apa pun.**
