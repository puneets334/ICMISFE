<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class Roster extends Entity
{
    protected $db;
    protected $table      = 'master.roster';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'bench_id', 'from_date', 'to_date', 'entry_dt', 'display', 'courtno', 'm_f', 'frm_time', 'tot_cases', 'session', 'judges', 'if_print_in', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}