<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TwTalDel extends Entity
{
    protected $db;
    protected $table      = 'tw_tal_del';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'process_id', 'diary_no', 'sr_no', 'pet_res', 'rec_dt', 'name', 'address', 'nt_type', 'print', 'amount', 'user_id', 'display', 'amt_wor', 'tal_state', 'tal_district', 'fixed_for', 'sub_tal', 'lok_reg', 'enrol_no', 'enrol_yr', 'order_dt', 'office_notice_rpt', 'notice_path', 'web_status', 'individual_multiple', 'published_by', 'userip', 'published_on', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}