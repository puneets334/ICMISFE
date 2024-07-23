<?php
/**
 * Created by PhpStorm.
 * User: Anshu
 * Date: 26/8/23
 * Time: 11:30 AM
 */
helper('view');
use eftec\bladeone\BladeOne;

 if (!function_exists('pr')) {
    function pr($request)
    {
        echo '<pre>';
        print_r($request);
        echo "<br>";
        die;
    }
}

if (!function_exists('pra')) {
    function pra($request)
    {
        pr($request->toArray());
    }
}

function setSessionData($key, $value)
{
    $session = \Config\Services::session();
    $session->set($key, $value);
}

function getSessionData($key)
{
    $session = \Config\Services::session();
    return $session->get($key);
}
function getClientIP(){
    if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)){
        return  $_SERVER["HTTP_X_FORWARDED_FOR"];
    }else if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
        return $_SERVER["REMOTE_ADDR"];
    }else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
        return $_SERVER["HTTP_CLIENT_IP"];
    }

    return '';
}
function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function getClientMAC(){
    if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)){
        $ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }else if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
        $ipAddress = $_SERVER["REMOTE_ADDR"];
    }else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
        $ipAddress = $_SERVER["HTTP_CLIENT_IP"];
    }

    //$ipAddress = getClientIP();

    //echo "<br>";
    //$ipAddress = "172.16.182.57";
    ob_start();
    system('ping -c 2 '.$ipAddress);
    $macfull=ob_get_contents();
    ob_clean();
    //echo $macfulll;

    ob_start();
    system('arp -an '.$ipAddress);
    $macfull=ob_get_contents();
    ob_clean();
    //echo $macfull;

    $pmac = strpos($macfull, $ipAddress);
    $mac=substr($macfull,($pmac+18),17);
    return $mac;
}
function sendSMS($mobile_no,$smsmsg,$template_id)
{
    if(empty($template_id)){
        $template_id=1107165900749762632;
    }
    $url = "http://10.25.78.5/eAdminSCI/a-push-sms-gw?mobileNos=".$mobile_no."&message=".rawurlencode($smsmsg)."&typeId=29&myUserId=NIC001001&myAccessId=root&templateId=".$template_id;
    $result = (array)json_decode(file_get_contents($url));
}




if (!function_exists('escape_data')) {

    function escape_data($post) {
        return trim(pg_escape_string(strip_tags($post)));
    }

}
function associative_array_merged_key($array1,$array2,$key){
    $combinedArray = array();
    foreach (array_merge($array1, $array2) as $item) {
        if (!empty($item)) {
            $year = $item["$key"];
            if (!isset($combinedArray[$year])) {
                $combinedArray[$year] = array("$key" => $year);
            }
            $combinedArray[$year] = array_merge($combinedArray[$year], $item);
        }
    }
    $combinedArray = array_values($combinedArray);
    return $combinedArray;
}

function get_from_table_json($table_name,$condition=null,$column_names=null){
    $file=env('Json_master_table').$table_name.'.json';
    if(file_exists($file)){
        $url=base_url('/'.$file); $json = file_get_contents($url); $json_data = json_decode($json, true);
        $json_array=array();
        if ($json_data){
            if (!empty($condition) && $condition !=null && !empty($column_names) && $column_names !=null) {
                foreach ($json_data as $subArray) {
                    if (isset($subArray[$column_names]) && $subArray[$column_names] == $condition) {
                        $json_array[] = $subArray;
                    } }
            }else{  $json_array=$json_data;}
        }else{ $json_array;}
        return $json_array;
    }else{ return false; }
}

function get_diary_case_type($case_type,$case_number,$case_year,$if_return_array='',$flag='')
{
    $result='';if ($flag==''){$flag='AB';}
    if(!empty($case_type) && !empty($case_number) && !empty($case_year))
    {
        $result=get_diary_case_type_details($case_type,$case_number,$case_year,'','',$if_return_array,$flag);
        if (empty($result)){
            $result=get_diary_case_type_details($case_type,$case_number,$case_year,'Y','',$if_return_array,$flag);
        }
        if (empty($result)){
            $result=get_diary_case_type_details($case_type,$case_number,$case_year,'','_a',$if_return_array,$flag);
        }
        if (empty($result)){
            $result=get_diary_case_type_details($case_type,$case_number,$case_year,'Y','_a',$if_return_array,$flag);
        }
    }
    //if (empty($result)){ $result='Data not found'; }
    return $result;
}

function get_diary_case_type_details($caseTypeId,$caseNo,$caseYear,$case_number_to='',$is_archival_table='',$if_return_array='',$flag='AB')
{
    $db = \Config\Database::connect();
    $result='';
    if ($flag=='AB' || $flag=='A') {
        $builder = $db->table("main$is_archival_table m");
        $builder->select("LEFT(CAST(m.diary_no AS TEXT), -4) AS dn, RIGHT(CAST(m.diary_no AS TEXT), 4) AS dy");
        if (!empty($case_number_to)) {
            $builder->join("(SELECT diary_no, 
                            CASE WHEN fil_no::text ~ '^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$'::text THEN CAST(SPLIT_PART(m.fil_no, '-', 1) AS INTEGER) ELSE 0 END AS case_type,
                            CASE WHEN fil_no::text ~ '^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$'::text THEN CAST(SPLIT_PART(m.fil_no, '-', 2) AS INTEGER) ELSE 0 END AS part1,
                            CASE WHEN fil_no::text ~ '^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$'::text THEN CAST(SPLIT_PART(m.fil_no, '-', 3) AS INTEGER) ELSE 0 END AS part2,
                            
                            CASE WHEN fil_no_fh::text ~ '^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$'::text THEN CAST(SPLIT_PART(m.fil_no_fh, '-', 1) AS INTEGER) ELSE 0 END AS fh_case_type,
                            CASE WHEN fil_no_fh::text ~ '^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$'::text THEN CAST(SPLIT_PART(m.fil_no_fh, '-', 2) AS INTEGER) ELSE 0 END AS fh_part1,
                            CASE WHEN fil_no_fh::text ~ '^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$'::text THEN CAST(SPLIT_PART(m.fil_no_fh, '-', 3) AS INTEGER) ELSE 0 END AS fh_part2,
                            
                            CASE WHEN reg_year_mh = 0 OR DATE(fil_dt) > '2017-05-10' THEN DATE_PART('year', fil_dt) ELSE reg_year_mh END AS mh_reg_year,
                            CASE WHEN reg_year_fh = 0 THEN DATE_PART('year', fil_dt_fh) ELSE reg_year_fh END AS fh_reg_year 
                            FROM main$is_archival_table m) t", "t.diary_no=m.diary_no", 'inner');
            $builder->where("((t.case_type = $caseTypeId AND $caseNo BETWEEN t.part1 AND t.part2 AND t.mh_reg_year = $caseYear) OR (t.fh_case_type = $caseTypeId AND $caseNo BETWEEN t.fh_part1 AND t.fh_part2 AND t.fh_reg_year = $caseYear))");
        } else {
            $builder->join("(SELECT diary_no, 
                            CASE WHEN fil_no::text ~ '^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$'::text THEN CAST(SPLIT_PART(m.fil_no, '-', 1) AS INTEGER) ELSE 0 END AS case_type,
                            CASE WHEN fil_no::text ~ '^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$'::text THEN CAST(SPLIT_PART(m.fil_no, '-', 2) AS INTEGER) ELSE 0 END AS part1,
                            CASE WHEN fil_no::text ~ '^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$'::text THEN CAST(SPLIT_PART(m.fil_no, '-', 2) AS INTEGER) ELSE 0 END AS part2,
                            
                            CASE WHEN fil_no_fh::text ~ '^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$'::text THEN CAST(SPLIT_PART(m.fil_no_fh, '-', 1) AS INTEGER) ELSE 0 END AS fh_case_type,
                            CASE WHEN fil_no_fh::text ~ '^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$'::text THEN CAST(SPLIT_PART(m.fil_no_fh, '-', 2) AS INTEGER) ELSE 0 END AS fh_part1,
                            CASE WHEN fil_no_fh::text ~ '^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$'::text THEN CAST(SPLIT_PART(m.fil_no_fh, '-', 2) AS INTEGER) ELSE 0 END AS fh_part2,
                            
                            CASE WHEN reg_year_mh = 0 OR DATE(fil_dt) > '2017-05-10' THEN DATE_PART('year', fil_dt) ELSE reg_year_mh END AS mh_reg_year,
                            CASE WHEN reg_year_fh = 0 THEN DATE_PART('year', fil_dt_fh) ELSE reg_year_fh END AS fh_reg_year 
                            FROM main$is_archival_table m) t", "t.diary_no=m.diary_no", 'inner');
            $builder->where("((t.case_type=$caseTypeId AND t.mh_reg_year=$caseYear AND t.part1=$caseNo) 
                                OR (t.fh_case_type=$caseTypeId AND t.fh_reg_year=$caseYear AND t.fh_part1=$caseNo))");
        }
        $builder1 = $builder->get();
        if ($builder1->getNumRows() >= 1) {
            if (!empty($if_return_array) && $if_return_array == 'A') {
                $result = $builder1->getResultArray();
            } elseif (!empty($if_return_array) && $if_return_array == 'R') {
                $result = $builder1->getRowArray();
            } else {
                $result1 = $builder1->getRowArray();
                $result = $result1['dn'] . $result1['dy'];
            }

        }
    }
    if(empty($result)) {
        if ($flag == 'AB' || $flag == 'B') {
            $query = $db->table("main_casetype_history$is_archival_table h");
            $query->select('h.old_registration_number,h.diary_no, new_registration_number, left((cast(h.diary_no as text)),-4) AS dn, right((cast(h.diary_no as text)),4) as dy');

            if (!empty($case_number_to)) {
                $query->join('(SELECT diary_no,
                        CASE WHEN new_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.new_registration_number, \'-\', 1)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS case_type,
                        CASE WHEN new_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.new_registration_number, \'-\', 2)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS part1,
                        CASE WHEN new_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.new_registration_number, \'-\', 3)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS part2,
                        new_registration_year,
                        
                        CASE WHEN old_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.old_registration_number, \'-\', 1)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS old_case_type,
                        CASE WHEN old_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.old_registration_number, \'-\', 2)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS old_part1,
                        CASE WHEN old_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.old_registration_number, \'-\', 3)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS old_part2,
                        old_registration_number
                        
                  FROM main_casetype_history' . $is_archival_table . ' h
                  WHERE is_deleted=\'f\') t', 't.diary_no = h.diary_no AND 
                  t.new_registration_year = h.new_registration_year AND h.ref_new_case_type_id = t.case_type and
                  t.old_registration_number = h.old_registration_number AND h.ref_old_case_type_id = t.old_case_type
                  ', 'inner');

                $query->where("((case_type=$caseTypeId  and h.new_registration_year=$caseYear and  $caseNo between part1 and part2) or 
                         (old_case_type=$caseTypeId  and h.old_registration_year=$caseYear and  $caseNo between old_part1 and old_part2))");
            } else {
                $query->join('(SELECT diary_no,
                        CASE WHEN new_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.new_registration_number, \'-\', 1)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS case_type,
                        CASE WHEN new_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.new_registration_number, \'-\', 2)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS part1,
                        CASE WHEN new_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.new_registration_number, \'-\', 2)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS part2,
                        new_registration_year,
                        
                        CASE WHEN old_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.old_registration_number, \'-\', 1)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS old_case_type,
                        CASE WHEN old_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.old_registration_number, \'-\', 2)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS old_part1,
                        CASE WHEN old_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.old_registration_number, \'-\', 2)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS old_part2,
                        old_registration_number
                        
                  FROM main_casetype_history' . $is_archival_table . ' h
                  WHERE is_deleted=\'f\') t', 't.diary_no = h.diary_no AND 
                  t.new_registration_year = h.new_registration_year AND h.ref_new_case_type_id = t.case_type and
                  t.old_registration_number = h.old_registration_number AND h.ref_old_case_type_id = t.old_case_type
                  ', 'inner');

                $query->where("((case_type=$caseTypeId  and h.new_registration_year=$caseYear and part1=$caseNo) or 
                         (old_case_type=$caseTypeId  and h.old_registration_year=$caseYear and old_part1=$caseNo))");
                $query->where('h.is_deleted', 'f');
            }
            $query2 = $query->get();
            if ($query2->getNumRows() >= 1) {
                if (!empty($if_return_array) && $if_return_array == 'A') {
                    $result2 = $query2->getResultArray();
                } elseif (!empty($if_return_array) && $if_return_array == 'R') {
                    $result2 = $query2->getRowArray();
                } else {
                    $result_2 = $query2->getRowArray();
                    $result2 = $result_2['dn'] . $result_2['dy'];
                }
                $result=$result2;
            }
        }
    }
    return $result;
}
function get_ref_agency_code_details($ddl_st_agncy,$ddl_bench)
{
    $db = \Config\Database::connect();
        $get_dno = "select s.agency_state,c.agency_name from master.ref_agency_code c join master.ref_agency_state s on c.cmis_state_id= s.cmis_state_id where c.id='$ddl_bench' and s.cmis_state_id='$ddl_st_agncy'";
    $query = $db->query($get_dno);
    if ($query->getNumRows() >= 1) {
        $result = $query->getRowArray();
        return $result;
    }
}

/* Code added by Shilpa -- Start 7th Dec */


function copying_weight_calculator($total_pages,$total_red_wrappers){
    $weight = 0;
    if($total_pages >= 1 and $total_pages <=5){
        //envelop no. 5 & addtional 1 gram for glue/pinup and barcode sticker
        $weight = 3 + 1;
    }
    else if($total_pages >= 6 and $total_pages <=8){
        //envelop no. 6 & addtional 2 gram for glue/pinup and barcode sticker
        $weight = 6 + 2;
    }
    else if($total_pages >= 9 and $total_pages <=10){
        //envelop no. 7 & addtional 3 gram for glue/pinup and barcode sticker
        $weight = 12 + 3;
    }
    else if($total_pages >= 11 and $total_pages <=20){
        //envelop no. A4 & addtional 4 gram for glue/pinup and barcode sticker
        $weight = 20 + 4;
    }
    else if($total_pages >= 21 and $total_pages <=500){
        //envelop no. 8 & addtional 5 gram for glue/pinup and barcode sticker
        $weight = 35 + 5;
    }
    else{
        //envelop no. 8 for above 500 pages & addtional 5 gram for glue/pinup and barcode sticker
        $additional_weight_times = ceil($total_pages / 500);
        $weight = (35+5) * $additional_weight_times;
    }
    //75 gsm page equal to 4 gram and wrap has 2 gram of weight
    $weight += ($total_pages * 4) + ($total_red_wrappers * 2);
    return $weight;
}

function force_download($filename = '', $data = '', $set_mime = FALSE)
	{
		if ($filename === '' OR $data === '')
		{
			return;
		}
		elseif ($data === NULL)
		{
			if ( ! @is_file($filename) OR ($filesize = @filesize($filename)) === FALSE)
			{
				return;
			}

			$filepath = $filename;
			$filename = explode('/', str_replace(DIRECTORY_SEPARATOR, '/', $filename));
			$filename = end($filename);
		}
		else
		{
			$filesize = strlen($data);
		}

		// Set the default MIME type to send
		$mime = 'application/octet-stream';

		$x = explode('.', $filename);
		$extension = end($x);

		if ($set_mime === TRUE)
		{
			if (count($x) === 1 OR $extension === '')
			{
				/* If we're going to detect the MIME type,
				 * we'll need a file extension.
				 */
				return;
			}

			// Load the mime types
			$mimes =& get_mimes();

			// Only change the default MIME if we can find one
			if (isset($mimes[$extension]))
			{
				$mime = is_array($mimes[$extension]) ? $mimes[$extension][0] : $mimes[$extension];
			}
		}

		/* It was reported that browsers on Android 2.1 (and possibly older as well)
		 * need to have the filename extension upper-cased in order to be able to
		 * download it.
		 *
		 * Reference: http://digiblog.de/2011/04/19/android-and-the-download-file-headers/
		 */
		if (count($x) !== 1 && isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Android\s(1|2\.[01])/', $_SERVER['HTTP_USER_AGENT']))
		{
			$x[count($x) - 1] = strtoupper($extension);
			$filename = implode('.', $x);
		}

		if ($data === NULL && ($fp = @fopen($filepath, 'rb')) === FALSE)
		{
			return;
		}

		// Clean output buffer
		if (ob_get_level() !== 0 && @ob_end_clean() === FALSE)
		{
			@ob_clean();
		}

		// Generate the server headers
		header('Content-Type: '.$mime);
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		header('Expires: 0');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.$filesize);
		header('Cache-Control: private, no-transform, no-store, must-revalidate');

		// If we have raw data - just dump it
		if ($data !== NULL)
		{
			exit($data);
		}

		// Flush 1MB chunks of data
		while ( ! feof($fp) && ($data = fread($fp, 1048576)) !== FALSE)
		{
			echo $data;
		}

		fclose($fp);
		exit;
	}


/* Code added by Shilpa -- End */


//CODE STARTS HERE BY - P.S

function get_diary_no_from_casetype($caseTypeId=null,$caseNo=null,$caseYear=null)
{
    $db = \Config\Database::connect();
    if(($caseTypeId != null) && ($caseNo != null) && ($caseYear != null))
    {
        $query = $db->table('main_casetype_history_a h');
        $query->select('h.diary_no, new_registration_number, left((cast(h.diary_no as text)),-4) AS dn, right((cast(h.diary_no as text)),4) as dy');
        $query->join('(SELECT diary_no,
                        CASE WHEN new_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.new_registration_number, \'-\', 1)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS case_type,
                        CASE WHEN new_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.new_registration_number, \'-\', 2)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS part1,
                        CASE WHEN new_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.new_registration_number, \'-\', 3)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS part2,
                        new_registration_year
                  FROM main_casetype_history_a h
                  WHERE is_deleted=\'f\') t', 't.diary_no = h.diary_no AND t.new_registration_year = h.new_registration_year AND h.ref_new_case_type_id = t.case_type', 'inner');
        $query->where('case_type', $caseTypeId);
        $query->where('h.new_registration_year', $caseYear);
        $query->where("$caseNo BETWEEN part1 AND part2");
        $query->where('h.is_deleted', 'f');

        $query1 = $query->get();
        if ($query1->getNumRows() > 0)
        {
            $result = $query1->getResultArray();
            return $result;
        }else{
            $query = $db->table('main_casetype_history h');
            $query->select('h.diary_no, new_registration_number, left((cast(h.diary_no as text)),-4) AS dn, right((cast(h.diary_no as text)),4) as dy');
            $query->join('(SELECT diary_no,
                        CASE WHEN new_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.new_registration_number, \'-\', 1)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS case_type,
                        CASE WHEN new_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.new_registration_number, \'-\', 2)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS part1,
                        CASE WHEN new_registration_number::text ~ \'^[0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9][0-9]$\'::text
                                THEN CAST((SPLIT_PART(h.new_registration_number, \'-\', 3)) AS INTEGER)
                                ELSE 0::INTEGER
                             END AS part2,
                        new_registration_year
                  FROM main_casetype_history h
                  WHERE is_deleted=\'f\') t', 't.diary_no = h.diary_no AND t.new_registration_year = h.new_registration_year AND h.ref_new_case_type_id = t.case_type', 'inner');
            $query->where('case_type', $caseTypeId);
            $query->where('h.new_registration_year', $caseYear);
            $query->where("$caseNo BETWEEN part1 AND part2");
            $query->where('h.is_deleted', 'f');

            $query1 = $query->get();
            $result = $query1->getResultArray();
            return $result;

        }

    }
}
function array_SORT_ASC_DESC($array,$key_name,$SORT_BY='')
{
    if (!empty($array)){
        if (!empty($array)){
        foreach ($array as $key => $row) {
            $casecodes[$key] = $row[$key_name];
        }
        if ($SORT_BY==''){
            array_multisort($casecodes, SORT_ASC, $array);
        }else{
            array_multisort($casecodes, SORT_DESC, $array);
        }
         $array;
        }else{
            $array='Array key Name is required';
        }
    }else{
        $array='Array is required';
    }
    return $array;

}

function get_sub_menus_ardar($q_usercode,$menu_id){
    $MenuModel = new \App\Models\MenuModel();
    $sqrs=$MenuModel->get_sub_menus($q_usercode,$menu_id);
    return $sqrs;

}

function f_get_cat_diary_basis($parm1)
{
    $db = \Config\Database::connect();
    $sql = "select sub_name1, sub_name2, sub_name3, sub_name4,category_sc_old from master.submaster s where s.id IN ($parm1) and s.display = 'Y'";
    $builder = $db->query($sql);
    $result = $builder->getResultArray();

    if (!empty($result)) {
        foreach ($result as $row) {
            $retn = $row["sub_name1"];
            if ($row["sub_name2"])
                $retn .= " - " . $row["sub_name2"];
            if ($row["sub_name3"])
                $retn .= " - " . $row["sub_name3"];
            if ($row["sub_name4"])
                $retn .= " - " . $row["sub_name4"];
            echo nl2br($retn .' ('.$row["category_sc_old"].') '. "\n");
        }
    } else {
        return false;
    }
}
    function f_get_judge_names_inshort($chk_jud_id){
        $db = \Config\Database::connect();
        $sql="select abbreviation FROM master.judge WHERE is_retired != 'Y' and jcode IN (".rtrim($chk_jud_id,',').")";
        $builder = $db->query($sql);
        $result = $builder->getResultArray();
        $jname = "";
        if(!empty($result)){
            foreach($result as $row){
                $jname .= $row['abbreviation'].", ";
            }
            return rtrim(trim($jname),",");
        }
    }

    function f_get_ntl_judge($parm1){
        $sql="SELECT j.abbreviation FROM advocate a LEFT JOIN master.ntl_judge n ON a.advocate_id = n.org_advocate_id
 LEFT JOIN master.judge j ON j.jcode = n.org_judge_id WHERE a.diary_no = '$parm1' 
 and j.is_retired != 'Y' AND a.display ='Y' AND n.display = 'Y' AND org_advocate_id IS NOT NULL 
 AND j.jcode IS NOT NULL group by abbreviation";
        $db = \Config\Database::connect();
        $builder = $db->query($sql);
        $result = $builder->getResultArray();
        if(!empty($result)){
                foreach($result as $row){
                echo nl2br("<font color='red'> AOR N : ".$row["abbreviation"]."</font>");
            }

        }
    }

    function f_get_ndept_judge($parm1){
        $sql="SELECT j.abbreviation FROM party a LEFT JOIN master.ntl_judge_dept n ON a.deptcode = n.dept_id 
            LEFT JOIN master.judge j ON j.jcode = n.org_judge_id WHERE n.display = 'Y' and a.diary_no = '$parm1' 
            AND a.pflag != 'T'  AND j.is_retired != 'Y'
            AND a.deptcode IS NOT NULL AND j.jcode IS NOT NULL";
        $db = \Config\Database::connect();
        $builder = $db->query($sql);
        $result = $builder->getResultArray();
        if(!empty($result)){
            foreach($result as $row){
                echo nl2br("<font color='red'> Dept N : ".$row["abbreviation"]."</font>");
            }
        }
    }

    function f_get_category_judge($parm1){
        $sql="SELECT j.abbreviation FROM (SELECT s.id FROM (SELECT s.id, sub_name1 FROM mul_category c, master.submaster s WHERE s.id = submaster_id AND 
        diary_no = '$parm1' AND c.display = 'Y' AND s.display = 'Y') a 
INNER JOIN master.submaster s ON s.sub_name1 = a.sub_name1
WHERE flag = 's') a
INNER JOIN master.ntl_judge_category n ON n.cat_id = a.id
LEFT JOIN master.judge j ON j.jcode = n.org_judge_id 
WHERE n.display = 'Y' AND j.jcode IS NOT NULL";
        $db = \Config\Database::connect();
        $builder = $db->query($sql);
        $result = $builder->getResultArray();
        if(!empty($result)){
            foreach($result as $row){
                echo nl2br("<font color='red'> Categ. N : ".$row["abbreviation"]."</font>");
            }
        }
    }

    function f_get_not_before($parm1){
        $sql="select j.abbreviation, notbef from not_before b 
left join master.judge j on j.jcode = b.j1 WHERE j.is_retired != 'Y' and b.diary_no = '$parm1' order by notbef";
        $db = \Config\Database::connect();
        $builder = $db->query($sql);
        $result = $builder->getResultArray();
        if(!empty($result)){
            foreach($result as $row){
                if($row["notbef"] == "N")
                    echo nl2br("<font color='red'> NB- ".$row["notbef"]." : ".$row["abbreviation"]."</font>");
                else
                    echo nl2br("<font color='green'> NB- ".$row["notbef"]." : ".$row["abbreviation"]."</font>");
            }
        }
    }

    function f_cl_rgo_default($q_diary_no){
        $num_rows = 0;
        $sql="SELECT * FROM rgo_default WHERE fil_no = '$q_diary_no' AND remove_def = 'N'";
        $db = \Config\Database::connect();
        $builder = $db->query($sql);
        $result = $builder->getRowArray();
        if(!empty($result)){
            $num_rows = $result['fil_no2'];
        }
        return $num_rows;
    }

    function f_get_section_name_fdno($parm1){
        $sql="SELECT tentative_section($parm1) as sname";
        $db = \Config\Database::connect();
        $builder = $db->query($sql);
        $result = $builder->getResultArray();
        if(!empty($result)){
            foreach($result as $row){
                echo "{".$row["sname"]."} ";
            }
        }
    }

    function f_get_user_name_fdno($parm1){
        $sql="SELECT u.name FROM main m INNER JOIN master.users u ON u.usercode = m.dacode WHERE u.display = 'Y' and m.diary_no = '$parm1'";
        $db = \Config\Database::connect();
        $builder = $db->query($sql);
        $result = $builder->getResultArray();
        if(!empty($result)){
            foreach($result as $row){
                echo nl2br($row["name"]."\n");
            }
        }
    }

    function get_pet_respondentby_diary($diaryno){
        $sql="select pet_res, string_agg(adv,',') as name from (
                SELECT pet_res,concat(name,string_agg(DISTINCT adv, ',')) as adv
                FROM advocate a
                JOIN master.bar b ON a.advocate_id=b.bar_id
                WHERE pet_res IN ('P','R','I')
                AND diary_no = '$diaryno'
                AND display = 'Y'
                AND isdead = 'N'
                group by pet_res,b.name,a.pet_res_show_no
                order by pet_res_show_no)a
                group by pet_res";
        $db = \Config\Database::connect();
        $builder = $db->query($sql);
        $result = $builder->getResultArray();
        return $result;
    }

function get_office_report($diaryno,$listing_date){
    $sql="Select LEFT(CAST(diary_no AS TEXT), -4) as dno, RIGHT(CAST(diary_no AS TEXT), 4) as d_yr, office_repot_name,office_report_id,order_dt,rec_dt from office_report_details where diary_no='$diaryno' 
          and order_dt='$listing_date' and display='Y' and web_status=1 ";
    $db = \Config\Database::connect();
    $builder = $db->query($sql);
    $result = $builder->getResultArray();
    return $result;
}

/* Start function case_nos Anshu */

function get_case_nos($diary_no,$separator,$rby=''){
    $IAModel = new \App\Models\Judicial\IAModel();
    $db = \Config\Database::connect();
    $builder = $db->table('main m');
    $builder->select('casetype_id');
    $builder->select("CONCAT(m.active_fil_no, ':', 
        CASE 
            WHEN (active_reg_year = 0 OR CAST(active_fil_dt AS DATE) > '2017-05-10') THEN EXTRACT(YEAR FROM active_fil_dt) 
            ELSE active_reg_year 
        END, 
        ':', TO_CHAR(active_fil_dt, 'DD-MM-YYYY')) ad", false);
    $builder->select("CASE 
        WHEN fil_no_fh != active_fil_no AND fil_no_fh != fil_no AND fil_no_fh != '' THEN CONCAT(m.fil_no_fh, ':', 
            CASE 
                WHEN (reg_year_fh = 0 OR CAST(fil_dt_fh AS DATE) > '2017-05-10') THEN EXTRACT(YEAR FROM fil_dt_fh) 
                ELSE reg_year_fh 
            END, 
            ':', TO_CHAR(fil_dt_fh, 'DD-MM-YYYY')) 
        ELSE '' 
        END rd", false);
    $builder->select("CASE 
        WHEN fil_no != active_fil_no AND fil_no_fh != fil_no AND fil_no != '' THEN CONCAT(m.fil_no, ':', 
            CASE 
                WHEN (reg_year_mh = 0 OR CAST(fil_dt AS DATE) > '2017-05-10') THEN EXTRACT(YEAR FROM fil_dt) 
                ELSE reg_year_mh 
            END, 
            ':', TO_CHAR(fil_dt, 'DD-MM-YYYY')) 
        ELSE '' 
    END md", false);
    $builder->where('diary_no', $diary_no);
    $query= $builder->get();
    $row_main= $query->getRowArray();
    $cases="";$t_fil_no='';
    if(!empty($row_main)){
        if($row_main['ad']!=''){
            $t_m_y=explode(':',$row_main['ad']);
            if($t_m_y[0]!='') {
                $cases .= $t_m_y[0] . ",";
                $t_m1 = substr($t_m_y[0], 0, 2);
                $t_m2 = substr($t_m_y[0], 3, 6);
                $t_m21 = substr($t_m_y[0], 10, 6);
                $t_m3 = $t_m_y[1];
                $t_m4 = $t_m_y[2];
                $sql_ct_type = $IAModel->get_short_description($t_m1);
                $res_ct_typ = ''; $res_ct_typ_mf = '';
                if (!empty($sql_ct_type)) {
                    $row = $sql_ct_type;
                    $res_ct_typ = $row['short_description'];
                    $res_ct_typ_mf = $row['cs_m_f'];
                }
                if ($t_m2 == $t_m21){
                    $t_fil_no .= '<font color="#043fff" style=" white-space: nowrap;">' . $res_ct_typ . " " . $t_m2 . ' / ' . $t_m3 . '</font>' . $separator . "(Reg.Dt." . $t_m4 . ")<br>";
                }else{
                    $t_fil_no .= '<font color="#043fff" style=" white-space: nowrap;">' . $res_ct_typ . " " . $t_m2 . ' - ' . $t_m21 . ' / ' . $t_m3 . '</font>' . $separator . "(Reg.Dt." . $t_m4 . ")<br>";
                }
            }
        }
        if($row_main['rd']!=''){
            $t_m_y=explode(':',$row_main['rd']);
            if($t_m_y[0]!=''){
                $cases.=$t_m_y[0].",";
                $t_m1=substr($t_m_y[0],0,2);
                $t_m2=substr($t_m_y[0],3,6);
                $t_m21=substr($t_m_y[0],10,6);
                $t_m3=$t_m_y[1];
                $t_m4=$t_m_y[2];
                $sql_ct_type = $IAModel->get_short_description($t_m1);
                $res_ct_typ = ''; $res_ct_typ_mf = '';
                if (!empty($sql_ct_type)) {
                    $row = $sql_ct_type;
                    $res_ct_typ = $row['short_description'];
                    $res_ct_typ_mf = $row['cs_m_f'];
                }
                if ($t_m2 == $t_m21){
                    $t_fil_no.='<font color="#043fff" style=" white-space: nowrap;">'.$res_ct_typ." ".$t_m2.' / '.$t_m3.'</font>'.$separator."(Reg.Dt.".$t_m4.")<br>";
                }else{
                    $t_fil_no.= '<font color="#043fff" style=" white-space: nowrap;">'.$res_ct_typ." ".$t_m2.' - '. $t_m21 .' / '.$t_m3.'</font>'.$separator."(Reg.Dt.".$t_m4.")<br>";
                }
            }
        }
        if($row_main['md']!=''){

            $t_m_y=explode(':',$row_main['md']);
            if($t_m_y[0]!=''){
                $cases.=$t_m_y[0].",";
                $t_m1=substr($t_m_y[0],0,2);
                $t_m2=substr($t_m_y[0],3,6);
                $t_m21=substr($t_m_y[0],10,6);
                $t_m3=$t_m_y[1];
                $t_m4=$t_m_y[2];

                $sql_ct_type = $IAModel->get_short_description($t_m1);
                $res_ct_typ = ''; $res_ct_typ_mf = '';
                if (!empty($sql_ct_type)) {
                    $row = $sql_ct_type;
                    $res_ct_typ = $row['short_description'];
                    $res_ct_typ_mf = $row['cs_m_f'];
                }
                if ($t_m2 == $t_m21){
                    $t_fil_no.= '<font color="#043fff" style=" white-space: nowrap;">'.$res_ct_typ." ".$t_m2.' / '.$t_m3.'</font>'.$separator."(Reg.Dt.".$t_m4.")<br>";
                }else{
                    $t_fil_no.= '<font color="#043fff" style=" white-space: nowrap;">'.$res_ct_typ." ".$t_m2.' - '. $t_m21 .' / '.$t_m3.'</font>'.$separator."(Reg.Dt.".$t_m4.")<br>";
                }

            }
        }

    }

    $registration_details = $IAModel->get_new_old_registration_details($diary_no);

    if(!empty($registration_details)){
        $cnt=0;
        foreach ($registration_details as $row_mc_h){
            if($row_mc_h['oldno']!=''){
                $t_m=explode(',',$row_mc_h['oldno']);

                $t_m_y=explode(':',$t_m[0]);
                $pos = strpos($cases, $t_m_y[0]);

                if ($pos === false) {
                    $cnt++;
                    if($cnt%2==0)
                        $bgcolor="#ff0015";
                    else
                        $bgcolor="#ff01c8";
                    $cases.=$t_m_y[0].",";
                    $t_m1=substr($t_m_y[0],0,2);
                    $t_m2=substr($t_m_y[0],3,6);
                    $t_m21=substr($t_m_y[0],10,6);
                    $t_m3=$t_m_y[1];
                    $t_m4=$t_m_y[2];

                    $sql_ct_type = $IAModel->get_short_description($t_m1);
                    $res_ct_typ = ''; $res_ct_typ_mf = '';
                    if (!empty($sql_ct_type)) {
                        $row = $sql_ct_type;
                        $res_ct_typ = $row['short_description'];
                        $res_ct_typ_mf = $row['cs_m_f'];
                    }
                    if ($t_m2 == $t_m21){
                        $t_fil_no.= '<font color="'.$bgcolor.'" style=" white-space: nowrap;">'.$res_ct_typ." ".$t_m2.' / '.$t_m3.'</font>'.$separator."(Reg.Dt.".$t_m4.")<br>";
                    }else{
                        $t_fil_no.= '<font color="'.$bgcolor.'" style=" white-space: nowrap;">'.$res_ct_typ." ".$t_m2.' - '. $t_m21 .' / '.$t_m3.'</font>'.$separator."(Reg.Dt.".$t_m4.")<br>";
                    }
                }
            }
            $t_chk="";

            if($row_mc_h['newno']!=''){
                $t_m=explode(',',$row_mc_h['newno']);
                for ($i = 0; $i < count($t_m); $i++) {
                    $t_m_y=explode(':',$t_m[$i]);
                    $pos = strpos($cases, $t_m_y[0]);
                    if ($pos === false) {
                        $cases .= $t_m_y[0] . ",";
                        $t_m1 = substr($t_m_y[0], 0, 2);
                        $t_m2 = substr($t_m_y[0], 3, 6);
                        $t_m21 = substr($t_m_y[0], 10, 6);
                        $t_m3 = $t_m_y[1];
                        $t_m4 = $t_m_y[2];
                        $t_fn = $t_m_y[0];
                        if ($t_chk != $t_fn) {
                            $cnt++;
                            if ($cnt % 2 == 0){
                                $bgcolor = "#ff0015";
                            }else{
                                $bgcolor = "#ff01c8";
                            }
                            $sql_ct_type = $IAModel->get_short_description($t_m1);
                            $res_ct_typ = ''; $res_ct_typ_mf = '';
                            if (!empty($sql_ct_type)) {
                                $row = $sql_ct_type;
                                $res_ct_typ = $row['short_description'];
                                $res_ct_typ_mf = $row['cs_m_f'];
                            }
                            if ($t_m2 == $t_m21){
                                $t_fil_no.='<font color="'.$bgcolor.'" style=" white-space: nowrap;">'.$res_ct_typ." ".$t_m2.' / '.$t_m3.'</font>'.$separator."(Reg.Dt.".$t_m4.")<br>";
                            }else{
                                $t_fil_no.='<font color="'.$bgcolor.'" style=" white-space: nowrap;">'.$res_ct_typ." ".$t_m2.' - '. $t_m21 .' / '.$t_m3.'</font>'.$separator."(Reg.Dt.".$t_m4.")<br>";
                            }

                        }
                        $t_chk=$t_fn;

                    }
                }

            }

        }
    }
    if(trim($t_fil_no)==''){
        if (!empty($row_main['casetype_id'])){
            $get_short_description = $IAModel->get_short_description($row_main['casetype_id']);
            if (!empty($get_short_description)) {
                $t_fil_no = $get_short_description['short_description'];
            }
        }
    }
    return $t_fil_no;

   

}

/* end function case_nos Anshu */


function render($view, $data = [])
{
    $views = APPPATH . 'Views';
    $cache = WRITEPATH . 'cache';

    if (ENVIRONMENT === 'production') {
        $templateEngine = new BladeOne(
            $views,
            $cache,
            BladeOne::MODE_AUTO
        );
    } else {
        $templateEngine = new BladeOne(
            $views,
            $cache,
            BladeOne::MODE_DEBUG
        );
    }

    $templateEngine->pipeEnable = true;
    $templateEngine->setBaseUrl(base_url());
    $views = APPPATH . 'Views'; // Path to your views directory
    $cache = WRITEPATH . 'cache'; // Path to your cache directory

    $blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);

    echo $blade->run($view, $data);
}