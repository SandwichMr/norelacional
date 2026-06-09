<?php
include "../includes/db.php";
$titulo = "Prestamos";
$nivel = "../";
$prestamo = null;
$libros = todos("libros");
$usuarios = todos("usuarios");
if (isset($_GET["id"])) {
  $prestamo = uno("prestamos", $_GET["id"]);
}
if ($_POST) {
  $datos = [
    "libroId" => new MongoDB\BSON\ObjectId($_POST["libroId"]),
    "usuarioId" => new MongoDB\BSON\ObjectId($_POST["usuarioId"]),
    "fechaPrestamo" => $_POST["fechaPrestamo"],
    "fechaEntrega" => $_POST["fechaEntrega"],
    "estado" => $_POST["estado"]
  ];
  if (isset($_GET["id"])) {
    if (actualizar("prestamos", $_GET["id"], $datos)) {
      header("Location: ../lista-prestamos/?mensaje=Prestamo actualizado correctamente");
    } else {
      header("Location: ./?id=" . $_GET["id"] . "&error=No se pudo actualizar el prestamo");
    }
  } else {
    if (insertar("prestamos", $datos)) {
      header("Location: ./?mensaje=Prestamo guardado correctamente");
    } else {
      header("Location: ./?error=No se pudo guardar el prestamo");
    }
  }
  exit;
}
include "../includes/header.php";
?>

<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="formulario">
      <h2 class="titulo-seccion mb-3"><i class="bi bi-arrow-left-right"></i> <?php echo $prestamo ? "Editar prestamo" : "Registrar prestamo"; ?></h2>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Libro</label>
          <select class="form-select" name="libroId" required>
            <option value="">Seleccionar libro</option>
            <?php foreach ($libros as $libro) { ?>
              <option value="<?php echo $libro->_id; ?>" <?php echo $prestamo && isset($prestamo->libroId) && (string)$prestamo->libroId == (string)$libro->_id ? "selected" : ""; ?>><?php echo $libro->titulo; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Usuario</label>
          <select class="form-select" name="usuarioId" required>
            <option value="">Seleccionar usuario</option>
            <?php foreach ($usuarios as $usuario) { ?>
              <option value="<?php echo $usuario->_id; ?>" <?php echo $prestamo && isset($prestamo->usuarioId) && (string)$prestamo->usuarioId == (string)$usuario->_id ? "selected" : ""; ?>><?php echo $usuario->nombre; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Fecha prestamo</label>
            <input type="date" class="form-control" name="fechaPrestamo" value="<?php echo texto($prestamo, "fechaPrestamo"); ?>" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Fecha entrega</label>
            <input type="date" class="form-control" name="fechaEntrega" value="<?php echo texto($prestamo, "fechaEntrega"); ?>" required>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Estado</label>
          <select class="form-select" name="estado" required>
            <option value="">Seleccionar estado</option>
            <option value="Prestado" <?php echo texto($prestamo, "estado") == "Prestado" ? "selected" : ""; ?>>Prestado</option>
            <option value="Entregado" <?php echo texto($prestamo, "estado") == "Entregado" ? "selected" : ""; ?>>Entregado</option>
            <option value="Retrasado" <?php echo texto($prestamo, "estado") == "Retrasado" ? "selected" : ""; ?>>Retrasado</option>
          </select>
        </div>
        <button class="btn btn-oro" type="submit"><i class="bi bi-save"></i> Guardar</button>
        <a href="../lista-prestamos/" class="btn btn-azul"><i class="bi bi-table"></i> Ver prestamos</a>
      </form>
    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
