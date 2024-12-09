
<?php
require("connectionbd.php");

// Verificar si se recibe una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del pedido
    $data = json_decode(file_get_contents("php://input"), true);
    $codPed = $data['cod_ped'];
    $nuevoEstado = $data['estado'];
    $fecha_act = date("Y-m-d");
    $hora_act = date("H:i:s");

    // Validar que el estado es uno de los valores permitidos
    $estado_options = [
        "Pendiente" => "Pendiente",
        "En_proceso" => "En_proceso",
        "Pagado" => "Pagado",
        "Entregado" => "Entregado",
        "Anulado" => "Anulado"
    ];

    if (!in_array($nuevoEstado, $estado_options)) {
        echo json_encode(['success' => false, 'message' => 'Estado no válido']);
        exit;
    }

    // Actualizar el estado en la base de datos
    $query = "UPDATE pedidos SET est_ped = '$nuevoEstado', fecha_act = '$fecha_act', hora_act = '$hora_act' WHERE cod_ped = '$codPed'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
    }
}
?>
