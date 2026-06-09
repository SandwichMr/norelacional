<?php
include "../includes/db.php";
$titulo = "Lista de Usuarios";
$nivel = "../";
if ($_POST && isset($_POST["eliminar"])) {
  if (eliminar("usuarios", $_POST["id"])) {
    header("Location: ./?mensaje=Usuario eliminado correctamente");
  } else {
    header("Location: ./?error=No se pudo eliminar el usuario");
  }
  exit;
}
$usuarios = todos("usuarios");
include "../includes/header.php";
?>

<div class="tabla-contenedor">
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <h2 class="titulo-seccion"><i class="bi bi-table"></i> Lista de usuarios</h2>
    <div>
      <a href="../usuarios/" class="btn btn-oro"><i class="bi bi-plus-circle"></i> Nuevo</a>
      <button class="btn btn-azul" onclick="imprimirPagina()"><i class="bi bi-printer"></i> Imprimir</button>
    </div>
  </div>
  <div class="input-group mb-3">
    <span class="input-group-text"><i class="bi bi-search"></i></span>
    <input id="buscar" onkeyup="buscarTabla()" class="form-control" placeholder="Buscar o generar consulta en usuarios">
    <button class="btn btn-oro" onclick="buscarTabla()">Buscar</button>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead>
        <tr><th>Nombre</th><th>Telefono</th><th>Correo</th><th>Grupo</th><th>Acciones</th></tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $usuario) { ?>
          <tr>
            <td><?php echo $usuario->nombre; ?></td>
            <td><?php echo $usuario->telefono; ?></td>
            <td><?php echo $usuario->correo; ?></td>
            <td><?php echo $usuario->grupo; ?></td>
            <td>
              <a class="btn btn-sm btn-warning" href="../usuarios/?id=<?php echo $usuario->_id; ?>"><i class="bi bi-pencil"></i></a>
              <form method="POST" class="d-inline" onsubmit="return confirmarEliminar(this)">
                <input type="hidden" name="id" value="<?php echo $usuario->_id; ?>">
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
