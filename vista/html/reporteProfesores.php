<?php
    require_once '../../fpdf/fpdf.php';
    require_once '../../controlador/persistencia/ControladorPersistencia.php';
    $pdf=new FPDF();
    $pdf->AddPage(100, 'A3');
    $pdf->SetFont('Arial', 'B', '20');
    $pdf->Cell(300,10,"LISTADO DE PROFESORES:",0,0,'C');
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFillColor(2,157,116);
    $pdf->SetTextColor(240, 255, 240);
    $pdf->Cell(60,15,"NOMBRE",1, 0, 'C', true);
    $pdf->Cell(60,15,"APELLIDO",1, 0, 'C', true);
    $pdf->Cell(60,15,"TITULO",1, 0, 'C', true);
    $pdf->Cell(60,15,"CALLE",1, 0, 'C', true);
    $pdf->Cell(60,15,"NUMERO",1, 0, 'C', true);
    $pdf->Ln();
    $cp = new ControladorPersistencia();
    $listadoProfesores = $cp->ejecutarSentencia(DBSentencias::BUSCAR_PROFESORES);
    $alterna = true;
    foreach ($listadoProfesores as $profesores) {
        if ($alterna) {
            $pdf->SetFont('Arial', '', '16');
            $pdf->SetFillColor(229, 229, 229);
            $pdf->SetTextColor(3, 3, 3);
            $pdf->Cell(60,10, utf8_decode($profesores['nombre']),1, 0, 'L', true);
            $pdf->Cell(60,10, utf8_decode($profesores['apellido']),1, 0, 'L', true);
            $pdf->Cell(60,10, utf8_decode($profesores['titulo']),1, 0, 'L', true);
            $pdf->Cell(60,10, utf8_decode($profesores['calle']),1, 0, 'L', true);
            $pdf->Cell(60,10, utf8_decode($profesores['numero']),1, 0, 'L', true);
            $pdf->Ln();
            $alterna = !$alterna;
        }else{
            $pdf->SetFont('Arial', '', '16');
            $pdf->SetFillColor(229, 229, 229);
            $pdf->SetTextColor(3, 3, 3);
            $pdf->Cell(60,10, utf8_decode($profesores['nombre']),1, 0, 'L', FALSE);
            $pdf->Cell(60,10, utf8_decode($profesores['apellido']),1, 0, 'L', FALSE);
            $pdf->Cell(60,10, utf8_decode($profesores['titulo']),1, 0, 'L', FALSE);
            $pdf->Cell(60,10, utf8_decode($profesores['calle']),1, 0, 'L', FALSE);
            $pdf->Cell(60,10, utf8_decode($profesores['numero']),1, 0, 'L', FALSE);
            $pdf->Ln();
            $alterna = !$alterna;
        }
    }
    $pdf->Output();
