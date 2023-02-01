<?
require_once('../api/helpers/logincheck.php');
require_once('../api/helpers/db.php');
require_once('../api/helpers/type.php');

$_SESSION['current_page'] = 'Modifica Utente';

$id = $_GET['Id'];

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


    <? require_once('./modals/nuovasede.php') ?>
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
                                    <h3 class="portlet-title">Modifica</h3>
                                </div>
                                <div class="portlet-body">
                                    <!-- BEGIN Datatable -->
                                    <?
                                    $query = "SELECT * FROM stlgroup.Utenti where id = '$id' ";
                                    $result = mysqli_query($connection, $query);
                                    $operatori = array();
                                    while ($row = mysqli_fetch_row($result)) {
                                        if ($row[0] != $_SESSION['user']['id']) {
                                            $data = array(
                                                "Id" => $row[0],
                                                "Cognome" => $row[1],
                                                "Nome" => $row[2],
                                                "Username" => $row[3],
                                                "Password" => $row[4],
                                                "Admin" => $row[5],
                                                "Attivo" => $row[6],
                                                "IdSede" => $row[7],
                                                "Tema" => $row[8],
                                                "Auth" => $row[9],
                                                "Qrurl" => $row[10],
                                                "Qr visibile" => $row[11],
                                                "Preavviso" => $row[12],
                                                "Data creazione" => $row[13],
                                                "IDSmart" => $row[14],
                                                "IDPc" => $row[15],
                                            );
                                            array_push($operatori, $data);
                                        }
                                    }

                                    ?>

                                    <!-- <form id="nuovo-operatore" name="nuovo-operatore"> -->
                                    <div class="modal-body">
                                        <!-- BEGIN Form Group -->
                                        <? foreach ($operatori as $operatore) : ?>
                                            <div class="row">
                                                <div class="td col-6">
                                                    <label>Cognome</label>
                                                    <input disabled type="text" class="form-control" id="cognome2" name="cognome" value="<?= $operatore['Cognome'] ?>" data-parsley-required maxlength="50">
                                                    <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $operatore['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                    <p hidden><?= $operatore['Cognome'] ?></p>
                                                </div>



                                                <div class="td col-6">
                                                    <label>Nome</label>
                                                    <input disabled type="text" class="form-control" id="nome2" name="nome" value="<?= $operatore['Nome'] ?>" data-parsley-required>
                                                    <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $operatore['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                    <p hidden><?= $operatore['Nome'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row mt-4">


                                                <hr>
                                                <div class="td col-6">
                                                    <label>Username</label>
                                                    <input disabled type="text" class="form-control" id="user2" name="username" value="<?= $operatore['Username'] ?>" minlength="10" data-parsley-required>
                                                    <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $operatore['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                    <p hidden><?= $operatore['Username'] ?></p>
                                                </div>



                                                <div class="td col-6">
                                                    <label>Password</label>
                                                    <input disabled <? if ($_SESSION['user']['admin'] == 2) {
                                                                        echo 'type="text"';
                                                                    } else {
                                                                        echo 'type="password"';
                                                                    } ?> class="form-control" id="pass2" name="password" <?
                                                                                                                            echo 'value="' . $operatore['Password'] . '"';
                                                                                                                            ?> placeholder="" data-parsley-required>
                                                    <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $operatore['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                </div>

                                            </div>
                                            <div class="row mt-4">

                                                <div class="td col-6">
                                                    <label>Sede di appartenenza</label>
                                                    <select disabled class="form-control" id="sede2" name="idsede">
                                                        <?
                                                        $query2 = "SELECT * FROM stlgroup.Sedi";
                                                        $result2 = mysqli_query($connection, $query2);
                                                        $sedi = array();
                                                        while ($row = mysqli_fetch_row($result2)) {
                                                            $data2 = array(
                                                                "Id" => $row[0],
                                                                "Citta" => $row[1],
                                                                "Indirizzo" => $row[2],
                                                                "Attiva" => $row[3],
                                                            );
                                                            array_push($sedi, $data2);
                                                        }
                                                        mysqli_free_result($result2);

                                                        ?>
                                                        <?
                                                        foreach ($sedi as $sede) {
                                                            if ($sede['Attiva'] == "1") {
                                                        ?>
                                                                <option value="<?= $sede['Id'] ?>" <? if ($operatore['IdSede'] == $sede['Id']) {
                                                                                                        echo "selected";
                                                                                                    } ?>><?= $sede['Citta'] ?></option>
                                                        <? }
                                                        }
                                                        ?>
                                                    </select>
                                                    <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $operatore['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                    <p hidden><?= $operatore['IdSede'] ?></p>
                                                </div>



                                                <div class="td col-6">
                                                    <label>Accessibilità</label>
                                                    <select disabled class="form-control" id="tipologia2" name="admin">
                                                        <option value="1" <? if ($operatore['Admin']) {
                                                                                echo "selected";
                                                                            } ?>>Amministratore</option>
                                                        <option value="0" <? if (!$operatore['Admin']) {
                                                                                echo "selected";
                                                                            } ?>>Utente</option>
                                                        <? if ($operatore['Admin'] == 2) {
                                                            echo '<option value="2" selected>SuperAdmin</option>';
                                                        } ?>
                                                    </select>
                                                    <? if ($operatore['Admin'] < 2) { ?>
                                                        <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $operatore['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                    <? } ?>
                                                    <p hidden><?= $operatore['Admin'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <? if ($operatore["Admin"] < 1) { ?>
                                                    <!-- <hr> -->
                                                    <div class="td col-6">
                                                        <label>Giorni di avviso per ferie</label>
                                                        <input disabled type="number" class="form-control" id="preavviso2" name="giorniavvisoferie" value="<?= $operatore['Preavviso'] ?>" data-parsley-required>
                                                        <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $operatore['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                        <p hidden><?= $operatore['Preavviso'] ?></p>
                                                    </div>
                                                    <!-- <hr>
                                                    <div class="td col-6">
                                                        <label>Può visualizzare il QR code?</label>
                                                        <select disabled class="form-control" id="qrvisibilita2" name="qrvisibile">
                                                            <option value="1" <? if ($operatore['Qr visibile'] == 1) {
                                                                                    echo "selected";
                                                                                } ?>>Si</option>
                                                            <option value="0" <? if ($operatore['Qr visibile'] == 0) {
                                                                                    echo "selected";
                                                                                } ?>>No</option>
                                                        </select>
                                                        <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $operatore['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                        <p hidden><?= $operatore['Qr visibile'] ?></p>
                                                    </div> -->

                                                <? } ?>



                                            <? endforeach; ?>

                                            <?
                                            if ($operatore['Admin'] == "0") {


                                                $query3 = "SELECT * FROM stlgroup.Orariutenti WHERE idoperatore = '$id'";
                                                $result3 = mysqli_query($connection, $query3);
                                                $dati3 = array();
                                                while ($row = mysqli_fetch_row($result3)) {
                                                    $data3 = array(
                                                        "Id" => $row[0],
                                                        "Idoperatore" => $row[1],
                                                        "OraInizio" => $row[2],
                                                        "OraFine" => $row[3],
                                                        "Idgiorno" => $row[4],
                                                        "TolleranzaStraordinario" => $row[5],
                                                        "Ritardo" => $row[6],
                                                    );
                                                    array_push($dati3, $data3);
                                                }
                                            ?>

                                                <div class="td col-6">
                                                    <label>Tolleranza straordinario in minuti</label>
                                                    <?
                                                    $counter = 0;
                                                    foreach ($dati3 as $dato) {
                                                        if ($counter == 0) { ?>
                                                            <input disabled type="number" min="1" max="60" class="form-control" id="tolleranza2" name="tolleranzastraordinario" value="<?= $dato['TolleranzaStraordinario'] ?>" data-parsley-required>
                                                            <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $dato['Idoperatore'] ?>')"><i class="fa fa-edit"></i></button>
                                                            <p hidden><?= $dato['TolleranzaStraordinario'] ?></p>
                                                    <? $counter = $counter + 1;
                                                        }
                                                    } ?>
                                                </div>

                                            </div>
                                            <div class="row mt-4 d-flex justify-content-start">
                                                <div class="td col-6">
                                                    <label>Tolleranza ritardo in minuti</label>
                                                    <?
                                                    $counter = 0;
                                                    foreach ($dati3 as $dato) {
                                                        if ($counter == 0) { ?>
                                                            <input disabled type="number" min="15" max="120" class="form-control" id="ritardo2" name="ritardo" value="<?= $dato['Ritardo'] ?>" data-parsley-required>
                                                            <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $dato['Idoperatore'] ?>')"><i class="fa fa-edit"></i></button>
                                                            <p hidden><?= $dato['Ritardo'] ?></p>
                                                    <? $counter = $counter + 1;
                                                        }
                                                    } ?>
                                                </div>

                                            </div>
                                            <div class="row d-flex justify-content-start">

                                                <div class="col-6 mt-5">
                                                    <input value="NULL" id="idsm" name="idsm" hidden>
                                                    <button class="btn btn-primary mt-1" onclick="check(this, '<?= $dato['Idoperatore'] ?>')">Reset ID Smartphone</button>
                                                </div>

                                                <!-- <div class="col-6">
                                                    <input value="NULL" id="idpc" name="idpc" hidden>
                                                    <button class="btn btn-primary mt-1" onclick="check(this, '<?= $dato['Idoperatore'] ?>')">Reset ID Pc</button>
                                                </div> -->

                                            </div>
                                            <!-- END Form Group -->
                                            <div class="mt-5">
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Orari</th>
                                                            <th scope="col" colspan="2">Mattina</th>
                                                            <th scope="col" colspan="2">Pomeriggio</th>
                                                        </tr>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Inizio</th>
                                                            <th scope="col">Fine</th>
                                                            <th scope="col">Inizio</th>
                                                            <th scope="col">Fine</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?
                                                        $counter = 2;
                                                        ?>

                                                        <?
                                                        foreach ($dati3 as $dato) {

                                                            if ($counter == 2) {
                                                                $counter = 0;
                                                        ?>
                                                                <tr>
                                                                    <th scope="row">
                                                                        <? switch ($dato['Idgiorno']) {
                                                                            case "1":
                                                                                echo "Lun";
                                                                                break;
                                                                            case "2":
                                                                                echo "Mar";
                                                                                break;
                                                                            case "3":
                                                                                echo "Mer";
                                                                                break;
                                                                            case "4":
                                                                                echo "Gio";
                                                                                break;
                                                                            case "5":
                                                                                echo "Ven";
                                                                                break;
                                                                            case "6":
                                                                                echo "Sab";
                                                                                break;
                                                                            case "7":
                                                                                echo "Dom";
                                                                                break;
                                                                        } ?></th>
                                                                <? }
                                                            // if($dato['Idgiorno'] < "8"){
                                                                ?>

                                                                <td class="td">
                                                                    <input disabled type="time" class="form-control" id="<? $dato['Id'] ?>" name="orarioinizio" value="<?= $dato['OraInizio'] ?>">
                                                                    <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $dato['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                                    <p hidden><?= $dato['OraInizio'] ?></p>
                                                                </td>
                                                                <td class="td">
                                                                    <input disabled type="time" class="form-control" id="<? $dato['Id'] ?>" name="orariofine" value="<?= $dato['OraFine'] ?>">
                                                                    <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $dato['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                                    <p hidden><?= $dato['OraFine'] ?></p>
                                                                </td>


                                                            <?
                                                            // }
                                                            if ($counter == 2) {
                                                                print "</tr>";
                                                            }
                                                            $counter = $counter + 1;
                                                        }
                                                            ?>
                                                            <!-- <tr>
                                                                    <th scope="row">Sab</th>
                                                                    <td class="td">
                                                                        <input disabled type="time" class="form-control" id="<? $dato['Id'] ?>" name="orarioinizio" value="<? if ($dato['Idgiorno'] == '6') {
                                                                                                                                                                                echo $dato['OraInizio'];
                                                                                                                                                                            } ?>">
                                                                        <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $dato['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                                        <p hidden><?= $dato['OraInizio'] ?></p>
                                                                    </td>

                                                                    <td class="td">
                                                                        <input disabled type="time" class="form-control" id="<? $dato['Id'] ?>" name="orariofine" value="<? if ($dato['Idgiorno'] == '6') {
                                                                                                                                                                                echo $dato['OraFine'];
                                                                                                                                                                            } ?>">
                                                                        <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $dato['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                                        <p hidden><?= $dato['OraFine'] ?></p>
                                                                    </td>
                                                                    <td class="td">
                                                                        <input disabled type="time" class="form-control" id="<? $dato['Id'] ?>" name="orarioinizio" value="<? if ($dato['Idgiorno'] == '6') {
                                                                                                                                                                                echo $dato['OraInizio'];
                                                                                                                                                                            } ?>">
                                                                        <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $dato['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                                        <p hidden><?= $dato['OraInizio'] ?></p>
                                                                    </td>

                                                                    <td class="td">
                                                                        <input disabled type="time" class="form-control" id="<? $dato['Id'] ?>" name="orariofine" value="<? if ($dato['Idgiorno'] == '6') {
                                                                                                                                                                                echo $dato['OraFine'];
                                                                                                                                                                            } ?>">
                                                                        <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $dato['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                                        <p hidden><?= $dato['OraFine'] ?></p>
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Dom</th>
                                                                    <td class="td">
                                                                        <input disabled type="time" class="form-control" id="<? $dato['Id'] ?>" name="orarioinizio" value="<? if ($dato['Idgiorno'] == '7') {
                                                                                                                                                                                echo $dato['OraInizio'];
                                                                                                                                                                            } ?>">
                                                                        <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $dato['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                                        <p hidden><?= $dato['OraInizio'] ?></p>
                                                                    </td>

                                                                    <td class="td">
                                                                        <input disabled type="time" class="form-control" id="<? $dato['Id'] ?>" name="orariofine" value="<? if ($dato['Idgiorno'] == '7') {
                                                                                                                                                                                echo $dato['OraFine'];
                                                                                                                                                                            } ?>">
                                                                        <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $dato['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                                        <p hidden><?= $dato['OraFine'] ?></p>
                                                                    </td>
                                                                    <td class="td">
                                                                        <input disabled type="time" class="form-control" id="<? $dato['Id'] ?>" name="orarioinizio" value="<? if ($dato['Idgiorno'] == '7') {
                                                                                                                                                                                echo $dato['OraInizio'];
                                                                                                                                                                            } ?>">
                                                                        <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $dato['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                                        <p hidden><?= $dato['OraInizio'] ?></p>
                                                                    </td>

                                                                    <td class="td">
                                                                        <input disabled type="time" class="form-control" id="<? $dato['Id'] ?>" name="orariofine" value="<? if ($dato['Idgiorno'] == '7') {
                                                                                                                                                                                echo $dato['OraFine'];
                                                                                                                                                                            } ?>">
                                                                        <button class="btn btn-info mt-1" onclick="handleModificaOperatore(this, '<?= $dato['Id'] ?>')"><i class="fa fa-edit"></i></button>
                                                                        <p hidden><?= $dato['OraFine'] ?></p>
                                                                    </td>

                                                                </tr> -->

                                                    </tbody>
                                                </table>
                                            </div>
                                        <? } ?>
                                    </div>


                                    <div class="modal-footer">

                                        <a class="btn btn-outline-danger" href="./operatori.php">Annulla</a>
                                    </div>
                                    <!-- </form> -->

                                    <!-- END Datatable -->
                                </div>
                            </div>
                            <!-- END Portlet -->
                        </div>
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
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.1/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.dataTables.min.css" rel="stylesheet">


    <script src="modificaoperatore.js"></script>
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