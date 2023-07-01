<?php
error_reporting(E_ALL ^ E_NOTICE);
	require '../lib/pdf/fpdf.php';

	class PDF extends FPDF{

		function Header(){
			$this->image('../img/banner1.png', 140, 10, 60);
			$this->SetFont('Arial','B','15');
			$this->Cell(30);
			$this->SetTextColor(20,50,150);
			$this->Cell(115,15, 'CREDITO HONDA',0,0,'C');
			$this->Ln(15);
			$this->Cell(170,6, 'AGROMAR',0,1,'C');

			$this->Cell(170,6, 'Calle Principal Rio Dulce',0,0,'C');
			$this->Ln(5);
			$this->Cell(170,6, 'Telefono: 7930-5140',0,0,'C');

			$this->Ln(5);
		}

		function Footer(){
			$this->SetY(-15);
			$this->SetFont('Arial','I','8');
			$this->Cell(0,10, '',0,0,'C');
		}
		
	}

?>