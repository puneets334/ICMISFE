<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TblRequisitionInteractions extends Entity
{
    protected $db;
    protected $table      = 'tbl_requisition_interactions';
    // protected $primaryKey = 'id';

    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'requisition_id', 'interaction_remarks', 'request_file', 'created_on', 'created_by', 'interaction_status', 'read_status', 'read_staus_time', 'read_status_librarian', 'read_status_librarian_time', 'itemno', 'interaction_ip', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}