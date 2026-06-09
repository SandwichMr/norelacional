<?php
$nombreBase = "biblioteca_juvenil";
$manager = new MongoDB\Driver\Manager("mongodb://127.0.0.1:27017");
$errorSistema = "";

function todos($coleccion) {
  global $manager, $nombreBase, $errorSistema;
  try {
    $query = new MongoDB\Driver\Query([]);
    return $manager->executeQuery($nombreBase . "." . $coleccion, $query)->toArray();
  } catch (Exception $e) {
    $errorSistema = "No se pudo conectar con MongoDB";
    return [];
  }
}

function uno($coleccion, $id) {
  global $manager, $nombreBase, $errorSistema;
  try {
    $query = new MongoDB\Driver\Query(["_id" => new MongoDB\BSON\ObjectId($id)]);
    $resultado = $manager->executeQuery($nombreBase . "." . $coleccion, $query)->toArray();
    if (count($resultado) > 0) {
      return $resultado[0];
    }
  } catch (Exception $e) {
    $errorSistema = "No se pudo conectar con MongoDB";
  }
  return null;
}

function insertar($coleccion, $datos) {
  global $manager, $nombreBase, $errorSistema;
  try {
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->insert($datos);
    $manager->executeBulkWrite($nombreBase . "." . $coleccion, $bulk);
    return true;
  } catch (Exception $e) {
    $errorSistema = "No se pudo guardar en MongoDB";
    return false;
  }
}

function actualizar($coleccion, $id, $datos) {
  global $manager, $nombreBase, $errorSistema;
  try {
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->update(["_id" => new MongoDB\BSON\ObjectId($id)], ['$set' => $datos]);
    $manager->executeBulkWrite($nombreBase . "." . $coleccion, $bulk);
    return true;
  } catch (Exception $e) {
    $errorSistema = "No se pudo actualizar en MongoDB";
    return false;
  }
}

function eliminar($coleccion, $id) {
  global $manager, $nombreBase, $errorSistema;
  try {
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->delete(["_id" => new MongoDB\BSON\ObjectId($id)]);
    $manager->executeBulkWrite($nombreBase . "." . $coleccion, $bulk);
    return true;
  } catch (Exception $e) {
    $errorSistema = "No se pudo eliminar en MongoDB";
    return false;
  }
}

function prestamosConDatos() {
  global $manager, $nombreBase, $errorSistema;
  try {
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
    return $manager->executeCommand($nombreBase, $comando)->toArray();
  } catch (Exception $e) {
    $errorSistema = "No se pudo conectar con MongoDB";
    return [];
  }
}

function texto($objeto, $campo) {
  if ($objeto && isset($objeto->$campo)) {
    return $objeto->$campo;
  }
  return "";
}
?>
