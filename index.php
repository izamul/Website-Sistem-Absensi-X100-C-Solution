<?php include 'view/templates/login/login-header.php'; ?>

<?php
session_start();

$errorMsg = '';
if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == 'gagal') {
        $errorMsg = '<div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
        Username atau Password salah!
    </div>';
    } elseif ($_GET['pesan'] == 'logout') {
        $errorMsg = '
        <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Alert!</h5>
                  Anda berhasil Logout!
                </div>';
    } elseif ($_GET['pesan'] == 'notlogin') {
        $errorMsg = '
        <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                  Anda harus login dulu!
                </div>';
    }
}
?>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="assets/img/smkn1bendomagetan.png" alt="SMKN 1 Bendo Magetan Logo" style="width: 150px; height: auto;">
            <p>SMKN 1 BENDO MAGETAN</p>
        </div>
        <p><?= $errorMsg; ?></p>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Login untuk akses sistem</p>

                <form action="view/cek_login.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required
                            maxlength="8" minlength="1">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <?php include 'view/templates/login/login-footer.php' ?>