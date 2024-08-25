<?php
require("connectionbd.php");
$code = $_POST['dni'];
$nom = $_POST['nom'];
$apellido = $_POST['ape'];
$password = $_POST['pass'];
$query = "UPDATE usuario SET prNombre='$nom',prApellido='$apellido',contrasena='$password' where ID_USUARIO='$code' ";
$result = mysqli_query($conn, $query);
if (!$result) {
    echo "no se pudo";
} else {
    header('location:../backend/Perfil.php');
}
