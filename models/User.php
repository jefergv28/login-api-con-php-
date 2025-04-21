<?php
// Incluye el archivo de conexión a la base de datos
require_once 'config/database.php';

class User {

    // Método para crear un nuevo usuario
    public static function create($nombre, $contrasena) {
        global $conexion;

        // Hash de la contraseña
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

        // Preparar la consulta para insertar el usuario
        $query = "INSERT INTO usuarios (nombre, contrasena) VALUES (?, ?)";

        // Usar una sentencia preparada para evitar inyecciones SQL
        if ($stmt = $conexion->prepare($query)) {
            $stmt->bind_param('ss', $nombre, $hashed_password);
            if ($stmt->execute()) {
                return true; // Usuario creado exitosamente
            } else {
                return false; // Error al crear usuario
            }
        }

        return false; // Error en la ejecución
    }

    // Método para obtener todos los usuarios
    public static function getAll() {
        global $conexion;

        // Consulta para obtener todos los usuarios
        $query = "SELECT id, nombre FROM usuarios";
        $result = $conexion->query($query);

        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            $usuarios = [];
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
            return $usuarios;
        }

        return null; // No hay usuarios
    }

    // Método para autenticar un usuario
    public static function authenticate($nombre, $contrasena) {
        global $conexion;

        // Consulta para obtener el usuario por nombre
        $query = "SELECT id, nombre, contrasena FROM usuarios WHERE nombre = ?";

        if ($stmt = $conexion->prepare($query)) {
            $stmt->bind_param('s', $nombre);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // El usuario existe
                $usuario = $result->fetch_assoc();

                // Verificar la contraseña
                if (password_verify($contrasena, $usuario['contrasena'])) {
                    return true; // Autenticación exitosa
                } else {
                    return false; // Contraseña incorrecta
                }
            }
        }

        return false; // Usuario no encontrado
    }
}
?>
