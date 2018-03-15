<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if ($_REQUEST['no_dummy'] == "" || $_REQUEST['no_meter_rusak'] == "" || $_REQUEST['no_meter_baru'] == "" || $_REQUEST['id_pelanggan'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_meter = $_REQUEST['id_meter'];
            $no_dummy = $_REQUEST['no_dummy'];
            $no_meter_rusak = $_REQUEST['no_meter_rusak'];
            $no_meter_baru = $_REQUEST['no_meter_baru'];
            $id_pelanggan = $_REQUEST['id_pelanggan'];
            $tgl_aktivasi = date("Y-m-d H:i:s");
            $nama = $_SESSION['nama'];
            $id_user = $_SESSION['id_user'];
            $unit = $_SESSION['unit'];

            //validasi input data
            if (!preg_match("/^[0-9]*$/", $no_dummy)) {
                $_SESSION['no_dummy'] = 'Form Nomor Dummy harus diisi angka!';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[0-9]*$/", $no_meter_rusak)) {
                    $_SESSION['no_meter_rusak'] = 'Form Nomor Meter Rusak harus diisi angka!';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[0-9]*$/", $no_meter_baru)) {
                        $_SESSION['no_meter_baru'] = 'Form No Meter Baru harus diisi angka!';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[0-9]*$/", $id_pelanggan)) {
                            $_SESSION['id_pelanggan'] = 'Form ID Pelanggan harus diisi angka!';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            $query = mysqli_query($config, "INSERT INTO tbl_aktivasi(id_meter,no_dummy,no_meter_rusak,no_meter_baru,id_pelanggan,tgl_aktivasi,nama,id_user,unit)
                                                   VALUES('$id_meter','$no_dummy','$no_meter_rusak','$no_meter_baru','$id_pelanggan','$tgl_aktivasi','$nama','$id_user','$unit')");

                            $query_aktivasi = mysqli_query($config, "UPDATE tbl_metdum_pakai SET aktivasi='aktif' WHERE id_meter='$id_meter'");
                            
                            $query_tgl_aktivasi = mysqli_query($config, "UPDATE tbl_metdum_stok SET tgl_aktivasi='$tgl_aktivasi' WHERE no_dummy='$no_dummy'");

                            if ($query == true) {
                                $_SESSION['succAdd'] = 'SUKSES! Meter berhasil diaktivasi!';
                                header("Location: ./admin.php?page=atv");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query!';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
                        }
                    }
                }
            }
        }
    } else {

        $id_meter = mysqli_real_escape_string($config, $_REQUEST['id_meter']);

        $query = mysqli_query($config, "SELECT no_dummy, no_meter_rusak, alasan_rusak, ptgs_pasang, sisa_pulsa, no_hp_plg, std_dummy, nama, id_user FROM tbl_metdum_pakai WHERE id_meter='$id_meter'");
        list($no_dummy, $no_meter_rusak, $alasan_rusak, $ptgs_pasang, $sisa_pulsa, $no_hp_plg, $std_dummy, $nama, $id_user) = mysqli_fetch_array($query);
        ?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <nav class="secondary-nav">
                    <div class="nav-wrapper blue-grey darken-1">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Aktivasi Meter Baru</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- Secondary Nav END -->
        </div>
        <!-- Row END -->

        <?php
        if (isset($_SESSION['errQ'])) {
            $errQ = $_SESSION['errQ'];
            echo '<div id="alert-message" class="row">
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
        if (isset($_SESSION['errEmpty'])) {
            $errEmpty = $_SESSION['errEmpty'];
            echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> ' . $errEmpty . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
            unset($_SESSION['errEmpty']);
        }
        ?>

        <!-- Row form Start -->
        <div class="row jarak-form">

            <!-- Form START -->
            <form class="col s12" method="POST" action="?page=atv&act=eam" enctype="multipart/form-data">

                <!-- Row in form START -->
                <div class="row">
                    <div class="input-field col s6" data-position="top" >
                        <input type="hidden" name="id_meter" value="<?php echo $id_meter ;?>"> 
                        <input id="no_dummy" type="hidden" class="validate" value="<?php echo $no_dummy; ?>" name="no_dummy" required >
                        <?php
                        if (isset($_SESSION['no_dummy'])) {
                            $no_dummy = $_SESSION['no_dummy'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_dummy . '</div>';
                            unset($_SESSION['no_dummy']);
                        }
                        ?>
                    </div>

                    <div class="input-field col s6" data-position="top">
                        <input id="no_meter_rusak" type="hidden" class="validate" value="<?php echo $no_meter_rusak; ?>" name="no_meter_rusak" required >
                        <?php
                        if (isset($_SESSION['no_meter_rusak'])) {
                            $no_meter_rusak = $_SESSION['no_meter_rusak'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_meter_rusak . '</div>';
                            unset($_SESSION['no_meter_rusak']);
                        }
                        ?>
                    </div>
                    <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                        <i class="material-icons prefix md-prefix">looks_two</i>
                        <input id="no_meter_baru" type="number" class="validate" value="" name="no_meter_baru" required>
                        <?php
                        if (isset($_SESSION['no_meter_baru'])) {
                            $no_meter_baru = $_SESSION['no_meter_baru'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_meter_baru . '</div>';
                            unset($_SESSION['no_meter_baru']);
                        }
                        ?>
                        <label for="no_meter_baru">No. Meter Baru</label>
                    </div>
                    <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                        <i class="material-icons prefix md-prefix">repeat_one</i>
                        <input id="id_pelanggan" type="number" class="validate" value="<?php echo $id_pelanggan; ?>" name="id_pelanggan" required>
                        <?php
                        if (isset($_SESSION['id_pelanggan'])) {
                            $id_pelanggan = $_SESSION['id_pelanggan'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $id_pelanggan . '</div>';
                            unset($_SESSION['id_pelanggan']);
                        }
                        ?>
                        <label for="stand">ID Pelanggan</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col 6">
                        <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">AKTIVASI <i class="material-icons">done</i></button>
                    </div>
                    <div class="col 6">
                        <a href="?page=atv" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                    </div>
                </div>

            </form>
            <!-- Form END -->

        </div>
        <!-- Row form END -->

        <?php
    }
}

?>
