<?php
include __DIR__ . "/../conexion.php";
$d = entrada();
try {
  $datos = [
    "titulo" => $d["titulo"],
    "genero" => $d["genero"],
    "anio" => intval($d["anio"]),
    "autorId" => new MongoDB\BSON\ObjectId($d["autorId"])
  ];
  if ($d["id"] != "") {
    actualizar("libros", $d["id"], $datos);
    responder(["ok" => true, "mensaje" => "Libro actualizado correctamente"]);
  } else {
    insertar("libros", $datos);
    responder(["ok" => true, "mensaje" => "Libro guardado correctamente"]);
  }
} catch (Exception $e) {
  responder(["ok" => false, "mensaje" => "No se pudo guardar el libro"]);
}
?>
