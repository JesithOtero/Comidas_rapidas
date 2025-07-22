<?php
require_once __DIR__ . '/../../../config/conexion.php';
require_once __DIR__ . '/../../../pdf/fpdf.php';

// Crear clase PDF personalizada
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Reporte de Reservas'), 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(20, 10, 'ID', 1);
        $this->Cell(50, 10, 'Usuario', 1);
        $this->Cell(20, 10, 'Mesa', 1);
        $this->Cell(30, 10, 'Fecha', 1);
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

// Obtener datos
try {
    $consulta = "SELECT 
                    r.id_reserva, 
                    p.nombre, 
                    p.apellido, 
                    r.id_mesa, 
                    r.fecha, 
                    r.hora, 
                    r.estado_reserva
                FROM reserva r
                INNER JOIN persona p ON r.id_usuario = p.id_usuario";

    $stmt = $conn->query($consulta);
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener reservas: " . $e->getMessage());
}

// Generar PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

foreach ($reservas as $row) {
    $usuario = $row['nombre'] . ' ' . $row['apellido'];

    $pdf->Cell(20, 10, $row['id_reserva'], 1);
    $pdf->Cell(50, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $usuario), 1);
    $pdf->Cell(20, 10, $row['id_mesa'], 1);
    $pdf->Cell(30, 10, $row['fecha'], 1);
    $pdf->Cell(30, 10, $row['hora'], 1);
    $pdf->Cell(40, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['estado_reserva']), 1);
    $pdf->Ln();
}

$pdf->Output('D', 'reporte_reservas.pdf');
