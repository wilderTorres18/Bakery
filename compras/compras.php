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
        $telefono = $row['url']; // Este es el número de teléfono de WhatsApp
    } else {
        $telefono = null; // Si no se encuentra el número, manejarlo de alguna manera
    }

    // Construir la URL de WhatsApp con el número obtenido
    if ($telefono) {
        $whatsapp_url = "https://wa.me/+51" . $telefono;
    } else {
        // URL predeterminada o mensaje de error si no hay número
        $whatsapp_url = "#"; // o puedes redirigir a otra página
    }

    // Generar un código de pedido aleatorio para la compra actual
    $cod_ped = strtoupper(uniqid('PED-'));

    // Obtener la fecha y hora actual
    $today = getdate();
    $d = $today['mday'];
    $m = $today['mon'];
    $y = $today['year'];
    $h = $today['hours'];
    $min = $today['minutes'];
    $s = $today['seconds'];

    $fec = $y . "-" . $m . "-" . $d;
    $hora_ped = $h . ":" . $min . ":" . $s;

    // Procesar el pedido
    $envio = $_SESSION['envio'];
    $arreglo = $_SESSION['carrito'];
    $cl = $_SESSION['cl'];

    // Asegúrate de que los valores de $envio que son NULL no se pasen tal cual en la consulta
    $referencia = isset($envio['referencia']) ? "'" . mysqli_real_escape_string($conn, $envio['referencia']) . "'" : "NULL";
    $direccion = isset($envio['direccion']) ? "'" . mysqli_real_escape_string($conn, $envio['direccion']) . "'" : "NULL";
    $fecha_recojo = isset($envio['fecha_recojo']) ? "'" . mysqli_real_escape_string($conn, $envio['fecha_recojo']) . "'" : "NULL";
    $hora_recojo = isset($envio['hora_recojo']) ? "'" . mysqli_real_escape_string($conn, $envio['hora_recojo']) . "'" : "NULL";
    $metodo = isset($envio['metodo']) ? "'" . mysqli_real_escape_string($conn, $envio['metodo']) . "'" : "NULL";


    // Verificar si 'fecha_act' tiene un valor, si no, asignar NULL
    $fecha_act = !empty($fec) ? "'" . mysqli_real_escape_string($conn, $fec) . "'" : "NULL";
    $hora_act = !empty($hora_ped) ? "'" . mysqli_real_escape_string($conn, $hora_ped) . "'" : "NULL";

    for ($i = 0; $i < count($arreglo); $i++) {
        $total = $arreglo[$i]['Cantidad'] * $arreglo[$i]['Precio'];

        // Construir la consulta SQL
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

        // Ejecutar la consulta SQL
        if (!mysqli_query($conn, $insertPedido)) {
            throw new Exception("Error en la inserción del pedido: " . mysqli_error($conn));
        }

        // Actualizar el stock de los productos
        $ids = $arreglo[$i]['Id'];
        $can = $arreglo[$i]['Cantidad'];

        $actualizarCatproducto = "UPDATE Catproducto 
                                  SET stock = stock - '$can'
                                  WHERE ID_CATPRODUCTO = '$ids'";

        if (!mysqli_query($conn, $actualizarCatproducto)) {
            throw new Exception("Error en la actualización del stock en Catproducto: " . mysqli_error($conn));
        }
    }

    // Limpiar el carrito después de la inserción
    unset($_SESSION['carrito']);
    unset($_SESSION['envio']);


    // Modal con QR y opción de enviar captura a WhatsApp
    echo "<script>
            Swal.fire({
                title: '¡Pedido exitoso!',
                html: '<b>Tu pedido ha sido registrado con éxito.</b><br>Generando código QR para el pago...',
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
                    // Abrir el modal con el QR
                    var qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
                    qrModal.show();
                }
            });
          </script>";
} catch (Exception $e) {
    // Mostrar alerta de error con tiempo de espera
    echo "<script>
            Swal.fire({
                title: 'Error',
                html: '" . $e->getMessage() . "<br>Redirigiendo en <b></b> milisegundos.',
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

<!-- Modal de QR -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrModalLabel">Paga con el código QR</h5>
                <button type="button" class="btn-close" aria-label="Close" onclick="window.location.href='/tienda.php';"></button>
            </div>
            <div class="modal-body text-center">
                <!-- Aquí va la imagen del QR -->
                <img src="../basededatos/fotos/yape.jpg" alt="QR para pago" class="img-fluid mb-3">
                <p>Por favor, realiza el pago escaneando el código QR. Luego, envía la captura de pantalla del pago a través de WhatsApp.</p>
                <a href="<?php echo $whatsapp_url; ?>" class="btn btn-success" target="_blank">Enviar Captura por WhatsApp</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='/tienda.php';">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Incluir Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var myModal = new bootstrap.Modal(document.getElementById('qrModal'), {
        backdrop: 'static',
        keyboard: false
    });
    myModal.show();
</script>