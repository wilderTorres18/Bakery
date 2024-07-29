<?php
session_start();
require ("../basededatos/connectionbd.php");

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <!-- Incluir SweetAlert2 -->
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <title>Proceso de Compra</title>
</head>
<body>";

try {
    $arreglo = $_SESSION['carrito'];
    $cl = $_SESSION['cl'];

    $todayh = getdate();
    $d = $todayh['mday'];
    $m = $todayh['mon'];
    $y = $todayh['year'];

    $fec = $y."-".$m."-".$d;
    for ($i = 0; $i < count($arreglo); $i++) {
        $insertPedido = "INSERT INTO pedidos (Fec_ped, can_ped, dir_ped, des_ped, cod_pro, dni_cl, est_ped) VALUES (
            '$fec',
            '".$arreglo[$i]['Cantidad']."',
            '".$cl['dircl']."',
            '".$cl['descl']."',
            '".$arreglo[$i]['Id']."',
            '".$cl['dnicl']."',
            '1'
        )";
        
        if (!mysqli_query($conn, $insertPedido)) {
            throw new Exception("Error en la inserción del pedido: " . mysqli_error($conn));
        }

        $ids = $arreglo[$i]['Id'];
        $can = $arreglo[$i]['Cantidad'];

        $actualizar = "UPDATE produccion 
                       SET unidades = unidades - '$can'
                       WHERE FK_ID_CATPRODUCTO = '$ids'";

        if (!mysqli_query($conn, $actualizar)) {
            throw new Exception("Error en la actualización de unidades: " . mysqli_error($conn));
        }
    }

    unset($_SESSION['carrito']);
    
    // Si todo es correcto, mostrar una alerta de éxito con tiempo de espera y luego una alerta de pago exitoso
    echo "<script>
            let timerInterval;
            Swal.fire({
                title: '¡Pedido exitoso!',
                html: 'Redirigiendo en <b></b> milisegundos.',
                timer: 1300,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getHtmlContainer().querySelector('b');
                    timerInterval = setInterval(() => {
                        timer.textContent = Swal.getTimerLeft();
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    Swal.fire({
                        title: '¡Pago Exitoso!',
                        text: 'Gracias por tu compra. Tu compra ha sido procesado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.href = '../index.php';
                    });
                }
            });
          </script>";

} catch (Exception $e) {
    // Mostrar alerta de error con tiempo de espera
    echo "<script>
            Swal.fire({
                title: 'Error',
                html: '".$e->getMessage()."<br>Redirigiendo en <b></b> milisegundos.',
                icon: 'error',
                timer: 1500,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getHtmlContainer().querySelector('b');
                    let timerInterval = setInterval(() => {
                        timer.textContent = Swal.getTimerLeft();
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    window.location.href = '../index.php';
                }
            });
          </script>";
}

echo "</body></html>";
?>
