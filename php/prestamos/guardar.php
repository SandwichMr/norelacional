<?php
include __DIR__ . "/../conexion.php";
$d = entrada();
try {
  $datos = [
    "libroId" => new MongoDB\BSON\ObjectId($d["libroId"]),
    "usuarioId" => new MongoDB\BSON\ObjectId($d["usuarioId"]),
    "fechaPrestamo" => $d["fechaPrestamo"],
    "fechaEntrega" => $d["fechaEntrega"],
    "estado" => $d["estado"]
  ];
  if ($d["id"] != "") {
    actualizar("prestamos", $d["id"], $datos);
    responder(["ok" => true, "mensaje" => "Prestamo actualizado correctamente"]);
  } else {
    insertar("prestamos", $datos);
    responder(["ok" => true, "mensaje" => "Prestamo guardado correctamente"]);
  }
} catch (Exception $e) {
  responder(["ok" => false, "mensaje" => "No se pudo guardar el prestamo"]);
}
?>
