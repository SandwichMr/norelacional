<?php
include __DIR__ . "/../conexion.php";
$d = entrada();
try {
  eliminar("prestamos", $d["id"]);
  responder(["ok" => true, "mensaje" => "Prestamo eliminado correctamente"]);
} catch (Exception $e) {
  responder(["ok" => false, "mensaje" => "No se pudo eliminar el prestamo"]);
}
?>
