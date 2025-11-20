# Latihan 01: Partial Staging (PHP)

## Tujuan
Melatih pemisahan commit fitur vs refactor dalam satu file atau beberapa file terkait.

## Instruksi
1. Buka `src/services/UserService.php`.
2. Fitur: Tambah method `validateAndAddUser(array $data)`:
   - Cek nama & email tidak kosong.
   - Validasi email via `EmailValidator::isValid`.
   - Push user baru ke array dengan id auto (misal `uniqid()`).
3. Refactor terpisah: ubah `listUsers()` agar bisa menerima parameter opsional `array $options` dengan kunci `sortBy` (`name`).
4. Jangan stage seluruh file sekaligus.
5. Stage hunk fitur → commit:
   ```
   feat(user): tambah fungsi validateAndAddUser
   ```
6. Stage hunk refactor → commit:
   ```
   refactor(user): dukung opsi sortBy pada listUsers
   ```
7. Verifikasi di Git Graph atau `git log --oneline`.

## Evaluasi
- Apakah commit fitur bersih tanpa perubahan refactor?
- Apakah pesan mudah dipahami tanpa melihat diff?

## Tantangan Tambahan
Pisahkan formatting otomatis (PSR-12) dalam commit:
```
chore(format): terapkan PSR-12 di UserService
```