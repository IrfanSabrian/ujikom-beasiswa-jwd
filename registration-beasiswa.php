<?php
include_once("connection.php");

$hasil = mysqli_query($conn, "SELECT * FROM daftar_mahasiswa");

// Reset
mysqli_data_seek($hasil, 0);

?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
  <title>Daftar Pendaftar</title>
</head>

<body>
  <!-- Navbar modern -->
  <nav class="navbar navbar-expand-lg sticky-top bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary" href="index.php">
        <i class="fas fa-graduation-cap me-2"></i>
        Portal Beasiswa JWD Ujikom
      </a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="fas fa-home me-1"></i> Beranda
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="form-beasiswa.php">
              <i class="fas fa-edit me-1"></i> Daftar
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Container utama -->
  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <!-- Card pendaftaran -->
        <div class="bg-white rounded-4 shadow-sm p-4">
          <div class="text-center mb-4">
            <h4 class="text-primary">Data Pendaftaran Berhasil</h4>
          </div>

          <?php
          $query = "SELECT * FROM daftar_mahasiswa ORDER BY id DESC LIMIT 1";
          $result = mysqli_query($conn, $query);
          $data_mahasiswa = mysqli_fetch_array($result);

          if ($data_mahasiswa) { ?>
            <!-- Status Pendaftaran -->
            <div class="text-center mb-4">
              <?php
              $status = $data_mahasiswa['status'];
              if ($status == 'Diverifikasi') {
                echo "<div class='badge bg-success-subtle text-success px-4 py-2 rounded-pill'>
                                    <i class='fas fa-check-circle me-1'></i>$status
                                  </div>";
              } else {
                echo "<div class='badge bg-warning-subtle text-warning px-4 py-2 rounded-pill'>
                                    <i class='fas fa-clock me-1'></i>Menunggu Verifikasi
                                  </div>";
              }
              ?>
            </div>

            <!-- Informasi Pribadi -->
            <div class="card border-0 bg-light mb-4">
              <div class="card-body p-4">
                <h6 class="text-primary mb-3">Informasi Pribadi</h6>
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="d-flex align-items-center">
                      <i class="fas fa-user text-muted me-3"></i>
                      <div>
                        <small class="text-muted d-block">Nama Lengkap</small>
                        <strong><?php echo $data_mahasiswa['nama']; ?></strong>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="d-flex align-items-center">
                      <i class="fas fa-envelope text-muted me-3"></i>
                      <div>
                        <small class="text-muted d-block">Email</small>
                        <strong><?php echo $data_mahasiswa['email']; ?></strong>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="d-flex align-items-center">
                      <i class="fas fa-phone text-muted me-3"></i>
                      <div>
                        <small class="text-muted d-block">Nomor HP</small>
                        <strong><?php echo $data_mahasiswa['hp']; ?></strong>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="d-flex align-items-center">
                      <i class="fas fa-graduation-cap text-muted me-3"></i>
                      <div>
                        <small class="text-muted d-block">Semester</small>
                        <strong>Semester <?php echo $data_mahasiswa['semester']; ?></strong>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Informasi Beasiswa -->
            <div class="card border-0 bg-light">
              <div class="card-body p-4">
                <h6 class="text-primary mb-3">Detail Beasiswa</h6>
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="d-flex align-items-center">
                      <i class="fas fa-medal text-muted me-3"></i>
                      <div>
                        <small class="text-muted d-block">IPK</small>
                        <strong class="text-success"><?php echo $data_mahasiswa['ipk']; ?></strong>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="d-flex align-items-center">
                      <i class="fas fa-award text-muted me-3"></i>
                      <div>
                        <small class="text-muted d-block">Jenis Beasiswa</small>
                        <strong><?php echo $data_mahasiswa['beasiswa']; ?></strong>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-flex align-items-center">
                      <i class="fas fa-file-alt text-muted me-3"></i>
                      <div>
                        <small class="text-muted d-block">Berkas Pendaftaran</small>
                        <button type="button"
                          class="btn btn-sm btn-light mt-1"
                          data-bs-toggle="modal"
                          data-bs-target="#berkasModal<?php echo $data_mahasiswa['id']; ?>">
                          <i class="fas fa-eye me-1"></i>Lihat Berkas
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>

          <!-- Tombol kembali -->
          <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary px-4">
              <i class="fas fa-home me-2"></i>Kembali ke Beranda
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal-modal dipindahkan ke sini -->
  <?php
  mysqli_data_seek($hasil, 0);
  while ($data_mahasiswa = mysqli_fetch_array($hasil)) {
    // Dapatkan ekstensi file
    $file_extension = pathinfo($data_mahasiswa['berkas'], PATHINFO_EXTENSION);
  ?>
    <div class="modal fade" id="berkasModal<?php echo $data_mahasiswa['id']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $data_mahasiswa['id']; ?>" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel<?php echo $data_mahasiswa['id']; ?>">
              <i class="fas fa-file me-2"></i>
              Berkas <?php echo $data_mahasiswa['nama']; ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center p-4">
            <?php if (strtolower($file_extension) === 'pdf') { ?>
              <embed src="uploads/<?php echo $data_mahasiswa['berkas']; ?>"
                type="application/pdf"
                width="100%"
                height="600px">
            <?php } else { ?>
              <img src="uploads/<?php echo $data_mahasiswa['berkas']; ?>"
                alt="Berkas <?php echo $data_mahasiswa['nama']; ?>"
                class="img-fluid rounded-3 shadow">
            <?php } ?>
          </div>
          <div class="modal-footer">
            <a href="uploads/<?php echo $data_mahasiswa['berkas']; ?>"
              class="btn btn-primary"
              download>
              <i class="fas fa-download me-2"></i>Unduh Berkas
            </a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="fas fa-times me-2"></i>Tutup
            </button>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <footer class="bg-dark text-white py-4 mt-5">
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
            <p class="mb-0 text-white">NIM: 3202216097</p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

  <!-- Script untuk inisialisasi modal -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Inisialisasi semua modal
      var modals = document.querySelectorAll('.modal');
      modals.forEach(function(modal) {
        new bootstrap.Modal(modal);
      });
    });
  </script>

  <!-- Tambahkan Modal di akhir body sebelum closing tag -->
  <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Verifikasi</h5>
          <button type="button" class="btn-close" onclick="modal.hide()" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin memverifikasi mahasiswa ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="modal.hide()">Batal</button>
          <button type="button" class="btn btn-primary" id="confirmVerify" onclick="modal.hide()">Ya, Verifikasi</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Ubah script verifikasi -->
  <script>
    let selectedId = null;
    const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));

    function verifikasiStatus(id) {
      selectedId = id;
      modal.show();
    }

    document.getElementById('confirmVerify').addEventListener('click', function() {
      if (selectedId) {
        const formData = new FormData();
        formData.append('id', selectedId);

        fetch('backend/verifikasi.php', {
            method: 'POST',
            body: formData
          })
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.text().then(text => {
              try {
                return JSON.parse(text);
              } catch (e) {
                console.error('Error parsing JSON:', text);
                throw new Error('Invalid JSON response');
              }
            });
          })
          .then(data => {
            if (data.success) {
              location.reload();
            } else {
              alert('Gagal memverifikasi: ' + data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memverifikasi status. Silakan coba lagi.');
          });
      }
      modal.hide();
    });
  </script>

</body>

</html>