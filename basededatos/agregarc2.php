<?php
session_start();
require ("connectionbd.php");
$dni_cl= $_POST['dni'];	
$nom_cl= $_POST['nombre'];	
$tel_cl= $_POST['telefono'];		
$des_cl= $_POST['descripcion'];		
$dir_cl= $_POST['direccion'];	
$a1_cl= $_POST['apellido_1'];	
$a2_cl= $_POST['apellido_2'];	

$cl = array('nomcl' => $nom_cl , 'ape1' => $a1_cl ,'ape2' => $a2_cl,'dnicl' => $dni_cl,'descl' => $des_cl ,'dircl'=> $dir_cl );
$_SESSION['cl']=$cl;


$query="Insert into clientes (dni,nombre,descripcion,direccion,apellido_1,apellido_2,password)values('$dni_cl','$nom_cl','$des_cl','$dir_cl','$a1_cl','$a2_cl','pass')";
$result=mysqli_query($conn,$query);
$query2="Insert into telcl (dni,tel_cl) values('$dni_cl','$tel_cl')";
$result2=mysqli_query($conn,$query2);
if(!$result || !$result2){
echo "no se pudo",mysqli_error($conn);

}else{
echo "registro insertado";
	header('location:../');
}

?>


