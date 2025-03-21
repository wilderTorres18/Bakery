<?php
session_start();
if ((isset($_SESSION['cl']))) { ?>
  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="utf-8">
    <title>Presentación - ERP</title>

    <?php
    require('Style.php');
    ?>

  </head>

  <div id="wrapper">


    <!-- Sidebar -->
    <?php
    require('menu.php');
    ?>

    <!-- End of Sidebar -->


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php
        require('Navigation.php');
        ?>
        <!-- End of -->
        <!-- Begin Page Content -->
        <div class="container-fluid">



          <!-- DataTales Example -->


          <div class="form-row">

            <iframe width="100%" height="540" frameborder="0" src="https://docs.google.com/viewer?url=https%3A%2F%2Fdocs.google.com%2Fdocument%2Fd%2F1_Sc1ZSZHidCDu10ifVqNx3GvN4KBApI2yXmSjaA3xJE%2Fexport%3Fformat%3Dpdf&embedded=true"></iframe>
          </div>
          <!-- /.container-fluid -->



          <script src="vendor/jquery/jquery.min.js"></script>
          <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

          <!-- Core plugin JavaScript-->
          <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

          <!-- Custom scripts for all pages-->
          <script src="js/sb-admin-2.min.js"></script>

          <!-- Page level plugins -->
          <script src="vendor/datatables/jquery.dataTables.js"></script>
          <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

          <!-- Page level custom scripts -->
          <script src="js/demo/datatables-demo.js"></script>

          </body>

  </html>
<?php }
require('llenar3.php');
?>