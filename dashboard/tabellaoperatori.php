<?
require_once('../api/helpers/logincheck.php');
require_once('../api/helpers/db.php');
require_once('../api/helpers/type.php');


$query = "SELECT ut.*, se.citta FROM stlgroup.Utenti ut
LEFT JOIN stlgroup.Sedi se ON
se.id = ut.idsede ";
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
            "Citta" => $row[16],
        );
        array_push($operatori, $data);
    }
}
mysqli_free_result($result);

db_disconnect(); ?>
<? if ($_SESSION['user']['admin'] >= 1) { ?>
    <? if (count($operatori) != 0) :
        require_once('./modals/modificaoperatore.php');
    ?>
        <table id="datatable-2" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Cognome</th>
                    <th>Nome</th>
                    <th>Username</th>
                    <th>Sede</th>
                    <th>Accessibilità</th>
                    <!-- <th>Qr visibile</th> -->
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody id="tBody">
                <? foreach ($operatori as $operatore) : ?>

                    <tr id="<?= $operatore['Id'] ?>" <? if (!$operatore['Attivo']) : ?> style="opacity: .6; <? endif ?>">

                        <th scope="row" class="td">
                            <!-- <input type="text" class="form-control" disabled value="<?= $operatore['Cognome'] ?>" idope="<?= $operatore['Id'] ?>" name="Cognome"> -->
                            <p><?= $operatore['Cognome'] ?></p>

                        <td class="td">
                            <!-- <input type="text" class="form-control" disabled value="<?= $operatore['Nome'] ?>" idope="<?= $operatore['Id'] ?>" name="Nome"> -->
                            <p><?= $operatore['Nome'] ?></p>
                        </td>
                        <td class="td">
                            <!-- <input type="text" class="form-control" disabled value="<?= $operatore['Username'] ?>" idope="<?= $operatore['Id'] ?>" name="Username"> -->
                            <p><?= $operatore['Username'] ?></p>
                        </td>
                        <td class="td">
                            <!-- <input type="text" class="form-control" disabled value="<?= $operatore['Citta'] ?>" idope="<?= $operatore['Id'] ?>" name="Sede"> -->
                            <p><?= $operatore['Citta'] ?></p>
                        </td>
                        <td class="td">
                            <!-- <input type="text" class="form-control" disabled value=" -->
                            <p>
                            <? if ($operatore['Admin'] == '0') {     
                                print "Utente";
                            } else if ($operatore['Admin'] == '1') {
                                print "Amministratore";
                            } ?></p>
                            <!-- " minlength="5" name="Admin"> -->
                        </td>
                        <!-- <td class="td">
                            <p>
                                    <? if ($operatore['Qr visibile'] == true) {
                                        print "Si";
                                    } else if ($operatore['Qr visibile'] == false) {
                                        print "No";
                                    } ?></option>
                                </p>
                            
                            <p><?= $operatore['Qr visibile'] ?></p>
                        </td> -->

                        <? if ($operatore['Attivo']) : ?>
                            <td class="d-flex">
                                <button class="btn btn-dark mr-3" onclick="eliminaOperatore('<?= $operatore['Cognome'] ?> <?= $operatore['Nome'] ?>', '<?= $operatore['Id'] ?>')">Disattiva</button>
                                <form action="./modificaoperatore.php" type="GET">
                                    <input type="hidden" value="<?= $operatore['Id']?>" name="Id">
                                    <button class="btn btn-warning ">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path d="M421.7 220.3l-11.3 11.3-22.6 22.6-205 205c-6.6 6.6-14.8 11.5-23.8 14.1L30.8 511c-8.4 2.5-17.5 .2-23.7-6.1S-1.5 489.7 1 481.2L38.7 353.1c2.6-9 7.5-17.2 14.1-23.8l205-205 22.6-22.6 11.3-11.3 33.9 33.9 62.1 62.1 33.9 33.9zM96 353.9l-9.3 9.3c-.9 .9-1.6 2.1-2 3.4l-25.3 86 86-25.3c1.3-.4 2.5-1.1 3.4-2l9.3-9.3H112c-8.8 0-16-7.2-16-16V353.9zM453.3 19.3l39.4 39.4c25 25 25 65.5 0 90.5l-14.5 14.5-22.6 22.6-11.3 11.3-33.9-33.9-62.1-62.1L314.3 67.7l11.3-11.3 22.6-22.6 14.5-14.5c25-25 65.5-25 90.5 0z" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        <? else : ?>
                            <td class="td">
                                <button class="btn btn-success mb-1" onclick="attivaOperatore('<?= $operatore['Cognome'] ?> <?= $operatore['Nome'] ?>', '<?= $operatore['Id'] ?>')">Attiva</button>
                            </td>
                        <? endif ?>


                    </tr>
                <? endforeach ?>
            </tbody>
        </table>
    <? else : ?>
        <h3 class="text text-center text-danger">Non ci sono operatori</h3>

    <? endif ?>
<? } ?>