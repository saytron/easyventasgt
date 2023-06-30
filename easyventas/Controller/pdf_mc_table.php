<?php
require('../../libs/pdf/fpdf.php');

class PDF_MC_Table extends FPDF
{

    var $widths;
    var $aligns;
    //datos de la factura 
    var $fechaFormato = '';
    var $noDte = '';
    var $serieDte = '';
    var $CorrelativoInterno = 0;
    var $usuario = '';
    function recuperarDatosFactura($fechaFormato, $noDte, $satSerie, $CorrelativoInterno, $usuario)
    {
        $this->fechaFormato = $fechaFormato;
        $this->noDte = $noDte;
        $this->serieDte = $satSerie;
        $digitos = strlen($noDte);
        $this->CorrelativoInterno = str_pad($CorrelativoInterno, $digitos, "0", STR_PAD_LEFT);
        $this->usuario = $usuario;
    }
    //recuperar detos del certificador y el valor total de la factura
    var $textoIzqierda = "";
    var $derecha = "";
    var $total = 0;
    var $sat_authorization = "";
    var $satCertifier = "";
    var $taxCode = "";
    var $certification_date = "";
    function recuperarDatosCertifier($txIzquierda, $txDerecha, $txtotal, $sat_authorization, $satCertifier, $taxCode, $certification_date)
    {

        $this->textoIzqierda = $txIzquierda;
        $this->derecha = $txDerecha;
        if (empty($txtotal)) {
            $this->total = 0;
        } else {
            $this->total = $txtotal;
        }

        $this->sat_authorization = $sat_authorization;
        $this->satCertifier = $satCertifier;
        $this->taxCode = $taxCode;
        $this->certification_date = $certification_date;
    }
    //datos del propietario del negocio
    var $propietario = '';
    var $direccion = '';
    var $razon_social = '';
    var $direccion1 = '';
    var $direccion2 = '';
    var $nitPropietario = '';
    var $telefonoPropietario = '';
    public function datosNegocio($razon_social, $direccion1, $direccion2, $propietario, $nitPropietario, $telefonoPropietario)
    {
        $this->razon_social = $razon_social;
        $this->propietario = $propietario;
        $this->direccion1 = $direccion1;
        $this->direccion2 = $direccion2;
        $this->nitPropietario = $nitPropietario;
        $this->telefonoPropietario = $telefonoPropietario;
    }
    //datos del cliente
    var $cliente = '';
    var $nombre = '';
    var $apellidos = '';
    var $direccionCliente = '';
    var $nit = '';
    function recuperarDatosCliente($cliente, $nombre, $apellidos, $direccion, $nit)
    {
        $this->cliente = $cliente;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->direccionCliente = $direccion;
        $this->nit = $nit;
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
        $h = 5 * $nb;
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
            //$this->Rect($x, $y, $w, $h);
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

        //imagenes
        $this->image('../img/banner1.png', 10, 15, 45);
        $this->image('../img/datosFactura.png', 138, 7, 66, 35);
        $this->image('../img/datosCliente.png', 10, 44, 194, 25);

        $this->SetFont('Arial', 'B', 13);
        //datos del propietario del negocio
        $this->Ln(-3);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(168, 5, $this->razon_social, 0, 1, 'C');
        $this->Ln(2);
        $this->SetFont('Arial', '', '9');
        $this->SetTextColor(1, 43, 84);
        $this->Cell(167, 5, $this->propietario, 0, 1, 'C');
        $this->Cell(165, 5, $this->direccion1, 0, 1, 'C');
        $this->Cell(165, 5, $this->direccion2, 0, 1, 'C');
        $this->Cell(165, 5, 'NIT: ' . $this->nitPropietario, 0, 1, 'C');
        $this->Cell(165, 5, $this->telefonoPropietario, 0, 1, 'C');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(60, 5, "Documento Tributario Electrónico", 0, 1, 'C');

        //datos de la factura 
        $this->SetTextColor(255, 255, 255);

        $this->SetFont('Arial', 'B', 9);

        $this->Ln(-35);
        $this->Cell(192, 4, 'FACTURA PEQUEÑO CONTRIBUYENTE', 0, 1, 'R');
        $this->Ln(3);
        $this->SetFont('Arial', 'B', 10);

        //fecha
        $this->Cell(130, 6, '', 0, 0, 'L');
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(252, 26, 4);
        $this->Cell(30, 6, 'Fecha: ', 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(29, 62, 96);
        $this->Cell(31, 6, $this->fechaFormato, 0, 1, 'R');
        //NO
        $this->Cell(130, 4, '', 0, 0, 'L');
        $this->SetTextColor(252, 26, 4);
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 4, 'No. Documento: ', 0, 0, 'L');
        $this->SetTextColor(29, 62, 96);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(31, 4, $this->noDte, 0, 1, 'R');
        //SERIE
        $this->Cell(130, 4, '', 0, 0, 'L');
        $this->SetTextColor(252, 26, 4);
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 4, 'Serie: ', 0, 0, 'L');
        $this->SetTextColor(29, 62, 96);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(31, 4, $this->serieDte, 0, 1, 'R');
        //CORRELATIVO
        $this->Cell(130, 4, '', 0, 0, 'L');
        $this->SetTextColor(252, 26, 4);
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 4, 'Correlativo: ', 0, 0, 'L');
        $this->SetTextColor(29, 62, 96);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(31, 4, $this->CorrelativoInterno, 0, 1, 'R');
        //usuario
        $this->Cell(130, 6, '', 0, 0, 'L');
        $this->SetTextColor(252, 26, 4);
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 6, 'Vendedor: ', 0, 0, 'L');
        $this->SetTextColor(29, 62, 96);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(31, 6, $this->usuario, 0, 1, 'R');

        //datos del cliente
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(195, 6, 'CLIENTE', 0, 1, 'C');
        $this->Ln(2);
        $this->SetFont('Courier', 'B', 11);


        $fontSize = 12;
        $this->SetTextColor(252, 26, 4);
        $this->Cell(28, 6, ' Nombre: ', 0, 0, 'L');
        $cellWidth2 = 120;
        while ($this->GetStringWidth($this->cliente) > $cellWidth2) {
            $this->SetFontSize($fontSize -= 0.1);
        }
        $this->SetTextColor(0, 0, 0);
        $this->Cell($cellWidth2, 6, $this->nombre . ' ' . $this->apellidos, 0, 1, 'L');
        $this->SetFont('Courier', 'B', 11);
        $this->SetTextColor(252, 26, 4);
        $this->Cell(28, 6, ' Direccion: ', 0, 0, 'L');
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Courier', 'B', 11);
        $cellWidth1 = 115;
        while ($this->GetStringWidth($this->direccionCliente) > $cellWidth1) {
            $this->SetFontSize($fontSize -= 0.1);
        }
        $this->Cell($cellWidth1, 6, $this->direccionCliente, 0, 0, 'L');
        $this->Ln(-7);
        $this->SetFont('Courier', 'B', 11);
        $this->SetTextColor(252, 26, 4);
        $this->Cell(164, 6, 'Nit: ', 0, 0, 'R');
        $this->SetTextColor(0, 0, 0);
        $this->Cell(29, 6, $this->nit, 0, 1, 'R');
        $this->SetY(72);

        //datos de la cabecera de la tabla
        $this->SetY(58);
        $this->SetLineWidth(0.5); //es el tamanio del borde
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(26, 99, 122);
        $this->SetTextColor(255, 255, 255);
        $this->Ln(13);
        $this->Cell(14, 8, 'Cant.', 0, 0, 'C', 1);
        $this->Cell(120, 8, 'Descripcion', 0, 0, 'C', 1);
        $this->Cell(30, 8, 'Precio Unitarario', 0, 0, 'C', 1);
        $this->Cell(30, 8, 'Precio Total', 0, 1, 'C', 1);


        //color de las lineas
        $this->SetLineWidth(0.5); //es el tamanio del borde
        $this->SetDrawColor(26, 99, 122);
        //pintamos las lineas
        $this->Line(10, 71, 204, 71);
        $this->Line(10, 246, 204, 246);
        $this->Line(10, 258, 204, 258);

        //linea vertical 1
        $this->Line(10, 71, 10, 258);
        //linea vertical 2
        $this->Line(24, 71, 24, 246);
        //linea vertical 3
        $this->Line(144, 71, 144, 246);
        //linea vertical 4
        $this->Line(174, 71, 174, 246);
        //linea vertical 5
        $this->Line(204, 71, 204, 258);
    }
    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-33);
        // Arial italic 8
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(110, 6, 'Son ' . $this->textoIzqierda . " quetzales con " . $this->derecha . '/100', 0, 1, 'L');
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(158, 5, 'Total:', 0, 0, 'R');
        $this->Cell(37, 5, 'Q ' . number_format($this->total, 2) . '  ', 0, 1, 'R');

        $this->SetFont('Arial', 'B', 9);
        $this->SetTextColor(29, 62, 96);
        $this->Cell(105, 6, 'NO. DE AUTORIZACIÓN: ' . $this->sat_authorization , 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(90, 6, 'No genera derecho a crédito fiscal', 0, 1, 'R');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(115, 5, 'CERTIFICADOR: ' . $this->satCertifier . ' NIT: ' . $this->taxCode, 0, 1, 'L');
        $this->Cell(55, 5, 'FECHA DE AUTORIZACIÓN: ' . $this->certification_date, 0, 1, 'L');
    }
}
