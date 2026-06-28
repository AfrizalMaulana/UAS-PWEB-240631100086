<?php
require_once 'functions/functions.php';

// ===== LOGIKA HARUS SEBELUM INCLUDE HEADER =====
$_SESSION_flash = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode      = trim($_POST['kode_barang'] ?? '');
    $nama      = trim($_POST['nama_barang'] ?? '');
    $kategori  = trim($_POST['kategori'] ?? '');
    $jumlah    = (int) ($_POST['jumlah'] ?? 0);
    $kondisi   = $_POST['kondisi'] ?? 'Baik';
    $lokasi    = trim($_POST['lokasi'] ?? '');
    $tanggal   = $_POST['tanggal_masuk'] ?? '';

    $errors = [];
    if (empty($kode)) $errors[] = 'Kode barang wajib diisi';
    if (empty($nama)) $errors[] = 'Nama barang wajib diisi';
    if (empty($kategori)) $errors[] = 'Kategori wajib diisi';
    if ($jumlah <= 0) $errors[] = 'Jumlah harus lebih dari 0';
    if (empty($lokasi)) $errors[] = 'Lokasi wajib diisi';
    if (empty($tanggal)) $errors[] = 'Tanggal masuk wajib diisi';

    if (empty($errors)) {
        if (tambahBarang($kode, $nama, $kategori, $jumlah, $kondisi, $lokasi, $tanggal)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data barang berhasil ditambahkan!'];
            header('Location: daftar.php');
            exit;
        } else {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Gagal menambahkan data. Kode barang mungkin sudah ada.'];
        }
    } else {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => implode('<br>', $errors)];
    }
}

$currentPage = 'tambah';
include 'inc/header.php';
?>

<div class="card-modern animate-fade">
    <div class="card-header-modern">
        <h5><i class="bi bi-plus-circle"></i> Form Tambah Barang</h5>
    </div>
    <div class="card-body" style="padding: 2rem 2rem;">
        <form method="POST" action="">
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label">Kode Barang <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-upc-scan"></i></span>
                        <input type="text" name="kode_barang" class="form-control border-start-0" 
                               placeholder="Contoh: BRG-001" 
                               value="<?= htmlspecialchars($_POST['kode_barang'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-box"></i></span>
                        <input type="text" name="nama_barang" class="form-control border-start-0" 
                               placeholder="Nama barang" 
                               value="<?= htmlspecialchars($_POST['nama_barang'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-tag"></i></span>
                        <input type="text" name="kategori" class="form-control border-start-0" 
                               placeholder="Elektronik, Aksesoris, dll" 
                               value="<?= htmlspecialchars($_POST['kategori'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-hash"></i></span>
                        <input type="number" name="jumlah" class="form-control border-start-0" 
                               min="1" value="<?= $_POST['jumlah'] ?? 1 ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-check-circle"></i></span>
                        <select name="kondisi" class="form-select border-start-0" required>
                            <option value="Baik" <?= ($_POST['kondisi'] ?? '') === 'Baik' ? 'selected' : '' ?>>Baik</option>
                            <option value="Rusak" <?= ($_POST['kondisi'] ?? '') === 'Rusak' ? 'selected' : '' ?>>Rusak</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-geo-alt"></i></span>
                        <input type="text" name="lokasi" class="form-control border-start-0" 
                               placeholder="Ruang, Gudang, dll" 
                               value="<?= htmlspecialchars($_POST['lokasi'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-calendar-event"></i></span>
                        <input type="date" name="tanggal_masuk" class="form-control border-start-0" 
                               value="<?= $_POST['tanggal_masuk'] ?? date('Y-m-d') ?>" required>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2">
                        <i class="bi bi-save me-2"></i> Simpan
                    </button>
                    <a href="daftar.php" class="btn btn-secondary px-4 py-2">
                        <i class="bi bi-arrow-left me-2"></i> Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'inc/footer.php'; ?>