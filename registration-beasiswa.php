<?php
include_once("connection.php");

$hasil = mysqli_query($conn, "SELECT * FROM daftar_mahasiswa");

// Inisialisasi statistik
$total_mahasiswa = 0;
$jumlah_akademik = 0;
$jumlah_non_akademik = 0;
$jumlah_per_semester = array_fill(1, 8, 0); // Asumsi 8 semester

// Mengumpulkan data
while ($data_mahasiswa = mysqli_fetch_array($hasil)) {
  $total_mahasiswa++;

  if ($data_mahasiswa['beasiswa'] == 'Akademik') {
    $jumlah_akademik++;
  } else {
    $jumlah_non_akademik++;
  }

  $semester = intval($data_mahasiswa['semester']);
  if ($semester >= 1 && $semester <= 8) {
    $jumlah_per_semester[$semester]++;
  }
}

// Menyiapkan data untuk grafik
$label_semester = json_encode(array_keys($jumlah_per_semester));
$data_semester = json_encode(array_values($jumlah_per_semester));
$label_beasiswa = json_encode(['Akademik', 'Non-Akademik']);
$data_beasiswa = json_encode([$jumlah_akademik, $jumlah_non_akademik]);

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
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
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
          <li class="nav-item">
            <a class="nav-link active fw-bold" href="registration-beasiswa.php">
              <i class="fas fa-list-alt me-1"></i> Hasil
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Container utama -->
  <div class="container py-4">
    <!-- Bagian statistik -->
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
      <h4 class="mb-4 text-primary">Statistik Pendaftaran</h4>
      <div class="row">
        <!-- Kolom kiri: Statistik -->
        <div class="col-md-4">
          <div class="card border-0">
            <div class="card-body">
              <p><strong>Total Mahasiswa yang Mendaftar:</strong> <?php echo $total_mahasiswa; ?></p>
              <p><strong>Pemilihan Beasiswa:</strong></p>
              <ul class="list-unstyled ps-3">
                <li>Akademik: <?php echo $jumlah_akademik; ?> mahasiswa</li>
                <li>Non-Akademik: <?php echo $jumlah_non_akademik; ?> mahasiswa</li>
              </ul>
              <p><strong>Jumlah Mahasiswa per Semester:</strong></p>
              <ul class="list-unstyled ps-3">
                <?php
                foreach ($jumlah_per_semester as $semester => $jumlah) {
                  if ($jumlah > 0) {
                    echo "<li>Semester $semester: $jumlah mahasiswa</li>";
                  }
                }
                ?>
              </ul>
            </div>
          </div>
        </div>

        <!-- Kolom kanan: Grafik -->
        <div class="col-md-8">
          <div class="row">
            <!-- Grafik Batang Semester -->
            <div class="col-12 mb-4">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title">Mahasiswa per Semester</h5>
                  <div style="height: 200px"> <!-- Mengatur tinggi grafik -->
                    <canvas id="grafikBarSemester"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <!-- Grafik Pie Beasiswa -->
            <div class="col-12">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title">Distribusi Beasiswa</h5>
                  <div style="height: 200px"> <!-- Mengatur tinggi grafik -->
                    <canvas id="grafikPieBeasiswa"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Daftar pendaftar -->
    <div class="bg-white rounded-4 shadow-sm p-4">
      <h4 class="mb-4 text-primary">Daftar Pendaftar</h4>
      <div class="table-responsive">
        <table class="table table-hover align-middle border" id="tabelPendaftar">
          <thead>
            <tr class="text-center" style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
              <th class="px-3 border">Nama</th>
              <th class="px-3 border">Email</th>
              <th class="px-3 border">Handphone</th>
              <th class="px-3 border">Semester</th>
              <th class="px-3 border">IPK</th>
              <th class="px-3 border">Beasiswa</th>
              <th class="px-3 border">Status</th>
              <th class="px-3 border">Berkas</th>
              <th class="px-3 border">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($data_mahasiswa = mysqli_fetch_array($hasil)) { ?>
              <tr class="align-middle">
                <td class="fw-semibold border"><?php echo $data_mahasiswa['nama']; ?></td>
                <td class="border">
                  <a href="mailto:<?php echo $data_mahasiswa['email']; ?>" class="text-decoration-none text-muted">
                    <i class="fas fa-envelope me-1"></i>
                    <?php echo $data_mahasiswa['email']; ?>
                  </a>
                </td>
                <td class="border">
                  <a href="tel:<?php echo $data_mahasiswa['hp']; ?>" class="text-decoration-none text-muted">
                    <i class="fas fa-phone me-1"></i>
                    <?php echo $data_mahasiswa['hp']; ?>
                  </a>
                </td>
                <td class="text-center border">
                  <span class="badge text-dark border" style="background-color: #f8f9fa;">
                    Semester <?php echo $data_mahasiswa['semester']; ?>
                  </span>
                </td>
                <td class="text-center fw-bold border">
                  <?php
                  $ipk = floatval($data_mahasiswa['ipk']);
                  $ipk_class = 'text-success';
                  echo "<span class='$ipk_class'>" . $data_mahasiswa['ipk'] . "</span>";
                  ?>
                </td>
                <td class="text-center border">
                  <?php
                  $beasiswa_class = $data_mahasiswa['beasiswa'] == 'Akademik' ? 'border-primary text-primary' : 'border-secondary text-secondary';
                  echo "<span class='badge border $beasiswa_class' style='background-color: transparent'>" .
                    $data_mahasiswa['beasiswa'] . "</span>";
                  ?>
                </td>
                <td class="text-center border">
                  <?php
                  $status = $data_mahasiswa['status'];
                  if ($status == 'Diverifikasi') {
                    echo "<span class='badge border border-success text-success' style='background-color: transparent'>
                            <i class='fas fa-check-circle me-1'></i>$status
                          </span>";
                  } else {
                    echo "<span class='badge border border-danger text-danger' style='background-color: transparent'>
                            <i class='fas fa-clock me-1'></i>$status
                          </span>";
                  }
                  ?>
                </td>
                <td class="text-center border">
                  <button type="button"
                    class="btn btn-sm btn-light border"
                    data-bs-toggle="modal"
                    data-bs-target="#berkasModal<?php echo $data_mahasiswa['id']; ?>">
                    <i class="fas fa-file me-1"></i>Lihat
                  </button>
                </td>
                <td class="text-center border">
                  <?php if ($data_mahasiswa['status'] == 'Belum Diverifikasi') { ?>
                    <button type="button"
                      class="btn btn-sm btn-success verify-btn"
                      data-id="<?php echo $data_mahasiswa['id']; ?>"
                      onclick="verifikasiStatus(<?php echo $data_mahasiswa['id']; ?>)">
                      <i class="fas fa-check me-1"></i>Verifikasi
                    </button>
                  <?php } else { ?>
                    <button type="button" class="btn btn-sm btn-secondary" disabled>
                      <i class="fas fa-check-circle me-1"></i>Terverifikasi
                    </button>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal-modal dipindahkan ke sini -->
  <?php
  // Reset pointer hasil query
  mysqli_data_seek($hasil, 0);
  while ($data_mahasiswa = mysqli_fetch_array($hasil)) {
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
            <img src="uploads/<?php echo $data_mahasiswa['berkas']; ?>"
              alt="Berkas <?php echo $data_mahasiswa['nama']; ?>"
              class="img-fluid rounded-3 shadow">
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

  <!-- Scripts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

  <!-- Inisialisasi script Chart -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const colors = {
        primary: 'rgba(54, 162, 235, 0.8)',
        secondary: 'rgba(255, 99, 132, 0.8)',
        border: 'rgba(54, 162, 235, 1)'
      };

      // Grafik Batang Semester
      const ctxSemester = document.getElementById('grafikBarSemester');
      if (ctxSemester) {
        const semesterLabels = JSON.parse('<?php echo $label_semester; ?>');
        const semesterData = JSON.parse('<?php echo $data_semester; ?>');

        new Chart(ctxSemester, {
          type: 'bar',
          data: {
            labels: semesterLabels.map(sem => 'Semester ' + sem),
            datasets: [{
              label: 'Jumlah Mahasiswa',
              data: semesterData,
              backgroundColor: colors.primary,
              borderColor: colors.border,
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  stepSize: 1
                }
              }
            },
            plugins: {
              legend: {
                display: false
              }
            }
          }
        });
      }

      // Grafik Pie Beasiswa
      const ctxBeasiswa = document.getElementById('grafikPieBeasiswa');
      if (ctxBeasiswa) {
        const beasiswaLabels = JSON.parse('<?php echo $label_beasiswa; ?>');
        const beasiswaData = JSON.parse('<?php echo $data_beasiswa; ?>');

        new Chart(ctxBeasiswa, {
          type: 'doughnut',
          data: {
            labels: beasiswaLabels,
            datasets: [{
              data: beasiswaData,
              backgroundColor: [colors.primary, colors.secondary],
              borderColor: 'white',
              borderWidth: 2
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'right',
                labels: {
                  padding: 20,
                  font: {
                    size: 12
                  }
                }
              }
            }
          }
        });
      }
    });
  </script>

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
  <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Verifikasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin memverifikasi mahasiswa ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="confirmVerify">Ya, Verifikasi</button>
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