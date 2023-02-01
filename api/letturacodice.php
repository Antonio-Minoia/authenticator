<?php
require_once('./helpers/funzioni.php');
require_once('./helpers/logincheck.php');
require_once('./helpers/db.php');


// Simple browser and OS detection script.
// This will not work if User Agent is false.
$agent = $_SERVER['HTTP_USER_AGENT'];
// Detect Device/Operating System
if (preg_match('/Linux/i', $agent)) $os = 'Linux';
elseif (preg_match('/Mac/i', $agent)) $os = 'Mac';
elseif (preg_match('/iPhone/i', $agent)) $os = 'iPhone';
elseif (preg_match('/iPad/i', $agent)) $os = 'iPad';
elseif (preg_match('/Droid/i', $agent)) $os = 'Droid';
elseif (preg_match('/Unix/i', $agent)) $os = 'Unix';
elseif (preg_match('/Windows/i', $agent)) $os = 'Windows';
else $os = 'Unknown';

// Browser Detection

if (preg_match('/Firefox/i', $agent)) $br = 'Firefox';
elseif (preg_match('/Mac/i', $agent)) $br = 'Mac';
elseif (preg_match('/Chrome/i', $agent)) $br = 'Chrome';
elseif (preg_match('/Opera/i', $agent)) $br = 'Opera';
elseif (preg_match('/MSIE/i', $agent)) $br = 'IE';
else $bs = 'Unknown';

function isMobileDevice()
{
    return preg_match(
        "/(android|avantgo|blackberry|bolt|boost|cricket|docomo
                                    |fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i",
        $_SERVER["HTTP_USER_AGENT"]
    );
}
if (isMobileDevice()) {
    $mobile = "Mobile";
} else {
    $mobile = "PC";
}
$giorno = date("D");

$userid = $_SESSION['user']['id'];
$dispositivoIns = $os . "-" . $mobile;
$posizione = pulisci_sql($_POST['posizione']);
$dispositivo = pulisci_sql($_POST['dispositivo']);
$value = pulisci_sql($_POST['value']);

if($value == "insert") {
    $query = "INSERT INTO stlgroup.Appoggio (idoperatore, posizione, dispositivo, iddispositivo)
            VALUES ('$userid', '$posizione', '$dispositivoIns', '$dispositivo')";
}

if($value == "update") {
    $query = "UPDATE stlgroup.Appoggio SET ora = CURRENT_TIMESTAMP(), posizione = '$posizione', dispositivo = '$dispositivoIns', iddispositivo = '$dispositivo' WHERE idoperatore = '$userid'";
}

try {
    mysqli_query($connection, $query);
    print('successo');
} catch (\Throwable $th) {
    print(json_encode($th->getMessage()));
}
