<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TblCourtRequisition extends Entity
{
    protected $db;
    protected $table      = 'master.tbl_court_requisition';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'court_number', 'court_username', 'remark1', 'remark2', 'current_status', 'section', 'user_type', 'itemno', 'itemdate', 'request_file', 'request_close_datetime', 'user_ip', 'urgent', 'court_bench', 'created_on', 'created_by', 'updated_on', 'updated_by', 'status', 'alternate_number', 'diary_no', 'advocate_name', 'appearing_for', 'party_serial_no', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}