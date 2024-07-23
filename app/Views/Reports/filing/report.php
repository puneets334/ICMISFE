<?php  $uri = current_url(true); ?>
<?= view('header') ?>
 
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header heading">
                            <div class="row">
                                <div class="col-sm-10">
                                    <h3 class="card-title">Filing / Report </h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <span class="alert-danger"><?=\Config\Services::validation()->listErrors()?></span>

                                <?php if(session()->getFlashdata('error')){ ?>
                                    <div class="alert alert-danger">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?= session()->getFlashdata('error')?>
                                    </div>
                                <?php } else if(session("message_error")){ ?>
                                    <div class="alert alert-danger text-danger" style="color: red;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?=session("message_error")?>
                                    </div>
                                <?php }else{?>

                                <?php }?>
                            </div>
                            <div class="col-md-12">
                                <div class="card-header p-2" style="background-color: #fff;">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a onclick="get_search_view(1)" class="nav-link active" href="#Diary" data-toggle="tab">Diary</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(2)" class="nav-link <?php if(($uri->getSegment(4))=="caveat_search"){ echo 'active';}?>" href="#Caveat" id="caveat_search_click" data-toggle="tab">Caveat</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(3)" class="nav-link <?php if(($uri->getSegment(4))=='dak_search'){ echo 'active';}?>" href="#DAK" id="dak_search_click" data-toggle="tab">DAK</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(4)" class="nav-link <?php if(($uri->getSegment(4))=='fil_trap_search'){ echo 'active';}?>" href="#Fil_Trap" id="filtrap_search_click" data-toggle="tab">Fil Trap</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(5)" class="nav-link <?php if(($uri->getSegment(4))=='case_search'){ echo 'active';}?>" href="#Case_Search" id="case_search_click" data-toggle="tab">Case Search</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(6)" class="nav-link <?php if(($uri->getSegment(4))=='refiling_search'){ echo 'active';}?>" href="#Refiling" id="refiling_search_click" data-toggle="tab">Refiling</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(7)" class="nav-link <?php if(($uri->getSegment(4))=='report_master_search'){ echo 'active';}?>" href="#Reports_Master" id="reports_master_search_click" data-toggle="tab">Reports Master (Filing)</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(8)" class="nav-link <?php if(($uri->getSegment(4))=='dynamic_report'){ echo 'active';}?>" href="#Dynamic_report" id="dynamic_report_click" data-toggle="tab">Dynamic Report</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(9)" class="nav-link <?php if(($uri->getSegment(4))=='filing_monitoring'){ echo 'active';}?>" href="#filing_monitoring" id="filing_monitoring_click" data-toggle="tab">Filing Monitoring</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(10)" class="nav-link <?php if(($uri->getSegment(4))=='scrutiny'){ echo 'active';}?>" href="#scrutiny" id="scrutiny_click" data-toggle="tab">Scrutiny</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(11)" class="nav-link <?php if(($uri->getSegment(4))=='management_report'){ echo 'active';}?>" href="#management_report" id="management_report_click" data-toggle="tab">Management Report</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(12)" class="nav-link <?php if(($uri->getSegment(4))=='high_court_report'){ echo 'active';}?>" href="#high_court_report" id="high_court_report_click" data-toggle="tab">High Court</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(13)" class="nav-link <?php if(($uri->getSegment(4))=='uoi_slp_report'){ echo 'active';}?>" href="#uoi_slp_report" id="uoi_slp_report_click" data-toggle="tab">UOI SLP</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(15)" class="nav-link <?php if(($uri->getSegment(4))=='defective_cases_report'){ echo 'active';}?>" href="#defective_cases_report" id="defective_cases_report_click" data-toggle="tab">Defective cases Report</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(16)" class="nav-link <?php if(($uri->getSegment(4))=='change_category_report'){ echo 'active';}?>" href="#change_category_report" id="change_category_report_click" data-toggle="tab">Change Category Report</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(17)" class="nav-link <?php if(($uri->getSegment(4))=='case_trap_report'){ echo 'active';}?>" href="#case_trap_report" id="case_trap_report_click" data-toggle="tab">Diary Progress Report</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(18)" class="nav-link <?php if(($uri->getSegment(4))=='work_done'){ echo 'active';}?>" href="#work_done" id="work_done_I_Bextension_click" data-toggle="tab">Work done (I-B extension)</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(19)" class="nav-link <?php if(($uri->getSegment(4))=='complete_filing'){ echo 'active';}?>" href="#complete_filing" id="complete_filing_click" data-toggle="tab">Complete Filing Report</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(20)" class="nav-link <?php if(($uri->getSegment(4))=='rcc_count_report'){ echo 'active';}?>" href="#rcc_count_report" id="rcc_count_report_click" data-toggle="tab">Diary - RP/Cur/Cont</a></li>
                                        <li class="nav-item"><a onclick="get_search_view(21)" class="nav-link <?php if(($uri->getSegment(4))=='loose_document'){ echo 'active';}?>" href="#loose_document/1" id="loose_document_report_click" data-toggle="tab">Loose Documents</a></li>

                                </div>
        <div class="card-body">
        <div class="tab-content">
            <div id="load_search_view"> </div>
   </div>
    <!-- /.row -->
  </div>
  </section>
    <!-- /.content -->
    <script>
        get_search_view(1);
       function get_search_view(type) {
           $.ajax({
                type: "GET",
                data: { type: type},
                url: "<?php echo base_url('Reports/Filing/Report/get_search_view'); ?>",
                success: function (data)
                {
                    $('#load_search_view').html(data);
                }
             });
        }
    </script>
 <?=view('sci_main_footer') ?>