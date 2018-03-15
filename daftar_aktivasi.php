<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if ($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 2 AND $_SESSION['admin'] != 3 AND $_SESSION['admin'] != 4 AND $_SESSION['admin'] != 5) {
        echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
    } else {

        if (isset($_REQUEST['act'])) {
            $act = $_REQUEST['act'];
            switch ($act) {
                case 'eam':
                    include "aktivasi.php";
                    break;
            }
        } else {

            $query = mysqli_query($config, "SELECT dft_aktivasi FROM tbl_sett");
            list($dft_aktivasi) = mysqli_fetch_array($query);

            //pagging
            $limit = $dft_aktivasi;
            $pg = @$_GET['pg'];
            if (empty($pg)) {
                $curr = 0;
                $pg = 1;
            } else {
                $curr = ($pg - 1) * $limit;
            }
            ?>

            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <div class="z-depth-1">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue-grey darken-1">
                                <div class="col m7">
                                    <ul class="left">
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=atv" class="judul"><i class="material-icons">kitchen</i> Aktivasi Meter</a></li>
                                        <li class="waves-effect waves-light hide-on-small-only  active"><a href="?page=dft_atv" class="judul"><i class="material-icons">done_all</i> History Aktivasi</a></li>
                                    </ul>
                                </div>
                                <div class="col m4 hide-on-med-and-down">
                                    <form method="post" action="?page=dft_atv">
                                        <div class="input-field round-in-box">
                                            <input id="search" type="search" name="cari" placeholder="Pencarian data..." required>
                                            <label for="search"><i class="material-icons">search</i></label>
                                            <input type="submit" name="submit" class="hidden">
                                        </div>
                                    </form>
                                </div>
                                <div class="col m1">
                                    <ul class="left">
                                        
                                        <li class="waves-effect waves-light">
                                            <a href=""><i class="material-icons md-24"></i>Export Excel</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
                <!-- Secondary Nav END -->
            </div>
            <!-- Row END -->

            <?php
            if (isset($_SESSION['succAdd'])) {
                $succAdd = $_SESSION['succAdd'];
                echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succAdd . '</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                unset($_SESSION['succAdd']);
            }
            if (isset($_SESSION['succEdit'])) {
                $succEdit = $_SESSION['succEdit'];
                echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succEdit . '</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                unset($_SESSION['succEdit']);
            }
            if (isset($_SESSION['succDel'])) {
                $succDel = $_SESSION['succDel'];
                echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succDel . '</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                unset($_SESSION['succDel']);
            }
            ?>

            <!-- Row form Start -->
            <div class="row jarak-form">

                <?php
                if (isset($_REQUEST['submit'])) {
                    $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                    echo '
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                    <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong>
                                    <span class="right"><a href="?page=dft_atv"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th width="6%" style="text-align: center">No. Dummy</th>
                                        <th width="10%" style="text-align: center">No. Meter Rusak</th>
                                        <th width="10%" style="text-align: center">No. Meter Baru</th>
                                        <th width="10%" style="text-align: center">ID Pelanggan</th>
                                        <th width="12%" style="text-align: center">Tanggal Aktivasi</th>
                                        <th width="13%" style="text-align: center">Petugas Aktivasi</th>
                                    <th width="10%">Status <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>';

                    //script untuk mencari data
                    $unit = $_SESSION['unit'];
                    
                    $query = mysqli_query($config, "SELECT * FROM tbl_aktivasi WHERE no_dummy LIKE '%$cari%' || no_meter_rusak LIKE '%$cari%'||"
                            . "no_meter_baru LIKE '%$cari%' || id_pelanggan LIKE '%$cari%' || nama LIKE '%$cari%' && unit='$unit%' ORDER by tgl_aktivasi DESC LIMIT $curr, $limit");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_array($query)) {
                            echo '
                             <td style="text-align: center">' . $row['no_dummy'] . '</td>
                             <td style="text-align: center">' . $row['no_meter_rusak'] . '</td>
                             <td style="text-align: center">' . $row['no_meter_baru'] . '</td>
                             <td style="text-align: center">' . $row['id_pelanggan'] . '</td>'
                            ;

                            $y = substr($row['tgl_aktivasi'], 0, 4);
                            $m = substr($row['tgl_aktivasi'], 5, 2);
                            $d = substr($row['tgl_aktivasi'], 8, 2);
                            $h = substr($row['tgl_aktivasi'], 11, 2);
                            $i = substr($row['tgl_aktivasi'], 14, 2);        
                            $s = substr($row['tgl_aktivasi'], 17, 2);

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
                                    <td style="text-align: center">' . $d . " " . $nm . " " . $y . ' <br/> <hr/> '  . $h . ":" . $i . ":" . $s . '</td>
                                    <td style="text-align: center">' . $row['nama'] . '</td>
                                    <td style="text-align: center">';
                            
                            echo '<button class="btn small green waves-effect waves-light"><i class="material-icons">check</i> Aktif</button>';
                            
                            echo '
                                        </td>
                                    </tr>
                                </tbody>';
                        }
                    } else {
                        echo '<tr><td colspan="9"><center><p class="add">Tidak ada data yang ditemukan</p></center></td></tr>';
                    }
                    echo '</table><br/><br/>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM tbl_aktivasi");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata / $limit);

                    echo '<!-- Pagination START -->
                          <ul class="pagination">';

                    if ($cdata > $limit) {

                        //first and previous pagging
                        if ($pg > 1) {
                            $prev = $pg - 1;
                            echo '<li><a href="?page=dft_atv&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=dft_atv&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for ($i = 1; $i <= $cpg; $i++)
                            if ($i != $pg) {
                                echo '<li class="waves-effect waves-dark"><a href="?page=dft_atv&pg=' . $i . '"> ' . $i . ' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=dft_atv&pg=' . $i . '"> ' . $i . ' </a></li>';
                            }

                        //last and next pagging
                        if ($pg < $cpg) {
                            $next = $pg + 1;
                            echo '<li><a href="?page=dft_atv&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=dft_atv&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">last_page</i></a></li>';
                        }
                        echo '
                        </ul>
                        <!-- Pagination END -->';
                    } else {
                        echo '';
                    }
                } else {

                    echo '
                        <div class="col m12" id="colres">
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                    <tr>
                                        <th width="6%" style="text-align: center">No. Dummy</th>
                                        <th width="10%" style="text-align: center">No. Meter Rusak</th>
                                        <th width="10%" style="text-align: center">No. Meter Baru</th>
                                        <th width="10%" style="text-align: center">ID Pelanggan</th>
                                        <th width="12%" style="text-align: center">Tanggal Aktivasi</th>
                                        <th width="13%" style="text-align: center">Petugas Aktivasi</th>
                                        <th width="10%" style="text-align: center">Status <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                                            <div id="modal" class="modal">
                                                <div class="modal-content white">
                                                    <h5>Jumlah data yang ditampilkan per halaman</h5>';
                                                    $query = mysqli_query($config, "SELECT id_sett, dft_aktivasi FROM tbl_sett");
                                                    list($id_sett, $dft_aktivasi) = mysqli_fetch_array($query);
                                                    echo '
                                                    <div class="row">
                                                        <form method="post" action="">
                                                            <div class="input-field col s12">
                                                                <input type="hidden" value="' . $id_sett . '" name="id_sett">
                                                                <div class="input-field col s1" style="float: left;">
                                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                                </div>
                                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                                    <select class="browser-default validate" name="dft_aktivasi" required>
                                                                        <option value="' . $dft_aktivasi . '">' . $dft_aktivasi . '</option>
                                                                        <option value="5">5</option>
                                                                        <option value="10">10</option>
                                                                        <option value="20">20</option>
                                                                        <option value="50">50</option>
                                                                        <option value="100">100</option>
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer white">
                                                                    <button type="submit" class="modal-action waves-effect waves-green btn-flat" name="simpan">Simpan</button>';
                                                                if (isset($_REQUEST['simpan'])) {
                                                                    $id_sett = "1";
                                                                    $dft_aktivasi = $_REQUEST['dft_aktivasi'];
                                                                    $id_user = $_SESSION['id_user'];

                                                                    $query = mysqli_query($config, "UPDATE tbl_sett SET dft_aktivasi='$dft_aktivasi', id_user='$id_user' WHERE id_sett='$id_sett'");
                                                                    if ($query == true) {
                                                                        header("Location: ./admin.php?page=dft_atv");
                                                                        die();
                                                                    }
                                                                } echo '
                                                                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Batal</a>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>';

                    //script untuk menampilkan data
                    $unit = $_SESSION['unit'];

                    $query = mysqli_query($config, "SELECT * FROM tbl_aktivasi WHERE unit LIKE '$unit%' ORDER by tgl_aktivasi DESC LIMIT $curr, $limit");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_array($query)) {
                            echo '
                             <td style="text-align: center">' . $row['no_dummy'] . '</td>
                             <td style="text-align: center">' . $row['no_meter_rusak'] . '</td>
                             <td style="text-align: center">' . $row['no_meter_baru'] . '</td>
                             <td style="text-align: center">' . $row['id_pelanggan'] . '</td>
                            ';

                            $y = substr($row['tgl_aktivasi'], 0, 4);
                            $m = substr($row['tgl_aktivasi'], 5, 2);
                            $d = substr($row['tgl_aktivasi'], 8, 2);
                            $h = substr($row['tgl_aktivasi'], 11, 2);
                            $i = substr($row['tgl_aktivasi'], 14, 2);        
                            $s = substr($row['tgl_aktivasi'], 17, 2);

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
                                    <td style="text-align: center">' . $d . " " . $nm . " " . $y . ' <br/> <hr/> '  . $h . ":" . $i . ":" . $s . '</td>
                                    <td style="text-align: center">' . $row['nama'] . '</td>
                                    <td style="text-align: center">';


                            echo '<button class="btn small green waves-effect waves-light"><i class="material-icons">check</i> Aktif</button>';
                            echo '
                                        </td>
                                    </tr>
                                </tbody>';
                        }
                    } else {
                        echo '<tr><td colspan="9"><center><p class="add">Tidak ada data yg sudah diaktivasi.';
                    }
                    echo '</table>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM tbl_metdum_pakai WHERE aktivasi='non aktif'");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata / $limit);

                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                    if ($cdata > $limit) {

                        //first and previous pagging
                        if ($pg > 1) {
                            $prev = $pg - 1;
                            echo '<li><a href="?page=dft_atv&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=dft_atv&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for ($i = 1; $i <= $cpg; $i++)
                            if ($i != $pg) {
                                echo '<li class="waves-effect waves-dark"><a href="?page=dft_atv&pg=' . $i . '"> ' . $i . ' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=dft_atv&pg=' . $i . '"> ' . $i . ' </a></li>';
                            }

                        //last and next pagging
                        if ($pg < $cpg) {
                            $next = $pg + 1;
                            echo '<li><a href="?page=dft_atv&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=dft_atv&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">last_page</i></a></li>';
                        }
                        echo '
                        </ul>
                        <!-- Pagination END -->';
                    } else {
                        echo '';
                    }
                }
            }
        }
    }
    ?>
