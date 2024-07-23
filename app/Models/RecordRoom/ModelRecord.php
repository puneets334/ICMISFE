<?php

namespace App\Models\RecordRoom;

use CodeIgniter\Model;
use App\Models\Entities\Model_Ac;


class ModelRecord extends Model
{

    protected $table = 'ac';
    protected $allowedFields = [
        'aor_code',
        'cname',
        'cfname',
        'pa_line1',
        'pa_line2',
        'pa_district',
        'pa_pin',
        'ppa_line1',
        'ppa_line2',
        'ppa_district',
        'ppa_pin',
        'dob',
        'place_birth',
        'nationality',
        'cmobile',
        'eq_x',
        'eq_xii',
        'eq_ug',
        'eq_pg',
        'eino',
        'regdate',
        'status',
        'updatedby',
        'updated_by',
        'create_modify',
        'updated_on',
        'updated_by_ip',
        'updatedip',

    ];


    public function __construct()
    {
        parent::__construct();
        $db = \Config\Database::connect();
        $this->db = db_connect();
    }
    public function checkExistingData($aorcode, $eino)
    {
        $builder = $this->db->table('ac');
        $builder->select('COUNT(*) as count_rows');
        $builder->where('aor_code', $aorcode);
        $builder->where('eino', $eino);
        $result = $builder->get()->getRow();
        return $result->count_rows;
    }


    public function getClerkDetails()
    {
        $builder = $this->db->table('ac a');
        $builder->select('b.name, cname, cfname, eino, TO_CHAR(regdate, \'DD-MM-YYYY\') as formatted_regdate, a.aor_code, a.id, a.cmobile');
        $builder->join('master.bar b', 'b.aor_code = a.aor_code');
        $builder->orderBy('a.id');
        $query = $builder->get();
        $rows = $query->getResult();


        return $query->getResultArray();
    }
    public function getClerkDetails1($tvap)
    {
        $builder = $this->db->table('ac a');
        $builder->select('b.name, cname, cfname, eino, TO_CHAR(regdate, \'DD-MM-YYYY\') as formatted_regdate, a.aor_code, a.id, a.cmobile');
        $builder->join('master.bar b', 'b.aor_code = a.aor_code');
        $builder->where('a.aor_code', $tvap); 

        $builder->orderBy('a.id');
        $query = $builder->get();
        $rows = $query->getResult();


        return $query->getResultArray();
    }
    public function getval($id)
    {
        $builder = $this->db->table('ac a');
        $builder->select('*');
        $builder->join('master.bar b', 'b.aor_code = a.aor_code');
        $builder->where('a.id', $id);
        $query = $builder->get();

        
        if ($query->getNumRows() > 0) {
            return $query->getRowArray(); 
        } else {
            return null; 
        }
    }
    public function updateAc($id, $data)
    {
        try {
            $this->db->table('ac')->where('id', $id)->update($data);
            return true;
        } catch (\Exception $e) {
          
            log_message('error', 'Error updating data in the database: ' . $e->getMessage());
           
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function getadv_name1($tvap)
    {
        $builder = $this->db->table('master.bar');
        $builder->select('name');
        $builder->where('aor_code', $tvap);
        $query = $builder->get();
        $row = $query->getRow();
        if ($row) {
            echo htmlspecialchars($row->name, ENT_QUOTES, 'UTF-8');
        }
    }
    public function getaoroption($tvap)
    {
        $builder = $this->db->table('ac a');
        $builder->select('b.aor_code, b.name');
        $builder->join('master.bar b', 'b.aor_code = a.aor_code');
        $builder->where('a.eino', $tvap);
        $query = $builder->get();

        return $query->getResultArray();
    }
    public function getclerk($tvap)
    {
        $builder = $this->db->table('ac a');
        $builder->select('*');
        $builder->join('master.bar b', 'b.aor_code = a.aor_code');
        $builder->where('a.eino', $tvap);
        $query = $builder->get();

        return $query->getResultArray();
    }
    public function getclerk1($tvap)
    {
        $builder = $this->db->table('ac a');
        $builder->select("UPPER(CONCAT(cname, ' S/o ', cfname)) as clerk_name", false);
        $builder->where('a.eino', $tvap);
        $query = $builder->get();
        $row = $query->getRow();
        if ($row) {
            return htmlspecialchars($row->clerk_name, ENT_QUOTES, 'UTF-8');
        } else {
            return "";
        }
    }
    
    
    public function getaoroption1($tvap, $vadvc)
    {
        $builder = $this->db->table('ac a');
        $builder->select("CONCAT(a.aor_code,'#',b.name,'#',cname,'#',cfname,'#',pa_line1,'#',pa_line2,'#', pa_district,'#', pa_pin,'#', ppa_line1,'#', ppa_line2,'#', ppa_district,'#', ppa_pin,'#', a.dob,'#', place_birth,'#', nationality,'#',cmobile,'#', eq_x,'#', eq_xii,'#', eq_ug,'#', eq_pg,'#',regdate,'#',id)");
        $builder->join('master.bar b', 'b.aor_code = a.aor_code');
        $builder->where('eino', $tvap);
        $builder->where('a.aor_code', $vadvc);
        $query = $builder->get();
        $row = $query->getRow();

        if ($row) {
            echo $row->{current($row)};
        }
    }


    public function getAORsWithMoreClerks()
    {
        return $this->db->table('ac')
            ->select('ac.aor_code, bar.name, COUNT(*) as clerk_count')
            ->join('master.bar', 'bar.aor_code = ac.aor_code')
            ->groupBy('ac.aor_code, bar.name')
            ->having('COUNT(*) >', 2)
            ->orderBy('ac.aor_code', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getAORClerks($aorCode)
    {
        return $this->db->table('ac')
            ->select('eino, cname, cfname, TO_CHAR(regdate, \'DD-MM-YYYY\') as formatted_regdate, id')
            ->where('aor_code', $aorCode)
            ->orderBy('eino')
            ->get()
            ->getResultArray();
    }


    public function getTransactions($acid)
    {
        return $this->db->table('transactions a')
            ->select('a.id, acid, event_name, TO_CHAR(event_date, \'DD-MM-YYYY\') as formatted_event_date, remarks')
            ->join('master.event_master b', 'b.event_code = a.event_code')
            ->where('acid', $acid)
            ->orderBy('a.event_code')
            ->get()
            ->getResultArray();
    }
    public function getCancelRecords()
    {
        return $this->db->table('ac')
            ->select('bar.name, ac.cname, ac.cfname, ac.eino, TO_CHAR(ac.regdate, \'DD-MM-YYYY\') as formatted_regdate, ac.aor_code, TO_CHAR(transactions.event_date, \'DD-MM-YYYY\') as formatted_event_date')
            ->join('master.bar', 'bar.aor_code = ac.aor_code')
            ->join('transactions', 'transactions.acid = ac.id', 'left')
            ->where('transactions.event_code', 3)
            ->orderBy('transactions.event_date', 'desc')
            ->orderBy('bar.name')
            ->get()
            ->getResultArray();
    }
    public function getDuplicateRecords()
    {
        $builder = $this->db->table('ac a');
        $builder->select('eino, aor_code, COUNT(*) as count');
        $builder->groupBy('eino, aor_code');
        $builder->having('COUNT(*) > 2');
        $builder->orderBy('eino', 'desc');

        return $builder->get()->getResultArray();
    }

    public function getClerksAttachedWithAORs($eino)
    {
        $builder = $this->db->table('ac');
        $builder->select('bar.name, ac.cname, ac.cfname, ac.eino, TO_CHAR(ac.regdate, \'DD-MM-YYYY\') as formatted_regdate, ac.aor_code');
        $builder->join('master.bar', 'bar.aor_code = ac.aor_code');
        $builder->where('ac.eino', $eino);
        $builder->orderBy('ac.aor_code');

        return $builder->get()->getResultArray();
    }
    public function getAORDetails()
    {
        return $this->db->table('master.bar')
            ->select('*')
            ->where(['isdead' => 'N', 'if_aor' => 'Y'])
            ->orderBy('aor_code')
            ->get()
            ->getResultArray();
    }

    public function getClerksWithMoreThan2AORs()
    {
        $query = $this->db->table('ac')
            ->select('eino, COUNT(*) as aor_count')
            ->groupBy('eino')
            ->having('COUNT(*) > 2')
            ->orderBy('eino', 'desc')
            ->get();

        return $query->getResultArray();
    }
    public function getClerkDetailsByEino($eino)
    {
        $query = $this->db->table('ac a')
            ->join('master.bar b', 'b.aor_code = a.aor_code')
            ->select('b.name, cname, cfname, eino, TO_CHAR(regdate, \'DD-MM-YYYY\') as regdate, a.aor_code, cmobile')
            ->where('eino', $eino)
            ->orderBy('a.aor_code')
            ->get();

        return $query->getResultArray();
    }
    public function getdept()
    {
        $query = $this->db->table('master.users a')
            ->select('dept_name, udept')
            ->join('master.userdept  b', 'a.udept=b.id')
            ->distinct('dept_name, udept')
            ->where('b.id', 3)
            ->get();

        return $query->getResultArray();
    }
    public function getuser($ucode)
    {

        $query = $this->db->table('master.users a')
            ->select('usertype, section, udept, usercode')
            ->where('usercode', $ucode)
            ->get();

        return $query->getRowArray();
    }
    public function insert1($data)
    {
        try {
            $this->db->table('ac')->insert($data);
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Error inserting data into the database: ' . $e->getMessage());
           echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}
