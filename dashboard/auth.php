<?php
require_once('../api/helpers/logincheck.php');
require_once('../api/helpers/db.php');

require "Authenticator.php";

if ($_SESSION['user']['mobile'] == "PC") {
    $Authenticator = new Authenticator();


    $code = $Authenticator->getCode($_SESSION['user']['auth']);
    $qrCodeUrl = $Authenticator->getQR('STL Group', $_SESSION['user']['auth']);

    if (!isset($_SESSION['failed'])) {
        $_SESSION['failed'] = false;
    }

    $_SESSION['current_page'] = 'Autenticazione';

    $qrCodeVisibility = true;
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
                            <div class="col-12">
                                <!-- BEGIN Portlet -->

                                <?
                                $id = 0;
                                $checkferie = "SELECT id, inizio, fine, urgente, idnatura FROM stlgroup.ferieepermessi WHERE accettato = 1 AND idoperatore = " . $_SESSION['user']['id'] . " AND inizio <= Current_timestamp() AND fine >= Current_timestamp()";

                                $result = mysqli_query($connection, $checkferie);

                                while ($row = mysqli_fetch_row($result)) {
                                    $id = $row[0];
                                    $inizio = $row[1];
                                    $fine = $row[2];
                                    $urgente = $row[3];
                                    $idnatura = $row[4];
                                }

                                // $now = date('d-m-y h:i:s');


                                if ($id != 0) {
                                ?>
                                    <center>
                                        <p>
                                            <b>
                                                <? if ($urgente == 0 && $idnatura == 0) {
                                                    echo "Hai richiesto delle ferie";
                                                }
                                                if ($urgente != 0 && $idnatura != 0) {
                                                    echo "Hai richiesto un permesso urgente";
                                                }
                                                if ($urgente == 0 && $idnatura != 0) {
                                                    echo "Hai richiesto un permesso";
                                                }
                                                ?>
                                                <br> dal <span style="color: green; font-size:large"><?= $inizio ?></span><br> al <span style="color: red; font-size:large"><?= $fine ?></span><br> quindi non puoi accedere.
                                            </b>
                                        </p>
                                    </center>
                                <?
                                } else {
                                ?>
                                    <!-- BEGIN Datatable -->
                                    <center>
                                        <div class="col-sm-10" style="text-align: center;">
                                            <div id="getloc">

                                                <p>Clicca il bottone per attivare la geolocalizzazione.</p>
                                                <button type="button" class="btn btn-danger btn-lg" onclick="getLocation()"> Attiva Geolocalizzazione</button>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#myModal">
                                                    Tutorial
                                                </button>
                                            </div>
                                            <div id="location"></div>


                                            <!-- Modal Tutorial -->

                                            <? if ($mobile == "Mobile") { ?>
                                                <!-- Modal MOBILE-->
                                                <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel">Tutorial</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h4 class="mt-1">Devi attivare la pasizione del tuo dispositivo abbassando la tendina e attivando il bottone POSIZIONE</h4>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END Modal MOBILE Tutorial -->
                                            <? } else { ?>
                                                <!-- Modal PC-->
                                                <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel">Tutorial</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h4 class="mt-1">Clicca su questa icona in alto</h4>
                                                                <img class="img-fluid" src="../assets/images/tutorial1.png">
                                                                <h4 class="mt-3">Eseguire istruzione 1 e 2</h4>
                                                                <img class="img-fluid" src="../assets/images/tutorial2.png">

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END Modal PC Tutorial -->
                                            <? } ?>

                                        </div>
                                        <?php
                                        $userid = $_SESSION['user']['id'];
                                        $idgiorno = "non definito";
                                        $tipo = "0";
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

                                        $giorno = "";
                                        switch ($idgiorno) {
                                            case "1":
                                                $giorno = "Lunedì";
                                                break;
                                            case "2":
                                                $giorno = "Martedì";
                                                break;
                                            case "3":
                                                $giorno = "Mercoledì";
                                                break;
                                            case "4":
                                                $giorno = "Giovedì";
                                                break;
                                            case "5":
                                                $giorno = "Venerdì";
                                                break;
                                            case "6":
                                                $giorno = "Sabato";
                                                break;
                                            case "7":
                                                $giorno = "Domenica";
                                                break;
                                            default:
                                                $giorno = "Non definito";
                                        }

                                        ?>

                                        <div id="session" class="col-sm-10 text-center mt-3" style="visibility: hidden;">
                                            <? if ($tipo == "start") { ?>
                                                <p>Hai iniziato una sessione <br><b><?= $giorno ?> <? $newDate = date("d-m-Y", strtotime($ora));
                                                                                                    echo $newDate ?></b> alle <b><? $newTime = date("H:i:s", strtotime($ora));
                                                                                                                                    echo $newTime ?></b></p>
                                            <? } ?>
                                            <? if ($tipo == "stop") { ?>
                                                <p>L'ultima sessione è terminata <br><b><?= $giorno ?> <? $newDate = date("d-m-Y", strtotime($ora));
                                                                                                        echo $newDate ?></b> alle <b><? $newTime = date("H:i:s", strtotime($ora));
                                                                                                                                        echo $newTime ?></b></p>
                                            <? } ?>
                                            <button type="button" class="btn btn-success btn-lg m-1" onclick="handlesession('start')" <?
                                                                                                                                        if ($tipo == "start") {
                                                                                                                                            print "disabled";
                                                                                                                                        } ?>>INIZA SESSIONE</button>
                                            <button type="button" class="btn btn-danger btn-lg m-1" onclick="handlesession('stop')" <?
                                                                                                                                    if ($tipo == "stop" || $tipo == "0") {
                                                                                                                                        print "disabled";
                                                                                                                                    } ?>>TERMINA SESSIONE</button>
                                        </div>

                                        <div id="auth" class="col-sm-10 text-center" style="visibility:hidden">
                                            <div class="col-12">

                                                <button type="button" class="btn btn-outline-secondary mt-5" data-toggle="modal" data-target="#myModal2">
                                                    Tutorial
                                                </button>
                                                <p style="font-style: italic; font-weight:bold; font-size: 16px" class="mt-5">Inserisci il codice d'autenticazione</p>
                                            </div>
                                            <!-- Modal Authenticator-->
                                            <div class="col-12">

                                                <div class="modal" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel2">Tutorial</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h4 class="mt-1">Accedere all'app tramite smartphone</h4>
                                                                <p class="mt-1">1. Attivare la localizzazione sullo smartphone.</p>
                                                                <p class="mt-1">2. Accedere con le stesse credenziali utilizzate per il pc.</p>
                                                                <p class="mt-1">3. Aprire il menu a tendina e selezionare la voce "Codice".</p>
                                                                <p class="mt-1">4. Leggere il codice ed inserirlo sul PC entro lo scadere dei 30 secondi.</p>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END Modal Authenticator -->

                                            <div class="col-12 d-flex justify-content-center">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="row">
                                                            <?php if ($_SESSION['failed']) : ?>

                                                                <div class="alert alert-danger col-12 d-flex justify-content-center" role="alert">
                                                                    <strong>Ops! </strong> Il codice non era valido.
                                                                </div>
                                                                <?php
                                                                $_SESSION['failed'] = false;
                                                                ?>
                                                            <?php endif ?>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col mt-5">
                                                                <form action="check.php" method="POST" id="auth-form">
                                                                    <input type="text" class="form-control text-center d-inline-flex fs-2" name="code" placeholder="Inserisci qui il codice" style="width: 200px; color: #0275d8;"><br> <br>
                                                                    <input id="session-value" name="session" value="" hidden />
                                                                    <button type="submit" class="btn btn-primary">Verifica codice</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- <div class="col-4" style="text-align: center;">
                                            <p>Autenticazione avvenuta!</p>
                                        </div> -->

                                    </center>

                                <? } ?>
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
        <script type="text/javascript" src="./auth.js"></script>
        <script type="text/javascript" src="../assets/scripts/mandatory.js"></script>
        <script type="text/javascript" src="../assets/scripts/core.js"></script>
        <script type="text/javascript" src="../assets/scripts/vendor.js"></script>
        <script type="text/javascript" src="../assets/scripts/dashboard1.js"></script>

    </body>

    </html>
<? } else {
    header('Location: ../dashboard');
    exit;
} ?>