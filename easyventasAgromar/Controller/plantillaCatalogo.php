<?php
require('../../libs/pdf/fpdf.php');

class PLANTILLA_CATALOGO extends FPDF
{

    var $widths;
    var $aligns;
    //datos de la factura 
    var $fechaFormato = '';
    var $CorrelativoInterno = 0;
    var $usuario = '';
    function recuperarDatosFactura($fechaFormato){
        $this->fechaFormato = $fechaFormato;
    
    }
    //recuperar detos del certificador y el valor total de la factura
    var $textoIzqierda = "";
    var $derecha = "";
    var $total = 0;
    var $tipoCatalogo = 0;
    function recuperarDatosTotales($txtotal,$tipoCatalogo)
    {
        $this->tipoCatalogo = (int)$tipoCatalogo;
        if (empty($txtotal)) {
            $this->total = 0;
        } else {
            $this->total = $txtotal;
        }

    }
  

    var $catalogo = '';
    
    public function recuperarDatosCatalogo($catalogo,$tipoCatalogo){
        $this->catalogo = $catalogo;
        $this->tipoCatalogo = $tipoCatalogo;
        
    }
    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }
    function SetPosition($p)
    {
        $this->position = $p;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 7 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $p = $this->position[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : $p;
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
           
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        $h = $h + 15;
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage('portrait', 'letter');
           
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    //encabezado
    public function header()
    {

        $this->Ln(12);
        //imagenes
        $this->image('../img/banner1.png', 10, 20, 45);
        

        
        
       

        //fecha
        $this->Cell(130, 6, '', 0, 0, 'L');
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(252, 26, 4);
        $this->Cell(30, 6, 'Fecha de creacion: ', 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(29, 62, 96);
        $this->Cell(31, 6, $this->fechaFormato, 0, 1, 'R');
        


        $this->SetFont('Arial', '', 16);
$this->Ln(10);
$this->SetTextColor(0, 0, 0);
$this->Cell(190, 6, $this->catalogo, 0, 0, 'L');



        //datos de la cabecera de la tabla
        $this->SetY(35);
        $this->SetLineWidth(0.5); //es el tamanio del borde
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(26, 99, 122);
        $this->SetTextColor(255, 255, 255);
        $this->Ln(13);
        $this->Cell(14, 8, 'Cant.', 0, 0, 'C', 1);
        $this->Cell(120, 8, 'Descripcion', 0, 0, 'C', 1);
        $this->Cell(30, 8, 'Precio Unitarario', 0, 0, 'C', 1);
        if($this->tipoCatalogo == 1){
        $this->Cell(25, 8, 'Apuntes', 0, 1, 'C', 1);
        }else{
            $this->Cell(25, 8, 'P.TOTAL', 0, 1, 'C', 1);
        }
    }
    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-33);
        // Arial italic 8
        $this->SetFont('Arial', 'B', 11);
        $this->SetFont('Arial', 'B', 12);
        if($this->tipoCatalogo == 0){
            $this->Cell(158, 5, 'Total:', 0, 0, 'R');
            $this->Cell(37, 5, 'Q ' . number_format($this->total, 2) . '  ', 0, 1, 'R');
        }
        

    }
}
