<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require("../basededatos/connectionbd.php");
$fecha_actual = date("Y-m-d");
$fecha2 = date("Y-m-d", strtotime($fecha_actual . "- 7 days"));
$fecha3 = date("Y-m-d", strtotime($fecha_actual . "- 1 month"));

function fetchData($conn, $year, $month) {
  $startDate = date("Y-m-d", strtotime("$year-$month-01"));
  $endDate = date("Y-m-t", strtotime($startDate)); // 't' gives the last day of the month
  $query = "SELECT SUM(VENTA_PRODUCCION.cantidad * CatProducto.precio) AS total FROM Venta, VENTA_PRODUCCION, Produccion, CatProducto WHERE Venta.fecha BETWEEN '$startDate' and '$endDate' AND Venta.ID_VENTA = VENTA_PRODUCCION.FK_ID_VENTA AND VENTA_PRODUCCION.FK_ID_PRODUCCION = Produccion.ID_PRODUCCION AND Produccion.FK_ID_CATPRODUCTO = CatProducto.ID_CATPRODUCTO";
  $result = mysqli_query($conn, $query);
  if ($result === false) {
      throw new Exception("SQL error: " . mysqli_error($conn));
  }
  $fila = mysqli_fetch_assoc($result);
  return $fila['total'] ?? 0;
}

$monthlySums = [];
for ($i = 1; $i <= 12; $i++) {
  $monthlySums[$i] = fetchData($conn, date("Y"), str_pad($i, 2, "0", STR_PAD_LEFT));
}


function fetchTopProducts($conn) {
    $query = "SELECT CatProducto.nombre, SUM(Produccion.cantidadInicial) AS total FROM Produccion, CatProducto WHERE Produccion.FK_ID_CATPRODUCTO = CatProducto.ID_CATPRODUCTO GROUP BY Produccion.FK_ID_CATPRODUCTO ORDER BY total DESC LIMIT 3";
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = ['name' => $row['nombre'], 'total' => $row['total']];
    }
    return $data;
}

$topProducts = fetchTopProducts($conn);
?>

<!-- HTML para los valores ocultos -->
<?php foreach ($monthlySums as $index => $sum): ?>
    <input type="hidden" value="<?php echo $sum; ?>" id="n<?php echo $index; ?>">
<?php endforeach; ?>

<?php foreach ($topProducts as $index => $product): ?>
    <input type="hidden" value="<?php echo $product['name']; ?>" id="no<?php echo $index + 1; ?>">
    <input type="hidden" value="<?php echo $product['total']; ?>" id="v<?php echo $index + 1; ?>">
<?php endforeach; ?>
