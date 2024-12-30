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
                        <li class="breadcrumb-item"><a href="#">Entri</a></li>
                        <li class="breadcrumb-item active">Entri Data</li>
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
                    <h3 class="card-title">Tambah Data Sasaran Perangkat Daerah</h3>

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
                <form action="/entrysasaranpd/savesasaranpd" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label>Tujuan Perangkat Daerah</label>
                                    <select class="form-control select2 selecttujuanpd" name="tujuanpd" id="tujuanpd" style="width: 100%;" required>
                                        <option value=""></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Sasaran Perangkat Daerah</label>
                                    <input type="text" class="form-control" name="sasaranpd" id="sasaranpd" placeholder="Sasaran Perangkat Daerah" value="" required>
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
    const ahrefentrysasaran = document.querySelector('.ahref-entrysaspd');

    liform.classList.add("menu-open");
    ahrefform.classList.add("active");
    ahrefentrysasaran.classList.add("active");

    const url = window.location.origin;

    $('#tujuanpd').select2({
        placeholder: "Pilih Tujuan Perangkat Daerah",
        ajax: {
            url: url + "/entrysasaranpd/apigetdatatujuanpd",
            dataType: 'json',
            delay: 250,
            data: function(data) {
                return {
                    searchTerm: data.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.data
                };
            },
            cache: true
        }
    });
</script>
<?= $this->endSection(); ?>