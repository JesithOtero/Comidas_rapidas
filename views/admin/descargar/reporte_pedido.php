<?php
require_once __DIR__ . '/../../../config/conexion.php';
require_once __DIR__ . '/../../../pdf/fpdf.php';

// Clase PDF personalizada
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Reporte de Pedidos'), 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(25, 10, ' ID Pedido', 1);
        $this->Cell(60, 10, 'Comida', 1);
        $this->Cell(25, 10, 'Cantidad', 1);
        $this->Cell(30, 10, 'Monto', 1);
        $this->Cell(35, 10, 'ID Reserva', 1);
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
    $consulta = "SELECT 
                    p.id_pedido, 
                    c.nombre AS nombre_comida, 
                    p.cantidad, 
                    p.monto, 
                    p.id_reserva
                 FROM pedido p
                 INNER JOIN comida c ON p.id_comida = c.id_comida";

    $stmt = $conn->query($consulta);
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener pedidos: " . $e->getMessage());
}

// Generar PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

foreach ($pedidos as $row) {
    $pdf->Cell(25, 10, $row['id_pedido'], 1);
    $pdf->Cell(60, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['nombre_comida']), 1);
    $pdf->Cell(25, 10, $row['cantidad'], 1);
    $pdf->Cell(30, 10, '$' . number_format($row['monto'], 2), 1);
    $pdf->Cell(35, 10, $row['id_reserva'], 1);
    $pdf->Ln();
}

$pdf->Output('D', 'reporte_pedidos.pdf');
