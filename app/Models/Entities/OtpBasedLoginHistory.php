<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class OtpBasedLoginHistory extends Entity
{
    protected $db;
    protected $table      = 'otp_based_login_history';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'updated_by', 'otp_send_time', 'otp_entered_time', 'otp_session_start_time', 'otp_session_logout_time', 'next_dt', 'mainhead', 'board_type', 'main_supp_flag', 'no_of_times_used', 'display', 'create_modify', 'updated_on', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}