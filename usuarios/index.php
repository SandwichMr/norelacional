<?php
include "../includes/db.php";
$titulo = "Usuarios";
$nivel = "../";
$usuario = null;
if (isset($_GET["id"])) {
  $usuario = uno("usuarios", $_GET["id"]);
}
if ($_POST) {
  $datos = [
    "nombre" => $_POST["nombre"],
    "telefono" => $_POST["telefono"],
    "correo" => $_POST["correo"],
    "grupo" => $_POST["grupo"]
  ];
  if (isset($_GET["id"])) {
    if (actualizar("usuarios", $_GET["id"], $datos)) {
      header("Location: ../lista-usuarios/?mensaje=Usuario actualizado correctamente");
    } else {
      header("Location: ./?id=" . $_GET["id"] . "&error=No se pudo actualizar el usuario");
    }
  } else {
    if (insertar("usuarios", $datos)) {
      header("Location: ./?mensaje=Usuario guardado correctamente");
    } else {
      header("Location: ./?error=No se pudo guardar el usuario");
    }
  }
  exit;
}
include "../includes/header.php";
?>

<div class="row justify-content-center">
  <div class="col-md-7">
    <div class="formulario">
      <h2 class="titulo-seccion mb-3"><i class="bi bi-people"></i> <?php echo $usuario ? "Editar usuario" : "Registrar usuario"; ?></h2>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" class="form-control" name="nombre" value="<?php echo texto($usuario, "nombre"); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Telefono</label>
          <input type="text" class="form-control" name="telefono" value="<?php echo texto($usuario, "telefono"); ?>" maxlength="10" pattern="[0-9]{10}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Correo</label>
          <input type="email" class="form-control" name="correo" value="<?php echo texto($usuario, "correo"); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Grupo</label>
          <input type="text" class="form-control" name="grupo" value="<?php echo texto($usuario, "grupo"); ?>" required>
        </div>
        <button class="btn btn-oro" type="submit"><i class="bi bi-save"></i> Guardar</button>
        <a href="../lista-usuarios/" class="btn btn-azul"><i class="bi bi-table"></i> Ver usuarios</a>
      </form>
    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
