<?php include '../templates/admin/admin-header.php'; ?>
<?php include '../templates/admin/admin-sidebar.php'; ?>
<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$id) {
    echo "ID absensi tidak valid.";
    exit;
}

$sql = "SELECT nama, tanggal, status FROM attendance WHERE id = $id";
$result = mysqli_query($connection, $sql);

if (!$result) {
    echo "Error: " . mysqli_error($connection);
    exit;
}

if (mysqli_num_rows($result) === 0) {
    echo "Data absensi tidak ditemukan.";
    exit;
}

$attendance = mysqli_fetch_assoc($result);

$updateMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];

    $updateSql = "UPDATE attendance SET status = '$status' WHERE id = $id";
    if (mysqli_query($connection, $updateSql)) {
        $updateMessage = "Status absensi berhasil diperbarui.";
    } else {
        echo "Terjadi kesalahan saat memperbarui status absensi: " . mysqli_error($connection);
    }
}

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Absensi Siswa</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php if (!empty($updateMessage)) : ?>
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?= $updateMessage; ?>
                                </div>
                            <?php endif; ?>
                            <form method="post">
                                <div class="form-group">
                                    <label for="status">Status:</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="Hadir" <?= ($attendance['status'] === 'Hadir') ? 'selected' : ''; ?>>Hadir</option>
                                        <option value="Telat" <?= ($attendance['status'] === 'Telat') ? 'selected' : ''; ?>>Telat</option>
                                        <option value="Izin" <?= ($attendance['status'] === 'Izin') ? 'selected' : ''; ?>>Izin</option>
                                        <option value="Absen" <?= ($attendance['status'] === 'Absen') ? 'selected' : ''; ?>>Absen</option>
                                        <option value="Tidak ada keterangan" <?= ($attendance['status'] === 'Tidak ada keterangan') ? 'selected' : ''; ?>>Tidak ada keterangan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Siswa:</label>
                                    <input type="text" class="form-control" id="nama" value="<?= htmlspecialchars($attendance['nama']); ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="hari">Tanggal Absensi:</label>
                                    <input type="text" class="form-control" id="hari" value="<?= date('l, d M Y', strtotime(htmlspecialchars($attendance['tanggal']))); ?>" readonly>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="data-absen.php" class="btn btn-secondary">Kembali</a>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include '../templates/footer.php'; ?>
