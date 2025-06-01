<?php
include 'header.php';
$conn = new mysqli("localhost", "root", "", "kai");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : date('n');
$tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

if ($id <= 0) {
    echo "ID tidak valid.";
    exit;
}

// Ambil data laporan_keuangan
$sqlLap = $conn->prepare("SELECT * FROM laporan_keuangan WHERE id = ?");
$sqlLap->bind_param("i", $id);
$sqlLap->execute();
$resultLap = $sqlLap->get_result();
if ($resultLap->num_rows == 0) {
    echo "Data laporan tidak ditemukan.";
    exit;
}
$dataLap = $resultLap->fetch_assoc();

// Ambil data laporan_nilai bulan dan tahun yang dipilih
$sqlNilai = $conn->prepare("SELECT * FROM laporan_nilai WHERE laporan_id = ? AND bulan = ? AND tahun = ? LIMIT 1");
$sqlNilai->bind_param("iii", $id, $bulan, $tahun);
$sqlNilai->execute();
$resultNilai = $sqlNilai->get_result();
$dataNilai = $resultNilai->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $kode = $_POST['kode'];
    $uraian = $_POST['uraian'];
    $parent_id = $_POST['parent_id'] ?: null;
    $kategori = $_POST['kategori'];

    $bulanForm = (int)$_POST['bulan'];
    $tahunForm = (int)$_POST['tahun'];

    $realisasi = $_POST['realisasi'] ?: 0;
    $anggaran = $_POST['anggaran'] ?: 0;
    $anggaran_tahun = $_POST['anggaran_tahun'] ?: 0;
    $ach = $_POST['ach'] ?: 0;
    $growth = $_POST['growth'] ?: 0;
    $ach_lalu = $_POST['ach_lalu'] ?: 0;
    $analisis_vertical = $_POST['analisis_vertical'] ?: 0;

    // Update laporan_keuangan
    $sqlUpdateLap = $conn->prepare("UPDATE laporan_keuangan SET kode=?, uraian=?, parent_id=?, kategori=? WHERE id=?");
    $sqlUpdateLap->bind_param("ssisi", $kode, $uraian, $parent_id, $kategori, $id);
    $sqlUpdateLap->execute();

    // Cek apakah data nilai sudah ada
    $sqlCheck = $conn->prepare("SELECT id FROM laporan_nilai WHERE laporan_id = ? AND bulan = ? AND tahun = ? LIMIT 1");
    $sqlCheck->bind_param("iii", $id, $bulanForm, $tahunForm);
    $sqlCheck->execute();
    $resCheck = $sqlCheck->get_result();

    if ($resCheck->num_rows > 0) {
        // Update nilai
        $rowCheck = $resCheck->fetch_assoc();
        $idNilai = $rowCheck['id'];

        $sqlUpdateNilai = $conn->prepare("UPDATE laporan_nilai SET realisasi=?, anggaran=?, anggaran_tahun=?, ach=?, growth=?, ach_lalu=?, analisis_vertical=? WHERE id=?");
        $sqlUpdateNilai->bind_param("dddddddi", $realisasi, $anggaran, $anggaran_tahun, $ach, $growth, $ach_lalu, $analisis_vertical, $idNilai);
        $sqlUpdateNilai->execute();
    } else {
        // Insert nilai baru
        $sqlInsertNilai = $conn->prepare("INSERT INTO laporan_nilai (laporan_id, bulan, tahun, realisasi, anggaran, anggaran_tahun, ach, growth, ach_lalu, analisis_vertical) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $sqlInsertNilai->bind_param("iiiddddddd", $id, $bulanForm, $tahunForm, $realisasi, $anggaran, $anggaran_tahun, $ach, $growth, $ach_lalu, $analisis_vertical);
        $sqlInsertNilai->execute();
    }

    echo "<div class='alert alert-success'>Data berhasil diperbarui.</div>";
    echo "<a href='index.php?bulan=$bulanForm&tahun=$tahunForm' class='btn btn-primary'>Kembali ke Laporan</a>";
    include 'footer.php';
    exit;
}

// Ambil daftar parent_id untuk select parent (exclude diri sendiri agar tidak looping)
$parentOptions = $conn->query("SELECT id, kode, uraian FROM laporan_keuangan WHERE id != $id ORDER BY kode ASC");

?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Edit Laporan</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="tampil_laporan.php">Tampil Laporan</a></li>
        <li class="breadcrumb-item active">Edit Laporan</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card" style="padding: 20px;">
      <div class="card-body" style="padding: 10px 20px;">

        <form method="POST" action="" class="needs-validation" novalidate>
          <div class="row mb-3">
            <label for="kode" class="col-sm-2 col-form-label">Kode</label>
            <div class="col-sm-10">
              <input type="text" id="kode" name="kode" class="form-control" value="<?= htmlspecialchars($dataLap['kode']) ?>" required>
              <div class="invalid-feedback">Kode wajib diisi.</div>
            </div>
          </div>

          <div class="row mb-3">
            <label for="uraian" class="col-sm-2 col-form-label">Uraian</label>
            <div class="col-sm-10">
              <input type="text" id="uraian" name="uraian" class="form-control" value="<?= htmlspecialchars($dataLap['uraian']) ?>" required>
              <div class="invalid-feedback">Uraian wajib diisi.</div>
            </div>
          </div>

          <div class="row mb-3">
            <label for="parent_id" class="col-sm-2 col-form-label">Parent</label>
            <div class="col-sm-10">
              <select id="parent_id" name="parent_id" class="form-select">
                <option value="">-- Tidak Ada (Induk) --</option>
                <?php
                while ($p = $parentOptions->fetch_assoc()) {
                    $selected = ($dataLap['parent_id'] == $p['id']) ? "selected" : "";
                    echo "<option value='" . $p['id'] . "' $selected>" . htmlspecialchars($p['kode'] . " " . $p['uraian']) . "</option>";
                }
                ?>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
            <div class="col-sm-10">
              <select id="kategori" name="kategori" class="form-select" required>
                <?php
                $kats = ['pendapatan', 'beban', 'laba', 'pajak', 'lainnya'];
                foreach ($kats as $k) {
                    $selected = ($dataLap['kategori'] == $k) ? "selected" : "";
                    echo "<option value='$k' $selected>" . ucfirst($k) . "</option>";
                }
                ?>
              </select>
              <div class="invalid-feedback">Kategori wajib dipilih.</div>
            </div>
          </div>

          <hr>

          <h5>Nilai Bulanan (Bulan <?= $bulan ?> Tahun <?= $tahun ?>)</h5>

          <input type="hidden" name="bulan" value="<?= $bulan ?>">
          <input type="hidden" name="tahun" value="<?= $tahun ?>">

          <div class="row mb-3">
            <label for="realisasi" class="col-sm-2 col-form-label">Realisasi</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" id="realisasi" name="realisasi" class="form-control" value="<?= htmlspecialchars($dataNilai['realisasi'] ?? 0) ?>">
            </div>
          </div>

          <div class="row mb-3">
            <label for="anggaran" class="col-sm-2 col-form-label">Anggaran</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" id="anggaran" name="anggaran" class="form-control" value="<?= htmlspecialchars($dataNilai['anggaran'] ?? 0) ?>">
            </div>
          </div>

          <div class="row mb-3">
            <label for="anggaran_tahun" class="col-sm-2 col-form-label">Anggaran Tahun</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" id="anggaran_tahun" name="anggaran_tahun" class="form-control" value="<?= htmlspecialchars($dataNilai['anggaran_tahun'] ?? 0) ?>">
            </div>
          </div>

          <div class="row mb-3">
            <label for="ach" class="col-sm-2 col-form-label">% Ach</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" id="ach" name="ach" class="form-control" value="<?= htmlspecialchars($dataNilai['ach'] ?? 0) ?>">
            </div>
          </div>

          <div class="row mb-3">
            <label for="growth" class="col-sm-2 col-form-label">% Growth</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" id="growth" name="growth" class="form-control" value="<?= htmlspecialchars($dataNilai['growth'] ?? 0) ?>">
            </div>
          </div>

          <div class="row mb-3">
            <label for="ach_lalu" class="col-sm-2 col-form-label">% Ach (lalu)</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" id="ach_lalu" name="ach_lalu" class="form-control" value="<?= htmlspecialchars($dataNilai['ach_lalu'] ?? 0) ?>">
            </div>
          </div>

          <div class="row mb-3">
            <label for="analisis_vertical" class="col-sm-2 col-form-label">Analisis Vertical</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" id="analisis_vertical" name="analisis_vertical" class="form-control" value="<?= htmlspecialchars($dataNilai['analisis_vertical'] ?? 0) ?>">
            </div>
          </div>

          <button type="submit" class="btn btn-success">Simpan Perubahan</button>
          <a href="index.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="btn btn-secondary">Batal</a>
        </form>

      </div>
    </div>
  </section>
</main>

<script src="assets/js/main.js"></script>

<?php include 'footer.php'; ?>
