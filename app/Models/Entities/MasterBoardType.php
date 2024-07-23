<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class MasterBoardType extends Entity
{
    protected $db;
    protected $table      = 'master.master_board_type';

    protected $primaryKey = 'board_id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['board_id', 'board_display', 'board_name', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
