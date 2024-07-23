<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class NjdgTransaction extends Entity
{
    protected $db;
    protected $table      = 'njdg_transaction';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['cino', 'filcase_type', 'fil_case_type_nc_full_name', 'fil_case_type_nc', 'fil_case_type_nc_name', 'fil_case_type_nc_type', 'fil_case_type_name_in_est', 'fil_no', 'fil_year', 'filing_no', 'regcase_type_full_name', 'regcase_type_nc', 'regcase_type_nc_name', 'regcase_type_nc_full_name', 'regcase_type_nc_type', 'regcase_type_name_in_est', 'reg_no', 'reg_year', 'regcase_type', 'case_no', 'main_case_no', 'main_matter_cino', 'maincase_filing_no', 'pet_name', 'pet_gender', 'pet_dob', 'pet_age', 'pet_sex', 'pet_adv', 'pet_adv_bar_regn', 'hide_pet_name', 'res_name', 'res_dob', 'res_age', 'res_sex', 'res_gender', 'hide_res_name', 'res_adv', 'res_bar_regn', 'purpose_today', 'purpose_today_nc', 'purpose_today_nc_type', 'purpose_today_nc_name', 'purpose_today_name_in_est', 'purpose_prev', 'purpose_prev_nc', 'purpose_prev_nc_type', 'purpose_prev_nc_name', 'purpose_prev_name_in_est', 'purpose_next', 'purpose_next_nc', 'purpose_next_nc_type', 'purpose_next_nc_name', 'disp_nature', 'disp_nature_o', 'disp_nature_nc', 'disp_nature_nc_group', 'disp_nature_nc_name', 'disp_nature_name_in_est', 'est_code', 'est_name', 'case_info_time_stamp', 'date_of_filing', 'dt_regis', 'date_filing_disp', 'date_first_list', 'date_last_list', 'date_next_list', 'date_of_decision', 'date_of_decision_o', 'court_no', 'judge_name_all', 'judge_name_in_est', 'jocode', 'create_modify', 'disposal_year', 'hide_partyname', 'ci_cri', 'diary_no', 'cino_conversion', 'main_casetype_history_id', 'insert_date_time', 'entry_source_flag', 'jocode_count', 'category_id', 'category_name', 'sub_category_id', 'sub_category_name', 'mainhead', 'main_supp_flag', 'next_dt', 'board_type', 'from_cino_conversion', 'to_cino_conversion', 'icmis_registration_no', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}