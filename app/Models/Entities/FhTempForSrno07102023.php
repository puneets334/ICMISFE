<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class FhTempForSrno07102023 extends Entity
{
    
    protected $table      = 'fh_temp_for_srno_07_10_2023';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['sno2', 'sno', 'last_head', 'actual_head', 'diary_no', 'submaster_id', 'sub_name1', 'sub_name2', 'sub_name3', 'sub_name4', 'subcode1', 'subcode2', 'subcode3', 'subcode4', 'diary_no_rec_date', 'n_dt', 'next_dt', 'clno', 'brd_slno', 'conn_key', 'mondayofweek', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}