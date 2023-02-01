<?
require_once('../api/helpers/logincheck.php');
require_once('../api/helpers/db.php');
require_once('../api/helpers/type.php');

//se ADMIN
if ($_SESSION['user']['admin'] >= 1) {
    $query = "SELECT fe.*, ut.nome, ut.cognome FROM stlgroup.Ferieepermessi as fe
            LEFT JOIN stlgroup.Utenti as ut ON ut.id = fe.idoperatore WHERE fe.urgente = '0' AND 
            -- inizio > NOW() AND
             idnatura <> 0 order by fe.accettato asc, fe.inizio asc ";

    $result = mysqli_query($connection, $query);
    $ferie = array();

    while ($row = mysqli_fetch_row($result)) {
        $data = array(
            "Id" => $row[0],
            "IdOperatore" => $row[1],
            "Inizio" => $row[2],
            "Fine" => $row[3],
            "Accettato" => $row[4],
            "Urgente" => $row[5],
            "Scalcola" => $row[6],
            "Idnatura" => $row[7],
            "Nome" => $row[8],
            "Cognome" => $row[9],
        );
        array_push($ferie, $data);
    }

    mysqli_free_result($result);

 ?>
    <? if (count($ferie) != 0) : ?>
        <table id="datatable-2" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Utente</th>
                    <th>Inizio</th>
                    <th>Fine</th>
                    <th>Tipo Permesso</th>
                    <th>Stato</th>
                </tr>
            </thead>
            <tbody id="tBody">
                <? foreach ($ferie as $permesso) : ?>

                    <!-- <tr id="<?= $permesso['Id'] ?>" <? if (!$permesso['Attiva']) : ?> style="opacity: .6; <? endif ?>"> -->
                    <tr id="<?= $permesso['Id'] ?>" style="<?
                                                            if ($permesso['Accettato'] == '0') {
                                                                echo 'background: rgba(255, 0, 0, 0.5)';
                                                            } else if ($permesso['Accettato'] == '1') {
                                                                echo 'background: rgba(0, 255, 0, 0.1)';
                                                            } else if ($permesso['Accettato'] == '2') {
                                                                echo 'background: rgba(255, 0, 0, 0.1)';
                                                            }
                                                            ?>">

                        <td class="td">
                            <!-- <input type="text" class="form-control" disabled value="<?= $permesso['Nome'] ?> <?= $permesso['Cognome'] ?>" id="<?= $permesso['Id'] ?>" name="Utente"> -->
                            <p><?= $permesso['Nome'] ?> <?= $permesso['Cognome'] ?></p>
                        </td>
                        <td class="td">
                            <!-- <input type="text" class="form-control" disabled value="<?= $permesso['Inizio'] ?>" id="<?= $permesso['Id'] ?>" name="Inizio"> -->
                            <p><?= $permesso['Inizio'] ?></p>
                        </td>
                        <td class="td">
                            <!-- <input type="text" class="form-control" disabled value="<?= $permesso['Fine'] ?>" id="<?= $permesso['Id'] ?>" name="Fine"> -->
                            <p><?= $permesso['Fine'] ?></p>
                        </td>
                        <td class="td">
                            <select disabled class="form-control" id="idnatura" name="idnatura">
                                <?
                                $query2 = "SELECT * FROM stlgroup.Naturapermessi";
                                $result2 = mysqli_query($connection, $query2);
                                $permessi = array();
                                while ($row = mysqli_fetch_row($result2)) {
                                    $data = array(
                                        "IdNatura" => $row[0],
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
                                    <option value="<?= $tipo['IdNatura'] ?>" <?if($permesso['Idnatura'] == $tipo['IdNatura']) {echo "selected";}?>><?= $tipo['Sigla'] ?> <?= $tipo['Motivo']; ?></option>
                                <?} ?>
                            </select>

                            <!-- <input type="text" class="form-control" disabled value="<?= $permesso['Id'] ?>" id="<?= $permesso['Id'] ?>" name="idnatura"> -->
                            <!-- <p><?= $permesso['Idnatura'] ?></p> -->
                            <button class="btn btn-info mt-1" onclick="handleModificaFerie(this, '<?= $permesso['Id'] ?>')"><i class="fa fa-edit"></i></button>
                        </td>
                        <td class="td" >
                            <select disabled class="form-control" name="accettato">
                                <option value="" hidden selected>
                                    <? if ($permesso['Accettato'] == '1') {
                                        echo "Accettato";
                                    } else if ($permesso['Accettato'] == '2') {
                                        echo "Rifiutato";
                                    } else {
                                        echo "Sospeso";
                                    } ?>
                                </option>
                                    <option value="0">In sospeso</option>
                                    <option value="1">Accetta</option>
                                    <option value="2">Rifiuta</option>
                            </select>

                            <? if($permesso['Fine'] > date("Y-m-d")){ ?>
                            <button class="btn btn-info mt-1" onclick="handleModificaFerie(this, '<?= $permesso['Id'] ?>')"><i class="fa fa-edit"></i></button>
                            <?}?>

                            <p hidden><? if ($permesso['Accettato'] == '1') {
                                            echo "Accettato";
                                        } else if ($permesso['Accettato'] == '2') {
                                            echo "Rifiutato";
                                        } else if ($permesso['Scalcola'] == '0') {
                                            echo "Abbuonato";
                                        } else if ($permesso['Scalcola'] == '1') {
                                            echo "Scalcolato";
                                        } else {
                                            echo "Sospeso";
                                        } ?></p>

                        </td>

                    </tr>
                <? endforeach ?>
            </tbody>
        </table>
    <? else : ?>
        <h3 class="text text-center text-danger">Non ci sono ferie</h3>

    <? endif ?>
    
<? } ?>


<?
// se OPERATORE
if ($_SESSION['user']['admin'] < 1) {
    $userid = $_SESSION['user']['id'];
    $query = "SELECT * FROM stlgroup.Ferieepermessi WHERE idoperatore = '$userid' order by inizio asc";
    $result = mysqli_query($connection, $query);
    $ferie = array();

    while ($row = mysqli_fetch_row($result)) {
        $data = array(
            "Id" => $row[0],
            "IdOperatore" => $row[1],
            "Inizio" => $row[2],
            "Fine" => $row[3],
            "Accettato" => $row[4],
            "Urgente" => $row[5],
        );
        array_push($ferie, $data);
    }

    mysqli_free_result($result);

    db_disconnect(); ?>
    <? if (count($ferie) != 0) : ?>
        <table data-order='[[ 2, "asc" ]]' id="datatable-2" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Inizio</th>
                    <th>Fine</th>
                    <th>Stato</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody id="tBody">
                <? foreach ($ferie as $permesso) : ?>

                    <tr id="<?= $permesso['Id'] ?>" <? if (!$permesso['Accettato']) : ?> disabled <? endif ?>>

                        <td class="td" <? if ($permesso['Urgente'] == 1) {
                                            echo 'style="background: rgba(255, 0, 0, 0.4)"';
                                        } else {
                                            echo 'style="background: rgba(255, 255, 154, 0.6)"';
                                        } ?>>
                            <p><? if ($permesso['Urgente'] == 1) {
                                    echo 'Urgente';
                                } else {
                                    echo 'Normale';
                                } ?></p>
                        </td>
                        <td class="td">
                            <p><?= $permesso['Inizio'] ?></p>
                        </td>
                        <td class="td">
                            <p><?= $permesso['Fine'] ?></p>
                        </td>
                        <td class="td">
                            <p><?
                                if ($permesso['Accettato'] == '1') {
                                    echo "Accettato";
                                } else if ($permesso['Accettato'] == '2') {
                                    echo "Rifiutato";
                                } else if ($permesso['Accettato'] == '3') {
                                    echo "Abbuonato";
                                } else if ($permesso['Accettato'] == '4') {
                                    echo "Scalcolato";
                                } else {
                                    echo "Da rispondere";
                                }
                                ?></p>
                        </td>

                        <? if ($permesso['Accettato']) : ?>
                            <td>
                                <button class="btn btn-danger mb-1" onclick="eliminaFerie('<?= $permesso['Id'] ?>')" disabled>Elimina</button>
                            </td>
                        <? else : ?>
                            <td>
                                <button class="btn btn-danger mb-1" onclick="eliminaFerie('<?= $permesso['Id'] ?>')">Elimina</button>
                            </td>
                        <? endif ?>


                    </tr>
                <? endforeach ?>
            </tbody>
        </table>
    <? else : ?>
        <h3 class="text text-center text-danger">Non hai mai richiesto ferie</h3>

    <? endif ?>
<? } 
    db_disconnect();?>