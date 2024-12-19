<?php
session_start();
date_default_timezone_set('America/Lima');
require("../basededatos/connectionbd.php");

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <!-- Incluir Bootstrap y SweetAlert2 -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <title>Proceso de Compra</title>
</head>
<body>";

try {
    // Obtener el número de teléfono de WhatsApp desde la tabla 'redes'
    $query = "SELECT url FROM redes WHERE red_social = 'WhatsApp' AND estado = 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $telefono = $row['url'];
    } else {
        $telefono = null;
    }

    // Generar un código de pedido aleatorio
    $cod_ped = strtoupper(uniqid('PED-'));

    // Fecha y hora actuales
    $fec = date('Y-m-d');
    $hora_ped = date('H:i:s');

    // Procesar pedido
    $envio = $_SESSION['envio'];
    $arreglo = $_SESSION['carrito'];
    $cl = $_SESSION['cl'];

    $referencia = isset($envio['referencia']) ? "'" . mysqli_real_escape_string($conn, $envio['referencia']) . "'" : "NULL";
    $direccion = isset($envio['direccion']) ? "'" . mysqli_real_escape_string($conn, $envio['direccion']) . "'" : "NULL";
    $fecha_recojo = isset($envio['fecha_recojo']) ? "'" . mysqli_real_escape_string($conn, $envio['fecha_recojo']) . "'" : "NULL";
    $hora_recojo = isset($envio['hora_recojo']) ? "'" . mysqli_real_escape_string($conn, $envio['hora_recojo']) . "'" : "NULL";
    $metodo = isset($envio['metodo']) ? "'" . mysqli_real_escape_string($conn, $envio['metodo']) . "'" : "NULL";

    $fecha_act = !empty($fec) ? "'" . mysqli_real_escape_string($conn, $fec) . "'" : "NULL";
    $hora_act = !empty($hora_ped) ? "'" . mysqli_real_escape_string($conn, $hora_ped) . "'" : "NULL";

    for ($i = 0; $i < count($arreglo); $i++) {
        $total = $arreglo[$i]['Cantidad'] * $arreglo[$i]['Precio'];

        $insertPedido = "INSERT INTO pedidos (cod_ped, Fec_ped, hora_ped, can_ped, precio_unit, total, dir_ped, des_ped, cod_pro, dni_cl, est_ped, referencia_opc, fecha_act, hora_act, fecha_recojo, hora_recojo, tipo_envio) 
        VALUES (
            '$cod_ped',
            '$fec',
            '$hora_ped',
            '" . $arreglo[$i]['Cantidad'] . "',
            '" . $arreglo[$i]['Precio'] . "',
            '$total',
            $direccion,
            '" . $cl['descl'] . "',
            '" . $arreglo[$i]['Id'] . "',
            '" . $cl['dnicl'] . "',
            'Pendiente',
            $referencia,
            $fecha_act,
            $hora_act,
            $fecha_recojo,
            $hora_recojo,
            $metodo
        )";

        if (!mysqli_query($conn, $insertPedido)) {
            throw new Exception("Error en la inserción del pedido: " . mysqli_error($conn));
        }

        // Actualizar stock
        $ids = $arreglo[$i]['Id'];
        $can = $arreglo[$i]['Cantidad'];
        $actualizarCatproducto = "UPDATE Catproducto 
                                  SET stock = stock - '$can'
                                  WHERE ID_CATPRODUCTO = '$ids'";
        if (!mysqli_query($conn, $actualizarCatproducto)) {
            throw new Exception("Error en la actualización del stock en Catproducto: " . mysqli_error($conn));
        }
    }

    unset($_SESSION['carrito']);
    unset($_SESSION['envio']);

    $base_url = "http://" . $_SERVER['HTTP_HOST']; // Generar la URL base dinámicamente
    $detalle_pedido_url = $base_url . "/detalle_pedido.php?cod_ped=" . $cod_ped;

    // Primera alerta
    echo "<script>
            Swal.fire({
                title: '¡Pedido exitoso!',
                html: '<b>Tu pedido ha sido registrado con éxito.</b><br>Redirigiendo...',
                timer: 1300,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                }
            }).then(() => {
                // Segunda alerta
                Swal.fire({
                    title: 'Pedido realizado correctamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirigir a detalle_pedido.php con el código de pedido
                    window.location.href = '$detalle_pedido_url';
                });
            });
          </script>";
} catch (Exception $e) {
    echo "<script>
            Swal.fire({
                title: 'Error',
                html: '" . $e->getMessage() . "<br>Redirigiendo...',
                icon: 'error',
                timer: 1500,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                }
            }).then(() => {
                window.location.href = '../index.php';
            });
          </script>";
}

echo "</body></html>";
?>


<!-- Incluir Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var myModal = new bootstrap.Modal(document.getElementById('qrModal'), {
        backdrop: 'static',
        keyboard: false
    });
    myModal.show();
</script>