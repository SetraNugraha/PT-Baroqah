<?php
session_start();
require_once 'classes/Database.php';
// Cek Login
if (!isset($_SESSION["login"])) {
      echo "<script>
            alert('Anda Belum Login ! ');
            document.location.href = 'login.php';
            </script>";
      exit;
}

include "layout/header.php";

$insertGaji = new Database();
// cek apakah button tambah diklik
if (isset($_POST["tambah_gaji"])) {
      if ($insertGaji->createData("gaji") > 0) {
            $nama = $_POST["nama_karyawan"];
            echo  "<script>
                   alert('Data Gaji $nama Berhasil Ditambahkan');
                   document.location.href = 'gaji.php';
                  </script>";
      } else {
            $nama = $_POST["nama_karyawan"];
            echo  "<script>
                   alert('Data Gaji Gagal Ditambahkan / Tidak Terdapat Karyawan Dengan Nama $nama');
                   document.location.href = 'gaji.php';
                  </script>";
      }
}
?>

<style>
      form,
      input {
            width: 400px;
      }

      .input-readonly {
            border-width: 1px;
            border-color: black;
            background-color: #C0C0C0;

      }
</style>

<div class="container">
      <h1 class="mt-3" style="display: flex; justify-content: center;">Tambah Data Gaji Karyawan</h1>
      <hr>

      <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <form action="" method="post">
                  <div class="mb-3">
                        <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                        <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" required>
                  </div>

                  <div class="mb-3">
                        <label for="jabatan_karyawan" class="form-label" hidden>Jabatan Karyawan</label>
                        <input type="text" class="form-control input-readonly" id="jabatan_karyawan" name="jabatan_karyawan" hidden disabled readonly>
                  </div>

                  <div class="mb-3">
                        <label for="gaji_pokok" class="form-label" hidden>Gaji Pokok</label>
                        <input type="number" class="form-control input-readonly" id="gaji_pokok" name="gaji_pokok" hidden disabled readonly>
                  </div>

                  <div class="mb-3">
                        <label for="bonus" class="form-label" hidden>Bonus</label>
                        <input type="number" class="form-control input-readonly" id="bonus" name="bonus" hidden disabled readonly>
                  </div>

                  <div class="mb-3">
                        <label for="pph" class="form-label" hidden>PPH</label>
                        <input type="number" class="form-control input-readonly" id="pph" name="pph" hidden disabled readonly>
                  </div>

                  <div class="mb-3">
                        <label for="total_gaji" class="form-label" hidden>Total Gaji</label>
                        <input type="number" class="form-control input-readonly" id="total_gaji" name="total_gaji" hidden disabled readonly>
                  </div>

                  <div class="mb-3">
                        <label for="tgl_gajian" class="form-label">Tanggal Gajian Karyawan</label>
                        <input type="date" class="form-control" id="tgl_gajian" name="tgl_gajian" placeholder="Tanggal Bergabung Karyawan" required>
                  </div>

                  <button type="submit" name="tambah_gaji" class="btn btn-primary" style="float: right;">Tambah</button>
                  <a href="gaji.php" class="btn btn-danger">Cancel</a>


            </form>
      </div>


</div>


<?php include "layout/footer.php"; ?>