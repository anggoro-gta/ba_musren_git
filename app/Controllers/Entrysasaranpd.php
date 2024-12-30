<?php

namespace App\Controllers;

use App\Models\usersModel;
use App\Models\msmisiModel;
use App\Models\msvisiModel;
use App\Models\tbtujuanpdModel;
use App\Models\tbsasaranpdModel;
use App\Models\tbsasaranpddetailModel;
use \Dompdf\Dompdf;

class Entrysasaranpd extends BaseController
{
    protected $users;

    protected $ms_visi;
    protected $ms_misi;
    protected $tb_sasaranpd;
    protected $tb_sasaranpddetail;
    protected $tb_tujuanpd;

    protected $dompdf;

    public function __construct()
    {
        $this->users = new usersModel();

        $this->ms_visi = new msvisiModel();
        $this->ms_misi = new msmisiModel();
        $this->tb_sasaranpd = new tbsasaranpdModel();
        $this->tb_tujuanpd = new tbtujuanpdModel();
        $this->tb_sasaranpddetail = new tbsasaranpddetailModel();

        $this->dompdf = new Dompdf();
    }

    public function index()
    {
        $kode_user_skpd = user()->kode_user;

        $get_fr_id_tujuan = $this->tb_sasaranpd->getfridtujuanpd($kode_user_skpd);

        //MEMBUAT WHERE CLAUSE   
        $where_clause = "";
        if (count($get_fr_id_tujuan) == 0) {
            $where_clause = "id_tujuanpd = 0";
        } else if (count($get_fr_id_tujuan) == 1) {
            $where_clause = 'id_tujuanpd = ' . $get_fr_id_tujuan[0]['fr_id_tujuanpd'];
        } else {
            for ($iter2 = 0; $iter2 < count($get_fr_id_tujuan); $iter2++) {
                if ($iter2 == count($get_fr_id_tujuan) - 1) {
                    $where_clause .= "id_tujuanpd = " . $get_fr_id_tujuan[$iter2]['fr_id_tujuanpd'];
                } else {
                    $where_clause .= "id_tujuanpd = " . $get_fr_id_tujuan[$iter2]['fr_id_tujuanpd'] . " OR ";
                }
            }
        }
        //END - MEMBUAT WHERE CLAUSE           

        $get_tujuanpd = $this->tb_tujuanpd->gettujuanpd_where($where_clause);
        $count_get_tujuanpd = count($get_tujuanpd);

        $data_sasaranpd = $this->tb_sasaranpd->getsasaranpd($kode_user_skpd);
        $count_data_sasaranpd = count($data_sasaranpd);

        $temp_data_sasaranpd = [];
        $temp_data_sasaranpd_id = [];
        for ($i = 0; $i < $count_get_tujuanpd; $i++) {
            $indek = 0;
            for ($j = 0; $j < $count_data_sasaranpd; $j++) {
                if ($get_tujuanpd[$i]['id_tujuanpd'] == $data_sasaranpd[$j]['fr_id_tujuanpd']) {
                    $temp_data_sasaranpd[$get_tujuanpd[$i]['tujuanpd']][$indek] = $data_sasaranpd[$j]['sasaranpd'];
                    $temp_data_sasaranpd_id[$get_tujuanpd[$i]['tujuanpd']][$indek] = $data_sasaranpd[$j]['id_sasaranpd'];
                    $indek = $indek + 1;
                }
            }
        }

        $data = [
            'tittle' => 'GTA CI siDika Sasaran PD',
            'datatujuanpd' => $get_tujuanpd,
            'hitungtujuanpd' => $count_get_tujuanpd,
            'datasasaranpd' => $temp_data_sasaranpd,
            'datasasaranpd_id' => $temp_data_sasaranpd_id
        ];

        return view('entry/sasaranpdindex', $data);
    }

    public function tambahsasaranpd()
    {
        $data = [
            'tittle' => 'GTA CI siDika Tambah Sasaran PD'
        ];

        return view('entry/sasaranpdcreate', $data);
    }

    public function savesasaranpd()
    {
        $kode_user_skpd = user()->kode_user;
        $get_tujuan = $this->request->getVar('tujuanpd');
        $get_sasaran = $this->request->getVar('sasaranpd');

        $this->tb_sasaranpd->savesasaranpd($kode_user_skpd, $get_tujuan, $get_sasaran);

        session()->setFlashdata('pesan', 'insertsasaranpd');

        return redirect()->to('/entrysasaranpd');
    }

    public function editsasaranpd($id)
    {
        $kode_user_skpd = user()->kode_user;

        $get_sasaranpd = $this->tb_sasaranpd->getsasaranpdbyidandkodeskpd($id, $kode_user_skpd);

        //jika sasaran Perangkat Daerah tidak ada dalam databases
        if (empty($get_sasaranpd)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tersebut : ' . $id . ' Tidak ada dalam database');
        }

        $get_tujuanpd = $this->tb_tujuanpd->gettujuanpdbyid($get_sasaranpd[0]['fr_id_tujuanpd']);

        $data = [
            'tittle' => 'GTA CI siDika Edit Sasaran PD',
            'tujuanpd' => $get_tujuanpd,
            'sasaranpd' => $get_sasaranpd
        ];

        return view('entry/sasaranpdedit', $data);
    }

    public function updatesasaranpd()
    {
        $get_id_tujuanpd = $this->request->getVar('tujuanpd');
        $get_sasaranpd = $this->request->getVar('sasaranpd');
        $get_id_sasaranpd = $this->request->getVar('id_sasaranpd');

        $this->tb_sasaranpd->updatesasaranpd($get_id_sasaranpd, $get_sasaranpd, $get_id_tujuanpd);

        session()->setFlashdata('pesan', 'updatesasaranpd');

        return redirect()->to('/entrysasaranpd');
    }

    public function tambahindikatorsasaranpd()
    {
        $kode_user_skpd = user()->kode_user;
        $get_id = $this->request->getVar('id_indsasaranpd');
        $get_sasaran = $this->tb_sasaranpd->getsasaranpdbyidandkodeskpd($get_id, $kode_user_skpd);

        $data = [
            'tittle' => 'GTA CI siDika Tambah Indikator Sasaran PD',
            'id_sasaranpd' => $get_id,
            'sasaranpd' => $get_sasaran
        ];

        return view('entry/sasaranpddetailcreate', $data);
    }

    public function saveindikatorsasaranpd()
    {
        $get_id_sasaranpd = $this->request->getVar('id_sasaranpd');
        $get_indikator_sasaranpd = $this->request->getVar('indikator_sasaranpd');

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
        $this->tb_sasaranpddetail->saveindikatorsasaranpd($get_indikator_sasaranpd, $tahunawal, $pembulatan_get_value_awal, $get_satuan_awal, $get_id_sasaranpd);

        //insert data tahun akhir
        $this->tb_sasaranpddetail->saveindikatorsasaranpd($get_indikator_sasaranpd, $tahunakhir, $pembulatan_get_value_akhir, $get_satuan_akhir, $get_id_sasaranpd);

        //insert data rata-rata
        $this->tb_sasaranpddetail->saveindikatorsasaranpd($get_indikator_sasaranpd, $tahunratarata, $pembulatan_mean_get_value, $get_satuan_akhir, $get_id_sasaranpd);

        session()->setFlashdata('pesan', 'insertindikatorsasaranpd');

        return redirect()->to('/entrysasaranpd');
    }

    public function editsasaranpddetail()
    {
        $get_id = $this->request->getVar('id');
        $get_indikator = $this->request->getVar('indikator');
        $get_sasaranpd = $this->request->getVar('sasaranpd');

        $get_data_detail_edit = $this->tb_sasaranpddetail->getdatadetailedit($get_id, $get_indikator);

        $data = [
            'tittle' => 'GTA CI siDika Sasaran PD Detail',
            'id' => $get_id,
            'indikator' => $get_indikator,
            'indikator_edit' => $get_data_detail_edit,
            'sasaranpd' => $get_sasaranpd
        ];

        return view('entry/sasaranpddetailedit', $data);
    }

    public function updatesasaranpddetail()
    {
        $get_id = $this->request->getVar('id');
        $get_indikator = $this->request->getVar('indikator');

        $get_data_detail_edit = $this->tb_sasaranpddetail->getdatadetailedit($get_id, $get_indikator);

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

            $this->tb_sasaranpddetail->updatesasaranpddetail($id_int, $pembulatan_get_value, $satuan, $get_indikator);
        }

        $idmean = $this->request->getVar('idmean');
        $satuanmean = $this->request->getVar('satuan' . $get_data_detail_edit[0]['tahun']);
        $ratarata = $sumfloatvalue / 2;

        $this->tb_sasaranpddetail->updatesasaranpddetail($idmean, $ratarata, $satuanmean, $get_indikator);

        session()->setFlashdata('pesan', 'merubahdetailsasaranpd');

        return redirect()->to('/entrysasaranpd');
    }

    public function hapussasaranpddetail()
    {
        $get_id = $this->request->getVar('id');
        $get_indikator = $this->request->getVar('indikator');

        $this->tb_sasaranpddetail->deletesasaranpdbyindikatorandid($get_id, $get_indikator);

        session()->setFlashdata('pesan', 'hapussasarandetail');
        return redirect()->to('/entrysasaranpd');
    }

    public function hapussasaranpd()
    {
        $get_id = $this->request->getVar('id_hidden');

        if (empty($this->tb_sasaranpddetail->getdatadetail($get_id))) {
            $this->tb_sasaranpd->deletesasaranpdbyid($get_id);
            session()->setFlashdata('pesan', 'hapussasaranpd');
            return redirect()->to('/entrysasaranpd');
        } else {
            session()->setFlashdata('pesan', 'gagalhapussasaranpd');
            return redirect()->to('/entrysasaranpd');
        }
    }

    public function apigetdataindiaktorsasaranpd()
    {
        $kode_user_skpd = user()->kode_user;
        $id = $_POST['id_data'];

        $data = [
            'getsasaranpd' => $this->tb_sasaranpd->getsasaranpdbyidandkodeskpd($id, $kode_user_skpd),
            'getdatadetailsasaranpd' => $this->tb_sasaranpddetail->getdatadetail($id),
            'getdatadetailsasaranpddistinct' => $this->tb_sasaranpddetail->getdatadetaildistinct($id)
        ];

        echo json_encode($data);
    }

    public function apigetdatatujuanpd()
    {
        $get_term_tujuanpd = $this->request->getVar('searchTerm');
        $kode_user_skpd = user()->kode_user;

        if ($get_term_tujuanpd) {
            $list_tujuanpd = $this->tb_tujuanpd->apigettujuanpdterm($kode_user_skpd, $get_term_tujuanpd);
        } else {
            $list_tujuanpd = $this->tb_tujuanpd->apigettujuanpdnoterm($kode_user_skpd);
        }

        foreach ($list_tujuanpd as $value) {
            $data[] = [
                'id' => $value['id_tujuanpd'],
                'text' => $value['tujuanpd']
            ];
        }

        $response['data'] = $data;
        return $this->response->setJSON($response);
    }

    public function viewprintpdfsasaranpd()
    {
        $kode_user_skpd = user()->kode_user;

        $nama_skpd = $this->users->getnamaskpd($kode_user_skpd);

        $visigetdb = $this->ms_visi->findAll();
        $visicount = $this->ms_visi->countAllResults();

        $get_fr_id_tujuanpd = $this->tb_sasaranpd->getfridtujuanpd_distinc($kode_user_skpd);
        $count_get_fr_id_tujuanpd = count($get_fr_id_tujuanpd);

        //MEMBUAT WHERE CLAUSE
        $where_clause_fr_id_tujuanpd = "";
        if ($count_get_fr_id_tujuanpd == 0) {
            $where_clause_fr_id_tujuanpd = "id_tujuanpd = 0";
        } else if ($count_get_fr_id_tujuanpd == 1) {
            $where_clause_fr_id_tujuanpd = 'id_tujuanpd = ' . $get_fr_id_tujuanpd[0]['fr_id_tujuanpd'];
        } else {
            for ($i = 0; $i < $count_get_fr_id_tujuanpd; $i++) {
                if ($i == $count_get_fr_id_tujuanpd - 1) {
                    $where_clause_fr_id_tujuanpd .= "id_tujuanpd = " . $get_fr_id_tujuanpd[$i]['fr_id_tujuanpd'];
                } else {
                    $where_clause_fr_id_tujuanpd .= "id_tujuanpd = " . $get_fr_id_tujuanpd[$i]['fr_id_tujuanpd'] . " OR ";
                }
            }
        }
        //END - MEMBUAT WHERE CLAUSE

        $get_fr_id_misi = $this->tb_tujuanpd->getfridmisi($where_clause_fr_id_tujuanpd);
        $count_get_fr_id_misi = count($get_fr_id_misi);

        //MEMBUAT WHERE CLAUSE
        $where_clause_get_fr_id_misi = "";
        if ($count_get_fr_id_misi == 0) {
            $where_clause_get_fr_id_misi = "id_misi = 0";
        } else if ($count_get_fr_id_misi == 1) {
            $where_clause_get_fr_id_misi = 'id_misi = ' . $get_fr_id_misi[0]['fr_id_misi'];
        } else {
            for ($i = 0; $i < $count_get_fr_id_misi; $i++) {
                if ($i == $count_get_fr_id_misi - 1) {
                    $where_clause_get_fr_id_misi .= "id_misi = " . $get_fr_id_misi[$i]['fr_id_misi'];
                } else {
                    $where_clause_get_fr_id_misi .= "id_misi = " . $get_fr_id_misi[$i]['fr_id_misi'] . " OR ";
                }
            }
        }
        //END - MEMBUAT WHERE CLAUSE

        $tujuangetdb_pd = $this->tb_tujuanpd->gettujuanpd($kode_user_skpd);
        $tujuancount_pd = count($tujuangetdb_pd);

        $misigetdb = $this->ms_misi->getmisibyidmisi_operasi_or($where_clause_get_fr_id_misi);
        $misicount = count($misigetdb);

        $temp_data = [];
        // $temp_data_id = [];
        // $temp_data_id_tujuanpd = [];
        for ($i = 0; $i < $visicount; $i++) {
            for ($j = 0; $j < $misicount; $j++) {
                $indek = 0;
                for ($k = 0; $k < $tujuancount_pd; $k++) {
                    if ($tujuangetdb_pd[$k]['fr_id_visi'] == $visigetdb[$i]['id_visi'] && $tujuangetdb_pd[$k]['fr_id_misi'] == $misigetdb[$j]['id_misi']) {
                        $temp_data[$visigetdb[$i]['visi']][$misigetdb[$j]['misi']][$indek] = $tujuangetdb_pd[$k]['tujuanpd'];
                        // $temp_data_id[$visigetdb[$i]['visi']][$misigetdb[$j]['misi']][$indek] = $tujuangetdb_pd[$k]['id_tujuanpd'];
                        // $temp_data_id_tujuanpd[$k] = $tujuangetdb_pd[$k]['id_tujuanpd'];
                        $indek = $indek + 1;
                    }
                }
            }
        }

        $sasarangetdb_pd = $this->tb_sasaranpd->getsasaranpd($kode_user_skpd);
        $sasarancount_pd = count($sasarangetdb_pd);
        $temp_data_sasranpd = [];
        $temp_data_sasranpd_id = [];
        $temp_data_sasranpd_id_send = [];

        for ($i = 0; $i < $visicount; $i++) {
            for ($j = 0; $j < $misicount; $j++) {
                $indek = 0;
                for ($k = 0; $k < $tujuancount_pd; $k++) {
                    if ($tujuangetdb_pd[$k]['fr_id_visi'] == $visigetdb[$i]['id_visi'] && $tujuangetdb_pd[$k]['fr_id_misi'] == $misigetdb[$j]['id_misi']) {
                        $indek = 0;
                        for ($l = 0; $l < $sasarancount_pd; $l++) {
                            if ($tujuangetdb_pd[$k]['id_tujuanpd'] == $sasarangetdb_pd[$l]['fr_id_tujuanpd']) {
                                $temp_data_sasranpd[$visigetdb[$i]['visi']][$misigetdb[$j]['misi']][$tujuangetdb_pd[$k]['tujuanpd']][$indek] = $sasarangetdb_pd[$l]['sasaranpd'];
                                $temp_data_sasranpd_id_send[$visigetdb[$i]['visi']][$misigetdb[$j]['misi']][$tujuangetdb_pd[$k]['tujuanpd']][$indek] = $sasarangetdb_pd[$l]['id_sasaranpd'];
                                $temp_data_sasranpd_id[$l] = $sasarangetdb_pd[$l]['id_sasaranpd'];
                                $indek = $indek + 1;
                            }
                        }
                    }
                }
            }
        }

        //MEMBUAT WHERE CLAUSE
        $where_clause_detail = "";

        if (count($temp_data_sasranpd_id) == 0) {
            $where_clause_detail = "fr_id_sasaranpd = 0";
        } else if (count($temp_data_sasranpd_id) == 1) {
            $where_clause_detail = "fr_id_sasaranpd = " . $temp_data_sasranpd_id[0];
        } else {
            for ($i = 0; $i < count($temp_data_sasranpd_id); $i++) {
                if ($i == count($temp_data_sasranpd_id) - 1) {
                    $where_clause_detail .= "fr_id_sasaranpd = " . $temp_data_sasranpd_id[$i];
                } else {
                    $where_clause_detail .= "fr_id_sasaranpd = " . $temp_data_sasranpd_id[$i] . " OR ";
                }
            }
        }
        //END - MEMBUAT WHERE CLAUSE 

        $array_detailpd = [];
        $get_sasaranpd_detail = $this->tb_sasaranpddetail->cetak_getdetaildatasasaranpd($where_clause_detail);
        $get_sasaranpd_detail_distinc = $this->tb_sasaranpddetail->cetak_getdetaildatasasaranpd_distinc($where_clause_detail);

        for ($iterarsi_detail = 0; $iterarsi_detail < count($get_sasaranpd_detail_distinc); $iterarsi_detail++) {
            $array_detailpd[$iterarsi_detail]['indikator_sasaranpd'] = $get_sasaranpd_detail_distinc[$iterarsi_detail]['indikator_sasaranpd'];
            $array_detailpd[$iterarsi_detail]['fr_id_sasaranpd'] = $get_sasaranpd_detail_distinc[$iterarsi_detail]['fr_id_sasaranpd'];
            for ($iterasi_detail2 = 0; $iterasi_detail2 < count($get_sasaranpd_detail); $iterasi_detail2++) {
                if ($get_sasaranpd_detail_distinc[$iterarsi_detail]['indikator_sasaranpd'] == $get_sasaranpd_detail[$iterasi_detail2]['indikator_sasaranpd'] && $get_sasaranpd_detail_distinc[$iterarsi_detail]['fr_id_sasaranpd'] == $get_sasaranpd_detail[$iterasi_detail2]['fr_id_sasaranpd']) {
                    if ($get_sasaranpd_detail[$iterasi_detail2]['tahun'] == 'awal') {
                        $replacecomma = str_replace('.', ',', $get_sasaranpd_detail[$iterasi_detail2]['nilai']);
                        if ($get_sasaranpd_detail[$iterasi_detail2]['nilai'] == '1.00') {
                            $array_detailpd[$iterarsi_detail]['nilai_awal'] =  $get_sasaranpd_detail[$iterasi_detail2]['satuan'];
                        } else if ($get_sasaranpd_detail[$iterasi_detail2]['satuan'] == '-') {
                            $array_detailpd[$iterarsi_detail]['nilai_awal'] =  $replacecomma;
                        } else {
                            $array_detailpd[$iterarsi_detail]['nilai_awal'] =  $replacecomma . " " . $get_sasaranpd_detail[$iterasi_detail2]['satuan'];
                        }
                    } else if ($get_sasaranpd_detail[$iterasi_detail2]['tahun'] == 'akhir') {
                        $replacecomma = str_replace('.', ',', $get_sasaranpd_detail[$iterasi_detail2]['nilai']);
                        if ($get_sasaranpd_detail[$iterasi_detail2]['nilai'] == '1.00') {
                            $array_detailpd[$iterarsi_detail]['nilai_akhir'] =  $get_sasaranpd_detail[$iterasi_detail2]['satuan'];
                        } else if ($get_sasaranpd_detail[$iterasi_detail2]['satuan'] == '-') {
                            $array_detailpd[$iterarsi_detail]['nilai_akhir'] =  $replacecomma;
                        } else {
                            $array_detailpd[$iterarsi_detail]['nilai_akhir'] =  $replacecomma . " " . $get_sasaranpd_detail[$iterasi_detail2]['satuan'];
                        }
                    } else if ($get_sasaranpd_detail[$iterasi_detail2]['tahun'] == 'mean') {
                        $replacecomma = str_replace('.', ',', $get_sasaranpd_detail[$iterasi_detail2]['nilai']);
                        if ($get_sasaranpd_detail[$iterasi_detail2]['nilai'] == '1.00') {
                            $array_detailpd[$iterarsi_detail]['nilai_rata2'] =  $get_sasaranpd_detail[$iterasi_detail2]['satuan'];
                        } else if ($get_sasaranpd_detail[$iterasi_detail2]['satuan'] == '-') {
                            $array_detailpd[$iterarsi_detail]['nilai_rata2'] =  $replacecomma;
                        } else {
                            $array_detailpd[$iterarsi_detail]['nilai_rata2'] =  $replacecomma . " " . $get_sasaranpd_detail[$iterasi_detail2]['satuan'];
                        }
                    }
                }
            }
        }

        $data = [
            'tittle' => 'GTA CI siDika Cetak Sasaran PD',
            'nama_skpd' => $nama_skpd,
            'visidata' => $visigetdb,
            'visihitung' => $visicount,
            'misidata' => $misigetdb,
            'misihitung' => $misicount,
            'data_tujuan_pd' => $temp_data,
            'data_sasaran_pd' => $temp_data_sasranpd,
            'id_data_sasaran_pd' => $temp_data_sasranpd_id_send,
            'indikator_detail' => $array_detailpd
        ];

        // return view('print/tujuanpdviewprint', $data);

        $html =  view('print/sasaranpdviewprint', $data);

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('folio', 'landscape');
        $this->dompdf->render();
        $this->dompdf->stream('sasaran_perangkat_daerah.pdf', array(
            "Attachment" => false
        ));
    }
}
