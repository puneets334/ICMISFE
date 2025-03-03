<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class LowerctHistory extends Entity
{
    protected $db;
    protected $table      = 'lowerct_history';
    // protected $primaryKey = 'id';

    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'lct_dec_dt', 'lct_judge_desg', 'lct_judge_name', 'lctjudname2', 'lct_jud_id', 'lct_jud_id1', 'lct_jud_id2', 'lct_jud_id3', 'l_dist', 'polstncode', 'crimeno', 'crimeyear', 'usercode', 'ent_dt', 'lctjudname3', 'ct_code', 'doi', 'hjs_cnr', 'ljs_doi', 'ljs_cnr', 'l_state', 'lower_court_id', 'lw_display', 'brief_desc', 'sub_law', 'l_inddep', 'l_iopb', 'l_iopbn', 'l_org', 'l_orgname', 'l_ordchno', 'lct_casetype', 'lct_caseno', 'lct_caseyear', 'is_order_challenged', 'full_interim_flag', 'judgement_covered_in', 'vehicle_code', 'vehicle_no', 'cnr_no', 'ref_court', 'ref_case_type', 'ref_case_no', 'ref_case_year', 'ref_state', 'ref_district', 'gov_not_state_id', 'gov_not_case_type', 'gov_not_case_no', 'gov_not_case_year', 'gov_not_date', 'fir_lodge_date', 'deleted_by', 'delete_datetime', 'delete_userip', 'updated_by', 'update_datetime', 'update_userip', 'create_modify', 'updated_on', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}