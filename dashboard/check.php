<?php
session_start();

require "Authenticator.php";
if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("location: auth.php");
    die();
}
$Authenticator = new Authenticator();
$checkResult = $Authenticator->verifyCode($_SESSION['user']['auth'], $_POST['code'], 2);    // 2 = 2*30sec clock tolerance

if (!$checkResult) {
    $_SESSION['failed'] = true;
    header("location: auth.php");
    die();
}

$session_value = $_POST['session'];
$userid = $_SESSION['user']['id'];

?>

<!DOCTYPE html>
<html lang="it" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&amp;family=Roboto+Mono&amp;display=swap" rel="stylesheet">
    <link href="../assets/styles/ltr-core.css" rel="stylesheet">
    <link href="../assets/styles/ltr-vendor.css" rel="stylesheet">
    <link href="../assets/styles/ltr-dashboard1.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <link rel="icon" type="image/x-icon" href="<?= $_SESSION['impostazioni']['logo'] ?>">
    <title><?= $_SESSION['current_page'] ?></title>
</head>

<body class="theme-<?= $_SESSION['user']['tema'] ?> preload-active aside-active aside-mobile-minimized aside-desktop-maximized" id="fullscreen">

    <!-- BEGIN Preload -->
    <div class="preload">
        <div class="preload-dialog">
            <div class="spinner-border text-primary preload-spinner"></div>
        </div>
    </div>
    <!-- END Preload -->
    <!-- BEGIN Page Holder -->
    <div class="holder">
        <div class="aside">
            <div class="aside-header">
                <h2 class="aside-title">
                    <?= $_SESSION['impostazioni']['nome_azienda'] ?><small class="text text-small"> gestione</small>
                </h2>
                <div class="aside-addon">
                    <button class="btn btn-label-primary btn-icon btn-lg" data-toggle="aside">
                        <i class="fa fa-times aside-icon-minimize"></i>
                        <i class="fa fa-thumbtack aside-icon-maximize"></i>
                    </button>



                </div>
            </div>
            <div class="aside-body" data-simplebar="data-simplebar">
                <!-- BEGIN Menu -->
                <? require_once('../partials/menu.php'); ?>
                <!-- END Menu -->

            </div>
        </div>

        <!-- BEGIN Page Wrapper -->
        <div class="wrapper">
            <!-- BEGIN Header -->
            <? require_once("../partials/header.php"); ?>
            <!-- END Header -->
            <!-- BEGIN Page Content -->
            <div class="content bg-grey" id="content-background">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-10">
                            <!-- BEGIN Portlet -->

                            <!-- BEGIN Datatable -->
                            <center>
                                <p><b><?= $session_value ?></b></p>
                                <?



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

                                $dispositivoIns = $os . "-" . $mobile;
                                $posizioneIns = $_COOKIE["latitude"] . " " . $_COOKIE["longitude"];
                                $tipo = "0";

                                $queryAppoggio = "SELECT * FROM stlgroup.Appoggio WHERE idoperatore = '$userid' ORDER BY id DESC LIMIT 1";

                                if ($resultAppoggio = mysqli_query($connection, $queryAppoggio)) {
                                    while ($row = mysqli_fetch_row($resultAppoggio)) {
                                        $id_x = $row[0];
                                        $idoperatore_x = $row[1];
                                        $ora_x = $row[2];
                                        $posizione_x = $row[3];
                                        $dispositivo_x = $row[4];
                                        $iddispositivo_x = $row[5];
                                    }
                                }

                                // print $queryAppoggio;

                                $queryLastBadge = "SELECT * FROM stlgroup.Oraribadge WHERE idoperatore = '$userid' ORDER BY id DESC LIMIT 1";

                                if ($resultLastBadge = mysqli_query($connection, $queryLastBadge)) {
                                    while ($row = mysqli_fetch_row($resultLastBadge)) {
                                        $id = $row[0];
                                        $idoperatore = $row[1];
                                        $tipo = $row[2];
                                        $idgiorno = $row[3];
                                        $ora = $row[4];
                                        $dispositivo = $row[5];
                                        $posizione = $row[5];
                                    }
                                }

                                // print $queryLastBadge;

                                if ($session_value == 'start') {
                                    $queryOrarioIdeale = "SELECT orarioinizio, tolleranzastraordinario, tolleranzaritardo FROM stlgroup.Orariutenti WHERE idoperatore = '$userid' and idgiorno = (WEEKDAY(CURDATE()) +1) and 
                                    (orarioinizio >= timediff(CURRENT_TIME(), '01:00:00') and orarioinizio <= addtime(CURRENT_TIME(), '01:00:00'))";
                                } else if ($session_value == 'stop') {
                                    $queryOrarioIdeale = "SELECT orariofine, tolleranzastraordinario, tolleranzaritardo FROM stlgroup.Orariutenti WHERE idoperatore = '$userid' and idgiorno = (WEEKDAY(CURDATE()) +1) and 
                                    (orariofine >= timediff(CURRENT_TIME(), '01:00:00') and orariofine <= addtime(CURRENT_TIME(), '01:00:00'))";
                                }

                                // print $queryOrarioIdeale;

                                $orario = 'CURRENT_TIME()';
                                if ($resultOrarioIdeale = mysqli_query($connection, $queryOrarioIdeale)) {
                                    while ($row = mysqli_fetch_row($resultOrarioIdeale)) {
                                        $orario = $row[0];
                                        $straordinario = $row[1];
                                        $ritardo = $row[2];
                                    }
                                }

                                $straordinario = $straordinario * 60;
                                $ritardo = $ritardo * 60;
                                // print isset($posizione_x) . ' ' . isset($posizione);
                                // print $straordinario. ' ';
                                // print $ritardo . ' ';
                                // print date("H:i:s", strtotime("now")) . ' <= ' . date("H:i:s", strtotime($orario) + $ritardo) . ' - '  . date("H:i:s", strtotime("now")) . ' >= ' . $orario;


                                // se sei nel range del ritardo...
                                if (date("H:i:s", strtotime("now")) <= date("H:i:s", strtotime($orario) + $ritardo) && date("H:i:s", strtotime("now")) >= $orario) {
                                    if (isset($posizione_x) && isset($posizioneIns)) {
                                        $insert = "INSERT INTO stlgroup.Oraribadge (idoperatore, tipo, idgiorno, ora, dispositivo, posizione, ora_x, posizione_x, dispositivo_x, iddispositivo_x) VALUES
                                    ('$userid', '$session_value', (WEEKDAY(CURDATE()) +1), DATE_FORMAT(CONCAT(CURRENT_DATE() , ' ' , '$orario'), '%Y-%m-%d %H:%i:%s'),'$dispositivoIns',  '$posizioneIns', '$ora_x', '$posizione_x', '$dispositivo_x', '$iddispositivo_x' )";
                                    } else {
                                        print "<h2 class='text-error'>OPS, c'è stato un errore, riprova rieseguendo il login!<h2/>";
                                        exit;
                                    }
                                } else {
                                    if (isset($posizione_x) && isset($posizioneIns)) {
                                        $insert = "INSERT INTO stlgroup.Oraribadge (idoperatore, tipo, idgiorno, ora, dispositivo, posizione, ora_x, posizione_x, dispositivo_x, iddispositivo_x) VALUES
                                    ('$userid', '$session_value', (WEEKDAY(CURDATE()) +1), DATE_FORMAT(CONCAT(CURRENT_DATE() , ' ' , CURRENT_TIME()), '%Y-%m-%d %H:%i:%s'),'$dispositivoIns',  '$posizioneIns', '$ora_x', '$posizione_x', '$dispositivo_x', '$iddispositivo_x' )";
                                    } else {
                                        print "<h2 class='text-error'>OPS, c'è stato un errore, riprova rieseguendo il login!<h2/>";
                                        exit;
                                    }
                                }


                                // print_r("tipo:" . $tipo . "    userid:" . $userid . "    sessionvalue:" . $session_value . " dispositivoIns:" . $dispositivoIns . " posizioneIns:" . $posizioneIns);

                                // print $insert;
                                // print isset($insert);

                                if ($tipo == $session_value) {
                                    //molto difficile che avvenga perchè c'è il contorllo di questa situazione in auth.php
                                    print "<h2 class='text-error'>OPS, c'è stato un errore, anche l'ultima volta hai effettuato uno " . $tipo . "<h2/>";
                                } else if ($tipo == "0") {
                                    try {

                                        if (mysqli_query($connection, $insert)) {

                                            print "<h2 class='text-success'>Benvenuto questa è la tua prima volta, l'operazione è andata a buon fine!<h2/>";
                                            $delete = "DELETE FROM stlgroup.Appoggio WHERE idoperatore = $userid";
                                            mysqli_query($connection, $delete);
                                        };
                                    } catch (\Throwable $th) {
                                        // print($th->getMessage());
                                        print "<h2 class='text-error'>OPS, c'è stato un errore, riprova rieseguendo il login!<h2/>";
                                    }
                                } else {
                                    try {
                                        if (mysqli_query($connection, $insert)) {

                                            print "<h2 class='text-success'>Successo, l'operazione è andata a buon fine!<h2/>";
                                            $delete = "DELETE FROM stlgroup.Appoggio WHERE idoperatore = $userid";
                                            mysqli_query($connection, $delete);
                                        };
                                    } catch (\Throwable $th) {
                                        // print($th->getMessage());
                                        print "<h2 class='text-error'>OPS, c'è stato un errore, riprova rieseguendo il login!<h2/>";
                                    }
                                }

                                // print_r("OS:" . $os . "    BROWSER:" . $br . "    DISPOSITIVO:" . $mobile . " TIPO:" . $tipo . "|");
                                ?>
                                <? if ($session_value == "start") { ?>

                                <? } else if ($session_value == "stop") { ?>

                                <? } ?>
                            </center>

                            <!-- END Datatable -->

                            <!-- END Portlet -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- END Page Content -->
            <!-- BEGIN Footer -->
            <? require_once("../partials/footer.php"); ?>
            <div class=" float-btn float-btn-right">
                <button class="btn btn-flat-primary btn-icon mb-2" id="theme-toggle" data-toggle="tooltip" data-placement="right" title="Change theme" onclick="cambiatema()">
                    <i class="fa fa-moon"></i>
                </button>
            </div>
            <!-- END Footer -->
        </div>
        <!-- END Page Wrapper -->
    </div>
    <!-- END Page Holder -->
    <script type="text/javascript" src="./check.js"></script>
    <script type="text/javascript" src="../assets/scripts/mandatory.js"></script>
    <script type="text/javascript" src="../assets/scripts/core.js"></script>
    <script type="text/javascript" src="../assets/scripts/vendor.js"></script>
    <script type="text/javascript" src="../assets/scripts/dashboard1.js"></script>

</body>

</html>