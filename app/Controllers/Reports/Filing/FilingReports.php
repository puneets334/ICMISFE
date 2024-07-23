<?php

namespace App\Controllers\Reports\Filing;
use App\Controllers\BaseController;
use App\Models\Reports\Filing\FilingReportModel;
use App\Models\Common\DropdownListModel;
use App\Models\Filing\Model_diary;

class FilingReports extends BaseController
{
    public $DropdownListModel;
    public $Model_diary;
    function __construct()
    {
        //ini_set('memory_limit','750M'); // This also needs to be increased in some cases. )
        ini_set('memory_limit', '-1');
        $this->DropdownListModel= new DropdownListModel();
        $this->Model_diary= new Model_diary();
        $ReportModel = new FilingReportModel();
    }


    public function get_defect_reports(){
        $ReportModel = new FilingReportModel();
        $data['case_result']='';
        $data['app_name']='User wise Diary Report';
        $data = $this->request->getGet();
        $data['dreports']= $ReportModel->get_filing_scrutiny_defect_reports($data);
        $data['prname']= $ReportModel->get_scrutiny_causetitle($data);
        $data['adv']= $ReportModel->get_scrutiny_adv($data);
        //print_r($data['prname']); exit;
        

        return view('Reports/filing_reports/get_scrutiny_defect_reports',$data);exit;
    }

    public function get_user_defect_reports(){
            $ReportModel = new FilingReportModel();
            $data['case_result']='';
            $data['app_name']='User wise Diary Report';
            $data = $this->request->getGet();
            $data['on_date'] = $this->request->getGet('on_date');
            $data['dreports']= $ReportModel->getDefectsReports($data);
    //print_r($data['dreports']);
            //$arr = array_merge($data['dreports'], $data['dreports1']);
    
            return view('Reports/filing_reports/get_defect_reports',$data);exit;
    }

  
    public function scrutiny_user_wise_detail_report($user,$ondate,$name)
    {
        
        $ReportModel = new FilingReportModel();
        $data['case_result']='';
        $data['app_name']='User wise Scrutiny Detail Report';
        $data['on_date']=$ondate;
        $data['name']=$name;
        $data['case_result'] = $ReportModel->scrutiny_user_wise_detail_report_model($user,$ondate);
         
        return view('Reports/filing_reports/scrutiny_user_wise_detail_report',$data);exit;

    }

    public function scrutiny_caseSearch(){
        $ReportModel = new FilingReportModel();
        $data['case_result']='';
        $data['app_name']='User wise Scrutiny Detail Report';
        $data['on_date']=$ondate;
        $data['name']=$name;
        $result_array = $ReportModel->get_res_total_defects($user,$ondate);
        $result_array = $ReportModel->scrutiny_diary_wise_case($user,$ondate);
        $data['case_result'] = $result_array;
        return view('Reports/filing_reports/scrutiny_case',$data);exit;
    }
    public function tagged_matter_report()
    {
        $ReportModel = new FilingReportModel();
        $result_array = $ReportModel->tagged_matter_report();
        $data['tagged_result'] = $result_array;
        return view('Reports/filing/tagged_report', $data);
    }

}
