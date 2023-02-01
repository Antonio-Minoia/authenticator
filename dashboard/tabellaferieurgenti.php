<?
require_once('../api/helpers/logincheck.php');
require_once('../api/helpers/db.php');
require_once('../api/helpers/type.php');

//se ADMIN
if ($_SESSION['user']['admin'] >= 1) {

    $query1 = "SELECT fe.*, ut.nome, ut.cognome FROM stlgroup.Ferieepermessi as fe
            LEFT JOIN stlgroup.Utenti as ut ON ut.id = fe.idoperatore WHERE fe.urgente = '1' and fe.idnatura <> 0 order by fe.scalcolo asc, fe.urgente desc, fe.inizio asc ";


    $result1 = mysqli_query($connection, $query1);

    $ferieUrg = array();

    while ($row1 = mysqli_fetch_row($result1)) {
        $data1 = array(
            "Id" => $row1[0],
            "IdOperatore" => $row1[1],
            "Inizio" => $row1[2],
            "Fine" => $row1[3],
            "Accettato" => $row1[4],
            "Urgente" => $row1[5],
            "Scalcola" => $row1[6],
            "Idnatura" => $row1[7],
            "Nome" => $row1[8],
            "Cognome" => $row1[9],
        );
        array_push($ferieUrg, $data1);
    }

    mysqli_free_result($result1);

?>

    <? if (count($ferieUrg) != 0) : ?>
        <table id="datatable-3" class="table table-bordered table-striped table-hover">
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
                <? foreach ($ferieUrg as $permesso) : ?>

                    <!-- <tr id="<?= $permesso['Id'] ?>" <? if (!$permesso['Attiva']) : ?> style="opacity: .6; <? endif ?>"> -->
                    <tr id="<?= $permesso['Id'] ?>" style="<?
                                                            if ($permesso['Scalcola'] == '0') {
                                                                echo 'background: rgba(255, 0, 0, 0.5)';
                                                            } else if ($permesso['Scalcola'] == '1') {
                                                                echo 'background: rgba(0, 255, 0, 0.1)';
                                                            } else if ($permesso['Scalcola'] == '2') {
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
                        <td class="td d-flex flex-wrap">
                            <select disabled class="form-control" name="scalcolo">
                                <option value="" hidden selected>
                                    <? if ($permesso['Scalcola'] == '1') {
                                        echo "Abbuonato";
                                    } else if ($permesso['Scalcola'] == '2') {
                                        echo "Scalcolato";
                                    } else {
                                        echo "Sospeso";
                                    } ?>
                                </option>

                                <option value="0">In sospeso</option>
                                <option value="1">Abbuona</option>
                                <option value="2">Scalcola</option>

                            </select>

                            <? if ($permesso['Fine'] > date("Y-m-d")) { ?>
                                <button class="btn btn-info mt-1" onclick="handleModificaFerie(this, '<?= $permesso['Id'] ?>')"><i class="fa fa-edit"></i></button>
                            <? } ?>


                            <p hidden><? if ($permesso['Accettato'] == '1') {
                                            echo "Accettato";
                                        } else if ($permesso['Accettato'] == '2') {
                                            echo "Rifiutato";
                                        } else if ($permesso['Scalcola'] == '0') {
                                            echo "Abbuonato";
                                        } else if ($permesso['Scalcola'] == '1') {
                                            echo "Scalcolato";
                                        } else {
                                            echo "Da rispondere";
                                        } ?></p>

                        </td>

                    </tr>
                <? endforeach ?>
            </tbody>
        </table>
    <? else : ?>
        <h3 class="text text-center text-danger">Non ci sono ferie</h3>

    <? endif ?>
<? }

db_disconnect(); ?>