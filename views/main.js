// Mostrar el formulario de login o registro según sea necesario
document
  .getElementById("show-register-form")
  .addEventListener("click", function () {
    document.getElementById("login-form").style.display = "none";
    document.getElementById("register-form").style.display = "block";
  });

document
  .getElementById("show-login-form")
  .addEventListener("click", function () {
    document.getElementById("register-form").style.display = "none";
    document.getElementById("login-form").style.display = "block";
  });

// Función para registrar un nuevo usuario
function registerUser() {
  const nombre = document.getElementById("register-nombre").value;
  const contrasena = document.getElementById("register-contrasena").value;

  fetch("http://localhost/login-api/index.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ nombre: nombre, contrasena: contrasena }),
  })
    .then((response) => response.json())
    .then((data) => {
      alert(data.mensaje);
      if (data.mensaje === "Usuario registrado con éxito") {
        // Cambiar al formulario de login después del registro
        document.getElementById("register-form").style.display = "none";
        document.getElementById("login-form").style.display = "block";
      }
    })
    .catch((error) => console.error("Error:", error));
}

// Función para iniciar sesión
function loginUser() {
  const nombre = document.getElementById("login-nombre").value;
  const contrasena = document.getElementById("login-contrasena").value;

  fetch("http://localhost/login-api/index.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ nombre: nombre, contrasena: contrasena }),
  })
    .then((response) => response.json())
    .then((data) => {
      alert(data.mensaje);
      if (data.mensaje === "Inicio de sesión exitoso") {
        // Redirigir a la página principal o a un área protegida
        window.location.href = "/dashboard"; // Puedes cambiar esta URL a la que necesites
      }
    })
    .catch((error) => console.error("Error:", error));
}

// Función para obtener y mostrar la lista de usuarios
function fetchUsers() {
  fetch("http://localhost/login-api/index.php", {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      const table = document.getElementById("users-table");
      table.innerHTML = ""; // Limpiar la tabla antes de agregar nuevos datos
      if (data.length) {
        data.forEach((user) => {
          const row = table.insertRow();
          row.insertCell(0).innerText = user.id;
          row.insertCell(1).innerText = user.nombre;

          // Crear el botón de eliminar
          const deleteCell = row.insertCell(2);
          const deleteButton = document.createElement("button");
          deleteButton.innerText = "Eliminar";
          deleteButton.addEventListener("click", function () {
            deleteUser(user.id);
          });
          deleteCell.appendChild(deleteButton);
        });
        document.getElementById("users-list-container").style.display = "block";
      }
    })
    .catch((error) => console.error("Error:", error));
}

// Función para eliminar usuario
function deleteUser(userId) {
  fetch("http://localhost/login-api/index.php", {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ id: userId }),
  })
    .then((response) => response.json())
    .then((data) => {
      alert(data.mensaje);
      if (data.mensaje === "Usuario eliminado con éxito") {
        fetchUsers(); // Vuelve a cargar la lista de usuarios
      }
    })
    .catch((error) => console.error("Error:", error));
}

// Llamar a fetchUsers() para cargar los usuarios cuando la página se carga
document.addEventListener("DOMContentLoaded", function () {
  fetchUsers();
});

// Agregar eventos de submit a los formularios de login y registro
document
  .getElementById("register-form")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Evitar el comportamiento por defecto del formulario
    registerUser();
  });

document
  .getElementById("login-form")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Evitar el comportamiento por defecto del formulario
    loginUser();
  });
