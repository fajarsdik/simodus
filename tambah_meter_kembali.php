<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if ($_SESSION['admin'] != 1 AND $_SESSION['admin'] AND $_SESSION['admin'] != 5) {
        echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./admin.php";
                  </script>';
    } else {

        if (isset($_REQUEST['submit'])) {

            $id_meter = $_REQUEST['id_meter'];
            $no_dummy = $_REQUEST['no_dummy'];
            $lokasi_posko = $_REQUEST['lokasi_posko'];
            $nama_cc = $_REQUEST['nama_cc'];
            $stand = $_REQUEST['stand'];
            $tgl_kbl = date("Y-m-d H:i:s");
            $nama = $_SESSION['nama'];
            $id_user = $_SESSION['id_user'];
            $unit = $_SESSION['unit'];

            //validasi input data
            if (!preg_match("/^[0-9]*$/", $no_dummy)) {
                $_SESSION['no_dummy'] = 'Form Nomor Dummy harus diisi angka!';
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
                            $query = mysqli_query($config, "INSERT INTO tbl_metdum_kbl(id_meter,no_dummy,lokasi_posko,nama_cc,stand,tgl_kbl,nama,id_user,unit)
                                                   VALUES('$id_meter','$no_dummy','$lokasi_posko','$nama_cc','$stand','$tgl_kbl','$nama','$id_user','$unit')");

                            $query_kembali = mysqli_query($config, "UPDATE tbl_metdum_pakai SET kembali='sudah' WHERE id_meter='$id_meter'");

                            $query_tgl_aktivasi = mysqli_query($config, "UPDATE tbl_metdum_stok SET tgl_kbl='$tgl_kbl', status='ready', no_meter_rusak='' WHERE no_dummy='$no_dummy'");

                            if ($query == true) {
                                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
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
        } else {
            ?>

            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue-grey darken-1">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="?page=mdk&act=add" class="judul"><i class="material-icons">description</i> Tambah Data Meter Kembali</a></li>
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
                $unit = $_SESSION['unit'];

                $query_id = mysqli_query($config, "SELECT id_meter FROM tbl_metdum_pakai WHERE aktivasi='aktif' && kembali='belum' && unit LIKE '$unit%' ORDER BY tgl_pakai DESC");
                list($id_meter) = mysqli_fetch_array($query_id);

                $query_stok = mysqli_query($config, "SELECT * FROM tbl_metdum_pakai WHERE aktivasi='aktif' && kembali='belum' && unit LIKE '$unit%' ORDER BY tgl_pakai DESC");
                ?>
                <!-- Form START -->
                <form class="col s12" method="POST" action="?page=mdk&act=add" enctype="multipart/form-data">

                    <!-- Row in form START -->
                    <div class="row">
                        <div class="input-field col s6">
                            <input type="hidden" name="id_meter" value="<?php echo $id_meter; ?>">
                            <i class="material-icons prefix md-prefix">looks_one</i><label>Pilih No. Dummy</label><br/>
                            <div class="input-field col s11 right">
                                <select id="no_dummy" type="number" class="browser-default validate" name="no_dummy" required>
                                    <option value="" disabled selected> -----</option>
                                    <?php
                                    if (mysqli_num_rows($query_stok) > 0) {
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
                                $no_dummy = $_SESSION['no_dummy'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_dummy . '</div>';
                                unset($_SESSION['no_dummy']);
                            }
                            ?>
                            <label for="no_meter"></label>
                        </div>
                        <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                            <i class="material-icons prefix md-prefix">looks_two</i>
                            <input id="stand" type="number" class="validate" name="stand" required>
                            <?php
                            if (isset($_SESSION['stand'])) {
                                $stand = $_SESSION['stand'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $stand . '</div>';
                                unset($_SESSION['stand']);
                            }
                            ?>
                            <label for="stand">Stand Bongkar</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">home</i>
                            <input id="lokasi_posko" type="text" class="validate" name="lokasi_posko" required>
                            <?php
                            if (isset($_SESSION['lokasi_posko'])) {
                                $lokasi_posko = $_SESSION['lokasi_posko'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $lokasi_posko . '</div>';
                                unset($_SESSION['lokasi_posko']);
                            }
                            ?>
                            <label for="lokasi_posko">Lokasi Posko</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">face</i>
                            <input id="nama_cc" type="text" class="validate" name="nama_cc" required>
                            <?php
                            if (isset($_SESSION['nama_cc'])) {
                                $nama_cc = $_SESSION['nama_cc'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_cc . '</div>';
                                unset($_SESSION['nama_cc']);
                            }
                            ?>
                            <label for="nama_cc">Nama Call Center</label>
                        </div>

                    </div>
                    <!-- Row in form END -->

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
}
?>
