<?php
// Mengimport koneksi database dan kelas-kelas OOP
require_once 'koneksi.php';
require_once 'Karyawan.php';
require_once 'KaryawanTetap.php';
require_once 'KaryawanKontrak.php';
require_once 'KaryawanMagang.php';

// Array penampung untuk mengelompokkan objek karyawan berdasarkan jenisnya
$daftarKaryawanTetap = [];
$daftarKaryawanKontrak = [];
$daftarKaryawanMagang = [];

try {
    // Mengambil seluruh data dari tabel_karyawan
    $query = "SELECT * FROM tabel_karyawan";
    $stmt = $pdo->query($query);
    
    while ($row = $stmt->fetch()) {
        // Polimorfisme: Instansiasi objek berdasarkan 'jenis_karyawan' dari database
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
            // Catatan: Properti uangSakuBulanan tidak lagi dipakai di hitungGaji() terbaru Anda, 
            // namun tetap dilewatkan ke constructor jika kelas memintanya.
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
    <title>Dashboard Data & Slip Gaji Karyawan</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="p-6 md:p-12">

    <div class="max-w-7xl mx-auto space-y-12">
        
        <header class="text-center md:text-left border-b border-gray-300 pb-6">
            <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">DASHBOARD DATA KARYAWAN PERUSAHAAN</h1>
            <p class="text-sm text-gray-500 mt-1">Sistem informasi penggajian terintegrasi berbasis Object-Oriented Programming (OOP)</p>
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
                            <th class="px-6 py-3">Spesifikasi Hak Atribut (Tetap)</th>
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
                            <th class="px-6 py-3">Spesifikasi Hubungan Kerja (Kontrak)</th>
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
                            <th class="px-6 py-3">Spesifikasi Program Belajar (Magang)</th>
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
                                    <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2.5 py-1 rounded-md font-medium max-w-xs truncate" title="<?= $k->getSertifikatKampusMerdeka(); ?>">
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