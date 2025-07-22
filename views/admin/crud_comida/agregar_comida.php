<?php
include __DIR__ . '/../../../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    $imagen = null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['tmp_name']) {
        $tipo = mime_content_type($_FILES['imagen']['tmp_name']);

        // Crear imagen desde el archivo
        switch ($tipo) {
            case 'image/jpeg':
                $imgOriginal = imagecreatefromjpeg($_FILES['imagen']['tmp_name']);
                break;
            case 'image/png':
                $imgOriginal = imagecreatefrompng($_FILES['imagen']['tmp_name']);
                break;
            case 'image/gif':
                $imgOriginal = imagecreatefromgif($_FILES['imagen']['tmp_name']);
                break;
            case 'image/webp':
                $imgOriginal = imagecreatefromwebp($_FILES['imagen']['tmp_name']);  
                break;
            default:
                die("Tipo de imagen no soportado.");
        }

        // Redimensionar
        $anchoNuevo = 300;
        $altoNuevo = 300;
        $anchoOriginal = imagesx($imgOriginal);
        $altoOriginal = imagesy($imgOriginal);

        $imagenRedimensionada = imagecreatetruecolor($anchoNuevo, $altoNuevo);

        // Conservar transparencia
        if ($tipo === 'image/png' || $tipo === 'image/gif') {
            imagecolortransparent($imagenRedimensionada, imagecolorallocatealpha($imagenRedimensionada, 0, 0, 0, 127));
            imagealphablending($imagenRedimensionada, false);
            imagesavealpha($imagenRedimensionada, true);
        }

        // Redimensionar la imagen
        imagecopyresampled($imagenRedimensionada, $imgOriginal, 0, 0, 0, 0, $anchoNuevo, $altoNuevo, $anchoOriginal, $altoOriginal);

        // Guardar en variable binaria
        ob_start();
        if ($tipo === 'image/png') {
            imagepng($imagenRedimensionada);
        } elseif ($tipo === 'image/gif') {
            imagegif($imagenRedimensionada);
        } else {
            imagejpeg($imagenRedimensionada, null, 90);
        }
        $imagen = ob_get_clean();

        // Liberar memoria
        imagedestroy($imgOriginal);
        imagedestroy($imagenRedimensionada);
    }

    // Insertar en base de datos
    $sql = "INSERT INTO comida (nombre, precio, img) VALUES (:nombre, :precio, :img)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':img', $imagen, PDO::PARAM_LOB);

    if ($stmt->execute()) {
        header("Location: ../comida.php");
        exit();
    } else {
        echo "Error al agregar comida.";
    }
}
?>
