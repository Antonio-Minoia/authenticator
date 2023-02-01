<?php
require_once('../api/helpers/logincheck.php');
require_once('../api/helpers/db.php');


if ($_SESSION['user']['mobile'] == "Mobile") {
    require "Authenticator.php";
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
    // echo $mobile;
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


                                <!-- BEGIN Datatable -->
                                <center>
                                    <div class="col-sm-6" style="text-align: center;">
                                        <?
                                        if ($_SESSION['user']['idsmartphone'] == NULL) {

                                        ?>
                                            <div id="idsm">
                                                <button type="button" class="btn btn-primary btn-lg" onclick="setFavourite()">Imposta come dispositivo preferito</button>
                                            </div>
                                            <?
                                        } else {
                                            ?>
                                            <div id="idsm">
                                                <p id="idsmvalue" style="opacity: 0;"><?= $_SESSION['user']['idsmartphone']?></p>
                                            </div>
                                            <?
                                        }
                                        ?>

                                        <div id="getLocation" style="visibility: hidden;">
                                            <p>Clicca il bottone per attivare la geolocalizzazione.</p>
                                            <button type="button" class="btn btn-danger btn-lg" onclick="getLocation()"> Attiva Geolocalizzazione</button>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#myModal">
                                                Tutorial
                                            </button>
                                        </div>

                                        <div class="portlet" id="div-location" style="visibility:hidden">
                                            <div class="portlet-header">
                                                <p class="text-danger"><b>Errore</b></p>
                                            </div>
                                            <div class="portlet-body">
                                                <b><div id="location" style="font-size: 16px"></div></b>
                                            </div>
                                        </div>


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
                                    $id = 0;
                                    $queryLastBadge = "SELECT * FROM stlgroup.Appoggio WHERE idoperatore = '$userid' ORDER BY id DESC LIMIT 1";
                                    $resultLastBadge = mysqli_query($connection, $queryLastBadge);

                                    $dati = array();
                                    while ($row = mysqli_fetch_row($resultLastBadge)) {
                                        $id = $row[0];
                                        $idoperatore = $row[1];
                                        $ora = $row[2];
                                        $posizioneSmartphone = $row[3];
                                        $dipositivo = $row[4];
                                        $iddispositivo = $row[5];
                                    }

                                    if ($id == NULL) {
                                    ?>

                                        <div id="session" class="col-sm-10 text-center mt-3 mb-3 d-flex justify-content-center" style="
                                        visibility:hidden
                                        ">
                                            <button type="button" class="btn btn-primary btn-lg m-1" onclick="showCode('show')">MOSTRA CODICE</button>
                                        </div>

                                        <!-- <h4 style="font-weight:bold" class="mt-5">Codice da inserire</h4> -->
                                        <div id="auth" class="col-sm-10 text-center mt-3 d-flex justify-content-center" style="
                                        visibility:hidden
                                        ">


                                            <button type="button" class="btn btn-outline-primary" style="font-size: 30px; border-radius: 10px"><?= $code ?></button>

                                            <div class="ml-3 mt-3" id="app"></div>
                                        </div>
                                    <?
                                    } else {
                                    ?>
                                        <h4 style="font-weight:bold" class="mt-5">Codice da inserire</h4>
                                        <div id="auth" class="col-sm-10 text-center mt-3 d-flex justify-content-center" style="
                                        visibility:hidden
                                        ">


                                            <button type="button" class="btn btn-outline-primary" style="font-size: 30px; border-radius: 10px"><?= $code ?></button>

                                            <div class="ml-3 mt-3" id="app"></div>
                                        </div>
                                    <?
                                    }

                                    ?>
                                    <!-- <div class="col-4" style="text-align: center;">
                                            <p>Autenticazione avvenuta!</p>
                                        </div> -->

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
        <script type="text/javascript" src="./codice.js"></script>
        <script type="text/javascript" src="../assets/scripts/mandatory.js"></script>
        <script type="text/javascript" src="../assets/scripts/core.js"></script>
        <script type="text/javascript" src="../assets/scripts/vendor.js"></script>
        <script type="text/javascript" src="../assets/scripts/dashboard1.js"></script>
        <style>
            body {
                font-family: sans-serif;
                display: grid;
                height: 100vh;
                place-items: center;
            }

            .base-timer {
                position: relative;
                width: 30px;
                height: 30px;
            }

            .base-timer__svg {
                transform: scaleX(1);
            }

            .base-timer__circle {
                fill: none;
                stroke: none;
            }

            .base-timer__path-elapsed {
                stroke-width: 7px;
                stroke: grey;
            }

            .base-timer__path-remaining {
                stroke-width: 7px;
                stroke-linecap: round;
                transform: rotate(90deg);
                transform-origin: center;
                transition: 1s linear all;
                fill-rule: nonzero;
                stroke: currentColor;
            }

            .base-timer__path-remaining.green {
                color: #0d6efd;
            }

            .base-timer__path-remaining.orange {
                color: orange;
            }

            .base-timer__path-remaining.red {
                color: red;
            }

            .base-timer__label {
                position: absolute;
                width: 300px;
                height: 300px;
                top: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0px;
            }
        </style>

    </body>

    </html>
<? } else {
    header('Location: ../dashboard');
    exit;
} ?>