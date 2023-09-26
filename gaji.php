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

// Menampilkan data gaji yang terbaru
// $data_gaji = select("SELECT * FROM gaji ORDER BY id_gaji DESC");
$data_gaji = new Database();

?>

<div class="container">
      <h1 class="mt-3">Data Gaji Karyawan</h1>
      <hr>

      <a href="tambah_gaji.php" class="btn btn-primary mt-3 mb-3">Input Gaji</a>

      <!-- button export pdf -->
      <button id="export-gaji-pdf" class="btn btn-success">Cetak PDF</button>


      <table class="table table-bordered border-dark mt-3" id="table-gaji">
            <thead>
                  <tr style="text-align: center;">
                        <th>No.</th>
                        <th>Nama Karyawan</th>
                        <th>Jabatan Karyawan</th>
                        <th>Gaji Pokok</th>
                        <th>Bonus</th>
                        <th>PPH</th>
                        <th>Total Gaji</th>
                        <th>Tanggal Gajian</th>
                        <th>Aksi</th>
                  </tr>
            </thead>

            <tbody class="table-group-divider">
                  <?php $no = 1; ?>
                  <?php foreach ($data_gaji->readData("gaji", "id_gaji") as $gaji) : ?>
                        <tr style="text-align: center;">
                              <td><?= $no++; ?></td>
                              <td><?= $gaji['nama_karyawan']; ?></td>
                              <td><?= $gaji['jabatan_karyawan']; ?></td>

                              <!-- angka format rupiah Indonesia -->
                              <td>Rp. <?= number_format($gaji['gaji_pokok'], 0, ',', '.'); ?></td>
                              <td>Rp. <?= number_format($gaji['bonus'], 0, ',', '.'); ?></td>
                              <td>- Rp. <?= number_format($gaji['pph'], 0, ',', '.'); ?></td>
                              <td>Rp. <?= number_format($gaji['total_gaji'], 0, ',', '.'); ?></td>
                              <td><?= date('d-M-Y', strtotime($gaji['tgl_gajian'])); ?></td>
                              <td>
                                   
                                    <a href="hapus_gaji.php?id_gaji=<?= $gaji['id_gaji'] ?>" class="btn btn-danger" onclick="return confirm('Yakin Ingin Menghapus Data Gaji Karyawan Bernama <?= $gaji['nama_karyawan']; ?> ?')">Hapus</a>
                              </td>
                        </tr>
                  <?php endforeach; ?>
            </tbody>
      </table>
</div>


<?php
include "layout/footer.php";

?>