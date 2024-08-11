<?php
session_start();
require("connectionbd.php");
$id = $_POST['id'];
$nom = $_POST['nom'];
$url_red = $_POST['url'];


$query = "UPDATE redes SET red_social='$nom', `url`='$url_red' WHERE id='$id'";
$id90 = $_SESSION['cl']['id_u'];
$actua = date("Y-m-d");
$fecha = date("Y-m-d", strtotime($actua . " - 1 days"));
$horario = new DateTime("now", new DateTimeZone('America/Lima'));
$hora = "" . $horario->format('H:i');
$desc = "Se ha modificado la red Social con el nombre : " . $nom . " con el id : " . $id;
$query90 = "INSERT INTO log(fecha, hora, descripcion, FK_ID_USUARIO) VALUES ('$fecha','$hora','$desc','$id90')";

$result = mysqli_query($conn, $query);
if (!$result) {
    echo "no se pudo";
} else {
    $result90 = mysqli_query($conn, $query90);
    if (!$result90) {
        echo "error", mysqli_error($conn);
    }
    echo "registro insertado";
    header('location:../backend/Redes_Ver.php');
}
