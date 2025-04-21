# Login API con PHP

Este proyecto implementa una API de autenticación de usuarios utilizando PHP. Permite a los usuarios registrarse, iniciar sesión, y eliminar sus cuentas a través de solicitudes HTTP.

## Tecnologías utilizadas

- **PHP**: Lenguaje principal para la lógica del backend.
- **MySQL**: Base de datos para almacenar usuarios y sus credenciales.
- **API REST**: La API sigue los principios REST, permitiendo operaciones CRUD (Crear, Leer, Actualizar, Eliminar) sobre los usuarios.

## Características

- **Registro de usuario**: Los usuarios pueden registrarse proporcionando un nombre de usuario y una contraseña.
- **Inicio de sesión**: Los usuarios pueden iniciar sesión proporcionando su nombre de usuario y contraseña.
- **Eliminación de usuario**: Los administradores pueden eliminar cuentas de usuario a través de la API.
- **Autenticación**: Utiliza un sistema básico de autenticación para asegurar las solicitudes.

## Instalación

### Requisitos previos

1. **Servidor web** (por ejemplo, Apache o Nginx) con soporte para PHP.
2. **MySQL** para la base de datos.
3. Tener configurado un entorno local o servidor para ejecutar PHP y MySQL.

### Pasos para ejecutar el proyecto

1. **Clona el repositorio** en tu máquina local:
   ```bash
   git clone https://github.com/jefergv28/login-api-con-php-.git


Configura la base de datos:

Crea una base de datos en MySQL y ajusta los parámetros de conexión en el archivo config/database.php:

php
Copiar
Editar
$db = new mysqli('localhost', 'usuario', 'contraseña', 'nombre_base_datos');


Ejecuta el servidor PHP:

Si estás usando el servidor embebido de PHP, navega hasta el directorio del proyecto y ejecuta:

bash
Copiar
Editar
php -S localhost:8000
Accede a la API:

La API estará disponible en http://localhost:8000/login-api/ o el puerto que hayas configurado.

Endpoints disponibles
POST /register
Descripción: Registra un nuevo usuario.

Parámetros:

nombre: Nombre del usuario.

contrasena: Contraseña del usuario.

POST /login
Descripción: Inicia sesión con un usuario registrado.

Parámetros:

nombre: Nombre del usuario.

contrasena: Contraseña del usuario.

DELETE /delete
Descripción: Elimina un usuario existente.

Parámetros:

id: ID del usuario a eliminar.
