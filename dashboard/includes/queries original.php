<?php

require_once __DIR__ . '/db.php';

function getOrdineByOF(string $codice_of, int $serie)
{
	$query = "	USE srl_rp;
					SELECT  CodArticolo as codice, 
							DescrizioneArticolo as descrizione, 
							Quantita as quantita,
							qtacheck,
							ISNULL(id, 0) as id,
							tipodoc, 
							seriedoc, 
							NumeroDoc, 
							NprRiga, 
							QTACHECK,
							GETDATE() as ident
					FROM vOF 
					where numeroDoc = $codice_of and seriedoc=$serie
					ORDER BY CodArticolo";
	return DB_QUERY($query);
}

function getOrdineByOC(string $codice_of, int $serie)
{
	$query = "	USE srl_rp;
					SELECT  CodArticolo as codice, 
							DescrizioneArticolo as descrizione, 
							Quantita as quantita,
							qtacheck,
							ISNULL(id, 0) as id,
							tipodoc, 
							seriedoc, 
							NumeroDoc, 
							NprRiga, 
							QTACHECK,
							GETDATE() as ident
					FROM vOF 
					where numeroDoc = $codice_of and seriedoc=$serie
					ORDER BY CodArticolo";
	return DB_QUERY($query);
}

function updateRiga(string $codice, float $quantita, int $id, $tipodoc, $seriedoc, $NumeroDoc, $NprRiga, $codice_univoco)
{
	if ($id == 0) {
		$query = "insert into qtacheck (CSG_DOC, NGB_SR_DOC, NGL_DOC, NPR_RIGA, QTA_CHECK, IDENTIFICATIVO) values ('$tipodoc', $seriedoc, $NumeroDoc, '$NprRiga', $quantita, '$codice_univoco')";
	} else {
		$query = "update qtacheck set IDENTIFICATIVO = '$codice_univoco', QTA_CHECK  = isnull(QTA_CHECK, 0) + $quantita where npr_riga = (select top 1 NprRiga  from srl_rp.dbo.vOF where codarticolo = '$codice')";
	}
	return DB_QUERY($query);
}

function closeUpdate(string $codice)
{
	$query = "INSERT INTO V_SPOSTAMENTI (trav, art, data ) VALUES  (0, '$codice', GETDATE())";
	return DB_QUERY($query);
}

function checkItem(string $codice)
{

	$codice = str_replace("'", "-", $codice);

	$query = " USE srl_rp;
					SELECT  
							arti.cky_Art as codice, 

							cds_art AS descrizione,

1 AS qta
					FROM SRL_ARTI arti
					left join SRL_ALIAS alias ON arti.cky_Art=alias.cky_Art

					where arti.CKY_ART LIKE '%$codice%' OR (rtrim(CDS_ART)+ltrim(cds_aggiun_art)) LIKE  '%$codice%' OR CSG_ART_ALT LIKE  '%$codice%' OR alias.CSG_ART_ALIAS LIKE '%$codice%'
					GROUP BY arti.cky_Art, arti.CDS_ART					
					ORDER BY arti.CKY_ART";

	//rtrim( replace( replace(replace( rtrim(CDS_ART) , '\"' , '') , '\' , '') , '°' , '') )  as descrizione, 

	/*$query = "USE srl_rp;       SELECT  CKY_ART as codice,         replace( CDS_ART , '\"' , '') as descrizione,          1 as qta       FROM SRL_ARTI       
					where (CKY_ART LIKE '%30%' OR (rtrim(CDS_ART)+ltrim(cds_aggiun_art)) LIKE  '%30%' OR CSG_ART_ALT LIKE  '%30%') 
					
					and cky_art>='STEL-03023'
					and cky_art<='STEL-033T040'
					
					and (rtrim(CDS_ART)+ltrim(cds_aggiun_art) ) not like '%/%' 
					and (rtrim(CDS_ART)+ltrim(cds_aggiun_art) ) not like '%*%' 
					
					
					ORDER BY CKY_ART";*/


	return DB_QUERY($query);
}

function checkCodArt(string $codice_articolo)
{
	$query = "SELECT codean, articolo from [Change].[dbo].[WEB_CodiciArticoliMultipli] where articolo = '$codice_articolo'";
	return DB_QUERY_SELECT($query);
}

function checkCodEan(string $codice_ean)
{
	$query = "SELECT articolo from [Change].[dbo].[WEB_CodiciArticoliMultipli] where codean = '$codice_ean'";
	return DB_QUERY_SELECT($query);
}

function checkQta(string $codice_lotto, string $codice_articolo, string $id_arrivomerce)
{
	$codice_lotto = str_replace('"', '', $codice_lotto);
	$codice_articolo = str_replace('"', '', $codice_articolo);
	$query = "SELECT SUM(qta) AS qta FROM [Change].[dbo].[ListaPrelievo]
	WHERE lotto = '$codice_lotto' AND cod_articolo = '$codice_articolo' AND id_arrivomerce = '$id_arrivomerce' AND trav = 0";
	return DB_QUERY_SELECT($query);
}

function checkLotto(string $lotto)
{
	$query = "SELECT articolo, descrizione_articolo, lotto, data_scadenza from [Change].[dbo].[WEB_GiacenzaLotti] where lotto = '$lotto'";
	return DB_QUERY_SELECT($query);
}

function checkQR($magazzino, $codice_articolo, $lotto)
{
	if ($magazzino == "mag1") {
		$query = "SELECT articolo, descrizione_articolo, um, lotto, data_scadenza, [1] as qta FROM [Change].[dbo].[WEB_GiacenzaLotti] WHERE articolo = '$codice_articolo' AND lotto = '$lotto' AND [1] > 0";
	} else {
		$query = "SELECT articolo, descrizione_articolo, um, lotto, data_scadenza, [3] as qta FROM [Change].[dbo].[WEB_GiacenzaLotti] WHERE articolo = '$codice_articolo' AND lotto = '$lotto' AND [3] > 0";
	}

	return DB_QUERY_SELECT($query);
}

function checkGiacenzaMag(string $magazzino, string $articolo)
{
	if ($magazzino == "mag1") {
		$query = "SELECT descrizione_articolo, um, lotto, data_scadenza, [1] as qta from [Change].[dbo].[WEB_GiacenzaLotti] where articolo = '$articolo' AND [1] > 0";
	} else {
		$query = "SELECT descrizione_articolo, um, lotto, data_scadenza, [3] as qta from [Change].[dbo].[WEB_GiacenzaLotti] where articolo = '$articolo' AND [3] > 0";
	}
	return DB_QUERY_SELECT($query);
}

function insertHeader(string $identif, string $codice_forn)
{
	$query = "If Not Exists(
		SELECT top(1) MAX(ID_ARRIVOMERCE) as last_id FROM [Change].[dbo].[ListaPrelievo] WHERE day(DATA) = day(GETDATE())
		)
  Begin
  SELECT top(1) MAX(ID_ARRIVOMERCE) as last_id FROM [Change].[dbo].[ListaPrelievo]
  End";
	$query = "If Not Exists(select * from arrivomerce where trav=2 and identif='$identif') 
			Begin 
				INSERT INTO ArrivoMerce (IDENTIF,CKY_CNT) VALUES ('$identif','$codice_forn') 
			End";
	DB_QUERY($query);

	$query = "select id from arrivomerce where trav=2 and identif='$identif'";
	return DB_SELECT_ONE($query);
}

function insertItem(string $codice_articolo, string $codice_lotto, float $qta, int $id_arrivomerce, int $id_operatore)
{
	$codice_lotto = str_replace("'", "''", $codice_lotto);
	$codice_articolo = str_replace("'", "''", $codice_articolo);
	$query = "INSERT INTO [Change].[dbo].[ListaPrelievo] (COD_ARTICOLO, LOTTO, QTA, ID_ARRIVOMERCE, ID_OPERATORE, TRAV, DATA) 
	VALUES ('$codice_articolo', '$codice_lotto', $qta, $id_arrivomerce, $id_operatore, 0, GETDATE())";
	return DB_QUERY($query);
}


function getOFbyIdentif(int $id)
{
	$id = str_replace('"', "", $id);
	$query = "SELECT ListaPrelievo.cod_articolo, ListaPrelievo.lotto, SUM(ListaPrelievo.qta) AS qta, WEB_GiacenzaLotti.DESCRIZIONE_ARTICOLO AS descrizione_articolo
	FROM [Change].[dbo].[ListaPrelievo] LEFT JOIN [Change].[dbo].[WEB_GiacenzaLotti] 
	ON ListaPrelievo.COD_ARTICOLO = WEB_GiacenzaLotti.ARTICOLO AND ListaPrelievo.Lotto = WEB_GiacenzaLotti.Lotto WHERE ListaPrelievo.id_arrivomerce = $id AND ListaPrelievo.TRAV = 0
	GROUP BY ListaPrelievo.cod_articolo, ListaPrelievo.lotto, WEB_GiacenzaLotti.DESCRIZIONE_ARTICOLO";
	return DB_QUERY_SELECT($query);
}

function deleteItem(int $idarrivomerce, string $articolo)
{
	$articolo = str_replace("'", "''", $articolo);
	$query = "DELETE FROM ArrivoMerce_Righe WHERE ID_ARRIVOMERCE=$idarrivomerce AND CKY_ART='$articolo'";
	return DB_QUERY($query);
}

function closeOFbyIdentif(int $idarrivomerce)
// function closeOFbyIdentif(int $idarrivomerce, string $identif)
{
	$query = "UPDATE [Change].[dbo].[ListaPrelievo] SET TRAV=1 WHERE ID_ARRIVOMERCE = $idarrivomerce";
	DB_QUERY($query);

	// $query = "INSERT INTO V_SPOSTAMENTI (trav, art, data , ub) VALUES  (0, '$identif', GETDATE(), $idarrivomerce)";
	// return DB_QUERY($query);
}
