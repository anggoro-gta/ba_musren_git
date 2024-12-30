<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Data</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Edit</a></li>
                        <li class="breadcrumb-item active">Edit Data</li>
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
                    <h3 class="card-title">Edit Data Tujuan Perangkat Daerah</h3>

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
                <form action="/entrytujuanpd/updatetujuanpd" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label>Visi</label>
                                    <select class="form-control select2 selectvisi" name="visiselect" id="visiselect" style="width: 100%;" required>
                                        <option value="<?= $visi[0]['id_visi']; ?>" selected="selected"><?= $visi[0]['visi']; ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Misi</label>
                                    <select class="form-control select2 selectmisi" name="misiselect" id="misiselect" style="width: 100%;" required>
                                        <option value="<?= $misi[0]['id_misi']; ?>" selected="selected"><?= $misi[0]['misi']; ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Tujuan Perangkat Daerah</label>
                                    <input type="text" class="form-control" name="tujuanpd" id="tujuanpd" placeholder="Tujuan Perangkat Daerah" value="<?= $tujuanpd[0]['tujuanpd']; ?>" required>
                                    <input type="hidden" value="<?= $tujuanpd[0]['id_tujuanpd']; ?>" name="id_tujuanpd">
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

    const url = window.location.origin;

    // $('#visiselect').html('').select2({
    //     data: [{
    //         id: '1',
    //         text: 'saya'
    //     }]
    // });    

    $('.selectvisi').select2({
        placeholder: "Pilih Visi",
        ajax: {
            url: url + "/entrytujuanpd/apigetdatavisi",
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

    $('.selectmisi').select2({
        placeholder: "Pilih Misi",
        ajax: {
            url: url + "/entrytujuanpd/apigetdatamisi",
            dataType: 'json',
            delay: 250,
            data: function(data) {
                return {
                    getid: $('#visiselect').val(),
                    searchTerm: data.term
                };
            },
            processResults: function(data) {
                // console.log($('#visiselect').val())
                return {
                    results: data.data,
                };
            },
            cache: true
        }
    });
</script>
<?= $this->endSection(); ?>