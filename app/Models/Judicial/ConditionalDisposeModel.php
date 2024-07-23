<?php
namespace App\Models\Judicial;
use CodeIgniter\Model;

class ConditionalDisposeModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->db = db_connect();
    }

    function case_types()
    {
        $builder2 = $this->db->table("master.casetype");
        $builder2->select("*");
        $builder2->where('casecode !=', '9999');
        $builder2->where('is_deleted', 'f');
        $builder2->orderBy('casecode', 'ASC');
        $query2 = $builder2->get();
        $result = $query2->getResultArray();
        return $result;
    }

    // function get_prev_cases($usercode)
    // {
    //     $sql = "SELECT 
    //     CASE WHEN (r.conn_key IS NULL or r.conn_key::text = '0')  THEN r.fil_no ELSE r.conn_key END AS listafter,
    //     m.reg_no_display AS reg_no_after,
    //     CONCAT(m.pet_name, ' Vs ', m.res_name) AS title_after,
    //     CONCAT(m2.pet_name, ' Vs ', m2.res_name) AS title_first,
    //     CASE WHEN r.conn_key IS NOT NULL THEN STRING_AGG(r.fil_no::text, ',') ELSE '' END AS connected,
    //     r.fil_no2 AS disposefirst,
    //     m2.reg_no_display AS reg_no_first,
    //     r.ent_dt,
    //     u.name AS user_after,
    //     us.section_name AS section_after,
    //     u2.name AS user_first,
    //     us2.section_name AS section_first, rgo_updated_by 
    //     FROM 
    //         rgo_default r 
    //     LEFT JOIN 
    //         main m ON CASE WHEN (r.conn_key IS NULL or r.conn_key::text = '0') THEN r.fil_no ELSE r.conn_key END = m.diary_no 
    //     LEFT JOIN 
    //         main m2 ON r.fil_no2 = m2.diary_no 
    //     LEFT JOIN 
    //         master.users u ON m.dacode = u.usercode 
    //     LEFT JOIN 
    //         master.usersection us ON u.section = us.id 
    //     LEFT JOIN 
    //         master.users u2 ON m2.dacode = u2.usercode 
    //     LEFT JOIN 
    //         master.usersection us2 ON u2.section = us2.id 
    //     WHERE 
    //         rgo_updated_by = '$usercode' 
    //         --AND remove_def = 'N' 
    //     GROUP BY 
    //         r.conn_key, m.reg_no_display, m.pet_name, m.res_name, m2.pet_name, m2.res_name, r.fil_no2, m2.reg_no_display, r.ent_dt, u.name, us.section_name, u2.name, us2.section_name, r.fil_no, rgo_updated_by";

    //     $result_party = $this->db->query($sql);
    //     $res = $result_party->getResultArray();
    //     if(count($res) >= 1){
    //         return $res;
    //     }else{
    //         return false;
    //     }
    // }

    public function get_prev_cases($usercode)
    {
        $builder = $this->db->table('rgo_default r')
            ->select("CASE WHEN (r.conn_key IS NULL or r.conn_key::text = '0') THEN r.fil_no ELSE r.conn_key END AS listafter,
                m.reg_no_display AS reg_no_after,
                CONCAT(m.pet_name, ' Vs ', m.res_name) AS title_after,
                CONCAT(m2.pet_name, ' Vs ', m2.res_name) AS title_first,
                CASE WHEN r.conn_key IS NOT NULL THEN STRING_AGG(r.fil_no::text, ',') ELSE '' END AS connected,
                r.fil_no2 AS disposefirst,
                m2.reg_no_display AS reg_no_first,
                r.ent_dt,
                u.name AS user_after,
                us.section_name AS section_after,
                u2.name AS user_first,
                us2.section_name AS section_first, 
                rgo_updated_by")
            ->join('main m', "CASE WHEN (r.conn_key IS NULL or r.conn_key::text = '0') THEN r.fil_no ELSE r.conn_key END = m.diary_no", 'left')
            ->join('main m2', 'r.fil_no2 = m2.diary_no', 'left')
            ->join('master.users u', 'm.dacode = u.usercode', 'left')
            ->join('master.usersection us', 'u.section = us.id', 'left')
            ->join('master.users u2', 'm2.dacode = u2.usercode', 'left')
            ->join('master.usersection us2', 'u2.section = us2.id', 'left')
            ->where('rgo_updated_by', $usercode)
            ->groupBy('r.conn_key, m.reg_no_display, m.pet_name, m.res_name, m2.pet_name, m2.res_name, r.fil_no2, m2.reg_no_display, r.ent_dt, u.name, us.section_name, u2.name, us2.section_name, r.fil_no, rgo_updated_by');

        $query = $builder->get();
        $res = $query->getResultArray();

        return (count($res) >= 1) ? $res : false;
    }


    function get_case_details($case_type_list=0,$case_number_list=0,$case_year_list=0,$diary_number_list=0,$diary_year_list=0
    ,$case_type_disp=0,$case_number_disp=0,$case_year_disp=0,$diary_number_disp=0,$diary_year_disp=0)
    {
         $builder2 = $this->db->table("main m");
        $builder2->select("m.diary_no as case_diary, m.c_status, concat(m.pet_name,' Vs ',m.res_name) as case_title,dacode");

        if(($case_type_list!=0 && $case_type_list!='' ) && ($case_number_list!=0 && $case_number_list!='') && ($case_year_list!==0 && $case_year_list!='')){
            $builder2->where("CAST(SUBSTRING(active_fil_no, 1, 2) AS INTEGER)", $case_type_list);
            $builder2->where('active_reg_year', $case_year_list);
            $builder2->groupStart();
            $builder2->where("CAST(SUBSTRING(active_fil_no, 4, 6) AS INTEGER)", $case_number_list);
            $builder2->orWhere("$case_number_list BETWEEN CAST(SUBSTRING(active_fil_no, 4, 6) AS INTEGER) AND CAST(SUBSTRING(active_fil_no, 11, 6) AS INTEGER)", null, false);
            $builder2->groupEnd();
            
        }
        else if(($diary_number_list!=0 && $diary_number_list!='') && ($diary_year_list!=0 && $diary_year_list!='')){
            $builder2->where("m.diary_no", $diary_number_list.$diary_year_list);
        }
        else if(($case_type_disp!=0 && $case_type_disp!='') && ($case_number_disp!=0 && $case_number_disp!='') && ($case_year_disp!=0 && $case_year_disp!='')){
             $builder2->where("CAST(SUBSTRING(active_fil_no, 1, 2) AS INTEGER)", $case_type_disp);
            $builder2->where('active_reg_year', $case_year_disp);
            $builder2->groupStart();
                $builder2->where("CAST(SUBSTRING(active_fil_no, 4, 6) AS INTEGER)", $case_number_disp);
                $builder2->orWhere("$case_number_disp BETWEEN CAST(SUBSTRING(active_fil_no, 4, 6) AS INTEGER) AND CAST(SUBSTRING(active_fil_no, 11, 6) AS INTEGER)", null, false);
            $builder2->groupEnd();
        }
        else if(($diary_number_disp!=0 && $diary_number_disp!='') && ($diary_year_disp!=0 && $diary_year_disp!='')){
             $builder2->where("m.diary_no", $diary_number_disp.$diary_year_disp);
        }
        $query2 = $builder2->get();
        $result = $query2->getResultArray();
        if(count($result) >= 1){
            return $result;
        }else{
            return false;
        }
    }


    function get_conn_details($diarynumber)
    {
        $builder2 = $this->db->table("main");
        $builder2->select("count(diary_no) as conn");
        $builder2->where('conn_key', $diarynumber);
        $builder2->where("diary_no != conn_key::int");
        $query2 = $builder2->get();
        $result = $query2->getResultArray();

        if(count($result) >= 1){
            return $result;
        }else{
            return false;
        }
    }

    function check_case($list_diary)
    {
        $builder = $this->db->table('rgo_default');
        $builder->where('fil_no', $list_diary);
        $builder->where('remove_def', 'N');
        $builder->orderBy('ent_dt', 'desc');
        $builder->limit(1);
        $query2 = $builder->get();
        $result = $query2->getResultArray();
        
        if(count($result) >= 1){
            return $result;
        }else{
            return false;
        }
    }


    function update_case_HighCourt($list_diary, $dispose_hCourt,$court_type,$connected,$usercode){
        if($this->check_case($list_diary)==true) {
            $subquery = $this->db->table("rgo_default");
            $subquery->select("fil_no,conn_key,reason,fil_no2,remove_def,remove_def_dt,ent_dt,rgo_updated_by,$usercode,now(),hCourt_no,Court_type");
            $subquery->where("fil_no", $list_diary);
            $query =$subquery->get();
            if($query->getNumRows() >= 1) {
                $insertData = $query->getResultArray();
                $sql_history = $this->db->table('rgo_default_history')->insertBatch($insertData);
            }
            $builder1 = $this->db->table('rgo_default');
            $builder1->where('fil_no', $list_diary);
            $sql_delete = $builder1->delete();

        }

        if($court_type=='S') {
            if($connected=='0'){
              
                $data = [
                 
                    'fil_no' => (int) $list_diary,
                    'conn_key' => 0,
                    'reason' => '',
                    'fil_no2' => (int)$dispose_hCourt,
                    'remove_def' => '',
                    'remove_def_dt' => 'NOW()',
                    'ent_dt' => 'NOW()',
                    'rgo_updated_by' => (int)$usercode,
                    'hcourt_no' => '',
                    'court_type' => $court_type,
                    'create_modify' => 'NOW()',
                    'updated_on' => 'NOW()',
                    'updated_by' => (int)$usercode,
                    'updated_by_ip' => ''
                ];                
                $sql = $this->db->table('rgo_default')->insert($data);               
            }
            else{
                $query = $this->db->table('rgo_default');
                $query->select("diary_no, $list_diary, $dispose_hCourt, NOW(), $usercode, $court_type", false);
                $query->from('main');
                $query->where('conn_key', $list_diary);
                $sql= $this->db->query("INSERT INTO rgo_default(fil_no, conn_key, fil_no2, ent_dt, rgo_updated_by, court_type) " . $query->getCompiledSelect());

            }
        }
        else {
            if ($connected == '0'){
              
                $data = [
                    'fil_no' => (int) $list_diary,
                    'conn_key' => 0,
                    'reason' => '',
                    'fil_no2' => (int)$dispose_hCourt,
                    'remove_def' => '',
                    'remove_def_dt' => 'NOW()',
                    'ent_dt' => 'NOW()',
                    'rgo_updated_by' => (int)$usercode,
                    'hcourt_no' => '',
                    'court_type' => $court_type,
                    'create_modify' => 'NOW()',
                    'updated_on' => 'NOW()',
                    'updated_by' => (int)$usercode,
                    'updated_by_ip' => ''
                ];                
                $sql = $this->db->table('rgo_default')->insert($data); 
            }
            else{
                $query = $this->db->table('rgo_default');
                $query->select("diary_no, $list_diary, $dispose_hCourt, NOW(), $usercode, $court_type", false);
                $query->from('main');
                $query->where('conn_key', $list_diary);
                $sql= $this->db->query("INSERT INTO rgo_default(fil_no, conn_key, hCourt_no, ent_dt, rgo_updated_by, court_type) " . $query->getCompiledSelect());
            }
        }
        if($this->check_case($list_diary)==true) {
            if($sql_history < 1){
                echo "Unable to process the Request. Please contact Computer Cell.";
            }
            if($sql_delete < 1){
                echo "Unable to process the Request. Please contact Computer Cell.";
            }
        }
        if($sql >=1 ){
            echo "Case Updated.";
        }else{
            echo "There is some problem. Please contact Computer-Cell.";
        }
    }

    function get_District_State($dstate_id){

        $builder = $this->db->table('master.state');
        $builder->select('id_no as id, name as agency_name');
        $builder->where('state_code', function($subquery) use ($dstate_id) {
            $subquery->select('state_code')
                ->from('master.state')
                ->where('id_no', $dstate_id)
                ->where('display', 'Y');
        });
        $builder->where('display', 'Y');
        $builder->where('sub_dist_code', 0);
        $builder->where('village_code', 0);
        $builder->where('district_code !=', 0);
        $builder->orderBy('name');
        $query2 = $builder->get();
        $result = $query2->getResultArray();

        if(count($result) >= 1){
            return $result;
        }else{
            return false;
        }
    }

    function get_CaseType_Tribunal($state_id){
        $builder = $this->db->table('master.lc_hc_casetype');
        $builder->select('lccasecode,type_sname lccasename');
        $builder->where('display', 'Y');
        $builder->where('cmis_state_id', $state_id);
        $builder->where('type_sname !=', 0);
        $builder->where('ref_agency_code_id !=', 0);
        $builder->orderBy('type_sname');
        $query2 = $builder->get();
        $result = $query2->getResultArray();

        if(count($result) >= 1){
            return $result;
        }else{
            return false;
        }
    }

    function get_HighCourt_State_bench($state_id,$agency_court)
    {
        $builder = $this->db->table('master.ref_agency_code');
        $builder->select('id, agency_name, short_agency_name');
        $builder->where('is_deleted', 'f');
        $builder->where('cmis_state_id', $state_id);
        $builder->where('agency_or_court', $agency_court);
        $query2 = $builder->get();
        $result = $query2->getResultArray();

        if(count($result) >= 1){
            return $result;
        }else{
            return false;
        }
    }

    function get_CaseType_State_bench($state_id, $court_type)
    {


        $builder = $this->db->table('master.lc_hc_casetype');
        $builder->select('lccasecode,type_sname lccasename');
        $builder->where('display', 'Y');
        $builder->where('cmis_state_id', $state_id);
        $builder->where('type_sname !=', '');
        $builder->where('corttyp', $court_type);
        $builder->orderBy('lccasename');
        $query2 = $builder->get();
        $result = $query2->getResultArray();

        if(count($result) >= 1){
            return $result;
        }else{
            return false;
        }
    }

    function get_Restrict_Cases_History($list_diary)
    {
        $builder = $this->db->table('rgo_default rg');
        $builder->select([
            'm.diary_no',
            'rg.fil_no2',
            "CONCAT(m.reg_no_display, '@ D.No.', SUBSTRING(m.diary_no::text FROM 1 FOR LENGTH(m.diary_no::text) - 4), '/', SUBSTRING(m.diary_no::text FROM -4)) AS mcaseno",
            'rg.court_type',
            'rg.hcourt_no',
            "CASE WHEN rg.court_type != 'S' OR rg.court_type IS NOT NULL THEN SPLIT_PART(rg.hcourt_no, '~', 4) ELSE NULL END AS lc_caseno",
            "CASE WHEN rg.court_type != 'S' OR rg.court_type IS NOT NULL THEN SPLIT_PART(rg.hcourt_no, '~', 5) ELSE NULL END AS lc_caseyear",
            "CASE WHEN rg.court_type != 'A' THEN
                    (SELECT type_sname
                    FROM master.lc_hc_casetype
                    WHERE display = 'Y'
                    AND corttyp = rg.court_type
                    AND type_sname != ''
                    ORDER BY type_sname limit 1)
                ELSE
                    (SELECT type_sname
                    FROM master.lc_hc_casetype
                    WHERE display = 'Y'
                    AND ref_agency_code_id != 0
                    AND type_sname != ''
                    ORDER BY type_sname limit 1)
                END AS lc_casetype",
            "CASE WHEN rg.court_type = 'S' OR rg.court_type IS NULL THEN
                    (SELECT CONCAT(reg_no_display, '@ D.No.', SUBSTRING(diary_no::text FROM 1 FOR LENGTH(diary_no::text) - 4), '/', SUBSTRING(diary_no::text FROM -4))
                    FROM main
                    WHERE diary_no = fil_no2)
                ELSE NULL
                END AS sc_caseno"
        ]);
        $builder->join('main m', 'm.diary_no = rg.fil_no');
        $builder->where('rg.fil_no', $list_diary);
        $builder->where('rg.remove_def', 'N');
        $query2 = $builder->get();
        $result = $query2->getResultArray();

        if(count($result) >= 1){
            return $result;
        }else{
            return false;
        }
    }

    function delete_Restricted_Case($list_diary,$usercode){
        $del_return='F';
        if($this->check_case($list_diary)==true) {
            
            $subquery = $this->db->table("rgo_default");
            $subquery->select('*');
            $subquery->where("fil_no", $list_diary);
           
            $query =$subquery->get();
            if($query->getNumRows() >= 1) {
                $insertData = $query->getResultArray();
                $insData = [];
                foreach ($insertData as $val) {
                    $insData[] = [
                        'fil_no' => (int) $insertData[0]['fil_no'],
                        'conn_key' => (int) $insertData[0]['conn_key'],
                        'reason' => $insertData[0]['reason'],
                        'fil_no2' => (int)$insertData[0]['fil_no2'],
                        'remove_def' => $insertData[0]['remove_def'],
                        'remove_def_dt' => $insertData[0]['remove_def_dt'],
                        'ent_dt' => $insertData[0]['ent_dt'],
                        'rgo_updated_by' => (int)$insertData[0]['rgo_updated_by'],
                        'hcourt_no' => $insertData[0]['hcourt_no'],
                        'court_type' => $insertData[0]['court_type'],
                        'create_modify' => $insertData[0]['create_modify'],
                        'removed_by' => (int)$usercode,
                        'removed_on' => 'NOW()',
                        'updated_on' => $insertData[0]['updated_on'],
                        'updated_by' => (int)$insertData[0]['updated_by'],
                        'updated_by_ip' => $insertData[0]['updated_by_ip'],

                    ];    
                }     
                $sql_history = $this->db->table('rgo_default_history')->insertBatch($insData);
            }

            $builder1 = $this->db->table('rgo_default');
            $builder1->where('fil_no', $list_diary);
            $sql_delete = $builder1->delete();
        }

        if($this->check_case($list_diary)==true) {
            if($sql_history < 1){
                echo "Unable to process the Request. Please contact Computer Cell.";
            }else{
                $del_return='T';
            }
        }else{
            if($sql_delete < 1){
                echo "Unable to process the Request. Please contact Computer Cell.";
            }else{
                $del_return='T';
            }
        }
        return $del_return;
    }

    function get_HighCourt_State()
    {

        $builder = $this->db->table('master.state');
        $builder->select('id_no, name');
        $builder->where('display', 'Y');
        $builder->where('sub_dist_code', 0);
        $builder->where('village_code', 0);
        $builder->where('district_code', 0);
        $builder->where('sci_state_id !=', 0);
        $builder->orderBy('name');
        $query2 = $builder->get();
        $result = $query2->getResultArray();

        if(count($result) >= 1){
            return $result;
        }else{
            return false;
        }
    }


}