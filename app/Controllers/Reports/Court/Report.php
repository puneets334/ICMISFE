<?php

namespace App\Controllers\Reports\Court;
use App\Controllers\BaseController;
use App\Models\Reports\Court\ReportModel;
use App\Models\Common\DropdownListModel;

class Report extends BaseController
{
    public $DropdownListModel;

    public $ReportModel;
    function __construct()
    {
         ini_set('memory_limit','51200M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
         $this->DropdownListModel= new DropdownListModel();
         $this->ReportModel= new ReportModel();
    }

    public function index(){
        return view('Reports/court/report');
    }
    public function get_search_view(){
        $type = $_REQUEST['type'];
        if(!empty($type)){
            $type =  (int)$type;
             switch($type){
                case 1: //Paperless Court
                   // $data['casetype']=get_from_table_json('casetype');
                    return view('Reports/court/paperless_court_search_view');
                    break;
                case 2: //Part Head
                    $judge = get_from_table_json('judge');
                    foreach($judge as $key => $value):

                        if($value['is_retired']=='N'){
                            $judge_list[] = $value;
                        }
                    endforeach;
                    $data['usertype'] = 1;
                    $data['judge'] = $judge_list;
                   return view('Reports/court/part_heard_search_view',$data);
                    break;
                case 3: //Daily Disposal Remarks
                    return view('Reports/court/daily_disposal_search_view');
                    break;
                case 4: //Gist Module
                    return view('Reports/court/gist_module_search_view');
                    break;
                case 5: //matters_disposed_through_mentioning_search
                    //print_r($role);exit;
                   // $data['judge'] = $this->ReportModel->get_judges_list_current();
                    return view('Reports/court/matters_disposed_through_mentioning_search_view');
                    break;
                case 6: //Final Disposal Matter
                   // $data['judge'] = $this->ReportModel->get_judges_list_current();
                    return view('Reports/court/final_disposal_matters_search_view');
                    break;
                case 7: //Fixed Date Matters
                    $data['judge'] = $this->ReportModel->get_judges_list_current();
                    return view('Reports/court/fixed_date_matters_search_view',$data);
                    break;
                 case 8: //Cause List with OR
                     $data['listing_dates'] = $this->ReportModel->getListingDates();
                     return view('Reports/court/cause_list_with_OR_search_view',$data);
                     break;
                 case 9: //Appearance Search
                     return view('Reports/court/appearance_search_view');
                     break;
                 case 10: //Reports master
                     return view('Reports/court/upload_search_view');
                     break;
                 case 11: //Vernacular Judgments Report
                     return view('Reports/court/vernacular_judgments_report_search_view');
                     break;
                 case 12: //CAV
                     $judge = get_from_table_json('judge');
                     foreach($judge as $key => $value):

                         if($value['is_retired']=='N'){
                             $judge_list[] = $value;
                         }
                     endforeach;
                     $data['usertype'] = 1;
                     $data['judge'] = $judge_list;
                     return view('Reports/court/cav_search_view',$data);
                     break;

                default:

            }
        }


    }
    public function paperless_court(){
        $ReportModel = new ReportModel();
        $data['cause_list_date'] = $this->request->getPost('cause_list_date');
        $data['courtno'] = $this->request->getPost('courtno');
        $data['formdata'] = $this->request->getPost();
        // print_r($data);exit;
        if (!empty($data)) {

            $rosterData= $ReportModel->get_rosterid($data);
            $rosterIds = [];
            foreach ($rosterData as $item) {
                $rosterIds[] = $item->roster_id;
            }
            $rosterIdsString = implode(',', $rosterIds);

            $data['rosterID'] = $rosterIdsString;
            if(!empty($rosterData)) {
                $data['report_title'] = 'Paperless Court ';
                $data['ppl_court'] = $ReportModel->getpaperless_court($data);

            }
            return view('Reports/court/get_content_paperless_court', $data); exit;
        }
    }
    public function part_heard_search(){
        $ReportModel = new ReportModel();
        $data['formdata'] = $this->request->getPost();
        $data['judge'] = $this->request->getPost('judge');
        $data['mr'] = $this->request->getPost('mr');
        $data['report_type'] = $this->request->getPost('report_type');
        $data['report_title'] = 'Details of Part heard';
       if ($data['judge']!=''){
            $data['dataPartHeard']= $ReportModel->getPartHeard($data);
       }
       if ($data['judge']!=0){
            $data['getJname']= $ReportModel->getJname($data['judge']);
            $data['Jname'] = $data['getJname'][0]['jname'];
       }
       return view('Reports/court/get_content_part_heard',$data);exit;
            
    }
    public function daily_disposal_remarks(){
        $ReportModel = new ReportModel();

        $data['formdata'] = $this->request->getPost();
        $disposalon_date = $this->request->getPost('on_date');
          $data['report_title'] = 'Details of Daily Disposal Remarks';
        if (!empty($disposalon_date)){
            $data['dataDisposalRemarks']= $ReportModel->getDisposalRemarks($disposalon_date);
        }
       return view('Reports/court/get_content_daily_disposal_remarks',$data);exit;

    }
    public function gist_module_search(){
        $ReportModel = new ReportModel();

        $data['formdata'] = $this->request->getPost();
        $data['listing_dts'] = $this->request->getPost('listing_dts');
        $data['courtno'] = $this->request->getPost('courtno');
        $data['mainhead'] = $this->request->getPost('mainhead');
        $data['report_title'] = 'Details of Gist Module Data';

        $board_type = $this->request->getPost('board_type');
        $main_suppl = $this->request->getPost('main_suppl');

        $data['board_type'] = $board_type;

        $max_gist_last_read_datetime = $ReportModel->max_gist_last_read_datetime($data);
        $data['max_date'] = $max_gist_last_read_datetime[0]['max_date'];
        if (!empty($data['courtno'])){
            $data['dataGistModule']= $ReportModel->getGistModule($data,$board_type,$main_suppl);
        }
        return view('Reports/court/get_content_gist_module',$data);exit;

    }
    public function cav_search(){
        $ReportModel = new ReportModel();
        $data['formdata'] = $this->request->getPost();
        $data['judge'] = $this->request->getPost('judge');
        $data['report_title'] = 'Details of CAV Search';
        if ($data['judge']!=''){
            $data['dataCAV']= $ReportModel->getCAV($data);
        }
        return view('Reports/court/get_content_cav',$data);exit;

    }
    public function matters_disposed_through_mm(){
        $ReportModel = new ReportModel();
        $data['formdata'] = $this->request->getPost();
        $data['from_date'] = $this->request->getPost('from_date');
        $data['to_date'] = $this->request->getPost('to_date');
        $data['courtno'] = $this->request->getPost('courtno');
        $data['report_title'] = 'Details of MDTM Search with Selected Filter';
      //  $data['judge'] = get_from_table_json('judge');
        $data['mdtmReport'] = $ReportModel->getmm_disposed($data);
        return view('Reports/court/get_content_matters_disposed_through_mm',$data);exit;

    }
    public function final_disposal_matters(){

        $ReportModel = new ReportModel();
        $judge = $this->request->getPost('judge');
        if (!empty($judge)){
            $data['dataFDM']= $ReportModel->getFinalDisposalMatters($judge);
        }

        $data['formdata'] = $this->request->getPost();
        $data['report_title'] = 'Details of File Trap Search with Selected Filter';
        return view('Reports/court/get_content_final_disposal_matters',$data);exit;

    }
    public function fixed_date_matters(){
        $ReportModel = new ReportModel();
        $data['report_type'] = $this->request->getPost('report_type');
        $judge = $this->request->getPost('judge');

        $data['judges_data'] = is_data_from_table('master.judge', ['jcode' => $judge,'display'=>'Y','jtype'=>'J'], 'jname, jcode','R');
        if($data['report_type'] == 1){
            $heading1 = " Misc. Matters ";
        } else if ($data['report_type']  == 2){
            $heading1 = " NMD Matters ";
        }else{
            $heading1 = " Regular Hearing Matters ";
        }
        $data['judge_id'] = $judge;
        $data['fdmReport'] = array();
        $data['heading'] = $heading1;
        if (!empty($data['report_type'])){
            $data['fdmReport']= $ReportModel->getFixedDateMatters($judge,$data['report_type']);
            $data['report_title'] = 'Reports Fixed Date Matters';
           // print_r($data);exit;
        }
      return view('Reports/court/get_content_fixed_date_matters',$data);exit;
            
    }
    public function cause_list_with_or(){
        $ReportModel = new ReportModel();
        $data['formdata'] = $this->request->getPost();
        $data['listing_date'] = $this->request->getPost('listing_date');
        $data['board_type'] = $this->request->getPost('board_type');
        $data['courtno'] = $this->request->getPost('courtno');
        $data['main_suppl'] = $this->request->getPost('main_suppl');
        $data['mr'] = $this->request->getPost('mr');
        $main_supl_head = $mainhead_descri =  '';
        if ($data['main_suppl']== "1") {
            $main_supl_head = "Main List";
        }
        if ($data['main_suppl'] == "2") {
            $main_supl_head = "Supplimentary List";
        }

        if ($data['mr'] == 'M') {
            $mainhead_descri = "Miscellaneous Hearing";
        }
        if ($data['mr'] == 'F') {
            $mainhead_descri = "Regular Hearing";
        }
        if($data['listing_date'] != "-1"){
            $listing_date = date('d-m-Y', strtotime($data['listing_date']));
        }else{
            $listing_date = date('d-m-Y');
        }

        $data['dataCauseListwithor']= $ReportModel->getcauseListWithOR($data);
        $data['report_title'] = 'Cause List for Dated '.$listing_date. '('.$mainhead_descri.')<br>'.$main_supl_head ;
           // print_r($data);exit;

        return view('Reports/court/get_content_cause_list_withor',$data);exit;

    }


    public function appearance_search(){
        $ReportModel = new ReportModel();
        $data['listing_dts'] = $this->request->getPost('listing_dts');
        $data['courtno'] = $this->request->getPost('courtno');

        if (!empty($data['listing_dts'])){
            $data['appearanceSearchData']= $ReportModel->getAppearanceSearchReport($data);
            $data['report_title'] = 'Appearance Search';
           //  print_r($data);exit;
        }
        return view('Reports/court/get_content_appearance_search_report',$data);exit;

    }

    public function vernacular_judgments_report(){
        $ReportModel = new ReportModel();
        $data['from_date'] = $this->request->getPost('from_date');
        $data['to_date'] = $this->request->getPost('to_date');
        $judge = $this->request->getPost('judge');
        if (!empty($data['from_date'])){
            $data['vernacularjudgmentData']= $ReportModel->getvernacularJudgmentsReport($data);
            $data['report_title'] = 'Reports Fixed Date Matters';
            // print_r($data);exit;
        }
        return view('Reports/court/get_content_vernacular_judgments_report',$data);exit;

    }

    public function judge_coram_cases_detail_get_nsh()
    {
        $data['app_name']='';
        $jcd=$this->request->getGet('jcd');
        $flag=$this->request->getGet('flag');
        $list_dt=$this->request->getGet('list_dt');
        $misc_nmd=$this->request->getGet('misc_nmd');
        $judge_name = is_data_from_table('master.judge',['jcode'=>$jcd],'jname','R');

        $msc_nmd_q = "";

        if ($misc_nmd == 1) {
            $mainhead = "M";
            $heading1 = " Misc. Matters ";
            $nmd_flag = 0;
            $subhead_qry = " AND h.subhead IN (824,810,803,802,807,804,808,811,812,813,814,815,816) ";
        } else if ($misc_nmd == 2) {
            $mainhead = "M";
            $heading1 = " NMD Matters ";
            $nmd_flag = 1;
            $subhead_qry = " AND h.subhead IN (824,810,803,802,807,804,808,811,812,813,814,815,816) ";
        } else {
            $mainhead = "F";
            $heading1 = " Regular Hearing Matters ";
            $nmd_flag = 1;
            $subhead_qry = "  ";
        }

        if ($flag == 'f') {
            // $subquert1 = " AND (listorder = 4) ";
            $headnote1 = " Court Dated Cases ";
        }
        if ($flag == 'all') {
            $subquert1 = " ";
            $headnote1 = " ";
        }

        if ($list_dt == 0) {
            $sub_list_dt = " AND next_dt >= curdate() ";
            $headnote_date = " ";
        } else {
            $sub_list_dt = " AND next_dt = '$list_dt'";
            $headnote_date = " List On " . date('d-m-Y', strtotime($list_dt));
        }
            $judge_coram_report=$this->ReportModel->judge_coram_cases_detail_get_nsh($nmd_flag,$mainhead,$jcd,$sub_list_dt,$msc_nmd_q,$subhead_qry);
            $data['judge_coram_result']=$judge_coram_report;
            $data['title'] = $judge_name['jname'] . ", " . $headnote1 . ", " . $heading1.", Ready To List".$headnote_date;
            //$data['dt_title'] = str_replace("'",$judge_name['jname']). ", " . $headnote1 . ", " . $heading1.", Ready To List".$headnote_date;

            return view('Reports/court/judge_coram_cases_detail_view', $data);

    }




}
