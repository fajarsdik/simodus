<?php

echo '
    
    <table class="bordered" id="tbl">
    <thead class="blue lighten-4" id="head">
    <tr>
        <th width="10%" style="text-align: center">No. Dummy</th>
        <th width="15%" style="text-align: center">No. Meter Rusak</th>
        <th width="15%" style="text-align: center">Tgl Pakai</th>
        <th width="15%" style="text-align: center">Tgl Aktivasi</th>
        <th width="15%" style="text-align: center">Tgl Kembali</th>    
    </tr>
    </thead>
    <tbody>
    <tr>';

//script untuk menampilkan data
$unit = $_SESSION['unit'];

$query = mysqli_query($config, "SELECT * FROM tbl_metdum_stok WHERE unit LIKE '$unit%' ORDER by no_dummy");
if (mysqli_num_rows($query) > 0) {
    $no = 1;
    while ($row = mysqli_fetch_array($query)) {
        echo '
            <td style="text-align: center">' . $row['no_dummy'] . '</td>
            <td style="text-align: center">' . $row['no_meter_rusak'] . '</td>'
        ;
        
        //perhitungan tgl pakai
        if(empty($row['tgl_pakai'])) {
            echo '<td style="text-align: center"></td>';
        } else {

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
            <td style="text-align: center">' . $d . " " . $nm . " " . $y . '</td>';
        }
        
        //perhitungan tgl aktivasi
        if($row['tgl_aktivasi'] < $row['tgl_pakai']) {
            echo '<td style="text-align: center"></td>';
        } elseif(empty($row['tgl_pakai'])) {
            echo '<td style="text-align: center"></td>';
        }
        else {
            
            $y = substr($row['tgl_aktivasi'], 0, 4);
            $m = substr($row['tgl_aktivasi'], 5, 2);
            $d = substr($row['tgl_aktivasi'], 8, 2);

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
            <td style="text-align: center">' . $d . " " . $nm . " " . $y . '</td>';
        }
        
        //perhitungan tgl kembali
        if($row['tgl_kbl'] < $row['tgl_aktivasi']) {
            echo '<td style="text-align: center"> </td>';
        } elseif(empty($row['tgl_aktivasi'])) {
            echo '<td style="text-align: center"> </td>';
        }
        else {
            
            $y = substr($row['tgl_kbl'], 0, 4);
            $m = substr($row['tgl_kbl'], 5, 2);
            $d = substr($row['tgl_kbl'], 8, 2);

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
            <td style="text-align: center">' . $d . " " . $nm . " " . $y . '</td>';
        }
        
        echo '
                    
                </tr>
            </tbody>';
    }
} else {
    echo '<tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan.</p></center></td></tr>';
}
echo '</table>
    </div>

            <!-- Row form END -->';
?>