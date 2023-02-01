<?
require_once('./logincheck.php');
require_once('./db.php');
$tema = trim($_POST["tema"]);

$query = "UPDATE Utenti SET Tema='$tema' WHERE id=" . $_SESSION['user']['id'] . ";";
mysqli_query($connection, $query);

print "1";

$_SESSION['user']['tema'] = $tema;

db_disconnect();
