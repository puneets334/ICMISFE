<?php

namespace App\Models\ARDRBM;

use CodeIgniter\Model;

class IAModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
    }

    private function executeQuery($builder)
    {
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getDocDetails($diaryNo, $docId = '', $isArchivalTable = '')
    {
        $builder = $this->db->table("public.docdetails$isArchivalTable");
        $builder->select("*, CONCAT(docnum, '/', docyear) AS ia");
        $builder->where('diary_no', $diaryNo);
        $builder->where('display', 'Y');

        if (!empty($docId)) {
            $builder->whereIn('docd_id', $docId);
        }

        return $this->executeQuery($builder);
    }


    public function getIaEntryDateCorrectionList($diaryNo, $isArchivalTable = '')
    {
        $builder = $this->db->table("public.docdetails$isArchivalTable a");
        $builder->select('docd_id, a.diary_no, a.doccode, a.doccode1, docnum, docyear, filedby, a.ent_dt, other1, a.remark, party, no_of_copy, advocate_id, docdesc, c.name AS advname, u.name AS entryuser, forresp, a.docfee, feemode, iastat');
        $builder->join('master.docmaster b', 'a.doccode = b.doccode AND a.doccode1 = b.doccode1', 'left');
        $builder->join('master.bar c', 'a.advocate_id = c.bar_id', 'left');
        $builder->join('master.users u', 'a.usercode = u.usercode', 'left');
        $builder->where('a.diary_no', $diaryNo);
        $builder->where('a.display', 'Y');
        $builder->where('b.display', 'Y');
        $builder->where('a.iastat', 'P');
        $builder->groupStart()
            ->where("a.ent_dt IS NULL")
            ->orWhere("a.ent_dt = '1900-01-01 00:00:00'")
            ->orWhere("a.ent_dt = '0200-09-11 00:00:00'")
            ->orWhere("a.ent_dt = '1933-07-30 00:00:00'")
            ->groupEnd();
        $builder->orderBy('a.doccode', 'ASC');
        $builder->orderBy('a.ent_dt', 'ASC');

        return $this->executeQuery($builder);
    }


    public function getHeardt($diaryNo)
    {
        $currentDate = date('Y-m-d');

        $builder = $this->db->table("public.heardt");
        $builder->select("*")
            ->where("next_dt >=", $currentDate)
            ->where('brd_slno >', 0)
            ->where('roster_id >', 0)
            ->where('diary_no', $diaryNo);

        $result = $this->executeQuery($builder);

        if (empty($result)) {
            $builder2 = $this->db->table("public.heardt_a");
            $builder2->select("*")
                ->where("next_dt >=", $currentDate)
                ->where('brd_slno >', 0)
                ->where('roster_id >', 0)
                ->where('diary_no', $diaryNo);

            $result = $this->executeQuery($builder2);
        }

        return $result;
    }


    public function getIaEntryDateCorrectionContent($docdId)
    {
        $result = $this->fetchIaEntryDateCorrectionContent('public.docdetails', $docdId);
    
        if (empty($result)) {
            $result = $this->fetchIaEntryDateCorrectionContent('public.docdetails_a', $docdId);
        }
        return $result;
    }

    private function fetchIaEntryDateCorrectionContent($table, $docdId)
    {
        $builder = $this->db->table("$table a");
        $builder->select('docd_id, a.diary_no, kntgrp, a.doccode, a.doccode1, docnum, docyear, filedby, a.ent_dt, other1, a.remark, party, no_of_copy, advocate_id, docdesc, c.name AS advname, u.nam e AS entryuser, forresp, a.docfee, feemode, iastat, aor_code')
            ->join('master.docmaster b', 'a.doccode = b.doccode AND a.doccode1 = b.doccode1', 'left')
            ->join('master.bar c', 'advocate_id = bar_id', 'left')
            ->join('master.users u', 'a.usercode = u.usercode', 'left')
            ->where('docd_id', $docdId);

        return $this->executeQuery($builder);
    }

    public function getDocMaster($docdId = null)
    {
        $builder = $this->db->table('master.docmaster');
        $builder->select('*')
            ->where('doccode1', 0)
            ->where('display', 'Y');
        if (!empty($docdId)) {
            $builder->where('docd_id', $docdId);
        }
        $builder->orderBy('doccode', 'ASC');

        return $this->executeQuery($builder);
    }

    public function getIaUpdationList($diaryNo, $isArchivalTable = '')
    {
        $builder = $this->db->table("public.docdetails$isArchivalTable a");
        $builder->select('docd_id, a.diary_no, a.doccode, a.doccode1, docnum, docyear, filedby, a.ent_dt, other1, a.remark, party, no_of_copy, advocate_id, docdesc, c.name AS advname, u.name AS entryuser, forresp, a.docfee, feemode, iastat, is_efiled')
            ->join('master.docmaster b', 'a.doccode = b.doccode AND a.doccode1 = b.doccode1', 'left')
            ->join('master.bar c', 'advocate_id = bar_id', 'left')
            ->join('master.users u', 'a.usercode = u.usercode', 'left')
            ->where('diary_no', $diaryNo)
            ->where('a.display', 'Y')
            ->where('b.display', 'Y')
            ->where('iastat', 'P')
            ->orderBy('docnum', 'ASC')
            ->orderBy('docyear', 'ASC');

        return $this->executeQuery($builder);
    }

    public function getSectionOfficerCount($diaryNo, $sessionUser)
    {
        $query = "
            SELECT COUNT(*) AS t 
            FROM main m
            LEFT JOIN master.users u ON m.dacode = u.usercode
            WHERE u.display = 'Y' 
              AND m.diary_no = :diary_no 
              AND u.section IN (
                  SELECT s.usec 
                  FROM master.users u 
                  JOIN master.usertype t ON u.usertype = t.id 
                  JOIN master.user_sec_map s ON u.empid = s.empid
                  WHERE t.id IN (9, 6, 4, 60) 
                    AND u.display = 'Y' 
                    AND t.display = 'Y' 
                    AND u.usercode = :session_user 
                    AND s.display = 'Y'
              )";

        $result = $this->db->query($query, [
            'diary_no' => $diaryNo,
            'session_user' => $sessionUser,
        ])->getResultArray();

        if (empty($result)) {
            $result = $this->db->query($query, [
                'diary_no' => $diaryNo,
                'session_user' => $sessionUser,
            ])->getResultArray();
        }

        return $result;
    }
}
