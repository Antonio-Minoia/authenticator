<?php 
require_once('../api/helpers/logincheck.php');
require_once('../api/helpers/db.php');
require_once('../api/helpers/type.php');

$_SESSION['current_page'] = "Orari ingressi/uscite";
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
                                <div class="m-3 col-6 mb-5 ">
                                    <div class="row">
                                        <div class="col-12">

                                            <form action="./arrivi.php" method="get" id="day-form">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="day">Selziona il giorno desiderato</label>
                                                        <input id="day" class="form-control" type="date" name="day" required />
                                                    </div>
                                                    <div class="col-6 d-flex align-items-end">
                                                        <input type="submit" class="btn btn-primary" value="Seleziona">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <!-- BEGIN Datatable -->

                                    <div id="tableOrari" style="overflow-x:false;">
                                            <?
                                            if(isset($_GET["day"])) {
                                                $day = $_GET["day"];
                                                // echo $day;
                                                ?>
                                            <?
                                            $query = "WITH pippo as (SELECT *, (Select ora from stlgroup.Oraribadge ta where ta.id > ts.id and idoperatore = ts.idoperatore and tipo = 'stop' limit 1) as Stopx,
                                            (Select abbuono from stlgroup.Oraribadge ta where ta.id > ts.id and idoperatore = ts.idoperatore and tipo = 'stop' limit 1) as AbbStopx,
                                            (Select id from stlgroup.Oraribadge ta where ta.id > ts.id and idoperatore = ts.idoperatore and tipo = 'stop' limit 1) as IdStopx
                                            FROM stlgroup.Oraribadge ts where tipo = 'start' )
                                            select pippo.id as idStart, pippo.idoperatore as idOperatore, ut.nome as Nome, ut.cognome as Cognome, se.citta as Sede, ora as orain, stopx, orut.idgiorno, 
                                            orut.orarioinizio, orut.orariofine, timediff(DATE_FORMAT(ora, '%T'), orut.orarioinizio) as ritardoingr, timediff(orut.orariofine, DATE_FORMAT(Stopx, '%T')) as anticipousc,
                                            abbuono as abbstart, AbbStopx as abbstop, IdStopx as idStop
                                            from pippo LEFT JOIN stlgroup.Utenti ut ON idoperatore = ut.id 
                                            LEFT JOIN stlgroup.Sedi se ON ut.idsede = se.id 
                                            inner join Orariutenti orut on pippo.idoperatore = orut.idoperatore and pippo.idgiorno = orut.idgiorno
                                            where stopx is not null 
                                            and DATE_FORMAT(ora, '%Y-%m-%d') = '" . $day . "'
                                            and ((DATE_FORMAT(ora, '%T') < orut.orarioinizio and DATE_FORMAT(stopx, '%T') >= orut.orarioinizio and DATE_FORMAT(stopx, '%T') <= orut.orariofine ) or 
                                            (DATE_FORMAT(ora, '%T') >= orut.orarioinizio and DATE_FORMAT(stopx, '%T') <= orut.orariofine ) or 
                                            (DATE_FORMAT(ora, '%T') <= orut.orarioinizio and DATE_FORMAT(stopx, '%T') > orut.orariofine ) or 
                                            (DATE_FORMAT(ora, '%T') >= orut.orarioinizio and DATE_FORMAT(ora, '%T') <= orut.orariofine and DATE_FORMAT(stopx, '%T') >= orut.orariofine ))";
                                        // echo $query;    
                                        $result = mysqli_query($connection, $query);
                                            $dati = array();

                                            while ($row = mysqli_fetch_row($result)) {
                                                $dato = array(
                                                    "IdStart" => $row[0],
                                                    "IdOperatore" => $row[1],
                                                    "Nome" => $row[2],
                                                    "Cognome" => $row[3],
                                                    "Sede" => $row[4],
                                                    "Ingresso" => $row[5],
                                                    "Uscita" => $row[6],
                                                    "IdGiorno" => $row[7],
                                                    "OrarioInizio" => $row[8],
                                                    "OrarioFine" => $row[9],
                                                    "RitardoIngresso" => $row[10],
                                                    "AnticipoUscita" => $row[11],
                                                    "AbbuonoStart" => $row[12],
                                                    "AbbuonoEnd" => $row[13],
                                                    "IdStop" => $row[14],
                                                );
                                                array_push($dati, $dato);
                                            }

                                            mysqli_free_result($result);

                                            db_disconnect(); ?>
                                            <?php if ($_SESSION['user']['admin'] >= 1) { ?>
                                                <?php if (count($dati) != 0) : ?>
                                                    <table id="datatable-orari" class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Nome</th>
                                                                <th>Cognome</th>
                                                                <th>Sede</th>
                                                                <th>Badge Inizio</th>
                                                                <th>Orario Inizio</th>
                                                                <th>Badge Fine</th>
                                                                <th>Orario Fine</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tBody">
                                                            <?php foreach ($dati as $dato) : ?>

                                                                <!-- <tr id="<? //$dato['IdOperatore'] 
                                                                                ?>" <? // if (!$dato['Attiva']) : 
                                                                                ?> style="opacity: .6; <? //endif 
                                                                                                        ?>"> -->
                                                                <tr id="<?= $dato['IdStart'] ?>">

                                                                    <td class="td">
                                                                        <p><?= $dato['Nome'] ?></p>
                                                                    </td>
                                                                    <td class="td">
                                                                        <p><?= $dato['Cognome'] ?></p>
                                                                    </td>
                                                                    <td class="td">
                                                                        <p><?= $dato['Sede'] ?></p>
                                                                    </td>
                                                                    <td class="td" style="<?php if ($dato['OrarioInizio'] < substr($dato['Ingresso'], 11, 20)) {
                                                                                                echo 'background: rgba(255, 0, 0, 0.2)';
                                                                                            } else {
                                                                                                echo 'background: rgba(0, 255, 0, 0.2)';
                                                                                            }; ?>">
                                                                        <?php
                                                                        $badge = date_create($dato['Ingresso']);
                                                                        $orario = date_create($dato['OrarioInizio']);
                                                                        // $newbadge = date('Y-m-d',$badge);
                                                                        // $neworario = date('Y-m-d',$orario);

                                                                        $difference = date_diff($badge, $orario);
                                                                        $ore = $difference->h;

                                                                        $minutes = $difference->days * 24 * 60;
                                                                        $minutes += $difference->h * 60;
                                                                        $minutes += $difference->i;
                                                                        $minuti = $minutes;

                                                                        ?>

                                                                        <p><?= substr(substr($dato['Ingresso'],11,20), 0, -3) ?> - <?if ($dato['AbbuonoStart']) { print 'Abbuonato';} else { print 'Scalcolato';} ?></p>
                                                                        <?
                                                                        $badgeStart = substr(substr($dato['Ingresso'],11,20), 0, -3);
                                                                        // echo date('H:i', strtotime($badgeStart)+10800) . ' '. date('H:i', strtotime(substr($dato['OrarioInizio'], 0, -3))). ' '. date('H:i', strtotime($badgeStart)-10800);
                                                                        ?>
                                                                        <?if(date('H:i', strtotime(substr($dato['OrarioInizio'], 0, -3))) <= date('H:i', strtotime($badgeStart)+10800) && date('H:i', strtotime(substr($dato['OrarioInizio'], 0, -3))) >=date('H:i', strtotime($badgeStart)-10800) ) {?>
                                                                        <button class="btn btn-info mt-1" onclick="setAbbuono(<? if($dato['AbbuonoStart']) { print  0;} else { print 1; }?>, '<?= $dato['IdStart'] ?>', '<?=$dato['IdOperatore']?>', '<?=$dato['IdGiorno']?>', '<?=substr($dato['Ingresso'],11,20)?>', 'start')"><? if($dato['AbbuonoStart']) { print "Scalcola"; } else { print "Abbuona"; }?></button>
                                                                        <?}?>
                                                                        <!-- <p hidden><?= $dato['OraFine'] ?></p> -->
                                                                    </td>
                                                                    <td class="td">
                                                                        <p><?= substr($dato['OrarioInizio'], 0, -3) ?></p>
                                                                    </td>
                                                                    <td class="td" style="<?php if ($dato['OrarioFine'] > substr($dato['Uscita'], 11, 20)) {
                                                                                                echo 'background: rgba(255, 0, 0, 0.2)';
                                                                                            } else {
                                                                                                echo 'background: rgba(0, 255, 0, 0.2)';
                                                                                            }; ?>">
                                                                        <p><?= substr(substr($dato['Uscita'], 11,20), 0, -3) ?> - <?if ($dato['AbbuonoEnd']) { print 'Abbuonato';} else { print 'Scalcolato';} ?></p>

                                                                        <?
                                                                        $badgeEnd = substr(substr($dato['Uscita'],11,20), 0, -3);
                                                                        // echo date('H:i', strtotime($badgeEnd)+10800) . ' '. date('H:i', strtotime(substr($dato['OrarioFine'], 0, -3))). ' '. date('H:i', strtotime($badgeEnd)-10800);
                                                                        ?>
                                                                        
                                                                        <?if(date('H:i', strtotime(substr($dato['OrarioFine'], 0, -3))) <= date('H:i', strtotime($badgeEnd)+10800) && date('H:i', strtotime(substr($dato['OrarioFine'], 0, -3))) >=date('H:i', strtotime($badgeEnd)-10800) ) {?>
                                                                        <button class="btn btn-info mt-1" onclick="setAbbuono(<? if($dato['AbbuonoEnd']) { print  0;} else { print 1; }?>, '<?= $dato['IdStop'] ?>', '<?=$dato['IdOperatore']?>', '<?=$dato['IdGiorno']?>', '<?=substr($dato['Uscita'],11,20)?>', 'stop')"><? if($dato['AbbuonoEnd']) { print "Scalcola"; } else { print "Abbuona"; }?></button>
                                                                        <?}?>
                                                                        <!-- <p hidden><?= $dato['OraFine'] ?></p> -->
                                                                    </td>
                                                                    <td class="td">
                                                                        <p><?= substr($dato['OrarioFine'], 0, -3) ?></p>
                                                                    </td>

                                                                </tr>
                                                            <?php endforeach ?>
                                                        </tbody>
                                                    </table>
                                                <?php else : ?>
                                                    <h3 class="text text-center text-danger">Non ci sono dati</h3>

                                                <?php endif ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <h3 class="text text-center text-danger">Seleziona una data</h3>
                                        <?php } ?>
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
            <?php require_once("../partials/footer.php"); ?>
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