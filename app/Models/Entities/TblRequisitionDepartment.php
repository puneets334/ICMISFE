<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TblRequisitionDepartment extends Entity
{
    protected $db;
    protected $table      = 'tbl_requisition_department';
    // protected $primaryKey = 'id';

    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'requisition_dep_name', 'status', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}