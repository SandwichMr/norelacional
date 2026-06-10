<?php
include __DIR__ . "/../conexion.php";
$d = entrada();
try {
  eliminar("usuarios", $d["id"]);
  responder(["ok" => true, "mensaje" => "Usuario eliminado correctamente"]);
} catch (Exception $e) {
  responder(["ok" => false, "mensaje" => "No se pudo eliminar el usuario"]);
}
?>
