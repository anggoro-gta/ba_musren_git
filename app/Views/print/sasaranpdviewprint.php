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

    h2 {
        text-align: center;
    }
</style>

<h1>Laporan Cetak SiDika Sasaran Perangkat Daerah</h1>
<h2>SKPD : <?= $nama_skpd[0]['fullname']; ?></h2>
<br>
<table>
    <thead>
        <tr>
            <th style="width: 25px">No</th>
            <th style="width: 400px">Uraian</th>
            <th style="width: 200px">Indikator</th>
            <th style="width: 100px">Tahun Awal</th>
            <th style="width: 100px">Tahun Akhir</th>
            <!-- <th style="width: 100px">Rata-rata</th> -->
        </tr>
    </thead>
    <tbody>
        <?php for ($i = 0; $i < $visihitung; $i++) : ?>
            <?php $namavisi = $visidata[$i]['visi']; ?>
            <tr>
                <td></td>
                <td><strong>Visi : <?= $visidata[$i]['visi']; ?></strong></td>
                <td></td>
                <td></td>
                <td></td>
                <!-- <td></td> -->
            </tr>
            <?php $hitungtujuan_pd = 0; ?>
            <?php for ($j = 0; $j < $misihitung; $j++) : ?>
                <?php $namamisi = $misidata[$j]['misi']; ?>
                <?php $hitungtujuan_pd = count($data_tujuan_pd[$namavisi][$namamisi]) ?>
                <tr>
                    <td></td>
                    <td><strong>Misi : <?= $misidata[$j]['misi']; ?></strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <!-- <td></td> -->
                </tr>
                <?php for ($k = 0; $k < $hitungtujuan_pd; $k++) : ?>
                    <?php $namatujuan =  $data_tujuan_pd[$namavisi][$namamisi][$k]; ?>
                    <?php $hitungsasaran_pd = count($data_sasaran_pd[$namavisi][$namamisi][$namatujuan]); ?>
                    <tr>
                        <td></td>
                        <td><strong>Tujuan : <?= $data_tujuan_pd[$namavisi][$namamisi][$k]; ?></strong></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <!-- <td></td> -->
                    </tr>
                    <?php for ($l = 0; $l < $hitungsasaran_pd; $l++) : ?>
                        <tr>
                            <td><?= $l + 1; ?></td>
                            <td><strong>Sasaran : </strong> <?= $data_sasaran_pd[$namavisi][$namamisi][$namatujuan][$l]; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <!-- <td></td> -->
                        </tr>
                        <?php $hitungandetail = count($indikator_detail); ?>
                        <?php for ($m = 0; $m < $hitungandetail; $m++) : ?>
                            <?php if ($id_data_sasaran_pd[$namavisi][$namamisi][$namatujuan][$l] == $indikator_detail[$m]['fr_id_sasaranpd']) { ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><?= $indikator_detail[$m]['indikator_sasaranpd']; ?></td>
                                    <td><?= $indikator_detail[$m]['nilai_awal']; ?></td>
                                    <td><?= $indikator_detail[$m]['nilai_akhir']; ?></td>
                                    <!-- <td>ada nilai rata-rata sementara di hilangkan</td> -->

                                </tr>
                            <?php } ?>
                        <?php endfor; ?>
                    <?php endfor; ?>
                <?php endfor; ?>
            <?php endfor; ?>
        <?php endfor; ?>
    </tbody>
</table>