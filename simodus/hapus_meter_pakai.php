<?php

//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_SESSION['errQ'])) {
        $errQ = $_SESSION['errQ'];
        echo '<div id="alert-message" class="row jarak-card">
                    <div class="col m12">
                        <div class="card red lighten-5">
                            <div class="card-content notif">
                                <span class="card-title red-text"><i class="material-icons md-36">clear</i> ' . $errQ . '</span>
                            </div>
                        </div>
                    </div>
                </div>';
        unset($_SESSION['errQ']);
    }

    $id_meter = $_REQUEST['id_meter'];
    $query = mysqli_query($config, "SELECT * FROM tbl_metdum_pakai WHERE id_meter='$id_meter'");

    if (mysqli_num_rows($query) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_array($query)) {

            if ($_SESSION['id_user'] != $row['id_user'] AND $_SESSION['id_user'] != 1) {
                echo '<script language="javascript">
                        window.alert("ERROR! Anda tidak memiliki hak akses untuk menghapus data ini");
                        window.location.href="./admin.php?page=mdg";
                      </script>';
            } else {

                if ($row['merk_meter_rusak'] == 14) {
                    $merk_meter_rusak = 'Hexing';
                } else if ($row['merk_meter_rusak'] == 86) {
                    $merk_meter_rusak = 'Smart Meter';
                } else if ($row['merk_meter_rusak'] == 45) {
                    $merk_meter_rusak = 'Sanxing';
                } else if ($row['merk_meter_rusak'] == 22) {
                    $merk_meter_rusak = 'Star';
                } else if ($row['merk_meter_rusak'] == 60) {
                    $merk_meter_rusak = 'FDE';
                } else if ($row['merk_meter_rusak'] == 32) {
                    $merk_meter_rusak = 'Itron';
                } else if ($row['merk_meter_rusak'] == 34) {
                    $merk_meter_rusak = 'Glomet';
                } else if ($row['merk_meter_rusak'] == 01) {
                    $merk_meter_rusak = 'Hexing (Lama)';
                }

                if ($row['alasan_rusak'] == 1) {
                    $alasan_rusak = "Token tidak dapat dimasukkan";
                } else if ($row['alasan_rusak'] == 2) {
                    $alasan_rusak = "Sisa kredit pada kWh meter hilang/bertambah saat listrik padam";
                } else if ($row['alasan_rusak'] == 3) {
                    $alasan_rusak = "Kerusakan pada keypad";
                } else if ($row['alasan_rusak'] == 4) {
                    $alasan_rusak = "LCD mati/rusak";
                } else if ($row['alasan_rusak'] == 5) {
                    $alasan_rusak = "kWh Meter rusak (akibat petir/terbakar)";
                } else if ($row['alasan_rusak'] == 6) {
                    $alasan_rusak = "Sisa kredit tidak bertambah saat kredit baru dimasukkan";
                } else if ($row['alasan_rusak'] == 7) {
                    $alasan_rusak = "Baut tutup terminal patah";
                } else if ($row['alasan_rusak'] == 8) {
                    $alasan_rusak = "Tegangan dibawah 180V tidak bisa hidup";
                } else if ($row['alasan_rusak'] == 9) {
                    $alasan_rusak = "Micro switch rusak / tidak keluar tegangan";
                } else if ($row['alasan_rusak'] == 10) {
                    $alasan_rusak = "ID meter pada display dan nameplate tidak sama";
                } else if ($row['alasan_rusak'] == 11) {
                    $alasan_rusak = "Sisa kredit tidak berkurang";
                } else if ($row['alasan_rusak'] == 12) {
                    $alasan_rusak = "Display overload tanpa beban";
                } else if ($row['alasan_rusak'] == 13) {
                    $alasan_rusak = "Terminal kWh meter rusak";
                } else if ($row['alasan_rusak'] == 14) {
                    $alasan_rusak = "Meter periksa/tutup dibuka lampu tetap nyala";
                } else if ($row['alasan_rusak'] == 15) {
                    $alasan_rusak = "Timbul rusak";
                } else if ($row['alasan_rusak'] == 16) {
                    $alasan_rusak = "kWh minus";
                } else if ($row['alasan_rusak'] == 17) {
                    $alasan_rusak = "kWh bertambah";
                } else if ($row['alasan_rusak'] == 18) {
                    $alasan_rusak = "Lain-lain";
                }

                echo '
                <!-- Row form Start -->
				<div class="row jarak-card">
				    <div class="col m12">
                    <div class="card">
                        <div class="card-content">
				        <table>
				            <thead class="red lighten-5 red-text">
				                <div class="confir red-text"><i class="material-icons md-36">error_outline</i>
				                Apakah Anda yakin akan menghapus data ini?</div>
				            </thead>

				            <tbody>
				                <tr>
				                    <td width="13%">No. Dummy</td>
				                    <td width="1%">:</td>
				                    <td width="86%">' . $row['no_dummy'] . '</td>
				                </tr>
				                <tr>
				                    <td width="13%">No. Meter Rusak</td>
				                    <td width="1%">:</td>
				                    <td width="86%">' . $row['no_meter_rusak'] . '</td>
				                </tr>
                                                <tr>
				                    <td width="13%">Merk Meter Rusak</td>
				                    <td width="1%">:</td>
				                    <td width="86%">' . $merk_meter_rusak . '</td>
				                </tr>
                                                <tr>
                                                    <td width="13%">Alasan Rusak</td>
                                                    <td width="1%">:</td>
                                                    <td width="86%">' . $alasan_rusak . '</td>
                                                </tr>
                                                <tr>
                                                    <td width="13%">Tanggal Pakai</td>
                                                    <td width="1%">:</td>
                                                    <td width="86%">' . $tgl = date('d M Y ', strtotime($row['tgl_pakai'])) . '</td>
                                                </tr>
                                                <tr>
                                                    <td width="13%">Petugas Pasang</td>
                                                    <td width="1%">:</td>
                                                    <td width="86%">' . $row['ptgs_pasang'] . '</td>
                                                </tr>
                                                <tr>
                                                    <td width="13%">Sisa Pulsa</td>
                                                    <td width="1%">:</td>
                                                    <td width="86%">' . $row['sisa_pulsa'] . '</td>
                                                </tr>
                                                <tr>
                                                    <td width="13%">No. HP Pelanggan</td>
                                                    <td width="1%">:</td>
                                                    <td width="86%">' . $row['no_hp_plg'] . '</td>
                                                </tr>
                                                <tr>
                                                    <td width="13%">Stand Dummy</td>
                                                    <td width="1%">:</td>
                                                    <td width="86%">' . $row['std_dummy'] . '</td>
                                                </tr>
    			               
    			            </tbody>
    			   	</table>
                        </div>
                        <div class="card-action">
        	                <a href="?page=mdg&act=del&submit=yes&id_meter=' . $row['id_meter'] . '" class="btn-large deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
        	                <a href="?page=mdg" class="btn-large blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
    	                </div>
    	            </div>
                </div>
            </div>
            <!-- Row form END -->';

                if (isset($_REQUEST['submit'])) {
                    $id_meter = $_REQUEST['id_meter'];

                    $query = mysqli_query($config, "DELETE FROM tbl_metdum_pakai WHERE id_meter='$id_meter'");

                    if ($query == true) {
                        $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                        header("Location: ./admin.php?page=mdg");
                        die();
                    } else {
                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                        echo '<script language="javascript">
                                    window.location.href="./admin.php?page=mdg&act=del&id_meter=' . $id_meter . '";
                                  </script>';
                    }
                }
            }
        }
    }
}
?>
