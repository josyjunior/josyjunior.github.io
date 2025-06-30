<?php
session_start();
include "db.php";

// Precios de los platos
$precios = [
    'Ceviche' => 25,
    'Arroz Chaufa' => 20,
    'Lomo Saltado' => 18
];

if (!isset($_SESSION["usuario"])) {
    $_SESSION["usuario"] = "Cliente"; // Cambiado de "Invitado" a "Cliente"
}
$usuario = $_SESSION["usuario"];

// Obtener restaurante desde GET o POST
$restaurante = $_GET['restaurante'] ?? $_POST['restaurante'] ?? null;
$plato = $_GET['plato'] ?? $_POST['plato'] ?? null;
$precioPlato = isset($precios[$plato]) ? $precios[$plato] : 0;

if (!$restaurante) {
    echo "Restaurante no especificado.";
    exit;
}

// Procesar reservas y cancelaciones
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["mesa"])) {
    $mesa = intval($_POST["mesa"]);
    $plato = $_POST['plato'] ?? $plato;

    if (isset($_POST["confirmar_cancelar"])) {
        // Confirmar cancelación
        $stmt = $conn->prepare("DELETE FROM reservas WHERE mesa = ? AND usuario = ? AND restaurante = ?");
        $stmt->bind_param("iss", $mesa, $usuario, $restaurante);
        $stmt->execute();
        $stmt->close();
        header("Location: reservar.php?restaurante=" . urlencode($restaurante));
        exit();
    } elseif (!isset($_POST["cancelar"])) {
        // Reservar
        $stmt = $conn->prepare("INSERT INTO reservas (mesa, usuario, restaurante, plato) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $mesa, $usuario, $restaurante, $plato);
        $stmt->execute();
        $stmt->close();
        $_SESSION["reservada"] = $mesa;
        // Redirigir directamente a pago.php después de reservar
        header("Location: pago.php");
        exit();
    }
}

// Obtener reservas actuales SOLO de este restaurante
$reservas = [];
$stmt = $conn->prepare("SELECT mesa, usuario FROM reservas WHERE restaurante = ?");
$stmt->bind_param("s", $restaurante);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $reservas[$row["mesa"]] = $row["usuario"];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar Mesas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            background: url('img/fondo.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .mesa-btn {
            width: 160px;
            height: 90px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(13,110,253,0.10);
            transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
            border: none;
        }
        .mesa-precio {
            font-size: 14px;
            font-weight: normal;
            color: #fff;
            background:rgb(37, 37, 172);
            border-radius: 10px;
            padding: 2px 8px;
            margin-top: 4px;
            display: inline-block;
        }
        .mesa-btn.btn-success {
            background: linear-gradient(90deg, #0d6efd 60%, #4f8cff 100%);
            color: #fff;
        }
        .mesa-btn.btn-success:hover {
            background: linear-gradient(90deg, #2563eb 60%, #60a5fa 100%);
            color: #fff;
            transform: scale(1.04);
            box-shadow: 0 8px 24px #0d6efd44;
        }
        .mesa-btn.btn-danger {
            background: linear-gradient(90deg, #dc3545 60%, #f87171 100%);
            color: #fff;
        }
        .mesa-btn.btn-danger:hover {
            background: linear-gradient(90deg, #b91c1c 60%, #f87171 100%);
            color: #fff;
            transform: scale(1.04);
            box-shadow: 0 8px 24px #dc354544;
        }
        .mesa-btn[disabled] {
            opacity: 0.7;
            background: linear-gradient(90deg, #64748b 60%, #94a3b8 100%);
            color: #fff;
        }
        // Estilos para el fondo y tarjetas  y precios
        .reservar-card {
            background: rgba(219, 208, 208, 0.92);
            border-radius: 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.10);
        }
        .main-title {
            font-weight: 700;
            color: #0d6efd;
            letter-spacing: 1px;
        }
        .btn-custom-secondary {
            border-radius: 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            font-size: 1.05rem;
            background: linear-gradient(90deg, #64748b 60%, #94a3b8 100%);
            color: #fff;
            box-shadow: 0 2px 8px #64748b33;
            border: none;
            transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
        }
        .btn-custom-secondary:hover {
            background: linear-gradient(90deg, #334155 60%, #64748b 100%);
            color: #fff;
            transform: scale(1.04);
            box-shadow: 0 4px 16px #64748b44;
        }
        .btn-custom {
            border-radius: 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            font-size: 1.05rem;
            background: linear-gradient(90deg, #0d6efd 60%, #4f8cff 100%);
            color: #fff;
            box-shadow: 0 2px 8px #0d6efd33;
            border: none;
            transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
        }
        .btn-custom:hover {
            background: linear-gradient(90deg, #2563eb 60%, #60a5fa 100%);
            color: #fff;
            transform: scale(1.04);
            box-shadow: 0 4px 16px #0d6efd44;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Cadena de Restaurantes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a href="login.php" class="btn btn-outline-light me-2">Inicio</a></li>
                    <li class="nav-item"><a href="menu.php" class="btn btn-outline-light me-2">Menú</a></li>
                    <li class="nav-item"><a href="mis_reservas.php" class="btn btn-outline-light me-2">Mesas Reservadas</a></li>
                    <li class="nav-item"><a href="contacto.php" class="btn btn-outline-light">Contacto</a></li>
                </ul>
                <a href="logout.php" class="btn btn-danger ms-auto">Salir</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="reservar-card p-4">
                    <h2 style="color: #fff; font-family: 'Montserrat', Arial, sans-serif; font-size: 2rem; font-weight: 700; letter-spacing: 1.5px; text-shadow: 2px 2px 8px #222;" class="main-title mb-6 text-center">
                        <?php if ($usuario !== ""): ?>
                            Reserve una mesa en línea!
                        <?php else: ?>
                            
                        <?php endif; ?>
                    </h2>

                    <!-- Botón para regresar a login.php -->
                    <div class="mb-3 text-end">
                        <a href="login.php" class="btn btn-custom-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
                    </div>

                    <?php if (isset($_SESSION["reservada"])): ?>
                        <div class="alert alert-success text-center">
                            ✅ Mesa Reservada <?php echo $_SESSION["reservada"]; ?><br>
                            <a href="pago.php?mesa=<?php echo urlencode($_SESSION["reservada"]); ?>&plato=<?php echo urlencode($plato); ?>&precio=<?php echo urlencode($precioPlato); ?>" class="btn btn-success mt-2">
                                Continuar con el pago <i class="bi bi-cash-coin"></i>
                            </a>
                        </div>
                        <?php unset($_SESSION["reservada"]); ?>
                    <?php endif; ?>

                    <div class="d-flex flex-wrap justify-content-center">
                        <?php for ($i = 1; $i <= 10; $i++): 
                            $ocupada = isset($reservas[$i]);
                            $reservadaPorUsuario = $ocupada && $reservas[$i] === $usuario;
                        ?>
                        <div class="m-2">
                            <?php if (isset($_POST["mesa"]) && $_POST["mesa"] == $i && isset($_POST["cancelar"])): ?>
                                <!-- Confirmación de cancelación -->
                                <form method="POST" action="">
                                    <input type="hidden" name="mesa" value="<?php echo $i; ?>">
                                    <input type="hidden" name="confirmar_cancelar" value="1">
                                    <input type="hidden" name="plato" value="<?php echo htmlspecialchars($plato); ?>">
                                    <div class="text-center">
                                        <p style="color: blak; font-weight: bold; text-shadow: 0 0 8px #0d6efd, 0 0 4px #fff;">
                                            ¿Cancelar reserva de la Mesa <?php echo $i; ?>?
                                        </p>
                                        <button type="submit" class="btn btn-danger btn-sm rounded-pill px-4">Sí</button>
                                        <a href="reservar.php?restaurante=<?php echo urlencode($restaurante); ?>&plato=<?php echo urlencode($plato); ?>" class="btn btn-custom-secondary btn-sm rounded-pill px-4">No</a>
                                    </div>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="">
                                    <input type="hidden" name="mesa" value="<?php echo $i; ?>">
                                    <input type="hidden" name="plato" value="<?php echo htmlspecialchars($plato); ?>">
                                    <?php if ($reservadaPorUsuario): ?>
                                        <input type="hidden" name="cancelar" value="1">
                                        <button type="submit" class="mesa-btn btn-danger">
                                            <i class="bi bi-x-circle"></i> Mesa <?php echo $i; ?><br>Cancelar
                                      
                                        </button>
                                    <?php elseif ($ocupada): ?>
                                        <button type="button" class="mesa-btn btn-danger" disabled>
                                            <i class="bi bi-lock-fill"></i> Mesa <?php echo $i; ?><br>Ocupada
                                            <br><small class="text-light">por <?php echo $reservas[$i]; ?></small>
                                           
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" class="mesa-btn btn-success">
                                            <i class="bi bi-check-circle"></i> Mesa <?php echo $i; ?><br>Reservar
                                            <?php if (!empty($plato) && isset($precios[$plato])): ?>
                                       
                                            <?php endif; ?>
                                        </button>
                                    <?php endif; ?>
                                </form>
                            <?php endif; ?>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>