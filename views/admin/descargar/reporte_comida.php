<?php
require_once __DIR__ . '/../../../config/conexion.php';
require_once __DIR__ . '/../../../pdf/fpdf.php';

// Clase PDF personalizada
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Reporte de Comidas'), 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(20, 10, 'ID', 1);
        $this->Cell(100, 10, 'Nombre', 1);
        $this->Cell(40, 10, 'Precio', 1);
        $this->Ln();
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Página ') . $this->PageNo(), 0, 0, 'C');
    }
}

// Obtener datos
try {
    $consulta = "SELECT id_comida, nombre, precio FROM comida";
    $stmt = $conn->query($consulta);
    $comidas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener comidas: " . $e->getMessage());
}

// Generar PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

foreach ($comidas as $row) {
    $pdf->Cell(20, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['id_comida']), 1);
    $pdf->Cell(100, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['nombre']), 1);
    $pdf->Cell(40, 10, '$' . number_format($row['precio'], 2), 1);
    $pdf->Ln();
}

$pdf->Output('D', 'reporte_comida.pdf');
