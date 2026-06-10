<?php
include __DIR__ . "/../conexion.php";
try {
  responder(["ok" => true, "datos" => todos("usuarios")]);
} catch (Exception $e) {
  responder(["ok" => false, "mensaje" => "No se pudieron cargar los usuarios"]);
}
?>
