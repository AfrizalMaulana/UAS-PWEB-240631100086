<?php
$currentPage = 'index';
include 'inc/header.php';

$totalBarang = totalBarang();
$totalKategori = totalKategori();
$totalBaik = totalBaik();
$totalRusak = totalRusak();
$recentBarang = getRecentBarang(5);
?>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card-primary">
            <div class="stat-icon"><i class="bi bi-box"></i></div>
            <div class="stat-info">
                <h3><?= $totalBarang ?></h3>
                <p>Total Barang</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card-success">
            <div class="stat-icon"><i class="bi bi-tags"></i></div>
            <div class="stat-info">
                <h3><?= $totalKategori ?></h3>
                <p>Kategori</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card-info">
            <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
            <div class="stat-info">
                <h3><?= $totalBaik ?></h3>
                <p>Kondisi Baik</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card-danger">
            <div class="stat-icon"><i class="bi bi-exclamation-triangle"></i></div>
            <div class="stat-info">
                <h3><?= $totalRusak ?></h3>
                <p>Kondisi Rusak</p>
            </div>
        </div>
    </div>
</div>

<div class="card-modern">
    <div class="card-header-modern d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5><i class="bi bi-clock-history"></i> Barang Terbaru</h5>
        <a href="daftar.php" class="btn btn-primary btn-sm">
            <i class="bi bi-arrow-right"></i> Lihat Semua
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover mb-0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($recentBarang) > 0): ?>
                        <?php while ($b = mysqli_fetch_assoc($recentBarang)): ?>
                            <tr>
                                <td><span class="badge-code"><?= htmlspecialchars($b['kode_barang']) ?></span></td>
                                <td><?= htmlspecialchars($b['nama_barang']) ?></td>
                                <td><?= htmlspecialchars($b['kategori']) ?></td>
                                <td><?= $b['jumlah'] ?></td>
                                <td>
                                    <span class="badge <?= $b['kondisi'] === 'Baik' ? 'badge-baik' : 'badge-rusak' ?>">
                                        <?= htmlspecialchars($b['kondisi']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>