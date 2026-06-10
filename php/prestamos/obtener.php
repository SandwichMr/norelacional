<?php
include __DIR__ . "/../conexion.php";
parse_str(getenv("QUERY_STRING"), $q);
try {
  $prestamo = uno("prestamos", $q["id"]);
  if ($prestamo) {
    $prestamo->libroId = (string)$prestamo->libroId;
    $prestamo->usuarioId = (string)$prestamo->usuarioId;
  }
  responder(["ok" => true, "dato" => $prestamo]);
} catch (Exception $e) {
  responder(["ok" => false, "mensaje" => "No se pudo cargar el prestamo"]);
}
?>
