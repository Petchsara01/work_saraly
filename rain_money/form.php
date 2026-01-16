<form action="calculate.php" method="POST">

    <!-- ปี พ.ศ -->
    <div class="mb-3">
        <label class="form-label fw-bold">Year (พ.ศ)</label>
        <input type="number"
            class="form-control"
            name="year"
            value="<?= date('Y') + 543 ?>"
            required>
    </div>

    <!-- เดือน -->
    <div class="mb-3">
        <label class="form-label fw-bold">Month</label>
        <select class="form-select" name="month"  required>

            <option value="">-- เลือกเดือน --</option>

            <?php
            $months = [
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

            $selectedMonth = $_POST['month'] ?? '';

            foreach ($months as $k => $v) {
                $selected = ($k == $selectedMonth) ? 'selected' : '';
                echo "<option value='$k' $selected>$v</option>";
            }
            ?>
        </select>
    </div>


    <button class="btn btn-primary w-100">Calculate</button>
</form>