<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if ($_REQUEST['no_meter_rusak'] == "" || $_REQUEST['alasan_rusak'] == "" || $_REQUEST['ptgs_pasang'] == "" || $_REQUEST['sisa_pulsa'] == "" || $_REQUEST['no_hp_plg'] == "" || $_REQUEST['std_dummy'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_meter = $_REQUEST['id_meter'];
            $no_meter_rusak = $_REQUEST['no_meter_rusak'];
            $alasan_rusak = $_REQUEST['alasan_rusak'];
            $tgl_pakai = date("Y-m-d");
            $ptgs_pasang = $_REQUEST['ptgs_pasang'];
            $sisa_pulsa = $_REQUEST['sisa_pulsa'];
            $no_hp_plg = $_REQUEST['no_hp_plg'];
            $std_dummy = $_REQUEST['std_dummy'];
            $nama = $_SESSION['nama'];
            $id_user = $_SESSION['id_user'];

            //validasi input data
            if (!preg_match("/^[0-9]*$/", $no_dummy)) {
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

                                        $query = mysqli_query($config, "UPDATE tbl_metdum_pakai SET no_meter_rusak='$no_meter_rusak', alasan_rusak='$alasan_rusak', "
                                                . "ptgs_pasang='$ptgs_pasang', sisa_pulsa='$sisa_pulsa', no_hp_plg='$no_hp_plg', std_dummy='$std_dummy' WHERE id_meter='$id_meter'");

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

        $query = mysqli_query($config, "SELECT no_dummy, no_meter_rusak,  alasan_rusak, ptgs_pasang, sisa_pulsa, no_hp_plg, std_dummy, nama, id_user FROM tbl_metdum_pakai WHERE id_meter='$id_meter'");
        list($no_dummy, $no_meter_rusak, $alasan_rusak, $ptgs_pasang, $sisa_pulsa, $no_hp_plg, $std_dummy, $nama, $id_user) = mysqli_fetch_array($query);
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
                        <input type="hidden" name="id_meter" value="<?php echo $id_meter; ?>">
                        <i class="material-icons prefix md-prefix">looks_two</i>
                        <input id="no_meter_rusak" type="number" class="validate" value="<?php echo $no_meter_rusak; ?>" name="no_meter_rusak" required>
                        <?php
                        if (isset($_SESSION['no_meter_rusak1'])) {
                            $no_meter_rusak1 = $_SESSION['no_meter_rusak1'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_meter_rusak1 . '</div>';
                            unset($_SESSION['no_meter_rusak1']);
                        }
                        ?>
                        <label for="no_meter_rusak">No. Meter Rusak</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">looks_one</i><label>Alasan Rusak</label><br/>
                        <div class="input-field col s11 right">
                            <select id="alasan_rusak" type="number" class="browser-default validate" name="alasan_rusak" required>
                                <option value="<?php echo $alasan_rusak; ?>" disabled selected> -----</option>
                                <option value="1">Token tidak dapat dimasukkan</option>
                                <option value="2">Sisa kredit pada kWh meter hilang/bertambah saat listrik padam</option>
                                <option value="3">Kerusakan pada keypad</option>
                                <option value="4">LCD mati/rusak</option>
                                <option value="5">kWh Meter rusak (akibat petir/terbakar)</option>
                                <option value="6">Sisa kredit tidak bertambah saat kredit baru dimasukkan</option>
                                <option value="7">Baut tutup terminal patah</option>
                                <option value="8">Tegangan dibawah 180V tidak bisa hidup</option>
                                <option value="9">Micro switch rusak / tidak keluar tegangan</option>
                                <option value="10">ID meter pada display dan nameplate tidak sama</option>
                                <option value="11">Sisa kredit tidak berkurang</option>
                                <option value="12">Display overload tanpa beban</option>
                                <option value="13">Terminal kWh meter rusak</option>
                                <option value="14">Meter periksa/tutup dibuka lampu tetap nyala</option>
                                <option value="15">Timbul rusak</option>
                                <option value="16">kWh minus</option>
                                <option value="17">kWh bertambah</option>
                                <option value="18">Lain-lain</option>
                            </select>
                        </div>
                        <?php
                        if (isset($_SESSION['alasan_rusak'])) {
                            $alasan_rusak = $_SESSION['alasan_rusak'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $alasan_rusak . '</div>';
                            unset($_SESSION['alasan_rusak']);
                        }
                        ?>
                    </div>
                    <div class="input-field col s6" data-position="top">
                        <i class="material-icons prefix md-prefix">person</i>
                        <input id="ptgs_pasang" type="text" class="validate" value="<?php echo $ptgs_pasang; ?>" name="ptgs_pasang" required>
                        <?php
                        if (isset($_SESSION['ptgs_pasang1'])) {
                            $ptgs_pasang1 = $_SESSION['ptgs_pasang1'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $ptgs_pasang1 . '</div>';
                            unset($_SESSION['ptgs_pasang1']);
                        }
                        ?>
                        <label for="stand">Petugas Pasang</label>
                    </div>
                    <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                        <i class="material-icons prefix md-prefix">repeat_one</i>
                        <input id="sisa_pulsa" type="number" class="validate" value="" name="sisa_pulsa" required>
                        <?php
                        if (isset($_SESSION['sisa_pulsa1'])) {
                            $sisa_pulsa1 = $_SESSION['sisa_pulsa1'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $sisa_pulsa1 . '</div>';
                            unset($_SESSION['sisa_pulsa1']);
                        }
                        ?>
                        <label for="stand">Sisa Pulsa</label>
                    </div>
                    <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                        <i class="material-icons prefix md-prefix">phone_iphone</i>
                        <input id="no_hp_plg" type="number" class="validate" value="<?php echo $no_hp_plg; ?>" name="no_hp_plg" required>
                        <?php
                        if (isset($_SESSION['no_hp_plg1'])) {
                            $no_hp_plg1 = $_SESSION['no_hp_plg1'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_hp_plg1 . '</div>';
                            unset($_SESSION['no_hp_plg1']);
                        }
                        ?>
                        <label for="stand">No. HP Pelanggan</label>
                    </div>
                    <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                        <i class="material-icons prefix md-prefix">looks_3</i>
                        <input id="std_dummy" type="number" class="validate" value="" name="std_dummy" required>
                        <?php
                        if (isset($_SESSION['std_dummy1'])) {
                            $std_dummy1 = $_SESSION['std_dummy1'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $std_dummy1 . '</div>';
                            unset($_SESSION['std_dummy1']);
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
