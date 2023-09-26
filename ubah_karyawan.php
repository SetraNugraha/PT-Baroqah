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

$karyawan = new Database();
// mengambil id_karyawan dari URL
$id_karyawan = (int)$_GET["id_karyawan"];

$result = $karyawan->readDataSingle("karyawan", "id_karyawan", $id_karyawan);

// cek apakah button tambah diklik
if (isset($_POST["ubah"])) {
      if ($result = $karyawan->updateData("karyawan")->rowCount() > 0) {
            echo  "<script>
                alert('Data Karyawan Berhasil Dirubah');
                //document.location.href = 'index.php';
                </script>";
      } else {
            echo  "<script>
                alert('Data Karyawan Gagal Dirubah !');
                //document.location.href = 'index.php';
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
      <h1 class="mt-3" style="display: flex; justify-content: center;">Ubah Data Karyawan</h1>
      <hr>

      <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <form action="" method="post" enctype="multipart/form-data">

                  <input type="hidden" name="id_karyawan" value="<?= $result['id_karyawan']; ?>">


                  <div class="mb-3">
                        <label for="nama" class="form-label">Nama Karyawan</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $result['nama']; ?>" placeholder="Nama Karyawan">
                  </div>

                  <div class="mb-3">
                        <label for="nohp" class="form-label">Nomor Handphone</label>
                        <input type="number" class="form-control" id="nohp" name="nohp" value="<?= $result['nohp']; ?>" placeholder="Nomor Handphone" autocomplete="off" max="999999999999" oninput="limitDigit(this)">
                  </div>

                  <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $result['alamat']; ?>" placeholder="Alamat">
                  </div>

                  <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <select name="jabatan" id="jabatan" class="form-control">
                              <?php $jabatan = $result['jabatan']; ?>
                              <option value="Manager" <?= $jabatan == 'Manager' ? 'selected' : null ?>>Manager</option>
                              <option value="Supervisor" <?= $jabatan == 'Supervisor' ? 'selected' : null ?>>Supervisor</option>
                              <option value="Staff" <?= $jabatan == 'Staff' ? 'selected' : null ?>>Staff</option>
                        </select>

                  </div>

                  <div class="mb-3">
                        <label for="gaji" class="form-label">Gaji Pokok Karyawan</label>
                        <input type="number" class="form-control" id="gaji" name="gaji" value="<?= $result['gaji']; ?>" placeholder="Gaji Pokok Karyawan">
                  </div>

                  <div class="mb-3">
                        <label for="tgl_bergabung" class="form-label">Tanggal Bergabung Karyawan</label>
                        <input type="date" class="form-control" id="tgl_bergabung" name="tgl_bergabung" value="<?= $result['tgl_bergabung']; ?>" placeholder="Tanggal Bergabung Karyawan">
                  </div>

                  <div class="mb-3">
                        <label for="image" class="form-label">Upload Gambar</label>
                        <input type="file" class="form-control" id="image" name="image" value="<?= $result['image']; ?>">
                  </div>

                  <button type="submit" name="ubah" class="btn btn-primary" style="float: right;">Ubah Data</button>
                  <a href="index.php" class="btn btn-danger">Cancel</a>



            </form>
      </div>


</div>

<?php include "layout/footer.php"; ?>