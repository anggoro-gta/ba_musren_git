<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Entri Data</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Tujuan PD</a></li>
                        <li class="breadcrumb-item active">Tambah Indikator</li>
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
                    <h3>Tujuan Perangkat Daerah : <?= $indikatortujuanpd[0]['tujuanpd']; ?></h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->

                <form action="/entrytujuanpd/saveindikatortujuanpd" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="card-body">
                        <div class="row">

                            <input type="hidden" name="id_tujuanpd" value="<?= $id_tujuanpd; ?>">

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Indikator Tujuan Perangkat Daerah</label>
                                    <input type="text" class="form-control" name="indikator_tujuanpd" required>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tahun</label>
                                    <input type="text" class="form-control" value="awal" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Value</label>
                                    <input type="text" class="form-control" name="valawal" placeholder="isikan angka murni dan angka dibelakang koma (contoh : 12345,23)" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" class="form-control" name="satawal" required>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tahun</label>
                                    <input type="text" class="form-control" value="akhir" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Value</label>
                                    <input type="text" class="form-control" name="valakhir" placeholder="isikan angka murni dan angka dibelakang koma (contoh : 12345,23)" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" class="form-control" name="satakhir" required>
                                </div>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</button>
                    </div>
                </form>
                <div class="card-footer">
                    <a href="/entrytujuanpd"><button type="button" class="btn btn-success"><i class="fas fa-arrow-circle-left"></i> Kembali</button></a>
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
    const liform = document.querySelector('.li-form');
    const ahrefform = document.querySelector('.ahref-form');
    const ahrefentrytujuan = document.querySelector('.ahref-entrypd');

    liform.classList.add("menu-open");
    ahrefform.classList.add("active");
    ahrefentrytujuan.classList.add("active");
</script>
<?= $this->endSection(); ?>