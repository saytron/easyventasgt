<?php
error_reporting(E_ALL ^ E_NOTICE);
	require '../lib/pdf/fpdf.php';

	class PDF extends FPDF{

		function Header(){
			
			$this->SetFont('Arial','B','15');
			$this->Cell(30);
			$this->Cell(105,15, '',0,0,'C');
            $this->Ln(8);
            $this->SetTextColor(20,20,75);
			
			
			$this->Ln(10);
		

			$this->Ln(1);
		}

		function Footer(){
			$this->SetY(-15);
			$this->SetFont('Arial','I','8');
			$this->Cell(0,10, '',0,0,'C');
		}
		
	}

?>