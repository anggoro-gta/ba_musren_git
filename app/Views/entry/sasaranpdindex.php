<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Data</a></li>
                        <li class="breadcrumb-item active">Sasaran PD</li>
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
                            <a href="/entrysasaranpd/tambahsasaranpd"><button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah Data Sasaran Perangkat Daerah</button></a>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>no</th>
                                        <th>Sasaran Perangkat Daerah</th>
                                        <th width="120px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < $hitungtujuanpd; $i++) : ?>
                                        <?php $namatujuan = $datatujuanpd[$i]['tujuanpd']; ?>
                                        <?php $hitungsasaran = count($datasasaranpd[$namatujuan]); ?>
                                        <tr>
                                            <td></td>
                                            <td><strong>TUJUAN : <?= $datatujuanpd[$i]['tujuanpd']; ?></strong></td>
                                            <td></td>
                                        </tr>
                                        <?php for ($j = 0; $j < $hitungsasaran; $j++) : ?>
                                            <tr>
                                                <td><?= $j + 1; ?></td>
                                                <td><?= $datasasaranpd[$namatujuan][$j]; ?></td>
                                                <td>

                                                    <button onclick="showdetail('<?= $datasasaranpd_id[$namatujuan][$j]; ?>')" type="button" class="btn btn-block btn-info"><i class="fas fa-info-circle"></i> Details</button>

                                                    <a href="/entrysasaranpd/<?= $datasasaranpd_id[$namatujuan][$j]; ?>"><button type="button" class="btn btn-block btn-warning"><i class="far fa-edit"></i> Edit</button></a>

                                                    <form action="/entrysasaranpd/hapussasaranpd" method="post" enctype="multipart/form-data">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="id_hidden" value="<?= $datasasaranpd_id[$namatujuan][$j]; ?>">
                                                        <button type="submit" id="button_delete" class="btn btn-block btn-danger" onclick="return confirm('Apakah anda yakin menghapus data ini?');"><i class="fas fa-minus-circle"></i> Hapus</button>
                                                    </form>

                                                </td>
                                            </tr>
                                        <?php endfor; ?>
                                    <?php endfor; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>no</th>
                                        <th>Sasaran Perangkat Daerah</th>
                                        <th width="120px">Aksi</th>
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

    <div class="modal fade" id="modal-details">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="card-header">
                    <form action="/entrysasaranpd/tambahindikatorsasaranpd" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id_indsasaranpd" id="id_indsasaranpd" value="">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah Indikator Sasaran Perangkat Daerah</button>
                    </form>
                </div>

                <div class="modal-body">

                    <!-- /.card-header -->
                    <div class="card-body" id="datatabel">
                    </div>
                    <!-- /.card-body -->

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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

    const liform = document.querySelector('.li-form');
    const ahrefform = document.querySelector('.ahref-form');
    const ahrefentrysasaran = document.querySelector('.ahref-entrysaspd');

    liform.classList.add("menu-open");
    ahrefform.classList.add("active");
    ahrefentrysasaran.classList.add("active");
</script>

<script>
    function showdetail(id) {
        const url = window.location.origin;
        const get_id = document.getElementById("id_indsasaranpd");

        get_id.value = id;

        const formData = {
            id_data: id,
        };

        $.ajax({
            type: "POST",
            url: url + "/entrysasaranpd/apigetdataindiaktorsasaranpd",
            data: formData,
            dataType: "json",
            headers: {
                "Access-Control-Allow-Origin": "*",
                "Access-Control-Allow-Methods": "POST"
            },
        }).done(function(data) {
            // console.log(data);
            let permision = 'apakah anda yakin menghapus data ini?';
            let eTable = "<div class='card-body table-responsive p-0'><table class='table table-hover'><thead><tr><th style='width: 5px'>#</th><th>Indikator Tujuan PD</th><th>Tahun Awal</th><th>Tahun Akhir</th><th style='width: 10px'>Aksi</th></tr></thead><tbody>";
            // let eTable = "<table class='table table-bordered'><thead><tr><th style='width: 5px'>#</th><th>Indikator Tujuan PD</th><th>Tahun Awal</th><th>Tahun Akhir</th><th>Rata-rata</th><th style='width: 10px'>Aksi</th></tr></thead><tbody>";

            for (let index = 0; index < data.getdatadetailsasaranpddistinct.length; index++) {
                eTable += "<tr>";
                eTable += "<td>" + (index + 1) + "</td><td>" + data.getdatadetailsasaranpddistinct[index]['indikator_sasaranpd'] + "</td>";
                let temp_etable = "";
                for (let indexj = 0; indexj < data.getdatadetailsasaranpd.length; indexj++) {
                    if (data.getdatadetailsasaranpddistinct[index]['indikator_sasaranpd'] == data.getdatadetailsasaranpd[indexj]['indikator_sasaranpd'] && data.getdatadetailsasaranpd[indexj]['tahun'] == 'awal') {
                        const replace = data.getdatadetailsasaranpd[indexj]['nilai'].replace(/\./g, ',');
                        if (data.getdatadetailsasaranpd[indexj]['nilai'] == '1.00') {
                            temp_etable += "<td>" + data.getdatadetailsasaranpd[indexj]['satuan'] + "</td>";
                        } else if (data.getdatadetailsasaranpd[indexj]['satuan'] == '-') {
                            temp_etable += "<td>" + replace + "</td>";
                        } else {
                            temp_etable += "<td>" + replace + " " + data.getdatadetailsasaranpd[indexj]['satuan'] + "</td>";
                        }
                    } else if (data.getdatadetailsasaranpddistinct[index]['indikator_sasaranpd'] == data.getdatadetailsasaranpd[indexj]['indikator_sasaranpd'] && data.getdatadetailsasaranpd[indexj]['tahun'] == 'akhir') {
                        const replace = data.getdatadetailsasaranpd[indexj]['nilai'].replace(/\./g, ',');
                        if (data.getdatadetailsasaranpd[indexj]['nilai'] == '1.00') {
                            temp_etable += "<td>" + data.getdatadetailsasaranpd[indexj]['satuan'] + "</td>";
                        } else if (data.getdatadetailsasaranpd[indexj]['satuan'] == '-') {
                            temp_etable += "<td>" + replace + "</td>";
                        } else {
                            temp_etable += "<td>" + replace + " " + data.getdatadetailsasaranpd[indexj]['satuan'] + "</td>";
                        }
                    }
                    // else if (data.getdatadetailsasaranpddistinct[index]['indikator_sasaranpd'] == data.getdatadetailsasaranpd[indexj]['indikator_sasaranpd'] && data.getdatadetailsasaranpd[indexj]['tahun'] == 'mean') {
                    //     const replace = data.getdatadetailsasaranpd[indexj]['nilai'].replace(/\./g, ',');
                    //     if (data.getdatadetailsasaranpd[indexj]['nilai'] == '1.00') {
                    //         temp_etable += "<td>" + data.getdatadetailsasaranpd[indexj]['satuan'] + "</td>";
                    //     } else if (data.getdatadetailsasaranpd[indexj]['satuan'] == '-') {
                    //         temp_etable += "<td>" + replace + "</td>";
                    //     } else {
                    //         temp_etable += "<td>" + replace + " " + data.getdatadetailsasaranpd[indexj]['satuan'] + "</td>";
                    //     }
                    // }

                }
                eTable += temp_etable;

                eTable += "<td><form action='/entrysasaranpd/editsasaranpddetail' method='post' enctype='multipart/form-data'><input type='hidden' name='id' value='" + data.getdatadetailsasaranpddistinct[index]['fr_id_sasaranpd'] + "'><input type='hidden' name='indikator' value='" + data.getdatadetailsasaranpddistinct[index]['indikator_sasaranpd'] + "'><input type='hidden' name='sasaranpd' value='" + data.getsasaranpd[0]['sasaranpd'] + "'><button type='submit' class='btn btn-block btn-warning'><i class='far fa-edit'></i></button></form><form action='/entrysasaranpd/hapussasaranpddetail' method='post' enctype='multipart/form-data'><input type='hidden' name='id' value='" + data.getdatadetailsasaranpddistinct[index]['fr_id_sasaranpd'] + "'><input type='hidden' name='indikator' value='" + data.getdatadetailsasaranpddistinct[index]['indikator_sasaranpd'] + "'><button onclick='return confirm(\"Apakah anda yakin menghapus data ini?\")' type='submit' class='btn btn-block btn-danger'><i class='fas fa-minus-circle'></i></button></form></td>";
                eTable += "</tr>";

            }
            eTable += "</tbody></table></div>";
            $('#datatabel').html(eTable);
        });

        $('#modal-details').modal('show');
    }
</script>

<?php if (session()->getFlashdata('pesan') == 'insertsasaranpd') : ?>
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
                title: 'Data berhasil disimpan'
            });
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('pesan') == 'updatesasaranpd') : ?>
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

<?php if (session()->getFlashdata('pesan') == 'insertindikatorsasaranpd') : ?>
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
                title: 'Data berhasil disimpan'
            });
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('pesan') == 'merubahdetailsasaranpd') : ?>
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

<?php if (session()->getFlashdata('pesan') == 'hapussasarandetail') : ?>
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

<?php if (session()->getFlashdata('pesan') == 'hapussasaranpd') : ?>
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

<?php if (session()->getFlashdata('pesan') == 'gagalhapussasaranpd') : ?>
    <script>
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 10000
            });
            Toast.fire({
                icon: 'error',
                title: 'Data tidak bisa dihapus, mohon cek detail indikatornya dan hapus detail indikatornya dahulu!'
            });
        });
    </script>
<?php endif; ?>

<?= $this->endSection(); ?>