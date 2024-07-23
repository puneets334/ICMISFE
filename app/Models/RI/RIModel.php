<?php

namespace App\Models\RI;

use CodeIgniter\Model;

class RIModel extends Model
{

    function __construct()
    {
        parent::__construct();
        $db = \Config\Database::connect();
    }

    function showRIData()
    {
        $builder = $this->db->table('ec_postal_received ep');
        $builder->select(["ep.id,concat(ep.diary_no,'/',ep.diary_year) as postal_diary_no,ep.postal_no,ep.postal_date, ep.sender_name,rpt.postal_type_description,
ep.address,ep.postal_addressee, ep.ec_case_id,
(case when dispatched_to_user_type='s' then (select section_name from master.usersection where id=ept.dispatched_to) 
else case when dispatched_to_user_type = 'o' then (select concat(name,' (',empid,') ') 
from master.users where usercode=ept.dispatched_to) 
else case when dispatched_to_user_type = 'j' then (select jname from master.judge where jcode=ept.dispatched_to) else ep.postal_addressee end end end) as address_to"]);
        $builder->join('master.ref_postal_type rpt', 'ep.ref_postal_type_id=rpt.id', 'inner');
        $builder->join('ec_postal_transactions ept', 'ep.id=ept.ec_postal_received_id', 'left');
        $builder->where("(ept.is_active='t' or ept.is_active is null) and ep.is_ad_card=0");
        $builder->orderBy('ep.id', 'DESC');
        $builder->limit(30);

        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }

    public function getReceiptId($diaryNo, $diaryYear)
    {
        $builder = $this->db->table('ec_postal_received');
        $builder->select('id');
        $builder->where('diary_no', $diaryNo);
        $builder->where('diary_year', $diaryYear);
        $query = $builder->get();
        $result = $query->getResultArray();
        if (!empty($result[0])) {
            return $result[0];
        } else {
            return false;
        }
    }

    public function getJudge()
    {
        $builder = $this->db->table('master.judge');
        $builder->select('*');
        $builder->where('display', 'Y');
        $builder->where('jtype', "J");
        $builder->where('is_retired', "N");
        $builder->orderBy('jtype', 'ASC');
        $builder->orderBy('judge_seniority', 'ASC');
        $query = $builder->get();
        $result = $query->getResultArray();
        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }



    public function getProcessIdDetails($processId, $processYear)
    {

        $builder = $this->db->table('ec_postal_dispatch epd');
        $builder->select([
            'epd.is_case',
            'epd.is_with_process_id',
            'epd.reference_number',
            'epd.id AS ec_postal_dispatch_id',
            'epd.process_id',
            'epd.process_id_year',
            "CASE WHEN m.reg_no_display IS NOT NULL THEN m.reg_no_display ELSE CONCAT(LEFT(CAST(m.diary_no AS TEXT),4), RIGHT(CAST(m.diary_no AS TEXT),4)) END AS case_no",
            'epd.diary_no',
            'epd.send_to_name',
            'epd.send_to_address',
            'tn.name AS doc_type',
            's.name AS state_name',
            'd.name AS district_name',
            'epd.pincode',
            'epd.tal_state',
            'epd.tal_district',
            'us.section_name',
            'epd.serial_number',
            'epd.ref_postal_type_id',
            'epd.postal_charges',
            'epd.weight',
            'epd.waybill_number',
            'epd.usersection_id',
            '(SELECT section_name FROM master.usersection WHERE id = epd.usersection_id) AS send_to_section',
            '(SELECT name FROM master.tw_serve WHERE serve_stage = epd.serve_stage AND serve_type = 0) AS serve_stage',
            '(SELECT name FROM master.tw_serve WHERE id = epd.tw_serve_id) AS serve_type',
            'epd.serve_remarks',
            'rpt.postal_type_description'
        ]);
        $builder->join('main m', 'epd.diary_no = m.diary_no', 'left');
        $builder->join('master.tw_notice tn', 'epd.tw_notice_id = tn.id', 'left');
        $builder->join('master.usersection us', 'epd.usersection_id = us.id', 'left');
        $builder->join('master.ref_postal_type rpt', 'epd.ref_postal_type_id = rpt.id', 'left');
        $builder->join('master.state s', 's.id_no = epd.tal_state', 'left');
        $builder->join('master.state d', 'd.id_no = epd.tal_district', 'left');
        $builder->where('epd.process_id', $processId);
        $builder->where('epd.process_id_year', $processYear);
        $builder->where('epd.ref_letter_status_id', '2');
        $builder->orderBy('epd.ref_postal_type_id');
        $builder->orderBy('epd.serial_number');

        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }

    public function getMainLetterDetails($ecPostalDispatchId)
    {
        $ecPostalDispatchId = intval($ecPostalDispatchId);
        $builder = $this->db->table('ec_postal_dispatch epd');
        $builder->select('epd.id,epd.process_id,epd.process_id_year,epd.send_to_name,epd.send_to_address,epd.ref_letter_status_id,epdct.id as connected_id');
        $builder->join('ec_postal_dispatch_connected_letters epdct', 'epd.id=epdct.ec_postal_dispatch_id', 'left');
        $builder->where('epd.id', $ecPostalDispatchId);
        $builder->where("epdct.is_deleted=0 or epdct.is_deleted is null");
        $query = $builder->get();
        $result = $query->getResultArray();
        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }

    public function addConnectedLetter($ecPostalDispatchId, $ecMainId, $usercode)
    {
        $dataForConnect = array(
            'ec_postal_dispatch_id' => $ecPostalDispatchId,
            'ec_postal_dispatch_id_main' => $ecMainId,
            'usercode' => $usercode,
            'updated_on' => date('Y-m-d H:i:s'),
            'create_modify' => date("Y-m-d H:i:s"),
            'updated_by' => $usercode,
            'updated_by_ip' => getClientIP()
        );

        $builder = $this->db->table('ec_postal_dispatch_connected_letters');

        $query = $builder->set($dataForConnect)->getCompiledInsert('ec_pil_group_file');
        echo $query;
        die;
    }

    public function getSection()
    {
        $builder = $this->db->table('master.usersection');
        $builder->select('*');
        $builder->where('display', 'Y');
        $builder->orderBy('section_name', 'ASC');
        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return 'false';
        }
    }

    public  function getOfficers()
    {
        $builder = $this->db->table('master.users u');
        $builder->select('usercode, empid, name, ut.type_name');
        $builder->join('master.usertype ut', 'u.usertype = ut.id', 'INNER');
        $builder->groupStart();
        $builder->like('type_name', 'Secretary General', 'both', '!', true);
        $builder->orLike('type_name', 'Registrar', 'both', '!', true);
        $builder->orLike('type_name', 'Additional Registrar', 'both', '!', true);
        $builder->orLike('type_name', 'Deputy Registrar', 'both', '!', true);
        $builder->orLike('type_name', 'Assistant Registrar', 'both', '!', true);
        $builder->orLike('type_name', 'AR-Cum-PS', 'both', '!', true);
        $builder->orLike('type_name', 'Assistant Editor', 'both', '!', true);
        $builder->orLike('type_name', 'Branch Officer', 'both', '!', true);
        $builder->orLike('type_name', 'OSD', 'both', '!', true);
        $builder->groupEnd();
        $builder->orderBy('name');
        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return 'false';
        }
    }


    public function getCaseType()
    {
        $builder = $this->db->table('master.casetype');
        $builder->select('casecode, skey, casename,short_description');
        $builder->where('display', 'Y');
        $builder->where('casecode!=', '9999');
        $builder->orderBy('casecode');
        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }

    public function getServeType($type, $serveStage = 0)
    {
        $builder = $this->db->table('master.tw_serve');
        $builder->where('display', 'Y');
        if ($type == 1) {
            $builder->orderBy('serve_stage', 'ASC');
            $builder->where('serve_type', 0);
        } elseif ($type == 2) {
            $builder->orderBy('serve_type', 'ASC');
            $builder->where('serve_stage', $serveStage);
            $builder->where('serve_type != ', 0);
        }

        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function getReceiptMode()
    {
        $builder = $this->db->table('master.ref_postal_type');
        $builder->select('*');
        $builder->where('id !=', '9999');
        $builder->orderBy('postal_type_code', 'ASC');
        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }

    public function getReceiptDataById($ecReceiptId)
    {
        $builder = $this->db->table('ec_postal_received');
        $builder->select('ec_postal_transactions.*,ec_postal_received.*,ec_postal_transactions.id as ec_postal_transactions_id,ec_postal_transactions.is_deleted as ec_postal_transactions_is_deleted');
        $builder->where('ec_postal_received.id', $ecReceiptId);
        $builder->where('ec_postal_received.is_deleted', 'f');
        $builder->where('ec_postal_transactions.is_active', 't');
        $builder->join('ec_postal_transactions', 'ec_postal_received.id = ec_postal_transactions.ec_postal_received_id', 'left');
        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return 'false';
        }
    }

    function getLastDiaryNumber($diaryYear)
    {
        $builder = $this->db->table('ec_postal_received');
        $builder->selectMax('diary_no');
        $builder->where('diary_year', $diaryYear);
        $query = $builder->get();

        $result = $query->getResultArray();
        if ($result != null) {
            return $result[0];
        } else {
            return [];
        }
    }

    public function getSearchDiary($searchType, $caseTypeId = null, $caseNo = null, $caseYear = null, $diaryNo = null, $diaryYear = null)
    {
        $db = \Config\Database::connect();
        $result = [];

        if ($searchType == 'c') {
            $builder = $db->table('main_casetype_history h');
            $builder->distinct();
            $builder->select('h.diary_no');
            $builder->where("SUBSTRING_INDEX(h.new_registration_number, '-', 1) = CAST(? AS UNSIGNED)", [$caseTypeId]);
            $builder->where("CAST(? AS UNSIGNED) BETWEEN (SUBSTRING_INDEX(SUBSTRING_INDEX(h.new_registration_number, '-', 2),'-',-1)) 
                              AND (SUBSTRING_INDEX(h.new_registration_number, '-', -1))", [$caseNo]);
            $builder->where('h.new_registration_year', $caseYear);
            $builder->where('h.is_deleted', 'f');
        } elseif ($searchType == 'd') {
            $builder = $db->table('main');
            $builder->distinct();
            $builder->select('diary_no');
            $builder->where('SUBSTRING(diary_no, 1, LENGTH(diary_no) - 4)', $diaryNo);
            $builder->where('SUBSTRING(diary_no, -4)', $diaryYear);
        }

        $query = $builder->get();
        $result = $query->getResultArray();

        if (count($result) >= 1) {
            return $result;
        } else {
            return false;
        }
    }


    public function transferReceiptDataToLogtable($receiptid)
    {


        $builder = $this->db->table('ec_postal_received_log');
        $sql = "INSERT INTO ec_postal_received_log SELECT * FROM ec_postal_received WHERE id = ?";

        $query = $this->db->query($sql, [$receiptid]);

        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }


    function saveReceiptData($query, $actionType = "")
    {
        if ($actionType == "i") {
            $this->db->query($query);
            return $this->db->insertID();
        } else {
            $result = $this->db->query($query);
            return $result;
        }
    }

    public function updateEcPostalTransactions($dataForInsert, $dataForUpdate, $id)
    {

        $builder = $this->db->table('ec_postal_transactions');
        $data = [
            'action_taken_on' => date('Y-m-d H:i:s'),
            'last_updated_on' => date('Y-m-d H:i:s'),
            'create_modify' => date("Y-m-d H:i:s"),
            'updated_on' => date("Y-m-d H:i:s"),
            'updated_by' => session()->get('login')['usercode'],
            'updated_by_ip' => getClientIP()
        ];
        $builder->where('is_active', 't');
        $builder->where('ec_postal_received_id', $id);
        $builder->update($dataForUpdate);
        $builder->insert($dataForInsert);
    }





    /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> DATE-WISE REPORT FUNCTION<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  */

    function getReceiptDateWise($fromDate, $toDate)
    {
        $builder = $this->db->table('ec_postal_received ecpd');
        $builder->select('ecpd.id,ecpd.ec_case_id,sender_name,address, concat(ecpd.diary_no,\'/\',ecpd.diary_year) as diary, ecpd.remarks, ecpd.subject');
        $builder->select('case when postal_no is not null then postal_no else (case when letter_no is not null then letter_no end) end as postal_number');
        $builder->select('case when postal_date is not null then postal_date else (case when letter_date is not null then letter_date end) end as postal_date');
        $builder->select('(select postal_type_description from master.ref_postal_type rpt where rpt.id=ref_postal_type_id) as postal_type');
        $builder->select("(case when ept.dispatched_to_user_type='s' then (select section_name from master.usersection where id=ept.dispatched_to) 
		else case when ept.dispatched_to_user_type = 'o' then (select concat(name,' (',empid,') ') from master.users where usercode=ept.dispatched_to) 
		else case when ept.dispatched_to_user_type = 'j' then (select jname from master.judge where jcode=ept.dispatched_to) 
		else ecpd.postal_addressee end end end) as address_to");
        $builder->select("ec.diary_no as diary_number, ec.reg_no_display, (SELECT CONCAT(name, ' (', empid, ')') FROM master.users WHERE usercode = adm_updated_by) as received_by, ecpd.received_on");
        $builder->join('main ec', 'ecpd.ec_case_id = ec.diary_no', 'left');
        $builder->join('ec_postal_transactions ept', 'ecpd.id = ept.ec_postal_received_id', 'left');
        $builder->where("(ept.is_active='t' OR ept.is_active IS NULL)");
        $builder->where("DATE(ecpd.received_on) BETWEEN '$fromDate' AND '$toDate'");
        $builder->where('ecpd.is_deleted', 'f');
        $builder->orderBy('ecpd.diary_no');
        $query = $builder->get();
        $result = $query->getResultArray();
        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }


    function getCompleteDetail($ecPostalReceivedId)
    {

        $builder = $this->db->table('ec_postal_received ep');
        $builder->select("id,(select postal_type_description from master.ref_postal_type where id=ref_postal_type_id) as postal_type,is_openable,
            postal_no,postal_date,letter_no,letter_date,subject,is_original_record,sender_name,address,
            (select state_name from master.ref_state where id=ref_state_id) as state,concat(ep.diary_no,'/',ep.diary_year) as ri_diary_number,pil_diary_number,remarks,
            (select concat(name ,'(',empid,')') from master.users where usercode=adm_updated_by) as received_by,received_on ,
            case when m.reg_no_display is not null and m.diary_no is not null then concat(m.reg_no_display,' @ ',concat(left((cast(m.diary_no as text)),-4),' / ',right((cast(m.diary_no as text)),4))) else '' end as case_no");
        $builder->join('main m', 'ep.ec_case_id=m.diary_no', 'left');
        $builder->where('id', $ecPostalReceivedId);
        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }


    function getTransactions($ecPostalReceivedId)
    {

        $builder = $this->db->table('ec_postal_transactions');
        $builder->select("(case when dispatched_to_user_type='s' then (select section_name from master.usersection where id=dispatched_to) else 
        case when dispatched_to_user_type = 'o' then (select concat(name,' (',empid,') ') from master.users where usercode=dispatched_to) else 
        case when dispatched_to_user_type = 'j' then (select jname from master.judge where jcode=dispatched_to) else '' end end end) as address_to
        ,(select concat(name ,'(',empid,')') from master.users where usercode=dispatched_by) as dispatched_by,dispatched_on,
        case when action_taken=1 then 'Received' else case when action_taken=2 then 'Returned' else case when action_taken=3 then 'Forwarded' else '' end end end as action_taken,action_taken_on,
        (select concat(name ,'(',empid,')') from master.users where usercode=action_taken_by) as action_taken_by,is_active,return_reason");
        $builder->where('ec_postal_received_id', $ecPostalReceivedId);
        $builder->where('is_deleted', 'f');
        $builder->orderBy('last_updated_on');
        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }

    /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> END DATE-WISE REPORT FUNCTION<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  */


    /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> DISPATCH AD TO SECTION REPORT FUNCTION<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  */






    function enteredDakToDispatchInRIWithProcessId($wherePostalDispatch, $whereDateRange)
    {
        $builder = $this->db->table('ec_postal_dispatch epd');
        $builder->select("epd.is_case,epd.is_with_process_id,epd.reference_number,epd.id as ec_postal_dispatch_id,epd.process_id,epd.process_id_year,
            case when (m.reg_no_display is null or m.reg_no_display='') then concat('Diary No. ',LEFT(cast(m.diary_no as text),4), '/',RIGHT(cast(m.diary_no as text),4)) else m.reg_no_display end as case_no,
            epd.diary_no,epd.send_to_name,epd.send_to_address,tn.name as doc_type,s.name as state_name, d.name as district_name,epd.pincode,epd.tal_state,epd.tal_district,
              (select concat(name ,'(',empid,')') from master.users where usercode=epdt.usercode) as sent_by,
              epdt.updated_on as sent_on,us.section_name,epd.serial_number,
              epd.ref_postal_type_id,epd.postal_charges,epd.weight,epd.waybill_number,epd.usersection_id,
              (select section_name from master.usersection where id=epd.usersection_id) as send_to_section,
              (select name from master.tw_serve where serve_stage=epd.serve_stage and serve_type=0) as serve_stage,
              (select name from master.tw_serve where id=epd.tw_serve_id) as serve_type,epd.serve_remarks");
        $builder->join('ec_postal_dispatch_transactions epdt', 'epd.id=epdt.ec_postal_dispatch_id and epd.ref_letter_status_id=epdt.ref_letter_status_id', 'INNER');
        $builder->join('main m', 'epd.diary_no=m.diary_no', 'left');
        $builder->join('master.tw_notice tn', 'epd.tw_notice_id=tn.id', 'left');
        $builder->join('master.usersection us', 'epd.usersection_id=us.id', 'left');
        $builder->join('master.state s', 's.id_no=epd.tal_state', 'left');
        $builder->join('master.state d', 'd.id_no=epd.tal_district', 'left');
        $builder->where("$wherePostalDispatch $whereDateRange");
        $builder->orderBy('epd.ref_postal_type_id,epd.serial_number');
        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }

    /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> END DISPATCH AD TO SECTION REPORT FUNCTION<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  */


    /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Dispatch to Officer/Section REPORT FUNCTION<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  */






    function getDispatchData($whereCondition, $receiptModeCondition, $fromDate, $toDate)
    {
        $builder = $this->db->table('ec_postal_received ecpd');
        $builder->select("ecpd.id,ecpd.ec_case_id,sender_name,address,concat(ecpd.diary_no,'/',ecpd.diary_year) as diary,ecpd.remarks,
        ecpd.subject,(case when postal_no is not null then postal_no else case when letter_no is not null then letter_no end end) as postal_number,
        (case when postal_date is not null then postal_date else case when letter_date is not null then letter_date end end) as postal_date,
      (select postal_type_description from master.ref_postal_type rpt where rpt.id=ref_postal_type_id) as postal_type,
      (case when ept.dispatched_to_user_type='s' then (select section_name from master.usersection where id=ept.dispatched_to) else 
        case when ept.dispatched_to_user_type = 'o' then (select concat(name,' (',empid,') ') from master.users where usercode=ept.dispatched_to) else 
        case when ept.dispatched_to_user_type = 'j' then (select jname from master.judge where jcode=ept.dispatched_to) else ecpd.postal_addressee end end end) as address_to,        
      ec.diary_no as diary_number,ec.reg_no_display,
     (select concat(name ,'(',empid,')') from master.users where usercode=ept.dispatched_by) as dispatched_by,ept.dispatched_on,ept.action_taken");

        $builder->join('main ec', 'ecpd.ec_case_id=ec.diary_no', 'LEFT');
        $builder->join('ec_postal_transactions ept', 'ecpd.id=ept.ec_postal_received_id', 'LEFT');
        $builder->where("(ept.is_active='t' or ept.is_active is null) and date(ecpd.received_on)  between '$fromDate' and '$toDate' and ecpd.is_deleted='f' ");
        if ($whereCondition != null) {
            $builder->where("$whereCondition");
        }
        if ($receiptModeCondition != null) {
            $builder->where("$receiptModeCondition");
        }
        $builder->where("(ept.action_taken is null or ept.action_taken!=1)");
        $builder->orderBy('ecpd.diary_no');
        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }

    /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> END Dispatch to Officer/Section REPORT FUNCTION<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  */


    /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Update Serve Status REPORT FUNCTION<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  */



    public function updateServeStatus($id, $letterStatus, $usercode, $serveStage, $serveType, $remarks)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ec_postal_dispatch');

        // Data array for updating ec_postal_dispatch
        $dataForDispatch = [
            'ref_letter_status_id' => $letterStatus,
            'usercode' => $usercode,
            'updated_on' => date('Y-m-d H:i:s'),
            'serve_stage' => $serveStage,
            'tw_serve_id' => $serveType,
            'serve_remarks' => $remarks,
            'create_modify' => date("Y-m-d H:i:s"),
            'updated_by' => $usercode,
            'updated_by_ip' => getClientIP()
        ];
        $builder->where('id', $id);
        $builder->update($dataForDispatch);

        if ($db->affectedRows() > 0) {
            $dataForDispatchTransactions = [
                'ec_postal_dispatch_id' => $id,
                'ref_letter_status_id' => $letterStatus,
                'usercode' => $usercode,
                'updated_on' => date('Y-m-d H:i:s'),
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_by' => $usercode,
                'updated_by_ip' => getClientIP()
            ];
            $transactionsBuilder = $db->table('ec_postal_dispatch_transactions');
            $transactionsBuilder->insert($dataForDispatchTransactions);
        }
    }



    /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> END Update Serve Status  REPORT FUNCTION<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  */


    /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Receipt By Section/Officer REPORT FUNCTION<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  */



    function getUserDetails($usercode)
    {

        $builder = $this->db->table('master.users u');
        $builder->select('ut.type_name,u.*');
        $builder->join('master.usertype ut', 'u.usertype=ut.id', 'inner');
        $builder->where('u.usercode', $usercode);
        $builder->where('u.display', 'Y');

        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }


    function getReceivedByConcernDateWise($fromDate, $toDate, $usercode, $section, $reportType = 0)
    {
        $whereCondition = "ept.action_taken in (1,2)";
        if ($reportType == 1) {
            $whereCondition = "ept.action_taken=1";
        } else if ($reportType == 2) {
            $whereCondition = "ept.action_taken=2";
        }
        if ($usercode == 1) {

            $builder = $this->db->table('ec_postal_received ecpd');
            $builder->select("ecpd.id,ecpd.ec_case_id,sender_name,address,concat(ecpd.diary_no,'/',ecpd.diary_year) as diary,ecpd.remarks,
                ecpd.subject,(case when postal_no is not null then postal_no else case when letter_no is not null then letter_no end end) as postal_number,
                (case when postal_date is not null then postal_date else case when letter_date is not null then letter_date end end) as postal_date,
                (select postal_type_description from master.ref_postal_type rpt where rpt.id=ref_postal_type_id) as postal_type,
               (case when ept.dispatched_to_user_type='s' then (select section_name from master.usersection where id=ept.dispatched_to) else 
                case when ept.dispatched_to_user_type = 'o' then (select concat(name,' (',empid,') ') from master.users where usercode=ept.dispatched_to) else 
                case when ept.dispatched_to_user_type = 'j' then (select jname from master.judge where jcode=ept.dispatched_to) else ecpd.postal_addressee end end end) as address_to
                ,ec.diary_no as diary_number,ec.reg_no_display,
                (select concat(name ,'(',empid,')') from master.users where usercode=dispatched_by) as dispatched_by,dispatched_on,
                (select concat(name ,'(',empid,')') from master.users where usercode=action_taken_by) as action_taken_by,action_taken_on,
                case when action_taken=1 then 'Received' else case when action_taken=2 then 'Returned' else '' end end as action_taken,
                (select concat(name ,'(',empid,')') from master.users where usercode=adm_updated_by) as received_by,ecpd.received_on");

            $builder->join('main ec', 'ecpd.ec_case_id=ec.diary_no', 'LEFT');
            $builder->join('ec_postal_transactions ept', 'ecpd.id=ept.ec_postal_received_id', 'LEFT');
            $builder->join('master.users u', 'u.usercode=ept.action_taken_by', 'INNER');
            $builder->join('master.usersection us', 'us.id=u.section', 'INNER');
            $builder->where("(ecpd.is_deleted='f' and date(ept.action_taken_on) between '$fromDate' and '$toDate')");
            $builder->where("$whereCondition");
            $builder->orderBy("ecpd.diary_no");
        } else {

            $builder = $this->db->table('ec_postal_received ecpd');
            $builder->select("ecpd.id,ecpd.ec_case_id,sender_name,address,concat(ecpd.diary_no,'/',ecpd.diary_year) as diary,ecpd.remarks,
                ecpd.subject,(case when postal_no is not null then postal_no else case when letter_no is not null then letter_no end end) as postal_number,
               (case when postal_date is not null then postal_date else case when letter_date is not null then letter_date end end) as postal_date,
                (select postal_type_description from master.ref_postal_type rpt where rpt.id=ref_postal_type_id) as postal_type,
               (case when ept.dispatched_to_user_type='s' then (select section_name from master.usersection where id=ept.dispatched_to) else 
                case when ept.dispatched_to_user_type = 'o' then (select concat(name,' (',empid,') ') from master.users where usercode=ept.dispatched_to) else 
                case when ept.dispatched_to_user_type = 'j' then (select jname from master.judge where jcode=ept.dispatched_to) else ecpd.postal_addressee end end end) as address_to
                ,ec.diary_no as diary_number,ec.reg_no_display,
                (select concat(name ,'(',empid,')') from master.users where usercode=dispatched_by) as dispatched_by,dispatched_on,
                (select concat(name ,'(',empid,')') from master.users where usercode=action_taken_by) as action_taken_by,action_taken_on,
                case when action_taken=1 then 'Received' else case when action_taken=2 then 'Returned' else '' end end as action_taken,
                (select concat(name ,'(',empid,')') from master.users where usercode=adm_updated_by) as received_by,ecpd.received_on");

            $builder->join('main ec', 'ecpd.ec_case_id=ec.diary_no', 'LEFT');
            $builder->join('ec_postal_transactions ept', 'ecpd.id=ept.ec_postal_received_id', 'LEFT');
            $builder->join('master.users u', 'u.usercode=ept.action_taken_by', 'INNER');
            $builder->join('master.usersection us', 'us.id=u.section', 'INNER');
            $builder->where("(ecpd.is_deleted='f' and date(ept.action_taken_on) between '$fromDate' and '$toDate')");
            $builder->where("(action_taken_by=$usercode or us.id=$section)");
            $builder->where("$whereCondition");
            $builder->orderBy("ecpd.diary_no");
        }

        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }




    /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> END Receipt By Section/Officer  REPORT FUNCTION<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  */


    /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Received Query REPORT FUNCTION<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  */



    function get_received_data($usercondition)
    {

        if ($usercondition != '') {
            $builder = $this->db->table('ec_postal_received epr');
            $builder->select('*');
            $builder->where("$usercondition");
            $query = $builder->get();
            $result = $query->getResultArray();

            if ($query->getNumRows() >= 1) {
                return $result;
            }
        } else {
            return false;
        }
    }

    /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> END Received Query REPORT FUNCTION<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  */


    /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> RECEIVE DAK FUNCTION<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  */








    function getDakDataForReceive($usercode, $section, $status = "", $actionType = "", $fromDate = "", $toDate = "")
    {

        $whereCondition = "";
        $dateCondition = "";
        if ($status == 'P') {
            $whereCondition = "(ept.action_taken is null or ept.action_taken=0 or CAST(ept.action_taken_by as text)='')";
        } elseif ($status = 'R') {
            if ($actionType == 1) {
                $whereCondition = "ept.action_taken=$actionType and (ept.action_taken_on is not null or ept.action_taken_on!='')";
            }
        }
        if ($fromDate != "" && $toDate != "") {
            $dateCondition = "and date(ept.action_taken_on) between $fromDate and $toDate";
        }
        $sql = "";
        if ($usercode == 1) {

            $builder = $this->db->table('ec_postal_received ecpd');
            $builder->select("ecpd.is_ad_card,ecpd.ec_postal_dispatch_id,epd.is_with_process_id,epd.process_id,epd.process_id_year,epd.reference_number,                
                (select name from master.tw_serve where serve_stage=epd.serve_stage and serve_type=0) as serve_stage,
              (select name from master.tw_serve where id=epd.tw_serve_id) as serve_type,epd.serve_remarks, 
                ept.id as ec_postal_transactions_id,ecpd.id,ecpd.ec_case_id,ecpd.sender_name,ecpd.address,concat(ecpd.diary_no,'/',ecpd.diary_year) as diary,ecpd.remarks,
                    ecpd.subject,(case when ecpd.postal_no is not null then ecpd.postal_no else case when ecpd.letter_no is not null then ecpd.letter_no end end) as postal_number,
                    (case when ecpd.postal_date is not null then ecpd.postal_date else case when ecpd.letter_date is not null then ecpd.letter_date end end) as postal_date,
                  (select postal_type_description from master.ref_postal_type rpt where rpt.id=ecpd.ref_postal_type_id) as postal_type,
                  (case when ept.dispatched_to_user_type='s' then (select section_name from master.usersection where id=ept.dispatched_to) else 
                  case when ept.dispatched_to_user_type = 'o' then (select concat(name,' (',empid,') ') from master.users where usercode=ept.dispatched_to) else 
                  case when ept.dispatched_to_user_type = 'j' then (select jname from master.judge where jcode=ept.dispatched_to) else ecpd.postal_addressee end end end) as address_to
                  ,ec.diary_no as diary_number,ec.reg_no_display,
                 (select concat(name ,'(',empid,')') from master.users where usercode=ept.dispatched_by) as dispatched_by,ept.dispatched_on,
                 (select concat(name ,'(',empid,')') from master.users where usercode=ept.action_taken_by) as action_taken_by,ept.action_taken_on,ept.action_taken,ept.is_forwarded,
       (case when ept.letterPriority='0' THEN 'Normal' else case when ept.letterPriority='1' THEN 'Urgent But Not Important' 
           else case  when ept.letterPriority='2' THEN 'Important But Not Urgent' else case when ept.letterPriority='3' THEN 'Urgent And Important' END END END END) as letterPriority");

            $builder->join('main ec', 'ecpd.ec_case_id=ec.diary_no', 'LEFT');
            $builder->join('ec_postal_transactions ept', 'ecpd.id=ept.ec_postal_received_id', 'LEFT');
            $builder->join('ec_postal_dispatch epd', 'ecpd.ec_postal_dispatch_id=epd.id', 'LEFT');

            $builder->where("(ept.is_active='t' or ept.is_active is null) and ecpd.is_deleted='f' and ept.dispatched_by is not null and CAST(ept.dispatched_by as text) !=''");
            $builder->where("$whereCondition $dateCondition");

            $builder->orderBy("ecpd.diary_no");
        } else {

            $builder = $this->db->table('ec_postal_received ecpd');
            $builder->select("ecpd.is_ad_card,ecpd.ec_postal_dispatch_id,epd.is_with_process_id,epd.process_id,epd.process_id_year,epd.reference_number,
        (select name from master.tw_serve where serve_stage=epd.serve_stage and serve_type=0) as serve_stage,
        (select name from master.tw_serve where id=epd.tw_serve_id) as serve_type,epd.serve_remarks,
        ept.id as ec_postal_transactions_id,ecpd.id,ecpd.ec_case_id,ecpd.sender_name,ecpd.address,concat(ecpd.diary_no,'/',ecpd.diary_year) as diary,ecpd.remarks,
        ecpd.subject,(case when ecpd.postal_no is not null then ecpd.postal_no else case when ecpd.letter_no is not null then ecpd.letter_no end end) as postal_number,
        (case when ecpd.postal_date is not null then ecpd.postal_date else case when ecpd.letter_date is not null then ecpd.letter_date end end) as postal_date,
        (select postal_type_description from master.ref_postal_type rpt where rpt.id=ecpd.ref_postal_type_id) as postal_type,
        (case when ept.dispatched_to_user_type='s' then (select section_name from master.usersection where id=ept.dispatched_to) else 
        case when ept.dispatched_to_user_type = 'o' then (select concat(name,' (',empid,') ') from master.users where usercode=ept.dispatched_to) else 
        case when ept.dispatched_to_user_type = 'j' then (select jname from master.judge where jcode=ept.dispatched_to) else ecpd.postal_addressee end end end) as address_to
        ,ec.diary_no as diary_number,ec.reg_no_display,
        (select concat(name ,'(',empid,')') from master.users where usercode=ept.dispatched_by) as dispatched_by,ept.dispatched_on,
        (select concat(name ,'(',empid,')') from master.users where usercode=ept.action_taken_by) as action_taken_by,ept.action_taken_on,ept.action_taken,ept.is_forwarded,
        (case when ept.letterPriority='0' THEN 'Normal' else case when ept.letterPriority='1' THEN 'Urgent But Not Important' else case  when ept.letterPriority='2' THEN 'Important But Not Urgent' else case when ept.letterPriority='3' THEN 'Urgent And Important' END END END END) as letterPriority ");

            $builder->join('main ec', 'ecpd.ec_case_id=ec.diary_no', 'LEFT');
            $builder->join('ec_postal_transactions ept', 'ecpd.id=ept.ec_postal_received_id', 'LEFT');
            $builder->join('ec_postal_dispatch epd', 'ecpd.ec_postal_dispatch_id=epd.id', 'LEFT');

            $builder->where("(ept.is_active='t' or ept.is_active is null) and ecpd.is_deleted='f' and ept.dispatched_by is not null and CAST(ept.dispatched_by as text) !=''");
            $builder->where("$whereCondition $dateCondition");
            $builder->where("((ept.dispatched_to_user_type='s' and ept.dispatched_to=$section) or (ept.dispatched_to_user_type='o' and ept.dispatched_to=$usercode)) ");
            $builder->orderBy("ecpd.diary_no");
        }

        $query = $builder->get();

        $result = $query->getResultArray();
        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }



    function getInitiatedDakDataForReceive($usercode, $section, $status = "", $actionType = "", $fromDate = "", $toDate = "")
    {
        $whereCondition = "";
        $dateCondition = "";
        if ($status == 'P') {
            $whereCondition = " (ept.action_taken is null or ept.action_taken=0 or cast(ept.action_taken_by as text)='')";
        } elseif ($status = 'R') {
            if ($actionType == 1) {
                $whereCondition = "and ept.action_taken=$actionType and (ept.action_taken_on is not null or ept.action_taken_on!='')";
            }
        }
        if ($fromDate != "" && $toDate != "") {
            $dateCondition = " and date(ept.action_taken_on) between $fromDate and $toDate";
        }
        $sql = "";
        $usercode = 2;

        if ($usercode == 1) {
            $builder = $this->db->table('ec_postal_user_initiated_letter ecpd');
            $builder->select("ecpd.id, ecpd.letter_no as letter_number,
                    ecpd.letter_subject as subject, ept.id as ec_postal_transactions_id, (case when ept.dispatched_to_user_type='s' then (select section_name from master.usersection where id=ept.dispatched_to) else 
                  case when ept.dispatched_to_user_type = 'o' then (select concat(name,' (',empid,') ') from master.users where usercode=ept.dispatched_to) else 
                  case when ept.dispatched_to_user_type = 'j' then (select jname from master.judge where jcode=ept.dispatched_to) end end end) as address_to,
                 (select concat(name ,'(',empid,')') from master.users where usercode=ept.dispatched_by) as dispatched_by,ept.dispatched_on,
                 (select concat(name ,'(',empid,')') from master.users where usercode=ept.action_taken_by) as action_taken_by,ept.action_taken_on,ept.action_taken,
                 ept.is_forwarded,
                 (case when ept.letterPriority='0' THEN 'Normal' else case when ept.letterPriority='1' THEN 'Urgent But Not Important' else 
                 case  when ept.letterPriority='2' THEN 'Important But Not Urgent' else case when ept.letterPriority='3' THEN 'Urgent And Important' END END END END) as letterPriority ");


            $builder->join('ec_postal_transactions ept', 'ecpd.id=ept.ec_postal_user_initiated_letter_id', 'LEFT');
            $builder->where("(ept.is_active='t' or ept.is_active is null) and ecpd.is_deleted='f' and ept.dispatched_by is not null and CAST(ept.dispatched_by as text) !=''");
            $builder->where("$whereCondition $dateCondition");
            $builder->orderBy("ecpd.id", "DESC");
        } else {

            $builder = $this->db->table('ec_postal_user_initiated_letter ecpd');
            $builder->select("ecpd.id, ecpd.letter_no as letter_number,
                    ecpd.letter_subject as subject, ept.id as ec_postal_transactions_id, 
                    (case when ept.dispatched_to_user_type='s' then (select section_name from master.usersection where id=ept.dispatched_to) else 
                  case when ept.dispatched_to_user_type = 'o' then (select concat(name,' (',empid,') ') from master.users where usercode=ept.dispatched_to) else 
                  case when ept.dispatched_to_user_type = 'j' then (select jname from master.judge where jcode=ept.dispatched_to) end end end) as address_to,
                 (select concat(name ,'(',empid,')') from master.users where usercode=ept.dispatched_by) as dispatched_by,ept.dispatched_on,
                 (select concat(name ,'(',empid,')') from master.users where usercode=ept.action_taken_by) as action_taken_by,ept.action_taken_on,ept.action_taken,
       ept.is_forwarded,
       (case when ept.letterPriority='0' THEN 'Normal' else case when ept.letterPriority='1' THEN 'Urgent But Not Important' else 
           case  when ept.letterPriority='2' THEN 'Important But Not Urgent' else case when ept.letterPriority='3' THEN 'Urgent And Important' END END END END) as letterPriority ");
            $builder->join('ec_postal_transactions ept', 'ecpd.id=ept.ec_postal_user_initiated_letter_id', 'LEFT');
            $builder->where("(ept.is_active='t' or ept.is_active is null) and ecpd.is_deleted='f' and ept.dispatched_by is not null and cast(ept.dispatched_by as text) !=''");
            $builder->where("$whereCondition $dateCondition");
            $builder->where("((ept.dispatched_to_user_type='s' and ept.dispatched_to=$section) or (ept.dispatched_to_user_type='o' and ept.dispatched_to=$usercode))");
            $builder->orderBy("ecpd.id", "DESC");
        }

        $query = $builder->get();

        $result = $query->getResultArray();


        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }

    function getOfficersListBySection($dealingSection)
    {

        $builder = $this->db->table('master.usersection us');
        $builder->select('nm.registrar, nm.additional_registrar, nm.deputy_registrar, nm.assistant_registrar, nm.branch_officer');
        $builder->join('master.notice_mapping nm', 'us.id=nm.section_id', 'INNER');
        $builder->where("nm.section_id", $dealingSection);
        $builder->where("us.display", 'Y');

        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return [];
        }
    }

    function getSectionNameBySection($section)
    {
        $builder = $this->db->table('master.usersection us');
        $builder->select('section_name');
        $builder->where('id', $section);

        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return [];
        }

    }

    public function getSecretaryGeneral()
{
    $db = \Config\Database::connect();
    $builder = $db->table('master.users');
    $builder->select('master.users.empid');
    $builder->join('master.usertype', 'master.users.usertype = master.usertype.id', 'inner');
    $builder->where("master.usertype.type_name like '%SECRETARY GENERAL%'");
    
    $query = $builder->get();
    $sql = $db->getLastQuery();
    echo (string)$sql;
    exit();

    $result = $query->getResultArray();

    if ($query->getNumRows() >= 1) {
        return $result;
    } else {
        return [];
    }
}




    function getImagesForTransactionId($id)
    {
        $builder = $this->db->table('ec_forward_letter_postal_transactions eflpt');
        $builder->select('efli.id,efli.file_display_name,efli.file_path,efli.file_name ');
        $builder->where("eflpt.transactions_id", $id);
        $builder->join('ec_forward_letter_images efli', 'eflpt.image_id = efli.id', 'INNER');
        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return [];
        }
    }

    function getDakTransactionDetails($ecPostalTransaction_id)
    {
        $builder = $this->db->table('ec_postal_transactions');
        $builder->select('*');
        $builder->where("id", $ecPostalTransaction_id);
        $query = $builder->get();
       $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return [];
        }
    }

    public function doReceiveDakForSection($id, $actionType, $usercode, $returnReason, $letterPriority, $officer)
    {
        $id = explode('#', $id);
       
        $ecPostalTransaction_id = $id[1];
        $isADCard = $id[2];
        $ecPostalDispatchId = $id[3];
    
        if ($actionType == 1) {
            $ecPostalReceivedId = $id[0];
            $data = [
                'action_taken' => $actionType,
                'action_taken_by' => $usercode,
                'action_taken_on' => date('Y-m-d H:i:s'),
                'last_updated_on' => date('Y-m-d H:i:s'),
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $usercode,
                'updated_by_ip' => $this->request->getIPAddress()
            ];
            $builder = $this->db->table('ec_postal_transactions');
            $builder->where('ec_postal_received_id', $ecPostalReceivedId)->where('is_active', 't')->where('is_deleted', 'f');
            $builder->update($data);
        } elseif ($actionType == 3) {
            $ecPostalReceivedId = $id[0];
            $data = [
                'action_taken' => $actionType,
                'action_taken_by' => $usercode,
                'action_taken_on' => date('Y-m-d H:i:s'),
                'last_updated_on' => date('Y-m-d H:i:s'),
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $usercode,
                'updated_by_ip' => $this->request->getIPAddress()
            ];
            $builder = $this->db->table('ec_postal_transactions');
            $builder->where('ec_postal_received_id', $ecPostalReceivedId)->where('is_active', 't')->where('is_deleted', 'f');
            $builder->update($data);
    
            $this->saveForwardedDak($ecPostalReceivedId, "", $letterPriority, $officer);
        } elseif ($actionType == 2) {
            $ecPostalReceivedId = $id[0];
            $data = [
                'action_taken' => $actionType,
                'action_taken_by' => $usercode,
                'return_reason' => $returnReason,
                'action_taken_on' => date('Y-m-d H:i:s'),
                'last_updated_on' => date('Y-m-d H:i:s'),
                'is_active' => 'f',
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $usercode,
                'updated_by_ip' => $this->request->getIPAddress()
            ];
            $builder = $this->db->table('ec_postal_transactions');
            $builder->where('ec_postal_received_id', $ecPostalReceivedId)->where('is_active', 't')->where('is_deleted', 'f');
            $builder->update($data);
    
            $data = [
                'ec_postal_received_id' => $ecPostalReceivedId,
                'dispatched_to_user_type' => 's',
                'dispatched_to' => 68, 
                'dispatched_by' => $usercode,
                'dispatched_on' => date('Y-m-d H:i:s'),
                'is_active' => 't',
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $usercode,
                'updated_by_ip' => $this->request->getIPAddress()
            ];
            $this->db->table('ec_postal_transactions')->insert($data);
        }
    
        if ($isADCard == 1) {
            $dataForDispatch = [
                'ref_letter_status_id' => 8,
                'usercode' => $usercode,
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $usercode,
                'updated_by_ip' => $this->request->getIPAddress()
            ];
            $this->db->table('ec_postal_dispatch')->where('id', $ecPostalDispatchId)->update($dataForDispatch);
    
            if ($this->db->affectedRows() > 0) {
                $dataForDispatchTransactions = [
                    'ec_postal_dispatch_id' => $ecPostalDispatchId,
                    'ref_letter_status_id' => 8,
                    'usercode' => $usercode,
                    'create_modify' => date("Y-m-d H:i:s"),
                    'updated_on' => date("Y-m-d H:i:s"),
                    'updated_by' => $usercode,
                    'updated_by_ip' => $this->request->getIPAddress()
                ];
                $this->db->table('ec_postal_dispatch_transactions')->insert($dataForDispatchTransactions);
            }
        }
    
        return $this->db->affectedRows();
    }
    

    public function doReceiveForwardableDakForSection($id, $actionType, $usercode, $returnReason, $ec_postal_user_initiated_letter_id, $dispatchedBy, $letterPriority, $officer)
    {
        $id = explode('#', $id);
        $ecPostalTransaction_id = $id[1];
        $isADCard = $id[2];
        $ecPostalDispatchId = $id[3];
        $ecPostalReceivedId = 0;
        
        if (!($ec_postal_user_initiated_letter_id > 0)) {
            $ecPostalReceivedId = $id[0];
        }
    
        if ($actionType == 1) {
            $data = [
                'action_taken' => $actionType,
                'action_taken_by' => $usercode,
                'action_taken_on' => date('Y-m-d H:i:s'),
                'last_updated_on' => date('Y-m-d H:i:s'),
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => session()->get('login')['usercode'],
                'updated_by_ip' => $this->request->getIPAddress()
            ];
    
            $builder = $this->db->table('ec_postal_transactions');
            
            if ($ec_postal_user_initiated_letter_id > 0) {
                $builder->where('ec_postal_user_initiated_letter_id', $ec_postal_user_initiated_letter_id);
            } else {
                $builder->where('ec_postal_received_id', $ecPostalReceivedId);
            }
            
            $builder->where('is_active', 't')->where('is_deleted', 'f')->update($data);
        } elseif ($actionType == 3) {
            $data = [
                'action_taken' => $actionType,
                'action_taken_by' => $usercode,
                'action_taken_on' => date('Y-m-d H:i:s'),
                'last_updated_on' => date('Y-m-d H:i:s'),
                'is_active' => 'f',
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => session()->get('login')['usercode'],
                'updated_by_ip' => $this->request->getIPAddress()
            ];
    
            $builder = $this->db->table('ec_postal_transactions');
    
            if ($ec_postal_user_initiated_letter_id > 0) {
                $builder->where('ec_postal_user_initiated_letter_id', $ec_postal_user_initiated_letter_id);
            } else {
                $builder->where('ec_postal_received_id', $ecPostalReceivedId);
            }
            
            $builder->where('is_active', 't')->where('is_deleted', 'f')->update($data);
            
            $forwardedDakInsertId = $this->saveForwardedDak($ecPostalReceivedId, $ec_postal_user_initiated_letter_id, $letterPriority, $officer);
            
            if ($forwardedDakInsertId > 0) {
                $this->updateForwardedImages($ecPostalTransaction_id, $forwardedDakInsertId);
            }
        } elseif ($actionType == 2) {
            $data = [
                'action_taken' => $actionType,
                'action_taken_by' => $usercode,
                'return_reason' => $returnReason,
                'action_taken_on' => date('Y-m-d H:i:s'),
                'last_updated_on' => date('Y-m-d H:i:s'),
                'is_active' => 'f',
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => session()->get('login')['usercode'],
                'updated_by_ip' => $this->request->getIPAddress()
            ];
    
            $dispatched_to_user_type = 'o';
            $dispatchersCode = $dispatchedBy;
    
            $builder = $this->db->table('ec_postal_transactions');
            
            if ($ec_postal_user_initiated_letter_id > 0) {
                $builder->where('ec_postal_user_initiated_letter_id', $ec_postal_user_initiated_letter_id);
            } else {
                $builder->where('ec_postal_received_id', $ecPostalReceivedId);
            }
    
            $builder->where('is_active', 't')->where('is_deleted', 'f')->update($data);
    
            $data = [
                'ec_postal_received_id' => $ecPostalReceivedId,
                'ec_postal_user_initiated_letter_id' => $ec_postal_user_initiated_letter_id,
                'dispatched_to_user_type' => $dispatched_to_user_type,
                'dispatched_to' => $dispatchersCode,
                'dispatched_by' => $usercode,
                'dispatched_on' => date('Y-m-d H:i:s'),
                'is_active' => 't',
                'is_forwarded' => 't',
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => session()->get('login')['usercode'],
                'updated_by_ip' => $this->request->getIPAddress()
            ];
    
            $this->db->table('ec_postal_transactions')->insert($data);
            
            $insertId = $this->db->insertID();
    
            if ($insertId > 0) {
                $this->updateForwardedImages($ecPostalTransaction_id, $insertId);
            }
        }
    
        if ($isADCard == 1) {
            $dataForDispatch = [
                'ref_letter_status_id' => 8, // 8 for AD/Letter Received by Section/Concerned
                'usercode' => $usercode,
                'updated_on' => date('Y-m-d H:i:s'),
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_by' => session()->get('login')['usercode'],
                'updated_by_ip' => $this->request->getIPAddress()
            ];
    
            $builder = $this->db->table('ec_postal_dispatch');
            $builder->where('id', $ecPostalDispatchId);
            $builder->update($dataForDispatch);
    
            $dataForDispatchTransactions = [
                'ec_postal_dispatch_id' => $ecPostalDispatchId,
                'ref_letter_status_id' => 8,
                'usercode' => $usercode,
                'updated_on' => date('Y-m-d H:i:s'),
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_by' => session()->get('login')['usercode'],
                'updated_by_ip' => $this->request->getIPAddress()
            ];
    
            $builder = $this->db->table('ec_postal_dispatch_transactions');
            $builder->insert($dataForDispatchTransactions);
        }
    }
    


    function getReceivedBySectionDak($ids)
    {
        //print_r($ids);
        $ecPostalReceivedId = [];
        $ecPostalTransactionId = [];
        foreach ($ids as $id) {
            $id = explode('#', $id);
            $ecPostalReceivedId[] = $id[0];
            $ecPostalTransactionId[] = $id[1];
        }
        $sql = "select ecpd.id,ecpd.ec_case_id,sender_name,address,concat(ecpd.diary_no,'/',ecpd.diary_year) as diary,ecpd.remarks,
              ecpd.subject,case when postal_no is not null then postal_no else case when letter_no is not null then letter_no end end as postal_number,
              case when postal_date is not null then postal_date else case when letter_date is not null then letter_date end end as postal_date,
              (select postal_type_description from master.ref_postal_type rpt where rpt.id=ref_postal_type_id) as postal_type,
              (case when ept.dispatched_to_user_type='s' then (select section_name from master.usersection where id=ept.dispatched_to) else 
              case when ept.dispatched_to_user_type = 'o' then (select concat(name,' (',empid,') ') from master.users where usercode=ept.dispatched_to) else 
              case when ept.dispatched_to_user_type = 'j' then (select jname from master.judge where jcode=ept.dispatched_to) else ecpd.postal_addressee end end end) as address_to
              ,ec.diary_no as diary_number,ec.reg_no_display,
              (select concat(name ,'(',empid,')') from master.users where usercode=dispatched_by) as dispatched_by,dispatched_on,
              (select concat(name ,'(',empid,')') from master.users where usercode=ept.action_taken_by) as action_taken_by,ept.action_taken_on,ept.is_forwarded,
              case when ept.action_taken=1 then 'Received' else case when ept.action_taken=2 then 'Returned' else case when ept.action_taken=3 then 'Forwarded' else '' end end end as action_taken,ept.return_reason
              from ec_postal_received ecpd left join main ec on ecpd.ec_case_id=ec.diary_no
              left join ec_postal_transactions ept on ecpd.id=ept.ec_postal_received_id
              where ept.id in (" . implode(',', $ecPostalTransactionId) . ") and ecpd.is_deleted=? order by ecpd.diary_no";
        $query = $this->db->query($sql, array('f'));
        //        $this->db->last_query();exit;
        if ($query->getNumRows() >= 1) {
            //            print_r($query->getResultArray());die;
            $result = $query->getResultArray();
            return $result;
        } else {
            return 0;
        }
    }

    function getInitiatedReceivedBySectionDak($ids)
    {
        //print_r($ids);
        $ecPostalReceivedId = [];
        $ecPostalTransactionId = [];
        foreach ($ids as $id) {
            $id = explode('#', $id);
            $ecPostalReceivedId[] = $id[0];
            $ecPostalTransactionId[] = $id[1];
        }
        $sql = "select ecpd.id,ecpd.letter_no,
              ecpd.letter_subject,
              (case when ept.dispatched_to_user_type='s' then (select section_name from master.usersection where id=ept.dispatched_to) else 
              case when ept.dispatched_to_user_type = 'o' then (select concat(name,' (',empid,') ') from master.users where usercode=ept.dispatched_to) else 
              case when ept.dispatched_to_user_type = 'j' then (select jname from master.judge where jcode=ept.dispatched_to) end end end) as address_to,
              (select concat(name ,'(',empid,')') from master.users where usercode=dispatched_by) as dispatched_by,dispatched_on,
              (select concat(name ,'(',empid,')') from master.users where usercode=ept.action_taken_by) as action_taken_by,ept.action_taken_on,ept.is_forwarded,
              case when ept.action_taken=1 then 'Received' else case when ept.action_taken=2 then 'Returned' else case when ept.action_taken=3 then 'Forwarded' else '' end end end as action_taken,ept.return_reason
              from ec_postal_user_initiated_letter ecpd left join ec_postal_transactions ept on ecpd.id=ept.ec_postal_user_initiated_letter_id
              where ept.id in (" . implode(',', $ecPostalTransactionId) . ") and ecpd.is_deleted=? order by ecpd.id DESC";
        $query = $this->db->query($sql, array('f'));
        //        echo $query->getNumRows();die;
        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return $result;
        } else {
            return 0;
        }
    }

    function updateForwardedImages($ecPostalTransaction_id, $forwardedDakInsertId)
    {

        $builder = $this->db->table('ec_forward_letter_postal_transactions');
        $builder->select('image_id');
        $builder->where("transactions_id", $ecPostalTransaction_id);
        $query = $builder->get();
        //        $query=$this->db->getLastQuery();echo (string) $query;exit();

        if ($query->getNumRows() >= 1) {
            $data["imageids"] = $query->getResultArray();

            foreach ($data["imageids"] as $datum) {
                $image_id = $datum['image_id'];
                $columnInsertData = array(
                    'transactions_id' => $forwardedDakInsertId,
                    'image_id' => $image_id,
                    'updated_on' => date('Y-m-d H:i:s'),
                    'create_modify' => date("Y-m-d H:i:s"),
                    'updated_by' => session()->get('login')['usercode'],
                    'updated_by_ip' => getClientIP()

                );

                $builder = $this->db->table('ec_forward_letter_postal_transactions');

                $query = $builder->insert($columnInsertData);
            }
        } else {
            return [];
        }
    }


    public function saveForwardedDak($ecPostalReceivedId, $initiatedDakInsertId, $letterPriority, $officer)
{
    $usercode = session()->get('login')['usercode'];
    $dispatched_to_user_type = 'o';
    $dispatched_to = $officer;
    $dispatched_on = date('Y-m-d H:i:s');

    if (!empty($ecPostalReceivedId)) {
        $queryUpdateInactive = "UPDATE ec_postal_transactions SET is_active = 'f' WHERE ec_postal_received_id = ?";
        $this->db->query($queryUpdateInactive, [$ecPostalReceivedId]);

        $data = [
            'ec_postal_received_id' => $ecPostalReceivedId,
            'dispatched_to_user_type' => $dispatched_to_user_type,
            'dispatched_to' => $dispatched_to,
            'dispatched_by' => $usercode,
            'dispatched_on' => $dispatched_on,
            'is_forwarded' => 't',
            'is_active' => 't',
            'letterPriority' => $letterPriority
        ];
    } elseif (!empty($initiatedDakInsertId)) {
        $queryUpdateInactive = "UPDATE ec_postal_transactions SET is_active = 'f' WHERE ec_postal_user_initiated_letter_id = ?";
        $this->db->query($queryUpdateInactive, [$initiatedDakInsertId]);

        $data = [
            'ec_postal_user_initiated_letter_id' => $initiatedDakInsertId,
            'dispatched_to_user_type' => $dispatched_to_user_type,
            'dispatched_to' => $dispatched_to,
            'dispatched_by' => $usercode,
            'dispatched_on' => $dispatched_on,
            'is_forwarded' => 't',
            'is_active' => 't',
            'letterPriority' => $letterPriority
        ];
    }

    $this->sendForwardedLetterIntimationSMS($letterPriority, $officer);
    $this->db->table('ec_postal_transactions')->insert($data);

    return $this->db->insertID();
}


    function sendForwardedLetterIntimationSMS($receivingUser, $letterPriority = 0)
    {
        $toMobile = '';
        $priorityText = '';
        if ($letterPriority == 0) {
            $priorityText = 'A letter';
        } elseif ($letterPriority == 1) {
            $priorityText = 'An Urgent But Not Important letter';
        } elseif ($letterPriority == 2) {
            $priorityText = 'An Important But Not Urgent letter';
        } elseif ($letterPriority == 3) {
            $priorityText = 'An Urgent And Important letter';
        }
        $SMSText = $priorityText . ' has been forwarded to you internally. Please login to RnI section in ICMIS to check for details';

        $receiving_employee_details_url = 'http://10.25.78.92:81/services/employee_details.php?employeeId=' . $receivingUser;
        $json = file_get_contents($receiving_employee_details_url);
        $obj = json_decode($json, true);

        $tmpArr = array();
        foreach ($obj as $sub) {
            $tmpArr[] = $sub['mobileNumbers'];
        }

        $mobile_numbers = implode(',', $tmpArr);

        if ($mobile_numbers == null or $mobile_numbers == '') {
            return;
        } else {
            $toMobile = $mobile_numbers;
        }
        $sms_text = rawurlencode($SMSText);
      

        $sms_url = 'http://10.25.78.60/eAdminSCI/a-push-sms-gw?mobileNos=' . $toMobile . '&message=' . $sms_text . '&typeId=30&myUserId=NIC001001&myAccessId=root';

        $sms_response = file_get_contents($sms_url);
        $json = json_decode($sms_response);
        if ($json->{'responseFlag'} == "success") {
         $this->insert_ForwardedSMSLogs($toMobile, $sms_text, $receivingUser, 'Success');
        } else {
            $this->insert_ForwardedSMSLogs($toMobile, $sms_text, $receivingUser, 'Error');
        }
    }

    public function insert_SMSLogs($toMobile, $smsText, $userId, $sendStatus)
    {
        $updatedFromSystem = $_SERVER['REMOTE_ADDR'];
        $data = [
            'mobile' => $toMobile,
            'msg' => rawurldecode($smsText),
            'send_by' => $userId,
            'send_date_time' => date('Y-m-d H:i:s'),
            'ip_address' => $updatedFromSystem,
            'send_status' => $sendStatus
        ];
    
        $builder = $this->db->table('paper_book_sms_log');
        $builder->insert($data);
        
        // Check if the insert was successful
        if ($builder->affectedRows() > 0) {
            return true; // or return $builder->insertID(); if you need the inserted ID
        } else {
            return false;
        }
    }
    
    



    /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> END Received DAK REPORT FUNCTION<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  */


    /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> ECOPY FUNCTION<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  */

    function get_envelope_data()
    {
        $builder = $this->db->table('post_bar_code_mapping p');
        $builder->select('p.envelope_weight, p.barcode, p.consumed_on, c.application_receipt, c.postal_fee, name, mobile, address, application_number_display, crn, email');
        $builder->join('copying_order_issuing_application_new c', 'p.copying_application_id = c.id', 'INNER');
        $builder->join('post_envelope_movement e', "e.barcode = p.barcode and e.display = 'Y'", 'LEFT');
        $builder->where("e.id is null and p.is_consumed = '1' and p.is_deleted = '0'");
        $builder->orderBy('p.ent_time');
        $query = $builder->get();
        //        $query=$this->db->getLastQuery();echo (string) $query;exit();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return false;
        }
    }


    function envelope_receive_data($barcode, $usercode, $section)
    {
        if (strlen(trim($_POST['barcode'])) >= 12) {

            $data = array(
                'barcode' => $barcode,
                'received_section' => $usercode,
                'received_by' => $section,
                'received_on' => date('Y-m-d H:i:s'),
                'updated_on' => date('Y-m-d H:i:s'),
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_by' => $usercode,
                'updated_by_ip' => getClientIP()

            );
            $builder = $this->db->table('post_envelope_movement');
            $query = $builder->insert($data);
            if ($query) {
                $return_arr = array("status" => "success");
            } else {
                $return_arr = array("status" => "Error:Not Saved");
            }
        } else {
            $return_arr = array("status" => "Error:Valid Barcode Required");
        }
        return $return_arr;
    }


    function envelope_report_data($from_date, $to_date)
    {
        $builder = $this->db->table('post_bar_code_mapping p');
        $builder->select('p.envelope_weight, p.barcode, p.consumed_on, c.application_receipt, c.postal_fee, c.name, c.mobile, c.address, c.application_number_display,
         c.crn, c.email, u.name as username, u.empid, e.received_on');
        $builder->join('copying_order_issuing_application_new c', 'p.copying_application_id = c.id', 'INNER');
        $builder->join('post_envelope_movement e', "e.barcode = p.barcode and e.display = 'Y'", 'INNER');
        $builder->join('master.users u', 'u.usercode = e.received_by', 'inner');
        $builder->where("p.is_consumed = '1' and p.is_deleted = '0' and date(e.received_on) between '$from_date' and '$to_date' ");
        $builder->orderBy("e.received_on");
        $query = $builder->get();
        $result = $query->getResultArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return [];
        }
    }
}
