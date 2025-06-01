<?php
$pageTitle = "Data Investasi";
include 'header.php';

// Koneksi database
$conn = new mysqli("localhost", "root", "", "kai");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data investasi
$sql = "SELECT * FROM investasi ORDER BY id ASC";
$result = $conn->query($sql);

$total_jumlah_dana = 0.0;
$total_budget_tahun_2024 = 0.0;
$total_tambahan_dana = 0.0;
$total_total_tahun_2024 = 0.0;
$total_commitment = 0.0;
$total_actual = 0.0;
$total_consumed_budget = 0.0;
$total_available_budget = 0.0;
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Data Investasi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Investasi</li>
            </ol>
        </nav>
    </div>

    <div class="card p-3" style="padding: 30px; margin-bottom: 20px;">
        <div class="col-md">
            <a href="tambah_investasi.php" class="btn btn-success">+ Tambah Data Investasi</a>
        </div>

        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>NO</th>
                    <th>URAIAN</th>
                    <th>WBS</th>
                    <th>LOKASI PENGADAAN</th>
                    <th>VOLUME & SATUAN</th>
                    <th>HARGA SATUAN (Rp)</th>
                    <th>JUMLAH DANA (Rp)</th>
                    <th>BUDGET TAHUN 2024 (Rp)</th>
                    <th>TAMBAHAN DANA (Rp)</th>
                    <th>TOTAL TAHUN 2024 (Rp)</th>
                    <th>COMMITMENT</th>
                    <th>ACTUAL</th>
                    <th>CONSUMED BUDGET</th>
                    <th>AVAILABLE BUDGET</th>
                    <th>PROGRES SAAT INI</th>
                    <th>TANGGAL KONTRAK</th>
                    <th>NO KONTRAK</th>
                    <th>NILAI KONTRAK (Rp)</th>
                    <th>KET</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                    $calculated_jumlah_dana = floatval($row['volume_satuan']) * floatval($row['harga_satuan']);
                    $calculated_total_tahun_2024 = floatval($row['budget_tahun_2024']) + floatval($row['tambahan_dana']);
                    $calculated_consumed_budget = floatval($row['commitment']) + floatval($row['actual']);
                    $calculated_available_budget = $calculated_total_tahun_2024 - $calculated_consumed_budget;

                    $total_jumlah_dana += $calculated_jumlah_dana;
                    $total_budget_tahun_2024 += floatval($row['budget_tahun_2024']);
                    $total_tambahan_dana += floatval($row['tambahan_dana']);
                    $total_total_tahun_2024 += $calculated_total_tahun_2024;
                    $total_commitment += floatval($row['commitment']);
                    $total_actual += floatval($row['actual']);
                    $total_consumed_budget += $calculated_consumed_budget;
                    $total_available_budget += $calculated_available_budget;
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['no']) ?></td>
                    <td class="text-start"><?= htmlspecialchars($row['uraian']) ?></td>
                    <td><?= htmlspecialchars($row['wbs']) ?></td>
                    <td><?= htmlspecialchars($row['lokasi_pengadaan']) ?></td>
                    <td><?= htmlspecialchars($row['volume_satuan']) ?></td>
                    <td class="text-end"><?= number_format($row['harga_satuan'], 2) ?></td>
                    <td class="text-end"><?= number_format($calculated_jumlah_dana, 2) ?></td>
                    <td class="text-end"><?= number_format($row['budget_tahun_2024'], 2) ?></td>
                    <td class="text-end"><?= number_format($row['tambahan_dana'], 2) ?></td>
                    <td class="text-end"><?= number_format($calculated_total_tahun_2024, 2) ?></td>
                    <td class="text-end"><?= number_format($row['commitment'], 2) ?></td>
                    <td class="text-end"><?= number_format($row['actual'], 2) ?></td>
                    <td class="text-end"><?= number_format($calculated_consumed_budget, 2) ?></td>
                    <td class="text-end"><?= number_format($calculated_available_budget, 2) ?></td>
                    <td class="text-start"><?= nl2br(htmlspecialchars($row['progres_saat_ini'])) ?></td>
                    <td><?= htmlspecialchars($row['tanggal_kontrak']) ?></td>
                    <td><?= htmlspecialchars($row['no_kontrak']) ?></td>
                    <td class="text-end"><?= number_format($row['nilai_kontrak'], 2) ?></td>
                    <td class="text-start"><?= nl2br(htmlspecialchars($row['ket'])) ?></td>
                    <td>
                        <a href="edit_investasi.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning mb-1">Edit</a>
                        <a href="hapus_investasi.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin hapus data?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr style="font-weight: bold; background-color: #f0f0f0;">
                    <td colspan="6" class="text-end">Jumlah</td>
                    <td class="text-end"><?= number_format($total_jumlah_dana, 2) ?></td>
                    <td class="text-end"><?= number_format($total_budget_tahun_2024, 2) ?></td>
                    <td class="text-end"><?= number_format($total_tambahan_dana, 2) ?></td>
                    <td class="text-end"><?= number_format($total_total_tahun_2024, 2) ?></td>
                    <td class="text-end"><?= number_format($total_commitment, 2) ?></td>
                    <td class="text-end"><?= number_format($total_actual, 2) ?></td>
                    <td class="text-end"><?= number_format($total_consumed_budget, 2) ?></td>
                    <td class="text-end"><?= number_format($total_available_budget, 2) ?></td>
                    <td colspan="6"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</main>

<?php include 'footer.php'; ?>

<script src="assets/js/sidebar-accordion.js"></script>
<script src="assets/js/main.js"></script>
