<?php
// KaryawanMagang.php
require_once 'karyawan.php';

class KaryawanMagang extends Karyawan {
    // Properti Tambahan Spesifik
    private $uangSakuBulanan;
    private $sertifikatKampusMerdeka;

    public function __construct($id, $nama, $dept, $hari, $gaji, $uangSakuBulanan, $sertifikatKampusMerdeka) {
        parent::__construct($id, $nama, $dept, $hari, $gaji);
        $this->uangSakuBulanan = $uangSakuBulanan;
        $this->sertifikatKampusMerdeka = $sertifikatKampusMerdeka;
    }

    // Getter & Setter untuk properti spesifik
    public function getUangSakuBulanan() { return $this->uangSakuBulanan; }
    public function setUangSakuBulanan($uangSaku) { $this->uangSakuBulanan = $uangSaku; }
    public function getSertifikatKampusMerdeka() { return $this->sertifikatKampusMerdeka; }
    public function setSertifikatKampusMerdeka($sertifikat) { $this->sertifikatKampusMerdeka = $sertifikat; }

    // Implementasi hitungGajiBersih untuk Karyawan Magang
    // Rumus: (Hari Kerja Masuk * Gaji Dasar per Hari) + Uang Saku Bulanan Tetap
    public function hitungGajiBersih() {
        return ($this->hariKerjaMasuk * $this->gajiDasarperHari) + $this->uangSakuBulanan;
    }

    // Implementasi tampilkanProfilKaryawan
    public function tampilkanProfilKaryawan() {
        echo "=== PROFIL KARYAWAN MAGANG ===<br>";
        echo "ID Karyawan : " . $this->id_karyawan . "<br>";
        echo "Nama        : " . $this->nama_karyawan . "<br>";
        echo "Departemen  : " . $this->departemen . "<br>";
        echo "Status      : Magang<br>";
        echo "Sertifikat  : " . $this->sertifikatKampusMerdeka . "<br>";
        echo "Gaji Bersih : Rp " . number_format($this->hitungGajiBersih(), 0, ',', '.') . "<br><br>";
    }
}
?>