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

// query menampilkan data karyawan
// $data_karyawan = select("SELECT * FROM karyawan ORDER BY id_karyawan DESC");
$data_karyawan = new Database();

?>


<div class="container mb-3 ">
      <h1 class="mt-3">Data Karyawan</h1>
      <hr>

      <a href="tambah_karyawan.php" class="btn btn-primary mt-3 mb-3">Tambah Data</a>
      <!-- button export pdf -->
      <button id="export-karyawan-pdf" class="btn btn-success">Cetak PDF</button>

      <table class="table " id="table-karyawan">
            <thead>
                  <tr class="align-middle">
                        <th>No.</th>
                        <th>Nama Karyawan</th>
                        <th>Nomor Handphone</th>
                        <th>Alamat</th>
                        <th>Jabatan</th>
                        <th>Gaji Pokok</th>
                        <th>Tanggal Bergabung</th>
                        <th>Foto Profile</th>
                        <th>Aksi</th>
                  </tr>
            </thead>

            <tbody class="table-group-divider align-middle ">
                  <?php $no = 1; ?>
                  <?php foreach ($data_karyawan->readData("karyawan", "id_karyawan") as $karyawan) : ?>
                        <tr style="text-align: cente; border-bottom: 1px solid black">

                              <!-- Nomer Table -->
                              <td style="width: 5%;"><?= $no++; ?></td>

                              <!-- Nama Karyawan -->
                              <td style="width: 15%;"><?= $karyawan['nama']; ?></td>

                              <!-- Nomor Handphone -->
                              <td style="width: 15%;"><?= $karyawan['nohp']; ?></td>

                              <!-- alamat karyawan -->
                              <td style="width: 20%;"><?= $karyawan['alamat']; ?></td>
                              <td><?= $karyawan['jabatan']; ?></td>

                              <!-- angka format rupiah Indonesia -->
                              <td style="width: 15%;">Rp. <?= number_format($karyawan['gaji'], 0, ',', '.'); ?></td>

                              <!-- Tanggal Bergabung -->
                              <td style="width: 10%;"><?= date('d-M-Y', strtotime($karyawan['tgl_bergabung'])); ?> </td>

                              <!-- Image -->
                              <td>
                                    <a href="img/employee/<?= $karyawan['image'] ?>">
                                          <img src="img/employee/<?= $karyawan['image'] ?>" alt="image" width="100px" height="100px">
                                    </a>
                              </td>

                              <!-- Aksi -->
                              <td style="width: 10%;">
                                    <!-- Menaruh id karyawan ke dalam URL -->
                                    <!-- Edit -->
                                    <a href="ubah_karyawan.php?id_karyawan=<?= $karyawan['id_karyawan'] ?>" class="btn btn-warning p-1">Ubah</a>

                                    <!-- Delete -->
                                    <a href="hapus_karyawan.php?id_karyawan=<?= $karyawan['id_karyawan'] ?>" class="btn btn-danger p-1 my-2" onclick="return confirm('Yakin Ingin Menghapus Data Karyawan Bernama <?= $karyawan['nama']; ?> ?')">Hapus</a>
                              </td>
                        </tr>
                  <?php endforeach; ?>
            </tbody>
      </table>
</div>

<?php
include "layout/footer.php";

?>