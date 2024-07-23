<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class LcHcCasetype extends Entity
{
    protected $db;
    protected $table      = 'lc_hc_casetype';
     //protected $primaryKey = 'id';

    //protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['lccasecode', 'lccasename', 'corttyp', 'display', 'type_sname', 'case_type', 'id', 'is_deleted', 'ref_agency_state_id', 'ref_agency_code_id', 'cmis_state_id', 'ent_user', 'ent_time', 'ent_ip_address', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}