<?php
if (isset($_POST['submit'])) {
    $nama_app = $_POST['nama_app'];

    // Handle Upload Logo
    $logo = $_FILES['logo']['name'];
    $tmp = $_FILES['logo']['tmp_name'];
    if (!empty($logo)) {
        move_uploaded_file($tmp, "dist/img/$logo");
    } else {
        $logo = $data_app['logo'];
    }

    $sql = "UPDATE tb_setting SET nama_app='$nama_app', logo='$logo' WHERE id='1'";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        echo "<script>alert('Pengaturan berhasil diperbarui!');window.location='?page=MyApp/setting_system';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui pengaturan!');</script>";
    }
}

$sql_app = mysqli_query($koneksi, "SELECT * FROM tb_setting WHERE id='1'");
$data_app = mysqli_fetch_array($sql_app);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Pengaturan Sistem</h3>
    </div>
    <form method="post" enctype="multipart/form-data">
        <div class="box-body">
            <div class="form-group">
                <label>Nama Aplikasi</label>
                <input type="text" name="nama_app" class="form-control" value="<?php echo $data_app['nama_app']; ?>" required>
            </div>
            <div class="form-group">
                <label>Logo</label>
                <input type="file" name="logo" class="form-control">
                <br>
                <img src="dist/img/<?php echo $data_app['logo']; ?>" width="100">
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
