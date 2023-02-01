<?
require_once('../api/helpers/logincheck.php');
require_once('../api/helpers/db.php');

$query = "SELECT cli.*, mis.data_ult FROM Clienti as cli
left join  (SELECT id_cliente, max(data) as data_ult FROM x_mis GROUP BY id_Cliente) as mis ON mis.id_cliente=cli.id_CLIENTE";
$result = mysqli_query($connection, $query);
$clienti = array();

while ($row = mysqli_fetch_row($result)) {
    $data = array(
        "Id" => $row[0],
        "Codice" => $row[1],
        "Tipo" => $row[2],
        "Referente" => $row[3],
        "Ragione" => $row[4],
        "PartitaIva" => $row[6],
        "Tel" => $row[7],
        "Mail" => $row[8],
        "Indirizzo" => $row[5],
        "CAP" => $row[9],
        "Città" => $row[10],
        "Provincia" => $row[11],
        "Stato" => $row[12],
        "Attivo" => $row[13],
        "CodFiscale" => $row[14],
        "PEC" => $row[15],
        "SDI" => $row[16],
        "UltimaData" => $row[17]
    );
    array_push($clienti, $data);
}
mysqli_free_result($result);
$res = (object) $clienti;
db_disconnect(); ?>

<? if (count($clienti) != 0) : ?>
    <table id="datatable-1" class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="tr">
                <th>Utima misurazione</th>
                <th>Codice</th>
                <th>Tipo</th>
                <th>Referente</th>
                <th>Ragione Sociale</th>
                <!-- <th>Partita Iva</th>
                <th>Telefono</th>
                <th>Mail</th>
                <th>Indirizzo</th>
                <th>CAP</th> -->
                <th>Città</th>
                <!-- <th>Provincia</th>
                <th>Stato</th> -->
                <th>Azioni</th>
                <? if ($_SESSION['user']['tipo'] == 3) : ?>
                <th>Altro</th>
                <? endif;?>
            </tr>
        </thead>
        <tbody id="tBody">
            <? foreach ($clienti as $cliente) : ?>
                <? if ($cliente['Attivo']) : ?>
                <tr id="<?= $cliente['Codice'] ?>">
                    <th scope="row"><?= $cliente['UltimaData'] ?></th>
                    <th scope="row"><?= $cliente['Codice'] ?></th>
                    <td class="td">
                        <input class="form-control" disabled value="<?= $cliente['Tipo'] ?>">
                        <!-- <input type="text" class="form-control" disabled value="<?= $cliente['Tipo'] ?>" name="Tipo"> -->
                    </td>
                    <td class="td">
                        <input type="text" class="form-control" disabled value="<?= $cliente['Referente'] ?>" name="Referente">
                    </td>
                    <td class="td">
                        <input type="text" class="form-control" disabled value="<?= $cliente['Ragione'] ?>" name="RagioneSociale">
                    </td>
                    <!-- <td class="td">
                        <input type="text" class="form-control" disabled value="<?= $cliente['PartitaIva'] ?>" name="PartitaIva">
                    </td>
                    <td class="td">
                        <input type="text" class="form-control" disabled value="<?= $cliente['Tel'] ?>" name="Telefono">
                    </td>
                    <td class="td">
                        <input type="text" class="form-control" disabled value="<?= $cliente['Mail'] ?>" name="Mail">
                    </td>
                    <td class="td">
                        <input type="text" class="form-control" disabled value="<?= $cliente['Indirizzo'] ?>" name="Indirizzo">
                    </td>
                    <td class="td">
                        <input type="text" class="form-control" disabled value="<?= $cliente['CAP'] ?>" name="CAP">
                    </td> -->
                    <td class="td">
                        <input type="text" class="form-control" disabled value="<?= $cliente['Città'] ?>" name="Citta">
                    </td>
                    <!-- <td class="td">
                        <input type="text" class="form-control" disabled value="<?= $cliente['Provincia'] ?>" name="Provincia">
                    </td>
                    <td class="td">
                        <input type="text" class="form-control" disabled value="<?= $cliente['Stato'] ?>" name="Stato">
                    </td> -->
                    <td class="d-flex justify-content-center">
                    <? if($_SESSION['user']['tipo'] == 3) { ?>
                        <form method="get" action="./tabelladettagli.php">
                            <input type="hidden" name="id" value="<?= $cliente['Id'] ?>">
                            <!-- <input type="hidden" name="ragione" value="<? //$cliente['Ragione'] ?>"> -->
                            <input type="hidden" name="tipo_misurazione" value="Misurazione">
                            <button class="btn m-2" style="background-color:#D5DEED" type="submit">Misurazioni</button>
                        </form>
                        <form method="get" action="./tabelladettagli.php">
                            <input type="hidden" name="id" value="<?= $cliente['Id'] ?>">
                            <!-- <input type="hidden" name="ragione" value="<? //$cliente['Ragione'] ?>"> -->
                            <input type="hidden" name="tipo_misurazione" value="Impianto">
                            <button class="btn m-2" style="background-color:#C3E0E5" type="submit">Impianti</button>
                        </form>
                        <? } ?>
                        <form method="get" action="./tabelladettagli.php">
                            <input type="hidden" name="id" value="<?= $cliente['Id'] ?>">
                            <!-- <input type="hidden" name="ragione" value="<? //$cliente['Ragione'] ?>"> -->
                            <input type="hidden" name="tipo_misurazione" value="Riparazione">
                            <button class="btn m-2" style="background-color:#7EC8E3" type="submit">Riparazioni</button>
                        </form>
                        <form method="get" action="./dettaglicliente.php">
                            <input type="hidden" name="id" value="<?= $cliente['Id'] ?>">
                            <input type="hidden" name="codice" value="<?= $cliente['Codice'] ?>">
                            <!-- <input type="hidden" name="ragione" value="<? //$cliente['Ragione'] ?>"> -->
                            <button class="btn m-2" style="background-color:#8CB1F5" type="submit">Dati cliente</button>
                        </form>
                    </td>
                    <? if ($_SESSION['user']['tipo'] == 3) : ?>
                    <td>
                        <button class="btn btn-dark m-1" onclick="eliminaCliente('<?= $cliente['Codice'] ?>')">Elimina</button>
                    </td>
                    <? endif;?>
                </tr>
                <? endif ?>
            <? endforeach ?>
        </tbody>
    </table>
<? else : ?>
    <h3 class="text text-center text-danger">Non ci sono clienti</h3>

<? endif ?>
<script>

</script>