<?php
// Establecer los encabezados para la respuesta en formato JSON
header("Content-Type: application/json"); // Indica que la respuesta será en formato JSON
header("Access-Control-Allow-Origin: *"); // Permite el acceso desde cualquier origen
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Especifica los métodos HTTP permitidos
header("Access-Control-Allow-Headers: Content-Type"); // Permite el encabezado Content-Type

// Incluir archivos necesarios para la conexión a la base de datos y el controlador de usuario
require_once 'config/database.php'; // Archivo que maneja la conexión a la base de datos
require_once 'controllers/UserController.php'; // Archivo que contiene la lógica del controlador de usuarios

// Crear una instancia del controlador de usuarios
$userController = new UserController();

// Verificar el método HTTP de la solicitud y ejecutar la acción correspondiente
// Agregar caso para DELETE en el controlador
switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
      $data = json_decode(file_get_contents("php://input"), true);
      $response = $userController->createUser($data);
      echo json_encode($response);
      break;

  case 'GET':
      $response = $userController->getUsers();
      echo json_encode($response);
      break;

  case 'DELETE':
      // Suponiendo que el ID del usuario se pasa por parámetros URL
      $data = json_decode(file_get_contents("php://input"), true);
      $id = $data['id'] ?? null;

      if ($id) {
          $response = $userController->deleteUser($id);
      } else {
          $response = ["mensaje" => "ID de usuario no proporcionado"];
      }
      echo json_encode($response);
      break;

  case 'OPTIONS':
      // Preflight para CORS
      http_response_code(200);
      break;

  default:
      echo json_encode(["mensaje" => "Método no permitido"]);
      break;
}

?>
