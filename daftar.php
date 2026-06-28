<?php
$currentPage = 'daftar';
include 'inc/header.php';

$keyword = $_GET['cari'] ?? '';
if (!empty($keyword)) {
    $data = cariBarang($keyword);
    $hasilPencarian = true;
} else {
    $data = getAllBarang();
    $hasilPencarian = false;
}
?>

<div class="card-modern">
    <div class="card-header-modern d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5><i class="bi bi-table"></i> Semua Barang</h5>
        <div class="d-flex gap-2 flex-wrap">
            <!-- Form Pencarian -->
            <form method="GET" action="" class="d-flex gap-2">
                <div class="input-group input-group-sm" style="width: 260px;">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="cari" class="form-control border-start-0" 
                           placeholder="Cari kode, nama, kategori..." 
                           value="<?= htmlspecialchars($keyword) ?>">
                </div>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-search"></i> Cari
                </button>
                <?php if (!empty($keyword)): ?>
                    <a href="daftar.php" class="btn btn-secondary btn-sm">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                <?php endif; ?>
            </form>
            <a href="tambah.php" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Barang
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Tanggal Masuk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($data) > 0): ?>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><span class="badge-code"><?= htmlspecialchars($row['kode_barang']) ?></span></td>
                                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                                <td><?= htmlspecialchars($row['kategori']) ?></td>
                                <td><?= $row['jumlah'] ?></td>
                                <td>
                                    <span class="badge <?= $row['kondisi'] === 'Baik' ? 'badge-baik' : 'badge-rusak' ?>">
                                        <?= htmlspecialchars($row['kondisi']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($row['lokasi']) ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal_masuk'])) ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $row['id_barang'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="hapus.php?id=<?= $row['id_barang'] ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin hapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-5">
                                <?php if ($hasilPencarian): ?>
                                    <i class="bi bi-search" style="font-size:2rem; display:block; margin-bottom:10px;"></i>
                                    Data tidak ditemukan untuk kata kunci "<strong><?= htmlspecialchars($keyword) ?></strong>"
                                <?php else: ?>
                                    <i class="bi bi-inbox" style="font-size:2rem; display:block; margin-bottom:10px;"></i>
                                    Belum ada data barang
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Info jumlah data -->
        <div class="p-3 border-top bg-light">
            <small class="text-muted">
                <?php if ($hasilPencarian): ?>
                    <i class="bi bi-info-circle"></i> Menampilkan <?= mysqli_num_rows($data) ?> hasil pencarian untuk "<strong><?= htmlspecialchars($keyword) ?></strong>"
                <?php else: ?>
                    <i class="bi bi-database"></i> Total <?= mysqli_num_rows($data) ?> data barang
                <?php endif; ?>
            </small>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>