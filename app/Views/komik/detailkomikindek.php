<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Komik</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Komik</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-inline-block d-sm-none">KOMIK</h3>
                        <div class="col-12">
                            <img src="../../img/<?= $komik['sampul']; ?>" alt="Product Image" width="300">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3"><?= $komik['judul']; ?></h3>
                        <p>Penulis : <?= $komik['penulis']; ?></p>
                        <p>Penerbit : <?= $komik['penerbit']; ?></p>
                        <div class="mt-4 product-share">
                            <a href="#" class="text-gray">
                                <i class="fab fa-facebook-square fa-2x"></i>
                            </a>
                            <a href="#" class="text-gray">
                                <i class="fab fa-twitter-square fa-2x"></i>
                            </a>
                            <a href="#" class="text-gray">
                                <i class="fas fa-envelope-square fa-2x"></i>
                            </a>
                            <a href="#" class="text-gray">
                                <i class="fas fa-rss-square fa-2x"></i>
                            </a>
                        </div>
                        <div class="mt-2">
                            <a href="/komik/edit/<?= $komik['slug']; ?>"><button type="button" class="btn btn-block btn-warning">Edit</button></a>
                        </div>
                        <div class="mt-2">
                            <form action="/komik/<?= $komik['id']; ?>" method="post">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-block btn-danger" onclick="return confirm('Apakah anda yakin?');">Hapus</button>
                            </form>
                        </div>
                        <div class="mt-2">
                            <a href="/komik">kembali ke detail komik</a>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection(); ?>