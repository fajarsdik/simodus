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

        if ($_SESSION['admin'] == 1 || $_SESSION['admin'] == 2) {
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
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=mon" class="judul"><i class="material-icons">kitchen</i> Monitoring Dummy</a></li>
                                    </ul>
                                </div>
                                <div class="col m5 hide-on-med-and-down">
                                    <form method="post" action="?page=mon">
                                        <div class="input-field round-in-box">
                                            <input id="search" type="search" name="cari" placeholder="Ketik dan tekan enter No Dummy.." required>
                                            <label for="search"><i class="material-icons">search</i></label>
                                            <input type="submit" name="submit" class="hidden">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
                <!-- Secondary Nav END -->
            </div>
            <!-- Row END -->
            <!-- Row form Start -->
            <div class="row jarak-form">

                <?php
                if (isset($_REQUEST['submit'])) {
                    $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                    echo '
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=mon"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                        <th width="10%" style="text-align: center">Unit</th>
                                        <th width="10%" style="text-align: center">No. Dummy</th>
                                        <th width="15%" style="text-align: center">No. Meter Rusak</th>
                                        <th width="15%" style="text-align: center">Hari Layanan</th>
                                        <th width="15%" style="text-align: center">Tgl Pakai</th>
                                        <th width="15%" style="text-align: center">Tgl Aktivasi</th>
                                        <th width="15%" style="text-align: center">Tgl Kembali</th>
                                        <th width="15%" style="text-align: center">Lama Standby</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>';

                    //script untuk mencari data
                    $unit = $_SESSION['unit'];

                    $query = mysqli_query($config, "SELECT * FROM tbl_metdum_stok WHERE no_dummy LIKE '$cari%' && unit LIKE '$unit%' ORDER BY unit, no_dummy");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_array($query)) {
                            echo '
                        <td style="text-align: center">' . $row['unit'] . '</td>
                        <td style="text-align: center">' . $row['no_dummy'] . '</td>
                        <td style="text-align: center">' . $row['no_meter_rusak'] . '</td>';

                            if (!empty($row['tgl_pakai']) && $row['tgl_kbl'] < $row['tgl_pakai']) {
                                $hari_layanan = date("Y-m-d H:i:s") - $row['tgl_pakai'];
                                echo '   
                                <td style="text-align: center">' . $hari_layanan . ' hari</td>';
                            } else {
                                echo '   
                                <td style="text-align: center"> </td>';
                            }

                            //perhitungan tgl pakai
                            if (empty($row['tgl_pakai'])) {
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
                            if ($row['tgl_aktivasi'] < $row['tgl_pakai']) {
                                echo '<td style="text-align: center"></td>';
                            } elseif (empty($row['tgl_pakai'])) {
                                echo '<td style="text-align: center"></td>';
                            } else {

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
                            if ($row['tgl_kembali'] < $row['tgl_aktivasi'] || $row['tgl_kembali'] < $row['tgl_pakai']) {
                                echo '<td style="text-align: center"> </td>';
                            } elseif (empty($row['tgl_aktivasi'])) {
                                echo '<td style="text-align: center"> </td>';
                            } else {

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

                            //perhitungan lama standby
                            if (!empty($row['tgl_pakai']) && $row['tgl_kbl'] > $row['tgl_pakai']) {
                                $lama_standby = date("Y-m-d H:i:s") - $row['tgl_kbl'];
                                echo
                                '<td style="text-align: center">' . $lama_standby . ' Hari</td>';
                            } else {
                                echo '   
                                <td style="text-align: center"> </td>';
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
                } else {

                    echo '
                        <div class="col m12" id="colres">
                            <table class="bordered" id="tbl" >
                                <thead class="blue lighten-4" id="head">
                                    <tr>
                                        <th width="10%" style="text-align: center">Unit</th>
                                        <th width="10%" style="text-align: center">No. Dummy</th>
                                        <th width="15%" style="text-align: center">No. Meter Rusak</th>
                                        <th width="15%" style="text-align: center">Hari Layanan</th>
                                        <th width="15%" style="text-align: center">Tgl Pakai</th>
                                        <th width="15%" style="text-align: center">Tgl Aktivasi</th>
                                        <th width="15%" style="text-align: center">Tgl Kembali</th>
                                        <th width="15%" style="text-align: center">Lama Standby</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>';

                    //script untuk menampilkan data
                    $unit = $_SESSION['unit'];

                    $query = mysqli_query($config, "SELECT * FROM tbl_metdum_stok WHERE unit LIKE '$unit%' ORDER BY unit, no_dummy");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_array($query)) {
                            echo '
                        <td style="text-align: center">' . $row['unit'] . '</td>
                        <td style="text-align: center">' . $row['no_dummy'] . '</td>
                        <td style="text-align: center">' . $row['no_meter_rusak'] . '</td>';

                            if (!empty($row['tgl_pakai']) && $row['tgl_kembali'] < $row['tgl_pakai']) {
                                $awal = date_create($row['tgl_pakai']);
                                $akhir = date_create();
                                $hari_layanan = date_diff($awal, $akhir);

                                echo '   
                                <td style="text-align: center">' . $hari_layanan->d . ' hari ' . $hari_layanan->h . ' jam</td>';
                            } else {
                                echo '   
                                <td style="text-align: center"> </td>';
                            }

                            //perhitungan tgl pakai
                            if (empty($row['tgl_pakai'])) {
                                echo '<td style="text-align: center"> </td>';
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
                            if ($row['tgl_aktivasi'] < $row['tgl_pakai']) {
                                echo '<td style="text-align: center"></td>';
                            } elseif (empty($row['tgl_pakai'])) {
                                echo '<td style="text-align: center"></td>';
                            } else {

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
                            if ($row['tgl_kembali'] < $row['tgl_aktivasi'] || $row['tgl_kembali'] < $row['tgl_pakai']) {
                                echo '<td style="text-align: center"> </td>';
                            } elseif (empty($row['tgl_aktivasi'])) {
                                echo '<td style="text-align: center"> </td>';
                            } else {

                                $y = substr($row['tgl_kembali'], 0, 4);
                                $m = substr($row['tgl_kembali'], 5, 2);
                                $d = substr($row['tgl_kembali'], 8, 2);

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

                            //perhitungan lama standby
                            if (!empty($row['tgl_pakai']) && $row['tgl_kembali'] > $row['tgl_pakai']) {
                                $awal = date_create($row['tgl_kembali']);
                                $akhir = date_create();
                                $lama_standby = date_diff($awal, $akhir);
                                echo
                                '<td style="text-align: center">' . $lama_standby->d . ' hari ' . $lama_standby->h . ' jam</td>';
                            } else {
                                echo '   
                                <td style="text-align: center"> </td>';
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
                }
            } else {

                if ($_SESSION['admin'] == 3 || $_SESSION['admin'] == 4 || $_SESSION['admin'] == 5) {
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
                                                <li class="waves-effect waves-light hide-on-small-only"><a href="?page=mon" class="judul"><i class="material-icons">kitchen</i> Monitoring Dummy</a></li>
                                            </ul>
                                        </div>
                                        <div class="col m5 hide-on-med-and-down">
                                            <form method="post" action="?page=mon">
                                                <div class="input-field round-in-box">
                                                    <input id="search" type="search" name="cari" placeholder="Ketik dan tekan enter No Dummy.." required>
                                                    <label for="search"><i class="material-icons">search</i></label>
                                                    <input type="submit" name="submit" class="hidden">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <!-- Secondary Nav END -->
                    </div>
                    <!-- Row END -->
                    <!-- Row form Start -->
                    <div class="row jarak-form">

                        <?php
                        if (isset($_REQUEST['submit'])) {
                            $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                            echo '
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=mon"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered responsive-table" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                        
                                        <th width="10%" style="text-align: center">No. Dummy</th>
                                        <th width="15%" style="text-align: center">No. Meter Rusak</th>
                                        <th width="15%" style="text-align: center">Hari Layanan</th>
                                        <th width="15%" style="text-align: center">Tgl Pakai</th>
                                        <th width="15%" style="text-align: center">Tgl Aktivasi</th>
                                        <th width="15%" style="text-align: center">Tgl Kembali</th>
                                        <th width="15%" style="text-align: center">Lama Standby</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>';

                            //script untuk mencari data
                            $unit = $_SESSION['unit'];

                            $query = mysqli_query($config, "SELECT * FROM tbl_metdum_stok WHERE no_dummy LIKE '$cari%' && unit LIKE '$unit%'");
                            if (mysqli_num_rows($query) > 0) {
                                $no = 1;
                                while ($row = mysqli_fetch_array($query)) {
                                    echo '
                        <td style="text-align: center">' . $row['no_dummy'] . '</td>
                        <td style="text-align: center">' . $row['no_meter_rusak'] . '</td>';

                                    if (!empty($row['tgl_pakai']) && $row['tgl_kbl'] < $row['tgl_pakai']) {
                                        $hari_layanan = date("Y-m-d H:i:s") - $row['tgl_pakai'];
                                        echo '   
                                <td style="text-align: center">' . $hari_layanan . ' hari</td>';
                                    } else {
                                        echo '   
                                <td style="text-align: center"> </td>';
                                    }




                                    //perhitungan tgl pakai
                                    if (empty($row['tgl_pakai'])) {
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
                                    if ($row['tgl_aktivasi'] < $row['tgl_pakai']) {
                                        echo '<td style="text-align: center"></td>';
                                    } elseif (empty($row['tgl_pakai'])) {
                                        echo '<td style="text-align: center"></td>';
                                    } else {

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
                                    if ($row['tgl_kbl'] < $row['tgl_aktivasi'] || $row['tgl_kbl'] < $row['tgl_pakai']) {
                                        echo '<td style="text-align: center"> </td>';
                                    } elseif (empty($row['tgl_aktivasi'])) {
                                        echo '<td style="text-align: center"> </td>';
                                    } else {

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

                                    //perhitungan lama standby
                                    if (!empty($row['tgl_pakai']) && $row['tgl_kbl'] > $row['tgl_pakai']) {
                                        $lama_standby = date("Y-m-d H:i:s") - $row['tgl_kbl'];
                                        echo
                                        '<td style="text-align: center">' . $lama_standby . ' Hari</td>';
                                    } else {
                                        echo '   
                                <td style="text-align: center"> </td>';
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
                        } else {

                            echo '
                        <div class="col m12" id="colres">
                            <table class="bordered responsive-table" id="tbl" >
                                <thead class="blue lighten-4" id="head">
                                    <tr>
                                        <th width="10%" style="text-align: center">No. Dummy</th>
                                        <th width="15%" style="text-align: center">No. Meter Rusak</th>
                                        <th width="15%" style="text-align: center">Hari Layanan</th>
                                        <th width="15%" style="text-align: center">Tgl Pakai</th>
                                        <th width="15%" style="text-align: center">Tgl Aktivasi</th>
                                        <th width="15%" style="text-align: center">Tgl Kembali</th>
                                        <th width="15%" style="text-align: center">Lama Standby</th>
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
                                    <td style="text-align: center">' . $row['no_meter_rusak'] . '</td>';

                                    if (!empty($row['tgl_pakai']) && $row['tgl_kembali'] < $row['tgl_pakai']) {
                                        $awal = date_create($row['tgl_pakai']);
                                        $akhir = date_create();
                                        $hari_layanan = date_diff($awal, $akhir);

                                        echo '   
                                <td style="text-align: center">' . $hari_layanan->d . ' hari ' . $hari_layanan->h . ' jam</td>';
                                    } else {
                                        echo '   
                                <td style="text-align: center"> </td>';
                                    }

                                    //perhitungan tgl pakai
                                    if (empty($row['tgl_pakai'])) {
                                        echo '<td style="text-align: center"> </td>';
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
                                    if ($row['tgl_aktivasi'] < $row['tgl_pakai']) {
                                        echo '<td style="text-align: center"></td>';
                                    } elseif (empty($row['tgl_pakai'])) {
                                        echo '<td style="text-align: center"></td>';
                                    } else {

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
                                    if ($row['tgl_kembali'] < $row['tgl_aktivasi'] || $row['tgl_kembali'] < $row['tgl_pakai']) {
                                        echo '<td style="text-align: center"> </td>';
                                    } elseif (empty($row['tgl_aktivasi'])) {
                                        echo '<td style="text-align: center"> </td>';
                                    } else {

                                        $y = substr($row['tgl_kembali'], 0, 4);
                                        $m = substr($row['tgl_kembali'], 5, 2);
                                        $d = substr($row['tgl_kembali'], 8, 2);

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

                                    //perhitungan lama standby
                                    if (!empty($row['tgl_pakai']) && $row['tgl_kembali'] > $row['tgl_pakai']) {
                                        $awal = date_create($row['tgl_kembali']);
                                        $akhir = date_create();
                                        $lama_standby = date_diff($awal, $akhir);
                                        echo
                                        '<td style="text-align: center">' . $lama_standby->d . ' hari ' . $lama_standby->h . ' jam</td>';
                                    } else {
                                        echo '   
                                <td style="text-align: center"> </td>';
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
                        }
                    }
                }
            }
        }
        ?>
