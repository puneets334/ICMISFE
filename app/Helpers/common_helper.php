<?php
/**
 * Created by PhpStorm.
 * User: Anshu
 * Date: 26/8/23
 * Time: 11:30 AM
 */
function sanitize($val){
    $val = preg_replace('/string:/','',$val);
    return $val;
}
function encrypt($val){
    $encrypter = \Config\Services::encrypter();
    $enc_id=bin2hex($encrypter->encrypt($val));
    return $enc_id;
}
function decrypt($val){
    $encrypter = \Config\Services::encrypter();
    $dec_id=$encrypter->decrypt(hex2bin($val));
    return $dec_id;
}
function url_encryption($val){
    $encrypter = \Config\Services::encrypter();
    $enc_id=bin2hex($encrypter->encrypt($val));
    return $enc_id;
}
function url_decryption($val){
    $encrypter = \Config\Services::encrypter();
    $dec_id=$encrypter->decrypt(hex2bin($val));
    return $dec_id;
}
function insert($table_name,$data)
{   $db = \Config\Database::connect();
    $builder = $db->table($table_name);
    if($builder->insert($data)) {
        return true;
    }else{return false;}
}
function update($table_name,$data,$condition)
{   $db = \Config\Database::connect();
    $builder = $db->table($table_name);
    $builder->where($condition);
    if($builder->update($data)) {
        return true;
    }else{return false;}
}
function is_data_from_table($table,$condition=null,$column_names='*',$row='A')
{
    $db = \Config\Database::connect();
    $builder = $db->table($table);
    if (!empty($condition) && $condition != null) {
        $query = $builder->select($column_names)->where($condition)->get();
    } else {
        $query = $builder->select($column_names)->get();
    }
    //echo $db->getLastQuery();
    //exit;
    if ($query->getNumRows() >= 1) {
        if($row=='A'){ $result = $query->getResultArray();}else{$result = $query->getRowArray();}
        return $result;
    } else {
        return false;
    }
}

function unique_multidim_array($array, $key) {
    $temp_array = array(); $i = 0; $key_array = array(); foreach($array as $val) { if (!in_array($val[$key], $key_array)) { $key_array[$i] = $val[$key]; $temp_array[$i] = $val; } $i++; }
    return $temp_array;
}
function exists_from_table($table,$col_name1,$col_str1,$col_name2=null,$col_str2=null,$column_names='*')
{
    if (!empty($col_name2) && !empty($col_str2) != null) {
        $lower=strtolower($col_str1);$lower2=strtolower($col_str2);
        for ($x = 1; $x <= 5; $x++) {
            if ($x==1){$text=$lower; $text2=$lower2;}elseif ($x==2){$text=strtoupper($lower); $text2=strtoupper($lower2);}elseif ($x==3){$text=ucwords($lower); $text2=ucwords($lower2);}elseif ($x==4){$text=ucfirst($lower); $text2=ucfirst($lower2);}elseif ($x==5){$text=lcfirst($lower); $text2=lcfirst($lower2);}
            $query =is_data_from_table($table,[$col_name1 => $text,$col_name2 => $text2, 'is_deleted' => false],$column_names);
            if ($query && !empty($query) && $query != false) { return $query; }
        }
    }elseif (!empty($col_name1) && $col_name1 != null) {
        $lower=strtolower($col_str1);
        for ($x = 1; $x <= 5; $x++) {
            if ($x==1){$text=$lower;}elseif ($x==2){$text=strtoupper($lower);}elseif ($x==3){$text=ucwords($lower);}elseif ($x==4){$text=ucfirst($lower);}elseif ($x==5){$text=lcfirst($lower);}
            $query =is_data_from_table($table,[$col_name1 => $text, 'is_deleted' => false],$column_names);
            if ($query && !empty($query) && $query != false) { return $query; }
        }
    } else {
        $query =is_data_from_table($table,'',$column_names);
    }
    if (!empty($query) && count($query) >= 1) {
        return $query;
    } else {
        return false;
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 16)
    {

        // generates random string for login salt

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
if (!function_exists('get_diff_two_date')) {
    function get_diff_two_date($date1, $date2)
    {

        // Declare and define two dates
        //$date1 = strtotime("2016-06-01 22:45:00");
        // $date2 = strtotime("2018-09-21 10:44:01");
        $date1 = strtotime($date1);
        $date2 = strtotime($date2);

        // Formulate the Difference between two dates
        $diff = abs($date2 - $date1);

        // To get the year divide the resultant date into
        // total seconds in a year (365*60*60*24)
        $years = floor($diff / (365 * 60 * 60 * 24));

        // To get the month, subtract it with years and
        // divide the resultant date into
        // total seconds in a month (30*60*60*24)
        $months = floor(($diff - $years * 365 * 60 * 60 * 24)
            / (30 * 60 * 60 * 24));

        // To get the day, subtract it with years and
        // months and divide the resultant date into
        // total seconds in a days (60*60*24)
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
                $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

        // To get the hour, subtract it with years,
        // months & seconds and divide the resultant
        // date into total seconds in a hours (60*60)
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24
                - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
            / (60 * 60));

        // To get the minutes, subtract it with years,
        // months, seconds and hours and divide the
        // resultant date into total seconds i.e. 60
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24
                - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
                - $hours * 60 * 60) / 60);

        // To get the minutes, subtract it with years,
        // months, seconds, hours and minutes
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24
            - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
            - $hours * 60 * 60 - $minutes * 60));
        $totalMinutes = ($hours * 60) + ($minutes);
        return $result = ['years' => $years, 'months' => $months, 'days' => $days, 'hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds, 'totalMinutes' => $totalMinutes];
        // Print the result
        /*printf("%d years, %d months, %d days, %d hours, "
             . "%d minutes, %d seconds", $years, $months,
                     $days, $hours, $minutes, $seconds);*/

    }
}

// Code Starts Here By- P.S

function get_advocate_mobile_number($diary_no,$party_type)
{
    $mobile = '';
    $db = \Config\Database::connect();
    $builder = $db->table("advocate a", false);
    $builder->select("mobile", false);
    $builder->join('master.bar b ', 'a.advocate_id=b.bar_id', 'inner', false);
    $builder->where('a.diary_no',  $diary_no)->where('a.display', 'Y')->where('a.pet_res',$party_type);
    $query2 = $builder->get();

    if ($query2->getNumRows() > 0)
    {
//        echo "FDSAF";
        $result = $query2->getResultArray();
//        echo $db->getLastQuery();exit;
        foreach($result as $row)
        {
            if ($row['mobile'] != '' && strlen($row['mobile']) == '10')
            {
                if ($mobile == '') {
                    $mobile = $row['mobile'];
                    return $mobile;
                }
                else{
                    $mobile = $mobile . ',' . $row['mobile'];
                    return $mobile;
                }

            }
        }

    }

}

function get_party_mobile_number($diary_no,$party_type)
{
    $mobile = '';
    $db = \Config\Database::connect();
    $builder = $db->table('party');
    $builder->select("contact");
    $builder->where('diary_no',$diary_no)->where('pet_res', $party_type);
    $query = $builder->get();

    if ($query->getNumRows() > 0)
    {
        $result = $query->getResultArray();
        foreach($result as $r_party)
        {
            if ($r_party['contact'] != '' && strlen($r_party['contact']) == '10')
            {
                if ($mobile == '') {
                    $mobile = $r_party['contact'];
                    return $mobile;
                }else{
                    $mobile = $mobile . ',' . $r_party['contact'];
                    return $mobile;
                }

            }
        }

    }

}

function component_case_status_process_tab($diary_no=''){
    $html="";
    $data = getCaseDetails($diary_no);
    $data['component']='component_for_case_status_process';
    $html=view('Common/Component/case_status/case_status_process_tab',$data);
    return $html;
}

function component_case_status_process_popup($diary_no=''){
    $html="";
    $data = getCaseDetails($diary_no);
    $data['component']='component_for_case_status_process_popup';
    $html=view('Common/Component/case_status/case_status_process',$data);
    return $html;
}


function component_EarlierCourt_tab($diary_no=''){
    $html="";
    $data = getEarlierCourtData($diary_no);
    $data['component']='component_for_EarlierCourt';
    $html=view('Common/Component/case_status/get_EarlierCourt',$data);
    return $html;
}




function get_main_case($main_diary_number,$flag)
{
    $main_case = "";
    $db = \Config\Database::connect();

    $builder1 = $db->table("main".$flag);
    $builder1->select("conn_key,active_casetype_id,casetype_id,active_fil_no,active_reg_year,diary_no");
    $builder1->where('diary_no', $main_diary_number);
    $builder1->where('conn_key is not null');
    $builder1->where('conn_key !=','');
    $query = $builder1->get(1);


    $outer_array = array();
    if ($query->getNumRows() >= 1) {

        $main = $query->getRowArray();

        $active_casetype_id = $main['active_casetype_id'];
        $casetype_id = $main['casetype_id'];

        if(empty($active_casetype_id)){
            $case_code = $casetype_id;
        }else{
            $case_code = $active_casetype_id;
        }

        $case_type_details = is_data_from_table('master.casetype',['casecode'=>$case_code],'*','R');

        if (!empty($case_type_details)) {
            $res = $case_type_details;

            if ($main['active_fil_no'] != '' && $main['active_fil_no'] != null) {
                $main_case = $res['short_description'] . " " . substr($main['active_fil_no'], 3) . "/" . $main['active_reg_year'];
            } else {
                $main_case = $res['short_description'] . " Diary no. " . substr($main['diary_no'], 0, strlen($main['diary_no']) - 4) . "/" . substr($main['diary_no'], -4);
            }
        }
    }

    return $main_case;
}

function send_sms($mobile,$message,$from,$templateId)
{

    if(empty($mobile)){
        return " Mobile No. Empty.";

    }
    else if(empty($message)){
        return " Message content Empty.";

    }
    else if(strlen($message) > 320){
        return " Message length should be less than 320 characters.";

    }
    else if(empty($from)){
        return " Sender Information Empty, contact to server room.";

    }
    else if(strlen($mobile) != '10'){
        return " Not a Proper Mobile No.";

    }
    else{
        $db = \Config\Database::connect();
        $fromAddress = trim($from);
        $smsLength = explode(",", trim($mobile));
        $count_sms = count($smsLength);
        $srno = 1;


        for($i=0; $i<$count_sms;$i++){
            echo "<br/>";
            if(strlen(trim($smsLength[$i])) != '10'){
                return " ".$srno++." ".$smsLength[$i]." Not a proper mobile number. \n";
            }
            else if(!is_numeric($smsLength[$i])){
                //not a numeric value
                return " ".$srno++." ".$smsLength[$i]." Mobile number contains invalid value. \n";
            }
            else{
                //header('Content-type: application/json;');
                $mm = trim($smsLength[$i]);
                $homepage = file_get_contents('http://10.2/eAdminSCI/a-push-sms-gw?mobileNos='.$mm.'&message='.urlencode($message).'&typeId=29&myUserId=NIC001001&myAccessId=root&authCode='.SMS_KEY.'&templateId='.$templateId);

                $json = json_decode($homepage);
                if($json->{'responseFlag'} == "success"){
//                    $sql = "INSERT INTO sms_pool (mobile,msg,table_name,c_status,ent_time,update_time, template_id) VALUES ('$mm','$cnt','$frm_adr','Y',NOW(),Now(),'$templateId')";
//                    mysql_query($sql) or die(mysql_errno());

                    $columnsData = array(
                        'mobile' => $mobile,
                        'msg' => $message,
                        'table_name' => $from,
                        'c_status' => 'Y',
                        'ent_time' => date("Y-m-d H:i:s"),
                        'template_id'=>$templateId,
                        'create_modify' => date("Y-m-d H:i:s"),
                        'updated_on' => date("Y-m-d H:i:s"),
                        'updated_by' => session()->get('login')['usercode'],
                        'updated_by_ip' => getClientIP()
                    );

                    $builder = $db->table('sms_pool');
                    $query1 = $builder->insert($columnsData);
                    return "Message Sent Successfully ";
//                    echo "  ".$srno++."  ".$smsLength[$i]."Success. SMS Sent \n";

                }
                else{
//                    $sql = "INSERT INTO sms_pool (mobile,msg,table_name,c_status,ent_time, template_id) VALUES ('$mm','$cnt','$frm_adr','N',NOW(),'$template_id')";
//                    mysql_query($sql) or die(mysql_errno());
                    $columnsData = array(
                        'mobile' => $mobile,
                        'msg' => $message,
                        'table_name' => $from,
                        'c_status' => 'N',
                        'ent_time' => date("Y-m-d H:i:s"),
                        'template_id'=>$templateId,
                        'create_modify' => date("Y-m-d H:i:s"),
                        'updated_on' => date("Y-m-d H:i:s"),
                        'updated_by' => session()->get('login')['usercode'],
                        'updated_by_ip' => getClientIP()
                    );

                    $builder = $db->table('sms_pool');
                    $query1 = $builder->insert($columnsData);

                    return "Error Message Not Sent ";

//                    echo " ".$srno++." ".$smsLength[$i]." Error:Not Sent, SMS may send later. \n";
                }
            }
        }

    }

}

function is_table_a($table_name){
    if (isset($_SESSION['filing_details'])) {
        $c_status=session()->get('filing_details')['c_status'];
        if (!empty($c_status) && $c_status=='D') { return $table_name.'_a';}
    }
    return $table_name;
}

function delete($table_name,$condition)
{   $db = \Config\Database::connect();
    $builder = $db->table($table_name);
    if($builder->delete($condition)) {
        return true;
    }else{return false;}
}
function allot_to_EC($diary_no,$ucode,$fil_type=null)
{
    $db = \Config\Database::connect();
    $today=date('Y-m-d');
    $current_date=date("Y-m-d");
    $current_date_time=date("Y-m-d H:i:s");
    $user_availability='';
    $check_marking=is_data_from_table('mark_all_for_hc',['display'=>'Y']);
    if($check_marking && !empty($check_marking)) {
        $check_qr=is_data_from_table('master.random_user_hc',['ent_date'=>$today],'empid','R');
        if (!empty($check_qr) && $check_qr){
            $empid=$check_qr['empid'];
            $assign_to=explode('~',$check_qr['empid']);
            $check_ava_row['to_userno']=$assign_to[0];
            $check_ava_row['to_name']=$assign_to[1];
            $delete_empid = delete('master.random_user_hc',['empid'=>$empid,'ent_date'=>$today]);
        }
        else{
            $check_if_EC_ava=get_fil_trap_users_empid(102);
            if (!empty($check_if_EC_ava) && $check_if_EC_ava) {
                $empid=array();
                foreach ($check_if_EC_ava as $row){
                    array_push($empid,$row['empid']);
                }
                shuffle($empid);
                for($i=0;$i<sizeof($empid);$i++){
                    $assign_to=explode('~',$empid[0]);
                    $check_ava_row['to_userno']=$assign_to[0];
                    $check_ava_row['to_name']=$assign_to[1];
                    if($i>0) {
                        $insert_random_user_hc = [
                            'empid'=>$empid[$i],
                            'ent_date'=>$today,

                            'create_modify' => date("Y-m-d H:i:s"),
                            'updated_by'=>$_SESSION['login']['usercode'],
                            'updated_by_ip'=>getClientIP(),
                        ];
                        $is_insert_random_user_hc= insert('master.random_user_hc',$insert_random_user_hc);

                    }
                }
            }
        }
    }
    else {
        $check_ava_row=array();
        $condition="and a.user_type='$fil_type'";
        $check_if_EC_ava=get_fil_trap_users_empid(102,$fil_type);

        if (empty($check_if_EC_ava)) {
            if ($fil_type == 'P') {
                $fil_type = 'E';
                $user_availability = " [Counter-Filing Users not available, Marked to E-Filing User] ";
            } else {
                $fil_type = 'P';
                $user_availability = " [E-Filing Users not available, Marked to Counter-Filing User] ";
            }
        }
        if (!empty($check_if_EC_ava) && $check_if_EC_ava) {
            $assign_to=explode('~',$check_if_EC_ava[0]['empid']);
            $first_row['empid']=$assign_to[0];
            $first_row['name']=$assign_to[1];

            $check_ava_row=get_fil_trap_users_with_fil_trap_seq($fil_type,'102','DE','R');

            if (empty($check_ava_row)) {
                $check_ava_row['to_userno'] = $first_row['empid'];
                $check_ava_row['to_name'] = $first_row['name'];
            }else{
                if (!empty($check_ava_row)) {
                    if ($check_ava_row['to_usercode']==NULL) {
                        $check_ava_row['to_userno'] = $first_row['empid'];
                        $check_ava_row['to_name'] = $first_row['name'];
                    }
                }
            }
        }
    }

    $select_for_deleted_filno=is_data_from_table('fil_trap',['diary_no'=>$diary_no],'diary_no');
    if ($select_for_deleted_filno && !empty($select_for_deleted_filno)){
        $update_casemove=delete('fil_trap',['diary_no'=>$diary_no]);
    }

    $select_for_deleted_filno_his=is_data_from_table('fil_trap_his',['diary_no'=>$diary_no],'diary_no');
    if ($select_for_deleted_filno_his && !empty($select_for_deleted_filno_his)){
        $update_casemove_his=delete('fil_trap_his',['diary_no'=>$diary_no]);
    }
    $insert_then = [
        'diary_no'=>$diary_no,
        'd_to_empid'=>$check_ava_row['to_userno'],
        'disp_dt'=>$current_date_time,
        'd_by_empid'=>$_SESSION['login']['empid'],
        'remarks'=>'FIL -> DE',
        'r_by_empid'=>0,
        'other'=>0,

        'create_modify' => date("Y-m-d H:i:s"),
        'updated_by'=>$_SESSION['login']['usercode'],
        'updated_by_ip'=>getClientIP(),
    ];
    $insert_then_result= insert('fil_trap',$insert_then);

    $check_fil_trap_seq=is_data_from_table('fil_trap_seq',['ddate'=>$current_date,'utype'=>'DE','user_type'=>$fil_type],'id');
    if (empty($check_fil_trap_seq)){
        $insert_query = [
            'ddate'=>$current_date_time,
            'utype'=>'DE',
            'no'=>$check_ava_row['to_userno'],
            'user_type'=>$fil_type,
            'ctype'=>0,
            'create_modify' => date("Y-m-d H:i:s"),
            'updated_by'=>$_SESSION['login']['usercode'],
            'updated_by_ip'=>getClientIP(),
        ];
        $insert_query_result= insert('fil_trap_seq',$insert_query);
    }else{
        $update_query = [
            'no'=>$check_ava_row['to_userno'],

            'updated_on' => date("Y-m-d H:i:s"),
            'updated_by'=>$_SESSION['login']['usercode'],
            'updated_by_ip'=>getClientIP(),
        ];
        $update_condition=['ddate'=>$current_date,'utype'=>'DE','user_type'=>'P'];
        $update_query_result=update('fil_trap_seq',$update_query,$update_condition);
    }
    if($user_availability!=''){
        $final_response=$check_ava_row['to_userno'].'~'.$check_ava_row['to_name'].'~'.$user_availability;
    }else{
        $final_response=$check_ava_row['to_userno'].'~'.$check_ava_row['to_name'];
    }
    return $final_response;
}
function get_fil_trap_users_empid($usertype,$user_type=null,$row='A')
{
    $db = \Config\Database::connect();
    $builder = $db->table('fil_trap_users a');
    $builder->select("CONCAT(b.empid, '~', b.name) as empid");
    $builder->join('master.users b', 'a.usercode = b.usercode');
    $builder->Join('master.specific_role s', "a.usercode = s.usercode AND s.display = 'Y' AND s.flag = 'P'",'left');
    $builder->where('s.id', null);
    $builder->where('a.usertype', $usertype);
    if (!empty($user_type) && $user_type != null) { $builder->where('a.user_type', $user_type); }
    $builder->where('a.display', 'Y');
    $builder->where('b.display', 'Y');
    $builder->where('b.attend', 'P');
    $builder->orderBy('empid');
    $query = $builder->get();
    if ($query->getNumRows() >= 1) {
        if($row=='A'){ $result = $query->getResultArray();}else{$result = $query->getRowArray();}
        return $result;
    } else {
        return false;
    }
}
function get_fil_trap_users_with_fil_trap_seq($fil_type,$usertype,$utype,$row='A'){
    $db = \Config\Database::connect();
    $current_date=date("Y-m-d");
    $query = $db->table('fil_trap_users a')
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
        ->get();
    if ($query->getNumRows() >= 1) {
        if($row=='A'){ $result = $query->getResultArray();}else{$result = $query->getRowArray();}
        return $result;
    } else {
        return false;
    }
}
function check_duplicate_token($t) {
    $db = \Config\Database::connect();
    $duplicate=0;
    $builder = $db->table('fil_trap');
    $builder->select('token_no')
        ->where('DATE(disp_dt) = CURRENT_DATE')
        ->where('token_no', $t)
        ->where("(remarks='AOR -> FDR')");

    $builder->orWhere(function ($builder) use ($t) {
        $builder->table('fil_trap_his')
            ->select('token_no')
            ->where('DATE(disp_dt) = CURRENT_DATE')
            ->where('token_no', $t)
            ->where("(remarks='AOR -> FDR')");
    });
    $query = $builder->get();
    if ($query->getNumRows() >= 1) {
        $duplicate=1;
    }
    return $duplicate;
}

/* Added by Shilpa on 06-12-20238 -- Start*/

function is_data_from_table_whereIn($table,$key=null,$arrv=null,$column_names='*',$row='A')
{
    $db = \Config\Database::connect();
    $builder = $db->table($table);
    if (!empty($arrv) && $arrv != null && !empty($key) && $key != null) {
        $query = $builder->select($column_names)->whereIn($key,$arrv)->get();
    } else {
        $query = $builder->select($column_names)->get();
    }
    if ($query->getNumRows() >= 1) {
        if($row=='A'){ $result = $query->getResultArray();}else{$result = $query->getRowArray();}
        return $result;
    } else {
        return false;
    }
}

/* Added by Shilpa on 06-12-20238 -- End*/


/* Added by P.S on 02-01-2024 -- Start*/

function getUserNameAndDesignation($usercode)
{
    $db = \Config\Database::connect();
    $builder = $db->table('master.users u');
    $query = $builder->select('u.name,ut.type_name,u.section,u.usertype')
             ->join('master.usertype ut','u.usertype=ut.id','inner')
             ->where('usercode',$usercode)->get()->getResultArray();

    if($query)
    {
        foreach ($query as $row)
        return $row;
    }else{
        echo "Error Occurred";
    }

}



function getCaseDetails($main_diary_number){
    $model = new \App\Models\Common\Component\CaseStatusModel();
    $dropdownlist_model = new \App\Models\Common\DropdownListModel();

    $data['diary_disposal_date'] = array();
    $diary_details = is_data_from_table('main',['diary_no'=>$main_diary_number],'*','R');
    $flag="";
    if(empty($diary_details)){

        $flag="_a";
        $diary_details = is_data_from_table('main_a',['diary_no'=>$main_diary_number],'*','R');
        $data['diary_disposal_date'] = json_decode($model->get_diary_disposal_date($main_diary_number),true);
    }
    $data['diary_details'] = $diary_details;
    $data['party_details'] = json_decode($model->get_party_details($main_diary_number, $flag),true);
    $data['pet_res_advocate_details'] = json_decode($model->get_pet_res_advocate($main_diary_number, $flag),true);
    $data['old_category'] = json_decode($model->get_old_category($main_diary_number, $flag),true);
    $data['new_category'] = json_decode($model->get_new_category($main_diary_number, $flag),true);

    $category_nm = '';
    $mul_category = '';
    $data['main_case'] ='';
    $data['new_category_name']='';
    if(!empty($data['old_category'])){
        foreach($data['old_category'] as $old_category){
            if($old_category['subcode1']>0 and $old_category['subcode2']==0 and $old_category['subcode3']==0 and $old_category['subcode4']==0)
                $category_nm=  $old_category['sub_name1'];
            elseif($old_category['subcode1']>0 and $old_category['subcode2']>0 and $old_category['subcode3']==0 and $old_category['subcode4']==0)
                $category_nm=  $old_category['sub_name1']." : ".$old_category['sub_name4'];
            elseif($old_category['subcode1']>0 and $old_category['subcode2']>0 and $old_category['subcode3']>0 and $old_category['subcode4']==0)
                $category_nm=  $old_category['sub_name1']." : ".$old_category['sub_name2']." : ".$old_category['sub_name4'];
            elseif($old_category['subcode1']>0 and $old_category['subcode2']>0 and $old_category['subcode3']>0 and $old_category['subcode4']>0)
                $category_nm=  $old_category['sub_name1']." : ".$old_category['sub_name2']." : ".$old_category['sub_name3']." : ".$old_category['sub_name4'];

            if ($mul_category == '') {
                $mul_category = $old_category['category_sc_old'].'-'.$category_nm;
            } else {
                $mul_category = $old_category['category_sc_old'].'-'.$mul_category . ',<br> ' . $category_nm;
            }
        }
        $data['old_category_name'] = $mul_category;
    }

    if(!empty($data['new_category'])){
        $data['new_category_name'] = $data['new_category'][0]['category_sc_old'].'-'.$data['new_category'][0]['sub_name1'].' : '.$data['new_category'][0]['sub_name4'];
    }
    $data['no_of_defect_days'] =json_decode($model->get_defect_days($main_diary_number, $flag),true);

    $data['recalled_matters'] = json_encode($model->get_recalled_matters($main_diary_number),true,JSON_UNESCAPED_SLASHES);
    $data['consignment_status']=json_decode($model->get_consignment_status($main_diary_number, $flag),true);
    $data['sensitive_case']=json_decode($model->get_sensitive_cases($main_diary_number),true);
    $data['efiled_cases'] = json_decode($model->get_efiled_cases($main_diary_number),true);
    $data['heardt_case']= json_decode($model->get_heardt_case($main_diary_number, $flag),true);
    $last_listed_on = "";
    $last_listed_on_jud = "";
    if(!empty($data['heardt_case'])){
        foreach($data['heardt_case'] as $row1){
            if ($row1['tbl'] == 'H') {
                $tentative_cl_dt = $row1['tentative_cl_dt'];
            }
            $mc = $row1["filno"];
            if (!empty($mc)) {
                $main_case = get_main_case($mc,$flag);
                $data['main_case'] = $main_case;
            }
            $chk_next_dt = $row1["next_dt"];
            if ($row1["porl"] == "L" and $last_listed_on == "") {
                $next_dt = date("Y-m-d", strtotime($row1["next_dt"]));
                $cl_printed = $model->get_cl_printed_data($next_dt, $row1['mainhead'],$row1["clno"],$row1["roster_id"]);
               // echo ">>>". $cl_printed;
            }
        }
    }
    $data['case_type_history'] = json_decode($model->get_case_type_history($main_diary_number,$flag),true);
    $data['fill_dt_case'] = json_decode($model->get_fill_dt_case($main_diary_number,$flag), true);
    $data['diary_section_details'] = json_decode($model->get_diary_section_details($main_diary_number,$flag), true);
    $data['da_section_details'] = json_decode($model->get_da_section_details($main_diary_number,$flag), true);
    $data['autodiary_details'] = json_decode($model->get_autodiary_details($main_diary_number),true);
    $data['filing_stage'] = json_decode($model->get_fil_trap_details($main_diary_number,$flag),true);
    $data['acts_sections'] = json_decode($model->get_acts_sections_details($main_diary_number),true);
    $data['diary_number'] = $main_diary_number;
    $data['IB_DA_Details'] = json_decode($model->get_IB_DA_Details($main_diary_number,$flag),true);
    $data['file_movement_data'] = json_decode($model->get_file_movement_data($main_diary_number,$flag),true);

    if(!empty($data['IB_DA_Details'])){
        $IbDaName = "<font color='blue' style='font-size:12px;font-weight:bold;'>".$data['IB_DA_Details']['name']." [" . $data['IB_DA_Details']["section_name"] . "]". "</font>";;
    }else{
        $IbDaName = "<font color='blue' style='font-size:12px;font-weight:bold;'>".$data['diary_section_details']["name"]. " [" .  $data['diary_section_details']["section_name"] . "]". "</font>";;
    }
    $section_da_name =  "<font color='blue' style='font-size:12px;font-weight:bold;'>" . $data['da_section_details']["name"] . "</font>";
    if ($data['da_section_details']["dacode"] != "0"){
        $section_da_name .= "<font style='font-size:12px;font-weight:bold;'> [SECTION: </font><font color='red' style='font-size:12px;font-weight:bold;'>" . $data['da_section_details']["section_name"] . "</font><font style='font-size:12px;font-weight:bold;'>]</font>";
    }else{
        $tentative_section = json_decode($model->get_tentative_section($main_diary_number,$flag),true);

        $section_da_name .= "<font style='font-size:12px;font-weight:bold;'> [Tentative SECTION: </font><font color='red' style='font-size:12px;font-weight:bold;'>" . $tentative_section['section_name'] . "</font><font style='font-size:12px;font-weight:bold;'>]</font>";
    }
    if(!empty($data['fill_dt_case'])){
        if ($data['fill_dt_case']['last_u'] != '')
            $data['last_updated_by'] = $data['fill_dt_case']['last_u'];
        if ($data['fill_dt_case']['last_dt'] != '') {
            $last_dt = date_create($data['fill_dt_case']['last_dt']);
            $last_dt= date_format($last_dt, "d-m-Y h:i A");
            $data['last_updated_by'] .= " On " . $last_dt;
        }
    }
    $pname = "";
    $rname = "";
    $impname = "";
    $intname = "";
    $padvname = "";
    $radvname = "";
    $iadvname = "";
    $nadvname = "";
    $ac_court = "";


    if(!empty($data['party_details'])){
        foreach($data['party_details']  as $row_p){
            $tmp_addr = "";
            $tmp_name = "";

            if ($row_p["pflag"] == 'O')
                $tmp_name = $tmp_name . "<p style=color:red>&nbsp;&nbsp;";
            else if ($row_p["pflag"] == 'D')
                $tmp_name = $tmp_name . "<p style=color:#9932CC>&nbsp;&nbsp;";
            else
                $tmp_name = $tmp_name . "<p>&nbsp;&nbsp;";

            $tmp_name = $tmp_name . $row_p["sr_no_show"];
            $tmp_name = $tmp_name . " ";
            $tmp_name = $tmp_name . $row_p["partyname"];
            if ($row_p["prfhname"] != "")
                $tmp_name = $tmp_name . " S/D/W/Thru:- " . $row_p["prfhname"];
            if ($row_p["remark_lrs"] != '' || $row_p["remark_lrs"] != NULL)
                $tmp_name .= " [" . $row_p["remark_lrs"] . "]";

            if ($row_p["pflag"] == 'O' || $row_p["pflag"] == 'D')
                $tmp_name .= " [" . $row_p["remark_del"] . "]";

            if ($row_p["addr1"] != "")
                $tmp_addr = $tmp_addr . $row_p["addr1"] . ", ";
            if ($row_p['ind_dep'] != 'I' && !empty($row_p['deptname']))
                $tmp_addr = $tmp_addr . " " . trim(str_replace($row_p['deptname'], '', $row_p['partysuff'])) . ", ";
            if ($row_p["addr2"] != "")
                $tmp_addr = $tmp_addr . $row_p["addr2"] . " ";
            if ($row_p["city"] != "") {

                $dstName = '';
                if ($row_p["dstname"] != "") {
                    $dstName .= " , DISTRICT: " . $row_p["dstname"];
                }
                $city_name = get_state_data($row_p["city"])[0]['name'];

                $tmp_addr = $tmp_addr . $dstName . " ," .$city_name . " ";

            }
            if ($row_p["state"] != "") {
                $state_name = get_state_data($row_p["state"])[0]['name'];
                $tmp_addr = $tmp_addr . ", " . $state_name . " ";
            }
            if ($tmp_addr != "")
                $tmp_name = $tmp_name . "<br>&nbsp;&nbsp;" . $tmp_addr . "";
            $tmp_name = $tmp_name . "</p>";

            if ($row_p["pet_res"] == "P") {
                $pname .= $tmp_name;
            }
            if ($row_p["pet_res"] == "R") {
                $rname .= $tmp_name;
            }
            if ($row_p["pet_res"] == "I") {
                $impname .= $tmp_name;
            }
            if ($row_p["pet_res"] == "N") {
                $intname .= $tmp_name;
            }
        }
    }
    $data['IB_da_name'] = $IbDaName;
    $data['section_da_name'] = $section_da_name;
    $data['petitioner_name'] = $pname;
    $data['respondent_name'] = $rname;
    $data['impleader'] = $impname;
    $data['intervenor'] = $intname;

    if(!empty($data['pet_res_advocate_details'] )){
        foreach($data['pet_res_advocate_details'] as $row_advp){
            $tmp_advname =  "<p>&nbsp;&nbsp;";
            if ($row_advp['is_ac'] == 'Y') {
                if ($row_advp['if_aor'] == 'Y')
                    $advType = "AOR";
                else if ($row_advp['if_sen'] == 'Y')
                    $advType = "Senior Advocate";
                else if ($row_advp['if_aor'] == 'N' && $row_advp['if_sen'] == 'N')
                    $advType = "NON-AOR";
                else if ($row_advp['if_other'] == 'Y')
                    $advType = "Other";
                $ac_text = '[Amicus Curiae- ' . $advType . ']';
            } else
                $ac_text = '';
            if ($row_advp['is_ac'] == 'Y' && ($row_advp['pet_res'] == '' || empty($row_advp['pet_res']) || $row_advp['pet_res'] == null)) {
                $for_court = "[For Court]";
            } else {
                $for_court = "";
            }
            $t_adv = $row_advp['name'];
            if($row_advp['isdead']=='Y'){
                $t_adv = "<font color=red>" . $t_adv . " (Dead / Retired / Elevated) </font>";
            }
            $tmp_advname = $tmp_advname . $t_adv.  $row_advp['adv'] . $ac_text.'</p>';
             if ($row_advp['pet_res'] == "P")
             $padvname .= $tmp_advname;
                if ($row_advp['pet_res'] == "R")
                    $radvname .= $tmp_advname;
                if ($row_advp['pet_res'] == "I")
                    $iadvname .= $tmp_advname;
                if ($row_advp['pet_res'] == "N")
                    $nadvname .= $tmp_advname;
                if ($row_advp['is_ac'] == 'Y' && ($row_advp['pet_res'] == '' || empty($row_advp['pet_res']) || $row_advp['pet_res'] == null))
                    $ac_court .= $tmp_advname;
        }
    }
    $data['ac_court'] = $ac_court;
    $data['padvname'] = $padvname;
    $data['radvname'] = $radvname;
    $data['respondent_name'] = $rname;
    $data['iadvname'] = $iadvname;
    $data['nadvname'] = $nadvname;

    //print_r($data);

    return $data;
    //return $result_view = view('Common/Component/case_status/case_status_details_tab',$data);
}


function get_state_data($id_no=null){
    $db = \Config\Database::connect();
    $builder = $db->table("master.state");
    $builder->select("id_no, name");
    $builder->WHERE('display','Y');
    if (!empty($id_no) && $id_no !=null){ $builder->WHERE('id_no',$id_no); }
    $builder->orderBy('name','ASC');
    $query =$builder->get();
    if($query->getNumRows() >= 1) {
        return $result = $query->getResultArray();
    }else{return false;}
}

/* Added by P.S on 02-01-2024 -- End*/
/* added by Shilpa */
function updateIn($table_name,$data,$key,$ids)
{   $db = \Config\Database::connect();
    $builder = $db->table($table_name);
    $builder->whereIn($key,$ids);
    //$builder->set($data);$query= $builder->getCompiledUpdate();echo (string) $query; exit();
    if($builder->update($data)) {
        return true;
    }else{return false;}
}
/* added by Shilpa end */
function component_html($component_type='')
{
    $html="";
    $data['component']='component_diary_with_case';
    $data['component_type']=$component_type;
    $html=view('Common/Component/index',$data);
    return $html;
}

function tentative_da($diary_no,$row='R'){
    $db = \Config\Database::connect();
    $query = $db->table('main m')
        ->select('us.section_name, us.id AS sec_id, u.empid, u.name,u.usercode,m.diary_no,m.c_status')
        ->join('master.users u', 'm.dacode = u.usercode')
        ->join('master.usersection us', 'u.section = us.id')
        ->where('u.display', 'Y')
        ->where('us.display', 'Y')
        ->where('m.diary_no', $diary_no)
        ->orderBy('us.section_name')
        ->get();
    if ($query->getNumRows() >= 1) {
        if($row=='R'){ $result = $query->getRowArray();}else{$result = $query->getResultArray();}
        return $result;
    } else {
        $query2 = $db->table('main_a m')
            ->select('us.section_name, us.id AS sec_id, u.empid, u.name,u.usercode,m.diary_no,m.c_status')
            ->join('master.users u', 'm.dacode = u.usercode')
            ->join('master.usersection us', 'u.section = us.id')
            ->where('u.display', 'Y')
            ->where('us.display', 'Y')
            ->where('m.diary_no', $diary_no)
            ->orderBy('us.section_name')
            ->get();
        if ($query2->getNumRows() >= 1) {
            if($row=='R'){ $result2 = $query2->getRowArray();}else{$result2 = $query2->getResultArray();}
            return $result2;
        } else {
            return $result= '';
        }
    }
}
function procedure_function($function_name,$diary_no,$array='K'){
    $db = \Config\Database::connect();
    $result2= '';
    if (!empty($diary_no) && $diary_no != null && !empty($function_name)) {
        $query="select $function_name($diary_no)";
    } else { return $result= 'Function name and diary number is required'; }
    $query = $db->query($query);
    if ($query->getNumRows() >= 1) {
        if($array=='K'){ $result=$query->getRowArray(); $result2=$result[$function_name]; }elseif ($array=='R'){ $result2 = $query->getRowArray(); }else{$result2 = $query->getResultArray();}
        return $result2;
    } else {
        return $result2= '';
    }
}

function getEarlierCourtData($diary_no){
    $model = new \App\Models\Common\Component\CaseStatusModel();
    $diary_details = is_data_from_table('main',['diary_no'=>$diary_no],'*','R');
    $flag="";
    if(empty($diary_details)){
        $flag="_a";
        $diary_details = is_data_from_table('main_a',['diary_no'=>$diary_no],'*','R');
    }
    $data['EarlierCourt'] = json_decode($model->getEarlierCourtData($diary_no,$flag),true);

    $data['all_ref_details'] =  json_decode($model->allReferenceDetailsByDiaryNo($diary_no,$flag),true);
    $data['all_gov_not_details'] =  json_decode($model->allGovernmentNotificationsByDiaryNo($diary_no,$flag),true);
    $data['all_relied_details'] =  json_decode($model->allReliedDetailsByDiaryNo($diary_no,$flag),true);
    $data['all_transfer_details'] =  json_decode($model->allTransferDetailsByDiaryNo($diary_no,$flag),true);
    $data['judges_details'] =  json_decode($model->getJudgeDetailsByDiary($diary_no,$flag),true);

    $data['diary_details'] = $diary_details;
    return $data;
}

function component_court_html($component_type='')
{
    $DropdownListModel = new App\Models\Common\DropdownListModel;
    $data['state'] = get_from_table_json('state');
    $data['court_type_list'] = $DropdownListModel->get_court_type_list();
    $html="";
    $data['component']='component_court';
    $data['component_type']=$component_type;
    $html=view('Common/Component/component_court_html',$data);
    return $html;
}

function get_judges($jcodes)
{
    $jnames="";
    if ($jcodes!=''){
        $t_jc=explode(",",$jcodes);
        for($i=0;$i<count($t_jc);$i++){
            $j_id = $t_jc[$i];
            $judges_data = is_data_from_table('master.judge',['jcode'=>$j_id],'jname');

            if (!empty($judges_data)) {
                foreach ($judges_data as $row11a) {
                    if($jnames=='')
                        $jnames.=$row11a["jname"];
                    else {
                        if($i==(count($t_jc)-1))
                            $jnames.=" and ".$row11a["jname"];
                        else
                            $jnames.=", ".$row11a["jname"];
                    }

                }
            }
        }
    }
    return $jnames;
}
function getBeforeNotBeforeData($diary_no)
{
    $db = \Config\Database::connect();
    $builder1 = $db->table("not_before a");
    $builder1->select("a.diary_no, string_agg(b.jname,',') as jn,a.notbef");
    $builder1->join('master.judge b', "a.j1=b.jcode");
    $builder1->where('diary_no', $diary_no);
    $builder1->groupBy('a.diary_no,a.notbef');
    $pr_bf = $nbf = $bf = "";
    $query = $builder1->get();

    if ($query->getNumRows() >= 1) {
        $result = $query->getResultArray();
        foreach($result as $rownb){
            $t_jn = $rownb["jn"];
            $t_jn1 = stripslashes($t_jn);
            if ($rownb["notbef"] == "B")
                if ($bf == "")
                    $bf .= $t_jn1;
                else
                    $bf .= ",  " . $t_jn1;
            if ($rownb["notbef"] == "N")
                if ($nbf == "")
                    $nbf .= $t_jn1;
                else
                    $nbf .= ",  " . $t_jn1;
        }
    }
      return $bf . "^|^" . $nbf;
}

function get_mul_category($diary_no,$flag=null){
    $db = \Config\Database::connect();
    $builder1 = $db->table("mul_category".$flag." mc");
    $builder1->select("s.*");
    $builder1->join('master.submaster s', "mc.submaster_id=s.id");
    $builder1->where('diary_no', $diary_no);
    $builder1->where('mc.display', 'Y');
    $query = $builder1->get();

    if ($query->getNumRows() >= 1) {
        $result = $query->getResultArray();
        $mul_category="";
        foreach($result as $row2){
            if($row2['subcode1']>0 and $row2['subcode2']==0 and $row2['subcode3']==0 and $row2['subcode4']==0)
                $category_nm=  $row2['sub_name1'];
            elseif($row2['subcode1']>0 and $row2['subcode2']>0 and $row2['subcode3']==0 and $row2['subcode4']==0)
                $category_nm=  $row2['sub_name1']." : ".$row2['sub_name4'];
            elseif($row2['subcode1']>0 and $row2['subcode2']>0 and $row2['subcode3']>0 and $row2['subcode4']==0)
                $category_nm=  $row2['sub_name1']." : ".$row2['sub_name2']." : ".$row2['sub_name4'];
            elseif($row2['subcode1']>0 and $row2['subcode2']>0 and $row2['subcode3']>0 and $row2['subcode4']>0)
                $category_nm=  $row2['sub_name1']." : ".$row2['sub_name2']." : ".$row2['sub_name3']." : ".$row2['sub_name4'];

            if ($mul_category == '') {
                $mul_category = $category_nm;
            } else {
                $mul_category = $mul_category . ',<br> ' . $category_nm;
            }
        }
        return $mul_category;
    } else {
        return false;
    }
}

function validate_verification($diary_no,$flag=null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('main' . $flag . ' as a');
    $builder->distinct();
    $builder->select('a.diary_no, pet_name, res_name, a.casetype_id ');
    $builder->join('defects_verification' . $flag . ' c', "a.diary_no = c.diary_no", 'left');
    $builder->where('a.diary_no', $diary_no);
    $builder->where('c_status', 'P');
    $builder->whereNotIn('a.casetype_id', [9, 10, 19, 20, 39, 11, 12, 25, 26]);
    $builder->where('a.diary_no_rec_date>', '2018-08-06');
    $builder->groupStart()
        ->where('c.diary_no is null')
        ->orWhere('c.diary_no IS NOT NULL')
        ->where('verification_status', '1')
        ->groupEnd();

    $builder2 = $db->table('main' . $flag . ' as a')
        ->distinct()
        ->select('a.diary_no, pet_name, res_name, a.casetype_id')
        ->join('docdetails b', 'a.diary_no = b.diary_no')
        ->join('master.docmaster c', 'b.doccode = c.doccode AND b.doccode1 = c.doccode1')
        ->join('defects_verification d', 'a.diary_no = d.diary_no', 'left')
        ->where('c_status', 'P')
        ->where('b.display', 'Y')
        ->where('c.display', 'Y')
        ->groupStart()
        ->where('not_reg_if_pen', 1)
        ->orWhere('not_reg_if_pen', 2)
        ->groupEnd()
        ->groupStart()
        ->where('d.diary_no', null)
        ->orWhere('verification_status', '1')
        ->groupEnd()
        ->where('a.diary_no', $diary_no)
        ->whereNotIn('a.casetype_id', [9, 10, 19, 20, 39, 11, 12, 25, 26])
        ->where("a.diary_no_rec_date >='2018-08-06'");

    $unionResult = $builder->union($builder2)->get();
    $ret = 0;
    if ($unionResult->getNumRows() >= 1) {
        $ret = 1;
        return $ret;
    } else {
        return $ret;
    }
}
    function main_regular()
    {?>
        <select name="main_regular" id="main_regular" class="form-control">
            <option value="M">Miscellaneous</option>
            <option value="R">Regular</option>
        </select>

    <?php }

    function board_type()
    {?>
        <select name="board_type" id="board_type" class="form-control">
            <option value="0">-ALL-</option>
            <option value="J">Court</option>
            <option value="S">Single Judge</option>
            <option value="C">Chamber</option>
            <option value="R">Registrar</option>
        </select>
    <?php }

    function main_supp()
    {?>
        <select class="form-control" name="main_suppl" id="main_suppl">
            <option value="0">-ALL-</option>
            <option value="1">Main</option>
            <option value="2">Suppl.</option>
        </select>
    <?php }


    function court_no()
    {?>
        <select class="form-control" name="courtno" id="courtno">
            <option value="0">-ALL-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="21">21 (RC1)</option>
            <option value="22">22 (RC2)</option>
        </select>
    <?php }

    function get_selected_values($parm1){
        $dld = "";
        foreach ($parm1 as $key => $value){
            $dld .= $value.",";
        }
        return rtrim($dld,',');
    }

    function send_email($to,$subject,$message,$files)
    {

        foreach($to as $to1) {

            $string = base64_encode(json_encode(array("allowed_key" => "G1Kp54WtuQ23", "sender" => "eService", "mailTo" => $to1, "subject" => $subject, "message" => $message, "files" => $files)));
            $content = http_build_query(array('a' => $string));
            $context = stream_context_create(array('http' => array('method' => 'POST', 'content' => $content,)));
            $json_return = @file_get_contents('http://10.25.78.60/supreme_court/Copying/index.php/Api/eMailSend', null, $context);
            $json2 = json_decode($json_return);
        }

    }

