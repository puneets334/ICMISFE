<?php

namespace App\Controllers\Filing;
use App\Controllers\BaseController;
use CodeIgniter\Controller;
use App\Models\Filing\AdvocateModel;
class Advocate extends BaseController
{
    public $model;
    public $diary_no;

    function __construct()
    {

        $this->model = new AdvocateModel();

        if (empty(session()->get('filing_details')['diary_no'])) {
            $uri = current_url(true);
            $getUrl = $uri->getSegment(1).'-'.$uri->getSegment(2);
            header('Location:'.base_url('Filing/Diary/search?page_url='.base64_encode($getUrl)));exit();
            exit();
        } else {
            $this->diary_no = session()->get('filing_details')['diary_no'];
        }
    }

    public function index($get_party_type = '')
    {
        $diary_no = $this->diary_no;

        $get_main = $this->model->get_main_tbl_data($diary_no);

        if ($get_party_type != '') {


            $get_data_arr = explode('-', $get_party_type);
            $get_pet_res = $get_data_arr[0];
            $get_sr_no_show = $get_data_arr[1];
            $get_adv_type = $get_data_arr[2];
            $get_advocate_id = $get_data_arr[3];

            $data['state_list'] = get_from_table_json('state');

            $data['get_party_edit'] = $this->model->get_party_by_sr_no_show($diary_no, $get_pet_res, $get_sr_no_show);
            $data['get_pet_res'] = $get_pet_res;
            $data['get_party_type'] = $get_party_type;
            $data['get_advocate_edit'] = $this->model->get_advocate_by_sr_no_show($diary_no, $get_pet_res, $get_sr_no_show, $get_adv_type, $get_advocate_id);
            
            if($data['get_advocate_edit']){
                $bar_id = $data['get_advocate_edit'][0]['advocate_id'];
                $aor_state = $data['get_advocate_edit'][0]['aor_state'];
                $get_adv_selected_data = $data['get_advocate_edit'][0]['adv'];
                $inperson_mobile = $data['get_advocate_edit'][0]['inperson_mobile'];
                $inperson_email = $data['get_advocate_edit'][0]['inperson_email'];
            }else{
                $bar_id = 0;
                $aor_state = '';
                $get_adv_selected_data = '';
                $inperson_mobile = '';
                $inperson_email = '';
            }

            $data['get_bar_detail'] = $this->model->bar_detail_by_bar_id($bar_id);

            $data['aor_state'] = $aor_state;

            if($data['get_bar_detail']){
                $bar_id = $data['get_bar_detail'][0]['aor_code'];
                $name = $data['get_bar_detail'][0]['name'];
                $enroll_no = $data['get_bar_detail'][0]['enroll_no'];
                $enroll_date = $data['get_bar_detail'][0]['enroll_date'];
            }else{
                $bar_id = '';
                $name = '';
                $enroll_no = '';
                $enroll_date = '';
            }
            $data['bar_id'] = $bar_id;
            $data['name'] = $name;
            $data['enroll_no'] = $enroll_no;
            $data['enroll_date'] = $enroll_date;
            $data['get_sr_no_show'] = $get_sr_no_show;
            $data['get_adv_selected_data'] = $get_adv_selected_data;
            $data['inperson_mobile'] = $inperson_mobile;
            $data['inperson_email'] = $inperson_email;


        } else {

            $data['get_pet_res'] = '';
            $data['get_party_edit'] = [];
            $data['get_party_type'] = $get_party_type;
            $data['get_advocate_edit'] = '';
            $data['get_bar_detail'] = '';
            $data['aor_state'] = '';
            $data['bar_id'] = '';
            $data['name'] = '';
            $data['enroll_no'] = '';
            $data['enroll_date'] = '';
            $data['get_sr_no_show'] = '';
            $data['get_adv_selected_data'] = '';
            $data['inperson_mobile'] = '';
            $data['inperson_email'] = '';

        }

        $main_row['c_status'] = '';

        foreach($get_main as $get_main_val):
            $main_row['c_status'] = $get_main_val['c_status'];
            $main_row['q'] = $get_main_val['q'];
        endforeach;

        $data['state_list'] = get_from_table_json('state');

        $data['party'] = $this->model->get_party($diary_no, 'P');

        $data['main_row'] = $main_row;

        return view('Filing/advocate', $data);
    }

    public function addAdvocate()
    {
        $diary_no = $this->diary_no;

        if ($this->request->getPost('sub')) {

            $get_party = $this->request->getPost('get_party');
            $party_name = $this->request->getPost('party_name');
            $category = $this->request->getPost('category');
            $type = $this->request->getPost('type');
            $adv_detail = $this->request->getPost('adv_detail');
            $state = $this->request->getPost('state');
            $aor_code = $this->request->getPost('aor_code');
            $adv_year = $this->request->getPost('adv_year');
            $adv_name = $this->request->getPost('adv_name');
            $if_ag = $this->request->getPost('if_ag');
            $state_adv = $this->request->getPost('state_adv');
            $inperson_mob = $this->request->getPost('inperson_mob');
            $inperson_email = $this->request->getPost('inperson_email');

            $f = '';

            if ($get_party == 'P' || $get_party == 'R') {
                if ($adv_detail == 'S') {
                    $type = 'S';
                }
            }

            if ($adv_detail == 'A') {
                $get_advocate = $this->model->check_aor_exist($aor_code);
                $advocate_id = $get_advocate[0]['bar_id'];
                if ($advocate_id == 0) {
                    echo "AOR- $aor_code NOT FOUND";
                }
            } elseif ($adv_detail == 'S') {
                $get_advocate = $this->model->check_aor_exist_with_state($state, $aor_code, $adv_year);
                $advocate_id = $get_advocate[0]['bar_id'];
                if ($advocate_id == 0) {
                    echo "ADV - $state/$aor_code/$adv_year NOT FOUND";
                }
            } elseif ($adv_detail == 'AC') {
                $adv_detail = 'N';
                $f = 'Y';
                $get_advocate = $this->model->check_aor_exist_with_state($state, $aor_code, $adv_year);
                $advocate_id = $get_advocate[0]['bar_id'];
                if ($advocate_id == 0) {
                    echo "ADV - $state/$aor_code/$adv_year NOT FOUND";
                }
            }


            if ($get_party == 'P' || $get_party == 'R') {

                foreach ($party_name as $party_val):

                    $party_arr = explode('/', $party_val);
                    $p_no = $party_arr[0];
                    $p_no_show = $party_arr[1];

                    $state_adv = '';

                    if (is_numeric($p_no)) {

                        if ($category == '') {
                            $category = 'A';
                        }

                        $check = $this->model->advocate($diary_no, $advocate_id, $get_party, $state_adv);

                        if ($check == 0 || $aor_code == '9999' || $adv_name == '2014') {

                            if ($p_no_show != 0) {
                                $adv_name = '[' . $get_party . '-' . $p_no_show . ']';

                            }

                            if ($get_party == 'P' || $get_party == 'R') {
                                if ($type != 'N') {
                                    $adv_name .= '[' . $type . ']';
                                }

                                if ($if_ag == 'AG') {
                                    $adv_name .= '[AG]';
                                }

                                if ($this->request->getPost('state_adv') == 'P') {
                                    $adv_name .= '[Pr]';
                                }

                                if ($this->request->getPost('state_adv') == 'G') {
                                    $adv_name .= '[Gr]';
                                }
                            }

                            $ins_arr = [
                                'diary_no' => $diary_no,
                                'adv_type' => $category,
                                'pet_res' => $get_party,
                                'pet_res_no' => $p_no,
                                'pet_res_show_no' => $p_no_show,
                                'advocate_id' => $advocate_id,
                                'adv' => $adv_name,
                                'usercode' => session()->get('login')['usercode'],
                                'ent_dt' => 'NOW()',
                                'stateadv' => $state_adv,
                                'aor_state' => $adv_detail,
                                'is_ac' => $f,
                                'inperson_mobile' => $inperson_mob,
                                'inperson_email' => $inperson_email,
                                'create_modify' => date("Y-m-d H:i:s"),
                                'updated_on' => date("Y-m-d H:i:s"),
                                'updated_by' => session()->get('login')['usercode'],
                                'updated_by_ip' => getClientIP()
                            ];


                            $ins = $this->model->insert_advocate($ins_arr);

                            if($ins > 0){

                                if($p_no==1 && $p_no_show==1){

                                    if($get_party == 'P'){
                                        $column_name = 'pet_adv_id';
                                    }
                                    elseif($get_party == 'R'){
                                        $column_name = 'res_adv_id';
                                    }

                                    $upd_main_arr = [
                                        $column_name => $advocate_id,
                                        'create_modify' => date("Y-m-d H:i:s"),
                                        'updated_on' => date("Y-m-d H:i:s"),
                                        'updated_by' => session()->get('login')['usercode'],
                                        'updated_by_ip' => getClientIP()
                                    ];

                                    $this->model->update_main_pet_res_adv_id($upd_main_arr,$diary_no);
                                }
                            }

                        }

                    }

                endforeach;

                if ($ins) {
                    session()->setFlashdata('success', 'Save Successful');
                    echo '<script>alert("Save Successful")</script>';
                    echo '<script>window.location.href="' . base_url('Filing/Advocate') . '";</script>';
                    //header('Location:'.base_url('Filing/Advocate'));
                    die();
                }
            } elseif ($get_party == 'I' || $get_party == 'N') {
                $p_no = 0;
                $p_no_show = NULL;

                $state_adv = $state_adv;

                if (is_numeric($p_no)) {

                    $check = $this->model->advocate($diary_no, $advocate_id, $get_party, $state_adv);

                    if ($check == 0 || $aor_code == '9999' || $adv_name == '2014') {

                        if ($p_no_show != 0) {
                            $adv_name = '[' . $get_party . '-' . $p_no_show . ']';

                        }


                        if ($get_party == 'I' || $get_party == 'N') {
                            if ($type != 'N') {
                                $adv_name = '[' . $type . ']';
                            }

                            if ($if_ag == 'AG') {
                                $adv_name .= '[AG]';
                            }

                            if ($state_adv == 'P') {
                                $adv_name .= '[Pr]';
                            }

                            if ($state_adv == 'G') {
                                $adv_name .= '[Gr]';
                            }
                        }


                        $ins_arr = [
                            'diary_no' => $diary_no,
                            'adv_type' => $category,
                            'pet_res' => $get_party,
                            'pet_res_no' => $p_no,
                            'pet_res_show_no' => $p_no_show,
                            'advocate_id' => $advocate_id,
                            'adv' => $adv_name,
                            'usercode' => session()->get('login')['usercode'],
                            'ent_dt' => 'NOW()',
                            'stateadv' => $state_adv,
                            'aor_state' => $adv_detail,
                            'is_ac' => $f,
                            'inperson_mobile' => $inperson_mob,
                            'inperson_email' => $inperson_email,
                            'create_modify' => date("Y-m-d H:i:s"),
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => session()->get('login')['usercode'],
                            'updated_by_ip' => getClientIP()
                        ];


                        $ins = $this->model->insert_advocate($ins_arr);

                        if ($ins) {
                            session()->setFlashdata('success', 'Save Successful');
                            echo '<script>alert("Save Successful")</script>';
                            echo '<script>window.location.href="' . base_url('Filing/Advocate') . '";</script>';
                            //header('Location:'.base_url('Filing/Advocate'));
                            die();
                        }

                    }

                }

            }

        }

    }

    public function get_party_name()
    {

        $diary_no = $this->diary_no;

        $party_type = '';
        if (!empty($this->request->getPost('party_type'))) {
            $party_type = $this->request->getPost('party_type');
        }
        $party = $this->model->get_party($diary_no, $party_type);

        echo '<option value="">Select</option>';
        foreach ($party as $party_val) {
            echo '<option value="' . $party_val['sr_no'] . '/' . $party_val['sr_no_show'] . '">' . $party_val['sr_no_show'] . '-' . $party_val['partyname'] . '</option>';
        }
    }

    public function get_party_data()
    {

        $diary_no = $this->diary_no;

        $get_main = $this->model->get_main_tbl_data($diary_no);

        foreach($get_main as $get_main_val):
            $main_row['c_status'] = $get_main_val['c_status'];
            $main_row['q'] = $get_main_val['q'];
        endforeach;

        $party_type = '';
        if (!empty($this->request->getPost('party_type'))) {
            $party_type = $this->request->getPost('party_type');
        }
        $party = $this->model->get_party($diary_no, $party_type);

        $get_caveat_advocate = $this->model->get_caveat_advocate($diary_no);

        echo '<table id="example1" class="table table-hover showData">
                <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>Advocate Name</th>
                  </tr>
                </thead>';
        $html = '';

        foreach($get_caveat_advocate as $get_caveat_advocate_val):
        if($main_row['c_status']=='P'){
        if($party_type=='R'){
        $html .='<tr>
                    <td></td>
                    <td></td>
                    <td>';
        $html .= $get_caveat_advocate_val['aor_code'].'-'.$get_caveat_advocate_val['name'] . $get_caveat_advocate_val['adv'] . '&nbsp;';
        $html .= '<a href="' . base_url('Filing/advocate/index/' . $party_type . '-' . $get_caveat_advocate_val['pet_res_show_no'] . '-' . $get_caveat_advocate_val['adv_type'] . '-' . $get_caveat_advocate_val['advocate_id']) . '"><i class="fas fa-pen" aria-hidden="true"></i></a>&nbsp;<a href="' . base_url('Filing/advocate/delete/' . $party_type . '-' . $get_caveat_advocate_val['pet_res_show_no'] . '-' . $get_caveat_advocate_val['adv_type'] . '-' . $get_caveat_advocate_val['advocate_id']) . '"><i class="fas fa-trash" style="color:red;" onclick="return confirm(' . "'Are you sure want to delete'" . ');" aria-hidden="true"></i></a>';

        $html .=   '</td>
                </tr>';
        }
        }
        endforeach;                

        foreach ($party as $party_val) {
            $get_advocate = $this->model->get_advocate($diary_no, $party_type, $party_val['sr_no_show']);

            $X = '';

            $html .= '<tr>
                    <td>[' . $party_type . '-' . $party_val['sr_no_show'] . ']</td>
                    <td>' . $party_val['partyname'] . '</td>
                    <td>';

            foreach ($get_advocate as $get_advocate_val) {

                if ($get_advocate_val['is_ac'] == 'Y') {
                    if ($get_advocate_val['if_aor'] == 'Y') {
                        $advType = "AOR";
                    } elseif ($get_advocate_val['if_sen'] == 'Y') {
                        $advType = "Senior Advocate";
                    } elseif ($get_advocate_val['if_aor'] == 'N' && $get_advocate_val['if_sen'] == 'N') {
                        $advType = "NON-AOR";
                    } elseif ($get_advocate_val['if_other'] == 'Y') {
                        $advType = "Other";
                        $X = '[Amicus Curiae- ' . $advType . ']';
                    }
                } else {
                    $x = '';
                }

                if ($get_advocate_val['isdead'] == 'Y') {

                    if ($party_type == 'P') {

                        $html .= '<font color = red><del>' .$get_advocate_val['aor_code'].'-'.$get_advocate_val['name'] . $get_advocate_val['adv'] . $X . '(Dead/Retired/Elevated)' . '&nbsp;'; 
                        if($main_row['c_status']=='P'){
                            $html .= '<a href="' . base_url('Filing/advocate/index/' . $party_type . '-' . $get_advocate_val['pet_res_show_no'] . '-' . $get_advocate_val['adv_type'] . '-' . $get_advocate_val['advocate_id']) . '"><i class="fas fa-pen" aria-hidden="true"></i></a>&nbsp;<a href="' . base_url('Filing/advocate/delete/' . $party_type . '-' . $get_advocate_val['pet_res_show_no'] . '-' . $get_advocate_val['adv_type'] . '-' . $get_advocate_val['advocate_id']) . '"><i class="fas fa-trash" style="color:red;" onclick="return confirm(' . "'Are you sure want to delete'" . ');" aria-hidden="true"></i></a> ';
                        }
                            $html .= '' . '<br>' . '<del></font>';

                    } elseif ($party_type == 'R') {

                        $html .= '<font color = red><del>' .$get_advocate_val['aor_code'].'-'.$get_advocate_val['name'] . $get_advocate_val['adv'] . $X . '(Dead)' . '&nbsp;';
                        if($main_row['c_status']=='P'){
                            $html .= '<a href="' . base_url('Filing/advocate/index/' . $party_type . '-' . $get_advocate_val['pet_res_show_no'] . '-' . $get_advocate_val['adv_type'] . '-' . $get_advocate_val['advocate_id']) . '"><i class="fas fa-pen" aria-hidden="true"></i></a>&nbsp;<a href="' . base_url('Filing/advocate/delete/' . $party_type . '-' . $get_advocate_val['pet_res_show_no'] . '-' . $get_advocate_val['adv_type'] . '-' . $get_advocate_val['advocate_id']) . '"><i class="fas fa-trash" style="color:red;" onclick="return confirm(' . "'Are you sure want to delete'" . ');" aria-hidden="true"></i></a> ';
                        }
                            $html .= '' . '<br>' . '<del></font>';

                    }

                } else {

                    if ($party_type == 'P') {

                        $html .= $get_advocate_val['aor_code'].'-'.$get_advocate_val['name'] . $get_advocate_val['adv'] . $x . '&nbsp;';
                        if($main_row['c_status']=='P'){
                            $html .= '<a href="' . base_url('Filing/advocate/index/' . $party_type . '-' . $get_advocate_val['pet_res_show_no'] . '-' . $get_advocate_val['adv_type'] . '-' . $get_advocate_val['advocate_id']) . '"><i class="fas fa-pen" aria-hidden="true"></i></a>&nbsp;<a href="' . base_url('Filing/advocate/delete/' . $party_type . '-' . $get_advocate_val['pet_res_show_no'] . '-' . $get_advocate_val['adv_type'] . '-' . $get_advocate_val['advocate_id']) . '"><i class="fas fa-trash" style="color:red;" onclick="return confirm(' . "'Are you sure want to delete'" . ');" aria-hidden="true"></i></a>';
                        }
                            $html .= '' . '<br>';

                    } elseif ($party_type == 'R') {

                        $html .= $get_advocate_val['aor_code'].'-'.$get_advocate_val['name'] . $get_advocate_val['adv'] . $x . '&nbsp;';
                        if($main_row['c_status']=='P'){
                            $html .= '<a href="' . base_url('Filing/advocate/index/' . $party_type . '-' . $get_advocate_val['pet_res_show_no'] . '-' . $get_advocate_val['adv_type'] . '-' . $get_advocate_val['advocate_id']) . '"><i class="fas fa-pen" aria-hidden="true"></i></a>&nbsp;<a href="' . base_url('Filing/advocate/delete/' . $party_type . '-' . $get_advocate_val['pet_res_show_no'] . '-' . $get_advocate_val['adv_type'] . '-' . $get_advocate_val['advocate_id']) . '"><i class="fas fa-trash" style="color:red;" onclick="return confirm(' . "'Are you sure want to delete'" . ');" aria-hidden="true"></i></a>';
                        }
                            $html .= '' . '<br>';

                    }

                }

            }

            $html .= '</td></tr>';
        }
        $html .= '</table>';

        echo $html;
    }

    public function get_party_data_imp_int()
    {

        $diary_no = $this->diary_no;

        $get_main = $this->model->get_main_tbl_data($diary_no);

        foreach($get_main as $get_main_val):
            $main_row['c_status'] = $get_main_val['c_status'];
            $main_row['q'] = $get_main_val['q'];
        endforeach;

        $party_type = '';
        if (!empty($this->request->getPost('party_type'))) {
            $party_type = $this->request->getPost('party_type');
        }

        $get_advocate_imp_int = $this->model->get_advocate_impleading_intervenor($diary_no, $party_type);

        echo '<table id="example1" class="table table-hover showData">
                <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Advocate Name</th>
                    <th>Delete</th>
                  </tr>
                </thead>';
        $html = '';
        $i = 1;
        foreach ($get_advocate_imp_int as $imp_int_val) {

            $html .= '<tr>
                    <td>' . $i++ . '</td>
                    <td>' .$imp_int_val['aor_code'].'-'. $imp_int_val['name'] . $imp_int_val['adv'] . '';

                    if(!empty($imp_int_val['inperson_mobile'])){
                $html .= '<br>'.'<b>Mob - </b>'.$imp_int_val['inperson_mobile'];
                    }

                    if(!empty($imp_int_val['inperson_email'])){
                $html .= ', '.'<b>Email - </b>'.$imp_int_val['inperson_email'];
                    }

                $html .= '</td>';

                    if($main_row['c_status']=='P'){
            $html .= '<td><a href="' . base_url('Filing/advocate/delete_imp/' . $party_type . '-' . $imp_int_val['adv_type'] . '-' . $imp_int_val['advocate_id']) . '"><i class="fas fa-trash" style="color:red;" onclick="return confirm(' . "'Are you sure want to delete'" . ');" aria-hidden="true"></i></a></td>
                    <td>';
                    }

            $html .= '</td></tr>';
        }
        $html .= '</table>';

        echo $html;

    }

    public function updateAdvocate()
    {
        $diary_no = $this->diary_no;

        if ($this->request->getPost('sub')) {

            $get_party_type = $this->request->getPost('get_party_type');
            $adv_detail = $this->request->getPost('adv_detail');
            $state = $this->request->getPost('state');
            $aor_code = $this->request->getPost('aor_code');
            $adv_year = $this->request->getPost('adv_year');
            $adv_name = $this->request->getPost('adv_name');
            $type = $this->request->getPost('type');
            $if_ag = $this->request->getPost('if_ag');
            $state_adv = $this->request->getPost('state_adv');
            $inperson_mob = $this->request->getPost('inperson_mob');
            $inperson_email = $this->request->getPost('inperson_email');


            $get_data_arr = explode('-', $get_party_type);
            $get_pet_res = $get_data_arr[0];
            $get_sr_no_show = $get_data_arr[1];
            $get_adv_type = $get_data_arr[2];
            $get_advocate_id = $get_data_arr[3];


            if($get_pet_res=='P'){

                if($aor_code == 799 || $aor_code == 1034 || $aor_code == 1372){
                    $inperson_mob = $inperson_mob;
                    $inperson_email = $inperson_email;
                }else{
                    $inperson_mob = '';
                    $inperson_email = '';
                }
            }
            elseif($get_pet_res=='R'){

                if($aor_code == 800 || $aor_code == 616 || $aor_code == 1034 || $aor_code == 1372 || $aor_code == 892){
                    $inperson_mob = $inperson_mob;
                    $inperson_email = $inperson_email;
                }else{
                    $inperson_mob = '';
                    $inperson_email = '';
                }
            }


            if($get_pet_res=='R' && $get_sr_no_show==0){
                $adv_name = '[caveat]';
            }else{
                $adv_name = '[' . $get_pet_res . '-' . $get_sr_no_show . ']';
            }

            if ($type != 'N') {
                $adv_name .= '[' . $type . ']';
            }

            if ($if_ag == 'AG') {
                $adv_name .= '[AG]';
            }

            if ($state_adv == 'P') {
                $adv_name .= '[Pr]';
            } elseif ($state_adv == 'G') {
                $adv_name .= '[Gr]';
            }

            if ($adv_detail == 'A') {
                $get_advocate = $this->model->check_aor_exist($aor_code);
                $advocate_id = $get_advocate[0]['bar_id'];
            } elseif ($adv_detail == 'S') {
                $get_advocate = $this->model->check_aor_exist_with_state($state, $aor_code, $adv_year);
                $advocate_id = $get_advocate[0]['bar_id'];
            } elseif ($adv_detail == 'AC') {
                $get_advocate = $this->model->check_aor_exist_with_state($state, $aor_code, $adv_year);
                $advocate_id = $get_advocate[0]['bar_id'];
            }

            $upd_arr = [

                'advocate_id' => $advocate_id,
                'adv' => $adv_name,
                'usercode' => session()->get('login')['usercode'],
                //'ent_dt' => 'NOW()',
                'stateadv' => $state_adv,
                'aor_state' => $adv_detail,
                'inperson_mobile' => $inperson_mob,
                'inperson_email' => $inperson_email,
                'create_modify' => date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => session()->get('login')['usercode'],
                'updated_by_ip' => getClientIP()
            ];

            $upd = $this->model->update_advocate($upd_arr, $diary_no, $get_pet_res, $get_sr_no_show, $get_adv_type, $get_advocate_id);

            if($upd > 0){

                if($get_pet_res=='P' || $get_pet_res=='R'){
                    if($get_sr_no_show == 1){

                        if($get_pet_res == 'P'){
                            $column_name = 'pet_adv_id';
                        }
                        elseif($get_pet_res == 'R'){
                            $column_name = 'res_adv_id';
                        }

                        $upd_main_arr = [
                            $column_name => $advocate_id,
                            'create_modify' => date("Y-m-d H:i:s"),
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => session()->get('login')['usercode'],
                            'updated_by_ip' => getClientIP()
                        ];

                        $this->model->update_main_pet_res_adv_id($upd_main_arr,$diary_no);
                    }
                }  
            }

            if ($upd) {
                session()->setFlashdata('success', 'Updated Successful');
                echo '<script>alert("Updated Successful")</script>';
                echo '<script>window.location.href="' . base_url('Filing/Advocate') . '";</script>';
                //header('Location:'.base_url('Filing/Advocate'));
                die();
            }
        }
    }

    public function delete($del_data)
    {

        $diary_no = $this->diary_no;

        $get_data_arr = explode('-', $del_data);
        $get_pet_res = $get_data_arr[0];
        $get_sr_no_show = $get_data_arr[1];
        $get_adv_type = $get_data_arr[2];
        $get_advocate_id = $get_data_arr[3];

        $del = $this->model->delete_advocate($diary_no, $get_pet_res, $get_sr_no_show, $get_adv_type, $get_advocate_id);

        if ($del) {
            session()->setFlashdata('success', 'Deleted Successful');
            echo '<script>alert("Deleted Successful")</script>';
            echo '<script>window.location.href="' . base_url('Filing/Advocate') . '";</script>';
            //header('Location:'.base_url('Filing/Advocate'));
            die();
        }

    }

    public function delete_imp($del_data)
    {

        $diary_no = $this->diary_no;

        $get_data_arr = explode('-', $del_data);
        $get_pet_res = $get_data_arr[0];
        $get_adv_type = $get_data_arr[1];
        $get_advocate_id = $get_data_arr[2];

        $del = $this->model->delete_advocate_imp($diary_no, $get_pet_res, $get_adv_type, $get_advocate_id);

        if ($del) {
            session()->setFlashdata('success', 'Deleted Successful');
            echo '<script>alert("Deleted Successful")</script>';
            echo '<script>window.location.href="' . base_url('Filing/Advocate') . '";</script>';
            //header('Location:'.base_url('Filing/Advocate'));
            die();
        }

    }

    public function search_advocate()
    {

        $diary_no = $this->diary_no;

        return view('Filing/search_advocate');
    }

    public function get_advocate_name()
    {

        $diary_no = $this->diary_no;

        $q = $this->request->getGet('term');

        if (!$q) return;

        $res = $this->model->get_advocate_name($q);
        $json=array();

        foreach($res as $res_val):
            $json[]=array('value'=>$res_val['data'],'label'=>$res_val['name']);
        endforeach;

        echo json_encode($json);
    }

    public function get_advocate_name_by_aor_code(){

        $diary_no = $this->diary_no;

        $get_aor_code = $this->request->getPost('get_aor_code');

        $res = $this->model->get_advocate_name_by_aor_code($get_aor_code);

        if(!empty($res)){
            echo json_encode($res);
        }else{
            echo json_encode(['err'=>'0']);
        }
    }

    public function bar_detail()
    {

        if (!empty($this->request->getPost('advocate_detail'))) {
            $advocate_detail = $this->request->getPost('advocate_detail');
            $adv_no = $this->request->getPost('adv_no');
            $adv_year = $this->request->getPost('adv_year');
            $stateID = $this->request->getPost('stateID');
        }
        $bar_detail = $this->model->bar_detail($advocate_detail, $adv_no, $adv_year, $stateID);

        echo isset($bar_detail[0]['name']) ? $bar_detail[0]['name'] : NULL;
    }

    public function show_add_caveator()
    {

        $filing_details = session()->get('filing_details');
//        echo "<pre>";
//        print_r($filing_details);
//        die;
        if (!empty($filing_details)) {
            $petitionerName = $filing_details['pet_name'];
            $respondentName = $filing_details['res_name'];
            $caseStatus = $filing_details['c_status'];
        }

        $aorcode = $this->model->select_aor_code();

        if(empty($aorcode))
        {
            $aorcode = '';
        }
//        echo "<pre>";
//        print_r($aorCode);die;

        $data = array('pet_name' => $petitionerName, 'res_name' => $respondentName, 'status' => $caseStatus, 'aor'=>$aorcode);

        echo json_encode($data);

    }

    public function add_advocate_writ()
    {
//        var_dump($_POST);
//        die;
        if(!empty($_POST))
        {
            $dno = $_POST['dno'];
            $advocateId = $_POST['adv_id'];
            $remarks = $_POST['rmk'];
            $ucode = $_POST['uscode'];
            $addCaveat = $this->model->add_caveator_writ($dno,$ucode,$advocateId,$remarks);
//            echo "<pre>";
//            print_r($addCaveat);die;
            if($addCaveat)
            {
                echo "<span style='color:Blue'>CAVEATOR NAME ADDED SUCCESSFULLY IN DIARY NO-  ".$dno."</span>";
            }else{
                echo "<span style='color:Red'>CAVEATOR NAME IS NOT ADDED SUCCESSFULLY IN DIARY NO-  ".$dno."</span>";
            }

        }
    }


}


















