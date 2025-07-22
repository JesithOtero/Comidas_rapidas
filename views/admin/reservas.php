<?php
session_start();

include '../../controller/controlador_reserva.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../../assets/css/sidebar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <title>Reservas</title>
</head>
<body>
<?php include __DIR__ . '/../../includes/sidebar.php'; ?>

<main>
  <div class="contenido container mt-4">
    <h1 class="text-center">Reservas</h1>
    <p class="text-center">Aquí puedes gestionar las reservas registradas en el sistema.</p>
    <hr>
  </div>

  <div class="table-container">
    <form method="GET" class="row mb-3 align-items-center">
      <div class="col-md-5">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar..." value="<?php echo htmlspecialchars($buscar); ?>">
      </div>
      <div class="col-md-3">
        <select name="filtro" id="filtro" class="form-control">
          <option value="id_reserva" <?php echo ($filtro == 'id_reserva') ? 'selected' : ''; ?>>ID Reserva</option>
          <option value="id_usuario" <?php echo ($filtro == 'id_usuario') ? 'selected' : ''; ?>>ID Usuario</option>
          <option value="id_mesa" <?php echo ($filtro == 'id_mesa') ? 'selected' : ''; ?>>ID Mesa</option>
        </select>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
      </div>
      <div class="col-md-2 text-end">
        <a href="descargar/reporte_reserva.php" class="btn btn-secondary"><i class="bi bi-filetype-pdf"></i> Reporte PDF</a>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID Reserva</th>
            <th>ID Usuario</th>
            <th>ID Mesa</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($reservas)): ?>
            <?php foreach ($reservas as $reserva): ?>
              <tr>
                <td><?php echo $reserva['id_reserva']; ?></td>
                <td><?php echo htmlspecialchars($reserva['id_usuario']); ?></td>
                <td><?php echo htmlspecialchars($reserva['id_mesa']); ?></td>
                <td><?php echo htmlspecialchars($reserva['fecha']); ?></td>
                <td><?php echo htmlspecialchars($reserva['hora']); ?></td>
                <td><?php echo htmlspecialchars($reserva['estado_reserva']); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center">No hay reservas registradas</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Paginación (siempre visible) -->
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <li class="page-item <?php echo ($paginaActual <= 1) ? 'disabled' : ''; ?>">
          <a class="page-link" href="?pagina=<?php echo $paginaActual - 1; ?>&buscar=<?php echo urlencode($buscar); ?>&filtro=<?php echo urlencode($filtro); ?>" aria-label="Anterior">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
          <li class="page-item <?php echo ($paginaActual == $i) ? 'active' : ''; ?>">
            <a class="page-link" href="?pagina=<?php echo $i; ?>&buscar=<?php echo urlencode($buscar); ?>&filtro=<?php echo urlencode($filtro); ?>"><?php echo $i; ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item <?php echo ($paginaActual >= $totalPaginas) ? 'disabled' : ''; ?>">
          <a class="page-link" href="?pagina=<?php echo $paginaActual + 1; ?>&buscar=<?php echo urlencode($buscar); ?>&filtro=<?php echo urlencode($filtro); ?>" aria-label="Siguiente">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</main>
</body>
</html>
