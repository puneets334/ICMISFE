<?php

namespace App\Controllers\PIL;

use App\Controllers\BaseController;
use CodeIgniter\Controller;
use CodeIgniter\Model;
use App\Models\Entities\EcPilGroupFile;
use App\Models\Entities\RefPilCategory;
use App\Models\Entities\EcPil;
use App\Models\Entities\EcPilLog;
use App\Models\Entities\RefState;
use App\Libraries\Fpdf;
use App\Libraries\Common;
use App\Models\PIL\PilModel;
//use Mpdf;
//use \setasign\Fpdi\PdfParser\StreamReader;
ini_set('memory_limit', '51200M');
class PilController extends BaseController
{
    public $ecPilGroupFile;
    public $masterRefPilCategory;
    public $ecPil;
    public $ecPilLog;
    public $pdf;
    public $common;
    public $commonHelper;
    public $masterRefState;
    public $PilModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        date_default_timezone_set('Asia/Calcutta');
        $this->ecPilGroupFile =  new EcPilGroupFile();
        $this->ecPil =  new EcPil();
        $this->masterRefPilCategory =  new RefPilCategory();
        $this->ecPilLog =  new EcPilLog();
        $this->masterRefState = new RefState();
        $this->pdf = new Fpdf();
        $this->common = new Common();

        $this->PilModel = new PilModel();
        ini_set('memory_limit', '51200M');
        define('FPDF_FONTPATH', include(FCPATH . 'assets/font/timesb.php'));
    }

    public function index($msg = '')
    {
        $data['msg'] = $msg;
        $data['app_name'] = 'PIL';
        $data['pilData'] = $this->PilModel->getPilData();
        //        echo "<pre>";
        //        print_r($data);
        //        die;
        return view('PIL/showPilData', $data);
    }
    public function addToPilGroupShow($msg = "", $ecPilGroupId = 0, $searchedYear = 0)
    {
        //        echo $ecPilGroupId;
        //        die;
        $usercode = $_SESSION['login']['usercode'];
        $diaryNo = '';
        $diaryYear = '';
        $ecPilGroupId = '';
        if ($searchedYear == 0) {
            $searchedYear = date("Y");
        }
        $data['msg'] = $msg;
        $resultArray = $this->PilModel->getPilGroup();
        if (!empty($resultArray)) {
            $data['pilGroup'] = $resultArray;
        } else {
            $data['pilGroup'] = '';
        }
        $data['ecPilGroupId'] = $ecPilGroupId;
        $data['searchedYear'] = $searchedYear;
        if (!empty($_POST)) {
            if (!empty($_POST['ecPilGroupId'])) {
                $ecPilGroupId = $_POST['ecPilGroupId'];
            }
            if (!empty($_POST['diaryNo'])) {
                $diaryNo = $_POST['diaryNo'];
            }
            $diaryYear = $_POST['diaryYear'];
            if ($diaryNo != '' && $diaryYear != '') {
                $ecPilId = $this->PilModel->getPilId($diaryNo, $diaryYear);
                //                echo "<pre>";
                //                print_r($ecPilId[0]);
                //                die;
                if ($ecPilId[0] != null) {
                    //                    echo "FFFF";
                    //                    die;
                    $rowsaffected = $this->PilModel->addInPilGroup($ecPilGroupId, $ecPilId, $usercode);
                    //                    echo "<pre>";
                    //                    print_r($rowsaffected);
                    //                    die;

                    if ($rowsaffected > 0) {
                        $data['msg'] = "Added Successfully.";
                        $data['casesInPilGroup'] = $this->PilModel->getCasesInPilGroup($ecPilGroupId);
                        $data['ecPilGroupId'] = $ecPilGroupId;
                        //                        echo "<pre>";
                        //                        print_r($data);
                        //                        die;
                        //                        $this->addToPilGroupShow("Added Successfully.", $ecPilGroupId, $diaryYear);
                    }
                } else {
                    //                    echo "EEE";
                    //                    die;
                    $data['msg'] = "No Record found.";
                    $data['casesInPilGroup'] = $this->PilModel->getCasesInPilGroup($ecPilGroupId);
                    $data['ecPilGroupId'] = $ecPilGroupId;
                    //                    $this->addToPilGroupShow("No Record found.", $ecPilGroupId, $diaryYear);
                }
            } else {
                $data['casesInPilGroup'] = $this->PilModel->getCasesInPilGroup($ecPilGroupId);
                $data['ecPilGroupId'] = $ecPilGroupId;
            }
            //            echo "POOOO";
            //            echo "<pre>";
            //            print_r($data);
            //            die;
            return view('PIL/addToPilGroup', $data);
        }
        //            echo "<pre>";
        //            print_r($data);
        return view('PIL/addToPilGroup', $data);
    }


    public function removeCaseFromPilGroup()
    {
        //        var_dump($_POST);
        //        die;
        $ecPilId = $_POST['id'];
        $ecPilGroupId = $_POST['pilgpid'];
        $userCode = $_SESSION['login']['usercode'];
        $client_ip = getClientIP();
        //      ECPIL TABLE SE LOG M S=DAAL RAHE HI VERNACULAR LANGUAGE DATATYPE
        $insertInLog = $this->transferPilDataToLogtable($ecPilId);
        if (!empty($insertInLog)) {
            $data = array(
                'group_file_number' => $ecPilGroupId,
                'adm_updated_by' => $userCode,
                'updated_on' => date('Y-m-d H:i:s'),
                'updated_by' => $userCode,
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by_ip' => $client_ip
            );
        }
        $result = $this->ecPil->where('id', $ecPilId)->where('group_file_number', $ecPilGroupId)->update($data);
        //        var_dump($result);
        //        die;
        if ($result > 0) {
            //            $this->addToPilGroupShow("PIL removed from this PIL Group.",$ecPilGroupId);
            echo "1";
        } else {
            echo "0";
            //            echo "There is some problem while removing PIL from this PIL Group";
        }
    }


    /*PIL ENTRY >>> PIL GROUP*/


    public function showPilGroup()
    {
        $data['pilGroup'] = $this->PilModel->getPilGroup();
        return view('PIL/showPilGroupData', $data);
    }

    public function editPilGroupData($ecPilGroupId = null)
    {
        //        echo "ddd".$ecPilGroupId;
        //        die;
        $data['pil_group_id'] = $ecPilGroupId;
        if ($ecPilGroupId != null and $ecPilGroupId != 0) {
            //            echo "idddd".$ecPilGroupId;
            //            die;
            $data['lodgeActionReason'] = $this->PilModel->getActionReason('a');
            $data['writtenActionReason'] = $this->PilModel->getActionReason('b');
            $data['returnActionReason'] = $this->PilModel->getActionReason('c');
            $data['sentActionReason'] = $this->PilModel->getActionReason('d');
            $data['transferActionReason'] = $this->PilModel->getActionReason('e');
            $data['pilGroupDetail'] = $this->PilModel->getPilGroupDataById($ecPilGroupId);
            $data['casesInPilGroup'] = $this->PilModel->getCasesInPilGroup($ecPilGroupId);
        }
        //        echo "<pre>";
        //        print_r($data['casesInPilGroup']);
        //        die;
        return view('PIL/addEditPilGroupData', $data);
    }

    public function savePilGroupData()
    {
        //        echo "hello";
        //        var_dump($_POST);
        //        die;
        $pilGroupId = $_POST['pid'];
        $groupFileNumber = $_POST['gpid'];
        $usercode = $_POST['ucode'];
        $result = $this->PilModel->savePilGroupData($pilGroupId, $this->addSlashinString($groupFileNumber), $usercode);
        echo $result;
    }

    private function addSlashinString($str)
    {
        return addslashes($str);
    }

    public function groupUpdate()
    {
        //        echo "TEWRTEWR";die;
        if (!empty($_POST)) {
            //            echo "<pre>";
            //            print_r($_POST);die;
            $pilGroupId = $_POST['pilGroupId'];
            $groupFileNumber = $_POST['groupFileNumber'];
            $actionTaken = $_POST['actionTaken'];
            $lodgementDate = $_POST['lodgementDate'];
            $lodgedActionReason = $_POST['lodgedActionReason'];
            $writtenOn = $_POST['writtenOn'];
            $writtenActionReason = $_POST['writtenActionReason'];
            $writtenTo = $_POST['writtenTo'];
            $writtenFor = $_POST['writtenFor'];
            $returnDate = $_POST['returnDate'];
            $returnActionReason = $_POST['returnActionReason'];
            $returnRemark = $_POST['returnRemark'];
            $sentTo = $_POST['sentTo'];
            $sentActionReason = $_POST['sentActionReason'];
            $sentOn = $_POST['sentOn'];
            $transferredTo = $_POST['transferredTo'];
            $transferActionReason = $_POST['transferActionReason'];
            $transferredOn = $_POST['transferredOn'];
            $convertedDiaryNumber = $_POST['convertedDiaryNumber'];
            $convertedDiaryYear = $_POST['convertedDiaryYear'];
            $otherRemedyRemark = $_POST['otherRemedyRemark'];
            $reportDate = $_POST['reportDate'];
            $destroyOrKeepIn = $_POST['destroyOrKeepIn'];
            $destroyOrKeepInDate = $_POST['destroyOrKeepInDate'];
            $destroyOrKeepInRemark = $_POST['destroyOrKeepInRemark'];
            $pils = $_POST['pils'];

            $result = 0;
            $ecPils = implode(',', $pils);
            $updateQuery = "";

            if (!empty($actionTaken)) {
                $updateQuery = $updateQuery . "action_taken='" . $actionTaken . "',";
            } else {
                $updateQuery = $updateQuery . "action_taken=null,";
            }
            if ($actionTaken == 'L') {
                if (!empty($lodgementDate)) {
                    $updateQuery = $updateQuery . "lodgment_date='" . $this->common->date_formatter($lodgementDate, 'Y-m-d') . "',";
                }
                if (!empty($lodgedActionReason) && $lodgedActionReason != 0) {
                    $updateQuery = $updateQuery . "ref_action_taken_id=" . $lodgedActionReason . ",";
                }
            } else if ($actionTaken == 'W') {
                if (!empty($writtenOn)) {
                    $updateQuery = $updateQuery . "written_on='" . $this->common->date_formatter($writtenOn, 'Y-m-d') . "',";
                }
                if (!empty($writtenActionReason) && $writtenActionReason != 0) {
                    $updateQuery = $updateQuery . "ref_action_taken_id=" . $writtenActionReason . ",";
                }
                if (!empty($writtenTo)) {
                    $updateQuery = $updateQuery . "written_to='" . $this->addSlashinString($writtenTo) . "',";
                }
                if (!empty($writtenFor)) {
                    $updateQuery = $updateQuery . "written_for='" . $this->addSlashinString($writtenFor) . "',";
                }
            } else if ($actionTaken == 'R') {
                if (!empty($returnDate)) {
                    $updateQuery = $updateQuery . "return_date='" . $this->common->date_formatter($returnDate, 'Y-m-d') . "',";
                }
                if (!empty($returnActionReason) && $returnActionReason != 0) {
                    $updateQuery = $updateQuery . "ref_action_taken_id=" . $returnActionReason . ",";
                }
                if (!empty($returnRemark)) {
                    $updateQuery = $updateQuery . "returned_to_sender_remarks='" . $this->addSlashinString($returnRemark) . "',";
                }
            } else if ($actionTaken == 'S') {
                if (!empty($sentTo)) {
                    $updateQuery = $updateQuery . "sent_to='" . $this->addSlashinString($sentTo) . "',";
                }
                if (!empty($sentActionReason) && $sentActionReason != 0) {
                    $updateQuery = $updateQuery . "ref_action_taken_id=" . $sentActionReason . ",";
                }
                if (!empty($sentOn)) {
                    $updateQuery = $updateQuery . "sent_on='" . $this->common->date_formatter($sentOn, 'Y-m-d') . "',";
                }
            } else if ($actionTaken == 'T') {
                if (!empty($transferredTo)) {
                    $updateQuery = $updateQuery . "transfered_to='" . $this->addSlashinString($transferredTo) . "',";
                }
                if (!empty($transferActionReason) && $transferActionReason != 0) {
                    $updateQuery = $updateQuery . "ref_action_taken_id=" . $this->addSlashinString($transferActionReason) . ",";
                }
                if (!empty($transferredOn)) {
                    $updateQuery = $updateQuery . "transfered_on='" . $this->common->date_formatter($transferredOn, 'Y-m-d') . "',";
                }
            } else if ($actionTaken == 'I') {
                if (!empty($convertedDiaryNumber)) {
                    $updateQuery = $updateQuery . "ec_case_id=" . $convertedDiaryNumber . $convertedDiaryYear . ",";
                }
            } else if ($actionTaken == 'O') {
                if (!empty($otherRemedyRemark)) {
                    $updateQuery = $updateQuery . "other_text='" . $this->addSlashinString($otherRemedyRemark) . "',";
                }
            }
            if (isset($reportReceived)) {
                $updateQuery = $updateQuery . "report_received='" . $reportReceived . "',";
            }
            if (!empty($reportDate)) {
                $updateQuery = $updateQuery . "report_received_date='" . $this->common->date_formatter($reportDate, 'Y-m-d') . "',";
            }
            if (isset($destroyOrKeepIn)) {
                if (!empty($destroyOrKeepInDate) && $destroyOrKeepIn == 'Y') {
                    $updateQuery = $updateQuery . "destroy_on='" . $this->common->date_formatter($destroyOrKeepInDate, 'Y-m-d') . "',";
                    $updateQuery = $updateQuery . "is_deleted='t',";
                }
                if (!empty($destroyOrKeepInDate) && $destroyOrKeepIn == 'N') {
                    $updateQuery = $updateQuery . "in_record_on='" . $this->common->date_formatter($destroyOrKeepInDate, 'Y-m-d') . "',";
                }
            }
            if (!empty($destroyOrKeepInRemark)) {
                $updateQuery = $updateQuery . "remarks='" . $this->addSlashinString($destroyOrKeepInRemark) . "',";
            }
            $usercode = $_SESSION['login']['usercode'];
            $updateQuery = $updateQuery . "updated_on=NOW(),";
            $updateQuery = $updateQuery . "adm_updated_by=" . $usercode . ",";
            $updateQuery = rtrim($updateQuery, ',');

            //            echo $updateQuer y;die;

            $query = "update ec_pil set " . $updateQuery . " where group_file_number=$pilGroupId and is_deleted='f' and id in ($ecPils)";

            $this->PilModel->transferPilDataToLogtableUsingGroup($pilGroupId, $ecPils);
            $result = $this->PilModel->performGroupUpdate($query);
            //            TO BE DELETED LATER HARDCODED VALUE
            $result = 1;
            if ($result) {
                //                print_r($pils);die;
                foreach ($pils as $pilIdForSMS) {
                    $msg = $this->getSMSText($pilIdForSMS);
                    //                    echo "<pre>";print_r($msg);die;
                    $msgs = explode('#', $msg);
                    //                    echo "<pre>";print_r($msgs);die;
                    if ($actionTaken != '' && $actionTaken != '0' && sizeof($msgs) > 0) {
                        send_sms($msgs[1], $msgs[0], 'ec_pil', $msgs[2]);
                    }
                }
            }
            echo $result;
            exit();
        }
    }

    private function getSMSText($ecPilId)
    {
        $result = $this->PilModel->getActionTakenInformation($ecPilId);
        //        echo "<pre>";
        //        print_r($result);die;
        $msg = "";
        $diaryNumber = "";
        $diaryNumber = $result[0]['diary_number'] . '/' . $result[0]['diary_year'];
        $pilSubActionCode = $result[0]['pil_sub_action_code'];
        $mobileNo = $result[0]['mobile'];
        //        ALL TEMPLATE ID VALUE IS USED HERE NOT CONSTANT NAMES PLEASE REFER OLD CODE FILE PilController/groupUpdate AND CONSTANTS DEFINITION IN includes/sms_template
        //        $templateId='SCISMS_GENERIC_TEMPLATE';
        $templateId = '1107161243622980738';
        //            TO BE DELETED LATER HARDCODED VALUE  395,396 above template id text ask kal
        //        $result[0]['action_taken']='R';
        //       echo  $pilSubActionCode.">>";die;
        //        echo $mobileNo.">>";

        if ($result[0]['action_taken'] == 'L') {
            $lodgementDate = $result[0]['lodgment_date'];
            if ($lodgementDate != null) {
                $lodgementDate = date('d-m-Y', strtotime($lodgementDate));
            }

            switch ($pilSubActionCode) {
                case 'A1': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", has been lodged/filed  on " . $lodgementDate . " as  contents of complaint are not covered under PIL guidelines.";
                        //                    $templateId='SCISMS_GRIEVEANCE_NOT_COVERED_PIL';
                        $templateId = '1107161243033590430';
                        break;
                    }
                case 'A2': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", has been lodged/filed  on " . $lodgementDate . " being not addressed to Supreme Court of India.";
                        //                    $templateId='SCISMS_GRIEVANCE_IMPROPER_ADDRESSED';
                        $templateId = '1107161243038586331';
                        break;
                    }
                case 'A3': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", has been lodged/filed  on " . $lodgementDate . " being unsigned.";
                        //                    $templateId='SCISMS_GRIEVANCE_UNSIGNED';
                        $templateId = '1107161243043518094';
                        break;
                    }
                case 'A4': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", has been lodged/filed  on " . $lodgementDate . " being anonymous.";
                        //                    $templateId='SCISMS_GRIEVANCE_ANONYMOUS';
                        $templateId = '1107161243048102363';
                        break;
                    }
                case 'A5': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", has been lodged/filed  on " . $lodgementDate . " since address is incomplete / pseudonymous.";
                        //                    $templateId='SCISMS_GRIEVANCE_INCOMPLETE_ADDRESS';
                        $templateId = '1107161243054908462';
                        break;
                    }
                case 'A6': {
                        $msg = "Your Grievance/Communication registered against Inward No. " . $diaryNumber . ", has been lodged/filed  on " . $lodgementDate . " since email is not digitally signed.";
                        //                    $templateId='SCISMS_GRIEVANCE_EMAIL_UNSIGNED';
                        $templateId = '1107161243060817022';
                        break;
                    }
                case 'A7': {
                        $msg = "Your Grievance/Communication registered against Inward No. " . $diaryNumber . ", has been lodged/filed  on " . $lodgementDate . " being incomprehensible.";
                        //                    $templateId='SCISMS_GRIEVANCE_INCOMPREHENSIBLE';
                        $templateId = '1107161243065540526';
                        break;
                    }
                case 'A8': {
                        $msg = "Your Grievance/Communication registered against Inward No. " . $diaryNumber . ", has been lodged/filed  on " . $lodgementDate . " Repititive in nature.No Action Required.";
                        //                    $templateId='SCISMS_GRIEVANCE_REPETITIVE';
                        $templateId = '1107161243074421372';
                        break;
                    }
            }
        } else if ($result[0]['action_taken'] == 'W') {
            switch ($pilSubActionCode) {
                case 'B1': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", you have been asked to approach concerned Court/Authority in accordance with law.";
                        //                    $templateId=SCISMS_GRIEVANCE_APPROACH_COURT;
                        $templateId = '1107161243082205857';
                        break;
                    }
                case 'B2': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", you have been asked to  approach Supreme Court Legal Services Committee for legal aid.";
                        //                    $templateId=SCISMS_GRIEVANCE_APPROACH_SCLSC;
                        $templateId = '1107161243088367408';
                        break;
                    }
                case 'B3': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", you have been asked to  approach Supreme Court Legal Services Committee for legal aid.";
                        //                    $templateId=SCISMS_GRIEVANCE_APPROACH_SCLSC;
                        $templateId = '1107161243088367408';
                        break;
                    }
                case 'B4': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", you have been informed that your letter petition stands forwarded to Supreme Court Legal Services Committee for necessary action.";
                        //                    $templateId=SCISMS_GRIEVANCE_LETTER_FORWARDED_SCLSC;
                        $templateId = '1107161243094245809';
                        break;
                    }
                case 'B5': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", you have been asked to file  requisite transfer petition in accordance with law.";
                        //                    $templateId=SCISMS_GRIEVANCE_TRANSFER_PETITION;
                        $templateId = '1107161243101406355';
                        break;
                    }
                case 'B6': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", you have been informed that earlier letter petition with annexures has been returned as requested.";
                        //                    $templateId=SCISMS_GRIEVANCE_TP_RETURN_REQUEST;
                        $templateId = '1107161243108554880';
                        break;
                    }
                case 'B7': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", you have been asked to take legal Recourse in accordance with Law.";
                        //                    $templateId=SCISMS_GRIEVANCE_LEGAL_RECOURSE;
                        $templateId = '1107161243115348334';
                        break;
                    }
                case 'B8': {
                        $msg = "Your Grievance/Communication registered against Inward No. " . $diaryNumber . ", you have been infomed that  fate of earlier letter-petition has been conveyed to the petitioner.";
                        //                    $templateId=SCISMS_GRIEVANCE_FATE_CONVEYED;
                        $templateId = "1107161243122261156";
                        break;
                    }
                case 'B9': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", you have been asked to Furnish in writing  complete facts of the matter.";
                        //                    $templateId=SCISMS_GRIEVANCE_COMPLETE_FACTS;
                        $templateId = '1107161243133394568';
                        break;
                    }
                case 'B10': {
                        $msg = "Your Grievance/Communication registered against Inward No. " . $diaryNumber . ", Visit www.sci.nic.in  for necessary information.";
                        //                    $templateId=SCISMS_GRIEVANCE_VISIT_WEBSITE;
                        $templateId = "1107161243142625534";
                        break;
                    }
            }
        } else if ($result[0]['action_taken'] == 'R') {
            switch ($pilSubActionCode) {
                case 'C1': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", has been returned to you  view of Article 235 of the Constitution of India vide this registry letter.";
                        //                    $templateId=SCISMS_GRIEVANCE_ARTICLE_235;
                        $templateId = '1107161243148975839';
                        break;
                    }
                case 'C2': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", you have been informed that no action was taken , in view of  Article 235 of the Constitution of India.";
                        //                    $templateId=SCISMS_GRIEVANCE_NO_ACTION;
                        $templateId = '1107161243154208023';
                        break;
                    }
                case 'C3': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", has been returned to  you as  matter is sub-judice  before concerned Court vide this registry letter.";
                        //                    $templateId=SCISMS_GRIEVANCE_SUBJUDICE_MATTER;
                        $templateId = '1107161243160186430';
                        break;
                    }
                case 'D1': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", a copy of your complaint/letter has been forwarded to  concerned authority for taking necessary action.";
                        //                    $templateId=SCISMS_GRIEVANCE_COPY_FOWARDED;
                        $templateId = '1107161243166287442';
                        break;
                    }
                case 'D2': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", a copy of your complaint/letter has been forwarded to  concerned authority  for taking necessary action and submit report to this Court.";
                        //                    $templateId=SCISMS_GRIEVANCE_FORWARD_REPORT;
                        $templateId = '1107161243173106684';
                        //                    echo $msg;die;
                        break; 
                    }
            }
        }
        //        else if($result[0]['action_taken']=='R')   THIS IS SAME CONDITION IS WRITTEN ABOVE SO THESE TWO CASE IS COMBINED IN ABOVE CONDITION
        //        {
        //            switch ($pilSubActionCode) {
        //                case 'D1':
        //                {
        //                    $msg ="Your Grievance/Communication registered against Inward No." . $diaryNumber . ", a copy of your complaint/letter has been forwarded to  concerned authority for taking necessary action.";
        //                    $templateId=SCISMS_GRIEVANCE_COPY_FOWARDED;
        //                    break;
        //                }
        //                case 'D2':
        //                {
        //                    $msg ="Your Grievance/Communication registered against Inward No." . $diaryNumber . ", a copy of your complaint/letter has been forwarded to  concerned authority  for taking necessary action and submit report to this Court.";
        //                    $templateId=SCISMS_GRIEVANCE_FORWARD_REPORT;
        ////                    echo $msg;die;
        //                    break;
        //                }
        //            }
        //        }
        else if ($result[0]['action_taken'] == 'T') {
            switch ($pilSubActionCode) {
                case 'E1': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", has been forwarded to   concerned  section/authority of Supreme Court.";
                        //                    $templateId=SCISMS_GRIEVANCE_FORWARDED_SECTION;
                        $templateId = '1107161243178467678';
                        break;
                    }
                case 'E2': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", has been transferred to  concerned  Bar Council  for action deemed fit.";
                        //                    $templateId=SCISMS_GRIEVANCE_TRANSFER_BAR_COUNCIL;
                        $templateId = '1107161243185446906';
                        break;
                    }
                case 'E3': {
                        $msg = "Your Grievance/Communication registered against Inward No." . $diaryNumber . ", has been  registered as writ petition as "; //Writ petition number to be print
                        //                    $templateId=SCISMS_GRIEVANCE_WRIT_PETITION;
                        $templateId = '1107161243191296798';
                        break;
                    }
            }
        }
        $msg = $msg . " - Supreme Court of India";
        if ($msg != "" && $mobileNo != "" && $mobileNo != null && $mobileNo != "0") {
            //            echo "RRR";die;
            $msg = $msg . '#' . $mobileNo . '#' . $templateId;
        }
        //        echo $msg;die;

        return $msg;
    }



    //  ************************************************************* BELOW SECTION IS FOR PIL REPORT SUBMENUS **************************************************************
    //BELOW FUNCTION IS NOT IN USED BECAUSE SUBMUDULE IS NOT IN USED GENERATE BRIEF HISTORY AND LETTERS
    public function reportsSection()
    {
        return view('PIL/pilReport');
    }

    public function reportPilGroup($msg = "", $ecPilGroupId = 0)
    {
        $data['msg'] = $msg;
        $data['pilGroup'] = $this->PilModel->getPilGroup();
        //        echo "<pre>";
        //        print_r($data['pilGroup']);
        $data['ecPilGroupId'] = $ecPilGroupId;
        if ($ecPilGroupId != 0) {
            $casesInPilGroup = $this->PilModel->getCasesInPilGroup($ecPilGroupId);
            //            print_r($casesInPilGroup); die;
            $data['casesInPilGroup'] = $casesInPilGroup;
            return $data;
        }
        //       var_dump($data['casesInPilGroup']);
        //        echo "<pre>";
        //        print_r($data);
        //        die;
        return view('PIL/reportPilGroupView', $data);
    }

    public function addToPilGroupReport()
    {
        //        var_dump($_POST);
        //        die;
        $record = $this->reportPilGroup("", $_POST['dt']);
        //        echo "<pre>";
        //        print_r($record);
        //        die;
        echo json_encode($record);
    }


    public function downloadFormatReport()
    {
        $usercode = $_REQUEST['id'];
        $ecPilGroupId = $_REQUEST['eid'];
        $reportType = $_REQUEST['uid'];

        //        echo $ecPilGroupId.">>>>".$reportType.">>>".$userCode;
        //        die;
        /*        print_r(FPDF_FONTPATH);
        die;*/

        $userdetail = getUserNameAndDesignation($usercode);
        /*        echo "<pre>";
        print_r($userdetail);
        die;*/
        $pilData = $this->PilModel->getCasesInPilGroup_asc($ecPilGroupId);
        /*        echo "<pre>";
        print_r($pilData);
        die;*/
        /*print_r($this->pdf->Output());
        die;*/
        //$pdf=new FPDF();
        //        print_r($this->pdf);
        //        die();
        $this->pdf->AddPage();
        $this->pdf->setleftmargin(40);
        $this->pdf->setrightmargin(20);
        if ($reportType == 1) {
            //            echo "DDDD";
            //            die;
            $this->pdf->ln(5);
            $this->pdf->SetFont('times', 'BU', 12);
            $this->pdf->Cell(0, 3, 'SUPREME COURT OF INDIA', 0, 1, 'C');
            $this->pdf->Cell(0, 8, 'PIL(ENGLISH) CELL', 0, 1, 'C');
            $this->pdf->SetFont('times', '', 11);
            $this->pdf->Cell(0, 8, 'Dated: ' . date('d-m-Y'), 0, 1, 'R');
            $this->pdf->Write(5, '              Letter-petition being not addressed to SCI ');

            $this->pdf->SetFont('times', 'B', 11);
            $this->pdf->Write(5, '(only copy of letter-petition endorsed to SCI)');
            $this->pdf->SetFont('times', '', 11);
            $this->pdf->Write(5, ' and not covered under PIL Guidelines.');
            $this->pdf->ln(5);
            $this->pdf->SetFont('times', '', 11);
            $this->pdf->Write(5, '              Hence, if approved, the same may be filed. ');

            $this->pdf->ln(10);
            $this->pdf->SetFont('times', '', 10);
            foreach ($pilData as $index => $data) {
                $this->pdf->Cell(20, 8, '', 0, 0, 'L');
                $this->pdf->Cell(10, 8, ($index + 1) . '.', 0, 0, 'L');
                $this->pdf->Cell(50, 8, $data['pil_diary_number'], 0, 0, 'L');
                $this->pdf->Cell(100, 8, $data['received_from'], 0, 1, 'L');
            }

            $this->pdf->SetFont('times', '', 11);
            $this->pdf->ln(15);

            $this->pdf->SetFont('times', 'B', 9);
            $this->pdf->Cell(80, 8, $userdetail['name'], 0, 1, 'L');
            $this->pdf->Cell(80, 0, $userdetail['type_name'], 0, 1, 'L');
            $this->pdf->ln(15);
            $this->pdf->Cell(80, 0, 'BRANCH OFFICER', 0, 1, 'L');
            /*$pdf->Cell(80,0,'Branch Officer',0,1,'L');*/
            $this->pdf->ln(15);
            $this->pdf->Cell(80, 0, 'DEPUTY REGISTRAR', 0, 1, 'L');
            /* $pdf->Cell(80,0,'Deputy Registrar',0,1,'L');*/
            $this->pdf->ln(15);
            /*$pdf->Cell(80,0,'Ld.Registrar(PIL E)',0,1,'L');*/
            $this->pdf->Cell(80, 0, 'Ld.REGISTRAR(PIL E)', 0, 1, 'L');
            $this->pdf->Output();
        }
        //        elseif ($reportType==2){
        //            $this->pdf->ln(5);
        //            $this->pdf->SetFont('times','BU',12);
        //            $this->pdf->Cell(0,3,'SUPREME COURT OF INDIA',0,1,'C');
        //            $this->pdf->Cell(0,8,'PIL(ENGLISH) CELL',0,1,'C');
        //            $this->pdf->SetFont('times','',11);
        //            $this->pdf->Cell(0,8,'Dated: '. date('d-m-Y'),0,1,'R');
        //            $this->pdf->Write(5,'              Letter-petition being ');
        //            $this->pdf->SetFont('times','B',11);
        //            $this->pdf->Write(5,'Vernacular ');
        //            $this->pdf->SetFont('times','',11);
        //            $this->pdf->Write(5,' and not covered under PIL Guidelines. Hence, if approved, the same may be filed. ');
        //            $this->pdf->ln(10);
        //            $this->pdf->SetFont('times','',10);
        //            foreach($pilData as $index=>$data){
        //                $this->pdf->Cell(20,8,'',0,0,'L');
        //                $this->pdf->Cell(10,8,($index+1).'.',0,0,'L');
        //                $this->pdf->Cell(50,8,$data['pil_diary_number'],0,0,'L');
        //                $this->pdf->Cell(100,8,$data['received_from'],0,1,'L');
        //            }
        //
        //            $this->pdf->ln(15);
        //            $this->pdf->SetFont('times','B',9);
        //            $this->pdf->Cell(80,8,$userdetail['name'],0,1,'L');
        //            $this->pdf->Cell(80,0,$userdetail['type_name'],0,1,'L');
        //            $this->pdf->ln(15);
        //            $this->pdf->Cell(80,0,'BRANCH OFFICER',0,1,'L');
        //            /*$pdf->Cell(80,0,'Branch Officer',0,1,'L');*/
        //            $this->pdf->ln(15);
        //            $this->pdf->Cell(80,0,'DEPUTY REGISTRAR',0,1,'L');
        //            /* $pdf->Cell(80,0,'Deputy Registrar',0,1,'L');*/
        //            $this->pdf->ln(15);
        //            /*$pdf->Cell(80,0,'Ld.Registrar(PIL E)',0,1,'L');*/
        //            $this->pdf->Cell(80,0,'Ld.REGISTRAR(PIL E)',0,1,'L');
        //        }
        //        elseif ($reportType==3){
        //
        //            foreach($pilData as $index=>$data){
        //                if($index==0){
        //                    $reportContent="    Inward Nos. ";
        //                    $receivedFrom="Received from :- ".$this->common->convertToTitleCase($data['received_from']);
        //                }
        //                $reportContent.=$data['pil_diary_number'].", ";
        //            }
        //            $totalPils=count($pilData);
        //            $reportContent=rtrim($reportContent,', ');
        //            $this->pdf->ln(5);
        //            $this->pdf->SetFont('times','BU',12);
        //            $this->pdf->Cell(0,3,'SUPREME COURT OF INDIA',0,1,'C');
        //            $this->pdf->Cell(0,8,'PIL(ENGLISH) CELL',0,1,'C');
        //            $this->pdf->SetFont('times','',11);
        //            $this->pdf->Cell(0,8,'Dated: '. date('d-m-Y'),0,1,'R');
        //
        //            $this->pdf->MultiCell(0, 8, $reportContent.".");
        //
        //            $this->pdf->SetFont('times','B',11);
        //            $this->pdf->Cell(80,8,$receivedFrom,0,1,'L');
        //            $this->pdf->Cell(80,8,$totalPils.' - letter petitions.',0,1,'L');
        //            /*$pdf->Cell(15,8,'',0,0,'L');*/
        //            $this->pdf->SetFont('times','BU',11);
        //            $this->pdf->Cell(80,8,'Brief History of the case and relief sought',0,1,'L');
        //            $this->pdf->SetFont('times','',11);
        //            $this->pdf->Write(5,'         The above emails have been received from the petitioners. If approved the emails may be filed in view of ');
        //            $this->pdf->SetFont('times','U',11);
        //            $this->pdf->Write(5,'Clause A(i) of the Internal Administrative Procedure approved by Hon\'ble PIL Committee/Hon\'ble CJI vide order dated 28.03.2016.');
        //            $this->pdf->SetFont('times','',11);
        //            $this->pdf->Write(5,'(Not Digitally Signed)');
        //            $this->pdf->ln(10);
        //
        //            $this->pdf->Cell(0,8,'         Await follow up with authentic copy and resubmit',0,1,'L');
        //            $this->pdf->Cell(0,8,'Submitted for order please.',0,1,'L');
        //
        //
        //            $this->pdf->ln(15);
        //            $this->pdf->SetFont('times','B',9);
        //            $this->pdf->Cell(80,8,$userdetail['name'],0,1,'L');
        //            $this->pdf->Cell(80,0,$userdetail['type_name'],0,1,'L');
        //            $this->pdf->ln(15);
        //            $this->pdf->Cell(80,0,'BRANCH OFFICER',0,1,'L');
        //            /*$pdf->Cell(80,0,'Branch Officer',0,1,'L');*/
        //            $this->pdf->ln(15);
        //            $this->pdf->Cell(80,0,'DEPUTY REGISTRAR',0,1,'L');
        //            /* $pdf->Cell(80,0,'Deputy Registrar',0,1,'L');*/
        //            $this->pdf->ln(15);
        //            /*$pdf->Cell(80,0,'Ld.Registrar(PIL E)',0,1,'L');*/
        //            $this->pdf->Cell(80,0,'Ld.REGISTRAR(PIL E)',0,1,'L');
        //        }
        //        else if($reportType==4){
        //            $this->pdf->ln(5);
        //            $this->pdf->SetFont('times','BU',12);
        //            $this->pdf->Cell(0,3,'SUPREME COURT OF INDIA',0,1,'C');
        //            $this->pdf->Cell(0,8,'PIL(ENGLISH) CELL',0,1,'C');
        //            $this->pdf->SetFont('times','',11);
        //            $this->pdf->Cell(0,8,'Dated: '. date('d-m-Y'),0,1,'R');
        //            $this->pdf->Write(5,'              Letter-petition being ');
        //            $this->pdf->SetFont('times','B',11);
        //            $this->pdf->Write(5,'unsigned ');
        //            $this->pdf->SetFont('times','',11);
        //            $this->pdf->Write(5,' and not covered under PIL Guidelines. Hence, if approved, the same may be filed. ');
        //            $this->pdf->ln(10);
        //            $this->pdf->SetFont('times','',10);
        //            foreach($pilData as $index=>$data){
        //                $this->pdf->Cell(20,8,'',0,0,'L');
        //                $this->pdf->Cell(10,8,($index+1).'.',0,0,'L');
        //                $this->pdf->Cell(50,8,$data['pil_diary_number'],0,0,'L');
        //                $this->pdf->Cell(100,8,$data['received_from'],0,1,'L');
        //            }
        //
        //            $this->pdf->ln(15);
        //            $this->pdf->SetFont('times','B',9);
        //            $this->pdf->Cell(80,8,$userdetail['name'],0,1,'L');
        //            $this->pdf->Cell(80,0,$userdetail['type_name'],0,1,'L');
        //            $this->pdf->ln(15);
        //            $this->pdf->Cell(80,0,'BRANCH OFFICER',0,1,'L');
        //            /*$pdf->Cell(80,0,'Branch Officer',0,1,'L');*/
        //            $this->pdf->ln(15);
        //            $this->pdf->Cell(80,0,'DEPUTY REGISTRAR',0,1,'L');
        //            /* $pdf->Cell(80,0,'Deputy Registrar',0,1,'L');*/
        //            $this->pdf->ln(15);
        //            /*$pdf->Cell(80,0,'Ld.Registrar(PIL E)',0,1,'L');*/
        //            $this->pdf->Cell(80,0,'Ld.REGISTRAR(PIL E)',0,1,'L');
        //        }
        //        else if ($reportType==5){
        //
        //            foreach($pilData as $index=>$data){
        //                if($index==0){
        //                    $reportContent="Inward Nos. ";
        //                    /*$receivedFrom="Received from :- ".$this->common->convertToTitleCase($data['received_from']);*/
        //                    $receivedFrom="Received from :- Anonymous petitioners";
        //                }
        //                $reportContent.=$data['pil_diary_number'].", ";
        //            }
        //            $totalPils=count($pilData);
        //            $reportContent=rtrim($reportContent,', ');
        //            $this->pdf->ln(5);
        //            $this->pdf->SetFont('times','BU',12);
        //            $this->pdf->Cell(0,3,'SUPREME COURT OF INDIA',0,1,'C');
        //            $this->pdf->Cell(0,8,'PIL(ENGLISH) CELL',0,1,'C');
        //            $this->pdf->SetFont('times','',11);
        //            $this->pdf->Cell(0,8,'Dated: '. date('d-m-Y'),0,1,'R');
        //
        //            $this->pdf->MultiCell(0, 8, $reportContent.".");
        //
        //            $this->pdf->SetFont('times','B',11);
        //            $this->pdf->Cell(80,8,$receivedFrom,0,1,'L');
        //            $this->pdf->Cell(80,8,$totalPils.' - letter petitions.',0,1,'L');
        //            /*$pdf->Cell(15,8,'    ',0,0,'L');*/
        //            $this->pdf->SetFont('times','BU',11);
        //            $this->pdf->Cell(80,8,'Brief History of the case and relief sought',0,1,'L');
        //            $this->pdf->ln(5);
        //            $this->pdf->SetFont('times','',11);
        //            $this->pdf->Write(5,'          The above letter-petitions have been received from the different petitioners i.e ');
        //            $this->pdf->SetFont('times','B',11);
        //            $this->pdf->Write(5,'Anonymous letter-petitions.');
        //
        //
        //            $this->pdf->ln(5);
        //            $this->pdf->SetFont('times','',11);
        //
        //            $this->pdf->Write(5,'          No action is called for under PIL guidelines. May be filed. ');
        //            $this->pdf->ln(5);
        //            $this->pdf->SetFont('times','',11);
        //            $this->pdf->Write(5,'          Submitted for order please.');
        //
        //            $this->pdf->ln(15);
        //            $this->pdf->SetFont('times','B',9);
        //            $this->pdf->Cell(80,8,$userdetail['name'],0,1,'L');
        //            $this->pdf->Cell(80,0,$userdetail['type_name'],0,1,'L');
        //            $this->pdf->ln(15);
        //            $this->pdf->Cell(80,0,'BRANCH OFFICER',0,1,'L');
        //            /*$pdf->Cell(80,0,'Branch Officer',0,1,'L');*/
        //            $this->pdf->ln(15);
        //            $this->pdf->Cell(80,0,'DEPUTY REGISTRAR',0,1,'L');
        //            /* $pdf->Cell(80,0,'Deputy Registrar',0,1,'L');*/
        //            $this->pdf->ln(15);
        //            /*$pdf->Cell(80,0,'Ld.Registrar(PIL E)',0,1,'L');*/
        //            $this->pdf->Cell(80,0,'Ld.REGISTRAR(PIL E)',0,1,'L');
        //        }
        //        $this->pdf->Output();


    }


    //END OF GENERATE BRIEF HISTORY FUNCTIONS


    // FOR QUERRY SUB MENUS BELOW IS THE CODE ----- START

    public function queryPilData()
    {
        $data = [];
        if (!empty($_POST)) {
            //            echo "<pre>";
            //            print_r($_POST);die;
            $columnName = $_POST['columnName'];
            $qryText = $_POST['qryText'];

            if (!empty($columnName) && !empty($qryText)) {
                $result_array = $this->PilModel->getQueryPilData($columnName, $qryText);
                //                echo "<pre>";
                //                print_r($result_array);die;
                if (!empty($result_array)) {
                    $data['pil_result'] = $result_array;
                }
                $data['column_name'] = $columnName;
                $data['text'] = $qryText;
                //            echo "<pre>";
                //            print_r($data);
                //            die;
            }
            echo view('PIL/queryPilReportData', $data);
            exit();
        }
        return view('PIL/queryPilReport');
    }


    public function rptPilCompleteData($ecPilId = null)
    {
        //        echo ">>".$ecPilId;
        //        die;
        $data['pil_id'] = $ecPilId;
        $data['state'] = $this->PilModel->get_state_list();
        $data['pilCategory'] = $this->PilModel->getPilCategory();
        $data['pilGroup'] = $this->PilModel->getPilGroup();
        if ($ecPilId != null and $ecPilId != 0)
            $recordArr = $this->PilModel->getPilDataById($ecPilId);

        if (!empty($recordArr)) {
            foreach ($recordArr as $record) {
                $data['pilCompleteDetail'] = $record;
            }
        }
        //                echo "<pre>";
        //        print_r($record);die;

        $data['date_formatter_received_on'] = $this->common->date_formatter($record['received_on'], 'd-m-Y');
        $data['date_formatter_petition_date'] =  $this->common->date_formatter($record['petition_date'], 'd-m-Y');
        $data['date_formatter_written_on'] = $this->common->date_formatter($record['written_on'], 'd-m-Y');
        $data['date_formatter_return_date'] = $this->common->date_formatter($record['return_date'], 'd-m-Y');
        $data['date_formatter_sent_on'] = $this->common->date_formatter($record['sent_on'], 'd-m-Y');
        $data['date_formatter_transfered_on'] = $this->common->date_formatter($record['transfered_on'], 'd-m-Y');
        $data['date_formatter_other_action_taken_on'] = $this->common->date_formatter($record['other_action_taken_on'], 'd-m-Y');
        $data['date_formatter_report_received_date'] = $this->common->date_formatter($record['report_received_date'], 'd-m-Y');
        $data['date_formatter_destroy_on'] = $this->common->date_formatter($record['destroy_on'], 'd-m-Y');
        $data['date_formatter_in_record_on'] = $this->common->date_formatter($record['in_record_on'], 'd-m-Y');

        if ($record['destroy_on'] != null && $record['destroy_on'] != "" && $record['is_deleted'] == 't') {
            $data['destroyOrKeepIn'] = 'Y';
            $data['destroyOrKeepInDate'] = $this->common->date_formatter($record['destroy_on'], 'd-m-Y');
        } else if ($record['in_record_on'] != null && $record['in_record_on'] != "") {
            $data['destroyOrKeepIn'] = 'N';
            $data['destroyOrKeepInDate'] = $this->common->date_formatter($record['in_record_on'], 'd-m-Y');
        }

        if ($record['action_taken'] != '') {

            switch (trim($record['action_taken'])) {
                case "L": {
                        if (!empty($record['lodgment_date'])) {
                            $data['actionTakenText'] = "No Action Required on " . date('d-m-Y', strtotime($record['lodgment_date']));
                        } else {
                            $data['actionTakenText'] = " ";
                        }
                        break;
                    }
                case "W": {
                        if (!empty($record['written_to'])) {
                            $data['actionTakenText'] = "Written Letter to " . $record['written_to'] . " on " . date('d-m-Y', strtotime($record['written_on']));
                        } else {
                            $data['actionTakenText'] = " ";
                        }
                        break;
                    }
                case "R": {
                        if (!empty($record['return_date'])) {
                            $data['actionTakenText'] = "Letter Returned to Sender on " . date('d-m-Y', strtotime($record['return_date']));
                        } else {
                            $data['actionTakenText'] = " ";
                        }

                        break;
                    }
                case "S": {
                        $data['actionTakenText'] = "Letter Sent To " . $record['sent_to'] . " on " . date('d-m-Y', strtotime($record['sent_on']));
                        break;
                    }
                case "T": {
                        $data['actionTakenText'] = "Letter Transferred To " . $record['transfered_to'] . " on " . date('d-m-Y', strtotime($record['transfered_on']));
                        break;
                    }
                case "I": {

                        $data['actionTakenText'] = "Letter Converted To Writ";
                        break;
                    }
                case "O": {
                        $data['actionTakenText'] = "Other Remedy <br/>" . $record['other_text'] . " on dated " . $data['date_formatter_other_action_taken_on'];
                        break;
                    }
                default: {
                        $data['actionTakenText'] = "UNDER PROCESS";
                        break;
                    }
            }
        } else {
            $data['actionTakenText'] = " ";
        }

        //        echo "<pre>";
        //        print_r($data);
        //        die;
        return view('PIL/rptCompletePilData', $data);
    }




    // PIL REPORTS >> REPORTS SUB MENU

    public function getPilReport()
    {
        //        echo "<pre>";
        //        print_r($_POST);  die;
        $from_date = $to_date = $reportType = '';
        if (!empty($_POST)) {
            $from_date = $_POST['from_date'];
            $to_date = $_POST['to_date'];
            $reportType = $_POST['reportType'];
        }
        if (!empty($from_date) && !empty($to_date)) {
            $first_date = date('Y-m-d', strtotime($from_date));
            $to_date = date('Y-m-d', strtotime($to_date));

            if (!empty($reportType)) {
                $reportTypeData = $reportType;
            }
            $result_array = $this->PilModel->getPilReportData($first_date, $to_date, $reportTypeData);
            $data['pil_result'] = $result_array;
            $data['first_date'] = $first_date;
            $data['to_date'] = $to_date;
            $data['reportType'] = $reportTypeData;
            //        echo"<pre>";
            //        print_r($data); die;
            return view('PIL/pilReport', $data);
        }
        return view('PIL/pilReport');
    }

    public function getPilUserWise()
    {

        if (!empty($_POST)) {
            $from_date = $_POST['from_date'];
            $to_date = $_POST['to_date'];
            //  echo "TTT";
            $first_date = date('Y-m-d', strtotime($from_date));
            $to_date = date('Y-m-d', strtotime($to_date));
            $reportTypeData = 'C';
            $result_array = $this->PilModel->getUserWorkDone($first_date, $to_date, $reportTypeData);
            //        echo "<pre>";
            //        print_r($result_array);
            if ($result_array === 'false') {
                $data['pil_result'] = '';
            } else {
                $data['pil_result'] = $result_array;
            }
            $data['first_date'] = $first_date;
            $data['to_date'] = $to_date;
            $data['reportType'] = $reportTypeData;
            //        echo"<pre>";
            //        print_r($data);
            //        die;
            echo view('PIL/pilReportUserWiseDetail', $data);
            exit();
        } else {
            return view('PIL/pilReportUserWise');
        }
    }

    public function getWorkDone($dated, $updatedBy)
    {
        //        print_r($_GET);die;
        $result_array = $this->PilModel->getWorkDone($dated, $updatedBy);
        if ($result_array === 'false') {
            $data['pil_result'] = '';
        } else {
            $data['pil_result'] = $result_array;
        }

        $data['dated'] = $dated;
        return view('PIL/pilEachUserWiseDetail', $data);
    }
}
