<?php
require_once("../../api/helpers/db.php");
// require_once("C:/xampp/htdocs/canonico/partials/fpdf/fpdf.php");
require_once("./fpdf/fpdf.php");

$id_mis = $_GET['id_mis'];

$sql ="SELECT campo, valore FROM x_mis_tabella WHERE id_mis = '$id_mis'";
$result = mysqli_query($connection, $sql);
$misurazioni = array();
while($row = mysqli_fetch_row($result)){
    $data = array(
        "Campo" => $row[0],
        "Valore" => $row[1]
    );
    array_push($misurazioni, $data);
}

$sql1 = "SELECT note FROM x_mis WHERE id_mis = $id_mis";
$result1 = mysqli_query($connection, $sql1);
$note = array();
while ($row = mysqli_fetch_row($result1)) {
    $dati = array(
        "Note" => $row[0]
    );
    array_push($note, $dati);
}

$cod_cliente = "";
$tipo_impianto = "";
$tipo_orologio = "";
$num_schedine = "";
$tipo_schedine = "";
$tipo_teleruttori = "";
$num_teleruttori = "";
$magnetotermico = "";
$interno_al_quadro = "";
$comando_quadranti = "";
$tipo_percussori = "";
$n_p400 = "";
$n_p900 = "";
$n_p900r = "";
$n_pl0 = "";
$n_pl1 = "";
$n_pl2 = "";
$n_pl3 = "";
$n_pl4 = "";
$n_pl5 = "";
$diam_mot1 = "";
$diam_mot2 = "";
$diam_mot3 = "";
$diam_mot4 = "";
$diam_mot5 = "";
$diam_mot6 = "";
$diam_mot7 = "";
$diam_mot8 = "";
$hp_mot1 = "";
$hp_mot2 = "";
$hp_mot3 = "";
$hp_mot4 = "";
$hp_mot5 = "";
$hp_mot6 = "";
$hp_mot7 = "";
$hp_mot8 = "";
$giri_mot1 = "";
$giri_mot2 = "";
$giri_mot3 = "";
$giri_mot4 = "";
$giri_mot5 = "";
$giri_mot6 = "";
$giri_mot7 = "";
$giri_mot8 = "";
$slancio_mot1 = "";
$slancio_mot2 = "";
$slancio_mot3 = "";
$slancio_mot4 = "";
$slancio_mot5 = "";
$slancio_mot6 = "";
$slancio_mot7 = "";
$slancio_mot8 = "";
$semi_slancio_mot1 = "";
$semi_slancio_mot2 = "";
$semi_slancio_mot3 = "";
$semi_slancio_mot4 = "";
$semi_slancio_mot5 = "";
$semi_slancio_mot6 = "";
$semi_slancio_mot7 = "";
$semi_slancio_mot8 = "";
$rapporto_mot1 = "";
$rapporto_mot2 = "";
$rapporto_mot3 = "";
$rapporto_mot4 = "";
$rapporto_mot5 = "";
$rapporto_mot6 = "";
$rapporto_mot7 = "";
$rapporto_mot8 = "";
$camme_mot1 = "";
$camme_mot2 = "";
$camme_mot3 = "";
$camme_mot4 = "";
$camme_mot5 = "";
$camme_mot6 = "";
$camme_mot7 = "";
$camme_mot8 = "";
$tipo_camme_mot1 = "";
$tipo_camme_mot2 = "";
$tipo_camme_mot3 = "";
$tipo_camme_mot4 = "";
$tipo_camme_mot5 = "";
$tipo_camme_mot6 = "";
$tipo_camme_mot7 = "";
$tipo_camme_mot8 = "";
$n_quadranti = "";
$diam_quadranti = "";
$retroilluminazione = "";
$n_mov_meccanici = "";
$n_rid_mov_meccanici = "";
$tipo_motoriduttore = "";
$n_mov_riduttori = "";
$n_4_quadranti = "";
$note_impianti = "";

foreach($misurazioni as $mis) {
    switch($mis['Campo']){
    case "tipo_impianto": $tipo_impianto = $mis['Valore']; break;
    case "tipo_orologio": $tipo_orologio = $mis['Valore']; break;
    case "num_schedine": $num_schedine = $mis['Valore']; break;
    case "tipo_schedine": $tipo_schedine = $mis['Valore']; break;
    case "tipo_teleruttori": $tipo_teleruttori = $mis['Valore']; break;
    case "num_teleruttori": $num_teleruttori = $mis['Valore']; break;
    case "magnetotermico": $magnetotermico = $mis['Valore']; break;
    case "interno_al_quadro": $interno_al_quadro = $mis['Valore']; break;
    case "comando_quadranti": $comando_quadranti = $mis['Valore']; break;
    case "tipo_percussori": $tipo_percussori = $mis['Valore']; break;
    case "n_p400": $n_p400 = $mis['Valore']; break;
    case "n_p900": $n_p900 = $mis['Valore']; break;
    case "n_p900r": $n_p900r = $mis['Valore']; break;
    case "n_pl0": $n_pl0 = $mis['Valore']; break;
    case "n_pl1": $n_pl1 = $mis['Valore']; break;
    case "n_pl2": $n_pl2 = $mis['Valore']; break;
    case "n_pl3": $n_pl3 = $mis['Valore']; break;
    case "n_pl4": $n_pl4 = $mis['Valore']; break;
    case "n_pl5": $n_pl5 = $mis['Valore']; break;
    case "diam_mot1": $diam_mot1 = $mis['Valore']; break;
    case "diam_mot2": $diam_mot2 = $mis['Valore']; break;
    case "diam_mot3": $diam_mot3 = $mis['Valore']; break;
    case "diam_mot4": $diam_mot4 = $mis['Valore']; break;
    case "diam_mot5": $diam_mot5 = $mis['Valore']; break;
    case "diam_mot6": $diam_mot6 = $mis['Valore']; break;
    case "diam_mot7": $diam_mot7 = $mis['Valore']; break;
    case "diam_mot8": $diam_mot8 = $mis['Valore']; break;
    case "hp_mot1": $hp_mot1 = $mis['Valore']; break;
    case "hp_mot2": $hp_mot2 = $mis['Valore']; break;
    case "hp_mot3": $hp_mot3 = $mis['Valore']; break;
    case "hp_mot4": $hp_mot4 = $mis['Valore']; break;
    case "hp_mot5": $hp_mot5 = $mis['Valore']; break;
    case "hp_mot6": $hp_mot6 = $mis['Valore']; break;
    case "hp_mot7": $hp_mot7 = $mis['Valore']; break;
    case "hp_mot8": $hp_mot8 = $mis['Valore']; break;
    case "giri_mot1": $giri_mot1 = $mis['Valore']; break;
    case "giri_mot2": $giri_mot2 = $mis['Valore']; break;
    case "giri_mot3": $giri_mot3 = $mis['Valore']; break;
    case "giri_mot4": $giri_mot4 = $mis['Valore']; break;
    case "giri_mot5": $giri_mot5 = $mis['Valore']; break;
    case "giri_mot6": $giri_mot6 = $mis['Valore']; break;
    case "giri_mot7": $giri_mot7 = $mis['Valore']; break;
    case "giri_mot8": $giri_mot8 = $mis['Valore']; break;
    case "slancio_mot1": $slancio_mot1 = $mis['Valore']; break;
    case "slancio_mot2": $slancio_mot2 = $mis['Valore']; break;
    case "slancio_mot3": $slancio_mot3 = $mis['Valore']; break;
    case "slancio_mot4": $slancio_mot4 = $mis['Valore']; break;
    case "slancio_mot5": $slancio_mot5 = $mis['Valore']; break;
    case "slancio_mot6": $slancio_mot6 = $mis['Valore']; break;
    case "slancio_mot7": $slancio_mot7 = $mis['Valore']; break;
    case "slancio_mot8": $slancio_mot8 = $mis['Valore']; break;
    case "semi_slancio_mot1": $semi_slancio_mot1 = $mis['Valore']; break;
    case "semi_slancio_mot2": $semi_slancio_mot2 = $mis['Valore']; break;
    case "semi_slancio_mot3": $semi_slancio_mot3 = $mis['Valore']; break;
    case "semi_slancio_mot4": $semi_slancio_mot4 = $mis['Valore']; break;
    case "semi_slancio_mot5": $semi_slancio_mot5 = $mis['Valore']; break;
    case "semi_slancio_mot6": $semi_slancio_mot6 = $mis['Valore']; break;
    case "semi_slancio_mot7": $semi_slancio_mot7 = $mis['Valore']; break;
    case "semi_slancio_mot8": $semi_slancio_mot8 = $mis['Valore']; break;
    case "rapporto_mot1": $rapporto_mot1 = $mis['Valore']; break;
    case "rapporto_mot2": $rapporto_mot2 = $mis['Valore']; break;
    case "rapporto_mot3": $rapporto_mot3 = $mis['Valore']; break;
    case "rapporto_mot4": $rapporto_mot4 = $mis['Valore']; break;
    case "rapporto_mot5": $rapporto_mot5 = $mis['Valore']; break;
    case "rapporto_mot6": $rapporto_mot6 = $mis['Valore']; break;
    case "rapporto_mot7": $rapporto_mot7 = $mis['Valore']; break;
    case "rapporto_mot8": $rapporto_mot8 = $mis['Valore']; break;
    case "camme_mot1": $camme_mot1 = $mis['Valore']; break;
    case "camme_mot2": $camme_mot2 = $mis['Valore']; break;
    case "camme_mot3": $camme_mot3 = $mis['Valore']; break;
    case "camme_mot4": $camme_mot4 = $mis['Valore']; break;
    case "camme_mot5": $camme_mot5 = $mis['Valore']; break;
    case "camme_mot6": $camme_mot6 = $mis['Valore']; break;
    case "camme_mot7": $camme_mot7 = $mis['Valore']; break;
    case "camme_mot8": $camme_mot8 = $mis['Valore']; break;
    case "tipo_camme_mot1": $tipo_camme_mot1 = $mis['Valore']; break;
    case "tipo_camme_mot2": $tipo_camme_mot2 = $mis['Valore']; break;
    case "tipo_camme_mot3": $tipo_camme_mot3 = $mis['Valore']; break;
    case "tipo_camme_mot4": $tipo_camme_mot4 = $mis['Valore']; break;
    case "tipo_camme_mot5": $tipo_camme_mot5 = $mis['Valore']; break;
    case "tipo_camme_mot6": $tipo_camme_mot6 = $mis['Valore']; break;
    case "tipo_camme_mot7": $tipo_camme_mot7 = $mis['Valore']; break;
    case "tipo_camme_mot8": $tipo_camme_mot8 = $mis['Valore']; break;
    case "n_quadranti": $n_quadranti = $mis['Valore']; break;
    case "diam_quadranti": $diam_quadranti = $mis['Valore']; break;
    case "retroilluminazione": $retroilluminazione = $mis['Valore']; break;
    case "n_mov_meccanici": $n_mov_meccanici = $mis['Valore']; break;
    case "n_rid_mov_meccanici": $n_rid_mov_meccanici = $mis['Valore']; break;
    case "tipo_motoriduttore": $tipo_motoriduttore = $mis['Valore']; break;
    case "n_mov_riduttori": $n_mov_riduttori = $mis['Valore']; break;
    case "n_4_quadranti": $n_4_quadranti = $mis['Valore']; break;
    case "note_impianti": $note_impianti = $mis['Valore']; break;
    }
}


class PDF extends FPDF
{


    // Load data
    function LoadData($file)
    {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach($lines as $line)
            $data[] = explode(';',trim($line));
        return $data;
    }

    function ImprovedTable($tipo_impianto, $tipo_orologio) {

            $this->Cell(80,6, 'tipo impianto: ' .$tipo_impianto, 1, 0, 'C');
            $this->Cell(80,6, 'tipo orologio: ' .$tipo_orologio, 1, 0, 'C');
            
            $this->Ln();
    }
    
    function ImprovedTable2($num_schedine, $tipo_schedine, $tipo_teleruttori,$num_teleruttori,$magnetotermico,$interno_al_quadro,$comando_quadranti) {
    
            $this->Cell(80,6, 'num schedine: '. $num_schedine, 1, 0, 'C');
            $this->Cell(80,6, 'tipo schedine: '. $tipo_schedine, 1, 1, 'C');
            $this->Cell(80,6, 'tipo teleruttori: '. $tipo_teleruttori, 1, 0, 'C');
            $this->Cell(80,6, 'num teleruttori: '. $num_teleruttori, 1, 1, 'C');
            $this->Cell(80,6, 'magnetotermico: '. $magnetotermico, 1, 0, 'C');
            $this->Cell(80,6, 'interno al quadro: '. $interno_al_quadro, 1, 1, 'C');
            $this->Cell(80,6, 'comando quadranti: '. $comando_quadranti, 1, 0, 'C');
            
            $this->Ln();
    }
    function ImprovedTable3($tipo_percussori, $n_p400, $n_p900, $n_p900r, $n_pl0, $n_pl1, $n_pl2, $n_pl3, $n_pl4, $n_pl5) {
    
        $this->Cell(80,6, 'tipo percussori: '. $tipo_percussori, 1, 1, 'C');
        $this->Cell(80,6, 'num P400 220VCC: '. $n_p400, 1, 0, 'C');
        $this->Cell(80,6, 'num PL0: '. $n_pl0, 1, 1, 'C');
        $this->Cell(80,6, 'num P900 220VCC: '. $n_p900, 1, 0, 'C');
        $this->Cell(80,6, 'num PL1: '. $n_pl1, 1, 1, 'C');
        $this->Cell(80,6, 'num P900/R 220VCC: '. $n_p900r, 1, 0, 'C');
        $this->Cell(80,6, 'num PL2: '. $n_pl2, 1, 1, 'C');
        $this->Cell(80,6, '', 0, 0, 'C');
        $this->Cell(80,6, 'num PL3: '. $n_pl3, 1, 1, 'C');
        $this->Cell(80,6, '', 0, 0, 'C');
        $this->Cell(80,6, 'num PL4: '. $n_pl4, 1, 1, 'C');
        $this->Cell(80,6, '', 0, 0, 'C');
        $this->Cell(80,6, 'num PL5: '. $n_pl5, 1, 1, 'C');
        
        $this->Ln();
    }
    function ImprovedTable4($header4, $diam_mot1, $diam_mot2, $diam_mot3, $diam_mot4, $diam_mot5, $diam_mot6, $diam_mot7, $diam_mot8,
    $hp_mot1, $hp_mot2, $hp_mot3, $hp_mot4, $hp_mot5, $hp_mot6, $hp_mot7, $hp_mot8,
    $giri_mot1, $giri_mot2, $giri_mot3, $giri_mot4, $giri_mot5, $giri_mot6, $giri_mot7, $giri_mot8,
    $slancio_mot1, $slancio_mot2, $slancio_mot3, $slancio_mot4, $slancio_mot5, $slancio_mot6, $slancio_mot7, $slancio_mot8,
    $semi_slancio_mot1, $rapporto_mot1, $camme_mot1, $tipo_camme_mot1,
    $semi_slancio_mot2, $rapporto_mot2, $camme_mot2, $tipo_camme_mot2,
    $semi_slancio_mot3, $rapporto_mot3, $camme_mot3, $tipo_camme_mot3,
    $semi_slancio_mot4, $rapporto_mot4, $camme_mot4, $tipo_camme_mot4,
    $semi_slancio_mot5, $rapporto_mot5, $camme_mot5, $tipo_camme_mot5,
    $semi_slancio_mot6, $rapporto_mot6, $camme_mot6, $tipo_camme_mot6,
    $semi_slancio_mot7, $rapporto_mot7, $camme_mot7, $tipo_camme_mot7,
    $semi_slancio_mot8, $rapporto_mot8, $camme_mot8, $tipo_camme_mot8) {
        $w = array(18, 22, 22, 22, 22, 22, 22, 22, 22);
        for($i=0;$i<count($header4);$i++)
        $this->Cell($w[$i],7,$header4[$i],1,0,'C');
        $this->Ln();
        $this->Cell(18,6, '1', 1, 0, 'C');
        $this->Cell(22,6, $diam_mot1, 1, 0, 'C');
        $this->Cell(22,6, $hp_mot1, 1, 0, 'C');
        $this->Cell(22,6, $giri_mot1, 1, 0, 'C');
        $this->Cell(22,6, $slancio_mot1, 1, 0, 'C');
        $this->Cell(22,6, $semi_slancio_mot1, 1, 0, 'C');
        $this->Cell(22,6, $rapporto_mot1, 1, 0, 'C');
        $this->Cell(22,6, $camme_mot1, 1, 0, 'C');
        $this->Cell(22,6, $tipo_camme_mot1, 1, 1, 'C');

        $this->Cell(18,6, '2', 1, 0, 'C');
        $this->Cell(22,6, $diam_mot2, 1, 0, 'C');
        $this->Cell(22,6, $hp_mot2, 1, 0, 'C');
        $this->Cell(22,6, $giri_mot2, 1, 0, 'C');
        $this->Cell(22,6, $slancio_mot2, 1, 0, 'C');
        $this->Cell(22,6, $semi_slancio_mot2, 1, 0, 'C');
        $this->Cell(22,6, $rapporto_mot2, 1, 0, 'C');
        $this->Cell(22,6, $camme_mot2, 1, 0, 'C');
        $this->Cell(22,6, $tipo_camme_mot2, 1, 1, 'C');

        $this->Cell(18,6, '3', 1, 0, 'C');
        $this->Cell(22,6, $diam_mot3, 1, 0, 'C');
        $this->Cell(22,6, $hp_mot3, 1, 0, 'C');
        $this->Cell(22,6, $giri_mot3, 1, 0, 'C');
        $this->Cell(22,6, $slancio_mot3, 1, 0, 'C');
        $this->Cell(22,6, $semi_slancio_mot3, 1, 0, 'C');
        $this->Cell(22,6, $rapporto_mot3, 1, 0, 'C');
        $this->Cell(22,6, $camme_mot3, 1, 0, 'C');
        $this->Cell(22,6, $tipo_camme_mot3, 1, 1, 'C');

        $this->Cell(18,6, '4', 1, 0, 'C');
        $this->Cell(22,6, $diam_mot4, 1, 0, 'C');
        $this->Cell(22,6, $hp_mot4, 1, 0, 'C');
        $this->Cell(22,6, $giri_mot4, 1, 0, 'C');
        $this->Cell(22,6, $slancio_mot4, 1, 0, 'C');
        $this->Cell(22,6, $semi_slancio_mot4, 1, 0, 'C');
        $this->Cell(22,6, $rapporto_mot4, 1, 0, 'C');
        $this->Cell(22,6, $camme_mot4, 1, 0, 'C');
        $this->Cell(22,6, $tipo_camme_mot4, 1, 1, 'C');

        $this->Cell(18,6, '5', 1, 0, 'C');
        $this->Cell(22,6, $diam_mot5, 1, 0, 'C');
        $this->Cell(22,6, $hp_mot5, 1, 0, 'C');
        $this->Cell(22,6, $giri_mot5, 1, 0, 'C');
        $this->Cell(22,6, $slancio_mot5, 1, 0, 'C');
        $this->Cell(22,6, $semi_slancio_mot5, 1, 0, 'C');
        $this->Cell(22,6, $rapporto_mot5, 1, 0, 'C');
        $this->Cell(22,6, $camme_mot5, 1, 0, 'C');
        $this->Cell(22,6, $tipo_camme_mot5, 1, 1, 'C');

        $this->Cell(18,6, '6', 1, 0, 'C');
        $this->Cell(22,6, $diam_mot6, 1, 0, 'C');
        $this->Cell(22,6, $hp_mot6, 1, 0, 'C');
        $this->Cell(22,6, $giri_mot6, 1, 0, 'C');
        $this->Cell(22,6, $slancio_mot6, 1, 0, 'C');
        $this->Cell(22,6, $semi_slancio_mot6, 1, 0, 'C');
        $this->Cell(22,6, $rapporto_mot6, 1, 0, 'C');
        $this->Cell(22,6, $camme_mot6, 1, 0, 'C');
        $this->Cell(22,6, $tipo_camme_mot6, 1, 1, 'C');

        $this->Cell(18,6, '7', 1, 0, 'C');
        $this->Cell(22,6, $diam_mot7, 1, 0, 'C');
        $this->Cell(22,6, $hp_mot7, 1, 0, 'C');
        $this->Cell(22,6, $giri_mot7, 1, 0, 'C');
        $this->Cell(22,6, $slancio_mot7, 1, 0, 'C');
        $this->Cell(22,6, $semi_slancio_mot7, 1, 0, 'C');
        $this->Cell(22,6, $rapporto_mot7, 1, 0, 'C');
        $this->Cell(22,6, $camme_mot7, 1, 0, 'C');
        $this->Cell(22,6, $tipo_camme_mot7, 1, 1, 'C');

        $this->Cell(18,6, '8', 1, 0, 'C');
        $this->Cell(22,6, $diam_mot8, 1, 0, 'C');
        $this->Cell(22,6, $hp_mot8, 1, 0, 'C');
        $this->Cell(22,6, $giri_mot8, 1, 0, 'C');
        $this->Cell(22,6, $slancio_mot8, 1, 0, 'C');
        $this->Cell(22,6, $semi_slancio_mot8, 1, 0, 'C');
        $this->Cell(22,6, $rapporto_mot8, 1, 0, 'C');
        $this->Cell(22,6, $camme_mot8, 1, 0, 'C');
        $this->Cell(22,6, $tipo_camme_mot8, 1, 1, 'C');

        $this->Ln();
    }
    function ImprovedTable5($n_quadranti, $diam_quadranti, $retroilluminazione, $n_mov_meccanici, $n_rid_mov_meccanici, $tipo_motoriduttore, $n_mov_riduttori, $n_4_quadranti) {

        $this->Cell(60,6, 'N quadranti: ' .$n_quadranti, 1, 0, 'C');
        $this->Cell(60,6, 'Diametro: ' .$diam_quadranti, 1, 0, 'C');
        $this->Cell(60,6, $retroilluminazione, 1, 1, 'C');
        $this->Cell(60,6, 'N mov. meccanici: ' .$n_mov_meccanici, 1, 0, 'C');
        $this->Cell(60,6, 'N Rid mov meccanici: ' .$n_rid_mov_meccanici, 1, 0, 'C');
        $this->Cell(60,6, 'Tipo motoriduttore: ' .$tipo_motoriduttore, 1, 1, 'C');
        $this->Cell(60,6, 'N mov. con riduttori: ' .$n_mov_riduttori, 1, 0, 'C');
        $this->Cell(60,6, 'N 4 quadranti: ' .$n_4_quadranti, 1, 0, 'C');
        
        $this->Ln();
    }
}
$pdf = new PDF();
// Column headings
$header = array('Tipo impianto','Tipo orologio');
$header2 = array('Quadro');
$header3 = array('N','Diametro campana', 'A', 'B', 'C', 'D');
$header4 = array('Motore N','Diametro','HP', 'Giri', 'Slancio', '1/2 Slancio', 'Rapporto', 'N Camme', 'Tipo Camme');
$header5 = array('N','Diametro campana', 'Punto di battuta', 'A', 'B', 'C', 'D');
$header6 = array('N','Diametro campana', 'A', 'B', 'C', 'D');
$header7 = array('N','Diametro foro', 'Modello quadrante');
// Data loading
$pdf->AliasNbPages();
// $data = $pdf->LoadData('countries.txt');
$pdf->SetFont('Arial','',10);
$pdf->AddPage();
$pdf->Cell(0,10,'Tipo Impianto',0,1);
$pdf->ImprovedTable($tipo_impianto, $tipo_orologio);
$pdf->Cell(0,10,'Quadro',0,1);
$pdf->ImprovedTable2($num_schedine, $tipo_schedine, $tipo_teleruttori,$num_teleruttori,$magnetotermico,$interno_al_quadro,$comando_quadranti);
$pdf->Cell(0,10,'Percussori',0,1);
$pdf->ImprovedTable3($tipo_percussori, $n_p400, $n_p900, $n_p900r, $n_pl0, $n_pl1, $n_pl2, $n_pl3, $n_pl4, $n_pl5);
$pdf->Cell(0,10,'Motori',0,1);
$pdf->ImprovedTable4($header4, $diam_mot1, $diam_mot2, $diam_mot3, $diam_mot4, $diam_mot5, $diam_mot6, $diam_mot7, $diam_mot8,
$hp_mot1, $hp_mot2, $hp_mot3, $hp_mot4, $hp_mot5, $hp_mot6, $hp_mot7, $hp_mot8,
$giri_mot1, $giri_mot2, $giri_mot3, $giri_mot4, $giri_mot5, $giri_mot6, $giri_mot7, $giri_mot8,
$slancio_mot1, $slancio_mot2, $slancio_mot3, $slancio_mot4, $slancio_mot5, $slancio_mot6, $slancio_mot7, $slancio_mot8,
$semi_slancio_mot1, $rapporto_mot1, $camme_mot1, $tipo_camme_mot1,
$semi_slancio_mot2, $rapporto_mot2, $camme_mot2, $tipo_camme_mot2,
$semi_slancio_mot3, $rapporto_mot3, $camme_mot3, $tipo_camme_mot3,
$semi_slancio_mot4, $rapporto_mot4, $camme_mot4, $tipo_camme_mot4,
$semi_slancio_mot5, $rapporto_mot5, $camme_mot5, $tipo_camme_mot5,
$semi_slancio_mot6, $rapporto_mot6, $camme_mot6, $tipo_camme_mot6,
$semi_slancio_mot7, $rapporto_mot7, $camme_mot7, $tipo_camme_mot7,
$semi_slancio_mot8, $rapporto_mot8, $camme_mot8, $tipo_camme_mot8);
$pdf->Cell(0,10,'Quadranti',0,1);
$pdf->ImprovedTable5($n_quadranti, $diam_quadranti, $retroilluminazione, $n_mov_meccanici, $n_rid_mov_meccanici, $tipo_motoriduttore, $n_mov_riduttori, $n_4_quadranti);

$pdf->Output();