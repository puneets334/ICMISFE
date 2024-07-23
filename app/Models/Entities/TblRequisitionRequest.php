<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TblRequisitionRequest extends Entity
{
    protected $db;
    protected $table      = 'tbl_requisition_request';
    // protected $primaryKey = 'id';

    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'request_id', 'request_user_id', 'req_user_type', 'request_data', 'request_file', 'created_on', 'issue_type', 'issue_date', 'issued_by', 'issued_remark', 'status', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}