<?php
include __DIR__ . "/../conexion.php";
try {
  $libros = todos("libros");
  $autores = todos("autores");
  $mapa = [];
  foreach ($autores as $autor) {
    $mapa[$autor->_id] = $autor->nombre;
  }
  foreach ($libros as $libro) {
    $libro->autorNombre = "Sin autor";
    if (isset($libro->autorId)) {
      $id = (string)$libro->autorId;
      $libro->autorId = $id;
      if (isset($mapa[$id])) {
        $libro->autorNombre = $mapa[$id];
      }
    }
  }
  responder(["ok" => true, "datos" => $libros]);
} catch (Exception $e) {
  responder(["ok" => false, "mensaje" => "No se pudieron cargar los libros"]);
}
?>
