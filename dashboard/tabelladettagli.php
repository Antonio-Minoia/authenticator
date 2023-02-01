<?
require_once('../api/helpers/db.php');
require_once('../api/helpers/logincheck.php');

$_SESSION['current_page'] = 'Storico Misurazioni';
$id_cliente = $_GET['id'];
$tipo_misurazione = $_GET['tipo_misurazione'];
// $ragione_cliente = $_GET['ragione'];
// $id_cliente = '1';
// $tipo_misurazione = 'Misurazione';
// $ragione_cliente = 'Ragione Cliente';

$query3 = "SELECT ragione_sociale FROM Clienti WHERE id_cliente = '$id_cliente' AND attivo = '1'";
$result3 = mysqli_query($connection, $query3);
while ($row = mysqli_fetch_row($result3)) {
    $ragione_cliente = $row[0];
}

$query = "SELECT id_mis, data, n_protocollo, id_cliente, id_operatore, travasato, note, tipo FROM x_mis WHERE id_cliente = $id_cliente AND tipo = '$tipo_misurazione' AND visibile = 1 ORDER BY data DESC";
$result = mysqli_query($connection, $query);
$dettagli = array();
while ($row = mysqli_fetch_row($result)) {
    $data = array(
        "IdMisurazione" => $row[0],
        "Data" => $row[1],
        "NProtocollo" => $row[2],
        "IdOperatore" => $row[4],
        "Note" => $row[6],
        "TipoMisurazione" => $row[7]
    );
    array_push($dettagli, $data);
}
mysqli_free_result($result);
$res = (object) $dettagli;

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
    <link rel="icon" type="image/x-icon" href="../assets/images/logo-canonico-white-300x300.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title><?= $_SESSION['current_page'] ?></title>
</head>

<body class="theme-<?= $_SESSION['user']['tema'] ?> preload-active aside-active aside-mobile-minimized aside-desktop-maximized" id="fullscreen">

    <div class="preload">
        <div class="preload-dialog">
            <div class="spinner-border text-primary preload-spinner"></div>
        </div>
    </div>
    <!-- END Preload -->
    <!-- BEGIN Page Holder -->
    <div class="holder">
        <?// if ($_SESSION['user']['tipo'] == 3) : ?>
            <div class="aside">
                <div class="aside-header">
                    <h2 class="aside-title">CANONICO<small class="text text-small"> gestione</small></h2>
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
        <? //endif ?>
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
                                    <span class="portlet-title fs-3">Cliente: <h2><?= $ragione_cliente ?></h2></span>
                                    <p class="portlet-title fs-3">
                                    <h2><?= $tipo_misurazione ?></h2>
                                    </p>
                                </div>
                                <div class="portlet-body">
                                    <!-- BEGIN Datatable -->
                                    <div id="table2" style="overflow-x:auto;">

                                        <? if (count($dettagli) != 0) : ?>
                                            <table id="datatable-2" class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr class="tr">
                                                        <th>Tipo</th>
                                                        <th>Data</th>
                                                        <th>N° Protocollo</th>
                                                        <th>Note</th>
                                                        <th>Operatore</th>
                                                        <th>Modifiche</th>
                                                        <th>Altro</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tBody">
                                                    <? foreach ($dettagli as $dettaglio) :
                                                        $id_op = $dettaglio['IdOperatore'];
                                                        $q_operatore = "SELECT concat(nome, ' ', cognome) as name FROM Operatori WHERE id_operatore = $id_op";
                                                        $r_operatore = mysqli_query($connection, $q_operatore);
                                                        while ($row = mysqli_fetch_row($r_operatore)) {
                                                            $nome_op = $row[0];
                                                        }
                                                        // $nome_op = mysqli_fetch_field($r_operatore);
                                                    ?>
                                                        <tr id="<?= $dettaglio['IdMisurazione'] ?>">
                                                            <th scope="row">
                                                                <p><?= $dettaglio['TipoMisurazione'] ?></p>
                                                            </th>
                                                            <th scope="row">
                                                                <p><?= $dettaglio['Data'] ?></p>
                                                            </th>
                                                            <td class="td">
                                                                <p><?= $dettaglio['NProtocollo'] ?></p>
                                                            </td>
                                                            <td class="td">
                                                                <textarea rows="2" cols="90" disabled><?= $dettaglio['Note'] ?></textarea>
                                                            </td>
                                                            <td class="td">
                                                                <p><?= $nome_op ?></p>
                                                            </td>
                                                            <td class="d-flex flex-row justify-content-center">
                                                                <? if ($dettaglio['TipoMisurazione'] == "Misurazione") { ?>
                                                                    <form method="get" action="./misurazioni.php">
                                                                        <input type="hidden" name="id" value="<?= $dettaglio['IdMisurazione'] ?>">
                                                                        <button class="btn m-1" style="background-color: #D5DEED;" type="submit">Modifica</button>
                                                                    </form>
                                                                    <form method="get" action="./mostraimmagini.php">
                                                                        <input type="hidden" name="id" value="<?= $dettaglio['IdMisurazione'] ?>">
                                                                        <button class="btn m-1" style="background-color: #C3E0E5;" type="submit">Tutte le foto</button>
                                                                    </form>
                                                                <? } else if ($dettaglio['TipoMisurazione'] == "Impianto") { ?>
                                                                    <form method="get" action="./impianti.php">
                                                                        <input type="hidden" name="id" value="<?= $dettaglio['IdMisurazione'] ?>">
                                                                        <button class="btn m-1" style="background-color: #D5DEED;" type="submit">Modifica</button>
                                                                    </form>
                                                                    <form method="get" action="./mostraimmagini.php">
                                                                        <input type="hidden" name="id" value="<?= $dettaglio['IdMisurazione'] ?>">
                                                                        <button class="btn m-1" style="background-color: #C3E0E5;" type="submit">Tutte le foto</button>
                                                                    </form>
                                                                <? } else { ?>
                                                                    <form method="get" action="./rapportino.php">
                                                                        <input type="hidden" name="id" value="<?= $dettaglio['IdMisurazione'] ?>">
                                                                        <button class="btn m-1" style="background-color: #D5DEED;" type="submit">Modifica</button>
                                                                    </form>
                                                                    <form method="get" action="./mostraimmagini.php">
                                                                        <input type="hidden" name="id" value="<?= $dettaglio['IdMisurazione'] ?>">
                                                                        <button class="btn m-1" style="background-color: #C3E0E5;" type="submit">Tutte le foto</button>
                                                                    </form>
                                                                <? } ?>
                                                            </td>
                                                            <td class="justify-content-center">
                                                                <? if ($dettaglio['TipoMisurazione'] == "Misurazione") { ?>
                                                                    <button class="btn btn-dark m-1" onclick="eliminaMisurazione('<?= $dettaglio['IdMisurazione'] ?>')">Elimina</button>
                                                                <? } else if ($dettaglio['TipoMisurazione'] == "Impianto") { ?>
                                                                    <button class="btn btn-dark m-1" onclick="eliminaMisurazione('<?= $dettaglio['IdMisurazione'] ?>')">Elimina</button>
                                                                <? } else { ?>
                                                                    <button class="btn btn-dark m-1" onclick="eliminaMisurazione('<?= $dettaglio['IdMisurazione'] ?>')">Elimina</button>
                                                                <?
                                                                } ?>
                                                            </td>
                                                        </tr>
                                                    <? endforeach ?>
                                                </tbody>
                                            </table>
                                        <? else : ?>
                                            <h3 class="text text-center text-danger">Non sono state effettuate misurazioni per qesto cliente</h3>
                                        <? endif;
                                        db_disconnect(); ?>
                                    </div>
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
            <!-- <div class="float-btn float-btn-right">
                <button class="btn btn-flat-primary btn-icon mb-2" id="theme-toggle" data-toggle="tooltip" data-placement="right" title="Change theme" onclick="cambiatema()">
                    <i class="fa fa-moon"></i>
                </button>
            </div> -->
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


    <script src="./tabelladettagli.js"></script>
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