<?php
// Karyawan.php

abstract class Karyawan {
    // Atribut Terenkapsulasi (Encapsulated Attributes)
    protected $id_karyawan;
    protected $nama_karyawan;
    protected $departemen;
    protected $hariKerjaMasuk;
    protected $gajiDasarperHari;

    // Constructor untuk inisialisasi data awal
    public function __construct($id_karyawan, $nama_karyawan, $departemen, $hariKerjaMasuk, $gajiDasarperHari) {
        $this->id_karyawan = $id_karyawan;
        $this->nama_karyawan = $nama_karyawan;
        $this->departemen = $departemen;
        $this->hariKerjaMasuk = $hariKerjaMasuk;
        $this->gajiDasarperHari = $gajiDasarperHari;
    }

    // ==================== GETTER & SETTER ====================
    
    public function getIdKaryawan() {
        return $this->id_karyawan;
    }

    public function setIdKaryawan($id_karyawan) {
        $this->id_karyawan = $id_karyawan;
    }

    public function getNamaKaryawan() {
        return $this->nama_karyawan;
    }

    public function setNamaKaryawan($nama_karyawan) {
        $this->nama_karyawan = $nama_karyawan;
    }

    public function getDepartemen() {
        return $this->departemen;
    }

    public function setDepartemen($departemen) {
        $this->departemen = $departemen;
    }

    public function getHariKerjaMasuk() {
        return $this->hariKerjaMasuk;
    }

    public function setHariKerjaMasuk($hariKerjaMasuk) {
        $this->hariKerjaMasuk = $hariKerjaMasuk;
    }

    public function getGajiDasarperHari() {
        return $this->gajiDasarperHari;
    }

    public function setGajiDasarperHari($gajiDasarperHari) {
        $this->gajiDasarperHari = $gajiDasarperHari;
    }

    // ==================== ABSTRACT METHODS ====================
    // Metode ini wajib diimplementasikan oleh kelas turunan (misal: KaryawanTetap, KaryawanMagang)
    
    abstract public function hitungGajiBersih();
    abstract public function tampilkanProfilKaryawan();
}
?>