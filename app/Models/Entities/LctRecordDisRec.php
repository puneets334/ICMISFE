<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class LctRecordDisRec extends Entity
{
    protected $db;
    protected $table      = 'lct_record_dis_rec';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'lowerct_id', 'tw_comp_not_id', 'lct_remark', 'display', 'user_id', 'ent_date', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}