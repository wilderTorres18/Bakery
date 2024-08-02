<?php
session_start();
require("connectionbd.php");

$idv = $_POST['cod']; // ID de la venta
$idp = $_POST['pro']; // ID de la producción
$can = $_POST['can']; // Cantidad solicitada
$fec = $_POST['fec']; // Fecha de la venta

// Obtener el stock disponible (unidades) del producto seleccionado
$query89 = "SELECT produccion.unidades, catproducto.nombre 
            FROM produccion 
            JOIN catproducto ON produccion.FK_ID_CATPRODUCTO = catproducto.ID_CATPRODUCTO
            WHERE produccion.ID_PRODUCCION = '$idp'";
$result89 = mysqli_query($conn, $query89);
$fila20 = mysqli_fetch_array($result89);
$unidadesDisponibles = $fila20['unidades']; // Stock disponible
$nombr = $fila20['nombre']; // Nombre del producto

// ID del usuario que realiza la venta
$id90 = $_SESSION['cl']['id_u'];
$fecha = date("Y-m-d");
$horario = new DateTime("now", new DateTimeZone('America/Lima')); // Zona horaria de Lima, Perú
$hora = $horario->format('H:i');
$desc = "Se ha añadido una venta del producto " . $nombr . ". Las unidades vendidas fueron " . $can;

// Verificar si la cantidad solicitada no supera el stock disponible
if ($can <= $unidadesDisponibles) {
    // Insertar en la tabla 'venta'
    $query1 = "INSERT INTO venta(ID_VENTA, fecha) VALUES ('$idv', '$fec')";
    $result1 = mysqli_query($conn, $query1);

    // Insertar en la tabla 'venta_produccion'
    $query = "INSERT INTO venta_produccion(FK_ID_PRODUCCION, FK_ID_VENTA, cantidad) VALUES ('$idp', '$idv', '$can')";
    $result = mysqli_query($conn, $query);

    // Actualizar el stock en la tabla 'produccion'
    $query2 = "UPDATE produccion 
               SET produccion.unidades = produccion.unidades - '$can'
               WHERE produccion.ID_PRODUCCION = '$idp'";
    $result2 = mysqli_query($conn, $query2);

    // Verificar si todas las operaciones fueron exitosas
    if ($result1 && $result && $result2) {
        // Registrar la operación en la tabla 'log'
        $query90 = "INSERT INTO log(fecha, hora, descripcion, FK_ID_USUARIO) VALUES ('$fecha', '$hora', '$desc', '$id90')";
        $result90 = mysqli_query($conn, $query90);

        if ($result90) {
            // Redirigir al usuario al resumen de ventas si todo fue exitoso
            header('location:../backend/Ventas_ver.php');
        } else {
            echo "Error en el registro del log: ", mysqli_error($conn);
        }
    } else {
        echo "Error en la venta: ", mysqli_error($conn);
    }
} else {
    // Mostrar alerta si la cantidad solicitada supera el stock disponible
    echo "<script>
            alert('La cantidad vendida no puede superar la producción');
            window.location.href='../backend/Ventas_Agregar.php';
          </script>";
}
?>
