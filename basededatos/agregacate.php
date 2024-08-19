<?php
session_start();
require("connectionbd.php");
$cod = $_POST['cd'];
$nom = $_POST['nom'];
$id = $_SESSION['cl']['id_u'];
$actua = date("Y-m-d");
$fecha = date("Y-m-d", strtotime($actua));
$horario = new DateTime("now", new DateTimeZone('America/Lima'));
$hora = "" . $horario->format('H:i');
$desc = "Se ha añadido la categoria de producto " . $nom . " con el id " . $cod;
$query = "Insert into `tipoproducto` (`ID_TIPOPRODUCTO`, `nombre`) values('$cod','$nom')";
$result = mysqli_query($conn, $query);
if (!$result) {
    echo "no se pudo", mysqli_error($conn);
} else {

    $query2 = "INSERT INTO log(fecha, hora, descripcion, FK_ID_USUARIO) VALUES ('$fecha','$hora','$desc','$id')";
    $result2 = mysqli_query($conn, $query2);
    if (!$result2) {
        echo "error", mysqli_error($conn);
    }
    header('location:../backend/CategoriaP_Ver.php');
}
