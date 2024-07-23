<?php

namespace App\Models\Filing;

use CodeIgniter\Model;

class DiaryentryModel extends Model
{
    protected $db;

    public function __construct(){
        parent::__construct();
        $db = \Config\Database::connect();
        $this->db = db_connect();
    }


    public function get_court_type(){
        $builder = $this->db->table("master.m_from_court");
        $builder->select("*");
        $builder->WHERE('display','Y');
        $query =$builder->get();
        if($query->getNumRows() >= 1) {
            return $result = $query->getResultArray();
        }else{return false;}
    }


    public function get_state_list(){
        $builder = $this->db->table("master.state");
        $builder->select("id_no, name");
        $builder->WHERE('district_code','0');
        $builder->WHERE('sub_dist_code','0');
        $builder->WHERE('village_code','0');
        $builder->WHERE('sci_state_id !=', '0' );
        $builder->WHERE('display','Y');
        $query =$builder->get();
        if($query->getNumRows() >= 1) {
            return $result = $query->getResultArray();
        }else{return false;}
    }

   

    public function get_bench_list($state_id, $court_type)
{
    
    
    if ($court_type == 3) {
        if ($state_id == '490506') {
            $subQuery = $this->db->table('master.state')
                           ->select('State_code')
                           ->where('id_no', $state_id)
                           ->where('display', 'Y')
                           ->getCompiledSelect();

            $builder = $this->db->table('master.state s');
            $builder->select('id_no id, court_name as agency_name, Name districtname')
                    ->join('master.delhi_district_court d', 's.state_code = d.state_code AND s.district_code = d.district_code')
                    ->where("s.State_code = ($subQuery)", null, false)
                    ->where([
                        's.display' => 'Y',
                        's.Sub_Dist_code' => 0,
                        's.Village_code' => 0,
                        's.District_code !=' => 0
                    ])
                    ->orderBy('TRIM(Name)', 'ASC');

        } else {
            $subQuery = $this->db->table('master.state')
                           ->select('State_code')
                           ->where('id_no', $state_id)
                           ->where('display', 'Y')
                           ->getCompiledSelect();

            $builder = $this->db->table('master.state');
            $builder->select('id_no id, Name agency_name')
                    ->where("State_code = ($subQuery)", null, false)
                    ->where([
                        'display' => 'Y',
                        'Sub_Dist_code' => 0,
                        'Village_code' => 0,
                        'District_code !=' => 0
                    ])
                    ->orderBy('TRIM(Name)', 'ASC');
        }

        $query = $builder->get();
        $result = $query->getResultArray();
        $result_rows = $query->getNumRows();

        if ($result_rows >= 1) {
            return $result;
        } else {
            return 0;
        }
    }

    if ($court_type == '1' || $court_type == '4') {
        $builder = $this->db->table('master.ref_agency_code');
        $builder->select('id, agency_name, short_agency_name')
                ->where([
                    'is_deleted' => 'f',
                    'agency_or_court' => $court_type,
                    'cmis_state_id' => $state_id
                ])
                ->orderBy('agency_name', 'ASC');

        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    if ($court_type == '5') {
        $court_no = [2, 5, 6];

        $builder = $this->db->table('master.ref_agency_code');
        $builder->select('id, agency_name, short_agency_name')
                ->whereIn('agency_or_court', $court_no)
                ->where([
                    'cmis_state_id' => $state_id,
                    'is_deleted' => 'f'
                ])
                ->orderBy('agency_name', 'ASC');

        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }
}



    public function get_role($dcmis_user_idd){

        $builder = $this->db->table("public.fil_trap_users");
        $builder->select("*");
        $builder->WHERE('usercode',$dcmis_user_idd);
        $builder->WHERE('display','Y');
        $builder->WHERE('usertype','101');
        $query =$builder->get();
        if($query) {
            return $result = $query->getNumRows();
        }else{return false;}
    }


    

    public function get_district_list($state_id)
{
   
    $subQuery = $this->db->table('master.state')
                   ->select('State_code')
                   ->where('id_no', $state_id)
                   ->where('display', 'Y')
                   ->getCompiledSelect();

    $builder = $this->db->table('master.state');
    $builder->select('id_no District_code, Name')
            ->where("State_code = ($subQuery)", null, false)
            ->where('District_code !=', 0)
            ->where('Sub_Dist_code', 0)
            ->where('Village_code', 0)
            ->where('display', 'Y')
            ->orderBy('Name');
    
    $query = $builder->get();
    $result = $query->getResultArray();
    $result_rows = $query->getNumRows();
    
    if ($result_rows >= 1) {
        return $result;
    } else {
        return 0;
    }
}


}