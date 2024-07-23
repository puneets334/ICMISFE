<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class LastHeardtWebuse extends Entity
{
    protected $db;
    protected $table      = 'last_heardt_webuse';
    //protected $primaryKey = 'id';
    //protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'conn_key', 'next_dt', 'mainhead', 'subhead', 'clno', 'brd_slno', 'roster_id', 'judges', 'coram', 'board_type', 'usercode', 'ent_dt', 'module_id', 'mainhead_n', 'subhead_n', 'main_supp_flag', 'listorder', 'tentative_cl_dt', 'bench_flag', 'lastorder', 'listed_ia', 'sitting_judges', 'list_before_remark', 'coram_del_res', 'is_nmd', 'no_of_time_deleted', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}