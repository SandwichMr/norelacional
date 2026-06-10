<?php
include __DIR__ . "/../conexion.php";
$d = entrada();
try {
  $datos = [
    "nombre" => $d["nombre"],
    "nacionalidad" => $d["nacionalidad"],
    "correo" => $d["correo"]
  ];
  if ($d["id"] != "") {
    actualizar("autores", $d["id"], $datos);
    responder(["ok" => true, "mensaje" => "Autor actualizado correctamente"]);
  } else {
    insertar("autores", $datos);
    responder(["ok" => true, "mensaje" => "Autor guardado correctamente"]);
  }
} catch (Exception $e) {
  responder(["ok" => false, "mensaje" => "No se pudo guardar el autor"]);
}
?>
