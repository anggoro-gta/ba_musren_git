<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item active">Edit data User</li>
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
                    <h3 class="card-title">Users</h3>

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
                <form action="/masterusers/update/<?= $datauser->id; ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id" value="<?= $datauser->id; ?>">
                    <input type="hidden" name="usernamelama" value="<?= $datauser->username; ?>">
                    <input type="hidden" name="emaillama" value="<?= $datauser->email; ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" id="username" placeholder="Username" value="<?= (old('username')) ? old('username') : $datauser->username ?>" required>
                                    <div class="error invalid-feedback">
                                        <?= $validation->getError('username'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Email address</label>
                                    <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= (old('email')) ? old('email') : $datauser->email ?>" required>
                                    <div class="error invalid-feedback">
                                        <?= $validation->getError('email'); ?>
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
                    <a href="/masterusers"><button type="button" class="btn btn-success"><i class="fas fa-arrow-circle-left"></i> Kembali</button></a>
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
    const ahrefusers = document.querySelector('.ahref-users');

    lidatamaster.classList.add("menu-open");
    ahrefdatamaster.classList.add("active");
    ahrefusers.classList.add("active");
</script>
<?= $this->endSection(); ?>