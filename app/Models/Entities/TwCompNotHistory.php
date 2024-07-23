<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TwCompNotHistory extends Entity
{
    protected $db;
    protected $table      = 'tw_comp_not_history';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'tw_comp_not_id', 'tw_o_r_id', 'tw_sn_to', 'sendto_state', 'sendto_district', 'copy_type', 'send_to_type', 'serve', 'ser_type', 'ser_date', 'ser_dt_ent_dt', 'ack_user_id', 'dis_da_dt', 'da_rec_dt', 'ack_id', 'remark', 'l_ljs_rem', 'l_hjs_rem', 'l_ljs_p_d', 'l_hjs_p_d', 'l_ljs_pt', 'l_hjs_pt', 't_ljs_p_d', 't_hjs_p_d', 't_ljs_rem', 't_hjs_rem', 'station', 'weight', 'stamp', 'dis_remark', 'dispatch_user_id', 'dispatch_dt', 'dispatch_id', 'barcode', 'm_d', 'send_mail_dt', 'display', 'update_by', 'update_on', 'p_id', 'pid_year', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}