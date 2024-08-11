<?php
require("basededatos/connectionbd.php");

// Consulta para obtener la URL de WhatsApp
$query = "SELECT url FROM redes WHERE red_social = 'WhatsApp'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $url = $row['url']; // Número de teléfono
    $wa_url = "https://wa.me/+51" . $url; // Construir la URL completa
} else {
    $wa_url = "#"; // URL predeterminada si no se encuentra el registro
}
?>

<!-- whatsapp.php -->
<a href="<?php echo $wa_url; ?>" class="whatsapp-float" target="_blank">
    <i class="fab fa-whatsapp"></i>
</a>
<style>
    .whatsapp-float {
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 40px;
        right: 40px;
        background-color: #25D366;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 3px #999;
        z-index: 1000;
    }

    .whatsapp-float i {
        margin-top: 16px;
    }

    .whatsapp-float:hover {
        background-color: #128C7E;
        color: white;
    }
</style>


