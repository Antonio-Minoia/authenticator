<?php

$connection = mysqli_connect("serverpersonale.it", "stlgroup", "96G&kpu43", "stlgroup");
// $connection = mysqli_connect("localhost", "root", "", "stlgroup");

$connection->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10);

function db_disconnect()
{
    global $connection;
    mysqli_close($connection);
}


$res = mysqli_query($connection, "SELECT id FROM stlgroup.Utenti");

while($id = mysqli_fetch_row($res)) {
    print "id0 ".$id[0] . '<br>';
    
    $res1 = mysqli_query($connection, "SELECT ob.id, ob.idoperatore, ob.tipo, ob.ora, ou.orariofine from stlgroup.Oraribadge ob 
    left join stlgroup.Orariutenti ou ON ou.idoperatore = ob.idoperatore
    where ob.idoperatore = '$id[0]' and ou.idgiorno = (WEEKDAY(CURDATE()) +1) 
    and (orariofine >= timediff(CURRENT_TIME(), '04:00:00') and orariofine <= addtime(CURRENT_TIME(), '00:10:00')) group by ob.id desc limit 1");
    
    while($id1 = mysqli_fetch_row($res1)) {
    
        
        print "<br> " . $id1[0]; // id
        print "<br> " . $id1[1]; // id operatore
        print "<br> " . $id1[2]; // tipo (start o stop)
        print "<br> " . $id1[3]; // ora
        print "<br> " . $id1[4]; // orariofine da orario badge
        if($id1[2] == "start") {

            $day = strftime('%u');
            $hours = date('H:i:s');

            print $day ;
            print $hours ;

            if($id1[4] <= $hours) {
                $query = "SELECT orariofine from stlgroup.Orariutenti where idoperatore = '$id1[1]' AND idgiorno = (WEEKDAY(CURDATE()) +1) order by orariofine desc limit 1";
                $res2 = mysqli_query($connection, $query);
                // print $query;
                while($id2 = mysqli_fetch_row($res2)) {
                    
                    $orarioFine = date("Y-m-d $id1[4]");
    
                    print "<br>" . $id1[4];//orario bsdge d'uscita
                    $query1 = "INSERT INTO stlgroup.Oraribadge (idoperatore, tipo, idgiorno, ora, dispositivo, posizione, chius_auto, ora_x, posizione_x, dispositivo_x) VALUES
                    ('$id1[1]', 'stop', (WEEKDAY(CURDATE()) +1), '$orarioFine', 'Chiusura AUTO',  '41.9027835 12.4963655',  1, '$orarioFine', '41.9027835 12.4963655', 'Chiusura AUTO' )";
                    print "<br>". $query1;
                    $res3 = mysqli_query($connection, $query1);
                    if($res3) { print "success"; } else { print "error"; }
                    print "<br>".date("Y-m-d $id2[0]");   //settare il giorno a giorno -1 perche alle 00.00 passa al giorno successivo
                    
                } 
            }


        } else { print "<br>OK BABY";}
        print "<br>";

    
    
    } 


} 


$resUpdate = mysqli_query($connection, "SET SQL_SAFE_UPDATES = 0;");
$resFerie = mysqli_query($connection, "UPDATE stlgroup.Ferieepermessi SET accettato = '2' WHERE inizio < NOW() AND accettato = '0'");