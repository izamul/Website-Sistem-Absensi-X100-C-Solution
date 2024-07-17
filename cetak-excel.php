<?php
include('Config/Database.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$filter = isset($_GET['excel_filter']) ? $_GET['excel_filter'] : 'all';

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
        break;
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Nama');
$sheet->setCellValue('C1', 'Status');
$sheet->setCellValue('D1', 'Hari');
$sheet->setCellValue('E1', 'Tanggal');
$sheet->setCellValue('F1', 'Waktu');

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

$data = mysqli_query($connection, $sql);
$i = 2;
$no = 1;
while ($d = mysqli_fetch_array($data)) {
    $tanggal = date("Y-m-d", strtotime($d['tanggal']));
    $hari = date("l", strtotime($d['tanggal']));
    $hari_indo = convertDayToIndo($hari); 

    $sheet->setCellValue('A' . $i, $no++);
    $sheet->setCellValue('B' . $i, $d['nama']);
    $sheet->setCellValue('C' . $i, $d['status']);
    $sheet->setCellValue('D' . $i, $hari_indo); 
    $sheet->setCellValue('E' . $i, $tanggal);
    $sheet->setCellValue('F' . $i, $d['waktu']);
    $i++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('Data Absensi.xlsx');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Data Absensi.xlsx"');
$writer->save('php://output');
exit;
?>
