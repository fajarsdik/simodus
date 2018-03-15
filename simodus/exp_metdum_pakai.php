<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=dummy_pakai.xls");
?>

<h3>Data Pemakaian Meter Dummy</h3>

<table border="1" cellpadding="5">
    <tr>
        <th width="6%" style="text-align: center">No. Dummy</th>
        <th width="10%" style="text-align: center">No. Meter Rusak</th>
        <th width="15%" style="text-align: center">Alasan Rusak</th>
        <th width="12%" style="text-align: center">Tanggal Pakai</th>
        <th width="13%" style="text-align: center">Petugas Pasang</th>
        <th width="7%" style="text-align: center">Sisa Pulsa</th>
        <th width="10%" style="text-align: center">No. HP Plg</th>
        <th width="7%" style="text-align: center">Stand Dummy</th>
    </tr>
    <tr>

        <?php
        // Load file koneksi.php
        include "./include/config.php";

        // Buat query untuk menampilkan semua data siswa
        $unit = $_SESSION['unit'];
        $query = mysqli_query($config, "SELECT * FROM tbl_metdum_pakai WHERE unit LIKE '$unit%' ORDER by tgl_pakai DESC");
        if (mysqli_num_rows($query) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_array($query)) {
                echo '
                <td>' . $no . '</td>
                <td>' . $row['no_dummy'] . '</td>
                <td>' . $row['no_meter_rusak'] . '</td>
                <td>' . $row['alasan_rusak'] . '</td>'
                ;

                $y = substr($row['tgl_pakai'], 0, 4);
                $m = substr($row['tgl_pakai'], 5, 2);
                $d = substr($row['tgl_pakai'], 8, 2);

                if ($m == "01") {
                    $nm = "Januari";
                } elseif ($m == "02") {
                    $nm = "Februari";
                } elseif ($m == "03") {
                    $nm = "Maret";
                } elseif ($m == "04") {
                    $nm = "April";
                } elseif ($m == "05") {
                    $nm = "Mei";
                } elseif ($m == "06") {
                    $nm = "Juni";
                } elseif ($m == "07") {
                    $nm = "Juli";
                } elseif ($m == "08") {
                    $nm = "Agustus";
                } elseif ($m == "09") {
                    $nm = "September";
                } elseif ($m == "10") {
                    $nm = "Oktober";
                } elseif ($m == "11") {
                    $nm = "November";
                } elseif ($m == "12") {
                    $nm = "Desember";
                }
                echo '
                                    <td>' . $d . " " . $nm . " " . $y . '</td>
                                    <td>' . $row['ptgs_pasang'] . '</td>
                                    <td>' . $row['sisa_pulsa'] . '</td>
                                    <td>' . $row['no_hp_plg'] . '</td>
                                    <td>' . $row['std_dummy'] . '</td> '
                . '</tr>';

                $no++; // Tambah 1 setiap kali looping
            }
        }
        ?>
</table>
