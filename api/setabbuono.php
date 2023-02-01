<?
require_once('./helpers/funzioni.php');
require_once('./helpers/logincheck.php');
require_once('./helpers/db.php');

$valueToSet = pulisci_sql($_POST['valueToSet']);
$idBadge = pulisci_sql($_POST['idBadge']);
$idOperatore = pulisci_sql($_POST['idOperatore']);
$idGiorno = pulisci_sql($_POST['idGiorno']);
$orario = pulisci_sql($_POST['orario']);
$tipo = pulisci_sql($_POST['tipo']);

if ($tipo == 'start') {

    $query1 = "SELECT * FROM stlgroup.Orariutenti where idoperatore = '$idOperatore' and idgiorno = '$idGiorno' and 
(orarioinizio >= timediff('$orario', '03:00:00') and orarioinizio <= addtime('$orario', '03:00:00'))";
    $result1 = mysqli_query($connection, $query1);
    if($result1) {print 'successo';}
    // print $query1;
    $dati = array();
    while ($row = mysqli_fetch_row($result1)) {

        $data = array(
            "Id" => $row[0],
            "IdOperatore" => $row[1],
            "OrarioInizio" => $row[2],
            "OrarioFine" => $row[3],
            "Idgiorno" => $row[4],
            "TolleranzaStraordinario" => $row[5],
            "TolleranzaRitardo" => $row[6]
        );
        array_push($dati, $data);
    }
} else {
    $query1 = "SELECT * FROM stlgroup.Orariutenti where idoperatore = '$idOperatore' and idgiorno = '$idGiorno' and 
(orariofine >= timediff('$orario', '03:00:00') and orariofine <= addtime('$orario', '03:00:00'))";
    $result1 = mysqli_query($connection, $query1);
    if($result1) {print 'successo';}
    // print $query1;
    $dati = array();
    while ($row = mysqli_fetch_row($result1)) {

        $data = array(
            "Id" => $row[0],
            "IdOperatore" => $row[1],
            "OrarioInizio" => $row[2],
            "OrarioFine" => $row[3],
            "Idgiorno" => $row[4],
            "TolleranzaStraordinario" => $row[5],
            "TolleranzaRitardo" => $row[6]
        );
        array_push($dati, $data);
    }

}

foreach ($dati as $dato) {

    if ($tipo == "start") {
        if ($valueToSet == '0') {
            $query = "UPDATE stlgroup.Oraribadge SET abbuono = '$valueToSet', orarioutente = '" . $dato['OrarioInizio'] . "' WHERE id = $idBadge ";
            // print $query;
            try {
                mysqli_query($connection, $query);
                print('successo');
            } catch (\Throwable $th) {
                print(json_encode($th->getMessage()));
            }
        }

        if ($valueToSet == '1') {
            $query = "UPDATE stlgroup.Oraribadge SET abbuono = '$valueToSet', orarioutente = '" . $dato['OrarioInizio'] . "' WHERE id = $idBadge ";
            // print $query;
            try {
                mysqli_query($connection, $query);
                print('successo');
            } catch (\Throwable $th) {
                print(json_encode($th->getMessage()));
            }
        }
    } else {
        if ($valueToSet == '0') {
            $query = "UPDATE stlgroup.Oraribadge SET abbuono = '$valueToSet', orarioutente = '" . $dato['OrarioFine'] . "' WHERE id = $idBadge ";
            // print $query;
            try {
                mysqli_query($connection, $query);
                print('successo');
            } catch (\Throwable $th) {
                print(json_encode($th->getMessage()));
            }
        }

        if ($valueToSet == '1') {
            $query = "UPDATE stlgroup.Oraribadge SET abbuono = '$valueToSet', orarioutente = '" . $dato['OrarioFine'] . "' WHERE id = $idBadge ";
            // print $query;
            try {
                mysqli_query($connection, $query);
                print('successo');
            } catch (\Throwable $th) {
                print(json_encode($th->getMessage()));
            }
        }
    }
}
