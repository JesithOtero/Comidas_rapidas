<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>COMIDAS RAPIDAS</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
  <link rel="stylesheet" href="../assets/css/ubicacion.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.12.1/font/bootstrap-icons.min.css">
</head>

<body>

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
              <button class="nav-link active" onclick="location.href='ubicacion.php'">Ubicación</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" onclick="location.href='productos.php'">Productos</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" onclick="location.href='reserva.php'">Reserva</button>
            </li>
          </ul>
        </div>
      </div>
    </nav>

  </header>

  <section id="ubicacion" class="ubicacion">
    <div class="container">
      <h2 class="text-center mb-4 ">¿Dónde nos puedes encontrar?</h2>
      <div class="descripcion text-center mb-3">
        <p>
          Nos encontramos en el centro de la ciudad, ¡fácil de localizar! Ven y disfruta de nuestras deliciosas comidas
          rápidas.
        </p>
      </div>
      <div class="text-center mb-2">
        <i class="bi bi-geo-alt-fill" style="color: red; font-size: 2rem;"></i>
      </div>
      <div class="mapa-responsive">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1970.6020288645864!2d-75.44894393593604!3d8.953336033129066!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2sco!4v1746407775552!5m2!1ses-419!2sco"
          width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe> width="100%" height="300" style="border:0;"
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </section>

  <?php include '../includes/footer.php'; ?>


</body>

</html>