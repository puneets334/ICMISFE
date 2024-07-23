<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class PostEnvelopeMovement extends Entity
{
    protected $db;
    protected $table      = 'post_envelope_movement';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'envelop_type', 'max_pages_limit', 'envelop_weight', 'glue_pinup_weight', 'display', 'from_date', 'to_date', 'entry_time', 'usercode', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}