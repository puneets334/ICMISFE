<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SmsWeekly extends Entity
{
    protected $db;
    protected $table      = 'sms_weekly';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'mobile', 'aor_code', 'list_number', 'list_year', 'diary_numbers', 'display', 'created_on', 'created_by', 'updated_on', 'updated_by', 'update_counter', 'sent_to_smspool', 'email', 'email_sent', 'email_sent_on', 'email_error', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}