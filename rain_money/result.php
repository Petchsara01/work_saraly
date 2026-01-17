<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Rain Salary</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        .typewriter {
            position: relative;
            margin: 0 auto;
            font-size: 180%;
            white-space: nowrap;
            overflow: hidden;
            width: calc(var(--chars) * 1ch);
            border-right: 2px solid rgba(0, 0, 0, 0.64);
            animation:
                typing 2s steps(var(--chars)) forwards,
                blink 0.5s step-end infinite;
        }

        @keyframes typing {
            from {
                width: 0;
            }

            to {
                width: calc(var(--chars) * 1ch);
            }
        }

        @keyframes blink {
            50% {
                border-color: transparent;
            }
        }
    </style>
</head>

<body>

<nav class="sticky-top">
    <?php include '../comp/navbar.php'; ?>
</nav>

<div class="container mt-4">

    <p class="typewriter" style="--chars: 15;">Welcome User 😊</p>

    <div class="card-body">
        <?php include 'form.php'; ?>
    </div>

    <br>
    <hr>
    <br>

<?php
/* =====================================================
   ดักการเข้าหน้าโดยไม่มีข้อมูล (แก้ Undefined variable)
   ===================================================== */
if (
    !isset($month) ||
    !isset($thaiYear) ||
    !isset($totalMoney) ||
    !isset($rows)
) {
    echo '
    <div class="alert alert-warning text-center">
        โปรดเลือกข้อมูล
    </div>
    ';
    return;
}

/* ===== แปลงเลขเดือนเป็นชื่อเดือนภาษาไทย ===== */
$monthNames = [
    1 => 'มกราคม',
    2 => 'กุมภาพันธ์',
    3 => 'มีนาคม',
    4 => 'เมษายน',
    5 => 'พฤษภาคม',
    6 => 'มิถุนายน',
    7 => 'กรกฎาคม',
    8 => 'สิงหาคม',
    9 => 'กันยายน',
    10 => 'ตุลาคม',
    11 => 'พฤศจิกายน',
    12 => 'ธันวาคม'
];

$monthName = $monthNames[$month] ?? '';
?>

    <div class="d-flex justify-content-between mb-3">
        <h4>เดือน <?= $monthName ?> ปี <?= $thaiYear ?> (พ.ศ)</h4>
        <h4 class="text-success">รวม <?= number_format($totalMoney) ?> บาท</h4>
    </div>

    <table id="weatherTable" class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>วันที่</th>
                <th>วัน</th>
                <th>สภาพอากาศ</th>
                <th class="text-center">คูณ (เท่า)</th>
                <th class="text-end">เงิน</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($rows) && is_array($rows)) {
                $rows = array_values($rows);
                for ($i = 0, $n = count($rows); $i < $n; $i++):
                    $r = $rows[$i];
            ?>
                <tr class="<?= $r['class'] ?>">
                    <td><?= $r['day'] ?></td>
                    <td><?= $r['dayName'] ?></td>
                    <td>
                        <i class="bi <?= $r['icon'] ?>"></i>
                        <?= $r['weather'] ?>
                    </td>
                    <td class="text-center">×<?= $r['multiplier'] ?></td>
                    <td class="text-end"><?= number_format($r['money']) ?></td>
                </tr>
            <?php
                endfor;
            } else {
            ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">ไม่พบข้อมูล</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <br>

</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(function() {
        $('#weatherTable').DataTable({
            pageLength: 10,
            lengthChange: false,
            ordering: true,
            searching: true,
            language: {
                search: "ค้นหา:",
                paginate: {
                    next: "ถัดไป",
                    previous: "ก่อนหน้า"
                }
            }
        });
    });
</script>

</body>
</html>
