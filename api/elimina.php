<?
require_once('./helpers/funzioni.php');
require_once('./helpers/logincheck.php');
require_once('./helpers/db.php');

$id = pulisci_sql($_POST['id']);
$tipo = pulisci_sql($_POST['tipo']);



try {
    if ($tipo == "operatore") {
        $query = "UPDATE stlgroup.Utenti SET attivo=0 WHERE id=$id";
    } else if ($tipo == "sede") {
        $query = "UPDATE stlgroup.Sedi SET attiva=0 WHERE id=$id";
    } else if($tipo == "ferie") {
        $query = "DELETE FROM stlgroup.Ferieepermessi WHERE id=$id";
    }
    $result = mysqli_query($connection, $query);
    if ($result) {
        print "successo";
    } else {
        print "err_disattiva";
    }
} catch (\Throwable $th) {
    print(json_encode($th->getMessage()));
}
