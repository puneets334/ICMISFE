<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class ShowlCdHistory extends Entity
{
    protected $db;
    protected $table      = 'showlcd_history';
    // protected $primaryKey = 'id';

    // protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['court', 'mf', 'cl_dt', 'csno', 'parties', 'clno', 'msg', 'ent_dt', 'ent_dttime', 'judges_list', 'fil_no', 'jcodes', 'sbdb', 'ent_by', 'is_mentioning', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}