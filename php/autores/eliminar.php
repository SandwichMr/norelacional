<?php
include __DIR__ . "/../conexion.php";
$d = entrada();
try {
  eliminar("autores", $d["id"]);
  responder(["ok" => true, "mensaje" => "Autor eliminado correctamente"]);
} catch (Exception $e) {
  responder(["ok" => false, "mensaje" => "No se pudo eliminar el autor"]);
}
?>
