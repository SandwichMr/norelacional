<?php
include __DIR__ . "/../conexion.php";
parse_str(getenv("QUERY_STRING"), $q);
try {
  responder(["ok" => true, "dato" => uno("usuarios", $q["id"])]);
} catch (Exception $e) {
  responder(["ok" => false, "mensaje" => "No se pudo cargar el usuario"]);
}
?>
