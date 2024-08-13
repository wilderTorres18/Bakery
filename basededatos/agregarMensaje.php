<?php
require("connectionbd.php");

// Obtener los datos del formulario
$tel = $_POST['tel'];
$des = $_POST['des'];
$nom = $_POST['nom'];
$dir = $_POST['dir'];

// Establecer la zona horaria a "America/Lima"
date_default_timezone_set('America/Lima');

// Obtener la fecha y hora actual
$fecha_actual = date('Y-m-d H:i:s'); // Formato: YYYY-MM-DD HH:MM:SS

// Consulta SQL para insertar los datos en la base de datos
$query = "INSERT INTO mensaje (mensaje, fecha, nombre, telefono, direccion) VALUES ('$des', '$fecha_actual', '$nom', '$tel', '$dir')";

// Ejecutar la consulta
$result = mysqli_query($conn, $query);

// Verificar si la consulta fue exitosa
if (!$result) {
    // Redirigir de vuelta al formulario con un mensaje de error
    header('Location: ../contacto.php?status=error');
} else {
    // Redirigir de vuelta al formulario con un mensaje de éxito
    header('Location: ../contacto.php?status=success');
    exit();
}
