<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {
        $id_meter = $_REQUEST['id_meter'];
        $no_dummy = $_REQUEST['no_dummy'];
        $no_meter_rusak = $_REQUEST['no_meter_rusak'];
        $alasan_rusak = $_REQUEST['alasan_rusak'];
        $tgl_pakai = date("Y-m-d H:i:s");
        $ptgs_pasang = $_REQUEST['ptgs_pasang'];
        $sisa_pulsa = $_REQUEST['sisa_pulsa'];
        $no_hp_plg = $_REQUEST['no_hp_plg'];
        $std_dummy = $_REQUEST['std_dummy'];
        $aktivasi = "non aktif";
        $kembali = "belum";
        $nama = $_SESSION['nama'];
        $id_user = $_SESSION['id_user'];
        $unit = $_SESSION['unit'];



        //validasi input data
        if (!preg_match("/^[0-9]*$/", $no_dummy)) {
            $_SESSION['no_dummy'] = 'Form Nomor Meter harus diisi angka!';
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
                                    
                                    $merk_meter_rusak = substr($no_meter_rusak, 0, 2);

                                    //jika form file tidak kosong akan mengeksekusi script dibawah ini
                                    $query = mysqli_query($config, "INSERT INTO tbl_metdum_pakai(id_meter,no_dummy,no_meter_rusak,merk_meter_rusak,alasan_rusak,tgl_pakai,ptgs_pasang,sisa_pulsa,
                                            no_hp_plg,std_dummy,aktivasi,kembali,nama,id_user,unit)
                                                   VALUES('','$no_dummy','$no_meter_rusak','$merk_meter_rusak','$alasan_rusak','$tgl_pakai','$ptgs_pasang',"
                                            . "'$sisa_pulsa','$no_hp_plg','$std_dummy','$aktivasi','$kembali','$nama','$id_user','$unit')");

                                    $query_status = mysqli_query($config, "UPDATE tbl_metdum_stok SET status='', tgl_pakai='$tgl_pakai', no_meter_rusak='$no_meter_rusak' WHERE no_dummy='$no_dummy'");

                                    if ($query == true) {
                                        $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
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
    } else {
        ?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <nav class="secondary-nav">
                    <div class="nav-wrapper blue-grey darken-1">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="?page=mdg&act=add" class="judul"><i class="material-icons">description</i> Tambah Data Pemakaian Dummy</a></li>
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

            <?php
            $query_stok = mysqli_query($config, "SELECT * FROM tbl_metdum_stok WHERE status='ready' ORDER BY no_dummy");
            ?>

            <!-- Form START -->
            <form class="col s12" method="POST" action="?page=mdg&act=add" enctype="multipart/form-data">

                <!-- Row in form START -->
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">looks_one</i><label>Pilih No. Dummy</label><br/>
                        <div class="input-field col s11 right">
                        <select id="no_dummy" type="number" class="browser-default validate" name="no_dummy" required>
                            <option value="" disabled selected> -----</option>
                            <?php if (mysqli_num_rows($query_stok) > 0) {
                                while ($row = mysqli_fetch_array($query_stok)) {
                                    ?>
                                    <option value="<?php echo $row['no_dummy'] ?>"><?php echo $row['no_dummy'] ?></option> <?php
                                }
                            }
                            ?>
                        </select>
                        </div>
                        <?php
                        if (isset($_SESSION['no_dummy'])) {
                            $no_meter = $_SESSION['no_dummy'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_dummy . '</div>';
                            unset($_SESSION['no_dummy']);
                        }
                        ?>
                    </div>
                    
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">looks_one</i><label>Alasan Rusak</label><br/>
                        <div class="input-field col s11 right">
                        <select id="alasan_rusak" type="number" class="browser-default validate" name="alasan_rusak" required>
                            <option value="" disabled selected> -----</option>
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
                    
                    <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                        <i class="material-icons prefix md-prefix">looks_two</i>
                        <input id="no_meter_rusak" type="number" class="validate" name="no_meter_rusak" required>
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
                        <i class="material-icons prefix md-prefix">person</i>
                        <input id="ptgs_pasang" type="text" class="validate" name="ptgs_pasang" required>
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
                        <input id="sisa_pulsa" type="number" class="validate" name="sisa_pulsa" required>
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
                        <input id="no_hp_plg" type="number" class="validate" name="no_hp_plg" required>
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
                        <input id="std_dummy" type="number" class="validate" name="std_dummy" required>
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
                <!-- Row in form END -->

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
