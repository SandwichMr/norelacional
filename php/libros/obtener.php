<?php
include __DIR__ . "/../conexion.php";
parse_str(getenv("QUERY_STRING"), $q);
try {
  $libro = uno("libros", $q["id"]);
  if ($libro && isset($libro->autorId)) {
    $libro->autorId = (string)$libro->autorId;
  }
  responder(["ok" => true, "dato" => $libro]);
} catch (Exception $e) {
  responder(["ok" => false, "mensaje" => "No se pudo cargar el libro"]);
}
?>
