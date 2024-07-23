<?php
namespace App\Models\Judicial;

use CodeIgniter\Model;

class DirectDisposeModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->db = db_connect();
    }

    public function get_casedesc($data)
    {

        $ucode = $_SESSION['login']['usercode'];
        $dataArr = [];
        $diaryno = $data['d_yr'];
        if($data['d_no']!='' && $data['d_yr']!='')
        {
            $builder = $this->db->table('main');
                $builder->select("dacode, diary_no, conn_key, fil_dt, EXTRACT(YEAR FROM fil_dt) as filyr, TO_CHAR(fil_dt, 'DD-MM-YYYY HH:MI PM') as fil_dt_f, fil_no_fh, TO_CHAR(fil_dt_fh, 'DD-MM-YYYY HH:MI PM') as fil_dt_fh, actcode, pet_adv_id, res_adv_id, lastorder, c_status");
                $builder->select("CASE WHEN diary_no::text != '' THEN SUBSTRING(diary_no::text FROM 0 FOR LENGTH(diary_no::text)) ELSE '' END AS ct1", false);
                $builder->select("CASE WHEN diary_no::text != '' THEN SUBSTRING(diary_no::text FROM POSITION('-' IN diary_no::text) + 1) ELSE '' END AS crf1", false);
                $builder->select("CASE WHEN diary_no::text != '' THEN SUBSTRING(diary_no::text FROM POSITION('-' IN REVERSE(diary_no::text)) + 1) ELSE '' END AS crl1", false);
                $builder->select("CASE WHEN fil_no_fh != '' THEN SUBSTRING(fil_no_fh FROM POSITION('-' IN fil_no_fh) + 1) ELSE '' END AS crf2", false);
                $builder->select("CASE WHEN fil_no_fh != '' THEN SUBSTRING(fil_no_fh FROM 1 FOR LENGTH(diary_no::text)) ELSE '' END AS ct2", false);
                $builder->select("CASE WHEN fil_no_fh != '' THEN SUBSTRING(fil_no_fh FROM POSITION('-' IN REVERSE(fil_no_fh)) + 1) ELSE '' END AS crl2", false);
                $builder->select("CASE WHEN conn_key != '' AND conn_key IS NOT NULL THEN CASE WHEN conn_key = diary_no::text THEN 'N' ELSE 'Y' END ELSE 'N' END AS ccdet", false);
                $builder->select('casetype_id, conn_key AS connto');
                $builder->where('SUBSTRING(diary_no::text FROM 1 FOR 4)', $data['d_no']);
                $builder->where('SUBSTRING(diary_no::text FROM -4)', $data['d_yr']);
               $query = $builder->get();
                $filno = $query->getResultArray();
                if(!empty($filno)){
                    $filno = $filno[0];
                    $dataArr['filno'] = $filno;

                    $dataArr['mul_category']= $this->get_mul_category($filno["diary_no"]);
                    $dataArr['conn_cases']= $this->get_conn_cases($diaryno);
                    $conn_cases = [];
                    if(!empty($dataArr['conn_cases'])){
                        $conn_cases = $dataArr['conn_cases'];
                    }
                    $dataArr['html_conn_cases'] = $this->get_conn_cases_html($conn_cases);
                    $dataArr['get_real_diaryno'] = $this->get_real_diaryno($diaryno);
                    $dataArr['case_nos']= $this->get_case_nos($diaryno, "&nbsp;&nbsp;");

                    $builder1 = $this->db->table('master.users');
                    $builder1->select("section,usertype");   
                    $builder1->where('usercode', $ucode);
                    $query1 = $builder1->get();
                    $dataArr['section_rs'] = $query1->getResultArray();

                    $builder2 = $this->db->table('main a');
                    $builder2->select("fil_dt, 
                        CASE 
                            WHEN last_dt IS NULL THEN ''
                            ELSE TO_CHAR(last_dt, 'DD-MM-YYYY HH:MI PM')
                        END AS last_dt,
                        a.usercode,
                        CASE 
                            WHEN last_usercode IS NULL OR last_usercode::text = '' THEN 0
                            ELSE last_usercode
                        END AS last_usercode,
                        b.name AS user,
                        c.name AS last_u");
                    $builder2->join('master.users b', 'a.usercode = b.usercode', 'LEFT');
                    $builder2->join('master.users c', 'a.last_usercode = c.usercode', 'LEFT');
                    $builder2->where('a.diary_no', $diaryno);
                        $query2 = $builder2->get();
                    $dataArr['fil_date_for'] = $query2->getResultArray();

                    $builder3 = $this->db->table('main a');
                    $builder3->select("a.usercode, name,section_name");   
                    $builder3->join('master.users b', 'a.usercode = b.usercode', 'LEFT');
                    $builder3->join('master.usersection us', 'b.section = us.id', 'LEFT');
                    $builder3->where('diary_no', $diaryno);
                    $query3 = $builder3->get();
                    $dataArr['results_da'] = $query3->getResultArray();
                    $builder4 = $this->db->table('master.casetype');
                    $builder4->select("short_description");   
                    $builder4->where('casecode', $filno['casetype_id']);
                    $builder4->where('display', 'Y');
                    $query4 = $builder4->get();
                    $dataArr['t_res_ct_typ'] = $query4->getResultArray();
                    
                    $builder5 = $this->db->table('party p');
                    $builder5->select(" substr(m.diary_no::text, 1, length(m.diary_no::text) - 4) AS case_no, substr(m.diary_no::text, -4) as year, p.sr_no, p.pet_res, p.ind_dep, p. partyname, p.sonof, p.prfhname, p.age, p.sex, p.caste, p.addr1, p.addr2, p.pin, p.state, p.city, p.email, p.contact AS mobile, p.deptcode,
                        (SELECT deptname FROM master.deptt WHERE deptcode = p.deptcode) AS deptname,
                        c.skey, TO_CHAR(m.diary_no_rec_date, 'DD-MM-YYYY HH:MI PM') AS diary_no_rec_date");
                    $builder5->join('main m', 'm.diary_no = p.diary_no', 'INNER');
                    $builder5->join('master.casetype c', 'c.casecode = cast(SUBSTRING(m.diary_no::text, 3, 3) AS INTEGER)', 'LEFT');
                    $builder5->where('m.diary_no', $filno['diary_no']);
                    $builder5->where('p.sr_no', 1);
                    $builder5->where('p.pflag', 'P');
                    $builder5->whereIn('p.pet_res', ['P', 'R']);
                    $builder5->orderBy('p.pet_res');
                    $builder5->orderBy('p.sr_no');
                    $query5 = $builder5->get();
                    $result = $query5->getResultArray();
                    
                    if (count($result) > 0) {

                        $data_state = [];
                        foreach ($result as $row) {
                            $dist_name = $this->get_district_det($row['state'], $row['city']);
                            $temp_dist = '';
                            if(!empty($dist_name)){
                                $t_var = $dist_name["name"];
                                if ($t_var != "") {
                                    $temp_dist = ", District : " . $t_var;
                                }
                            }                            
                            $data_state[] = [
                                'case_no' => $row['case_no'], 
                                'year' => $row['year'], 
                                'sr_no' => $row['sr_no'], 
                                'pet_res' => $row['pet_res'], 
                                'ind_dep' => $row['ind_dep'],  
                                'partyname' => $row['partyname'], 
                                'sonof' => $row['sonof'], 
                                'prfhname' => $row['prfhname'], 
                                'age' => $row['age'], 
                                'sex' => $row['sex'], 
                                'caste' => $row['caste'], 
                                'addr1' => $row['addr1'], 
                                'addr2' => $row['addr2'], 
                                'pin' => $row['pin'], 
                                'state' => $row['state'], 
                                'city' => $row['city'], 
                                'email' => $row['email'], 
                                'mobile' => $row['mobile'], 
                                'deptcode' => $row['deptcode'], 
                                'deptname' => $row['deptname'], 
                                'skey' => $row['skey'], 
                                'diary_no_rec_date' => $row['diary_no_rec_date'],
                                'temp_district_name' => $temp_dist
                            ];
                        }
                        $dataArr['result'] = $data_state;
                        
                    }else{
                        $dataArr['result'] = [];
                    }
                    $builder7 = $this->db->table('master.casetype');
                    $builder7->select("short_description");   
                    $builder7->where('casecode', $filno['casetype_id']);
                    $builder7->where('display', 'Y');
                    $query7 = $builder7->get();
                    $res12 = $query7->getResultArray();
                    if(!empty($res12)){
                        $dataArr['results12'] = $res12[0];
                    }else{
                        $dataArr['results12'] = [];
                    }
                                
                    $builder8 = $this->db->table('lowerct a');
                    $builder8->select("lct_dec_dt, lct_caseno, lct_caseyear, short_description AS type_sname");
                    $builder8->join('master.casetype ct', "ct.casecode = a.lct_casetype AND ct.display = 'Y'", 'LEFT');
                    $builder8->where('a.diary_no', $diaryno);
                    $builder8->where('a.lw_display', 'Y');
                    $builder8->where('a.ct_code', 4);
                    $builder8->orderBy('a.lct_dec_dt');
                    $query8 = $builder8->get();
                    $dataArr['rs_lct'] = $query8->getResultArray();
        
                    $builder9 = $this->db->table('act_main a');
                    $builder9->select("a.act, STRING_AGG(b.section, ', ') AS section, act_name", false);
                    $builder9->join('master.act_section b', 'a.id = b.act_id', 'LEFT');
                    $builder9->join('master.act_master c', 'c.id = a.act', 'JOIN');
                    $builder9->where('a.diary_no', $filno['diary_no']);
                    $builder9->where('a.display', 'Y');
                    $builder9->where('b.display', 'Y');
                    $builder9->where('c.display', 'Y');
                    $builder9->groupBy('act, c.act_name');
                    $query9 = $builder9->get();
                    $dataArr['act'] = $query9->getResultArray();
                    $builder10 = $this->db->table('master.caselaw');
                    $builder10->select("law");
                    $builder10->where('id', $filno['actcode']);
                    $query10 = $builder10->get();
                    $t_pol_data = $query10->getResultArray();
                    if(!empty($t_pol_data)){
                        $dataArr['t_pol'] = $t_pol_data[0]; 
                    }else{
                        $dataArr['t_pol'] = [];
                    }

                    $builder11 = $this->db->table('advocate');
                    $builder11->select("pet_res_no,adv, advocate_id, pet_res");
                    $builder11->where('diary_no', $filno['diary_no']);
                    $builder11->where('display', 'Y');
                    $builder11->orderBy('pet_res');
                    $query11 = $builder11->get();
                    $result_advp = $query11->getResultArray();
                    if(!empty($result_advp)){
                        $adv_arr = [];
                        foreach ($result_advp as $row_advp) {
                            $adv_detail = $this->get_advocates($row_advp["advocate_id"],"");
                            $adv_arr[] = [
                                'pet_res_no' =>  $row_advp['pet_res_no'],
                                'adv' => $row_advp['adv'],
                                'advocate_id' =>  $row_advp['advocate_id'],
                                'pet_res' =>  $row_advp['pet_res'],
                                'adv_det' => $adv_detail
                            ];
                        }
                        $dataArr['result_advp'] = $adv_arr;
                    }else{
                        $dataArr['result_advp'] = [];
                    }
                    
                    $builder12 = $this->db->table('dispose d');
                    $builder12->select([
                        'd.rj_dt',
                        'd.jud_id',
                        "TO_CHAR(d.ent_dt, 'DD-MM-YYYY') AS ddt",
                        "TO_CHAR(d.ord_dt, 'DD-MM-YYYY') AS odt",
                        "TO_CHAR(d.ord_dt, 'DD-MM-YYYY') AS ord_dt",
                        'd.disp_dt',
                        'd.month',
                        'd.year',
                        'd.dispjud',
                        'd.disp_type',
                        "STRING_AGG(j.jname, ', ' ORDER BY j.judge_seniority) AS judges",
                    ]);
                    $builder12->join('master.judge j', "j.jcode = ANY(string_to_array(d.jud_id, ',')::int[])", 'LEFT');
                    $builder12->where('d.diary_no', $filno['diary_no']);
                    $builder12->groupBy('d.diary_no');
                    $query12 = $builder12->get();
                    $results_rj = $query12->getResultArray();
                    if(!empty($results_rj)){
                        $row_rj = $results_rj[0];
                        $dataArr['results_rj'] = $row_rj;
                        $builder13 = $this->db->table('heardt h');
                        $builder13->select('h.diary_no');
                        $builder13->join('mul_category mc', 'mc.diary_no = h.diary_no AND (mc.submaster_id = 912 OR h.subhead = 818)', 'LEFT');
                        $builder13->where('mc.diary_no IS NOT NULL', null, false);
                        $builder13->where('h.diary_no', $filno['diary_no']);
                        $query13 = $builder13->get();
                        $dataArr['row_k1'] = $query13->getResultArray();



                        $builder14 = $this->db->table("case_remarks_multiple");
                        $builder14->select("jcodes");
                        $builder14->where("diary_no",$filno['diary_no']);
                        $builder14->groupBy('cl_date, case_remarks_multiple.jcodes, case_remarks_multiple.e_date');
                        $builder14->orderBy("e_date", 'DESC');
                        $builder14->limit(1);
                        $final_query  = $this->db->newQuery()->select("STRING_AGG(j.jname, ', ' ORDER BY j.judge_seniority) AS judges")->fromSubquery($builder14, 'a')->join("master.judge j", "j.jcode = ANY(string_to_array(a.jcodes, ',')::int[])::int > 0","left");
                         
                        $query14 = $final_query->get();
                        $dataArr['row_k3'] = $query14->getResultArray();


                        
                        $builder15 = $this->db->table("master.judge");
                        $builder15->select("jname");
                        $builder15->where("jcode",$row_rj['dispjud']);
                        $query15 = $builder15->get();
                        $dataArr['row_k2'] = $query15->getResultArray();
                        
                        $disptype = $row_rj['disp_type'];
                        $builder16 = $this->db->table("master.disposal");
                        $builder16->select("*");
                        $builder16->where("dispcode",$disptype);
                        $query16 = $builder16->get();
                        $dataArr['results_dsql'] = $query16->getResultArray();
                    }else{
                        $dataArr['results_rj'] = [];
                    }

                    $builder17 = $this->db->table("rgo_default");
                    $builder17->select("DISTINCT(fil_no2)");
                    $builder17->where("fil_no",$filno['diary_no']);
                    $builder17->where("remove_def", 'N');
                    $query17 = $builder17->get();
                    $dataArr['res_rgo'] = $query17->getResultArray();
                    
                    $builder18 = $this->db->table("heardt");
                    $builder18->select("tentative_cl_dt");
                    $builder18->where("diary_no", $filno['diary_no']);
                    $query18 = $builder18->get();
                    $dataArr['ttv'] = $query18->getResultArray();
                    if(!empty($dataArr['ttv'])){
                        $tentative_cl_dt = $dataArr['ttv'][0];
                        $tentative_cl_dt = $tentative_cl_dt['tentative_cl_dt'];
                        if($tentative_cl_dt != ''){
                            $dataArr['get_display_status_with_date_differnces'] = $this->get_display_status_with_date_differnces($tentative_cl_dt);
                            $dataArr['change_date_format'] = $this->change_date_format($tentative_cl_dt);
                        }
                        
                    }$builder19 = $this->db->table('master.case_status_flag');
                    $builder19->select('display_flag, always_allowed_users');
                    $builder19->where('CAST(to_date AS CHAR(10))', '0000-00-00');
                    $builder19->where('flag_name', 'tentative_listing_date');
                    $query19 = $builder19->get();
                    $dataArr['result_sql_display'] = $query19->getResultArray();
                    $builder20 = $this->db->table('main m');
                    $builder20->select('m.diary_no, (SELECT list FROM conct cc WHERE cc.diary_no = m.diary_no LIMIT 1) AS llist');
                    $builder20->where("(m.diary_no = '".$diaryno."' OR m.conn_key IN (SELECT conn_key FROM main WHERE diary_no = '".$diaryno."'))");
                    $builder20->where('m.diary_no != cast(m.conn_key as INTEGER)');
                    $builder20->orderBy('m.fil_dt');
                    $query20 = $builder20->get();
                    $dataArr['results_oc'] = $query20->getResultArray();            
                                
                
                    $builder21 = $this->db->table('main m');
                    $builder21->select("
                        m.diary_no,
                        m.pet_name,
                        m.res_name,
                        m.pet_adv_id,
                        m.res_adv_id,
                        m.c_status,
                        m.lastorder,
                        m.bench,
                        CASE 
                            WHEN m.conn_key IS NOT NULL AND m.conn_key != '' THEN 
                                CASE 
                                    WHEN m.conn_key::text = m.diary_no::text THEN 'N'
                                    ELSE 'Y'
                                END
                            ELSE 'N'
                        END AS ccdet,
                        m.conn_key AS connto");
                    $builder21->where('m.diary_no', $diaryno);
                    $query21 = $builder21->get();
                    $dataArr['results_m'] = $query21->getResultArray();
                
                    $builder22 = $this->db->table('docdetails a');
                    $builder22->select('a.diary_no, a.doccode, a.doccode1, a.docnum, a.docyear, a.filedby, a.docfee, a.forresp, a.feemode, a.ent_dt, a.other1, a.iastat, b.docdesc');
                    $builder22->join('master.docmaster b', 'a.doccode = b.doccode AND a.doccode1 = b.doccode1', 'INNER');
                    $builder22->where('a.diary_no', $diaryno);
                    $builder22->where('a.doccode', 8);
                    $builder22->orderBy('a.ent_dt');
                    $query22 = $builder22->get();
                    $dataArr['results_ian'] = $query22->getResultArray();
                
                    $builder23 = $this->db->table('docdetails a');
                    $builder23->select(' a.diary_no, a.doccode, a.doccode1, a.docnum, a.docyear, a.filedby, a.docfee, a.forresp, a.feemode, a.ent_dt, a.other1, b.docdesc');
                    $builder23->join('master.docmaster b', 'a.doccode = b.doccode AND a.doccode1 = b.doccode1', 'INNER');
                    $builder23->where('a.diary_no', $diaryno);
                    $builder23->where('a.doccode !=', 8);
                    $builder23->orderBy('a.ent_dt');
                    $query23 = $builder23->get();
                    $dataArr['results_od'] = $query23->getResultArray();
        
                    $builder24 = $this->db->table('master.casetype');
                    $builder24->select('skey');
                    $builder24->where("casecode = CAST(SUBSTRING('$diaryno' FROM 3 FOR 3) AS INTEGER)");
                    $builder24->where('display', 'Y');
                   
                    $query24 = $builder24->get();
                    $dataArr['row11'] = $query24->getResultArray();   

                    $builder25 = $this->db->table('party');
                    $builder25->select("STRING_AGG(partyname, ', ' ORDER BY sr_no) as pn, pet_res");
                    $builder25->where('diary_no', $diaryno);
                    $builder25->where('sr_no >', 1);
                    $builder25->groupBy('pet_res');
                    $query25 = $builder25->get();
                    $dataArr['results_party'] = $query25->getResultArray();
                    
                    $builder26 = $this->db->table('not_before a');
                    $builder26->select("a.diary_no, STRING_AGG(b.jname, ', ') as jn, a.notbef");
                    $builder26->join('master.judge b', "b.jcode = a.j1", 'left');
                    $builder26->where('a.diary_no', $diaryno);
                    $builder26->groupBy('a.diary_no, a.notbef');
                    $query26 = $builder26->get();
                    $dataArr['t_nb'] = $query26->getResultArray();
                
                    $builder27 = $this->db->table('dispose');
                    $builder27->select("rj_dt");
                    $builder27->where('diary_no', $diaryno);
                    $query27 = $builder27->get();
                    $dataArr['results_rj2'] = $query27->getResultArray();

                    $builder28 = $this->db->table('heardt');
                    $builder28->select("*");
                    $builder28->where('diary_no', $diaryno);
                    $query28 = $builder28->get();
                    $dataArr['result_listing'] = $query28->getResultArray();

                    $builder29 = $this->db->table('last_heardt');
                    $builder29->select("*");
                    $builder29->where('diary_no', $diaryno);
                    $builder29->where('CAST(next_dt AS CHAR(10)) !=', '0000-00-00');
                    $builder29->orderBy('ent_dt', 'DESC');
                    $query29 = $builder29->get();
                    $dataArr['result_listing1'] = $query29->getResultArray();
                    $builder30 = $this->db->table('master.users');
                    $builder30->select("section,is_courtmaster,usertype");
                    $builder30->where('usercode', $ucode);
                    $query30 = $builder30->get();
                    $dataArr['row_courtMaster'] = $query30->getResultArray();
                    $builder31 = $this->db->table('main m');
                    $builder31->select("COALESCE(m.dacode::text, '') AS dacode, COALESCE(u.name, '') AS username, u.empid");
                    $builder31->join('master.users u', 'm.dacode = u.usercode', 'left');
                    $builder31->where('m.diary_no', $diaryno);
                    $query31 = $builder31->get();
                    $dataArr['sq_ck_da_cd'] = $query31->getResultArray();
                    $builder32 = $this->db->table('docdetails a');
                    $builder32->select('a.diary_no, a.doccode, a.doccode1, a.docnum, a.docyear, a.filedby, a.docfee, a.forresp, a.feemode, a.ent_dt, a.other1, a.iastat, b.docdesc');
                    $builder32->join('master.docmaster b', 'a.doccode = b.doccode AND a.doccode1 = b.doccode1', 'inner');
                    $builder32->where('a.diary_no', $diaryno);
                    $builder32->where('a.doccode', 8);
                    $builder32->where('a.display', 'Y');
                    $builder32->orderBy('a.ent_dt');
                    $query32 = $builder32->get();
                    $dataArr['results_ian'] = $query32->getResultArray();
                    $builder34 = $this->db->table('master.judge');
                    $builder34->select("jcode AS jcode, CASE WHEN (jname ILIKE '%CHIEF JUSTICE%' OR jname ILIKE '%Registrar%') THEN CONCAT(TRIM(jname), ' (', first_name, ' ', sur_name, ' )') ELSE TRIM(jname) END AS jname");
                    $builder34->where('display', 'Y');
                    $builder34->whereIn('jtype', ['J', 'R']);
                    $builder34->orderBy("CASE WHEN is_retired = 'N' THEN 0 ELSE 1 END, jtype, judge_seniority");
                    $query34 = $builder34->get();
                    $dataArr['results2'] = $query34->getResultArray();
                    $builder35 = $this->db->table("master.case_remarks_head");
                    $builder35->select("*");
                    $builder35->where("side","D");
                    $builder35->where("display","Y");
                    $builder35->orderBy("(CASE WHEN cat_head_id < 1000 THEN 0 ELSE 1 END),head");
                  
                    $query35 = $builder35->get();
                    $dataArr['t11'] = $query35->getResultArray();

                }else{
                    $dataArr['notFound'] = "Case not found";
                }

                
                return $dataArr;
                
            
        }



    }




    function get_district_det($state, $city){
        $builder6 = $this->db->table('master.state');
        $builder6->select("name");   
        $builder6->where('state_code', $state);
        $builder6->where('district_code', $city);
        $builder6->where('sub_dist_code', 0);
        $builder6->where('village_code', 0);
        $builder6->where('display', 'Y');
        $query6 = $builder6->get();
        $t_dist = $query6->getResultArray();
        if(!empty($t_dist)){
            return $t_dist[0];
        }else{
            return '';
        }        
    }

    function get_mul_category($dn){
        $mul_category="";
        if($dn!=""){
            // $category = "SELECT b.* FROM mul_category a, submaster b where a.diary_no='".$dn."'  and a.display='Y' and a.submaster_id=b.id";                       
            // $category = mysql_query($category) or die("Error: " . __LINE__ . mysql_error());
            $builder = $this->db->table('mul_category a');
            $builder->select('b.*');
            $builder->join('master.submaster b', 'a.submaster_id = b.id');
            $builder->where('a.diary_no', $dn);
            $builder->where('a.display', 'Y');
            $query = $builder->get();
            $category = $query->getResultArray();
            if (count($category) > 0) {
                $category_nm = '';
                $mul_category = '';
                foreach ($category as $row2) {
                    // while ($row2 = mysql_fetch_array($category)) {
                    if($row2['subcode1']>0 and $row2['subcode2']==0 and $row2['subcode3']==0 and $row2['subcode4']==0){
                        $category_nm=  $row2['sub_name1'];
                    }
                    elseif($row2['subcode1']>0 and $row2['subcode2']>0 and $row2['subcode3']==0 and $row2['subcode4']==0){
                        $category_nm=  $row2['sub_name1']." : ".$row2['sub_name4'];
                    }
                    elseif($row2['subcode1']>0 and $row2['subcode2']>0 and $row2['subcode3']>0 and $row2['subcode4']==0){
                        $category_nm=  $row2['sub_name1']." : ".$row2['sub_name2']." : ".$row2['sub_name4'];
                    }
                    elseif($row2['subcode1']>0 and $row2['subcode2']>0 and $row2['subcode3']>0 and $row2['subcode4']>0){
                        $category_nm=  $row2['sub_name1']." : ".$row2['sub_name2']." : ".$row2['sub_name3']." : ".$row2['sub_name4'];
                    }
                    
                    if ($mul_category == '') {
                        $mul_category = $category_nm;
                    } else {
                        $mul_category = $mul_category . ',<br> ' . $category_nm;
                    }
                    $id=$row2['id'];
                }

            }
        }
        return array($mul_category,$id);
    }

    function get_conn_cases($dn){
        $me2 = array();
        $chk_for_main='';
        if($dn!=""){
            // $sql_p1 = "SELECT conn_key FROM main WHERE (diary_no='".$dn."' AND conn_key is NOT NULL and conn_key!='' and conn_key!=0 ) ";
            // $result_p1 = mysql_query($sql_p1) or die(mysql_error());
            $builder = $this->db->table('main');
            $builder->select('conn_key');
            $builder->where('diary_no', $dn);
            $builder->where('conn_key IS NOT NULL');
            $builder->where('conn_key !=', '');
            // $builder->where('conn_key !=', 0);
            $query = $builder->get();
            $result_p1 = $query->getResultArray();

            if(count($result_p1) > 0){    
                $conn_key= $result_p1[0]['conn_key'];
                // $sql_p = "SELECT diary_no,if(conn_key=diary_no, 'M',conn_type) as c_type,list FROM conct WHERE (conn_key='".$conn_key."' and diary_no IS NOT NULL) ORDER BY if(diary_no='".$conn_key."',0,1),c_type DESC";
                // $result_p = mysql_query($sql_p) or die(mysql_error());
                $builder1 = $this->db->table('conct');
                $builder1->select("diary_no, CASE WHEN conn_key = diary_no THEN 'M' ELSE conn_type END AS c_type, list");
                $builder1->where('conn_key', $conn_key);
                $builder1->where('diary_no IS NOT NULL');
                $builder1->orderBy('CASE WHEN diary_no = ' . $conn_key . ' THEN 0 ELSE 1 END', 'ASC', false);
                $builder1->orderBy('c_type', 'DESC');
                $query1 = $builder1->get();
                $result_p = $query1->getResultArray();
                foreach ($result_p as $row) {
                    // while ($row = mysql_fetch_array($result_p)) {
                    if($chk_for_main=='' and $row['c_type']!='M'){
                        $me2[$conn_key]['diary_no'] = $conn_key;
                        $me2[$conn_key]['c_type'] = 'M';
                        $me2[$conn_key]['list'] = 'Y';
                        $chk_for_main='over';
                    }
                    $me2[$row['diary_no']]['diary_no'] = $row['diary_no'];
                    $me2[$row['diary_no']]['c_type'] = $row['c_type'];
                    $me2[$row['diary_no']]['list'] = $row['list'];
                } 
            }
        }
        return $me2; 

    }

    function get_conn_cases_html($conn_cases){
    
        $connchks = '';
        $conncases = $conn_cases;
        // $connchks = "<table class='table_tr_th_w_clr c_vertical_align'  width='100%'><tr><td align='center' colspan='5'><font color='red'><b>CONNECTED CASES</b></font></td></tr>";
        // $connchks .= "<tr><td align='center' width='30px'><b></b></td><td><b>Case No.</b></td><td><b>Petitioner Vs. Respondant</b></td><td align='center'><b>Status</b></td><td><b>IA</b></td></tr>";
        $sn = 0;
        $t_conn_cases = "";
        if(!empty($conncases)){
            foreach ($conncases as $row => $link) {
                if ($link["c_type"] != "") {
                    $sn++;
                    $main_details = $this->get_main_details( $link["diary_no"], "diary_no,pet_name,res_name,c_status,fil_no_fh");
                    if (is_array($main_details)) {
                        foreach ($main_details as $rowm => $linkm) {
                            $t_pname = $linkm["pet_name"];
                            $t_rname = $linkm["res_name"];
                            $t_status = $linkm["c_status"];
                            $t_fil_no_fh = $linkm["fil_no_fh"];
                            if ($link["list"] == "Y") {
                                $chked = "checked";
                            } else {
                                $chked = "";
                            }
                            if ($linkm["c_status"] == "D") {
                                $chked = " disabled=disabled";
                            }
                        }
                    }
                    $t_brdrem = $this->get_brd_remarks($link["diary_no"]);
                    $t_conn_type = "";
                    if ($link["c_type"] == "M") {
                        $t_conn_type = "Main";
                    }
                    if ($link["c_type"] == "C") {
                        $t_conn_type = "Connected";
                    }
                    if ($link["c_type"] == "L") {
                        $t_conn_type = "Linked";
                    }
                    if ( $link["c_type"] != "M" and $t_status == "P" and $link["diary_no"] != "") {
                        $t_conn_cases .= '<tr><td><input type="checkbox" name="conncchk' . $link["diary_no"] . '" id="conncchk' . $link["diary_no"] . '" value="' . $link["diary_no"] . '"/><label class="lblclass" for="conncchk' . $link["diary_no"] . '">' . $this->get_real_diaryno($link["diary_no"]) . "</label></td></tr>";
                    }
    
                    $mul_cat = $this->get_mul_category($link["diary_no"]);
                    $connchks .= "<tr><td align='center' width='30px'>" . $sn . "</td><td>" . $this->get_real_diaryno($link["diary_no"]) . "</td><td>" . $t_conn_type . "</td><td>" . $t_pname . " Vs. " . $t_rname . "</td><td>" . $mul_cat[0] . "</td><td align='center'>" . $t_status . "</td><td align='center'></td><td align='center'>" . $link["list"] . "</td><td></td></tr>";
    
                    if ($link["c_type"] != "M") {
                        if ($t_fil_no_fh == "") {
                            $t_check = '<div class="fh_error" style="display:none;"><font color="red">Case is not registered in Regular Hearing</font></div>';
                        } else {
                            $t_check = "";
                        }
    
                        // $connchks .= "<tr><td align='center'><input type='checkbox' name='ccchk" . $link["diary_no"] . "' id='ccchk" . $link["diary_no"] . "' value='" . $link["diary_no"] . "' " . $chked . " ></td><td>" . $this->get_real_diaryno($link["diary_no"]) . "</td><td>" . $t_pname . " Vs. " . $t_rname . $t_check . "</td><td align='center'>" . $t_status . "</td><td><input type='hidden' name='brdremh_" . $link["diary_no"] . "' id='brdremh_" . $link["diary_no"] . "' value=" . $t_brdrem . "><textarea style='width:95%' name='brdrem_" . $link["diary_no"] . "' id='brdrem_" . $link["diary_no"] . "' rows='3'>" . $t_brdrem . "</textarea>" . $this->get_ia($link["diary_no"]) . "</td></tr>";
                    }
                }
            }
        }
        
        $connchks .= "</table>";

        return array('t_conn_cases' => $t_conn_cases, 'connchks' => $connchks);

    }

    
    function get_case_nos($dn,$separator,$rby=''){
    
        $t_fil_no='';
        // $sql_from_main="SELECT casetype_id,
        // CONCAT(
        //     m.active_fil_no,
        //     ':',
        //     IF(
        //     (
        //         active_reg_year = 0 
        //         OR DATE(active_fil_dt) > DATE('2017-05-10')
        //     ),
        //     YEAR(active_fil_dt),
        //     active_reg_year
        //     ),
        //     ':',
        //     DATE_FORMAT(active_fil_dt, '%d-%m-%Y')
        // ) ad,
        // IF(fil_no_fh!=active_fil_no AND fil_no_fh!=fil_no AND fil_no_fh!='', CONCAT(
        //     m.fil_no_fh,
        //     ':',
        //     IF(
        //     (
        //         reg_year_fh = 0 
        //         OR DATE(fil_dt_fh) > DATE('2017-05-10')
        //     ),
        //     YEAR(fil_dt_fh),
        //     reg_year_fh
        //     ),
        //     ':',
        //     DATE_FORMAT(fil_dt_fh, '%d-%m-%Y')
        // ),'') rd,
        // IF(fil_no!=active_fil_no AND fil_no_fh!=fil_no AND fil_no!='', CONCAT(
        //     m.fil_no,
        //     ':',
        //     IF(
        //     (
        //         reg_year_mh = 0 
        //         OR DATE(fil_dt) > DATE('2017-05-10')
        //     ),
        //     YEAR(fil_dt),
        //     reg_year_mh
        //     ),
        //     ':',
        //     DATE_FORMAT(fil_dt, '%d-%m-%Y')
        // ),'') md
        // FROM
        // main m 
        // WHERE `diary_no` = ".$dn; 
        // $result_main = mysql_query($sql_from_main) or die(mysql_error().$sql_from_main);

        $builder = $this->db->table('main m');
        $builder->select("casetype_id,
            CONCAT(
                active_fil_no,
                ':',
                CASE
                    WHEN active_reg_year = 0 OR active_fil_dt > '2017-05-10'::date THEN EXTRACT(YEAR FROM active_fil_dt)::VARCHAR
                    ELSE active_reg_year::VARCHAR
                END,
                ':',
                TO_CHAR(active_fil_dt, 'DD-MM-YYYY')
            ) ad,
            CASE
                WHEN fil_no_fh != active_fil_no AND fil_no_fh != fil_no AND fil_no_fh != '' THEN CONCAT(
                    fil_no_fh,
                    ':',
                    CASE
                        WHEN reg_year_fh = 0 OR fil_dt_fh > '2017-05-10'::date THEN EXTRACT(YEAR FROM fil_dt_fh)::VARCHAR
                        ELSE reg_year_fh::VARCHAR
                    END,
                    ':',
                    TO_CHAR(fil_dt_fh, 'DD-MM-YYYY')
                )
                ELSE ''
            END rd,
            CASE
                WHEN fil_no != active_fil_no AND fil_no_fh != fil_no AND fil_no != '' THEN CONCAT(
                    fil_no,
                    ':',
                    CASE
                        WHEN reg_year_mh = 0 OR fil_dt > '2017-05-10'::date THEN EXTRACT(YEAR FROM fil_dt)::VARCHAR
                        ELSE reg_year_mh::VARCHAR
                    END,
                    ':',
                    TO_CHAR(fil_dt, 'DD-MM-YYYY')
                )
                ELSE ''
            END md", false);
        $builder->where('diary_no', $dn);
        $query = $builder->get();
        $result_main = $query->getResultArray();

        $cases="";
        if(count($result_main)>0){
            $row_main= $result_main[0];
            if($row_main['ad']!=''){
                $t_m_y=explode(':',$row_main['ad']);
                if($t_m_y[0]!=''){
                    $cases.=$t_m_y[0].",";
                    $t_m1=substr($t_m_y[0],0,2);
                    $t_m2=substr($t_m_y[0],3,6);
                    $t_m21=substr($t_m_y[0],10,6);
                    $t_m3=$t_m_y[1];
                    $t_m4=$t_m_y[2];
                    // $sql_ct_type = mysql_query("Select short_description,cs_m_f from casetype where casecode='".$t_m1."' and display='Y'") or die("Error" . __LINE__ . mysql_error());
                    // $row=mysql_fetch_array($sql_ct_type);
                    $builder1 = $this->db->table('master.casetype');
                    $builder1->select('short_description,cs_m_f');
                    $builder1->where('casecode', $t_m1);
                    $builder1->where('display', 'Y');
                    $query1 = $builder1->get();
                    $row = $query1->getResultArray();
                    $row = $row[0];
                    $res_ct_typ = $row['short_description'];   
                    $res_ct_typ_mf = $row['cs_m_f'];
                    if($t_m2==$t_m21){
                        $t_fil_no.= '<font color="#043fff" style=" white-space: nowrap;">'.$res_ct_typ." ".$t_m2.' / '.$t_m3.'</font>'.$separator."(Reg.Dt.".$t_m4.")<br>";
                    }else{
                        $t_fil_no.= '<font color="#043fff" style=" white-space: nowrap;">'.$res_ct_typ." ".$t_m2.' - '. $t_m21 .' / '.$t_m3.'</font>'.$separator."(Reg.Dt.".$t_m4.")<br>";
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
                    // $sql_ct_type = mysql_query("Select short_description,cs_m_f from casetype where casecode='".$t_m1."' and display='Y'") or die("Error" . __LINE__ . mysql_error());
                    // $row=mysql_fetch_array($sql_ct_type);
                    $builder1 = $this->db->table('master.casetype');
                    $builder1->select('short_description,cs_m_f');
                    $builder1->where('casecode', $t_m1);
                    $builder1->where('display', 'Y');
                    $query1 = $builder1->get();
                    $row = $query1->getResultArray();
                    $row = $row[0];
                    $res_ct_typ = $row['short_description'];   
                    $res_ct_typ_mf = $row['cs_m_f'];
                    if($t_m2==$t_m21){
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
                    // $sql_ct_type = mysql_query("Select short_description,cs_m_f from casetype where casecode='".$t_m1."' and display='Y'") or die("Error" . __LINE__ . mysql_error());
                    // $row=mysql_fetch_array($sql_ct_type);
                    $builder1 = $this->db->table('master.casetype');
                    $builder1->select('short_description,cs_m_f');
                    $builder1->where('casecode', $t_m1);
                    $builder1->where('display', 'Y');
                    $query1 = $builder1->get();
                    $row = $query1->getResultArray();
                    $row = $row[0];
                    $res_ct_typ = $row['short_description'];   
                    $res_ct_typ_mf = $row['cs_m_f'];
                    if($t_m2==$t_m21){
                        $t_fil_no.= '<font color="#043fff" style=" white-space: nowrap;">'.$res_ct_typ." ".$t_m2.' / '.$t_m3.'</font>'.$separator."(Reg.Dt.".$t_m4.")<br>";
                    }else{
                        $t_fil_no.= '<font color="#043fff" style=" white-space: nowrap;">'.$res_ct_typ." ".$t_m2.' - '. $t_m21 .' / '.$t_m3.'</font>'.$separator."(Reg.Dt.".$t_m4.")<br>";
                    }
                }
            }
        }
        // $sql_mc_h="SELECT t.oldno,
        // GROUP_CONCAT(DISTINCT CONCAT(t.new_registration_number,':',t.new_registration_year,':',DATE_FORMAT(t.order_date,'%d-%m-%Y')) ORDER BY t.order_date,t.id ) AS newno FROM
        // (SELECT @rowid:=@rowid+1 AS rowid,`main_casetype_history`.*, IF(@rowid=1,IF(old_registration_number='' OR old_registration_number IS NULL,'',CONCAT(old_registration_number,':',old_registration_year,':',DATE_FORMAT(order_date,'%d-%m-%Y'))),'') AS oldno 
        // FROM `main_casetype_history`, (SELECT @rowid:=0) AS init
        // WHERE `diary_no` = ".$dn." AND is_deleted='f'
        // ORDER BY `main_casetype_history`.`order_date`,id ) t GROUP BY t.diary_no";
        $builder2 = $this->db->table('main_casetype_history');
        $builder2->select('t.oldno');
        $builder2->select("STRING_AGG(DISTINCT CONCAT(t.new_registration_number, ':', t.new_registration_year, ':', TO_CHAR(t.order_date, 'DD-MM-YYYY')), ' ') AS newno");
        $subQuery = $this->db->table('main_casetype_history')
            ->select('ROW_NUMBER() OVER (ORDER BY order_date, id) AS rowid', false)
            ->select('*')
            ->select("CASE
                            WHEN ROW_NUMBER() OVER (ORDER BY order_date, id) = 1
                            THEN COALESCE(NULLIF(old_registration_number, ''), CONCAT(old_registration_number, ':', old_registration_year, ':', TO_CHAR(order_date, 'DD-MM-YYYY')))
                            ELSE ''
                        END AS oldno", false)
            ->where('diary_no', '16892023')
            ->where('is_deleted', 'f')
            ->getCompiledSelect();
        $builder2->from("($subQuery) t");
        $builder2->groupBy(['t.diary_no', 't.oldno']);
    
        // $queryString = $builder2->getCompiledSelect();
        // echo $queryString;
        // exit();

        $query2 = $builder2->get();
        $result_mc_h = $query2->getResultArray(); 
        // $result_mc_h = mysql_query($sql_mc_h) or die(mysql_error().$sql_mc_h);
        if(count($result_mc_h)>0){
            $cnt=0;
            foreach ($result_mc_h as $row_mc_h) {
                // while($row_mc_h=mysql_fetch_array($result_mc_h)){
                if($row_mc_h['oldno']!=''){
                    $t_m=explode(',',$row_mc_h['oldno']);        
                    $t_m_y=explode(':',$t_m[0]);
                    $pos = strpos($cases, $t_m_y[0]);            
                    if ($pos === false) {
                        $cnt++;
                        if($cnt%2==0){
                            $bgcolor="#ff0015";
                        }else{
                            $bgcolor="#ff01c8";
                        }
                        $cases.=$t_m_y[0].",";
                        $t_m1=substr($t_m_y[0],0,2);
                        $t_m2=substr($t_m_y[0],3,6);
                        $t_m21=substr($t_m_y[0],10,6);
                        $t_m3=$t_m_y[1];
                        $t_m4=$t_m_y[2];
                        // $sql_ct_type = mysql_query("Select short_description,cs_m_f from casetype where casecode='".$t_m1."' and display='Y'") or die("Error" . __LINE__ . mysql_error());
                        // $row=mysql_fetch_array($sql_ct_type);
                        $builder1 = $this->db->table('master.casetype');
                        $builder1->select('short_description,cs_m_f');
                        $builder1->where('casecode', $t_m1);
                        $builder1->where('display', 'Y');
                        $query1 = $builder1->get();
                        $row = $query1->getResultArray();
                        $row = $row[0];
                        $res_ct_typ = $row['short_description'];   
                        $res_ct_typ_mf = $row['cs_m_f'];
                        if($t_m2==$t_m21){
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
                            $cases.=$t_m_y[0].",";
                            $t_m1=substr($t_m_y[0],0,2);
                            $t_m2=substr($t_m_y[0],3,6);
                            $t_m21=substr($t_m_y[0],10,6);
                            $t_m3=$t_m_y[1];
                            $t_m4=$t_m_y[2];  
                            $t_fn=$t_m_y[0];
                            if($t_chk!=$t_fn){
                                $cnt++;
                                if($cnt%2==0){
                                    $bgcolor="#ff0015";
                                }else{
                                    $bgcolor="#ff01c8";
                                }
                                // $sql_ct_type = mysql_query("Select short_description,cs_m_f from casetype where casecode='".$t_m1."' and display='Y'") or die("Error" . __LINE__ . mysql_error());
                                // $row=mysql_fetch_array($sql_ct_type);
                                $builder1 = $this->db->table('master.casetype');
                                $builder1->select('short_description,cs_m_f');
                                $builder1->where('casecode', $t_m1);
                                $builder1->where('display', 'Y');
                                $query1 = $builder1->get();
                                $row = $query1->getResultArray();
                                $row = $row[0];
                                $res_ct_typ = $row['short_description'];   
                                $res_ct_typ_mf = $row['cs_m_f'];
                                if($t_m2==$t_m21)
                                $t_fil_no.='<font color="'.$bgcolor.'" style=" white-space: nowrap;">'.$res_ct_typ." ".$t_m2.' / '.$t_m3.'</font>'.$separator."(Reg.Dt.".$t_m4.")<br>";
                                else
                                $t_fil_no.='<font color="'.$bgcolor.'" style=" white-space: nowrap;">'.$res_ct_typ." ".$t_m2.' - '. $t_m21 .' / '.$t_m3.'</font>'.$separator."(Reg.Dt.".$t_m4.")<br>";
                            }
                            $t_chk=$t_fn;        
                        }
                    }
                }        
            }
        }
    
        if(trim($t_fil_no)==''){
            // $sql12=   "SELECT short_description from casetype where casecode='".$row_main['casetype_id']."'";
            // $results12 = mysql_query($sql12) or die(mysql_error()." SQL:".$sql12);
            $builder1 = $this->db->table('master.casetype');
            $builder1->select('short_description');
            $builder1->where('casecode', $row_main['casetype_id']);
            $query1 = $builder1->get();
            $results12 = $query1->getResultArray();
            if (count($results12) > 0) {
                $row_12 = $results12[0]; 
                $t_fil_no=$row_12['short_description'];
            }
        }                    
                
        return $t_fil_no;   
    }

    function get_next_working_date($dt){
        $cdate=$dt;
        $cdate1 = date('d-m-Y',strtotime($cdate));
        for($i=1; $i<=1; $i++){
            $dateget=getdate(strtotime($cdate1));
            $t_dtt1=$dateget['year']."-".$dateget['mon']."-".$dateget['mday'];
            $sql="SELECT count(*) FROM holidays WHERE hdate='".$t_dtt1."'";
            $results=mysql_query($sql);
            $row=mysql_fetch_array($results);
            if($dateget['weekday']=="Saturday" OR $dateget['weekday']=="Sunday" OR $row[0]>0)
            {
                $cdate1 = date('d-m-Y',strtotime($cdate) + (24*3600*1));
            $i--;
            }
            $cdate=$cdate1;
        }
        return $cdate1;
    }

    function navigate_diary($dno){
        $sql = "SELECT m.diary_no, c1.short_description, m.active_reg_year, m.active_fil_no,
            m.pet_name, m.res_name, pno, rno, m.diary_no_rec_date, m.active_fil_dt, m.lastorder, m.c_status FROM main m 
            left JOIN casetype c1 ON m.active_casetype_id = c1.casecode WHERE m.diary_no = '$dno'";
        $res=mysql_query($sql) or die(mysql_error());    
        while($ro=mysql_fetch_array($res)){
                $filno_array = explode("-",$ro['active_fil_no']);             
            if(empty($filno_array[0])){
                $fil_no_print = "Unreg."; 
            }            
            else{
                $fil_no_print = $ro['short_description']."/".ltrim($filno_array[1], '0');
                if(!empty($filno_array[2]) and $filno_array[1] != $filno_array[2])
                    $fil_no_print .= "-".ltrim($filno_array[2], '0');
                $fil_no_print .= "/".$ro['active_reg_year'];                
            }
            if($ro['c_status'] == "P"){
                $cstatus = "Pending";
            }
            else{
                $cstatus = "Disposed";
            }
            $_SESSION['session_c_status'] = $cstatus;
            $_SESSION['session_pet_name'] = $ro['pet_name'];                
            $_SESSION['session_res_name'] = $ro['res_name'];
            $_SESSION['session_lastorder'] = $ro['lastorder'];
            $_SESSION['session_diary_recv_dt'] = date('d-m-Y H:i:s', strtotime($ro['diary_no_rec_date']));
            $_SESSION['session_active_fil_dt '] = date('d-m-Y H:i:s', strtotime($ro['active_fil_dt']));
            $_SESSION['session_diary_no'] = substr($dno,0,-4);
            $_SESSION['session_diary_yr'] = substr($dno,-4);
            $_SESSION['session_active_reg_no'] = $fil_no_print;                
        }
                
    }   

    function ifInFinalList($diaryNo){
        $result=false;
        $sql="select h.next_dt from heardt h join 
        (select next_dt from (select aa.next_dt, ad.* from advance_allocated aa
        left join advanced_drop_note ad on aa.diary_no = ad.diary_no and aa.next_dt = ad.cl_date
        left join heardt h on h.diary_no = aa.diary_no and h.next_dt = aa.next_dt
        where h.diary_no is not null
        and (aa.diary_no=$diaryNo) and date(aa.next_dt)>='current_date()'
        group by aa.conn_key
        ) a where a.cl_date is null )b on h.next_dt=b.next_dt where 
        main_supp_flag in(1,2) and 
        h.diary_no=$diaryNo ;";
        $res=mysql_query($sql) or die(mysql_error());
        if(mysql_num_rows($res)>0){
            $result=true;
        }
        return $result;
    }

    function ifInAdvanceList($diaryNo){
        $result=false;
        $sql="select next_dt from (select aa.next_dt, ad.* from advance_allocated aa
        left join advanced_drop_note ad on aa.diary_no = ad.diary_no and aa.next_dt = ad.cl_date
        left join heardt h on h.diary_no = aa.diary_no and h.next_dt = aa.next_dt
        where h.diary_no is not null
        and (aa.diary_no=$diaryNo) and date(aa.next_dt)>=current_date() 
        group by aa.conn_key
        ) a where a.cl_date is null";
    

        $res=mysql_query($sql) or die(mysql_error());
        if(mysql_num_rows($res)>0){
            $result=true;
        }
        return $result;
    }

    function ifInAdvanceListSingleJudge($diaryNo){
        $result=false;
        $sql="select next_dt from (select aa.next_dt, ad.* from advance_allocated aa
        left join advanced_drop_note ad on aa.diary_no = ad.diary_no and aa.next_dt = ad.cl_date
        left join heardt h on h.diary_no = aa.diary_no and h.next_dt = aa.next_dt
        where h.diary_no is not null and h.board_type='S'
        and (aa.diary_no=$diaryNo) and date(aa.next_dt)>=current_date() 
        group by aa.conn_key
        ) a where a.cl_date is null";       

        $res=mysql_query($sql) or die(mysql_error());
        if(mysql_num_rows($res)>0){
            $result=true;
        }
        return $result;
    }

    function ifInFinalListSingleJudge($diaryNo){
        $result=false;
        $sql="select h.next_dt from heardt h join 
        (select next_dt from (select aa.next_dt, ad.* from advance_allocated aa
        left join advanced_drop_note ad on aa.diary_no = ad.diary_no and aa.next_dt = ad.cl_date
        left join heardt h on h.diary_no = aa.diary_no and h.next_dt = aa.next_dt
        where h.diary_no is not null and h.board_type='S'
        and (aa.diary_no=$diaryNo) and date(aa.next_dt)>='current_date()'
        group by aa.conn_key
        ) a where a.cl_date is null )b on h.next_dt=b.next_dt where 
        main_supp_flag in(1,2) and 
        h.diary_no=$diaryNo ;";
        $res=mysql_query($sql) or die(mysql_error());
        if(mysql_num_rows($res)>0){
            $result=true;
        }
        return $result;
    }

    function get_advocates($adv_id,$wen=''){
        //with Enrollment No.
        $t_adv="";
        if($adv_id!=0){
                // $sql11a = "SELECT name,enroll_no,YEAR(enroll_date) as eyear, isdead  FROM  bar where bar_id IN (".$adv_id.")";
                // $t11a = mysql_query($sql11a);
                $builder = $this->db->table('master.bar');
                $builder->select('name, enroll_no, EXTRACT(YEAR FROM enroll_date) as eyear, isdead');
                $builder->where('bar_id', $adv_id);
                $query = $builder->get();
                $t11a = $query->getResultArray();
                if (count($t11a) > 0) {
                    foreach ($t11a as $row11a) {
                        // while ($row11a = mysql_fetch_array($t11a)) {
                        $t_adv=$row11a['name'];
                        if($row11a['isdead']=='Y'){
                            $t_adv="<font color=red>".$t_adv." (Dead / Retired / Elevated) </font>"; 
                        }               
                        if($wen=='wen'){
                            $t_adv.=" [".$row11a['enroll_no']."/".$row11a['eyear']."]";
                        }
                    }
                        
                }
        }
        return $t_adv;
    }

    function get_main_details($dn,$fields){
        $data_array = array(); 
        if($dn!=""){
            if($fields==""){
                $fields="*";
            }
            // $sql = mysql_query("Select ".$fields." from main where diary_no='".$dn."'") or die('Error: ' . __LINE__ . mysql_error());
            $builder = $this->db->table('main');
            $builder->select($fields);
            $builder->where('diary_no', $dn);
            $query = $builder->get();
            $sql = $query->getResultArray();
            if (count($sql) > 0) {
                foreach ($sql as $row) {
                    // while($row = mysql_fetch_assoc($sql)){
                    foreach($row as $key => $value) {
                        $data_array[$row['diary_no']][$key] = $value;
                    }
                }
            }
        }
        return $data_array;
    }

    function get_brd_remarks($dn){
        $brdrem="";
        // $sqlbr_conn = "select remark from brdrem where diary_no='" . $dn . "'";
        $builder = $this->db->table('brdrem');
        $builder->select('remark');
        $builder->where('diary_no', $dn);
        $query = $builder->get();
        $results_br_conn = $query->getResultArray();
        // $results_br_conn = mysql_query($sqlbr_conn);
            if (count($results_br_conn) > 0) {
                $row_br_conn = $results_br_conn[0];
                $brdrem=$row_br_conn['remark'];
            }
        return $brdrem;
    }

    function get_real_diaryno($dn){
        $real_diary_no="";
        if($dn!=""){
            $real_diary_no=substr($dn, 0, -4)."/".substr($dn, -4);
        }
        return $real_diary_no;
    }

    function get_ia($dn){
        $ian_p_conn = "";
        //    $sql_ian_conn = "select a.diary_no,a.doccode,a.doccode1,a.docnum,a.docyear,a.filedby,a.docfee,a.forresp,a.feemode,a.ent_dt,a.other1,a.iastat,b.docdesc from docdetails a,  docmaster b  where a.doccode=b.doccode and a.doccode1=b.doccode1 and a.diary_no='" . $dn . "' and a.doccode=8 and a.display='Y' order by ent_dt";
        $builder = $this->db->table('docdetails a');
        $builder->select('a.diary_no, a.doccode, a.doccode1, a.docnum, a.docyear, a.filedby, a.docfee, a.forresp, a.feemode, a.ent_dt, a.other1, a.iastat, b.docdesc');
        $builder->join('master.docmaster b', 'a.doccode = b.doccode AND a.doccode1 = b.doccode1', 'INNER');
        $builder->where('a.diary_no', $dn);
        $builder->where('a.doccode', 8);
        $builder->where('a.display', 'Y');
        $builder->orderBy('a.ent_dt');
        $query = $builder->get();
        $results_ian_conn = $query->getResultArray();

        // $results_ian_conn = mysql_query($sql_ian_conn);
        $iancntr_conn = 1;
        if (count($results_ian_conn) > 0) {
            $ian_p_inhdt = $listed_ia_conn = "";
                // $sql_ian_inhdt = "select listed_ia from heardt  where diary_no='" . $dn . "'";
                // $results_ian_inhdt = mysql_query($sql_ian_inhdt);
                $builder2 = $this->db->table('heardt');
                $builder2->select('listed_ia');
                $builder2->where('diary_no', $dn);
                $query2 = $builder2->get();
                $results_ian_inhdt = $query2->getResultArray();
            if (count($results_ian_inhdt) > 0) {
                $row_ian_inhdt = $results_ian_inhdt[0];
                $listed_ia_conn = $row_ian_inhdt["listed_ia"];
            }
            foreach ($results_ian_conn as $row_ian_conn) {
                // while ($row_ian_conn = mysql_fetch_array($results_ian_conn)) {
                if ($ian_p_conn == "" and $row_ian_conn["iastat"] == "P") {
                    $ian_p_conn = "<div style='overflow:auto; max-height:100px;'><table border='1' bgcolor='#F5F5FC' class='tbl_hr' width='98%' cellspacing='0' cellpadding='3'>";
                }
                if ($row_ian_conn["other1"] != "")
                    $t_part_conn = $row_ian_conn["docdesc"] . " [" . $row_ian_conn["other1"] . "]";
                else
                    $t_part_conn = $row_ian_conn["docdesc"];
                $t_ia_conn = "";
                if ($row_ian_conn["iastat"] == "P")
                    $t_ia_conn = "<font color='blue'>" . $row_ian_conn["iastat"] . "</font>";
                if ($row_ian_conn["iastat"] == "D")
                    $t_ia_conn = "<font color='red'>" . $row_ian_conn["iastat"] . "</font>";
                if ($row_ian_conn["iastat"] == "P") {
                    $t_iaval_conn = $row_ian_conn["docnum"] . "/" . $row_ian_conn["docyear"] . ",";
                    if (strpos($listed_ia_conn, $t_iaval_conn) !== false)
                        $check = "checked='checked'";
                    else
                        $check = "";
                    $ian_p_conn.="<tr><td align='center'><input type='checkbox' name='cn_ia_" . $row_ian_conn["diary_no"] . "_" . $iancntr_conn . "' id='cn_ia_" . $row_ian_conn["diary_no"] . "_" . $iancntr_conn . "' value='" . $row_ian_conn["diary_no"] . "|#|" . $row_ian_conn["docnum"] . "/" . $row_ian_conn["docyear"] . "|#|" . str_replace("XTRA", "", $t_part_conn) . "' onClick='feed_rmrk_conn(\"" . $row_ian_conn["diary_no"] . "\");' " . $check . "></td><td align='center'>" . $row_ian_conn["docnum"] . "/" . $row_ian_conn["docyear"] . "</td><td align='left'>" . str_replace("XTRA", "", $t_part_conn) . "</td><td align='center'>" . date("d-m-Y", strtotime($row_ian_conn["ent_dt"])) . "</td></tr>";
                }
                $iancntr_conn++;
            }
        }
        if ($ian_p_conn != ""){
            $ian_p_conn.="</table></div>";
        }
        return $ian_p_conn;
    } 

    function get_display_status_with_date_differnces($tentative_cl_dt){
        $tentative_cl_date_greater_than_today_flag="F";
        $curDate=date('d-m-Y');
        $tentativeCLDate = date('d-m-Y', strtotime($tentative_cl_dt));
        $datediff=strtotime($tentativeCLDate) - strtotime($curDate);
        $noofdays= round($datediff / (60 * 60 * 24));

        if(strtotime($tentativeCLDate) > strtotime($curDate) ){
            if($noofdays<=60 && $noofdays>0){
                //echo "no of days ddd".$noofdays;
                $tentative_cl_date_greater_than_today_flag='T';
            }
        }else{
            $tentative_cl_date_greater_than_today_flag='F';
        }
        return $tentative_cl_date_greater_than_today_flag;
    }

    function change_date_format($date){
        if($date=="" or $date=="0000-00-00")
            $date="";
        else
            $date=date('d-m-Y', strtotime($date));
        return $date;
    }


    function get_coram($data){
        $diary_no = $data['diary_no'];
        $cl_date = $data['cl_dt'];
        $cl_date = date('Y-m-d', strtotime($cl_date));

        if ($diary_no != '' AND $cl_date != '') {
            // $sql = "select jcode,jname from judge where find_in_set(jcode,  
            // (select judges as judge_code from last_heardt
            // where diary_no='$diary_no' and clno!=0 and brd_slno!=0 and roster_id!=0 and judges!='' and (bench_flag = '' and bench_flag is null) and next_dt='$cl_date' group by judges));";
            // $result=mysql_query($sql) or die("Error: " . __LINE__ . mysql_error());
            $subQuery = $this->db->table('last_heardt')
                ->select("STRING_AGG(judges, ',') as judge_code")
                ->where('diary_no', $diary_no)
                ->where('clno !=', 0)
                ->where('brd_slno !=', 0)
                ->where('roster_id !=', 0)
                ->where('judges !=', '')
                ->where('bench_flag', '')
                ->orWhere('bench_flag', null)
                ->where('next_dt', $cl_date)
                ->groupBy('judges')
                ->get();
            $subQueryData = $subQuery->getResultArray();

            $jCode_Arr = [];
            if(!empty($subQueryData)){
                foreach ($subQueryData as $val) {
                    $vr1 = trim($val['judge_code']);
                    $vr2 = explode(',', $vr1);
                    if(!empty($vr2)){
                        foreach ($vr2 as $vle) {
                            $jCode_Arr[] = trim($vle);
                        }
                    }
                }
            }
            if(!empty($jCode_Arr)){
                $jCode_Arr = array_unique($jCode_Arr);
            }                
            $builder = $this->db->table('master.judge');
            $builder->select('jcode, jname');
            $builder->whereIn('jcode', $jCode_Arr);
            $query = $builder->get();
            $result = $query->getResultArray();
            // echo "<pre>";
            // print_r($result); die;

            $output="";
            if(count($result)>0) {
                $count=1;
                foreach ($result as $row) {
                    // while($row= mysql_fetch_array($result)){
                    $output.='<tr><td><input type="checkbox" id="hd_chk_jd'.$count.'" value="'.$row["jcode"].'||'.str_replace("\\","",$row["jname"]).'" checked><label style="color: red; font-weight: bold;">'.$row["jname"].'</label></td></tr>';
                }
            }else {
                $subQuery = $this->db->table('heardt')
                ->select("STRING_AGG(judges, ',') as judge_code")
                ->where('diary_no', $diary_no)
                ->where('clno !=', 0)
                ->where('brd_slno !=', 0)
                ->where('roster_id !=', 0)
                ->where('judges !=', '')
                ->where('next_dt', $cl_date)
                ->groupBy('judges')
                ->get();
                $subQueryData = $subQuery->getResultArray();
                $jCode_Arr = [];
                if(!empty($subQueryData)){
                    foreach ($subQueryData as $val) {
                        $vr1 = trim($val['judge_code']);
                        $vr2 = explode(',', $vr1);
                        if(!empty($vr2)){
                            foreach ($vr2 as $vle) {
                                $jCode_Arr[] = trim($vle);
                            }
                        }
                    }
                }
                if(!empty($jCode_Arr)){
                    $jCode_Arr = array_unique($jCode_Arr);
                }                
                $builder = $this->db->table('master.judge');
                $builder->select('jcode, jname');
                $builder->whereIn('jcode', $jCode_Arr);
                $query = $builder->get();
                $result = $query->getResultArray();


                $output = "";
                if (count($result) > 0) {
                    $count = 1;
                    foreach ($result as $row) {
                        // while ($row = mysql_fetch_array($result)) {
                        $output .= '<tr><td><input type="checkbox" id="hd_chk_jd' . $count . '" value="' . $row["jcode"] . '||' . str_replace("\\", "", $row["jname"]) . '" checked><label style="color: red; font-weight: bold;">' . $row["jname"] . '</label></td></tr>';
                    }

                }
            }
            echo $output;
        }
    }

    function chk_disp_date($disp_dt){
        $m1=date('m',strtotime($disp_dt));
        $y1=date('Y',strtotime($disp_dt));
        $m2=date('m');
        $y2=date('Y');
        $y=$y2-$y1;
        if($m2>=$m1){
            $m=$m2-$m1;
        }else{
           $m=12-($m1-$m2); 
           $y--;
        }
        $rm=($y*12)+$m;
        return $rm;
    }

    function insert_rec_an_disp($data){

        $check_for_regular_case="";
        $temp_mh='';
        $tdt_str='';
        $ucode = $_SESSION['login']['usercode'];

        $str=$_POST['str'];
        $str1=$_POST['str1'];
        $dt=$_POST['dt'];
        $hdt=$_POST['hdt'];
        $rjdt=$_POST['rjdt'];
        if(isset($_POST['concstr'])){
            $concstr = $_POST['concstr'];
        }else{
            $concstr = "";   
        }

        if($concstr!=''){
            $cncases=explode(',',$concstr);   
            $cncntr=count($cncases);
        }else{
            $cncntr=1; 
        }

        $bench='';
        $uip1='';
        $umac1='';
        $rec=explode("#",$str);
        $fno=$rec[0];
        $status=$rec[1];
        $rec_rem=explode("!",$rec[2]);
        $subh=$rec[3];
        $jcodes=$str1; 
        $jcodes1=explode(",",$jcodes);
        $j1=$jcodes1[0];
        $err="";
        $rcount=count($rec_rem);
        $head_r = array(); 
        $head_c = array(); 
        $i_cnt=0;
        $check_case_withdraw="";
        for ( $i = 0; ($i < ($rcount-1)); $i++) {
            $rec1=explode("|",$rec_rem[$i]);
            $head=$rec1[0];
            $head_cont=$rec1[1];
            if($head==35){
                $check_case_withdraw="YES";  
            }         
            if($head!=16){
                $head_r[$i_cnt]=$rec1[0];
                $head_c[$i_cnt]=$rec1[1];
            }else{
                $i_cnt--;
            }
            $i_cnt++;
        }
        $up_str="";$side="";$disp_code="";$nature="";$disp_code_all="";
        for($i=0;$i<count($head_r);$i++){
            // $str_cr = "SELECT sno,head,side,cis_disp_code,pending_text FROM case_remarks_head WHERE sno=".$head_r[$i]."";
            // $results_cr=mysql_query($str_cr) or die(mysql_error().$str_cr);
            $builder = $this->db->table('master.case_remarks_head');
            $builder->select('sno,head,side,cis_disp_code,pending_text');
            $builder->where('sno', $head_r[$i]);
            $query = $builder->get();
            $results_cr = $query->getResultArray();

            if(count($results_cr) > 0){
                if($i>0){
                    $up_str.=", ";
                }
                $row_cr = $results_cr[0];            
                if(trim($row_cr["pending_text"])!=""){
                    $up_str.=$row_cr["pending_text"];
                }else{
                    $up_str.=$row_cr["head"];
                }

                if($head_c[$i]!=""){
                    $up_str.=" (".$head_c[$i].")"; 
                }
                $side=$row_cr["side"];
                $disp_code=$row_cr["cis_disp_code"];     
                $disp_code_all.=$row_cr["cis_disp_code"].",";
            }
        }
        $side=$status;
        $tdt=explode("-",$dt);
        $up_str.="-Ord dt:".$tdt[2]."/".$tdt[1]."/".$tdt[0];
        $dday=$dmonth=$dyear=0;
        if($rjdt!="" && $rjdt!="0000-00-00" && $rjdt!="null"){
            $rjdt1=explode("-",$rjdt);
            $dmonth=$rjdt1[1];
            $dyear=$rjdt1[0];
            $dday=$rjdt1[2];
            $t_month= $this->chk_disp_date($rjdt);
        }else{
            $hdt1=explode("-",$hdt);  
            $dmonth=$hdt1[1];
            $dyear=$hdt1[0];
            $dday=$hdt1[2];
            $t_month= $this->chk_disp_date($hdt);
        }
        if(intval($t_month)==1){
            if(intval(date('d'))>=15){
                $dmonth=date('m');
                $dyear=date('Y');    
            }
        }
        if(intval($t_month)>=2){
            $dmonth=date('m');
            $dyear=date('Y');   
        }

        for($ivar=0; $ivar < $cncntr; $ivar++){  
            if($ivar>0){
                $fno=$cncases[$ivar-1];
            }
            if($tdt_str==""){
                // $str_up_main = "UPDATE main SET last_dt=NOW(), lastorder='".$up_str."',c_status='".$side."', last_usercode=".$ucode." where diary_no='".$fno."'";
                $updateData = [
                    'lastorder' => $up_str,
                    'c_status' => $side,
                    'last_usercode' => $ucode,
                    'last_dt' => 'NOW()'
                ];            
                $builder = $this->db->table("main");
                $builder->where('diary_no', $fno);
                $str_up_main = $builder->update($updateData);

            }else{
                // $str_up_main = "UPDATE main SET last_dt=NOW(), lastorder='".$up_str."',c_status='".$side."', last_usercode=".$ucode.$tdt_str." where diary_no='".$fno."'";
                $updateData = [
                    'lastorder' => $up_str,
                    'c_status' => $side,
                    'last_usercode' => $ucode.$tdt_str,
                    'last_dt' => 'NOW()'
                ];            
                $builder = $this->db->table("main");
                $builder->where('diary_no', $fno);
                $str_up_main = $builder->update($updateData);
            }
            // mysql_query($str_up_main) or die(mysql_error().$str_up_main);
            if($row_cr["side"]=="D"){
                // $str_sel_disp = "SELECT * FROM dispose where diary_no='".$fno."'";
                // $results_disp=mysql_query($str_sel_disp) or die(mysql_error().$str_sel_disp);
                $builder1 = $this->db->table('dispose');
                $builder1->select('*');
                $builder1->where('diary_no', $fno);
                $query1 = $builder1->get();
                $results_disp = $query1->getResultArray();

                $disp_str = $up_str; 
                if(count($results_disp) > 0){
                    // $str_up_disp = "UPDATE dispose SET month=".$dmonth.",year=".$dyear.",dispjud=".$j1.", ord_dt='".$dt."', disp_dt='".$hdt."',disp_type=".$disp_code.",disp_type_all='".$disp_code_all."', bench='".$bench."',jud_id='".$jcodes."',rj_dt='".$rjdt."',ent_dt=NOW(),camnt=0,usercode=".$ucode.",crtstat='".$temp_mh."',jorder='' where diary_no='".$fno."'";
                    // mysql_query($str_up_disp) or die(mysql_error().$str_up_disp);                    
                    $updateData = [
                         'month' => $dmonth,
                        'year' => $dyear,
                        'dispjud' => $j1,
                        'ord_dt' => $dt,
                        'disp_dt' => $hdt,
                        'disp_type' => $disp_code,
                        'disp_type_all' => $disp_code_all,
                        'bench' => $bench,
                        'jud_id' => $jcodes,
                        'rj_dt' => $rjdt != 'null' ? $rjdt : null ,
                        'ent_dt' => 'NOW()',
                        'camnt' => 0,
                        'usercode' => $ucode,
                        'crtstat' => $temp_mh,
                        'jorder' => ''
                    ];
                    $builder2 = $this->db->table("dispose");
                    $builder2->where('diary_no', $fno);
                    $str_up_disp = $builder2->update($updateData);

                    // $str_up_disp1 = "INSERT INTO dispose_delete(diary_no, `month`, dispjud, `year`, ord_dt, disp_dt, disp_type, bench, jud_id, camnt, crtstat, usercode, ent_dt, jorder, rj_dt, disp_type_all) (SELECT diary_no, `month`, dispjud, `year`, ord_dt, disp_dt, disp_type, bench,jud_id, camnt, crtstat, usercode, ent_dt, jorder, rj_dt,disp_type_all FROM dispose where diary_no='".$fno."')";
                    // mysql_query($str_up_disp1) or die(mysql_error().$str_up_disp1);
                    $builder5 = $this->db->table('dispose');
                    $builder5->select("diary_no, month, dispjud, year, ord_dt, disp_dt, disp_type, bench, jud_id, camnt, crtstat, usercode, ent_dt, jorder, rj_dt, disp_type_all,(select 0 as dispose_updated_by)");
                    $builder5->where('diary_no', $fno);
                    $rlts = $builder5->get()->getResultArray();
                    if (!empty($rlts)) {
                        // echo "<pre>"; print_r($rlts); die;
                        $str_up_disp1 = $this->db->table('dispose_delete')->insertBatch($rlts);
                    }

                    
                    // $str_ia_d = "UPDATE docdetails SET iastat='D', lst_mdf=NOW(),dispose_date='$dt',last_modified_by=$ucode WHERE diary_no='".$fno."' AND iastat='P' AND doccode=8 AND display='Y'";
                    // mysql_query($str_ia_d) or die(mysql_error().$str_ia_d);
                    $updateData1 = [
                       'lst_mdf' => 'NOW()',
                       'iastat' => 'D',
                       'last_modified_by' => $ucode,
                       'dispose_date' => $dt
                   ];
                   $builder4 = $this->db->table("docdetails");
                   $builder4->where('diary_no', $fno);
                   $builder4->where('iastat', 'P');
                   $builder4->where('doccode', '8');
                   $builder4->where('display', 'Y');
                   $str_ia_d = $builder4->update($updateData1);

                }else{
                    // $str_up_disp = "INSERT INTO dispose(diary_no, month,year,dispjud,ord_dt,disp_dt,disp_type,bench,jud_id,ent_dt,camnt,usercode,crtstat,jorder,rj_dt,disp_type_all) VALUES('".$fno."',".$dmonth.",".$dyear.",".$j1.",'".$dt."','".$hdt."',".$disp_code.",'".$bench."','".$jcodes."',NOW(),0,".$ucode.",'".$temp_mh."','','".$rjdt."','".$disp_code_all."')";
                    // mysql_query($str_up_disp) or die(mysql_error().$str_up_disp);
                    // error_reporting(0);

                    $insertData = [
                        'diary_no' => $fno,
                        'month' => $dmonth,
                        'year' => $dyear,
                        'dispjud' => $j1,
                        'ord_dt' => $dt,
                        'disp_dt' => $hdt,
                        'disp_type' => $disp_code,
                        'bench' => $bench,
                        'jud_id' => $jcodes,
                        'ent_dt' => 'NOW()',
                        'camnt' => 0,
                        'usercode' => $ucode,
                        'crtstat' => $temp_mh,
                        'jorder' => '',
                        'rj_dt' => $rjdt != 'null' ? $rjdt : null ,
                        'disp_type_all' => $disp_code_all
                    ];
                    $builder8 = $this->db->table("dispose");
                    $builder8->insert($insertData);
                 
                    // $str_ia_d = "UPDATE docdetails SET iastat='D', lst_mdf=NOW(),dispose_date='$dt',last_modified_by=$ucode WHERE diary_no='".$fno."' AND iastat='P' AND doccode=8 AND display='Y'";
                    // mysql_query($str_ia_d) or die(mysql_error().$str_ia_d);
                    $updateData1 = [
                        'lst_mdf' => 'NOW()',
                        'iastat' => 'D',
                        'last_modified_by' => $ucode,
                        'dispose_date' => $dt
                    ];
                    $builder4 = $this->db->table("docdetails");
                    $builder4->where('diary_no', $fno);
                    $builder4->where('iastat', 'P');
                    $builder4->where('doccode', '8');
                    $builder4->where('display', 'Y');
                    $str_ia_d = $builder4->update($updateData1);
                }
            }
            //rgo_default table update
            // $rgo="Update rgo_default set remove_def='Y' WHERE fil_no2=".$fno;
            // mysql_query($rgo) or die(mysql_error().$rgo);
            $builder9 = $this->db->table('rgo_default');
            $builder9->set('remove_def', 'Y');
            $builder9->where('fil_no2', $fno);
            $builder9->update();
            //rgo_default table update End
        }

        
    }

    
    

}  