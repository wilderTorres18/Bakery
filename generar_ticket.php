<?php
require('./fpdf/fpdf.php');
require("./basededatos/connectionbd.php");

// Desactiva caché del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Iniciar sesión y verificar cliente
session_start();
if (!isset($_SESSION['cl'])) {
    header("Location: index.php");
    exit;
}

// Verificar parámetro cod_ped
$cod_ped = isset($_GET['cod_ped']) ? $_GET['cod_ped'] : null;
if ($cod_ped === null) {
    die("Error: No se proporcionó un código de pedido.");
}

// Consulta para obtener los productos del pedido
$query = "SELECT precio_unit, can_ped, total 
          FROM pedidos 
          WHERE cod_ped = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $cod_ped);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Error: Pedido no encontrado.");
}

// Generar PDF
$pdf = new FPDF('P', 'mm', 'A5');
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10);
$pdf->SetFont('Arial', 'B', 10);

// ENCABEZADO DE LA EMPRESA
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 6, 'Panadería "Los Gemelos"', 0, 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 4, 'RUC: 12345678901', 0, 1, 'C');
$pdf->Cell(0, 4, 'WhatsApp: +51 942 720 461', 0, 1, 'C');
$pdf->Cell(0, 4, 'Direccion: Av. Principal 123 - Piura', 0, 1, 'C');
$pdf->Ln(2);

// DETALLES DEL PEDIDO
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 4, 'Nro. Pedido: ' . $cod_ped, 0, 1, 'L');
$pdf->Cell(0, 4, 'Fecha: ' . date('d/m/Y H:i'), 0, 1, 'L');
$pdf->Ln(3);

// TABLA DE PRODUCTOS (más compacta)
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(12, 6, 'Uds.', 1, 0, 'C');
$pdf->Cell(70, 6, 'Producto', 1, 0, 'C');
$pdf->Cell(22, 6, 'Precio', 1, 0, 'C');
$pdf->Cell(22, 6, 'Importe', 1, 1, 'C');

$pdf->SetFont('Arial', '', 7);
$totalGeneral = 0;

while ($producto = $result->fetch_assoc()) {
    $cantidad = $producto['can_ped'];
    $precio = $producto['precio_unit'];
    $subtotal = $cantidad * $precio;
    $totalGeneral += $subtotal;

    $pdf->Cell(12, 5, $cantidad, 1, 0, 'C');
    $pdf->Cell(70, 5, 'Producto', 1, 0, 'L'); // Simular producto
    $pdf->Cell(22, 5, 'S/ ' . number_format($precio, 2), 1, 0, 'C');
    $pdf->Cell(22, 5, 'S/ ' . number_format($subtotal, 2), 1, 1, 'C');
}

// TOTAL
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(104, 5, 'TOTAL A PAGAR:', 0, 0, 'R');
$pdf->Cell(22, 5, 'S/ ' . number_format($totalGeneral, 2), 0, 1, 'C');

// MENSAJE FINAL
$pdf->Ln(3);
$pdf->SetFont('Arial', 'I', 7);
$pdf->SetTextColor(162, 86, 39);
$pdf->Cell(0, 4, 'Gracias por su compra. ¡Esperamos verle pronto!', 0, 1, 'C');

// Salida del archivo PDF
$pdf->Output('I', 'ticket_' . $cod_ped . '.pdf');
exit;
