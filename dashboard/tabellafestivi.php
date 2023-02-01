<?
require_once('../api/helpers/logincheck.php');
require_once('../api/helpers/db.php');
require_once('../api/helpers/type.php');


$query = "SELECT * FROM stlgroup.giornifestivi ";
$result = mysqli_query($connection, $query);
$sedi = array();

while ($row = mysqli_fetch_row($result)) {
    $data = array(
        "Id" => $row[0],
        "Citta" => $row[1],
        "Indirizzo" => $row[2],
        "Attiva" => $row[3],
    );
    array_push($sedi, $data);
}

mysqli_free_result($result);

db_disconnect(); ?>
<? if ($_SESSION['user']['admin'] >= 1) { ?>
    <? if (count($sedi) != 0) : ?>
        <table id="datatable-2" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Città</th>
                    <th>Indirizzo</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody id="tBody">
                <? foreach ($sedi as $sede) : ?>

                    <tr id="<?= $sede['Id'] ?>" <? if (!$sede['Attiva']) : ?> style="opacity: .6; <? endif ?>">

                        <td class="td">
                            <input type="text" class="form-control" disabled value="<?= $sede['Citta'] ?>" idope="<?= $sede['Id'] ?>" name="Citta">
                            <button class="btn btn-info mt-1" onclick="handleModificaSede(this, '<?= $sede['Id'] ?>')"><i class="fa fa-edit"></i></button>
                            <p hidden><?= $sede['Citta'] ?></p>
                        </td>

                        <td class="td">
                            <input type="text" class="form-control" disabled value="<?= $sede['Indirizzo'] ?>" idope="<?= $sede['Id'] ?>" name="Indirizzo">
                            <button class="btn btn-info mt-1" onclick="handleModificaSede(this, '<?= $sede['Id'] ?>')"><i class="fa fa-edit"></i></button>
                            <p hidden><?= $sede['Indirizzo'] ?></p>
                        </td>

                        <? if ($sede['Attiva']) : ?>
                            <td>
                                <button class="btn btn-dark mb-1" onclick="eliminaSede('<?= $sede['Citta'] ?>', '<?= $sede['Id'] ?>')">Disattiva</button>
                            </td>
                        <? else : ?>
                            <td>
                                <button class="btn btn-success mb-1" onclick="attivaSede('<?= $sede['Citta'] ?>', '<?= $sede['Id'] ?>')">Attiva</button>
                            </td>
                        <? endif ?>


                    </tr>
                <? endforeach ?>
            </tbody>
        </table>
    <? else : ?>
        <h3 class="text text-center text-danger">Non ci sono sedi</h3>

    <? endif ?>
<? } ?>