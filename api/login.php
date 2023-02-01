<?php
if (isset($_COOKIE["PHPSESSID"])) {
    session_id($_COOKIE["PHPSESSID"]);
    session_start();
} else {
    session_start();
}

require_once('./helpers/db.php');
require_once('./helpers/type.php');

header('Content-Type: application/json');

// $username = utf8_decode($_POST['username']);
// $password = crypt(utf8_decode($_POST['password']), 'passsss');
// $password = utf8_decode($_POST['password']);
$username = $_POST['username'];
$password = $_POST['password'];

// $password= password_verify($password, $)

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


$id = 0;
$query = "SELECT * FROM stlgroup.Utenti WHERE attivo = '1' AND username='$username' AND password='$password'";
$result = mysqli_query($connection, $query);



while ($row = mysqli_fetch_row($result)) {
    $id = $row[0]; 
    $cognome = $row[1];
    $nome = $row[2];
    $username = $row[3];
    $password = $row[4];
    $admin = $row[5];
    $attivo = $row[6];
    $idsede = $row[7];
    $tema = $row[8];
    $auth = $row[9];
    $qrcodeurl = $row[10];
    $qrvisibile = $row[11];
    $giorniavvisoferie = $row[12];
    $datacreazione = $row[13];
    $idsmartphone = $row[14];
    $idpc = $row[15];
}
mysqli_free_result($result);


if ($id == NULL) {
    // printf("id: " . $id . ", nome: " . $nome . ", admin: " . $admin . ", attivo: ". $attivo . "  ");
    echo json_encode("err_no_user");
    session_destroy();
} else {
    if ($attivo == 1) {
        $_SESSION['user'] = array(
            'id' => $id,
            'cognome' => $cognome,
            'nome' => $nome,
            'username' => $username,
            'admin' => $admin,
            'attivo' => $attivo,
            'idsede' => $idsede,
            'tema' => $tema,
            'auth' => $auth,
            'qrcodeurl' => $qrcodeurl,
            'qrvisibile' => $qrvisibile,
            'giorniavvisoferie' => $giorniavvisoferie,
            'datacreazione' => $datacreazione,
            'mobile' => $mobile,
            'idsmartphone' => $idsmartphone,
            'idpc' => $idpc,
        );
        // if($qrvisibile==1){$_SESSION['user']['auth'] = $auth;}
        
        if ($admin == 0) {
            $_SESSION['key'] = crypt($nome, 'apikeycasuale');
        }
        echo json_encode($admin);
    } else {
        echo json_encode("err_no_attivo");
        session_destroy();
    }
}

$settings_query = "SELECT * FROM stlgroup.Config";
$res = mysqli_query($connection, $settings_query);
while ($row = mysqli_fetch_row($res)) {
    $nome_azienda = $row[1];
    $logo = $row[3];
    $maincolor = $row[4];
}
$_SESSION['impostazioni'] = array(
    'nome_azienda' => $nome_azienda,
    'logo' => $logo,
    'maincolor' => $maincolor,
);


// // Google Authenticator
// session_start();
// require "../dashboard/authenticator/Authenticator.php";

// $Authenticator = new Authenticator();
// if (!isset($_SESSION['auth_secret'])) {
//     $secret = $Authenticator->generateRandomSecret();
//     $_SESSION['auth_secret'] = $secret;
// }

// $qrCodeUrl = $Authenticator->getQR('myPHPnotes', $_SESSION['auth_secret']);

// if (!isset($_SESSION['failed'])) {
//     $_SESSION['failed'] = false;
// }
// $_SESSION['qrcodeurl'] = $qrCodeUrl; 

mysqli_free_result($res);


db_disconnect();
