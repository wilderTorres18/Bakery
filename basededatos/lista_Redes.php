<?php
require("connectionbd.php");
$query = "Select * from redes";
$result = mysqli_query($conn, $query);
$i = 0;

while ($fila = mysqli_fetch_array($result)) {
    $id = $fila['id'];
    $red = $fila['red_social'];
    $url = $fila['url'];
    $es = $fila['estado'];
    $i++;    ?>

    <tr align="center">

        <td><?php echo $red; ?></td>
        <td><?php echo $url; ?></td>
        <td><a class="btn btn-success" href="Redes_Modificar.php?id=<?php echo $id; ?>">Editar</a></td>

    </tr>
<?php } ?>