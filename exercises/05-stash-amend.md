# Latihan 05: Stash & Amend

## Tujuan
Memahami penyimpanan sementara pekerjaan dan koreksi commit terakhir.

## Instruksi
1. Tambah komentar TODO panjang di `public/index.php` (pekerjaan belum siap).
2. Anda perlu segera memperbaiki bug: tambahkan validasi null pada `isTokenExpired` di `AuthService`.
3. Simpan perubahan sementara: "Git: Stash".
4. Perbaiki bug:
   ```php
   public function isTokenExpired(?int $expiryMs): bool {
       if ($expiryMs === null) {
           return true;
       }
       return (int) (microtime(true) * 1000) > $expiryMs;
   }
   ```
5. Commit:
   ```
   fix(auth): perbaiki validasi null pada isTokenExpired
   ```
6. Apply stash.
7. Lanjutkan fitur komentar (kalau perlu commit):
   ```
   chore(index): tambah catatan TODO perbaikan struktur bootstrap
   ```
8. Jika ada typo di commit terakhir sebelum push remote, lakukan amend.

## Evaluasi
- Apakah stash mencegah tercampurnya perubahan tidak relevan?
- Apakah amend hanya dilakukan sebelum push?

## Tips
Gunakan `git stash list` untuk melihat daftar stash.