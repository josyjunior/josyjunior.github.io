<!-- menu.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú del Restaurante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg,rgb(120, 134, 182) 0%,rgb(221, 224, 228) 100%);
            min-height: 100vh;
        }
        .card {
            border-radius: 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        }
        .card-img-top {
            border-top-left-radius: 18px;
            border-top-right-radius: 18px;
            height: 220px;
            object-fit: cover;
        }
        .mb-4 {
            font-weight: 700;
            color:rgb(255, 255, 255);
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">Nuestro Menú</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <!-- Plato 1 -->
            <div class="col">
                <div class="card h-100">
                    <a href="reservar.php?restaurante=olivar&plato=Ceviche">
                        <img src="img/ceviche.jpg" class="card-img-top" alt="Ceviche">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">Ceviche</h5>
                          <h5 class="card-title">Precio: 25 soles</h5>
                        <p class="card-text">Fresco y picante, preparado al momento.</p>
                        <a href="reservar.php?restaurante=olivar&plato=Ceviche" class="btn btn-primary w-100 mt-2">Reservar en Olivar</a>
                    </div>
                </div>
            </div>
            <!-- Plato 2 -->
            <div class="col">
                <div class="card h-100">
                    <a href="reservar.php?restaurante=batan&plato=Arroz%20Chaufa">
                        <img src="img/chaufa.jpg" class="card-img-top" alt="Arroz Chaufa">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">Arroz Chaufa</h5>
                        <h5 class="card-title">Precio: 20 soles</h5>
                        <p class="card-text">Nuestro clásico chaufa al estilo chinchano.</p>
                        <a href="reservar.php?restaurante=batan&plato=Arroz%20Chaufa" class="btn btn-primary w-100 mt-2">Reservar en Batan</a>
                    </div>
                </div>
            </div>
            <!-- Plato 3 -->
            <div class="col">
                <div class="card h-100">
                    <a href="reservar.php?restaurante=sunampe&plato=Lomo%20Saltado">
                        <img src="img/lomo.jpg" class="card-img-top" alt="Lomo Saltado">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">Lomo Saltado</h5>
                        <h5 class="card-title">Precio: 18 soles</h5>
                        <p class="card-text">Una fusión de sabor criollo.</p>
                        <a href="reservar.php?restaurante=sunampe&plato=Lomo%20Saltado" class="btn btn-primary w-100 mt-2">Reservar en Sunampe</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
$precios = [
    'Ceviche' => 25,
    'Arroz Chaufa' => 20,
    'Lomo Saltado' => 18
];

$platoSeleccionado = $_GET['plato'] ?? '';
$precioSeleccionado = isset($precios[$platoSeleccionado]) ? $precios[$platoSeleccionado] : null;
?>
<?php if ($platoSeleccionado && $precioSeleccionado): ?>
    <div class="alert alert-info text-center mb-4">
        Estás reservando: <strong><?php echo htmlspecialchars($platoSeleccionado); ?></strong> <br>
        Precio del menú: <strong>S/ <?php echo $precioSeleccionado; ?></strong>
    </div>
<?php endif; ?>
</body>
</html>
