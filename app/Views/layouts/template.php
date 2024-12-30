<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="<?= base_url(); ?>/icon/data.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $tittle; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <!-- <link rel="stylesheet" href="../../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"> -->
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../../assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="../../assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- navbar dan sidebar -->
        <?= $this->include('layouts/navbarsidebar'); ?>

        <!-- section isinya disini -->
        <?= $this->renderSection('content'); ?>
        <!-- section isinya disini -->

        <!-- footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; <?= date('Y'); ?> Bappeda Kab. Kediri All rights reserved, Design by GTA and <a href="https://adminlte.io">AdminLTE.io</a>.</strong>.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="../../assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- Select2 -->
    <script src="../../assets/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="../../assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../assets/plugins/jszip/jszip.min.js"></script>
    <script src="../../assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <!-- Tempusdominus Bootstrap 4 -->
    <!-- <script src="../../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> -->
    <!-- SweetAlert2 -->
    <script src="../../assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="../../assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="../../assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="../../assets/plugins/dropzone/min/dropzone.min.js"></script>
    <!-- template -->
    <script src="../../assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../assets/dist/js/demo.js"></script>

    <!-- Page specific script -->
    <!-- section javascript isinya disini -->
    <?= $this->renderSection('javascriptkhusus'); ?>
    <!-- section javascript isinya disini -->

    <!-- <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                // "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            // $('#example2').DataTable({
            //     "paging": true,
            //     "lengthChange": false,
            //     "searching": false,
            //     "ordering": true,
            //     "info": true,
            //     "autoWidth": false,
            //     "responsive": true,
            // });
        });
    </script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script> -->
</body>

</html>