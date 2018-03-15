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
                            case 'mon':
                                include "monitoring.php";
                                break;
                            case 'mdk':
                                include "meter_dummy_kembali.php";
                                break;
                            case 'mdg':
                                include "meter_dummy_pakai.php";
                                break;
                            case 'atv':
                                include "aktivasi_meter.php";
                                break;
                            case 'dft_atv':
                                include "daftar_aktivasi.php";
                                break;
                            case 'usr':
                                include "user.php";
                                break;
                            case 'pro':
                                include "profil.php";
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
                                                echo "<strong>Admin Area</strong>. Berikut adalah statistik data yang tersimpan dalam sistem.";
                                            } elseif ($_SESSION['admin'] == 3) {
                                                echo "<strong>Admin Rayon</strong>. Berikut adalah statistik data yang tersimpan dalam sistem.";
                                            } elseif ($_SESSION['admin'] == 4) {
                                                echo "<strong>Petugas Aktivasi</strong>. Berikut adalah statistik data yang tersimpan dalam sistem.";
                                            } elseif ($_SESSION['admin'] == 5) {
                                                echo "<strong>Petugas Posko</strong>. Berikut adalah statistik data yang tersimpan dalam sistem.";
                                            }
                                            ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Welcome Message END -->

                            <?php
                            $unit = $_SESSION['unit']; 

                            //menghitung jumlah meter dummy
                            $count1 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_metdum_stok WHERE unit LIKE '$unit%'"));

                            //menghitung jumlah dummy terpasang
                            $count2 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_metdum_stok WHERE unit LIKE '$unit%' && status=''"));

                            //menghitung jumlah dummy standby
                            $count3 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_metdum_stok WHERE unit LIKE '$unit%' && status='ready'"));

                            //menghitung jumlah meter belum diaktivasi
                            $count4 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_metdum_pakai WHERE unit LIKE '$unit%' && aktivasi='non aktif'"));

                            //menghitung jumlah meter belum kembali
                            $count5 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_metdum_pakai WHERE unit LIKE '$unit%' && aktivasi='aktif' && kembali='belum'"));
                                                       
                            ?>

                            <!-- Info Statistic START -->

                            <div class="col s12 m4">
                                <div class="card lime darken-1">
                                    <div class="card-content">
                                        <span class="card-title white-text"><i class="material-icons md-36">drafts</i> Dummy Terpasang</span>
                                        <?php echo '<h5 class="white-text link">' . $count2 . ' Meter</h5>'; ?>
                                    </div>
                                </div>
                            </div>   

                            <div class="col s12 m4">
                                <div class="card yellow darken-3">
                                    <div class="card-content">
                                        <span class="card-title white-text"><i class="material-icons md-36">description</i> Dummy Standby</span>
                                        <?php echo '<h5 class="white-text link">' . $count3 . ' Meter</h5>'; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col s12 m4">
                                <div class="card cyan">
                                    <div class="card-content">
                                        <span class="card-title white-text"><i class="material-icons md-36">storage</i> Jml Meter Dummy</span>
                                        <?php echo '<h5 class="white-text link"> ' . $count1 . ' Meter</h5>'; ?>
                                    </div>
                                </div>
                            </div>                          

                            <?php
                            
                            if ($count4 > 0) {
                        
                            if ($_SESSION['id_user'] == 1 || $_SESSION['admin'] == 2 || $_SESSION['admin'] == 3 || $_SESSION['admin'] == 4) { ?>
                            <div class="col s12 m4">
                                <a href="?page=atv"><div class="card red accent-2">
                                    <div class="card-content">
                                        <span class="card-title white-text"><i class="material-icons md-36">people</i> Meter Belum Aktivasi</span>
                                        <?php echo '<h5 class="white-text link">' . $count4 . ' Meter</h5>'; ?>
                                    </div>
                                </div></a>
                            </div>
                            <?php } } 
                            
                            if ($count5 > 0) {
                        
                            if ($_SESSION['id_user'] == 1 || $_SESSION['admin'] == 2 || $_SESSION['admin'] == 3 || $_SESSION['admin'] == 5) { ?>
                            <div class="col s12 m4">
                                <a href="?page=mdk&act=add"><div class="card red accent-2">
                                    <div class="card-content">
                                        <span class="card-title white-text"><i class="material-icons md-36">people</i> Dummy Belum Kembali</span>
                                        <?php echo '<h5 class="white-text link">' . $count5 . ' Meter</h5>'; ?>
                                    </div>
                                </div></a>
                            </div>
                            <?php } } ?>
                            
                            
                            
                            
                            
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
