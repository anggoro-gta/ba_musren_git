<style>
    table,
    td,
    th {
        border: 1px solid #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td,
    th {
        padding: 2px;
    }

    th {
        background-color: #CCC;
    }

    h1 {
        text-align: center;
    }

    @page {
        margin: 10px;
    }
</style>

<h1>SKPD : <?= $sipd[0]['nama_skpd']; ?></h1>
<input type="button" value="Print PDF" onclick="window.open('<?= site_url('printscraping/printsipd'); ?>','blank')">
<br>
<br>

<!-- "pagu_giat" = pagu P-RKPD -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Program</th>
            <th>kegiatan</th>
            <th>Sub Kegiatan</th>
            <th>Indikator</th>
            <th>Target</th>
            <th>Pagu Anggaran</th>
        </tr>
    </thead>
    <tbody>

        <?php $temp_prog = $sipd[0]['nama_program']; ?>
        <?php $temp_giat = $sipd[0]['nama_giat']['nama_giat']; ?>

        <?php $count_prog = 0; ?>
        <?php $count_giat = 0; ?>

        <?php $hitung =  count($sipd); ?>
        <?php for ($i = 0; $i < $hitung; $i++) : ?>
            <tr>
                <td><?= $i + 1; ?></td>

                <!-- cetak program -->
                <?php if ($temp_prog == $sipd[$i]['nama_program']) { ?>
                    <?php $count_prog += 1; ?>
                <?php } else { ?>
                    <?php $temp_prog = $sipd[$i]['nama_program']; ?>
                    <?php $count_prog = 1; ?>
                <?php } ?>

                <?php if ($count_prog == 1) { ?>
                    <td><?= $sipd[$i]['nama_program']; ?></td>
                <?php } else { ?>
                    <td></td>
                <?php } ?>
                <!-- end cetak program -->

                <!-- cetak kegiatan -->
                <?php if ($temp_giat == $sipd[$i]['nama_giat']['nama_giat']) { ?>
                    <?php $count_giat += 1; ?>
                <?php } else { ?>
                    <?php $temp_giat = $sipd[$i]['nama_giat']['nama_giat']; ?>
                    <?php $count_giat = 1; ?>
                <?php } ?>

                <?php if ($count_giat == 1) { ?>
                    <td><?= $sipd[$i]['nama_giat']['nama_giat']; ?></td>
                <?php } else { ?>
                    <td></td>
                <?php } ?>
                <!-- end cetak kegiatan -->

                <td><?= $sipd[$i]['nama_sub_giat']['nama_sub_giat']; ?></td>
                <td></td>
                <td></td>
                <td><?= $sipd[$i]['rincian']; ?></td>

            </tr>
        <?php endfor; ?>
    </tbody>
</table>