<?php
namespace App\Models\Filing;

use CodeIgniter\Model;

class IADocumentModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->db = db_connect();
    }


    public function get_hcinfo_m_e_new($diary_no){

        $dataArr['dno'] = $diary_no;       
        $hdfil = $dataArr['dno'];

        $dataRet = []; 

        $builder = $this->db->table("public.main a");
        $builder->select("a.pet_name,a.res_name,a.pet_adv_id,a.res_adv_id,a.c_status,a.claim_amt,a.dacode,section_name,a.fil_no,a.fil_no_fh,a.fil_dt,a.fil_dt_fh, a.active_reg_year,a.reg_year_fh,a.reg_year_mh,a.active_casetype_id,a.casetype_id,a.ref_agency_state_id, a.diary_no_rec_date");
        $builder->join('master.users u', 'a.dacode=u.usercode', 'LEFT');
        $builder->join('public.main_a ma', 'ma.dacode=u.usercode', 'LEFT');
        $builder->join('master.usersection us', 'u.section=us.id', 'LEFT');
        $builder->where('a.diary_no', $dataArr['dno']);
        $query = $builder->get();
        $rw = $query->getResultArray();


        // $sr=0; $pet=''; $res='';
        if(!empty($rw)){
            $rw = $rw[0];
            if($rw['c_status']=='D'){
                $status='Case has been disposed'; 
            }
            if($rw['c_status']=='P'){
                $status='Case is pending'; 						
            }
           
            $dataRet['status']= $status;
            if($rw['fil_dt']=='0000-00-00 00:00:00' || $rw['fil_dt'] == ''){
                $dataRet['Reg_Date'] = "Not Registered";
            }else{
                $dataRet['Reg_Date'] = date('d-m-Y h:i:s A',strtotime($rw['fil_dt']));
            }


            if($rw['section_name']!=""){
                $dataRet['section_name'] = $rw['section_name'];
            }else{
                // echo "<pre>"; print_r($rw); die;
                if($rw['active_reg_year']!=0){
                    $ten_reg_yr = $rw['active_reg_year'];
                }else if($rw['reg_year_fh']!=0){
                    $ten_reg_yr = $rw['reg_year_fh'];
                }else if($rw['reg_year_mh']!=0){
                    $ten_reg_yr = $rw['reg_year_mh'];
                }else{
                    $ten_reg_yr = date('Y',strtotime($rw['diary_no_rec_date']));
                }

                if($rw['active_casetype_id']!=0){
                    $casetype_displ = $rw['active_casetype_id'];
                }else if($rw['casetype_id']!=0){
                    $casetype_displ = $rw['casetype_id'];
                }
                
                $section_ten_q="select tentative_section($dataArr[dno])";
                $query2 = $this->db->query($section_ten_q);
                $section_ten_rs = $query2->getResultArray();
                if(count($section_ten_rs)>0){
                    $section_ten_row = $section_ten_rs[0]['tentative_section'];
                    $dataRet['section_name'] = $section_ten_row.'[Tentative]';
                }else{
                    $diff_da_sec_name = array(39,9,10,19,20,25,26);
                    if(in_array($casetype_displ, $diff_da_sec_name)){
                      

                        $builder1 = $this->db->table("public.lowerct");
                        $builder1->select("ct_code,l_state,lct_casetype,lct_caseno,lct_caseyear");
                        $builder1->where('diary_no', $dataArr['dno']);
                        $builder1->where('lw_display', 'Y');
                        $query1 = $builder1->get();
                        $lower_case_temp = $query1->getResultArray();

                        if(count($lower_case_temp)>0){
                            $lower_case_temp_row = $lower_case_temp[0];
                            $builder2 = $this->db->table("public.main_casetype_history a");
                            $builder2->select("a.diary_no, new_registration_number, split_part(split_part(new_registration_number, '-', 2),'-',-1) AS start_range, split_part(new_registration_number, '-', -1) AS end_range, dacode, name, section_name, casetype_id, active_casetype_id, diary_no_rec_date, reg_year_mh, reg_year_fh, active_reg_year, ref_agency_state_id");
                            $builder2->join('public.main b', 'a.diary_no = b.diary_no', 'LEFT');
                            $builder2->join('master.users c', 'b.dacode = c.usercode', 'LEFT');
                            $builder2->join('master.usersection us', 'c.section = us.id', 'LEFT');
                            $builder2->where('ref_new_case_type_id', $lower_case_temp_row['lct_casetype']);
                            $builder2->where('new_registration_year', $lower_case_temp_row['lct_caseyear']);
                            $builder2->where('is_deleted', 'f');
                            $builder2->where("'" . str_pad($lower_case_temp_row['lct_caseno'], 6, 0, STR_PAD_LEFT) . "' BETWEEN split_part(split_part(new_registration_number, '-', 2), '-', -1) AND split_part(new_registration_number, '-', -1)");
                            $query2 = $builder2->get();
                            $for_da_temp_row = $query2->getResultArray();

                            if(!empty($for_da_temp_row)){
                                $for_da_temp_row = $for_da_temp_row[0];
                                if($for_da_temp_row['section_name'] != NULL || $for_da_temp_row['section_name'] != ''){
                                    $dataRet['section_name'] = $for_da_temp_row["section_name"].'[Tentative]';
                                }else{
                                    if($for_da_temp_row['active_reg_year']!=0)
                                        $ten_reg_yr = $for_da_temp_row['active_reg_year'];
                                    else if($for_da_temp_row['reg_year_fh']!=0)
                                        $ten_reg_yr = $for_da_temp_row['reg_year_fh'];
                                    else if($for_da_temp_row['reg_year_mh']!=0)
                                        $ten_reg_yr = $for_da_temp_row['reg_year_mh'];
                                    else
                                        $ten_reg_yr = date('Y',strtotime($for_da_temp_row['diary_no_rec_date']));
    
                                    if($for_da_temp_row['active_casetype_id']!=0)
                                        $casetype_displ = $for_da_temp_row['active_casetype_id'];
                                    else if($for_da_temp_row['casetype_id']!=0)
                                        $casetype_displ = $for_da_temp_row['casetype_id'];
    
                                    
                                    $section_ten_q="select tentative_section($dataArr[dno])";
                                    $section_ten_rs = $this->db->query($section_ten_q);
                                    $section_ten_rs = $for_da_temp->getResultArray();
                                    if(count($section_ten_rs)>0){
                                        $section_ten_row = $section_ten_rs[0];
                                        $dataRet['section_name'] = $section_ten_row[0].'[Tentative]';
                                    }
    
    
                                }
                            }                            
                        }
                    }
                }
            }

            $builder8 = $this->db->table("public.loose_block");
            $builder8->select("reason_blk");
            $builder8->where('diary_no', $dataArr['dno']);
            $builder8->where('display', 'Y');
            $query2 = $builder8->get();
            $chk_block = $query2->getResultArray();
            if(count($chk_block)>0){
                $row_chk_block = $chk_block[0]['reason_blk'];
                $dataRet['chckBlockMsg'] = "THIS CASE IS BLOCKED TO RECEIVE ANY DOCS DUE TO THE REASON = ".$row_chk_block;
            }
            if($rw['c_status']=='D'){
                $dataRet['c_status_D'] = "IA and letter cannot be inserted as Case has been disposed";
            }

            $dataRet['c_status'] = $rw['c_status'];

            
            if($rw['c_status']=='D'){
                // $sql_d = "select * from master.docmaster where doccode1=0 and display='Y' and doccode in(15,22,26,119) order by doccode";
                $builder3 = $this->db->table("master.docmaster");
                $builder3->select("*");
                $builder3->where('doccode1', 0);
                $builder3->where('display', 'Y');
                $builder3->where('doccode', ['15', '22', '26', '119']);
                $builder3->orderBy('doccode');
                $query3 = $builder3->get();
                $rs_d = $query3->getResultArray();
                $dataRet['docOptions'] = $rs_d;
            }
            else {
                // $sql_d = "select * from master.docmaster where doccode1=0 and display='Y' order by doccode";
                $builder4 = $this->db->table("master.docmaster");
                $builder4->select("*");
                $builder4->where('doccode1', 0);
                $builder4->where('display', 'Y');
                $builder4->orderBy('doccode');
                $query4 = $builder4->get();
                $rs_d = $query4->getResultArray();
                $dataRet['docOptions'] = $rs_d;
            }

        }else{

            $builder = $this->db->table("public.main_a a");
            $builder->select("a.pet_name,a.res_name,a.pet_adv_id,a.res_adv_id,a.c_status,a.claim_amt,a.dacode,section_name,a.fil_no,a.fil_no_fh,a.fil_dt,a.fil_dt_fh, a.active_reg_year,a.reg_year_fh,a.reg_year_mh,a.active_casetype_id,a.casetype_id,a.ref_agency_state_id, a.diary_no_rec_date");
            $builder->join('master.users u', 'a.dacode=u.usercode', 'LEFT');
            $builder->join('master.usersection us', 'u.section=us.id', 'LEFT');
            $builder->where('a.diary_no', $dataArr['dno']);
            $query = $builder->get();
            $rw = $query->getResultArray();

            if(!empty($rw)){
                $rw = $rw[0];
                if($rw['c_status']=='D'){
                    $status='Case has been disposed';
                }
                if($rw['c_status']=='P'){
                    $status='Case is pending';
                }

                $dataRet['status']= $status;
                if($rw['fil_dt']=='0000-00-00 00:00:00' || $rw['fil_dt'] == ''){
                    $dataRet['Reg_Date'] = "Not Registered";
                }else{
                    $dataRet['Reg_Date'] = date('d-m-Y h:i:s A',strtotime($rw['fil_dt']));
                }


                if($rw['section_name']!=""){
                    $dataRet['section_name'] = $rw['section_name'];
                }else{
                    // echo "<pre>"; print_r($rw); die;
                    if($rw['active_reg_year']!=0){
                        $ten_reg_yr = $rw['active_reg_year'];
                    }else if($rw['reg_year_fh']!=0){
                        $ten_reg_yr = $rw['reg_year_fh'];
                    }else if($rw['reg_year_mh']!=0){
                        $ten_reg_yr = $rw['reg_year_mh'];
                    }else{
                        $ten_reg_yr = date('Y',strtotime($rw['diary_no_rec_date']));
                    }

                    if($rw['active_casetype_id']!=0){
                        $casetype_displ = $rw['active_casetype_id'];
                    }else if($rw['casetype_id']!=0){
                        $casetype_displ = $rw['casetype_id'];
                    }

                    $section_ten_q="select tentative_section($dataArr[dno])";
                    $query2 = $this->db->query($section_ten_q);
                    $section_ten_rs = $query2->getResultArray();
                    if(count($section_ten_rs)>0){
                        $section_ten_row = $section_ten_rs[0]['tentative_section'];
                        // echo "<pre>"; print_r($section_ten_row); die;
                        $dataRet['section_name'] = $section_ten_row.'[Tentative]';
                    }else{
                        $diff_da_sec_name = array(39,9,10,19,20,25,26);
                        if(in_array($casetype_displ, $diff_da_sec_name)){

                            $builder1 = $this->db->table("public.lowerct");
                            $builder1->select("ct_code,l_state,lct_casetype,lct_caseno,lct_caseyear");
                            $builder1->where('diary_no', $dataArr['dno']);
                            $builder1->where('lw_display', 'Y');
                            $query1 = $builder1->get();
                            $lower_case_temp = $query1->getResultArray();

                            if(count($lower_case_temp)>0){
                                $lower_case_temp_row = $lower_case_temp[0];

                                $builder2 = $this->db->table("public.main_casetype_history a");
                                $builder2->select("a.diary_no, new_registration_number, split_part(split_part(new_registration_number, '-', 2),'-',-1) AS start_range, split_part(new_registration_number, '-', -1) AS end_range, dacode, name, section_name, casetype_id, active_casetype_id, diary_no_rec_date, reg_year_mh, reg_year_fh, active_reg_year, ref_agency_state_id");
                                $builder2->join('public.main b', 'a.diary_no = b.diary_no', 'LEFT');
                                $builder2->join('master.users c', 'b.dacode = c.usercode', 'LEFT');
                                $builder2->join('master.usersection us', 'c.section = us.id', 'LEFT');
                                $builder2->where('ref_new_case_type_id', $lower_case_temp_row['lct_casetype']);
                                $builder2->where('new_registration_year', $lower_case_temp_row['lct_caseyear']);
                                $builder2->where('is_deleted', 'f');
                                $builder2->where("'" . str_pad($lower_case_temp_row['lct_caseno'], 6, 0, STR_PAD_LEFT) . "' BETWEEN split_part(split_part(new_registration_number, '-', 2), '-', -1) AND split_part(new_registration_number, '-', -1)");
                                $query2 = $builder2->get();
                                $for_da_temp_row = $query2->getResultArray();

                                if(!empty($for_da_temp_row)){
                                    $for_da_temp_row = $for_da_temp_row[0];
                                    if($for_da_temp_row['section_name'] != NULL || $for_da_temp_row['section_name'] != ''){
                                        $dataRet['section_name'] = $for_da_temp_row["section_name"].'[Tentative]';
                                    }else{
                                        if($for_da_temp_row['active_reg_year']!=0)
                                            $ten_reg_yr = $for_da_temp_row['active_reg_year'];
                                        else if($for_da_temp_row['reg_year_fh']!=0)
                                            $ten_reg_yr = $for_da_temp_row['reg_year_fh'];
                                        else if($for_da_temp_row['reg_year_mh']!=0)
                                            $ten_reg_yr = $for_da_temp_row['reg_year_mh'];
                                        else
                                            $ten_reg_yr = date('Y',strtotime($for_da_temp_row['diary_no_rec_date']));

                                        if($for_da_temp_row['active_casetype_id']!=0)
                                            $casetype_displ = $for_da_temp_row['active_casetype_id'];
                                        else if($for_da_temp_row['casetype_id']!=0)
                                            $casetype_displ = $for_da_temp_row['casetype_id'];


                                        $section_ten_q="select tentative_section($dataArr[dno])";
                                        $section_ten_rs = $this->db->query($section_ten_q);
                                        $section_ten_rs = $for_da_temp->getResultArray();
                                        if(count($section_ten_rs)>0){
                                            $section_ten_row = $section_ten_rs[0];
                                            $dataRet['section_name'] = $section_ten_row[0].'[Tentative]';
                                        }


                                    }
                                }
                            }
                        }
                    }
                }


                $builder8 = $this->db->table("public.loose_block");
                $builder8->select("reason_blk");
                $builder8->where('diary_no', $dataArr['dno']);
                $builder8->where('display', 'Y');
                $query2 = $builder8->get();
                $chk_block = $query2->getResultArray();
                if(count($chk_block)>0){
                    $row_chk_block = $chk_block[0]['reason_blk'];
                    $dataRet['chckBlockMsg'] = "THIS CASE IS BLOCKED TO RECEIVE ANY DOCS DUE TO THE REASON = ".$row_chk_block;
                }
                if($rw['c_status']=='D'){
                    $dataRet['c_status_D'] = "IA and letter cannot be inserted as Case has been disposed";
                }

                $dataRet['c_status'] = $rw['c_status'];


                if($rw['c_status']=='D'){
                    // $sql_d = "select * from master.docmaster where doccode1=0 and display='Y' and doccode in(15,22,26,119) order by doccode";
                    $builder3 = $this->db->table("master.docmaster");
                    $builder3->select("*");
                    $builder3->where('doccode1', 0);
                    $builder3->where('display', 'Y');
                    $builder3->whereIn('doccode', ['15', '22', '26', '119']);
                    $builder3->orderBy('doccode');
                    $query3 = $builder3->get();
                    $rs_d = $query3->getResultArray();
                    $dataRet['docOptions'] = $rs_d;
                }
                else {
                    // $sql_d = "select * from master.docmaster where doccode1=0 and display='Y' order by doccode";
                    $builder4 = $this->db->table("master.docmaster");
                    $builder4->select("*");
                    $builder4->where('doccode1', 0);
                    $builder4->where('display', 'Y');
                    $builder4->orderBy('doccode');
                    $query4 = $builder4->get();
                    $rs_d = $query4->getResultArray();
                    $dataRet['docOptions'] = $rs_d;
                }

            }

        }
        $builder5 = $this->db->table("public.heardt");
        $builder5->select('*');
        $builder5->where('diary_no', $dataArr['dno']);
        $builder5->where('clno <>', 0);
        $builder5->where('brd_slno <>', 0);
        $builder5->where('judges <>', '');
        $query5 = $builder5->get();
        $rs1= $query5->getNumRows();
        $builder6 = $this->db->table("public.heardt");
        $builder6->select('*');
        $builder6->where('diary_no', $dataArr['dno']);
        $builder6->where('clno <>', 0);
        $builder6->where('brd_slno <>', 0);
        $builder6->where('judges <>', '');
        $query6 = $builder6->get();
        $rs2= $query6->getNumRows();
        $builder7 = $this->db->table("public.drop_note");
        $builder7->select('*');
        $builder7->where('diary_no', $dataArr['dno']);
        $query7 = $builder7->get();
        $rs4 = $query7->getNumRows();


        $total_no_of_listing= (($rs1+$rs2))-($rs4);
        if(($total_no_of_listing) < 0){    
            $total_no_of_listing=0;
        }
        $todays_date=date('Y-m-d');
        $day_of_date = date('N',strtotime($todays_date));
        switch ($day_of_date){
            case 1:
                $start_date = $todays_date;
                $end_date = date('Y-m-d',strtotime($todays_date.'+4 day'));
                break;
            case 2:
                $start_date = date('Y-m-d',strtotime($todays_date.'-1 day'));
                $end_date = date('Y-m-d',strtotime($todays_date.'+3 day'));
                break;
            case 3:
                $start_date = date('Y-m-d',strtotime($todays_date.'-2 day'));
                $end_date = date('Y-m-d',strtotime($todays_date.'+2 day'));
                break;
            case 4:
                $start_date = date('Y-m-d',strtotime($todays_date.'-3 day'));
                $end_date = date('Y-m-d',strtotime($todays_date.'+1 day'));
                break;
            case 5:
                $start_date = date('Y-m-d',strtotime($todays_date.'-4 day'));
                $end_date = $todays_date;
                break;
            case 6:
                $start_date = date('Y-m-d',strtotime($todays_date.'+2 day'));
                $end_date = date('Y-m-d',strtotime($todays_date.'+6 day'));
                break;
            case 7:
                $start_date = date('Y-m-d',strtotime($todays_date.'+1 day'));
                $end_date = date('Y-m-d',strtotime($todays_date.'+5 day'));
                break;
        }


        $dataRet['total_no_of_listing'] = $total_no_of_listing;
        $builder8 = $this->db->table("public.case_remarks_multiple");
        $builder8->select('cl_date');
        $builder8->where('diary_no', $dataArr['dno']);
        $builder8->where('r_head', '7');
        $query8 = $builder8->get();
        $cav = $query8->getResultArray();
        if(count($cav)>0){
            $dataRet['judg_rev_date'] = date('d-m-Y',strtotime($cav[0]['cl_date']));

        $builder78 = $this->db->table("public.main");
        $builder78->select('fil_no');
        $builder78->where('diary_no', $dataArr['dno']);
        $query78 = $builder78->get(1);
        $fil_no_check = $query78->getResultArray();
        if(!empty($fil_no_check)){
            $fil_no_Arr = $fil_no_check[0]['fil_no'];
            if($fil_no_Arr !=''){
                $builder9 = $this->db->table("main a");
                $builder9->select('fil_no, fil_dt, fil_no_fh, fil_dt_fh, short_description, CASE WHEN reg_year_mh = 0 THEN EXTRACT(YEAR FROM a.fil_dt) ELSE reg_year_mh END AS m_year, CASE WHEN reg_year_fh = 0 THEN EXTRACT(YEAR FROM a.fil_dt_fh) ELSE reg_year_fh END AS f_year');
                $builder9->join('master.casetype b', 'CAST(SUBSTRING(fil_no, 1, 2) AS INTEGER) = casecode', 'LEFT');
                $builder9->where('diary_no', $dataArr['dno']);
                $query9 = $builder9->get();
                $casetype = $query9->getResultArray();
        
                if(!empty($casetype)){
                    $casetype = $casetype[0];
                    if($casetype['fil_no'] !='' || $casetype['fil_no'] !=NULL){
                        $dataRet['caseType1'] = '[M]'.$casetype['short_description'].SUBSTR($casetype['fil_no'],3).'/'.$casetype['m_year'];
                    }
            
                    if($casetype['fil_no_fh'] !='' || $casetype['fil_no_fh'] !=NULL){
                        $fil_No = $casetype['fil_no_fh']; 
                        $builder10 = $this->db->table("master.casetype");
                        $builder10->select('short_description');
                        $builder10->where('casecode', substr($fil_No,0,2));
                        $query10 = $builder10->get();
                        $r_case = $query10->getResultArray();
                        if(!empty($r_case)){
                            $r_case = $r_case[0];
                            $dataRet['caseType2'] = ',[R]'.$r_case['short_description'].SUBSTR($casetype['fil_no_fh'],3).'/'.$casetype['f_year'];
                        }
                    }
                }
            }
        }
        $builder11 = $this->db->table("public.mul_category a");
        $builder11->select('category_sc_old,sub_name1');
        $builder11->join('master.submaster b', 'submaster_id=b.id', 'LEFT');
        $builder11->where('diary_no', $dataArr['dno']);
        $query11 = $builder11->get();
        $category = $query11->getResultArray();

        $cate_for_doc = '';
        if(!empty($category)){
            foreach ($category as $row_cate) {
                $cate_for_doc .= $row_cate['category_sc_old'].',';
            }
        }
        $dataRet['cate_for_doc'] = rtrim($cate_for_doc,',');
        $builder12 = $this->db->table("public.heardt");
        $builder12->select('next_dt,board_type,clno,brd_slno,roster_id');
        $builder12->where('diary_no', $dataArr['dno']);
        $query12 = $builder12->get();
        $listing = $query12->getResultArray();
        if(count($listing)>0){
            $listing = $listing[0];
            if($listing['next_dt'] >= date('Y-m-d') && $listing['clno'] >0 && $listing['roster_id'] >0){
                $dataRet['listing'] = date('d-m-Y',strtotime($listing['next_dt'])).$listing['board_type'];
            }
        }
        $builder13 = $this->db->table("public.main a");
        $builder13->select('agency_state');
        $builder13->join('master.ref_agency_state b', 'ref_agency_state_id=b.cmis_state_id');
        $builder13->where('diary_no', $dataArr['dno']);
        $query13 = $builder13->get();
        $lower_high = $query13->getResultArray();
        if(count($lower_high)>0){
            $dataRet['lower_high'] = $lower_high[0];
        }
        $builder14 = $this->db->table("public.indexing");
        $builder14->select("file_id");
        $builder14->where('diary_no',$dataArr['dno']);
        $builder14->where('file_id is NOT NULL', NULL, FALSE);
        $builder14->where('display','Y');
        $query14 = $builder14->get();
        $scan = $query14->getResultArray(); 
        if(count($scan)>0){
            $dataRet['scan'] = "(SCANNED)";
        }
        $builder15 = $this->db->table("public.heardt");
        $builder15->select('stagename');
        $builder15->join('master.subheading', 'heardt.subhead = subheading.stagecode');
        $builder15->whereIn('stagecode', function ($builder16) use ($dataArr) {
                $builder16->select('subhead');
                $builder16->from('public.heardt');
                $builder16->where('diary_no', $dataArr['dno']);
                $builder16->orderBy('ent_dt', 'desc');
                $builder16->limit(1);
        });
        $builder15->where('diary_no', $dataArr['dno']);
        $query15 = $builder15->get();
        $rws = $query15->getResultArray();
        if(count($rws)==0){
            $dataRet['subhead'] ='FRESH MATTER';
        }else{
            $rws = $rws[0];
            $dataRet['subhead'] = $rws['stagename'];
        }
        $builder17 = $this->db->table("public.party");
        $builder17->select('pet_res, sr_no, sr_no_show, ind_dep, partyname, pflag');
        $builder17->where('diary_no', $dataArr['dno']);
        $builder17->where('pflag !=', 'T');
        $builder17->where('pet_res !=', '');
        $builder17->orderBy('pet_res, sr_no');
        $builder17->orderBy("(string_to_array(sr_no_show || '.0.0', '.', '3')::text[])");
        $rs_l = $builder17->get();
        $rws_l = $rs_l->getResultArray();
        $dataRet['tablePetRes'] = $rws_l;
        $builder18 = $this->db->table("public.advocate a");
        $builder18->select('pet_res, name adv, adv_type,aor_code');
        $builder18->join('master.bar b', 'advocate_id=bar_id', 'LEFT');
        $builder18->where('diary_no', $dataArr['dno']);
        $builder18->where('a.display', 'Y');
        $builder18->orderBy('pet_res, a.ent_dt');
        $builder18->orderBy('adv_type', 'DESC');
        $query18 = $builder18->get();
        $rws_a = $query18->getResultArray();
        $dataRet['tablePetResAdvocates'] = $rws_a;
        
        return $dataRet;
        

    }
}

    public function get_aor_name(){


        $builder2 = $this->db->table("master.bar");
        $builder2->select("aor_code,name");
        $builder2->where('if_sen', 'N');
        $builder2->where('isdead','N');
        $query1 = $builder2->get();
        $result = $query1->getResultArray();

        return $result;
    }

    public function get_adv_name($term){
        $builder = $this->db->table("master.bar");
        $builder->select("name");
        $builder->where('aor_code',$term);
        $builder->where('isdead','N');
        $query = $builder->get();
        $result = $query->getResultArray();
        return $result;
    }

    public function get_party_name($dataset){
        $fil = explode('~', $dataset['fil']);
        $dno=$fil[0];
        $dyr=$fil[1];
        $q = strtolower($dataset["term"]);
        
        $builder = $this->db->table("public.party");
        $builder->select("sr_no, partyname");
        $builder->where('diary_no',$dno);
        $builder->where('pflag', 'P');
        $builder->where('pet_res', $dataset['type']);
        $builder->like('partyname', $q);
        $query1 = $builder->get();
        $result = $query1->getResultArray();

        $json=array();
        foreach ($result as $row) {
            $json[]=array('value'=>$row['partyname'],'label'=>$row['partyname']);
        }
        return json_encode($json);

    }

    public function getDoc_type1($diary_no){
        
        $mnat2=0;
        $builder = $this->db->table("public.main");
        $builder->select("case_grp");
        $builder->where('diary_no',$diary_no);
        $query = $builder->get();
        $rsctp1 = $query->getResultArray();
        if(count($rsctp1)>0){
            $rowctp1 = $rsctp1[0];
            if($rowctp1['case_grp'] == "C")
                $mnat2=1;
            if($rowctp1['case_grp'] == "R")
                $mnat2=2;
        }

        $builder3 = $this->db->table("master.docmaster");
        $builder3->select("doccode, doccode1, docdesc");
        $builder3->where('doccode', '8');
        $builder3->whereNotIn('doccode1', [0, 19]);  
        $builder3->where("(doctype = '$mnat2' OR doctype = '0')");
        $builder3->where('display', 'Y');
        $builder3->orderBy('docdesc');
        $query3 = $builder3->get();
        $rs1 = $query3->getResultArray();
        
        $json=array();
        foreach ($rs1 as $row) {
            $json[]=array('value'=>$row['doccode1'],'label'=>$row['docdesc']);
        }
        echo json_encode($json);


    }

    public function getInfoForLd($diary_no){

        $builder = $this->db->table("public.docdetails a");
        $builder->select("docd_id,a.diary_no,kntgrp, a.doccode,a.doccode1,docnum,docyear,filedby,a.ent_dt,other1,a.remark,party,no_of_copy,advocate_id,docdesc,c.name advname,u.name entryuser,forresp,a.docfee,feemode, a.is_efiled");
        $builder->join('master.docmaster b', 'a.doccode=b.doccode AND a.doccode1=b.doccode1', 'LEFT');
        $builder->join('master.bar c', 'advocate_id=bar_id', 'LEFT');
        $builder->join('master.users u', 'a.usercode=u.usercode', 'LEFT');
        $builder->where('diary_no', $diary_no);
        $builder->where('a.display', 'Y');
        $builder->where('b.display', 'Y');
        $builder->where('iastat', 'P');
        $builder->orderBy('ent_dt', 'DESC');
        $query = $builder->get();
        $rs1 = $query->getResultArray();

        $dataArr = [];

        foreach ($rs1 as $key => $row) {
            $from='';
            $undertxt = '';
            if(($row['doccode']== 1 || $row['doccode']== 12 || $row['doccode']== 13) && ($row['advocate_id'] != 0)) {
                $undertxt = 'Please remove advocate from case also';
            }
            if($row['doccode'] == 8){ 
                $builder4 = $this->db->table("public.heardt");
                $builder4->select("diary_no, next_dt, roster_id, ent_dt");
                $builder4->where('diary_no',$row['diary_no']);
                $builder4->whereIn('module_id',['14', '15']);
                $builder4->where('ent_dt',$row['ent_dt']);
                $query = $builder4->get();
                $check11 = $query->getResultArray(); 
               
                if(count($check11)>0){
                    $from='H';
                    $undertxt = 'Auto Proposed Case';
                }
                else{
                    $builder4 = $this->db->table("public.heardt");
                    $builder4->select("diary_no, next_dt, roster_id, ent_dt");
                    $builder4->where('diary_no',$row['diary_no']);
                    $builder4->whereIn('module_id',['14', '15']);
                    $builder4->where('ent_dt',$row['ent_dt']);
                    $query = $builder4->get();
                    $check22 = $query->getResultArray(); 
                   
                    if(count($check22)>0){
                        $from='L';
                        $undertxt = 'Auto Proposed Case';
                    }
                }
            }

            $dataArr[] = [
                'docd_id' => $row['docd_id'],
                'diary_no' => $row['diary_no'],
                'doccode' => $row['doccode'],
                'doccode1' => $row['doccode1'],
                'docnum' => $row['docnum'],
                'docyear' => $row['docyear'],
                'filedby' => $row['filedby'],
                'ent_dt' => $row['ent_dt'] != '' ? date("d-m-Y h:i:s A", strtotime($row['ent_dt'])) : '',
                'other1' => $row['other1'],
                'remark' => $row['remark'],
                'party' => $row['party'],
                'no_of_copy' => $row['no_of_copy'],
                'advocate_id' => $row['advocate_id'],
                'docdesc' => $row['docdesc'],
                'advname' => $row['advname'],
                'entryuser' => $row['entryuser'],
                'forresp' => $row['forresp'],
                'docfee' => $row['docfee'],
                'feemode' => $row['feemode'],
                'from' => $from,
                'undertxt' => $undertxt,
                'is_efiled' =>$row['is_efiled'],
                'docfee' =>$row['docfee'],
                'kntgrp' => $row['kntgrp']
            ];

        }

        return $dataArr;

    }

    public function getPetResList($dataset){
        $dno= $dataset['dno'];
        $builder4 = $this->db->table("public.party");
        $builder4->select("sr_no,partyname");
        $builder4->where('diary_no',$dno);
        $builder4->where('pflag','P');
        $builder4->where('pet_res',$dataset['type']);
        $query = $builder4->get();
        $result = $query->getResultArray(); 
        $json=array();
        foreach ($result as $row) {
            $json[]=array('value'=>$row['partyname'],'label'=>$row['partyname']);
        }
        return json_encode($json);
    }

    public function dispatch_ld($dn,$dc,$dc1,$dno,$dyr,$uc){
        $builder4 = $this->db->table("public.main");
        $builder4->select("dacode");
        $builder4->where('diary_no',$dn);
        $builder4->where('dacode is NOT NULL', NULL, FALSE);
        $query = $builder4->get();
        $chk_da_rs = $query->getResultArray(); 
        if(count($chk_da_rs)>0){
            $row_chk_da=$chk_da_rs[0];
            $dacode=$row_chk_da['dacode'];
            
            if($dn == ''){
                $builder5 = $this->db->table("public.ld_move");
                $builder5->select("fil_no");
                $builder5->where('doccode',$dc);
                $builder5->where('doccode1',$dc1);
                $builder5->where('docnum',$dno);
                $builder5->where('docyear',$dyr);
                $query5 = $builder5->get();
                $chk_if_move_rs = $query5->getResultArray(); 
            }else if($dc == '') {
                $builder5 = $this->db->table("public.ld_move");
                $builder5->select("fil_no");
                $builder5->where('diary_no',$dn);
                $builder5->where('doccode1',$dc1);
                $builder5->where('docnum',$dno);
                $builder5->where('docyear',$dyr);
                $query5 = $builder5->get();
                $chk_if_move_rs = $query5->getResultArray(); 
            }else if($dc1 == '') {
                $builder5 = $this->db->table("public.ld_move");
                $builder5->select("fil_no");
                $builder5->where('diary_no',$dn);
                $builder5->where('doccode',$dc);
                $builder5->where('docnum',$dno);
                $builder5->where('docyear',$dyr);
                $query5 = $builder5->get();
                $chk_if_move_rs = $query5->getResultArray(); 
            }else if($dno == '') {
                $builder5 = $this->db->table("public.ld_move");
                $builder5->select("fil_no");
                $builder5->where('diary_no',$dn);
                $builder5->where('doccode',$dc);
                $builder5->where('doccode1',$dc1);
                $builder5->where('docyear',$dyr);
                $query5 = $builder5->get();
                $chk_if_move_rs = $query5->getResultArray(); 
            }else if($dyr == '') {
                $builder5 = $this->db->table("public.ld_move");
                $builder5->select("fil_no");
                $builder5->where('diary_no',$dn);
                $builder5->where('doccode',$dc);
                $builder5->where('doccode1',$dc1);
                $builder5->where('docnum',$dno);
                $query5 = $builder5->get();
                $chk_if_move_rs = $query5->getResultArray(); 
            }else{
                $builder5 = $this->db->table("public.ld_move");
                $builder5->select("fil_no");
                $builder5->where('diary_no',$dn);
                $builder5->where('doccode',$dc);
                $builder5->where('doccode1',$dc1);
                $builder5->where('docnum',$dno);
                $builder5->where('docyear',$dyr);
                $query5 = $builder5->get();
                $chk_if_move_rs = $query5->getResultArray();
            }
            
            if(count($chk_if_move_rs) == 0){
              
                $insert_data = [
                    'diary_no' => (int)$dn,
                    'fil_no' => '', 
                    'remarks' => '', 
                    'doccode' => (int)$dc, 
                    'doccode1' => (int)$dc1,
                    'docnum' => (int)$dno,
                    'docyear' => (int)$dyr,
                    'disp_by' => (int)$uc,
                    'disp_to' => (int)$dacode,
                    'disp_dt' => date('Y-m-d H:i:s'),
                    'rece_by' => 0,
                    'rece_dt' => date('Y-m-d H:i:s'), 
                    'other' => ''
                ];
             
                $builder54 = $this->db->table("public.ld_move");                 
                $insert = $builder54->insert($insert_data);

               
            }
        }
    }

    public function save_loose($dataset){

        $ucode = $_SESSION['login']['usercode'];
        $doccode=$dataset['doccode'];
        $doccode1=$dataset['doccode1'];
        $docfee=$dataset['docfee'];
        $other1=trim(strtoupper(addslashes($dataset['other1'])));
        $remark=trim(strtoupper(addslashes($dataset['remark'])));
        $filedby=$dataset['filedby'];
        $fee1=$dataset['fee1'];
        $fee2=$dataset['fee2'];
        $feemode=$dataset['feemode'];
        $forresp=$dataset['forresp'];
        $efil=0;
        $efil_no=0;
        $efil_yr='';
        if($dataset['if_efil']==0 || $dataset['if_efil']=='')
            $efil='';
        else {
            $efil='Y';
        }
        $builder4 = $this->db->table("master.bar");
        $builder4->select("bar_id");
        $builder4->where('aor_code',$dataset['aorcode']);
        $query = $builder4->get();
        $advid = $query->getResultArray(); 
        $advid = $advid[0];

        $curyr=date('Y');
        $builder5 = $this->db->table("master.dockount");
        $builder5->select("max(knt) max");
        $builder5->where('year',$curyr);
        $query5 = $builder5->get();
        $mm = $query5->getResultArray(); 
        $mm = $mm[0];
        if($mm['max'] == NULL){
            $insert_data = [
                'year' => $curyr,
                'knt' => 0
            ];
            $builder5 = $this->db->table("master.dockount");
            $builder5->insert($insert_data);
            $m_docno=1;
        }
        else{
            $m_docno=$mm['max']+1;
        }

        if($doccode==8 && $doccode1==0){
            echo json_encode(["message"=>"ERROR, IA DESCRIPTION IS NOT SELECTED"]);
            exit();
        }

        $builder2 = $this->db->table("master.dockount");
        $builder2->set('knt', $m_docno );
        $builder2->where('year',$curyr);
        $builder2->update(); 
        $builder5 = $this->db->table("public.docdetails");
        $builder5->select("docd_id");
        $builder5->where('docnum',$m_docno);
        $builder5->where('docyear',$curyr);
        $builder5->where('display','Y');
        $query5 = $builder5->get();
        $check_for_double = $query5->getResultArray(); 
        if(count($check_for_double)>0){
            echo json_encode(["message"=>"DOCUMENT NO. CAN NOT BE DOUBLE, PLEASE TRY AGAIN"]);
            exit();
        }

        if($doccode==7) {
            $docfee=$fee1+$fee2;
          $data = [
                'diary_no' => $dataset['hdfno'],
                'doccode' => $doccode,
                'doccode1' => $doccode1,
                'docnum' => $m_docno,
                'docyear' => $curyr,
                'filedby' => $filedby,
                'docfee' => $docfee,
                'forresp' => $forresp,
                'feemode' => $feemode,
                'fee1' => $fee1,
                'fee2' => $fee2,
                'usercode' => $ucode,
                'ent_dt' => 'NOW()', 
                'advocate_id' => $dataset['aorcode'],
                'remark' => $remark,
                'no_of_copy' => $dataset['copy'],
                'is_efiled' => $efil,
            ];
            $sqlad= $this->db->table('docdetails')->insert($data);
        }else{
             $data = [
                'diary_no' => (int)$dataset['hdfno'],
                'doccode' => (int)$doccode,
                'doccode1' => (int)$doccode1,
                'docnum' => (int)$m_docno,
                'docyear' => (int)$curyr,
                'filedby' => $filedby,
                'docfee' => (int)$docfee,
                'other1' => $other1,
                'usercode' => (int)$ucode,
                'ent_dt' => 'NOW()',  // Replace with the appropriate date format
                'party' => $dataset['party'],
                'advocate_id' => (int)$dataset['aorcode'],
                'remark' => $remark,
                'no_of_copy' => (int)$dataset['copy'],
                'is_efiled' => $efil,
            ];
            
            $sqlad= $this->db->table('public.docdetails')->insert($data);
        }

        // echo $sqlad; die;
        // $rqlad=mysql_query($sqlad) or die(__LINE__.'->'.mysql_error());
        $rqlad= $sqlad;

        $this->dispatch_ld($dataset['hdfno'],$doccode,$doccode1,$m_docno,$curyr,$ucode);
        if($rqlad) {
           
            if($dataset['pet_master']!='')
            {
                $pet_master = explode(',', $dataset['pet_master']);
                for($i=0;$i<sizeof($pet_master);$i++)
                {
                    $pet_mast = explode('~', $pet_master[$i]);
                    $data = [
                        'diary_no' => $dataset['hdfno'],
                        'docnum' => $m_docno,
                        'docyear' => $curyr,
                        'pet_res' => 'P',
                        'sr_no' => $pet_mast[0],
                        'type' => $pet_mast[1],
                        'usercode' => $ucode,
                        'ent_dt' => 'NOW()',  
                    ];                    
                    $insert_tw_pro = $this->db->table('public.tw_pro_desc')->insert($data);
                   
            }
            if($dataset['res_master']!='')
            {
                $res_master = explode(',', $dataset['res_master']);
                for($i=0;$i<sizeof($res_master);$i++)
                {
                    $res_mast = explode('~', $res_master[$i]);
                   $data = [
                        'diary_no' => (int)$dataset['hdfno'],
                        'docnum' => (int)$m_docno,
                        'docyear' => (int)$curyr,
                        'pet_res' => 'R',
                        'sr_no' => (int)$res_mast[0],
                        'type' => $res_mast[1],
                        'usercode' => (int)$ucode,
                        'ent_dt' => 'NOW()',  
                    ];
                    
                    $insert_tw_pro = $this->db->table('public.tw_pro_desc')->insert($data);
                }
            }

          
            
        }
       

        $data = [
            'remark_data' => $remark,
        ];        
        $insert_auto = $this->db->table('public.docdetails_remark')->insert($data);

        
        $data = [
            'diary_no' => (int)$dataset['hdfno'],
            'doccode' => (int)$doccode,
            'doccode1' => (int)$doccode1,
            'other' => $other1,
            'i_type' => 1,
            'entdt' => 'NOW()',  
            'ucode' => (int)$ucode,
            'src_of_ent' => 1,
            'fp' => 0,
            'tp' => 0,
            'np' => 0,
            'pdf_name' => '',
            'lowerct_id' => 0,

        ];        
        $insert_indexing = $this->db->table('public.indexing')->insert($data);


        if($insert_indexing){
            $builder6 = $this->db->table("master.docmaster");
            $builder6->select("docdesc");
            $builder6->where('doccode',$doccode);
            $builder6->where('display','Y');
            $builder6->limit('1');
            $query6 = $builder6->get();
            $docdetail = $query6->getResultArray(); 
            $docdetail = $docdetail[0]['docdesc'];

            echo json_encode(["message"=> "Document no. ".$m_docno.'/'.$curyr. " - [".$docdetail."]  has been filed in Diary no.  ".$dataset['hdfno'].' - Supreme Court of India' ]);
        }else{
            echo json_encode(["message"=>  "Error while inserting." ]);
        }


    }

    }

    public function get_case_back($fil_no,$docnum,$docyear){
        
        $builder4 = $this->db->table("public.heardt");
        $builder4->select("diary_no, next_dt, roster_id, ent_dt");
        $builder4->where('diary_no',$fil_no);
        $builder4->whereIn('module_id', ['14','15']);
        $builder4->where('usercode','9777');
        $query = $builder4->get();
        $check = $query->getResultArray(); 
       if(count($check)>0){
           $builder6 = $this->db->table("public.last_heardt");
            $builder6->select("diary_no,conn_key,next_dt,mainhead,subhead,clno,brd_slno,roster_id,judges,coram,board_type,usercode,ent_dt,module_id,mainhead_n,subhead_n,main_supp_flag,listorder,tentative_cl_dt, listed_ia,sitting_judges,list_before_remark");
            $builder6->where('diary_no',$fil_no);
            $builder6->orderBy('ent_dt', 'DESC');
            $builder6->limit('1');
            $query = $builder6->get();
            $row = $query->getResultArray();            
            $row = $row[0];
            $builder5 = $this->db->table("public.heardt");
            $builder5->set('conn_key', $row['conn_key']);
            $builder5->set('next_dt', $row['next_dt']);
            $builder5->set('mainhead', $row['mainhead']);
            $builder5->set('subhead', $row['subhead']);
            $builder5->set('clno', $row['clno']);
            $builder5->set('brd_slno', $row['brd_slno']);
            $builder5->set('roster_id', $row['roster_id']);
            $builder5->set('judges', $row['judges']);
            $builder5->set('coram', $row['coram']);
            $builder5->set('board_type', $row['board_type']);
            $builder5->set('usercode', $row['usercode']);
            $builder5->set('ent_dt', $row['ent_dt']);
            $builder5->set('module_id', $row['module_id']);
            $builder5->set('mainhead_n', $row['mainhead_n']);
            $builder5->set('subhead_n', $row['subhead_n']);
            $builder5->set('main_supp_flag', $row['main_supp_flag']);
            $builder5->set('listorder', $row['listorder']);
            $builder5->set('tentative_cl_dt', $row['tentative_cl_dt']);
            $builder5->set('listed_ia', $row['listed_ia']);
            $builder5->set('sitting_judges', $row['sitting_judges']);
            $builder5->set('list_before_remark', $row['list_before_remark']);
            $builder5->where('diary_no',$fil_no);
            $builder5->update();          
           $builder = $this->db->table("public.brdrem");
           $builder->select("remark");
           $builder->where('diary_no',$fil_no);
           $query = $builder->get();
           $result2 = $query->getResultArray();

           if(count($result2)>0){
               $row2 = $result2[0];
               $brd_vac_parts = preg_split("/AND/i", $row2['remark']);
               $find = $docnum.'/'.$docyear;
               $tobe = $brd_vac_parts[0].'AND';
               if(strpos($tobe,$find)){
                    $brdrem = str_ireplace($tobe,"",$row2['remark']);
                    $builder3 = $this->db->table("public.brdrem");
                    $builder3->set('remark', $brdrem);
                    $builder3->where('diary_no', $fil_no);
                    $builder3->update();
               }
           }
           
           $builder3 = $this->db->table("public.last_heardt");
            $builder3->where('diary_no', $fil_no);
            $builder3->where('conn_key', $row['conn_key']);
            $builder3->where('next_dt', $row['next_dt']);
            $builder3->where('mainhead', $row['mainhead']);
            $builder3->where('subhead', $row['subhead']);
            $builder3->where('roster_id', $row['roster_id']);
            $builder3->where('judges', $row['judges']);
            $builder3->where('board_type', $row['board_type']);
            $builder3->where('clno', $row['clno']);
            $builder3->where('brd_slno', $row['brd_slno']);
            $builder3->where('usercode', $row['usercode']);
            $builder3->where('ent_dt', $row['ent_dt']);
            if($builder3->delete()){
                return $message = "***AUTO GENERATE*** IA $docnum/$docyear DELETED from Diary No. ".substr($fil_no,0,-4).'/'.substr($fil_no,-4)."; Proposal DELETED, Please take a look";
            } 
       }
       else{
           return $message = "***AUTO GENERATE*** IA $docnum/$docyear DELETED from Diary No. ".substr($fil_no,0,-4).'/'.substr($fil_no,-4)."; PLEASE DELETE PROPOSAL as System Not Found Proper Record"; 
       }
    }

    public function del_for_ld_del($dataset){

        $fullid = explode('~', $dataset['idfull']);
        $dno = $fullid[0];
        $doccode = $fullid[1];
        $doccode1 = $fullid[2];
        $docnum = $fullid[3];
        $docyear = $fullid[4];
        $advid = $fullid[5];
        $src = $fullid[6];
        $is_efiled= $fullid[7];
        $ucode = $_SESSION['login']['usercode'];

        if($dataset['type'] == 'D'){
            // $query = "SELECT diary_no,docdesc,docnum,docyear FROM docdetails d join master.docmaster m on d.doccode=m.doccode and d.doccode1=m.doccode1 WHERE diary_no='$dno' AND d.doccode=$doccode AND d.doccode1=$doccode1 AND docnum=$docnum AND docyear=$docyear AND d.display='Y' AND m.display='Y'";
            // $result = $this->db->query($query);
            $builder = $this->db->table("public.docdetails d");
            $builder->select("diary_no,docdesc,docnum,docyear");
            $builder->join('master.docmaster m', 'd.doccode=m.doccode and d.doccode1=m.doccode1');
            $builder->where('d.diary_no', $dno);
            $builder->where('d.doccode', $doccode);
            $builder->where('d.doccode1', $doccode1);
            $builder->where('d.docnum', $docnum);
            $builder->where('d.docyear', $docyear);
            $builder->where('d.display', 'Y');
            $query = $builder->get();
            $result = $query->getResultArray();

            if(count($result)>0){
                $document = $result[0];
                $builder3 = $this->db->table("public.docdetails");
                $builder3->set('display', 'N' );
                $builder3->set("remark", "CONCAT(COALESCE(remark, ''),  ' WRONGLY MADE-$ucode') ");
                $builder3->set('lst_mdf', 'NOW()' );
                $builder3->set('lst_user', $ucode );
                $builder3->where('diary_no', $dno);
                $builder3->where('doccode', $doccode);
                $builder3->where('doccode1', $doccode1);
                $builder3->where('docnum', $docnum);
                $builder3->where('docyear', $docyear);
                $builder3->where('display', 'Y');
                if($builder3->update()){
                    echo "DELETED SUCCESSFULLY";
                }

                if($doccode == 8){                 
                    $builder = $this->db->table("public.brdrem");
                    $builder->select("remark");
                    $builder->where('diary_no',$dno);
                    $query = $builder->get();
                    $result2 = $query->getResultArray();
                    if(count($result2)>0){
                        $row2 = $result2[0];

                        $search_string = 'IA No.'.$document['docnum'].'/'.$document['docyear'].'-'.$document['docdesc'];

                        if(strpos($row2['remark'],'and '.$search_string) !== false){
                            $search_string = 'and IA No.'.$document['docnum'].'/'.$document['docyear'].'-'.$document['docdesc'];
                        }
                        if(strpos($row2['remark'],$search_string.' and') !== false){
                            $search_string = 'IA No.'.$document['docnum'].'/'.$document['docyear'].'-'.$document['docdesc'].' and';
                        }
                        $replaced_string = str_ireplace($search_string,'', $row2['remark']);

                        $builder3 = $this->db->table("public.brdrem");
                        $builder3->set('remark', $replaced_string );
                        $builder3->where('diary_no', $dno);
                        $queryup = $builder3->update();

                    }

                    if($src == 'L'){
                        $message = "***AUTO GENERATE*** IA $docnum/$docyear DELETED from Diary No. ".substr($dno,0,-4).'/'.substr($dno,-4)."; Please delete proposal, as entry found in last_heardt"; 
                       
                    }
                    else if($src == 'H'){
                        $message = $this->get_case_back($dno,$docnum,$docyear);                        
                    }
                }
            }
            else{
                echo "SORRY, RECORD NOT FOUND";
            }
        }

    } 

    public function loose_up_new($dataset){

        $fullid = explode('~', $dataset['idfull']);
        // $dno = $fullid[0];
        // $doccode = $fullid[1];
        // $doccode1 = $fullid[2];
        // $docnum = $fullid[3];
        // $docyear = $fullid[4];
        // $advid = $fullid[5];
        // $is_efiled= $fullid[7];

        $dno = $fullid[0];
        $doccode = $fullid[1];
        $doccode1 = $fullid[2];
        $docnum = $fullid[3];
        $docyear = $fullid[4];
        $advid = $fullid[5];
        // $docid = $fullid[7];
        $is_efiled= $fullid[8];
        $docfee = $fullid[9];
        $docdesc = $fullid[10];
        $remark = $fullid[11];
        $no_of_copy = $fullid[12];
        $filDate = $fullid[13];
        $filuser = $fullid[14];
        $kntgrop = $fullid[15];
        $filedby = $fullid[16];

        $ucode = $_SESSION['login']['usercode'];
        $dataArr = $dataset['data'];        
        if($dataArr['fee'] == ''){
            $dataArr['fee'] = 0;
        }
        $efil=0;
        $efil_no=0;
        $efil_yr='';
        if($dataArr['if_efil']==0 || $dataArr['if_efil']==''){
            $efil='';
        }else {
            $efil='Y';
        }
        $builder = $this->db->table("public.docdetails");
        $builder->select("*");
        $builder->where('diary_no', $dno);
        $builder->where('doccode', $doccode);
        $builder->where('doccode1', $doccode1);
        $builder->where('docnum', $docnum);
        $builder->where('docyear', $docyear);
        $builder->where('display', 'Y');
        $query = $builder->get();
        $result = $query->getResultArray();
        if(count($result)>0) {
            $row=$result[0];
            $data_insert = [
                'diary_no' => (int)$row['diary_no'],
                'doccode' => (int)$row['doccode'],
                'doccode1' => (int)$row['doccode1'],
                'docnum' => (int)$row['docnum'],
                'docyear' => (int)$row['docyear'],
                'filedby' => $row['filedby'],
                'docfee' => (int)$row['docfee'],
                'other1' => $row['other1'],
                'iastat' => $row['iastat'],
                'forresp' => $row['forresp'],
                'feemode' => $row['feemode'],
                'fee1' => (int)$row['fee1'],
                'fee2' => (int)$row['fee2'],
                'usercode' => (int)$row['usercode'],
                'ent_dt' => $row['ent_dt'],
                'display' => $row['display'],
                'remark' => $row['remark'],
                'lst_mdf' => $row['lst_mdf'],
                'lst_user' => (int)$row['lst_user'],
                'j1' => (int)$row['j1'],
                'j2' => (int)$row['j2'],
                'j3' => (int)$row['j3'],
                'party' => $row['party'],
                'advocate_id' => (int)$row['advocate_id'],
                'verified' => $row['verified'] != '' ? $row['verified'] : '',
                'verified_by' => (int)$row['verified_by'],
                'verified_on' => $row['verified_on'],
                'sc_ia_sta_code' => (int)$row['sc_ia_sta_code'],
                'sc_ref_code_id' => (int)$row['sc_ref_code_id'],
                'sc_application_no' => $row['sc_application_no']!= '' ? $row['sc_application_no'] : '',
                'no_of_copy' => (int)$row['no_of_copy'],
                'sc_old_doc_code' => (int)$row['sc_old_doc_code'],
                // 'docd_id' => (int)$row['docd_id'],
                'verified_remarks' => $row['verified_remarks'] != '' ? $row['verified_remarks'] : '',
                'dispose_date' => $row['dispose_date'],
                'last_modified_by' => $row['last_modified_by'] != '' ? (int)$row['last_modified_by'] : 0,
                'disposal_remark' => $row['disposal_remark'] != '' ? $row['disposal_remark'] : '',
                'is_efiled' => $row['is_efiled'],
                'update_by' => (int)$ucode,
                'create_modify' => 'NOW()',  
                'updated_on' => 'NOW()',
                'updated_by' => (int)$ucode,
                'updated_by_ip' => ''
            ];            
            ;
            $builder54 = $this->db->table("public.docdetails_history");   
            $insert = $builder54->insert($data_insert);

          

            $builder3 = $this->db->table("public.docdetails");
            $builder3->set('doccode', $dataArr['doccode'] );
            $builder3->set('doccode1', $dataArr['doccode1']);
            $builder3->set('other1', $dataArr['other1'] );
            $builder3->set('remark', $dataArr['rem']);
            $builder3->set('advocate_id', $dataArr['aor']);
            $builder3->set('docfee', $dataArr['fee']);
            $builder3->set('no_of_copy', $dataArr['noc']);
            $builder3->set('filedby', $dataArr['aor_name']);
            $builder3->set('forresp', $dataArr['frsp']);
            $builder3->set('lst_mdf', 'NOW()');
            $builder3->set('lst_user', $ucode);
            $builder3->set('is_efiled', $efil);
            $builder3->where('diary_no', $dno);
            $builder3->where('doccode', $doccode);
            $builder3->where('doccode1',$doccode1);
            $builder3->where('docnum',$docnum);
            $builder3->where('docyear',$docyear);
            $builder3->where('display','Y');

            if($builder3->update()){
                echo "UPDATED SUCCESSFULLY";
            }

        }
        else{
            echo "SORRY, RECORD NOT FOUND";
        }

    }

    public function getcaseblocklist(){

       
        $builder = $this->db->table("public.loose_block a");
        $builder->select("a.id,a.diary_no, reason_blk, section_name,a.ent_dt");
        $builder->select("CASE WHEN (m.pet_name IS NOT NULL or m.pet_name != '') THEN m.pet_name ELSE ma.pet_name END AS pet_name", false);
        $builder->select("CASE WHEN (m.res_name IS NOT NULL or m.res_name != '') THEN m.res_name ELSE ma.res_name END AS res_name", false);
        $builder->join('master.users b', 'a.usercode=b.usercode', 'LEFT');
        $builder->join('master.usersection c', 'b.section = c.id', 'LEFT');
        $builder->join('main m', 'a.diary_no=m.diary_no', 'LEFT');
        $builder->join('main_a ma', 'a.diary_no=ma.diary_no', 'LEFT');
        $builder->where('a.display', 'Y');
        $builder->orderBy('a.ent_dt', 'ASC');
        $query = $builder->get();
        $result = $query->getResultArray();

        return $result;
    }

    public function delete_case_block($dataset){
        $ucode = $_SESSION['login']['usercode'];

        $builder3 = $this->db->table("public.loose_block");
        $builder3->set('display', 'N' );
        $builder3->set('up_user', $ucode);
        $builder3->set('up_dt', 'NOW()' );
        $builder3->where('id', $dataset['id']);
        if($builder3->update()){
            echo "1~RECORD DELETED SUCCESSFULLY";
        }
    }

    public function save_case_block($dataset){
        $ucode= $_SESSION['login']['usercode'];
        $dataset['dno']=$dataset['dno'].$dataset['dyr'];
        $builder = $this->db->table("loose_block");
        $builder->select("*");
        $builder->where('diary_no',$dataset['dno']);
        $builder->where('display','Y');
        $query = $builder->get();
        $result = $query->getResultArray();
        
        if(count($result)>0){
            echo "0~RECORD ALREADY PRESENT";
        }else{
            $reason=trim(strtoupper(addslashes($dataset['reason']))); 

            $insert_data = [
                'diary_no' => (int)$dataset['dno'],
                'reason_blk' => $reason, 
                'usercode' => (int) $ucode, 
                'ent_dt' => 'NOW()', 
                'up_user' => (int) $ucode
            ];
            $builder54 = $this->db->table("public.loose_block");             
            $insert = $builder54->insert($insert_data);
            if($insert){
                echo "1~RECORD INSERTED SUCCESSFULLY";
            }
        }
    }

    public function getUserDetails_verify(){

        $usercode = $_SESSION['login']['usercode'];
        $user = "";
        
        $builder = $this->db->table("master.users a");
        $builder->select("usercode, name, empid, service, udept, section, usertype, log_in, jcode, attend, dept_name, section_name, type_name, a.entdt, isda");
        $builder->join('master.userdept b', 'a.udept = b.id', 'LEFT');
        $builder->join('master.usersection c', 'a.section = c.id', 'LEFT');
        $builder->join('master.usertype d', 'a.usertype = d.id', 'LEFT');
        $builder->where('a.usercode', $usercode);
        $query = $builder->get();
        $rs_user = $query->getResultArray();

        if (count($rs_user) > 0) {
            $row = $rs_user[0];
            if ($row['isda'] == "Y"){
                $isda = " [DA]";
            }else{
                $isda = "";
            }
            $user = "Section: <font color=green>" . $row['section_name'] . $isda . "</font>, User Name: <font color=green>" . $row['name'] . ", " . $row['type_name'] . "</font>";        
            return $user;
        }

    }

    public function getverify_defective(){

        $usercode = $_SESSION['login']['usercode'];

        $builder = $this->db->table("public.ld_move a");
        $builder->select("*");
        $builder->join('docdetails b', "a.diary_no = b.diary_no AND a.diary_no > 0 AND b.diary_no > 0 AND a.doccode = b.doccode AND a.doccode1 = b.doccode1 AND a.docnum = b.docnum AND a.docyear = b.docyear AND b.display = 'Y' AND a.rece_by = $usercode AND b.verified = '' AND b.iastat = 'P' ", 'INNER');
        $builder->join('main m', 'a.diary_no = m.diary_no', 'INNER');
        $builder->join('master.docmaster c', 'a.doccode = c.doccode AND a.doccode1 = c.doccode1', 'LEFT');
        $builder->orderBy('a.disp_dt', 'DESC');
        $query = $builder->get();
        $select_q = $query->getResultArray();
        $dataArr = [];
        foreach ($select_q as $val) {

            $real_diaryno = $this->get_real_diaryno($val['diary_no']); 
            $casenos_comma = $this->get_casenos_comma($val['diary_no']);
            $user_details = $this->get_user_details($val['disp_by']); 

            $dataArr[] = [
                            'diary_no' => $val['diary_no'],
                            'fil_no' => $val['fil_no'],
                            'doccode' => $val['doccode'],
                            'doccode1' => $val['doccode1'],
                            'docnum' => $val['docnum'],
                            'docyear' => $val['docyear'],
                            'disp_by' => $val['disp_by'],
                            'disp_to' => $val['disp_to'],
                            'disp_dt' => $val['disp_dt'],
                            'remarks' => $val['remarks'],
                            'rece_by' => $val['rece_by'],
                            'rece_dt' => $val['rece_dt'],
                            'other' => $val['other'],
                            'create_modify' => $val['create_modify'],
                            'updated_on' => $val['updated_on'],
                            'updated_by' => $val['updated_by'],
                            'updated_by_ip' => $val['updated_by_ip'],
                            'filedby' => $val['filedby'],
                            'docfee' => $val['docfee'],
                            'other1' => $val['other1'],
                            'iastat' => $val['iastat'],
                            'forresp' => $val['forresp'],
                            'feemode' => $val['feemode'],
                            'fee1' => $val['fee1'],
                            'fee2' => $val['fee2'],
                            'usercode' => $val['usercode'],
                            'ent_dt' => $val['ent_dt'],
                            'display' => $val['display'],
                            'remark' => $val['remark'],
                            'lst_mdf' => $val['lst_mdf'],
                            'lst_user' => $val['lst_user'],
                            'j1' => $val['j1'],
                            'j2' => $val['j2'],
                            'j3' => $val['j3'],
                            'party' => $val['party'],
                            'advocate_id' => $val['advocate_id'],
                            'verified' =>  $val['verified'],
                            'verified_by' => $val['verified_by'],
                            'verified_on' => $val['verified_on'],
                            'sc_ia_sta_code' => $val['sc_ia_sta_code'],
                            'sc_ref_code_id' => $val['sc_ref_code_id'],
                            'sc_application_no' => $val['sc_application_no'],
                            'no_of_copy' => $val['no_of_copy'],
                            'sc_old_doc_code' => $val['sc_old_doc_code'],
                            'docd_id' => $val['docd_id'],
                            'verified_remarks' => $val['verified_remarks'],
                            'dispose_date' => $val['dispose_date'],
                            'last_modified_by' => $val['last_modified_by'],
                            'disposal_remark' => $val['disposal_remark'],
                            'is_efiled' => $val['is_efiled'],
                            'active_fil_no' => $val['active_fil_no'],
                            'fil_no_old' => $val['fil_no_old'],
                            'pet_name' => $val['pet_name'],
                            'res_name' => $val['res_name'],
                            'res_name_old' => $val['res_name_old'],
                            'pet_adv_id' => $val['pet_adv_id'],
                            'res_adv_id' => $val['res_adv_id'],
                            'actcode' => $val['actcode'],
                            'claim_amt' => $val['claim_amt'],
                            'bench' => $val['bench'],
                            'fixed' => $val['fixed'],
                            'c_status' => $val['c_status'],
                            'fil_dt' => $val['fil_dt'],
                            'active_fil_dt' => $val['active_fil_dt'],
                            'case_pages' => $val['case_pages'],
                            'relief' => $val['relief'],
                            'last_usercode' => $val['last_usercode'],
                            'dacode' => $val['dacode'],
                            'old_dacode' => $val['old_dacode'],
                            'old_da_ec_case' => $val['old_da_ec_case'],
                            'last_dt' => $val['last_dt'],
                            'conn_key' => $val['conn_key'],
                            'case_grp' =>   $val['case_grp'],
                            'lastorder' => $val['lastorder'],
                            'fixeddet' => $val['fixeddet'],
                            'bailno' => $val['bailno'],
                            'prevno' => $val['prevno'],
                            'head_code' => $val['head_code'],
                            'scr_user' => $val['scr_user'],
                            'scr_time' => $val['scr_time'],
                            'scr_type' => $val['scr_type'],
                            'prevno_fildt' => $val['prevno_fildt'],
                            'ack_id' => $val['ack_id'],
                            'ack_rec_dt' => $val['ack_rec_dt'],
                            'admitted' => $val['admitted'],
                            'outside' => $val['outside'],
                            'diary_no_rec_date' => $val['diary_no_rec_date'],
                            'diary_user_id' => $val['diary_user_id'],
                            'ref_agency_state_id' => $val['ref_agency_state_id'],
                            'ref_agency_state_id_old' => $val['ref_agency_state_id_old'],
                            'ref_agency_code_id' => $val['ref_agency_code_id'],
                            'ref_agency_code_id_old' => $val['ref_agency_code_id_old'],
                            'from_court' => $val['from_court'],
                            'is_undertaking' => $val['is_undertaking'],
                            'undertaking_doc_type' => $val['undertaking_doc_type'],
                            'undertaking_reason' => $val['undertaking_reason'],
                            'casetype_id' => $val['casetype_id'],
                            'active_casetype_id' => $val['active_casetype_id'],
                            'padvt' => $val['padvt'],
                            'radvt' => $val['radvt'],
                            'total_court_fee' => $val['total_court_fee'],
                            'court_fee' => $val['court_fee'],
                            'valuation' => $val['valuation'],
                            'case_status_id' => $val['case_status_id'],
                            'brief_description' => $val['brief_description'],
                            'nature' => $val['nature'],
                            'fil_no_fh' => $val['fil_no_fh'],
                            'fil_no_fh_old' => $val['fil_no_fh_old'],
                            'fil_dt_fh' => $val['fil_dt_fh'],
                            'mf_active' => $val['mf_active'],
                            'active_reg_year' => $val['active_reg_year'],
                            'reg_year_mh' => $val['reg_year_mh'],
                            'reg_year_fh' => $val['reg_year_fh'],
                            'reg_no_display' => $val['reg_no_display'],
                            'pno' => $val['pno'],
                            'rno' => $val['rno'],
                            'if_sclsc' => $val['if_sclsc'],
                            'section_id' => $val['section_id'],
                            'unreg_fil_dt' => $val['unreg_fil_dt'],
                            'refiling_attempt' => $val['refiling_attempt'],
                            'last_return_to_adv' => $val['last_return_to_adv'],
                            'docdesc' => $val['docdesc'],
                            'kntgrp' =>$val['kntgrp'],
                            'doctype' => $val['doctype'],
                            'old_id' => $val['old_id'],
                            'relief_code' => $val['relief_code'],
                            'remark1' => $val['remark1'],
                            'remark2' => $val['remark2'],
                            'listable' => $val['listable'],
                            'sc_doc_code' => $val['sc_doc_code'],
                            'not_reg_if_pen' => $val['not_reg_if_pen'],
                            'doc_ia_type' => $val['doc_ia_type'],
                            'real_diaryno' => $real_diaryno,
                            'casenos_comma' => $casenos_comma,
                            'user_details' => $user_details,
            ];
                        
        }
        return $dataArr;

    }

    function get_real_diaryno($dn){
        $real_diary_no="";
        if($dn!=""){
            $real_diary_no=substr($dn, 0, -4)."/".substr($dn, -4);
        }
        return $real_diary_no;
    }

    function get_casenos_comma($dn)
    {
        $t_fil_no='';
       
        if($dn!=''){
            $sql_from_main="SELECT casetype_id,
                    CONCAT(
                        m.active_fil_no,
                        ':',
                        CASE
                            WHEN active_reg_year = 0 OR active_fil_dt > '2017-05-10' THEN EXTRACT(YEAR FROM active_fil_dt)::TEXT
                            ELSE active_reg_year::TEXT
                        END,
                        ':',
                        TO_CHAR(active_fil_dt, 'DD-MM-YYYY')
                    ) AS ad,
                    CASE
                        WHEN fil_no_fh != active_fil_no AND fil_no_fh != fil_no AND fil_no_fh != '' THEN CONCAT(
                            m.fil_no_fh,
                            ':',
                            CASE
                                WHEN reg_year_fh = 0 OR fil_dt_fh > '2017-05-10' THEN EXTRACT(YEAR FROM fil_dt_fh)::TEXT
                                ELSE reg_year_fh::TEXT
                            END,
                            ':',
                            TO_CHAR(fil_dt_fh, 'DD-MM-YYYY')
                        )
                        ELSE ''
                    END AS rd,
                    CASE
                        WHEN fil_no != active_fil_no AND fil_no_fh != fil_no AND fil_no != '' THEN CONCAT(
                            m.fil_no,
                            ':',
                            CASE
                                WHEN reg_year_mh = 0 OR fil_dt > '2017-05-10' THEN EXTRACT(YEAR FROM fil_dt)::TEXT
                                ELSE reg_year_mh::TEXT
                            END,
                            ':',
                            TO_CHAR(fil_dt, 'DD-MM-YYYY')
                        )
                        ELSE ''
                    END AS md
            FROM public.main m
            WHERE diary_no = '$dn' "; 

            // $result_main = mysql_query($sql_from_main) or die(mysql_error().$sql_from_main);
            $result_main = $this->db->query($sql_from_main);
            $result_main = $result_main->getResultArray();
            $cases="";
            if(count($result_main)>0){
                $row_main=$result_main[0];
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
                        $builder = $this->db->table("master.casetype");
                        $builder->select("short_description,cs_m_f");
                        $builder->where('casecode',$t_m1);
                        $builder->where('display','Y');
                        $query = $builder->get();
                        $result = $query->getResultArray();
                        $row= $result[0];
                        $res_ct_typ = $row['short_description'];   
                        $res_ct_typ_mf = $row['cs_m_f'];
                        if(trim($t_fil_no)!=''){
                            $t_fil_no.=",";
                        }
                        if($t_m2==$t_m21){
                            $t_fil_no.= $res_ct_typ." ".ltrim($t_m2,'0').'/'.$t_m3;
                        }else{
                            $t_fil_no.= $res_ct_typ." ".ltrim($t_m2,'0').'-'. ltrim($t_m21,'0') .'/'.$t_m3;
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
                        $builder = $this->db->table("master.casetype");
                        $builder->select("short_description,cs_m_f");
                        $builder->where('casecode',$t_m1);
                        $builder->where('display','Y');
                        $query = $builder->get();
                        $result = $query->getResultArray();
                        $row= $result[0];
                        $res_ct_typ = $row['short_description'];   
                        $res_ct_typ_mf = $row['cs_m_f'];
                        if(trim($t_fil_no)!=''){
                            $t_fil_no.=",";
                        }
                        if($t_m2==$t_m21){
                            $t_fil_no.= $res_ct_typ." ".ltrim($t_m2,'0').'/'.$t_m3;
                        }else{
                            $t_fil_no.= $res_ct_typ." ".ltrim($t_m2,'0').'-'. ltrim($t_m21,'0') .'/'.$t_m3;
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
                        $builder = $this->db->table("master.casetype");
                        $builder->select("short_description,cs_m_f");
                        $builder->where('casecode',$t_m1);
                        $builder->where('display','Y');
                        $query = $builder->get();
                        $result = $query->getResultArray();
                        $row= $result[0];
                        $res_ct_typ = $row['short_description'];   
                        $res_ct_typ_mf = $row['cs_m_f'];
                        if(trim($t_fil_no)!='')
                            $t_fil_no.=",";
                        if($t_m2==$t_m21){
                            $t_fil_no.= $res_ct_typ." ".ltrim($t_m2,'0').'/'.$t_m3;
                        }else{
                            $t_fil_no.= $res_ct_typ." ".ltrim($t_m2,'0').'-'. ltrim($t_m21,'0') .'/'.$t_m3;
                        }
                    }
                }
            }
            // $sql_mc_h="SELECT t.oldno, GROUP_CONCAT(DISTINCT CONCAT(t.new_registration_number,':',t.new_registration_year,':',DATE_FORMAT(t.order_date,'%d-%m-%Y')) ORDER BY t.order_date,t.id ) AS newno FROM (SELECT @rowid:=@rowid+1 AS rowid,`main_casetype_history`.*, IF(@rowid=1,IF(old_registration_number='' OR old_registration_number IS NULL,'',CONCAT(old_registration_number,':',old_registration_year,':',DATE_FORMAT(order_date,'%d-%m-%Y'))),'') AS oldno FROM `main_casetype_history`, (SELECT @rowid:=0) AS init  WHERE `diary_no` = ".$dn." AND is_deleted='f' ORDER BY `main_casetype_history`.`order_date`,id ) t GROUP BY t.diary_no";
            $sql_mc_h = "SELECT t.oldno, STRING_AGG(CONCAT(t.new_registration_number, ':', t.new_registration_year, ':', TO_CHAR(t.order_date, 'DD-MM-YYYY')), ',' ORDER BY t.order_date, t.id) AS newno
                    FROM (
                        SELECT
                            ROW_NUMBER() OVER (ORDER BY order_date, id) AS rowid,
                            public.main_casetype_history.*,
                            CASE
                                WHEN ROW_NUMBER() OVER (ORDER BY order_date, id) = 1 THEN
                                    CASE
                                        WHEN old_registration_number = '' OR old_registration_number IS NULL THEN ''
                                        ELSE CONCAT(old_registration_number, ':', old_registration_year, ':', TO_CHAR(order_date, 'DD-MM-YYYY'))
                                    END
                                ELSE ''
                            END AS oldno
                        FROM
                            public.main_casetype_history
                        WHERE
                            diary_no = $dn AND is_deleted = 'f'
                        ORDER BY
                            main_casetype_history.order_date, id
                    ) t
                    GROUP BY t.diary_no, t.oldno";

            $result_mc_h = $this->db->query($sql_mc_h);
            $result_mc_h = $result_mc_h->getResultArray();
            if(count($result_mc_h)>0){
                $cnt=0;
                foreach ($result_mc_h as $row_mc_h) {
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
                            $builder = $this->db->table("master.casetype");
                            $builder->select("short_description,cs_m_f");
                            $builder->where('casecode',$t_m1);
                            $builder->where('display','Y');
                            $query = $builder->get();
                            $result = $query->getResultArray();
                            $row= $result[0];
                            $res_ct_typ = $row['short_description'];   
                            $res_ct_typ_mf = $row['cs_m_f'];
                            if(trim($t_fil_no)!=''){
                                $t_fil_no.=",<br>";
                            }
                            if($t_m2==$t_m21){
                                $t_fil_no.= $res_ct_typ." ".ltrim($t_m2,'0').'/'.$t_m3;
                            }else{
                                $t_fil_no.= $res_ct_typ." ".ltrim($t_m2,'0').'-'. ltrim($t_m21,'0') .'/'.$t_m3;
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
                                    $builder = $this->db->table("master.casetype");
                                    $builder->select("short_description,cs_m_f");
                                    $builder->where('casecode',$t_m1);
                                    $builder->where('display','Y');
                                    $query = $builder->get();
                                    $result = $query->getResultArray();
                                    $row= $result[0];
                                    $res_ct_typ = $row['short_description'];   
                                    $res_ct_typ_mf = $row['cs_m_f'];
                                    if(trim($t_fil_no)!=''){
                                        $t_fil_no.=",<br>";
                                    }
                                    if($t_m2==$t_m21) { 
                                        $t_fil_no.= $res_ct_typ." ".ltrim($t_m2,'0').'/'.$t_m3;
                                    }else{
                                        $t_fil_no.= $res_ct_typ." ".ltrim($t_m2,'0').'-'. ltrim($t_m21,'0') .'/'.$t_m3;
                                    }
                                }
                                $t_chk=$t_fn;            
                            }
                        }
                    }
                
                }
            }
            
            if(trim($t_fil_no)==''){
                $builder = $this->db->table("master.casetype");
                $builder->select("short_description");
                $builder->where('casecode',$row_main['casetype_id']);
                $query = $builder->get();
                $result = $query->getResultArray();
                if (count($result) > 0) {
                    $row_12 = $result[0]; 
                    $t_fil_no=$row_12['short_description'];            
                }
            }
        }
        return $t_fil_no;   
    }

    function get_user_details($usercode) {
      
        $user = "";
        $builder = $this->db->table("master.users a");
        $builder->select("usercode, name, empid, service, udept, section, usertype, log_in, jcode, attend, dept_name, section_name, type_name, a.entdt, isda");
        $builder->join('master.userdept b', 'a.udept = b.id', 'LEFT');
        $builder->join('master.usersection c', 'a.section = c.id', 'LEFT');
        $builder->join('master.usertype d', 'a.usertype = d.id', 'LEFT');
        $builder->where('a.usercode', $usercode);
        $query = $builder->get();
        $rs_user = $query->getResultArray();

        if (count($rs_user) > 0) {
            $row = $rs_user[0];
            if ($row['isda'] == "Y"){
                $isda = " [DA]";
            }else{
                $isda = "";
            }
            $user = "Section: ". $row['section_name'] . $isda . ", User Name: " . $row['name'] . ", " . $row['type_name'] ;        
            return $user;
        }

    }

    public function verify_save($dataset){
        $ucode = $_SESSION['login']['usercode'];
        $vr=$dataset['vr'];
        $cont = 0;
        foreach ($dataset['alldata'] as $key => $value){
            $t_vr=$dataset['tb'][$key];
            $new_value = explode('-', $value);
            $builder3 = $this->db->table("public.docdetails");
            $builder3->set('verified', $vr );
            $builder3->set('verified_by', $ucode);
            $builder3->set('verified_on', 'NOW()' );
            $builder3->set('verified_remarks', $t_vr);
            $builder3->where('diary_no', $new_value[0]);
            $builder3->where('doccode', $new_value[1]);
            $builder3->where('doccode1',$new_value[2]);
            $builder3->where('docnum',$new_value[3]);
            $builder3->where('docyear',$new_value[4]);
            if($builder3->update()){
                $cont = $cont +1;
            }

        }

        return $cont;

    }


    public function getRemarksList($dataset){
               
        $builder = $this->db->table('public.docdetails_remark');
        $builder->distinct();
        $builder->select('remark_data');
        $builder->where("remark_data != ''");
        $builder->where("remark_data ILIKE '%$dataset%'");
        $query1 = $builder->get();
        $result = $query1->getResultArray();

        if(!empty($result)){
            return json_encode($result, true);
        }else{
            return false;
        }
       
       
    }

}