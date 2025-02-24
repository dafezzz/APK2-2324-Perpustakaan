<?php
// Periksa apakah session sudah aktif sebelum memulai sesi baru
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Pastikan koneksi ke database
include "inc/koneksi.php";

$data_id = $_SESSION["ses_id"];

// Periksa apakah query berhasil
$sql_user = mysqli_query($koneksi, "SELECT * FROM tb_pengguna WHERE id='$data_id'");

if (!$sql_user) {
    die("Query Error: " . mysqli_error($koneksi));
}

$data_user = mysqli_fetch_assoc($sql_user);

if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);

    // Jika password tidak diisi, gunakan password lama
    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
    } else {
        $password = $data_user['password'];
    }

    // Update data pengguna
    $sql = "UPDATE tb_pengguna SET nama='$nama', username='$username', password='$password' WHERE id='$data_id'";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        echo "<script>alert('Profil berhasil diperbarui!');window.location='?page=MyApp/setting_profil';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui profil: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Pengaturan Profil</h3>
    </div>
    <form method="post">
        <div class="box-body">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($data_user['nama']); ?>" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($data_user['username']); ?>" required>
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
