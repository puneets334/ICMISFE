<?php

namespace App\Controllers\RecordRoom;

use App\Controllers\BaseController;

use App\Models\RecordRoom\ModelRecord;
use App\Models\Entities\Model_Ac;


class Record extends BaseController

{
    public $Model_Ac;

    public $model;

    function __construct()
    {
        $this->model = new ModelRecord();
        ini_set('memory_limit', '51200M');
         // This also needs to be increased in some cases. Can be changed to a higher value as per need)
        $this->Model_Ac = new Model_Ac();
    }

    public function index()

    {
        $sessionData = $this->session->get();
        $usercode = $sessionData['login']['usercode'];
        return view('Record_room/ac_form');
    }


    public function AorInsert()
    {
        $model = new ModelRecord();
        $sessionData = $this->session->get();
        $ucode = $sessionData['login']['usercode'];
        $tvap = $this->request->getGet('tvap');
        $wordChunks = explode(";", $tvap);
        for ($i = 0; $i < count($wordChunks); $i++) {
            $vform[$i] = str_replace("undefined", "", $wordChunks[$i]);
        }

        $vcname = $vform[2] . ' ' . $vform[3] . ' ' . $vform[4];
        // print_r($vcname); exit;
        if ((!$vform[0]) or (!$vcname) or (!$vform[5]) or (!$vform[22])) 
        {
            echo "Please Enter Mandatory *  Values";
            die(" ");
        }

        try {
            $aorcode = $vform[0];
            $eino = $vform[22];
            $Model = new ModelRecord();
            $numRows = $Model->checkExistingData($aorcode, $eino);
            if ($numRows > 0) {
                echo "Data already exists!!!";
                die();
            }
            $data = [
                'aor_code' => $aorcode,
                'cname' => $vcname,
                'cfname' => $vform[5],
                'pa_line1' => $vform[6],
                'pa_line2' => $vform[7],
                'pa_district' => $vform[8],
                'pa_pin' => $vform[9],
                'ppa_line1' => $vform[10],
                'ppa_line2' => $vform[11],
                'ppa_district' => $vform[12],
                'ppa_pin' => $vform[13],
                'dob' => date('Y-m-d', strtotime($vform[14])),
                'place_birth' => $vform[15],
                'nationality' => $vform[16],
                'cmobile' => $vform[17],
                'eq_x' => $vform[18],
                'eq_xii' => $vform[19],
                'eq_ug' => $vform[20],
                'eq_pg' => $vform[21],
                'eino' => $eino,
                'regdate' => date('Y-m-d', strtotime($vform[23])),
                'status' => 1,
                'updatedby' => $ucode,
                'updated_by' => $ucode,
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by_ip' => getClientIP(),
                'updatedip' => getClientIP(),
            ];

            $model->insert1($data);
            echo "Record Successfully Inserted";
        } catch (\Exception $e) {
            die("Error! Contact Administrator!!");
        }
    }
    public function modify_details()
    {
        $Model = new ModelRecord();

        $data = [
            'clerkDetails' => $Model->getClerkDetails(),
        ];

        return view('Record_room/modify_ac_form', $data);
    }
    public function modify()
    {
        $Model = new ModelRecord();
        $id = $this->request->getGet('id');
        $res = '';
        $val = $Model->getval($id);
        $data['val'] = $val;
        // echo "<pre>";
        // print_r($id);
        // exit();
        return view('Record_room/modify_ac_form1', $data);
    }
    public function getadv_name()
    {
        $model = new ModelRecord();
        $tvap = $this->request->getGet('tvap');
        $defects['result'] = $model->getadv_name1($tvap);
        // return view('Record_room/modify_ac_form1');
    }


    public function AorUpdate()
    {
        $sessionData = $this->session->get();
        $ucode = $sessionData['login']['usercode'];
        $tvap = $this->request->getGet('tvap');
        $id = $this->request->getGet('id');

        $wordChunks = explode(";", $tvap);
        for ($i = 0; $i < count($wordChunks); $i++) 
        {
            $vform[$i] = str_replace("undgdfgefined", "", $wordChunks[$i]);
        }
        $vcname = $vform[2] . ' ' . $vform[3] . ' ' . $vform[4];
        try {
            $aorcode = $vform[0];
            $eino = $vform[22];
            $data = [
                'aor_code' => $aorcode,
                'cname' => $vcname,
                'cfname' => $vform[5],
                'pa_line1' => $vform[6],
                'pa_line2' => $vform[7],
                'pa_district' => $vform[8],
                'pa_pin' => $vform[9],
                'ppa_line1' => $vform[10],
                'ppa_line2' => $vform[11],
                'ppa_district' => $vform[12],
                'ppa_pin' => $vform[13],
                'dob' => date('Y-m-d', strtotime($vform[14])),
                'place_birth' => $vform[15],
                'nationality' => $vform[16],
                'cmobile' => $vform[17],
                'eq_x' => $vform[18],
                'eq_xii' => $vform[19],
                'eq_ug' => $vform[20],
                'eq_pg' => $vform[21],
                'eino' => $eino,
                'regdate' => date('Y-m-d', strtotime($vform[23])),
                'status' => 1,
                'updatedby' => $ucode,
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by_ip' => getClientIP(),
                'updatedip' => getClientIP(),
            ];

            $model = new ModelRecord();
            $model->updateAc($id, $data);

            // Show alert message
            echo "<script>alert('Record Successfully Updated')</script>";
        } catch (\Exception $e) {
            die("Error! Contact Administrator!!");
        }
    }


    public function renewal()
    {
        $Model = new ModelRecord();


        return view('Record_room/renewal_cancel_ac_form');
    }
    public function getAorOptions()
    {
        $tvap = $this->request->getGet('tvap');
        $Model = new ModelRecord();
        $options1 = $Model->getaoroption($tvap);
        $data['options'] = $options1;
        return view('Record_room/renewal_cancel_ac_form', $data);
    }
    public function getAorOptions1()
    {
        $tvap = $this->request->getGet('tvap');
        $vadvc = $this->request->getGet('vadvc');
        $Model = new ModelRecord();
        $options = $Model->getaoroption1($tvap, $vadvc);
        return view('Record_room/renewal_cancel_ac_form');
    }
    public function getAORsWithMoreClerks()
    {
        $model = new ModelRecord();
        $data['model'] = $model;

        $data['records'] = $model->getAORsWithMoreClerks();
        foreach ($data['records'] as $record) {
            $data['clerks'][$record['aor_code']] = $model->getAORClerks($record['aor_code']);
        }
        $mergedData = array_merge_recursive($data['records'], $data['clerks']);
        $data['mergedData'] = $mergedData;
        return view('Record_room/reports/lst_aor_rep1', $data);
    }

    public function getCancelRecords()
    {
        $model = new ModelRecord();
        $data['records'] = $model->getCancelRecords();

        return view('Record_room/reports/lst_cancel_rec', $data);
    }

    public function duplicateRecords()
    {
        $model = new ModelRecord();
        $data['records'] = $model->getDuplicateRecords();

        foreach ($data['records'] as $record) {
            $data['clerks'][$record['eino']] = $model->getClerksAttachedWithAORs($record['eino']);
        }
        $mergedData = array_merge_recursive($data['records'], $data['clerks']);
        $data['mergedData'] = $mergedData;
        return view('Record_room/reports/lst_dup_rec', $data);
    }
    public function aorDetails()
    {
        $model = new ModelRecord();
        $data['records'] = $model->getAORDetails();

        // echo "<pre>"; print_r($data); exit;
        return view('Record_room/reports/lst_aor_rep', $data);
    }
    public function clerkReport()
    {
        $Model = new ModelRecord();

        $data = [
            'clerkDetails' => $Model->getClerkDetails(),
        ];
        return view('Record_room/reports/lst_clerk_rep', $data);
    }


    public function lst_clerk_rep1()
    {
        $model = new ModelRecord();
        $records = $model->getClerksWithMoreThan2AORs();
        foreach ($records as $record) {
            $data['clerks'][$record['eino']] = $model->getClerkDetailsByEino($record['eino']);
        }
        $data['records'] = $records;
        $mergedData = array_merge_recursive($data['records'], $data['clerks']);
        $data['mergedData'] = $mergedData;
        return view('Record_room/reports/lst_clerk_rep1', $data);
    }
    public function rr_user_mgmt_view()
    {
        $sessionData = $this->session->get();
        $ucode = $sessionData['login']['usercode'];
        $model = new ModelRecord();
        $data['records'] = $model->getdept();
        $data['user'] = $model->getuser($ucode);

        //   echo "<pre>"; print_r($data); exit();

        return view('Record_room/file_movement/rr_user_mgmt_view', $data);
    }
    public function lst_aor_search1()
    {
        $Model = new ModelRecord();

        $sessionData = session()->get();
        $ucode = $sessionData['login']['usercode'];

        $tvap = $this->request->getGet('tvap');

        $wordChunks = explode(";", $tvap);
        for ($i = 0; $i < count($wordChunks); $i++) {
            $vform[$i] = str_replace("undefined", "", $wordChunks[$i]);
        }
        $tvap = $vform[0];
        $aorn = $vform[1];

        if (!$tvap) {
            echo "Please Enter AOR Code";
            die(" ");
        }

        $clerks = $Model->getClerkDetails1($tvap);
        $transactions = [];
        $data['model'] = $Model;

        $data['clerks'] = $clerks;
        $data['aorn'] = $aorn;
        $data['tvap'] = $tvap;
        return view('Record_room/search/lst_aor_search_details', $data);

        exit;
    }
    public function lst_aor_search()
    {
        $sessionData = $this->session->get();
        $ucode = $sessionData['login']['usercode'];
        $model = new ModelRecord();
        $data['records'] = $model->getdept();
        $data['user'] = $model->getuser($ucode);

        //   echo "<pre>"; print_r($data); exit();

        return view('Record_room/search/lst_aor_search', $data);
    }
    public function lst_clerk_search()
    {
        $model = new ModelRecord();
        $records = $model->getClerksWithMoreThan2AORs();
        foreach ($records as $record) {
            $data['clerks'][$record['eino']] = $model->getClerkDetailsByEino($record['eino']);
        }
        $data['records'] = $records;
        $mergedData = array_merge_recursive($data['records'], $data['clerks']);
        $data['mergedData'] = $mergedData;

        //   echo "<pre>"; print_r($data); exit();

        return view('Record_room/search/lst_clerk_search', $data);
    }
    public function lst_clerk_search1()
    {
        $Model = new ModelRecord();

        $sessionData = session()->get();
        $ucode = $sessionData['login']['usercode'];

        $tvap = $this->request->getGet('tvap');

        $wordChunks = explode(";", $tvap);
        for ($i = 0; $i < count($wordChunks); $i++) {
            $vform[$i] = str_replace("undefined", "", $wordChunks[$i]);
        }
        $tvap = $vform[0];
        $aorn = $vform[1];

        if (!$tvap) {
            echo "Please Enter AOR Code";
            die(" ");
        }
        $records = $Model->getclerk($tvap);
        $data['model'] = $Model;
        $data['clerks'] = $records;
        $data['aorn'] = $aorn;
        $data['tvap'] = $tvap;




        return view('Record_room/search/lst_clerk_search_details', $data);

        exit;
    }
    public function getclerk_name()
    {
        $model = new ModelRecord();
        $tvap = $this->request->getGet('tvap');
        $defects['result'] = $model->getclerk1($tvap);

        return $defects['result'];

        // print_r($defects['result']);exit;
       
        // return view('Record_room/Record/lst_clerk_search',$defects);
    }
}
