<?php
session_start();
require_once 'Controller/KaryawanController.php';
require_once 'Controller/UserController.php';
require_once 'layout/header.php';

// Cek Login
if (!isset($_SESSION["login"])) {
      echo "<script>
            alert('Anda Belum Login ! ');
            document.location.href = 'login.php';
            </script>";
      exit;
}

$karyawan = new Karyawan();
$stmt = $karyawan->pdo->prepare("SELECT k.nama, k.nohp, k.alamat, k.jabatan, k.tgl_bergabung, k.image, g.total_gaji FROM karyawan k INNER JOIN gaji g ON k.nama = g.nama_karyawan");

$stmt->execute();
?>

<link rel="stylesheet" href="css/cardKaryawan.css">
<div class="container-menu-card">

      <?php foreach ($stmt as $result) : ?>
            <div class="container-card">

                  <!-- Header -->
                  <div class="header">
                        <div class="container-picture">
                              <img src="img/employee/<?= $result['image'] ?>" alt="" class="profile-picture">
                        </div>
                        <div class="employee-name">
                              <p><?= $result['jabatan'] ?></p>
                              <h5>Employee Name</h5>
                              <h6><?= $result['nama'] ?></h6>
                        </div>
                  </div>

                  <!-- Horizontal Line -->
                  <hr class="horizontal-line">

                  <!-- Detail Information -->
                  <div class="detail-card">
                        <table class="table">
                              <tr>
                                    <td class="left">No Handphone</td>
                                    <td>:</td>
                                    <td class="right"><?= $result['nohp'] ?></td>
                              </tr>

                              <tr>
                                    <td class="left">Join Date</td>
                                    <td>:</td>
                                    <td class="right"><?= $result['tgl_bergabung'] ?></td>
                              </tr>

                              <tr>
                                    <td class="left">Sallary</td>
                                    <td>:</td>
                                    <td class="right"><?php if ($result['total_gaji'] == NULL) {
                                                            echo "Tidak terdapat Gaji";
                                                      } else {
                                                            echo "Rp. " . number_format($result['total_gaji'], 0, ',', '.');
                                                      } ?> </td>
                              </tr>

                              <tr>
                                    <td class="left">Address</td>
                                    <td>:</td>
                                    <td class="right"><?= $result['alamat'] ?></td>
                              </tr>
                        </table>
                  </div>

                  <!-- Footer -->
                  <div class="footer">
                        <div class="line"></div>
                        <h6>PT. Baroqah</h6>
                        <div class="line"></div>
                  </div>
            </div>
      <?php endforeach; ?>
</div>

<?php require_once 'layout/footer.php' ?>