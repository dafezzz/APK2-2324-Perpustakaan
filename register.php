<?php
include "inc/koneksi.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Register | SI Perpustakaan</title>
    <link rel="icon" href="dist/img/logo.png">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <h3>
                <font color="green"><b>Register Perpustakaan</b></font>
            </h3>
        </div>
        <div class="login-box-body">
            <center><img src="image/logo.png" width=160px /></center>
            <br>
            <p class="login-box-msg">Buat Akun Baru</p>

            <form action="" method="post">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="nama_pengguna" placeholder="Nama Lengkap" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <label>Level</label>
                    <select name="level" id="level" class="form-control">
                        <option>-- Pilih Level --</option>
                        <option value="Administrator">Administrator</option>
                        <option value="Petugas">Petugas</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-success btn-block btn-flat" name="btnRegister">
                            <b>Register</b>
                        </button>
                    </div>
                </div>
            </form>
            <br>
            <p class="text-center">Sudah punya akun? <a href="login.php">Login</a></p>
        </div>
    </div>

    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</body>

</html>
<?php
if (isset($_POST['btnRegister'])) {
    include "inc/koneksi.php";

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, md5($_POST['password']));
    $nama_pengguna = mysqli_real_escape_string($koneksi, $_POST['nama_pengguna']);
    $level = isset($_POST['level']) ? mysqli_real_escape_string($koneksi, $_POST['level']) : '';

    // Ubah validasi level sesuai ENUM di database
    if (!in_array($level, ['Administrator', 'Petugas'])) {
        echo "<script>
            Swal.fire({title: 'Level tidak valid', icon: 'error', confirmButtonText: 'OK'})
            .then(() => { window.location = 'register.php'; });
        </script>";
        exit();
    }

    // Cek apakah username sudah digunakan
    $cek_user = mysqli_query($koneksi, "SELECT * FROM tb_pengguna WHERE username='$username'");
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>
            Swal.fire({title: 'Username sudah digunakan', icon: 'error', confirmButtonText: 'OK'})
            .then(() => { window.location = 'register.php'; });
        </script>";
        exit();
    }

    // Simpan ke database dengan level yang benar
    $query = "INSERT INTO tb_pengguna (username, password, nama_pengguna, level) 
              VALUES ('$username', '$password', '$nama_pengguna', '$level')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
            Swal.fire({title: 'Registrasi Berhasil', icon: 'success', confirmButtonText: 'OK'})
            .then(() => { window.location = 'login.php'; });
        </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi); // Untuk debugging jika ada error
    }
}
?>