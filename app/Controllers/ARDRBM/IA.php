<?php

namespace App\Controllers\ARDRBM;

use App\Controllers\BaseController;
use App\Models\ARDRBM\IAModel;
use App\Models\Common\DropdownListModel;

class IA extends BaseController
{
    public $DropdownListModel;
    public $IAModel;

    function __construct()
    {
        parent::__construct();
        $this->DropdownListModel = new DropdownListModel();
        $this->IAModel = new IAModel();
    }
    public function test($mobile = 9525555516)
    {
        echo $mobile;
        $application_number_display = 123;
        echo sendSMS($mobile, "Your application received in Copying Branch has been registered with application number " . $application_number_display . ". - Supreme Court of India", '1107161243437551558');
    }
    public function index()
    {
        $data['current_page_url'] = base_url('ARDRBM/IA');
        return view('ARDRBM/IA_view', $data);
    }
    public function doc_transfer()
    {
        $data['current_page_url'] = base_url('ARDRBM/IA/doc_transfer');
        return view('ARDRBM/IA_view', $data);
    }
    public function ia_entry_date_correction()
    {
        $data['current_page_url'] = base_url('ARDRBM/IA/ia_entry_date_correction');
        $this->render('ARDRBM/IA_view', compact('data'));
    }
    public function ia_updation()
    {
        $data['current_page_url'] = base_url('ARDRBM/IA/ia_updation');
        return view('ARDRBM/IA_view', $data);
    }
    public function get_search_view()
    {
        $default = '<span class="text-danger text-center"><h2>Under Development</h2></span>';
        $type = $_REQUEST['type'];
        if (!empty($type)) {
            $type = (int)$type;
            switch ($type) {
                case 3301: //IA restore
                    return $default;
                    break;
                case 3302: //Lower Court  Modification
                    return $default;
                    break;
                case 3303: //Old Registration
                    return $default;
                    break;
                case 3304: //IA updation
                    $data['current_page_url'] = base_url('ARDRBM/IA/ia_updation');
                    return view('ARDRBM/ia_updation_view', $data);
                    break;
                case 3305: //Reg No. display Change (for causelist)
                    return $default;
                    break;
                case 3307: //IA or Doc transfer
                    $data['current_page_url'] = base_url('ARDRBM/IA/doc_transfer');
                    return view('ARDRBM/IA_or_doc_transfer_view', $data);
                    break;
                case 3308: //IA Entry Date Correction
                    $data['current_page_url'] = base_url('ARDRBM/IA/doc_transfer');
                    return view('ARDRBM/ia_entry_date_correction_view', $data);
                    break;
                default:
                    return $default;
            }
        }
    }

    public function get_content_ia_transfer_process()
    {
        $diary_no = $_SESSION['filing_details']['diary_no'];
        $is_docdetails = '';
        if (!empty($diary_no)) {
            $is_docdetails = $this->IAModel->get_docdetails($diary_no);
            if (empty($is_docdetails)) {
                $is_docdetails = $this->IAModel->get_docdetails($diary_no, '', '_a');
            }
        }
        $data['dno_data'] = $_SESSION['filing_details'];
        $data['ia_res'] = $is_docdetails;
        //echo "<pre>";print_r($data); die;
        return view('ARDRBM/get_content_ia_transfer_process', $data);
    }
    public function get_information_diary()
    {
        if ($this->request->getMethod() === 'post') {

            $search_type = $this->request->getPost('search_type');

            $diary_number = $this->request->getPost('diary_number');
            $diary_year = $this->request->getPost('diary_year');

            $case_type = $this->request->getPost('case_type');
            $case_number = $this->request->getPost('case_number');
            $case_year = $this->request->getPost('case_year');

            $this->validation->setRule('search_type', 'Select Diary or Case type', 'required');

            if (!empty($search_type) && $search_type != null) {
                if ($search_type == 'D') {
                    $this->validation->setRule('search_type', 'Select Diary or Case type', 'required');
                    $this->validation->setRule('diary_number', 'Diary number', 'required');
                    $this->validation->setRule('diary_year', 'Diary year', 'required');

                    $data = [
                        'search_type' => $search_type,
                        'diary_number' => $diary_number,
                        'diary_year' => $diary_year,
                    ];
                } else {
                    $this->validation->setRule('search_type', 'Select Diary or Case type', 'required');
                    $this->validation->setRule('case_type', 'Case type', 'required');
                    $this->validation->setRule('case_number', 'Case number', 'required');
                    $this->validation->setRule('case_year', 'Case year', 'required');

                    $data = [
                        'search_type' => $search_type,
                        'case_type' => $case_type,
                        'case_number' => $case_number,
                        'case_year' => $case_year,
                    ];
                }
            } else {
                $data = [
                    'search_type' => $search_type
                ];
            }

            if (!$this->validation->run($data)) {
                // handle validation errors
                echo '3@@@';
                //echo $this->validation->getError('search_type').$this->validation->getError('case_type');
                echo $this->validation->listErrors();
                exit();
            }
            $get_main_table = array();
            $search_type = $this->request->getPost('search_type');
            if ($search_type == 'D') {
                $diary_no = $diary_number . $diary_year;
                $get_main_table = $this->DropdownListModel->get_diary_details_by_diary_no($diary_no);
            } elseif ($search_type == 'C') {
                $diary_no = get_diary_case_type($case_type, $case_number, $case_year);
                if (!empty($diary_no)) {
                    $get_main_table = $this->DropdownListModel->get_diary_details_by_diary_no($diary_no);
                } else {
                    $get_main_table = array();
                }
            }

            $diary_no_first = $_SESSION['filing_details']['diary_no'];
            if ($diary_no == $diary_no_first) {
                echo "<center><span class='text-danger'>Both Diary No./Case No. cannot be same</span></center>";
                exit();
            }
            $data['dno_data'] = $get_main_table;
            $data['diary_number_year_ia'] = $diary_no;
            return view('ARDRBM/get_content_ia_transfer_process_diary', $data);
        }
    }
    public function ia_transfer_process()
    {
        $option = $_REQUEST['option'];
        $diary_no = $_SESSION['filing_details']['diary_no'];
        $usercode = session()->get('login')['usercode'];
        if ($option == 2) {
            $remark_array = $_REQUEST['remark'];

            $doc_id = $_REQUEST['doc_id'];
            $dno = $diary_no;
            $transf_to_dno = $_REQUEST['tr_to_diary_no'];
            if ($dno == $transf_to_dno) {
                echo "3@@@Both Diary No./Case No. cannot be same";
                exit();
            }
            $len = sizeof($doc_id);

            $this->db = \Config\Database::connect();
            $this->db->transStart();
            $temp_doc_id = '';
            for ($i = 0; $i < $len; $i++) {
                if ($temp_doc_id) {
                    $temp_doc_id = $temp_doc_id . ',' . $doc_id[$i];
                } else {
                    $temp_doc_id = $doc_id[$i];
                }
                $remarks = $remark_array[$i] . " (Transferred to diary no. " . substr($transf_to_dno, 0, strlen($transf_to_dno) - 4) . '/' . substr($transf_to_dno, -4) . ')';
                $docdetails = $this->IAModel->get_docdetails($diary_no, [$doc_id[$i]]);
                if (empty($docdetails)) {
                    $docdetails = $this->IAModel->get_docdetails($diary_no, [$doc_id[$i]], '_a');
                }
                if (!empty($docdetails)) {
                    $ia_restore_remarks_data = [
                        'diary_no' => $docdetails[0]['diary_no'],
                        'docnum' => $docdetails[0]['docnum'],
                        'docyear' => $docdetails[0]['docyear'],
                        'docd_id' => $docdetails[0]['docd_id'],
                        'restoration_remarks' => $remarks,
                        'ip_address' => getClientIP(),

                        'updated_on' => date("Y-m-d H:i:s"),
                        'create_modify' => date("Y-m-d H:i:s"),
                        'updated_by' => session()->get('login')['usercode'],
                        'updated_by_ip' => getClientIP(),
                    ];
                    $is_sql_lowerct_judges = insert('ia_restore_remarks', $ia_restore_remarks_data);
                }
            }
            $is_data_from_docdetails = 'P';
            $docdetails2 = $this->IAModel->get_docdetails($diary_no, $doc_id);
            if (empty($docdetails2)) {
                $docdetails2 = $this->IAModel->get_docdetails($diary_no, $doc_id, '_a');
                $is_data_from_docdetails = 'D';
            }
            if (!empty($docdetails2)) {
                $data_addon = [
                    'updated_on' => date("Y-m-d H:i:s"),
                    'updated_by' => session()->get('login')['usercode'],
                    'updated_by_ip' => getClientIP(),
                ];
                unset($docdetails2[0]['updated_on']);
                unset($docdetails2[0]['updated_by']);
                unset($docdetails2[0]['ia']);
                $final_array = array_merge($docdetails2[0], $data_addon);

                $query_ia_log = insert('docdetails_history', $final_array);
                if ($query_ia_log) {
                    $upd_docdetails = [
                        'diary_no'     => $transf_to_dno,
                        'updated_on' => date("Y-m-d H:i:s"),
                        'updated_by' => session()->get('login')['usercode'],
                        'updated_by_ip' => getClientIP(),
                    ];

                    if ($is_data_from_docdetails == 'D') {
                        $query_update_res = $this->db->table('docdetails_a');
                    } else {
                        $query_update_res = $this->db->table('docdetails');
                    }
                    $query_update_res->whereIn('docd_id', $doc_id);
                    $query_update_res->where('diary_no', $dno);
                    $query_update_res->update($upd_docdetails);

                    if ($query_update_res) {
                        $response = '1@@@<div class="alert alert-success"><strong>Success!</strong> IA(s) transferred successfully.</div>';
                    } else {
                        $response = '3@@@<div class="alert alert-danger"><strong>Fail!</strong> IA transfer failed.</div>';
                    }
                } else {
                    $response = '3@@@<div class="alert alert-danger"><strong>Fail!</strong> IA transfer failed.</div>';
                }
            }
            $this->db->transComplete();

            echo $response;
            exit();
        }

        // echo "3@@@Diary No. or Case No. doesn't exist .";exit();
    }
    public function get_ia_entry_date_correction_list()
    {
        $diary_no = $_SESSION['filing_details']['diary_no'];
        $data['current_page_url'] = base_url('ARDRBM/IA/ia_entry_date_correction');
        $data['result'] = $this->IAModel->get_ia_entry_date_correction_list($diary_no);
        $data['listing'] = $this->IAModel->get_heardt($diary_no);
        return view('ARDRBM/get_ia_entry_date_correction_list', $data);
    }
    public function get_ia_entry_date_correction_content()
    {
        $diary_no = $_SESSION['filing_details']['diary_no'];
        $docd_id = $_REQUEST['docd_id'];
        $data['result'] = $this->IAModel->get_ia_entry_date_correction_content($docd_id);
        $data['docmaster'] = $this->IAModel->get_docmaster();
        $data['docd_id'] = $docd_id;
        //echo '<pre>';print_r($data);exit();
        return view('ARDRBM/get_ia_entry_date_correction_content', $data);
    }
    public function update_ia_entry_date_correction_content()
    {

        if ($_REQUEST['type'] == 'U') {
            $diary_no = $_SESSION['filing_details']['diary_no'];
            $new_filing_date = $_REQUEST['new_filing_date'];
            $docd_id = $_REQUEST['docd_id'];
            if (empty($diary_no)) {
                "3@@@Diary No. is required";
                exit();
            }
            if (empty($new_filing_date)) {
                "3@@@New filing date is required";
                exit();
            }
            if (empty($docd_id)) {
                "3@@@Doc ID is required";
                exit();
            }

            $is_data_from_docdetails = 'P';
            $docdetails = $this->IAModel->get_docdetails($diary_no, [$docd_id]);
            if (empty($docdetails)) {
                $docdetails = $this->IAModel->get_docdetails($diary_no, [$docd_id], '_a');
                $is_data_from_docdetails = 'D';
            }
            if (!empty($docdetails)) {
                $data_addon = [
                    'updated_on' => date("Y-m-d H:i:s"),
                    'create_modify' => date("Y-m-d H:i:s"),
                    'updated_by' => session()->get('login')['usercode'],
                    'updated_by_ip' => getClientIP(),
                ];
                unset($docdetails[0]['create_modify']);
                unset($docdetails[0]['updated_on']);
                unset($docdetails[0]['updated_by']);
                unset($docdetails[0]['ia']);
                $final_array = array_merge($docdetails[0], $data_addon);

                $query_ia_log = insert('docdetails_history', $final_array);
                if ($query_ia_log) {
                    $new_filing_date = !empty($new_filing_date) ? date('Y-m-d H:i:s', strtotime($new_filing_date)) : '';
                    $upd_docdetails = [
                        'ent_dt'     => $new_filing_date,
                        'lst_mdf' => date("Y-m-d H:i:s"),
                        'lst_user' => session()->get('login')['usercode'],
                        'updated_on' => date("Y-m-d H:i:s"),
                        'updated_by' => session()->get('login')['usercode'],
                        'updated_by_ip' => getClientIP(),
                    ];

                    if ($is_data_from_docdetails == 'D') {
                        $query_update_res = $this->db->table('docdetails_a');
                    } else {
                        $query_update_res = $this->db->table('docdetails');
                    }
                    $query_update_res->where('docd_id', $docd_id);
                    $query_update_res->where('diary_no', $diary_no);
                    $query_update_res->update($upd_docdetails);

                    if ($query_update_res) {
                        $response = '1@@@<div class="alert alert-success">UPDATED SUCCESSFULLY.</div>';
                    } else {
                        $response = '3@@@<div class="alert alert-danger"><strong>Fail!</strong> Update failed.</div>';
                    }
                } else {
                    $response = '3@@@<div class="alert alert-danger"><strong>Fail!</strong> Update failed.</div>';
                }
            } else {
                $response = "3@@@SORRY, RECORD NOT FOUND";
            }
            echo $response;
            exit();
        }
    }
    public function delete_ia_entry_date_correction()
    {

        if ($_REQUEST['type'] == 'D') {
            $diary_no = $_SESSION['filing_details']['diary_no'];
            $docd_id = $_REQUEST['docd_id'];
            if (empty($diary_no)) {
                "3@@@Diary No. is required";
                exit();
            }
            if (empty($docd_id)) {
                "3@@@Doc ID is required";
                exit();
            }

            $is_data_from_docdetails = 'P';
            $docdetails = $this->IAModel->get_docdetails($diary_no, [$docd_id]);
            if (empty($docdetails)) {
                $docdetails = $this->IAModel->get_docdetails($diary_no, [$docd_id], '_a');
                $is_data_from_docdetails = 'D';
            }
            if (!empty($docdetails)) {
                $data_addon = [
                    'updated_on' => date("Y-m-d H:i:s"),
                    'create_modify' => date("Y-m-d H:i:s"),
                    'updated_by' => session()->get('login')['usercode'],
                    'updated_by_ip' => getClientIP(),
                ];
                unset($docdetails[0]['create_modify']);
                unset($docdetails[0]['updated_on']);
                unset($docdetails[0]['updated_by']);
                unset($docdetails[0]['ia']);
                $final_array = array_merge($docdetails[0], $data_addon);

                $query_ia_log = insert('docdetails_history', $final_array);
                if ($query_ia_log) {
                    $new_filing_date = !empty($new_filing_date) ? date('Y-m-d H:i:s', strtotime($new_filing_date)) : '';
                    $upd_docdetails = [
                        'display'     => 'N',
                        'remark' => date("Y-m-d H:i:s"),
                        'updated_on' => date("Y-m-d H:i:s"),
                        'updated_by' => session()->get('login')['usercode'],
                        'updated_by_ip' => getClientIP(),
                    ];

                    if ($is_data_from_docdetails == 'D') {
                        $query_update_res = $this->db->table('docdetails_a');
                    } else {
                        $query_update_res = $this->db->table('docdetails');
                    }
                    $query_update_res->where('docd_id', $docd_id);
                    $query_update_res->where('diary_no', $diary_no);
                    $query_update_res->update($upd_docdetails);

                    if ($query_update_res) {
                        $response = '1@@@DELETED SUCCESSFULLY.';
                    } else {
                        $response = '3@@@Delete failed.';
                    }
                } else {
                    $response = '3@@@Delete failed.';
                }
            } else {
                $response = "3@@@SORRY, RECORD NOT FOUND";
            }
            echo $response;
            exit();
        }
    }
    /*start IA UP-DATION*/
    function get_adv_name_aor()
    {
        $aorcode = $_REQUEST['aorcode'];
        $adv = $this->IAModel->get_adv_name_aor($aorcode);
        if (!empty($adv)) {
            echo $adv['name'] . '~' . $adv['mobile'] . '~' . $adv['email'] . '~' . $adv['bar_id'] . '~' . $adv['enroll_year'];
        } else {
            echo '0';
        }
        exit();
    }
    public function getDoc_type()
    {
        $doctype = 0;
        $diary_no = $_SESSION['filing_details']['diary_no'];
        $case_grp = !empty($_SESSION['filing_details']['case_grp']) ? trim($_SESSION['filing_details']['case_grp']) : '';

        if ($case_grp == 'C' || $case_grp == 'c') {
            $doctype = 1;
        } else if ($case_grp == 'R' || $case_grp == 'r') {
            $doctype = 2;
        }
        $q = strtolower($_GET["term"]);

        $result = $this->IAModel->getDoc_type($doctype, $q);
        echo json_encode($result);

        exit();
    }
    public function get_ia_updation_list()
    {
        $session_user = session()->get('login')['usercode'];
        $diary_no = $_SESSION['filing_details']['diary_no'];
        $result = $this->IAModel->get_ia_updation_list($diary_no);
        $is_allowed = 0;
        $section_officer = '';
        $IB_officer = 0;
        if (empty($result)) {
            $result = $this->IAModel->get_ia_updation_list($diary_no, '_a');
        }
        if (!empty($result)) {
            $users = is_data_from_table('master.users', ['display' => 'Y', 'section' => 19, 'usercode' => $session_user]);
            if (!empty($users)) {
                $is_allowed = 1;
            } else {
                $is_main = is_data_from_table('main', ['diary_no' => $diary_no, 'usercode' => $session_user]);
                if (empty($is_main)) {
                    $is_main = is_data_from_table('main_a', ['diary_no' => $diary_no, 'usercode' => $session_user]);
                }
                if (!empty($is_main)) {
                    $is_allowed = 1;
                }

                $is_section_officer = $this->IAModel->get_section_officer_count($diary_no, $session_user);
                if (!empty($is_section_officer)) {
                    $section_officer = 1;
                } else {
                    $check_ibuser = is_data_from_table('master.users', ['section' => 19, 'usercode' => $session_user, 'usertype' => 4, 'usertype' => 6]);
                    if (!empty($check_ibuser)) {
                        $IB_officer = 1;
                    }
                }
            }
        }

        $data['diary_no'] = $diary_no;
        $data['is_allowed'] = $is_allowed;
        $data['section_officer'] = $section_officer;
        $data['IB_officer'] = $IB_officer;
        $data['session_user'] = $session_user;

        $data['result'] = $result;
        $data['listing'] = $this->IAModel->get_heardt($diary_no);
        $data['casetype'] = $this->IAModel->get_diary_with_short_description($diary_no);
        //echo '<pre>';print_r($casetype); exit();
        return view('ARDRBM/get_ia_updation_list', $data);
    }
    public function get_ia_updation_content()
    {
        $from = '';
        $diary_no = $_SESSION['filing_details']['diary_no'];
        $idfull = $_REQUEST['idfull'];
        if (!empty($idfull)) {
            $fullid = explode('~', $_REQUEST['idfull']);
            if (!empty($fullid)) {
                $fil_no = $fullid[0];
                $doccode = $fullid[1];
                $doccode1 = $fullid[2];
                $docnum = $fullid[3];
                $docyear = $fullid[4];
                $advid = $fullid[5];
                $src = $fullid[6];
                $docd_id = $fullid[7];
                $is_efiled = $fullid[8];

                $result = $this->IAModel->get_ia_updation_content($diary_no, $doccode, $doccode1, $docnum, $docyear);
                if (empty($result)) {
                    $result = $this->IAModel->get_ia_updation_content($diary_no, $doccode, $doccode1, $docnum, $docyear, '_a');
                }
                if (!empty($result)) {
                    $ent_dt = !empty($result['ent_dt']) ? date('Y-m-d h:i', strtotime($result['ent_dt'])) : '';
                    $get_heardt = $this->IAModel->get_heardt_by_ent_dt($diary_no, $ent_dt);
                    if (!empty($get_heardt)) {
                        $from = 'H';
                    } else {
                        $get_last_heardt = $this->IAModel->get_last_heardt_by_ent_dt($diary_no, $ent_dt);
                        if (!empty($get_last_heardt)) {
                            $from = 'L';
                        }
                    }
                    $data['idfull'] = $idfull;
                    $data['from'] = $from;
                    $data['result'] = $result;
                    $data['docmaster'] = $this->IAModel->get_docmaster();
                    $data['docd_id'] = $docd_id;
                    //echo '<pre>';print_r($data);exit();
                    return view('ARDRBM/get_ia_updation_content', $data);
                } else {
                    echo "SORRY, RECORD NOT FOUND!!!";
                    exit();
                }
            } else {
                echo "SORRY, RECORD NOT FOUND!!";
                exit();
            }
        } else {
            echo "SORRY, RECORD NOT FOUND!";
            exit();
        }
    }
    public function ia_update()
    {
        if ($_REQUEST['type'] == 'U') {
            $diary_no = $_SESSION['filing_details']['diary_no'];
            $idfull = $_REQUEST['idfull'];
            if (!empty($idfull)) {
                $fullid = explode('~', $idfull);
                if (!empty($fullid)) {
                    $fil_no = $fullid[0];
                    $doccode = $fullid[1];
                    $doccode1 = $fullid[2];
                    $docnum = $fullid[3];
                    $docyear = $fullid[4];
                    $advid = $fullid[5];
                    $src = $fullid[6];
                    $docd_id = $fullid[7];
                    $is_efiled = $fullid[8];

                    if ($_REQUEST['fee'] == '') {
                        $_REQUEST['fee'] = 0;
                    }

                    $efil = 0;
                    $efil_no = 0;
                    $efil_yr = '';
                    if ($_REQUEST['if_efil'] == 0 || $_REQUEST['if_efil'] == '')
                        $efil = '';
                    else {
                        $efil = 'Y';
                    }


                    $is_data_from_docdetails = 'P';
                    $docdetails = $this->IAModel->get_ia_docdetails($diary_no, $doccode, $doccode1, $docnum, $docyear);
                    if (empty($docdetails)) {
                        $is_data_from_docdetails = 'D';
                        $docdetails = $this->IAModel->get_ia_docdetails($diary_no, $doccode, $doccode1, $docnum, $docyear, '_a');
                    }
                    if (!empty($docdetails)) {
                        $this->db = \Config\Database::connect();
                        $this->db->transStart();
                        $data_addon = [
                            'updated_on' => date("Y-m-d H:i:s"),
                            'create_modify' => date("Y-m-d H:i:s"),
                            'updated_by' => session()->get('login')['usercode'],
                            'updated_by_ip' => getClientIP(),
                        ];
                        unset($docdetails['create_modify']);
                        unset($docdetails['updated_on']);
                        unset($docdetails['updated_by']);
                        $final_array = array_merge($docdetails, $data_addon);

                        $query_ia_log = insert('docdetails_history', $final_array);
                        if ($query_ia_log) {
                            $noc = $_REQUEST['noc'];
                            $rem = $_REQUEST['rem'];
                            $doccode_post = $_REQUEST['doccode'];
                            $doccode1_post = $_REQUEST['doccode1'];
                            $other1 = $_REQUEST['other1'];
                            $docno = $_REQUEST['docno'];
                            $docyr = $_REQUEST['docyr'];
                            $aor = $_REQUEST['aor'];
                            $aor_name = $_REQUEST['aor_name'];
                            $fee = $_REQUEST['fee'];

                            $upd_docdetails = [
                                'doccode' => $doccode_post,
                                'doccode1' => $doccode1_post,
                                'other1' => $other1,
                                'remark' => $rem,
                                'advocate_id' => $aor,
                                'docfee' => $fee,
                                'no_of_copy' => $noc,
                                'filedby' => $aor_name,
                                'lst_mdf' => date("Y-m-d H:i:s"),
                                'lst_user' => session()->get('login')['usercode'],
                                'is_efiled' => $efil,
                                'updated_on' => date("Y-m-d H:i:s"),
                                'updated_by' => session()->get('login')['usercode'],
                                'updated_by_ip' => getClientIP(),
                            ];

                            if ($is_data_from_docdetails == 'D') {
                                $query_update_res = $this->db->table('docdetails_a');
                            } else {
                                $query_update_res = $this->db->table('docdetails');
                            }
                            $query_update_res->where('diary_no', $diary_no);
                            $query_update_res->where('docd_id', $docd_id);
                            $query_update_res->where('doccode', $doccode);
                            $query_update_res->where('doccode1', $doccode1);
                            $query_update_res->where('docnum', $docno);
                            $query_update_res->where('docyear', $docyr);
                            $query_update_res->where('display', 'Y');
                            $query_update_res->update($upd_docdetails);

                            if ($query_update_res) {
                                echo 'UPDATED SUCCESSFULLY.';
                            } else {
                                echo 'Update failed.';
                            }
                        } else {
                            echo 'Update failed.';
                        }

                        $this->db->transComplete();
                    } else {
                        echo "SORRY, RECORD NOT FOUND!!!!";
                        exit();
                    }
                } else {
                    echo "SORRY, RECORD NOT FOUND!!!";
                    exit();
                }
            } else {
                echo "SORRY, RECORD NOT FOUND!!";
                exit();
            }
        } else {
            echo "SORRY, RECORD NOT FOUND!";
            exit();
        }
        exit();
    }

    public function delete_ia_updation()
    {
        if ($_REQUEST['type'] == 'D') {
            $diary_no = $_SESSION['filing_details']['diary_no'];
            $idfull = $_REQUEST['docd_id'];
            if (!empty($idfull)) {
                $fullid = explode('~', $idfull);
                if (!empty($fullid)) {
                    $dno = !empty($fullid[0]) ? $fullid[0] : '';
                    $doccode = !empty($fullid[1]) ? $fullid[1] : 0;
                    $doccode1 = !empty($fullid[2]) ? $fullid[2] : 0;
                    $docnum = !empty($fullid[3]) ? $fullid[3] : 0;
                    $docyear = !empty($fullid[4]) ? $fullid[4] : 0;
                    $advid = !empty($fullid[5]) ? $fullid[5] : 0;
                    $src = !empty($fullid[6]) ? $fullid[6] : 0;
                    $is_efiled = !empty($fullid[7]) ? $fullid[7] : 0;

                    /*$doccode = $fullid[1];
                    $doccode1 = $fullid[2];
                    $docnum = $fullid[3];
                    $docyear = $fullid[4];
                    $advid = $fullid[5];
                    $src = $fullid[6];
                    $is_efiled= $fullid[7];*/
                    //echo '<pre>';print_r($fullid);exit();



                    $is_data_from_docdetails = 'P';
                    $document = $this->IAModel->is_ia_updation_content($diary_no, $doccode, $doccode1, $docnum, $docyear);
                    if (empty($document)) {
                        $is_data_from_docdetails = 'D';
                        $document = $this->IAModel->is_ia_updation_content($diary_no, $doccode, $doccode1, $docnum, $docyear, '_a');
                    }
                    if (!empty($document)) {
                        $this->db = \Config\Database::connect();
                        $this->db->transStart();
                        /*$data_addon = [
                            'updated_on' => date("Y-m-d H:i:s"),
                            'create_modify' => date("Y-m-d H:i:s"),
                            'updated_by' => session()->get('login')['usercode'],
                            'updated_by_ip' => getClientIP(),
                        ];
                        unset($docdetails['create_modify']);unset($docdetails['updated_on']);unset($docdetails['updated_by']);
                        $final_array = array_merge($docdetails,$data_addon);

                        $query_ia_log = insert('docdetails_history', $final_array);*/
                        //if ($query_ia_log) {

                        $remark = !empty($document['remark']) ? $document['remark'] : 'WRONGLY MADE-' . session()->get('login')['usercode'];

                        $upd_docdetails = [
                            'display' => 'N',
                            'remark' => $remark,
                            'lst_mdf' => date("Y-m-d H:i:s"),
                            'lst_user' => session()->get('login')['usercode'],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => session()->get('login')['usercode'],
                            'updated_by_ip' => getClientIP(),
                        ];

                        if ($is_data_from_docdetails == 'D') {
                            $query_update_res = $this->db->table('docdetails_a');
                        } else {
                            $query_update_res = $this->db->table('docdetails');
                        }
                        $query_update_res->where('diary_no', $diary_no);
                        $query_update_res->where('doccode', $doccode);
                        $query_update_res->where('doccode1', $doccode1);
                        $query_update_res->where('docnum', $docnum);
                        $query_update_res->where('docyear', $docyear);
                        $query_update_res->where('display', 'Y');
                        $query_update_res->update($upd_docdetails);

                        if ($query_update_res) {
                            echo '1@@@UPDATED SUCCESSFULLY.';

                            if ($doccode == 8) {
                                $is_data_from_brdrem = 'P';
                                $get_brdrem = $this->IAModel->get_brdrem($diary_no);
                                if (empty($get_brdrem)) {
                                    $is_data_from_brdrem = 'D';
                                    $get_brdrem = $this->IAModel->get_brdrem($diary_no, '_a');
                                }
                                if (!empty($get_brdrem)) {
                                    $row2 = $get_brdrem;
                                    $search_string = 'IA No.' . $document['docnum'] . '/' . $document['docyear'] . '-' . $document['docdesc'];

                                    if (strpos($row2['remark'], 'and ' . $search_string) !== false) {
                                        $search_string = 'and IA No.' . $document['docnum'] . '/' . $document['docyear'] . '-' . $document['docdesc'];
                                    }
                                    if (strpos($row2['remark'], $search_string . ' and') !== false) {
                                        $search_string = 'IA No.' . $document['docnum'] . '/' . $document['docyear'] . '-' . $document['docdesc'] . ' and';
                                    }
                                    $replaced_string = str_ireplace($search_string, '', $row2['remark']);

                                    $upd_brdrem = [
                                        'remark' => $replaced_string,
                                        'updated_on' => date("Y-m-d H:i:s"),
                                        'updated_by' => session()->get('login')['usercode'],
                                        'updated_by_ip' => getClientIP(),
                                    ];

                                    if ($is_data_from_brdrem == 'D') {
                                        $query_update_brdrem = $this->db->table('brdrem_a');
                                    } else {
                                        $query_update_brdrem = $this->db->table('brdrem');
                                    }
                                    $query_update_brdrem->where('diary_no', $diary_no);
                                    $query_update_brdrem->update($upd_brdrem);
                                }
                            }
                        } else {
                            echo '3@@@Update failed.';
                        }


                        $this->db->transComplete();
                    } else {
                        echo "3@@@SORRY, RECORD NOT FOUND!!!!";
                        exit();
                    }
                } else {
                    echo "3@@@SORRY, RECORD NOT FOUND!!!";
                    exit();
                }
            } else {
                echo "3@@@SORRY, RECORD NOT FOUND!!";
                exit();
            }
        } else {
            echo "3@@@SORRY, RECORD NOT FOUND!";
            exit();
        }
        exit();
    }
    /*end IA UP-DATION*/
}
