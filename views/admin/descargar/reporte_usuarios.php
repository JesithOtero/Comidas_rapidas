<?php
require_once __DIR__ . '/../../../config/conexion.php';
require_once __DIR__ . '/../../../pdf/fpdf.php';

// Crear clase PDF personalizada
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Reporte de Usuarios', 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(10, 10, 'ID', 1);
        $this->Cell(35, 10, 'Nombre', 1);
        $this->Cell(35, 10, 'Apellido', 1);
        $this->Cell(55, 10, 'Correo', 1);
        $this->Cell(30, 10, 'Celular', 1);
        $this->Cell(20, 10, 'Tipo', 1);
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
    $consulta = "SELECT * FROM persona";
    $stmt = $conn->query($consulta);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener usuarios: " . $e->getMessage());
}

// Generar PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

foreach ($usuarios as $row) {
    $pdf->Cell(10, 10, $row['id_usuario'], 1);
    $pdf->Cell(35, 10, $row['nombre'], 1);
    $pdf->Cell(35, 10, $row['apellido'], 1);
    $pdf->Cell(55, 10, $row['correo'], 1);
    $pdf->Cell(30, 10, $row['n_celular'], 1);
    $pdf->Cell(20, 10, $row['tipo'], 1);
    $pdf->Ln();
}

$pdf->Output('D', 'reporte_usuarios.pdf');
