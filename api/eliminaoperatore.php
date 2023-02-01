<?
require_once('./helpers/funzioni.php');
require_once('./helpers/logincheck.php');
require_once('./helpers/db.php');

$id = pulisci_sql($_POST['id']);

$query = "UPDATE stlgroup.Utenti SET attivo=0 WHERE id=$id";

try {
    mysqli_query($connection, $query);
    print('Successo!');
} catch (\Throwable $th) {
    print(json_encode($th->getMessage()));
}
