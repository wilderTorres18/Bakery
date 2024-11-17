<?php
session_start();
require("connectionbd.php");

$id_user = $_POST['ced'];
$pas_user = $_POST['pas'];

// Consulta para la tabla Usuario
$query_user = "SELECT * FROM Usuario WHERE ID_USUARIO='$id_user' AND contrasena='$pas_user'";
$result_user = mysqli_query($conn, $query_user);
$num_user = mysqli_num_rows($result_user);

if ($num_user > 0) {
    while ($fila = mysqli_fetch_array($result_user)) {
        $id_u = $fila['ID_USUARIO'];
        $nom = $fila['prNombre'];
        $ape = $fila['prApellido'];
        $rol = $fila['rol'];

        $usr = array('id_u' => $id_u, 'nom' => $nom, 'ape' => $ape, 'rol' => $rol);

        $_SESSION['cl'] = $usr;
        header('Location: ../backend/'); // Redirige a los módulos backend para usuarios
        exit();
    }
} else {
?>
    <script>
        alert(' Los datos no coinciden');
        window.location.href = '../login/adminLogin.php';
    </script>
<?php
}

if (!$result_user || !$result_cliente) {
    echo "No se pudo ejecutar la consulta: ", mysqli_error($conn);
}
?>