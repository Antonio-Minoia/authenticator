<? require_once('../api/helpers/logincheck.php');
require_once('../api/helpers/db.php');
require_once('../api/helpers/type.php');

$_SESSION['current_page'] = 'Ore di lavoro';
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
                                    <h3 class="portlet-title"><?= $_SESSION['current_page'] ?></h3>
                                </div>
                                <div class="portlet-body">
                                    <!-- BEGIN Datatable -->

                                    <div id="tableOrari" style="overflow-x:false;">
                                        <?
                                        $query = "with pippo as (SELECT *, 
                                                (Select ora from stlgroup.Oraribadge ta where ta.id > ts.id and idoperatore = ts.idoperatore 
                                                and tipo = 'stop' limit 1) as Stopx
                                                FROM stlgroup.Oraribadge ts where tipo = 'start' )
                                                
                                                select idoperatore, ut.nome, ut.cognome, se.citta, DATE_FORMAT(ora, '%d/%m/%Y') as Data,  sec_to_time(sum(timestampdiff(second, ora, stopx))) as diff
                                                from pippo 
                                                LEFT JOIN stlgroup.Utenti ut
                                                ON idoperatore = ut.id
                                                LEFT JOIN stlgroup.Sedi se
                                                ON ut.idsede = se.id
                                                where stopx is not null AND DATE_FORMAT(ora, '%Y-%m-%d') = curdate() group by idoperatore, DATE_FORMAT(ora, '%d/%m/%Y')";
                                        $result = mysqli_query($connection, $query);
                                        $dati = array();

                                        while ($row = mysqli_fetch_row($result)) {
                                            $dato = array(
                                                "IdOperatore" => $row[0],
                                                "Nome" => $row[1],
                                                "Cognome" => $row[2],
                                                "Citta" => $row[3],
                                                "Data" => $row[4],
                                                "Differenza" => $row[5],
                                            );
                                            array_push($dati, $dato);
                                        }

                                        mysqli_free_result($result);

                                        db_disconnect(); ?>
                                        <? if ($_SESSION['user']['admin'] >= 1) { ?>
                                            <? if (count($dati) != 0) : ?>
                                                <table id="datatable-orari" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nome</th>
                                                            <th>Cognome</th>
                                                            <th>Sede</th>
                                                            <th>Data</th>
                                                            <th>Ore di lavoro</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tBody">
                                                        <? foreach ($dati as $dato) : ?>

                                                            <!-- <tr id="<? //$dato['Id'] 
                                                                            ?>" <? // if (!$dato['Attiva']) : 
                                                                                                ?> style="opacity: .6; <? //endif 
                                                                                                                                                    ?>"> -->
                                                            <tr id="<?= $dato['IdOperatore'] ?>">

                                                                <td class="td">
                                                                    <p><?= $dato['Nome'] ?></p>
                                                                </td>
                                                                <td class="td">
                                                                    <p><?= $dato['Cognome'] ?></p>
                                                                </td>
                                                                <td class="td">
                                                                    <p><?= $dato['Citta'] ?></p>
                                                                </td>
                                                                <td class="td">
                                                                    <p><?= $dato['Data'] ?></p>
                                                                </td>
                                                                <td class="td">
                                                                    <p><?= $dato['Differenza'] ?></p>
                                                                </td>

                                                            </tr>
                                                        <? endforeach ?>
                                                    </tbody>
                                                </table>
                                            <? else : ?>
                                                <h3 class="text text-center text-danger">Non ci sono dati</h3>

                                            <? endif ?>
                                        <? } ?>
                                    </div>
                                    <!-- END Datatable -->
                                </div>
                            </div>
                            <!-- END Portlet -->
                        </div>
                        <button class="btn btn-outline-success m-3" onclick="exportTableToExcel('datatable-orari', `Orari utenti ${getDateTime()}`)">Esporta File Excel</button>
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
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.1/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.dataTables.min.css" rel="stylesheet">


    <script src="statistiche.js"></script>
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