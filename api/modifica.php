<?
require_once('./helpers/db.php');
require_once('./helpers/logincheck.php');

$id = $_POST["Id"];
$valoreDaAggiornare = $_POST["valoreDaAggiornare"];
$valoreAggiornato = $_POST["valoreAggiornato"];

try {
    if ($valoreDaAggiornare == "Citta") {
        $query = "UPDATE stlgroup.Sedi SET citta = '$valoreAggiornato' WHERE id = '$id'";
        $result = mysqli_query($connection, $query);
        if ($result) {
            print "successo";
        } else {
            print "err_ins";
        }
        return;
    }
    if ($valoreDaAggiornare == "Indirizzo") {
        $query = "UPDATE stlgroup.Sedi SET indirizzo = '$valoreAggiornato' WHERE id = '$id'";
        $result = mysqli_query($connection, $query);
        if ($result) {
            print "successo";
        } else {
            print "err_ins";
        }
        return;
    }
    if ($valoreDaAggiornare == 'password') {
        // $valoreAggiornato = crypt(utf8_decode($valoreAggiornato), 'passsss');
        $query = "UPDATE stlgroup.Utenti SET $valoreDaAggiornare = '$valoreAggiornato' WHERE id = '$id'";
        $result = mysqli_query($connection, $query);
        if ($result) {
            print "successo";
        } else {
            print "err_ins_pw";
        }
        return;
    }
    if ($valoreDaAggiornare == 'Username') {
        $check = mysqli_query($connection, "SELECT Username FROM stlgroup.Utenti");
        $rows = mysqli_fetch_array($check, MYSQLI_NUM);
        foreach ($rows as $row) {
            if ($valoreAggiornato == $row) {
                $json = "errore";
            } else {
                $json = "successo";
            }
        }
        if ($json == "successo") {
            $query = "UPDATE stlgroup.Utenti SET $valoreDaAggiornare = '$valoreAggiornato' WHERE id = '$id'";
            $result = mysqli_query($connection, $query);
            if ($result) {
                print "successo";
                return;
            } else {
                print "err_ins";
                return;
            }
        } else {
            print "err_ut_exi";
            return;
        }
    } 
    if($valoreDaAggiornare == "accettato") {
        $query = "UPDATE stlgroup.Ferieepermessi SET $valoreDaAggiornare = '$valoreAggiornato' WHERE id = '$id'";
        $result = mysqli_query($connection, $query);
        if ($result) {
            print "successo";
        } else {
            print "err_ins";
        }
        return;
    }
    if($valoreDaAggiornare == "scalcolo") {
        $query = "UPDATE stlgroup.Ferieepermessi SET scalcolo = '$valoreAggiornato', accettato = '1' WHERE id = '$id'";
        $result = mysqli_query($connection, $query);
        if ($result) {
            print "successo";
        } else {
            print "err_ins";
        }
        return;
    }
    if($valoreDaAggiornare == "idnatura") {
        $query = "UPDATE stlgroup.Ferieepermessi SET idnatura = '$valoreAggiornato' WHERE id = '$id'";
        $result = mysqli_query($connection, $query);
        if ($result) {
            print "successo";
        } else {
            print "err_ins";
        }
        return;
    }
    if($valoreDaAggiornare == "tolleranzastraordinario") {
        $query = "UPDATE stlgroup.Orariutenti SET $valoreDaAggiornare = '$valoreAggiornato' WHERE idoperatore = '$id'";
        $result = mysqli_query($connection, $query);
        if ($result) {
            print "successo";
        } else {
            print "err_ins";
        }
        return;
    }
    if($valoreDaAggiornare == "orarioinizio") {
        $query = "UPDATE stlgroup.Orariutenti SET $valoreDaAggiornare = '$valoreAggiornato' WHERE id = '$id'";
        $result = mysqli_query($connection, $query);
        if ($result) {
            print "successo";
        } else {
            print "err_ins";
        }
        return;
    }
    if($valoreDaAggiornare == "orariofine") {
        $query = "UPDATE stlgroup.Orariutenti SET $valoreDaAggiornare = '$valoreAggiornato' WHERE id = '$id'";
        $result = mysqli_query($connection, $query);
        if ($result) {
            print "successo";
        } else {
            print "err_ins";
        }
        return;
    } 
    if ($valoreDaAggiornare == 'idsm' || $valoreDaAggiornare == 'idpc') {
        $query = "UPDATE stlgroup.Utenti SET $valoreDaAggiornare = NULL WHERE id = '$id'";
        $result = mysqli_query($connection, $query);
        if ($result) { print "successo"; } else { print "err_ins_idsm"; }
    } else {
        $query = "UPDATE stlgroup.Utenti SET $valoreDaAggiornare = '$valoreAggiornato' WHERE id = '$id'";
        $result = mysqli_query($connection, $query);
        if ($result) {
            print "successo";
        } else {
            print "err_ins_agg";
        }
        return;
    }
} catch (\Throwable $th) {
    print "errore";
}
