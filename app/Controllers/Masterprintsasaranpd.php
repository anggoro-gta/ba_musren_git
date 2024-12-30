<?php

namespace App\Controllers;

use \Dompdf\Dompdf;
use App\Models\usersModel;
use App\Models\msmisiModel;
use App\Models\msvisiModel;
use App\Models\tbtujuanpdModel;
use App\Models\tbsasaranpdModel;
use App\Models\tbsasaranpddetailModel;

class Masterprintsasaranpd extends BaseController
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
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.id as usersid, username, email, name, kode_user, fullname');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $builder->get();

        $resultquery = $query->getResult();

        $data = [
            'tittle' => 'GTA CI siDika Master Sasaran PD',
            'datausers' => $resultquery
        ];

        // dd($data['datausers']);

        return view('datamaster/cetaksasaranpd', $data);
    }

    public function masterprintpdfsasaranpd($kode_user_skpd)
    {
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

        $html =  view('datamaster/pdfcetaksasaranpd', $data);

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('folio', 'landscape');
        $this->dompdf->render();
        $this->dompdf->stream('sasaran_perangkat_daerah.pdf', array(
            "Attachment" => true
        ));
    }
}
