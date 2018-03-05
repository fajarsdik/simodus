<?php
ob_start();
//cek session
session_start();

if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    ?>

    <!doctype html>
    <html lang="en">

        <!-- Include Head START -->
        <?php include('include/head.php'); ?>
        <!-- Include Head END -->

        <!-- Body START -->
        <body class="bg">

            <!-- Header START -->
            <header>

                <!-- Include Navigation START -->
                <?php include('include/menu.php'); ?>
                <!-- Include Navigation END -->

            </header>
            <!-- Header END -->

            <!-- Main START -->
            <main>

                <!-- container START -->
                <div class="container">

                    <?php
                    if (isset($_REQUEST['page'])) {
                        $page = $_REQUEST['page'];
                        switch ($page) {
                            case 'mdk':
                                include "meter_dummy_kembali.php";
                                break;
                            case 'mdg':
                                include "meter_dummy_pakai.php";
                                break;
                            case 'sett':
                                include "pengaturan.php";
                                break;
                        }
                    } else {
                        ?>
                        <!-- Row START -->
                        <div class="row">

                            <!-- Include Header Instansi START -->
                            <?php include('include/header_instansi.php'); ?>
                            <!-- Include Header Instansi END -->

                            <!-- Welcome Message START -->
                            <div class="col s12">
                                <div class="card">
                                    <div class="card-content">
                                        <h4>Selamat Datang <?php echo $_SESSION['nama']; ?></h4>
                                        <p class="description">Anda login sebagai
                                            <?php
                                            if ($_SESSION['admin'] == 1) {
                                                echo "<strong>Super Admin</strong>. Anda memiliki akses penuh terhadap sistem.";
                                            } elseif ($_SESSION['admin'] == 2) {
                                                echo "<strong>Administrator</strong>. Berikut adalah statistik data yang tersimpan dalam sistem.";
                                            } else {
                                                echo "<strong>Petugas Disposisi</strong>. Berikut adalah statistik data yang tersimpan dalam sistem.";
                                            }
                                            ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Welcome Message END -->

                            <?php
                            //menghitung jumlah stok meter dummy
                            $count1 = mysqli_query($config, "SELECT * FROM tbl_metdum_JML WHERE unit='18301'");
                            list($id, $unit, $stok) = mysqli_fetch_array($count1);

                            //menghitung jumlah surat masuk
                            //$count2 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_surat_keluar"));
                            //menghitung jumlah surat masuk
                            //$count3 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_disposisi"));
                            //menghitung jumlah klasifikasi
                            //$count4 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_klasifikasi"));
                            //menghitung jumlah pengguna
                            //$count5 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_user"));
                            ?>

                            <!-- Info Statistic START -->
                            <div class="col s12 m4">
                                <div class="card cyan">
                                    <div class="card-content">
                                        <span class="card-title white-text"><i class="material-icons md-36">storage</i> Jumlah Meter Dummy</span>
        <?php echo '<h5 class="white-text link"> ' . $stok . ' Meter</h5>'; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col s12 m4">
                                <div class="card lime darken-1">
                                    <div class="card-content">
                                        <span class="card-title white-text"><i class="material-icons md-36">drafts</i> Meter Dummy Terpasang</span>
        <?php echo '<h5 class="white-text link">0 Meter</h5>'; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col s12 m4">
                                <div class="card yellow darken-3">
                                    <div class="card-content">
                                        <span class="card-title white-text"><i class="material-icons md-36">description</i> Meter Dummy Kembali</span>
        <?php echo '<h5 class="white-text link">0 Meter</h5>'; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col s12 m4">
                                <div class="card yellow darken-3">
                                    <div class="card-content">
                                        <span class="card-title white-text"><i class="material-icons md-36">description</i> Meter Dummy Standby</span>
        <?php echo '<h5 class="white-text link">0 Meter</h5>'; ?>
                                    </div>
                                </div>
                            </div>

        <?php if ($_SESSION['id_user'] == 1 || $_SESSION['admin'] == 2) { ?>
                                <div class="col s12 m4">
                                    <div class="card blue accent-2">
                                        <div class="card-content">
                                            <span class="card-title white-text"><i class="material-icons md-36">people</i> Jumlah Pengguna</span>
            <?php echo '<h5 class="white-text link">0 Pengguna</h5>'; ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- Info Statistic START -->
            <?php
        }
        ?>

                        </div>
                        <!-- Row END -->
        <?php
    }
    ?>
                </div>
                <!-- container END -->

            </main>
            <!-- Main END -->

            <!-- Include Footer START -->
    <?php include('include/footer.php'); ?>
            <!-- Include Footer END -->

        </body>
        <!-- Body END -->

    </html>

    <?php
}
?>
