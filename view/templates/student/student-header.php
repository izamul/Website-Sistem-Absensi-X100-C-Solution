<?php
session_start();

include '../../integration/connectionzk.php';
include '../../Config/Database.php';

$username = $_SESSION['username'];


$userFound = false;
$userDataFromZK = [];

foreach ($userdata as $user) {
    if ($user[1] == $username) {
        $userFound = true;
        $userDataFromZK = $user; 
        break;
    }
}

if (!$userFound) {
    header("location:../../index.php?pesan=notlogin");
    exit;
}

$_SESSION['username'] = $userDataFromZK[1];
$_SESSION['role'] = $userDataFromZK[2]; 
$_SESSION['status'] = 'login';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SMKN 1 BENDO MAGETAN</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../student/" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="../../assets/img/student.jpg" class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-none d-md-inline"><?= ucfirst($userDataFromZK[1]); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-dark">
                            <img src="../../assets/img/student.jpg" class="img-circle elevation-2" alt="User Image">
                            <p>
                                <?= ucfirst($userDataFromZK[1]); ?>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="../logout.php" class="btn btn-info btn-flat float-right">Sign out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->