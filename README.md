# 🚀 Web Pegawai - Sistem Manajemen Kepegawaian & Presensi

Aplikasi berbasis **Laravel 11 + Filament v4.1 + Vite + FullCalendar** untuk mengelola data pegawai, presensi, aktivitas, dan aset secara komprehensif.

[![Laravel](https://img.shields.io/badge/Laravel-11.31-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-4.1-F59E0B?style=flat)](https://filamentphp.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 📋 Daftar Isi

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Instalasi](#-instalasi)
- [Penggunaan](#-penggunaan)
- [Link-Link Penting](#-link-link-penting)
- [Deployment](#-deployment-production)
- [Troubleshooting](#-troubleshooting)
- [Contributing](#-contributing)

---

## 🎯 Features

### ✅ Manajemen Kepegawaian
* 👥 **Data Pegawai**: CRUD lengkap dengan NIP, jabatan, kontak
* 📊 **Dashboard Admin**: Statistik pegawai dan aktivitas
* 🔐 **Role-based Access**: Admin, Manager, Employee dengan permission

### ✅ Sistem Presensi
* 📅 **Presensi Harian**: Check-in/out dengan timestamp
* 📊 **Laporan Bulanan**: Rekap presensi per bulan dalam format tabel
* 📈 **Laporan Horizontal**: View presensi dengan ikon visual
* 📥 **Export CSV**: Download laporan presensi ke file CSV
* 🖨️ **Print Report**: Print-friendly view untuk cetak laporan

### ✅ Manajemen Aktivitas
* 📅 **Kalender Interaktif**: FullCalendar.js dengan color-coding
* ✔️ **Approval Workflow**: Pengajuan dan persetujuan aktivitas
* 📄 **Upload Dokumen**: Attach dokumen ke aktivitas
* 🔔 **Status Tracking**: Monitor status aktivitas real-time

### ✅ Manajemen Aset & Pinjaman
* 🏢 **Inventaris Aset**: Tracking aset perusahaan
* 📋 **Peminjaman**: Request dan approval peminjaman aset
* 📊 **Availability Monitor**: Cek ketersediaan aset

---

## ⚡ Tech Stack

* **Backend**: Laravel 11.31
* **Admin Panel**: Filament v4.1.0 (FilamentPHP)
* **Frontend Build**: Vite 7.1.7
* **Database**: SQLite (dev) / MySQL 8+ / PostgreSQL (prod)
* **Authentication**: Laravel Sanctum
* **Permissions**: Spatie Laravel Permission
* **Calendar**: FullCalendar.js v6
* **Styling**: Tailwind CSS v4
* **Export**: CSV native PHP (fputcsv)

---

## 📂 Project Structure

```
app/
  Models/                    # Eloquent Models
    Activity.php            # Aktivitas pegawai
    Employee.php            # Data pegawai
    Asset.php              # Inventaris aset
    Loan.php               # Peminjaman
    Document.php           # Dokumen
    User.php               # User authentication
  Filament/
    Resources/             # Filament CRUD Resources
    Pages/                 # Custom Filament Pages
      EmployeeActivityCalendar.php
resources/
  views/
    filament/pages/        # Filament custom views
  js/
    calendar.js            # FullCalendar implementation
  css/
    app.css               # Tailwind styles
database/
  migrations/             # Database schema
  seeders/               # Sample data
```

---

## 🔧 Requirements

### Minimum Requirements
* **PHP**: 8.3 atau lebih tinggi
* **Composer**: 2.x
* **Node.js**: 18+ dengan NPM 9+
* **Database**: SQLite (dev) / MySQL 8+ / PostgreSQL 13+ (prod)
* **Web Server**: Apache / Nginx / PHP Built-in Server

### PHP Extensions Required
```bash
php -m | grep -E 'intl|zip|bcmath|curl|mbstring|xml|pdo|sqlite3|mysql'
```
- `ext-intl` - Internationalization
- `ext-zip` - ZIP archive support
- `ext-bcmath` - Arbitrary precision math
- `ext-curl` - HTTP requests
- `ext-mbstring` - Multibyte string
- `ext-xml` - XML parsing
- `ext-pdo` - Database abstraction
- `ext-sqlite3` / `ext-mysql` - Database driver

---

## 📦 Instalasi

### **Metode 1: Instalasi Manual (Recommended)**

#### **Step 1: Clone Repository**
```bash
# Clone dari GitHub
git clone https://github.com/Rofiq02bae/web-pegawai.git
cd web-pegawai/web-pegawai

# Atau download ZIP dan extract
wget https://github.com/Rofiq02bae/web-pegawai/archive/refs/heads/main.zip
unzip main.zip
cd web-pegawai-main/web-pegawai
```

#### **Step 2: Install Dependencies**
```bash
# Install PHP dependencies
composer install

# Jika ada error ext-zip, gunakan:
composer install --ignore-platform-req=ext-zip

# Install Node.js dependencies
npm install
```

#### **Step 3: Setup Environment**
```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate

# Edit .env sesuai kebutuhan
nano .env  # atau gunakan editor favorit Anda
```

**Konfigurasi `.env` penting:**
```env
APP_NAME="Web Pegawai"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# DB_CONNECTION=mysql  # Uncomment untuk MySQL

# Jika menggunakan MySQL:
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=web_pegawai
# DB_USERNAME=root
# DB_PASSWORD=
```

#### **Step 4: Setup Database**
```bash
# Buat file database SQLite
touch database/database.sqlite

# Atau untuk MySQL:
# mysql -u root -p
# CREATE DATABASE web_pegawai;
# exit;

# Jalankan migration
php artisan migrate

# Seed data awal (permissions, roles, sample users)
php artisan db:seed --class=PermissionSeeder

# Optional: Seed sample data
php artisan db:seed
```

#### **Step 5: Build Assets**
```bash
# Build untuk production
npm run build

# Atau untuk development (dengan hot reload)
npm run dev
```

#### **Step 6: Set Permissions (Linux/Mac)**
```bash
# Set permissions untuk storage dan cache
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Atau jika menggunakan user sendiri:
chmod -R 775 storage bootstrap/cache
```

#### **Step 7: Start Development Server**
```bash
# Gunakan Laravel built-in server
php artisan serve

# Atau specify host dan port
php artisan serve --host=0.0.0.0 --port=8000
```

### **Metode 2: Quick Install (One-liner)**
```bash
# Clone, install, setup, dan jalankan dalam satu command
git clone https://github.com/Rofiq02bae/web-pegawai.git && \
cd web-pegawai/web-pegawai && \
composer install --ignore-platform-req=ext-zip && \
npm install && \
cp .env.example .env && \
php artisan key:generate && \
touch database/database.sqlite && \
php artisan migrate --seed && \
npm run build && \
php artisan serve
```

---

## 🎮 Penggunaan

### **1. Akses Aplikasi**

Setelah server berjalan, akses aplikasi di browser:

**🔑 Login Admin Panel:**
- URL: `http://localhost:8000/admin`
- Atau: `http://localhost:8000/admin/login`

### **2. Default Users (Test Accounts)**

| Role | Email | Password | Akses |
|------|-------|----------|-------|
| **Admin** | admin@test.com | password | Full access semua modul |
| **Manager** | manager@test.com | password | Approve activities, view reports |
| **Employee** | employee@test.com | password | Submit activities, view calendar |

### **3. Menu & Fitur Utama**

#### **📊 Dashboard**
- **URL**: `/admin`
- **Fitur**: 
  - Overview statistik pegawai
  - Grafik aktivitas bulanan
  - Quick links ke modul utama
  - Recent activities

#### **👥 Manajemen Pegawai**
- **URL**: `/admin/employees`
- **Fitur**:
  - Tambah/Edit/Hapus pegawai
  - Import data pegawai (CSV)
  - Export data pegawai
  - Filter & Search
  - View detail pegawai

#### **📅 Presensi Pegawai**

**Presensi Harian:**
- **URL**: `/admin/attendances`
- **Fitur**:
  - Input check-in/out manual
  - Bulk import presensi
  - Filter by date, status
  - Edit/hapus record presensi

**Laporan Bulanan:**
- **URL**: `/admin/monthly-attendances`
- **Fitur**:
  - Tabel rekap presensi per bulan
  - Kolom sticky (No, NIP, Nama)
  - Status presensi per hari (H, S, I, C, TK, dll)
  - Filter bulan & tahun
  - **Export CSV** button
  - **Print** button
  - **View Web Report** button

**Laporan Horizontal:**
- **URL**: `/admin/horizontal-attendances`
- **Fitur**:
  - View horizontal dengan ikon visual
  - Color-coded status
  - Tooltip detail per hari
  - Legend keterangan warna
  - Responsive horizontal scroll

**Web Report (Public View):**
- **URL**: `/attendance/report?year=2025&month=10`
- **Fitur**:
  - View laporan tanpa login
  - Export CSV langsung
  - Print-friendly layout
  - Filter bulan/tahun

#### **🗓️ Kalender Aktivitas**
- **URL**: `/admin/employee-activity-calendar`
- **Fitur**:
  - FullCalendar interactive view
  - Color-coded by status (Pending/Approved/Rejected)
  - Click event untuk detail
  - Month/Week/Day view
  - Add activity via calendar

#### **📋 Manajemen Aktivitas**
- **URL**: `/admin/activities`
- **Fitur**:
  - Create/Edit/Delete activity
  - Approval workflow
  - Upload dokumen pendukung
  - Filter by status, employee, date
  - Activity timeline

#### **🏢 Manajemen Aset**
- **URL**: `/admin/assets`
- **Fitur**:
  - CRUD aset perusahaan
  - Track kondisi aset
  - Asset availability status
  - QR code untuk aset (optional)

#### **📦 Peminjaman Aset**
- **URL**: `/admin/loans`
- **Fitur**:
  - Request peminjaman
  - Approval peminjaman
  - Return tracking
  - History peminjaman

#### **📄 Dokumen**
- **URL**: `/admin/documents`
- **Fitur**:
  - Upload dokumen
  - Download dokumen
  - Categorize by jenis
  - Link ke aktivitas

### **4. Export & Print Presensi**

#### **Export ke CSV:**
```
1. Buka: /admin/monthly-attendances
2. Pilih bulan & tahun di filter
3. Klik tombol "Export CSV"
4. File akan terdownload: laporan_presensi_2025_10.csv
5. Buka dengan Excel/Google Sheets/LibreOffice
```

#### **Print Laporan:**
```
1. Buka: /admin/monthly-attendances
2. Klik tombol "Print"
3. Akan terbuka tab baru dengan print-friendly view
4. Ctrl+P atau Cmd+P untuk print
5. Pilih printer atau Save as PDF
```

#### **View Web Report:**
```
1. Buka: /admin/monthly-attendances
2. Klik tombol "Lihat Laporan Web"
3. Akses public report tanpa perlu login
4. URL: /attendance/report?year=2025&month=10
5. Export CSV atau Print langsung dari sini
```

### **5. Format Kode Presensi**

| Kode | Status | Deskripsi |
|------|--------|-----------|
| **H** | Hadir | Hadir tanpa jam (default) |
| **08:00** | Hadir | Jam check-in |
| **08:00<br>17:00** | Hadir | Check-in & check-out |
| **08:00<br>TPP** | Hadir | Check-in tanpa check-out |
| **S** | Sakit | Sakit dengan surat dokter |
| **I** | Izin | Izin pribadi |
| **C** | Cuti | Cuti tahunan |
| **DD** | Dinas Dalam | Dinas dalam kota |
| **DL** | Dinas Luar | Dinas luar kota |
| **TK** | Tidak Hadir | Alpha / tidak ada keterangan |
| **0** | Libur | Weekend / hari libur |

---

## 🔗 Link-Link Penting

### **Aplikasi URLs**

| Deskripsi | URL | Akses |
|-----------|-----|-------|
| **Homepage** | `http://localhost:8000` | Public |
| **Admin Login** | `http://localhost:8000/admin` | Auth Required |
| **Admin Dashboard** | `http://localhost:8000/admin` | Admin/Manager/Employee |
| **Employees** | `http://localhost:8000/admin/employees` | Admin/Manager |
| **Attendances** | `http://localhost:8000/admin/attendances` | Admin/Manager |
| **Monthly Report** | `http://localhost:8000/admin/monthly-attendances` | Admin/Manager |
| **Horizontal Report** | `http://localhost:8000/admin/horizontal-attendances` | Admin/Manager |
| **Calendar** | `http://localhost:8000/admin/employee-activity-calendar` | All Users |
| **Activities** | `http://localhost:8000/admin/activities` | All Users |
| **Assets** | `http://localhost:8000/admin/assets` | Admin/Manager |
| **Loans** | `http://localhost:8000/admin/loans` | Admin/Manager |
| **Documents** | `http://localhost:8000/admin/documents` | All Users |
| **Web Report (Public)** | `http://localhost:8000/attendance/report` | Public |
| **Print Report** | `http://localhost:8000/attendance/print` | Public |
| **Export CSV** | `http://localhost:8000/attendance/export-excel` | Public |

### **Development Tools**

| Tool | URL | Deskripsi |
|------|-----|-----------|
| **Laravel Telescope** | `/telescope` | Debugging & monitoring (jika diinstall) |
| **Horizon** | `/horizon` | Queue monitoring (jika diinstall) |
| **API Routes** | `php artisan route:list` | List semua route |

### **Documentation Links**

| Resource | Link |
|----------|------|
| **Laravel Docs** | https://laravel.com/docs/11.x |
| **Filament Docs** | https://filamentphp.com/docs/4.x |
| **FullCalendar** | https://fullcalendar.io/docs |
| **Tailwind CSS** | https://tailwindcss.com/docs |
| **Spatie Permission** | https://spatie.be/docs/laravel-permission |

### **GitHub Repository**

```
Repository: https://github.com/Rofiq02bae/web-pegawai
Issues: https://github.com/Rofiq02bae/web-pegawai/issues
Wiki: https://github.com/Rofiq02bae/web-pegawai/wiki
Releases: https://github.com/Rofiq02bae/web-pegawai/releases
```

---

## 🚀 Deployment (Production)

### **Opsi 1: Shared Hosting (cPanel)**

#### **Persiapan:**
1. Hosting dengan PHP 8.3+, MySQL, Composer
2. SSH access (recommended)
3. Domain/subdomain sudah disiapkan

#### **Steps:**

**1. Upload Files via FTP/SSH:**
```bash
# Compress locally
tar -czf web-pegawai.tar.gz .

# Upload via SCP
scp web-pegawai.tar.gz user@yourserver.com:/home/user/

# SSH ke server
ssh user@yourserver.com

# Extract
cd /home/user/
tar -xzf web-pegawai.tar.gz -C public_html/
```

**2. Setup via SSH:**
```bash
cd public_html

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Setup environment
cp .env.example .env
nano .env

# Configure .env untuk production
# APP_ENV=production
# APP_DEBUG=false
# APP_URL=https://yourdomain.com
# DB_CONNECTION=mysql
# DB_HOST=localhost
# DB_DATABASE=your_db
# DB_USERNAME=your_user
# DB_PASSWORD=your_pass

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate --force
php artisan db:seed --class=PermissionSeeder --force

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chmod -R 755 storage bootstrap/cache
```

**3. Configure Web Server:**

**Apache (.htaccess in public/):**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

**Nginx (example config):**
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /home/user/public_html/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### **Opsi 2: VPS (Digital Ocean, AWS, Linode)**

#### **1. Server Setup (Ubuntu 24.04):**
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install LEMP Stack
sudo apt install -y nginx mysql-server php8.3 php8.3-fpm php8.3-mysql \
  php8.3-mbstring php8.3-xml php8.3-bcmath php8.3-zip php8.3-curl \
  php8.3-intl php8.3-sqlite3 composer npm

# Install Node.js 18+
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs

# Secure MySQL
sudo mysql_secure_installation
```

#### **2. Create Database:**
```bash
# Login MySQL
sudo mysql -u root -p

# Create database and user
CREATE DATABASE web_pegawai;
CREATE USER 'webpegawai'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON web_pegawai.* TO 'webpegawai'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### **3. Deploy Application:**
```bash
# Create directory
sudo mkdir -p /var/www/web-pegawai
cd /var/www/web-pegawai

# Clone repository
sudo git clone https://github.com/Rofiq02bae/web-pegawai.git .
cd web-pegawai

# Install dependencies
sudo composer install --optimize-autoloader --no-dev
sudo npm install
sudo npm run build

# Setup environment
sudo cp .env.example .env
sudo nano .env

# Configure .env:
# APP_ENV=production
# APP_DEBUG=false
# APP_URL=https://yourdomain.com
# DB_CONNECTION=mysql
# DB_HOST=localhost
# DB_DATABASE=web_pegawai
# DB_USERNAME=webpegawai
# DB_PASSWORD=strong_password

# Application setup
sudo php artisan key:generate
sudo php artisan migrate --force
sudo php artisan db:seed --class=PermissionSeeder --force
sudo php artisan storage:link

# Optimize
sudo php artisan config:cache
sudo php artisan route:cache
sudo php artisan view:cache

# Set permissions
sudo chown -R www-data:www-data /var/www/web-pegawai
sudo chmod -R 755 /var/www/web-pegawai/storage
sudo chmod -R 755 /var/www/web-pegawai/bootstrap/cache
```

#### **4. Configure Nginx:**
```bash
sudo nano /etc/nginx/sites-available/web-pegawai
```

**Paste this config:**
```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/web-pegawai/web-pegawai/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

**Enable site:**
```bash
sudo ln -s /etc/nginx/sites-available/web-pegawai /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

#### **5. Setup SSL (Let's Encrypt):**
```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Get SSL certificate
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renewal test
sudo certbot renew --dry-run
```

### **Opsi 3: Laravel Forge (Easiest)**

1. **Sign up**: https://forge.laravel.com
2. **Connect VPS**: DigitalOcean, AWS, Linode
3. **Create Server**: Choose PHP 8.3, MySQL, Nginx
4. **Deploy Site**: 
   - Repository: `https://github.com/Rofiq02bae/web-pegawai`
   - Branch: `main`
   - Root: `/web-pegawai/public`
5. **Environment**: Set `.env` via Forge panel
6. **Deploy Script**:
```bash
cd /home/forge/yourdomain.com
git pull origin main
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
7. **Enable Quick Deploy**: Auto-deploy on git push

### **Opsi 4: Docker (Advanced)**

**Dockerfile:**
```dockerfile
FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# Set working directory
WORKDIR /var/www

# Copy files
COPY . /var/www

# Install dependencies
RUN composer install --optimize-autoloader --no-dev
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]
```

**docker-compose.yml:**
```yaml
version: '3.8'

services:
  app:
    build: .
    container_name: web-pegawai-app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
    networks:
      - web-pegawai

  nginx:
    image: nginx:alpine
    container_name: web-pegawai-nginx
    restart: unless-stopped
    ports:
      - "80:80"
    volumes:
      - ./:/var/www
      - ./docker/nginx:/etc/nginx/conf.d
    networks:
      - web-pegawai

  mysql:
    image: mysql:8.0
    container_name: web-pegawai-db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: web_pegawai
      MYSQL_ROOT_PASSWORD: secret
      MYSQL_USER: webpegawai
      MYSQL_PASSWORD: password
    volumes:
      - dbdata:/var/lib/mysql
    networks:
      - web-pegawai

networks:
  web-pegawai:
    driver: bridge

volumes:
  dbdata:
    driver: local
```

**Deploy:**
```bash
docker-compose up -d
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan db:seed --force
```

### **Post-Deployment Checklist**

- [ ] Test login admin (admin@test.com)
- [ ] Check all menu accessible
- [ ] Test export CSV functionality
- [ ] Test print report
- [ ] Verify calendar display
- [ ] Check file uploads working
- [ ] Test database connections
- [ ] Verify SSL certificate
- [ ] Setup backup cronjob
- [ ] Configure monitoring (optional)
- [ ] Setup error logging
- [ ] Test email notifications (if configured)

### **Maintenance Commands**

```bash
# Clear all cache
php artisan optimize:clear

# Rebuild cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Database backup
php artisan backup:run  # If spatie/laravel-backup installed

# Or manual backup
mysqldump -u user -p web_pegawai > backup_$(date +%Y%m%d).sql

# Update application
git pull origin main
composer install --no-dev
npm install && npm run build
php artisan migrate --force
php artisan optimize:clear
php artisan optimize
```

---

## 🛠️ Troubleshooting

### **Error: "ext-zip" missing**
```bash
# Opsi 1: Install extension
sudo apt install php8.3-zip

# Opsi 2: Ignore requirement
composer install --ignore-platform-req=ext-zip
```

### **Error: NPM build failed**
```bash
# Clear cache
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
npm run build
```

### **Error: Permission denied (storage/logs)**
```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Atau gunakan current user
chmod -R 775 storage bootstrap/cache
```

### **Calendar tidak muncul?**
```bash
# Clear cache dan rebuild
php artisan cache:clear
php artisan config:clear
php artisan view:clear
npm run build
```

### **Database migration errors?**
```bash
# Reset database (WARNING: Deletes all data!)
php artisan migrate:fresh
php artisan db:seed --class=PermissionSeeder

# Atau rollback step by step
php artisan migrate:rollback
php artisan migrate
```

### **Filament login redirect loop?**
```bash
# Clear browser cache and cookies
# Clear Laravel cache
php artisan optimize:clear
php artisan config:cache

# Check .env file
# APP_URL should match your actual URL
```

### **Export CSV tidak berfungsi?**
```bash
# Check route
php artisan route:list | grep export

# Clear route cache
php artisan route:clear
php artisan route:cache

# Check permissions on storage
chmod -R 775 storage
```

### **Livewire error (405 Method Not Allowed)**
```bash
# Clear cache
php artisan optimize:clear

# Rebuild assets
npm run build

# Restart server
# Stop current server (Ctrl+C)
php artisan serve
```

### **MySQL connection refused**
```bash
# Check MySQL status
sudo systemctl status mysql

# Start MySQL
sudo systemctl start mysql

# Check .env database config
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_pegawai
```

### **500 Internal Server Error in production**
```bash
# Enable debug temporarily
nano .env
# Set: APP_DEBUG=true

# Check logs
tail -f storage/logs/laravel.log

# Common fixes:
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R 775 storage bootstrap/cache
```

---

## 📂 Project Structure

```
web-pegawai/
├── app/
│   ├── Exports/
│   │   └── AttendanceExport.php        # CSV export logic
│   ├── Filament/
│   │   ├── Resources/
│   │   │   ├── ActivityResource.php
│   │   │   ├── AssetResource.php
│   │   │   ├── AttendanceResource.php
│   │   │   ├── EmployeeResource.php
│   │   │   ├── LoanResource.php
│   │   │   ├── MonthlyAttendanceResource.php
│   │   │   ├── HorizontalAttendanceResource.php
│   │   │   └── Attendances/
│   │   │       └── Tables/
│   │   │           ├── MonthlyAttendanceTable.php
│   │   │           └── HorizontalAttendanceTable.php
│   │   ├── Pages/
│   │   │   └── EmployeeActivityCalendar.php
│   │   └── Widgets/
│   ├── Http/
│   │   └── Controllers/
│   │       └── AttendanceReportController.php  # Web report & CSV export
│   ├── Models/
│   │   ├── Activity.php
│   │   ├── Asset.php
│   │   ├── Attendance.php              # Attendance model with scopes
│   │   ├── Document.php
│   │   ├── Employee.php
│   │   ├── Loan.php
│   │   ├── User.php
│   │   └── WorkSchedule.php
│   ├── Providers/
│   │   ├── AppServiceProvider.php
│   │   └── Filament/
│   │       └── AdminPanelProvider.php
│   └── Traits/
│       └── HasSimpleRoles.php
├── database/
│   ├── migrations/                      # Database schema
│   ├── seeders/                         # Sample data & permissions
│   └── database.sqlite                  # SQLite database (dev)
├── resources/
│   ├── views/
│   │   ├── attendance/
│   │   │   ├── monthly-report.blade.php # Web report view
│   │   │   └── print.blade.php          # Print view
│   │   └── filament/
│   │       └── pages/
│   │           └── employee-activity-calendar.blade.php
│   ├── js/
│   │   ├── app.js
│   │   └── calendar.js                  # FullCalendar setup
│   └── css/
│       └── app.css                      # Tailwind CSS
├── routes/
│   ├── web.php                          # Public routes (report, export, print)
│   └── console.php
├── public/
│   ├── index.php                        # Entry point
│   └── build/                           # Compiled assets
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
├── .env.example                         # Environment template
├── composer.json                        # PHP dependencies
├── package.json                         # Node dependencies
├── vite.config.js                       # Vite configuration
└── README.md                            # This file
```

---

## 🧪 Testing

### **Manual Testing Checklist**

- [ ] Login sebagai Admin
- [ ] Create new employee
- [ ] Input attendance data
- [ ] View monthly report
- [ ] Export CSV successfully
- [ ] Print report format OK
- [ ] Create activity on calendar
- [ ] Approve/reject activity (Manager)
- [ ] Upload document
- [ ] Request asset loan
- [ ] Test all filters working

### **Automated Testing (Optional)**

```bash
# Run PHPUnit tests
php artisan test

# Run specific test
php artisan test --filter AttendanceTest

# With coverage
php artisan test --coverage
```

---

## 🔒 Security

### **Best Practices Implemented:**

- ✅ **CSRF Protection**: All forms protected
- ✅ **SQL Injection Prevention**: Eloquent ORM
- ✅ **XSS Protection**: Blade templating auto-escaping
- ✅ **Password Hashing**: bcrypt algorithm
- ✅ **Role-based Access Control**: Spatie Permission
- ✅ **Environment Variables**: Sensitive data in .env

### **Production Security Checklist:**

- [ ] Set `APP_DEBUG=false` in production
- [ ] Use strong `APP_KEY`
- [ ] Enable HTTPS/SSL
- [ ] Set strong database passwords
- [ ] Configure firewall rules
- [ ] Regular security updates
- [ ] Backup database regularly
- [ ] Monitor error logs
- [ ] Implement rate limiting
- [ ] Use secure session configuration

---

## 🤝 Contributing

Kontribusi sangat diterima! Silakan ikuti langkah berikut:

### **Step-by-step:**

1. **Fork repository**
```bash
# Click "Fork" di GitHub
```

2. **Clone fork Anda**
```bash
git clone https://github.com/YOUR_USERNAME/web-pegawai.git
cd web-pegawai
```

3. **Create feature branch**
```bash
git checkout -b feat/amazing-feature
```

4. **Make changes dan commit**
```bash
git add .
git commit -m "feat: add amazing feature"
```

5. **Push ke branch**
```bash
git push origin feat/amazing-feature
```

6. **Create Pull Request**
- Buka repository Anda di GitHub
- Klik "Pull Request"
- Jelaskan perubahan Anda

### **Commit Convention:**

Gunakan [Conventional Commits](https://www.conventionalcommits.org/):

```
feat: menambah fitur baru
fix: memperbaiki bug
docs: update dokumentasi
style: formatting, semicolon, dll (tidak mengubah kode)
refactor: refactoring kode
test: menambah atau update tests
chore: update dependencies, build tools, dll
perf: performance improvements
```

**Examples:**
```bash
git commit -m "feat: add employee export to PDF"
git commit -m "fix: resolve attendance calculation bug"
git commit -m "docs: update deployment guide"
```

---

## 📊 Roadmap & Future Features

### ✅ **Completed (v1.0)**
- [x] Filament 4.1 admin panel
- [x] Employee management CRUD
- [x] Attendance tracking system
- [x] Monthly attendance report
- [x] Horizontal attendance view
- [x] CSV export functionality
- [x] Print-friendly reports
- [x] FullCalendar integration
- [x] Activity approval workflow
- [x] Asset & loan management
- [x] Role-based permissions
- [x] Document management

### 🚧 **In Progress (v1.1)**
- [ ] PDF export dengan custom styling
- [ ] Email notifications (approve/reject)
- [ ] Dashboard analytics charts
- [ ] Attendance QR code scanner
- [ ] Mobile app (Flutter/React Native)

### 📋 **Planned (v2.0)**
- [ ] Payroll calculation
- [ ] Leave management system
- [ ] Performance appraisal module
- [ ] Training & development tracker
- [ ] Multi-branch support
- [ ] API endpoints (REST/GraphQL)
- [ ] Webhook integrations
- [ ] Advanced reporting dengan Chart.js
- [ ] Real-time notifications (Pusher/Laravel Echo)
- [ ] Multi-language support (i18n)

### 💡 **Ideas & Suggestions**
Punya ide? [Buat issue di GitHub](https://github.com/Rofiq02bae/web-pegawai/issues/new)!

---

## 📞 Support & Contact

### **Get Help:**

- **📖 Documentation**: Baca README ini dengan teliti
- **🐛 Bug Reports**: [GitHub Issues](https://github.com/Rofiq02bae/web-pegawai/issues)
- **💬 Discussions**: [GitHub Discussions](https://github.com/Rofiq02bae/web-pegawai/discussions)
- **📧 Email**: rofiq02bae@gmail.com
- **💼 LinkedIn**: [Your LinkedIn Profile]
- **🌐 Website**: [Your Website]

### **Response Time:**
- Issues: 1-3 hari kerja
- Pull Requests: 1-5 hari kerja
- Email: 3-7 hari kerja

---

## 📜 License

Project ini dilisensikan di bawah **MIT License**.

```
MIT License

Copyright (c) 2025 Rofiq02bae

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

See [LICENSE](LICENSE) file for details.

---

## 🙏 Acknowledgments

Terima kasih kepada project open-source berikut:

- **[Laravel](https://laravel.com)** - The PHP Framework for Web Artisans
- **[Filament](https://filamentphp.com)** - Beautiful admin panels for Laravel
- **[FullCalendar](https://fullcalendar.io)** - Full-sized JavaScript calendar
- **[Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)** - Associate users with roles and permissions
- **[Tailwind CSS](https://tailwindcss.com)** - Utility-first CSS framework
- **[Vite](https://vitejs.dev)** - Next generation frontend tooling
- **[Alpine.js](https://alpinejs.dev)** - Your new, lightweight, JavaScript framework
- **[Livewire](https://livewire.laravel.com)** - A full-stack framework for Laravel

### **Contributors:**
<!-- Akan di-update otomatis via GitHub -->
<a href="https://github.com/Rofiq02bae/web-pegawai/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=Rofiq02bae/web-pegawai" />
</a>

---

## 📈 Stats & Badges

![GitHub stars](https://img.shields.io/github/stars/Rofiq02bae/web-pegawai?style=social)
![GitHub forks](https://img.shields.io/github/forks/Rofiq02bae/web-pegawai?style=social)
![GitHub issues](https://img.shields.io/github/issues/Rofiq02bae/web-pegawai)
![GitHub pull requests](https://img.shields.io/github/issues-pr/Rofiq02bae/web-pegawai)
![GitHub last commit](https://img.shields.io/github/last-commit/Rofiq02bae/web-pegawai)
![GitHub repo size](https://img.shields.io/github/repo-size/Rofiq02bae/web-pegawai)
![GitHub language count](https://img.shields.io/github/languages/count/Rofiq02bae/web-pegawai)
![GitHub top language](https://img.shields.io/github/languages/top/Rofiq02bae/web-pegawai)

---

## 🎉 Changelog

### **v1.0.0** (2025-01-27)
- ✨ Initial release
- ✅ Employee management system
- ✅ Attendance tracking with CSV export
- ✅ Activity calendar with FullCalendar
- ✅ Asset & loan management
- ✅ Role-based access control
- ✅ Filament 4.1 admin panel

### **v1.0.1** (2025-01-27)
- 🐛 Fix: Livewire route error resolved
- 📝 Docs: Enhanced README with deployment guide
- ⚡ Performance: Optimized CSV export
- 🎨 Style: Improved attendance table layout

---

<div align="center">

**⭐ If this project helps you, please give it a star! ⭐**

**Made with ❤️ by [Rofiq02bae](https://github.com/Rofiq02bae)**

[![GitHub](https://img.shields.io/badge/GitHub-Rofiq02bae-181717?style=for-the-badge&logo=github)](https://github.com/Rofiq02bae)
[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-4.1-F59E0B?style=for-the-badge)](https://filamentphp.com)

</div>
