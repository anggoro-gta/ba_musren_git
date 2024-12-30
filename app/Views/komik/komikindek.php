<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Indeks Komik</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Table</a></li>
                        <li class="breadcrumb-item active">Komik</li>
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
                            <!-- <h3 class="card-title">Tabel Komik</h3> -->
                            <div>
                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>
                                <a href="/komik/create"><button type="button" class="btn btn-block btn-primary">Tambah Data</button></a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5">#</th>
                                        <th>Sampul</th>
                                        <th>Judul</th>
                                        <th width="20">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($komik as $k) : ?>
                                        <tr>
                                            <td scope="row"><?= $i++; ?></td>
                                            <td><img src="img/<?= $k['sampul']; ?>" alt="" width="50"></td>
                                            <td><?= $k['judul']; ?></td>
                                            <td>
                                                <a href="/komik/<?= $k['slug']; ?>"><button type="button" class="btn btn-block btn-success">Detail</button></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th width="5">#</th>
                                        <th>Sampul</th>
                                        <th>Judul</th>
                                        <th width="20">Aksi</th>
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
            "responsive": true,
            // "lengthChange": false,
            "autoWidth": false,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    const liclastables = document.querySelector('.li-tables');
    const ahrefkomik = document.querySelector('.a-href-komik');
    const ahrefclastables = document.querySelectorAll('.a-href-tables');

    liclastables.classList.add('menu-open');
    ahrefkomik.classList.add('active');
    ahrefclastables[0].classList.add('active');
</script>
<?= $this->endSection(); ?>