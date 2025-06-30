<!-- contacto.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacto - Restaurante</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
            min-height: 100vh;
        }
        .contact-card {
            border-radius: 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            background: #fff;
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
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="bi bi-egg-fried"></i> Cadena de Restaurantes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="login.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="mis_reservas.php">Mesas Reservadas</a></li>
                    <li class="nav-item"><a class="nav-link active" href="contacto.php">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <div class="container mt-5">
        <h1 class="mb-4 text-primary text-center">Información de Contacto</h1>
        <div class="card contact-card shadow p-4 mx-auto" style="max-width: 500px;">
            <p><strong>🍽 Restaurante:</strong>Olivar,Batna,sunampe</p>
            <p><strong>📍 Dirección:</strong> Av. Principal 123, Chincha Alta</p>
            <p><strong>📞 Teléfono:</strong> (056) 123-456</p>
            <p><strong>✉️ Correo:</strong> Josycarbajal@elolivar.com</p>
            <p><strong>🕘 Horario de atención:</strong> Lunes a Domingo, 9:00 AM – 10:00 PM</p>

             <p><strong>Desarrollador:</strong> Hola mi nombre es Josy 
            me dedico a crear paginas web para Restaurante y centro comerciales
        espero que mi pagina web sea de su agrado</p>
        </div>
        <!-- Botón para volver a login.php -->
        <div class="text-center">
            <a href="login.php" class="btn btn-custom mt-4"><i class="bi bi-arrow-left-circle"></i> Volver</a>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
