# Git VS Code Workshop (Backend PHP)

Repo ini mendukung pelatihan penggunaan Git granular di VS Code dengan contoh kode PHP sederhana.

## Tujuan
- Latihan stage per file, per hunk, per line.
- Memisahkan commit fitur vs refactor vs formatting.
- Menggunakan blame, history, dan ekstensi GitLens / Git Graph.
- Mencoba amend, stash, branching, dan format pesan commit.

## Prasyarat
- PHP 8.1+
- Composer
- Git
- VS Code + ekstensi: GitLens, Git Graph

## Cara Menjalankan
1. Clone repo.
2. Jalankan `composer install`.
3. Jalankan server built-in: `php -S localhost:8000 -t public`.
4. Akses `http://localhost:8000/users` atau `http://localhost:8000/health`.

## Konvensi Commit
Gunakan pola `<type>: <subject>`:
- feat: fitur baru
- fix: perbaikan bug
- refactor: perubahan struktur internal tanpa ubah perilaku
- docs: dokumentasi
- chore: konfigurasi / hal minor
- test: penambahan/perbaikan test

Contoh:
```
feat(user): tambah endpoint POST /users
refactor(logger): ubah format log error menjadi JSON
fix(auth): perbaiki pengecekan token kedaluwarsa null
```

## Alur Latihan Disarankan
1. Mulai dengan exercises/01-partial-staging.md.
2. Buat perubahan campuran (fitur + refactor dalam satu file).
3. Stage selektif (hunk/line) → commit fitur.
4. Stage refactor → commit terpisah.
5. Evaluasi riwayat dengan Git Graph.

## Tips
- Gunakan "Git: Stage Selected Ranges" untuk line staging.
- Periksa `git diff --staged` sebelum commit final.
- Gunakan stash bila perubahan belum siap di-commit.

## Struktur Log Error (JSON)
`Logger::error` sekarang menghasilkan format JSON:
```json
{
  "level": "error",
  "timestamp": "2025-11-20T00:00:00+00:00",
  "message": "Unhandled exception",
  "context": {}
}
```
Gunakan format terstruktur ini untuk parsing atau agregasi log.

Selamat berlatih!