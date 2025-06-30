<?php
session_start();
include "db.php";

// Validar usuario
if (!isset($_SESSION["usuario"])) {
    $_SESSION["usuario"] = "Invitado";
}
$usuario = $_SESSION["usuario"];

// Precios de los platos
$precios = [
    'Ceviche' => 25,
    'Arroz Chaufa' => 20,
    'Lomo Saltado' => 18
];

// Obtener reservas del usuario
$stmt = $conn->prepare("SELECT mesa, restaurante, plato FROM reservas WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

$reservas = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $plato = $row['plato'] ?? '';
    $precio = isset($precios[$plato]) ? $precios[$plato] : 0;
    $row['precio'] = $precio;
    $total += $precio;
    $reservas[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Total de Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg,rgb(110, 136, 221) 0%,rgb(80, 140, 201) 100%);
            min-height: 100vh;
        }
        .total-card {
            border-radius: 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            background: #fff;
            margin-top: 50px;
        }
        .main-title {
            font-weight: 700;
            color: #0d6efd;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="total-card p-4">
                    <h2 class="main-title mb-4 text-center">Total de Reservas de <?php echo htmlspecialchars($usuario); ?></h2>
                    <?php if (count($reservas) === 0): ?>
                        <div class="alert alert-warning text-center">❌ No tienes mesas reservadas.</div>
                    <?php else: ?>
                        <ul class="list-group mb-3">
                            <?php foreach ($reservas as $res): ?>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Mesa <strong class="ms-2"><?php echo $res['mesa']; ?></strong>
                                    <span class="ms-3 badge bg-primary"><?php echo ucfirst($res['restaurante']); ?></span>
                                    <?php if (!empty($res['plato'])): ?>
                                        <span class="ms-3 badge bg-success"><?php echo htmlspecialchars($res['plato']); ?></span>
                                        <span class="ms-3 badge bg-warning text-dark">S/ <?php echo $res['precio']; ?></span>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="alert alert-info text-end">
                            <strong>Total a pagar: S/ <?php echo $total; ?></strong>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <a href="mis_reservas.php" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i> Volver a Reservas
                        </a>
                        <a href="menu.php" class="btn btn-secondary">
                            <i class="bi bi-list"></i> Ir al Menú
                        </a>
                        <a href="login.php" class="btn btn-success">
                            <i class="bi bi-house-door"></i> Ir al Inicio
                        </a>
                        <a href="pago.php" class="btn btn-warning">
                            <i class="bi bi-credit-card"></i> Ver Pago
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>