<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styles.css">
  <title>Beasiswa</title>
</head>

<body>
  <!-- Navbar baru dengan desain modern -->
  <nav class="navbar navbar-expand-lg sticky-top bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary" href="index.php">
        <i class="fas fa-graduation-cap me-2"></i>
        Portal Beasiswa JWD Ujikom
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active fw-bold' : ''; ?>" href="index.php">
              <i class="fas fa-home me-1"></i> Beranda
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'form-beasiswa.php' ? 'active fw-bold' : ''; ?>" href="form-beasiswa.php">
              <i class="fas fa-edit me-1"></i> Daftar
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'registration-beasiswa.php' ? 'active fw-bold' : ''; ?>" href="registration-beasiswa.php">
              <i class="fas fa-list-alt me-1"></i> Hasil
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Container utama dengan padding top -->
  <div class="container py-4">
    <div class="bg-white rounded-4 shadow-sm p-4">
      <!-- Konten halaman -->
      <div class="section-menu">
        <h3 class="mb-4 text-primary">Jenis Beasiswa</h3>
        <p>Beasiswa kuliah merupakan bantuan biaya pendidikan yang diberikan kepada mahasiswa berprestasi atau yang membutuhkan, agar mereka dapat melanjutkan studi ke jenjang yang lebih tinggi. Ada berbagai jenis beasiswa dengan persyaratan yang berbeda-beda.
        </p>
        <ul>
          <!-- Beasiswa Akademik -->
          <li>
            <h5>Beasiswa Akademik</h5>
            <p>Beasiswa akademik diberikan kepada mahasiswa yang memiliki prestasi akademik yang sangat baik. Biasanya, persyaratan yang harus dipenuhi adalah:</p>
            <ul>
              <li>
                <span>Transkrip nilai: Bukti perolehan nilai yang tinggi selama menempuh pendidikan sebelumnya.</span>
              </li>
              <li>
                <span>Pas foto: Foto terbaru dengan ukuran sesuai ketentuan.</span>
              </li>
              <li>
                <span>Surat keterangan prestasi akademik: Dokumen resmi yang menyatakan prestasi akademik yang pernah diraih, misalnya peringkat kelas, juara olimpiade, atau publikasi ilmiah.</span>
              </li>
            </ul>
            <a class="btn btn-primary my-large-btn my-2" href="form-beasiswa.php?jenis_beasiswa=akademik">Daftar Sekarang</a>
          </li>
          <hr />
          <!-- Beasiswa Non Akademik -->
          <li>
            <h5>Beasiswa Non Akademik</h5>
            <p>Beasiswa non-akademik diberikan kepada mahasiswa yang memiliki prestasi di bidang di luar akademik, seperti olahraga, seni, atau kegiatan sosial. Persyaratan yang umumnya dibutuhkan adalah: </p>
            <ul>
              <li>
                <span>Transkrip nilai: Sebagai bukti bahwa calon penerima beasiswa juga memiliki kemampuan akademik yang memadai.</span>
              </li>
              <li>
                <span>Pas foto: Foto terbaru dengan ukuran sesuai ketentuan.</span>
              </li>
              <li>
                <span>Bukti prestasi non-akademik: Dokumen yang menunjukkan prestasi di bidang non-akademik, misalnya sertifikat kejuaraan, portofolio karya seni, atau surat rekomendasi dari pembina kegiatan.</span>
              </li>
              <li>
                <span>Surat Keterangan Tidak Mampu (SKTM): Bagi calon penerima beasiswa yang berasal dari keluarga kurang mampu, SKTM dapat menjadi salah satu persyaratan yang wajib dipenuhi. </span>
              </li>
            </ul>
            <a class="btn btn-primary my-large-btn my-2" href="form-beasiswa.php?jenis_beasiswa=non_akademik">Daftar Sekarang</a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <footer class="bg-primary text-white py-4 mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h5 class="fw-bold mb-3">Portal Beasiswa JWD</h5>
          <p class="mb-0">Ujian Kompetensi Junior Web Developer</p>
        </div>
        <div class="col-md-6 text-md-end">
          <div class="d-flex flex-column">
            <p class="mb-1 fw-bold">Dikembangkan oleh:</p>
            <p class="mb-1">Irfan Sabrian</p>
            <p class="mb-0 text-light">NIM: 3202216097</p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Tambahkan Font Awesome untuk ikon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Bootstrap JS dan dependencies -->
  <script src="js/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- Script JavaScript -->
  <script src="js/function-form.js"></script>

</body>

</html>