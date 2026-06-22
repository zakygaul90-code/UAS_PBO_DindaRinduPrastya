<?php
// ==========================================
// 1. KONFIGURASI KONEKSI DATABASE
// ==========================================
$host = 'localhost';
$user = 'root';
$pass = ''; 
$db   = 'db_uas_pbo_ti1c_dindarinduprastya'; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     die("Koneksi database gagal: " . $e->getMessage());
}

// ==========================================
// 2. STRUKTUR OOP (ABSTRACT CLASS & INHERITANCE)
// ==========================================

abstract class Karyawan {
    protected $idKaryawan;
    protected $namaKaryawan;
    protected $departemen;
    protected $hariKerjaMasuk;
    protected $gajiDasarperHari;

    public function __construct($idKaryawan, $namaKaryawan, $departemen, $hariKerjaMasuk, $gajiDasarperHari) {
        $this->idKaryawan = $idKaryawan;
        $this->namaKaryawan = $namaKaryawan;
        $this->departemen = $departemen;
        $this->hariKerjaMasuk = $hariKerjaMasuk;
        $this->gajiDasarperHari = $gajiDasarperHari;
    }

    // Deklarasi method abstract yang WAJIB di-override oleh kelas anak
    abstract public function hitungGajiBersih();

    public function getIdKaryawan() { return $this->idKaryawan; }
    public function getNamaKaryawan() { return $this->namaKaryawan; }
    public function getDepartemen() { return $this->departemen; }
    public function getHariKerjaMasuk() { return $this->hariKerjaMasuk; }
    public function getGajiDasarperHari() { return $this->gajiDasarperHari; }
}

// KELAS ANAK: KARYAWAN TETAP
class KaryawanTetap extends Karyawan {
    private $tunjanganKesehatan;
    private $opsiSahamId;

    public function __construct($idKaryawan, $namaKaryawan, $departemen, $hariKerjaMasuk, $gajiDasarperHari, $tunjanganKesehatan, $opsiSahamId) {
        parent::__construct($idKaryawan, $namaKaryawan, $departemen, $hariKerjaMasuk, $gajiDasarperHari);
        $this->tunjanganKesehatan = $tunjanganKesehatan;
        $this->opsiSahamId = $opsiSahamId;
    }

    // METHOD OVERRIDING (Rumus Tetap)
    public function hitungGajiBersih() {
        return ($this->hariKerjaMasuk * $this->gajiDasarperHari) + $this->tunjanganKesehatan;
    }

    public function getTunjanganKesehatan() { return $this->tunjanganKesehatan; }
    public function getOpsiSahamId() { return $this->opsiSahamId; }
}

// KELAS ANAK: KARYAWAN KONTRAK
class KaryawanKontrak extends Karyawan {
    private $durasiKontrakBulan;
    private $agensiPenyalur;

    public function __construct($idKaryawan, $namaKaryawan, $departemen, $hariKerjaMasuk, $gajiDasarperHari, $durasiKontrakBulan, $agensiPenyalur) {
        parent::__construct($idKaryawan, $namaKaryawan, $departemen, $hariKerjaMasuk, $gajiDasarperHari);
        $this->durasiKontrakBulan = $durasiKontrakBulan;
        $this->agensiPenyalur = $agensiPenyalur;
    }

    // METHOD OVERRIDING (Rumus Kontrak murni harian)
    public function hitungGajiBersih() {
        return $this->hariKerjaMasuk * $this->gajiDasarperHari;
    }

    public function getDurasiKontrakBulan() { return $this->durasiKontrakBulan; }
    public function getAgensiPenyalur() { return $this->agensiPenyalur; }
}

// KELAS ANAK: KARYAWAN MAGANG
class KaryawanMagang extends Karyawan {
    private $uangSakuBulanan;
    private $sertifikatKampusMerdeka;

    public function __construct($idKaryawan, $namaKaryawan, $departemen, $hariKerjaMasuk, $gajiDasarperHari, $uangSakuBulanan, $sertifikatKampusMerdeka) {
        parent::__construct($idKaryawan, $namaKaryawan, $departemen, $hariKerjaMasuk, $gajiDasarperHari);
        $this->uangSakuBulanan = $uangSakuBulanan;
        $this->sertifikatKampusMerdeka = $sertifikatKampusMerdeka;
    }

    // METHOD OVERRIDING (Rumus Magang baru dengan pengali 0.80)
    public function hitungGajiBersih() {
        return ($this->hariKerjaMasuk * $this->gajiDasarperHari) * 0.80;
    }

    public function getUangSakuBulanan() { return $this->uangSakuBulanan; }
    public function getSertifikatKampusMerdeka() { return $this->sertifikatKampusMerdeka; }
}

// ==========================================
// 3. PROSES AMBIL DATA & INSTANSIASI OBJEK
// ==========================================
$daftarKaryawanTetap = [];
$daftarKaryawanKontrak = [];
$daftarKaryawanMagang = [];

try {
    $query = "SELECT * FROM tabel_karyawan"; 
    $stmt = $pdo->query($query);
    
    while ($row = $stmt->fetch()) {
        if ($row['jenis_karyawan'] === 'tetap') {
            $daftarKaryawanTetap[] = new KaryawanTetap(
                $row['id_karyawan'], $row['nama_karyawan'], $row['departemen'], 
                $row['hari_kerja_masuk'], $row['gaji_dasar_per_hari'], 
                $row['tunjangan_kesehatan'], $row['opsi_saham_id']
            );
        } elseif ($row['jenis_karyawan'] === 'kontrak') {
            $daftarKaryawanKontrak[] = new KaryawanKontrak(
                $row['id_karyawan'], $row['nama_karyawan'], $row['departemen'], 
                $row['hari_kerja_masuk'], $row['gaji_dasar_per_hari'], 
                $row['durasi_kontrak_bulan'], $row['agensi_penyalur']
            );
        } elseif ($row['jenis_karyawan'] === 'magang') {
            $daftarKaryawanMagang[] = new KaryawanMagang(
                $row['id_karyawan'], $row['nama_karyawan'], $row['departemen'], 
                $row['hari_kerja_masuk'], $row['gaji_dasar_per_hari'], 
                $row['uang_saku_bulanan'], $row['sertifikat_kampus_merdeka']
            );
        }
    }
} catch (PDOException $e) {
    die("Gagal mengambil data dari database: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Karyawan</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="p-6 md:p-12">

    <div class="max-w-7xl mx-auto space-y-12">
        
        <header class="text-center md:text-left border-b border-gray-300 pb-6">
            <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">DASHBOARD DATA KARYAWAN PERUSAHAAN</h1>
        </header>

        <section class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-200">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white tracking-wide">Kategori Karyawan: Tetap</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase font-semibold">
                            <th class="px-6 py-3">ID & Nama</th>
                            <th class="px-6 py-3">Departemen</th>
                            <th class="px-6 py-3 text-center">Hari Kerja</th>
                            <th class="px-6 py-3">Spesifikasi Hak Atribut</th>
                            <th class="px-6 py-3 text-right">Total Gaji Diterima</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                        <?php if (empty($daftarKaryawanTetap)): ?>
                            <tr><td colspan="5" class="px-6 py-4 text-center text-gray-400">Tidak ada data karyawan tetap.</td></tr>
                        <?php else: foreach ($daftarKaryawanTetap as $k): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    <span class="block text-xs font-mono text-gray-400"><?= $k->getIdKaryawan(); ?></span>
                                    <?= $k->getNamaKaryawan(); ?>
                                </td>
                                <td class="px-6 py-4 text-gray-500"><?= $k->getDepartemen(); ?></td>
                                <td class="px-6 py-4 text-center font-semibold"><?= $k->getHariKerjaMasuk(); ?> hari</td>
                                <td class="px-6 py-4 space-y-1">
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2.5 py-1 rounded-md font-medium">
                                        ID Saham: <?= $k->getOpsiSahamId() ?: '-'; ?>
                                    </span>
                                    <span class="inline-block bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-md font-medium">
                                        Tunjangan: Rp <?= number_format($k->getTunjanganKesehatan(), 0, ',', '.'); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-blue-600 text-base">
                                    Rp <?= number_format($k->hitungGajiBersih(), 2, ',', '.'); ?>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-200">
            <div class="bg-teal-700 px-6 py-4">
                <h2 class="text-lg font-bold text-white tracking-wide">Kategori Karyawan: Kontrak</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase font-semibold">
                            <th class="px-6 py-3">ID & Nama</th>
                            <th class="px-6 py-3">Departemen</th>
                            <th class="px-6 py-3 text-center">Hari Kerja</th>
                            <th class="px-6 py-3">Spesifikasi Hubungan Kerja</th>
                            <th class="px-6 py-3 text-right">Total Gaji Diterima</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                        <?php if (empty($daftarKaryawanKontrak)): ?>
                            <tr><td colspan="5" class="px-6 py-4 text-center text-gray-400">Tidak ada data karyawan kontrak.</td></tr>
                        <?php else: foreach ($daftarKaryawanKontrak as $k): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    <span class="block text-xs font-mono text-gray-400"><?= $k->getIdKaryawan(); ?></span>
                                    <?= $k->getNamaKaryawan(); ?>
                                </td>
                                <td class="px-6 py-4 text-gray-500"><?= $k->getDepartemen(); ?></td>
                                <td class="px-6 py-4 text-center font-semibold"><?= $k->getHariKerjaMasuk(); ?> hari</td>
                                <td class="px-6 py-4 space-y-1">
                                    <span class="inline-block bg-teal-100 text-teal-800 text-xs px-2.5 py-1 rounded-md font-medium">
                                        Vendor: <?= $k->getAgensiPenyalur(); ?>
                                    </span>
                                    <span class="inline-block bg-amber-100 text-amber-800 text-xs px-2.5 py-1 rounded-md font-medium">
                                        Masa Kontrak: <?= $k->getDurasiKontrakBulan(); ?> Bulan
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-teal-700 text-base">
                                    Rp <?= number_format($k->hitungGajiBersih(), 2, ',', '.'); ?>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-200">
            <div class="bg-purple-700 px-6 py-4">
                <h2 class="text-lg font-bold text-white tracking-wide">Kategori Karyawan: Magang</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase font-semibold">
                            <th class="px-6 py-3">ID & Nama</th>
                            <th class="px-6 py-3">Departemen</th>
                            <th class="px-6 py-3 text-center">Hari Kerja</th>
                            <th class="px-6 py-3">Spesifikasi Program Belajar</th>
                            <th class="px-6 py-3 text-right">Total Gaji Diterima</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                        <?php if (empty($daftarKaryawanMagang)): ?>
                            <tr><td colspan="5" class="px-6 py-4 text-center text-gray-400">Tidak ada data karyawan magang.</td></tr>
                        <?php else: foreach ($daftarKaryawanMagang as $k): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    <span class="block text-xs font-mono text-gray-400"><?= $k->getIdKaryawan(); ?></span>
                                    <?= $k->getNamaKaryawan(); ?>
                                </td>
                                <td class="px-6 py-4 text-gray-500"><?= $k->getDepartemen(); ?></td>
                                <td class="px-6 py-4 text-center font-semibold"><?= $k->getHariKerjaMasuk(); ?> hari</td>
                                <td class="px-6 py-4 space-y-1">
                                    <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2.5 py-1 rounded-md font-medium">
                                        <?= $k->getSertifikatKampusMerdeka() ?: 'Program Reguler'; ?>
                                    </span>
                                    <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-md font-medium">
                                        Uang Saku Dasar: Rp <?= number_format($k->getUangSakuBulanan(), 0, ',', '.'); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-purple-700 text-base">
                                    Rp <?= number_format($k->hitungGajiBersih(), 2, ',', '.'); ?>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>

</body>
</html>