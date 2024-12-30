<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Master</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                        <li class="breadcrumb-item active">User</li>
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
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($datausers as $k) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $k->username; ?></td>
                                            <td><?= $k->email; ?></td>
                                            <td><?= $k->name; ?></td>
                                            <td>
                                                <a href="/masterusers/<?= $k->usersid; ?>"><button type="button" class="btn btn-block btn-warning"><i class="far fa-edit"></i> Edit</button></a>
                                                <?php if ($k->name == "admin") { ?>

                                                <?php } else { ?>
                                                    <form action="/masterusers/delete" method="post" enctype="multipart/form-data">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="id_hidden" value="<?= $k->usersid; ?>">
                                                        <button type="submit" id="button_delete" class="btn btn-block btn-danger" onclick="return confirm('Apakah anda yakin menghapus data ini?');"><i class="fas fa-minus-circle"></i> Hapus</button>
                                                    </form>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
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

    const lidatamaster = document.querySelector('.li-datamaster');
    const ahrefdatamaster = document.querySelector('.ahref-datamaster');
    const ahrefusers = document.querySelector('.ahref-users');

    lidatamaster.classList.add("menu-open");
    ahrefdatamaster.classList.add("active");
    ahrefusers.classList.add("active");
</script>

<?php if (session()->getFlashdata('pesan') == 'merubah') : ?>
    <script>
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'success',
                title: 'Data berhasil dirubah'
            });
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('pesan') == 'hapus') : ?>
    <script>
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'success',
                title: 'Data berhasil dihapus'
            });
        });
    </script>
<?php endif; ?>
<?= $this->endSection(); ?>