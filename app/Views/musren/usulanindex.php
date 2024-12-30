<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Musrenbang RKPD 2025</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Data</a></li>
                        <li class="breadcrumb-item active">Usulan Musrenbang</li>
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
                        <!-- <div class="card-header">
                            <a href="/entrytujuanpd/tambahtujuanpd"><button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah Data Tujuan Perangkat Daerah</button></a>
                        </div> -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>no</th>
                                        <th>Kecamatan</th>
                                        <th>Total Usulan</th>
                                        <th>Total Validasi</th>
                                        <th width="120px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $hitungkec = count($datakecamatan); ?>
                                    <?php for ($i = 0; $i < $hitungkec; $i++) : ?>
                                        <tr>
                                            <td><?= $i + 1; ?></td>
                                            <td><?= $datakecamatan[$i]['nama_kecamatan']; ?></td>
                                            <td><?= $datakecamatan[$i]['jumlah_usulan']; ?></td>
                                            <td><?= $datakecamatan[$i]['jumlah_validasi']; ?></td>
                                            <td>
                                                <a href="/detailusulan/<?= $datakecamatan[$i]['id']; ?>"><button type="button" class="btn btn-block btn-info"><i class="fa fa-eye"></i> Lihat</button></a>
                                            </td>
                                        </tr>
                                    <?php endfor; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>no</th>
                                        <th>Kecamatan</th>
                                        <th>Total Usulan</th>
                                        <th>Total Validasi</th>
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

    const liformbidangadmin = document.querySelector('.liformbidangadmin');
    const ahrefformbidangdamin = document.querySelector('.ahrefformbidangdamin');
    const ahrefbidangadmin = document.querySelector('.ahrefbidangadmin');

    liformbidangadmin.classList.add("menu-open");
    ahrefformbidangdamin.classList.add("active");
    ahrefbidangadmin.classList.add("active");
</script>

<script>
    function showdetail(id) {
        const url = window.location.origin;
        const get_id = document.getElementById("id_indtujuanpd");

        get_id.value = id;

        const formData = {
            id_data: id,
        };

        $.ajax({
            type: "POST",
            url: url + "/entrytujuanpd/apigetdataindiaktortujuanpd",
            data: formData,
            dataType: "json",
            headers: {
                "Access-Control-Allow-Origin": "*",
                "Access-Control-Allow-Methods": "POST"
            },
        }).done(function(data) {
            // console.log(data);
            let permision = 'apakah anda yakin menghapus data ini?';
            // let eTable = "<table class='table table-bordered'><thead><tr><th style='width: 5px'>#</th><th>Indikator Tujuan PD</th><th>Tahun Awal</th><th>Tahun Akhir</th><th>Rata-rata</th><th style='width: 10px'>Aksi</th></tr></thead><tbody>";
            let eTable = "<div class='card-body table-responsive p-0'><table class='table table-hover'><thead><tr><th style='width: 5px'>#</th><th>Indikator Tujuan PD</th><th>Tahun Awal</th><th>Tahun Akhir</th><th style='width: 10px'>Aksi</th></tr></thead><tbody>";

            for (let index = 0; index < data.getdatadetailtujuanpddistinct.length; index++) {
                eTable += "<tr>";
                eTable += "<td>" + (index + 1) + "</td><td>" + data.getdatadetailtujuanpddistinct[index]['indikator_tujuanpd'] + "</td>";
                let temp_etable = "";
                for (let indexj = 0; indexj < data.getdatadetailtujuanpd.length; indexj++) {
                    if (data.getdatadetailtujuanpddistinct[index]['indikator_tujuanpd'] == data.getdatadetailtujuanpd[indexj]['indikator_tujuanpd'] && data.getdatadetailtujuanpd[indexj]['tahun'] == 'awal') {
                        const replace = data.getdatadetailtujuanpd[indexj]['nilai'].replace(/\./g, ',');
                        if (data.getdatadetailtujuanpd[indexj]['nilai'] == '1.00') {
                            temp_etable += "<td>" + data.getdatadetailtujuanpd[indexj]['satuan'] + "</td>";
                        } else if (data.getdatadetailtujuanpd[indexj]['satuan'] == '-') {
                            temp_etable += "<td>" + replace + "</td>";
                        } else {
                            temp_etable += "<td>" + replace + " " + data.getdatadetailtujuanpd[indexj]['satuan'] + "</td>";
                        }
                    } else if (data.getdatadetailtujuanpddistinct[index]['indikator_tujuanpd'] == data.getdatadetailtujuanpd[indexj]['indikator_tujuanpd'] && data.getdatadetailtujuanpd[indexj]['tahun'] == 'akhir') {
                        const replace = data.getdatadetailtujuanpd[indexj]['nilai'].replace(/\./g, ',');
                        if (data.getdatadetailtujuanpd[indexj]['nilai'] == '1.00') {
                            temp_etable += "<td>" + data.getdatadetailtujuanpd[indexj]['satuan'] + "</td>";
                        } else if (data.getdatadetailtujuanpd[indexj]['satuan'] == '-') {
                            temp_etable += "<td>" + replace + "</td>";
                        } else {
                            temp_etable += "<td>" + replace + " " + data.getdatadetailtujuanpd[indexj]['satuan'] + "</td>";
                        }
                    }
                    // else if (data.getdatadetailtujuanpddistinct[index]['indikator_tujuanpd'] == data.getdatadetailtujuanpd[indexj]['indikator_tujuanpd'] && data.getdatadetailtujuanpd[indexj]['tahun'] == 'mean') {
                    //     const replace = data.getdatadetailtujuanpd[indexj]['nilai'].replace(/\./g, ',');
                    //     if (data.getdatadetailtujuanpd[indexj]['nilai'] == '1.00') {
                    //         temp_etable += "<td>" + data.getdatadetailtujuanpd[indexj]['satuan'] + "</td>";
                    //     } else if (data.getdatadetailtujuanpd[indexj]['satuan'] == '-') {
                    //         temp_etable += "<td>" + replace + "</td>";
                    //     } else {
                    //         temp_etable += "<td>" + replace + " " + data.getdatadetailtujuanpd[indexj]['satuan'] + "</td>";
                    //     }
                    // }

                }
                eTable += temp_etable;

                eTable += "<td><form action='/entrytujuanpd/edittujuanpddetail' method='post' enctype='multipart/form-data'><input type='hidden' name='id' value='" + data.getdatadetailtujuanpddistinct[index]['fr_id_tujuanpd'] + "'><input type='hidden' name='indikator' value='" + data.getdatadetailtujuanpddistinct[index]['indikator_tujuanpd'] + "'><input type='hidden' name='tujuanpd' value='" + data.gettujuanpd[0]['tujuanpd'] + "'><button type='submit' class='btn btn-block btn-warning'><i class='far fa-edit'></i></button></form><form action='/entrytujuanpd/hapustujuanpddetail' method='post' enctype='multipart/form-data'><input type='hidden' name='id' value='" + data.getdatadetailtujuanpddistinct[index]['fr_id_tujuanpd'] + "'><input type='hidden' name='indikator' value='" + data.getdatadetailtujuanpddistinct[index]['indikator_tujuanpd'] + "'><button onclick='return confirm(\"Apakah anda yakin menghapus data ini?\")' type='submit' class='btn btn-block btn-danger'><i class='fas fa-minus-circle'></i></button></form></td>";
                eTable += "</tr>";

            }
            eTable += "</tbody></table></div>";
            $('#datatabel').html(eTable);
        });

        $('#modal-details').modal('show');
    }
</script>

<?php if (session()->getFlashdata('pesan') == 'inserttujuanpd') : ?>
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

<?php if (session()->getFlashdata('pesan') == 'insertindikatortujuanpd') : ?>
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

<?php if (session()->getFlashdata('pesan') == 'updatetujuanpd') : ?>
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

<?php if (session()->getFlashdata('pesan') == 'merubahdetailtujuanpd') : ?>
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

<?php if (session()->getFlashdata('pesan') == 'hapusindikatorpd') : ?>
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

<?php if (session()->getFlashdata('pesan') == 'hapustujuanpd') : ?>
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

<?php if (session()->getFlashdata('pesan') == 'gagalhapustujuanpd') : ?>
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