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

<h1>SKPD : SMP</h1>
<input type="button" value="Print PDF" onclick="window.open('<?= site_url('printscraping/printsipd'); ?>','blank')">
<br>
<br>

<!-- "pagu_giat" = pagu P-RKPD -->
<table>
    <thead>
        <tr>
            <th>NO</th>
            <th>MENU KEGIATAN</th>
            <th>DETAIL KEGIATAN</th>
            <th>METODE PENGADAAN</th>
            <th>LOKASI KEGIATAN</th>
            <th>VOLUME</th>
            <th>SATUAN</th>
            <th>KEBUTUHAN DANA</th>
        </tr>
    </thead>
    <tbody>

        <?php $temp_menu = $sipd[0]['menu']; ?>
        <?php $temp_detail = $sipd[0]['rincian']; ?>

        <?php $count_menu = 0; ?>
        <?php $count_detail = 0; ?>

        <?php $hitung =  count($sipd); ?>
        <?php for ($i = 0; $i < $hitung; $i++) : ?>
            <tr>
                <td><?= $i + 1; ?></td>

                <!-- cetak menu -->
                <?php if ($temp_menu == $sipd[$i]['menu']) { ?>
                    <?php $count_menu += 1; ?>
                <?php } else { ?>
                    <?php $temp_menu = $sipd[$i]['menu']; ?>
                    <?php $count_menu = 1; ?>
                <?php } ?>

                <?php if ($count_menu == 1) { ?>
                    <td><?= $sipd[$i]['menu'] ?></br>
                        Pelaksana : <?= $sipd[$i]['pelaksana'] ?></td>
                <?php } else { ?>
                    <td></td>
                <?php } ?>
                <!-- end cetak menu -->

                <!-- cetak detail -->
                <?php if ($temp_detail == $sipd[$i]['rincian']) { ?>
                    <?php $count_detail += 1; ?>
                <?php } else { ?>
                    <?php $temp_detail = $sipd[$i]['rincian']; ?>
                    <?php $count_detail = 1; ?>
                <?php } ?>

                <?php if ($count_detail == 1) { ?>
                    <td><?= $sipd[$i]['rincian'] ?></td>
                <?php } else { ?>
                    <td></td>
                <?php } ?>
                <!-- end cetak detail -->

                <td>Penyedia</td>
                <td><?= $sipd[$i]['detail_rincian'] ?></br>
                    (Kecamatan <?= $sipd[$i]['kecamatan'] ?>,Desa <?= $sipd[$i]['desa'] ?>)</br>
                    <u>Komponen:</u>
                </td>
                <td><?= $sipd[$i]['volume'] ?></td>
                <td><?= $sipd[$i]['satuan'] ?></td>
                <td><?= $sipd[$i]['usulan'] ?></td>
            </tr>
        <?php endfor; ?>
    </tbody>
</table>