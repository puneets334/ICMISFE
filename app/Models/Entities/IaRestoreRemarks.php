<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class IaRestoreRemarks extends Entity
{
    
    protected $table      = 'ia_restore_remarks';
    // protected $primaryKey = 'hf_id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'docnum', 'docyear', 'docd_id', 'restoration_remarks', 'updated_by', 'updated_on', 'ip_address', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}