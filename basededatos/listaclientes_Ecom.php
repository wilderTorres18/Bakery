<?php
require("connectionbd.php");
$query = "Select * from clientes,telcl where telcl.dni=clientes.dni";
$result = mysqli_query($conn, $query);
$i = 0;

while ($fila = mysqli_fetch_array($result)) {
	$dni = $fila['dni'];
	$Nom = $fila['nombre'];
	$ap1 = $fila['apellido_1'];
	$ap2 = $fila['apellido_2'];
	$tel = $fila['tel_cl'];
	$dir = $fila['direccion'];
	$est = $fila['estado'];
	$i++;	?>

	<tr align="center">

		<td><?php echo $dni; ?></td>
		<td><?php echo $Nom; ?></td>
		<td><?php echo $ap1; ?></td>
		<td><?php echo $ap2; ?></td>
		<td><?php echo $tel; ?></td>
		<td><?php echo $dir; ?></td>
		<!-- 		<td><?php
							if ($est == 1) {

							?><label class="btn btn-primary">Activo</label><?php
																		} else {

																			?><label class="btn btn-warning">Inactivo</label><?php
																											}

																												?></td> -->
		<td><a class="btn btn-success" href="Ecom_Clientes_Modificar.php?id=<?php echo $dni; ?>">Editar</a></td>

	</tr> <br>
<?php } ?>