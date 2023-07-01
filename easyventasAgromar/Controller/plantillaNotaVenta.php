<?php
error_reporting(E_ALL ^ E_NOTICE);
	require '../../libs/pdf/fpdf.php';

	class PDF extends FPDF{

		function Header(){
			$this->image('../img/banner1.png', 141, 15, 60);
			$this->SetFont('Courier','B','12');
			
			
            $this->Ln(5);
            $this->SetTextColor(1,43,84);
			$this->Cell(35,5, 'AGROMAR',0,1,'L');

			$this->Cell(35,5, 'Calle Principal Rio Dulce',0,1,'L');
			
			$this->Cell(35,5, 'Telefono: 7930-5140',0,1,'L');
			$this->SetLineWidth(1);
			$this->SetDrawColor(252,29,7);
			$this->Cell(190,1, '','B',0,'L');
			$this->SetLineWidth(0.5);
			$this->Ln(1);
		}

		function Footer(){
			$this->SetY(-15);
			$this->SetFont('Arial','I','8');
			$this->Cell(0,10, '',0,0,'C');
		}
		
	}

?>