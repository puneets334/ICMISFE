<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class MCourtFeeValuation extends Entity
{
    protected $db;
    protected $table      = 'master.m_court_fee_valuation';

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'court_fee_id', 'from_valuation', 'to_valuation', 'for_added_valuation', 'added_amount', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
