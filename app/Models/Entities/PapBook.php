<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class PapBook extends Entity
{
    protected $db;
    protected $table      = 'pap_book';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'fil_no', 'con_fil', 'dis_dt', 'dis_id', 'estimate_y_n', 'pab_rec_dt', 'no_of_cps', 'pab_rec_id', 'adv_mn', 'no_of_pg', 'est_cost', 'pb_user_id', 'pb_rec_dt', 'est_print', 'print', 'def_status', 'da_send_dt', 'or_cost', 'org_cost_re_dt', 'org_cost_u_id', 'phocp_rec_dt', 'phocp_us_id', 'ready', 'rd_user_id', 'rd_date', 'display', 'dis_link', 'supreme_rec_dt', 'supreme_disp_dt', 'pab_rec_dt_1', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}