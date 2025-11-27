# Skrip Narasi Lengkap (PHP Versi)

Slide 1 – Pengantar  
"Kita akan memaksimalkan Git di VS Code menggunakan contoh proyek PHP sederhana. Tujuan: menghasilkan commit yang bersih, terstruktur, mudah ditelusuri. UI VS Code membantu visualisasi staging yang sebelumnya Anda lakukan lewat CLI."  

Slide 2 – Prasyarat  
"Saya asumsi Anda sudah nyaman dengan perintah dasar seperti git add, git commit, git diff. Pastikan Git dan VS Code terpasang, serta kita punya repo contoh dengan beberapa branch agar bisa simulasi skenario nyata."  

Slide 3 – Mapping Konsep  
"Working directory = file PHP yang Anda edit. Saat di-stage, masuk ke area Staged Changes. HEAD merepresentasikan commit terakhir. Diff view menampilkan perubahan baris—memudahkan keputusan: mana masuk commit fitur, mana nanti untuk refactor."  

Slide 4 – Source Control Overview  
"Panel Source Control menampilkan daftar perubahan, input pesan commit, serta tombol pull, push, sync. Dengan ini Anda memvalidasi konteks sebelum commit tanpa banyak berpindah ke terminal."  

Slide 5 – Struktur Panel  
"Terdapat dua bagian utama: Changes (belum staged) dan Staged Changes. Ikon plus untuk stage, minus untuk unstage, dan panah melingkar untuk discard. Pastikan setiap perpindahan ke staging merupakan keputusan sadar, bukan otomatis."  

Slide 6 – Stage Per File  
"Men-stage seluruh file cocok jika seluruh isi perubahan logis berkaitan dengan satu tema. Misalnya `UserService.php` hanya berisi tambahan method fitur baru. Namun jika bercampur dengan refactor, jangan langsung stage semua."  

Slide 7 – Stage Per Hunk  
"Partial staging per hunk memungkinkan Anda memisahkan blok fitur dari blok refactor dalam file yang sama. VS Code menampilkan blok-blok ini. Praktik ini meniru `git add -p` dengan antarmuka visual yang lebih intuitif."  

Slide 8 – Stage Per Line  
"Kadang satu hunk masih mengandung dua maksud yang berbeda. Stage per line akan memberikan presisi maksimum. Gunakan Command Palette ‘Git: Stage Selected Ranges’. Ini mempertegas kebersihan narasi histori."  

Slide 9 – Unstage vs Discard  
"Unstage hanya memindahkan perubahan keluar dari staging, tanpa menghapus. Discard akan membuang perubahan di working directory dan kembali ke versi HEAD. Jika ragu, gunakan stash daripada discard."  

Slide 10 – Memahami Diff  
"Hijau = penambahan, merah = penghapusan. Hunk memecah perubahan menjadi unit logis. Semakin tepat Anda memilih hunk yang masuk ke commit, semakin mudah untuk melakukan blame atau bisect di masa depan."  

Slide 11 – Pesan Commit Dasar  
"Commit adalah pesan untuk diri Anda dan rekan tim di masa depan. Hindari penggunaan istilah generik seperti ‘update’ atau ‘perubahan kecil’. Jelaskan dengan singkat tujuan dan konteks dari permasalahan yang dipecahkan atau kemampuan yang ditambahkan."  

Slide 12 – Format Disarankan  
"Mengikuti pola `type: subject` seperti `feat:`, `fix:`, `refactor:`, `docs:` akan memastikan konsistensi. Batas 50 karakter akan menjaga keterbacaan di log ringkas. Tambahkan deskripsi lanjutan jika perlu elaborasi teknis."  

Slide 13 – Workflow Multi Commit  
"Strategi utama: pisahkan fitur dari refactor. Stage hunk fitur terlebih dahulu, lalu commit. Setelah itu, refactor di commit terpisah. Hasilnya: revert refactor tidak akan menabrak fitur, dan debugging lebih cepat."  

Slide 14 – Riwayat per File  
"Timeline per file di VS Code akan membantu audit ‘kapan dan mengapa file ini berubah’. Ini berguna saat menilai area yang sering bermasalah atau menentukan dampak dari refactor lanjutan."  

Slide 15 – Riwayat Global  
"Git Graph dan GitLens akan memvisualisasikan percabangan branch. Ini lebih mudah untuk menjelaskan alur penggabungan ke anggota tim baru dibandingkan hanya menggunakan `git log --graph`. Visualisasi ini membantu mengurangi miskomunikasi."  

Slide 16 – Blame & Insight  
"Blame menunjukkan penulis dan waktu perubahan terakhir pada setiap baris. Pola perubahan yang sering terjadi di area yang sama bisa menjadi sinyal kebutuhan untuk melakukan refactor struktural atau peningkatan test coverage."  

Slide 17 – Ekstensi Utama  
"Gunakan GitLens untuk insight commit, blame, dan perbandingan. Git Graph untuk diagram branch. PR & Issues untuk integrasi GitHub. Pasang secukupnya—terlalu banyak ekstensi dapat memperlambat editor."  

Slide 18 – Praktik Baik  
"Commit kecil memudahkan bisect. Partial staging memisahkan maksud. Format yang konsisten akan membantu alat otomatis. Review diff sebelum commit untuk meminimalkan noise seperti spasi yang tidak sengaja."  

Slide 19 – Demo Alur  
"Kita akan ubah `UserService.php`: tambahkan method fitur, dan ubah listUsers untuk mendukung sort. Stage hunk fitur, commit `feat`. Lalu stage hunk refactor, commit `refactor`. Periksa Git Graph untuk melihat dua commit terpisah yang rapi."  

Slide 20 – Tantangan  
"Peserta melakukan sendiri: modifikasi dua fungsi berbeda, stage secara selektif, kemudian commit sesuai dengan konvensi. Evaluasi: apakah commit dapat dipahami tanpa membuka diff? Jika ya, Anda berhasil."  

Slide 21 – Kesalahan Umum  
"Menggabungkan fitur + refactor + formatting dalam satu commit besar akan menyulitkan untuk revert. Pesan yang generik dapat menghilangkan konteks. Melakukan discard tanpa pemeriksaan dapat menyebabkan hilangnya pekerjaan yang belum ter-backup."  

Slide 22 – Integrasi Terminal  
"Meskipun UI sangat kuat, terminal tetap diperlukan untuk operasi yang kompleks: rebase interaktif, cherry-pick, bisect. Gunakan keduanya secara komplementer untuk mendapatkan fleksibilitas penuh."  

Slide 23 – Advanced  
"Amend akan memperbaiki commit terakhir. Stash menyimpan snapshot sementara tanpa tercampur. Bisect mempercepat pelacakan commit yang menyebabkan bug. Rebase menjaga riwayat tetap linear—sesuaikan dengan kebijakan tim."  

Slide 24 – Ringkasan  
"Granular staging meningkatkan kualitas histori. Komit yang naratif memudahkan pemeliharaan. Ekstensi menambah visibilitas. Disiplin sekarang akan menghemat waktu debugging di masa mendatang."  

Slide 25 – Tanya Jawab  
"Silakan ajukan masalah nyata dari workflow: konflik merge sering terjadi? Pesan commit kurang informatif? Kesulitan untuk memisahkan refactor? Kita akan bedah solusi praktis."