<?php

namespace App\Models\Filing;

use CodeIgniter\Model;

class ModelDiary extends Model
{
    public function get_diary_details($diary_no){
        $builder = $this->db->table("public.main as m");
        $builder->select("*");
        $builder->WHERE('m.diary_no',$diary_no);
        $query =$builder->get(1);
        if($query->getNumRows() >= 1) {
            $get_main_table = $query->getRowArray();
            return $get_main_table;
        }else{
            $builder2 = $this->db->table("public.main_a as ma");
            $builder2->select("*");
            $builder2->WHERE('ma.diary_no',$diary_no);
            $query2 =$builder2->get(1);
            if($query2->getNumRows() >= 1) {
                $get_main_table2 = $query2->getRowArray();
                return $get_main_table2;
            }else{return false;}
        }
    }
    public function get_sclsc($diary_no){
        $builder = $this->db->table("public.sclsc_details as sc");
        $builder->select("*");
        $builder->WHERE('sc.display','Y');
        $builder->WHERE('sc.diary_no',$diary_no);
        $query =$builder->get();
        if($query->getNumRows() >= 1) {
            return $result = $query->getRowArray();
        }else{return false;}
    }
    public function get_jailer_sign_dt($diary_no){
        $builder = $this->db->table("public.jail_petition_details as jpd");
        $builder->select("TO_CHAR(jpd.jailer_sign_dt, 'DD-MM-YYYY') as jailer_sign_dt");
        $builder->WHERE('jpd.jail_display','Y');
        $builder->WHERE('jpd.diary_no',$diary_no);
        $query =$builder->get();
        if($query->getNumRows() >= 1) {
            return $result = $query->getRowArray();
        }else{return false;}
    }
    public function get_party_list($diary_no,$type='P',$pflag='P'){
        $builder = $this->db->table(is_table_a('public.party').' as pp');
        $builder->join('master.deptt d', 'pp.state_in_name=d.deptcode','left');
        $builder->select("pp.*,d.deptcode,d.deptname");
        $builder->WHERE('pp.pet_res',$type);
        $builder->WHERE('pp.pflag',$pflag);
        $builder->WHERE('pp.diary_no',$diary_no);
        $builder->orderBy('pp.sr_no ASC,pp.sr_no_show ASC');
        $query =$builder->get(1);
        //$query=$this->db->getLastQuery();echo (string) $query;exit();
        if($query->getNumRows() >= 1) {
            return $result = $query->getRowArray();
        }else{return false;}
    }
    public function get_role_fil_trap($usercode){
        $role="filing";
        $builder = $this->db->table("public.fil_trap_users");
        $builder->select("*");
        $builder->WHERE('display','Y');
        $builder->WHERE('usercode',$usercode);
        $builder->WHERE('usertype','101');
        $query =$builder->get();
        if($query->getNumRows() <=0 and $usercode !=1) {
            return $role="";
        }else{return $role;}
    }
    public function get_section($data1)
    {
        $a = explode("-", $data1);
        $court = $a[0];
        $state = $a[1];
        $bench = $a[2];
        $nature = $a[3];
    
        $tribunal = '';
        if (!empty($bench)) {
            $builder = $this->db->table('master.ref_agency_code');
            $builder->select('agency_or_court');
            $builder->where('id', $bench);
            $query = $builder->get();
            if ($query->getNumRows() >= 1) {
                $tribunal_sec_arr = $query->getRowArray();
                $tribunal = $tribunal_sec_arr['agency_or_court'];
            }
        }
    
        if (($court == 5) && (($nature == 2) || ($nature == 4)) && !empty($bench)) {
            $sql_section = "SELECT public.section_code FROM master.agency_master WHERE case_type='$nature' AND '$bench' = ANY(string_to_array(id, ',')::integer[])";
            $query = $this->db->query($sql_section);
            if ($query->getNumRows() >= 1) {
                $rs_section = $query->getResultArray();
                $section = $rs_section[0]['section_code'];
                echo $section;
            }
        } else if (($court == 5) && ($nature != 2) && ($nature != 4)) {
            if ($tribunal == 5) {
                echo 82;
            } else {
                echo 52;
            }
        } else if (in_array($nature, [32, 33, 34, 35, 40, 41])) {
            echo 52;
        } else if (in_array($nature, [17, 18, 21, 22, 27, 36, 37, 38])) {
            echo 82;
        } else if ($nature == 24) {
            echo 32;
        } else if (in_array($nature, [5, 6])) {
            echo 42;
        } else if (in_array($nature, [7, 8]) && !empty($state)) {
            $sql_section = "SELECT public.section_code FROM master.agency_master WHERE case_type='$nature' AND '$state' = ANY(string_to_array(id, ',')::integer[])";
            $query = $this->db->query($sql_section);
            if ($query->getNumRows() >= 1) {
                $rs_section = $query->getResultArray();
                $section = $rs_section[0]['section_code'];
                echo $section;
            }
        } else {
            if (!empty($nature) && !empty($bench)) {
                $sql_section = "SELECT public.section_code FROM master.agency_master WHERE case_type='$nature' AND '$bench' = ANY(string_to_array(id, ',')::integer[])";
                $query = $this->db->query($sql_section);
                if ($query->getNumRows() >= 1) {
                    $rs_section = $query->getResultArray();
                    $section = $rs_section[0]['section_code'];
                    echo $section;
                }
            } else {
                echo 0;
            }
        }
    }
    
    public function check_if_fil_user($usercode=null){
        $builder = $this->db->table("public.fil_trap_users as a");
        $builder->join('master.users as b', 'a.usercode=b.usercode');
        $builder->select("*");
        $builder->WHERE('b.display','Y');
        $builder->WHERE('a.display','Y');
        if (!empty($usercode) && $usercode !=null) { $builder->WHERE('b.usercode',$usercode); }
        $builder->WHERE('a.usertype',101);
        $builder->WHERE('b.attend','P');
        $builder->orderBy('b.empid','ASC');
        $query =$builder->get();
        if($query->getNumRows() <=0 and $usercode !=1) {
            if (!empty($usercode) && $usercode !=null) { $result= $query->getRowArray();}else{ $result=$query->getResultArray(); }
            return $result;

        }else{return false;}
    }
    public function get_jail_petition_details($diary_no,$id=null){
        $builder = $this->db->table('public.jail_petition_details');
        $builder->select('id, diary_no, jailer_sign_dt, jail_display,TO_CHAR(diary_no_entry_dt, \'DD/MM/YYYY\') as diary_no_entry_dt, create_modify, updated_on, updated_by, updated_by_ip');
        if (!empty($id) && $id !=null) { $builder->WHERE('id',$id); }
        $builder->WHERE('diary_no',$diary_no);
        $builder->WHERE('jail_display','Y');
        $builder->orderBy('id','ASC');
        $query =$builder->get();
        if($query->getNumRows() >= 1) {
            return $result = $query->getRowArray();
        }else{return false;}
    }
    public function check_lowerct_when_modify_diary($diary_no)
    {
        $builder = $this->db->table(is_table_a('public.lowerct'));
        $builder->select('count(lower_court_id)');
        $builder->WHERE('diary_no',$diary_no);
        $builder->whereIn('lw_display',['Y' ,'N']);
        $query =$builder->get();
        if($query->getNumRows() <=0) {

            $builder2 = $this->db->table(is_table_a('public.lowerct'));
            $builder2->select('lct_casetype,lct_caseno,lct_caseyear');
            $builder2->where('lw_display','R');
            $builder2->WHERE('diary_no',$diary_no);
            $query2 =$builder2->get();
            if($query2->getNumRows() >= 1) {
                return $query2->getRowArray();
            }else{return false;}

        }else{return false;}
    }
    public function get_special_category_filing_details($diary_no){
        $builder = $this->db->table('master.ref_special_category_filing r');
        $builder->join('public.special_category_filing s', 'r.id=s.ref_special_category_filing_id and s.display=\'Y\' and s.diary_no='.$diary_no,'left');
        $builder->select("r.id ,s.ref_special_category_filing_id,category_name,r.display");
        $builder->WHERE('r.display','Y');
        $builder->orderBy('r.id','ASC');
        $query =$builder->get();
        if($query->getNumRows() >= 1) {
            $result=$query->getResultArray();
            return $result;

        }else{return false;}
    }
    public function get_advocate_details($diary_no,$pet_res_type=null){
        $builder = $this->db->table(is_table_a('public.advocate').' a');
        $builder->join('master.bar b', 'a.advocate_id=b.bar_id');
        $builder->select("aor_state,advocate_id,a.is_ac,mobile,email,enroll_no,TO_CHAR(enroll_date, 'YYYY') as enroll_date,state_id,name,aor_code,diary_no");
        $builder->WHERE('diary_no',$diary_no);
        $builder->WHERE('adv_type','M');
        $builder->WHERE('display','Y');
        $builder->WHERE('pet_res_no',1);
        $builder->WHERE('pet_res',$pet_res_type);
        $query =$builder->get();
        if($query->getNumRows() >= 1) {
            $result=$query->getRowArray();
            return $result;

        }else{return false;}
    }
    public function get_efiled_cases($diary_no){
        $builder = $this->db->table('public.efiled_cases e');
        $builder->join('public.efiled_cases_transfer_status t', 'e.diary_no=t.diary_no');
        $builder->select('e.diary_no ,t.diary_no as ects_diary_no, t.diary_update_by');
        $builder->WHERE('e.diary_no',$diary_no);
        $query =$builder->get();
        if($query->getNumRows() >= 1) {
            return $query->getRowArray();
        }else{return false;}
    }
    public function get_additional_address_details($diary_no,$pet_res_type){
        $query = $this->db->table('public.party_additional_address')
            ->select('id, address, country, state, district')
            ->where('display', 'Y')
            ->whereIn('party_id', function ($builder) use ($diary_no, $pet_res_type) {
                return $builder->select('auto_generated_id')
                    ->from('party')
                    ->where('sr_no', '1')
                    ->where('diary_no', $diary_no)
                    ->where('pet_res', $pet_res_type)
                    ->where('pflag', 'P');
            });
        $result = $query->get();
        if($result->getNumRows() >= 1) {
            return $result->getResultArray();
        }else{return false;}
    }
}