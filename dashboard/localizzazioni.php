<? require_once('../api/helpers/logincheck.php');
require_once('../api/helpers/db.php');
require_once('../api/helpers/type.php');

$_SESSION['current_page'] = 'Localizzazioni';
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


    <? //require_once('./modals/nuovasede.php') 
    ?>
    <!-- END modals-->
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
                <h2 class="aside-title">STL<small class="text text-small"> gestione</small></h2>
                <div class="aside-addon">
                    <button class="btn btn-label-primary btn-icon btn-lg" id="burger_tasto" data-toggle="aside">
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
            <div class="content ">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- BEGIN Portlet -->
                            <div class="portlet">
                                <div class="portlet-header portlet-header-bordered">
                                    <h3 class="portlet-title">Lista localizzazioni dispositivi</h3>
                                </div>
                                <div class="portlet-body">

                                    <div class="m-3 col-12 mb-5 ">
                                        <div class="row">
                                            <div class="col-12">

                                                <form action="./localizzazioni.php" method="get" id="month-form">
                                                    <div class="row">
                                                        <div class="col-6 d-flex">
                                                            <div class="col-6">
                                                                <label for="inizio">Selziona l'inizio</label>
                                                                <input id="inizio" value="<? if (isset($_GET["inizio"]) && isset($_GET["fine"])) {
                                                                                                echo $_GET["inizio"];
                                                                                            } ?>" class="form-control" type="date" name="inizio" required />
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="fine">Selziona la fine</label>
                                                                <input id="fine" value="<? if (isset($_GET["inizio"]) && isset($_GET["fine"])) {
                                                                                            echo $_GET["fine"];
                                                                                        } ?>" class="form-control" type="date" name="fine" required />
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="utente">Selziona l'utente</label>
                                                                <select class="form-control" id="utente" name="utente" required>
                                                                    <?
                                                                    $query2 = "SELECT ut.id, ut.nome, ut.cognome, se.citta, se.indirizzo FROM stlgroup.Utenti as ut LEFT JOIN stlgroup.Sedi as se ON ut.idsede = se.id WHERE ut.admin < 1";
                                                                    $result2 = mysqli_query($connection, $query2);
                                                                    $utenti = array();
                                                                    while ($row = mysqli_fetch_row($result2)) {
                                                                        $data = array(
                                                                            "Id" => $row[0],
                                                                            "Nome" => $row[1],
                                                                            "Cognome" => $row[2],
                                                                            "Citta" => $row[3],
                                                                            "Indirizzo" => $row[4],
                                                                        );
                                                                        array_push($utenti, $data);
                                                                    }
                                                                    mysqli_free_result($result2);
                                                                    ?>
                                                                    <?
                                                                    foreach ($utenti as $utente) {
                                                                    ?>
                                                                        <option value="<?= $utente['Id'] ?>" <?
                                                                            if (isset($_GET["inizio"]) && isset($_GET["fine"]) && isset($_GET["utente"]) && $utente["Id"] == $_GET["utente"]) {
                                                                                echo "selected";
                                                                            }
                                                                            ?>><?= $utente['Cognome'] ?> <?= $utente['Nome'] ?> - <?= $utente['Citta'] ?> <?= $utente['Indirizzo']; ?></option>
                                                                    <? } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-6 d-flex align-items-end">
                                                                <input type="submit" class="btn btn-primary" value="Seleziona">
                                                            </div>
                                                            <hr>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- BEGIN Datatable -->
                                    <hr>
                                    <div id="tableOrari" >
                                        <?
                                        if (isset($_GET["inizio"]) && isset($_GET["fine"]) && isset($_GET["utente"])) {
                                        ?>
                                            <?
                                            $id = $_GET["utente"];
                                            $firstDay = $_GET["inizio"] . ' 00:00:00';
                                            $lastDay = $_GET["fine"] . ' 23:59:00';
                                            // echo "date " . $date . "<br>";
                                            // echo "firstday " . $firstDay . "<br>";
                                            // echo "lastday " . $lastDay . "<br>";

                                            $query = "SELECT * FROM stlgroup.Oraribadge WHERE idoperatore = '$id' and ora between '$firstDay' and '$lastDay' order by id desc";
                                            // echo $query;

                                            $result = mysqli_query($connection, $query);
                                            $dati = array();
                                            while ($row = mysqli_fetch_row($result)) {
                                                $data = array(
                                                    "Id" => $row[0],
                                                    "IdOperatore" => $row[1],
                                                    "Tipo" => $row[2],
                                                    "IdGiorno" => $row[3],
                                                    "Ora" => $row[4],
                                                    "Dispositivo" => $row[5],
                                                    "Posizione" => $row[6],
                                                    "ChiusuraAuto" => $row[7],
                                                    "Ora_x" => $row[8],
                                                    "Posizione_x" => $row[9],
                                                    "Dispositivo_x" => $row[10],
                                                    "IdDispositivo_x" => $row[11],
                                                );
                                                array_push($dati, $data);
                                            }
                                            // mysqli_free_result($result3);
                                            db_disconnect(); ?>
                                            <? if (count($dati) != 0) : ?>
                                                <? //$fieldinfo = mysqli_fetch_fields($result);
                                                ?>

                                                <table data-order='[[ 2, "asc" ]]' id="datatable-posizioni" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Tipo</th>
                                                            <th>Giorno</th>
                                                            <th>Ora PC</th>
                                                            <th>PC</th>
                                                            <th>Posizione PC</th>
                                                            <th>Ora Smartphone</th>
                                                            <th>Smartphone</th>
                                                            <th>Posizione Smartphone</th>
                                                            <?
                                                            // $i = 0;
                                                            // foreach ($fieldinfo as $val) {

                                                            //     echo '<th>' . $val->name . '</th>';
                                                            // } 
                                                            ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tBody">
                                                        <?
                                                        // $i = 0;
                                                        foreach ($dati as $dato) : ?>
                                                            <tr <? if ($dato['Tipo'] == "start") {
                                                                    echo 'style="background: rgba(0, 255, 0, 0.1)"';
                                                                } else {
                                                                    echo 'style="background: rgba(255, 0, 0, 0.2)"';
                                                                } ?>>

                                                                <td><?= $dato["Tipo"] ?></td>
                                                                <td><?switch($dato["IdGiorno"]) {
                                                                    case '1': echo "Lun"; break;
                                                                    case '2': echo "Mar"; break;
                                                                    case '3': echo "Mer"; break;
                                                                    case '4': echo "Gio"; break;
                                                                    case '5': echo "Ven"; break;
                                                                    case '6': echo "Sab"; break;
                                                                    case '7': echo "Dom"; break;
                                                                }?></td>
                                                                <td><?= $dato["Ora"] ?></td>
                                                                <td><?= $dato["Dispositivo"] ?></td>

                                                                <td>
                                                                    <a href="https://www.google.com/search?q=<?= $dato["Posizione"] ?>" target="_blank" class="btn btn-primary" value="<?= $dato["Posizione"] ?>">Vedi posizione PC</a>
                                                                    <p hidden><?= $dato["Posizione"] ?></p>
                                                                </td>
                                                                <td><?= $dato["Ora_x"] ?></td>
                                                                <td><?= $dato["Dispositivo_x"] ?></td>

                                                                <td>
                                                                    <a href="https://www.google.com/search?q=<?= $dato["Posizione_x"] ?>" target="_blank" class="btn btn-primary" value="<?= $dato["Posizione_x"] ?>">Vedi posizione Smartphone</a>
                                                                    <p hidden><?= $dato["Posizione_x"] ?></p>
                                                                </td>
                                                            </tr>

                                                        <? endforeach; ?>
                                                    </tbody>
                                                </table>
                                            <? else : ?>
                                                <h3 class="text text-center text-danger">Non ci sono dati</h3>
                                            <? endif ?>
                                            <? //} 
                                            ?>
                                    </div>
                                <? } else { ?>
                                    <h3 class="text text-center text-danger">Seleziona una data</h3>
                                <? } ?>
                                <!-- END Datatable -->
                                </div>
                            </div>
                            <!-- END Portlet -->
                        </div>
                        <button class="btn btn-outline-success m-3" onclick="exportTableToExcel('datatable-posizioni', `Posizioni utenti ${getDateTime()}`)">Esporta File Excel</button>
                    </div>
                </div>
            </div>
            <!-- END Page Content -->
            <!-- BEGIN Footer -->
            <? require_once("../partials/footer.php"); ?>
            <div class="float-btn float-btn-right">
                <button class="btn btn-flat-primary btn-icon mb-2" id="theme-toggle" data-toggle="tooltip" data-placement="right" title="Change theme" onclick="cambiatema()">
                    <i class="fa fa-moon"></i>
                </button>
            </div>
            <!-- END Footer -->
        </div>
        <!-- END Page Wrapper -->
    </div>
    <!-- END Page Holder -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>
    <script type="text/javascript" src="../assets/scripts/mandatory.js"></script>
    <script type="text/javascript" src="../assets/scripts/core.js"></script>
    <script type="text/javascript" src="../assets/scripts/vendor.js"></script>
    <script type="text/javascript" src="../assets/scripts/dashboard1.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.1/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.dataTables.min.css" rel="stylesheet">


    <script src="localizzazioni.js"></script>
    <style>
        .td button {
            display: none;
        }

        .td:hover>button {
            display: block;
        }

        .remove {
            animation: remove .5s ease forwards;
        }

        @keyframes remove {
            from {
                opacity: 100%;
                transform: none;
            }

            99% {
                opacity: 0;
                transform: translateX(100%);
            }

            100% {
                display: none;
            }
        }
    </style>
</body>

</html>