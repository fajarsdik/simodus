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
				                    <td width="13%">No. Meter</td>
				                    <td width="1%">:</td>
				                    <td width="86%">' . $row['no_meter'] . '</td>
				                </tr>
				                <tr>
				                    <td width="13%">No. Meter Rusak</td>
				                    <td width="1%">:</td>
				                    <td width="86%">' . $row['no_meter_rusak'] . '</td>
				                </tr>
                                                    <td width="13%">Alasan Rusak</td>
                                                    <td width="1%">:</td>
                                                    <td width="86%">' . $row['alasan_rusak'] . '</td>
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
