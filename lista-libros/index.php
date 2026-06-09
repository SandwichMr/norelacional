<?php
include "../includes/db.php";
$titulo = "Lista de Libros";
$nivel = "../";
if ($_POST && isset($_POST["eliminar"])) {
  if (eliminar("libros", $_POST["id"])) {
    header("Location: ./?mensaje=Libro eliminado correctamente");
  } else {
    header("Location: ./?error=No se pudo eliminar el libro");
  }
  exit;
}
$libros = todos("libros");
$autores = todos("autores");
$mapaAutores = [];
foreach ($autores as $autor) {
  $mapaAutores[(string)$autor->_id] = $autor->nombre;
}
include "../includes/header.php";
?>

<div class="tabla-contenedor">
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <h2 class="titulo-seccion"><i class="bi bi-table"></i> Lista de libros</h2>
    <div>
      <a href="../libros/" class="btn btn-oro"><i class="bi bi-plus-circle"></i> Nuevo</a>
      <button class="btn btn-azul" onclick="imprimirPagina()"><i class="bi bi-printer"></i> Imprimir</button>
    </div>
  </div>
  <div class="input-group mb-3">
    <span class="input-group-text"><i class="bi bi-search"></i></span>
    <input id="buscar" onkeyup="buscarTabla()" class="form-control" placeholder="Buscar o generar consulta en libros">
    <button class="btn btn-oro" onclick="buscarTabla()">Buscar</button>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead>
        <tr><th>Titulo</th><th>Genero</th><th>Anio</th><th>Autor</th><th>Acciones</th></tr>
      </thead>
      <tbody>
        <?php foreach ($libros as $libro) { ?>
          <tr>
            <td><?php echo $libro->titulo; ?></td>
            <td><?php echo $libro->genero; ?></td>
            <td><?php echo $libro->anio; ?></td>
            <td><?php echo isset($mapaAutores[(string)$libro->autorId]) ? $mapaAutores[(string)$libro->autorId] : "Sin autor"; ?></td>
            <td>
              <a class="btn btn-sm btn-warning" href="../libros/?id=<?php echo $libro->_id; ?>"><i class="bi bi-pencil"></i></a>
              <form method="POST" class="d-inline" onsubmit="return confirmarEliminar(this)">
                <input type="hidden" name="id" value="<?php echo $libro->_id; ?>">
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
