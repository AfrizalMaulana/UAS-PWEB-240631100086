<?php
require_once 'functions/functions.php';

$id = $_GET['id'] ?? 0;
if ($id <= 0) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'ID tidak valid!'];
    header('Location: daftar.php');
    exit();
}

$data = getBarangById($id);
if (!$data) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Data tidak ditemukan!'];
    header('Location: daftar.php');
    exit();
}

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
        if (updateBarang($id, $kode, $nama, $kategori, $jumlah, $kondisi, $lokasi, $tanggal)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data berhasil diperbarui!'];
            header('Location: daftar.php');
            exit();
        } else {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Gagal memperbarui data.'];
        }
    } else {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => implode('<br>', $errors)];
    }
}

$currentPage = 'edit';
include 'inc/header.php';
?>

<div class="card-modern animate-fade">
    <div class="card-header-modern">
        <h5><i class="bi bi-pencil-square"></i> Edit Barang</h5>
    </div>
    <div class="card-body" style="padding: 2rem 2rem;">
        <form method="POST" action="">
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label">Kode Barang <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-upc-scan"></i></span>
                        <input type="text" name="kode_barang" class="form-control border-start-0" 
                               value="<?= htmlspecialchars($data['kode_barang']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-box"></i></span>
                        <input type="text" name="nama_barang" class="form-control border-start-0" 
                               value="<?= htmlspecialchars($data['nama_barang']) ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-tag"></i></span>
                        <input type="text" name="kategori" class="form-control border-start-0" 
                               value="<?= htmlspecialchars($data['kategori']) ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-hash"></i></span>
                        <input type="number" name="jumlah" class="form-control border-start-0" 
                               min="1" value="<?= $data['jumlah'] ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-check-circle"></i></span>
                        <select name="kondisi" class="form-select border-start-0" required>
                            <option value="Baik" <?= $data['kondisi'] === 'Baik' ? 'selected' : '' ?>>Baik</option>
                            <option value="Rusak" <?= $data['kondisi'] === 'Rusak' ? 'selected' : '' ?>>Rusak</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-geo-alt"></i></span>
                        <input type="text" name="lokasi" class="form-control border-start-0" 
                               value="<?= htmlspecialchars($data['lokasi']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-calendar-event"></i></span>
                        <input type="date" name="tanggal_masuk" class="form-control border-start-0" 
                               value="<?= $data['tanggal_masuk'] ?>" required>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2">
                        <i class="bi bi-save me-2"></i> Update
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