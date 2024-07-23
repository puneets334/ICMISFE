<?php

namespace CodeIgniter\Validation;

namespace App\Controllers\Caveat;

use App\Controllers\BaseController;
use App\Models\Caveat\ModelSimilarity;
use App\Models\Entities\Caveat;
use App\Models\Entities\CaveatA;
use App\Models\Entities\CaveatAdvocate;
use App\Models\Entities\CaveatAdvocateA;
use App\Models\Entities\CaveatDiaryMatching;
use CodeIgniter\Model;

class CaveatDiaryMatched extends BaseController
{
    public $Model_caveat;
    public $Model_caveat_a;
    public $ModelSimilarity;
    public $Model_caveat_diary_matching;
    public $Model_CaveatAdvocate;
    public $Model_CaveatAdvocateA;
    function __construct()
    {
        $this->Model_caveat = new Caveat();
        $this->Model_caveat_a = new CaveatA();
        $this->ModelSimilarity = new ModelSimilarity();
        $this->Model_caveat_diary_matching = new CaveatDiaryMatching();
        $this->Model_CaveatAdvocate = new CaveatAdvocate();
        $this->Model_CaveatAdvocateA = new CaveatAdvocateA();
    }

    public function index()
    {

        return view('Caveat/CaveatDiaryMatched');
    }
    public function get_CaveatDiaryMatched()
    {
        $data['param'] = array();
        $response = $this->get_data();
        $data['CaveatDiaryMatched_list'] = $response;
        $resul_view = view('Caveat/get_CaveatDiaryMatched', $data);
        echo '1@@@' . $resul_view;
        exit();
    }
    public function get_data($is_archival_table = '')
    {
        $query = $this->db->table("lowerct a")
            ->distinct()
            ->select('a.diary_no, b.caveat_no')
            ->join("caveat_lowerct$is_archival_table b", 'a.lct_dec_dt = b.lct_dec_dt AND a.l_state = b.l_state AND trim(leading \'0\' from a.lct_caseno::text) = trim(leading \'0\' from b.lct_caseno::text) AND a.lct_caseyear = b.lct_caseyear AND a.ct_code = b.ct_code')
            ->join("caveat$is_archival_table c", 'c.caveat_no = b.caveat_no')
            ->join('caveat_diary_matching cdm', 'cdm.caveat_no = c.caveat_no AND cdm.diary_no = a.diary_no AND cdm.display = \'Y\'', 'left')
            ->join("main m", 'm.diary_no = a.diary_no AND m.c_status = \'P\'')
            ->where('date(c.diary_no_rec_date) >=', '2017-05-08')
            ->where('a.lw_display', 'Y')
            ->where('b.lw_display', 'Y')
            ->where('a.is_order_challenged', 'Y')
            ->where('b.lct_dec_dt IS NOT NULL')
            ->where('cdm.caveat_no IS NULL')
            ->where('cdm.diary_no IS NULL')
            ->groupStart()
            ->where('(m.diary_no_rec_date - c.diary_no_rec_date)<=\'90 days\' or date(c.diary_no_rec_date) > date(m.diary_no_rec_date)')
            ->groupEnd();
        $result = $query->get()->getResultArray();
        $query_a = $this->db->table("lowerct a")
            ->distinct()
            ->select('a.diary_no, b.caveat_no')
            ->join("caveat_lowerct_a b", 'a.lct_dec_dt = b.lct_dec_dt AND a.l_state = b.l_state AND trim(leading \'0\' from a.lct_caseno::text) = trim(leading \'0\' from b.lct_caseno::text) AND a.lct_caseyear = b.lct_caseyear AND a.ct_code = b.ct_code')
            ->join("caveat_a c", 'c.caveat_no = b.caveat_no')
            ->join('caveat_diary_matching cdm', 'cdm.caveat_no = c.caveat_no AND cdm.diary_no = a.diary_no AND cdm.display = \'Y\'', 'left')
            ->join("main m", 'm.diary_no = a.diary_no AND m.c_status = \'P\'')
            ->where('date(c.diary_no_rec_date) >=', '2017-05-08')
            ->where('a.lw_display', 'Y')
            ->where('b.lw_display', 'Y')
            ->where('a.is_order_challenged', 'Y')
            ->where('b.lct_dec_dt IS NOT NULL')
            ->where('cdm.caveat_no IS NULL')
            ->where('cdm.diary_no IS NULL')
            ->groupStart()
            ->where('(m.diary_no_rec_date - c.diary_no_rec_date) <= interval \'90 days\' or date(c.diary_no_rec_date) > date(m.diary_no_rec_date)')
            ->groupEnd();
        $result_a = $query_a->get()->getResultArray();
        return  $response = array_merge($result, $result_a);
    }
}
