<div class="modal fade" id='modalNewOperatore'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inserisci nuovo operatore</h5>
                <button type="button" class="btn btn-label-danger btn-icon" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <!-- <form id="nuovo-operatore" name="nuovo-operatore"> -->
                <div class="modal-body">
                    <!-- BEGIN Form Group -->
                    <div class="form-group">
                        <label>Cognome</label>
                        <input type="text" class="form-control" id="cognome2" name="cognome" data-parsley-required maxlength="50">


                        <hr>
                        <label>Nome</label>
                        <input type="text" class="form-control" id="nome2" name="nome" data-parsley-required>


                        <hr>
                        <label>Username</label>
                        <input type="text" class="form-control" id="user2" name="user" minlength="10" data-parsley-required>


                        <hr>
                        <label>Password</label>
                        <input type="password" class="form-control" id="pass2" name="pass" data-parsley-required>


                        <hr>
                        <label>Sede di appartenenza</label>
                        <select class="form-control" id="sede2" name="sede">
                            <?
                            $query2 = "SELECT * FROM stlgroup.Sedi";
                            $result2 = mysqli_query($connection, $query2);
                            $sedi = array();
                            while ($row = mysqli_fetch_row($result2)) {
                                $data = array(
                                    "Id" => $row[0],
                                    "Citta" => $row[1],
                                    "Indirizzo" => $row[2],
                                    "Attiva" => $row[3],
                                );
                                array_push($sedi, $data);
                            }
                            mysqli_free_result($result2);
                            ?>
                            <?
                            foreach ($sedi as $sede) {
                                if ($sede['Attiva'] == "1") { ?>
                                    <option value="<?= $sede['Id'] ?>"><?= $sede['Citta'] ?> <? if($sede['Indirizzo']) { echo "- " . $sede['Indirizzo'];  }?></option>
                            <? }
                            } ?>
                        </select>


                        <hr>
                        <label>Accessibilità</label>
                        <select class="form-control" id="tipologia2" name="tipologia">
                            <option value="1">Amministratore</option>
                            <option value="0">Utente</option>
                        </select>


                        <!-- <hr>
                        <label>Può visualizzare il QR code?</label>
                        <select class="form-control" id="qrvisibilita2" name="qrvisibilita" disabled>
                            <option value="1" selected>Si</option>
                            <option value="0">No</option>
                        </select> -->

                        <hr>
                        <label>Giorni di avviso per ferie</label>
                        <input type="number" class="form-control" id="preavviso2" name="preavviso" value="0" disabled data-parsley-required>

                        <hr>
                        <label>Tolleranza ritardo in minuti</label>
                        <input type="number" min="15" max="59" class="form-control" id="ritardo2" name="ritardo" value="15" disabled data-parsley-required>
                        
                        <hr>
                        <label>Tolleranza straordinario in minuti</label>
                        <input type="number" min="1" max="59" class="form-control" id="tolleranza2" name="tolleranza" value="1" disabled data-parsley-required>

                        <hr>
                    </div>
                    <!-- END Form Group -->

                    <div id="orari2" class="" hidden>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">Orari</th>
                                    <th scope="col" colspan="2">Mattina</th>
                                    <th scope="col" colspan="2">Pomeriggio</th>
                                </tr>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Inizio</th>
                                    <th scope="col">Fine</th>
                                    <th scope="col">Inizio</th>
                                    <th scope="col">Fine</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Lun</th>
                                    <td><input type="time" class="form-control" id="11" name="11" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="12" name="12" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="13" name="13" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="14" name="14" value="00:00:00"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Mar</th>
                                    <td><input type="time" class="form-control" id="21" name="21" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="22" name="22" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="23" name="23" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="24" name="24" value="00:00:00"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Mer</th>
                                    <td><input type="time" class="form-control" id="31" name="31" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="32" name="32" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="33" name="33" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="34" name="34" value="00:00:00"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Giov</th>
                                    <td><input type="time" class="form-control" id="41" name="41" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="42" name="42" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="43" name="43" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="44" name="44" value="00:00:00"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Ven</th>
                                    <td><input type="time" class="form-control" id="51" name="51" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="52" name="52" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="53" name="53" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="54" name="54" value="00:00:00"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Sab</th>
                                    <td><input type="time" class="form-control" id="61" name="61" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="62" name="62" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="63" name="63" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="64" name="64" value="00:00:00"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Dom</th>
                                    <td><input type="time" class="form-control" id="71" name="71" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="72" name="72" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="73" name="73" value="00:00:00"></td>
                                    <td><input type="time" class="form-control" id="74" name="74" value="00:00:00"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>


                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary mr-2" id="sendButtonOperatori" onclick="nuovoOperatore()" data-dismiss="modal" value="Nuovo operatore">
                    <button class=" btn btn-outline-danger" data-dismiss="modal">Annulla</button>
                </div>
            <!-- </form> -->
        </div>
    </div>
</div>