<?php
$base = "biblioteca_juvenil";
$manager = new MongoDB\Driver\Manager("mongodb://127.0.0.1:27017");

function entrada() {
  $texto = file_get_contents("php://stdin");
  $datos = [];
  parse_str($texto, $datos);
  return $datos;
}

function responder($datos) {
  echo json_encode($datos);
}

function todos($coleccion) {
  global $manager, $base;
  $query = new MongoDB\Driver\Query([]);
  $filas = $manager->executeQuery($base . "." . $coleccion, $query)->toArray();
  $datos = [];
  foreach ($filas as $fila) {
    $fila->_id = (string)$fila->_id;
    $datos[] = $fila;
  }
  return $datos;
}

function uno($coleccion, $id) {
  global $manager, $base;
  $query = new MongoDB\Driver\Query(["_id" => new MongoDB\BSON\ObjectId($id)]);
  $filas = $manager->executeQuery($base . "." . $coleccion, $query)->toArray();
  if (count($filas) > 0) {
    $filas[0]->_id = (string)$filas[0]->_id;
    return $filas[0];
  }
  return null;
}

function insertar($coleccion, $datos) {
  global $manager, $base;
  $bulk = new MongoDB\Driver\BulkWrite;
  $bulk->insert($datos);
  $manager->executeBulkWrite($base . "." . $coleccion, $bulk);
}

function actualizar($coleccion, $id, $datos) {
  global $manager, $base;
  $bulk = new MongoDB\Driver\BulkWrite;
  $bulk->update(["_id" => new MongoDB\BSON\ObjectId($id)], ['$set' => $datos]);
  $manager->executeBulkWrite($base . "." . $coleccion, $bulk);
}

function eliminar($coleccion, $id) {
  global $manager, $base;
  $bulk = new MongoDB\Driver\BulkWrite;
  $bulk->delete(["_id" => new MongoDB\BSON\ObjectId($id)]);
  $manager->executeBulkWrite($base . "." . $coleccion, $bulk);
}
?>
