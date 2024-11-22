<?php
session_start(); // Asegúrate de que esta línea esté al inicio del archivo

// Incluir la conexión a la base de datos
require("connectionbd.php"); // Verifica que esta ruta sea correcta

// Verificar si la sesión del cliente está activa
if (!isset($_SESSION['cl'])) {
    echo "Debes estar logueado para realizar esta acción.";
    exit;
}

// Verificar si los datos fueron enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recogemos los datos del formulario (según los nombres del array POST)
    $nombre = $_POST['nomcl'];            // Nombre completo
    $apellido_1 = $_POST['ape1'];         // Primer apellido
    $apellido_2 = $_POST['ape2'];         // Segundo apellido
    $dni = $_POST['dnicl'];               // DNI (no editable)
    $direccion = $_POST['dircl'];         // Dirección
    $descripcion = $_POST['descl'];       // Descripción

    // Verificar que el DNI no haya cambiado (ya está en la sesión)
    if ($dni !== $_SESSION['cl']['dnicl']) {
        echo "El DNI no puede ser modificado.";
        exit;
    }

    // Preparamos la consulta SQL para actualizar los datos
    $sql = "UPDATE clientes SET nombre = ?, apellido_1 = ?, apellido_2 = ?, direccion = ?, descripcion = ? WHERE dni = ?";

    // Verificar si la conexión es válida
    if ($conn) {
        // Usamos una declaración preparada para evitar inyecciones SQL
        if ($stmt = $conn->prepare($sql)) {
            // Enlazamos los parámetros
            $stmt->bind_param("ssssss", $nombre, $apellido_1, $apellido_2, $direccion, $descripcion, $dni);

            // Ejecutamos la consulta
            if ($stmt->execute()) {
                echo "Perfil actualizado correctamente.";
            } else {
                echo "Error al actualizar el perfil: " . $stmt->error;
            }

            // Cerramos la declaración
            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta: " . $conn->error;
        }
    } else {
        echo "Error de conexión a la base de datos.";
    }

    // Cerramos la conexión
    $conn->close();
}
