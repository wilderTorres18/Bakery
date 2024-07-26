<?php
session_start();
require ("connectionbd.php");

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
    // Si no se encuentra en la tabla Usuario, buscar en la tabla Cliente
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
			$cl = array('nomcl' => $nom_cl , 'ape1' => $a1_cl ,'ape2' => $a2_cl,'dnicl' => $dni_cl,'dircl'=> $dir_cl, 'descl' => $des_cl);
            $_SESSION['cl'] = $cl;
            header('Location: ../index.php'); // Redirige a la página de productos para clientes
            exit();
        }
    } else {
        ?>
        <script>
            alert('Datos no válidos');
            window.location.href = '../login/index.php';
        </script>
        <?php
    }
}

if (!$result_user || !$result_cliente) {
    echo "No se pudo ejecutar la consulta: ", mysqli_error($conn);
}
?>
