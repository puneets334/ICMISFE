<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TokenStatus extends Entity
{
    protected $db;
    protected $table      = 'master.token_status';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'pending', 'resolved', 'technical_issue', 'in_process', 'resolved_by_tt', 'pending_from', 'pending_to', 'technical_issue_from', 'technical_issue_to', 'resolved_date_by_tt', 'resolved_by_dmt', 'resolved_dmt_user', 'technical_issue_dmt_user', 'technical_issue_assign_to', 'resolved_by_tt_user', 'technical_issue_assign_date', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}