<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class VernacularOrdersJudgments extends Entity
{
    protected $db;
    protected $table      = 'vernacular_orders_judgments';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'order_date', 'ref_vernacular_languages_id', 'pdf_name', 'user_code', 'entry_date', 'order_type', 'web_status', 'display', 'ordertextdata', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}