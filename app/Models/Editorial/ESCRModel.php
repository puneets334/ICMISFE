<?php

namespace App\Models\Editorial;

use CodeIgniter\Model;

class ESCRModel extends Model
{

    protected $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
    }

    //    DATE WISE EDITORIAL REPORT ***********************************************************

    public function datewise_report($from_date, $to_date)
    {

        $builder = $this->db->table("judgment_summary");
        $builder->select("DATE(updated_on) AS uploaded_on,
                    COUNT(DISTINCT (diary_no, orderdate)) AS updated,
                    COUNT(DISTINCT CASE WHEN is_verified = 't' THEN diary_no END) AS verified");
        $builder->where('is_deleted', 'f')->where("DATE(updated_on) BETWEEN '$from_date' AND '$to_date'")->groupBy('DATE(updated_on)');
        $query = $builder->get();
        //        $query=$this->db->getLastQuery();echo (string) $query."<br>";exit;
        $result = $query->getResultArray();
        //        echo "<pre>";
        //        print_r($result);die;
        if ($result) {
            return $result;
        } else {
            return 0;
        }
    }
    //    USER WISE EDITORIAL REPORT ***********************************************************

    public function escr_user_role($ucode)
    {

        $builder = $this->db->table("master.escr_users");
        $builder->select("role");
        $builder->where("usercode", $ucode);
        $query = $builder->get();
        //        $query=$this->db->getLastQuery();echo (string) $query."<br>";exit;
        $result = $query->getResultArray();
        //        echo "<pre>";
        //        print_r($result);die;
        if ($result) {
            return $result;
        } else {
            return 0;
        }
    }

    public function userwise_report($from_date, $to_date, $loggedInUserRole, $ucode)
    {
        $builder = $this->db->table("judgment_summary js");
        $builder->select('name, empid, type_name, COUNT(DISTINCT (diary_no, orderdate)) as updated');
        $builder->join('master.users u', 'js.updated_by = u.usercode');
        $builder->join('master.usertype ut', 'u.usertype = ut.id');
        $builder->where('is_deleted', 'f');
        /*  UNCOMMENT FOR A WHILE TO GET DATA COMMENTED */
        if ($loggedInUserRole == 1) {
            $builder->where('js.updated_by', $ucode);
        }
        if ($from_date != '' && $from_date != '1970-01-01' && $to_date != '' && $to_date != '1970-01-01') {
            $builder->where("DATE(js.updated_on) BETWEEN '$from_date' AND '$to_date'");
        } else {
            $builder->where('is_verified', 'f');
        }
        $builder->groupBy('js.updated_by,name,empid,type_name');

        $query = $builder->get();
        //        $query=$this->db->getLastQuery();echo (string) $query."<br>";exit;
        $result = $query->getResultArray();
        //        echo "<pre>";
        //        print_r($result);die;
        if ($result) {
            return $result;
        } else {
            return 0;
        }
    }

    public function get_case_type_list()
    {
        $builder = $this->db->table("master.casetype");
        $builder->select('casecode, skey, casename,short_description');
        $builder->where('display', 'Y');
        $builder->where('casecode!=', '9999');
        $builder->orderBy('short_description');
        $query = $builder->get();
        //        $query=$this->db->getLastQuery();echo (string) $query."<br>";exit;
        $result = $query->getResultArray();
        //        echo "<pre>";
        //        print_r($result);die;
        if ($result) {
            return $result;
        } else {
            return 0;
        }
    }

    public function get_role($ucode)
    {

        $sql = "select role from master.eSCR_users where usercode=" . $ucode;
        $query = $this->db->query($sql);

        //        $query=$this->db->getLastQuery();echo (string) $query."<br>";exit;
        $result = $query->getResultArray();
        //        echo "<pre>";
        //        print_r($result);die;
        if ($result) {
            return $result;
        } else {
            return 0;
        }
    }



    function show_user_details($from_date, $to_date, $empid)
    {
        // echo "F=".$from_date."T=".$to_date."E=".$empid;die;
        $builder = $this->db->table("judgment_summary");
        $builder->select('DISTINCT u.name, u.empid, ut.type_name, judgment_summary.id, judgment_summary.diary_no, orderdate, summary, judgment_summary.updated_on, is_verified,
              reg_no_display, m.pet_name, m.res_name, v.name as verified_name, v.empid as verified_empid,
              vt.type_name as verified_desig, verified_on', false);
        $builder->join('main_a m', 'm.diary_no = judgment_summary.diary_no');
        $builder->join('master.users u', 'judgment_summary.updated_by = u.usercode');
        $builder->join('master.usertype ut', 'u.usertype = ut.id');
        $builder->Join('master.users v', 'judgment_summary.verified_by = v.usercode', 'left');
        $builder->Join('master.usertype vt', 'v.usertype = vt.id', 'left');
        $builder->where('is_deleted', 'f');
        $builder->where('u.empid', $empid);
        if ($from_date != '' && $from_date != '1970-01-01' && $to_date != '' && $to_date != '1970-01-01') {
            $builder->where("DATE(judgment_summary.updated_on) BETWEEN '$from_date' AND '$to_date'");
        } else {
            $builder->where('is_verified', 'f');
        }

        $result1 = $builder->get();

        if ($result1->getNumRows() > 0) {

            $results = $result1->getResultArray();
        } else {

            $builder = $this->db->table("judgment_summary");
            $builder->select('DISTINCT u.name, u.empid, ut.type_name, judgment_summary.id, judgment_summary.diary_no, orderdate, summary, judgment_summary.updated_on, is_verified,
            reg_no_display, m.pet_name, m.res_name, v.name as verified_name, v.empid as verified_empid,
            vt.type_name as verified_desig, verified_on', false);
            $builder->join('main m', 'm.diary_no = judgment_summary.diary_no');
            $builder->join('master.users u', 'judgment_summary.updated_by = u.usercode');
            $builder->join('master.usertype ut', 'u.usertype = ut.id');
            $builder->Join('master.users v', 'judgment_summary.verified_by = v.usercode', 'left');
            $builder->Join('master.usertype vt', 'v.usertype = vt.id', 'left');
            $builder->where('is_deleted', 'f');
            $builder->where('u.empid', $empid);
            if ($from_date != '' && $from_date != '1970-01-01' && $to_date != '' && $to_date != '1970-01-01') {
                $builder->where("DATE(judgment_summary.updated_on) BETWEEN '$from_date' AND '$to_date'");
            } else {
                $builder->where('is_verified', 'f');
            }
            $result1 = $builder->get();
            //          $query=$this->db->getLastQuery();echo (string) $query."<br>";exit;
            $results = $result1->getResultArray();
            //            $query2->findAll();
            //  echo "GSDF";
            //  echo "<pre>";
            //  print_r($query2);

        }
        //       echo "<pre>";print_r($results);die;
        if ($results) {
            return $results;
        } else {
            return 0;
        }
    }


    public function delete_gist($id, $ucode)
    {
        $columnUpdate = array(
            'is_deleted' => 't',
            'deleted_on' => 'NOW()',
            'deleted_by' => $ucode,
            'deleted_by_ip' => getClientIP(),
            'create_modify' => date("Y-m-d H:i:s"),
            'updated_on' => date("Y-m-d H:i:s"),
            'updated_by' => session()->get('login')['usercode'],
            'updated_by_ip' => getClientIP()

        );

        $builder = $this->db->table('judgment_summary');
        $this->db->where('id', $id);
        $query = $this->db->update($columnUpdate);

        $query = $builder->get();
        //        $query=$this->db->getLastQuery();echo (string) $query."<br>";exit;
        $result = $query->getResultArray();
        //        echo "<pre>";
        //        print_r($result);die;
        if ($result) {
            return $result;
        } else {
            return 0;
        }
    }

    public function judgement_summary_check($dno, $juddate)
    {

        $builder = $this->db->table('judgment_summary');
        $builder->select('*');
        $builder->where('is_deleted', 'f')->where('diary_no', $dno)->where('orderdate', $juddate);
        $query = $builder->get();
        //        $query=$this->db->getLastQuery();echo (string) $query."<br>";exit;
        $result = $query->getResultArray();
        //        echo "<pre>";
        //        print_r($result);die;
        if ($result) {
            return $result;
        } else {
            return 0;
        }
    }

    public function judgment_summary_update($dno, $juddate, $userCode, $client_ip)
    {
        $data = [
            'is_deleted' => 't',
            'updated_by' => $userCode,
            'updated_on' => 'NOW()',
            'updated_by_ip' => $client_ip,
        ];

        $builder = $this->db->table('judgment_summary');

        $builder->where('diary_no', $dno)->where('orderdate', $juddate);

        $query = $builder->update($data);
        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function judgment_summary_insertion($userrole, $diaryNumber, $remarks, $judgmentDate, $ucode, $client_ip, $updated_by = '', $updated_on = '', $updated_by_ip = '')
    {
        if ($userrole == 1) {
            $data = [
                'diary_no' => $diaryNumber,
                'summary' => $remarks,
                'is_deleted' => 'f',
                'updated_by' => $ucode,
                'updated_on' => 'NOW()',
                'updated_by_ip' => $client_ip,
                'orderdate' => $judgmentDate,

            ];

            $builder = $this->db->table('judgment_summary');
            $query = $builder->insert($data);
        } else if ($userrole == 2) {

            $data = [
                'diary_no' => $diaryNumber,
                'summary' => $remarks,
                'is_deleted' => 'f',
                'updated_by' => $ucode,
                'updated_on' => 'NOW()',
                'updated_by_ip' => $client_ip,
                'is_verified' => 't',
                'verified_by' => $ucode,
                'verified_on' => 'NOW()',
                'verified_by_ip' => $client_ip,
                'orderdate' => $judgmentDate,

            ];

            $builder = $this->db->table('judgment_summary');
            $query = $builder->insert($data);
        } else {

            $data = [
                'diary_no' => $diaryNumber,
                'summary' => $remarks,
                'is_deleted' => 'f',
                'updated_by' => $ucode,
                'updated_on' => 'NOW()',
                'updated_by_ip' => $client_ip,
                'is_verified' => 't',
                'verified_by' => $ucode,
                'verified_on' => 'NOW()',
                'verified_by_ip' => $client_ip,
                'orderdate' => $judgmentDate,

            ];

            $builder = $this->db->table('judgment_summary');
            $query = $builder->insert($data);
        }

        //        echo $query;die;
        //        $query=$this->db->getLastQuery();echo (string) $query."<br>";exit;

        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function judgment_detail($dno, $juddate)
    {
        //        echo $id.">>>";echo "<pre>";print_r($data);die;

        $sql = "SELECT o.diary_no diary_no,o.dated::text dated FROM tempo o 
            LEFT JOIN main m ON concat(o.dn,o.dy) = m.diary_no::text 
            left join master.bar pet on m.pet_adv_id=pet.bar_id 
            left join master.bar res on m.res_adv_id=res.bar_id 
            LEFT JOIN master.casetype c ON m.active_casetype_id = casecode WHERE m.diary_no =$dno and o.jt NOT LIKE '%or%' AND o.jt NOT LIKE '%rop%' and o.dated='$juddate' 
            union 
            SELECT o.diary_no diary_no,o.orderdate::text dated FROM ordernet o 
            LEFT JOIN main m ON o.diary_no = m.diary_no 
            left join master.bar pet on m.pet_adv_id=pet.bar_id 
            left join master.bar res on m.res_adv_id=res.bar_id 
            LEFT JOIN master.casetype c ON m.active_casetype_id = casecode 
            left join dispose d1 on m.diary_no=d1.diary_no WHERE o.diary_no =$dno AND o.type='J' and o.display='Y' and o.orderdate='$juddate' 
            union 
            SELECT o.dn diary_no,o.juddate::text dated FROM scordermain o 
            LEFT JOIN main m ON o.dn = m.diary_no 
            left join master.bar pet on m.pet_adv_id=pet.bar_id 
            left join master.bar res on m.res_adv_id=res.bar_id 
            LEFT JOIN master.casetype c ON m.active_casetype_id = casecode WHERE o.dn = $dno and o.juddate='$juddate'";
        $query = $this->db->query($sql);
        //        $query=$this->db->getLastQuery();echo (string) $query."<br>";exit;
        $result = $query->getResultArray();
        //        echo "<pre>";
        //        print_r($result);die;
        if ($result) {
            return $result;
        } else {
            $sql = "SELECT o.diary_no diary_no,o.dated::text dated FROM tempo o 
            LEFT JOIN main_a m ON concat(o.dn,o.dy) = m.diary_no::text 
            left join master.bar pet on m.pet_adv_id=pet.bar_id 
            left join master.bar res on m.res_adv_id=res.bar_id 
            LEFT JOIN master.casetype c ON m.active_casetype_id = casecode WHERE m.diary_no =$dno and o.jt NOT LIKE '%or%' AND o.jt NOT LIKE '%rop%' and o.dated='$juddate' 
            union 
            SELECT o.diary_no diary_no,o.orderdate::text dated FROM ordernet_a o 
            LEFT JOIN main_a m ON o.diary_no = m.diary_no 
            left join master.bar pet on m.pet_adv_id=pet.bar_id 
            left join master.bar res on m.res_adv_id=res.bar_id 
            LEFT JOIN master.casetype c ON m.active_casetype_id = casecode 
            left join dispose d1 on m.diary_no=d1.diary_no WHERE o.diary_no =$dno AND o.type='J' and o.display='Y' and o.orderdate='$juddate' 
            union 
            SELECT o.dn diary_no,o.juddate::text dated FROM scordermain o 
            LEFT JOIN main_a m ON o.dn = m.diary_no 
            left join master.bar pet on m.pet_adv_id=pet.bar_id 
            left join master.bar res on m.res_adv_id=res.bar_id 
            LEFT JOIN master.casetype c ON m.active_casetype_id = casecode WHERE o.dn = $dno and o.juddate='$juddate'";
            $query = $this->db->query($sql);
            //        $query=$this->db->getLastQuery();echo (string) $query."<br>";exit;
            $result = $query->getResultArray();
            if ($result) {
                return $result;
            } else {
                return 0;
            }
        }
    }
}
