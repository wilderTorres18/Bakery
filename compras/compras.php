<?php
session_start();
require ("../basededatos/connectionbd.php");
		$arreglo=$_SESSION['carrito'];
		$cl=$_SESSION['cl'];

		echo '<pre>';
		print_r($cl);
		print_r($arreglo);
		echo '</pre>';
		
	$todayh=getdate();
$d=$todayh['mday'];
		$m=$todayh['mon'];
		$y=$todayh['year'];

		$fec=$y."-".$m."-".$d;
		for($i=0; $i<count($arreglo);$i++){
			mysqli_query($conn,"insert into pedidos (Fec_ped,can_ped,dir_ped,des_ped,cod_pro,dni_cl,est_ped) values(
				'".$fec."',
				'".$arreglo[$i]['Cantidad']."',
				'".$cl['dircl']."',
				'".$cl['descl']."',
				'".$arreglo[$i]['Id']."',
				'".$cl['dnicl']."',
				'1'
				)")or die(mysqli_error($conn));
			$ids=$arreglo[$i]['Id'];
			$can=$arreglo[$i]['Cantidad'];
			
			$actualizar = "UPDATE produccion 
               SET unidades = unidades - '$can',
                   cantidadInicial = cantidadInicial - '$can' 
               WHERE FK_ID_CATPRODUCTO = '$ids'";
		
		$ejecutar = mysqli_query($conn, $actualizar);
		}
		
		unset($_SESSION['carrito']);
	

?>