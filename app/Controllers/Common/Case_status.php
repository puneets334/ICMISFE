<?php

namespace App\Controllers\Common;

use App\Controllers\BaseController;
use App\Models\Entities\Model_main;
use App\Models\Entities\Model_main_a;

class Case_status extends BaseController
{
    public $Model_main;
    public $Model_main_a;

    function __construct()
    {
        $this->Model_main = new Model_main();
        $this->Model_main_a = new Model_main_a();
        ini_set('memory_limit','1024M');
    }
    function index()
    {

        $data['casetype']=get_from_table_json('casetype');
        return view('Common/Component/case_status/case_status',$data);
    }

    function case_status(){

        if ($this->request->getMethod() === 'post') {
            $search_type=$this->request->getPost('search_type');
            $diary_number=$this->request->getPost('diary_number');
            $diary_year=$this->request->getPost('diary_year');
            $case_type=$this->request->getPost('case_type');
            $case_number=$this->request->getPost('case_number');
            $case_year=$this->request->getPost('case_year');

            $this->validation->setRule('search_type', 'Select Diary or Case type', 'required');

            if (!empty($search_type) && $search_type !=null){
                if ($search_type =='D'){
                    $this->validation->setRule('search_type', 'Select Diary or Case type', 'required');
                    $this->validation->setRule('diary_number', 'Diary number', 'required');
                    $this->validation->setRule('diary_year', 'Diary year', 'required');

                    $data = [
                        'search_type'=>$search_type,
                        'diary_number'=>$diary_number,
                        'diary_year'=>$diary_year,
                    ];

                }else{
                    $this->validation->setRule('search_type', 'Select Diary or Case type', 'required');
                    $this->validation->setRule('case_type', 'Case type', 'required');
                    $this->validation->setRule('case_number', 'Case number', 'required');
                    $this->validation->setRule('case_year', 'Case year', 'required');

                    $data = [
                        'search_type'=>$search_type,
                        'case_type'=>$case_type,
                        'case_number'=>$case_number,
                        'case_year'=>$case_year,
                    ];
                }

            }else{
                $data = [
                    'search_type'=>$search_type
                ];
            }

            if (!$this->validation->run($data)) {
                echo '3@@@';
                echo $this->validation->listErrors();exit();
            }
            $is_a='';
            if ($search_type !='D'){
                $main_diary_number = get_diary_case_type($case_type,$case_number,$case_year);
            }else{
                $main_diary_number = $diary_number.$diary_year;
            }
            echo component_case_status_process_tab($main_diary_number);exit();

        }
        exit();
    }

    function earlier_court(){
        if ($this->request->getMethod() === 'post') {
            $diary_number=$this->request->getPost('diaryno');
            /*$this->validation->setRule('diaryno', 'Diary Number', 'required');

            if (!$this->validation->run($diary_number)) {
                echo '3@@@';
                echo $this->validation->listErrors();exit();
            }
            */

            echo component_earlier_court_tab($diary_number);exit();
        }
        exit();
    }
}
