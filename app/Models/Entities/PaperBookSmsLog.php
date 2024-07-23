<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class PaperBookSmsLog extends Entity
{
    protected $db;
    protected $table      = 'paper_book_sms_log';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'mobile', 'msg', 'send_by', 'send_date_time', 'ip_address', 'send_status', 'sms_for', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}