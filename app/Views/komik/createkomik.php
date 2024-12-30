<?= $this->extend('layouts/template'); ?>


<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>General Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Komik</a></li>
                        <li class="breadcrumb-item active">Tambah Komik</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Data Komik</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="/komik/save" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="judul">Judul</label>
                                    <input type="text" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>" id="judul" name="judul" placeholder="Judul" autofocus required value="<?= old('judul'); ?>">
                                    <div class="error invalid-feedback">
                                        <?= $validation->getError('judul'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="penulis">Penulis</label>
                                    <input type="text" class="form-control" id="penulis" name="penulis" placeholder="Penulis" required value="<?= old('penulis'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="penerbit">Penerbit</label>
                                    <input type="text" class="form-control" id="penerbit" name="penerbit" placeholder="Penerbit" required value="<?= old('penerbit'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="customFile">Sampul</label>

                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input <?= ($validation->hasError('sampul')) ? 'is-invalid' : ''; ?>" id="sampul" name="sampul">
                                        <label class="custom-file-label" for="customFile">Pilih gambar</label>
                                        <div class="error invalid-feedback">
                                            <?= $validation->getError('sampul'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection(); ?>

<?= $this->section('javascriptkhusus'); ?>
<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>
<?= $this->endSection(); ?>