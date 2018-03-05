                    <div class="browser-default col s6 tooltipped" data-position="top" data-tooltip="Pilih Nomor Dummy">
                        <i class="material-icons prefix md-prefix">looks_one</i>
                        <label for="no_meter">No Dummy</label>
                        <select id="no_meter" class="icons" name="no_meter" required>
                            <option></option>
                            <?php if (mysqli_num_rows($query_stok) > 0) { ?>
                                <?php while ($row_stok = mysqli_fetch_array($query_stok)) { ?>
                                    <option ><?php echo $row_stok['no_meter'] ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                        
                        <?php
                        if (isset($_SESSION['no_meter'])) {
                            $no_meter = $_SESSION['no_meter'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_meter . '</div>';
                            unset($_SESSION['no_meter']);
                        }
                        ?>
                    </div>