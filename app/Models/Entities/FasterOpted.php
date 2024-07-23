<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class FasterOpted extends Entity
{
    
    protected $table      = 'faster_opted';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'diary_no', 'conn_key', 'next_dt', 'mainhead', 'board_type', 'roster_id', 'main_supp_flag', 'judges', 'user_id', 'entry_date', 'user_ip', 'is_active', 'deleted_by', 'deleted_date', 'deleted_ip', 'court_no', 'item_number', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}