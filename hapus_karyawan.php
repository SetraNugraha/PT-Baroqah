<?php 
session_start();
require_once 'Controller/KaryawanController.php';
require_once 'Controller/UserController.php';

// Cek Login
if (!isset($_SESSION["login"])) {
      echo "<script>
            alert('Anda Belum Login ! ');
            document.location.href = 'login.php';
            </script>";
      exit;
}

$karyawan = new Karyawan();
// mengambil id karyawan dari URL
$id_karyawan = (int)$_GET["id_karyawan"];
// $result = $karyawan->readDataSingle("karyawan", $id_karyawan);

if($karyawan->deleteData("karyawan", "id_karyawan", $id_karyawan)->rowCount() > 0) {
      echo "<script>
            alert('Data Karyawan Berhasil Dihapus !');
            document.location.href = 'index.php';
            </script>";
} else {
      echo "<script>
            alert('Data Karyawan Gagal Dihapus !');
            document.location.href = 'index.php';
            </script>";
}

?>