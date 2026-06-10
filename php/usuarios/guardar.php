<?php
include __DIR__ . "/../conexion.php";
$d = entrada();
try {
  $datos = [
    "nombre" => $d["nombre"],
    "telefono" => $d["telefono"],
    "correo" => $d["correo"],
    "grupo" => $d["grupo"]
  ];
  if ($d["id"] != "") {
    actualizar("usuarios", $d["id"], $datos);
    responder(["ok" => true, "mensaje" => "Usuario actualizado correctamente"]);
  } else {
    insertar("usuarios", $datos);
    responder(["ok" => true, "mensaje" => "Usuario guardado correctamente"]);
  }
} catch (Exception $e) {
  responder(["ok" => false, "mensaje" => "No se pudo guardar el usuario"]);
}
?>
