<?
require_once('./helpers/db.php');
require_once('./helpers/logincheck.php');

$id= $_POST["Id"];
$valoreDaAggiornare = $_POST["valoreDaAggiornare"];
$valoreAggiornato = $_POST["valoreAggiornato"];

try {
    if ($valoreDaAggiornare == 'password') {
        // $valoreAggiornato = crypt(utf8_decode($valoreAggiornato), 'passsss');
        $query = "UPDATE stlgroup.Utenti SET $valoreDaAggiornare = '$valoreAggiornato' WHERE id = '$id'";
        $result=mysqli_query($connection, $query);
        if($result){print "successo";} else{print "err_ins_pw";}
        return;
    } 
    if($valoreDaAggiornare == 'Username') {
        $check = mysqli_query($connection, "SELECT Username FROM stlgroup.Utenti");
        $rows = mysqli_fetch_array($check, MYSQLI_NUM);
        foreach ($rows as $row) {
            if ($valoreAggiornato == $row) { $json = "errore";
            } else { $json = "successo";}
        }
        if ($json == "successo") {
            $query = "UPDATE stlgroup.Utenti SET $valoreDaAggiornare = '$valoreAggiornato' WHERE id = '$id'";
            $result= mysqli_query($connection, $query);    
            if($result){print "successo";} else{print "err_ins_ut";}
        } else { print "err_ut_exi" ; }
    } else if ($valoreDaAggiornare == 'idsm' || $valoreDaAggiornare == 'idpc') {
        $query = "UPDATE stlgroup.Utenti SET $valoreDaAggiornare = NULL WHERE id = '$id'";
        $result=mysqli_query($connection, $query);
        if ($result) { print "successo"; } else { print "err_ins_idsm"; }
    } else {
            $query = "UPDATE stlgroup.Utenti SET $valoreDaAggiornare = '$valoreAggiornato' WHERE id = '$id'";
            $result = mysqli_query($connection, $query);
            if($result){ print "successo"; } else{ print "err_ins_agg"; }
    }
} catch (\Throwable $th) {
    print "errore";
}
