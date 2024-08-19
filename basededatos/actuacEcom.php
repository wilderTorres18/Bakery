<?php
session_start();
require("connectionbd.php");
$dni = $_POST['dni'];
$tel = $_POST['tel'];
$nom = $_POST['nom'];
$ap1 = $_POST['ap1'];
$ap2 = $_POST['ap2'];
$dir = $_POST['dir'];
$est = $_POST['est'];



$query = "UPDATE clientes SET nombre='$nom',apellido_1='$ap1',apellido_2='$ap2',direccion='$dir',estado='$est' WHERE dni='$dni'";
$query2 = "UPDATE telcl set tel_cl='$tel' where dni='$dni'";
$id90 = $_SESSION['cl']['id_u'];
$actua = date("Y-m-d");
$fecha = date("Y-m-d", strtotime($actua));
$horario = new DateTime("now", new DateTimeZone('America/Lima'));
$hora = "" . $horario->format('H:i');
$desc = "Se ha modificado al cliente : " . $nom . " con el id : " . $dni;
$query90 = "INSERT INTO log(fecha, hora, descripcion, FK_ID_USUARIO) VALUES ('$fecha','$hora','$desc','$id90')";

$result = mysqli_query($conn, $query);
$result2 = mysqli_query($conn, $query2);
if (!$result) {
    echo "no se pudo";
} else {
    $result90 = mysqli_query($conn, $query90);
    if (!$result90) {
        echo "error", mysqli_error($conn);
    }
    echo "registro insertado";
    header('location:../backend/Ecom_Clientes_Ver.php');
}
