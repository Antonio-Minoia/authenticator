<?php
require_once("../../api/helpers/db.php");

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

$sql1 = "SELECT note FROM x_mis WHERE id_mis = '$id_mis'";
$result1 = mysqli_query($connection, $sql1);
$note = array();
while ($row = mysqli_fetch_row($result1)) {
    $dati = array(
        "Note" => $row[0]
    );
    array_push($note, $dati);
}


$d_c1_t1 = ""; $d_c2_t1 = ""; $d_c3_t1 = ""; $d_c4_t1 = ""; $d_c5_t1 = ""; $d_c6_t1 = ""; $d_c7_t1 = ""; $d_c8_t1 = "";
$p_b1_t1 = ""; $p_b2_t1 = ""; $p_b3_t1 = ""; $p_b4_t1 = ""; $p_b5_t1 = ""; $p_b6_t1 = ""; $p_b7_t1 = ""; $p_b8_t1 = "";
$a1_t1 = ""; $a2_t1 = ""; $a3_t1 = ""; $a4_t1 = ""; $a5_t1 = ""; $a6_t1 = ""; $a7_t1 = ""; $a8_t1 = ""; 
$a1_t2 = ""; $a2_t2 = ""; $a3_t2 = ""; $a4_t2 = "";$a1_t3 = ""; $a2_t3 = ""; $a3_t3 = ""; $a4_t3 = "";
$a1_t4 = ""; $a2_t4 = ""; $a3_t4 = ""; $a4_t4 = "";$a1_t5 = ""; $a2_t5 = ""; $a3_t5 = ""; $a4_t5 = "";
$a1_t6 = ""; $a2_t6 = ""; $a3_t6 = ""; $a4_t6 = "";$b1_t1 = ""; $b2_t1 = ""; $b3_t1 = ""; $b4_t1 = ""; $b5_t1 = ""; $b6_t1 = ""; $b7_t1 = ""; $b8_t1 = ""; 
$b1_t2 = ""; $b2_t2 = ""; $b3_t2 = ""; $b4_t2 = "";$b1_t3 = ""; $b2_t3 = ""; $b3_t3 = ""; $b4_t3 = "";
$b1_t4 = ""; $b2_t4 = ""; $b3_t4 = ""; $b4_t4 = "";$b1_t5 = ""; $b2_t5 = ""; $b3_t5 = ""; $b4_t5 = "";
$b1_t6 = ""; $b2_t6 = ""; $b3_t6 = ""; $b4_t6 = "";$c1_t1 = ""; $c2_t1 = ""; $c3_t1 = ""; $c4_t1 = ""; $c5_t1 = ""; $c6_t1 = ""; $c7_t1 = ""; $c8_t1 = ""; 
$c1_t2 = ""; $c2_t2 = ""; $c3_t2 = ""; $c4_t2 = "";$c1_t3 = ""; $c2_t3 = ""; $c3_t3 = ""; $c4_t3 = "";
$c1_t4 = ""; $c2_t4 = ""; $c3_t4 = ""; $c4_t4 = "";$c1_t5 = ""; $c2_t5 = ""; $c3_t5 = ""; $c4_t5 = "";
$c1_t6 = ""; $c2_t6 = ""; $c3_t6 = ""; $c4_t6 = "";$d1_t3 = ""; $d2_t3 = ""; $d3_t3 = ""; $d4_t3 = "";
$d1_t4 = ""; $d2_t4 = ""; $d3_t4 = ""; $d4_t4 = "";$d1_t5 = ""; $d2_t5 = ""; $d3_t5 = ""; $d4_t5 = "";
$d1_t6 = ""; $d2_t6 = ""; $d3_t6 = ""; $d4_t6 = "";$d_c1_t2 = ""; $d_c2_t2 = ""; $d_c3_t2 = ""; $d_c4_t2 = "";
$d_c1_t3 = ""; $d_c2_t3 = ""; $d_c3_t3 = ""; $d_c4_t3 = "";$d_c1_t4 = ""; $d_c2_t4 = ""; $d_c3_t4 = ""; $d_c4_t4 = "";
$d_c1_t5 = ""; $d_c2_t5 = ""; $d_c3_t5 = ""; $d_c4_t5 = "";$p_b1_t5 = ""; $p_b2_t5 = ""; $p_b3_t5 = ""; $p_b4_t5 = "";
$d_c1_t6 = ""; $d_c2_t6 = ""; $d_c3_t6 = ""; $d_c4_t6 = "";$r1_t1 = ""; $r2_t1 = ""; $r3_t1 = ""; $r4_t1 = ""; $r5_t1 = ""; $r6_t1 = ""; $r7_t1 = ""; $r8_t1 = ""; 
$r1_t2 = ""; $r2_t2 = ""; $r3_t2 = ""; $r4_t2 = "";$m1_t2 = ""; $m2_t2 = ""; $m3_t2 = ""; $m4_t2 = "";$diam_foro = ""; $mod_quad = "";


foreach($misurazioni as $mis){
    switch($mis['Campo']){

 case "diametro_campana1_tab1": $d_c1_t1= $mis['Valore']; break; 
 case "diametro_campana2_tab1": $d_c2_t1= $mis['Valore']; break; 
 case "diametro_campana3_tab1": $d_c3_t1= $mis['Valore']; break; 
 case "diametro_campana4_tab1": $d_c4_t1= $mis['Valore']; break; 
 case "diametro_campana5_tab1": $d_c5_t1= $mis['Valore']; break; 
 case "diametro_campana6_tab1": $d_c6_t1= $mis['Valore']; break; 
 case "diametro_campana7_tab1": $d_c7_t1= $mis['Valore']; break; 
 case "diametro_campana8_tab1": $d_c8_t1= $mis['Valore']; break; 

 case "punto_battuta1_tab1": $p_b1_t1= $mis['Valore']; break; 
 case "punto_battuta2_tab1": $p_b2_t1= $mis['Valore']; break; 
 case "punto_battuta3_tab1": $p_b3_t1= $mis['Valore']; break; 
 case "punto_battuta4_tab1": $p_b4_t1= $mis['Valore']; break; 
 case "punto_battuta5_tab1": $p_b5_t1= $mis['Valore']; break; 
 case "punto_battuta6_tab1": $p_b6_t1= $mis['Valore']; break; 
 case "punto_battuta7_tab1": $p_b7_t1= $mis['Valore']; break; 
 case "punto_battuta8_tab1": $p_b8_t1= $mis['Valore']; break; 

 case "mis_a1_tab1": $a1_t1= $mis['Valore']; break; 
 case "mis_a2_tab1": $a2_t1= $mis['Valore']; break; 
 case "mis_a3_tab1": $a3_t1= $mis['Valore']; break; 
 case "mis_a4_tab1": $a4_t1= $mis['Valore']; break; 
 case "mis_a5_tab1": $a5_t1= $mis['Valore']; break; 
 case "mis_a6_tab1": $a6_t1= $mis['Valore']; break; 
 case "mis_a7_tab1": $a7_t1= $mis['Valore']; break; 
 case "mis_a8_tab1": $a8_t1= $mis['Valore']; break; 
 
 case "mis_a1_tab2": $a1_t2= $mis['Valore']; break; 
 case "mis_a2_tab2": $a2_t2= $mis['Valore']; break; 
 case "mis_a3_tab2": $a3_t2= $mis['Valore']; break; 
 case "mis_a4_tab2": $a4_t2= $mis['Valore']; break; 

 case "mis_a1_tab3": $a1_t3= $mis['Valore']; break; 
 case "mis_a2_tab3": $a2_t3= $mis['Valore']; break; 
 case "mis_a3_tab3": $a3_t3= $mis['Valore']; break; 
 case "mis_a4_tab3": $a4_t3= $mis['Valore']; break; 

 case "mis_a1_tab4": $a1_t4= $mis['Valore']; break; 
 case "mis_a2_tab4": $a2_t4= $mis['Valore']; break; 
 case "mis_a3_tab4": $a3_t4= $mis['Valore']; break; 
 case "mis_a4_tab4": $a4_t4= $mis['Valore']; break; 

 case "mis_a1_tab5": $a1_t5= $mis['Valore']; break; 
 case "mis_a2_tab5": $a2_t5= $mis['Valore']; break; 
 case "mis_a3_tab5": $a3_t5= $mis['Valore']; break; 
 case "mis_a4_tab5": $a4_t5= $mis['Valore']; break; 

 case "mis_a1_tab6": $a1_t6= $mis['Valore']; break; 
 case "mis_a2_tab6": $a2_t6= $mis['Valore']; break; 
 case "mis_a3_tab6": $a3_t6= $mis['Valore']; break; 
 case "mis_a4_tab6": $a4_t6= $mis['Valore']; break; 

 case "mis_b1_tab1": $b1_t1= $mis['Valore']; break; 
 case "mis_b2_tab1": $b2_t1= $mis['Valore']; break; 
 case "mis_b3_tab1": $b3_t1= $mis['Valore']; break; 
 case "mis_b4_tab1": $b4_t1= $mis['Valore']; break; 
 case "mis_b5_tab1": $b5_t1= $mis['Valore']; break; 
 case "mis_b6_tab1": $b6_t1= $mis['Valore']; break; 
 case "mis_b7_tab1": $b7_t1= $mis['Valore']; break; 
 case "mis_b8_tab1": $b8_t1= $mis['Valore']; break; 
 
 case "mis_b1_tab2": $b1_t2= $mis['Valore']; break; 
 case "mis_b2_tab2": $b2_t2= $mis['Valore']; break; 
 case "mis_b3_tab2": $b3_t2= $mis['Valore']; break; 
 case "mis_b4_tab2": $b4_t2= $mis['Valore']; break; 

 case "mis_b1_tab3": $b1_t3= $mis['Valore']; break; 
 case "mis_b2_tab3": $b2_t3= $mis['Valore']; break; 
 case "mis_b3_tab3": $b3_t3= $mis['Valore']; break; 
 case "mis_b4_tab3": $b4_t3= $mis['Valore']; break; 

 case "mis_b1_tab4": $b1_t4= $mis['Valore']; break; 
 case "mis_b2_tab4": $b2_t4= $mis['Valore']; break; 
 case "mis_b3_tab4": $b3_t4= $mis['Valore']; break; 
 case "mis_b4_tab4": $b4_t4= $mis['Valore']; break; 

 case "mis_b1_tab5": $b1_t5= $mis['Valore']; break; 
 case "mis_b2_tab5": $b2_t5= $mis['Valore']; break; 
 case "mis_b3_tab5": $b3_t5= $mis['Valore']; break; 
 case "mis_b4_tab5": $b4_t5= $mis['Valore']; break; 

 case "mis_b1_tab6": $b1_t6= $mis['Valore']; break; 
 case "mis_b2_tab6": $b2_t6= $mis['Valore']; break; 
 case "mis_b3_tab6": $b3_t6= $mis['Valore']; break; 
 case "mis_b4_tab6": $b4_t6= $mis['Valore']; break; 

 case "mis_c1_tab1": $c1_t1= $mis['Valore']; break; 
 case "mis_c2_tab1": $c2_t1= $mis['Valore']; break; 
 case "mis_c3_tab1": $c3_t1= $mis['Valore']; break; 
 case "mis_c4_tab1": $c4_t1= $mis['Valore']; break; 
 case "mis_c5_tab1": $c5_t1= $mis['Valore']; break; 
 case "mis_c6_tab1": $c6_t1= $mis['Valore']; break; 
 case "mis_c7_tab1": $c7_t1= $mis['Valore']; break; 
 case "mis_c8_tab1": $c8_t1= $mis['Valore']; break; 
 
 case "mis_c1_tab2": $c1_t2= $mis['Valore']; break; 
 case "mis_c2_tab2": $c2_t2= $mis['Valore']; break; 
 case "mis_c3_tab2": $c3_t2= $mis['Valore']; break; 
 case "mis_c4_tab2": $c4_t2= $mis['Valore']; break; 

 case "mis_c1_tab3": $c1_t3= $mis['Valore']; break; 
 case "mis_c2_tab3": $c2_t3= $mis['Valore']; break; 
 case "mis_c3_tab3": $c3_t3= $mis['Valore']; break; 
 case "mis_c4_tab3": $c4_t3= $mis['Valore']; break; 

 case "mis_c1_tab4": $c1_t4= $mis['Valore']; break; 
 case "mis_c2_tab4": $c2_t4= $mis['Valore']; break; 
 case "mis_c3_tab4": $c3_t4= $mis['Valore']; break; 
 case "mis_c4_tab4": $c4_t4= $mis['Valore']; break; 

 case "mis_c1_tab5": $c1_t5= $mis['Valore']; break; 
 case "mis_c2_tab5": $c2_t5= $mis['Valore']; break; 
 case "mis_c3_tab5": $c3_t5= $mis['Valore']; break; 
 case "mis_c4_tab5": $c4_t5= $mis['Valore']; break; 

 case "mis_c1_tab6": $c1_t6= $mis['Valore']; break; 
 case "mis_c2_tab6": $c2_t6= $mis['Valore']; break; 
 case "mis_c3_tab6": $c3_t6= $mis['Valore']; break; 
 case "mis_c4_tab6": $c4_t6= $mis['Valore']; break; 

 case "mis_d1_tab3": $d1_t3= $mis['Valore']; break; 
 case "mis_d2_tab3": $d2_t3= $mis['Valore']; break; 
 case "mis_d3_tab3": $d3_t3= $mis['Valore']; break; 
 case "mis_d4_tab3": $d4_t3= $mis['Valore']; break; 

 case "mis_d1_tab4": $d1_t4= $mis['Valore']; break; 
 case "mis_d2_tab4": $d2_t4= $mis['Valore']; break; 
 case "mis_d3_tab4": $d3_t4= $mis['Valore']; break; 
 case "mis_d4_tab4": $d4_t4= $mis['Valore']; break; 

 case "mis_d1_tab5": $d1_t5= $mis['Valore']; break; 
 case "mis_d2_tab5": $d2_t5= $mis['Valore']; break; 
 case "mis_d3_tab5": $d3_t5= $mis['Valore']; break; 
 case "mis_d4_tab5": $d4_t5= $mis['Valore']; break; 

 case "mis_d1_tab6": $d1_t6= $mis['Valore']; break; 
 case "mis_d2_tab6": $d2_t6= $mis['Valore']; break; 
 case "mis_d3_tab6": $d3_t6= $mis['Valore']; break; 
 case "mis_d4_tab6": $d4_t6= $mis['Valore']; break; 

 case "diametro_campana1_tab2": $d_c1_t2= $mis['Valore']; break; 
 case "diametro_campana2_tab2": $d_c2_t2= $mis['Valore']; break; 
 case "diametro_campana3_tab2": $d_c3_t2= $mis['Valore']; break; 
 case "diametro_campana4_tab2": $d_c4_t2= $mis['Valore']; break; 

 case "diametro_campana1_tab3": $d_c1_t3= $mis['Valore']; break; 
 case "diametro_campana2_tab3": $d_c2_t3= $mis['Valore']; break; 
 case "diametro_campana3_tab3": $d_c3_t3= $mis['Valore']; break; 
 case "diametro_campana4_tab3": $d_c4_t3= $mis['Valore']; break; 

 case "diametro_campana1_tab4": $d_c1_t4= $mis['Valore']; break; 
 case "diametro_campana2_tab4": $d_c2_t4= $mis['Valore']; break; 
 case "diametro_campana3_tab4": $d_c3_t4= $mis['Valore']; break; 
 case "diametro_campana4_tab4": $d_c4_t4= $mis['Valore']; break; 

 case "diametro_campana1_tab5": $d_c1_t5= $mis['Valore']; break; 
 case "diametro_campana2_tab5": $d_c2_t5= $mis['Valore']; break; 
 case "diametro_campana3_tab5": $d_c3_t5= $mis['Valore']; break; 
 case "diametro_campana4_tab5": $d_c4_t5= $mis['Valore']; break; 
 
 case "punto_battuta1_tab5": $p_b1_t5= $mis['Valore']; break; 
 case "punto_battuta2_tab5": $p_b2_t5= $mis['Valore']; break; 
 case "punto_battuta3_tab5": $p_b3_t5= $mis['Valore']; break; 
 case "punto_battuta4_tab5": $p_b4_t5= $mis['Valore']; break; 

 case "diametro_campana1_tab6": $d_c1_t6= $mis['Valore']; break; 
 case "diametro_campana2_tab6": $d_c2_t6= $mis['Valore']; break; 
 case "diametro_campana3_tab6": $d_c3_t6= $mis['Valore']; break; 
 case "diametro_campana4_tab6": $d_c4_t6= $mis['Valore']; break; 

 case "exampleRadios1_tab1": $r1_t1= $mis['Valore']; break; 
 case "exampleRadios2_tab1": $r2_t1= $mis['Valore']; break; 
 case "exampleRadios3_tab1": $r3_t1= $mis['Valore']; break; 
 case "exampleRadios4_tab1": $r4_t1= $mis['Valore']; break; 
 case "exampleRadios5_tab1": $r5_t1= $mis['Valore']; break; 
 case "exampleRadios6_tab1": $r6_t1= $mis['Valore']; break; 
 case "exampleRadios7_tab1": $r7_t1= $mis['Valore']; break; 
 case "exampleRadios8_tab1": $r8_t1= $mis['Valore']; break; 
 
 case "exampleRadios1_tab2": $r1_t2= $mis['Valore']; break; 
 case "exampleRadios2_tab2": $r2_t2= $mis['Valore']; break; 
 case "exampleRadios3_tab2": $r3_t2= $mis['Valore']; break; 
 case "exampleRadios4_tab2": $r4_t2= $mis['Valore']; break; 

 case "modello1_tab2": $m1_t2= $mis['Valore']; break; 
 case "modello2_tab2": $m2_t2= $mis['Valore']; break; 
 case "modello3_tab2": $m3_t2= $mis['Valore']; break; 
 case "modello4_tab2": $m4_t2= $mis['Valore']; break; 

 case "diametro_foro1_tab7": $diam_foro= $mis['Valore']; break; 
 case "modello_quadrante1_tab7": $mod_quad= $mis['Valore']; break; 
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

    // Better table
    function ImprovedTable($header, $d_c1_t1, $d_c2_t1, $d_c3_t1, $d_c4_t1, $d_c5_t1, $d_c6_t1, $d_c7_t1, $d_c8_t1,
    $p_b1_t1, $p_b2_t1, $p_b3_t1, $p_b4_t1, $p_b5_t1, $p_b6_t1, $p_b7_t1, $p_b8_t1,
    $a1_t1, $a2_t1, $a3_t1, $a4_t1, $a5_t1, $a6_t1, $a7_t1, $a8_t1,
    $b1_t1, $b2_t1, $b3_t1, $b4_t1, $b5_t1, $b6_t1, $b7_t1, $b8_t1,
    $c1_t1, $c2_t1, $c3_t1, $c4_t1, $c5_t1, $c6_t1, $c7_t1, $c8_t1,
    $r1_t1, $r2_t1, $r3_t1, $r4_t1, $r5_t1, $r6_t1, $r7_t1, $r8_t1
    )
    {
        
    // Column widths
    $w = array(10, 40, 35, 20, 20, 20, 50);
    // MultiCell(float w, float h, string txt , mixed border , string align , boolean fill)
    // Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
        $this->Ln();
        // Data
        // Closing line
        // $this->Cell(array_sum($w),0,'','T');
        // MultiCell(float w, float h, string txt , mixed border , string align , boolean fill)
        $this->Cell(10,6, '1', 1, 0,'C');
        $this->Cell(40,6, $d_c1_t1, 1, 0, 'C');
        $this->Cell(35,6, $p_b1_t1, 1, 0, 'C');
        $this->Cell(20,6, $a1_t1, 1, 0, 'C');
        $this->Cell(20,6, $b1_t1, 1, 0, 'C');
        $this->Cell(20,6, $c1_t1, 1, 0, 'C');
        $this->Cell(50,6, $r1_t1, 1, 1, 'C');
        
        $this->Cell(10,6, '2', 1, 0, 'C');
        $this->Cell(40,6, $d_c2_t1, 1, 0, 'C');
        $this->Cell(35,6, $p_b2_t1, 1, 0, 'C');
        $this->Cell(20,6, $a2_t1, 1, 0, 'C');
        $this->Cell(20,6, $b2_t1, 1, 0, 'C');
        $this->Cell(20,6, $c2_t1, 1, 0, 'C');
        $this->Cell(50,6, $r2_t1, 1, 1, 'C');
        
        $this->Cell(10,6, '3', 1, 0, 'C');
        $this->Cell(40,6, $d_c3_t1, 1, 0, 'C');
        $this->Cell(35,6, $p_b3_t1, 1, 0, 'C');
        $this->Cell(20,6, $a3_t1, 1, 0, 'C');
        $this->Cell(20,6, $b3_t1, 1, 0, 'C');
        $this->Cell(20,6, $c3_t1, 1, 0, 'C');
        $this->Cell(50,6, $r3_t1, 1, 1, 'C');
        
        $this->Cell(10,6, '4', 1, 0, 'C');
        $this->Cell(40,6, $d_c4_t1, 1, 0, 'C');
        $this->Cell(35,6, $p_b4_t1, 1, 0, 'C');
        $this->Cell(20,6, $a4_t1, 1, 0, 'C');
        $this->Cell(20,6, $b4_t1, 1, 0, 'C');
        $this->Cell(20,6, $c4_t1, 1, 0, 'C');
        $this->Cell(50,6, $r4_t1, 1, 1, 'C');
        
        $this->Cell(10,6, '5', 1, 0, 'C');
        $this->Cell(40,6, $d_c5_t1, 1, 0, 'C');
        $this->Cell(35,6, $p_b5_t1, 1, 0, 'C');
        $this->Cell(20,6, $a5_t1, 1, 0, 'C');
        $this->Cell(20,6, $b5_t1, 1, 0, 'C');
        $this->Cell(20,6, $c5_t1, 1, 0, 'C');
        $this->Cell(50,6, $r5_t1, 1, 1, 'C');
        
        $this->Cell(10,6, '6', 1, 0, 'C');
        $this->Cell(40,6, $d_c6_t1, 1, 0, 'C');
        $this->Cell(35,6, $p_b6_t1, 1, 0, 'C');
        $this->Cell(20,6, $a6_t1, 1, 0, 'C');
        $this->Cell(20,6, $b6_t1, 1, 0, 'C');
        $this->Cell(20,6, $c6_t1, 1, 0, 'C');
        $this->Cell(50,6, $r6_t1, 1, 1, 'C');
        
        $this->Cell(10,6, '7', 1, 0, 'C');
        $this->Cell(40,6, $d_c7_t1, 1, 0, 'C');
        $this->Cell(35,6, $p_b7_t1, 1, 0, 'C');
        $this->Cell(20,6, $a7_t1, 1, 0, 'C');
        $this->Cell(20,6, $b7_t1, 1, 0, 'C');
        $this->Cell(20,6, $c7_t1, 1, 0, 'C');
        $this->Cell(50,6, $r7_t1, 1, 1, 'C');
        
        $this->Cell(10,6, '8', 1, 0, 'C');
        $this->Cell(40,6, $d_c8_t1, 1, 0, 'C');
        $this->Cell(35,6, $p_b8_t1, 1, 0, 'C');
        $this->Cell(20,6, $a8_t1, 1, 0, 'C');
        $this->Cell(20,6, $b8_t1, 1, 0, 'C');
        $this->Cell(20,6, $c8_t1, 1, 0, 'C');
        $this->Cell(50,6, $r8_t1, 1, 1, 'C');
        $this->Ln();
    }
    

    function ImprovedTable2($header2, 
    $d_c1_t2, $d_c2_t2, $d_c3_t2, $d_c4_t2,
    $m1_t2, $m2_t2, $m3_t2, $m4_t2, 
    $a1_t2, $a2_t2, $a3_t2, $a4_t2, 
    $b1_t2, $b2_t2, $b3_t2, $b4_t2,
    $c1_t2, $c2_t2, $c3_t2, $c4_t2,
    $r1_t2, $r2_t2, $r3_t2, $r4_t2) {
    
        $w = array(10, 40, 35, 20, 20, 20, 50);
        for($i=0;$i<count($header2);$i++)
            $this->Cell($w[$i],7,$header2[$i],1,0,'C');
            $this->Ln();

            $this->Cell(10,6, '1', 1, 0, 'C');
            $this->Cell(40,6, $d_c1_t2, 1, 0, 'C');
            $this->Cell(35,6, $m1_t2, 1, 0, 'C');
            $this->Cell(20,6, $a1_t2, 1, 0, 'C');
            $this->Cell(20,6, $b1_t2, 1, 0, 'C');
            $this->Cell(20,6, $c1_t2, 1, 0, 'C');
            $this->Cell(50,6, $r1_t2, 1, 1, 'C');
            
            $this->Cell(10,6, '2', 1, 0, 'C');
            $this->Cell(40,6, $d_c2_t2, 1, 0, 'C');
            $this->Cell(35,6, $m2_t2, 1, 0, 'C');
            $this->Cell(20,6, $a2_t2, 1, 0, 'C');
            $this->Cell(20,6, $b2_t2, 1, 0, 'C');
            $this->Cell(20,6, $c2_t2, 1, 0, 'C');
            $this->Cell(50,6, $r2_t2, 1, 1, 'C');
            
            $this->Cell(10,6, '3', 1, 0, 'C');
            $this->Cell(40,6, $d_c3_t2, 1, 0, 'C');
            $this->Cell(35,6, $m3_t2, 1, 0, 'C');
            $this->Cell(20,6, $a3_t2, 1, 0, 'C');
            $this->Cell(20,6, $b3_t2, 1, 0, 'C');
            $this->Cell(20,6, $c3_t2, 1, 0, 'C');
            $this->Cell(50,6, $r3_t2, 1, 1, 'C');
            
            $this->Cell(10,6, '4', 1, 0, 'C');
            $this->Cell(40,6, $d_c4_t2, 1, 0, 'C');
            $this->Cell(35,6, $m4_t2, 1, 0, 'C');
            $this->Cell(20,6, $a4_t2, 1, 0, 'C');
            $this->Cell(20,6, $b4_t2, 1, 0, 'C');
            $this->Cell(20,6, $c4_t2, 1, 0, 'C');
            $this->Cell(50,6, $r4_t2, 1, 1, 'C');
            $this->Ln();
    }
    
    function ImprovedTable3($header3, 
    $d_c1_t3, $d_c2_t3, $d_c3_t3, $d_c4_t3,
    $a1_t3, $a2_t3, $a3_t3, $a4_t3, 
    $b1_t3, $b2_t3, $b3_t3, $b4_t3,
    $c1_t3, $c2_t3, $c3_t3, $c4_t3,
    $d1_t3, $d2_t3, $d3_t3, $d4_t3) {
    
        $w = array(10, 40, 20, 20, 20, 20);
        for($i=0;$i<count($header3);$i++)
            $this->Cell($w[$i],7,$header3[$i],1,0,'C');
            $this->Ln();

            $this->Cell(10,6, '1', 1, 0, 'C');
            $this->Cell(40,6, $d_c1_t3, 1, 0, 'C');
            $this->Cell(20,6, $a1_t3, 1, 0, 'C');
            $this->Cell(20,6, $b1_t3, 1, 0, 'C');
            $this->Cell(20,6, $c1_t3, 1, 0, 'C');
            $this->Cell(20,6, $d1_t3, 1, 1, 'C');
            
            $this->Cell(10,6, '2', 1, 0, 'C');
            $this->Cell(40,6, $d_c2_t3, 1, 0, 'C');
            $this->Cell(20,6, $a2_t3, 1, 0, 'C');
            $this->Cell(20,6, $b2_t3, 1, 0, 'C');
            $this->Cell(20,6, $c2_t3, 1, 0, 'C');
            $this->Cell(20,6, $d2_t3, 1, 1, 'C');
            
            $this->Cell(10,6, '3', 1, 0, 'C');
            $this->Cell(40,6, $d_c3_t3, 1, 0, 'C');
            $this->Cell(20,6, $a3_t3, 1, 0, 'C');
            $this->Cell(20,6, $b3_t3, 1, 0, 'C');
            $this->Cell(20,6, $c3_t3, 1, 0, 'C');
            $this->Cell(20,6, $d3_t3, 1, 1, 'C');
            
            $this->Cell(10,6, '4', 1, 0, 'C');
            $this->Cell(40,6, $d_c4_t3, 1, 0, 'C');
            $this->Cell(20,6, $a4_t3, 1, 0, 'C');
            $this->Cell(20,6, $b4_t3, 1, 0, 'C');
            $this->Cell(20,6, $c4_t3, 1, 0, 'C');
            $this->Cell(20,6, $d4_t3, 1, 1, 'C');
            $this->Ln();
    }
    
    
    function ImprovedTable4($header4, 
    $d_c1_t4, $d_c2_t4, $d_c3_t4, $d_c4_t4,
    $a1_t4, $a2_t4, $a3_t4, $a4_t4, 
    $b1_t4, $b2_t4, $b3_t4, $b4_t4,
    $c1_t4, $c2_t4, $c3_t4, $c4_t4,
    $d1_t4, $d2_t4, $d3_t4, $d4_t4) {
    
        $w = array(10, 40, 20, 20, 20, 20);
        for($i=0;$i<count($header4);$i++)
            $this->Cell($w[$i],7,$header4[$i],1,0,'C');
            $this->Ln();

            $this->Cell(10,6, '1', 1, 0, 'C');
            $this->Cell(40,6, $d_c1_t4, 1, 0, 'C');
            $this->Cell(20,6, $a1_t4, 1, 0, 'C');
            $this->Cell(20,6, $b1_t4, 1, 0, 'C');
            $this->Cell(20,6, $c1_t4, 1, 0, 'C');
            $this->Cell(20,6, $d1_t4, 1, 1, 'C');
            
            $this->Cell(10,6, '2', 1, 0, 'C');
            $this->Cell(40,6, $d_c2_t4, 1, 0, 'C');
            $this->Cell(20,6, $a2_t4, 1, 0, 'C');
            $this->Cell(20,6, $b2_t4, 1, 0, 'C');
            $this->Cell(20,6, $c2_t4, 1, 0, 'C');
            $this->Cell(20,6, $d2_t4, 1, 1, 'C');
            
            $this->Cell(10,6, '3', 1, 0, 'C');
            $this->Cell(40,6, $d_c3_t4, 1, 0, 'C');
            $this->Cell(20,6, $a3_t4, 1, 0, 'C');
            $this->Cell(20,6, $b3_t4, 1, 0, 'C');
            $this->Cell(20,6, $c3_t4, 1, 0, 'C');
            $this->Cell(20,6, $d3_t4, 1, 1, 'C');
            
            $this->Cell(10,6, '4', 1, 0, 'C');
            $this->Cell(40,6, $d_c4_t4, 1, 0, 'C');
            $this->Cell(20,6, $a4_t4, 1, 0, 'C');
            $this->Cell(20,6, $b4_t4, 1, 0, 'C');
            $this->Cell(20,6, $c4_t4, 1, 0, 'C');
            $this->Cell(20,6, $d4_t4, 1, 1, 'C');
            $this->Ln();
    }
    
    
    function ImprovedTable5($header5, 
    $d_c1_t5, $d_c2_t5, $d_c3_t5, $d_c4_t5,
    $p_b1_t5, $p_b2_t5, $p_b3_t5, $p_b4_t5,
    $a1_t5, $a2_t5, $a3_t5, $a4_t5,
    $b1_t5, $b2_t5, $b3_t5, $b4_t5,
    $c1_t5, $c2_t5, $c3_t5, $c4_t5,
    $d1_t5, $d2_t5, $d3_t5, $d4_t5) {
    
        $w = array(10, 40, 35, 20, 20, 20, 20);
        for($i=0;$i<count($header5);$i++)
            $this->Cell($w[$i],7,$header5[$i],1,0,'C');
            $this->Ln();

            $this->Cell(10,6, '1', 1, 0, 'C');
            $this->Cell(40,6, $d_c1_t5, 1, 0, 'C');
            $this->Cell(35,6, $p_b1_t5, 1, 0, 'C');
            $this->Cell(20,6, $a1_t5, 1, 0, 'C');
            $this->Cell(20,6, $b1_t5, 1, 0, 'C');
            $this->Cell(20,6, $c1_t5, 1, 0, 'C');
            $this->Cell(20,6, $d1_t5, 1, 1, 'C');
            
            $this->Cell(10,6, '2', 1, 0, 'C');
            $this->Cell(40,6, $d_c2_t5, 1, 0, 'C');
            $this->Cell(35,6, $p_b2_t5, 1, 0, 'C');
            $this->Cell(20,6, $a2_t5, 1, 0, 'C');
            $this->Cell(20,6, $b2_t5, 1, 0, 'C');
            $this->Cell(20,6, $c2_t5, 1, 0, 'C');
            $this->Cell(20,6, $d2_t5, 1, 1, 'C');
            
            $this->Cell(10,6, '3', 1, 0, 'C');
            $this->Cell(40,6, $d_c3_t5, 1, 0, 'C');
            $this->Cell(35,6, $p_b3_t5, 1, 0, 'C');
            $this->Cell(20,6, $a3_t5, 1, 0, 'C');
            $this->Cell(20,6, $b3_t5, 1, 0, 'C');
            $this->Cell(20,6, $c3_t5, 1, 0, 'C');
            $this->Cell(20,6, $d3_t5, 1, 1, 'C');
            
            $this->Cell(10,6, '4', 1, 0, 'C');
            $this->Cell(40,6, $d_c4_t5, 1, 0, 'C');
            $this->Cell(35,6, $p_b4_t5, 1, 0, 'C');
            $this->Cell(20,6, $a4_t5, 1, 0, 'C');
            $this->Cell(20,6, $b4_t5, 1, 0, 'C');
            $this->Cell(20,6, $c4_t5, 1, 0, 'C');
            $this->Cell(20,6, $d4_t5, 1, 1, 'C');
            $this->Ln();
    }


    function ImprovedTable6($header6, 
    $d_c1_t6, $d_c2_t6, $d_c3_t6, $d_c4_t6,
    $a1_t6, $a2_t6, $a3_t6, $a4_t6, 
    $b1_t6, $b2_t6, $b3_t6, $b4_t6,
    $c1_t6, $c2_t6, $c3_t6, $c4_t6,
    $d1_t6, $d2_t6, $d3_t6, $d4_t6) {
    
        $w = array(10, 40, 20, 20, 20, 20);
        for($i=0;$i<count($header6);$i++)
            $this->Cell($w[$i],7,$header6[$i],1,0,'C');
            $this->Ln();

            $this->Cell(10,6, '1', 1, 0, 'C');
            $this->Cell(40,6, $d_c1_t6, 1, 0, 'C');
            $this->Cell(20,6, $a1_t6, 1, 0, 'C');
            $this->Cell(20,6, $b1_t6, 1, 0, 'C');
            $this->Cell(20,6, $c1_t6, 1, 0, 'C');
            $this->Cell(20,6, $d1_t6, 1, 1, 'C');
            
            $this->Cell(10,6, '2', 1, 0, 'C');
            $this->Cell(40,6, $d_c2_t6, 1, 0, 'C');
            $this->Cell(20,6, $a2_t6, 1, 0, 'C');
            $this->Cell(20,6, $b2_t6, 1, 0, 'C');
            $this->Cell(20,6, $c2_t6, 1, 0, 'C');
            $this->Cell(20,6, $d2_t6, 1, 1, 'C');
            
            $this->Cell(10,6, '3', 1, 0, 'C');
            $this->Cell(40,6, $d_c3_t6, 1, 0, 'C');
            $this->Cell(20,6, $a3_t6, 1, 0, 'C');
            $this->Cell(20,6, $b3_t6, 1, 0, 'C');
            $this->Cell(20,6, $c3_t6, 1, 0, 'C');
            $this->Cell(20,6, $d3_t6, 1, 1, 'C');
            
            $this->Cell(10,6, '4', 1, 0, 'C');
            $this->Cell(40,6, $d_c4_t6, 1, 0, 'C');
            $this->Cell(20,6, $a4_t6, 1, 0, 'C');
            $this->Cell(20,6, $b4_t6, 1, 0, 'C');
            $this->Cell(20,6, $c4_t6, 1, 0, 'C');
            $this->Cell(20,6, $d4_t6, 1, 1, 'C');
            $this->Ln();
        }
        
    function ImprovedTable7($header7, $diam_foro, $mod_quad) {

        $w = array(10, 40, 40);
        for($i=0;$i<count($header7);$i++)
        $this->Cell($w[$i],7,$header7[$i],1,0,'C');
        $this->Ln();
        $this->Cell(10,6, '1', 1, 0, 'C');
        $this->Cell(40,6, $diam_foro, 1, 0, 'C');
        $this->Cell(40,6, $mod_quad, 1, 0, 'C');
        $this->Ln();
        
    }
    function Note($nota){
        $this->MultiCell(190,6, $nota, 1, 'L');
    }



}
   


$pdf = new PDF();
// Column headings
$header = array('N','Diametro campana', 'Punto di battuta', 'A', 'B', 'C', 'Slancio/Contropeso');
$header2 = array('N','Diametro campana', 'Modello', 'A', 'B', 'C', 'Slancio/Contropeso');
$header3 = array('N','Diametro campana', 'A', 'B', 'C', 'D');
$header4 = array('N','Diametro campana', 'A', 'B', 'C', 'D');
$header5 = array('N','Diametro campana', 'Punto di battuta', 'A', 'B', 'C', 'D');
$header6 = array('N','Diametro campana', 'A', 'B', 'C', 'D');
$header7 = array('N','Diametro foro', 'Modello quadrante');
// Data loading
$pdf->AliasNbPages();
// $data = $pdf->LoadData('countries.txt');
$pdf->SetFont('Arial','',12);
$pdf->AddPage();
$pdf->Cell(0,10,'Misurazione 1',0,1);
$pdf->Image('../../assets/images/img_tab_1.png',50,5,100,0, 'PNG');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->ImprovedTable($header,
$d_c1_t1, $d_c2_t1, $d_c3_t1, $d_c4_t1, $d_c5_t1, $d_c6_t1, $d_c7_t1, $d_c8_t1,
$p_b1_t1, $p_b2_t1, $p_b3_t1, $p_b4_t1, $p_b5_t1, $p_b6_t1, $p_b7_t1, $p_b8_t1,
$a1_t1, $a2_t1, $a3_t1, $a4_t1, $a5_t1, $a6_t1, $a7_t1, $a8_t1,
$b1_t1, $b2_t1, $b3_t1, $b4_t1, $b5_t1, $b6_t1, $b7_t1, $b8_t1,
$c1_t1, $c2_t1, $c3_t1, $c4_t1, $c5_t1, $c6_t1, $c7_t1, $c8_t1,
$r1_t1, $r2_t1, $r3_t1, $r4_t1, $r5_t1, $r6_t1, $r7_t1, $r8_t1);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0,10,'Misurazione 2',0,1);
$pdf->Image('../../assets/images/img_tab_2.png',60,160,100,0, 'PNG');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->ImprovedTable2($header2, 
$d_c1_t2, $d_c2_t2, $d_c3_t2, $d_c4_t2,
$m1_t2, $m2_t2, $m3_t2, $m4_t2, 
$a1_t2, $a2_t2, $a3_t2, $a4_t2, 
$b1_t2, $b2_t2, $b3_t2, $b4_t2,
$c1_t2, $c2_t2, $c3_t2, $c4_t2,
$r1_t2, $r2_t2, $r3_t2, $r4_t2);


$pdf->AddPage();
$pdf->Cell(0,10,'Misurazione 3',0,1);
$pdf->Image('../../assets/images/img_tab_3.png',60,5,100,0, 'PNG');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->ImprovedTable3($header3,
$d_c1_t3, $d_c2_t3, $d_c3_t3, $d_c4_t3,
$a1_t3, $a2_t3, $a3_t3, $a4_t3,
$b1_t3, $b2_t3, $b3_t3, $b4_t3,
$c1_t3, $c2_t3, $c3_t3, $c4_t3,
$d1_t3, $d2_t3, $d3_t3, $d4_t3
);
$pdf->Cell(0,10,'Misurazione 4',0,1);
$pdf->Image('../../assets/images/img_tab_4.png',30,155,150,0, 'PNG');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->ImprovedTable4($header4, 
    $d_c1_t4, $d_c2_t4, $d_c3_t4, $d_c4_t4,
    $a1_t4, $a2_t4, $a3_t4, $a4_t4, 
    $b1_t4, $b2_t4, $b3_t4, $b4_t4,
    $c1_t4, $c2_t4, $c3_t4, $c4_t4,
    $d1_t4, $d2_t4, $d3_t4, $d4_t4
);
$pdf->AddPage();
$pdf->Cell(0,10,'Misurazione 5',0,1);
$pdf->Image('../../assets/images/img_tab_5.png',50,5,80,0, 'PNG');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->ImprovedTable5($header5, 
$d_c1_t5, $d_c2_t5, $d_c3_t5, $d_c4_t5,
$p_b1_t5, $p_b2_t5, $p_b3_t5, $p_b4_t5,
$a1_t5, $a2_t5, $a3_t5, $a4_t5,
$b1_t5, $b2_t5, $b3_t5, $b4_t5,
$c1_t5, $c2_t5, $c3_t5, $c4_t5,
$d1_t5, $d2_t5, $d3_t5, $d4_t5);
$pdf->Cell(0,10,'Misurazione 6',0,1);
$pdf->Image('../../assets/images/img_tab_6.png',50,100,80,0, 'PNG');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->ImprovedTable6($header6,
$d_c1_t6, $d_c2_t6, $d_c3_t6, $d_c4_t6,
$a1_t6, $a2_t6, $a3_t6, $a4_t6,
$b1_t6, $b2_t6, $b3_t6, $b4_t6,
$c1_t6, $c2_t6, $c3_t6, $c4_t6,
$d1_t6, $d2_t6, $d3_t6, $d4_t6
);
$pdf->Cell(0,10,'Misurazione 7 Quadrante',0,1);
$pdf->ImprovedTable7($header7,$diam_foro, $mod_quad);

$pdf->Cell(0,10,'Note:',0,1);
foreach($note as $nota) {
    $pdf->Note($nota['Note']);
    }

$pdf->Output();

?>