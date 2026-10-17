# Sistem Data Kantor

Sistem informasi kantor berbasis **Laravel 13** + **Filament** + **PostgreSQL**.
Dibangun sebagai project portfolio sekaligus fondasi sistem data kantor yang bisa dipakai nyata.

> Status: dalam pengembangan (Fase 1 — fondasi)

## Fitur (Fase 1)

- [ ] Autentikasi & role (super_admin, admin, manajer, karyawan)
- [ ] Manajemen divisi & karyawan
- [ ] Pengumuman kantor
- [ ] Manajemen dokumen (dengan versioning)
- [ ] Dashboard statistik
- [ ] Audit log

## Tech Stack

- **Laravel 13** — backend framework
- **Filament** — admin panel
- **PostgreSQL 16** — database
- **DDEV** — local development environment
- **Spatie** — permission, activity log, media library
- **PHPUnit / Pest** — testing
- **Laravel Pint** — code style

## Cara Menjalankan

Prasyarat: Docker + DDEV sudah terinstall.

    git clone https://github.com/raihanmuzaffar/data-kantor.git
    cd data-kantor

    ddev start
    ddev composer install
    cp .env.example .env
    ddev artisan key:generate
    ddev artisan migrate --seed
    ddev launch

Aplikasi akan tersedia di `https://data-kantor.ddev.site`.

## Roadmap

- [x] Setup project + DDEV + PostgreSQL
- [ ] Install Filament + package inti
- [ ] Modul Divisi & Karyawan
- [ ] Modul Pengumuman
- [ ] Modul Dokumen
- [ ] Dashboard
- [ ] Audit Log viewer
- [ ] Testing & CI/CD

## Lisensi

MIT
