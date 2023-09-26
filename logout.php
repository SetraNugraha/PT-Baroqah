<?php 
session_start();
// Cek Login
if (!isset($_SESSION["login"])) {
      echo "<script>
            alert('Anda Belum Login ! ');
            document.location.href = 'login.php';
            </script>";
      exit;
}

// kosongkan session user
$_SESSION = [];
session_unset();
session_destroy();


header("Location: login.php");
?>