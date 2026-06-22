<?php
// KaryawanKontrak.php
require_once 'karyawan.php';

class KaryawanKontrak extends Karyawan {
    // Properti Tambahan Spesifik
    private $durasiKontrakBulan;
    private $agensiPenyalur;

    public function __construct($id, $nama, $dept, $hari, $gaji, $durasiKontrakBulan, $agensiPenyalur) {
        // Memanggil constructor dari parent class (Karyawan)
        parent::__construct($id, $nama, $dept, $hari, $gaji);
        $this->durasiKontrakBulan = $durasiKontrakBulan;
        $this->agensiPenyalur = $agensiPenyalur;
    }

    // Getter & Setter untuk properti spesifik
    public function getDurasiKontrakBulan() { return $this->durasiKontrakBulan; }
    public function setDurasiKontrakBulan($durasi) { $this->durasiKontrakBulan = $durasi; }
    public function getAgensiPenyalur() { return $this->agensiPenyalur; }
    public function setAgensiPenyalur($agensi) { $this->agensiPenyalur = $agensi; }

    // Implementasi hitungGajiBersih untuk Karyawan Kontrak
    // Rumus: Hari Kerja Masuk * Gaji Dasar per Hari
    public function hitungGajiBersih() {
        return $this->hariKerjaMasuk * $this->gajiDasarperHari;
    }

    // Implementasi tampilkanProfilKaryawan
    public function tampilkanProfilKaryawan() {
        echo "=== PROFIL KARYAWAN KONTRAK ===<br>";
        echo "ID Karyawan : " . $this->id_karyawan . "<br>";
        echo "Nama        : " . $this->nama_karyawan . "<br>";
        echo "Departemen  : " . $this->departemen . "<br>";
        echo "Status      : Kontrak (" . $this->durasiKontrakBulan . " Bulan)<br>";
        echo "Agensi      : " . $this->agensiPenyalur . "<br>";
        echo "Gaji Bersih : Rp " . number_format($this->hitungGajiBersih(), 0, ',', '.') . "<br><br>";
    }
}
?>