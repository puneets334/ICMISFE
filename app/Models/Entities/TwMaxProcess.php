<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TwMaxProcess extends Entity
{
    protected $db;
    protected $table      = 'master.tw_max_process';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'year', 'processid', 'tw_max_ack', 'tw_disp_id', 'tw_disp_reg', 'tw_disp_adv_reg', 'office_report', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}