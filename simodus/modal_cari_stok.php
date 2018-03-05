<div id="modal" class="modal">
    <div class="modal-content white">
        <h5>Jumlah data yang ditampilkan per halaman</h5>';
        $query = mysqli_query($config, "SELECT id_sett, metdum_kbl FROM tbl_sett");
        list($id_sett, $metdum_kbl) = mysqli_fetch_array($query);
        echo '
        <div class="row">
            <form method="post" action="">
                <div class="input-field col s12">
                    <input type="hidden" value="' . $id_sett . '" name="id_sett">
                    <div class="input-field col s1" style="float: left;">
                        <i class="material-icons prefix md-prefix">looks_one</i>
                    </div>
                    <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                        <select class="browser-default validate" name="metdum_kbl" required>
                            <option value="' . $metdum_kbl . '">' . $metdum_kbl . '</option>
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
                        $metdum_kbl = $_REQUEST['metdum_kbl'];
                        $id_user = $_SESSION['id_user'];

                        $query = mysqli_query($config, "UPDATE tbl_sett SET metdum_kbl='$metdum_kbl', id_user='$id_user' WHERE id_sett='$id_sett'");
                        if ($query == true) {
                        header("Location: ./admin.php?page=mdk");
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