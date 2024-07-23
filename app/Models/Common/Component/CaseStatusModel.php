<?php

namespace App\Models\Common\Component;

use CodeIgniter\Model;

class CaseStatusModel extends Model
{

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
    }


    function get_diary_disposal_date($diary_no)
    {
        $builder = $this->db->table("public.dispose");

        $builder->select("disp_dt");

        $builder->where('diary_no', $diary_no);

        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return json_encode($result);
        } else {
            return false;
        }
    }


    function get_party_details($diary_no, $flag = null)
    {
        $builder1 = $this->db->table("public.party" . $flag . " p");
        $builder1->select("sr_no_show, partyname, prfhname, addr1, addr2, state, city, dstname, pet_res, remark_del, remark_lrs, pflag, partysuff, deptname, ind_dep");

        $builder1->join('master.deptt d', "state_in_name = d.deptcode", 'LEFT');

        $builder1->where('diary_no', $diary_no);
        $builder1->whereNotIn('pflag', ['T', 'Z']);

        $builder1->orderBy("pet_res");
        $builder1->orderBy("CAST(split_part(sr_no_show, '.', 1) AS INTEGER)");
        $builder1->orderBy("CAST(split_part(sr_no_show || '.0', '.', 2) AS INTEGER)");
        $builder1->orderBy("CAST(split_part(sr_no_show || '.0.0', '.', 3) AS INTEGER)");
        $builder1->orderBy("CAST(split_part(sr_no_show || '.0.0.0', '.', 4) AS INTEGER)");

        $query = $builder1->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return json_encode($result);
        } else {
            return false;
        }
    }


    function get_pet_res_advocate($diary_no, $flag = null)
    {
        $builder1 = $this->db->table("public.advocate" . $flag . " a");

        $builder1->select("pet_res_no, adv, advocate_id, pet_res, is_ac, if_aor, if_sen, if_other, name, enroll_no, enroll_date, isdead");

        $builder1->join('master.bar b', "a.advocate_id = b.bar_id");
        $builder1->where('diary_no', $diary_no);
        $builder1->where('display', 'Y');

        $builder1->orderBy("pet_res");

        $query = $builder1->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_old_category($diary_no, $flag = null)
    {

        $builder1 = $this->db->table("public.mul_category" . $flag . " mc");

        $builder1->select("s.*");

        $builder1->join('master.submaster s', "mc.submaster_id = s.id");

        $builder1->where('diary_no', $diary_no);
        $builder1->where('mc.display', 'Y');

        $query = $builder1->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_new_category($diary_no, $flag = null)
    {

        $builder1 = $this->db->table("public.mul_category" . $flag . " mc");

        $builder1->select("s.*");

        $builder1->join('master.submaster s', "mc.new_submaster_id = s.id");

        $builder1->where('diary_no', $diary_no);
        $builder1->where('mc.display', 'Y');

        $query = $builder1->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_defect_days($diary_no, $flag = null)
    {
        $builder = $this->db->table("public.obj_save" . $flag . " obj")
            ->select('(CURRENT_DATE - date(save_dt)) as no_of_days')
            ->join("public.main" . $flag . " m", "obj.diary_no = m.diary_no", 'left')
            ->where('obj.diary_no', $diary_no)
            ->where('rm_dt IS NULL')
            ->where('date(m.diary_no_rec_date) >', '2018-10-14')
            ->where('obj.display', 'Y');

        $query = $this->db->newQuery()
            ->select('max(no_of_days) as no_of_days')
            ->fromSubquery($builder, 'a')
            ->get();


        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return json_encode($result[0]);
        } else {
            return false;
        }
    }

    function get_recalled_matters($diary_no)
    {
        $builder = $this->db->table("public.recalled_matters");
        $builder->select('*');
        $builder->where('diary_no', $diary_no);
        $builder->where('court_or_user', 'C');
        $query = $builder->get();
        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_consignment_status($diary_no, $flag = null)
    {
        $builder = $this->db->table('public.record_keeping')
            ->select('diary_no, DATE(consignment_date) AS consignment_date')
            ->where('diary_no', $diary_no)
            ->where('display', 'Y')
            ->where('consignment_status', 'Y');

        $builder2 = $this->db->table('public.fil_trap_his' . $flag)
            ->select('diary_no, DATE(rece_dt) AS consignment_date')
            ->where('diary_no', $diary_no)
            ->where('remarks', 'DISPOSAL -> RR-DA');

        $builder3 = $this->db->table('public.fil_trap' . $flag)
            ->select('diary_no, DATE(rece_dt) AS consignment_date')
            ->where('diary_no', $diary_no)
            ->where('remarks', 'RR-DA -> SEG-DA');

        $query = $builder->union($builder2)->union($builder3)->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_sensitive_cases($diary_no)
    {
        $builder = $this->db->table('public.sensitive_cases')
            ->select('diary_no')
            ->where('diary_no', $diary_no)
            ->where('display', 'Y');

        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_efiled_cases($diary_no)
    {
        $builder = $this->db->table('public.efiled_cases')
            ->select('*')
            ->where('diary_no', $diary_no)
            ->where('display', 'Y')
            ->where('efiled_type', 'new_case');

        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_heardt_case($diary_no, $flag = null)
    {

        $query1 = $this->db->table('public.heardt' . $flag)
            ->select("next_dt as next_dt, clno, brd_slno AS brdslno, judges, subhead, mainhead, 'H' AS tbl, diary_no AS filno, null AS benchflag, next_dt AS next_dt_o, main_supp_flag, roster_id, CAST(board_type AS TEXT) as board_type, tentative_cl_dt")
            ->where('diary_no', $diary_no)
            ->where('next_dt IS NOT NULL');

        $query2 = $this->db->table('public.last_heardt' . $flag)
            ->select("next_dt as next_dt, clno, 0 AS brdslno, judges, subhead, mainhead, 'L' AS tbl, diary_no AS filno, bench_flag AS benchflag, next_dt AS next_dt_o, main_supp_flag, roster_id, CAST(board_type AS TEXT) as board_type, tentative_cl_dt")
            ->where('diary_no', $diary_no)
            ->groupStart()
            ->where('bench_flag is null')
            ->orWhere('bench_flag', '')
            ->orWhere('bench_flag', 'W')
            ->groupEnd()
            ->where('next_dt IS NOT NULL');

        $unionResult = $query1->union($query2);

        $finalQuery = $this->db->newQuery()
            ->select("t1.*, 
            (CASE 
                WHEN t1.tbl = 'H' THEN 
                    (CASE 
                        WHEN t1.main_supp_flag IN (1, 2) THEN 'L' 
                        ELSE 'P' 
                    END) 
                ELSE 
                    (CASE 
                        WHEN t1.main_supp_flag IN (1, 2) THEN 'L' 
                        ELSE 'P' 
                    END) 
            END) AS porl")
            ->fromSubquery($unionResult, 't1')
            ->orderBy('t1.tbl, t1.next_dt_o DESC')
            ->get();

        if ($finalQuery->getNumRows() >= 1) {
            $result = $finalQuery->getResultArray();
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_case_type_history($diary_no, $flag = null)
    {
        $query = $this->db->table('public.main_casetype_history' . $flag)
            ->select("date(order_date) as orderdt, date(updated_on) as updated")
            ->whereIn('ref_new_case_type_id', [3, 4])
            ->where('diary_no', $diary_no)
            ->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_recalled_by($diary_no)
    {
        $builder1 = $this->db->table("public.recalled_matters rm");

        $builder1->select("u.name, us.section_name, rm.updated_on");

        $builder1->join('master.users u', "rm.updated_by=u.usercode");

        $builder1->join('master.usersection us', "us.id=u.section");

        $builder1->where('rm.diary_no', $diary_no);

        $query = $builder1->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_fill_dt_case($diary_no, $flag = null)
    {
        $builder1 = $this->db->table("public.main" . $flag . " a");

        $builder1->select("fil_dt, 
        CASE WHEN last_dt IS NULL THEN NULL ELSE last_dt END AS last_dt, 
        a.usercode, 
        CASE WHEN last_usercode IS NULL THEN NULL ELSE last_usercode END AS last_usercode, 
        u.name AS user, 
        c.name AS last_u");

        $builder1->join('master.users u', "a.usercode = u.usercode", 'left');
        $builder1->join('master.users c', "a.last_usercode = c.usercode", 'left');

        $builder1->where('a.diary_no', $diary_no);

        $query = $builder1->get(1);

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray()[0];
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_diary_section_details($diary_no, $flag = null)
    {
        $builder1 = $this->db->table("public.main" . $flag . " a");

        $builder1->select("a.usercode, b.name, us.section_name");

        $builder1->join('master.users b', "a.diary_user_id = b.usercode", 'left');
        $builder1->join('master.usersection us', "b.section = us.id", 'left');

        $builder1->where('a.diary_no', $diary_no);

        $query = $builder1->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return json_encode($result[0]);
        } else {
            return false;
        }
    }

    function get_autodiary_details($diary_no)
    {
        $builder1 = $this->db->table("public.efiled_cases");

        $builder1->select("diary_no");

        $builder1->where('diary_no', $diary_no);
        $builder1->where('display', 'Y');
        $builder1->where('efiled_type', 'new_case');


        $builder1->groupStart()
            ->where('created_by', 10531)
            ->orWhere('date(created_at) >', '2023-07-19')
            ->groupEnd();

        $query = $builder1->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_fil_trap_details($diary_no, $flag = null)
    {
        $filing_stage = "";
        $get_fil_trap = is_data_from_table('public.fil_trap' . $flag, ['diary_no' => $diary_no], 'remarks', 'R');

        if (!empty($get_fil_trap)) {
            $stagerow = $get_fil_trap['remarks'];
            if ($stagerow == 'FIL -> DE') {
                $filing_stage = "Case is Diarized and Pending for Data Entry!!";
            } elseif ($stagerow == 'DE -> SCR') {
                $filing_stage = "Case is Pending for Scrutiny";
            } elseif ($stagerow == 'FDR -> SCR') {
                $builder = $this->db->table('public.fil_trap' . $flag)->select('remarks');
                $builder->where('diary_no', $diary_no)->where('remarks', 'SCR -> FDR');

                $builder2 = $this->db->table('public.fil_trap_his' . $flag)->select('remarks');
                $builder2->where('diary_no', $diary_no)->where('remarks', 'SCR -> FDR');

                $unionResult = $builder->unionAll($builder2)->get();

                if ($unionResult->getNumRows() == 1) {
                    $filing_stage = "Defects Notified & Returned";
                } elseif ($unionResult->getNumRows() > 1) {
                    $filing_stage = "Still Defective & Returned";
                }
            } elseif ($stagerow == 'SCR -> CAT' || $stagerow == 'CAT -> TAG' || $stagerow == 'AUTO -> TAG') {
                $builder = $this->db->table('public.main' . $flag . ' m')->select('m.*');
                $builder->join('obj_save AS o', 'm.diary_no = o.diary_no', 'left');
                $builder->where('m.diary_no', $diary_no);
                $builder->groupStart()->groupStart()->where('org_id', '10193')->where('display', 'Y')->where('rm_dt is not null')->groupEnd()->orWhere('display', null)->groupEnd()->groupStart()->where('m.ack_id', null)->orWhere('m.ack_id', 0)->groupEnd();

                $query = $builder->get();

                if ($query->getNumRows() == 0) {
                    $filing_stage = "Soft Copy not Filed";
                } else {
                    $verify_rs = is_data_from_table('public.defects_verification' . $flag, ['diary_no' => $diary_no, 'verification_status' => 0], '*');
                    if (empty($verify_rs)) {
                        $filing_stage = "Case is Pending for Verification";
                    }
                }
            } elseif ($stagerow == 'TAG -> IB-Ex' || $stagerow == 'CAT -> IB-Ex') {
                $filing_stage = "Case is Listed/Ready for Listing";
            }
        }

        $get_case_type = is_data_from_table('public.main' . $flag, ['diary_no' => $diary_no], 'casetype_id', 'R');
        if (!empty($get_case_type)) {
            $casetype_id = $get_case_type['casetype_id'];

            $section_casetypes = array(11, 12, 19, 25, 26, 9, 10, 39);
            if (in_array($casetype_id, $section_casetypes)) {
                $t_section = is_data_from_table('public.main' . $flag, ['diary_no' => $diary_no], 'tentative_section(diary_no) as section', 'R');
                if (!empty($t_section)) {
                    $sec = $t_section['section'];
                    $filing_stage = "Pending in Section: " . $sec;
                }
            }
        }
        return json_encode($filing_stage);
    }

    function get_acts_sections_details($diary_no)
    {
        $builder = $this->db->table('public.act_main as a');
        $builder->select('a.act, b.act_name, array_agg(c.section ORDER BY c.section) as sections');
        $builder->join('master.act_master as b', "(a.act = b.id AND b.display = 'Y')");
        $builder->join('master.act_section as c', "(c.act_id = a.id AND c.display = 'Y')", "left");
        $builder->where('diary_no', $diary_no);
        $builder->groupBy("a.act, b.act_name");
        $builder->orderBy('b.act_name');
        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            foreach ($result as &$row) {
                $row['sections'] = implode(', ', $row['sections']);
            }
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_IB_DA_Details($diary_no, $flag)
    {
        $unionQuery = $this->db
            ->table('public.fil_trap_his' . $flag)
            ->select('d_to_empid, diary_no')
            ->where('diary_no', $diary_no)
            ->where('remarks', 'CAT -> IB-Ex');

        $builder = $this->db
            ->table('public.fil_trap' . $flag)
            ->select('d_to_empid, diary_no')
            ->union($unionQuery);

        $query = $this->db
            ->newQuery()
            ->select("f.d_to_empid, u.name, us.section_name")
            ->fromSubquery($builder, 'f')
            ->join('master.users as u', 'f.d_to_empid = u.empid')
            ->join('master.usersection us', 'u.section = us.id')
            ->where('f.diary_no', $diary_no)
            ->whereIn('us.id', [19, 77])
            ->get(1);

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray()[0];
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_da_section_details($diary_no, $flag = null)
    {
        $builder = $this->db->table("public.main" . $flag . " a");
        $builder->select("dacode, name, section_name, casetype_id, active_casetype_id, diary_no_rec_date, reg_year_mh, reg_year_fh, active_reg_year, ref_agency_state_id");
        $builder->join('master.users b', "a.dacode = b.usercode", 'LEFT');
        $builder->join('master.usersection us', "b.section = us.id", "LEFT");
        $builder->where('a.diary_no', $diary_no);
        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getRowArray();
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_tentative_section($diary_no, $flag)
    {
        $builder = $this->db->table("public.main" . $flag);
        $builder->select("tentative_section(:diary_no) as section_name", ['diary_no' => $diary_no]);
        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getRowArray();
            return json_encode($result);
        } else {
            return false;
        }
    }

    function get_cl_printed_data($next_date, $gender, $part, $roster_id)
    {
        $builder = $this->db->table("public.cl_printed");
        $builder->select("*");
        $builder->where('next_dt >= CURRENT_DATE');
        $builder->where('next_dt', $next_date);
        $builder->where('m_f', $gender);
        $builder->where('part', $part);
        $builder->where('roster_id', $roster_id);
        $builder->where('display', 'Y');
        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            return 'Y';
        } else {
            return 'N';
        }
    }

    function get_file_movement_data($diary_no, $flag = null)
    {
        $builder1 = $this->db->table('public.fil_trap' . $flag);
        $builder1->select('diary_no, d_by_empid, disp_dt, remarks, r_by_empid, d_to_empid, rece_dt, comp_dt, other');
        $builder1->where('diary_no', $diary_no);

        $builder2 = $this->db->table('public.fil_trap_his' . $flag);
        $builder2->select('diary_no, d_by_empid, disp_dt, remarks, r_by_empid, d_to_empid, rece_dt, comp_dt, other');
        $builder2->where('diary_no', $diary_no);
        $builder2->where("comp_dt = (SELECT MAX(comp_dt) FROM fil_trap" . $flag . ")");

        $unionResult = $builder1->union($builder2);

        $query = $this->db->query("SELECT a.*, u1.name AS d_by_name, u2.name AS r_by_name, u3.name AS o_name, u4.name AS d_to_name FROM (" . $unionResult->getCompiledSelect() . ") a LEFT JOIN master.users u1 ON a.d_by_empid = u1.empid LEFT JOIN master.users u2 ON a.r_by_empid = u2.empid LEFT JOIN master.users u3 ON a.other = u3.empid LEFT JOIN master.users u4 ON a.d_to_empid = u4.empid ORDER BY a.disp_dt DESC, a.rece_dt DESC");

        if ($query->num_rows() >= 1) {
            return json_encode($query->result_array());
        } else {
            return false;
        }
    }


    function getEarlierCourtData($diary_no, $flag)
    {
        $builder = $this->db->table("public.lowerct" . $flag . " as a");
        $builder->select('casetype_id, lct_dec_dt, lct_judge_name, lctjudname2, lctjudname3, l_dist, ct_code, l_state, name, brief_desc AS desc1, sub_law AS usec2, lct_judge_desg');
        $builder->select("CASE 
            WHEN ct_code = 3 THEN 
                (CASE 
                    WHEN l_state = 490506 THEN 
                        (SELECT court_name FROM master.state s 
                            LEFT JOIN master.delhi_district_court d ON s.state_code = d.state_code AND s.district_code = d.district_code 
                            WHERE s.id_no = a.l_dist AND s.display = 'Y') 
                    ELSE 
                        (SELECT name FROM master.state s WHERE s.id_no = a.l_dist AND s.display = 'Y') 
                END) 
            ELSE 
                (SELECT agency_name FROM master.ref_agency_code c 
                    WHERE c.cmis_state_id = a.l_state AND c.id = a.l_dist AND c.is_deleted = 'f') 
        END AS agency_name", false);
        $builder->select('crimeno, crimeyear, polstncode');
        $builder->select("(SELECT policestndesc FROM master.police p 
                        WHERE p.policestncd = a.polstncode AND p.display = 'Y' AND p.cmis_state_id = a.l_state AND p.cmis_district_id = a.l_dist 
                            AND a.crimeno != '' AND a.crimeno != '0') policestndesc", false);
        $builder->select('authdesc, l_inddep, l_orgname, l_ordchno, l_iopb, l_iopbn, l_org, lct_casetype, lct_caseno, lct_caseyear');
        $builder->select("CASE 
            WHEN ct_code = 4 THEN 
                (SELECT skey FROM master.casetype ct WHERE ct.display = 'Y' AND ct.casecode = a.lct_casetype) 
            ELSE 
                (SELECT type_sname FROM master.lc_hc_casetype d WHERE d.lccasecode = a.lct_casetype AND d.display = 'Y') 
        END AS type_sname", false);
        $builder->select('a.lower_court_id, is_order_challenged, full_interim_flag, judgement_covered_in, vehicle_code, vehicle_no, code, post_name, cnr_no, ref_court, ref_case_type, ref_case_no, ref_case_year, ref_state, ref_district, gov_not_state_id, gov_not_case_type, gov_not_case_no, gov_not_case_year, gov_not_date, relied_court, relied_case_type, relied_case_no, relied_case_year, relied_state, relied_district, transfer_case_type, transfer_case_no, transfer_case_year, transfer_state, transfer_district, transfer_court');
        $builder->join('master.state b', 'a.l_state = b.id_no AND b.display = \'Y\'', 'left');
        $builder->join('public.main' . $flag . ' e', 'e.diary_no = a.diary_no');
        $builder->join('master.authority f', 'f.authcode = a.l_iopb AND f.display = \'Y\'', 'left');
        $builder->join('master.rto h', 'h.id = a.vehicle_code AND h.display = \'Y\'', 'left');
        $builder->join('master.post_t i', 'i.post_code = a.lct_judge_desg AND i.display = \'Y\'', 'left');
        $builder->join('public.relied_details rd', 'rd.lowerct_id = a.lower_court_id AND rd.display = \'Y\'', 'left');
        $builder->join('public.transfer_to_details t_t', 't_t.lowerct_id = a.lower_court_id AND t_t.display = \'Y\'', 'left');
        $builder->where('a.diary_no', $diary_no);
        $builder->where('a.lw_display', 'Y');
        $builder->orderBy('a.lower_court_id');

        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return json_encode($result);
        } else {
            return false;
        }
    }

    function allTransferDetailsByDiaryNo($diary_no, $flag)
    {
        $builder = $this->db->table("public.lowerct" . $flag . " as a");
        $builder->select([
            'a.lower_court_id',
            't.transfer_court',
            't.transfer_case_type',
            'a.name',
            '(CASE 
            WHEN t.transfer_court = 3 THEN 
                (CASE 
                    WHEN t.transfer_state = 490506 THEN 
                        (SELECT court_name FROM master.state s 
                            LEFT JOIN master.delhi_district_court d ON s.state_code = d.state_code AND s.district_code = d.district_code 
                            WHERE s.id_no = t.transfer_district AND s.display = \'Y\') 
                    ELSE 
                        (SELECT name FROM master.state s WHERE s.id_no = t.transfer_district AND s.display = \'Y\') 
                END) 
            ELSE 
                (SELECT agency_name FROM master.ref_agency_code c 
                    WHERE c.cmis_state_id = t.transfer_state AND c.id = t.transfer_district AND c.is_deleted = \'f\') 
        END) AS reference_name',
            'CONCAT(
            CASE WHEN t.transfer_court = 4 THEN (SELECT skey FROM master.casetype ct WHERE ct.display = \'Y\' AND ct.casecode = t.transfer_case_type) 
                 ELSE (SELECT type_sname FROM master.lc_hc_casetype d WHERE d.lccasecode = t.transfer_case_type AND d.display = \'Y\') 
            END, \'-\', 
            t.transfer_case_no, \'-\', 
            t.transfer_case_year) AS case_name',
            '(CASE 
            WHEN t.transfer_court = 4 THEN \'Supreme Court\' 
            WHEN t.transfer_court = 1 THEN \'High Court\' 
            WHEN t.transfer_court = 3 THEN \'District Court\' 
            WHEN t.transfer_court = 5 THEN \'State Agency\' 
        END) AS court_name',
        ]);

        $builder->join('public.transfer_to_details t', 't.lowerct_id = a.lower_court_id AND t.display = \'Y\'', 'LEFT');
        $builder->join('master.state b', 't.transfer_state = b.id_no AND b.display = \'Y\'', 'LEFT');

        $builder->where('a.diary_no', $diary_no);
        $builder->where('a.lw_display', 'Y');
        $builder->where('t.transfer_court >=', 1);

        $builder->orderBy('a.lower_court_id');

        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            if (is_array($result)) {
                $data = [];
                foreach ($result as $all_data) {
                    $data[$all_data['lower_court_id']] = $all_data;
                }
                return json_encode($data);
            }
        }

        return false;
    }


    function allReferenceDetailsByDiaryNo($diary_no, $flag)
    {
        $builder = $this->db->table("public.lowerct" . $flag . " as a");
        $builder->select([
            'a.lower_court_id',
            'a.ref_court',
            'a.name',
            '(CASE 
            WHEN a.ref_court = 3 THEN 
                (CASE 
                    WHEN a.ref_state = 490506 THEN 
                        (SELECT court_name FROM master.state s 
                            LEFT JOIN master.delhi_district_court d ON s.state_code = d.state_code AND s.district_code = d.district_code 
                            WHERE s.id_no = a.ref_district AND s.display = \'Y\') 
                    ELSE 
                        (SELECT name FROM master.state s WHERE s.id_no = a.ref_district AND s.display = \'Y\') 
                END) 
            ELSE 
                (SELECT agency_name FROM master.ref_agency_code c 
                    WHERE c.cmis_state_id = a.ref_state AND c.id = a.ref_district AND c.is_deleted = \'f\') 
        END) AS reference_name',
            'CONCAT(
            CASE WHEN a.ref_court = 4 THEN (SELECT skey FROM master.casetype ct WHERE ct.display = \'Y\' AND ct.casecode = a.ref_case_type) 
                 ELSE (SELECT type_sname FROM master.lc_hc_casetype d WHERE d.lccasecode = a.ref_case_type AND d.display = \'Y\') 
            END, \'-\', 
            a.ref_case_no, \'-\', 
            a.ref_case_year) AS case_name',
            '(CASE 
            WHEN a.ref_court = 4 THEN \'Supreme Court\' 
            WHEN a.ref_court = 1 THEN \'High Court\' 
            WHEN a.ref_court = 3 THEN \'District Court\' 
            WHEN a.ref_court = 5 THEN \'State Agency\' 
        END) AS court_name',
        ]);

        $builder->join('master.state b', 'a.ref_state = b.id_no AND b.display = \'Y\'', 'LEFT');

        $builder->where('a.diary_no', $diary_no);
        $builder->where('a.lw_display', 'Y');
        $builder->where('a.ref_court >=', 1);

        $builder->orderBy('a.lower_court_id');

        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            if (is_array($result)) {
                $data = [];
                foreach ($result as $all_data) {
                    $data[$all_data['lower_court_id']] = $all_data;
                }
                return json_encode($data);
            }
        }

        return false;
    }

    function allGovernmentNotificationsByDiaryNo($diary_no, $flag)
    {
        $builder = $this->db->table("public.lowerct" . $flag . " as a");
        $builder->select([
            'a.lower_court_id',
            'a.name',
            'CONCAT(a.gov_not_case_type, \'-\', a.gov_not_case_no, \'-\', a.gov_not_case_year) AS case_name',
            'a.gov_not_date',
        ]);

        $builder->join('master.state b', 'a.gov_not_state_id = b.id_no AND b.display = \'Y\'', 'LEFT');

        $builder->where('a.diary_no', $diary_no);
        $builder->where('a.lw_display', 'Y');
        $builder->where('a.gov_not_state_id >=', 1);
        $builder->orderBy('a.lower_court_id');

        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            if (is_array($result)) {
                $data = [];
                foreach ($result as $all_data) {
                    $data[$all_data['lower_court_id']] = $all_data;
                }
                return json_encode($data);
            }
        }

        return false;
    }

    function allReliedDetailsByDiaryNo($diary_no, $flag)
    {
        $builder = $this->db->table("public.lowerct" . $flag . " as a");
        $builder->select([
            'a.lower_court_id',
            'a.relied_court',
            'a.relied_case_type',
            'a.name',
            '(CASE WHEN a.relied_court = 3 THEN (CASE WHEN rd.relied_state = 490506 THEN (SELECT court_name FROM master.state s LEFT JOIN master.delhi_district_court d ON s.state_code = d.state_code AND s.district_code = d.district_code WHERE s.id_no = rd.relied_district AND s.display = \'Y\') ELSE (SELECT name FROM master.state s WHERE s.id_no = rd.relied_district AND s.display = \'Y\') END) ELSE (SELECT agency_name FROM master.ref_agency_code c WHERE c.cmis_state_id = rd.relied_state AND c.id = rd.relied_district AND c.is_deleted = \'f\') END) AS reference_name',
            'CONCAT(CASE WHEN a.relied_court = 4 THEN (SELECT skey FROM master.casetype ct WHERE ct.display = \'Y\' AND ct.casecode = rd.relied_case_type) ELSE (SELECT type_sname FROM master.lc_hc_casetype d WHERE d.lccasecode = rd.relied_case_type AND d.display = \'Y\') END, \'-\', rd.relied_case_no, \'-\', rd.relied_case_year) AS case_name',
            '(CASE WHEN a.relied_court = 4 THEN \'Supreme Court\' WHEN a.relied_court = 1 THEN \'High Court\' WHEN a.relied_court = 3 THEN \'District Court\' WHEN a.relied_court = 5 THEN \'State Agency\' END) AS court_name',
        ]);

        $builder->join('public.relied_details rd', 'rd.lowerct_id = a.lower_court_id AND rd.display = \'Y\'', 'LEFT');
        $builder->join('master.state b', 'rd.relied_state = b.id_no AND b.display = \'Y\'', 'LEFT');

        $builder->where('a.diary_no', $diary_no);
        $builder->where('a.lw_display', 'Y');
        $builder->where('a.relied_court >=', 1);

        $builder->orderBy('a.lower_court_id');

        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            if (is_array($result)) {
                $data = [];
                foreach ($result as $all_data) {
                    $data[$all_data['lower_court_id']] = $all_data;
                }
                return json_encode($data);
            }
        }

        return false;
    }

    public function getJudgeDetailsByDiary($diary_no, $flag)
    {
        $builder = $this->db->table("public.lowerct" . $flag . " as l");
        $builder->select([
            'l.lower_court_id',
            '(CASE 
            WHEN l.ct_code = 4 THEN (
                SELECT 
                    CASE 
                        WHEN lj.judge_id is not null THEN CONCAT(j.title, \' \', j.first_name, \' \', j.sur_name)
                        ELSE \'\'
                    END          
                FROM master.judge j 
                WHERE lj.judge_id = j.jcode            
            )
            ELSE (
                SELECT 
                    CASE 
                        WHEN lj.judge_id is not null THEN CONCAT(oj.title, \' \', oj.first_name, \' \', oj.sur_name)
                        ELSE \'\'
                    END
                FROM master.org_lower_court_judges oj 
                WHERE lj.judge_id = oj.id           
            )
        END) AS judge_name',
        ]);

        $builder->join('public.lowerct_judges' . $flag . ' as lj', 'l.lower_court_id = lj.lowerct_id', 'LEFT');
        $builder->where('l.diary_no', $diary_no);

        $query = $builder->get();
        $resultJudges = $query->getResultArray();

        if (empty($resultJudges)) {
            return false;
        }

        $resultSet = [];
        foreach ($resultJudges as $jud) {
            $lower_court_id = $jud['lower_court_id'];
            $resultSet[$lower_court_id][] = [
                'judge_name' => $jud['judge_name']
            ];
        }

        return json_encode($resultSet);
    }
}
