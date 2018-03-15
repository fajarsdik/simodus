<?php
    //session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if(isset($_REQUEST['act'])){
            $act = $_REQUEST['act'];
            switch ($act) {
                case 'add':
                    include "tambah_user.php";
                    break;
                case 'edit':
                    include "edit_tipe_user.php";
                    break;
                case 'del':
                    include "hapus_user.php";
                    break;
            }
        } else {

            //pagging
            $limit = 10;
            $pg = @$_GET['pg'];
                if(empty($pg)){
                    $curr = 0;
                    $pg = 1;
                } else {
                    $curr = ($pg - 1) * $limit;
                }

                $query = mysqli_query($config, "SELECT * FROM tbl_user LIMIT $curr, $limit");
                echo '<!-- Row Start -->
                    <div class="row">
                        <!-- Secondary Nav START -->
                        <div class="col s12">
                            <div class="z-depth-1">
                                <nav class="secondary-nav">
                                    <div class="nav-wrapper blue-grey darken-1">
                                        <div class="col m12">
                                            <ul class="left">
                                                <li class="waves-effect waves-light hide-on-small-only"><a href="?page=sett&sub=usr" class="judul"><i class="material-icons">people</i> Manajemen User</a></li>
                                                <li class="waves-effect waves-light">
                                                    <a href="?page=usr&act=add"><i class="material-icons md-24">person_add</i> Tambah User</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <!-- Secondary Nav END -->
                    </div>
                    <!-- Row END -->';

                    if(isset($_SESSION['succAdd'])){
                        $succAdd = $_SESSION['succAdd'];
                        echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succAdd.'</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        unset($_SESSION['succAdd']);
                    }
                    if(isset($_SESSION['succEdit'])){
                        $succEdit = $_SESSION['succEdit'];
                        echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succEdit.'</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        unset($_SESSION['succEdit']);
                    }
                    if(isset($_SESSION['succDel'])){
                        $succDel = $_SESSION['succDel'];
                        echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succDel.'</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        unset($_SESSION['succDel']);
                    }

                echo '
                    <!-- Row form Start -->
                    <div class="row jarak-form">

                        <div class="col m12" id="colres">
                            <!-- Table START -->
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                    <tr>
                                        <th width="4%" style="text-align: center">No</th>
                                        <th width="12%" style="text-align: center">Username</th>
                                        <th width="15%" style="text-align: center">Nama<br/>NIP</th>
                                        <th width="15%" style="text-align: center">Level</th>
                                        <th width="25%" style="text-align: center">Unit</th>
                                        <th width="10%" style="text-align: center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>';

                                if(mysqli_num_rows($query) > 0){
                                    $no = 1;
                                    while($row = mysqli_fetch_array($query)){
                                    echo '<td style="text-align: center">'.$no++.'</td>';

                                    if($row['admin'] == 1){
                                        $row['admin'] = 'Super Admin';
                                    } elseif($row['admin'] == 2){
                                        $row['admin'] = 'Admin Area';
                                    } elseif($row['admin'] == 3){
                                        $row['admin'] = 'Admin Rayon';
                                    } elseif($row['admin'] == 4){
                                        $row['admin'] = 'Petugas Aktivasi';
                                    } elseif($row['admin'] == 5){
                                        $row['admin'] = 'Petugas Posko';
                                    }
                                    
                                    if($row['unit'] == 18) {
                                        $row['unit'] = 'WRKR';
                                    } elseif ($row['unit'] == 183) {
                                        $row['unit'] = 'Area Tanjungpinang';
                                    } elseif ($row['unit'] == 18301) {
                                        $row['unit'] = 'Rayon Bintan Center';
                                    } elseif ($row['unit'] == 18302) {
                                        $row['unit'] = 'Rayon Kijang';
                                    } elseif ($row['unit'] == 18303) {
                                        $row['unit'] = 'Rayon Tg. Uban';
                                    } elseif ($row['unit'] == 18304) {
                                        $row['unit'] = 'Rayon Belakang Padang';
                                    } elseif ($row['unit'] == 18305) {
                                        $row['unit'] = 'Rayon Tg. Balai Karimun';
                                    } elseif ($row['unit'] == 18306) {
                                        $row['unit'] = 'Rayon Tg. Batu';
                                    } elseif ($row['unit'] == 18307) {
                                        $row['unit'] = 'Rayon Dabosingkep';
                                    } elseif ($row['unit'] == 18308) {
                                        $row['unit'] = 'Rayon Natuna';
                                    } elseif ($row['unit'] == 18309) {
                                        $row['unit'] = 'Rayon Tanjungpinang Kota';
                                    } elseif ($row['unit'] == 18310) {
                                        $row['unit'] = 'Rayon Anambas';
                                    }
                                    
                                    
                                        echo '<td style="text-align: center">'.$row['username'].'</td>
                                              <td style="text-align: center">'.$row['nama'].'<br/>'.$row['nip'].'</td>
                                              <td style="text-align: center">'.$row['admin'].'</td>
                                              <td style="text-align: center">'.$row['unit'].'</td>    
                                              <td style="text-align: center">';

                                    if($_SESSION['username'] == $row['username']){
                                        echo '<button class="btn small blue-grey waves-effect waves-light"><i class="material-icons">error</i> No Action</button>';
                                    } else {

                                        if($row['id_user'] == 1){
                                            echo '<button class="btn small blue-grey waves-effect waves-light"><i class="material-icons">error</i> No Action</button>';
                                        } else {
                                          echo ' <a class="btn small blue waves-effect waves-light" href="?page=usr&act=edit&id_user='.$row['id_user'].'">
                                                 <i class="material-icons">edit</i>EDIT</a>
                                                 <a class="btn small deep-orange waves-effect waves-light" href="?page=usr&act=del&id_user='.$row['id_user'].'"><i class="material-icons">delete</i> DEL</a>';
                                        }
                                    } echo '</td>
                                    </tr>
                                </tbody>';
                                    }
                                } else {
                        echo '<tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan</p></center></td></tr>';
                                }
                      echo '</table>
                            <!-- Table END -->
                        </div>

                    </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM tbl_user");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata/$limit);

                    echo '<!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit){

                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=usr&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=usr&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=usr&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=usr&pg='.$i.'"> '.$i.' </a></li>';
                            }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=usr&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=usr&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">last_page</i></a></li>';
                        }
                            echo ' </ul>
                                   <!-- Pagination END -->';
                    } else {
                        echo '';
                    }
                }
            }
?>
