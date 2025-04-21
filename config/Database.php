<?php
// Definir las variables de conexión a la base de datos
$host = "localhost"; // Dirección del servidor de base de datos (en este caso, localhost)
$usuario = "root"; // Usuario de la base de datos
$password = ""; // Contraseña del usuario de la base de datos
$basededatos = "login_db"; // Nombre de la base de datos a la que se va a conectar

// Crear la conexión a la base de datos utilizando la clase mysqli
$conexion = new mysqli($host, $usuario, $password, $basededatos);

// Verificar si hay algún error en la conexión
if ($conexion->connect_error) {
    // Si hay un error, terminar la ejecución y mostrar el error
    die("Conexión no establecida: " . $conexion->connect_error);
}
?>
