<?
//print $p;

function indirizzo_ip()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (
		!empty($_SERVER['HTTP_X_FORWARDED_FOR'])
	) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function is_date($date, $format = 'd/m/Y H:i:s')
{
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}

function encode($x)
{
	return base64_encode($x);
}

function decode($x)
{
	return base64_decode($x);
}

function strToHex($string)
{
	$hex = '';
	for ($i = 0; $i < strlen($string); $i++) {
		$hex .= dechex(ord($string[$i]));
	}
	return $hex;
}

function pulisci_sql($x, $tag_html = false)
{
	$x = str_replace("€", "&euro;", $x);
	$x = trim(str_replace("'", "''", utf8_decode($x)));
	//$x = iconv('UTF-8', 'ISO-8859-1//IGNORE', $x);
	//$x = mb_convert_encoding($x, 'UTF-8', 'ISO-8859-1');

	//$x = preg_replace("/([\xC2\xC3])([\x80-\xBF])/e",
	//            "chr(ord('\\1')<<6&0xC0|ord('\\2')&0x3F)",
	//             $x);

	return $x;
}

function pulisci_cifra($x)
{
	$x = str_replace(",", ".", $x);
	if (!is_numeric($x)) {
		$x = 0;
	}
	return $x;
}

function pulisci_da_rs($x)
{
	$x = cp1252_to_utf8(trim($x));
	//$x = trim(iconv("UTF-8", "ISO-8859-1//IGNORE", $x));
	return $x;
}

function pulisci_numero_da_rs($x)
{
	if (!is_numeric($x)) {
		$x = 0;
	}
	return $x;
}

function pulisci_caratteri($x)
{
	//$x = str_replace("-", "", $x);
	//return $x;
	return preg_replace("/[^\w]/", "", $x);
}

function pulisci_caratteri_trattino($x)
{
	//$x = str_replace("-", "", $x);
	//return $x;
	return preg_replace("/[^\w]-./", "", $x);
}

function pulisci_apici_doppi($x)
{
	$x = str_replace('"', "", $x);
	//$x = str_replace("'", "\'", $x);
	return $x;
}

function categoria_statistica_lettera_numero($x, $y)
{
	return $x . substr("0" . $y, -2);
}

function ritorna_mese($x)
{
	global $vett_mesi;
	return substr("0" . $x, -2) . "-" . $vett_mesi[$x];
}

function ritorna_mese_lungo($x, $full = -1)
{
	$x = (int)$x;
	$vett_mesi = array("", "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");
	if ($full == -1) {
		$mese = $vett_mesi[$x];
	} else {
		$mese = substr($vett_mesi[$x], 0, $full);
	}
	return $mese;
}

function numero_giorni($x)
{
	$vett_ultimo_giorno_mese = array("", 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	if ($x == 2 && date("Y", time()) / 4 == 0) {
		$x = 29;
	}
	$x = (int)$x;
	return $vett_ultimo_giorno_mese[$x];
}

function data_italiana($x)
{
	if (strlen($x) > 0) {
		$x = substr($x, 8, 2) . "/" . substr($x, 5, 2) . "/" . substr($x, 0, 4) . " " . substr($x, 11, 2) . ":" . substr($x, 14, 2);
	}
	return $x;
}

function data_italiana_no_ora($x)
{
	if (strlen($x) > 0) {
		if (strlen($x) > 0) {
			$x = substr($x, 8, 2) . "/" . substr($x, 5, 2) . "/" . substr($x, 0, 4);
		} else {
			$x = "-";
		}
	}
	return $x;
}

function data_italiana_separata($g, $m, $a)
{
	$x = substr("0" . $g, -2) . "-" . substr("0" . $m, -2) . "-" . substr("0000" . $a, -4);
	return $x;
}

function giorno_settimana($a, $m, $g)
{
	$giorno = date('w', strtotime($a . "-" . $m . "-" . $g));
	$festivita = array("1/1", "6/1", "25/4", "1/5", "2/6", "15/8", "1/11", "25/12", "26/12");
	if (in_array($g . "/" . $m, $festivita) == true) {
		$giorno = 0;
	}
	return $giorno;
}

function cp1252_to_utf8($str)
{
	$cp1252_map = array(
		"\xc2\x80" => "\xe2\x82\xac", /* EURO SIGN */
		"\xc2\x82" => "\xe2\x80\x9a", /* SINGLE LOW-9 QUOTATION MARK */
		"\xc2\x83" => "\xc6\x92",     /* LATIN SMALL LETTER F WITH HOOK */
		"\xc2\x84" => "\xe2\x80\x9e", /* DOUBLE LOW-9 QUOTATION MARK */
		"\xc2\x85" => "\xe2\x80\xa6", /* HORIZONTAL ELLIPSIS */
		"\xc2\x86" => "\xe2\x80\xa0", /* DAGGER */
		"\xc2\x87" => "\xe2\x80\xa1", /* DOUBLE DAGGER */
		"\xc2\x88" => "\xcb\x86",     /* MODIFIER LETTER CIRCUMFLEX ACCENT */
		"\xc2\x89" => "\xe2\x80\xb0", /* PER MILLE SIGN */
		"\xc2\x8a" => "\xc5\xa0",     /* LATIN CAPITAL LETTER S WITH CARON */
		"\xc2\x8b" => "\xe2\x80\xb9", /* SINGLE LEFT-POINTING ANGLE QUOTATION */
		"\xc2\x8c" => "\xc5\x92",     /* LATIN CAPITAL LIGATURE OE */
		"\xc2\x8e" => "\xc5\xbd",     /* LATIN CAPITAL LETTER Z WITH CARON */
		"\xc2\x91" => "\xe2\x80\x98", /* LEFT SINGLE QUOTATION MARK */
		"\xc2\x92" => "\xe2\x80\x99", /* RIGHT SINGLE QUOTATION MARK */
		"\xc2\x93" => "\xe2\x80\x9c", /* LEFT DOUBLE QUOTATION MARK */
		"\xc2\x94" => "\xe2\x80\x9d", /* RIGHT DOUBLE QUOTATION MARK */
		"\xc2\x95" => "\xe2\x80\xa2", /* BULLET */
		"\xc2\x96" => "\xe2\x80\x93", /* EN DASH */
		"\xc2\x97" => "\xe2\x80\x94", /* EM DASH */

		"\xc2\x98" => "\xcb\x9c",     /* SMALL TILDE */
		"\xc2\x99" => "\xe2\x84\xa2", /* TRADE MARK SIGN */
		"\xc2\x9a" => "\xc5\xa1",     /* LATIN SMALL LETTER S WITH CARON */
		"\xc2\x9b" => "\xe2\x80\xba", /* SINGLE RIGHT-POINTING ANGLE QUOTATION*/
		"\xc2\x9c" => "\xc5\x93",     /* LATIN SMALL LIGATURE OE */
		"\xc2\x9e" => "\xc5\xbe",     /* LATIN SMALL LETTER Z WITH CARON */
		"\xc2\x9f" => "\xc5\xb8"      /* LATIN CAPITAL LETTER Y WITH DIAERESIS*/
	);

	return  strtr(utf8_encode($str), $cp1252_map);
}



function calcola_percentuale_sconto($sc)
{
	$sc = str_replace("+++", "+", $sc);
	$sc = str_replace("++", "+", $sc);
	if (substr($sc, -1) == "+") {
		$sc = substr($sc, 0, strlen($sc) - 1);
	}
	//print $sc."<br>";

	$c = explode("+", $sc);

	$valore = 100;
	for ($i = 0; $i < count($c); $i++) {
		//print $i."<br>".$c[$i];
		$c[$i] = pulisci_cifra($c[$i]);
		if (is_numeric($c[$i])) {
			$valore = $valore - ($valore * ($c[$i] / 100));
		}
	}
	//print "<br>".(100-$valore);
	return (100 - $valore);
}


function ritorna_id($sql)
{
	global $conn;

	$id = 0;
	$result = mysqli_query($conn, $sql);
	while (mysqli_fetch_row($result)) {
		$id = pulisci_numero_da_rs(mysqli_fetch_field($result, "ID"));
	};
	odbc_free_result($result);

	return $id;
}

function attivo_icona($x)
{
	switch ($x) {
		case 0:
			return '<i class="fa fa-times text-danger"></i>';
			break;
		case 1:
			return '<i class="fa fa-check text-success"></i>';
			break;
	}
}

function data_sql($data, $sep = "-", $apice = "'")
{
	if (strlen($data)) {
		if (is_date($data, "d/m/Y")) {
			$array = explode("-", str_replace("/", "-", $data));
			$data = $apice . $array[2] . $sep . $array[1] . $sep . $array[0] . $apice;
		} else {
			$data = "NULL";
		}
	} else {
		$data = "NULL";
	}
	return $data;
}

function isn($x)
{
	if (isset($x)) {
	} else {
		$x = "";
	}
	$x = trim($x);
	return $x;
}

function trasforma_data($data): string
{
	$data_pulita = substr($data, 4, 4) . substr($data, 2, 2) . substr($data, 0, 2);
	return $data_pulita;
}
