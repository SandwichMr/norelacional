<?php
include "../includes/db.php";
$titulo = "Lista de Prestamos";
$nivel = "../";
if ($_POST && isset($_POST["eliminar"])) {
  if (eliminar("prestamos", $_POST["id"])) {
    header("Location: ./?mensaje=Prestamo eliminado correctamente");
  } else {
    header("Location: ./?error=No se pudo eliminar el prestamo");
  }
  exit;
}
$prestamos = prestamosConDatos();
include "../includes/header.php";
?>

<div class="tabla-contenedor">
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <h2 class="titulo-seccion"><i class="bi bi-table"></i> Lista de prestamos</h2>
    <div>
      <a href="../prestamos/" class="btn btn-oro"><i class="bi bi-plus-circle"></i> Nuevo</a>
      <button class="btn btn-azul" onclick="imprimirPagina()"><i class="bi bi-printer"></i> Imprimir</button>
    </div>
  </div>
  <div class="alert alert-light border">
    Esta tabla usa aggregate(), $lookup, $unwind y $project para mostrar el usuario y el libro relacionado.
  </div>
  <div class="input-group mb-3">
    <span class="input-group-text"><i class="bi bi-search"></i></span>
    <input id="buscar" onkeyup="buscarTabla()" class="form-control" placeholder="Buscar o generar consulta en prestamos">
    <button class="btn btn-oro" onclick="buscarTabla()">Buscar</button>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead>
        <tr><th>Usuario</th><th>Libro</th><th>Fecha prestamo</th><th>Fecha entrega</th><th>Estado</th><th>Acciones</th></tr>
      </thead>
      <tbody>
        <?php foreach ($prestamos as $prestamo) { ?>
          <tr>
            <td><?php echo $prestamo->nombreUsuario; ?></td>
            <td><?php echo $prestamo->tituloLibro; ?></td>
            <td><?php echo $prestamo->fechaPrestamo; ?></td>
            <td><?php echo $prestamo->fechaEntrega; ?></td>
            <td><span class="badge badge-biblioteca"><?php echo $prestamo->estado; ?></span></td>
            <td>
              <a class="btn btn-sm btn-warning" href="../prestamos/?id=<?php echo $prestamo->_id; ?>"><i class="bi bi-pencil"></i></a>
              <form method="POST" class="d-inline" onsubmit="return confirmarEliminar(this)">
                <input type="hidden" name="id" value="<?php echo $prestamo->_id; ?>">
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
