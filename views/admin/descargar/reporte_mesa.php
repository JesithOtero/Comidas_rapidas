<?php
require_once __DIR__ . '/../../../config/conexion.php';
require_once __DIR__ . '/../../../pdf/fpdf.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Reporte de Mesas', 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(20, 10, 'ID', 1);
        $this->Cell(30, 10, 'Capacidad', 1);
        $this->Cell(40, 10, 'Fecha', 1);
        $this->Cell(30, 10, 'Hora', 1);
        $this->Cell(40, 10, 'Estado', 1);
        $this->Ln();
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
                $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Página ') . $this->PageNo(), 0, 0, 'C');
    }
}

try {
    $stmt = $conn->query("SELECT * FROM mesa");
    $mesas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // No imprimir errores aquí si vas a generar un PDF
    exit("Error al obtener datos de la base de datos.");
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

foreach ($mesas as $mesa) {
    $pdf->Cell(20, 10, $mesa['id_mesa'], 1);
    $pdf->Cell(30, 10, $mesa['capacidad'], 1);
    $pdf->Cell(40, 10, $mesa['fecha'], 1);
    $pdf->Cell(30, 10, $mesa['hora'], 1);
    $pdf->Cell(40, 10, ucfirst($mesa['estado']), 1);
    $pdf->Ln();
}

$pdf->Output('D', 'reporte_mesas.pdf');
exit();
