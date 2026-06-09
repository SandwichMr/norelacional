<?php
if (!isset($nivel)) {
  $nivel = "";
}
if (!isset($titulo)) {
  $titulo = "Biblioteca";
}
$mensaje = isset($_GET["mensaje"]) ? $_GET["mensaje"] : "";
$error = isset($_GET["error"]) ? $_GET["error"] : "";
if ($error == "" && isset($errorSistema)) {
  $error = $errorSistema;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $titulo; ?></title>
  <link rel="stylesheet" href="<?php echo $nivel; ?>public/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $nivel; ?>public/icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?php echo $nivel; ?>public/css/estilos.css">
</head>
<body data-mensaje="<?php echo $mensaje; ?>" data-error="<?php echo $error; ?>">
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="<?php echo $nivel; ?>"><i class="bi bi-book-half"></i> Biblioteca</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="<?php echo $nivel; ?>"><i class="bi bi-house"></i> Inicio</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-journal-bookmark"></i> Libros</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?php echo $nivel; ?>libros/">Registrar</a></li>
              <li><a class="dropdown-item" href="<?php echo $nivel; ?>lista-libros/">Lista</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-person-lines-fill"></i> Autores</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?php echo $nivel; ?>autores/">Registrar</a></li>
              <li><a class="dropdown-item" href="<?php echo $nivel; ?>lista-autores/">Lista</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-people"></i> Usuarios</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?php echo $nivel; ?>usuarios/">Registrar</a></li>
              <li><a class="dropdown-item" href="<?php echo $nivel; ?>lista-usuarios/">Lista</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-arrow-left-right"></i> Prestamos</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?php echo $nivel; ?>prestamos/">Registrar</a></li>
              <li><a class="dropdown-item" href="<?php echo $nivel; ?>lista-prestamos/">Lista</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="<?php echo $nivel; ?>manual/"><i class="bi bi-file-earmark-text"></i> Manual</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <main class="container py-4">
