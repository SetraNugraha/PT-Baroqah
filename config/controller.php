<?php
include "database.php";

// Fungsi Select (Menampilkan data)
function select($query)
{

      global $db;

      $result = mysqli_query($db, $query);
      $rows = [];

      while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
      }

      return $rows;
}


// Fungsi menambahkan data (CREATE)

function create_karyawan($post)
{

      global $db;

      $nama             = strip_tags($post['nama']);
      $alamat           = strip_tags($post['alamat']);
      $jabatan          = strip_tags($post['jabatan']);
      $gaji             = strip_tags($post['gaji']);
      $tgl_bergabung    = strip_tags($post['tgl_bergabung']);

      // query untuk menambahkan data
      $query = "INSERT INTO karyawan VALUES (
            null,
            '$nama',
            '$alamat',
            '$jabatan',
            '$gaji',
            '$tgl_bergabung'
      )";

      mysqli_query($db, $query);

      return mysqli_affected_rows($db);
}

// Fungsi Update Data
function update_karyawan($post)
{

      global $db;

      $id_karyawan      = strip_tags($post['id_karyawan']);
      $nama             = strip_tags($post['nama']);
      $alamat           = strip_tags($post['alamat']);
      $jabatan          = strip_tags($post['jabatan']);
      $gaji             = strip_tags($post['gaji']);
      $tgl_bergabung    = strip_tags($post['tgl_bergabung']);

      // query untuk update data
      $query = "UPDATE karyawan SET
                  nama = '$nama',
                  alamat = '$alamat',
                  jabatan = '$jabatan',
                  gaji = '$gaji',
                  tgl_bergabung = '$tgl_bergabung'
                  WHERE id_karyawan = '$id_karyawan'";

      mysqli_query($db, $query);

      return mysqli_affected_rows($db);
}


// Fungsi Delete Data

function delete_karyawan($id_karyawan)
{

      global $db;

      //query delete
      $query = "DELETE FROM karyawan WHERE id_karyawan = '$id_karyawan'";

      mysqli_query($db, $query);

      return mysqli_affected_rows($db);
}

// Fungsi Gaji ====================================================================================================================================>

// Fungsi menambakan data (CREATE)

function create_gaji($post)
{
      global $db;

      $nama_karyawan = strip_tags($post['nama_karyawan']);
      $tgl_gajian = strip_tags($post['tgl_gajian']);

      // Mendapatkan data karyawan dari tabel 'karyawan'
      $select_query = "SELECT jabatan, gaji FROM karyawan WHERE nama = '$nama_karyawan'";
      $result = mysqli_query($db, $select_query);

      if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $jabatan = $row['jabatan'];
            $gaji_pokok = $row['gaji'];

            // Menghitung bonus berdasarkan jabatan
            $bonus = 0;
            if ($jabatan == 'Manager') {
                  $bonus = $gaji_pokok * 0.5;
            } elseif ($jabatan == 'Supervisor') {
                  $bonus = $gaji_pokok * 0.4;
            } elseif ($jabatan == 'Staff') {
                  $bonus = $gaji_pokok * 0.3;
            } else {
                  echo "Jabatan tidak ditemukan";
                  return;
            }

            // Menghitung pph
            $pph = ($gaji_pokok + $bonus) * 0.05;

            // Menghitung total gaji
            $total_gaji = $gaji_pokok + $bonus - $pph;

            // Query untuk memasukkan data ke tabel 'gaji'
            $insert_query = "INSERT INTO gaji (nama_karyawan,jabatan_karyawan, gaji_pokok, bonus, pph, total_gaji, tgl_gajian) 
                         VALUES ('$nama_karyawan','$jabatan', $gaji_pokok, $bonus, $pph, $total_gaji, '$tgl_gajian')";
            mysqli_query($db, $insert_query);

            return mysqli_affected_rows($db);   

      }
}


// Fungsi Delete Gaji
function delete_gaji($id_gaji)
{

      global $db;

      //query delete
      $query = "DELETE FROM gaji WHERE id_gaji = '$id_gaji'";

      mysqli_query($db, $query);

      return mysqli_affected_rows($db);
}
