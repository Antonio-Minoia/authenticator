<?
require_once('../api/helpers/logincheck.php');
require_once('../api/helpers/db.php');
require_once('../api/helpers/type.php');

//se ADMIN
if ($_SESSION['user']['admin'] >= 1) {
    $query = "SELECT fe.*, ut.nome, ut.cognome FROM stlgroup.Ferieepermessi as fe
            LEFT JOIN stlgroup.Utenti as ut ON ut.id = fe.idoperatore WHERE fe.urgente = '0' AND 
            -- inizio > NOW() AND
             fe.idnatura = 0 order by fe.accettato asc, fe.inizio asc ";

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
            "Nome" => $row[7],
            "Cognome" => $row[8],
        );
        array_push($ferie, $data);
    }

    mysqli_free_result($result);

    db_disconnect(); ?>
    <? if (count($ferie) != 0) : ?>
        <table id="datatable-4" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Utente</th>
                    <th>Inizio</th>
                    <th>Fine</th>
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
            "Scalcolo" => $row[6],
            "Idnatura" => $row[7],
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

                        <td class="td" <? if ($permesso['Urgente'] == 1 && $permesso['Idnatura'] != 0) {
                                            echo 'style="background: rgba(255, 0, 0, 0.4)"';
                                        } else if($permesso['Urgente'] == 0 && $permesso['Idnatura'] == 0) {
                                            echo 'style="background: rgba(0, 255, 0, 0.3)"';
                                        } else {
                                            echo 'style="background: rgba(255, 255, 154, 0.6)"';
                                        } ?>>
                            <p><? if ($permesso['Urgente'] == 1 && $permesso['Idnatura'] != 0) {
                                    echo 'Permesso urgente';
                                } else if($permesso['Urgente'] == 0 && $permesso['Idnatura'] == 0){
                                    echo 'Ferie';
                                } else {
                                    echo 'Permesso non urgente';
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
<? } ?>