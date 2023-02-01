<? require_once('../api/helpers/logincheck.php');
require_once('../api/helpers/db.php');
require_once('../api/helpers/type.php');

$_SESSION['current_page'] = 'Statistiche';
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
                                    <!-- <h3 class="portlet-title">Statistiche</h3>
                                    <br> -->
                                    <h4 class="portlet-title">Report mensile per invio al consulente</h4>
                                </div>
                                <div class="portlet-body">

                                    <div class="m-3 col-6 mb-5 ">
                                        <div class="row">
                                            <div class="col-12">

                                                <form action="./statistiche.php" method="get" id="month-form">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label for="month">Selziona il mese desiderato</label>
                                                            <input id="month" class="form-control" type="month" name="month" required />
                                                        </div>
                                                        <div class="col-6 d-flex align-items-end">
                                                            <input type="submit" class="btn btn-primary" value="Seleziona">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- BEGIN Datatable -->
                                    <hr>
                                    <div id="tableOrari" style="overflow-x:auto;" >
                                        <?
                                        if (isset($_GET["month"])) {
                                        ?>
                                            <?
                                            $date = $_GET["month"];
                                            $firstDay = date("Y-m-01", strtotime($date));
                                            $lastDay = date("Y-m-t", strtotime($date));
                                            // echo "date ". $date . "<br>";
                                            // echo "firstday ". $firstDay . "<br>";
                                            // echo "lastday ". $lastDay . "<br>";
                                            $risultato = "";
                                            $date1 = $firstDay;
                                            while (strtotime($date1) <= strtotime($lastDay)) {

                                                $date2 = date("d/m", strtotime($date1));
                                                $date3 = date("d/m/Y", strtotime($date1));
                                                // $risultato = $risultato . ", left(sec_to_time(sum((case when DATE_FORMAT(ora, '%d/%m/%Y') = '" . $date3 . "' then timestampdiff(second, ora, stopx) else 0 END))), 5) as '" . $date2 . "'";
                                                $risultato = $risultato . ", sec_to_time(sum((case when DATE_FORMAT(ora, '%d/%m/%Y') = '" . $date3 . "' then timestampdiff(second, ora, stopx) else 0 END))) as '" . $date2 . "'";
                                                $date1 = date("d-m-Y", strtotime("+1 day", strtotime($date1))); //Adds 1 day onto current date
                                            }
                                            $risultato = str_replace('-', '/', $risultato);
                                            $query = "WITH pippo as (SELECT *, (Select ora from stlgroup.Oraribadge ta where ta.id > ts.id and idoperatore = ts.idoperatore and tipo = 'stop' limit 1) as Stopx 
                                                FROM stlgroup.Oraribadge ts where tipo = 'start' ) select idoperatore as Id, ut.nome as Nome, ut.cognome as Cognome, se.citta as Sede, ora , stopx" . $risultato . "
                                                from pippo LEFT JOIN stlgroup.Utenti ut ON idoperatore = ut.id LEFT JOIN stlgroup.Sedi se ON ut.idsede = se.id where stopx is not null 
                                                group by idoperatore, ut.nome, ut.cognome, se.citta;";
                                            echo $query;

                                            $result = mysqli_query($connection, $query);
                                            $dati = array();

                                            while ($row = mysqli_fetch_row($result)) {
                                                $i = 0;
                                                while ($i < mysqli_num_fields($result)) {
                                                    $dato = array(
                                                        $i => $row[$i]
                                                    );
                                                    $i = $i + 1;
                                                    array_push($dati, $dato);
                                                }
                                            } ?>

                                            <? if ($_SESSION['user']['admin'] >= 1) { ?>
                                                <? if (count($dati) != 0) : ?>
                                                    <? $fieldinfo = mysqli_fetch_fields($result);
                                                    ?>

                                                    <table id="datatable-orari" class="table table-bordered table-striped table-hover mt-3" >
                                                        <thead>
                                                            <tr>
                                                                <?
                                                                $i = 0;
                                                                foreach ($fieldinfo as $val) {

                                                                    echo '<th>' . $val->name . '</th>';
                                                                } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tBody">
                                                            <?
                                                            $i = 0;
                                                            foreach ($dati as $dato) {

                                                                if ($i == 0 || $i == mysqli_num_fields($result)) {
                                                                    print '<tr>';
                                                                }
                                                                print '<td class="td">' . implode(" ", $dato) . " " . '</td>';

                                                                $i = $i + 1;
                                                                if ($i == 0 || $i == mysqli_num_fields($result)) {
                                                                    print '<tr/>';
                                                                    $i = 0;
                                                                }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                <? else : ?>
                                                    <h3 class="text text-center text-danger">Non ci sono dati</h3>
                                                <? endif ?>
                                            <? } ?>
                                    </div>
                                <? } else { ?>
                                    <h3 class="text text-center text-danger">Seleziona una data</h3>
                                <? } ?>
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