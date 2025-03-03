<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SmsDropCl extends Entity
{
    protected $db;
    protected $table      = 'sms_drop_cl';
    // protected $primaryKey = 'id';

    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['mobile', 'diary_no', 'next_dt', 'court', 'roster_id', 'brd_slno', 'ent_time', 'cno', 'qry_from', 'sent_to_smspool', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}