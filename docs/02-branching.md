# 1. Branching (Konsep & Manfaat)
- Memisahkan pengembangan fitur / eksperimen dari main
- Mengurangi risiko mengganggu kode stabil
- Memudahkan parallel work antar anggota tim

Narasi:
Branching memungkinkan kita membuat jalur pengembangan terisolasi dari cabang utama (biasanya `main` atau `master`). Dengan membuat branch baru sebelum memulai fitur atau perbaikan bug, kita menjaga kestabilan base branch agar selalu siap dirilis. Setiap branch adalah pointer ke commit tertentu yang dapat bergerak seiring kita menambahkan commit baru. Praktik baik: beri nama deskriptif dan konsisten (misal `feat/login-form`, `fix/auth-expiry`, `docs/logger-json`). Hindari bekerja langsung di `main` kecuali untuk hotfix darurat yang sederhana. Branching juga mendukung eksperimen: jika ide gagal, cukup hapus branch tanpa meninggalkan “jejak noisy” di riwayat utama.

# 2. Membuat & Mengelola Branch di VS Code
- Panel Source Control (ikon Git) + Command Palette
- Tombol status bar (nama branch) untuk switch / create
- Perintah CLI alternatif: `git branch`, `git checkout -b`

Narasi:
Di VS Code, nama branch muncul di pojok kiri bawah (status bar). Klik nama branch → muncul daftar branch dan opsi “Create new branch”. Beri nama lalu otomatis checkout ke branch baru. Command Palette (`Ctrl+Shift+P` / `Cmd+Shift+P`) → ketik “Git: Create Branch” untuk alur yang sama. Untuk berpindah, gunakan “Git: Checkout to…” atau klik lagi nama branch dan pilih target. Via CLI: `git branch` menampilkan daftar; `git checkout -b feat/login` membuat dan switch sekaligus. Pastikan sebelum membuat branch baru, Anda `git pull` agar basis commit terbaru diambil—mengurangi kemungkinan konflik saat nanti merge.

# 3. Branching Strategy Ringkas
- Feature branches untuk setiap perubahan terpisah
- Short-lived branches (hapus setelah merge)
- Hindari nama generik: gunakan prefix (feat/, fix/, docs/, chore/)
- Periodik rebase / merge dari main untuk tetap up to date

Narasi:
Strategi umum: buat branch per unit kerja (fitur kecil, bugfix fokus). Menjaga branch tetap pendek umurnya mengurangi divergensi dari main dan potensi konflik besar. Penamaan dengan prefix mempermudah filter visual di GitLens atau Git Graph. Jika fitur berjalan beberapa hari, sync secara rutin: `git fetch origin` lalu `git rebase origin/main` (atau `git merge origin/main`) agar perubahan tim lain masuk lebih dini. Di tim besar, tetapkan aturan: misal, “branch tidak lebih dari 50 baris perubahan sebelum PR” untuk menjaga review cepat.

# 4. Merging (Konsep Dasar)
- Menggabungkan riwayat branch fitur ke base branch
- Dapat menghasilkan merge commit (non fast-forward) atau fast-forward
- Menjaga jejak kronologis integrasi

Narasi:
Merge mengambil commit unik dari branch sumber (misal `feat/login`) dan menambahkan ke base branch (`main`). Jika base branch belum bergerak sejak branch dibuat dan perubahan linear, Git melakukan fast-forward: pointer `main` maju tanpa membuat commit khusus. Jika ada divergensi (keduanya memiliki commit baru), Git membuat merge commit yang menyatukan dua jalur riwayat. Merge commit memudahkan memetakan titik integrasi fitur di timeline proyek. Di VS Code, setelah checkout ke `main`, jalankan “Git: Merge Branch…” lalu pilih `feat/login`. Pastikan konflik beres sebelum menekan “Commit Merge”.

# 5. Jenis Merge: Fast-Forward vs Merge Commit
- Fast-forward: linear, tidak ada commit baru (pointer maju)
- Merge commit: ada commit gabungan (menyatukan dua parent)
- Visualisasi di log membedakan bentuk sejarah

Narasi:
Fast-forward terjadi saat `main` belum berubah—riwayat branch fitur dapat ditempel langsung. Kelebihan: riwayat bersih. Kekurangan: sulit melihat titik integrasi khusus. Merge commit menambah satu commit dengan dua parent, berguna untuk audit “kapan fitur X masuk”. Beberapa tim memaksa merge commit (menonaktifkan fast-forward) agar semua integrasi tercatat. Perintah CLI: `git merge --no-ff feat/login` memaksa merge commit. Evaluasi kebutuhan: repositori library kecil biasanya fine dengan fast-forward; proyek besar dengan compliance / audit lebih suka merge commit.

# 6. Squash Merge
- Menggabungkan seluruh commit fitur menjadi satu commit sebelum masuk main
- Mengurangi “noise” commit kecil (typo, minor refactor)
- Memperjelas sejarah: satu commit = satu unit fitur

Narasi:
Squash merge menekan rangkaian commit di branch fitur (misal 8 commit kecil) menjadi satu commit tunggal saat digabung ke base. Hasilnya riwayat utama ringkas dan mudah dibaca. Biasanya dilakukan lewat Pull Request (opsi “Squash and merge”) atau manual: checkout `main`, jalankan `git merge --squash feat/login`, kemudian `git commit -m "feat(login): form autentikasi dasar"`. Trade-off: kehilangan granularitas detail commit fitur (berguna untuk debugging). Solusi kompromi: sebelum squash, pastikan pesan commit final merangkum perubahan penting (validasi, log, edge-case). Jika butuh jejak granular di branch histori, simpan branch secara ter-tag sebelum dihapus.

# 7. Merge vs Squash vs Rebase (Perbandingan)
- Merge commit: jejak integrasi eksplisit
- Squash: satu commit bersih, riwayat padat
- Rebase: menata ulang basis commit agar linear (memindahkan commit di atas main)

Narasi:
Rebase berbeda: bukan menggabungkan, tetapi memindahkan rangkaian commit branch fitur ke atas commit terbaru base branch, menciptakan riwayat linear seolah dikembangkan langsung dari akhir `main`. `git rebase main` saat berada di branch fitur menulis ulang commit (hash baru). Bagus untuk menghindari merge commit berulang, tapi hati-hati kolaborasi: jangan rebase branch yang sudah dipush dan dipakai orang lain tanpa koordinasi (risiko force-push memecah referensi). Pola umum: rebase private branch Anda sebelum membuat PR, lalu gunakan squash atau merge commit sesuai kebijakan tim.

# 8. Langkah Praktis Merge / Squash di VS Code
- Gunakan Pull Request (GitHub) untuk memilih opsi merge
- Local: “Git: Merge Branch…” atau CLI
- Squash lokal: `git merge --squash <branch>` lalu commit manual

Narasi:
Di VS Code terintegrasi dengan GitHub, PR adalah tempat standar memilih jenis merge: “Merge commit”, “Squash and merge”, atau “Rebase and merge”. Jika bekerja lokal murni: 1) checkout ke base branch; 2) jalankan merge; 3) selesaikan konflik; 4) commit. Untuk squash lokal: `git checkout main`, `git merge --squash feat/login`, perbaiki file (jika konflik), `git commit`. Pastikan pengujian berjalan sebelum push. Gunakan Git Graph / Timeline view untuk memverifikasi hasil: riwayat harus mencerminkan strategi yang dipilih (commit tunggal atau node merge).

# 9. Konflik (Apa & Mengapa Terjadi)
- Terjadi saat dua perubahan menyentuh baris / area file yang sama
- Git tidak bisa memilih versi mana yang benar
- Bidang rawan: file konfigurasi, index/controller, package lock

Narasi:
Konflik muncul karena Git melakukan penggabungan berbasis tiga arah (base, ours, theirs). Jika kedua sisi memodifikasi potongan kode yang sama atau menghapus / memindahkan bagian beririsan, Git menandai bagian itu dengan marker `<<<<<<<`, `=======`, `>>>>>>>`. Konflik bukan error fatal; ini sinyal memerlukan keputusan manusia. Makin lama branch dibiarkan tanpa sinkronisasi, makin tinggi probabilitas konflik. Strategi pencegahan: sync sering, pecah fitur besar menjadi potongan lebih kecil, refactor terpisah dari commit fitur untuk meminimalisir area tumpang tindih.

# 10. Menyelesaikan Konflik di VS Code
- Editor menampilkan blok konflik dengan pilihan UI (Accept Current / Incoming / Both / Custom)
- Gunakan tampilan diff 3-way jika tersedia
- Setelah resolusi: hapus marker, test, stage, commit

Narasi:
Saat konflik, VS Code menyorot segmen dengan tombol inline: Accept Current (versi branch yang sedang checkout), Accept Incoming (versi branch yang digabung), Accept Both, atau Compare. Pilihan “Both” sering dipakai lalu dirapikan manual. Jangan lupa periksa logic gabungan (hindari duplikasi variabel, import). Setelah selesai: simpan file, jalankan test / linter, `git add <file>`, lalu commit (jika merge secara manual) atau menyelesaikan PR. Pastikan tidak tersisa marker `<<<<<<<` di file—CI sering gagal bila marker masih ada. Gunakan “Search” global untuk string `<<<<<<<` sebagai double check.

# 11. Best Practices Menghindari & Mengelola Konflik
- Commit kecil dan fokus
- Sinkronisasi rutin (fetch + rebase/merge main)
- Pisahkan refactor dari penambahan fitur
- Gunakan formatter konsisten (hindari konflik whitespace)

Narasi:
Commit besar yang mencampur refactor dan fitur menaikkan peluang konflik karena banyak baris berubah. Lakukan refactor di branch khusus lebih dulu, merge cepat ke main, baru bangun fitur di atas struktur baru. Gunakan auto-format (Prettier, PHP CS Fixer, ESLint) secara konsisten menurunkan konflik “kosmetik”. Hindari rename masal bersamaan dengan penambahan logika. Atur jadwal integrasi (misal akhir hari kerja) agar semua orang sync sebelum melanjutkan esok hari. Dokumentasikan pola penamaan dan struktur modul sehingga developer lain tidak mengubah area sama tanpa koordinasi.

# 12. Decision Guide: Kapan Merge Commit vs Squash vs Rebase
- Merge commit: fitur kompleks, butuh jejak integrasi
- Squash: banyak commit atom kecil ingin diringkas
- Rebase (sebelum PR): membersihkan riwayat pribadi agar linear

Narasi:
Gunakan merge commit bila audit integrasi penting (regulasi, milestone). Squash cocok untuk fitur yang mengalami banyak iterasi “perbaikan kecil” (typo, rename) yang tidak perlu berjejak terpisah di main. Rebase lakukan hanya pada branch yang belum dikonsumsi orang lain (belum di-review / di-merge) untuk memperjelas narasi commit. Hindari rebase branch bersama setelah orang lain sudah melakukan kerja turunan darinya—resikonya force-push yang memicu kebingungan. Konsistensi tim lebih penting daripada “kesempurnaan” riwayat; dokumentasikan kebijakan di README / docs internal.

# 13. Contoh Alur Lengkap (Scenario Mini)
- Buat branch fitur: `git checkout -b feat/logger-json`
- Commit bertahap (validate log, update README)
- Sync main: `git fetch origin` + `git rebase origin/main`
- Buka PR → pilih “Squash and merge”
- Hapus branch di remote & lokal

Narasi:
Alur: Developer memulai dengan branch fitur. Ia menambah beberapa commit kecil (ubah struktur payload log, perbaikan doc). Sebelum PR, ia rebase agar basis up-to-date mengurangi konflik. Di PR, reviewer menilai commit terlalu granular → pilih squash untuk menjaga main bersih. Setelah merge terjadi, branch dihapus (remote dan lokal: `git branch -d feat/logger-json`). Riwayat main memuat satu commit ringkas dengan pesan informatif. Dokumentasi di README mempermudah anggota tim lain memahami perubahan tanpa menelusuri 5–6 commit minor.

# 14. Cheat Sheet Perintah CLI (Referensi Cepat)
- List branch: `git branch -a`
- Buat & checkout: `git checkout -b feat/xyz`
- Merge (fast-forward bila memungkinkan): `git checkout main && git merge feat/xyz`
- Paksa merge commit: `git merge --no-ff feat/xyz`
- Squash merge manual: `git merge --squash feat/xyz` + `git commit`
- Rebase onto main: `git checkout feat/xyz && git fetch origin && git rebase origin/main`
- Abort rebase: `git rebase --abort`
- Resolve konflik: edit file → `git add` → `git commit` (atau lanjut rebase dengan `git rebase --continue`)

Narasi:
Cheat sheet ini memadatkan perintah yang paling sering digunakan dalam siklus branch-fitur → integrasi. Simpan di dokumen internal atau tempel di wiki tim. Penting untuk memahami konsekuensi setiap perintah (terutama rebase vs merge). Jika ragu, jalankan `git log --oneline --graph --decorate` sebelum dan sesudah operasi untuk memvisualkan perbedaan.

# 15. Penutup & Arah Lanjutan
- Fokus selanjutnya: Rebase interaktif (squash / reorder)
- Automasi lint & test di pre-push hook
- Dokumentasi jalur release (tagging & versioning)

Narasi:
Dengan memahami branching, jenis merge, dan manajemen konflik, tim siap melangkah ke optimasi lanjutan: rebase interaktif (`git rebase -i`) untuk merapikan pesan commit, pengaturan hook (pre-commit, pre-push) agar kualitas terjaga otomatis, dan strategi release (tag semantik `v1.2.0`, changelog). Langkah-langkah ini meningkatkan profesionalitas riwayat dan memudahkan kolaborasi jangka panjang.

---
## Lampiran: Tabel Keputusan Singkat

| Kebutuhan                       | Pilihan            | Alasan Utama                          | Konsekuensi |
|---------------------------------|--------------------|---------------------------------------|-------------|
| Jejak integrasi eksplisit       | Merge commit       | Audit & milestone jelas               | Riwayat bercabang |
| Riwayat bersih satu commit fitur| Squash merge       | Mudah dibaca                          | Hilang detail commit kecil |
| Linear tanpa merge commit       | Rebase sebelum PR  | Narasi kronologis halus               | Rewrite commit (hindari pada branch publik) |

## Tips Pesan Commit
Gunakan pola konvensi: `type(scope): subject`
Deskriptif: `feat(auth): tambah endpoint login`
Hindari: `update stuff`, `fix bug`

Akhiri narasi PR dengan konteks tambahan jika perlu (alasan pendekatan, kompromi teknis).
