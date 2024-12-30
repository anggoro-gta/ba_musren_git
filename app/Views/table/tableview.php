<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>DataTables</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Table</a></li>
                        <li class="breadcrumb-item active">DataTables</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DataTable with default features</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>no</th>
                                        <th>Nama Prov/Daerah</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 0; ?>
                                    <?php for ($i = 0; $i < $hitungprov; $i++) : ?>
                                        <?php $namaprov = $dataprovinsi[$i]['nama_provinsi'];
                                        $count = count($data[$namaprov]); ?>
                                        <tr>
                                            <td></td>
                                            <td><strong><?= $dataprovinsi[$i]['nama_provinsi']; ?></strong></td>
                                            <td></td>
                                        </tr>
                                        <?php $no = 0; ?>
                                        <?php for ($j = 0; $j < $count; $j++) : ?>
                                            <tr>
                                                <td><?= $no = $no + 1; ?></td>
                                                <td><?= $data[$namaprov][$j]; ?></td>
                                                <td></td>
                                            </tr>
                                        <?php endfor; ?>
                                    <?php endfor; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>no</th>
                                        <th>Nama Prov/Daerah</th>
                                        <th>Value</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection(); ?>

<?= $this->section('javascriptkhusus'); ?>
<script>
    $(function() {
        $("#example1").DataTable({
            // "lengthChange": true,
            "responsive": true,
            "autoWidth": false,
            "ordering": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    const liclastables = document.querySelector('.li-tables');
    const ahrefclastables = document.querySelectorAll('.a-href-tables');

    liclastables.classList.add("menu-open");
    for (let index = 0; index < ahrefclastables.length; index++) {
        ahrefclastables[index].classList.add("active");
    }
</script>
<?= $this->endSection(); ?>