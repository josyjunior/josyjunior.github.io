<?php
session_start();
include "db.php";

// Validar usuario
if (!isset($_SESSION["usuario"])) {
    $_SESSION["usuario"] = "Invitado"; // Reemplaza esto si tienes sistema de login
}
$usuario = $_SESSION["usuario"];

// Obtener reservas del usuario (mesa y restaurante)
$stmt = $conn->prepare("SELECT mesa, restaurante, plato FROM reservas WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

$reservas = [];
while ($row = $result->fetch_assoc()) {
    $reservas[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background-image: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }
        .card, .reservas-card, .container > div, .container, .bg-white {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }
        .reservas-card {
            border-radius: 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            background: #fff;
        }
        .main-title {
            font-weight: 700;
            color: #0d6efd;
            letter-spacing: 1px;
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="bi bi-egg-fried"></i> Cadena de Restaurantes</a>
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
                <a href="logout.php" class="btn btn-danger ms-auto"><i class="bi bi-box-arrow-right"></i> Salir</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="reservas-card p-4">
                    <h2 class="main-title mb-4 text-center">Reservas<?php; ?></h2>
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
                                    <?php endif; ?>
                                    <a href="reservar.php?restaurante=<?php echo urlencode($res['restaurante']); ?>" class="btn btn-sm btn-custom ms-auto">
                                        <i class="bi bi-arrow-repeat"></i> Volver a Reservar
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <a href="login.php" class="btn btn-custom-secondary">
                            <i class="bi bi-house-door"></i> Volver al Inicio
                        </a>
                        <a href="pago.php" class="btn btn-warning">
                            <i class="bi bi-credit-card"></i> Ir al Pago
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>