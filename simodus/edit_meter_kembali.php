<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if ($_REQUEST['no_meter'] == "" || $_REQUEST['lokasi_posko'] == "" || $_REQUEST['nama_cc'] == "" || $_REQUEST['stand'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_meter = $_REQUEST['id_meter'];
            $no_meter = $_REQUEST['no_meter'];
            $lokasi_posko = $_REQUEST['lokasi_posko'];
            $nama_cc = $_REQUEST['nama_cc'];
            $stand = $_REQUEST['stand'];
            $tgl_kbl = $_REQUEST['tgl_kbl'];
            $username = $_SESSION['username'];
            $id_user = $_SESSION['id_user'];

            //validasi input data
            if (!preg_match("/^[0-9]*$/", $no_meter)) {
                $_SESSION['no_agenda'] = 'Form Nomor Meter harus diisi angka!';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[0-9]*$/", $stand)) {
                    $_SESSION['stand'] = 'Form Stand Bongkar harus diisi angka!';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $lokasi_posko)) {
                        $_SESSION['lokasi_posko'] = 'Form Lokasi Posko hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $nama_cc)) {
                            $_SESSION['nama_cc'] = 'Form Nama Call Center hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            //jika form file tidak kosong akan mengeksekusi script dibawah ini
                            $query = mysqli_query($config, "UPDATE tbl_metdum_kbl SET no_meter='$no_meter', lokasi_posko='$lokasi_posko', nama_cc='$nama_cc',"
                                    . "stand='$stand' WHERE no_meter='$no_meter'");

                            if ($query == true) {
                                $_SESSION['succAdd'] = 'SUKSES! Data berhasil diperbarui';
                                header("Location: ./admin.php?page=mdk");
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
    } else {

        $id_meter = $_REQUEST['id_meter'];
        
        $query = mysqli_query($config, "SELECT no_meter, lokasi_posko, nama_cc, stand, tgl_kbl, username, id_user FROM tbl_metdum_kbl WHERE id_meter='$id_meter'");
        list($no_meter, $lokasi_posko, $nama_cc, $stand, $tgl_kbl, $username, $id_user) = mysqli_fetch_array($query);
        ?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <nav class="secondary-nav">
                    <div class="nav-wrapper blue-grey darken-1">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit Data Meter Kembali</a></li>
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
            <form class="col s12" method="POST" action="?page=mdk&act=edit" enctype="multipart/form-data">

                <!-- Row in form START -->
                <div class="row">
                    <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                        <input type="hidden" name="no_meter" value="<?php echo $no_meter; ?>">
                        <i class="material-icons prefix md-prefix">looks_one</i>
                        <input id="no_meter" type="number" class="validate" value="<?php echo $no_meter; ?>" name="no_meter" required>
                        <?php
                        if (isset($_SESSION['no_meter'])) {
                            $no_meter = $_SESSION['no_meter'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_meter . '</div>';
                            unset($_SESSION['no_meter']);
                        }
                        ?>
                        <label for="no_meter">Nomor Meter</label>
                    </div>
                    <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                        <input type="hidden" name="stand" value="<?php echo $stand; ?>">
                        <i class="material-icons prefix md-prefix">looks_two</i>
                        <input id="stand" type="number" class="validate" value="<?php echo $stand; ?>" name="stand" required>
                        <?php
                        if (isset($_SESSION['stand'])) {
                            $stand = $_SESSION['stand'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $stand . '</div>';
                            unset($_SESSION['stand']);
                        }
                        ?>
                        <label for="stand">Stand Bongkar</label>
                    </div>
                    <div class="input-field col s6" data-position="top">
                        <input type="hidden" name="lokasi_posko" value="<?php echo $lokasi_posko; ?>">
                        <i class="material-icons prefix md-prefix">home</i>
                        <input id="lokasi_posko" type="text" class="validate" value="<?php echo $lokasi_posko; ?>" name="lokasi_posko" required>
                        <?php
                        if (isset($_SESSION['lokasi_posko'])) {
                            $lokasi_posko = $_SESSION['lokasi_posko'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $lokasi_posko . '</div>';
                            unset($_SESSION['lokasi_posko']);
                        }
                        ?>
                        <label for="lokasi_posko">Lokasi Posko</label>
                    </div>
                    <div class="input-field col s6" data-position="top">
                        <input type="hidden" name="nama_cc" value="<?php echo $nama_cc; ?>">
                        <i class="material-icons prefix md-prefix">face</i>
                        <input id="nama_cc" type="text" class="validate" value="<?php echo $nama_cc; ?>" name="nama_cc" required>
                        <?php
                        if (isset($_SESSION['nama_cc'])) {
                            $nama_cc = $_SESSION['nama_cc'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_cc . '</div>';
                            unset($_SESSION['nama_cc']);
                        }
                        ?>
                        <label for="nama_cc">Nama Call Center</label>
                    </div>


                    <div class="row">
                        <div class="col 6">
                            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                        </div>
                        <div class="col 6">
                            <a href="?page=mdk" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
