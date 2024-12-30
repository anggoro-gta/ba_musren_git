<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Master</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                        <li class="breadcrumb-item active">Sasaran</li>
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
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>no</th>
                                        <th>Sasaran</th>
                                        <th width="120px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < $misihitung; $i++) : ?>
                                        <?php $namamisi = $misidata[$i]['misi']; ?>
                                        <?php $hitungtujuan = count($datasasaran[$namamisi]); ?>
                                        <tr>
                                            <td></td>
                                            <td><strong>Misi <?= $i + 1; ?> : <?= $misidata[$i]['misi']; ?></strong></td>
                                            <td></td>
                                        </tr>
                                        <?php for ($j = 0; $j < $hitungtujuan; $j++) : ?>
                                            <?php $namatujuan = $datatujuan[$namamisi][$j]; ?>
                                            <?php $hitungsasaran = count($datasasaran[$namamisi][$namatujuan]); ?>
                                            <tr>
                                                <td></td>
                                                <td><strong>Tujuan <?= $j + 1; ?> : <?= $datatujuan[$namamisi][$j]; ?></strong></td>
                                                <td></td>
                                            </tr>
                                            <?php for ($k = 0; $k < $hitungsasaran; $k++) : ?>
                                                <tr>
                                                    <td><?= $k + 1; ?></td>
                                                    <td><?= $datasasaran[$namamisi][$namatujuan][$k]; ?></td>
                                                    <td>
                                                        <button onclick="showdetail('<?= $iddatasasaran[$namamisi][$namatujuan][$k]; ?>')" type="button" class="btn btn-block btn-info" data-toggle="modal"><i class="fas fa-info-circle"></i> Details</button>
                                                        <a href="/mastersasaran/<?= $iddatasasaran[$namamisi][$namatujuan][$k]; ?>"><button type="button" class="btn btn-block btn-warning"><i class="far fa-edit"></i> Edit</button></a>

                                                        <form action="/mastersasaran/delete" method="post" enctype="multipart/form-data">
                                                            <?= csrf_field(); ?>
                                                            <input type="hidden" name="id_hidden" value="<?= $iddatasasaran[$namamisi][$namatujuan][$k]; ?>">
                                                            <button type="submit" id="button_delete" class="btn btn-block btn-danger" onclick="return confirm('Apakah anda yakin menghapus data ini?');"><i class="fas fa-minus-circle"></i> Hapus</button>
                                                        </form>

                                                    </td>
                                                </tr>
                                            <?php endfor; ?>
                                        <?php endfor; ?>
                                    <?php endfor; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>no</th>
                                        <th>Sasaran</th>
                                        <th>Aksi</th>
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

    const lidatamaster = document.querySelector('.li-datamaster');
    const ahrefdatamaster = document.querySelector('.ahref-datamaster');
    const ahrefsasaran = document.querySelector('.ahref-sasaran');

    lidatamaster.classList.add("menu-open");
    ahrefdatamaster.classList.add("active");
    ahrefsasaran.classList.add("active");
</script>
<script>
    function showdetail(id) {
        const url = window.location.origin;

        const formData = {
            id_data: id,
        };

        $.ajax({
            type: "POST",
            url: url + "/mastersasaran/apigetdatasasaran",
            data: formData,
            dataType: "json",
            headers: {
                "Access-Control-Allow-Origin": "*",
                "Access-Control-Allow-Methods": "POST"
            },
        }).done(function(data) {
            // console.log(data);
            let eTable = "<div class='card-body table-responsive p-0'><table class='table table-hover'><thead><tr><th style='width: 5px'>#</th><th>Indikator Sasaran</th><th>2021</th><th>2022</th><th>2023</th><th>2024</th><th>2025</th><th>2026</th><th style='width: 10px'>Aksi</th></tr></thead><tbody>";

            for (let index = 0; index < data.dataindikatorsasaran.length; index++) {
                eTable += "<tr>";
                eTable += "<td>" + (index + 1) + "</td><td>" + data.dataindikatorsasaran[index]['indikator_sasaran'] + "</td>";
                let temp_etable = "";
                for (let indexj = 0; indexj < data.datadetail.length; indexj++) {
                    if (data.dataindikatorsasaran[index]['indikator_sasaran'] == data.datadetail[indexj]['indikator_sasaran'] && data.datadetail[indexj]['tahun'] == '2021') {
                        if (data.datadetail[indexj]['satuan'] == null) {
                            temp_etable += "<td>" + data.datadetail[indexj]['nilai'] + "</td>";
                        } else {
                            temp_etable += "<td>" + data.datadetail[indexj]['nilai'] + " " + data.datadetail[indexj]['satuan'] + "</td>";
                        }
                    } else if (data.dataindikatorsasaran[index]['indikator_sasaran'] == data.datadetail[indexj]['indikator_sasaran'] && data.datadetail[indexj]['tahun'] == '2022') {
                        if (data.datadetail[indexj]['satuan'] == null) {
                            temp_etable += "<td>" + data.datadetail[indexj]['nilai'] + "</td>";
                        } else {
                            temp_etable += "<td>" + data.datadetail[indexj]['nilai'] + " " + data.datadetail[indexj]['satuan'] + "</td>";
                        }
                    } else if (data.dataindikatorsasaran[index]['indikator_sasaran'] == data.datadetail[indexj]['indikator_sasaran'] && data.datadetail[indexj]['tahun'] == '2023') {
                        if (data.datadetail[indexj]['satuan'] == null) {
                            temp_etable += "<td>" + data.datadetail[indexj]['nilai'] + "</td>";
                        } else {
                            temp_etable += "<td>" + data.datadetail[indexj]['nilai'] + " " + data.datadetail[indexj]['satuan'] + "</td>";
                        }
                    } else if (data.dataindikatorsasaran[index]['indikator_sasaran'] == data.datadetail[indexj]['indikator_sasaran'] && data.datadetail[indexj]['tahun'] == '2024') {
                        if (data.datadetail[indexj]['satuan'] == null) {
                            temp_etable += "<td>" + data.datadetail[indexj]['nilai'] + "</td>";
                        } else {
                            temp_etable += "<td>" + data.datadetail[indexj]['nilai'] + " " + data.datadetail[indexj]['satuan'] + "</td>";
                        }
                    } else if (data.dataindikatorsasaran[index]['indikator_sasaran'] == data.datadetail[indexj]['indikator_sasaran'] && data.datadetail[indexj]['tahun'] == '2025') {
                        if (data.datadetail[indexj]['satuan'] == null) {
                            temp_etable += "<td>" + data.datadetail[indexj]['nilai'] + "</td>";
                        } else {
                            temp_etable += "<td>" + data.datadetail[indexj]['nilai'] + " " + data.datadetail[indexj]['satuan'] + "</td>";
                        }
                    } else if (data.dataindikatorsasaran[index]['indikator_sasaran'] == data.datadetail[indexj]['indikator_sasaran'] && data.datadetail[indexj]['tahun'] == '2026') {
                        if (data.datadetail[indexj]['satuan'] == null) {
                            temp_etable += "<td>" + data.datadetail[indexj]['nilai'] + "</td>";
                        } else {
                            temp_etable += "<td>" + data.datadetail[indexj]['nilai'] + " " + data.datadetail[indexj]['satuan'] + "</td>";
                        }
                    }
                }
                eTable += temp_etable;

                eTable += "<td><form action='/mastersasaran/sasarandetail' method='post' enctype='multipart/form-data'><input type='hidden' name='id' value='" + data.dataindikatorsasaran[index]['fr_id_sasaran'] + "'><input type='hidden' name='indikator_sasaran' value='" + data.dataindikatorsasaran[index]['indikator_sasaran'] + "'><input type='hidden' name='sasaran' value='" + data.datasasaran[0]['sasaran'] + "'><button type='submit' class='btn btn-block btn-warning'><i class='far fa-edit'></i></button></form></td>";
                eTable += "</tr>";
            }
            eTable += "</tbody></table></div>";
            $('#datatabel').html(eTable);
        });

        $('#modal-details').modal('show');
    }
</script>

<?php if (session()->getFlashdata('pesan') == 'merubahsasaran') : ?>
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

<?php if (session()->getFlashdata('pesan') == 'merubahdetailsasaran') : ?>
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

<?php if (session()->getFlashdata('pesan') == 'hapus') : ?>
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

<?php if (session()->getFlashdata('pesan') == 'gagalhapus') : ?>
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