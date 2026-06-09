<?php
include "../includes/db.php";
$titulo = "Autores";
$nivel = "../";
$autor = null;
if (isset($_GET["id"])) {
  $autor = uno("autores", $_GET["id"]);
}
if ($_POST) {
  $datos = [
    "nombre" => $_POST["nombre"],
    "nacionalidad" => $_POST["nacionalidad"],
    "correo" => $_POST["correo"]
  ];
  if (isset($_GET["id"])) {
    if (actualizar("autores", $_GET["id"], $datos)) {
      header("Location: ../lista-autores/?mensaje=Autor actualizado correctamente");
    } else {
      header("Location: ./?id=" . $_GET["id"] . "&error=No se pudo actualizar el autor");
    }
  } else {
    if (insertar("autores", $datos)) {
      header("Location: ./?mensaje=Autor guardado correctamente");
    } else {
      header("Location: ./?error=No se pudo guardar el autor");
    }
  }
  exit;
}
include "../includes/header.php";
?>

<div class="row justify-content-center">
  <div class="col-md-7">
    <div class="formulario">
      <h2 class="titulo-seccion mb-3"><i class="bi bi-person-lines-fill"></i> <?php echo $autor ? "Editar autor" : "Registrar autor"; ?></h2>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" class="form-control" name="nombre" value="<?php echo texto($autor, "nombre"); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Nacionalidad</label>
          <input type="text" class="form-control" name="nacionalidad" value="<?php echo texto($autor, "nacionalidad"); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Correo</label>
          <input type="email" class="form-control" name="correo" value="<?php echo texto($autor, "correo"); ?>" required>
        </div>
        <button class="btn btn-oro" type="submit"><i class="bi bi-save"></i> Guardar</button>
        <a href="../lista-autores/" class="btn btn-azul"><i class="bi bi-table"></i> Ver autores</a>
      </form>
    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
