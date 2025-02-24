<?php
// Pastikan session sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "inc/koneksi.php";

// Ambil id_pengguna dari session
$data_id = $_SESSION["ses_id"];

// Ambil data pengguna dari tabel tb_pengguna
$sql_user = mysqli_query($koneksi, "SELECT * FROM tb_pengguna WHERE id_pengguna='$data_id'");
$data_user = mysqli_fetch_assoc($sql_user);

if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);

    // Cek password, kosong = pakai password lama
    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
    } else {
        $password = $data_user['password'];
    }

    // Update tb_pengguna sesuai kolom di DB
    $sql = "UPDATE tb_pengguna 
            SET nama_pengguna='$nama', username='$username', password='$password' 
            WHERE id_pengguna='$data_id'";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        // Update session agar nama di header ikut berubah
        $_SESSION["ses_nama"] = $nama;

        echo "<script>alert('Profil berhasil diperbarui!');
              window.location='?page=MyApp/setting_profil';
              </script>";
    } else {
        echo "<script>alert('Gagal memperbarui profil: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengaturan Profil</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container" style="margin-top:20px;">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Pengaturan Profil</h3>
        </div>
        <form method="post">
            <div class="box-body">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <!-- Gunakan data_user['nama_pengguna'] -->
                    <input type="text" name="nama" class="form-control" 
                           value="<?php echo htmlspecialchars($data_user['nama_pengguna']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control"
                           value="<?php echo htmlspecialchars($data_user['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Password (Kosongkan jika tidak ingin diubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
