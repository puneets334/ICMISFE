<?php

namespace App\Controllers\Judicial;
use App\Controllers\BaseController;
use App\Models\Common\DropdownListModel;
use App\Models\Judicial\UpdateDACodeModel;
use App\Libraries\webservices\Efiling_webservices;
use App\Libraries\webservices\Highcourt_webservices;

class UpdateDACode extends BaseController
{
    public $DropdownListModel;
    public $efiling_webservices;
    public $highcourt_webservices;
    public $UpdateDACodeModel;

    function __construct(){   
        $this->DropdownListModel= new DropdownListModel();
        $this->UpdateDACodeModel = new UpdateDACodeModel();
    }


    public function index(){
        if ($this->request->getMethod() === 'post' && $this->validate([
                'search_type' => ['label' => 'search Type', 'rules' => 'required|min_length[1]|max_length[1]'],
                'diary_number' => ['label' => 'Diary Number', 'rules' => 'required|min_length[1]|max_length[8]'],
                'diary_year' => ['label' => 'Diary Year', 'rules' => 'required|min_length[4]'],
            ])) {
            $search_type = $this->request->getPost('search_type');
            if ($search_type=='D'){
                $diary_number = $this->request->getPost('diary_number');
                $diary_year = $this->request->getPost('diary_year');
                $diary_no=$diary_number.$diary_year;
                $get_main_table= $this->DropdownListModel->get_diary_details_by_diary_no($diary_no);
            }elseif($search_type=='C'){
                $case_number = $this->request->getPost('case_number');
                $case_year = $this->request->getPost('case_year');
                session()->setFlashdata("message_error", 'Data not Fount');
            }


            if ($get_main_table){
                $this->session->set(array('filing_details'=> $get_main_table));
                return redirect()->to('Judicial/UpdateDACode/redirect_on_diary_user_type');exit();
            }else{
                session()->setFlashdata("message_error", 'Data not Fount');
            }

        }
        $data['formAction'] = 'Judicial/UpdateDACode/index/';
        $data['casetype']=get_from_table_json('casetype');
        return view('Judicial/diary_search',$data);
    }

    function redirect_on_diary_user_type() {
        if(session()->get('login')) {
            return redirect()->to('Judicial/UpdateDACode/updateCode');
        }else{
            session()->setFlashdata("message_error", 'Accessing permission denied contact to Computer Cell.');
        }
        return redirect()->to('Judicial/UpdateDACode/updateCode');
    }


    public function updateCode(){
        $diary_no = $_SESSION['filing_details']['diary_no'];
        $data['dno'] = $diary_no;
        $diary_year = substr($diary_no, -4);
        $data['dyr'] = $diary_year;
        $data['casedesc'] = $this->UpdateDACodeModel->get_casedesc($diary_no);
        // echo "<pre>";
        // print_r($data['casedesc']); die;
        return view('Judicial/updateCode_view', $data);
    }


    public function set_dacode(){
        $data = $_POST;
        if(!empty($data)){
            $msg = $this->UpdateDACodeModel->set_dacode($data);
            echo $msg;
        }
    }


}