<?
require_once('./helpers/funzioni.php');
require_once('./helpers/logincheck.php');
require_once('./helpers/db.php');

$userid = $_SESSION['user']['id'];
$dispositivo = pulisci_sql($_POST['dispositivo']);
$value = pulisci_sql($_POST['value']);

if($value == 'smartphone'){
    $query = "UPDATE stlgroup.Utenti SET idsm = '$dispositivo' WHERE id = $userid ";
    $_SESSION['user']['idsmartphone'] = $dispositivo;
    try {
        mysqli_query($connection, $query);
        print('successo');
    } catch (\Throwable $th) {
        print(json_encode($th->getMessage()));
    }
}

if($value == 'pc'){
    $query = "UPDATE stlgroup.Utenti SET idpc = '$dispositivo' WHERE id = $userid ";
    try {
        mysqli_query($connection, $query);
        print('successo');
    } catch (\Throwable $th) {
        print(json_encode($th->getMessage()));
    }
}

