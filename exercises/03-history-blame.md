# Latihan 03: History & Blame

## Tujuan
Memanfaatkan Timeline & GitLens (blame) untuk memahami evolusi file.

## Instruksi
1. Buka `src/utils/EmailValidator.php`.
2. Catat commit terakhir (Timeline).
3. Tambah whitelist domain:
   ```php
   private static array $whitelist = ['example.com', 'workshop.dev'];
   ```
   Modifikasi `isValid` untuk mengecek domain ada di whitelist.
4. Stage & commit:
   ```
   feat(email): tambah whitelist domain pada EmailValidator
   ```
5. Hover line baru dengan GitLens untuk metadata.
6. Bandingkan versi sebelum commit (GitLens diff).

## Evaluasi
- Dapatkah Anda identifikasi siapa (simulasi) mengubah baris terakhir?
- Apakah perubahan terisolasi jelas dalam diff?