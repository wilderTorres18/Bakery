<?php
require("connectionbd.php");

// Consulta SQL mejorada utilizando JOIN
$query = "
    SELECT 
        pedidos.cod_ped AS codigo_pedido,
        pedidos.dni_cl AS cliente_dni,
        pedidos.fec_ped AS fecha_pedido, 
        pedidos.hora_ped AS hora_pedido,
        pedidos.can_ped AS cant, 
        pedidos.dir_ped AS dir, 
        pedidos.est_ped AS estado_pedido, 
        clientes.nombre AS nom, 
        clientes.apellido_1 AS ap1, 
        clientes.apellido_2 AS ap2, 
        catproducto.nombre AS nomproduct, 
        (catproducto.precio * pedidos.can_ped) AS pro_precio
    FROM 
        pedidos
    JOIN 
        clientes ON pedidos.dni_cl = clientes.dni
    JOIN 
        catproducto ON pedidos.cod_pro = catproducto.ID_CATPRODUCTO
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conn));
}

$pedidos = [];

while ($fila = mysqli_fetch_array($result)) {
    $codigo_pedido = $fila['codigo_pedido'];
    $cliente_dni = $fila['cliente_dni'];
    $fec = $fila['fecha_pedido'];
    $hora_pedido = $fila['hora_pedido'];
    $can = $fila['cant'];
    $dir = $fila['dir'];
    $est_ped = $fila['estado_pedido'];
    $nom = $fila['nom'];
    $ap1 = $fila['ap1'];
    $ap2 = $fila['ap2'];
    $nomproducto = $fila['nomproduct'];
    $pro_precio = $fila['pro_precio'];

    // Agrupar los pedidos por código de pedido y cliente
    $pedidos[$codigo_pedido][$cliente_dni][] = [
        'fecha' => $fec,
        'hora' => $hora_pedido,
        'cantidad' => $can,
        'direccion' => $dir,
        'estado' => $est_ped,
        'nombre' => $nom,
        'apellidos' => "$ap1 $ap2",
        'producto' => $nomproducto,
        'precio' => $pro_precio
    ];
}

$i = 0;

foreach ($pedidos as $codigo => $clientes) {
    foreach ($clientes as $dni => $detalles) {
        $i++;
        $cliente = reset($detalles); // Obtenemos los datos del cliente para el modal
        // Comprueba si 'codigo_pedido' está definido
        $codigo_pedido = isset($cliente['codigo_pedido']) ? $cliente['codigo_pedido'] : 'No definido';

        $estado_options = [
            1 => "Pendiente",
            0 => "Cancelado",
            2 => "Pagado",
            3 => "Entregado"
        ];

        // Aquí puedes generar la fila de la tabla
        echo "
            <tr align='center'>
                <td>{$cliente['fecha']}</td>
                <td>
                    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#userModal$i'>
                        <i class='fas fa-user'></i> Ver Datos
                    </button>
                </td>
                <td>
                    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#productoModal$i'>
                        <i class='fas fa-shopping-cart'></i> Ver Producto
                    </button>
                </td>
                <td>
                    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#mensajeModal$i'>
                        <i class='fas fa-car'></i> Ver Dirección
                    </button>
                </td>
                <td>
                    <select class='form-select estado-pedido' data-pedido-id='$i' data-cod-ped='$codigo_pedido'> 
                        " . generateEstadoOptions($cliente['estado'], $estado_options) . "
                    </select>
                </td>
            </tr>
        ";

        renderModals($i, $cliente, $detalles);
    }
}

function generateEstadoOptions($estado_actual, $estado_options)
{
    $html = '';
    foreach ($estado_options as $value => $label) {
        $selected = $estado_actual == $value ? "selected" : "";
        $style = getEstadoStyle($value);
        $html .= "<option value='$value' $selected style='$style'>$label</option>";
    }
    return $html;
}

function getEstadoStyle($estado)
{
    switch ($estado) {
        case 1:
            return 'background-color: yellow;';
        case 0:
            return 'background-color: red; color: white;';
        case 2:
            return 'background-color: green; color: white;';
        case 3:
            return 'background-color: violet; color: white;';
        default:
            return '';
    }
}

function renderModals($i, $cliente, $detalles)
{
    echo "
    <div class='modal fade' id='mensajeModal$i' tabindex='-1' role='dialog' aria-labelledby='mensajeModalLabel$i' aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='mensajeModalLabel$i'>Dirección de {$cliente['nombre']}</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    " . nl2br($cliente['direccion']) . "
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    ";

    // Modal Producto sin Tabla
    echo "
    <div class='modal fade' id='productoModal$i' tabindex='-1' role='dialog' aria-labelledby='infoProductoModal$i' aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='infoProductoModal$i'>Información de Productos</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div style='display: flex; flex-direction: column; gap: 10px;'>
                        <div style='display: flex; justify-content: space-between; font-weight: bold; border-bottom: 1px solid #ddd; padding-bottom: 8px;'>
                            <span style='flex: 2;'>Producto</span>
                            <span style='flex: 1; text-align: center;'>Cantidad</span>
                            <span style='flex: 2; text-align: right;'>Precio Total</span>
                        </div>
    ";

    $total_general = 0;

    foreach ($detalles as $detalle) {
        $total = $detalle['cantidad'] * $detalle['precio'];
        $total_general += $total;

        echo "
                        <div style='display: flex; justify-content: space-between;'>
                            <span style='flex: 2; font-weight: bold;'>{$detalle['producto']}</span>
                            <span style='flex: 1; text-align: center;'>{$detalle['cantidad']}</span>
                            <span style='flex: 2; text-align: right;'>S/ {$detalle['precio']}</span>
                        </div>
        ";
    }

    echo "
                    </div>
                    <div style='font-weight: bold; margin-top: 10px; text-align: right;'>Total General: S/ {$total_general}</div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    ";

    // Modal Usuario
    echo "
    <div class='modal fade' id='userModal$i' tabindex='-1' role='dialog' aria-labelledby='infoUserModal$i' aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='infoUserModal$i'>Información del Cliente</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <p><strong>Nombre:</strong> {$cliente['nombre']}</p>
                    <p><strong>Apellidos:</strong> {$cliente['apellidos']}</p>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    ";
}

// Código para manejar la actualización masiva de estados
if (isset($_GET['cod_ped']) && isset($_GET['estado'])) {
    $codPed = $_GET['cod_ped'];
    $nuevoEstado = $_GET['estado'];

    $fecha_act = date("Y-m-d");
    $hora_act = date("H:i:s");

    $query = "UPDATE pedidos SET est_ped = '$nuevoEstado', fecha_act = '$fecha_act', hora_act = '$hora_act' WHERE cod_ped = '$codPed'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.estado-pedido').forEach(function(select) {
        select.addEventListener('change', function() {
            var codPed = this.getAttribute('data-cod-ped');
            var nuevoEstado = this.value;

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Vas a cambiar el estado de todos los pedidos asociados.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    actualizarEstadoMasivo(codPed, nuevoEstado);
                } else {
                    // Si se cancela, revertir la selección
                    this.value = this.getAttribute('data-original-value');
                }
            });
        });
    });

    function actualizarEstadoMasivo(codPed, nuevoEstado) {
        // Aquí haces una petición AJAX para actualizar el estado en la base de datos
        fetch(`actualizar_estado.php?cod_ped=${codPed}&estado=${nuevoEstado}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('¡Actualizado!', 'El estado del pedido ha sido actualizado.', 'success');
                    location.reload(); // recargar la página para reflejar los cambios
                } else {
                    Swal.fire('Error', 'No se pudo actualizar el estado.', 'error');
                }
            });
    }
</script>