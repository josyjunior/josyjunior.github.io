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

$mesa = $_GET['mesa'] ?? null;
$plato = $_GET['plato'] ?? null;
$precio = $_GET['precio'] ?? null;

if (isset($_GET['cancelar_pago']) && $_GET['cancelar_pago'] == '1') {
    // Borra todas las reservas del usuario actual
    $stmt = $conn->prepare("DELETE FROM reservas WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->close();
    // Muestra mensaje de cancelación
    echo "<script>alert('Se canceló exitosamente'); window.location='pago.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago de Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }
        .card {
            border-radius: 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.10);
            background: transparent; /* Fondo totalmente transparente */
        }
        .alert-info {
            background-color: rgba(173, 216, 230, 0.5) !important; /* azul claro transparente */
            color: #0c5460 !important; /* mantiene el color de letra original */
            border: none;
        }
        .alert-warning {
            background-color: rgba(255, 193, 7, 0.5) !important; /* amarillo transparente */
            color: #856404 !important; /* mantiene el color de letra original */
            border: none;
        }
        .list-group-item {
            background: rgba(255,255,255,0.5) !important; /* Blanco translúcido */
            border: none !important;
        }
        h2 {
            color:rgb(255, 255, 255); /* Un marrón elegante */
            font-family: 'Playfair Display', 'Montserrat', Arial, sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-shadow: 2px 2px 8pxrgb(83, 81, 77);
        }
        .list-group-item,
        .alert-info,
        .alert-warning {
            border: none !important;
            box-shadow: none !important;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card p-4">
                    <h2 class="mb-4 text-center">
                        Detalle de Pago
                    </h2>
                    <?php if (count($reservas) === 0): ?>
                        <div class="alert alert-warning text-center" id="no-reservas-msg">❌ No tienes mesas reservadas.</div>
                    <?php else: ?>
                        <div id="detalle-pago">
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
                            <?php if ($mesa && $plato && $precio): ?>
                                <div class="alert alert-info text-center" id="detalle-extra">
                                    Mesa: <strong><?php echo htmlspecialchars($mesa); ?></strong><br>
                                    Plato: <strong><?php echo htmlspecialchars($plato); ?></strong><br>
                                    <span style="font-size:1.2em;">
                                        <strong>Total a pagar: S/ <?php echo htmlspecialchars($precio); ?></strong>
                                    </span>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info text-end" id="total-pago">
                                    <strong>Total a pagar: S/ <?php echo $total; ?></strong>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-center gap-2 mt-4" id="botones-pago">
                        <a href="menu.php" class="btn btn-primary" id="btn-menu">
                            <i class="bi bi-arrow-left"></i> Ir al menú
                        </a>
                        <button type="button" class="btn btn-warning" onclick="pagarYReservar()">
                            <i class="bi bi-cash-coin"></i> Pagar y Reservar
                        </button>
                        <button type="button" class="btn btn-danger" onclick="cancelarPago()">
                            <i class="bi bi-x-circle"></i> Cancelar Pago
                        </button>
                    </div>
                    <div class="d-flex justify-content-center gap-2 mt-4" id="boton-inicio" style="display:none;">
                        <a href="login.php" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i> Ir al inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
function pagarYReservar() {
    const reservas = document.querySelectorAll('.list-group-item');
    if (reservas.length === 0) {
        // Limpia todo el contenido de la tarjeta y muestra solo el mensaje
        const card = document.querySelector('.card.p-4');
        if (card) {
            card.innerHTML = `
                <div class="alert alert-warning text-center" style="font-size:1.2em; color: #fff;">
                    No tiene mesas reservadas ni pago, reserve una mesa
                </div>
                <div class="text-center mt-4">
                    <a href="login.php" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Ir al inicio
                    </a>
                </div>
            `;
        }
        return;
    }
    alert('¡Su pago y su reserva fue exitoso!');
    document.getElementById('botones-pago').style.display = 'none';
    document.getElementById('boton-inicio').style.display = 'flex';
}
function cancelarPago() {
    fetch('pago.php?cancelar_pago=1')
        .then(() => {
            alert('Se canceló correctamente');
            const card = document.querySelector('.card.p-4');
            if (card) {
                card.innerHTML = `
                    <div style="background:rgb(5, 6, 7); border-radius: 18px; box-shadow: 0 2px 12px rgba(0,0,0,0.10); padding: 40px 20px; min-height: 250px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <div class="alert text-center w-100 mb-4" style="background:rgb(41, 40, 39); color: #2563eb; font-size:1.2em; border: 1px solid #b6d4fe;">
                            <span style="font-size:2em; vertical-align:middle;">❌</span>
                            <span style="vertical-align:middle;">No tienes mesas reservadas.</span>
                        </div>
                        <a href="login.php" class="btn btn-primary mt-2">
                            <i class="bi bi-arrow-left"></i> Ir al inicio
                        </a>
                    </div>
                `;
            }
        });
}
    </script>
</body>
</html>