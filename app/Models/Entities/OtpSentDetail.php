<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class OtpSentDetail extends Entity
{
    protected $db;
    protected $table      = 'otp_sent_detail';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'otp_based_login_history_id', 'usercode', 'otp_sent', 'otp_sent_time', 'otp_entered', 'otp_entered_time', 'no_of_times_wrong_attemt', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}