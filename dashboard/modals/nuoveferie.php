<div class="modal fade" id='modalNewFerie'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Richiedi ferie</h5>
                <button type="button" class="btn btn-label-danger btn-icon" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <!-- inizio form permesso -->
            <div id="ferie">
                <form id="nuove-ferie" name="nuove-ferie" autocomplete="off">
                    <div class="modal-body">
                        <!-- BEGIN Form Group -->
                        <div class="form-group">

                            <!-- datetime picker -->
                            <div class="form-group col-md-12 mt-2">
                                <label for="date">Inizio</label>
                                <div class="input-group date" id="inizioFerie2">
                                    <input type="date" id="inputInizio2" class="form-control datePicker" aria-disabled>
                                    <!-- <label class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></label> -->
                                </div>
                            </div>


                            <hr>
                            <div class="form-group col-md-12">
                                <label for="date">Fine</label>
                                <div class="input-group date" id="fineFerie2">
                                    <input type="date" id="inputFine2" class="form-control datePicker" aria-disabled="">
                                    <!-- <label class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></label> -->
                                    <input id="preavvisoferie2" name="preavvisoferie2" value="<?= $_SESSION['user']['giorniavvisoferie'] ?>" hidden />
                                </div>
                            </div>



                        </div>
                        <!-- END Form Group -->


                    </div>


                    <div class="modal-footer">
                        <input id="richiedi-ferie2" type="submit" class="btn btn-primary mr-2" onclick="nuoveFerie()" onsubmit="nuoveFerie()" data-dismiss="modal" value="Richiedi ferie o permesso" disabled>
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