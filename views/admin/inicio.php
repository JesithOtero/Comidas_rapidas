<?php
session_start();

include '../../controller/controlador_inicio.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap y Chart.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include '../../includes/sidebar.php'; ?>

    <main class="contenido">
        <div class="container-fluid mt-4">
            <h1 class="text-center">Bienvenido al Sistema de Gestión</h1>
            <hr>

            <!-- Tarjetas -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Clientes</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalClientes; ?></div>
                            </div>
                            <i class="bi bi-people fs-2 text-primary"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pedidos</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalPedidos; ?></div>
                            </div>
                            <i class="bi bi-cart fs-2 text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Monto Total</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo number_format($montoTotal, 2); ?></div>
                            </div>
                            <i class="bi bi-currency-dollar fs-2 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Últimos Pedidos -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Últimos Pedidos</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente</th>
                                            <th>Fecha</th>
                                            <th>Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($ultimosPedidos as $pedido): ?>
                                        <tr>
                                            <td><?php echo $pedido['id']; ?></td>
                                            <td><?php echo $pedido['nombre']; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($pedido['fecha'])); ?></td>
                                            <td>$<?php echo number_format($pedido['monto'], 2); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php if(empty($ultimosPedidos)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No hay pedidos registrados</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico -->
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Monto Total por Día</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="graficoMontosDiarios" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

  
    <script>
    const fechas = <?php echo json_encode(array_column($montoDiario, 'fecha')); ?>;
    const montos = <?php echo json_encode(array_map('floatval', array_column($montoDiario, 'monto'))); ?>;
    </script>
    <script src="../../assets/js/grafico.js"></script>

  
</body>
</html>
