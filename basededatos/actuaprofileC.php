<?php
session_start(); // Asegúrate de que esta línea esté al inicio del archivo

// Incluir la conexión a la base de datos
require("connectionbd.php"); // Verifica que esta ruta sea correcta

// Función para redirigir sin mostrar el estado en la URI
function redirigirSinEstado() {
    header("Location: ../perfil.php");
    exit();
}

// Verificar si la sesión del cliente está activa
if (!isset($_SESSION['cl'])) {
    redirigirSinEstado();
}

// Verificar si los datos fueron enviados
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger y sanitizar los datos enviados
    $nombre = trim($_POST['nomcl']);
    $apellido_1 = trim($_POST['ape1']);
    $apellido_2 = trim($_POST['ape2']);
    $dni = trim($_POST['dnicl']);
    $direccion = trim($_POST['dircl']);
    $descripcion = trim($_POST['descl']);

    // Validar que el DNI no haya cambiado
    if ($dni !== $_SESSION['cl']['dnicl']) {
        $_SESSION['status'] = 'error'; // Guardamos el estado en la sesión
        redirigirSinEstado();
    }

    // Preparamos la consulta SQL para actualizar los datos
    $sql = "UPDATE clientes SET nombre = ?, apellido_1 = ?, apellido_2 = ?, direccion = ?, descripcion = ? WHERE dni = ?";

    // Ejecutar la consulta de manera segura
    if ($stmt = $conn->prepare($sql)) {
        // Enlazar los parámetros con la consulta
        $stmt->bind_param("ssssss", $nombre, $apellido_1, $apellido_2, $direccion, $descripcion, $dni);

        // Ejecutar y verificar el resultado
        if ($stmt->execute()) {
            // Actualizar los datos en la sesión con los nuevos valores
            $_SESSION['cl']['nomcl'] = $nombre;
            $_SESSION['cl']['ape1'] = $apellido_1;
            $_SESSION['cl']['ape2'] = $apellido_2;
            $_SESSION['cl']['dircl'] = $direccion;
            $_SESSION['cl']['descl'] = $descripcion;

            $_SESSION['status'] = 'success'; // Guardamos el estado en la sesión
            redirigirSinEstado(); // Redirigir sin mostrar el estado en la URI
        } else {
            $_SESSION['status'] = 'error'; // Guardamos el estado en la sesión
            redirigirSinEstado();
        }

        $stmt->close(); // Cerrar la declaración preparada
    } else {
        $_SESSION['status'] = 'error'; // Guardamos el estado en la sesión
        redirigirSinEstado();
    }
} else {
    redirigirSinEstado();
}

// Cerrar la conexión a la base de datos
$conn->close();
