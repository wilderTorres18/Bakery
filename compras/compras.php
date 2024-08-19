<?php
session_start();
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
    $arreglo = $_SESSION['carrito'];
    $cl = $_SESSION['cl'];

    for ($i = 0; $i < count($arreglo); $i++) {
        $insertPedido = "INSERT INTO pedidos (cod_ped, Fec_ped, hora_ped, can_ped, dir_ped, des_ped, cod_pro, dni_cl, est_ped) VALUES (
            '$cod_ped',
            '$fec',
            '$hora_ped',
            '" . $arreglo[$i]['Cantidad'] . "',
            '" . $cl['dircl'] . "',
            '" . $cl['descl'] . "',
            '" . $arreglo[$i]['Id'] . "',
            '" . $cl['dnicl'] . "',
            '1'
        )";

        if (!mysqli_query($conn, $insertPedido)) {
            throw new Exception("Error en la inserción del pedido: " . mysqli_error($conn));
        }

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
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrModalLabel">Paga con el código QR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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