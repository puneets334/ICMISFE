<?php

namespace App\Models\Filing;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseBuilder;
class ModelFilTrap extends Model
{
    public function get_fil_trap_type_user_details($usercode=null,$id=null)
    {
        $builder = $this->db->table('public.fil_trap_users as a');
        $builder->select('a.usertype,b.type_name,b.disp_flag');
        $builder->join('master.usertype as b', 'a.usertype=b.id', 'left');
        $builder->WHERE('b.display','E');
        $builder->WHERE('a.display','Y');
        if (!empty($id) && $id !=null)
        {
            $builder->WHERE('a.id',$id);
        }
        if (!empty($usercode) && $usercode !=null)
        { 
            $builder->WHERE('a.usercode',$usercode); }else{$builder->WHERE('a.usercode',$_SESSION['login']['usercode']);
        }
        $query = $builder->get();
        if($query->getNumRows() >= 1)
        {
            return $result = $query->getRowArray();
        }
        else
        {
            return false;
        }
    }
    public function get_fil_trap_list($dno = null, $dyr = null)
    {
        $session = session();
        $usercode = $session->get('login')['usercode'];
        $icmic_empid = $session->get('login')['empid'];
        $fil_trap_type_row = $this->get_fil_trap_type_user_details();
        $cur_date = date('d-m-Y');
        $new_date = date('d-m-Y', strtotime($cur_date . ' + 60 days'));
        $cat = 0;
        $ref = 0;
        $condition = "AND remarks=''";
    
        if (!empty($fil_trap_type_row)) {
            if ($fil_trap_type_row['usertype'] == 104) {
                $ref = 1;
            }
            if ($fil_trap_type_row['usertype'] == 108) {
                $ref = 2;
            }
            if ($fil_trap_type_row['usertype'] == 105 || $fil_trap_type_row['usertype'] == 106)
            {  // for category and tagging user
                $cat = 1;
                if ($fil_trap_type_row['usertype'] == 105) {
                    $text = "Category";
                } else {
                    $text = "Tagging";
                }
            }
            if ($fil_trap_type_row['usertype'] == 102)
            {
                $condition = "AND remarks='FIL -> DE'";
            }
            if ($fil_trap_type_row['usertype'] == 103)
            {
                $condition = "AND remarks IN('DE -> SCR','FDR -> SCR')";
            }
            if ($fil_trap_type_row['usertype'] == 107)
            {
                $condition = "AND remarks IN('CAT -> IB-Ex','TAG -> IB-Ex','SCN -> IB-Ex')";
            }
    
            $usertype = $fil_trap_type_row['usertype'];
            $builder = $this->db->table('public.fil_trap a');
            $builder->select("ec.efiling_no, a.uid, a.diary_no, d_by_empid, d_to_empid, disp_dt, remarks, e.name d_by_name, pet_name, res_name, rece_dt, nature, TO_CHAR(h.next_dt, 'DD-MM-YYYY') as next_dt, h.main_supp_flag,
                CASE WHEN h.board_type='C' THEN 'CHAMBER' ELSE CASE WHEN h.board_type='J' THEN 'COURT' ELSE 'Registrar' END END AS board_type, ref_special_category_filing_id,
                category_name");
            $builder->join('public.main b', 'a.diary_no = b.diary_no', 'left');
            $builder->join('master.users e', 'e.empid = a.d_by_empid', 'left');
            $builder->join('public.heardt h', 'b.diary_no = h.diary_no', 'left');
            $builder->join('public.efiled_cases ec', "ec.diary_no = b.diary_no AND ec.display = 'Y'", 'left');
            $builder->join('public.special_category_filing s', "a.diary_no = s.diary_no AND s.display = 'Y'", 'left');
            $builder->join('master.ref_special_category_filing r', "s.ref_special_category_filing_id = r.id AND r.display = 'Y'", 'left');
            
            if ($cat == 0 && $ref == 0) {
                $builder->where("d_to_empid", $icmic_empid);
                $builder->where("comp_dt IS NULL");
                $builder->where("b.c_status", "P");
                $builder->where($condition, null, false);
                $builder->orderBy("disp_dt", "DESC");
            } else if ($cat == 1) {
                $builder->whereIn("d_to_empid", function($builder) use ($usertype) {
                    $builder->select("empid")
                        ->from("fil_trap_users")
                        ->join("master.users", "fil_trap_users.usercode = users.usercode")
                        ->where("fil_trap_users.usertype", $usertype);
                });
                $builder->where("comp_dt IS NULL");
                $builder->where("b.c_status", "P");
                $builder->orderBy("disp_dt", "DESC");
            } else if ($ref == 1) {
                $builder->where("d_to_empid", function($builder) {
                    $builder->select("empid")
                        ->from("users")
                        ->where("usertype", 59)
                        ->like("name", "REFILING", 'both');
                });
                $builder->where("comp_dt IS NULL");
                $builder->where("b.c_status", "P");
                $builder->orderBy("disp_dt", "DESC");
            } else if ($ref == 2) {
                $condition1 = '';
                if (!empty($dno) && !empty($dyr)) {
                    $condition1 = "a.diary_no = " . $dno . $dyr . " AND ";
                    $builder->where($condition1, null, false);
                }
                $builder->whereIn("d_to_empid", function($builder) {
                    $builder->select("empid")
                        ->from("users")
                        ->groupStart()
                            ->like("name", "FILING DISPATCH RECEIVE", 'both')
                            ->where("usertype", 51)
                        ->groupEnd()
                        ->orGroupStart()
                            ->like("name", "ADVOCATE CHAMBER SUB-SECTION", 'both')
                            ->where("usertype", 59)
                        ->groupEnd();
                });
                $builder->where("comp_dt IS NULL");
                $builder->where("b.c_status", "P");
                $builder->orderBy("disp_dt", "DESC");
            }
    
            $query = $builder->get();
            if ($query->getNumRows() >= 1) {
                return $query->getResultArray();
            } else {
                return false;
            }
        } else {
            echo "<br>No record found!!!!";
            exit();
        }
    }
    
    public function update_main_refiling_attempt($id) {
      
        $builder = $this->db->table('public.main');
        $builder->whereIn('diary_no', static function (BaseBuilder $builder) use ($id)
        {
            $builder->select('diary_no')->from('fil_trap')->where('uid', $id);
        });
        $builder->update(['refiling_attempt' => date("Y-m-d H:i:s")]);
        return $this->db->affectedRows();
    }
    public function get_case_skey($diary_no)
    {
        $builder = $this->db->table('public.main a');
        $builder->select('b.skey');
        $builder->join('master.casetype b', "CASE WHEN a.active_fil_no IS NOT NULL AND a.active_fil_no != '' THEN a.active_casetype_id = b.casecode ELSE a.casetype_id = b.casecode END", null, false);
        $builder->where('b.display', 'Y');
        $builder->where('a.diary_no', $diary_no);
    
        $query = $builder->get();
        if ($query->getNumRows() >= 1) {
            return $query->getRowArray();
        } else {
            return false;
        }
    }
    
    public function get_fil_trap_efiled_type_details($uid=null,$row='A')
    {
        $sql_nature="select count(*) from fil_trap  join main on fil_trap.diary_no=main.diary_no  join efiled_cases e on main.diary_no=e.diary_no   where  uid =$_REQUEST[id] and (ack_id <> 0 or (display='Y' and efiled_type='new_case'))";
        $builder = $this->db->table('fil_trap f');
        $builder->select('f.*,e.*,m.ack_id');
        $builder->join('main m', 'f.diary_no=m.diary_no');
        $builder->join('efiled_cases e', 'm.diary_no=e.diary_no');
        if (!empty($uid) && $uid !=null){ $builder->WHERE('f.uid',$uid); }
        $builder->groupStart();
        $builder->where('m.ack_id <>', 0);
        $builder->orGroupStart();
        $builder->Where(['e.display'=>'Y']);
        $builder->Where(['e.efiled_type'=>'new_case']);
        $builder->groupEnd();
        $builder->groupEnd();
        $query = $builder->get();
        if($query->getNumRows() >= 1)
        {
            if ($row !='A'){ return $query->getRowArray(); }else{ return $query->getResultArray();}
        }
        else
        {
            return false;
        }
    }

    public function update_fil_trap_by_case($uid,$ck_adv_rec,$ext_rec)
    {
       
        $usercode=$_SESSION['login']['usercode']; $ip=getClientIP(); $current_date=date("Y-m-d H:i:s");
         $query = "UPDATE fil_trap SET updated_on='$current_date', updated_by=$usercode, updated_by_ip='$ip', rece_dt='$current_date',r_by_empid=$ck_adv_rec  $ext_rec  WHERE uid=$uid";
        $query = $this->db->query($query);
        if($this->db->affectedRows()) {
            return true;
        }else{
            return false;
        }

    }

    public function update_fil_trap_by_allot_to_AOR($uid, $to_userno, $remarks)
    {
        $empid = session()->get('login')['empid'];
        $usercode = session()->get('login')['usercode'];
        $current_date = date("Y-m-d H:i:s");
        $data1 = [
            'd_by_empid' => 'r_by_empid',
            'other' => $empid,
            'd_to_empid' => $to_userno,
            'disp_dt' => $current_date,
            'remarks' => $remarks,
            'rece_dt' => null,
            'comp_dt' => null,
            'disp_dt_seq' => '',
            'updated_on' => $current_date,
            'updated_by' => $usercode,
            'updated_by_ip' => getClientIP()
        ];
    
       
        $data2 = [
            'r_by_empid' => '0',
            'other' => '0',
            'updated_on' => $current_date,
            'updated_by' => $usercode,
            'updated_by_ip' => getClientIP()
        ];
    
        
        $builder = $this->db->table('fil_trap');
        $builder->where('uid', $uid);
        $builder->set('d_by_empid', 'r_by_empid', false); 
        $builder->update($data1);
    
        if ($this->db->affectedRows()) {
           
            $builder->where('uid', $uid);
            $builder->update($data2);
            return true;
        } else {
            return false;
        }
    }
    
    public function update_fil_trap_comp_dt_by_uid($uid)
    {
        
        $empid=session()->get('login')['empid']; $usercode=$_SESSION['login']['usercode']; $ip=getClientIP(); $current_date=date("Y-m-d H:i:s");
        $query = "UPDATE fil_trap SET updated_on='$current_date', updated_by=$usercode, updated_by_ip='$ip', comp_dt='$current_date',other=CASE WHEN d_to_empid=$empid THEN 0 else $empid end WHERE uid=$uid";
        $query = $this->db->query($query);
        if($this->db->affectedRows()) {
            return true;
        }else{
            return false;
        }

    }
    

    public function insert_into_history($uid)
    {
        if(!empty($uid)){
            $fil_trap=is_data_from_table('fil_trap',['uid'=>$uid],'','R');
            if(!empty($fil_trap)){
                $row=$fil_trap;
               
                $where_condition = [
                    'diary_no' => $row['diary_no'],
                    'd_by_empid'=>$row['d_by_empid'],
                    'd_to_empid'=>$row['d_to_empid'],
                    'disp_dt'=>$row['disp_dt'],
                    'rece_dt'=>$row['rece_dt'],
                    'comp_dt'=>$row['comp_dt'],
                    'disp_dt_seq'=>$row['disp_dt_seq'],
                    'other'=>$row['other'],
                    'scr_lower'=>$row['scr_lower']
                ];
                $check_fil_trap=is_data_from_table('fil_trap_his',$where_condition);
                if (empty($check_fil_trap)){
                    $insert_q = [
                        'diary_no' => $row['diary_no'],
                        'd_by_empid'=>$row['d_by_empid'],
                        'd_to_empid'=>$row['d_to_empid'],
                        'disp_dt'=>$row['disp_dt'],
                        'remarks'=>$row['remarks'],
                        'r_by_empid'=>$row['r_by_empid'],
                        'rece_dt'=>$row['rece_dt'],
                        'comp_dt'=>$row['comp_dt'],
                        'disp_dt_seq'=>$row['disp_dt_seq'],
                        'other'=>$row['other'],
                        'scr_lower'=>$row['scr_lower'],
                        'thisdt'=>date("Y-m-d H:i:s"),
                        'token_no'=>$row['token_no']
                    ];
                    return $is_insert_cnt_token= insert('fil_trap_his',$insert_q);
                }

            }
        }
    }
    public function allot_to_category($uid,$ucode,$usertype,$fil_type)
    {
        $chk_j_c=0;
        $chk_lc_usr=0; $diary_no='';
        $check_if_SCR_ava=$this->check_user_fresh_or_first_scrutiny_not_available_then_sequential_refiling_user_allotment($fil_type,103);
       
        if(!empty($check_if_SCR_ava)){
            $first_row = $check_if_SCR_ava;
            $next_user='';

           
            $check_ava_rs =$this->check_if_SCR_available_fil_trap_seq($fil_type,103,'SCR');
            $check_ava_row = $check_ava_rs;

            if(!empty($check_ava_rs)>0)
            {
                $next_user=$check_ava_row['to_usercode'];
                if($check_ava_row['to_usercode'] == NULL){
                    $check_ava_row['to_userno'] = $first_row['empid'];
                    $check_ava_row['to_name'] = $first_row['name'];
                    $next_user=$check_ava_row['to_userno'];
                }
            }else{
                $check_ava_row['to_userno'] = $first_row['empid'];
                $check_ava_row['to_name'] = $first_row['name'];
                $next_user=$check_ava_row['to_userno'];
            }

            //if($check_ava_row['to_usercode'] == NULL){
            /* if(mysql_num_rows($check_ava_rs)==0 || $check_ava_row['to_usercode'] == NULL){
                 $check_ava_row['to_userno'] = $first_row['empid'];
                 $check_ava_row['to_name'] = $first_row['name'];
                 $next_user=$check_ava_row['to_userno'];
             }*/

            /*$diary_no = "SELECT diary_no FROM `fil_trap` WHERE uid=$uid";
            $diary_no = mysql_query($diary_no) or die(__LINE__.'->'.mysql_error());
            $diary_no = mysql_result($diary_no,0);*/

            $get_diary=is_data_from_table('fil_trap',['uid'=>$uid],'diary_no','R');
            if (!empty($get_diary)) {
                $diary_no = $get_diary['diary_no'];
            }
        }


        if($ucode!='29' && $usertype!='108' && $chk_j_c==0 && !empty($check_ava_row))
        {
            $utype='';
            if($ucode=='9796')
            {
                $utype='IB-Ex';
            }
            else
            {
                $utype='SCR';
            }
            if($chk_lc_usr==0 || ($check_ava_row['to_userno']==$next_user && $chk_lc_usr==1))
            {
                /*$check = "SELECT id FROM fil_trap_seq WHERE ddate=CURDATE() AND utype='$utype' and user_type='$fil_type'";
                $check = mysql_query($check) or die(__LINE__.'->'.mysql_error());
                if(mysql_num_rows($check)==0)
                    $query = "INSERT INTO fil_trap_seq(ddate,utype,no,user_type) VALUES(CURDATE(),'$utype',$check_ava_row[to_userno],'$fil_type')";
                else
                    // $query = "UPDATE fil_trap_seq SET no=$check_ava_row[to_userno] WHERE ddate=CURDATE() AND utype='$utype' and user_type='$fil_type'";
                    $query = "UPDATE fil_trap_seq SET no=$check_ava_row[to_userno] WHERE ddate=CURDATE() AND utype='$utype' and user_type='$fil_type'";

                mysql_query($query) or die(__LINE__.'->'.mysql_error());*/

                $current_date=date("Y-m-d");
                $check=is_data_from_table('fil_trap_seq',['utype'=>$utype,'user_type'=>$fil_type,'ddate'=>$current_date],'id','R');
                if (empty($check)) {
                    $insert_fil_trap_seq = [
                        'ddate'=>date("Y-m-d"),
                        'utype'=>(!empty($utype)) ? $utype :'',
                        'no'=>(!empty($check_ava_row['to_userno'])) ? $check_ava_row['to_userno'] :0,
                        'user_type'=>(!empty($fil_type)) ? $fil_type :'',
                        'ctype'=>0,
                        'create_modify' => date("Y-m-d H:i:s"),
                        'updated_by'=>$_SESSION['login']['usercode'],
                        'updated_by_ip'=>getClientIP(),
                    ];
                    $is_insert_fil_trap_seq= insert('fil_trap_seq',$insert_fil_trap_seq);
                }else{
                    $update_fil_trap_seq = [
                        'no'=>(!empty($check_ava_row['to_userno'])) ? $check_ava_row['to_userno'] :0,
                        'updated_on' => date("Y-m-d H:i:s"),
                        'updated_by'=>$_SESSION['login']['usercode'],
                        'updated_by_ip'=>getClientIP(),
                    ];
                    $is_update_fil_trap_refil_users=update('fil_trap_seq',$update_fil_trap_seq,['ddate'=>$current_date,'utype'=>$utype,'user_type'=>$fil_type]);
                }
            }
        }

        $this->insert_into_history($uid);
        $remarks='';
        if($_SESSION['login']['empid']=='29' || $usertype=='108') {
            $remarks = "FDR -> SCR";
        } else if($_SESSION['login']['empid']=='9796') {
            if($chk_j_c==0) {
                $remarks = "SCN -> IB-Ex";
            }else if($chk_j_c==1) {
                $remarks = "SCN -> DA";
            }
        }
        else {
            $remarks = "DE -> SCR";
        }

        /* $update_then = "UPDATE fil_trap SET d_by_empid='$_SESSION[icmic_empid]',d_to_empid='$check_ava_row[to_userno]',disp_dt=NOW(),
          remarks='$remarks',r_by_empid=0,rece_dt='0000-00-00 00:00:00',comp_dt='0000-00-00 00:00:00',disp_dt_seq='0000-00-00 00:00:00.000000',
              other='0'
          WHERE uid='$uid'";
         mysql_query($update_then) or die(__LINE__.'->'.mysql_error());*/

        $update_then_fil_trap = [
            'd_by_empid'=>$_SESSION['login']['empid'],
            'd_to_empid'=>(!empty($check_ava_row['to_userno'])) ? $check_ava_row['to_userno'] :0,
            'disp_dt' => date("Y-m-d H:i:s"),
            'remarks' => $remarks,
            'r_by_empid'=>0,
            'rece_dt' => null,
            'comp_dt' => null,
            'disp_dt_seq' => '',
            'other' => 0,

            'updated_on' => date("Y-m-d H:i:s"),
            'updated_by'=>$_SESSION['login']['usercode'],
            'updated_by_ip'=>getClientIP(),
        ];
        $is_update_then_fil_trap=update('fil_trap',$update_then_fil_trap,['uid'=>$uid]);
        if($ucode=='29') {
            $check_users=is_data_from_table('master.users',['display'=>'Y','attend'=>'P','usercode' => $ucode], '*', 'R');
        }elseif ($usertype=='108') {
            $check_users=is_data_from_table('master.users',['display'=>'Y','attend'=>'P','usertype'=>$usertype],'*','R');
        }else{
            return $check_ava_row['to_userno'] . '~' . $check_ava_row['to_name'];
        }
        $r_get_scr_usr = $r_user_name = '';
        if (!empty($check_users)) {
            $r_get_scr_usr = $check_users['empid'];
            $r_user_name = $check_users['name'];
        }
        return $r_get_scr_usr . '~' . $r_user_name;
    }





    public function allot_to_CAT_REF($uid,$fil_type)
    {
        $d_to_empid='';
        $d_to_empname='';
        $chk_status=0;
        $get_diary=is_data_from_table('fil_trap',['uid'=>$uid],'diary_no','R');
        if (!empty($get_diary)) {
            $diary_no = $get_diary['diary_no'];
        }
           // $chk_if_default=is_data_from_table('obj_save',['diary_no'=>$diary_no,'display'=>'Y','rm_dt is null'=>null],'*','R');
        $builder_obj_save = $this->db->table('public.obj_save');
        $builder_obj_save->select('*');
        $builder_obj_save->where('display', 'Y');
        $builder_obj_save->where('rm_dt is null');
        $builder_obj_save->where('diary_no', $diary_no);
        $chk_if_default = $builder_obj_save->get()->getResultArray();
       // echo $this->db->getLastQuery();
            $refiling_categorization = 'N';
            $remark='';
            $chk_status=0;
            if(!empty($chk_if_default)){

                $usr_nm=" usertype=51 AND name iLIKE '%FILING DISPATCH RECEIVE%'";
                $first_row=is_data_from_table('master.users',$usr_nm,'usercode, name to_name, empid to_userno','R');

                $d_to_empid=$first_row['to_userno'];
                $d_to_empname=$first_row['to_name'];
                $refiling_categorization='R';
                 $remark = "SCR -> FDR";
            }
            else{

                $r_chk_ias=$this->check_main_with_docdetails_docmaster($diary_no);
                if(empty($r_chk_ias))
                {

                    $r_chk_registered=is_data_from_table('main',['diary_no'=>$diary_no,'c_status'=>'P'],'active_fil_no','R');

                    if (!empty($r_chk_registered)){
                        if($r_chk_registered['active_fil_no']=='' || $r_chk_registered['active_fil_no']==NULL)
                        { $chk_status=1; }
                    }

                }

                if($chk_status==0)
                {
                    $chk_lc_usr=0;

                    $check_if_SCR_ava=$this->check_user_fresh_or_first_scrutiny_not_available_then_sequential_refiling_user_allotment($fil_type,105);
                    if(!empty($check_if_SCR_ava)){
                        $first_row = $check_if_SCR_ava;
                        $next_user='';


                        $check_ava_row = $this->check_if_SCR_available_fil_trap_seq($fil_type,105,'CAT');
                        if (!empty($check_ava_row)) {
                            $next_user=$check_ava_row['to_userno'];
                            $d_to_empname=$check_ava_row['to_name'];
                        }else{
                            if (empty($check_ava_row) || $check_ava_row['to_usercode'] == NULL){
                                $check_ava_row2['to_userno'] = $first_row['empid'];
                                $check_ava_row2['to_name'] = $first_row['name'];
                                $check_ava_row=$check_ava_row2;
                                $next_user=$first_row['empid'];
                                $d_to_empname=$first_row['name'];
                            }
                        }

                    }
                    $d_to_empid=$next_user;
                    $remark = "SCR -> CAT";
                }
            }

            if($chk_status==0)
            {
                if($d_to_empid!=''){


                    $update_fil_trap_comp_dt = [
                        'comp_dt'=>date("Y-m-d H:i:s"),
                        'updated_on' => date("Y-m-d H:i:s"),
                        'updated_by'=>$_SESSION['login']['usercode'],
                        'updated_by_ip'=>getClientIP(),
                    ];
                    $query_to_update_fil_trap_comp_dt=update('fil_trap',$update_fil_trap_comp_dt,['uid='=>$uid]);

                    $this->insert_into_history($uid);


                    $update_then_fil_trap = [
                        'd_by_empid'=>$_SESSION['login']['empid'],
                        'd_to_empid'=>(!empty($d_to_empid)) ? $d_to_empid :0,
                        'disp_dt' => date("Y-m-d H:i:s"),
                        'remarks' => $remark,
                        'r_by_empid'=>0,
                        'rece_dt' => null,
                        'comp_dt' => null,
                        'disp_dt_seq' => '',

                        'updated_on' => date("Y-m-d H:i:s"),
                        'updated_by'=>$_SESSION['login']['usercode'],
                        'updated_by_ip'=>getClientIP(),
                    ];
                    $is_update_then_fil_trap=update('fil_trap',$update_then_fil_trap,['uid'=>$uid]);



                    if($remark=="SCR -> CAT") {


                        $current_date=date("Y-m-d");
                        $check=is_data_from_table('fil_trap_seq',['ddate'=>$current_date,'utype'=>'CAT','user_type'=>$fil_type],'id','R');
                        if (empty($check)) {
                            $insert_fil_trap_seq = [
                                'ddate'=>date("Y-m-d"),
                                'utype'=>(!empty($utype)) ? $utype :'',
                                'no'=>(!empty($to_userno)) ? $to_userno :0,
                                'user_type'=>(!empty($fil_type)) ? $fil_type :'',
                                'ctype'=>0,
                                'create_modify' => date("Y-m-d H:i:s"),
                                'updated_by'=>$_SESSION['login']['usercode'],
                                'updated_by_ip'=>getClientIP(),
                            ];
                            $is_insert_fil_trap_seq= insert('fil_trap_seq',$insert_fil_trap_seq);

                        }else{
                            $update_fil_trap_seq = [
                                'no'=>(!empty($check_ava_row['to_userno'])) ? $check_ava_row['to_userno'] :0,
                                'updated_on' => date("Y-m-d H:i:s"),
                                'updated_by'=>$_SESSION['login']['usercode'],
                                'updated_by_ip'=>getClientIP(),
                            ];
                            $is_update_fil_trap_refil_users=update('fil_trap_seq',$update_fil_trap_seq,['ddate'=>$current_date,'utype'=>$utype,'user_type'=>$fil_type]);
                        }



                    }
                    if($fil_type=='E' and $remark!="SCR -> CAT") {

                        $update_fil_trap = [
                            'r_by_empid'=>9798,
                            'rece_dt' =>  date("Y-m-d H:i:s"),
                            'comp_dt' =>  date("Y-m-d H:i:s"),

                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by'=>$_SESSION['login']['usercode'],
                            'updated_by_ip'=>getClientIP(),
                        ];
                        $is_update_then_fil_trap=update('fil_trap',$update_fil_trap,['uid'=>$uid]);

                        $message = $this->allot_to_AOR($uid, '9798', 'SCR -> FDR', '1', '', $diary_no);
                        $update_last_return_to_adv_main = [
                            'last_return_to_adv'=>date("Y-m-d H:i:s"),
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by'=>$_SESSION['login']['usercode'],
                            'updated_by_ip'=>getClientIP(),
                        ];
                        $query_to_update_last_return_to_adv_main=update('main',$update_last_return_to_adv_main,['diary_no='=>$diary_no]);



                        return $message;
                    }
                    return $d_to_empid.'~'.$d_to_empname;
                }
            } else  {
                echo "Can't dispatch file because case is not yet registered.";
                $this->db->transComplete();
                exit();
            }
    }
    public function allot_to_CAT($uid)
    {
        $usr_nm=" usertype=59 AND name iLIKE '%CATEGORIZATION%'";
        $check_if_CAT_ava=is_data_from_table('master.users',$usr_nm,'usercode,name as to_name, empid as to_userno','R');
        if(!empty($check_if_CAT_ava)){
            $first_row = $check_if_CAT_ava;

            $this->insert_into_history($uid);
            $get_fil_trap_details=is_data_from_table('fil_trap',['uid'=>$uid],'d_by_empid,r_by_empid','R');
            if (!empty($get_fil_trap_details)){
                $r_by_empid=$get_fil_trap_details['r_by_empid'];
                if (!empty($r_by_empid) && $r_by_empid !=0){
                    $update_fil_trap_r_by_empid = [
                        'd_by_empid'=>$r_by_empid,
                        'updated_on' => date("Y-m-d H:i:s"),
                        'updated_by'=>$_SESSION['login']['usercode'],
                        'updated_by_ip'=>getClientIP(),
                    ];
                    $query_to_update_fil_trap_r_by_empid=update('fil_trap',$update_fil_trap_r_by_empid,['uid='=>$uid]);
                    if ($query_to_update_fil_trap_r_by_empid){
                        $update_then_fil_trap = [
                            'other'=>$_SESSION['login']['empid'],
                            'd_to_empid'=>(!empty($first_row['to_userno'])) ? $first_row['to_userno'] :0,
                            'disp_dt' => date("Y-m-d H:i:s"),
                            'remarks' => 'REF -> CAT',
                            'r_by_empid'=>0,
                            'rece_dt' => null,
                            'comp_dt' => null,
                            'disp_dt_seq' => '',

                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by'=>$_SESSION['login']['usercode'],
                            'updated_by_ip'=>getClientIP(),
                        ];
                        $is_update_then_fil_trap=update('fil_trap',$update_then_fil_trap,['uid'=>$uid]);
                    }
                }

            }


            return $first_row['to_userno'].'~'.$first_row['to_name'];
        }
    }

    public function  allot_to_TAG($uid,$fil_type)
    {
        $check_if_TAG_ava=$this->get_concat_empid_name_from_fil_trap_users_allot_to_TAG(106);
        if(!empty($check_if_TAG_ava)){


            $first_row = $check_if_TAG_ava;
            $check_ava_row=$this->check_if_TAG_available_with_fil_trap_seq(106);
            if (!empty($check_ava_row)){
                if($check_ava_row['to_usercode'] == NULL){
                    $check_ava_row['to_userno'] = $first_row['empid'];
                    $check_ava_row['to_name'] = $first_row['name'];
                }
            }else{
                $check_ava_row['to_userno'] = $first_row['empid'];
                $check_ava_row['to_name'] = $first_row['name'];
            }



            $this->insert_into_history($uid);



            $get_fil_trap_details=is_data_from_table('fil_trap',['uid'=>$uid],'d_by_empid,r_by_empid','R');
            if (!empty($get_fil_trap_details)){
                $r_by_empid=$get_fil_trap_details['r_by_empid'];
                if (!empty($r_by_empid) && $r_by_empid !=0){
                    $update_fil_trap_r_by_empid = [
                        'd_by_empid'=>$r_by_empid,
                        'updated_on' => date("Y-m-d H:i:s"),
                        'updated_by'=>$_SESSION['login']['usercode'],
                        'updated_by_ip'=>getClientIP(),
                    ];
                    $query_to_update_fil_trap_r_by_empid=update('fil_trap',$update_fil_trap_r_by_empid,['uid='=>$uid]);
                    if ($query_to_update_fil_trap_r_by_empid){
                        $update_then_fil_trap = [
                            'other'=>$_SESSION['login']['empid'],
                            'd_to_empid'=>(!empty($first_row['to_userno'])) ? $first_row['to_userno'] :0,
                            'disp_dt' => date("Y-m-d H:i:s"),
                            'remarks' => 'CAT -> TAG',
                            'r_by_empid'=>0,
                            'rece_dt' => null,
                            'comp_dt' => null,
                            'disp_dt_seq' => '',

                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by'=>$_SESSION['login']['usercode'],
                            'updated_by_ip'=>getClientIP(),
                        ];
                        $is_update_then_fil_trap=update('fil_trap',$update_then_fil_trap,['uid'=>$uid]);
                    }
                }

            }




            // $check = "SELECT id FROM fil_trap_seq WHERE ddate=CURDATE() AND utype='TAG' and user_type='$fil_type'"; // commented for efiling

            $check=is_data_from_table('fil_trap_seq',['ddate'=>date("Y-m-d"),'utype'=>'TAG'],'id','R');


            $current_date=date("Y-m-d");
            if (empty($check)) {
                $insert_fil_trap_seq = [
                    'ddate'=>$current_date,
                    'utype'=>'TAG',
                    'no'=>(!empty($check_ava_row['to_userno'])) ? $check_ava_row['to_userno'] :0,
                    'user_type'=>(!empty($fil_type)) ? $fil_type :'',
                    'ctype'=>0,
                    'create_modify' => date("Y-m-d H:i:s"),
                    'updated_by'=>$_SESSION['login']['usercode'],
                    'updated_by_ip'=>getClientIP(),
                ];
                $is_insert_fil_trap_seq= insert('fil_trap_seq',$insert_fil_trap_seq);

            }else{
                $update_fil_trap_seq = [
                    'no'=>(!empty($check_ava_row['to_userno'])) ? $check_ava_row['to_userno'] :0,
                    'updated_on' => date("Y-m-d H:i:s"),
                    'updated_by'=>$_SESSION['login']['usercode'],
                    'updated_by_ip'=>getClientIP(),
                ];
                $is_update_fil_trap_refil_users=update('fil_trap_seq',$update_fil_trap_seq,['ddate'=>$current_date,'utype'=>'TAG']);
            }



            return $check_ava_row['to_userno'].'~'.$check_ava_row['to_name'];
        }
    }
    public function allot_to_AOR($uid,$ucode,$r_remarks,$usertype,$rec_comp,$fil_type,$dno=null)
    {
        $usercode=session()->get('login')['usercode'];
        $empid=session()->get('login')['empid'];
        $usr_nm='';
        $ins_remk='';
        if($r_remarks=='SCR -> FDR')
        {
            $usr_nm=" usertype=59 AND name iLIKE '%ADVOCATE CHAMBER SUB-SECTION%'";
            $ins_remk='FDR -> AOR';


            $update_update_last_return_to_adv_main = [
                'last_return_to_adv'=>date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by'=>$_SESSION['login']['usercode'],
                'updated_by_ip'=>getClientIP(),
            ];
            if (!empty($dno)){
                $query_to_update_last_return_to_adv_main=update('main',$update_update_last_return_to_adv_main,['diary_no='=>$dno]);
            }

        }
        else  if($r_remarks=='FDR -> AOR')
        {
            $usr_nm=" usertype=51 AND name iLIKE '%FILING DISPATCH RECEIVE%'";
            $ins_remk='AOR -> FDR';
        }

        if($r_remarks=='SCR -> FDR' || $r_remarks=='FDR -> AOR')
        {    $first_row=is_data_from_table('master.users',$usr_nm,'usercode, name to_name, empid to_userno','R');

            if(!empty($first_row)){

                $is_insert_into_history=$this->insert_into_history($uid);
                if (!empty($uid) && !empty($first_row['to_userno']) && !empty($ins_remk)){
                    $this->update_fil_trap_by_allot_to_AOR($uid,$first_row['to_userno'],$ins_remk);
                }



                if($r_remarks=='FDR -> AOR')
                {


                    $ck_adv_rec="CASE WHEN d_to_empid=29 THEN 29 else $empid end";
                    $ext_rec=",other =CASE WHEN d_to_empid=$empid THEN 0 else $empid end";
                    if (!empty($uid)){
                        $up_aor_fdr= $this->update_fil_trap_by_case($uid,$ck_adv_rec,$ext_rec);
                    }

                }
                if($rec_comp==2 && $r_remarks!='SCR -> FDR')
                {
                    $given_to = $this->allot_to_SCR($uid,$ucode,$usertype,$fil_type);
                    $given_to = explode('~', $given_to);

                }
                else
                    return $first_row['to_userno'].'~'.$first_row['to_name'];
            }
        }
        else  if($r_remarks=='AOR -> FDR')
        {
           
            $given_to = $this->allot_to_SCR($uid,$ucode,$usertype,$fil_type);
            $given_to = explode('~', $given_to);
            if(count($given_to)==3){
                echo "Completed Successfully And Automatically Allotted to: $given_to[1] [$given_to[0]]".$given_to[2];
                $this->db->transComplete();
                exit();
            }
            else
                echo "Completed Successfully And Automatically Allotted to: $given_to[1] [$given_to[0]]";
            $this->db->transComplete();
            exit();
           

        }
    }

    public function allot_to_SCR($uid,$ucode,$usertype,$fil_type)
    {
        $user_availability='';
        $to_userno=0;
        $to_name='';
        $chk_j_c=0;
        if($ucode=='29' || $usertype=='108') {
            $available = '';
            $role = '';
            $display = '';
            $mark_to_inperson_scr = 0;


            $rs_inperson=$this->check_if_inperson_matter($uid);
            if (!empty($rs_inperson)) {

                $rs_inperson_scr=$this->is_specific_role();
                if (!empty($rs_inperson_scr)) {
                    $mark_to_inperson_scr = 1;
                    $inperson_scr = $rs_inperson_scr['usercode'];
                    $r_get_scr_usr = $to_userno=$rs_inperson_scr['empid'];
                    $r_user_name = $rs_inperson_scr['name'];
                }
            }
            if ($mark_to_inperson_scr == 0)
            {
                $get_diary=is_data_from_table('fil_trap',['uid'=>$uid],'diary_no','R');
                $r_get_diary= $get_diary['diary_no'];
                $refil_user_flag = 0;
                $get_scr_usr=$this->check_who_has_done_scruitny_of_that_matter_when_refiling_comes($r_get_diary);
                if (!empty($get_scr_usr)) {
                    $j = count($get_scr_usr);
                    foreach ($get_scr_usr as $scr_usr) {


                        $user_avail=$this->user_available_done_scruitny_of_that_matter_by_d_to_empid($scr_usr['d_to_empid']);
                        if (!empty($user_avail)) {

                            $available = $user_avail['attend'];
                            $role = $user_avail['usertype'];
                            $display = $user_avail['display'];

                            if ($available == 'P' && $role == '103' && $display == 'Y') {
                                $r_get_scr_usr =$to_userno= $scr_usr['d_to_empid'];
                                $r_user_name = $user_avail['name'];
                                $refil_user_flag = 1;
                                break;
                            }
                        }

                    }

                }
                if ($refil_user_flag == 0) {

                    $check_if_SCR_ava=$this->check_user_fresh_or_first_scrutiny_not_available_then_sequential_refiling_user_allotment($fil_type,103);


                    if (empty($check_if_SCR_ava)) {
                        $user_availability = "";
                        if ($fil_type == 'P') {
                            $fil_type = 'E';
                            $user_availability = " [Counter-Filing Users not available, Marked to E-Filing User] ";
                        } else {
                            $fil_type = 'P';
                            $user_availability = " [E-Filing Users not available, Marked to Counter-Filing User] ";
                        }


                        $check_if_SCR_ava=$this->check_user_fresh_or_first_scrutiny_not_available_then_sequential_refiling_user_allotment($fil_type,103);


                    }


                    if (!empty($check_if_SCR_ava)) {
                        $utype='SCR';
                        $first_row =$check_if_SCR_ava;

                        $next_user = '';

                        $check_ava_row= $this->check_if_SCR_available($fil_type,103,$utype);
                        if (!empty($check_ava_row)) {
                            $next_user = $check_ava_row['to_userno'];
                            $to_userno= $check_ava_row['to_userno'];
                        }else{
                            if (!empty($first_row)){
                                $to_userno = $first_row['empid'];
                                $to_name = $first_row['name'];
                                $next_user = $to_userno;
                            }

                        }

                        $utype = 'SCR';

                        $current_date=date("Y-m-d");
                        $check=is_data_from_table('fil_trap_refil_users',['ddate'=>$current_date,'utype'=>$utype],'','R');
                        if (empty($check)) {
                            $insert_fil_trap_refil_users = [
                                'ddate'=>date("Y-m-d"),
                                'utype'=>$utype,
                                'no'=>(!empty($to_userno)) ? $to_userno :0,
                                'ctype'=>0,
                                'create_modify' => date("Y-m-d H:i:s"),
                                'updated_by'=>$_SESSION['login']['usercode'],
                                'updated_by_ip'=>getClientIP(),
                            ];
                            $is_insert_fil_trap_refil_users= insert('fil_trap_refil_users',$insert_fil_trap_refil_users);

                        }else {


                            $update_fil_trap_refil_users = [
                                'no'=>(!empty($to_userno)) ? $to_userno :0,
                                'updated_on' => date("Y-m-d H:i:s"),
                                'updated_by'=>$_SESSION['login']['usercode'],
                                'updated_by_ip'=>getClientIP(),
                            ];

                            $is_update_fil_trap_refil_users=update('fil_trap_refil_users',$update_fil_trap_refil_users,['ddate'=>$current_date,'utype'=>$utype]);
                        }
                    }
                    $r_get_scr_usr = $to_userno;
                    $r_user_name = $to_name;
                }

                
            }

        }
        else  if($ucode=='9796')
        {



            $diary_no=0;$r_pet_adv_id=0; $r_get_status='';$r_chk_list_bef='';
            $get_diary=is_data_from_table('fil_trap',['uid'=>$uid],'diary_no','R');

            if (!empty($get_diary)){
                $diary_no= $get_diary['diary_no'];
                $chk_list_bef=is_data_from_table('heardt',['diary_no'=>$diary_no],'board_type','R');
                if (!empty($chk_list_bef)){
                    $r_chk_list_bef= $chk_list_bef['board_type'] ;
                }

                $r_pet_adv_id=is_data_from_table('main',['diary_no'=>$diary_no],'c_status,pet_adv_id','R');
                if (!empty($r_pet_adv_id)){
                    $r_get_status=  $r_pet_adv_id['c_status'];
                    $r_pet_adv_id=$r_pet_adv_id['pet_adv_id'];
                }
            }


            if(($r_chk_list_bef=='J' || $r_pet_adv_id=='584') && $r_get_status=='P')
            {



                $check_if_SCR_ava=$this->check_user_fresh_or_first_scrutiny_not_available_then_sequential_refiling_user_allotment($fil_type,107);

                if(!empty($check_if_SCR_ava)){
                    $utype='IB-Ex';
                    $first_row =$check_if_SCR_ava;

                    $check_ava_row= $this->check_if_SCR_available_fil_trap_seq($fil_type,107,$utype);
                    if (empty($check_ava_row)) {
                        $to_userno = $first_row['empid'];
                        $to_name = $first_row['name'];
                    }else{
                        if (!empty($check_ava_row) && $check_ava_row['to_usercode'] == NULL){
                            $to_userno = $first_row['empid'];
                            $to_name = $first_row['name'];
                        }
                    }
                }
            }
            else
            {
                $chk_j_c=1;

                $check_ava_row= $this->get_empid_name_section_name($diary_no);
                if (!empty($check_ava_row)){
                    $to_userno=$check_ava_row['empid'];
                    if($check_ava_row['name']=='') {
                        $to_name = '(' . $check_ava_row['section_name'] . ')';
                    }else {
                        $to_name = $check_ava_row['name'] . '(' . $check_ava_row['section_name'] . ')';
                    }
                }

            }
        }
        else {

           
            $mark_to_inperson_scr = 0;
            $rs_inperson=$this->check_if_inperson_matter($uid);

            if (!empty($rs_inperson)) {

                $rs_inperson_scr=$this->is_specific_role();
                if (!empty($rs_inperson_scr)) {
                    $mark_to_inperson_scr = 1;
                    $inperson_scr = $rs_inperson_scr['usercode'];
                    $r_get_scr_usr = $to_userno=$rs_inperson_scr['empid'];
                    $to_name = $rs_inperson_scr['name'];
                }

            }

            if ($mark_to_inperson_scr == 0) {
                $chk_lc_usr = 0;
                $today = date('Y-m-d');
                $check_marking_rs=is_data_from_table('mark_all_for_scrutiny',['display'=>'Y']);
                if (!empty($check_marking_rs)) {
                    $assign_to = '';
                    $check_random_user=is_data_from_table('master.random_user',['ent_date'=>$today],'empid','R');
                    if (!empty($check_random_user)) {
                        $row = $check_random_user;
                        $assign_to = explode('~', $row['empid']);
                        $to_userno = $assign_to[0];
                        $to_name = $assign_to[1];
                        if (!empty($row['empid'])){
                            $delete_empid = delete('master.random_user',['empid'=>$row['empid'],'ent_date'=>$today]);
                        }

                    } else {

                        $check_if_SCR_ava=$this->get_concat_empid_name_from_fil_trap_users(103);

                        if (!empty($check_if_SCR_ava) > 0) {
                            $empid = array();
                            foreach ($check_if_SCR_ava as $row){
                                array_push($empid, $row['empid']);
                            }
                            shuffle($empid);
                            for ($i = 0; $i < sizeof($empid); $i++) {
                                $assign_to = explode('~', $empid[0]);
                                $to_userno = $assign_to[0];
                                $to_name = $assign_to[1];
                                if ($i > 0) {
                                    $insert_random_user = [
                                        'empid'=>(!empty($empid[$i])) ? $empid[$i] :0,
                                        'ent_date'=>$today,
                                        'create_modify' => date("Y-m-d H:i:s"),
                                        'updated_by'=>$_SESSION['login']['usercode'],
                                        'updated_by_ip'=>getClientIP(),
                                    ];

                                    $is_insert_random_user= insert('master.random_user',$insert_random_user);

                                }
                            }
                        }


                    }
                } else {
                    $check_if_SCR_ava=$this->get_usercode_name_empid_from_fil_trap_users($fil_type,103);

                    if (empty($check_if_SCR_ava)) {

                        $user_availability = "";
                        if ($fil_type == 'P') {
                            $fil_type = 'E';
                            $user_availability = " [Counter-Filing Users not available, Marked to E-Filing User] ";
                        } else {
                            $fil_type = 'P';
                            $user_availability = " [E-Filing Users not available, Marked to Counter-Filing User] ";
                        }


                        $check_if_SCR_ava=$this->get_usercode_name_empid_from_fil_trap_users($fil_type,103);
                    }
                    if (!empty($check_if_SCR_ava)) {
                        $first_row = $check_if_SCR_ava;
                        $next_user = '';
                        $utype = 'SCR';

                        $check_ava_row=$this->check_if_SCR_available_with_fil_trap_seq($fil_type,103,$utype);

                        if (!empty($check_ava_row)) {
                            $next_user = $check_ava_row['to_userno'];
                            $to_userno=$check_ava_row['to_userno'];
                            $to_name=$check_ava_row['to_name'];
                        }else{
                            if (empty($check_ava_row) || $check_ava_row['to_usercode'] == NULL){
                                $to_userno = $first_row['empid'];
                                $to_name = $first_row['name'];
                                $next_user = $to_userno;
                            }

                        }

                    }
                }

                if ($ucode != '29' && $usertype != '108' && $chk_j_c == 0) {
                    $utype = '';
                    if ($ucode == '9796') {
                        $utype = 'IB-Ex';
                    } else {
                        $utype = 'SCR';
                    }
                    if ($chk_lc_usr == 0 || ($to_userno == $next_user && $chk_lc_usr == 1)) {
                        $current_date=date("Y-m-d");
                        $check=is_data_from_table('fil_trap_seq',['ddate'=>$current_date,'utype'=>$utype],'id','R');
                        if (empty($check)) {
                            $insert_fil_trap_seq = [
                                'ddate'=>date("Y-m-d"),
                                'utype'=>(!empty($utype)) ? $utype :'',
                                'no'=>(!empty($to_userno)) ? $to_userno :0,
                                'user_type'=>(!empty($fil_type)) ? $fil_type :'',
                                'ctype'=>0,
                                'create_modify' => date("Y-m-d H:i:s"),
                                'updated_by'=>$_SESSION['login']['usercode'],
                                'updated_by_ip'=>getClientIP(),
                            ];
                            $is_insert_fil_trap_seq= insert('fil_trap_seq',$insert_fil_trap_seq);

                        }else{
                            $update_fil_trap_seq = [
                                'no'=>(!empty($to_userno)) ? $to_userno :0,
                                'updated_on' => date("Y-m-d H:i:s"),
                                'updated_by'=>$_SESSION['login']['usercode'],
                                'updated_by_ip'=>getClientIP(),
                            ];
                            $is_update_fil_trap_refil_users=update('fil_trap_seq',$update_fil_trap_seq,['ddate'=>$current_date,'utype'=>$utype,'user_type'=>$fil_type]);
                        }




                    }
                }
            }
        }
        $this->insert_into_history($uid);
        $remarks='';
        if($_SESSION['login']['empid']=='29' || $usertype=='108')
            $remarks="FDR -> SCR";
        else if($_SESSION['login']['empid']=='9796')
        {
            if($chk_j_c==0)
                $remarks="SCN -> IB-Ex";
            else if($chk_j_c==1)
                $remarks="SCN -> DA";
        }
        else
            $remarks="DE -> SCR";
        $update_then_fil_trap = [
            'd_by_empid'=>$_SESSION['login']['empid'],
            'd_to_empid'=>(!empty($to_userno)) ? $to_userno :0,
            'disp_dt' => date("Y-m-d H:i:s"),
            'remarks' => $remarks,
            'r_by_empid'=>(!empty($to_userno)) ? $to_userno :0,
            'rece_dt' => date("Y-m-d H:i:s"),
            'comp_dt' => null,
            'disp_dt_seq' => '',

            'updated_on' => date("Y-m-d H:i:s"),
            'updated_by'=>$_SESSION['login']['usercode'],
            'updated_by_ip'=>getClientIP(),
        ];
        $is_update_then_fil_trap=update('fil_trap',$update_then_fil_trap,['uid'=>$uid]);
        
        $select_condition="CONCAT(left((cast(diary_no as text)),-4),'/', right((cast(diary_no as text)),4)) as diary_no";
        $rw_diary_no=is_data_from_table('fil_trap',['uid'=>$uid],$select_condition,'R');
        $f_dno='';
        if (!empty($rw_diary_no)){
            $f_dno=$rw_diary_no['diary_no'];
        }

        $mobile_no=0;
        if (!empty($to_userno)){
            $rw_mob=is_data_from_table('master.users',['empid'=>$to_userno],'mobile_no','R');
            if (!empty($rw_mob)){
                $mobile_no=$rw_mob['mobile_no'];
            }
        }

        $message ="Diary No: ".$f_dno." alloted to you for Scrutiny/Rechecking"."- Supreme Court of India";
        if($mobile_no ==0)
        {
            echo " SMS could not be sent to " .$to_userno."-".$to_name  . " as no mobile number is updated in ICMIS";
        }
        else
        {
            /* $_REQUEST[mob]=$mobile_no;
             $_REQUEST[sms_status]='scrutiny';
             $_REQUEST[msg]=$message;
             include('../sms/send_sms.php');*/
            /* $sql_sms="insert into sms_pool(mobile,msg,c_status,table_name,ent_time) values ('$mobile_no','$message','N','scr_user',now())";
             $rs_sms=mysql_query($sql_sms);
             if($rs_sms)
             {
                // echo "SMS sent successfully to ".$to_userno."-".$to_name;
                // echo "SMS sent";
             }*/
        }
      



        if($ucode=='29' || $usertype=='108') {
            if($user_availability!='')
                return $r_get_scr_usr . '~' . $r_user_name.'~'.$user_availability;
            else
                return $r_get_scr_usr . '~' . $r_user_name;
        }
        else {
            if($user_availability!='')
                return $to_userno.'~'.$to_name.'~'.$user_availability;
            else
                return $to_userno.'~'.$to_name;
        }
    }


  

    public function check_duplicate_token($t) {
        $duplicate=0;
        $query = "select * from (Select token_no from fil_trap where date(disp_dt)=CURRENT_DATE and
            token_no='$t' and (remarks='AOR -> FDR')
            union
            Select token_no from fil_trap_his where  date(disp_dt)=CURRENT_DATE and
            token_no='$t' and (remarks='AOR -> FDR'))a where token_no='$t'";

        $query = $this->db->query($query);
        if($query->getNumRows() >= 1) {
            $duplicate=1;
        }
        return $duplicate;
    }
    

    public function check_if_inperson_matter($uid){

        $builder = $this->db->table("fil_trap f");
        $builder->select("*");
        $builder->JOIN('main a', 'f.diary_no=a.diary_no');
        $builder->whereIn('a.pet_adv_id',[584,666]);
        $builder->where('f.uid', $uid);
        $query = $builder->get();
        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return $result;
        } else {
            return false;
        }
    }
    public function is_specific_role(){

        $builder = $this->db->table('master.specific_role s');
        $builder->select("u.usercode,u.empid,u.name");
        $builder->JOIN('master.users u', 's.usercode=u.usercode');
        $builder->where('s.flag', 'P');
        $builder->where('u.display', 'Y');
        $builder->where('s.display', 'Y');
        $builder->orderBy('s.usercode','RANDOM');
        $query = $builder->get(1);
        if ($query->getNumRows() >= 1) {
            $result = $query->getRowArray();
            return $result;
        } else {
            return false;
        }
    }


    public function check_who_has_done_scruitny_of_that_matter_when_refiling_comes($diary_no){
        $get_scr_usr = "select  distinct(d_to_empid),uid from (Select d_to_empid,uid from fil_trap_his where diary_no='$diary_no' and (remarks='DE -> SCR' or remarks='FDR -> SCR'))a join master.users u on a.d_to_empid=u.empid where u.display='Y' and u.section=19 order by uid asc limit 2 ";

        $query = $this->db->query($get_scr_usr);
        if($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return $result;
        }else{return false;}
    }
    public function user_available_done_scruitny_of_that_matter_by_d_to_empid($d_to_empid){
        $builder = $this->db->table('fil_trap_users a');
        $builder->select("b.attend,a.usertype,a.display,b.name");
        $builder->JOIN('master.users b', 'a.usercode=b.usercode');
        $builder->where('b.empid', $d_to_empid);
        $builder->orderBy('a.ent_dt','desc');
        $builder->orderBy('a.usercode','RANDOM');
        $query = $builder->get(1);
        if ($query->getNumRows() >= 1) {
            $result = $query->getRowArray();
            return $result;
        } else {
            return false;
        }

    }
    public function check_user_fresh_or_first_scrutiny_not_available_then_sequential_refiling_user_allotment($fil_type,$usertype){
        
        $query = $this->db->table('fil_trap_users a')
            ->select('a.usercode, b.name, b.empid')
            ->join('master.users b', 'a.usercode = b.usercode')
            ->where('a.usertype', $usertype)
            ->where('a.display', 'Y')
            ->where('b.display', 'Y')
            ->where('b.attend', 'P')
            ->where('a.user_type', $fil_type)
            ->orderBy('a.usercode','RANDOM')
            ->get();
        if ($query->getNumRows() >= 1) {
            $result = $query->getRowArray();
            return $result;
        } else {
            return false;
        }
    }

    public function check_if_SCR_available($fil_type,$usertype,$utype){

        $query = $this->db->table('fil_trap_users a')
            ->select('a.usercode as to_usercode, b.name as to_name, b.empid as to_userno, c.ddate, c.no as curno')
            ->join('master.users b', 'a.usercode = b.usercode')
            ->join('fil_trap_refil_users c', 'c.no < b.empid', 'left')
            ->where('a.usertype', $usertype)
            ->where('a.display', 'Y')
            ->where('b.display', 'Y')
            ->where('b.attend', 'P')
            ->where('c.utype', $utype)
            ->where('c.ddate', "(SELECT c.ddate FROM fil_trap_seq WHERE c.utype='SCR' AND a.user_type='$fil_type' ORDER BY c.ddate DESC LIMIT 1)", false)
            
            ->orderBy('to_userno ASC,c.ddate DESC')
            ->orderBy('a.usercode','RANDOM')
            ->get(1);

        if ($query->getNumRows() >= 1) {
            $result = $query->getRowArray();
            return $result;
        } else {
            return false;
        }
    }

    public function check_if_SCR_available_fil_trap_seq($fil_type,$usertype,$utype){

        $current_date=date("Y-m-d");
        $query = $this->db->table('fil_trap_users a')
            ->select('a.usercode as to_usercode, b.name as to_name, b.empid as to_userno, c.ddate, c.no as curno')
            ->join('master.users b', 'a.usercode = b.usercode')
            ->join('fil_trap_seq c', 'c.no < b.empid', 'left')
            ->where('a.usertype', $usertype)
            ->where('a.display', 'Y')
            ->where('b.display', 'Y')
            ->where('b.attend', 'P')
            ->where('c.utype', $utype)
            ->where('c.ddate', $current_date)
            ->where('a.user_type', $fil_type)
            ->where('c.user_type', $fil_type)
            ->orderBy('to_userno')
            ->orderBy('a.usercode','RANDOM')
            ->get(1);
        if ($query->getNumRows() >= 1) {
            $result = $query->getRowArray();
            return $result;
        } else {
            return false;
        }
    }

    public function check_if_SCR_available_with_fil_trap_seq($fil_type,$usertype,$utype){

        $query = $this->db->table('fil_trap_users a')
            ->select('a.usercode as to_usercode, b.name as to_name, b.empid as to_userno, c.ddate, c.no as curno')
            ->join('master.users b', 'a.usercode = b.usercode')
            ->join('master.specific_role s', "a.usercode=s.usercode AND s.display = 'Y' AND s.flag = 'P'", 'left')
            ->join('fil_trap_seq c', 'c.no < b.empid', 'left')
            ->where('s.id', null)
            ->where('a.usertype', $usertype)
            ->where('a.display', 'Y')
            ->where('b.display', 'Y')
            ->where('b.attend', 'P')
            ->where('a.user_type', $fil_type)
            ->where('c.user_type', $fil_type)
            ->where('c.utype', $utype)
            ->where('a.user_type', $fil_type)
            ->where('ddate', "(SELECT ddate FROM fil_trap_seq WHERE utype='SCR' AND user_type='$fil_type' ORDER BY ddate DESC LIMIT 1)", false)
            ->orderBy('c.ddate', 'DESC')
            ->get();
        if ($query->getNumRows() >= 1) {
            $result = $query->getRowArray();
            return $result;
        } else {
            return false;
        }
    }

    public function check_if_TAG_available_with_fil_trap_seq($usertype){

        $query = $this->db->table('fil_trap_users a')
            ->select('a.usercode as to_usercode, b.name as to_name, b.empid as to_userno, c.ddate, c.no as curno')
            ->join('master.users b', 'a.usercode = b.usercode')
            ->join('fil_trap_seq c', 'c.no < b.empid', 'left')
            ->where('a.usertype', $usertype)
            ->where('a.display', 'Y')
            ->where('b.display', 'Y')
            ->where('b.attend', 'P')
            ->where('c.utype', 'TAG')
            ->where('c.ddate', date("Y-m-d"))
            ->orderBy('c.ddate', 'DESC')
            ->orderBy('a.usercode','RANDOM')
            ->get(1);
        if ($query->getNumRows() >= 1) {
            $result = $query->getRowArray();
            return $result;
        } else {
            return false;
        }
    }
    public function get_empid_name_section_name($diary_no,$usertype=14){

        $query = $this->db->table('main a')
            ->select('b.empid,b.name,c.section_name')
            ->join('master.users b', 'a.dacode=b.usercode')
            ->join('master.usersection c', 'c.id=b.section', 'left')
            ->where('a.diary_no', $diary_no)
            ->where('b.display', 'Y')
            ->get(1);
        if ($query->getNumRows() >= 1) {
            return $query->getRowArray();
        } else {
            $query2 = $this->db->table('main a')
                ->select('b.empid,b.name,c.section_name')
                ->join('master.users b', "a.section_id=b.section and b.usertype='$usertype'")
                ->join('master.usersection c', 'c.id=b.section', 'left')
                ->where('a.diary_no', $diary_no)
                ->where('b.display', 'Y')
                ->get(1);
            if ($query2->getNumRows() >= 1) {
                return $query2->getRowArray();
            } else {
                return false;
            }
        }
    }
    public function get_concat_empid_name_from_fil_trap_users($usertype){

        $query = $this->db->table('fil_trap_users a')
            ->select("CONCAT(b.empid, '~', b.name) as empid")
            ->join('master.users b', 'a.usercode = b.usercode')
            ->Join('master.specific_role s', "a.usercode = s.usercode AND s.display = 'Y' AND s.flag = 'P'",'left')
            ->where('s.id', null)
            ->where('a.usertype', $usertype)
            ->where('a.display', 'Y')
            ->where('b.display', 'Y')
            ->where('b.attend', 'P')
            ->orderBy('a.usercode','RANDOM')
            ->get();
        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return $result;
        } else {
            return false;
        }
    }
    public function get_concat_empid_name_from_fil_trap_users_allot_to_TAG($usertype){
        $query = $this->db->table('fil_trap_users a')
            ->select("a.usercode,b.name,b.empid")
            ->join('master.users b', 'a.usercode = b.usercode')
            ->where('a.usertype', $usertype)
            ->where('a.display', 'Y')
            ->where('b.display', 'Y')
            ->where('b.attend', 'P')
            ->orderBy('a.usercode','RANDOM')
            ->get();
        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return $result;
        } else {
            return false;
        }
    }
    public function get_usercode_name_empid_from_fil_trap_users($fil_type,$usertype){
        $query = $this->db->table('public.fil_trap_users a')
            ->select('a.usercode, b.name, b.empid')
            ->join('master.users b', 'a.usercode = b.usercode')
            ->Join('master.specific_role s', "a.usercode = s.usercode AND s.display = 'Y' AND s.flag = 'P'",'left')
            ->where('s.id', null)
            ->where('a.usertype', $usertype)
            ->where('a.display', 'Y')
            ->where('b.display', 'Y')
            ->where('b.attend', 'P')
            ->where('a.user_type', $fil_type)
            ->get();
        if ($query->getNumRows() >= 1) {
            $result = $query->getRowArray();
            return $result;
        } else {
            return false;
        }
    }
    public function check_main_with_docdetails_docmaster($diary_no){

        $builder = $this->db->table('public.main a');
        $builder->select('a.diary_no');
        $builder->join('public.docdetails b', 'a.diary_no = b.diary_no');
        $builder->join('master.docmaster c', 'b.doccode = c.doccode AND b.doccode1 = c.doccode1');
        $builder->where('a.c_status', 'P');
        $builder->where('b.display', 'Y');
        $builder->where('a.diary_no', $diary_no);
        $builder->where('(c.not_reg_if_pen = 1 OR c.not_reg_if_pen = 2)');
        $builder->where('b.iastat', 'P');
        $builder->orderBy('b.doccode','RANDOM');;
         $query = $builder->get();
        $result = $query->getResultArray();
        return $result;
    }

    public function get_report_complete($data){

        $builder = $this->db->table('public.main a');
        $builder->select('a.diary_no');
        $builder->join('public.docdetails b', 'a.diary_no = b.diary_no');
        $builder->join('master.docmaster c', 'b.doccode = c.doccode AND b.doccode1 = c.doccode1');
        $builder->where('a.c_status', 'P');
        $builder->where('b.display', 'Y');
        $builder->where('(c.not_reg_if_pen = 1 OR c.not_reg_if_pen = 2)');
        $builder->where('b.iastat', 'P');
        $builder->orderBy('b.doccode','RANDOM');;
        $query = $builder->get();
        $result = $query->getResultArray();
        return $result;
    }
}