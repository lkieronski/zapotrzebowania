<?php
require('assets/fpdf/fpdf.php');
require('assets/conf.php');
require('assets/classes/kategoria.class.php');
require('assets/classes/produkt.class.php');
require('assets/classes/wydzial.class.php');
require('assets/classes/zapotrzebowanie.class.php');
require('assets/classes/zapotrzebowanie_nr.class.php');
require('assets/classes/zapotrzebowanie_info.class.php');

if (isset($_GET['id'])){

	$id = ($_GET['id']);
	$zinfo = new Zapotrzebowanie_info($conn);
	$zi = $zinfo->zwroc_zapotrzebowanie_info_po_id($id);
	
	$zap = new Zapotrzebowanie($conn);
	$zapotrzebowania = $zap->zwroc_wszystkie_po_zapotrzebowanie_nr($zi->zapotrzebowanie_nr);
	
	$pdf = new FPDF();
	$pdf->AddFont('arialpl','','arialpl.php');
	$pdf->AddPage();
	
	//nagłówek
		$pdf->SetFont('arialpl','',8);
		$naglowek = "Załącznik nr ".$zi->szacowany_koszt."\ndo regulaminu udzielania zamówień publicznych, których\nwartość netto nie przekracza kwoty 30.000 euro";
		$naglowek = iconv('UTF-8','ISO8859-2', $naglowek);
		$pdf->MultiCell(0,3,$naglowek,0,'R');
	
		$pdf->ln(30);
	
	//body	
		$pdf->SetFont('arialpl','',10);
		switch($zi->szacowany_koszt){
			case 1:
			break;

			case 2:
				$temat = "Wniosek o udzielenie zamówienia-zapotrzebowanie o wartości netto\nrównej lub wyższej 100,00 euro, a nie przekraczającej 1000 euro.";
			break;

			case 3:
				$temat = "Wniosek o udzielenie zamówienia-zapotrzebowanie o wartości netto\nrównej lub wyższej niż 1.000,00 euro, a nie przekraczającej 30.000,00 euro ";
			break;
		}
		$temat = iconv('UTF-8','ISO8859-2', $temat);
		$pdf->MultiCell(0,4,$temat,0,'C');
	
		$pdf->ln(30);
	
		$opis = "1. Opis przedmiotu zamówienia:\n";

		foreach($zapotrzebowania as $z){
			$opis .= "\n     $z->ilosc x $z->produkt";
		}
		$opis = iconv('UTF-8','ISO8859-2', $opis);
		$pdf->MultiCell(0,4,$opis,0,'L');
	
		$pdf->ln(10);
		
		$termin = "2. Termin realizacji zamówienia:\n";
		$termin .= "\n     $zi->termin_realizacji";
		$termin = iconv('UTF-8','ISO8859-2', $termin);
		$pdf->MultiCell(0,4,$termin,0,'L');
	
		$pdf->ln(10);
	
		$pozostale = "3. Pozostałe informacje:";
		$pozostale = iconv('UTF-8','ISO8859-2', $pozostale);
		$pdf->MultiCell(0,4,$pozostale,0,'L');
	
		$pdf->Cell(10,1,'');
		$poz = "\n$zi->pozostale_informacje";
		$poz = iconv('UTF-8','ISO8859-2', $poz);
		$poz = str_replace("
		","\n", $poz);
		$pdf->MultiCell(0,4,$poz,0,'L');
	
		$pdf->ln(10);
		$sporzadzil = "Wniosek sporządził/ła:\n $zi->skladajacy";
		$sporzadzil = iconv('UTF-8','ISO8859-2', $sporzadzil);
		$pdf->MultiCell(0,4,$sporzadzil,0,'L');
	
	
		$pdf->ln(20);
	
		$pdf->Cell(130,1,'');
		$pdf->SetFont('arialpl','',8);
		$s = "...............................................................\n(data i podpis Naczelnika lub osoby zatrudnionej na samodzielnym stanowisku)";
		$s = iconv('UTF-8','ISO8859-2', $s);
		$pdf->MultiCell(0,4,$s,0,'L');
	
		$pdf->ln(10);
	
		$p = "................................................................\n(akceptacja Starosty)";
		$p = iconv('UTF-8','ISO8859-2', $p);
		$pdf->MultiCell(60,4,$p,0,'L');
	
	$pdf->Output();

}
?>
