<?php
$titulo = "Biblioteca";
$nivel = "";
include "includes/header.php";
?>

<section class="hero mb-4">
  <div class="row g-0 align-items-center">
    <div class="col-md-6 p-5">
      <h1 class="display-5 fw-bold">Biblioteca Juvenil</h1>
      <p class="lead">Sistema web sencillo en PHP y MongoDB para administrar libros, autores, usuarios y prestamos de una biblioteca escolar pequena.</p>
      <a href="libros/" class="btn btn-oro me-2"><i class="bi bi-plus-circle"></i> Registrar libro</a>
      <a href="lista-libros/" class="btn btn-light"><i class="bi bi-table"></i> Ver libros</a>
    </div>
    <div class="col-md-6">
      <img src="public/img/img1.jpg" alt="Biblioteca">
    </div>
  </div>
</section>

<div class="row g-4">
  <div class="col-md-3">
    <div class="card tarjeta h-100">
      <img src="public/img/img2.jpg" class="card-img-top" alt="Libros">
      <div class="card-body">
        <h5 class="card-title"><i class="bi bi-journal-bookmark"></i> Libros</h5>
        <p class="card-text">Registro y consulta de libros escolares.</p>
        <a href="libros/" class="btn btn-azul w-100">Entrar</a>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card tarjeta h-100">
      <img src="public/img/img3.jpg" class="card-img-top" alt="Autores">
      <div class="card-body">
        <h5 class="card-title"><i class="bi bi-person-lines-fill"></i> Autores</h5>
        <p class="card-text">Datos basicos de autores y correos.</p>
        <a href="autores/" class="btn btn-azul w-100">Entrar</a>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card tarjeta h-100">
      <img src="public/img/img4.jpg" class="card-img-top" alt="Usuarios">
      <div class="card-body">
        <h5 class="card-title"><i class="bi bi-people"></i> Usuarios</h5>
        <p class="card-text">Alumnos registrados en biblioteca.</p>
        <a href="usuarios/" class="btn btn-azul w-100">Entrar</a>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card tarjeta h-100">
      <img src="public/img/img5.jpg" class="card-img-top" alt="Prestamos">
      <div class="card-body">
        <h5 class="card-title"><i class="bi bi-arrow-left-right"></i> Prestamos</h5>
        <p class="card-text">Control simple de libros prestados.</p>
        <a href="prestamos/" class="btn btn-azul w-100">Entrar</a>
      </div>
    </div>
  </div>
</div>

<div class="row g-4 mt-2">
  <div class="col-md-4"><img class="imagen-chica" src="public/img/img6.jpg" alt="Decoracion"></div>
  <div class="col-md-4"><img class="imagen-chica" src="public/img/img7.jpg" alt="Decoracion"></div>
  <div class="col-md-4"><img class="imagen-chica" src="public/img/img8.jpg" alt="Decoracion"></div>
</div>

<?php include "includes/footer.php"; ?>
