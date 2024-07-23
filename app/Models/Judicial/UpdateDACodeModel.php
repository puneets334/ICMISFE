<?php
namespace App\Models\Judicial;

use CodeIgniter\Model;

class UpdateDACodeModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->db = db_connect();
    }


    public function get_casedesc($diary_no){

        $main_q = "SELECT pet_name,res_name,c_status,name,section_name,a.dacode,empid,section_id FROM main a LEFT JOIN master.users b ON a.dacode=b.usercode LEFT JOIN master.usersection c ON b.section=c.id WHERE diary_no=$diary_no";
        $result = $this->db->query($main_q);
        $result = $result->getResultArray();

        if(!empty($result)){
            $result = $result[0];
        }else{
            $result = [];
        }
        return $result;
    }


   public function set_dacode($data){
    $ucode = $_SESSION['login']['usercode'];
    $builder15 = $this->db->table("main");
    $builder15->select("dacode");
    $builder15->where('diary_no', $data['dno']);
    $query15 = $builder15->get();
    $resdaCode = $query15->getResultArray();
    if(!empty($resdaCode)){
        $daCode = $resdaCode[0]['dacode'];
        $updateData = [
            'old_dacode' => $daCode,
            'dacode' => $data['dacode'],
            'last_usercode' => $ucode,
            'last_dt' => 'NOW()'
        ];
    
        $builder = $this->db->table("main");
        $builder->where('diary_no', $data['dno']);
        if($builder->update($updateData)){
            return 1;
        }else{
            return 0;
        }
    }
    
   
   }







}