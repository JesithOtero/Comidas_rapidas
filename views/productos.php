<?php
include '../config/conexion.php';

$sql = "SELECT * FROM comida";
$stmt = $conn->prepare($sql);
$stmt->execute();
$comidas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>COMIDAS RAPIDAS</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>
</head>
<body>

<!-- HEADER -->
<header class="header">
  <div class="top-bar">
    <img src="../assets/img/logo.png" alt="Logo de comidas" class="logo">
    <h1 class="titulo">COMIDAS RAPIDAS</h1>
  </div>
  <div class="curva"></div>
  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="quienessomos.php"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#pillsNavbar"
        aria-controls="pillsNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="pillsNavbar">
        <ul class="nav nav-pills mb-3 ms-auto" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link" onclick="location.href='quienessomos.php'">Inicio</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" onclick="location.href='ubicacion.php'">Ubicación</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link active" onclick="location.href='productos.php'">Productos</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" onclick="location.href='reserva.php'">Reserva</button>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>

<!-- SECCIÓN DE PRODUCTOS EN CARRUSEL -->
<div class="container my-5">
  <h2 class="text-center mb-4">Nuestros Productos</h2>

  <div id="carouselProductos" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" >
    <div class="carousel-inner">
      <?php
      $chunked = array_chunk($comidas, 4); // Agrupar de 4 en 4
      foreach ($chunked as $index => $grupo) {
      ?>
        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
          <div class="row justify-content-center">
            <?php foreach ($grupo as $comida) { ?>
              <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 text-center shadow-sm mx-2">
                  <?php 
                    $imgData = base64_encode($comida['img']);
                    $imgSrc = 'data:image/jpeg;base64,' . $imgData;
                  ?>
                  <img src="<?php echo $imgSrc; ?>" class="card-img-top" alt="Imagen de comida">
                  <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($comida['nombre']); ?></h5>
                    <p class="card-text">Precio: $<?php echo number_format($comida['precio'], 2); ?></p>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
    </div>

    <!-- Controles del carrusel -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselProductos" data-bs-slide="prev">
      <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselProductos" data-bs-slide="next">
      <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
      <span class="visually-hidden">Siguiente</span>
    </button>
  </div>
</div>


<?php include '../includes/footer.php'; ?>
</body>
</html>
