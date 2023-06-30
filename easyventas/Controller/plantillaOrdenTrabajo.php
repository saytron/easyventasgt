<?php
error_reporting(E_ALL ^ E_NOTICE);
	require '../lib/pdf/fpdf.php';

	class PDF extends FPDF{

		function Header(){
			
		
		}

		function Footer(){
			$this->SetFont('Arial','B',10);
			$this->SetTextColor( 170, 166, 165 );
			$this->SetY(-15);
			$this->Write(5,'Tecnofer');
			$this->SetX(-25);
			$this->AliasNbPages();
			$this->Write(5,$this->PageNo().'/{nb}');
		}
		
	}

?>