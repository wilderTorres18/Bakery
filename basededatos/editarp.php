<?php
require ("connectionbd.php");
			$editar_id = $_GET['id']; 
			
			$consulta = "SELECT * FROM pedidos WHERE cod='$editar_id'";
			$ejecutar = mysqli_query($conn, $consulta); 
			
			$fila=mysqli_fetch_array($ejecutar);
				$nom = $fila['des'];
				$fece = $fila['fechae']; 
				$fecp = $fila['fechap'];  
 
				$con = $fila['cod'];

            ?>
<input type="text" name="nom" value="<?php echo $nom ?>">
<input type="number" name="id" value="<?php echo $con?>">
<input type="text" name="fece" value="<?php echo $fece ?>">
<input type="text" name="fecp" value="<?php echo $fecp ?>">