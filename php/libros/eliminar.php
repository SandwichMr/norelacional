<?php
include __DIR__ . "/../conexion.php";
$d = entrada();
try {
  eliminar("libros", $d["id"]);
  responder(["ok" => true, "mensaje" => "Libro eliminado correctamente"]);
} catch (Exception $e) {
  responder(["ok" => false, "mensaje" => "No se pudo eliminar el libro"]);
}
?>
