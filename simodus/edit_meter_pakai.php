<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if ($_REQUEST['no_meter'] == "" || $_REQUEST['no_meter_rusak'] == "" || $_REQUEST['alasan_rusak'] == "" || $_REQUEST['ptgs_pasang'] == "" || $_REQUEST['sisa_pulsa'] == "" || $_REQUEST['no_hp_plg'] == "" || $_REQUEST['std_dummy'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_meter = $_REQUEST['id_meter'];
            $no_meter = $_REQUEST['no_meter'];
            $no_meter_rusak = $_REQUEST['no_meter_rusak'];
            $alasan_rusak = $_REQUEST['alasan_rusak'];
            $tgl_pakai = date("Y-m-d");
            $ptgs_pasang = $_REQUEST['ptgs_pasang'];
            $sisa_pulsa = $_REQUEST['sisa_pulsa'];
            $no_hp_plg = $_REQUEST['no_hp_plg'];
            $std_dummy = $_REQUEST['std_dummy'];
            $username = $_SESSION['username'];
            $id_user = $_SESSION['id_user'];

            //validasi input data
            if (!preg_match("/^[0-9]*$/", $no_meter)) {
                $_SESSION['no_meter'] = 'Form Nomor Meter harus diisi angka!';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[0-9]*$/", $no_meter_rusak)) {
                    $_SESSION['no_meter_rusak'] = 'Form Nomor Meter Rusak harus diisi angka!';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $alasan_rusak)) {
                        $_SESSION['alasan_rusak'] = 'Form Alasan Rusak hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $ptgs_pasang)) {
                            $_SESSION['ptgs_pasang'] = 'Form Petugas Pasang hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if (!preg_match("/^[0-9]*$/", $sisa_pulsa)) {
                                $_SESSION['sisa_pulsa'] = 'Form Sisa Pulsa harus diisi angka!';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                if (!preg_match("/^[0-9]*$/", $no_hp_plg)) {
                                    $_SESSION['no_hp_plg'] = 'Form Nomor HP Pelanggan harus diisi angka!';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {

                                    if (!preg_match("/^[0-9]*$/", $std_dummy)) {
                                        $_SESSION['std_dummy'] = 'Form Stand Dummy harus diisi angka!';
                                        echo '<script language="javascript">window.history.back();</script>';
                                    } else {

                                        $id_meter = mysqli_real_escape_string($config, $_REQUEST['id_meter']);

                                        //jika form file tidak kosong akan mengeksekusi script dibawah ini
                                        $query = mysqli_query($config, "UPDATE tbl_metdum_pakai SET no_meter='$no_meter', no_meter_rusak='$no_meter_rusak', alasan_rusak='$alasan_rusak', "
                                                . "ptgs_pasang='$ptgs_pasang', sisa_pulsa='$sisa_pulsa', no_hp_plg='$no_hp_plg', std_dummy='$std_dummy' WHERE no_meter='$no_meter'");

                                        if ($query == true) {
                                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil diperbarui';
                                            header("Location: ./admin.php?page=mdg");
                                            die();
                                        } else {
                                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                            echo '<script language="javascript">window.history.back();</script>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    } else {

        $id_meter = mysqli_real_escape_string($config, $_REQUEST['id_meter']);

        $query = mysqli_query($config, "SELECT no_meter, no_meter_rusak, alasan_rusak, ptgs_pasang, sisa_pulsa, no_hp_plg, std_dummy, username, id_user FROM tbl_metdum_pakai WHERE id_meter='$id_meter'");
        list($no_meter, $no_meter_rusak, $alasan_rusak, $ptgs_pasang, $sisa_pulsa, $no_hp_plg, $std_dummy, $username, $id_user) = mysqli_fetch_array($query);
        ?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <nav class="secondary-nav">
                    <div class="nav-wrapper blue-grey darken-1">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit Data Meter Dipakai</a></li>
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
            <form class="col s12" method="POST" action="?page=mdg&act=edit" enctype="multipart/form-data">
                
            <!-- Row in form START -->
            <div class="row">
                <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <input id="no_meter" type="number" class="validate" value="<?php echo $no_meter; ?>" name="no_meter" required>
                    <?php
                    if (isset($_SESSION['no_meter'])) {
                        $no_meter = $_SESSION['no_meter'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_meter . '</div>';
                        unset($_SESSION['no_meter']);
                    }
                    ?>
                    <label for="no_meter">No. Dummy</label>
                </div>

                <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                    <i class="material-icons prefix md-prefix">looks_two</i>
                    <input id="no_meter_rusak" type="number" class="validate" value="<?php echo $no_meter_rusak; ?>" name="no_meter_rusak" required>
                    <?php
                    if (isset($_SESSION['no_meter_rusak'])) {
                        $no_meter_rusak = $_SESSION['no_meter_rusak'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_meter_rusak . '</div>';
                        unset($_SESSION['no_meter_rusak']);
                    }
                    ?>
                    <label for="no_meter_rusak">No. Meter Rusak</label>
                </div>
                <div class="input-field col s6" data-position="top">
                    <i class="material-icons prefix md-prefix">report_problem</i>
                    <input id="alasan_rusak" type="text" class="validate" value="<?php echo $alasan_rusak; ?>" name="alasan_rusak" required>
                    <?php
                    if (isset($_SESSION['alasan_rusak'])) {
                        $alasan_rusak = $_SESSION['alasan_rusak'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $alasan_rusak . '</div>';
                        unset($_SESSION['alasan_rusak']);
                    }
                    ?>
                    <label for="stand">Alasan Rusak</label>
                </div>
                <div class="input-field col s6" data-position="top">
                    <i class="material-icons prefix md-prefix">person</i>
                    <input id="ptgs_pasang" type="text" class="validate" value="<?php echo $ptgs_pasang; ?>" name="ptgs_pasang" required>
                    <?php
                    if (isset($_SESSION['ptgs_pasang'])) {
                        $ptgs_pasang = $_SESSION['ptgs_pasang'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $ptgs_pasang . '</div>';
                        unset($_SESSION['ptgs_pasang']);
                    }
                    ?>
                    <label for="stand">Petugas Pasang</label>
                </div>
                <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                    <i class="material-icons prefix md-prefix">repeat_one</i>
                    <input id="sisa_pulsa" type="number" class="validate" value="<?php echo $sisa_pulsa; ?>" name="sisa_pulsa" required>
                    <?php
                    if (isset($_SESSION['sisa_pulsa'])) {
                        $sisa_pulsa = $_SESSION['sisa_pulsa'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $sisa_pulsa . '</div>';
                        unset($_SESSION['sisa_pulsa']);
                    }
                    ?>
                    <label for="stand">Sisa Pulsa</label>
                </div>
                <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                    <i class="material-icons prefix md-prefix">phone_iphone</i>
                    <input id="no_hp_plg" type="number" class="validate" value="<?php echo $no_hp_plg; ?>" name="no_hp_plg" required>
                    <?php
                    if (isset($_SESSION['no_hp_plg'])) {
                        $no_hp_plg = $_SESSION['no_hp_plg'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_hp_plg . '</div>';
                        unset($_SESSION['no_hp_plg']);
                    }
                    ?>
                    <label for="stand">No. HP Pelanggan</label>
                </div>
                <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                    <i class="material-icons prefix md-prefix">looks_3</i>
                    <input id="std_dummy" type="number" class="validate" value="<?php echo $std_dummy; ?>" name="std_dummy" required>
                    <?php
                    if (isset($_SESSION['std_dummy'])) {
                        $std_dummy = $_SESSION['std_dummy'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $std_dummy . '</div>';
                        unset($_SESSION['std_dummy']);
                    }
                    ?>
                    <label for="stand">Stand Dummy</label>
                </div>
            </div>
            <div class="row">
                <div class="col 6">
                    <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                </div>
                <div class="col 6">
                    <a href="?page=mdg" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
