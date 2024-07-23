<?php

namespace App\Controllers\Filing;
// use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Common\DropdownListModel;
use App\Models\Filing\PartyModel;
use App\Libraries\webservices\Efiling_webservices;
use App\Libraries\webservices\Highcourt_webservices;

class Party extends BaseController
{
    // protected $session;
    public $DropdownListModel;
    public $efiling_webservices;
    public $highcourt_webservices;
    public $PartyModel;

    function __construct()
    {
        $this->DropdownListModel= new DropdownListModel();
        $this->PartyModel = new PartyModel();
    }




    public function index(){
        // echo "<pre>"; print_r($_SESSION['filing_details']); die;
        if(isset($_SESSION['filing_details'])){
            return redirect()->to('Filing/Party/partyDetails');
        }else{
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
                    return redirect()->to('Filing/Party/redirect_on_diary_user_type');exit();
                }else{
                    session()->setFlashdata("message_error", 'Data not Fount');
                }
    
            }
            $data['casetype']=get_from_table_json('casetype');
            $data['formAction'] = 'Filing/Party/index/';
            return view('Filing/diary_search_party',$data);
        }        
    }


    function redirect_on_diary_user_type() {
        if(session()->get('login')) {
            return redirect()->to('Filing/Party/partyDetails');
        }else{
            session()->setFlashdata("message_error", 'Accessing permission denied contact to Computer Cell.');
        }
        return redirect()->to('Filing/Party/partyDetails');
    }

    public function partyDetails(){
        $data['state_list'] = $this->DropdownListModel->get_address_state_list();
        $diary_no = $_SESSION['filing_details']['diary_no'];
        $data['diary_no'] = $diary_no;
        $data['party_list'] = $this->PartyModel->getpartyList($diary_no);
        $data['copied_party_list'] = $this->PartyModel->getCopiedpartyList($diary_no);
        $data['lr_list'] = $this->PartyModel->getLRList($diary_no);
        $data['lowercase'] = $this->PartyModel->getlowercase($diary_no);
        $data['occ_list'] = $this->PartyModel->getoccupList();
        $data['edu_list'] = $this->PartyModel->geteduList();
        $data['country_list'] = $this->PartyModel->getcountryList();

        $data['get_only_state_name'] = $this->PartyModel->get_only_state_name();
        $data['get_only_post'] = $this->PartyModel->get_only_post();
        $data['get_petResCaseTitle'] = $this->PartyModel->get_petResCaseTitle($diary_no);
        $data['casetypeDetails'] = $this->PartyModel->casetypeDetails($diary_no);
        // echo "<pre>"; print_r($data['party_list']); die;
        // if(!empty($data['lowercase'])){
        //     $data['no_of_chall'] = 1;
        // }else{
        //     $data['no_of_chall'] = 0;
        // }

        return view('Filing/party_view', $data);
    }

    public function set_party_status(){
        if(!empty($_POST['data'])){
            $dataArr = $_POST['data'];
            $data = $this->PartyModel->set_party_status($dataArr);
            echo $data;
        }
    }

    public function save_party_details(){
        if(!empty($_POST['data'])){
            $dataArr = $_POST['data'];
            $data = $this->PartyModel->savepartyDetails($dataArr);
            echo $data;
        }
    }

    public function deleteAction(){
        $dataset = $_POST['data'];
        $data = $this->PartyModel->deleteAction($dataset);
        echo $data;
    }

    public function getUpdateData(){
        $dataset = $_POST['data'];
        $data = $this->PartyModel->getUpdateData($dataset);
        echo $data;
    }

    public function get_cause_title(){
        $dataset = $_POST['data'];
        $data = $this->PartyModel->get_cause_title($dataset);
        echo $data;
    }

    public function copy_party_details(){
        $dataset = $_POST['data'];
        $data = $this->PartyModel->copy_party_details($dataset);
        echo $data;
    }


    public function getDepttList(){
        $dataset = $_POST['deptt'];
        $data = $this->PartyModel->get_only_deptt($dataset);
        echo $data;
    }

}