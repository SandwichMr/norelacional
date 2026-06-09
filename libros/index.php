<?php
include "../includes/db.php";
$titulo = "Libros";
$nivel = "../";
$libro = null;
$autores = todos("autores");
if (isset($_GET["id"])) {
  $libro = uno("libros", $_GET["id"]);
}
if ($_POST) {
  $datos = [
    "titulo" => $_POST["titulo"],
    "genero" => $_POST["genero"],
    "anio" => intval($_POST["anio"]),
    "autorId" => new MongoDB\BSON\ObjectId($_POST["autorId"])
  ];
  if (isset($_GET["id"])) {
    if (actualizar("libros", $_GET["id"], $datos)) {
      header("Location: ../lista-libros/?mensaje=Libro actualizado correctamente");
    } else {
      header("Location: ./?id=" . $_GET["id"] . "&error=No se pudo actualizar el libro");
    }
  } else {
    if (insertar("libros", $datos)) {
      header("Location: ./?mensaje=Libro guardado correctamente");
    } else {
      header("Location: ./?error=No se pudo guardar el libro");
    }
  }
  exit;
}
include "../includes/header.php";
?>

<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="formulario">
      <h2 class="titulo-seccion mb-3"><i class="bi bi-journal-bookmark"></i> <?php echo $libro ? "Editar libro" : "Registrar libro"; ?></h2>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Titulo</label>
          <input type="text" class="form-control" name="titulo" value="<?php echo texto($libro, "titulo"); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Genero</label>
          <input type="text" class="form-control" name="genero" value="<?php echo texto($libro, "genero"); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Anio</label>
          <input type="number" class="form-control" name="anio" value="<?php echo texto($libro, "anio"); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Autor</label>
          <select class="form-select" name="autorId" required>
            <option value="">Seleccionar autor</option>
            <?php foreach ($autores as $autor) { ?>
              <option value="<?php echo $autor->_id; ?>" <?php echo $libro && isset($libro->autorId) && (string)$libro->autorId == (string)$autor->_id ? "selected" : ""; ?>><?php echo $autor->nombre; ?></option>
            <?php } ?>
          </select>
        </div>
        <button class="btn btn-oro" type="submit"><i class="bi bi-save"></i> Guardar</button>
        <a href="../lista-libros/" class="btn btn-azul"><i class="bi bi-table"></i> Ver libros</a>
      </form>
    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
