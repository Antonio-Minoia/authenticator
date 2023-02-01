<div class="modal fade" id='modalNewPermesso'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Richiedi permesso</h5>
                <button type="button" class="btn btn-label-danger btn-icon" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <!-- inizio form permesso -->
            <div id="permesso">
                <form id="nuove-ferie" name="nuove-ferie" autocomplete="off">
                    <div class="modal-body">
                        <!-- BEGIN Form Group -->
                        <div class="form-group">
                            <div class="d-flex justify-content-start m-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="urgente">
                                    <label class="form-check-label" for="urgente">
                                        Permesso urgente
                                    </label>
                                </div>
                            </div>

                            <hr>
                            <div class="form-group col-md-12">
                                <label>Tipo di permesso</label>
                                <select class="form-control" id="natura" name="natura">
                                    <?
                                    $query2 = "SELECT * FROM stlgroup.Naturapermessi";
                                    $result2 = mysqli_query($connection, $query2);
                                    $permessi = array();
                                    while ($row = mysqli_fetch_row($result2)) {
                                        $data = array(
                                            "Id" => $row[0],
                                            "Sigla" => $row[1],
                                            "Motivo" => $row[2],
                                            "Descrizione" => $row[3],
                                        );
                                        array_push($permessi, $data);
                                    }
                                    mysqli_free_result($result2);
                                    ?>
                                    <?
                                    foreach ($permessi as $tipo) {
                                    ?>
                                        <option value="<?= $tipo['Id'] ?>"><?= $tipo['Sigla'] ?> <? echo  $tipo['Motivo']; ?></option>
                                    <?
                                    } ?>
                                </select>
                            </div>
                            <hr>
                            <div class="m-3">
                                <b class="">*Il giorno d'inizio e di fine devono essere uguali, per richiedere permessi in più giorni effettua più richieste. Ci può solo un permesso in una data.</b>
                            </div>


                            <!-- datetime picker -->
                            <div class="form-group col-md-12 mt-2">
                                <label for="date">Inizio</label>
                                <div class="input-group date" id="inizioFerie">
                                    <input type="datetime-local" id="inputInizio" class="form-control datePicker" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}" aria-disabled>
                                    <!-- <label class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></label> -->
                                </div>
                            </div>


                            <hr>
                            <div class="form-group col-md-12">
                                <label for="date">Fine</label>
                                <div class="input-group date" id="fineFerie">
                                    <input type="datetime-local" id="inputFine" class="form-control datePicker" aria-disabled="">
                                    <!-- <label class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></label> -->
                                    <input id="preavvisoferie" name="preavvisoferie" value="<?= $_SESSION['user']['giorniavvisoferie'] ?>" hidden />
                                </div>
                            </div>



                        </div>
                        <!-- END Form Group -->


                    </div>


                    <div class="modal-footer">
                        <input id="richiedi-ferie" type="submit" class="btn btn-primary mr-2" onclick="nuovoPermesso()" onsubmit="nuovoPermesso()" data-dismiss="modal" value="Richiedi ferie o permesso" disabled>
                        <button class=" btn btn-outline-danger" data-dismiss="modal">Annulla</button>
                    </div>
                </form>
            </div>
            <!-- fine form permesso -->
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('#datepicker').datepicker();
    });
</script>