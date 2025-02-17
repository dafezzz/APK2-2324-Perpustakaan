<?php
@session_start();


if (@$_SESSION['email']) {
    if (@$_SESSION['level'] == "Admin") { header("location:../admin/index.php");
    } elseif (@$_SESSION['level'] == "user") {
        header("location:../user/index.php");
    } elseif (@$_SESSION['level'] == "karyawan") {
        header("location:../pustakawan/index.php");
    }
}



if (isset($_POST['login'])) {
    $email = strtolower(stripslashes($_POST['email'])); //email di input oleh user
    $userpass = mysqli_real_escape_string($KONEKSI, $_POST['password']); //password di input oleh user

    // lalu kita query ke database
    $sql = mysqli_query($KONEKSI, "SELECT password, role FROM tbl_users WHERE email='$email'");

    list($paswd, $role) = mysqli_fetch_array($sql);

    // ambil level/role user yang sedang login
    $tipe_user = "SELECT  * FROM tbl_tipe_user WHERE id_tipe_user='$role'";
    $hasil = mysqli_query($KONEKSI, $tipe_user);
    $row = mysqli_fetch_assoc($hasil);
    $level = $row['tipe_user'];
    // echo $level;

    //jika data ditemukan dalam database, maka akan melakukan proses validasi dengan menggunakan password_verify
    if (mysqli_num_rows($sql) > 0) {
        /*jika ada data >0 maka kita lakukan validasi
        $userpass adalah diambil dari form input yang dilakukan oleh user
        $paswd adalah password yang ada di database dalam betuk HASH
        */
        if (password_verify($userpass, $paswd)) {
            //akan kita buatb session baru
            $_SESSION['email'] = $email;
            $_SESSION['level'] = $level;

            /*jika berhasil login maka user akan kita arahkan ke halaman admin sesuai dengan level user
            jika dia level admin maka akan diarahkan ke folder admin/index.php
            jika dia level petugas maka akan diarahkan ke folder petugas/index.php
            jika dia level penyewa maka akan diarahkan ke folder penyewa/index.php
            */
            if ($_SESSION['level'] == "Admin") {
                header("location:../admin/index.php");
            } elseif ($_SESSION['level'] == "user") {
                header("location:../user/index.php");
            } elseif ($_SESSION['level'] == "Penyewa") {
                header("location:../penyewa/index.php");
            }
            die();
        } else {
            echo '<script language="javascript">
                window.alert("LOGIN KM GAGAL! email/passwordnya mohon di cek);
                window.document.location.href="login.php";
                </script>';
        }
    } else {
        echo '<script language="javascript">
            window.alert("LOGIN KM GAGAL! email ga ketemu");
            window.document.location.href="login.php";
            </script>';
    }
}
?>



<!DOCTYPE html>
<html lang="en" class="h-100">


<!-- Mirrored from demo.themefisher.com/focus-bootstrap/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 17 Oct 2024 01:31:32 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Focus - Bootstrap Admin Dashboard </title>
    <!-- Favicon icon -->
    <link rel="icon" type="../image/png" sizes="16x16" href="../images/favicon.png">
    <link href="../css/style.css" rel="stylesheet">

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                                   <form action="login.php" method="POST">
                  <div class="row">
                    <div class="form-group col-md-12 mb-4">
                      <input
                        type="email"
                        class="form-control input-lg"
                        name="email"
                        aria-describedby="emailHelp"
                        placeholder="Email"
                        required
                      />
                    </div>
                    <div class="form-group col-md-12">
                      <input
                        type="password"
                        class="form-control input-lg"
                        name="password"
                        placeholder="Password"
                        required
                      />
                      <label for="inputTypeUser" class=""></label><br>
                                            <select name="type_user" onchange="tipeUser(this.value);" id="inputTypeUser" class="form-control">
                                                <option value="">Select Type User</option>
                                                <option value="1">Admin</option>
                                                <option value="2">Pustakawan</option>
                                                <option value="3">User</option>
                                            </select>

                    </div>
                    <div class="col-md-12">
                      <div class="d-flex justify-content-between mb-3">
                        <div class="custom-control custom-checkbox mr-3 mb-3">
                          <input
                            type="checkbox"
                            class="custom-control-input"
                            id="customCheck2"
                          />
                          <label class="custom-control-label" for="customCheck2">
                            Remember me
                          </label>
                        </div>

                        <!-- Uncomment this if needed -->
                        <!-- <a class="text-color" href="#"> Forgot password? </a> -->
                      </div>

                      <button type="submit" name="login" class="btn btn-primary btn-pill mb-4">
                        Sign In
                      </button>

                      <p>
                        Don't have an account yet?
                        <a class="text-blue" href="register.php">register</a>
                      </p>                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    

</body>

</html>