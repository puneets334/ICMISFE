<?php

namespace App\Models\Judicial;

use CodeIgniter\Model;

class PhysicalVerificationModel extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
    }


    public function getreportDetails()
    {
        $ucode = $_SESSION['login']['usercode'];
        $sql = "SELECT array_to_string(array_agg(c.short_description || ' - ' || 
                CASE WHEN SPLIT_PART(new_registration_number, '-', 2) = SPLIT_PART(new_registration_number, '-', -1) 
                    THEN SPLIT_PART(new_registration_number, '-', -1) 
                    ELSE SPLIT_PART(new_registration_number, '-', -2) 
                END || ' / ' || mch.new_registration_year || ' Dt. ' || TO_CHAR((order_date), 'DD-MM-YYYY')),',') AS all_regno,
                a.name AS da_name, a.empid AS da_empid, b.section_name AS da_section_name, active_fil_no, m.diary_no AS dno,
                CONCAT(SUBSTRING((m.diary_no::text), 1, LENGTH((m.diary_no::text)) - 4), '/', SUBSTRING((m.diary_no::text), -4)) AS diary,
                p.avaliable_flag AS is_verify, reg_no_display, CONCAT((pet_name), ' Vs ', (res_name)) AS cause_title, (diary_no_rec_date) AS diary_no_rec_date,
                (active_fil_dt) AS active_fil_dt, (m.diary_no) AS min_diary_no, 
                string_agg(distinct vp.name||'(' ||vp.empid||')'||'-'||vs.section_name,',') AS verified_by, rgs.agency_state, rgc.agency_name 
                FROM main m 
                LEFT JOIN main_casetype_history mch ON mch.diary_no = m.diary_no AND mch.is_deleted = 'f' 
                LEFT JOIN master.casetype c ON c.casecode = mch.ref_new_case_type_id 
                LEFT JOIN physical_verify p ON m.diary_no = p.diary_no AND p.display='Y' 
                LEFT JOIN master.users vp ON p.ucode = vp.usercode 
                LEFT JOIN master.usersection vs ON vp.section = vs.id 
                LEFT JOIN master.users a ON m.dacode = a.usercode 
                LEFT JOIN master.usersection b ON b.id = a.section 
                LEFT JOIN master.ref_agency_state rgs ON rgs.cmis_state_id = m.ref_agency_state_id 
                LEFT JOIN master.ref_agency_code rgc ON rgc.id = m.ref_agency_code_id 
                WHERE c_status='P' AND m.dacode = $ucode 
                GROUP BY m.diary_no, a.name, a.empid, b.section_name, active_fil_no, p.avaliable_flag, reg_no_display, rgs.agency_state, rgc.agency_name,  m.pet_name, m.res_name, m.diary_no_rec_date, m.active_fil_dt 
                order by dno";
        $result = $this->db->query($sql);
        $result = $result->getResultArray();


        $dataArr = [];
        if (!empty($result)) {
            $dataArr['total_cases'] = count($result);
            $dataArr['result'] = $result;
        }

        return $dataArr;
    }


    public function wrong_updated_get($data)
    {

        $datares = [];
        $builder1 = $this->db->table("main m");
        $builder1->select("reg_no_display, m.diary_no, diary_no_rec_date, fil_dt, active_fil_dt, fil_dt_fh, mf_active, c_status,
        pet_name, res_name, pno, rno, active_casetype_id,case_grp");
        $builder1->where('m.diary_no', $data['dno']);
        $builder1->where('m.c_status', 'P');
        $query1 = $builder1->get();
        $chk_avl = $query1->getResultArray();

        if (!empty($chk_avl)) {
            $datares['chk_avl'] = $chk_avl[0];
            $builder2 = $this->db->table("heardt h");
            $builder2->select("mainhead");
            $builder2->where('h.diary_no', $data['dno']);
            $builder2->where('mainhead', 'F');
            $query2 = $builder2->get();
            $chk_avl5 = $query2->getResultArray();
            $datares['chk_avl5'] = !empty($chk_avl) ? $chk_avl[0] : [];
            $builder3 = $this->db->table("heardt h");
            $builder3->select("stagename, h.mainhead");
            $builder3->join('master.subheading s', 'h.subhead = s.stagecode', 'INNER');
            $builder3->where('h.diary_no', $data['dno']);
            $builder3->where('mainhead', 'M');
            $query3 = $builder3->get();
            $chk_avl55 = $query3->getResultArray();
            $datares['chk_avl55'] = !empty($chk_avl55) ? $chk_avl55[0] : [];
            $builder4 = $this->db->table("mul_category mc");
            $builder4->select("sub_name1, sub_name2, sub_name3, sub_name4, category_sc_old");
            $builder4->join('master.submaster s', 's.id = mc.submaster_id', 'INNER');
            $builder4->where('mc.diary_no', $data['dno']);
            $builder4->where('mc.display', 'Y');
            $builder4->whereNotIn('subcode1', ['8888', '9999']);
            $query4 = $builder4->get();
            $res4 = $query4->getResultArray();
            $datares['res6'] = $res4;
            $builder5 = $this->db->table('master.submaster');
            $builder5->select('id, subcode1, sub_name1');
            $builder5->where('flag_use', 'S');
            $builder5->orWhere('flag_use', 'L');
            $builder5->where('display', 'Y');
            $builder5->where('match_id !=', 0);
            $builder5->where('flag', 'S');
            $builder5->groupBy('subcode1, id, sub_name1');
            $builder5->orderBy('subcode1');
            $query5 = $builder5->get();
            $res5 = $query5->getResultArray();
            $datares['res5'] = $res5;
            $builder6 = $this->db->table("main_casetype_history m");
            $builder6->select("diary_no, id, c.short_description, SPLIT_PART(SPLIT_PART(new_registration_number, '-', 2), '-', -1) AS split_caseno1, SPLIT_PART(new_registration_number, '-', -1) AS split_caseno2, new_registration_year, order_date");
            $builder6->join('master.casetype c', 'c.casecode = CAST(SUBSTRING(new_registration_number FROM 1 FOR 2) AS INTEGER)', 'LEFT');
            $builder6->where('m.diary_no', $data['dno']);
            $builder6->where('m.is_deleted', 'f');
            $builder6->orderBy('order_date');
            $query6 = $builder6->get();
            $res6 = $query6->getResultArray();
            $datares['res_reg_form'] = $res6;
            $dno = $data['dno'];

            $builder = $this->db->table('party p');
            $builder->select('p.sr_no, p.pet_res, p.ind_dep, p.partyname, p.sonof, p.prfhname, p.age, p.sex, p.caste, p.addr1, p.addr2, p.pin, p.state, p.city, p.email, p.contact AS mobile, p.deptcode, s1.name as state_name, s2.name as district_name, auto_generated_id');
            $builder->join('master.state s1', 'p.state::text = s1.id_no::text', 'left');
            $builder->join('master.state s2', 'p.city::text = s2.id_no::text', 'left');
            $builder->join('main m', 'm.diary_no = p.diary_no AND pflag = \'P\' AND pet_res IN (\'P\', \'R\')', 'inner');
            $builder->where('m.diary_no', $dno);
            $builder->orderBy('p.pet_res, p.sr_no');
            $query = $builder->get();
            $result_party = $query->getResultArray();
            $datares['result_party'] = $result_party;
            $builder8 = $this->db->table('heardt h');
            $builder8->select('*');
            $builder8->join('main m', 'h.diary_no = m.diary_no ', 'inner');
            $builder8->where('h.diary_no', $data['dno']);
            $builder8->where('m.c_status', 'P');
            $query8 = $builder8->get();
            $result_listing_status = $query8->getResultArray();
            $datares['result_listing_status'] = $result_listing_status;
            $builder9 = $this->db->table("rgo_default");
            $builder9->select("*");
            $builder9->where('fil_no', $data['dno']);
            $query9 = $builder9->get();
            $result_rgo_default = $query9->getResultArray();
            $datares['result_rgo_default'] = $result_rgo_default;
            $builder10 = $this->db->table("dispose");
            $builder10->select("*");
            $builder10->where('diary_no', $data['dno']);
            $query10 = $builder10->get();
            $results_disp = $query10->getResultArray();
            $datares['results_disp'] = $results_disp;
            $builder11 = $this->db->table('docdetails a');
            $builder11->select('a.docnum, a.docyear, a.ent_dt, b.docdesc, a.other1');
            $builder11->join('master.docmaster b', 'a.doccode = b.doccode AND a.doccode1 = b.doccode1', 'inner');
            $builder11->where('a.iastat', 'P');
            $builder11->where('a.diary_no', $data['dno']);
            $builder11->where('a.doccode', 8);
            $builder11->where('a.display', 'Y');
            $builder11->where('b.display', 'Y');
            $builder11->orderBy('a.ent_dt');
            $query11 = $builder11->get();
            $results_ian = $query11->getResultArray();
            $datares['results_ian'] = $results_ian;
            $builder12 = $this->db->table('act_main a');
            $builder12->select("a.act, STRING_AGG(b.section, ', ') AS section, c.act_name");
            $builder12->join('master.act_section b', 'a.id = b.act_id', 'left');
            $builder12->join('master.act_master c', 'c.id = a.act', 'inner');
            $builder12->where('a.diary_no', $data['dno']);
            $builder12->where('a.display', 'Y');
            $builder12->where('b.display', 'Y');
            $builder12->where('c.display', 'Y');
            $builder12->groupBy('a.act, c.act_name');
            $query12 = $builder12->get();
            $act = $query12->getResultArray();
            $datares['act'] = $act;
            $builder13 = $this->db->table("master.act_master");
            $builder13->select("*");
            $builder13->where('display', 'Y');
            $builder13->where('act_name is NOT NULL', NULL, FALSE);
            $builder13->where('act_name !=', '');
            $builder13->orderBy('act_name');
            $query13 = $builder13->get();
            $res13 = $query13->getResultArray();
            $datares['res13'] = $res13;
            $builder14 = $this->db->table('lowerct a');
            $builder14->select("
                lct_dec_dt,
                lct_judge_name,
                lctjudname2,
                lctjudname3,
                l_dist,
                ct_code,
                l_state,
                name,
                brief_desc AS desc1,
                sub_law AS usec2,
                lct_judge_desg,
                CASE
                    WHEN ct_code = 3 AND l_state = 490506 THEN
                        (SELECT court_name
                        FROM master.state s
                        LEFT JOIN master.delhi_district_court d ON s.state_code = d.state_code AND s.district_code = d.district_code
                        WHERE s.id_no = a.l_dist AND s.display = 'Y')
                    WHEN ct_code = 3 THEN
                        (SELECT name
                        FROM master.state s
                        WHERE s.id_no = a.l_dist AND s.display = 'Y')
                    ELSE
                        (SELECT agency_name
                        FROM master.ref_agency_code c
                        WHERE c.cmis_state_id = a.l_state AND c.id = a.l_dist AND c.is_deleted = 'f')
                END AS agency_name,
                crimeno,
                crimeyear,
                polstncode,
                (SELECT policestndesc
                FROM master.police p
                WHERE p.policestncd = a.polstncode AND p.display = 'Y' AND p.cmis_state_id = a.l_state AND p.cmis_district_id = a.l_dist
                    AND a.crimeno != '' AND a.crimeno != '0') AS policestndesc,
                authdesc,
                l_inddep,
                l_orgname,
                l_ordchno,
                l_iopb,
                l_iopbn,
                l_org,
                lct_casetype,
                lct_caseno,
                lct_caseyear,
                CASE
                    WHEN ct_code = 4 THEN
                        (SELECT skey
                        FROM master.casetype ct
                        WHERE ct.display = 'Y' AND ct.casecode = a.lct_casetype)
                    ELSE
                        (SELECT type_sname
                        FROM master.lc_hc_casetype d
                        WHERE d.lccasecode = a.lct_casetype AND d.display = 'Y')
                END AS type_sname,
                a.lower_court_id,
                is_order_challenged,
                full_interim_flag,
                judgement_covered_in,
                vehicle_code,
                vehicle_no,
                code,
                post_name,
                cnr_no,
                ref_court,
                ref_case_type,
                ref_case_no,
                ref_case_year,
                ref_state,
                ref_district,
                gov_not_state_id,
                gov_not_case_type,
                gov_not_case_no,
                gov_not_case_year,
                gov_not_date,
                relied_court,
                relied_case_type,
                relied_case_no,
                relied_case_year,
                relied_state,
                relied_district,
                transfer_case_type,
                transfer_case_no,
                transfer_case_year,
                transfer_state,
                transfer_district,
                transfer_court
            ");
            $builder14->join('master.state b', "a.l_state = b.id_no AND b.display = 'Y'", 'left');
            $builder14->join('main e', 'e.diary_no = a.diary_no', 'inner');
            $builder14->join('master.authority f', "f.authcode = a.l_iopb AND f.display = 'Y'", 'left');
            $builder14->join('master.rto h', "h.id = a.vehicle_code AND h.display = 'Y'", 'left');
            $builder14->join('master.post_t i', "i.post_code = a.lct_judge_desg AND i.display = 'Y'", 'left');
            $builder14->join('relied_details rd', "rd.lowerct_id = a.lower_court_id AND rd.display = 'Y'", 'left');
            $builder14->join('transfer_to_details t_t', "t_t.lowerct_id = a.lower_court_id AND t_t.display = 'Y'", 'left');
            $builder14->where('a.diary_no', $data['dno']);
            $builder14->where('lw_display', 'Y');
            $builder14->orderBy('a.lower_court_id');

            $query14 = $builder14->get();
            $res14 = $query14->getResultArray();
            if (!empty($res14)) {
                $datrs14 = [];

                foreach ($res14 as $key => $row5) {

                    $builder1 = $this->db->table("lowerct_judges");
                    $builder1->select("judge_id");
                    $builder1->where('lct_display', 'Y');
                    $builder1->where('lowerct_id', $row5['lower_court_id']);
                    $query1 = $builder1->get();
                    $chk_lower_jud = $query1->getResultArray();

                    $jud_name = '';
                    $jud_id = '';
                    if (count($chk_lower_jud) > 0) {

                        foreach ($chk_lower_jud as $row) {

                            if ($row5['ct_code'] == '4') {

                                $builder2 = $this->db->table("judge");
                                $builder2->select("first_name,sur_name");
                                $builder2->where('display', 'Y');
                                $builder2->where('jcode', $row['judge_id']);
                                $query2 = $builder2->get();
                                $jud_name_l = $query2->getResultArray();
                            } else {

                                $builder2 = $this->db->table("master.org_lower_court_judges");
                                $builder2->select("first_name,sur_name");
                                $builder2->where('is_deleted', 'f');
                                $builder2->where('id', $row['judge_id']);
                                $query2 = $builder2->get();
                                $jud_name_l = $query2->getResultArray();
                            }

                            if (!empty($jud_name_l)) {
                                $res_jud_name_l = $jud_name_l[0];
                                if ($jud_name == '') {
                                    $jud_name .= $res_jud_name_l['first_name'] . ' ' . $res_jud_name_l['sur_name'];
                                } else {
                                    $jud_name .= $jud_name . ', ' . $res_jud_name_l['first_name'] . ' ' . $res_jud_name_l['sur_name'];
                                }
                            }
                        }
                    }


                    $ref_court = '';
                    $ref_state = '';
                    $ref_district = '';
                    $ref_case_type = '';
                    if ($row5['ref_court'] != 0) {

                        $builder3 = $this->db->table("master.m_from_court");
                        $builder3->select("court_name");
                        $builder3->where('display', 'Y');
                        $builder3->where('id', $row5['ref_court']);
                        $query3 = $builder3->get();
                        $res_court = $query3->getResultArray();
                        if (!empty($res_court)) {
                            $res_court = $res_court[0]['court_name'];
                        } else {
                            $res_court = '-';
                        }
                        $ref_court = $res_court;


                        $builder4 = $this->db->table("master.state");
                        $builder4->select("name");
                        $builder4->where('display', 'Y');
                        $builder4->where('id_no', $row5['ref_state']);
                        $query4 = $builder4->get();
                        $res_state = $query4->getResultArray();
                        if (!empty($res_state)) {
                            $res_state = $res_state[0]['name'];
                        } else {
                            $res_state = '-';
                        }
                        $ref_state = $res_state;

                        if ($row5['ref_court'] == '3') {

                            $builder5 = $this->db->table("master.state");
                            $builder5->select("name");
                            $builder5->where('display', 'Y');
                            $builder5->where('id_no', $row5['ref_district']);
                            $query5 = $builder5->get();
                            $res_district = $query5->getResultArray();
                            if (!empty($res_district)) {
                                $res_district = $res_district[0]['name'];
                            } else {
                                $res_district = '-';
                            }
                            $ref_district = $res_district;
                        } else {

                            $builder5 = $this->db->table("master.ref_agency_code");
                            $builder5->select("agency_name");
                            $builder5->where('is_deleted', 'f');
                            $builder5->where('id', $row5['ref_district']);
                            $query5 = $builder5->get();
                            $res_district = $query5->getResultArray();
                            if (!empty($res_district)) {
                                $res_district = $res_district[0]['agency_name'];
                            } else {
                                $res_district = '-';
                            }
                            $ref_district = $res_district;
                        }

                        $case_type = '';
                        if ($row5['ref_court'] == '4') {

                            $builder6 = $this->db->table("master.casetype");
                            $builder6->select("skey");
                            $builder6->where('display', 'Y');
                            $builder6->where('casecode', $row5['ref_case_type']);
                            $query6 = $builder6->get();
                            $r_case_type = $query6->getResultArray();
                            if (!empty($r_case_type)) {
                                $r_case_type = $r_case_type[0]['skey'];
                            } else {
                                $r_case_type = '-';
                            }
                            $ref_case_type = $r_case_type;
                        } else {

                            $builder6 = $this->db->table("master.lc_hc_casetype");
                            $builder6->select("type_sname skey");
                            $builder6->where('display', 'Y');
                            $builder6->where('lccasecode', $row5['ref_case_type']);
                            $query6 = $builder6->get();
                            $r_case_type = $query6->getResultArray();
                            if (!empty($r_case_type)) {
                                $r_case_type = $r_case_type[0]['skey'];
                            } else {
                                $r_case_type = '-';
                            }
                            $ref_case_type = $r_case_type;
                        }
                    }

                    $relied_court = '';
                    $relied_state = '';
                    $relied_district = '';
                    $relied_case_type = '';
                    if ($row5['relied_court'] != 0) {

                        $builder3 = $this->db->table("master.m_from_court");
                        $builder3->select("court_name");
                        $builder3->where('display', 'Y');
                        $builder3->where('id', $row5['relied_court']);
                        $query3 = $builder3->get();
                        $res_court = $query3->getResultArray();
                        if (!empty($res_court)) {
                            $res_court = $res_court[0]['court_name'];
                        } else {
                            $res_court = '-';
                        }
                        $relied_court = $res_court;


                        $builder4 = $this->db->table("master.state");
                        $builder4->select("name");
                        $builder4->where('display', 'Y');
                        $builder4->where('id_no', $row5['relied_state']);
                        $query4 = $builder4->get();
                        $res_state = $query4->getResultArray();
                        if (!empty($res_state)) {
                            $res_state = $res_state[0]['name'];
                        } else {
                            $res_state = '-';
                        }
                        $relied_state = $res_state;

                        if ($row5['relied_court'] == '3') {

                            $builder5 = $this->db->table("master.state");
                            $builder5->select("name");
                            $builder5->where('display', 'Y');
                            $builder5->where('id_no', $row5['relied_district']);
                            $query5 = $builder5->get();
                            $res_district = $query5->getResultArray();
                            if (!empty($res_district)) {
                                $res_district = $res_district[0]['name'];
                            } else {
                                $res_district = '-';
                            }
                            $relied_district = $res_district;
                        } else {

                            $builder5 = $this->db->table("master.ref_agency_code");
                            $builder5->select("agency_name");
                            $builder5->where('is_deleted', 'f');
                            $builder5->where('id', $row5['relied_district']);
                            $query5 = $builder5->get();
                            $res_district = $query5->getResultArray();
                            if (!empty($res_district)) {
                                $res_district = $res_district[0]['agency_name'];
                            } else {
                                $res_district = '-';
                            }
                            $relied_district = $res_district;
                        }

                        $case_type = '';
                        if ($row5['relied_court'] == '4') {

                            $builder6 = $this->db->table("master.casetype");
                            $builder6->select("skey");
                            $builder6->where('display', 'Y');
                            $builder6->where('casecode', $row5['relied_case_type']);
                            $query6 = $builder6->get();
                            $r_case_type = $query6->getResultArray();
                            if (!empty($r_case_type)) {
                                $r_case_type = $r_case_type[0]['skey'];
                            } else {
                                $r_case_type = '-';
                            }
                            $relied_case_type = $r_case_type;
                        } else {

                            $builder6 = $this->db->table("master.lc_hc_casetype");
                            $builder6->select("type_sname skey");
                            $builder6->where('display', 'Y');
                            $builder6->where('lccasecode', $row5['relied_case_type']);
                            $query6 = $builder6->get();
                            $r_case_type = $query6->getResultArray();
                            if (!empty($r_case_type)) {
                                $r_case_type = $r_case_type[0]['skey'];
                            } else {
                                $r_case_type = '-';
                            }
                            $relied_case_type = $r_case_type;
                        }
                    }

                    $transfer_court = '';
                    $transfer_state = '';
                    $transfer_district = '';
                    $transfer_case_type = '';
                    if ($row5['transfer_state'] != NULL && $row5['transfer_state'] != 0 && $row5['transfer_state'] != '') {

                        $builder3 = $this->db->table("master.m_from_court");
                        $builder3->select("court_name");
                        $builder3->where('display', 'Y');
                        $builder3->where('id', $row5['transfer_court']);
                        $query3 = $builder3->get();
                        $res_court = $query3->getResultArray();
                        if (!empty($res_court)) {
                            $res_court = $res_court[0]['court_name'];
                        } else {
                            $res_court = '-';
                        }
                        $transfer_court = $res_court;


                        $builder4 = $this->db->table("master.state");
                        $builder4->select("name");
                        $builder4->where('display', 'Y');
                        $builder4->where('id_no', $row5['transfer_state']);
                        $query4 = $builder4->get();
                        $res_state = $query4->getResultArray();
                        if (!empty($res_state)) {
                            $res_state = $res_state[0]['name'];
                        } else {
                            $res_state = '-';
                        }
                        $transfer_state = $res_state;

                        if ($row5['transfer_court'] == '3') {

                            $builder5 = $this->db->table("master.state");
                            $builder5->select("name");
                            $builder5->where('display', 'Y');
                            $builder5->where('id_no', $row5['transfer_district']);
                            $query5 = $builder5->get();
                            $res_district = $query5->getResultArray();
                            if (!empty($res_district)) {
                                $res_district = $res_district[0]['name'];
                            } else {
                                $res_district = '-';
                            }
                            $transfer_district = $res_district;
                        } else {

                            $builder5 = $this->db->table("master.ref_agency_code");
                            $builder5->select("agency_name");
                            $builder5->where('is_deleted', 'f');
                            $builder5->where('id', $row5['transfer_district']);
                            $query5 = $builder5->get();
                            $res_district = $query5->getResultArray();
                            if (!empty($res_district)) {
                                $res_district = $res_district[0]['agency_name'];
                            } else {
                                $res_district = '-';
                            }
                            $transfer_district = $res_district;
                        }

                        $case_type = '';
                        if ($row5['transfer_court'] == '4') {

                            $builder6 = $this->db->table("master.casetype");
                            $builder6->select("skey");
                            $builder6->where('display', 'Y');
                            $builder6->where('casecode', $row5['transfer_case_type']);
                            $query6 = $builder6->get();
                            $r_case_type = $query6->getResultArray();
                            if (!empty($r_case_type)) {
                                $r_case_type = $r_case_type[0]['skey'];
                            } else {
                                $r_case_type = '-';
                            }
                            $transfer_case_type = $r_case_type;
                        } else {

                            $builder6 = $this->db->table("master.lc_hc_casetype");
                            $builder6->select("type_sname skey");
                            $builder6->where('display', 'Y');
                            $builder6->where('lccasecode', $row5['transfer_case_type']);
                            $query6 = $builder6->get();
                            $r_case_type = $query6->getResultArray();
                            if (!empty($r_case_type)) {
                                $r_case_type = $r_case_type[0]['skey'];
                            } else {
                                $r_case_type = '-';
                            }
                            $transfer_case_type = $r_case_type;
                        }
                    }

                    $gov_not_state_id = '';
                    $gov_not_case_type = '';
                    $gov_not_case_no = '';
                    $gov_not_case_year = '';
                    $gov_not_date = '';
                    if ($row5['gov_not_state_id'] != 0) {

                        $builder4 = $this->db->table("master.state");
                        $builder4->select("name");
                        $builder4->where('display', 'Y');
                        $builder4->where('id_no', $row5['gov_not_state_id']);
                        $query4 = $builder4->get();
                        $res_state = $query4->getResultArray();
                        if (!empty($res_state)) {
                            $res_state = $res_state[0]['name'];
                        } else {
                            $res_state = '-';
                        }
                        $gov_not_state_id = $res_state;

                        if ($row5['gov_not_case_type'] == '') {
                            $gov_not_case_type = '';
                        } else {
                            $gov_not_case_type = $row5['gov_not_case_type'];
                        }

                        if ($row5['gov_not_case_no'] == 0) {
                            $gov_not_case_no = '';
                        } else {
                            $gov_not_case_no = $row5['gov_not_case_no'];
                        }

                        if ($row5['gov_not_case_year'] == 0) {
                            $gov_not_case_year = '';
                        } else {
                            $gov_not_case_year = $row5['gov_not_case_year'];
                        }

                        if ($row5['gov_not_date'] == '0000-00-00') {
                            $gov_not_date = '-';
                        } else {
                            $gov_not_date = date('d-m-Y', strtotime($row5['gov_not_date']));
                        }
                    }

                    $l_inddep = '';
                    if ($row5['l_inddep'] == 'D1') {
                        $l_inddep = "State Department";
                    } else if ($row5['l_inddep'] == 'D2') {
                        $l_inddep = "Central Department";
                    } else if ($row5['l_inddep'] == 'D3') {
                        $l_inddep = "Other Organisation";
                    } else if ($row5['l_inddep'] == 'X') {
                        $l_inddep = "Xtra";
                    }

                    $l_inddepx = '';
                    if ($row5['l_inddep'] == 'X') {
                        $l_inddepx = $row5['l_iopbn'];
                    } else {
                        $l_inddepx = $row5['authdesc'];
                    }

                    $is_order_challenged = '';
                    if ($row5['is_order_challenged'] == 'Y') {
                        $is_order_challenged = "Yes";
                    } else if ($row5['is_order_challenged'] == 'N') {
                        $is_order_challenged = "No";
                    }

                    $full_interim_flag = '';
                    if ($row5['full_interim_flag'] == 'I') {
                        $full_interim_flag = 'Interim';
                    } else  if ($row5['full_interim_flag'] == 'F') {
                        $full_interim_flag = 'Final';
                    } else {
                        $full_interim_flag = '-';
                    }

                    $ct_code = '';
                    if ($row5['ct_code'] == '4') {
                        $ct_code = "Supreme Court";
                    } else  if ($row5['ct_code'] == '1') {
                        $ct_code = "High Court";
                    } else  if ($row5['ct_code'] == '3') {
                        $ct_code = "District Court";
                    } else  if ($row5['ct_code'] == '2') {
                        $ct_code = "Other";
                    } else  if ($row5['ct_code'] == '5') {
                        $ct_code = "State Agency";
                    }

                    $lct_dec_dt = '';
                    if ($row5['lct_dec_dt'] == '1970-01-01' || $row5['lct_dec_dt'] == '0000-00-00') {
                        $lct_dec_dt = '';
                    } else {
                        $lct_dec_dt = $row5['lct_dec_dt'] != '' ? date('d-m-Y', strtotime($row5['lct_dec_dt'])) : '';
                    }

                    $cnr_no = '';
                    if ($row5['cnr_no'] != '') {
                        $cnr_no = ' / ';
                    } else {
                        $cnr_no = $row5['cnr_no'];
                    }

                    $datrs14[] = [
                        'cnr_no' => $cnr_no,
                        'lct_dec_dt' => $lct_dec_dt,
                        'ct_code' => $ct_code,
                        'full_interim_flag' => $full_interim_flag,
                        'is_order_challenged' => $is_order_challenged,
                        'l_inddepx' => $l_inddepx,
                        'l_inddep' => $l_inddep,
                        'gov_not_state_id' => $gov_not_state_id,
                        'gov_not_case_type' => $gov_not_case_type,
                        'gov_not_case_no' => $gov_not_case_no,
                        'gov_not_case_year' => $gov_not_case_year,
                        'gov_not_date' => $gov_not_date,
                        'transfer_court' => $transfer_court,
                        'transfer_state' => $transfer_state,
                        'transfer_district' => $transfer_district,
                        'transfer_case_type' => $transfer_case_type,
                        'relied_court' => $relied_court,
                        'relied_state' => $relied_state,
                        'relied_district' => $relied_district,
                        'relied_case_type' => $relied_case_type,
                        'ref_court' => $ref_court,
                        'ref_state' => $ref_state,
                        'ref_district' => $ref_district,
                        'ref_case_type' => $ref_case_type,
                        'jud_name' => $jud_name,
                        'transfer_case_no' => $row5['transfer_case_no'],
                        'transfer_case_year' => $row5['transfer_case_year'],
                        'relied_case_no' => $row5['relied_case_no'],
                        'relied_case_year' => $row5['relied_case_year'],
                        'ref_case_no' => $row5['ref_case_no'],
                        'ref_case_year' => $row5['ref_case_year'],
                        'auth_org' => $row5['l_orgname'] . '/' . $row5['l_ordchno'],
                        'judgement_covered_in' => $row5['judgement_covered_in'],
                        'code_vehicle_no' => $row5['code'] . ' ' . $row5['vehicle_no'],
                        'name' => $row5['name'],
                        'agency_name' => $row5['agency_name'],
                        'type_sname_lct_caseno' => $row5['type_sname'] . '-' . $row5['lct_caseno'] . '-' . $row5['lct_caseyear'],
                        'policestndesc' => $row5['policestndesc'],
                        'crime_desc' => $row5['crimeno'] . ' / ' . $row5['crimeyear'],
                        'post_name' => $row5['post_name']
                    ];
                }
                $datares['get_EarlierCourt'] = $datrs14;
            }
        } else {
            $datares['chk_avl'] = "Record Not Available";
        }


        return $datares;
    }

    public function get_sections_by_act($data)
    {
        $act = !empty($data['act_id']) ? $data['act_id'] : NULL;
        $data = array();
        if (isset($act) && !empty($act)) {
            $builder1 = $this->db->table("master.act_section");
            $builder1->select("act_id as id,section");
            $builder1->where('act_id', '846'); 
            $builder1->where('display', 'Y');
            $builder1->where('section !=', '');
            $builder1->where('section is NOT NULL', NULL, FALSE);
            $query1 = $builder1->get();
            $res = $query1->getResultArray();

            if (count($res) > 0) {
                $options = '';
                $options .= '<option value="0" onclick="return selectDeselectAll(true)">Select Section</option>';
                foreach ($res as $result) {
                    $options .= '<option value="' . $result['id'] . '#' . $result['section'] . '">' . $result['section'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_sub_category_by_main_catId($data)
    {
        $mainCategory = !empty($data['mainCategory']) ? $data['mainCategory'] : NULL;
        $data = array();
        if (isset($mainCategory) && !empty($mainCategory))
        {
            $builder1 = $this->db->table('master.submaster');
            $builder1->select("id, subcode1, category_sc_old, sub_name1, sub_name4,
                CASE WHEN category_sc_old IS NOT NULL AND category_sc_old != '' AND category_sc_old != 0 THEN
                        CONCAT('', category_sc_old, '#-#', sub_name4)
                    ELSE
                        CONCAT('', CONCAT(subcode1, '', subcode2), '#-#', sub_name4)
                END AS dsc", false);
            $builder1->where('subcode1', $mainCategory);
            $builder1->where('id_sc_old !=', 0);
            $builder1->where('flag', 's');
            $builder1->whereIn('flag_use', ['S', 'L']);
            $builder1->groupBy('id, subcode1, category_sc_old, sub_name1, sub_name4');
            $query1 = $builder1->get();
            $res = $query1->getResultArray();


            if (count($res) > 0) {
                $options = '';
                $options .= '<option value="0" onclick="return selectDeselectAll(true)">Select Subject Category</option>';
                foreach ($res as $result) {
                    $options .= '<option value="' . $result['id'] . '">' . $result['dsc'] . '</option>';
                }
            }
        }
        echo $options;
    }

    public function physical_verification_data_updation($data)
    {

        $form_data = json_decode($data['form_data'], true);
        $main_condition = $diary_no = $diary_date = $leave_grant_date = $case_group = $party_ids = $history_backup = $history_ids = $subject_category = $act = $section = '';
        $orderdt_m_list = [];
        $gender_m_list = [];
        $age_m_list = [];
        $ucode =  $_SESSION['login']['usercode'];
        $ip_address = $_SERVER['REMOTE_ADDR'];
      
        foreach ($form_data as $form_element) {
            $counter = 0;
            if ($form_element['name'] == 'valid_dno') {
                $diary_no = $form_element['value'];
            } else if ($form_element['name'] == 'ddt') {
                $diary_date = $form_element['value'];
            } else if ($form_element['name'] == 'fhdt') {
                $leave_grant_date = $form_element['value'];
            } else if ($form_element['name'] == 'case_group') {
                $case_group = $form_element['value'];
            } else if ($form_element['name'] == 'categoryCode') {
                $subject_category = $form_element['value'];
            } else if ($form_element['name'] == 'section') {
                $act_array = $form_element['value'];
                $act_values = explode('#', $act_array);
                $act = $act_values[0];
                $section = $act_values[1];
            } else {
                $form_element1 = '';
                $form_element1 = explode("_", $form_element['name']);
                $orderdt_count = 0;

                if ($form_element1[0] == 'orderdt') {
                    $orderdt_list = array_merge($form_element1, array('table_id' => $form_element1[1], 'value' => $form_element['value']));
                    array_push($orderdt_m_list, $orderdt_list);
                    $history_ids .= $form_element1[1] . ',';
                    $orderdt_count = $orderdt_count + 1;
                }
            }
        }

        $ddt = explode("-", $diary_date);
        $ddt = $ddt[2] . "-" . $ddt[1] . "-" . $ddt[0];

        if ($leave_grant_date != '') {
            $leave_date = explode("/", $leave_grant_date);
            $reg_year = $leave_date[2];
            $leave_date = $leave_date[2] . "-" . $leave_date[1] . "-" . $leave_date[0];
        }


        $history_ids = rtrim($history_ids, ',');

        $builder1 = $this->db->table("main");
        $builder1->select("*");
        $builder1->where('diary_no', $diary_no);
        $query1 = $builder1->get();
        $row_main = $query1->getResultArray();
        if (!empty($row_main)) {
            $row_main = $row_main[0];
        }

        $builder5 = $this->db->table('main');
        $builder5->select('*');
        $builder5->where('diary_no', $diary_no);
        $rlts = $builder5->get()->getResultArray();
        if (!empty($rlts)) {
            $result_backup_main = $this->db->table('main_backup_data_correction')->insertBatch($rlts);
        }


        if (!empty($history_ids)) {
            $history_ids = explode(',', $history_ids);

            $builder4 = $this->db->table("main_casetype_history");
            $builder4->select("*");
            $builder4->whereIn('id', $history_ids);
            $query4 = $builder4->get();
            $row_history = $query4->getResultArray();
            if (!empty($row_history)) {
                $row_history = $row_history[0];
            }

            $builder6 = $this->db->table('main_casetype_history');
            $builder6->select('*');
            $builder6->whereIn('id', $history_ids);
            $rlts = $builder6->get()->getResultArray();
            if (!empty($rlts)) {
                $result_backup_history = $this->db->table('main_casetype_history_backup_data_correction')->insertBatch($rlts);
                if (!empty($result_backup_history)) {
                    $history_backup = 1;
                } else {
                    $history_backup = 0;
                }
            }
        } else {
            $history_backup = 1;
        }

        if (!empty($result_backup_main) && $history_backup == 1) {
            $dataUp = [];
            if (!empty($ddt) && date($row_main['diary_no_rec_date']) != $ddt) {
               $dataUp[] = [
                    'diary_no_rec_date' => $ddt
                ];
            }
            if (!empty($case_group) && $row_main['case_grp'] != $case_group) {
               $dataUp[] = [
                    'case_grp' => $case_group
                ];
            }
            if (!empty($leave_date)) {
                if ($row_main['fil_dt_fh'] != null || $row_main['fil_dt_fh'] != '') {
                    if (date($row_main['fil_dt_fh']) != $leave_date) {
                        $dataUp[] = [
                            'fil_dt_fh' => $leave_date,
                            'reg_year_fh' => $reg_year
                        ];
                    }
                }
            }

            $dataUp = !empty($dataUp) ? array_merge(...$dataUp) : [];
           

            $builder3 = $this->db->table("main");
            $builder3->where('diary_no', $diary_no);
            $builder3->update($dataUp);
            foreach ($orderdt_m_list as $case_history) {
                $order_date = explode("-", $case_history['value']);
                $order_date = $order_date[2] . "-" . $order_date[1] . "-" . $order_date[0];
               
                $dataUp1 = [
                    'order_date' => $order_date
                ];
                $builder7 = $this->db->table("main_casetype_history");
                $builder7->where('id', $case_history['table_id']);
                $builder7->update($dataUp1);
            }

            if (!empty($subject_category)) {
              
                $dataUp2 = [
                    'display' => 'N'
                ];
                $builder7 = $this->db->table("mul_category");
                $builder7->where('diary_no', $diary_no);
                $builder7->where('display', 'Y');
                $builder7->update($dataUp2);

                $insert_category_data = [
                    'diary_no' => $diary_no,
                    'submaster_id' => $subject_category,
                    'display' => 'Y',
                    'mul_cat_user_code' => $ucode,
                    'e_date' => 'NOW()',
                ];
                $builder8 = $this->db->table("mul_category");
                $builder8->insert($insert_category_data);
            }
            if (!empty($act)) {

                $insert_act_data = [
                    'act' => $act,
                    'entdt' => 'NOW()',
                    'user' => $ucode,
                    'diary_no' => $diary_no
                ];
                $builder9 = $this->db->table("act_main");
                $builder9->insert($insert_act_data);
                $act_id = $this->db->insertID();

                $insert_section_data = [
                    'act_id' => $act_id,
                    'section' => $section,
                    'entdt' => 'NOW()',
                    'user' => $ucode,
                    'display' => 'Y',
                ];
                $builder10 = $this->db->table("master.act_section");
                $builder10->insert($insert_section_data);
            }
            $dataUp4 = [
                'display' => 'N'
            ];
            $builder11 = $this->db->table("physical_verify");
            $builder11->where('diary_no', $diary_no);
            $builder11->update($dataUp4);
            $insert_physical_verify = [
                'diary_no' => $diary_no,
                'ent_dt' => 'NOW()',
                'ucode' => $ucode,
                'avaliable_flag' => 'Y',
                'display' => 'Y',
                'ip_address' => $ip_address
            ];
            $builder12 = $this->db->table("physical_verify");
            $builder12->insert($insert_physical_verify);


            return 1;
        }
    }

    public function wrong_updated_get_response($data)
    {

        $ucode =  $_SESSION['login']['usercode'];
        $diary_no = $data['valid_dno'];
        $ip_address = $_SERVER['REMOTE_ADDR'];
        if (!empty($diary_no)) {
            $dataUp = [
                'display' => 'N'
            ];
            $builder3 = $this->db->table("physical_verify");
            $builder3->where('diary_no', $diary_no);
            $builder3->update($dataUp);
            $insert_physical_verify = [
                'diary_no' => $diary_no,
                'ent_dt' => 'NOW()',
                'ucode' => $ucode,
                'avaliable_flag' => 'N',
                'display' => 'Y',
                'ip_address' => $ip_address,
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => session()->get('login')['usercode'],
                'updated_by_ip' => getClientIP(),
            ];
            $builder12 = $this->db->table("physical_verify");
            $result = $builder12->insert($insert_physical_verify);

            if ($result >= 1) {
                return  'Diary No : ' . $diary_no . ' Updated successfully as not with you';
            } else {
                return 'Error in updation as not with you';
            }
        }
    }
}
