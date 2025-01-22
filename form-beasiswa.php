<?php
include_once("connection.php");
$result = mysqli_query($conn, "SELECT * FROM daftar_mahasiswa");

// Mengambil jenis beasiswa dari parameter URL, default ke "Pilih Beasiswa" jika tidak ada
$jenis_beasiswa = isset($_GET['jenis_beasiswa']) ? $_GET['jenis_beasiswa'] : "Pilih Beasiswa";

// Fungsi untuk menandai opsi beasiswa yang dipilih
function SetBeasiswa($actual_beasiswa, $reference_beasiswa)
{
  return ($actual_beasiswa == $reference_beasiswa) ? "selected" : "";
}

// Fungsi untuk menonaktifkan komponen form jika IPK kurang dari 3
function SetDisable($ipk)
{
  return ($ipk < 3) ? "disabled" : "";
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Form Pendaftaran Beasiswa</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styles.css">
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
            <a class="nav-link active fw-bold" href="form-beasiswa.php">
              <i class="fas fa-edit me-1"></i> Daftar
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="registration-beasiswa.php">
              <i class="fas fa-list-alt me-1"></i> Hasil
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Container utama -->
  <div class="container py-4">
    <div class="bg-white rounded-4 shadow-sm p-4">
      <h4 class="mb-4 text-primary">Form Pendaftaran Beasiswa</h4>

      <!-- Warning Modal untuk IPK -->
      <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="warningModalLabel">Peringatan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Mohon maaf, IPK anda tidak mencukupi untuk mendaftar beasiswa
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Warning Modal untuk Email -->
      <div class="modal fade" id="WarningModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <h3>Email Tidak Teridentifikasi</h3>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <form action="backend/process-registration.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="mb-3 row">
          <label for="inputNama" class="col-sm-3 col-form-label">Nama Lengkap</label>
          <div class="col-sm-9">
            <input type="text" class="form-control w-100" id="inputNama" name="nama" placeholder="Masukkan nama lengkap" required>
          </div>
        </div>

        <div class="mb-3 row">
          <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
          <div class="col-sm-9">
            <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Masukkan email anda" required>
          </div>
        </div>

        <div class="mb-3 row">
          <label for="hp" class="col-sm-3 col-form-label">Nomor HP</label>
          <div class="col-sm-9">
            <input type="number" class="form-control" id="hp" name="hp" placeholder="Masukkan nomor HP" required>
          </div>
        </div>

        <div class="mb-3 row">
          <label for="semester" class="col-sm-3 col-form-label">Semester</label>
          <div class="col-sm-9">
            <select class="form-select" name="semester" id="semester" required onchange="validateSelect(this)">
              <option value="" disabled selected>Pilih Semester</option>
              <?php for ($i = 1; $i <= 8; $i++) { ?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php } ?>
            </select>
            <div class="invalid-feedback">Harap pilih semester</div>
          </div>
        </div>

        <div class="mb-3 row">
          <label for="inputIpk" class="col-sm-3 col-form-label">IPK</label>
          <div class="col-sm-9">
            <input type="text" class="form-control w-100" id="inputIpk" name="ipk" readonly>
          </div>
        </div>

        <div class="mb-3 row">
          <label for="beasiswa" class="col-sm-3 col-form-label">Pilihan Beasiswa</label>
          <div class="col-sm-9">
            <select class="form-select" name="beasiswa" id="beasiswa" required onchange="validateSelect(this)" disabled>
              <option value="" disabled selected>Pilih Beasiswa</option>
              <option value="Akademik" <?php echo SetBeasiswa($jenis_beasiswa, "akademik") ?>>Akademik</option>
              <option value="Non Akademik" <?php echo SetBeasiswa($jenis_beasiswa, "non_akademik") ?>>Non Akademik</option>
            </select>
            <div class="invalid-feedback">Harap pilih beasiswa</div>
          </div>
        </div>

        <div class="mb-3 row">
          <label class="col-sm-3 col-form-label" for="customfile">Upload Berkas</label>
          <div class="col-sm-9">
            <input type="file" class="form-control" id="customfile" name="berkas" required disabled>
          </div>
        </div>

        <div class="d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-primary" id="tombolDaftar" disabled>
            <i class="fas fa-paper-plane me-2"></i>Daftar
          </button>
          <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-times me-2"></i>Batal
          </a>
        </div>
      </form>
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

  <!-- Scripts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="js/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
  <script src="js/function-form.js"></script>
  <script>
    // Fungsi untuk memvalidasi form
    function validateForm() {
      var email = document.getElementById("inputEmail").value;
      var nama = document.getElementById("inputNama").value;
      var hp = document.getElementById("hp").value;
      var semester = document.getElementById("semester").value;
      var beasiswa = document.getElementById("beasiswa").value;
      var berkas = document.getElementById("customfile").value;

      if (email == "" || nama == "" || hp == "" || semester == "" || beasiswa == "" || berkas == "") {
        alert("Semua field harus diisi!");
        return false;
      }
      return true;
    }

    // Fungsi untuk memvalidasi select
    function validateSelect(selectElement) {
      if (selectElement.value === "") {
        selectElement.classList.add("is-invalid");
      } else {
        selectElement.classList.remove("is-invalid");
      }
    }

    // Event listener untuk semester - tidak perlu generate IPK random
    document.getElementById("semester").addEventListener("change", function() {
      validateSelect(this);
    });

    // Pastikan input nama selalu enabled saat halaman dimuat
    window.onload = function() {
      document.getElementById("inputNama").disabled = false;
    }
  </script>
</body>

</html>