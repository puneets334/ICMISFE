<?php

namespace App\Controllers\Filing;

use App\Controllers\BaseController;
use App\Models\Common\DropdownListModel;
use App\Models\Filing\IADocumentModel;
use App\Libraries\webservices\Efiling_webservices;
use App\Libraries\webservices\Highcourt_webservices;

class IaDocuments extends BaseController
{
    public $DropdownListModel;
    public $efiling_webservices;
    public $highcourt_webservices;
    public $IADocumentModel;

    function __construct()
    {
        $this->DropdownListModel = new DropdownListModel();
        $this->IADocumentModel = new IADocumentModel();
    }


    public function index()
    {
        // echo "<pre>"; print_r($_SESSION['filing_details']); die;
        if (isset($_SESSION['filing_details'])) {
            return redirect()->to('Filing/IaDocuments/IaDocumentsDetails');
        } else {
            if ($this->request->getMethod() === 'post' && $this->validate([
                'search_type' => ['label' => 'search Type', 'rules' => 'required|min_length[1]|max_length[1]'],
                'diary_number' => ['label' => 'Diary Number', 'rules' => 'required|min_length[1]|max_length[8]'],
                'diary_year' => ['label' => 'Diary Year', 'rules' => 'required|min_length[4]'],
            ])) {
                $search_type = $this->request->getPost('search_type');
                if ($search_type == 'D') {
                    $diary_number = $this->request->getPost('diary_number');
                    $diary_year = $this->request->getPost('diary_year');
                    $diary_no = $diary_number . $diary_year;
                    $get_main_table = $this->DropdownListModel->get_diary_details_by_diary_no($diary_no);
                } elseif ($search_type == 'C') {
                    $case_number = $this->request->getPost('case_number');
                    $case_year = $this->request->getPost('case_year');
                    session()->setFlashdata("message_error", 'Data not Fount');
                }

                if ($get_main_table) {
                    $this->session->set(array('filing_details' => $get_main_table));
                    return redirect()->to('Filing/IaDocuments/redirect_on_diary_user_type');
                    exit();
                } else {
                    session()->setFlashdata("message_error", 'Data not Fount');
                }
            }
            $data['casetype'] = get_from_table_json('casetype');
            $data['formAction'] = 'Filing/IaDocuments/index/';
            return view('Filing/diary_search_party', $data);
        }
    }


    function redirect_on_diary_user_type()
    {
        if (session()->get('login')) {
            return redirect()->to('Filing/IaDocuments/IaDocumentsDetails');
        } else {
            session()->setFlashdata("message_error", 'Accessing permission denied contact to Computer Cell.');
        }
        return redirect()->to('Filing/IaDocuments/IaDocumentsDetails');
    }

    public function IaDocumentsDetails()
    {

        if (!isset($_SESSION['filing_details'])) {
            return redirect()->to('Filing/IaDocuments/index');
        }
        $diary_no = $_SESSION['filing_details']['diary_no'];
        $data['dno'] = $diary_no;
        $diary_year = substr($diary_no, -4);
        $data['dyr'] = $diary_year;

        $data['aorList'] = $this->IADocumentModel->get_aor_name();
        $data['viewData'] = $this->IADocumentModel->get_hcinfo_m_e_new($diary_no);
        $data['doc_list'] = $this->IADocumentModel->getInfoForLd($diary_no);

        return view('Filing/ia_documents_view', $data);
    }


    public function caseBlockList_view()
    {

        if (!isset($_SESSION['filing_details'])) {
            // return redirect()->to('Filing/IaDocuments/index');
            if ($this->request->getMethod() === 'post' && $this->validate([
                'search_type' => ['label' => 'search Type', 'rules' => 'required|min_length[1]|max_length[1]'],
                'diary_number' => ['label' => 'Diary Number', 'rules' => 'required|min_length[1]|max_length[8]'],
                'diary_year' => ['label' => 'Diary Year', 'rules' => 'required|min_length[4]'],
            ])) {
                $search_type = $this->request->getPost('search_type');
                if ($search_type == 'D') {
                    $diary_number = $this->request->getPost('diary_number');
                    $diary_year = $this->request->getPost('diary_year');
                    $diary_no = $diary_number . $diary_year;
                    $get_main_table = $this->DropdownListModel->get_diary_details_by_diary_no($diary_no);
                } elseif ($search_type == 'C') {
                    $case_number = $this->request->getPost('case_number');
                    $case_year = $this->request->getPost('case_year');
                    session()->setFlashdata("message_error", 'Data not Fount');
                }

                if ($get_main_table) {
                    $this->session->set(array('filing_details' => $get_main_table));
                    return redirect()->to('Filing/IaDocuments/caseBlockList_view');
                    exit();
                } else {
                    session()->setFlashdata("message_error", 'Data not Fount');
                }
            }
            $data['casetype'] = get_from_table_json('casetype');
            $data['formAction'] = 'Filing/IaDocuments/caseBlockList_view/';
            return view('Filing/diary_search_party', $data);
        }

        $diary_no = $_SESSION['filing_details']['diary_no'];
        $data['dno'] = $diary_no;
        $diary_year = substr($diary_no, -4);
        $data['dyr'] = $diary_year;

        $data['caseBlock_list'] = $this->IADocumentModel->getcaseblocklist();

        return view('Filing/caseBlockList_view', $data);
    }

    public function verify_defective_view()
    {
        if (!isset($_SESSION['filing_details'])) {
            // return redirect()->to('Filing/IaDocuments/index');
            if ($this->request->getMethod() === 'post' && $this->validate([
                'search_type' => ['label' => 'search Type', 'rules' => 'required|min_length[1]|max_length[1]'],
                'diary_number' => ['label' => 'Diary Number', 'rules' => 'required|min_length[1]|max_length[8]'],
                'diary_year' => ['label' => 'Diary Year', 'rules' => 'required|min_length[4]'],
            ])) {
                $search_type = $this->request->getPost('search_type');
                if ($search_type == 'D') {
                    $diary_number = $this->request->getPost('diary_number');
                    $diary_year = $this->request->getPost('diary_year');
                    $diary_no = $diary_number . $diary_year;
                    $get_main_table = $this->DropdownListModel->get_diary_details_by_diary_no($diary_no);
                } elseif ($search_type == 'C') {
                    $case_number = $this->request->getPost('case_number');
                    $case_year = $this->request->getPost('case_year');
                    session()->setFlashdata("message_error", 'Data not Fount');
                }

                if ($get_main_table) {
                    $this->session->set(array('filing_details' => $get_main_table));
                    return redirect()->to('Filing/IaDocuments/verify_defective_view');
                    exit();
                } else {
                    session()->setFlashdata("message_error", 'Data not Fount');
                }
            }
            $data['casetype'] = get_from_table_json('casetype');
            $data['formAction'] = 'Filing/IaDocuments/verify_defective_view/';
            return view('Filing/diary_search_party', $data);
        }

        $diary_no = $_SESSION['filing_details']['diary_no'];
        $data['dno'] = $diary_no;
        $diary_year = substr($diary_no, -4);
        $data['dyr'] = $diary_year;

        $data['userDetails_verify'] = $this->IADocumentModel->getUserDetails_verify();
        $data['verify_defective'] = $this->IADocumentModel->getverify_defective();

        return view('Filing/verify_defective_view', $data);
    }



    public function get_party_name()
    {
        $dataset = $_POST['data'];
        $getParty = $this->IADocumentModel->get_party_name($dataset);
        echo $getParty;
    }

    public function getDoc_type1()
    {
        $diary_no = $_POST['dno'];
        $gettype = $this->IADocumentModel->getDoc_type1($diary_no);
        echo $gettype;
    }


    public function getPetResList()
    {
        $dataset = $_POST['data'];
        $getList = $this->IADocumentModel->getPetResList($dataset);
        echo $getList;
    }


    public function save_loose()
    {
        $dataset = $_POST;
        $getList = $this->IADocumentModel->save_loose($dataset);
        echo $getList;
    }

    public function del_for_ld_del()
    {
        $dataset = $_POST;
        $getList = $this->IADocumentModel->del_for_ld_del($dataset);
        echo $getList;
    }

    public function loose_up_new()
    {
        $dataset = $_POST;
        $getList = $this->IADocumentModel->loose_up_new($dataset);
        echo $getList;
    }

    public function delete_case_block()
    {
        $dataset = $_POST;
        $getList = $this->IADocumentModel->delete_case_block($dataset);
        echo $getList;
    }

    public function save_case_block()
    {
        $dataset = $_POST['data'];
        $getList = $this->IADocumentModel->save_case_block($dataset);
        echo $getList;
    }


    public function verify_save()
    {
        $dataset = $_POST['data'];
        $getList = $this->IADocumentModel->verify_save($dataset);
        echo $getList;
    }

    public function getRemarksList()
    {
        $dataset = $_POST['txt'];
        $getList = $this->IADocumentModel->getRemarksList($dataset);
        echo $getList;
    }
}
