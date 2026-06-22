<?php
// KaryawanTetap.php
require_once 'karyawan.php';

class KaryawanTetap extends Karyawan {
    // Properti Tambahan Spesifik
    private $tunjanganKesehatan;
    private $opsiSahamId;

    public function __construct($id, $nama, $dept, $hari, $gaji, $tunjanganKesehatan, $opsiSahamId) {
        parent::__construct($id, $nama, $dept, $hari, $gaji);
        $this->tunjanganKesehatan = $tunjanganKesehatan;
        $this->opsiSahamId = $opsiSahamId;
    }

    // Getter & Setter untuk properti spesifik
    public function getTunjanganKesehatan() { return $this->tunjanganKesehatan; }
    public function setTunjanganKesehatan($tunjangan) { $this->tunjanganKesehatan = $tunjangan; }
    public function getOpsiSahamId() { return $this->opsiSahamId; }
    public function setOpsiSahamId($sahamId) { $this->opsiSahamId = $sahamId; }

    // Implementasi hitungGajiBersih untuk Karyawan Tetap
    // Rumus: (Hari Kerja Masuk * Gaji Dasar per Hari) + Tunjangan Kesehatan
    public function hitungGajiBersih() {
        return ($this->hariKerjaMasuk * $this->gajiDasarperHari) + $this->tunjanganKesehatan;
    }

    // Implementasi tampilkanProfilKaryawan
    public function tampilkanProfilKaryawan() {
        echo "=== PROFIL KARYAWAN TETAP ===<br>";
        echo "ID Karyawan : " . $this->id_karyawan . "<br>";
        echo "Nama        : " . $this->nama_karyawan . "<br>";
        echo "Departemen  : " . $this->departemen . "<br>";
        echo "Status      : Tetap<br>";
        echo "ID Opsi Saham: " . $this->opsiSahamId . "<br>";
        echo "Gaji Bersih : Rp " . number_format($this->hitungGajiBersih(), 0, ',', '.') . "<br><br>";
    }
}
?>