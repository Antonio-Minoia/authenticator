<?
require_once('./helpers/logincheck.php');
require_once('./helpers/db.php');
require_once('./helpers/type.php');

require_once('./helpers/funzioni.php');

//creazione codice QR per Google Authenticator
// session_start();
require "Authenticator.php";
$Authenticator = new Authenticator();
$auth = $Authenticator->generateRandomSecret();
$code = $Authenticator->getCode($auth);

// echo $auth;


$cognome = pulisci_sql($_POST['cognome']);
$nome = pulisci_sql($_POST['nome']);
$user = pulisci_sql($_POST['user']);
$pass = pulisci_sql($_POST['pass']);
$sede = pulisci_sql($_POST['sede']);
$tipo = pulisci_sql($_POST['tipo']);
$qrvisibilita = pulisci_sql($_POST['qrvisibilita']);
$preavviso = pulisci_sql($_POST['preavviso']);
$tolleranzastraordinario = $_POST['tolleranza'];
$ritardo = $_POST['ritardo'];
if (!$preavviso) {
    $preavviso == "0";
}
if ($tolleranzastraordinario == "") {
    $tolleranzastraordinario == "0";
}
if ($ritardo == "") {
    $ritardo == "0";
}


$l1 = $_POST['l1'];
$l2 = $_POST['l2'];
$l3 = $_POST['l3'];
$l4 = $_POST['l4'];
$m1 = $_POST['m1'];
$m2 = $_POST['m2'];
$m3 = $_POST['m3'];
$m4 = $_POST['m4'];
$w1 = $_POST['w1'];
$w2 = $_POST['w2'];
$w3 = $_POST['w3'];
$w4 = $_POST['w4'];
$g1 = $_POST['g1'];
$g2 = $_POST['g2'];
$g3 = $_POST['g3'];
$g4 = $_POST['g4'];
$v1 = $_POST['v1'];
$v2 = $_POST['v2'];
$v3 = $_POST['v3'];
$v4 = $_POST['v4'];
$s1 = $_POST['s1'];
$s2 = $_POST['s2'];
$s3 = $_POST['s3'];
$s4 = $_POST['s4'];
$d1 = $_POST['d1'];
$d2 = $_POST['d2'];
$d3 = $_POST['d3'];
$d4 = $_POST['d4'];
$qrCodeUrl = $Authenticator->getQR('STL Group', $auth);

$res = mysqli_query($connection, "SELECT * from stlgroup.Utenti WHERE username = '$user' ");
if (mysqli_fetch_row($res)) {
    print(json_encode("Operatore già esistente. Assicurati che non ci sia un altro operatore con questo username ($user)"));
    exit;
}

try {
    $query = "INSERT INTO stlgroup.Utenti ( cognome, nome, username, password, admin, attivo, idsede, tema, qrurl, auth, qrvisibile, giorniavvisoferie
) VALUES ('$cognome', '$nome', '$user', '$pass', '$tipo',  1, '$sede', 'light', '$qrCodeUrl','$auth', '$qrvisibilita', '$preavviso')";

    $result = mysqli_query($connection, $query);

    if ($result) {
        $lastid = 0;
        $lastidquery = "SELECT MAX(id) as id FROM stlgroup.Utenti ORDER BY id asc";
        $resultid = mysqli_query($connection, $lastidquery);
        while ($row = mysqli_fetch_row($resultid)) {
            $lastid = $row[0];
        }
        if ($resultid) {



            if ($l1 == "" && $l2 == "") {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '00:00:00', '00:00:00', '1', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            } else {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '$l1', '$l2', '1', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            }
            if ($l3 == "" && $l4 == "") {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '00:00:00', '00:00:00', '1', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            } else {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '$l3', '$l4', '1', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            }

            if ($m1 == "" && $m2 == "") {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '00:00:00', '00:00:00', '2', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            } else {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '$m1', '$m2', '2', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            }
            if ($m3 == "" && $m4 == "") {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '00:00:00', '00:00:00', '2', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            } else {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '$m3', '$m4', '2', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            }

            if ($w1 == "" && $w2 == "") {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '00:00:00', '00:00:00', '3', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            } else {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '$w1', '$w2', '3', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            }
            if ($w3 == "" && $w4 == "") {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '00:00:00', '00:00:00', '3', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            } else {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '$w3', '$w4', '3', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            }

            if ($g1 == "" && $g2 == "") {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '00:00:00', '00:00:00', '4', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            } else {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '$g1', '$g2', '4', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            }
            if ($g3 == "" && $g4 == "") {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '00:00:00', '00:00:00', '4', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            } else {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '$g3', '$g4', '4', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            }

            if ($v1 == "" && $v2 == "") {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '00:00:00', '00:00:00', '5', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            } else {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '$v1', '$v2', '5', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            }
            if ($v3 == "" && $v4 == "") {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '00:00:00', '00:00:00', '5', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            } else {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '$v3', '$v4', '5', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            }

            if ($s1 == "" && $s2 == "") {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '00:00:00', '00:00:00', '6', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            } else {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '$s1', '$s2', '6', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            }
            if ($s3 == "" && $s4 == "") {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '00:00:00', '00:00:00', '6', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            } else {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '$s3', '$s4', '6', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            }

            if ($d1 == "" && $d2 == "") {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '00:00:00', '00:00:00', '7', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            } else {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '$d1', '$d2', '7', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            }
            if ($d3 == "" && $d4 == "") {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '00:00:00', '00:00:00', '7', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            } else {
                $query2 = "INSERT INTO stlgroup.Orariutenti ( idoperatore, orarioinizio, orariofine, idgiorno, tolleranzastraordinario, tolleranzaritardo) 
            VALUES ( '$lastid', '$d3', '$d4', '7', '$tolleranzastraordinario', '$ritardo')";
                $result2 = mysqli_query($connection, $query2);
            }
        }
        // echo $secret . " " . $code. " " . $qrCodeUrl;
        // print "php: lastid:".$lastid ." tolleranza:" . $tolleranzastraordinario. " ritardo:". $ritardo . " lunedi:".$l1.$l2.$l3.$l4.$m1.$m2.$m3.$m4.$w1.$w2.$w3.$w4.$g1.$g2.$g3.$g4.$v1.$v2.$v3.$v4.$s1.$s2.$s3.$s4.$d1.$d2.$d3.$d4;
        print 'successo';
    } else {
        print $query;
    }
} catch (\Throwable $th) {
    print($th->getMessage());
}






db_disconnect();
