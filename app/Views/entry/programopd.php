<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Data</a></li>
                        <li class="breadcrumb-item active">Program OPD</li>
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
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>no</th>
                                        <th>Kode Urusan</th>
                                        <th>Nama Urusan</th>
                                        <th>Kode Program</th>
                                        <th>Nama Program</th>
                                        <th>OPD</th>
                                        <th>Pagu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $hitung = count($datautama); ?>
                                    <?php for ($i = 0; $i < $hitung; $i++) : ?>
                                        <tr>
                                            <td><?= $i + 1; ?></td>
                                            <td><?= $datautama[$i]['kode_urusan']; ?></td>
                                            <td><?= $datautama[$i]['nama_urusan']; ?></td>
                                            <td><?= $datautama[$i]['kode_program']; ?></td>
                                            <td><?= $datautama[$i]['nama_program']; ?></td>
                                            <td><?= $datautama[$i]['opd']; ?></td>
                                            <td><?= $datautama[$i]['pagu']; ?></td>
                                        </tr>
                                    <?php endfor; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>no</th>
                                        <th>Kode Urusan</th>
                                        <th>Nama Urusan</th>
                                        <th>Kode Program</th>
                                        <th>Nama Program</th>
                                        <th>OPD</th>
                                        <th>Pagu</th>
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

    <div class="modal fade" id="modal-details">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="card-header">
                    <form action="/entrytujuanpd/tambahindikatortujuanpd" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id_indtujuanpd" id="id_indtujuanpd" value="">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah Indikator Tujuan Perangkat Daerah</button>
                    </form>
                </div>

                <div class="modal-body">

                    <!-- /.card-header -->
                    <div class="card-body" id="datatabel">
                    </div>
                    <!-- /.card-body -->

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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

    const liform = document.querySelector('.li-form');
    const ahrefform = document.querySelector('.ahref-form');
    const ahrefprogramopd = document.querySelector('.ahrefprogramopd');

    liform.classList.add("menu-open");
    ahrefform.classList.add("active");
    ahrefprogramopd.classList.add("active");
</script>

<?= $this->endSection(); ?>