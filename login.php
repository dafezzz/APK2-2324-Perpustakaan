<?php
include "inc/koneksi.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | SI Perpustakaan</title>
    <link rel="icon" href="image/logo.png">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <h3><font color="green"><b>Sistem Informasi Perpustakaan</b></font></h3>
        </div>
        <div class="login-box-body">
            <center><img src="image/logo.png" width=160px /></center>
            <br>
            <p class="login-box-msg">Login System</p>
            <form action="" method="post">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <a href="register.php" class="btn btn-primary btn-block btn-flat">Register</a>
                    </div>
                    <div class="col-xs-6">
                        <button type="submit" class="btn btn-success btn-block btn-flat" name="btnLogin" title="Masuk Sistem">
                            <b>Masuk</b>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</body>
</html>
<?php 
include "inc/koneksi.php";

if (isset($_POST['btnLogin'])) {  
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, md5($_POST['password'])); // Cocokkan dengan password hash

    $sql_login = "SELECT * FROM tb_pengguna WHERE BINARY username='$username' AND password='$password'";
    $query_login = mysqli_query($koneksi, $sql_login);
    $data_login = mysqli_fetch_array($query_login, MYSQLI_BOTH);
    $jumlah_login = mysqli_num_rows($query_login);
    
    if ($jumlah_login == 1) {
        session_start();
        $_SESSION["ses_id"] = $data_login["id_pengguna"];
        $_SESSION["ses_nama"] = $data_login["nama_pengguna"];
        $_SESSION["ses_username"] = $data_login["username"];
        $_SESSION["ses_level"] = $data_login["level"];
        
        echo "<script>
            Swal.fire({title: 'Login Berhasil', icon: 'success', confirmButtonText: 'OK'})
            .then(() => { window.location = 'index.php'; });
        </script>";
    } else {
        echo "<script>
            Swal.fire({title: 'Login Gagal', text: 'Username atau password salah!', icon: 'error', confirmButtonText: 'OK'})
            .then(() => { window.location = 'login.php'; });
        </script>";
    }
} 
?>
