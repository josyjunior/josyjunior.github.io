<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadena de Restaurantes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <style>
      body {
        background: linear-gradient(135deg,rgb(155, 168, 228) 0%, #f8fafc 100%);
        min-height: 100vh;
      }
      .img-hover-3d {
        opacity: 0.7;
        transition: all 0.3s ease;
        transform-style: preserve-3d;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        height: 400px;
        object-fit: cover;
        border-top-left-radius: 18px;
        border-top-right-radius: 18px;
        width: 100%;
      }
      .img-hover-3d:hover {
        opacity: 1;
        transform: scale(1.05) rotateY(5deg);
        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
      }
      .rest-card {
        border-radius: 18px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        transition: box-shadow 0.2s;
        border: 2px solid #0d6efd1a;
      }
      .rest-card:hover {
        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        border-color: #0d6efd;
      }
      .navbar-brand {
        font-weight: bold;
        letter-spacing: 1px;
      }
      .navbar-nav .btn {
        margin-right: 8px;
        border-radius: 20px;
        font-weight: 500;
        letter-spacing: 0.5px;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
      }
      .navbar-nav .btn:hover {
        background: #0d6efd;
        color: #fff;
        box-shadow: 0 2px 8px #0d6efd33;
      }
      .main-title {
        margin-top: 90px;
        font-weight: 700;
        color:rgb(255, 255, 255);
        letter-spacing: 1px;
        text-shadow: 1px 2px 8pxrgb(15, 16, 20);
      }
      .lead {
        color: #444;
      }
      .btn-reservar {
        border-radius: 20px;
        font-weight: 600;
        letter-spacing: 0.5px;
        font-size: 1.1rem;
        background: linear-gradient(90deg, #0d6efd 60%, #4f8cff 100%);
        color: #fff;
        box-shadow: 0 2px 8px #0d6efd33;
        border: none;
        transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
      }
      .btn-reservar:hover {
        background: linear-gradient(90deg, #2563eb 60%, #60a5fa 100%);
        color: #fff;
        transform: scale(1.04);
        box-shadow: 0 4px 16px #0d6efd44;
      }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="bi bi-egg-fried"></i> Cadena de Restaurantes</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a href="login.php" class="btn btn-outline-light"><i class="bi bi-house-door"></i> Inicio</a>
            </li>
            <li class="nav-item">
              <a href="menu.php" class="btn btn-outline-light"><i class="bi bi-list"></i> Menú</a>
            </li>
            <li class="nav-item">
              <a href="mis_reservas.php" class="btn btn-outline-light"><i class="bi bi-calendar-check"></i> Mesas Reservadas</a>
            </li>
            <li class="nav-item">
              <a href="contacto.php" class="btn btn-outline-light"><i class="bi bi-envelope"></i> Contacto</a>
            </li>
          </ul>

          </a>   
          <a href="logout.php" class="btn btn-danger ms-auto"><i class="bi bi-box-arrow-right"></i> Salir</a>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="container text-center">
      <h1 class="main-title mb-10">Bienvenidos a nuestra Cadena de Restaurantes - Chincha</h1>
      <p class="lead mb-5" style="font-family: 'Pacifico', cursive, 'Segoe UI', Arial, sans-serif; font-size: 1.5rem; color: #2b6777; font-weight: 500; letter-spacing: 1.5px; text-shadow: 1px 1px 8px #e0e0e0;">
        Disfruta de la mejor experiencia gastronómica con nosotros en nuestra provincia.
      </p>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card rest-card h-100">
            <img src="img/olivar.jpg" alt="Restaurante El Olivar" class="card-img-top img-hover-3d">
            <div class="card-body">
              <h5 class="card-title">El Olivar</h5>
              <p class="card-text">Ubicación: Grocio Prado</p>
              <a href="reservar.php?restaurante=olivar" class="btn btn-reservar w-100"><i class="bi bi-calendar-plus"></i> Reservar en Olivar</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card rest-card h-100">
            <img src="img/batan.jpg" alt="Restaurante Batan" class="card-img-top img-hover-3d">
            <div class="card-body">
              <h5 class="card-title">Batan</h5>
              <p class="card-text">Ubicación: Chincha</p>
              <a href="reservar.php?restaurante=batan" class="btn btn-reservar w-100"><i class="bi bi-calendar-plus"></i> Reservar en Batan</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card rest-card h-100">
            <img src="img/img.jpg" alt="Restaurante Sunampe" class="card-img-top img-hover-3d">
            <div class="card-body">
              <h5 class="card-title">Sunampe</h5>
              <p class="card-text">Ubicación: Sunampe</p>
              <a href="reservar.php?restaurante=sunampe" class="btn btn-reservar w-100"><i class="bi bi-calendar-plus"></i> Reservar en Sunampe</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
      <p class="mb-0">&copy; 2025 Cadena de Restaurantes Chincha. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>