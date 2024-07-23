<?php

namespace App\Models\Reports\Filing;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseBuilder;

class FilingReportModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDefectsReports($on_date)
    {

        //echo $on_date['on_date'];exit;


        // $subquery = $this->db->table('obj_save os')
        //                     ->select('CONCAT(SUBSTRING(os.diary_no::text, 1, LENGTH(os.diary_no::text) - 4), \'/\', SUBSTRING(os.diary_no::text, -4)) AS diary_no, u.name, u.usercode, o.objdesc, os.remark, DATE(os.save_dt) AS save_date')
        //                     ->join('master.objection o', 'os.org_id = o.objcode', 'left')
        //                     ->join('master.users u', 'os.usercode = u.usercode', 'left')
        //                     //->where("date(os.save_dt)", $on_date)
        //                     //->where("date_trunc('day', os.save_dt) = TIMESTAMP ".$on_date['on_date']."", NULL, false)  // Use TIMESTAMP for date comparison 
        //                     ->where("date_trunc('day', os.save_dt) = TIMESTAMP '".$on_date['on_date']."'", NULL, false)
        //                     ->groupBy('diary_no, u.name, u.usercode, save_date,o.objdesc,os.remark'); 

        // $subquery_sql = $subquery->getCompiledSelect();
        // $subquery_result = $this->db->query($subquery_sql)->getResult();
        // $query = $this->db->table("($subquery_sql) AS table2")
        //                   ->select('name, COUNT(*) AS total, usercode, save_date')
        //                   ->groupBy('name, usercode, save_date')
        //                   ->get();

        // Subquery for the first part of the union
        // Subquery for the first part of the union
        // $query= $this->db->query("  SELECT
        // name,
        // COUNT(*) AS total,
        // usercode,
        // save_date
        // FROM
        // (
        //     SELECT
        //         diary_no,
        //         name,
        //         usercode,
        //         save_date
        //     FROM
        //         (
        //             SELECT
        //                 substring(os.diary_no::text, 1, length(os.diary_no::text) - 4) || '/' || substring(os.diary_no::text, -4) AS diary_no,
        //                 u.name,
        //                 u.usercode,
        //                 date(os.save_dt) AS save_date
        //             FROM
        //                 obj_save os
        //             LEFT JOIN
        //                 master.objection o ON os.org_id = o.objcode
        //             LEFT JOIN
        //                 master.users u ON os.usercode = u.usercode
        //             WHERE
        //                 date(os.save_dt) = '" . $on_date['on_date'] . "'  
        //         ) AS table1
        //     GROUP BY
        //         diary_no, name, usercode, save_date

        //     UNION ALL

        //     SELECT
        //         diary_no,
        //         name,
        //         usercode,
        //         save_date
        //     FROM
        //         (
        //             SELECT
        //                 substring(os.diary_no::text, 1, length(os.diary_no::text) - 4) || '/' || substring(os.diary_no::text, -4) AS diary_no,
        //                 u.name,
        //                 u.usercode,
        //                 date(os.save_dt) AS save_date
        //             FROM
        //                 obj_save_a os
        //             LEFT JOIN
        //                 master.objection o ON os.org_id = o.objcode
        //             LEFT JOIN
        //                 master.users u ON os.usercode = u.usercode
        //             WHERE
        //                 date(os.save_dt) = '" . $on_date['on_date'] . "'  
        //         ) AS table1
        //     GROUP BY
        //         diary_no, name, usercode, save_date
        // ) AS combined_data
        // GROUP BY
        // name, usercode, save_date;

        //  "); // Group by all selected fields




        $subQuery1 = $this->db->table('obj_save os')
            ->select("CONCAT(SUBSTRING(os.diary_no::text, 1, LENGTH(os.diary_no::text) - 4), '/', SUBSTRING(os.diary_no::text, -4)) AS diary_no, u.name, u.usercode AS user_code, DATE(os.save_dt) AS save_date")
            ->join('master.objection o', 'os.org_id = o.objcode', 'left')
            ->join('master.users u', 'os.usercode = u.usercode', 'left')
            ->where('DATE(os.save_dt)', $on_date['on_date'])
            ->groupBy('diary_no, name, user_code, save_date');

        $subQuery2 = $this->db->table('obj_save_a os')
            ->select("CONCAT(SUBSTRING(os.diary_no::text, 1, LENGTH(os.diary_no::text) - 4), '/', SUBSTRING(os.diary_no::text, -4)) AS diary_no, u.name, u.usercode AS user_code, DATE(os.save_dt) AS save_date")
            ->join('master.objection o', 'os.org_id = o.objcode', 'left')
            ->join('master.users u', 'os.usercode = u.usercode', 'left')
            ->where('DATE(os.save_dt)', $on_date['on_date'])
            ->groupBy('diary_no, name, user_code, save_date');

        $combinedQuery = $this->db->table('(' . $subQuery1->getCompiledSelect() . ' UNION ALL ' . $subQuery2->getCompiledSelect() . ') AS combined_data')
            ->select('name, COUNT(*) AS total, user_code, save_date')
            ->groupBy('name, user_code, save_date');

        $result = $combinedQuery->get();

        return $result->getResultArray();
    }



    function scrutiny_user_wise_detail_report_model($userid, $scrutiny_date)
    {

        $subQuery1 = $this->db->table('obj_save os')
            ->select([
                'CONCAT(SUBSTRING(os.diary_no::text, 1, LENGTH(os.diary_no::text) - 4), \'/\', SUBSTRING(os.diary_no::text, -4)) AS diaryno',
                'u.name AS scrutiny_user_name',
                'u.usercode',
                'os.remark',
                'DATE(os.save_dt) AS save_date',
                'c.casename AS casetype',
                'CONCAT(m.pet_name, \' vs \', m.res_name) AS causetitle',
                'TO_CHAR(m.diary_no_rec_date, \'YYYY-MM-DD\') AS filingdate',
                'COUNT(*) AS no_of_defect'
            ])
            ->join('master.users u', 'os.usercode = u.usercode', 'left')
            ->join('main m', 'm.diary_no = os.diary_no', 'inner')
            ->join('master.casetype c', 'm.casetype_id = c.casecode', 'left')
            ->where('DATE(os.save_dt)', $scrutiny_date)
            ->where('os.usercode', $userid)
            ->where('os.display', 'Y')
            ->groupBy(['diaryno', 'casetype', 'causetitle', 'filingdate', 'scrutiny_user_name', 'u.usercode', 'os.remark', 'save_date'])
            ->getCompiledSelect();

        $subQuery2 = $this->db->table('obj_save_a os')
            ->select([
                'CONCAT(SUBSTRING(os.diary_no::text, 1, LENGTH(os.diary_no::text) - 4), \'/\', SUBSTRING(os.diary_no::text, -4)) AS diaryno',
                'u.name AS scrutiny_user_name',
                'u.usercode',
                'os.remark',
                'DATE(os.save_dt) AS save_date',
                'c.casename AS casetype',
                'CONCAT(m.pet_name, \' vs \', m.res_name) AS causetitle',
                'TO_CHAR(m.diary_no_rec_date, \'YYYY-MM-DD\') AS filingdate',
                'COUNT(*) AS no_of_defect'
            ])
            ->join('master.users u', 'os.usercode = u.usercode', 'left')
            ->join('main_a m', 'm.diary_no = os.diary_no', 'inner')
            ->join('master.casetype c', 'm.casetype_id = c.casecode', 'left')
            ->where('DATE(os.save_dt)', $scrutiny_date)
            ->where('os.usercode', $userid)
            ->where('os.display', 'Y')
            ->groupBy(['diaryno', 'casetype', 'causetitle', 'filingdate', 'scrutiny_user_name', 'u.usercode', 'os.remark', 'save_date'])
            ->getCompiledSelect();

        $mainQuery = $this->db->table("($subQuery1 UNION ALL $subQuery2) AS table1")
            ->groupBy(['diaryno', 'casetype', 'causetitle', 'filingdate', 'scrutiny_user_name', 'usercode', 'save_date'])
            ->select([
                'diaryno',
                'casetype',
                'causetitle',
                'filingdate',
                'scrutiny_user_name',
                'usercode',
                'save_date',
                'SUM(no_of_defect) AS total_defect_count'
            ])
            ->get();



        //     $query= $this->db->query(" SELECT 
        //     diaryno, 
        //     casetype, 
        //     causetitle, 
        //     filingdate, 
        //     scrutiny_user_name, 
        //     usercode, 
        //     save_date, 
        //     no_of_defect,
        //     SUM(no_of_defect) AS total_defect_count 
        // FROM (
        //     SELECT 
        //         diaryno, 
        //         casetype, 
        //         causetitle, 
        //         filingdate, 
        //         scrutiny_user_name, 
        //         usercode, 
        //         save_date, 
        //         no_of_defect 
        //     FROM (
        //         SELECT 
        //             CONCAT(SUBSTRING(os.diary_no::text, 1, LENGTH(os.diary_no::text) - 4), '/', SUBSTRING(os.diary_no::text, -4)) AS diaryno, 
        //             u.name AS scrutiny_user_name, 
        //             u.usercode, 
        //             os.remark, 
        //             DATE(os.save_dt) AS save_date, 
        //             c.casename AS casetype, 
        //             CONCAT(m.pet_name, ' vs ', m.res_name) AS causetitle, 
        //             TO_CHAR(m.diary_no_rec_date, 'YYYY-MM-DD') AS filingdate, 
        //             COUNT(*) AS no_of_defect 
        //         FROM 
        //             obj_save os 
        //         LEFT JOIN 
        //             master.users u ON os.usercode = u.usercode 
        //         JOIN 
        //             main m ON m.diary_no = os.diary_no 
        //         LEFT JOIN 
        //             master.casetype c ON m.casetype_id = c.casecode 
        //         WHERE 
        //         DATE(os.save_dt) = '".$scrutiny_date."' 
        //         AND os.usercode = '".$userid."'
        //             AND os.display = 'Y' 
        //         GROUP BY 
        //             diaryno, 
        //             casetype, 
        //             causetitle, 
        //             filingdate, 
        //             scrutiny_user_name, 
        //             u.usercode, 
        //             os.remark, 
        //             save_date 

        //         UNION ALL 

        //         SELECT 
        //             CONCAT(SUBSTRING(os.diary_no::text, 1, LENGTH(os.diary_no::text) - 4), '/', SUBSTRING(os.diary_no::text, -4)) AS diaryno, 
        //             u.name AS scrutiny_user_name, 
        //             u.usercode, 
        //             os.remark, 
        //             DATE(os.save_dt) AS save_date, 
        //             c.casename AS casetype, 
        //             CONCAT(m.pet_name, ' vs ', m.res_name) AS causetitle, 
        //             TO_CHAR(m.diary_no_rec_date, 'YYYY-MM-DD') AS filingdate,
        //             COUNT(*) AS no_of_defect
        //         FROM 
        //             obj_save_a os 
        //         LEFT JOIN 
        //             master.users u ON os.usercode = u.usercode 
        //         JOIN 
        //             main_a m ON m.diary_no = os.diary_no 
        //         LEFT JOIN 
        //             master.casetype c ON m.casetype_id = c.casecode 
        //         WHERE 
        //         DATE(os.save_dt) = '".$scrutiny_date."' 
        //         AND os.usercode = '".$userid."'
        //             AND os.display = 'Y' 
        //         GROUP BY 
        //             diaryno, 
        //             casetype, 
        //             causetitle, 
        //             filingdate, 
        //             scrutiny_user_name, 
        //             u.usercode, 
        //             os.remark,
        //             save_date
        //     ) AS table1
        // ) AS table2
        // GROUP BY 
        //     diaryno, 
        //     casetype, 
        //     causetitle, 
        //     filingdate, 
        //     no_of_defect,
        //     scrutiny_user_name, 
        //     usercode, 
        //     save_date;

        // ");


        return $mainQuery->getResultArray();
        //echo $this->db->getLastQuery();


    }

    function get_filing_scrutiny_defect_reports($data)
    {

        $dairyno = $data['dno'] . $data['dyr'];

        $query1 = $this->db->table('obj_save a')
            ->select('objdesc, save_dt, rm_dt, remark, u.name AS ent_by, u1.name AS rem_by, mul_ent')
            ->join('master.objection b', 'a.org_id = b.objcode')
            ->join('master.users u', 'a.usercode = u.usercode')
            ->join('master.users u1', 'a.rm_user_id = u1.usercode', 'left')
            ->where("a.display = 'Y'
                            AND (b.display = 'Y'
                                OR (b.display = 'N'
                                    AND b.objcode < 10075))
                            AND diary_no = $dairyno ");

        $query2 = $this->db->table('obj_save_a a')
            ->select('objdesc, save_dt, rm_dt, remark, u.name AS ent_by, u1.name AS rem_by, mul_ent')
            ->join('master.objection b', 'a.org_id = b.objcode')
            ->join('master.users u', 'a.usercode = u.usercode')
            ->join('master.users u1', 'a.rm_user_id = u1.usercode', 'left')
            ->where("a.display = 'Y'
                            AND (b.display = 'Y'
                                OR (b.display = 'N'
                                    AND b.objcode < 10075))
                            AND diary_no = $dairyno ");

        $query = $query1->union($query2, true)->get();

        return $query->getResultArray();
        //echo $this->db->getLastQuery();

    }

    function get_navigate_diary($dno)
    {
        $query = $this->db->table('main_a m')
            ->select('m.diary_no, c1.short_description, m.active_reg_year, m.active_fil_no,
                            m.pet_name, m.res_name, m.pno, m.rno, m.diary_no_rec_date, m.active_fil_dt,
                            m.lastorder, m.c_status')
            ->join('master.casetype c1', 'm.active_casetype_id = c1.casecode', 'left')
            ->where('m.diary_no', $dno)
            ->get();
        return $query->getRowArray();
    }

    function get_scrutiny_causetitle($dairy_no)
    {

        $dairyno = $dairy_no['dno'] . $dairy_no['dyr'];

        $queryMain = $this->db->table('main')
            ->select('pet_name, res_name, pno, rno')
            ->where('diary_no', $dairyno);


        $queryMainA = $this->db->table('main_a')
            ->select('pet_name, res_name, pno, rno')
            ->where('diary_no', $dairyno);

        $query = $queryMain->union($queryMainA)
            ->get();

        return $results = $query->getResult();
    }

    function get_scrutiny_adv($dairy_no)
    {
        $dairyno = $dairy_no['dno'] . $dairy_no['dyr'];
        $query1 = $this->db->table('advocate a')
            ->select('name')
            ->join('master.bar b', 'a.advocate_id = b.bar_id')
            ->where('a.display', 'Y')
            ->where('diary_no', $dairyno)
            ->where('pet_res', 'P')
            ->where('adv_type', 'M')
            ->where('pet_res_no', 1)
            ->get();

        $query2 = $this->db->table('advocate_a a')
            ->select('name')
            ->join('master.bar b', 'a.advocate_id = b.bar_id')
            ->where('a.display', 'Y')
            ->where('diary_no', $dairyno)
            ->where('pet_res', 'P')
            ->where('adv_type', 'M')
            ->where('pet_res_no', 1)
            ->get();

        $results = $query1->getResult();
        $results2 = $query2->getResult();
        // Combine results if needed
        return $results_combined = array_merge($results, $results2);
    }
    public function tagged_matter_report()
    {
        $query = "SELECT
        b.main_case,
        CONCAT(SUBSTRING(b.diary_no::text, -4)) AS connected_case,
        connected
    FROM
        (
            SELECT
                CONCAT(SUBSTRING(c.conn_key::text, -4)) AS main_case,
                c.diary_no,
                CASE
                    WHEN c.conn_type = 'C' THEN 'connected'
                    ELSE 'Linked'
                END AS connected
            FROM
                (
                    SELECT
                        m.*
                    FROM
                        main m
                    LEFT JOIN mul_category mc ON mc.diary_no = m.diary_no
                        AND mc.display = 'Y'
                        AND mc.submaster_id IN (239, 240)
                    WHERE
                        (m.diary_no::text = m.conn_key::text)
                        AND m.c_status = 'P'
                        AND mc.diary_no IS NOT NULL
                    GROUP BY
                        m.diary_no
                ) a
            LEFT JOIN conct c ON c.conn_key::text = a.diary_no::text
                AND c.diary_no::text != a.diary_no::text
            WHERE
                c.list = 'Y'
                AND DATE(c.ent_dt) >= '2017-05-08'
        ) b
    LEFT JOIN heardt h ON h.diary_no = b.diary_no
    WHERE
        (h.subhead IN (811, 812)
            OR listorder = '32')
    ORDER BY
        main_case;
     ";
        $results = $this->db->query($query)->getResult();

        return $results;
    }
}
