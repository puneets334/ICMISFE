<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RefAgencyState extends Entity
{
    protected $db;
    protected $table      = 'master.ref_agency_state';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'agency_state', 'adm_updated_by', 'updated_on', 'is_deleted', 'agency_state_code', 'cmis_state_id', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}