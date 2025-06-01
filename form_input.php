<?php
$pageTitle = "Input Data Laporan";
include 'header.php';
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Input Data Laporan</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Form Input</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Form Input Data Laporan</h5>

        <form action="simpan.php" method="POST" class="needs-validation" novalidate>
          <div class="row mb-3">
            <label for="kode" class="col-sm-2 col-form-label">Kode</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="kode" name="kode" required>
              <div class="invalid-feedback">Kode wajib diisi.</div>
            </div>
          </div>
          <div class="row mb-3">
            <label for="uraian" class="col-sm-2 col-form-label">Uraian</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="uraian" name="uraian" required>
              <div class="invalid-feedback">Uraian wajib diisi.</div>
            </div>
          </div>
          <div class="row mb-3">
            <label for="parent_id" class="col-sm-2 col-form-label">Parent ID</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="parent_id" name="parent_id">
            </div>
          </div>
          <div class="row mb-3">
            <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
            <div class="col-sm-10">
              <select class="form-select" id="kategori" name="kategori" required>
                <option value="">Pilih kategori</option>
                <option value="pendapatan">Pendapatan</option>
                <option value="beban">Beban</option>
                <option value="laba">Laba (Rugi) Usaha</option>
                <option value="pajak">Pendapatan (Beban) Lain-lain</option>
                <option value="pajak">Laba (Rugi) Sebelum Pajak Penghasilan</option>
                <option value="pajak">Pajak Penghasilan</option>
                <option value="pajak">Laba (Rugi) Bersih Tahun Berjalan</option>
                <option value="pajak">Kepentingan Non Pengendali</option>
                <option value="lainnya">Lainnya</option>
              </select>
              <div class="invalid-feedback">Kategori wajib dipilih.</div>
            </div>
          </div>

          <h4>Data Nilai Bulanan</h4>
          <div class="row mb-3">
            <label for="bulan" class="col-sm-2 col-form-label">Bulan</label>
            <div class="col-sm-10">
              <select class="form-select" id="bulan" name="bulan" required>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                  <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
              </select>
              <div class="invalid-feedback">Bulan wajib dipilih.</div>
            </div>
          </div>
          <div class="row mb-3">
            <label for="tahun" class="col-sm-2 col-form-label">Tahun</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="tahun" name="tahun" value="<?= date('Y') ?>" required>
              <div class="invalid-feedback">Tahun wajib diisi.</div>
            </div>
          </div>
          <div class="row mb-3">
            <label for="realisasi" class="col-sm-2 col-form-label">Realisasi</label>
            <div class="col-sm-10">
              <input type="number" step="any" class="form-control" id="realisasi" name="realisasi" required>
              <div class="invalid-feedback">Realisasi wajib diisi.</div>
            </div>
          </div>
          <div class="row mb-3">
            <label for="anggaran" class="col-sm-2 col-form-label">Anggaran</label>
            <div class="col-sm-10">
              <input type="number" step="any" class="form-control" id="anggaran" name="anggaran" required>
              <div class="invalid-feedback">Anggaran wajib diisi.</div>
            </div>
          </div>
          <div class="row mb-3">
            <label for="anggaran_tahun" class="col-sm-2 col-form-label">Anggaran Tahun</label>
            <div class="col-sm-10">
              <input type="number" step="any" class="form-control" id="anggaran_tahun" name="anggaran_tahun" required>
              <div class="invalid-feedback">Anggaran Tahun wajib diisi.</div>
            </div>
          </div>
          <div class="row mb-3">
            <label for="ach" class="col-sm-2 col-form-label">% Ach</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" class="form-control" id="ach" name="ach" required>
              <div class="invalid-feedback">% Ach wajib diisi.</div>
            </div>
          </div>
          <div class="row mb-3">
            <label for="growth" class="col-sm-2 col-form-label">% Growth</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" class="form-control" id="growth" name="growth" required>
              <div class="invalid-feedback">% Growth wajib diisi.</div>
            </div>
          </div>
          <div class="row mb-3">
            <label for="ach_lalu" class="col-sm-2 col-form-label">% Ach Lalu</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" class="form-control" id="ach_lalu" name="ach_lalu" required>
              <div class="invalid-feedback">% Ach Lalu wajib diisi.</div>
            </div>
          </div>
          <div class="row mb-3">
            <label for="analisis_vertical" class="col-sm-2 col-form-label">Analisis Vertical</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" class="form-control" id="analisis_vertical" name="analisis_vertical" required>
              <div class="invalid-feedback">Analisis Vertical wajib diisi.</div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

      </div>
    </div>
  </section>
</main>

<script src="assets/js/main.js"></script>

<?php include 'footer.php'; ?>
