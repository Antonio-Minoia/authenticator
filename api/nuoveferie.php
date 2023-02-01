<?
require_once('./helpers/logincheck.php');
require_once('./helpers/db.php');
require_once('./helpers/type.php');
require_once('./helpers/funzioni.php');


$idoperatore = $_SESSION['user']['id'];
$inizio = $_POST['inizio'];
$fine = $_POST['fine'];
$urgente = $_POST['urgente'];
$idnatura = $_POST['natura'];

if ($idnatura != 0) {

    $res = mysqli_query($connection, "SELECT * FROM stlgroup.Ferieepermessi WHERE idoperatore = '$idoperatore' AND 
(accettato = '0' OR accettato = '1') AND (
('$inizio' >= inizio AND '$inizio' <= fine) or
('$fine' >= inizio AND '$fine' <= fine) or
('$inizio' <= inizio AND '$fine' >= fine)) or 
inizio LIKE '". substr($inizio, 0 ,10) ."%' or fine LIKE '". substr($fine, 0 ,10) ."'");
    if (mysqli_fetch_row($res)) {

        print "err_ferie_exist";
    } else {
        $query = "INSERT INTO stlgroup.Ferieepermessi (idoperatore, inizio, fine, accettato, urgente, idnatura) VALUES ('$idoperatore', '$inizio', '$fine', 0, $urgente, $idnatura)";

        $result = mysqli_query($connection, $query);
        // echo $query . " result:" . $result;

        try {
            if ($result) {
                print "successo";
                exit;
            } else {
                print "errore";
                exit;
            }
        } catch (\Throwable $th) {
            print($th->getMessage());
        }
    }
} else {
    $res = mysqli_query($connection, "SELECT * FROM stlgroup.Ferieepermessi WHERE idoperatore = '$idoperatore' AND 
    (accettato = '0' OR accettato = '1') AND (
    ('$inizio' >= inizio AND '$inizio' <= fine) or
    ('$fine' >= inizio AND '$fine' <= fine) or
    ('$inizio' <= inizio AND '$fine' >= fine))");
        if (mysqli_fetch_row($res)) {
    
            print "err_ferie_exist";
        } else {
            $query = "INSERT INTO stlgroup.Ferieepermessi (idoperatore, inizio, fine, accettato, urgente, idnatura) VALUES ('$idoperatore', '$inizio', '$fine', 0, $urgente, 0)";
    
            $result = mysqli_query($connection, $query);
            // echo $query . " result:" . $result;
    
            try {
                if ($result) {
                    print "successo";
                    exit;
                } else {
                    print "errore";
                    exit;
                }
            } catch (\Throwable $th) {
                print($th->getMessage());
            }
        }
}

db_disconnect();
