<?
require_once('../api/helpers/db.php');
require_once('../api/helpers/funzioni.php');


$cod_cliente = pulisci_sql($_POST['codice']);
// $cod_cliente = 1;

$q_id_cli = "SELECT id_cliente FROM Clienti WHERE codice = '$cod_cliente'";
$r_id_cli = mysqli_query($connection, $q_id_cli);
$test = array();
while($riga = mysqli_fetch_row($r_id_cli)) {
    $array = array(
        "IdCliente" => $riga[0]
    );
    array_push($test, $array);
}
mysqli_free_result($r_id_cli);
$resp = (object) $test;

    foreach($test as $id){
        $id_cliente = $id["IdCliente"];
    }

// print($id_cli);
// $id_cli = 1;

$query = "SELECT * FROM x_mis WHERE id_cliente = $id_cliente AND visibile = 1 ORDER BY data DESC";
$result = mysqli_query($connection, $query);
$dettagli = array();
while ($row = mysqli_fetch_row($result)) {
    $data = array(
        "IdMisurazione" => $row[0],
        "Data" => $row[1],
        "NProtocollo" => $row[2],
        "IdOperatore" => $row[4],
        "Note" => $row[6]
    );
    array_push($dettagli, $data);
}
mysqli_free_result($result);
$res = (object) $dettagli;
?>

<? if (count($dettagli) != 0) : ?>
    <table id="datatable-2" class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="tr">
                <th><?= $cod_cliente?></th>
                <th>Data</th>
                <th>N° Protocollo</th>
                <th>Note</th>
                <th>Operatore</th>
                <th>Modifiche</th>
            </tr>
        </thead>
        <tbody id="tBody">
            <? foreach ($dettagli as $dettaglio) :
                $id_op = $dettaglio['IdOperatore'];
                $q_operatore = "SELECT concat(nome, ' ', cognome) as name FROM Operatori WHERE id_operatore = $id_op";
                $r_operatore = mysqli_query($connection, $q_operatore);
                $nome_op = mysqli_fetch_column($r_operatore);
            ?>
                <tr id="<?= $dettaglio['IdMisurazione'] ?>">
                    <th scope="row">
                        <p><?= $dettaglio['IdMisurazione'] ?></p>
                    </th>
                    <th scope="row">
                        <p><?= $dettaglio['Data'] ?></p>
                    </th>
                    <td class="td">
                        <p><?= $dettaglio['NProtocollo'] ?></p>
                    </td>
                    <td class="td">
                        <p><?= $dettaglio['Note'] ?></p>
                    </td>
                    <td class="td">
                        <p><?= $nome_op ?></p>
                    </td>
                    <td class="">
                        <form>
                            <button type="submit" class="btn btn-warning mb-1" onclick="modificaMisurazioni('<?= $dettaglio['IdMisurazione'] ?>')">Misurazioni</button>
                        </form>
                    </td>
                </tr>
            <? endforeach ?>
        </tbody>
    </table>
<? else : ?>
    <h3 class="text text-center text-danger">Non sono state effettuate misurazioni per qesto cliente</h3>
<? endif;
db_disconnect(); ?>