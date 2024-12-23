<?php
require("basededatos/connectionbd.php");

// Consulta para obtener la URL de Facebook
$query = "SELECT url FROM redes WHERE red_social = 'Facebook'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $facebook_url = $row['url']; // Obtener la URL de Facebook
} else {
    $facebook_url = "#"; // URL predeterminada si no se encuentra el registro
}
?>

<!-- Footer -->
<footer class="bg-gray-800 py-6 mt-12">
    <div class="container mx-auto text-center text-white">
        <div class="flex justify-center space-x-6 mb-4">
            <a href="<?php echo $facebook_url; ?>" class="text-white hover:text-gray-400" target="_blank">
                <i class="fab fa-facebook"></i>
            </a>
        </div>
        <p>.</p>
    </div>
</footer>