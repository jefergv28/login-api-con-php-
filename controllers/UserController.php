<?php
// Incluye el archivo de conexión a la base de datos
require_once 'config/database.php';

class UserController {

    // Función para crear un nuevo usuario
    public function createUser($data) {
        global $conexion;

        // Validación básica
        if (isset($data['nombre']) && isset($data['contrasena'])) {
            $nombre = $data['nombre'];
            $contrasena = password_hash($data['contrasena'], PASSWORD_DEFAULT); // Seguridad: Hash de la contraseña

            // Verificar si el nombre de usuario ya existe
            $query_check = "SELECT id FROM usuarios WHERE nombre = ?";
            $stmt_check = $conexion->prepare($query_check);
            $stmt_check->bind_param("s", $nombre);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows > 0) {
                return ["mensaje" => "El nombre de usuario ya existe"];
            }

            // Consulta para insertar el nuevo usuario
            $query = "INSERT INTO usuarios (nombre, contrasena) VALUES (?, ?)";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("ss", $nombre, $contrasena);
            if ($stmt->execute()) {
                return ["mensaje" => "Usuario creado con éxito"];
            } else {
                return ["mensaje" => "Error al crear el usuario"];
            }
        } else {
            return ["mensaje" => "Datos incompletos"];
        }
    }

    // Función para obtener todos los usuarios
    public function getUsers() {
        global $conexion;

        // Consulta para obtener todos los usuarios
        $query = "SELECT * FROM usuarios";
        $resultado = $conexion->query($query);

        if ($resultado->num_rows > 0) {
            $usuarios = [];
            while ($fila = $resultado->fetch_assoc()) {
                $usuarios[] = $fila;
            }
            return $usuarios;
        } else {
            return ["mensaje" => "No se encontraron usuarios"];
        }
    }

    // Función para autenticar a un usuario
    public function authenticateUser($data) {
        global $conexion;

        if (isset($data['nombre']) && isset($data['contrasena'])) {
            $nombre = $data['nombre'];
            $contrasena = $data['contrasena'];

            // Consulta para obtener el usuario
            $query = "SELECT * FROM usuarios WHERE nombre = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("s", $nombre);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                $usuario = $resultado->fetch_assoc();

                // Verificación de la contraseña
                if (password_verify($contrasena, $usuario['contrasena'])) {
                    // Autenticación exitosa, devolver el nombre y el id del usuario
                    return [
                        "mensaje" => "Autenticación satisfactoria",
                        "nombre" => $usuario['nombre'],
                        "id" => $usuario['id']
                    ];
                } else {
                    return ["mensaje" => "Contraseña incorrecta"];
                }
            } else {
                return ["mensaje" => "Usuario no encontrado"];
            }
        } else {
            return ["mensaje" => "Datos incompletos"];
        }
    }

    // Función para eliminar un usuario
public function deleteUser($id) {
  global $conexion;

  try {
      // Consulta para eliminar el usuario por ID
      $query = "DELETE FROM usuarios WHERE id = ?";
      $stmt = $conexion->prepare($query);
      $stmt->bind_param("i", $id);

      if ($stmt->execute()) {
          return ["mensaje" => "Usuario eliminado con éxito"];
      } else {
          return ["mensaje" => "Error al eliminar el usuario"];
      }
  } catch (Exception $e) {
      return ["mensaje" => "Error inesperado: " . $e->getMessage()];
  }
}

}
?>
