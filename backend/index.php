 <?php
  session_start();
  if ((isset($_SESSION['cl']))) {
    require('../basededatos/llenare.php');
  ?>
   <!DOCTYPE html>
   <html lang="es">

   <head>
     <meta charset="utf-8">
     <title>Administración ERP</title>

     <?php
      require('Style.php');
      ?>


   </head>

   <body id="page-top">

     <!-- Page Wrapper -->
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
           <!-- End of Topbar -->

           <!-- Begin Page Content -->
           <div class="container-fluid">

             <!-- Page Heading -->
             <div class="d-sm-flex align-items-center justify-content-between mb-4">
               <h1 class="h3 mb-0 text-gray-800">Administración</h1>
               <!-- <button id="theme-toggle" class="btn btn-outline-dark" >Activar Modo Oscuro</button> -->

             </div>

             <!-- Content Row -->
             <div class="row">

               <!-- Earnings (Monthly) Card Example -->
               <div class="col-xl-3 col-md-6 mb-4">
                 <div class="card border-left-primary shadow h-100 py-2">
                   <div class="card-body">
                     <div class="row no-gutters align-items-center">
                       <div class="col mr-2">
                         <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Ventas (Semanales)</div>
                         <div class="h5 mb-0 font-weight-bold text-gray-800">S/<?php echo isset($prom2) ? $prom2 : 0 ?></div>
                       </div>
                       <div class="col-auto">
                         <i class="fas fa-calendar fa-2x text-gray-300"></i>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>

               <!-- Earnings (Monthly) Card Example -->
               <div class="col-xl-3 col-md-6 mb-4">
                 <div class="card border-left-success shadow h-100 py-2">
                   <div class="card-body">
                     <div class="row no-gutters align-items-center">
                       <div class="col mr-2">
                         <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ventas (Mensuales)</div>
                         <div class="h5 mb-0 font-weight-bold text-gray-800">S/<?php echo isset($prom4) ? $prom4 : 0 ?></div>
                       </div>
                       <div class="col-auto">
                         <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>

               <!-- Earnings (Monthly) Card Example -->
               <div class="col-xl-3 col-md-6 mb-4">
                 <div class="card border-left-info shadow h-100 py-2">
                   <div class="card-body">
                     <div class="row no-gutters align-items-center">
                       <div class="col mr-2">
                         <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tareas</div>
                         <div class="row no-gutters align-items-center">
                           <div class="col-auto">
                             <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $veri; ?>%</div>
                           </div>
                           <div class="col">
                             <div class="progress progress-sm mr-2">
                               <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $veri; ?>%" aria-valuenow="<?php echo $veri; ?>" aria-valuemin="0" aria-valuemax="100"></div>

                             </div>
                           </div>
                         </div>
                       </div>
                       <div class="col-auto">
                         <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>

               <!-- Pending Requests Card Example -->
               <div class="col-xl-3 col-md-6 mb-4">
                 <div class="card border-left-warning shadow h-100 py-2">
                   <div class="card-body">
                     <div class="row no-gutters align-items-center">
                       <div class="col mr-2">
                         <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pendientes</div>
                         <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $i - 1; ?> </div>
                       </div>
                       <div class="col-auto">
                         <i class="fas fa-comments fa-2x text-gray-300"></i>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>

             <!-- Content Row -->

             <div class="row">

               <!-- Area Chart -->
               <div class="col-xl-8 col-lg-7">
                 <div class="card shadow mb-4">
                   <!-- Card Header - Dropdown -->
                   <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Ganancias Anuales</h6>
                     <div class="dropdown no-arrow">

                     </div>
                   </div>
                   <!-- Card Body -->
                   <div class="card-body">
                     <div class="chart-area">
                       <canvas id="myAreaChart"></canvas>
                     </div>
                   </div>
                 </div>
               </div>

               <!-- Pie Chart -->
               <div class="col-xl-4 col-lg-5">
                 <div class="card shadow mb-4">
                   <!-- Card Header - Dropdown -->
                   <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Producción Popular</h6>
                   </div>
                   <!-- Card Body -->
                   <div class="card-body">
                     <div class="chart-pie pt-4 pb-2">
                       <canvas id="myPieChart"></canvas>
                     </div>
                     <div class="mt-4 text-center small">
                       <span class="mr-2">
                         <i class="fas fa-circle text-primary"></i> <?php echo isset($nb1) ? $nb1 : 0; ?>
                       </span>
                       <span class="mr-2">
                         <i class="fas fa-circle text-success"></i> <?php echo  isset($nb2) ? $nb2 : 0; ?>
                       </span>
                       <span class="mr-2">
                         <i class="fas fa-circle text-info"></i> <?php echo  isset($nb3) ? $nb3 : 0; ?>
                       </span>
                     </div>
                   </div>
                 </div>
               </div>
             </div>

             <!-- Content Row -->
             <div class="row">

               <!-- Content Column -->
               <div class="col-lg-6 mb-4">

                 <!-- Project Card Example -->
                 <div class="card shadow mb-4">
                   <div class="card-header py-3">
                     <h6 class="m-0 font-weight-bold text-primary">Porcentaje de operaciones por usuarios</h6>
                   </div>
                   <div class="card-body">
                     <?php if (isset($lo3, $lo4) && ($lo3 > 0 || $lo4 > 0)) { ?>
                       <h4 class="small font-weight-bold">
                         <?php echo isset($nus) ? $nus : 'N/A'; ?>
                         <span class="float-right"><?php echo isset($div) ? $div . '%' : '0%'; ?></span>
                       </h4>
                       <div class="progress mb-4">
                         <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo isset($div) ? $div : '0'; ?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                     <?php }
                      if (isset($lo3, $lo4) && ($lo3 > 1 || $lo4 > 1)) { ?>
                       <h4 class="small font-weight-bold">
                         <?php echo isset($nus1) ? $nus1 : 'N/A'; ?>
                         <span class="float-right"><?php echo isset($div1) ? $div1 . '%' : '0%'; ?></span>
                       </h4>
                       <div class="progress mb-4">
                         <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo isset($div1) ? $div1 : '0'; ?>%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                     <?php }
                      if (isset($lo3, $lo4) && ($lo3 > 2 || $lo4 > 2)) { ?>
                       <h4 class="small font-weight-bold">
                         <?php echo isset($nus2) ? $nus2 : 'N/A'; ?>
                         <span class="float-right"><?php echo isset($div2) ? $div2 . '%' : '0%'; ?></span>
                       </h4>
                       <div class="progress mb-4">
                         <div class="progress-bar" role="progressbar" style="width: <?php echo isset($div2) ? $div2 : '0'; ?>%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                     <?php }
                      if (isset($lo3, $lo4) && ($lo3 > 3 || $lo4 > 3)) { ?>
                       <h4 class="small font-weight-bold">
                         <?php echo isset($nus3) ? $nus3 : 'N/A'; ?>
                         <span class="float-right"><?php echo isset($div3) ? $div3 . '%' : '0%'; ?></span>
                       </h4>
                       <div class="progress mb-4">
                         <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo isset($div3) ? $div3 : '0'; ?>%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                     <?php }
                      if (isset($lo3, $lo4) && ($lo3 > 4 || $lo4 > 1)) { ?>
                       <h4 class="small font-weight-bold">
                         <?php echo isset($nus4) ? $nus4 : 'N/A'; ?>
                         <span class="float-right"><?php echo isset($div4) ? $div4 . '%' : '0%'; ?></span>
                       </h4>
                       <div class="progress">
                         <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo isset($div4) ? $div4 : '0'; ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                     <?php } ?>
                   </div>
                 </div>


               </div>

               <div class="col-lg-6 mb-4">
                 <div class="card shadow mb-4">
                   <div class="card-header py-3">
                     <h6 class="m-0 font-weight-bold text-primary">Productos más Vendidos</h6>
                   </div>
                   <div class="card-body">
                     <?php if (isset($lo5, $lo6) && ($lo5 > 0 || $lo6 > 0)) { ?>
                       <h4 class="small font-weight-bold">
                         <?php echo isset($bnus) ? $bnus : 'Producto no especificado'; ?>
                         <span class="float-right"><?php echo isset($bdiv) ? $bdiv . '%' : '0%'; ?></span>
                       </h4>
                       <div class="progress mb-4">
                         <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo isset($bdiv) ? $bdiv : '0'; ?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                     <?php }
                      if (isset($lo5, $lo6) && ($lo5 > 1 || $lo6 > 1)) { ?>
                       <h4 class="small font-weight-bold">
                         <?php echo isset($bnus1) ? $bnus1 : 'Producto no especificado'; ?>
                         <span class="float-right"><?php echo isset($bdiv1) ? $bdiv1 . '%' : '0%'; ?></span>
                       </h4>
                       <div class="progress mb-4">
                         <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo isset($bdiv1) ? $bdiv1 : '0'; ?>%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                     <?php }
                      if (isset($lo5, $lo6) && ($lo5 > 2 || $lo6 > 2)) { ?>
                       <h4 class="small font-weight-bold">
                         <?php echo isset($bnus2) ? $bnus2 : 'Producto no especificado'; ?>
                         <span class="float-right"><?php echo isset($bdiv2) ? $bdiv2 . '%' : '0%'; ?></span>
                       </h4>
                       <div class="progress mb-4">
                         <div class="progress-bar" role="progressbar" style="width: <?php echo isset($bdiv2) ? $bdiv2 : '0'; ?>%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                     <?php }
                      if (isset($lo5, $lo6) && ($lo5 > 3 || $lo6 > 3)) { ?>
                       <h4 class="small font-weight-bold">
                         <?php echo isset($bnus3) ? $bnus3 : 'Producto no especificado'; ?>
                         <span class="float-right"><?php echo isset($bdiv3) ? $bdiv3 . '%' : '0%'; ?></span>
                       </h4>
                       <div class="progress mb-4">
                         <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo isset($bdiv3) ? $bdiv3 : '0'; ?>%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                     <?php }
                      if (isset($lo5, $lo6) && ($lo5 > 4 || $lo6 > 4)) { ?>
                       <h4 class="small font-weight-bold">
                         <?php echo isset($bnus4) ? $bnus4 : 'Producto no especificado'; ?>
                         <span class="float-right"><?php echo isset($bdiv4) ? $bdiv4 . '%' : '0%'; ?></span>
                       </h4>
                       <div class="progress">
                         <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo isset($bdiv4) ? $bdiv4 : '0'; ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                     <?php } ?>
                   </div>
                 </div>
               </div>

             </div>

           </div>
           <!-- /.container-fluid -->

         </div>
         <!-- End of Main Content -->

         <!-- Footer -->
         <?php
          require('footer.php');
          ?>
         <!-- End of Footer -->

       </div>
       <!-- End of Content Wrapper -->

     </div>
     <!-- End of Page Wrapper -->

     <!-- Scroll to Top Button-->
     <a class="scroll-to-top rounded" href="#page-top">
       <i class="fas fa-angle-up"></i>
     </a>

     <!-- Logout Modal-->
     <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
         <div class="modal-content">
           <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">¿Está Seguro?</h5>
             <button class="close" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
             </button>
           </div>
           <div class="modal-body">Seleccionar "Cerrar sesión" a continuación si está listo para finalizar tu sesión
             actual.</div>
           <div class="modal-footer">
             <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
             <a class="btn btn-primary" href="../salir.php">Cerrar Sesión</a>
           </div>
         </div>
       </div>
     </div>

     <!-- Bootstrap core JavaScript-->
     <script src="vendor/jquery/jquery.min.js"></script>
     <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

     <!-- Swtich JavaScript-->
     <script src="js/switch.js"></script>

     <!-- Core plugin JavaScript-->
     <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

     <!-- Custom scripts for all pages-->
     <script src="js/sb-admin-2.min.js"></script>

     <!-- Page level plugins -->
     <script src="vendor/chart.js/Chart.min.js"></script>

     <!-- Page level custom scripts -->
     <script src="js/demo/chart-area-demo.js">

     </script>
     <script src="js/demo/chart-pie-demo.js"></script>
     <script src="js/script.js"></script>


   </body>

   </html>

 <?php
  }
  require('llenar3.php');
  ?>