<?php

namespace App\Controllers;

use App\Models\usersModel;
use App\Models\msmisiModel;
use App\Models\msvisiModel;
use App\Models\tbtujuanpdModel;
use App\Models\tbtujuanpddetailModel;
use \Dompdf\Dompdf;

class Masterprinttujuanpd extends BaseController
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
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.id as usersid, username, email, name, kode_user, fullname');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $builder->get();

        $resultquery = $query->getResult();

        $data = [
            'tittle' => 'GTA CI siDika Master Tujuan PD',
            'datausers' => $resultquery
        ];

        // dd($data['datausers']);

        return view('datamaster/cetaktujuanpd', $data);
    }

    public function masterprintpdftujuanpd($kode_user_skpd)
    {
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

        $html =  view('datamaster/pdfcetaktujuanpd', $data);

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('folio', 'landscape');
        $this->dompdf->render();
        $this->dompdf->stream('tujuan_perangkat_daerah.pdf', array(
            "Attachment" => true
        ));
    }
}
