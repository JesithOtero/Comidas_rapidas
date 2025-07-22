<?php
session_start();
include __DIR__ . '/../../controller/controlador_comida.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../../assets/css/sidebar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <title>Comidas</title>
</head>
<body>
<?php include __DIR__ . '/../../includes/sidebar.php'; ?>

<main>
  <div class="contenido container mt-4">
    <h1 class="text-center">Comidas</h1>
    <p class="text-center">Aquí puedes gestionar las comidas registradas en el sistema.</p>
    <hr />

    <form method="GET" class="row mb-3 align-items-center">
      <div class="col-md-6">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre..." value="<?php echo htmlspecialchars($buscar); ?>" />
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
      </div>
      <div class="col-md-4 text-end">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarComida">
          <i class="bi bi-plus-circle"></i> Agregar Comida
        </button>
      </div>
    </form>

    <div class="col-md-12 text-end mb-3">
      <a href="descargar/reporte_comida.php" class="btn btn-secondary"><i class="bi bi-filetype-pdf"></i> Reporte PDF</a>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($comidas)): ?>
            <?php foreach ($comidas as $comida): ?>
              <tr>
                <td><?php echo $comida['id_comida']; ?></td>
                <td>
                  <?php if (!empty($comida['img'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($comida['img']); ?>" alt="Imagen" width="80" height="60" style="object-fit: cover;" />
                  <?php else: ?>
                    <span class="text-muted">Sin imagen</span>
                  <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($comida['nombre']); ?></td>
                <td>$<?php echo number_format($comida['precio'], 2); ?></td>
                <td>
                  <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditar<?php echo $comida['id_comida']; ?>">
                    <i class="bi bi-pencil"></i> Actualizar
                  </button>
                  <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar<?php echo $comida['id_comida']; ?>">
                    <i class="bi bi-trash"></i> Eliminar
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="5" class="text-center">No hay comidas registradas</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <li class="page-item <?php echo ($paginaActual <= 1) ? 'disabled' : ''; ?>">
          <a class="page-link" href="?pagina=<?php echo max(1, $paginaActual - 1); ?>&buscar=<?php echo urlencode($buscar); ?>" aria-label="Anterior">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
          <li class="page-item <?php echo ($paginaActual == $i) ? 'active' : ''; ?>">
            <a class="page-link" href="?pagina=<?php echo $i; ?>&buscar=<?php echo urlencode($buscar); ?>"><?php echo $i; ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item <?php echo ($paginaActual >= $totalPaginas) ? 'disabled' : ''; ?>">
          <a class="page-link" href="?pagina=<?php echo min($totalPaginas, $paginaActual + 1); ?>&buscar=<?php echo urlencode($buscar); ?>" aria-label="Siguiente">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>

<!-- Modal Agregar Comida -->
<div class="modal fade" id="modalAgregarComida" tabindex="-1" aria-labelledby="modalAgregarComidaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="crud_comida/agregar_comida.php" method="POST" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarComidaLabel">Agregar Nueva Comida</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" name="nombre" required />
        </div>
        <div class="mb-3">
          <label for="precio" class="form-label">Precio</label>
          <input type="number" class="form-control" name="precio" required />
        </div>
        <div class="mb-3">
          <label for="imagen" class="form-label">Imagen</label>
          <input type="file" class="form-control" name="imagen" accept="image/*" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">Agregar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modales Editar y Eliminar -->
<?php foreach ($comidas as $comida): ?>
<!-- Modal Editar -->
<div class="modal fade" id="modalEditar<?php echo $comida['id_comida']; ?>" tabindex="-1" aria-labelledby="modalEditarLabel<?php echo $comida['id_comida']; ?>" aria-hidden="true">
  <div class="modal-dialog">
    <form action="crud_comida/actualizar_comida.php" method="POST" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarLabel<?php echo $comida['id_comida']; ?>">Editar Comida</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id_comida" value="<?php echo $comida['id_comida']; ?>" />
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($comida['nombre']); ?>" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Precio</label>
          <input type="number" step="0.01" min="0" name="precio" class="form-control" value="<?php echo $comida['precio']; ?>" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Imagen (opcional)</label>
          <input type="file" name="imagen" class="form-control" accept="image/*" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="modalEliminar<?php echo $comida['id_comida']; ?>" tabindex="-1" aria-labelledby="modalEliminarLabel<?php echo $comida['id_comida']; ?>" aria-hidden="true">
  <div class="modal-dialog">
    <form action="crud_comida/eliminar_comida.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEliminarLabel<?php echo $comida['id_comida']; ?>">Eliminar Comida</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro de que deseas eliminar la comida <strong><?php echo htmlspecialchars($comida['nombre']); ?></strong>?</p>
        <input type="hidden" name="id_comida" value="<?php echo $comida['id_comida']; ?>" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-danger">Eliminar</button>
      </div>
    </form>
  </div>
</div>
<?php endforeach; ?>

</main>
</body>
</html>
