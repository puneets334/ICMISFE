<?php

namespace App\Models\Filing;

use CodeIgniter\Model;

class AdvocateModel extends Model
{
    protected $table = 'party';

    public function __construct(){
        parent::__construct();
        $this->db = db_connect();
        
    }
    
    public function get_party($diary_no, $party_type)
    {
        $builder = $this->db->table('public.party');
        $builder->select('partyname, sr_no, sr_no_show');
        $builder->where('diary_no', $diary_no);
        $builder->where('pet_res', $party_type);
        $builder->where('pflag', 'P');
        $builder->orderBy('CAST(sr_no AS BIGINT),
            CAST(split_part(sr_no_show, \'.\', 1) AS BIGINT),
            CAST(split_part(split_part(sr_no_show || \'.0\', \'.\', 2), \'.\', -1) AS BIGINT),
            CAST(split_part(split_part(sr_no_show || \'.0.0\', \'.\', 3), \'.\', -1) AS BIGINT),
            CAST(split_part(split_part(sr_no_show || \'.0.0.0\', \'.\', 4), \'.\', -1) AS BIGINT)');
        
        $query = $builder->get();
        $result = $query->getResultArray(); 

        if (!empty($result))
        {
         return $result;
         }
         else
         {
          return [];
         }
    }

    public function get_party_by_sr_no_show($diary_no, $party_type, $sr_no_show)
    {
        $builder = $this->db->table('public.party');
        $builder->select('partyname, sr_no, sr_no_show');
        $builder->where('diary_no', $diary_no);
        $builder->where('pet_res', $party_type);
        $builder->where('sr_no_show', $sr_no_show);
        $builder->where('pflag', 'P');
        $builder->orderBy('CAST(sr_no AS BIGINT),
            CAST(split_part(sr_no_show, \'.\', 1) AS BIGINT),
            CAST(split_part(split_part(sr_no_show || \'.0\', \'.\', 2), \'.\', -1) AS BIGINT),
            CAST(split_part(split_part(sr_no_show || \'.0.0\', \'.\', 3), \'.\', -1) AS BIGINT),
            CAST(split_part(split_part(sr_no_show || \'.0.0.0\', \'.\', 4), \'.\', -1) AS BIGINT)');
        
        $query = $builder->get();
    
        return $query->getResultArray();
    }


    public function get_advocate_by_sr_no_show($diary_no, $get_party, $sr_no_show, $adv_type, $advocate_id)
{
    $tbl = is_table_a('advocate');

    $builder = $this->db->table('public.' . $tbl);
    $builder->select('*');
    $builder->where('diary_no', $diary_no);
    $builder->where('pet_res', $get_party);

    // Check if $sr_no_show is a floating-point number
    if (fmod((float)$sr_no_show, 1) !== 0.0) {
        $builder->where('pet_res_show_no', $sr_no_show);
    } else {
        $builder->where('pet_res_no', $sr_no_show, false); // Use false to avoid quoting
    }

    $builder->where('adv_type', $adv_type);
    $builder->where('advocate_id', $advocate_id);
    $builder->where('display', 'Y');

    $query = $builder->get();

    if ($query->getNumRows() >0) {
        return $query->getResultArray();
    } else {
        return [];
    }
}



    public function bar_detail_by_bar_id($bar_id)
    {

        $builder = $this->db->table('master.bar');
        $builder->select('bar_id,name,mobile,email,enroll_no,extract(year from enroll_date) as enroll_date,aor_code');
        $builder->where('bar_id',$bar_id);
        
        $query =$builder->get();

        if($query->getNumRows() >= 1) {
            return $result = $query->getResultArray();
        }else{
            return [];
        }
    }


    public function bar_detail($advocate_detail,$adv_no,$adv_year,$stateID)
    {

        $builder = $this->db->table('master.bar');
        $builder->select('name,mobile,email');

        if($advocate_detail=='A'){
            $builder->where('aor_code',$adv_no);
            $builder->where("isdead!='Y'");
            $builder->where('if_aor','Y');
        }

        if($advocate_detail=='S' || $advocate_detail=='AC'){
            $builder->where('enroll_no',$adv_no);
            $builder->where("extract(year from enroll_date)",$adv_year);
            $builder->where('state_id',$stateID);
            $builder->where('isdead','N');
        }
        
        $query =$builder->get();

        if($query->getNumRows() >= 1) {
            return $result = $query->getResultArray();
        }else{
            return [];
        }
    }


    public function check_aor_exist($aor_code)
    {

        $builder = $this->db->table('master.bar');
        $builder->select('bar_id');
        $builder->where('aor_code',$aor_code);
        $builder->where('isdead','N');
        
        $query =$builder->get();

        if($query->getNumRows() >= 1) {
            return $result = $query->getResultArray();
        }else{
            return [];
        }
    }

    public function check_aor_exist_with_state($state,$adv_no,$adv_year)
    {

        $builder = $this->db->table('master.bar');
        $builder->select('bar_id');
        $builder->where('enroll_no',$adv_no);
        $builder->where("extract(year from enroll_date)",$adv_year);
        $builder->where('isdead','N');
        
        $query =$builder->get();

        if($query->getNumRows() >= 1) {
            return $result = $query->getResultArray();
        }else{
            return [];
        }
    }


    public function advocate($diary_no,$advocate_id,$get_party,$state_adv)
    {

        $tbl = is_table_a('advocate');

        if($get_party=='P' || $get_party=='R'){
            $p_no_show = NULL;
            $state_adv = NULL;
        }
        elseif($get_party=='I' || $get_party=='N'){
            $p_no_show = 0;
            $state_adv = $state_adv;
        }

        $builder = $this->db->table('public.'.$tbl);
        $builder->select('advocate_id');
        $builder->where('diary_no',$diary_no);
        $builder->where('advocate_id',$advocate_id);
        $builder->where('pet_res',$get_party);
        $builder->where('pet_res_no',$p_no_show);
        $builder->where('display','Y');
        $builder->where('stateadv',$state_adv);
        
        $query =$builder->get();

        if($query->getNumRows() >= 1) {
            return $result = $query->getNumRows();
        }else{
            return 0;
        }
    }

    public function get_advocate($diary_no,$get_party,$sr_no_show)
    {

        $tbl = is_table_a('advocate');

        $builder = $this->db->table("public.".$tbl);
        $builder->select("pet_res_no,adv,adv_type,advocate_id");
        $builder->select("COALESCE(NULLIF(pet_res_show_no, ''), TRIM(CAST(pet_res_no AS VARCHAR)), TRIM(CAST(pet_res_show_no AS VARCHAR))) AS pet_res_show_no");
        $builder->select("name,is_ac,isdead,if_aor,if_sen,if_other,aor_code");
        $builder->join("master.bar", "bar.bar_id=advocate.advocate_id");
        $builder->where('diary_no',$diary_no);
        $builder->where('display','Y');
        $builder->where('pet_res',$get_party);
        $builder->where("COALESCE(NULLIF(pet_res_show_no, ''), TRIM(CAST(pet_res_no AS VARCHAR)), TRIM(CAST(pet_res_show_no AS VARCHAR))) = '".$sr_no_show."'");

        $query =$builder->get();

        if($query->getNumRows() >= 1) {
            return $result = $query->getResultArray();
        }else{
            return [];
        }
    }

    public function get_caveat_advocate($diary_no)
    {

        $tbl = is_table_a('advocate');

        $builder = $this->db->table("public.".$tbl);
        $builder->select("pet_res_no,adv,adv_type,advocate_id");
        $builder->select("COALESCE(NULLIF(pet_res_show_no, ''), TRIM(CAST(pet_res_no AS VARCHAR)), TRIM(CAST(pet_res_show_no AS VARCHAR))) AS pet_res_show_no");
        $builder->select("name,is_ac,isdead,if_aor,if_sen,if_other,aor_code");
        $builder->join("master.bar", "bar.bar_id=advocate.advocate_id");
        $builder->where('diary_no',$diary_no);
        $builder->where('display','Y');
        $builder->where('pet_res','R');
        $builder->where("pet_res_no","0");

        $query =$builder->get();

        if($query->getNumRows() >= 1) {
            return $result = $query->getResultArray();
        }else{
            return [];
        }
    }

    public function get_advocate_impleading_intervenor($diary_no,$get_party)
    {

        $tbl = is_table_a('advocate');

        $builder1 = $this->db->table("public.".$tbl." a");
        $builder1->select("0,'',a.adv,a.advocate_id,a.adv_type,a.is_ac,b.name,b.aor_code,a.inperson_mobile,a.inperson_email");
        $builder1->join("master.bar b", "b.bar_id=a.advocate_id","left");
        $builder1->where('a.diary_no',$diary_no);
        $builder1->where('a.pet_res',$get_party);
        $builder1->where('a.pet_res_no','0');
        $builder1->where('a.display','Y');
        $builder1->orderBy('a.adv_type','DESC');

        $builder = $this->db->table("public.party p");
        $builder->select("p.sr_no,p.partyname,a.adv,a.advocate_id,a.adv_type,a.is_ac,b.name,b.aor_code,a.inperson_mobile,a.inperson_email");
        $builder->join("public.".$tbl." a", "p.diary_no=a.diary_no","right");
        $builder->join("master.bar b", "b.bar_id=a.advocate_id","left");
        $builder->where('p.diary_no',$diary_no);
        $builder->where('p.pet_res',$get_party);
        $builder->where('pflag','P');
        $builder->where('a.display','Y');       
        

        $query = $builder->union($builder1)->get();

        if($query->getNumRows() >= 1) {
            return $result = $query->getResultArray();
        }else{
            return [];
        }
    }

    public function insert_advocate($ins_arr)
    {
        
        $builder = $this->db->table('public.advocate');

        $query = $builder->insert($ins_arr);

        if($query) {
            return 1;
        }else
        {
            return 0;
        }
        
    }

    public function update_main_pet_res_adv_id($upd_arr,$diary_no)
    {
        
        $builder = $this->db->table('public.main');
        $builder->where('diary_no',$diary_no);

        $query = $builder->update($upd_arr);

        if($query) {
            return 1;
        }else
        {
            return 0;
        }
        
    }

    public function update_advocate($upd_arr,$diary_no,$get_pet_res,$get_sr_no_show,$get_adv_type,$get_advocate_id)
    {
        
        $builder = $this->db->table('public.advocate');

        $builder->where('diary_no',$diary_no);
        $builder->where('pet_res',$get_pet_res);

        if($get_sr_no_show==0){
            $builder->where('pet_res_no',$get_sr_no_show);
        }else{
            $builder->where('pet_res_show_no',$get_sr_no_show);
        }
        
        $builder->where('adv_type',$get_adv_type);
        $builder->where('advocate_id',$get_advocate_id);

        $query = $builder->update($upd_arr);

        if($query) {
            return 1;
        }else
        {
            return 0;
        }
        
    }

    public function delete_advocate($diary_no,$get_pet_res,$get_sr_no_show,$get_adv_type,$get_advocate_id)
    {
        
        $builder = $this->db->table('public.advocate');

        $builder->where('diary_no',$diary_no);
        $builder->where('pet_res',$get_pet_res);

        if($get_sr_no_show==0){
            $builder->where('pet_res_no',$get_sr_no_show);
        }else{
            $builder->where('pet_res_show_no',$get_sr_no_show);
        }

        $builder->where('adv_type',$get_adv_type);
        $builder->where('advocate_id',$get_advocate_id);

        $query = $builder->delete();

        if($query) {
            return 1;
        }else
        {
            return 0;
        }
        
    }

    public function delete_advocate_imp($diary_no,$get_pet_res,$get_adv_type,$get_advocate_id)
    {
        
        $builder = $this->db->table('public.advocate');

        $builder->where('diary_no',$diary_no);
        $builder->where('pet_res',$get_pet_res);
        $builder->where('adv_type',$get_adv_type);
        $builder->where('advocate_id',$get_advocate_id);

        $query = $builder->delete();

        if($query) {
            return 1;
        }else
        {
            return 0;
        }
        
    }

    public function get_main_tbl_data($diary_no)
    {

        $builder = $this->db->table("public.party a");
        $builder->select("CONCAT(count(sr_no_show),'-',pet_res)q,c_status");
        $builder->join("public.main b", "a.diary_no=b.diary_no and pflag='P'");
        $builder->where('a.diary_no',$diary_no);
        $builder->groupBy('pet_res,c_status');

        $query =$builder->get();

        if($query->getNumRows() >= 1) {
            return $result = $query->getResultArray();
        }else{
            return [];
        }
    }

    public function get_advocate_name($term)
    {

        $builder = $this->db->table("master.bar");
        $builder->select("name,CONCAT(mobile,'~',email,'~',aor_code,'~',if_aor) data");
        $builder->where("name iLIKE '%".$term."%' ");
        $builder->where("isdead","N");
        
        $query =$builder->get();

        if($query->getNumRows() >= 1) {
            return $result = $query->getResultArray();
        }else{
            return [];
        }
    }

    public function get_advocate_name_by_aor_code($aor_code)
    {

        $builder = $this->db->table("master.bar");
        $builder->select("name,mobile,email,aor_code,if_aor");
        $builder->where("aor_code",$aor_code);
        $builder->where("isdead","N");
        
        $query =$builder->get();

        if($query->getNumRows() >= 1) {
            return $result = $query->getResultArray();
        }else{
            return [];
        }
    }

    public function select_aor_code()
    {
        $builder = $this->db->table('master.bar');
        $builder->select('aor_code, bar_id,name');
        $builder->where('if_aor','Y')->where('isdead','N');
        $query = $builder->get();
        $result = $query->getResultArray();
        if($result)
        {
            return $result;
        }else{
            return 0;
        }
    }


    public function add_caveator_writ($diary_no,$usercode,$advocateId,$remarks)
    {
        $columnsData = array(
            'diary_no' => $diary_no,
            'adv_type' => 'A',
            'pet_res' => 'R',
            'advocate_id' => $advocateId,
            'usercode' => $usercode,
            'ent_dt' => 'NOW()',
            'display' => 'Y',
            'stateadv' => 'N',
            'aor_state' => 'A',
            'adv' => '[caveat]',
            'writ_adv_remarks' => $remarks,
            'create_modify' => date("Y-m-d H:i:s"),
            'updated_on' => date("Y-m-d H:i:s"),
            'updated_by' => $usercode,
            'updated_by_ip' => getClientIP()
        );
        $builder = $this->db->table('public.advocate');
        $result = $builder->insert($columnsData);

        if($result)
        {
            return $result;
        }else{
            return 0;
        }
    }


}
