<?php
require("connectionbd.php");
$query = "SELECT * FROM mensaje";
$result = mysqli_query($conn, $query);
$i = 0;

while ($fila = mysqli_fetch_array($result)) {
    $nom = $fila['nombre'];
    $men = $fila['mensaje'];
    $fec = $fila['fecha'];
    $tel = $fila['telefono'];
    $dir = $fila['direccion'];

    // Formatear la fecha y la hora
    $fecha_formateada = date('d/m/Y', strtotime($fec));
    $hora_formateada = date('h:i A', strtotime($fec));

    $i++;
?>

    <tr align="center">
        <td><?php echo $nom; ?></td>
        <td><?php echo $tel; ?></td>
        <td><?php echo $fecha_formateada; ?></td>
        <td><?php echo $hora_formateada; ?></td>
        <td><?php echo $dir; ?></td>
        <td>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mensajeModal<?php echo $i; ?>">
                <i class="fas fa-eye"></i> Ver
            </button>
        </td>
    </tr>

    <!-- Modal -->
    <div class="modal fade" id="mensajeModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="mensajeModalLabel<?php echo $i; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mensajeModalLabel<?php echo $i; ?>">Mensaje de <?php echo $nom; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo nl2br($men); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

<?php } ?>