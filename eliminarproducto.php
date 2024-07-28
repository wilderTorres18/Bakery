<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_POST['id'])) {
    $id = $_POST['id'];
    if(isset($_SESSION['carrito'])) {
        $arreglo = $_SESSION['carrito'];
        foreach ($arreglo as $key => $item) {
            if($item['Id'] == $id) {
                unset($arreglo[$key]);
                break;
            }
        }
        $_SESSION['carrito'] = array_values($arreglo); // Reindexar el array
    }
}
$total = 0;
if(isset($_SESSION['carrito'])) {
    foreach($_SESSION['carrito'] as $item) {
        $total += $item['Cantidad'] * $item['Precio'];
    }
}
include 'carritodecompras.php';
?>
