<?php
require('./fpdf/fpdf.php');
require("./basededatos/connectionbd.php");


// Verifica si el cliente está logueado
session_start();
if (!isset($_SESSION['cl'])) {
    header("Location: index.php");
    exit;
}

// Obtener el código del pedido
$cod_ped = isset($_GET['cod_ped']) ? $_GET['cod_ped'] : null;
if ($cod_ped === null) {
    die("Error: No se proporcionó un código de pedido.");
}

// Consulta para obtener los detalles del pedido
$query = "SELECT 
            p.cod_ped, 
            p.Fec_ped, 
            p.est_ped, 
            p.total, 
            p.tipo_envio, 
            c.nombre, 
            c.apellido_1, 
            c.apellido_2, 
            c.dni
          FROM pedidos p
          JOIN clientes c ON p.dni_cl = c.dni
          WHERE p.cod_ped = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $cod_ped);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Error: Pedido no encontrado.");
}

$pedido = $result->fetch_assoc();

// Crear el ticket PDF
$pdf = new FPDF('P', 'mm', [150, 80]); // Formato personalizado para ticket pequeño
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

// Encabezado del ticket
$pdf->Cell(0, 10, 'Panaderia "Los Gemelos"', 0, 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 5, 'RUC: 12345678901', 0, 1, 'C');
$pdf->Cell(0, 5, 'Direccion: Av. Principal 123', 0, 1, 'C');
$pdf->Cell(0, 5, 'Telefono: (01) 123-4567', 0, 1, 'C');
$pdf->Ln(5);

// Información del cliente
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 5, 'INFORMACION DEL CLIENTE:', 0, 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 5, 'Nombre: ' . $pedido['nombre'] . ' ' . $pedido['apellido_1'] . ' ' . $pedido['apellido_2'], 0, 1, 'L');
$pdf->Cell(0, 5, 'DNI: ' . $pedido['dni'], 0, 1, 'L');
$pdf->Ln(5);

// Detalles del pedido
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 5, 'DETALLES DEL PEDIDO:', 0, 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 5, 'Codigo: ' . $pedido['cod_ped'], 0, 1, 'L');
$pdf->Cell(0, 5, 'Fecha: ' . date("d/m/Y", strtotime($pedido['Fec_ped'])), 0, 1, 'L');
$pdf->Cell(0, 5, 'Estado: ' . $pedido['est_ped'], 0, 1, 'L');
$pdf->Cell(0, 5, 'Tipo de envio: ' . $pedido['tipo_envio'], 0, 1, 'L');
$pdf->Ln(5);

// Totales
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 5, 'TOTAL A PAGAR:', 0, 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 5, 'S/ ' . number_format($pedido['total'], 2), 0, 1, 'L');
$pdf->Ln(5);

// Pie del ticket
$pdf->SetFont('Arial', 'I', 7);
$pdf->Cell(0, 5, 'Gracias por tu compra.', 0, 1, 'C');
$pdf->Cell(0, 5, 'Esperamos verte pronto.', 0, 1, 'C');

// Salida del archivo PDF
$pdf->Output('D', 'ticket_pedido_' . $pedido['cod_ped'] . '.pdf');
