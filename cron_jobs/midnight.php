<?php

$connection = mysqli_connect("serverpersonale.it", "stlgroup", "96G&kpu43", "stlgroup");

$connection->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10);

function db_disconnect()
{
    global $connection;
    mysqli_close($connection);
}



// mysqli_query($connection, "CALL rifiuta_ferie()");
// CREATE DEFINER=`root`@`localhost` PROCEDURE `rifiuta_ferie`()
// BEGIN
// 	SET SQL_SAFE_UPDATES = 0;
// 	UPDATE ferieepermessi
//     SET accettato = '1' WHERE inizio <= now();
// END


$res = mysqli_query($connection, "SELECT id FROM stlgroup.Utenti");

while($id = mysqli_fetch_row($res)) {
    
    $res1 = mysqli_query($connection, "SELECT id, idoperatore, tipo, ora from stlgroup.Oraribadge where idoperatore = '$id[0]' order by id desc limit 1");
    
    while($id1 = mysqli_fetch_row($res1)) {
    
        
        print " " . $id1[0]; // id
        print " " . $id1[1]; // id operatore
        print " " . $id1[2]; // tipo (start o stop)
        print " " . $id1[3]; // ora
        if($id1[2] == "start") {

            $day = strftime('%u');

            print $day ;
            $query = "SELECT orariofine from stlgroup.Orariutenti where idoperatore = '$id1[1]' AND idgiorno = (WEEKDAY(CURDATE()) +1) order by orariofine desc limit 1";
            $res2 = mysqli_query($connection, $query);
            // print $query;
            while($id2 = mysqli_fetch_row($res2)) {
                
                $orarioFine = date("Y-m-d $id2[0]");

                print "<br>" . $id2[0];//orario bsdge d'uscita
                $query1 = "INSERT INTO stlgroup.Oraribadge (idoperatore, tipo, idgiorno, ora, dispositivo, posizione, chius_auto, ora_x, posizione_x, dispositivo_x) VALUES
                ('$id1[1]', 'stop', (WEEKDAY(CURDATE()) +1), '$orarioFine', 'Windows-PC',  '41.9027835 12.4963655',  1, '$orarioFine', '41.9027835 12.4963655', 'Chiusura AUTO')";
                print "<br>". $query1;
                $res3 = mysqli_query($connection, $query1);
                if($res3) { print "success"; } else { print "error"; }
                print "<br>".date("Y-m-d $id2[0]");   //settare il giorno a giorno -1 perche alle 00.00 passa al giorno successivo
                
            } 


        } else { print "OK BABY";}
        print "<br>";

    
    
    } 


} 


$resUpdate = mysqli_query($connection, "SET SQL_SAFE_UPDATES = 0;");
$resFerie = mysqli_query($connection, "UPDATE stlgroup.Ferieepermessi SET accettato = '2' WHERE inizio < NOW() AND accettato = '0'");