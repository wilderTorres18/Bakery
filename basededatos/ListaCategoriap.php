<?php
require("connectionbd.php");
$query = "Select tipoproducto.ID_TIPOPRODUCTO as id,tipoproducto.nombre as nom from tipoproducto";
$result = mysqli_query($conn, $query);
$i = 0;

while ($fila = mysqli_fetch_array($result)) {

    $id = $fila['id'];
    $nom = $fila['nom'];
    $i++;    ?>

    <tr align="center">
        <td width="auto"><?php echo $id; ?></td>

        <td><?php echo $nom; ?></td>
        <td><a class="btn btn-success" href="CategoriaP_Modificar.php?id=<?php echo $id; ?>">Editar</a></td>
    </tr>
<?php } ?>