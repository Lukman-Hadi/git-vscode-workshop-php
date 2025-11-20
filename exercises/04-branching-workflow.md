# Latihan 04: Branching Workflow

## Tujuan
Menggunakan branch terpisah untuk fitur autentikasi.

## Instruksi
1. Buat branch: `feat/auth-login`.
2. Tambah endpoint POST `/users/login` (simulasi) di `public/index.php` atau ekstrak ke controller.
3. Tambah method `verifyToken(string $token)` di `AuthService`.
4. Commit terpisah:
   ```
   feat(auth): tambah endpoint login
   feat(auth): tambah fungsi verifyToken
   ```
5. Merge ke `main` (fast-forward) atau buat PR (simulasi).
6. Cek riwayat visual.

## Evaluasi
- Apakah setiap commit fokus satu perubahan?
- Apakah nama branch deskriptif?

## Catatan
Gunakan Git Graph untuk visualisasi.