<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tujuan Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Tujuan</a></li>
                        <li class="breadcrumb-item active">Edit data Tujuan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Tujuan</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button> -->
                    </div>
                </div>
                <!-- /.card-header -->

                <form action="/mastertujuan/update" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id" value="<?= $datatujuan->id_tujuan; ?>">
                    <input type="hidden" name="tujuanlama" value="<?= $datatujuan->tujuan; ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tujuan</label>
                                    <input type="text" class="form-control <?= ($validation->hasError('tujuan')) ? 'is-invalid' : ''; ?>" name="tujuan" id="tujuan" value="<?= (old('tujuan')) ? old('tujuan') : $datatujuan->tujuan; ?>" required>
                                    <div class="error invalid-feedback">
                                        <?= $validation->getError('tujuan'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Ubah</button>
                    </div>
                </form>
                <div class="card-footer">
                    <a href="/mastertujuan"><button type="button" class="btn btn-success"><i class="fas fa-arrow-circle-left"></i> Kembali</button></a>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection(); ?>

<?= $this->section('javascriptkhusus'); ?>
<script>
    const lidatamaster = document.querySelector('.li-datamaster');
    const ahrefdatamaster = document.querySelector('.ahref-datamaster');
    const ahreftujuan = document.querySelector('.ahref-tujuan');

    lidatamaster.classList.add("menu-open");
    ahrefdatamaster.classList.add("active");
    ahreftujuan.classList.add("active");
</script>
<?= $this->endSection(); ?>