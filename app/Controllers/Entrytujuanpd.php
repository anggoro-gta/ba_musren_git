<?php

namespace App\Controllers;

use App\Models\msmisiModel;
use App\Models\msvisiModel;
use App\Models\tbtujuanpdModel;
use App\Models\tbtujuanpddetailModel;
use App\Models\usersModel;
use \Dompdf\Dompdf;

class Entrytujuanpd extends BaseController
{
    protected $users;

    protected $ms_visi;
    protected $ms_misi;
    protected $tb_tujuanpd;
    protected $tb_tujuanpd_detail;

    protected $dompdf;

    public function __construct()
    {
        $this->users = new usersModel();

        $this->ms_visi = new msvisiModel();
        $this->ms_misi = new msmisiModel();
        $this->tb_tujuanpd = new tbtujuanpdModel();
        $this->tb_tujuanpd_detail = new tbtujuanpddetailModel();

        $this->dompdf = new Dompdf();
    }

    public function index()
    {
        $kode_user_skpd = user()->kode_user;

        $data_tujuanpd = $this->tb_tujuanpd->gettujuanpd($kode_user_skpd);

        $data = [
            'tittle' => 'GTA CI siDika Tujuan PD',
            'datatujuanpd' => $data_tujuanpd
        ];

        return view('entry/tujuanpdindex', $data);
    }

    public function tambahtujuanpd()
    {
        $data = [
            'tittle' => 'GTA CI siDika Tambah Tujuan PD'
            // 'datausers' => $resultquery
        ];

        return view('entry/tujuanpdcreate', $data);
    }

    public function tambahindikatortujuanpd()
    {
        $kode_user_skpd = user()->kode_user;
        $get_id = $this->request->getVar('id_indtujuanpd');
        $get_indikator_tujuanpd = $this->tb_tujuanpd->gettujuanpdbyidandkodeskpd($get_id, $kode_user_skpd);

        $data = [
            'tittle' => 'GTA CI siDika Tambah Indikator Tujuan PD',
            'id_tujuanpd' => $get_id,
            'indikatortujuanpd' => $get_indikator_tujuanpd
        ];

        return view('entry/tujuandetailcreate', $data);
    }

    public function edittujuanpd($id)
    {
        $kode_user_skpd = user()->kode_user;

        $get_tujuan = $this->tb_tujuanpd->gettujuanpdbyidandkodeskpd($id, $kode_user_skpd);

        //jika tujuanpd tidak ada dalam database
        if (empty($get_tujuan)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tersebut : ' . $id . ' Tidak ada dalam database');
        }

        $get_visi = $this->ms_visi->getvisiarray($get_tujuan[0]['fr_id_visi']);
        $get_misi = $this->ms_misi->getmisiarray($get_tujuan[0]['fr_id_misi']);

        $data = [
            'tittle' => 'GTA CI siDika Edit Tujuan PD',
            'tujuanpd' => $get_tujuan,
            'visi' => $get_visi,
            'misi' => $get_misi
        ];

        return view('entry/tujuanpdedit', $data);
    }

    public function edittujuanpddetail()
    {
        $get_id = $this->request->getVar('id');
        $get_indikator = $this->request->getVar('indikator');
        $get_tujuanpd = $this->request->getVar('tujuanpd');

        $get_data_detail_edit = $this->tb_tujuanpd_detail->getdatadetailedit($get_id, $get_indikator);

        $data = [
            'tittle' => 'GTA CI siDika Tujuan PD Detail',
            'id' => $get_id,
            'indikator' => $get_indikator,
            'indikator_edit' => $get_data_detail_edit,
            'tujuanpd' => $get_tujuanpd
        ];

        return view('entry/tujuanpddetailedit', $data);
    }

    public function apigetdatavisi()
    {
        $get_term_visi = $this->request->getVar('searchTerm');

        if ($get_term_visi) {
            $list_visi = $this->ms_visi->select('id_visi,visi')->like('visi', $get_term_visi)->orderBy('visi')->findAll();
        } else {
            $list_visi = $this->ms_visi->select('id_visi,visi')->orderBy('visi')->findAll();
        }

        $data = [];

        foreach ($list_visi as $value) {
            $data[] = [
                'id' => $value['id_visi'],
                'text' => $value['visi']
            ];
        }

        $response['data'] = $data;
        return $this->response->setJSON($response);
    }

    public function apigetdatamisi()
    {
        $get_term_misi = $this->request->getVar('searchTerm');
        $get_id = $this->request->getVar('getid');
        $data = [];

        if ($get_term_misi) {
            $list_misi = $this->ms_misi->getapimisiterm($get_id, $get_term_misi);
        } else {
            $list_misi = $this->ms_misi->getapimisi($get_id);
        }

        foreach ($list_misi as $value) {
            $data[] = [
                'id' => $value['id_misi'],
                'text' => $value['misi']
            ];
        }

        $response['data'] = $data;
        return $this->response->setJSON($response);
    }

    public function apigetdataindiaktortujuanpd()
    {
        $kode_user_skpd = user()->kode_user;
        $id = $_POST['id_data'];

        $data = [
            'gettujuanpd' => $this->tb_tujuanpd->gettujuanpdbyidandkodeskpd($id, $kode_user_skpd),
            'getdatadetailtujuanpd' => $this->tb_tujuanpd_detail->getdatadetail($id),
            'getdatadetailtujuanpddistinct' => $this->tb_tujuanpd_detail->getdatadetaildistinct($id)
        ];

        echo json_encode($data);
    }

    public function savetujuanpd()
    {
        $get_visi = $this->request->getVar('visiselect');
        $get_misi = $this->request->getVar('misiselect');
        $get_tujuanpd = $this->request->getVar('tujuanpd');
        $kode_user = user()->kode_user;

        $this->tb_tujuanpd->savetujuanpd($get_visi, $get_misi, $kode_user, $get_tujuanpd);

        session()->setFlashdata('pesan', 'inserttujuanpd');

        return redirect()->to('/entrytujuanpd');
    }

    public function saveindikatortujuanpd()
    {
        $get_id_tujuanpd = $this->request->getVar('id_tujuanpd');
        $get_indikator_tujuanpd = $this->request->getVar('indikator_tujuanpd');

        $get_value_awal = $this->request->getVar('valawal');
        $get_satuan_awal = $this->request->getVar('satawal');

        $get_value_akhir = $this->request->getVar('valakhir');
        $get_satuan_akhir = $this->request->getVar('satakhir');

        $tahunawal = 'awal';
        $tahunakhir = 'akhir';
        $tahunratarata = 'mean';

        $splitcomma_get_value_awal = str_replace(',', '.', $get_value_awal);
        $float_get_value_awal = (float)$splitcomma_get_value_awal;
        $pembulatan_get_value_awal = round($float_get_value_awal, 2);

        $splitcomma_get_value_akhir = str_replace(',', '.', $get_value_akhir);
        $float_get_value_akhir = (float)$splitcomma_get_value_akhir;
        $pembulatan_get_value_akhir = round($float_get_value_akhir, 2);

        $mean_get_value = ($float_get_value_awal + $float_get_value_akhir) / 2;
        $pembulatan_mean_get_value = round($mean_get_value, 2);

        //insert data tahun awal
        $this->tb_tujuanpd_detail->saveindikatortujuanpd($get_indikator_tujuanpd, $tahunawal, $pembulatan_get_value_awal, $get_satuan_awal, $get_id_tujuanpd);

        //insert data tahun akhir
        $this->tb_tujuanpd_detail->saveindikatortujuanpd($get_indikator_tujuanpd, $tahunakhir, $pembulatan_get_value_akhir, $get_satuan_akhir, $get_id_tujuanpd);

        //insert data rata-rata
        $this->tb_tujuanpd_detail->saveindikatortujuanpd($get_indikator_tujuanpd, $tahunratarata, $pembulatan_mean_get_value, $get_satuan_akhir, $get_id_tujuanpd);

        session()->setFlashdata('pesan', 'insertindikatortujuanpd');

        return redirect()->to('/entrytujuanpd');
    }

    public function updatetujuanpd()
    {
        $get_id_tujuanpd = $this->request->getVar('id_tujuanpd');
        $get_visi_edit = $this->request->getVar('visiselect');
        $get_misi_edit = $this->request->getVar('misiselect');
        $get_tujuanpd_edit = $this->request->getVar('tujuanpd');

        $this->tb_tujuanpd->updatetujuanpd($get_id_tujuanpd, $get_visi_edit, $get_misi_edit, $get_tujuanpd_edit);

        session()->setFlashdata('pesan', 'updatetujuanpd');

        return redirect()->to('/entrytujuanpd');
    }

    public function updatetujuanpddetail()
    {
        $get_id = $this->request->getVar('id');
        $get_indikator = $this->request->getVar('indikator');

        $get_data_detail_edit = $this->tb_tujuanpd_detail->getdatadetailedit($get_id, $get_indikator);

        $hitung = count($get_data_detail_edit);

        $sumfloatvalue = 0;
        for ($i = 0; $i < $hitung; $i++) {
            $id = $this->request->getVar('id' . $get_data_detail_edit[$i]['tahun']);
            $value = $this->request->getVar('indikator' . $get_data_detail_edit[$i]['tahun']);
            $satuan = $this->request->getVar('satuan' . $get_data_detail_edit[$i]['tahun']);

            $id_int = (int)$id;

            //tampung jumlah value nya
            $splitcomma_get_value = str_replace(',', '.', $value);
            $float_get_value = (float)$splitcomma_get_value;
            $pembulatan_get_value = round($float_get_value, 2);
            $sumfloatvalue += $pembulatan_get_value;

            $this->tb_tujuanpd_detail->updatetujuanpddetail($id_int, $pembulatan_get_value, $satuan, $get_indikator);
        }

        $idmean = $this->request->getVar('idmean');
        $satuanmean = $this->request->getVar('satuan' . $get_data_detail_edit[0]['tahun']);
        $ratarata = $sumfloatvalue / 2;

        $this->tb_tujuanpd_detail->updatetujuanpddetail($idmean, $ratarata, $satuanmean, $get_indikator);

        session()->setFlashdata('pesan', 'merubahdetailtujuanpd');

        return redirect()->to('/entrytujuanpd');
    }

    public function hapustujuanpddetail()
    {
        $get_id = $this->request->getVar('id');
        $get_indikator = $this->request->getVar('indikator');

        $this->tb_tujuanpd_detail->deletetujuanpdbyindikatorandid($get_id, $get_indikator);

        session()->setFlashdata('pesan', 'hapusindikatorpd');
        return redirect()->to('/entrytujuanpd');
    }

    public function hapustujuanpd()
    {
        $get_id = $this->request->getVar('id_hidden');

        if (empty($this->tb_tujuanpd_detail->getdatadetail($get_id))) {
            $this->tb_tujuanpd->deletetujuanpdbyid($get_id);
            session()->setFlashdata('pesan', 'hapustujuanpd');
            return redirect()->to('/entrytujuanpd');
        } else {
            session()->setFlashdata('pesan', 'gagalhapustujuanpd');
            return redirect()->to('/entrytujuanpd');
        }
    }

    public function viewprintpdftujuanpd()
    {
        $kode_user_skpd = user()->kode_user;

        $nama_skpd = $this->users->getnamaskpd($kode_user_skpd);

        $visigetdb = $this->ms_visi->findAll();
        $visicount = $this->ms_visi->countAllResults();

        $get_distinc_misi_id = $this->tb_tujuanpd->getfridmisi_distinc($kode_user_skpd);
        $count_get_distinc_misi_id = count($get_distinc_misi_id);
        $count_end = $count_get_distinc_misi_id - 1;

        $tujuangetdb_pd = $this->tb_tujuanpd->gettujuanpd($kode_user_skpd);
        $tujuancount_pd = count($tujuangetdb_pd);

        //MEMBUAT WHERE CLAUSE
        $where_clause = "";
        if ($count_get_distinc_misi_id == 1) {
            $where_clause = 'id_misi = ' . $get_distinc_misi_id[0]['fr_id_misi'];
        } else {
            for ($iter = 0; $iter < $count_get_distinc_misi_id; $iter++) {
                if ($iter == $count_end) {
                    $where_clause .= "id_misi = " . $get_distinc_misi_id[$iter]['fr_id_misi'];
                } else {
                    $where_clause .= "id_misi = " . $get_distinc_misi_id[$iter]['fr_id_misi'] . " OR ";
                }
            }
        }
        //END - MEMBUAT WHERE CLAUSE

        $misigetdb = $this->ms_misi->getmisibyidmisi_operasi_or($where_clause);
        $misicount = count($misigetdb);

        $temp_data = [];
        $temp_data_id = [];
        $temp_data_id_tujuanpd = [];
        for ($i = 0; $i < $visicount; $i++) {
            for ($j = 0; $j < $misicount; $j++) {
                $indek = 0;
                for ($k = 0; $k < $tujuancount_pd; $k++) {
                    if ($tujuangetdb_pd[$k]['fr_id_visi'] == $visigetdb[$i]['id_visi'] && $tujuangetdb_pd[$k]['fr_id_misi'] == $misigetdb[$j]['id_misi']) {
                        $temp_data[$visigetdb[$i]['visi']][$misigetdb[$j]['misi']][$indek] = $tujuangetdb_pd[$k]['tujuanpd'];
                        $temp_data_id[$visigetdb[$i]['visi']][$misigetdb[$j]['misi']][$indek] = $tujuangetdb_pd[$k]['id_tujuanpd'];
                        $temp_data_id_tujuanpd[$k] = $tujuangetdb_pd[$k]['id_tujuanpd'];
                        $indek = $indek + 1;
                    }
                }
            }
        }

        //MEMBUAT WHERE CLAUSE
        $where_clause_detail = "";
        if (count($temp_data_id_tujuanpd) == 1) {
            $where_clause_detail = 'fr_id_tujuanpd = ' . $temp_data_id_tujuanpd[0];
        } else {
            for ($iter2 = 0; $iter2 < count($temp_data_id_tujuanpd); $iter2++) {
                if ($iter2 == count($temp_data_id_tujuanpd) - 1) {
                    $where_clause_detail .= "fr_id_tujuanpd = " . $temp_data_id_tujuanpd[$iter2];
                } else {
                    $where_clause_detail .= "fr_id_tujuanpd = " . $temp_data_id_tujuanpd[$iter2] . " OR ";
                }
            }
        }
        //END - MEMBUAT WHERE CLAUSE        

        $array_detailpd = [];
        $get_tujuanpd_detail = $this->tb_tujuanpd_detail->cetak_getdetaildatatujuanpd($where_clause_detail);
        $get_tujuanpd_detail_distinc = $this->tb_tujuanpd_detail->cetak_getdetaildatatujuanpd_distinc($where_clause_detail);

        for ($iterarsi_detail = 0; $iterarsi_detail < count($get_tujuanpd_detail_distinc); $iterarsi_detail++) {
            $array_detailpd[$iterarsi_detail]['indikator_tujuanpd'] = $get_tujuanpd_detail_distinc[$iterarsi_detail]['indikator_tujuanpd'];
            $array_detailpd[$iterarsi_detail]['fr_id_tujuanpd'] = $get_tujuanpd_detail_distinc[$iterarsi_detail]['fr_id_tujuanpd'];
            for ($iterasi_detail2 = 0; $iterasi_detail2 < count($get_tujuanpd_detail); $iterasi_detail2++) {
                if ($get_tujuanpd_detail_distinc[$iterarsi_detail]['indikator_tujuanpd'] == $get_tujuanpd_detail[$iterasi_detail2]['indikator_tujuanpd'] && $get_tujuanpd_detail_distinc[$iterarsi_detail]['fr_id_tujuanpd'] == $get_tujuanpd_detail[$iterasi_detail2]['fr_id_tujuanpd']) {
                    if ($get_tujuanpd_detail[$iterasi_detail2]['tahun'] == 'awal') {
                        $replacecomma = str_replace('.', ',', $get_tujuanpd_detail[$iterasi_detail2]['nilai']);
                        if ($get_tujuanpd_detail[$iterasi_detail2]['nilai'] == '1.00') {
                            $array_detailpd[$iterarsi_detail]['nilai_awal'] =  $get_tujuanpd_detail[$iterasi_detail2]['satuan'];
                        } else if ($get_tujuanpd_detail[$iterasi_detail2]['satuan'] == '-') {
                            $array_detailpd[$iterarsi_detail]['nilai_awal'] =  $replacecomma;
                        } else {
                            $array_detailpd[$iterarsi_detail]['nilai_awal'] =  $replacecomma . " " . $get_tujuanpd_detail[$iterasi_detail2]['satuan'];
                        }
                    } else if ($get_tujuanpd_detail[$iterasi_detail2]['tahun'] == 'akhir') {
                        $replacecomma = str_replace('.', ',', $get_tujuanpd_detail[$iterasi_detail2]['nilai']);
                        if ($get_tujuanpd_detail[$iterasi_detail2]['nilai'] == '1.00') {
                            $array_detailpd[$iterarsi_detail]['nilai_akhir'] =  $get_tujuanpd_detail[$iterasi_detail2]['satuan'];
                        } else if ($get_tujuanpd_detail[$iterasi_detail2]['satuan'] == '-') {
                            $array_detailpd[$iterarsi_detail]['nilai_akhir'] =  $replacecomma;
                        } else {
                            $array_detailpd[$iterarsi_detail]['nilai_akhir'] =  $replacecomma . " " . $get_tujuanpd_detail[$iterasi_detail2]['satuan'];
                        }
                    } else if ($get_tujuanpd_detail[$iterasi_detail2]['tahun'] == 'mean') {
                        $replacecomma = str_replace('.', ',', $get_tujuanpd_detail[$iterasi_detail2]['nilai']);
                        if ($get_tujuanpd_detail[$iterasi_detail2]['nilai'] == '1.00') {
                            $array_detailpd[$iterarsi_detail]['nilai_rata2'] =  $get_tujuanpd_detail[$iterasi_detail2]['satuan'];
                        } else if ($get_tujuanpd_detail[$iterasi_detail2]['satuan'] == '-') {
                            $array_detailpd[$iterarsi_detail]['nilai_rata2'] =  $replacecomma;
                        } else {
                            $array_detailpd[$iterarsi_detail]['nilai_rata2'] =  $replacecomma . " " . $get_tujuanpd_detail[$iterasi_detail2]['satuan'];
                        }
                    }
                }
            }
        }

        $data = [
            'tittle' => 'GTA CI siDika Tambah Tujuan PD',
            'nama_skpd' => $nama_skpd,
            'visidata' => $visigetdb,
            'visihitung' => $visicount,
            'misidata' => $misigetdb,
            'misihitung' => $misicount,
            'data_tujuan_pd' => $temp_data,
            'id_data_tujuan_pd' => $temp_data_id,
            'indikator_detail' => $array_detailpd
        ];

        // return view('print/tujuanpdviewprint', $data);

        $html =  view('print/tujuanpdviewprint', $data);

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('folio', 'landscape');
        $this->dompdf->render();
        $this->dompdf->stream('tujuan_perangkat_daerah.pdf', array(
            "Attachment" => false
        ));
    }
}
