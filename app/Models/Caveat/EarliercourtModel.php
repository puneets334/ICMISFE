<?php

namespace App\Models\Caveat;

use CodeIgniter\Model;

class EarlierCourtModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
    }

    public function getAllLowerCourtDetails($caveat_no, $is_archival_table = '')
    {
        $sql = "SELECT 
                a.casetype_id,
                a.lct_dec_dt,
                a.lct_judge_name,
                a.lctjudname2,
                a.lctjudname3,
                a.l_dist,
                a.ct_code,
                a.l_state,
                a.name,
                a.brief_desc AS desc1,
                a.sub_law AS usec2,
                a.lct_judge_desg,
                CASE 
                    WHEN a.ct_code = 3 THEN (
                        CASE 
                            WHEN a.l_state = 490506 THEN (
                                SELECT court_name 
                                FROM master.state s 
                                LEFT JOIN master.delhi_district_court d 
                                ON s.state_code = d.state_code 
                                AND s.district_code = d.district_code 
                                WHERE s.id_no = a.l_dist 
                                AND s.display = 'Y'
                            )
                            ELSE (
                                SELECT Name 
                                FROM master.state s 
                                WHERE s.id_no = a.l_dist 
                                AND s.display = 'Y'
                            )
                        END
                    )
                    ELSE (
                        SELECT agency_name 
                        FROM master.ref_agency_code c 
                        WHERE c.cmis_state_id = a.l_state 
                        AND c.id = a.l_dist 
                        AND c.is_deleted = 'f'
                    )
                END AS agency_name,
                a.crimeno,
                a.crimeyear,
                a.polstncode,
                (
                    SELECT policestndesc 
                    FROM master.police p 
                    WHERE p.policestncd = a.polstncode 
                    AND p.display = 'Y' 
                    AND p.cmis_state_id = a.l_state 
                    AND p.cmis_district_id = a.l_dist
                ) AS policestndesc,
                a.authdesc,
                a.l_inddep,
                a.l_orgname,
                a.l_ordchno,
                a.l_iopb,
                a.l_iopbn,
                a.l_org,
                a.lct_casetype,
                a.lct_caseno,
                a.lct_caseyear,
                CASE 
                    WHEN a.ct_code = 4 THEN (
                        SELECT skey 
                        FROM master.casetype ct 
                        WHERE ct.display = 'Y' 
                        AND ct.casecode = a.lct_casetype
                    )
                    ELSE (
                        SELECT type_sname 
                        FROM master.lc_hc_casetype d 
                        WHERE d.lccasecode = a.lct_casetype 
                        AND d.display = 'Y'
                    )
                END AS type_sname,
                a.lower_court_id,
                a.is_order_challenged,
                a.full_interim_flag,
                a.judgement_covered_in,
                a.vehicle_code,
                a.vehicle_no,
                a.code,
                a.post_name,
                a.cnr_no,
                a.ref_court,
                a.ref_case_type,
                a.ref_case_no,
                a.ref_case_year,
                a.ref_state,
                a.ref_district,
                a.gov_not_state_id,
                a.gov_not_case_type,
                a.gov_not_case_no,
                a.gov_not_case_year,
                a.gov_not_date,
                a.relied_court,
                a.relied_case_type,
                a.relied_case_no,
                a.relied_case_year,
                a.relied_state,
                a.relied_district,
                a.transfer_case_type,
                a.transfer_case_no,
                a.transfer_case_year,
                a.transfer_state,
                a.transfer_district,
                a.transfer_court
            FROM 
                public.caveat_lowerct$is_archival_table AS a
            LEFT JOIN 
                master.state b ON a.l_state = b.id_no AND b.display = 'Y'
            LEFT JOIN 
                caveat$is_archival_table e ON e.caveat_no = a.caveat_no
            LEFT JOIN 
                master.authority f ON f.authcode = a.l_iopb AND f.display = 'Y'
            LEFT JOIN 
                master.rto h ON h.id = a.vehicle_code AND h.display = 'Y'
            LEFT JOIN 
                master.post_t i ON i.post_code = a.lct_judge_desg AND i.display = 'Y'
            LEFT JOIN 
                relied_details rd ON rd.lowerct_id = a.lower_court_id AND rd.display = 'Y'
            LEFT JOIN 
                transfer_to_details t_t ON t_t.lowerct_id = a.lower_court_id AND t_t.display = 'Y'
            WHERE 
                a.caveat_no = :caveat_no
                AND a.lw_display = 'Y'
                AND e.c_status = 'P'
            ORDER BY 
                a.lower_court_id";

        $query = $this->db->query($sql, ['caveat_no' => $caveat_no]);
        $result = $query->getResultArray();

        return !empty($result) ? $result : false;
    }

    public function getAlreadyAddeLowerCourtDetails($conditionArray)
    {
        $caveat_no = $conditionArray['caveat_no'];
        $state_agency = $conditionArray['state_agency'];
        $district_id = $conditionArray['district_id'];
        $case_type = $conditionArray['case_type'];
        $lc_case_no = (string) $conditionArray['lc_case_no'];
        $lc_case_year = $conditionArray['lc_case_year'];
        $lct_dec_dt = $conditionArray['lct_dec_dt'];
        $m_policestn = $conditionArray['m_policestn'];
        $crimeno = $conditionArray['crimeno'];
        $crimeyear = $conditionArray['crimeyear'];
        $c_type = $conditionArray['c_type'];

        $sql = "SELECT *
            FROM public.caveat_lowerct
            WHERE caveat_no = :caveat_no
            AND l_state = :state_agency
            AND l_dist = :district_id
            AND ct_code = :c_type
            AND lct_casetype = :case_type
            AND lct_caseno = :lc_case_no
            AND lct_caseyear = :lc_case_year
            AND (
                (lw_display = 'R' AND lct_dec_dt IS NULL AND polstncode = :m_policestn AND crimeno = :crimeno AND crimeyear = :crimeyear)
                OR
                (lw_display = 'Y' AND lct_dec_dt = :lct_dec_dt AND polstncode = :m_policestn AND crimeno = :crimeno AND crimeyear = :crimeyear)
            )";

        $query = $this->db->query($sql, [
            'caveat_no' => $caveat_no,
            'state_agency' => $state_agency,
            'district_id' => $district_id,
            'c_type' => $c_type,
            'case_type' => $case_type,
            'lc_case_no' => $lc_case_no,
            'lc_case_year' => $lc_case_year,
            'm_policestn' => $m_policestn,
            'crimeno' => $crimeno,
            'crimeyear' => $crimeyear,
            'lct_dec_dt' => $lct_dec_dt,
        ]);

        $result = $query->getResultArray();

        return !empty($result) ? $result : false;
    }


    public function getEarlierCourtData($lc_id)
    {
        $sql = "SELECT *
                FROM public.caveat_lowerct
                WHERE lower_court_id = :lc_id";

        $query = $this->db->query($sql, [
            'lc_id' => $lc_id,
        ]);

        $result = $query->getResultArray();

        return !empty($result) ? $result : false;
    }



    public function insertEarlierCourt($earlierCourtArray)
    {
        $builder = $this->db->table("public.caveat_lowerct");
        unset($earlierCourtArray['lower_court_id']);

        // Perform the insert operation
        if ($builder->insert($earlierCourtArray)) {
            // PostgreSQL equivalent of getting the last insert ID
            $lastInsertId = $this->db->insertID('caveat_lowerct_lower_court_id_seq');
            return $lastInsertId;
        } else {
            return false;
        }
    }

    public function insertLowerCourtJudges($judgesArray)
    {
        $builder = $this->db->table("public.caveat_lowerct_judges");
        if ($builder->insert($judgesArray)) {
            return true;
        } else {
            return false;
        }
    }

    public function updateEarlierCourt($updateData, $lower_court_id)
    {
        $builder = $this->db->table("public.caveat_lowerct");

        // Perform the update operation
        $builder->where('lower_court_id', $lower_court_id);
        $builder->where('lw_display', 'Y');

        // Convert updateData keys to lowercase for PostgreSQL compatibility
        $updateData = array_change_key_case($updateData, CASE_LOWER);

        if ($builder->update($updateData)) {
            return true;
        } else {
            return false;
        }
    }

    public function getJudgesDetailsofLowerCourt($lowerct_id)
    {
        $builder = $this->db->table("public.caveat_lowerct_judges");
        $builder->select('*');
        $builder->where('lowerct_id', $lowerct_id);
        $builder->where('lct_display', 'Y');

        $query = $builder->get();

        $result = $query->getResultArray();

        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function getJudgeDetailsByDiary($caveat_no)
    {
        $builder = $this->db->table("public.caveat_lowerct as l");
        $builder->select([
            'id',
            'lower_court_id',
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

        $builder->join('caveat_lowerct_judges as lj', 'l.lower_court_id = lj.lowerct_id', 'RIGHT', false);
        $builder->where('l.caveat_no', $caveat_no);
        $query = $builder->get();

        $resultJudges = $query->getResultArray();

        // Initialize an empty result set
        $resultSet = [];

        // Process the result array to group judges by lower_court_id
        foreach ($resultJudges as $jud) {
            $id = $jud['lower_court_id'];
            $resultSet[$id][] = [
                'judge_name' => $jud['judge_name']
            ];
        }

        return $resultSet;
    }



    public function getReliedDetails($conditionArray)
    {
        $lowerct_id = $conditionArray['lowerct_id'];
        $relied_court = $conditionArray['relied_court'];
        $relied_case_type = $conditionArray['relied_case_type'];
        $relied_case_no = $conditionArray['relied_case_no'];
        $relied_case_year = $conditionArray['relied_case_year'];
        $relied_state = $conditionArray['relied_state'];
        $relied_district = $conditionArray['relied_district'];

        $builder = $this->db->table("public.relied_details");
        $builder->select('count(*)');
        $builder->where('lowerct_id', $lowerct_id);
        $builder->where('relied_court', $relied_court);
        $builder->where('relied_case_type', $relied_case_type);
        $builder->where('relied_case_no', $relied_case_no);
        $builder->where('relied_case_year', $relied_case_year);
        $builder->where('relied_state', $relied_state);
        $builder->where('relied_district', $relied_district);

        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return $result;
        } else {
            return false;
        }
        // $result = $query->getResultArray();
    }

    public function insertReliedDetails($relied_details)
    {
        $builder = $this->db->table("public.relied_details");
        if ($builder->insert($relied_details)) {
            return true;
            //return $this->db->insertID();
        } else {
            return false;
        }
    }


    public function getTransferDetails($conditionArray)
    {
        $lowerct_id = $conditionArray['lowerct_id'];
        $transfer_court = $conditionArray['transfer_court'];
        $transfer_case_type = $conditionArray['transfer_case_type'];
        $transfer_case_no = $conditionArray['transfer_case_no'];
        $transfer_case_year = $conditionArray['transfer_case_year'];
        $transfer_state = $conditionArray['transfer_state'];
        $transfer_district = $conditionArray['transfer_district'];

        $builder = $this->db->table("public.transfer_to_details");
        $builder->select('COUNT(*) AS count');
        $builder->where('lowerct_id', $lowerct_id);
        $builder->where('transfer_court', $transfer_court);
        $builder->where('transfer_case_type', $transfer_case_type);
        $builder->where('transfer_case_no', $transfer_case_no);
        $builder->where('transfer_case_year', $transfer_case_year);
        $builder->where('transfer_state', $transfer_state);
        $builder->where('transfer_district', $transfer_district);

        $query = $builder->get();

        $result = $query->getRow();

        if ($result && $result->count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function insertTransferDetails($transfer_details)
    {
        $builder = $this->db->table("public.transfer_to_details");
        if ($builder->insert($transfer_details)) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteTransferDetails($lowerCourt)
    {
        $builder = $this->db->table("public.transfer_to_details");
        $builder->where('lowerct_id', $lowerCourt);
        if ($builder->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteReliedDetails($lowerCourt)
    {
        $builder = $this->db->table("public.relied_details");
        $builder->where('lowerct_id', $lowerCourt);
        if ($builder->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteJudgesDetails($lowerCourt)
    {
        $builder = $this->db->table("public.caveat_lowerct_judges");
        $builder->where('lowerct_id', $lowerCourt);
        if ($builder->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteLowerCourtDetails($lowerCourt)
    {
        $builder = $this->db->table("public.caveat_lowerct");
        $builder->where('lower_court_id', $lowerCourt);
        if ($builder->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public function getCaveatDetails($caveat_no, $lc_cno, $lc_cyear)
    {
        $query = $this->db->query("
            SELECT *
            FROM public.caveat_lowerct
            WHERE caveat_no = ANY(:caveat_no)
              AND lct_caseyear = :lc_cyear
              AND lct_caseno = :lc_cno
              AND lw_display = 'Y'
        ", [
            'caveat_no' => $caveat_no,
            'lc_cyear' => $lc_cyear,
            'lc_cno' => $lc_cno
        ]);

        $result = $query->getResultArray();

        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }


    public function getCaveatDetailsNumber($caveat_no, $lc_cno, $lc_cyear)
    {
        $query = $this->db->query("
            SELECT STRING_AGG(CONCAT(SUBSTRING(CAST(caveat_no AS TEXT) FROM 1 FOR LENGTH(CAST(caveat_no AS TEXT)) - 4), '/', SUBSTRING(CAST(caveat_no AS TEXT) FROM -4)), ',') AS concatenated_numbers
            FROM caveat_lowerct
            WHERE caveat_no = ANY(:caveat_no)
              AND lct_caseyear = :lc_cyear
              AND lct_caseno = :lc_cno
              AND lw_display = 'Y'
        ", [
            'caveat_no' => $caveat_no,
            'lc_cyear' => $lc_cyear,
            'lc_cno' => $lc_cno
        ]);

        $result = $query->getResultArray();

        if (!empty($result)) {
            return $result[0]['concatenated_numbers'];
        } else {
            return false;
        }
    }



    public function allReliedDetailsbyLowerCourt($lowerct_id)
    {
        $query = $this->db->query("
            SELECT *
            FROM public.relied_details
            WHERE lowerct_id = :lowerct_id
              AND display = 'Y'
            LIMIT 1
        ", [
            'lowerct_id' => $lowerct_id
        ]);

        $result = $query->getResultArray();

        if (!empty($result)) {
            return $result[0];
        } else {
            return false;
        }
    }

    public function allTransferDetails($lowerct_id)
    {
        $query = $this->db->query("
        SELECT *
        FROM public.transfer_to_details
        WHERE lowerct_id = :lowerct_id
          AND display = 'Y'
        LIMIT 1
    ", [
            'lowerct_id' => $lowerct_id
        ]);

        $result = $query->getResultArray();

        if (!empty($result)) {
            return $result[0];
        } else {
            return false;
        }
    }


    public function allTransferDetailsByDiaryNo($caveat_no)
    {
        $query = $this->db->query("
        SELECT
            a.lower_court_id,
            a.transfer_court,
            a.transfer_case_type,
            a.name,
            CASE
                WHEN a.transfer_court = 3 THEN (
                    CASE
                        WHEN t.transfer_state = 490506 THEN (
                            SELECT court_name
                            FROM master.state s
                            LEFT JOIN master.delhi_district_court d ON s.state_code = d.state_code AND s.district_code = d.district_code
                            WHERE s.id_no = t.transfer_district AND s.display = 'Y'
                        )
                        ELSE (
                            SELECT Name
                            FROM master.state s
                            WHERE s.id_no = t.transfer_district AND s.display = 'Y'
                        )
                    END
                )
                ELSE (
                    SELECT agency_name
                    FROM master.ref_agency_code c
                    WHERE c.cmis_state_id = t.transfer_state AND c.id = t.transfer_district AND c.is_deleted = 'f'
                )
            END AS reference_name,
            CONCAT(
                CASE WHEN a.transfer_court = 4 THEN (
                    SELECT skey FROM master.casetype ct WHERE ct.display = 'Y' AND ct.casecode = t.transfer_case_type
                ) ELSE (
                    SELECT type_sname FROM master.lc_hc_casetype d WHERE d.lccasecode = t.transfer_case_type AND d.display = 'Y'
                ) END,
                '-',
                t.transfer_case_no,
                '-',
                t.transfer_case_year
            ) AS case_name,
            CASE
                WHEN a.transfer_court = 4 THEN 'Supreme Court'
                WHEN a.transfer_court = 1 THEN 'High Court'
                WHEN a.transfer_court = 3 THEN 'District Court'
                WHEN a.transfer_court = 5 THEN 'State Agency'
            END AS court_name
        FROM public.caveat_lowerct AS a
        LEFT JOIN public.transfer_to_details AS t ON t.lowerct_id = a.lower_court_id AND t.display = 'Y'
        LEFT JOIN master.state AS b ON t.transfer_state = b.id_no AND b.display = 'Y'
        WHERE a.caveat_no = :caveat_no
          AND a.lw_display = 'Y'
          AND a.transfer_court >= 1
        ORDER BY a.lower_court_id
    ", [
            'caveat_no' => $caveat_no
        ]);

        $result = $query->getResultArray();

        if (!empty($result)) {
            $data = [];
            foreach ($result as $all_data) {
                $data[$all_data['lower_court_id']] = $all_data;
            }
            return $data;
        } else {
            return false;
        }
    }


    public function allReferenceDetailsByDiaryNo($caveat_no)
    {
        $query = $this->db->query("
        SELECT
            a.lower_court_id,
            a.ref_court,
            a.name,
            CASE
                WHEN a.ref_court = 3 THEN (
                    CASE
                        WHEN a.ref_state = 490506 THEN (
                            SELECT court_name
                            FROM master.state s
                            LEFT JOIN master.delhi_district_court d ON s.state_code = d.state_code AND s.district_code = d.district_code
                            WHERE s.id_no = a.ref_district AND s.display = 'Y'
                        )
                        ELSE (
                            SELECT Name
                            FROM master.state s
                            WHERE s.id_no = a.ref_district AND s.display = 'Y'
                        )
                    END
                )
                ELSE (
                    SELECT agency_name
                    FROM master.ref_agency_code c
                    WHERE c.cmis_state_id = a.ref_state AND c.id = a.ref_district AND c.is_deleted = 'f'
                )
            END AS reference_name,
            CONCAT(
                CASE WHEN a.ref_court = 4 THEN (
                    SELECT skey FROM master.casetype ct WHERE ct.display = 'Y' AND ct.casecode = a.ref_case_type
                ) ELSE (
                    SELECT type_sname FROM master.lc_hc_casetype d WHERE d.lccasecode = a.ref_case_type AND d.display = 'Y'
                ) END,
                '-',
                a.ref_case_no,
                '-',
                a.ref_case_year
            ) AS case_name,
            CASE
                WHEN a.ref_court = 4 THEN 'Supreme Court'
                WHEN a.ref_court = 1 THEN 'High Court'
                WHEN a.ref_court = 3 THEN 'District Court'
                WHEN a.ref_court = 5 THEN 'State Agency'
            END AS court_name
        FROM public.caveat_lowerct a
        LEFT JOIN master.state b ON a.ref_state = b.id_no AND b.display = 'Y'
        WHERE a.caveat_no = :caveat_no
          AND a.lw_display = 'Y'
          AND a.ref_court >= 1
        ORDER BY a.lower_court_id
    ", [
            'caveat_no' => $caveat_no
        ]);

        $result = $query->getResultArray();

        if (!empty($result)) {
            $data = [];
            foreach ($result as $all_data) {
                $data[$all_data['lower_court_id']] = $all_data;
            }
            return $data;
        } else {
            return false;
        }
    }

    public function allGovernmentNotificationsByDiaryNo($caveat_no)
    {
        $query = $this->db->query("
        SELECT
            a.lower_court_id,
            a.name,
            CONCAT(a.gov_not_case_type, '-', a.gov_not_case_no, '-', a.gov_not_case_year) AS case_name,
            a.gov_not_date
        FROM public.caveat_lowerct a
        LEFT JOIN master.state b ON a.gov_not_state_id = b.id_no AND b.display = 'Y'
        WHERE a.caveat_no = :caveat_no
          AND a.lw_display = 'Y'
          AND a.gov_not_state_id >= 1
        ORDER BY a.lower_court_id
    ", [
            'caveat_no' => $caveat_no
        ]);

        $result = $query->getResultArray();

        if (!empty($result)) {
            $data = [];
            foreach ($result as $all_data) {
                $data[$all_data['lower_court_id']] = $all_data;
            }
            return $data;
        } else {
            return false;
        }
    }

    public function allReliedDetailsByDiaryNo($caveat_no)
    {
        $query = $this->db->query("
        SELECT
            a.lower_court_id,
            a.relied_court,
            a.relied_case_type,
            a.name,
            CASE
                WHEN a.relied_court = 3 THEN (
                    CASE
                        WHEN rd.relied_state = 490506 THEN (
                            SELECT court_name
                            FROM master.state s
                            LEFT JOIN master.delhi_district_court d ON s.state_code = d.state_code AND s.district_code = d.district_code
                            WHERE s.id_no = rd.relied_district AND s.display = 'Y'
                        )
                        ELSE (
                            SELECT name
                            FROM master.state s
                            WHERE s.id_no = rd.relied_district AND s.display = 'Y'
                        )
                    END
                )
                ELSE (
                    SELECT agency_name
                    FROM master.ref_agency_code c
                    WHERE c.cmis_state_id = rd.relied_state AND c.id = rd.relied_district AND c.is_deleted = 'f'
                )
            END AS reference_name,
            CONCAT(
                CASE WHEN a.relied_court = 4 THEN (
                    SELECT skey
                    FROM master.casetype ct
                    WHERE ct.display = 'Y' AND ct.casecode = rd.relied_case_type
                )
                ELSE (
                    SELECT type_sname
                    FROM master.lc_hc_casetype d
                    WHERE d.lccasecode = rd.relied_case_type AND d.display = 'Y'
                )
                END,
                '-',
                rd.relied_case_no,
                '-',
                rd.relied_case_year
            ) AS case_name,
            CASE
                WHEN a.relied_court = 4 THEN 'Supreme Court'
                WHEN a.relied_court = 1 THEN 'High Court'
                WHEN a.relied_court = 3 THEN 'District Court'
                WHEN a.relied_court = 5 THEN 'State Agency'
            END AS court_name
        FROM public.caveat_lowerct a
        LEFT JOIN public.relied_details rd ON rd.lowerct_id = a.lower_court_id AND rd.display = 'Y'
        LEFT JOIN master.state b ON rd.relied_state = b.id_no AND b.display = 'Y'
        WHERE a.caveat_no = :caveat_no
          AND a.lw_display = 'Y'
          AND a.relied_court >= 1
        ORDER BY a.lower_court_id
    ", [
            'caveat_no' => $caveat_no
        ]);

        $result = $query->getResultArray();

        if (!empty($result)) {
            $data = [];
            foreach ($result as $all_data) {
                $data[$all_data['lower_court_id']] = $all_data;
            }
            return $data;
        } else {
            return false;
        }
    }


    public function get_caveat_details($caveat_no, $is_archival_table = '')
    {
        $sql = "SELECT c.*, b.name, b.aor_code 
            FROM public.caveat$is_archival_table AS c 
            LEFT JOIN master.bar AS b ON c.pet_adv_id = b.bar_id 
            WHERE c.caveat_no = :caveat_no";

        $query = $this->db->query($sql, ['caveat_no' => $caveat_no]);
        $result = $query->getRowArray();

        return $result;
    }
}
