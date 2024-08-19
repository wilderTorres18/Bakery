<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Agregar producto</title>
	<!-- SweetAlert2 CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>

	<!-- Tu contenido aquí -->

	<!-- SweetAlert2 JS -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<?php
	session_start();
	$id = $_SESSION['cl']['id_u'];
	require("connectionbd.php");

	$cod_pro = $_POST['cod'];
	$nom_pro = $_POST['nom'];
	$cat_pro = $_POST['cat'];
	$des_pro = $_POST['des'];
	$pre_pro = $_POST['pre'];
	$dur_pro = $_POST['dur'];
	$sab_pro = $_POST['sab'];
	$est_pro = $_POST['est'];
	$img_pro = $_FILES["img"]["name"];
	$ruta = $_FILES["img"]["tmp_name"];
	$destino = "fotos/" . $img_pro;
	copy($ruta, $destino);

	$fecha = date("Y-m-d");
	$horario = new DateTime("now", new DateTimeZone('America/Lima'));
	$hora = "" . $horario->format('H:i');

	$desc = "Se ha añadido el producto " . $nom_pro . " con el id " . $cod_pro;

	// Verificar si ya existe un producto con el mismo código o nombre
	$check_query = "SELECT * FROM CATPRODUCTO WHERE ID_CATPRODUCTO = '$cod_pro' OR nombre = '$nom_pro'";
	$check_result = mysqli_query($conn, $check_query);

	if (mysqli_num_rows($check_result) > 0) {
		// Si existe un producto con el mismo código o nombre, mostrar un mensaje de error personalizado con SweetAlert2
		echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Producto Duplicado',
                text: 'Error: ya existe un producto con el mismo código o nombre.',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../backend/Productos_Ver.php'; // Redirigir si es necesario
                }
            });
        </script>";
	} else {
		// Si no existe, proceder con la inserción
		$query = "INSERT INTO CATPRODUCTO (ID_CATPRODUCTO, nombre, FK_ID_SUBTIPOPRODUCTO, descripcion, precio, sabor, imagen, estado, duracion, stock) 
                  VALUES ('$cod_pro', '$nom_pro', '$cat_pro', '$des_pro', '$pre_pro', '$sab_pro', '$destino', '$est_pro', '$dur_pro', '0')";
		$result = mysqli_query($conn, $query);

		if (!$result) {
			if (mysqli_errno($conn) == 1062) {
				echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error: ya se encuentra un registro con el mismo id.',
                        confirmButtonText: 'Aceptar'
                    });
                </script>";
			} else {
				echo "Error: ", mysqli_error($conn);
			}
		} else {
			$query2 = "INSERT INTO log(fecha, hora, descripcion, FK_ID_USUARIO) VALUES ('$fecha', '$hora', '$desc', '$id')";
			$result2 = mysqli_query($conn, $query2);
			if (!$result2) {
				echo "Error: ", mysqli_error($conn);
			} else {
				echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Registro Exitoso',
                        text: 'El producto ha sido registrado correctamente.',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '../backend/Productos_Ver.php';
                        }
                    });
                </script>";
			}
		}
	}
	?>

</body>

</html>