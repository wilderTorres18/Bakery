<?php
session_start();
require("connectionbd.php");

$nom = $_POST['nom'];
$url = $_POST['url'];
$est = $_POST['est'];

// Verifica si la red social ya existe
$query_check = "SELECT * FROM redes WHERE red_social = '$nom'";
$result_check = mysqli_query($conn, $query_check);

if (mysqli_num_rows($result_check) > 0) {
?>
    <script type="text/javascript">
        alert("Error: Ya existe una red social con el mismo nombre.");
        window.location.href = '../backend/Redes_Ver.php'; // Redirige al formulario de agregar redes
    </script>
<?php
} else {
    $query = "INSERT INTO redes(red_social, `url`, estado) VALUES ('$nom', '$url', '$est')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error: ", mysqli_error($conn);
    } else {
        $razon = "Se agregó una nueva Red Social (" . $nom . ").";
        require("reg_log.php");
        header('location:../backend/Redes_Ver.php');
    }
}
?>