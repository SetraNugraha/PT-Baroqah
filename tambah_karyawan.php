<?php 
require_once 'classes/Database.php';

session_start();
// Cek Login
if (!isset($_SESSION["login"])) {
      echo "<script>
            alert('Anda Belum Login ! ');
            document.location.href = 'login.php';
            </script>";
      exit;
}


include "layout/header.php";

$insertKaryawan = new Database();
// cek apakah button tambah diklik
if (isset($_POST["tambah"])) {
      if ($insertKaryawan->createData("karyawan") > 0) {
            echo  "<script>
                  alert('Data Karyawan Berhasil Ditambahkan');
                  document.location.href = 'index.php';
                  </script>";
      } else {
            echo  "<script>
                  alert('Data Karyawan Gagal Ditambahkan !');
                  document.location.href = 'index.php';
                  </script>";
      }
}
?>

<style>
      form,
      input {
            width: 400px;
      }
</style>

<div class="container">
      <h1 class="mt-3" style="display: flex; justify-content: center;">Tambah Data Karyawan</h1>
      <hr>

      <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <form action="" method="post" enctype="multipart/form-data">

                  <div class="mb-3">
                        <label for="nama" class="form-label">Nama Karyawan</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Karyawan" autocomplete="off" required>
                  </div>

                  <div class="mb-3">
                        <label for="nohp" class="form-label">Nomor Handphone</label>
                        <input type="number" class="form-control" id="nohp" name="nohp" placeholder="Nomor Handphone" autocomplete="off" max="999999999999" oninput="limitDigit(this)" required>
                  </div>

                  <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" required>
                  </div>

                  <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <select name="jabatan" id="jabatan" class="form-control" required>
                              <option value="" disabled selected>--- Pilih Jabatan ---</option>
                              <option value="Manager">Manager</option>
                              <option value="Supervisor">Supervisor</option>
                              <option value="Staff">Staff</option>
                        </select>
                  </div>

                  <div class="mb-3">
                        <label for="gaji" class="form-label">Gaji Pokok Karyawan</label>
                        <input type="number" class="form-control" id="gaji" name="gaji" placeholder="Gaji Karyawan" required>
                  </div>

                  <div class="mb-3">
                        <label for="tgl_bergabung" class="form-label">Tanggal Bergabung Karyawan</label>
                        <input type="date" class="form-control" id="tgl_bergabung" name="tgl_bergabung" placeholder="Tanggal Bergabung Karyawan" required>
                  </div>

                  <div class="mb-3">
                        <label for="image" class="form-label">Upload Gambar</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                  </div>

                  <button type="submit" name="tambah" class="btn btn-primary" style="float: right;">Tambah</button>
                  <a href="index.php" class="btn btn-danger">Cancel</a>


            </form>
      </div>


</div>

<?php include "layout/footer.php"; ?>