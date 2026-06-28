<?php
require_once __DIR__ . '/../config/koneksi.php';

function getAllBarang() {
    global $koneksi;
    $query = "SELECT * FROM barang ORDER BY id_barang DESC";
    return mysqli_query($koneksi, $query);
}

// ===== FUNGSI PENCARIAN =====
function cariBarang($keyword) {
    global $koneksi;
    $keyword = mysqli_real_escape_string($koneksi, $keyword);
    $query = "SELECT * FROM barang 
              WHERE kode_barang LIKE '%$keyword%' 
              OR nama_barang LIKE '%$keyword%' 
              OR kategori LIKE '%$keyword%'
              OR lokasi LIKE '%$keyword%'
              ORDER BY id_barang DESC";
    return mysqli_query($koneksi, $query);
}

function getBarangById($id) {
    global $koneksi;
    $id = mysqli_real_escape_string($koneksi, $id);
    $query = "SELECT * FROM barang WHERE id_barang = '$id'";
    $result = mysqli_query($koneksi, $query);
    return mysqli_fetch_assoc($result);
}

function totalBarang() {
    global $koneksi;
    $query = "SELECT COUNT(*) AS total FROM barang";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function totalKategori() {
    global $koneksi;
    $query = "SELECT COUNT(DISTINCT kategori) AS total FROM barang";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function totalBaik() {
    global $koneksi;
    $query = "SELECT COUNT(*) AS total FROM barang WHERE kondisi = 'Baik'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function totalRusak() {
    global $koneksi;
    $query = "SELECT COUNT(*) AS total FROM barang WHERE kondisi = 'Rusak'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function getRecentBarang($limit = 5) {
    global $koneksi;
    $query = "SELECT * FROM barang ORDER BY id_barang DESC LIMIT $limit";
    return mysqli_query($koneksi, $query);
}

function hapusBarang($id) {
    global $koneksi;
    $id = mysqli_real_escape_string($koneksi, $id);
    $query = "DELETE FROM barang WHERE id_barang = '$id'";
    return mysqli_query($koneksi, $query);
}

function tambahBarang($kode, $nama, $kategori, $jumlah, $kondisi, $lokasi, $tanggal) {
    global $koneksi;
    $kode      = mysqli_real_escape_string($koneksi, $kode);
    $nama      = mysqli_real_escape_string($koneksi, $nama);
    $kategori  = mysqli_real_escape_string($koneksi, $kategori);
    $jumlah    = (int) $jumlah;
    $kondisi   = mysqli_real_escape_string($koneksi, $kondisi);
    $lokasi    = mysqli_real_escape_string($koneksi, $lokasi);
    $tanggal   = mysqli_real_escape_string($koneksi, $tanggal);

    $query = "INSERT INTO barang (kode_barang, nama_barang, kategori, jumlah, kondisi, lokasi, tanggal_masuk)
              VALUES ('$kode', '$nama', '$kategori', $jumlah, '$kondisi', '$lokasi', '$tanggal')";
    return mysqli_query($koneksi, $query);
}

function updateBarang($id, $kode, $nama, $kategori, $jumlah, $kondisi, $lokasi, $tanggal) {
    global $koneksi;
    $id        = mysqli_real_escape_string($koneksi, $id);
    $kode      = mysqli_real_escape_string($koneksi, $kode);
    $nama      = mysqli_real_escape_string($koneksi, $nama);
    $kategori  = mysqli_real_escape_string($koneksi, $kategori);
    $jumlah    = (int) $jumlah;
    $kondisi   = mysqli_real_escape_string($koneksi, $kondisi);
    $lokasi    = mysqli_real_escape_string($koneksi, $lokasi);
    $tanggal   = mysqli_real_escape_string($koneksi, $tanggal);

    $query = "UPDATE barang SET 
                kode_barang = '$kode',
                nama_barang = '$nama',
                kategori    = '$kategori',
                jumlah      = $jumlah,
                kondisi     = '$kondisi',
                lokasi      = '$lokasi',
                tanggal_masuk = '$tanggal'
              WHERE id_barang = '$id'";
    return mysqli_query($koneksi, $query);
}
?>
