<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>EDIT DATA</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Sasaran PD</a></li>
                        <li class="breadcrumb-item active">Edit data</li>
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
                    <h3><?= $sasaranpd; ?></h3>
                    <h3 class="card-title">Indikator Sasaran PD : <?= $indikator; ?></h3>

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
                <?php $count_indikator = count($indikator_edit); ?>
                <form action="/entrysasaranpd/updatesasaranpddetail" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="id" value="<?= $id; ?>">
                            <input type="hidden" name="indikator" value="<?= $indikator; ?>">

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Indikator Tujuan Perangkat Daerah</label>
                                    <input type="text" class="form-control" name="indikator_sasaranpd" value="<?= $indikator; ?>" required>
                                </div>
                            </div>

                            <?php for ($i = 0; $i < $count_indikator; $i++) : ?>
                                <?php if ($indikator_edit[$i]['tahun'] == 'mean') { ?>
                                    <input type="hidden" name="idmean" value="<?= $indikator_edit[$i]['id_sasaranpd_detail']; ?>">
                                <?php } else { ?>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <input type="text" class="form-control" value="<?= $indikator_edit[$i]['tahun']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Value</label>
                                            <input type="text" class="form-control" name="indikator<?= $indikator_edit[$i]['tahun']; ?>" value="<?= number_format($indikator_edit[$i]['nilai'], 2, ",", ""); ?>" placeholder="isikan angka murni dan angka dibelakang koma (contoh : 12345,23)" required>
                                            <input type="hidden" name="id<?= $indikator_edit[$i]['tahun']; ?>" value="<?= $indikator_edit[$i]['id_sasaranpd_detail']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Satuan</label>
                                            <input type="text" class="form-control" name="satuan<?= $indikator_edit[$i]['tahun']; ?>" value="<?= $indikator_edit[$i]['satuan']; ?>" required>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php endfor; ?>

                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Ubah</button>
                    </div>
                </form>
                <div class="card-footer">
                    <a href="/entrysasaranpd"><button type="button" class="btn btn-success"><i class="fas fa-arrow-circle-left"></i> Kembali</button></a>
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
</script>
<?= $this->endSection(); ?>