<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cetak Tujuan Perangkat Daerah</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                        <li class="breadcrumb-item active">cetak</li>
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
                    <!-- <a href="#"><button type="button" class="btn btn-block btn-primary"><i class="fas fa-plus-circle"></i> Tambah Data User</button></a> -->
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>SKPD</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($datausers as $k) : ?>
                                        <?php if ($k->kode_user != null && $k->kode_user != 1) { ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $k->fullname; ?></td>
                                                <td>
                                                    <a href="/masterprintpdftujuanpd/<?= $k->kode_user; ?>" target="_blank"><button type="button" class="btn btn-block btn-secondary"><i class="fas fa-print"></i> Print</button></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>SKPD</th>
                                        <th>Aksi</th>
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

    const lidatamaster = document.querySelector('.li-datamaster-cetak');
    const ahrefdatamaster = document.querySelector('.ahref-datamaster-cetak');
    const cetaktujuanpd = document.querySelector('.ahref-cetaktujuanpd');

    lidatamaster.classList.add("menu-open");
    ahrefdatamaster.classList.add("active");
    cetaktujuanpd.classList.add("active");
</script>

<?= $this->endSection(); ?>