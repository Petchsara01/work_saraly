<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: form.php");
    exit;
}

$thaiYear = (int)$_POST['year'];
$month    = (int)$_POST['month'];

if ($thaiYear < 2400) {
    echo "<div class='alert alert-danger'>กรุณากรอกปี พ.ศ.</div>";
    exit;
}

// แปลง พ.ศ. → ค.ศ.
$year = $thaiYear - 543;

// ตัวคูณเงิน
$multiplierMap = [
    'sun'     => 1,
    'rain'    => 2,
    'raincon' => 4
];

// ข้อมูลสภาพอากาศ
$weatherMap = [
    'sun' => [
        'label' => 'แดดออก',
        'icon'  => 'bi-brightness-high',
        'class' => 'table-warning'
    ],
    'rain' => [
        'label' => 'ฝนตก',
        'icon'  => 'bi-cloud-rain',
        'class' => 'table-primary'
    ],
    'raincon' => [
        'label' => 'ฝนตกต่อเนื่อง',
        'icon'  => 'bi-cloud-rain-heavy',
        'class' => 'table-primary'
    ]
];

$dayNames = ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'];

$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// หา pattern ฝน
$rain = [];
$satCount = 0;

for ($d = 1; $d <= $daysInMonth; $d++) {
    $w = date('w', strtotime("$year-$month-$d"));
    $rain[$d] = false;

    if ($w == 3) $rain[$d] = true; // พุธ
    if ($w == 6) {
        $satCount++;
        if ($satCount % 2 == 1) $rain[$d] = true;
    }
}

for ($d = 1; $d <= $daysInMonth; $d++) {
    if ($rain[$d] && date('w', strtotime("$year-$month-$d")) == 6) {
        $tue = $d + ((2 - 6 + 7) % 7);
        if ($tue <= $daysInMonth) $rain[$tue] = true;
    }
}

// เตรียมข้อมูลตาราง
$rows = [];
$totalMoney = 0;

for ($d = 1; $d <= $daysInMonth; $d++) {

    $today = $rain[$d];
    $yesterday = ($d > 1) ? $rain[$d - 1] : false;

    if ($today && $yesterday) $type = 'raincon';
    elseif ($today) $type = 'rain';
    else $type = 'sun';

    $multi = $multiplierMap[$type];
    $money = $d * $multi;
    $totalMoney += $money;

    $rows[] = [
        'day'        => $d,
        'dayName'    => $dayNames[date('w', strtotime("$year-$month-$d"))],
        'weather'    => $weatherMap[$type]['label'],
        'icon'       => $weatherMap[$type]['icon'],
        'class'      => $weatherMap[$type]['class'],
        'multiplier' => $multi,
        'money'      => $money
    ];
}

include 'result.php';
