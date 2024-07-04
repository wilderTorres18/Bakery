<?php
$conn = mysqli_connect(
    '127.0.0.1', // Servidor de la base de datos usando la dirección IP del loopback
    'root',      // Usuario de la base de datos
    '',          // Contraseña del usuario de la base de datos
    'panaderiaerp',  // Nombre de la base de datos
    3306         // Puerto, cambia si tu MySQL está en un puerto diferente
) or die("Error al conectar con la base de datos: " . mysqli_connect_error());
?>
