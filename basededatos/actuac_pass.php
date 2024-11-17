<?php
require("connectionbd.php");

// Recibir los datos enviados por el formulario
$dni_cl = $_POST['dni'];
$password_cl = $_POST['password'];
$confirm_pass_cl = $_POST['confirm-password'];

// Verificar si el DNI existe en la base de datos
$query_check = "SELECT * FROM clientes WHERE dni = '$dni_cl'";
$result_check = mysqli_query($conn, $query_check);

if (mysqli_num_rows($result_check) > 0) {
	// Si el DNI existe, validar las contraseñas
	if ($password_cl === $confirm_pass_cl) {
		// Actualizar la contraseña
		$query_update = "UPDATE clientes SET password = '$password_cl' WHERE dni = '$dni_cl'";
		$result_update = mysqli_query($conn, $query_update);

		if ($result_update) {
			// Redirigir con el estado de éxito
			$message = urlencode("Contraseña actualizada correctamente.");
			header("Location: ../cambia_pass.php?status=success&message=$message");
			exit();
		} else {
			// Redirigir con el estado de error
			$message = urlencode("Error al actualizar la contraseña.");
			header("Location: ../cambia_pass.php?status=error&message=$message");
			exit();
		}
	} else {
		// Contraseñas no coinciden
		$message = urlencode("Las contraseñas no coinciden.");
		header("Location: ../cambia_pass.php?status=error&message=$message");
		exit();
	}
} else {
	// El DNI no existe
	$message = urlencode("El DNI ingresado no existe.");
	header("Location: ../cambia_pass.php?status=error&message=$message");
	exit();
}

// Cerrar la conexión
mysqli_close($conn);
