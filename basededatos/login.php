<?php
session_start();
require("connectionbd.php");

$id_user = $_POST['ced'];
$pas_user = $_POST['pas'];

// Consulta para la tabla Usuario
$query_cliente = "SELECT * FROM Clientes WHERE dni='$id_user' AND `password`='$pas_user'";
$result_cliente = mysqli_query($conn, $query_cliente);
$num_cliente = mysqli_num_rows($result_cliente);

if ($num_cliente > 0) {
    while ($fila = mysqli_fetch_array($result_cliente)) {
        $dni_cl = $fila['dni'];
        $nom_cl = $fila['nombre'];
        $a1_cl = $fila['apellido_1'];
        $a2_cl = $fila['apellido_2'];
        $dir_cl = $fila['direccion'];
        $des_cl = $fila['descripcion'];
        $cl = array('nomcl' => $nom_cl, 'ape1' => $a1_cl, 'ape2' => $a2_cl, 'dnicl' => $dni_cl, 'dircl' => $dir_cl, 'descl' => $des_cl);
        $_SESSION['cl'] = $cl;
        header('Location: ../index.php'); // Redirige a la página de productos para clientes
        exit();
    }
} else {
?>
    <script>
        alert('Datos Incorrectos');
        window.location.href = '../login/index.php';
    </script>
<?php
}

if (!$result_user || !$result_cliente) {
    echo "No se pudo ejecutar la consulta: ", mysqli_error($conn);
}
?>