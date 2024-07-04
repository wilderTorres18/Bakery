<?php
session_start();
if (isset($_SESSION['cl']['id_u'])) {
    $idusu = $_SESSION['cl']['id_u'];

    // Establecer la zona horaria a Lima, Perú
    date_default_timezone_set('America/Lima');

    $hora_nof = new DateTime('now');
    $hora = $hora_nof->format("H:i");
    $fecha = date("Y-n-j");

    $query_inlog = "INSERT INTO Log(fecha, hora, descripcion, FK_ID_USUARIO) VALUES ('$fecha', '$hora', '$razon', '$idusu');";
    mysqli_query($conn, $query_inlog);
} else {
    echo "ID de usuario no definido.";
}
?>
