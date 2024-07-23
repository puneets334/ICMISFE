<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class ListedInfo extends Entity
{
    protected $db;
    protected $table      = 'listed_info';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'next_dt', 'main_supp', 'remark', 'mainhead', 'bench_flag', 'fix_dt', 'mentioning', 'week_commencing', 'freshly_filed', 'freshly_filed_adj', 'part_heard', 'inperson', 'bail', 'after_week', 'imp_ia', 'ia', 'nr_adj', 'adm_order', 'ordinary', 'total', 'usercode', 'ent_dt', 'roster_id', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}