# Workshop: Unit Testing PHP Backend dengan PHPUnit (Studi Kasus Repo: git-vscode-workshop-php)

> Catatan: Repo saat ini hanya memiliki `composer.json` dan struktur folder kosong (`src/`, `public/`, dll). Studi kasus tiap slide akan menggunakan contoh kode yang akan kita tambahkan ke dalam folder `src/` dan folder `tests/` agar selaras dengan autoload PSR-4: `App\ => src/`.

---

## Slide 1: Apa Itu Unit Test?
- Menguji bagian terkecil (unit) dari kode: fungsi atau method kelas
- Tujuan: memastikan perilaku tetap benar saat ada perubahan
- Manfaat: dokumentasi hidup, mengurangi bug regresi, meningkatkan kepercayaan refactor
- Alat utama di PHP: PHPUnit

Contoh (konsep sederhana fungsi penjumlahan):
```php
function tambah(int $a, int $b): int {
    return $a + $b;
}
```

Studi Kasus:
- Kita akan buat kelas `Calculator` di `src/Calculator.php` dan menguji method `add()`
- Ini merepresentasikan kebutuhan umum: perhitungan dasar di backend (misal untuk invoice, statistik)

---

## Slide 2: Instalasi PHPUnit
- Tambahkan PHPUnit sebagai dev dependency
- Gunakan Composer
- Pastikan versi PHP mendukung (misal PHP >= 8.1)

Perintah:
```bash
composer require --dev phpunit/phpunit
```

composer.json (setelah instalasi dev dependency akan otomatis menambah bagian require-dev):
```json
{
  "name": "workshop/git-vscode-php",
  "type": "project",
  "require": {},
  "require-dev": {
    "phpunit/phpunit": "^11.0"
  },
  "autoload": {
    "psr-4": {
      "App\\": "src/"
    }
  }
}
```

Studi Kasus:
- Jalankan perintah di atas di repo Anda
- Setelah itu buat folder `tests/` untuk menyimpan test case

---

## Slide 3: Konfigurasi Dasar PHPUnit
- File konfigurasi: `phpunit.xml` atau `phpunit.xml.dist`
- Mengatur bootstrap (autoload), coverage, test suite
- Memudahkan eksekusi cukup `vendor/bin/phpunit`

Contoh `phpunit.xml`:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit
    colors="true"
    bootstrap="vendor/autoload.php"
    processIsolation="false"
    stopOnFailure="false"
>
  <testsuites>
    <testsuite name="Unit">
      <directory suffix="Test.php">tests</directory>
    </testsuite>
  </testsuites>

  <coverage includeUncoveredFiles="true">
    <include>
      <directory>src</directory>
    </include>
    <report>
      <html outputDirectory="coverage-html"/>
      <text outputFile="coverage.txt"/>
    </report>
  </coverage>
</phpunit>
```

Studi Kasus:
- Letakkan file di root repo
- Jalankan: `vendor/bin/phpunit`

---

## Slide 4: Menulis Test Case Pertama
- Struktur: kelas test mewarisi `PHPUnit\Framework\TestCase`
- Nama file: `NamaKelasTest.php`
- Setiap method test diawali `test` atau diberi annotation `@test`

Kode `src/Calculator.php`:
```php
<?php
namespace App;

class Calculator {
    public function add(int $a, int $b): int {
        return $a + $b;
    }
}
```

Kode `tests/CalculatorTest.php`:
```php
<?php
use PHPUnit\Framework\TestCase;
use App\Calculator;

class CalculatorTest extends TestCase {
    public function testAddReturnsCorrectSum(): void {
        $calc = new Calculator();
        $this->assertSame(7, $calc->add(3, 4));
    }
}
```

Studi Kasus:
- Jalankan: `vendor/bin/phpunit --filter CalculatorTest`

---

## Slide 5: Assertions (Inti Verifikasi)
- `assertSame($expected, $actual)`
- `assertEquals($expected, $actual)`
- `assertTrue($value)`
- `assertFalse($value)`
- `assertCount($n, $array)`
- `assertInstanceOf(Kelas::class, $obj)`
- `assertThrows` via `expectException()`

Contoh:
```php
$this->assertSame(10, $calc->add(4, 6));
$this->assertTrue($user->isActive());
$this->assertInstanceOf(User::class, $user);
```

Studi Kasus:
- Tambahkan assertion tambahan di `CalculatorTest` untuk beberapa nilai berbeda

---

## Slide 6: Menjalankan Test
- Perintah standar: `vendor/bin/phpunit`
- Filter test tertentu: `--filter NamaTest`
- Gunakan `phpunit.xml` agar tanpa opsi tambahan
- Tambahkan script di composer

composer.json (script):
```json
"scripts": {
  "test": "phpunit"
}
```

Menjalankan:
```bash
composer test
```

Studi Kasus:
- Jalankan semua test setelah menambah script agar tim mudah konsisten

---

## Slide 7: Menguji Fungsi Tunggal
- Jika fungsi berada di file util tanpa kelas (kurang disarankan untuk skala besar)
- Tetap bisa diuji dengan memanggil langsung

Contoh `src/functions.php`:
```php
<?php
namespace App;

function normalizeName(string $name): string {
    return trim(strtolower($name));
}
```

Test `tests/FunctionsTest.php`:
```php
<?php
use PHPUnit\Framework\TestCase;
use function App\normalizeName;

class FunctionsTest extends TestCase {
    public function testNormalizeName(): void {
        $this->assertSame('john doe', normalizeName("  John Doe "));
    }
}
```

Studi Kasus:
- Buat file `src/functions.php` bila ingin contoh util terpisah

---

## Slide 8: Menguji Kelas (OOP Focus)
- Unit test memeriksa method publik
- Private method diuji lewat efek method publik
- Gunakan dependency injection untuk memudahkan mocking

Contoh kelas dengan dependency:
```php
<?php
namespace App;

class UserRepository {
    public function findById(int $id): array {
        // Dummy sementara
        return ['id' => $id, 'name' => 'Demo'];
    }
}

class UserService {
    public function __construct(private UserRepository $repo) {}

    public function getDisplayName(int $id): string {
        $data = $repoData = $this->repo->findById($id);
        return strtoupper($data['name']);
    }
}
```

Test:
```php
<?php
use PHPUnit\Framework\TestCase;
use App\UserService;
use App\UserRepository;

class UserServiceTest extends TestCase {
    public function testGetDisplayName(): void {
        $repo = new UserRepository();
        $service = new UserService($repo);
        $this->assertSame('DEMO', $service->getDisplayName(5));
    }
}
```

Studi Kasus:
- Nanti akan kita tingkatkan dengan mocking agar tidak bergantung ke DB

---

## Slide 9: Multiple Test Methods
- Pisahkan skenario berbeda per method
- Memudahkan identifikasi gagal mana
- Hindari test yang terlalu panjang

Contoh:
```php
public function testAddPositiveNumbers(): void { ... }
public function testAddNegativeNumbers(): void { ... }
public function testAddZero(): void { ... }
```

Studi Kasus:
- Tambahkan 3 method berbeda di `CalculatorTest` untuk variasi input

---

## Slide 10: Data Providers
- Mengurangi duplikasi test untuk variasi data
- Method provider mengembalikan array of arrays
- Annotation: `@dataProvider namaProvider`

Contoh:
```php
class CalculatorTest extends TestCase {
    /**
     * @dataProvider addProvider
     */
    public function testAddWithDataProvider($a, $b, $expected): void {
        $calc = new Calculator();
        $this->assertSame($expected, $calc->add($a, $b));
    }

    public function addProvider(): array {
        return [
            [1, 2, 3],
            [0, 0, 0],
            [-1, 1, 0],
            [10, 5, 15],
        ];
    }
}
```

Studi Kasus:
- Implementasikan provider di `CalculatorTest` untuk variasi

---

## Slide 11: Bootstrapping Test
- Bootstrap = menyiapkan environment sebelum test berjalan
- Biasanya: autoload composer, load env, konstanta
- Sudah diatur di `phpunit.xml` via `bootstrap=vendor/autoload.php`
- Untuk hal khusus bisa buat `tests/bootstrap.php`

Contoh `tests/bootstrap.php`:
```php
<?php
require __DIR__ . '/../vendor/autoload.php';
define('APP_ENV', 'test');
```

phpunit.xml (ubah):
```xml
<phpunit bootstrap="tests/bootstrap.php" ...>
```

Studi Kasus:
- Jika nanti ada koneksi DB / .env, bisa diinisialisasi di bootstrap

---

## Slide 12: Konfigurasi Lanjut (phpunit.xml)
- Mengaktifkan coverage
- Menyetel cache result (di versi terbaru)
- Memisahkan test suite (unit vs integration)
- Mengatur daftar direktori exclude

Contoh suite ganda:
```xml
<testsuites>
  <testsuite name="Unit">
    <directory suffix="Test.php">tests/Unit</directory>
  </testsuite>
  <testsuite name="Integration">
    <directory suffix="Test.php">tests/Integration</directory>
  </testsuite>
</testsuites>
```

Studi Kasus:
- Buat folder `tests/Unit` & `tests/Integration` untuk mempersiapkan skala besar

---

## Slide 13: Errors vs Failures
- Failure: Assertion tidak terpenuhi (logika salah)
- Error: Exception tidak ter-handle / kode crash (misal undefined variable)
- Penting membedakan agar tahu: masalah test atau masalah kode

Contoh Failure:
```php
$this->assertSame(5, $calc->add(2, 2)); // hasil 4 -> failure
```

Contoh Error:
```php
$undefinedVar->doSomething(); // PHP Fatal / Error
```

Studi Kasus:
- Simulasikan dengan salah menulis expected lalu perbaiki

---

## Slide 14: Test Dependencies (@depends)
- Menggunakan hasil test sebelumnya
- Memungkinkan reuse objek/hasil sementara
- Hati-hati: terlalu banyak dependency menambah fragilitas

Contoh:
```php
public function testCreateUser(): User {
    $user = new User('Lukman');
    $this->assertSame('Lukman', $user->getName());
    return $user;
}

/**
 * @depends testCreateUser
 */
public function testUserActivation(User $user): void {
    $user->activate();
    $this->assertTrue($user->isActive());
}
```

Studi Kasus:
- Gunakan pada `UserServiceTest` untuk memisahkan pembuatan user & status

---

## Slide 15: Fixtures (setUp / tearDown)
- `setUp()`: dijalankan sebelum setiap test method
- `tearDown()`: setelah setiap test method
- Hindari state tersembunyi (fixture harus jelas)

Contoh:
```php
class CalculatorTest extends TestCase {
    private Calculator $calc;

    protected function setUp(): void {
        $this->calc = new Calculator();
    }

    public function testAdd(): void {
        $this->assertSame(3, $this->calc->add(1, 2));
    }
}
```

Studi Kasus:
- Refactor test untuk menghindari duplikasi instansiasi objek

---

## Slide 16: Stubbing
- Stub = objek tiruan sederhana mengembalikan nilai tetap
- Berguna saat dependency belum selesai / mahal (I/O)
- Menggunakan `createStub(ClassName::class)`

Contoh:
```php
$repoStub = $this->createStub(UserRepository::class);
$repoStub->method('findById')->willReturn(['id' => 1, 'name' => 'Tester']);

$service = new UserService($repoStub);
$this->assertSame('TESTER', $service->getDisplayName(1));
```

Studi Kasus:
- Gantikan `UserRepository` nyata dengan stub agar terisolasi

---

## Slide 17: Mocking
- Mock = seperti stub tetapi bisa verifikasi interaksi (expect method dipanggil)
- Gunakan `createMock()`
- Dapat menggunakan `expects($this->once())`

Contoh:
```php
$repoMock = $this->createMock(UserRepository::class);
$repoMock->expects($this->once())
    ->method('findById')
    ->with(5)
    ->willReturn(['id' => 5, 'name' => 'Demo']);

$service = new UserService($repoMock);
$this->assertSame('DEMO', $service->getDisplayName(5));
```

Studi Kasus:
- Pastikan method dipanggil sekali, cocok untuk memastikan query DB tidak berulang

---

## Slide 18: Code Coverage - Instalasi
- Gunakan Xdebug atau PCOV
- Xdebug: mudah di dev, PCOV: lebih ringan
- Pastikan extension aktif

Instal Xdebug (contoh Linux):
```bash
pecl install xdebug
echo "zend_extension=xdebug.so" > /etc/php/8.2/mods-available/xdebug.ini
```

Studi Kasus:
- Aktifkan Xdebug di lingkungan lokal Anda untuk laporan coverage

---

## Slide 19: Generate Coverage Report
- Aktifkan section `<coverage>` di `phpunit.xml`
- Jalankan: `vendor/bin/phpunit --coverage-html coverage-html`
- Analisa file yang belum ter-cover

Contoh output perintah:
```bash
Generating code coverage report in HTML format ...
```

Studi Kasus:
- Revisi test untuk menambah coverage method yang belum diuji

---

## Slide 20: VSCode Integration - Setup
- Ekstensi disarankan:
  - PHP Intelephense
  - PHPUnit Test Explorer / PHP Test Explorer
  - PHP Debug (Xdebug)
- Konfigurasi `launch.json` untuk debugging test

Contoh `launch.json`:
```json
{
  "version": "0.2.0",
  "configurations": [
    {
      "name": "Debug PHPUnit",
      "type": "php",
      "request": "launch",
      "program": "${workspaceFolder}/vendor/bin/phpunit",
      "args": [
        "--filter",
        "CalculatorTest"
      ],
      "cwd": "${workspaceFolder}",
      "port": 9003
    }
  ]
}
```

Studi Kasus:
- Set breakpoint di `Calculator::add` lalu jalankan konfigurasi debug

---

## Slide 21: VSCode - Install Library / PHP Extension
- Pastikan PHP path benar (cek: `which php`)
- Install Xdebug sudah (untuk coverage & debug)
- Composer autoload terdeteksi otomatis

Validasi:
```bash
php -v
php -m | grep xdebug
```

Studi Kasus:
- Pastikan Xdebug tampil di modul sebelum debug test

---

## Slide 22: VSCode - Install Ekstensi
- Buka Marketplace VSCode
- Cari & install:
  - "PHP Intelephense"
  - "PHP Debug"
  - "PHPUnit Test Explorer" (atau yang serupa)
- Reload window setelah instalasi

Studi Kasus:
- Setelah instalasi, lihat panel Test Explorer muncul

---

## Slide 23: VSCode - Konfigurasi Task / Shortcut
- Tambah `tasks.json` untuk menjalankan test cepat
- Tambah keybinding ke task

Contoh `.vscode/tasks.json`:
```json
{
  "version": "2.0.0",
  "tasks": [
    {
      "label": "Run PHPUnit",
      "type": "shell",
      "command": "vendor/bin/phpunit",
      "group": "test",
      "problemMatcher": []
    }
  ]
}
```

Studi Kasus:
- Jalankan via Command Palette: "Run Task" -> "Run PHPUnit"

---

## Slide 24: Merancang Struktur Folder Test
- `tests/Unit` untuk logika murni
- `tests/Integration` untuk gabungan modul / I/O
- Hindari campur sehingga eksekusi cepat terjaga
- Simpan helper test di `tests/_support` (opsional)

Studi Kasus:
- Pindahkan `CalculatorTest` ke `tests/Unit`
- Buat `UserServiceTest` di `tests/Unit`

---

## Slide 25: Menangani Exception
- Gunakan `$this->expectException(ExceptionClass::class)`
- Bisa juga periksa pesan dengan `expectExceptionMessage()`

Contoh:
```php
$this->expectException(InvalidArgumentException::class);
$service->process(-1);
```

Studi Kasus:
- Tambahkan method baru `Calculator::divide($a, $b)` yang lempar exception saat `$b == 0`

---

## Slide 26: Refactor Dengan Aman
- Ubah implementasi internal (misal algoritma)
- Pastikan semua test tetap hijau -> perilaku konsisten
- Jika test ikut gagal karena perubahan yang benar, perbarui test dengan hati-hati

Studi Kasus:
- Ubah `Calculator::add` untuk menerima array bilangan: `addMany(array $nums)`
- Tulis test baru tanpa menghapus test lama

---

## Slide 27: Menulis Test yang Mudah Dibaca
- Arrange - Act - Assert (AAA pattern)
- Hindari banyak assertion tidak terkait dalam satu method
- Nama test harus deskriptif

Contoh pola:
```php
// Arrange
$calc = new Calculator();
// Act
$result = $calc->add(2, 3);
// Assert
$this->assertSame(5, $result);
```

Studi Kasus:
- Refactor test yang bercampur ke pola AAA

---

## Slide 28: Menghindari Flaky Test
- Jangan bergantung pada waktu real (pakai time abstraction)
- Hindari external API (mock)
- Jangan pakai state global (static)

Studi Kasus:
- Jika nanti buat class `Clock`, test dengan stub jam tetap

---

## Slide 29: Checklist Sebelum Commit
- Semua test hijau
- Coverage meningkat atau minimal stabil
- Tidak ada test yang terlalu kompleks
- Tidak ada mocking berlebihan (mock anti-pattern)

Contoh Automasi (Git Hook sederhana):
```bash
#!/bin/sh
composer test
if [ $? -ne 0 ]; then
  echo "Gagal: Test belum hijau"
  exit 1
fi
```

Studi Kasus:
- Tambahkan pre-commit hook di `.git/hooks/pre-commit`

---

## Slide 30: Ringkasan & Langkah Berikutnya
- Kita telah membahas: Instalasi, Penulisan, Assertions, Fixtures, Mocking, Coverage, VSCode
- Langkah lanjut: Integration test, Test database (dengan transaksi rollback)
- Rekomendasi: Tambahkan CI (GitHub Actions) untuk otomatis menjalankan test

Contoh GitHub Actions (singkat):
```yaml
name: CI
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
    - uses: actions/checkout@v4
    - uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        coverage: xdebug
    - run: composer install
    - run: vendor/bin/phpunit
```

Studi Kasus:
- Implementasikan file `.github/workflows/ci.yml` untuk menjaga kualitas repo

---

## Bonus: Daftar File yang Direkomendasikan Ditambahkan ke Repo
- `phpunit.xml`
- `src/Calculator.php`
- `src/functions.php`
- `src/UserRepository.php`
- `src/UserService.php`
- `tests/CalculatorTest.php`
- `tests/FunctionsTest.php`
- `tests/UserServiceTest.php`
- `.vscode/launch.json`
- `.vscode/tasks.json`
- GitHub Actions workflow (`.github/workflows/ci.yml`)

Semua contoh di slide siap dijadikan implementasi nyata agar materi tidak hanya teoretis.

---

## Narasi Penutup (Mentor Style)
Dengan memahami unit test sebagai “jaring pengaman” kita bisa bergerak lebih percaya diri saat menambah fitur atau refactor. Mulailah dari test sederhana (Calculator), naik ke kelas dengan dependency (UserService), kemudian terapkan praktik lanjutan: data provider, mocking, coverage. Integrasikan ke VSCode agar siklus umpan balik (feedback loop) cepat. Setelah nyaman, otomatisasikan pipeline CI. Ingat: kode tanpa test adalah hutang masa depan—investasi kecil di awal, manfaat besar saat skala tumbuh.

Selamat berlatih! Jika siap, kita bisa lanjut ke integration test & test database di sesi berikut.
