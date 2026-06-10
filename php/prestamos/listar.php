<?php
include __DIR__ . "/../conexion.php";
try {
  global $manager, $base;
  $comando = new MongoDB\Driver\Command([
    "aggregate" => "prestamos",
    "pipeline" => [
      [
        '$lookup' => [
          "from" => "libros",
          "localField" => "libroId",
          "foreignField" => "_id",
          "as" => "libro"
        ]
      ],
      [
        '$lookup' => [
          "from" => "usuarios",
          "localField" => "usuarioId",
          "foreignField" => "_id",
          "as" => "usuario"
        ]
      ],
      ['$unwind' => '$libro'],
      ['$unwind' => '$usuario'],
      [
        '$project' => [
          "libroId" => 1,
          "usuarioId" => 1,
          "nombreUsuario" => '$usuario.nombre',
          "tituloLibro" => '$libro.titulo',
          "fechaPrestamo" => 1,
          "fechaEntrega" => 1,
          "estado" => 1
        ]
      ]
    ],
    "cursor" => new stdClass
  ]);
  $prestamos = $manager->executeCommand($base, $comando)->toArray();
  foreach ($prestamos as $prestamo) {
    $prestamo->_id = (string)$prestamo->_id;
    $prestamo->libroId = (string)$prestamo->libroId;
    $prestamo->usuarioId = (string)$prestamo->usuarioId;
  }
  responder(["ok" => true, "datos" => $prestamos]);
} catch (Exception $e) {
  responder(["ok" => false, "mensaje" => "No se pudieron cargar los prestamos"]);
}
?>
