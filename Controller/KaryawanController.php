<?php

class Karyawan
{
    public $host = 'localhost';
    public $user = 'root';
    public $pass = '';
    public $db = 'pt_baroqah';

    public $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Koneksi ke database gagal: " . $e->getMessage());
        }
    }

    public function readData($table, $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $table ORDER BY $id DESC");
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    // $idTable = Nama Kolom Uniq pada tabel. Contoh (id_karyawan dan id_gaji).
    //$id = ID yang diambil dari satu baris. contoh (ID dari karyawan bernama setra adalah 12)
    public function readDataSingle($table, $idTable, $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $table WHERE $idTable = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        return $results;
    }

    public function uploadFile()
    {
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $error    = $_FILES['image']['error'];
        $tmpName  = $_FILES['image']['tmp_name'];

        // Cek ekstensi file yang diupload
        $extensifileValid = ['jpg', 'jpeg', 'png'];

        // Pisahkan nama file ketika ada titik(.)
        $extensifile = explode('.', $fileName);

        // Membuat nama file menjadi lower semua dan menagmbil kata terakhir.
        $extensifile = strtolower(end($extensifile));

        // cek extensi file 
        if (!in_array($extensifile, $extensifileValid)) {

            //pesan gagal
            echo "<script>
                alert('Ekstensi file tidak didukung');
                document.location.href = 'index.php';
                </script>";
            die();
        }

        //cek ukuran file 2MB
        if ($fileSize > 2048000) {
            //pesan gagal

            echo "<script>
                alert('Ukuran Maksimal File 2 MB');
                document.location.href = 'tambah_karyawan.php';
                </script>";
            die();
        }

        // generate nama file baru
        $newFileName = uniqid();
        $newFileName .= '.';
        $newFileName .= $extensifile;

        //pindahkan ke folder local 
        move_uploaded_file($tmpName, 'img/employee/' . $newFileName);

        return $newFileName;
    }

    public function createData($insertTable)
    {
        if ($insertTable == "karyawan") {

            // Table Karyawan
            $nama             = strip_tags($_POST['nama']);
            $nohp             = strip_tags($_POST['nohp']);
            $alamat           = strip_tags($_POST['alamat']);
            $jabatan          = strip_tags($_POST['jabatan']);
            $gaji             = strip_tags($_POST['gaji']);
            $tgl_bergabung    = strip_tags($_POST['tgl_bergabung']);
            $image            = $this->uploadFile();

            // Cek upload File
            if (!$image) {
                return false;
            }

            try {
                $stmt = $this->pdo->prepare("INSERT INTO $insertTable VALUES (
                    null, 
                    :nama,
                    :nohp,
                    :alamat,
                    :jabatan,
                    :gaji,
                    :tgl_bergabung,
                    :image)");

                $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
                $stmt->bindParam(':nohp', $nohp, PDO::PARAM_INT);
                $stmt->bindParam(':alamat', $alamat, PDO::PARAM_STR);
                $stmt->bindParam(':jabatan', $jabatan, PDO::PARAM_STR);
                $stmt->bindParam(':gaji', $gaji, PDO::PARAM_INT);
                $stmt->bindParam(':tgl_bergabung', $tgl_bergabung, PDO::PARAM_STR);
                $stmt->bindParam(':image', $image, PDO::PARAM_STR);

                $results = $stmt->execute();

                return $results;
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        } else if ($insertTable == "gaji") {

            // Table Gaji
            $nama_karyawan = strip_tags($_POST['nama_karyawan']);
            $tgl_gajian = strip_tags($_POST['tgl_gajian']);

            // Mendapatkan data karyawan dari tabel 'karyawan'
            $stmt = $this->pdo->prepare("SELECT jabatan, gaji FROM karyawan WHERE nama = :nama_karyawan ");
            $stmt->bindParam('nama_karyawan', $nama_karyawan, PDO::PARAM_STR);
            $stmt->execute();

            // jika baris > 0 maka terdapat data
            if ($stmt->rowCount() > 0) {

                // Mengambil 1 baris data dari tabel karyawan
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // ambil data jabatan dan gaji pokok dari tabel karyawan untuk dikalkulasi
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

                try {
                    $stmt = $this->pdo->prepare("INSERT INTO $insertTable (
                        nama_karyawan,
                        jabatan_karyawan,
                        gaji_pokok,
                        bonus,
                        pph,
                        total_gaji,
                        tgl_gajian)
                    VALUES (
                        :nama_karyawan,
                        :jabatan_karyawan,
                        :gaji_pokok,
                        :bonus,
                        :pph,
                        :total_gaji,
                        :tgl_gajian)");

                    $stmt->bindParam(':nama_karyawan', $nama_karyawan, PDO::PARAM_STR);
                    $stmt->bindParam(':jabatan_karyawan', $jabatan, PDO::PARAM_STR);
                    $stmt->bindParam(':gaji_pokok', $gaji_pokok, PDO::PARAM_INT);
                    $stmt->bindParam(':bonus', $bonus, PDO::PARAM_INT);
                    $stmt->bindParam(':pph', $pph, PDO::PARAM_INT);
                    $stmt->bindParam(':total_gaji', $total_gaji, PDO::PARAM_INT);
                    $stmt->bindParam(':tgl_gajian', $tgl_gajian, PDO::PARAM_STR);

                    $results = $stmt->execute();


                    return $results;
                } catch (PDOException $e) {
                    die("Error: " . $e->getMessage());
                }
            }
        } else {
            die("Table Not Found !");
        }
    }

    public function updateData($updateTable)
    {

        if ($updateTable == "karyawan") {

            $id_karyawan      = strip_tags($_POST['id_karyawan']);
            $nama             = strip_tags($_POST['nama']);
            $nohp             = strip_tags($_POST['nohp']);
            $alamat           = strip_tags($_POST['alamat']);
            $jabatan          = strip_tags($_POST['jabatan']);
            $gaji             = strip_tags($_POST['gaji']);
            $tgl_bergabung    = strip_tags($_POST['tgl_bergabung']);

            // Mencari Image Karyawan
            $searchImage = $this->pdo->prepare("SELECT image FROM karyawan WHERE id_karyawan = :id_karyawan");
            $searchImage->bindParam(':id_karyawan', $id_karyawan, PDO::PARAM_INT);
            $searchImage->execute();
            $results = $searchImage->fetch(PDO::FETCH_ASSOC);
            $oldImage = $results['image'];

            // Mengecek apakah ada file yang diunggah
            // == 4 menunjukkan tidak ada file yang diunggah
            if ($_FILES['image']['error'] == 4) {
                $image = $oldImage;
            } else {
                $image = $this->uploadFile();
                $pathImage = "img/employee/" . $oldImage;
                if (file_exists($pathImage)) {
                    unlink($pathImage);
                }
            }

            try {
                $stmt = $this->pdo->prepare("UPDATE $updateTable SET
                                    nama = :nama,
                                    nohp = :nohp,
                                    alamat = :alamat,
                                    jabatan = :jabatan,
                                    gaji = :gaji,
                                    tgl_bergabung = :tgl_bergabung,
                                    image = :image
                                    WHERE id_karyawan = :id_karyawan");

                $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
                $stmt->bindParam(':nohp', $nohp, PDO::PARAM_INT);
                $stmt->bindParam(':alamat', $alamat, PDO::PARAM_STR);
                $stmt->bindParam(':jabatan', $jabatan, PDO::PARAM_STR);
                $stmt->bindParam(':gaji', $gaji, PDO::PARAM_INT);
                $stmt->bindParam(':tgl_bergabung', $tgl_bergabung, PDO::PARAM_STR);
                $stmt->bindParam(':image', $image, PDO::PARAM_STR);
                $stmt->bindParam(':id_karyawan', $id_karyawan, PDO::PARAM_INT);

                $stmt->execute();

                return $stmt;
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        } else {
            die("Table Not Found !");
        }
    }

    public function deleteData($deleteTable, $idTable, $id)
    {
        if ($deleteTable == "karyawan") {
            try {

                // Mengambil image dari karyawan yang dipilih
                $id_karyawan = (int)$_GET["id_karyawan"];
                $image = $this->readDataSingle("karyawan", "id_karyawan", $id_karyawan);

                $stmt = $this->pdo->prepare("DELETE FROM $deleteTable WHERE $idTable = :id");
                // Menghapus File Karyawan
                unlink("img/employee/" . $image['image']);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);


                $stmt->execute();

                return $stmt;
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        } else if ($deleteTable == "gaji") {
            try {
                $stmt = $this->pdo->prepare("DELETE FROM $deleteTable WHERE $idTable = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                $stmt->execute();

                return $stmt;
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        } else {
            die("Table Not Found !");
        }
    }
}
