<?php
session_start();

include '../integration/zklib/zklib.php';
$zk = new ZKLib("192.168.1.88", 4370);
$zk->connect();
$zk->disableDevice();

$username = $_POST['username'];
$password = $_POST['password'];

function getUserDataFromZK($zk) {
    $userdata = $zk->getUser();
    return $userdata;
}

$userdata = getUserDataFromZK($zk);

$zk->enableDevice();
$zk->disconnect();

$userFound = false;
$role = '';

foreach ($userdata as $user) {
    if ($user[1] == $username && $user[3] == $password) { 
        $userFound = true;
        $role = $user[1] == 'admin' ? 'admin' : 'student'; 
        break;
    }
}

if ($userFound) {
    $_SESSION['username'] = $username;
    $_SESSION['status'] = 'login';
    
    if ($role == 'admin') {
        $_SESSION['role'] = 'admin';
        header('location:admin/');
    } else {
        $_SESSION['role'] = 'student';
        header('location:student/');
    }
} else {
    header("location:../index.php?pesan=gagal");
}
?>
