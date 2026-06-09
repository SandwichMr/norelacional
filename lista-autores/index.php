<?php
include "../includes/db.php";
$titulo = "Lista de Autores";
$nivel = "../";
if ($_POST && isset($_POST["eliminar"])) {
  if (eliminar("autores", $_POST["id"])) {
    header("Location: ./?mensaje=Autor eliminado correctamente");
  } else {
    header("Location: ./?error=No se pudo eliminar el autor");
  }
  exit;
}
$autores = todos("autores");
include "../includes/header.php";
?>

<div class="tabla-contenedor">
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <h2 class="titulo-seccion"><i class="bi bi-table"></i> Lista de autores</h2>
    <div>
      <a href="../autores/" class="btn btn-oro"><i class="bi bi-plus-circle"></i> Nuevo</a>
      <button class="btn btn-azul" onclick="imprimirPagina()"><i class="bi bi-printer"></i> Imprimir</button>
    </div>
  </div>
  <div class="input-group mb-3">
    <span class="input-group-text"><i class="bi bi-search"></i></span>
    <input id="buscar" onkeyup="buscarTabla()" class="form-control" placeholder="Buscar o generar consulta en autores">
    <button class="btn btn-oro" onclick="buscarTabla()">Buscar</button>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead>
        <tr><th>Nombre</th><th>Nacionalidad</th><th>Correo</th><th>Acciones</th></tr>
      </thead>
      <tbody>
        <?php foreach ($autores as $autor) { ?>
          <tr>
            <td><?php echo $autor->nombre; ?></td>
            <td><?php echo $autor->nacionalidad; ?></td>
            <td><?php echo $autor->correo; ?></td>
            <td>
              <a class="btn btn-sm btn-warning" href="../autores/?id=<?php echo $autor->_id; ?>"><i class="bi bi-pencil"></i></a>
              <form method="POST" class="d-inline" onsubmit="return confirmarEliminar(this)">
                <input type="hidden" name="id" value="<?php echo $autor->_id; ?>">
                <button class="btn btn-sm btn-danger" name="eliminar" value="1" type="submit"><i class="bi bi-trash"></i></button>
              </form>
              <button class="btn btn-sm btn-secondary" onclick="imprimirPagina()"><i class="bi bi-printer"></i></button>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
