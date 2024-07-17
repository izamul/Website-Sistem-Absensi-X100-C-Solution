<?php
include '../../integration/zklib/zklib.php';
$zk = new ZKLib("192.168.1.88", 4370);
$zk->connect();
$zk->disableDevice();

$userdata = $zk->getUser(); 
$attendancedata = $zk->getAttendance();

$zk->enableDevice();
$zk->disconnect();
?>