<?
require_once('./helpers/logincheck.php');
require_once('./helpers/db.php');
require_once('./helpers/type.php');
require_once('./helpers/funzioni.php');



$citta = $_POST['citta'];
$attiva = $_POST['attiva'];


$res = mysqli_query($connection, "SELECT * from stlgroup.Sedi WHERE citta = '$citta'");
if (mysqli_fetch_row($res)) {
    print "err_sede_exist";
    
} else {
    $query = "INSERT INTO stlgroup.Sedi (citta, attiva) VALUES ('$citta', $attiva)";
    
    $result = mysqli_query($connection, $query);
    // echo $secret . " " . $code. " " . $qrCodeUrl;
    
    try {
        if($result){print "successo"; exit;} else { print "errore"; exit; }
    } catch (\Throwable $th) {
        print($th->getMessage());
    }
}


db_disconnect();
