<?php
require_once 'Controller/KaryawanController.php';

class User extends Karyawan
{
    public function login()
    {
        // mengambil input username dan password user
        $username = strip_tags($_POST["username"]);
        $password = strip_tags($_POST["password"]);

        //cek username
        $cekUsername = $this->pdo->prepare("SELECT * FROM user WHERE username = '$username'");
        $cekUsername->execute();

        // cek apakah username ditemukan
        if ($cekUsername->rowCount() == 1) {

            //cek password
            $row = $cekUsername->fetch(PDO::FETCH_ASSOC);

            if ($password == $row['password']) {
                //set session
                $_SESSION['login'] = true;
                $_SESSION['id_user'] = $row['id_user'];
                $_SESSION['username'] = $row['username'];

                header("Location: index.php");
                exit;
            }
        }
    }
}
