# Latihan 02: Commit Messages

## Tujuan
Memperbaiki kualitas pesan commit dengan amend.

## Instruksi
1. Ubah `Logger::error` menjadi output JSON (array encode).
2. Commit sementara dengan pesan buruk: `update logger`.
3. Gunakan "Git: Amend Last Commit" ubah jadi:
   ```
   refactor(logger): ubah format log error menjadi JSON
   ```
4. Tambah dokumentasi format log di README → commit:
   ```
   docs(logger): jelaskan struktur output log error JSON
   ```

## Evaluasi
- Apakah amend menggantikan pesan buruk tanpa commit baru?
- Apakah type `refactor:` tepat untuk perubahan ini?

## Catatan
Jangan amend commit yang sudah di-push ke remote bersama tim.