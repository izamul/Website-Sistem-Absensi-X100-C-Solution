<?php include '../templates/student/student-header.php'; ?>
<?php include '../templates/student/student-sidebar.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Absensi</h1>
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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Daftar Absensi Siswa</h3>
                            <div class="d-flex justify-content-end ml-auto">
                                <!-- Form filter dipindahkan ke sini -->
                                <form method="get" action="" class="form-inline mr-5">
                                    <div class="form-group mr-2">
                                        <label for="filter" class="mr-2">Filter:</label>
                                        <select class="form-control" id="filter" name="filter">
                                            <option value="">Pilih</option>
                                            <option value="all">Semua</option>
                                            <option value="today">Hari Ini</option>
                                            <option value="this_week">Minggu Ini</option>
                                            <option value="this_month">Bulan Ini</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Terapkan</button>
                                </form>
                                <form method="get" action="../../cetak-excel.php" class="form-inline">
                                    <div class="form-group mr-2">
                                        <label for="excel_filter" class="mr-2">Cetak:</label>
                                        <select class="form-control" id="excel_filter" name="excel_filter">
                                            <option value="">Pilih</option>
                                            <option value="all">Semua</option>
                                            <option value="today">Hari Ini</option>
                                            <option value="this_week">Minggu Ini</option>
                                            <option value="this_month">Bulan Ini</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success">Cetak Excel</button>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Hari</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

                                    // Fungsi untuk mengonversi hari dari bahasa Inggris ke bahasa Indonesia
                                    function convertDayToIndo($day) {
                                        $days = [
                                            'Monday' => 'Senin',
                                            'Tuesday' => 'Selasa',
                                            'Wednesday' => 'Rabu',
                                            'Thursday' => 'Kamis',
                                            'Friday' => 'Jumat',
                                            'Saturday' => 'Sabtu',
                                            'Sunday' => 'Minggu'
                                        ];
                                        return $days[$day];
                                    }

                                    // Ubah query berdasarkan filter
                                    $sql = "SELECT * FROM attendance";
                                    switch ($filter) {
                                        case 'today':
                                            $sql .= " WHERE DATE(tanggal) = CURDATE()";
                                            break;
                                        case 'this_week':
                                            $sql .= " WHERE YEARWEEK(tanggal, 1) = YEARWEEK(CURDATE(), 1)";
                                            break;
                                        case 'this_month':
                                            $sql .= " WHERE MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())";
                                            break;
                                        default:
                                            // Semua data, tidak perlu tambahkan kondisi WHERE tambahan
                                            break;
                                    }

                                    $getAttendance = mysqli_query($connection, $sql);
                                    $i = 1;
                                    foreach ($getAttendance as $value) :
                                        $tanggal = htmlspecialchars($value['tanggal']);
                                        $hari = date('l', strtotime($tanggal));
                                        $hari_indo = convertDayToIndo($hari); // Mengonversi hari ke bahasa Indonesia
                                        $tanggal_format = date('d M Y', strtotime($tanggal));
                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= htmlspecialchars($value['nama']); ?></td>
                                            <td><?= htmlspecialchars($value['status']); ?></td>
                                            <td><?= $hari_indo; ?></td> <!-- Menggunakan hari dalam bahasa Indonesia -->
                                            <td><?= $tanggal_format; ?></td>
                                            <td><?= htmlspecialchars($value['waktu']); ?></td>
                                        </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
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
