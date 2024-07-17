<?php include '../templates/student/student-header.php'; ?>
<?php include '../templates/student/student-sidebar.php'; ?>
<?php
$firstAttendance = [];
$today = date("Y-m-d");

foreach ($userdata as $user) {
    $user_id = $user[0];
    $found = false;

    foreach ($attendancedata as $data) {
        if ($user_id == $data[1] && !$found && $today == date("Y-m-d", strtotime($data[3])) && $user[1] != 'admin') {
            $checkinHour = date("H", strtotime($data[3]));

            if ($data[2] == 1 && ($checkinHour >= 5 && $checkinHour <= 8)) {
                $status = 'Hadir';
            } else {
                $status = 'Telat';
            }

            $firstAttendance[$user_id] = [
                'nama' => $user[1],
                'status' => $status,
                'tanggal' => date("d-m-Y", strtotime($data[3])),
                'waktu' => date("H:i:s", strtotime($data[3])),
            ];

            $found = true;
        }
    }
    if (!$found && $user[1] != 'admin') {
        $firstAttendance[$user_id] = [
            'nama' => $user[1],
            'status' => 'Belum ada data',
            'tanggal' => date("d-m-Y"),
            'waktu' => 'Belum ada data',
        ];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_attendance'])) {
    foreach ($firstAttendance as $user_id => $attendance) {
        $nama = $attendance['nama'];
        $status = $attendance['status'];
        $tanggal = date("Y-m-d", strtotime($attendance['tanggal']));
        $waktu = $attendance['waktu'];

        $checkSql = "SELECT * FROM attendance WHERE nama = '$nama' AND DATE(tanggal) = '$tanggal'";
        $checkResult = mysqli_query($connection, $checkSql);

        if (mysqli_num_rows($checkResult) > 0) {
            $updateSql = "UPDATE attendance SET status = '$status', waktu = '$waktu' WHERE nama = '$nama' AND DATE(tanggal) = '$tanggal'";
            mysqli_query($connection, $updateSql);
        } else {
            $insertSql = "INSERT INTO attendance (nama, status, tanggal, waktu) VALUES ('$nama', '$status', '$tanggal', '$waktu')";
            mysqli_query($connection, $insertSql);
        }
    }
    $updateMessage = "Data absensi berhasil disubmit.";
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Realtime Absensi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                        <li class="breadcrumb-item active">Attendance</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3 class="card-title">Daftar Absensi Siswa - <?= date("d F Y") ?></h3>
                            <div class="ml-auto">
                                <button class="btn btn-primary btn-sm" onclick="window.location.reload();">Refresh</button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php if (!empty($updateMessage)) : ?>
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?= $updateMessage; ?>
                                </div>
                            <?php endif; ?>
                            <form id="attendanceForm" method="post">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $i = 1;
                                        foreach ($firstAttendance as $attendance) {
                                            ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $attendance['nama'] ?></td>
                                                <td><?= $attendance['status'] ?></td>
                                                <td><?= $attendance['tanggal'] ?></td>
                                                <td><?= $attendance['waktu'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                    </tbody>
                                </table>
                                <input type="hidden" name="submit_attendance" value="1">
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

<script>
    function confirmSubmit() {
        var confirmation = confirm("Data akan disubmit. Apakah Anda yakin?");
        if (confirmation) {
            document.getElementById('attendanceForm').submit();
        }
    }
</script>
