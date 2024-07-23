<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class WeeklyList extends Entity
{
    protected $db;
    protected $table      = 'weekly_list';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['item_no', 'diary_no', 'conn_key', 'next_dt', 'from_dt', 'to_dt',  'courtno','judges_code','listorder','usercode','ent_dt','weekly_no','weekly_year', 'create_modify','updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}