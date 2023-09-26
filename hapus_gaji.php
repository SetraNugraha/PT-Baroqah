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


include "config/app.php";
$gaji = new Database();
// mengambil id gaji dari URL
$id_gaji = (int)$_GET["id_gaji"];

if($gaji->deleteData("gaji", "id_gaji", $id_gaji)->rowCount() > 0) {
      echo "<script>
            alert('Data Gaji Karyawan Berhasil Dihapus !');
            document.location.href = 'gaji.php';
            </script>";
} else {
      echo "<script>
            alert('Data Gaji Karyawan Gagal Dihapus !');
            document.location.href = 'gaji.php';
            </script>";
}

?>