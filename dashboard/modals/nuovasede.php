<div class="modal fade" id='modalNewSede'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inserisci una nuova sede</h5>
                <button type="button" class="btn btn-label-danger btn-icon" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <!-- BEGIN Form Group -->
                    <div class="form-group">
                        <label>Città</label>
                        <input type="text" class="form-control" id="citta2" name="citta" data-parsley-required maxlength="50">
                        <hr>
                        <label>Indirizzo</label>
                        <input type="text" class="form-control" id="indirizzo2" name="indirizzo" data-parsley-required maxlength="50">


                        <hr>
                        <label>Attiva</label>
                        <select class="form-control" id="attiva2" name="attiva" >
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>                  
                    </div>
                    <!-- END Form Group -->
                </div>
                <div class="modal-footer">
                    <input class="btn btn-primary mr-2" id="sendButtonSedi" onclick="nuovaSede()" data-dismiss="modal" name="submitnuovasede" value="Nuova Sede">
                    <button class=" btn btn-outline-danger" data-dismiss="modal">Annulla</button>
                </div>
            </form>
        </div>
    </div>
</div>