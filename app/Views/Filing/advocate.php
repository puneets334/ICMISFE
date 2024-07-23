<?=view('header'); ?>
 
<style>
    .custom-radio{float: left; display: inline-block; margin-left: 10px; }
    .custom_action_menu{float: left; display: inline-block; margin-left: 10px; }
    .basic_heading{text-align: center;color: #31B0D5}
    .btn-sm {
        padding: 0px 8px;
        font-size: 14px;
    }
    .card-header {
        padding: 5px;
    }
    h4 {
        line-height: 0px;
    }
</style>
<link href="<?php echo base_url();?>/css/jquery-ui.css" rel="stylesheet">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header heading">

                            <div class="row">
                                <div class="col-sm-10">
                                    <h3 class="card-title">Filing >> Advocate</h3>
                                </div>

                                <div class="col-sm-2">
                                    <div class="custom_action_menu">
                                        <a href="<?= base_url() ?>/Filing/Diary"><button class="btn btn-success btn-sm" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button></a>
                                        <a href="<?= base_url() ?>/Filing/Diary/search"><button class="btn btn-primary btn-sm" type="button"><i class="fas fa-pen  " aria-hidden="true"></i></button></a>
                                        <a href="<?= base_url() ?>/Filing/Diary/deletion"><button class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <?=view('Filing/filing_breadcrumb'); ?>


                        <?php
                        $filing_details = session()->get('filing_details');
                        $user_details = session()->get('login');
                        ?>
                        <!-- /.card-header -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header p-2" style="background-color: #fff;">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a id="advocate" class="nav-link active" onclick="advocateBtn()" href="#advocate_tab_panel" data-toggle="tab">Advocate</a></li>
                                            <li class="nav-item"><a id="search" class="nav-link" onclick="searchBtn()"href="#search_advocate_tab_panel" data-toggle="tab">Search</a></li>
                                            <li class="nav-item"><a id="add_caveator" class="nav-link" onclick="addCaveator()" href="#add_caveator_writ" data-toggle="tab">Add Caveator In Writ</a></li>


                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">

                                            <div class="active tab-pane" id="advocate_tab_panel">
                                                <h4 class="basic_heading"> Advocate </h4><br>
                                                <?php
                                                if(!empty($get_party_type)){
                                                    $method = 'updateAdvocate';
                                                    $attr = 'disabled';
                                                }else{
                                                    $method = 'addAdvocate';
                                                    $attr = '';
                                                }
                                                $attribute = array('class' => 'form-horizontal', 'name' => '', 'id' => '', 'autocomplete' => 'off');
                                                echo form_open('Filing/Advocate/'.$method, $attribute);

                                                ?>

                                                <?php if($main_row['c_status']=='D'){ ?>
                                                    <span style="color:red;"><center><b>!!!The Case is Disposed!!!</b></center></span>
                                                <?php }elseif($main_row['c_status']=='P'){ ?>

                                                <div class="form-group row ">
                                                    <div class="col-sm-2"></div>
                                                    <label for="inputEmail3" class="col-sm-1 col-form-label"> Party Type <span style="color: red">*</span> :</label>
                                                    <div class="col-sm-9">

                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input party" type="radio" id="radio_selected_court1" required name="get_party" value="P" maxlength="2" <?=$attr;?> <?php echo ($get_pet_res=='P')?'checked':'';  ?> >
                                                            <label for="radio_selected_court1" class="custom-control-label">Petitioner</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input party" type="radio" id="radio_selected_court2" required name="get_party" value="R" maxlength="2" <?=$attr;?> <?php echo ($get_pet_res=='R')?'checked':''; ?> >
                                                            <label for="radio_selected_court2" class="custom-control-label">Respondent</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input party" type="radio" id="radio_selected_court3" required name="get_party" value="I" maxlength="2" <?=$attr;?> <?php echo ($get_pet_res=='I')?'checked':''; ?> >
                                                            <label for="radio_selected_court3" class="custom-control-label">Impleader</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input party" type="radio" id="radio_selected_court4" required name="get_party" value="N" maxlength="2" <?=$attr;?> <?php echo ($get_pet_res=='N')?'checked':''; ?> >
                                                            <label for="radio_selected_court4" class="custom-control-label">Intervenor</label>
                                                        </div>

                                                    </div>
                                                </div>


                                                <div class="row ">

                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Party Name</label>
                                                            <div class="col-sm-8">
                                                                <select name="party_name[]" id="part_name" multiple class="custom-select rounded-0" <?php echo !empty($get_party_type)?'disabled':''; ?> required>
                                                                    <option value="">Select</option>
                                                                    <?php foreach($get_party_edit as $get_party_val): ?>
                                                                        <option value="<?php echo $get_party_val['sr_no'].'/'.$get_party_val['sr_no_show'];?>" selected><?php echo $get_party_val['sr_no_show'].'-'.$get_party_val['partyname'];?></option>
                                                                    <?php endforeach; ?>    
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Category</label>
                                                            <div class="col-sm-8">
                                                                <select name="category" class="custom-select rounded-0 category" <?php echo !empty($get_party_type)?'disabled':''; ?> >
                                                                    <option value="M">Main</option>
                                                                    <option value="A" selected>Additional</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Type</label>
                                                            <div class="col-sm-8">
                                                                <?php
                                                                    $string = $get_adv_selected_data;
                                                                    $str = (!empty($string))?$string:'';
                                                                    if (stripos($str, "[SURETY]") !== false) {
                                                                        $surety = "selected";
                                                                    }else{
                                                                        $surety = "";
                                                                    }

                                                                    if (stripos($str, "[INT]") !== false) {
                                                                        $int = "selected";
                                                                    }else{
                                                                        $int = "";
                                                                    }

                                                                    if (stripos($str, "[LR/S]") !== false) {
                                                                        $lrs = "selected";
                                                                    }else{
                                                                        $lrs = "";
                                                                    }

                                                                    if (stripos($str, "[DRW]") !== false) {
                                                                        $drw = "selected";
                                                                    }else{
                                                                        $drw = "";
                                                                    }

                                                                    if (stripos($str, "[SCLSC]") !== false) {
                                                                        $sclsc = "selected";
                                                                    }else{
                                                                        $sclsc = "";
                                                                    }
                                                                ?>
                                                                <select name="type" class="custom-select rounded-0 type">
                                                                    <option value="N">None</option>
                                                                    <option value="SURETY" <?=$surety?> >SURETY</option>
                                                                    <option value="INT" <?=$int?> >INTERVENOR</option>
                                                                    <option value="LR/S" <?=$lrs?> >LR/S</option>
                                                                    <option value="DRW" <?=$drw?> >DRAWNBY</option>
                                                                    <option value="SCLSC" <?=$sclsc?> >SCLSC</option>
                                                                    <?php 
                                                                        if(!empty($get_party_type)){
                                                                            if($get_pet_res=='R'){

                                                                                if (stripos($str, "[OBJ]") !== false) {
                                                                                    $obj = "selected";
                                                                                }else{
                                                                                    $obj = "";
                                                                                }

                                                                                if (stripos($str, "[IMPL]") !== false) {
                                                                                    $impl = "selected";
                                                                                }else{
                                                                                    $impl = "";
                                                                                }

                                                                                if (stripos($str, "[COMP]") !== false) {
                                                                                    $comp = "selected";
                                                                                }else{
                                                                                    $comp = "";
                                                                                }
                                                                    ?>
                                                                        <option value="OBJ" <?=$obj?> >OBJECTOR</option>
                                                                        <option value="IMPL" <?=$impl?> >IMPLEADER</option>
                                                                        <option value="COMP" <?=$comp?> >COMPLAINANT</option>
                                                                    <?php }} ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Advocate Details</label>
                                                            <div class="col-sm-8">
                                                                <select name="adv_detail" id="adv_detail" class="custom-select rounded-0 adv_detail">
                                                                    <option value="A" <?php echo ($aor_state=='A')?'selected':''; ?> >AOR</option>
                                                                    <option value="S" <?php echo ($aor_state=='S')?'selected':''; ?> >State</option>
                                                                    <option value="AC" <?php echo ($aor_state=='AC')?'selected':''; ?> >NON-AOR</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" id="show_state" style="<?php echo ($aor_state=='S')?'':'display:none'; ?>">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">State</label>
                                                            <div class="col-sm-8">
                                                                <select name="state" class="custom-select rounded-0">
                                                                    <option value="">State</option>
                                                                <?php foreach($state_list as $state_value): ?>
                                                                    <option value="<?=!empty($state_value['cmis_state_id'])?$state_value['cmis_state_id']:''?>"><?=$state_value['state_name']?></option>
                                                                <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label id="title" class="col-sm-4 col-form-label">AOR Code</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" name="aor_code" class="form-control bar_detail" value="<?php if($aor_state=='S'){ echo $enroll_no; }else{ echo $bar_id; };?>" placeholder="Enter Number" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" id="show_state_code" style="<?php echo ($aor_state=='S')?'':'display:none'; ?>">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Advocate Year</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" name="adv_year" class="form-control bar_detail_adv" value="<?php echo $enroll_date; ?>" placeholder="Enter Number">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Advocate Name</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="adv_name" name="adv_name" value="<?php echo $name;?>" class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php
                                                        $mobile_attr = 'none';
                                                        $email_attr = 'none';

                                                        if($get_party_type){
                                                            if($get_sr_no_show==0){

                                                                if($bar_id==1034 || $bar_id==1372 || $bar_id==800 || $bar_id==616 || $bar_id==892){
                                                                    $mobile_attr = 'block';
                                                                    $email_attr = 'block';
                                                                }

                                                            }
                                                            elseif($bar_id==799 || $bar_id==1034 || $bar_id==1372 || $bar_id==800 || $bar_id==616 || $bar_id==868){
                                                                $mobile_attr = 'block';
                                                                $email_attr = 'block';
                                                            }
                                                        }
                                                    ?>

                                                    <div class="col-md-4" id="inperson_mob_div" style="display:<?=$mobile_attr?>;">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Mobile No.</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" maxlength="10" size="10" id="inperson_mob" name="inperson_mob" value="<?=$inperson_mobile?>" placeholder="Mobile no." class="form-control" onkeypress="return onlynumbers(event,this.id)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" id="inperson_email_div" style="display:<?=$email_attr?>;">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Email Id</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="inperson_email" name="inperson_email" value="<?=$inperson_email?>" placeholder="Email id" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">If [AG]</label>
                                                            <div class="col-sm-8">
                                                                <?php
                                                                    if (stripos($str, "[AG]") !== false) {
                                                                        $ag = "selected";
                                                                    }else{
                                                                        $ag = "";
                                                                    }
                                                                ?>
                                                                <select name="if_ag" class="custom-select rounded-0">
                                                                    <option value="N">NO</option>
                                                                    <option value="AG" <?=$ag?> >ATTORNY GENERAL</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">STATE ADV[Pri/Gov]</label>
                                                            <div class="col-sm-8">
                                                                <?php
                                                                    if (stripos($str, "[Pr]") !== false) {
                                                                        $pr = "selected";
                                                                    }else{
                                                                        $pr = "";
                                                                    }

                                                                    if (stripos($str, "[Gr]") !== false) {
                                                                        $gr = "selected";
                                                                    }else{
                                                                        $gr = "";
                                                                    }
                                                                ?>
                                                                <select name="state_adv" class="custom-select rounded-0">
                                                                    <option value="N">NO</option>
                                                                    <option value="P" <?=$pr?> >Private</option>
                                                                    <option value="G" <?=$gr?> >Government</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="get_party_type" value="<?php echo !empty($get_party_type)?$get_party_type:''; ?>">
                                                    
                                                    <div class="col-md-12">
                                                        <center>
                                                            <?php
                                                                if(!empty($get_party_type)){
                                                                    $btn_lable = 'Update';
                                                                }else{
                                                                    $btn_lable = 'Save';
                                                                }
                                                            ?>
                                                            <input type="submit" name="sub" class="btn btn-primary" onclick="return checkAdvocateName()" value="<?=$btn_lable?>">
                                                            <?php if(!empty($get_party_type)): ?>
                                                                <a href="<?php echo base_url('Filing/Advocate'); ?>"><button type="button" class="btn btn-info">Cancel</button></a>
                                                            <?php endif; ?>
                                                        </center>
                                                    </div>

                                                </div>

                                                <?php }else{ ?>
                                                    <span style="color:red;"><center><b>Record Not Found!!!</b></center></span>
                                                <?php } ?>

                                            </div>
                                            <!-- /.advocate_tab_panel -->

                                            <div class="tab-pane" id="search_advocate_tab_panel">
                                                <h4 class="basic_heading"> Advocate Search </h4><br>

                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Search by Name</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="adv_search_name" class="form-control" placeholder="Enter Advocate Name">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Search by AOR Code</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" id="adv_search_by_aor" class="form-control" placeholder="Enter AOR Code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="row mt-3">
                                                            <div class="col-md-12">
                                                                <div id="sr_adv_div_not_found"><center><b>Advocate not found</b></center></div>
                                                                <div id="sr_adv_div" style="display:grid;justify-content: flex-start;">
                                                                    <div class="mb-1" style="font-family: Font Awesome 5 Free;">
                                                                        <span><strong>Name:</strong></span>
                                                                        <span id="adv_name_sear"></span>
                                                                    </div>
                                                                    <div class="mb-1" style="font-family: Font Awesome 5 Free;">
                                                                        <span><strong>AOR/NAOR:</strong></span>
                                                                        <span id="adv_aor_sear"></span>
                                                                    </div>
                                                                    <div class="mb-1" id="aor_code_hide_show" style="font-family: Font Awesome 5 Free;">
                                                                        <span><strong>AOR Code:</strong></span>
                                                                        <span id="adv_aor_code_sear"></span>
                                                                    </div>
                                                                    <div class="mb-1" style="font-family: Font Awesome 5 Free;">
                                                                        <span><strong>Mobile:</strong></span>
                                                                        <span id="adv_mobile_sear"></span>
                                                                    </div>
                                                                    <div class="mb-1" style="font-family: Font Awesome 5 Free;">
                                                                        <span><strong>Email:</strong></span>
                                                                        <span id="adv_email_sear"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <!-- /.advocate_tab_panel -->



                                            <div id="show_view">
                                            <hr><br>
                                            <div class="">
                                                <h4 class="basic_heading"> View </h4><br>

                                                <div class="form-group row ">
                                                    <div class="col-sm-2"></div>
                                                    <label for="inputEmail3" class="col-sm-1 col-form-label"> Party Type <span style="color: red">*</span> :</label>
                                                    <div class="col-sm-9">

                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input partyView" type="radio" id="radio_selected_court5" name="view_party" value="P" maxlength="2" <?php echo ($get_pet_res=='P')?'checked':'';  ?> checked>
                                                            <label for="radio_selected_court5" class="custom-control-label">Petitioner</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input partyView" type="radio" id="radio_selected_court6" name="view_party" value="R" maxlength="2" <?php echo ($get_pet_res=='R')?'checked':'';  ?> >
                                                            <label for="radio_selected_court6" class="custom-control-label">Respondent</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input partyView" type="radio" id="radio_selected_court7" name="view_party" value="I" maxlength="2" <?php echo ($get_pet_res=='I')?'checked':'';  ?> >
                                                            <label for="radio_selected_court7" class="custom-control-label">Impleader</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input partyView" type="radio" id="radio_selected_court8" name="view_party" value="N" maxlength="2" <?php echo ($get_pet_res=='N')?'checked':'';  ?> >
                                                            <label for="radio_selected_court8" class="custom-control-label">Intervenor</label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <center><span><b>Petitioner</b></span></center><br>
                                                        <table id="example1" class="table table-hover showData">
                                                            <thead>
                                                              <tr>
                                                                <th>S.No.</th>
                                                                <th>Name</th>
                                                                <th>Advocate Name</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                              <?php
                                                                if(!empty($party)):
                                                               foreach($party as $party_val): ?>  
                                                                  <!-- <tr>
                                                                    <td><?php //echo "[P-".$party_val['sr_no_show']."]";  ?>
                                                                    <td><?php //echo $party_val['partyname'];?></td>
                                                                    <td></td>
                                                                  </tr> -->
                                                              <?php endforeach; endif; ?>
                                                            </tbody>
                                                          </table>
                                                    </div>
                                                </div>

                                            </div>
                                            </div>
                                            <!-- /.diary_generation_tab_panel -->

<!--               **************************** CODE ADDED BY P.S TO ADD CAVEATOR IN WRIT MODULE IN ADVOCATE MENU ***************************                                     -->
                                            <br>

                                            <div class="tab-pane" id="add_caveator_writ">
                                                <h4 class="basic_heading"> Add Caveator In Writ </h4><br><br>


                                                <div class="row">
                                                    <div class="col-sm-7" id="caseInfo" >
                                                        <div class="form-group row">
                                                            <h5 for="information" style="color:red">Diary Information:</h5>&nbsp;&nbsp;
                                                            <div class="col-sm-9">
                                                                <span > Petitioner: </span><span style='text-align: center;color: blue' id="pet"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5" id="caseInfo" >
                                                        <div class="form-group row">
                                                            <div class="col-sm-9">
                                                                <span > Respondent: </span><span style='text-align: center;color: blue' id="res"></span>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>

                                                <div class="row" id="select_remarks_div">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Select Aor Code:</label>
                                                            <div class="col-sm-7">
                                                                <select class="form-control" id="aorcode">
                                                                    <option value="">select</option>
<!--                                                                    --><?php
//
//                                                                    $sql="select aor_code, bar_id,name from bar where if_aor='Y' and isdead='N'";
//
//                                                                    $rs=mysql_query($sql);
//                                                                    while($rw=mysql_fetch_array($rs))
//                                                                    {
//                                                                        ?>
<!---->
<!--                                                                        <option value="--><?php //echo $rw[bar_id] ?><!--">--><?php //echo $rw[aor_code]."-".$rw[name];  ?><!--</option>-->
<!--                                                                        --><?php
//                                                                    }
//                                                                    ?>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6" >
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Enter Remarks :</label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Remarks"  value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <br><br>

                                                <center> <div class="col-md-2" id="btn_div">
                                                    <button type="button" id="button" class="btn btn-primary" onClick="insert_advocate()" >Add Advocate</button>

                                                </div></center>
                                                <br><br>
                                                <center><div id="message_for_disposalcase"> </div></center>

                                            </div>
<!--                                            <div class="form-group" id="add_caveator_writ"></div>-->
<!--                                            **************************** CODE ADDED BY P.S TO ADD CAVEATOR IN WRIT MODULE IN ADVOCATE MENU ENDS HERE ***************************-->
                                        </div>
                                        <!-- /.tab-content -->




                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>


                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  
  <script src="<?php echo base_url();?>/jquery/jquery-1.9.1.js"></script>
  <script src="<?php echo base_url();?>/js/jquery-ui.js"></script> 
    
    <script>

        // **************************** CODE ADDED BY P.S TO ADD CAVEATOR IN WRIT MODULE IN ADVOCATE MENU ***************************
        function addCaveator()
        {
            $('#show_view').hide();
            $('#advocate_tab_panel').hide();
            $('#search_advocate_tab_panel').hide();
            $('#add_caveator_writ').show();
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.ajax({
                type:"POST",
                data: {
                    CSRF_TOKEN: CSRF_TOKEN_VALUE,
                },
                url: "<?php echo base_url('Filing/Advocate/show_add_caveator'); ?>",
                success: function(data) {
                    // alert(data);
                    updateCSRFToken();
                    var info = JSON.parse(data);
                    // alert(info.pet_name);
                    $("#pet").html(info.pet_name);
                    $("#res").html(info.res_name);
                    if(info.status == 'P') {
                        var option = '';
                         option += "<option value=''>"+"Select"+"</option>";
                        for (var i in info.aor) {
                            console.log( info.aor[i].bar_id + ' ' + info.aor[i].name );
                            option += "<option value="+ info.aor[i].bar_id + ">" + info.aor[i].aor_code + "-" + info.aor[i].name + "</option>";
                        }
                        $("#aorcode").html(option);

                    }else{
                        $("#select_remarks_div").hide();
                        $("#btn_div").hide();
                        $("#message_for_disposalcase").html("<span style='color:Red;'> The Case Is Disposed, Cannot Add Caveat In Writ</span>");


                    }
                },
                error: function(data) {
                    alert(data);
                    updateCSRFToken();
                }
            });


        }

        function insert_advocate()
        {
            var dno = '<?= $filing_details['diary_no'] ?>';
            var ucode ='<?= $user_details['usercode'] ?>';
            var advocate_id = document.getElementById('aorcode').value;
            var remarks= document.getElementById('remarks').value;
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

            if(remarks=='')
            {
                alert("Remarks cannot be empty");
                return false;
            }
            // alert(advocate_id);
            // return false;

            var result = confirm("Are you sure to add caveator name?");
            // console.log(result);
            // return false;
            if (result) {

                $.ajax({
                    type:"POST",
                    data: {
                        CSRF_TOKEN: CSRF_TOKEN_VALUE,
                        dno:dno,
                        adv_id:advocate_id,
                        rmk:remarks,
                        uscode:ucode
                    },
                    url: "<?php echo base_url('Filing/Advocate/add_advocate_writ'); ?>",
                    success: function(data) {
                        // alert(data);
                        $("#message_for_disposalcase").html(data);
                        updateCSRFToken();

                    },
                    error: function(data) {
                        // alert(data);
                        $("#message_for_disposalcase").html(data);
                        updateCSRFToken();
                    }
                });

            }
        }

        // **************************** CODE ADDED BY P.S TO ADD CAVEATOR IN WRIT MODULE IN ADVOCATE MENU ENDS HERE ***************************

        function searchBtn()
        {
            $('#show_view').hide();
            $('#advocate_tab_panel').hide();
            $('#add_caveator_writ').hide();
            $('#search_advocate_tab_panel').show();

        }
        function advocateBtn()
        {
            $('#advocate_tab_panel').show();
            $('#search_advocate_tab_panel').hide();
            $('#add_caveator_writ').hide();

        }

        function checkAdvocateName(){
            var adv_name_get = $('#adv_name').val();
            if(adv_name_get == ""){
                alert("Please enter advocate.");
                $('#adv_name').focus();
                return false;
            }
        }

        function onlynumbers(evt)
        {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode >= 48 && charCode<= 57)||charCode==9||charCode==8||charCode==37||charCode==39) {
                return true;
            }
            return false;
        }

        $(document).ready(function() {


            var party_type = 'P';
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var csrf = $("input[name='CSRF_TOKEN']").val();

            if(party_type=='P' || party_type=='R'){

                $.ajax({
                    url:"<?php echo base_url('Filing/advocate/get_party_data/');?>",
                    type: "post",
                    data: {CSRF_TOKEN:csrf,party_type: party_type},
                    success:function(result){
                        //console.log(result);
                        $('.showData').html(result);
                        $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        });
                    },
                    error: function () {
                        $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        });
                    }
                });

            }


            /*code for show view data on edit page*/
            var url = ''+window.location.href+'';
            var array = url.split("/");
            var secondStr = array[6];

            if(secondStr){
                var array1 = secondStr.split("-");
                var getPartyUrl = array1[0];

                var party_type = getPartyUrl;
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var csrf = $("input[name='CSRF_TOKEN']").val();

                if(party_type=='P' || party_type=='R'){

                    $.ajax({
                        url:"<?php echo base_url('Filing/advocate/get_party_data/');?>",
                        type: "post",
                        data: {CSRF_TOKEN:csrf,party_type: party_type},
                        success:function(result){
                            //console.log(result);
                            $('.showData').html(result);
                            $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                            });
                        },
                        error: function () {
                            $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                            });
                        }
                    });

                }
            }
            /*code for show view data on edit page*/



            $('#adv_detail').change(function(){
                var adv_id = $(this).val();
                if(adv_id=='S' || adv_id=='AC'){
                    $('#show_state').css({"display":"block"});
                    $('#show_state_code').css({"display":"block"});
                    $('#title').html('Advocate No.');
                }else{
                    $('#show_state').css({"display":"none"});
                    $('#show_state_code').css({"display":"none"});
                    $('#title').html('AOR Code');
                }
            });

            $('.bar_detail').keyup(function(){

                var get_party_value = $('.party:checked').val();

                if(jQuery.type(get_party_value) === "undefined"){
                    alert("Please select party first");
                    $('#radio_selected_court1').focus();
                    return false;
                }

                var advocate_detail = $("select[name='adv_detail']").val();

                if(advocate_detail=='A'){
                    var adv_no = $(this).val();

                    if(get_party_value=='P'){
                        if(adv_no==799 || adv_no==1034 || adv_no==1372){
                            $('#inperson_mob_div').css({'display':'block'});
                            $('#inperson_email_div').css({'display':'block'});
                        }else{
                            $('#inperson_mob_div').css({'display':'none'});
                            $('#inperson_email_div').css({'display':'none'});
                        }
                    }
                    else if(get_party_value=='R'){
                        if(adv_no==800 || adv_no==616 || adv_no==1034 || adv_no==1372 || adv_no==892){
                            $('#inperson_mob_div').css({'display':'block'});
                            $('#inperson_email_div').css({'display':'block'});
                        }else{
                            $('#inperson_mob_div').css({'display':'none'});
                            $('#inperson_email_div').css({'display':'none'});
                        }
                    }
                    else if(get_party_value=='N'){
                        if(adv_no==868){
                            $('#inperson_mob_div').css({'display':'block'});
                            $('#inperson_email_div').css({'display':'block'});
                        }else{
                            $('#inperson_mob_div').css({'display':'none'});
                            $('#inperson_email_div').css({'display':'none'});
                        }
                    }

                    var CSRF_TOKEN = 'CSRF_TOKEN';
                    var csrf = $("input[name='CSRF_TOKEN']").val();

                    $.ajax({
                        url:"<?php echo base_url('Filing/advocate/bar_detail/');?>",
                        type: "post",
                        data: {CSRF_TOKEN:csrf,adv_no: adv_no,advocate_detail:advocate_detail},
                        success:function(result){
                            //console.log(result);
                            $('#adv_name').val(result);
                            $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                            });
                        },
                        error: function () {
                            $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                            });
                        }
                    });
                }

            });

            $('.bar_detail_adv').keyup(function(){
                var advocate_detail = $("select[name='adv_detail']").val();
                
                if(advocate_detail=='S' || advocate_detail=='AC'){

                    var CSRF_TOKEN = 'CSRF_TOKEN';
                    var csrf = $("input[name='CSRF_TOKEN']").val();
                    var stateID = $("select[name='state']").val();
                    var adv_no = $("input[name='aor_code']").val();
                    var adv_year = $(this).val();

                    $.ajax({
                        url:"<?php echo base_url('Filing/advocate/bar_detail/');?>",
                        type: "post",
                        data: {CSRF_TOKEN:csrf,stateID: stateID,adv_no: adv_no,adv_year: adv_year,advocate_detail: advocate_detail},
                        success:function(result){
                            //console.log(result);
                            $('#adv_name').val(result);
                            $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                            });
                        },
                        error: function () {
                            $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                            });
                        }
                    });
                }

            });

            $('#advocate').click(function(){
                $('#show_view').css({"display":"block"});
            });

            $('#search').click(function(){
                $('#show_view').css({"display":"none"});
            });

            $('.party').click(function(){
                var party_type = $(this).val();
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var csrf = $("input[name='CSRF_TOKEN']").val();

                $.ajax({
                    url:"<?php echo base_url('Filing/advocate/get_party_name/');?>",
                    type: "post",
                    data: {CSRF_TOKEN:csrf,party_type: party_type},
                    success:function(result){
                        //console.log(result);
                        $('#part_name').html(result);
                        $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        });
                    },
                    error: function () {
                        $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        });
                    }
                });

            });

            $('.partyView').click(function(){
                var party_type = $(this).val();
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var csrf = $("input[name='CSRF_TOKEN']").val();

                if(party_type=='P' || party_type=='R'){

                    $.ajax({
                        url:"<?php echo base_url('Filing/advocate/get_party_data/');?>",
                        type: "post",
                        data: {CSRF_TOKEN:csrf,party_type: party_type},
                        success:function(result){
                            //console.log(result);
                            $('.showData').html(result);
                            $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                            });
                        },
                        error: function () {
                            $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                            });
                        }
                    });

                }
                else if(party_type=='I' || party_type=='N'){

                    $.ajax({
                        url:"<?php echo base_url('Filing/advocate/get_party_data_imp_int/');?>",
                        type: "post",
                        data: {CSRF_TOKEN:csrf,party_type: party_type},
                        success:function(result){
                            //console.log(result);
                            $('.showData').html(result);
                            $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                            });
                        },
                        error: function () {
                            $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                            });
                        }
                    });

                }

            });

        });

        $(function () {
            $("#example1").DataTable({
              "responsive": true, "lengthChange": false, "autoWidth": false,searching: false,
              //"buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        $('.party').click(function(){
            var party_type = $(this).val();

            if(party_type=='P'){
                $("#part_name").removeAttr('disabled', 'disabled');

                $(".category").html('<option value="M" selected>Main</option><option value="A" selected>Additional</option>');

                $(".type").html('<option value="N">None</option><option value="SURETY">SURETY</option><option value="INT">INTERVENOR</option><option value="LR/S">LR/S</option><option value="DRW">DRAWNBY</option><option value="SCLSC">SCLSC</option>');

                $(".adv_detail").html('<option value="A">AOR</option><option value="S">State</option><option value="AC">NON-AOR</option>');

            }

            if(party_type=='R'){
                $("#part_name").removeAttr('disabled', 'disabled');

                $(".category").html('<option value="M" selected>Main</option><option value="A" selected>Additional</option>');

                $(".type").html('<option value="N">None</option><option value="SURETY">SURETY</option><option value="INT">INTERVENOR</option><option value="LR/S">LR/S</option><option value="DRW">DRAWNBY</option><option value="SCLSC">SCLSC</option><option value="OBJ">OBJECTOR</option><option value="IMPL">IMPLEADER</option><option value="COMP">COMPLAINANT</option>');

                $(".adv_detail").html('<option value="A">AOR</option><option value="S">State</option><option value="AC">NON-AOR</option>');

            }

            if(party_type=='I'){
                $("#part_name").attr('disabled', 'disabled');

                $(".category").html('<option value="A" selected>Additional</option>');

                $(".type").html('<option value="IMPL">IMPLEADER</option>');

                $(".adv_detail").html('<option value="A">AOR</option><option value="S">State</option>');
            }

            if(party_type=='N'){
                $("#part_name").attr('disabled', 'disabled');

                $(".category").html('<option value="A" selected>Additional</option>');

                $(".type").html('<option value="INT">INTERVENOR</option>');

                $(".adv_detail").html('<option value="A">AOR</option><option value="S">State</option>');
            }
        });

        $(document).on("focus","#adv_search_name",function(){
            $('#adv_search_by_aor').val('');
            $("#adv_search_name").autocomplete({
                source:"<?php echo base_url('Filing/advocate/get_advocate_name/');?>",
                width: 450,
                matchContains: true,    
                minChars: 1,
                selectFirst: false,
                select: function (event, ui){

                    $('#sr_adv_div_not_found').hide();
                    $('#sr_adv_div').show();
                    // Set autocomplete element to display the label
                    this.value = ui.item.label;
                    // Store value in hidden field
                    var data = ui.item.value;
                    data = data.split('~');
                    $("#adv_mobile_sear").html(data[0]);
                    $("#adv_email_sear").html(data[1]);

                    if(data[3]=='Y'){
                        var labelAor = 'AOR';
                        $("#aor_code_hide_show").show();
                        $("#adv_aor_code_sear").html(data[2]);
                    }
                    else if(data[3]=='N'){
                        var labelAor = 'NON-AOR';
                        $("#adv_aor_code_sear").html('');
                        $("#aor_code_hide_show").hide();
                    }
                    else{
                        var labelAor = '';
                    }

                    $("#adv_aor_sear").html(labelAor);
                    $("#adv_name_sear").html(ui.item.label);
                    // Prevent default behaviour
                    return false;
                },
                focus: function( event, ui){
                    $("#adv_search_name").val(ui.item.label);
                    return false;  
                }
            });    
        });

        $('#sr_adv_div_not_found').hide();

        $('#adv_search_by_aor').keyup(function(){

            $('#adv_search_name').val('');

            updateCSRFToken();

            var get_aor_code = $('#adv_search_by_aor').val();

            var CSRF_TOKEN = 'CSRF_TOKEN';
            var csrf = $("input[name='CSRF_TOKEN']").val();

            $.ajax({
                    url:"<?php echo base_url('Filing/advocate/get_advocate_name_by_aor_code/');?>",
                    type: "post",
                    data: {CSRF_TOKEN:csrf,get_aor_code: get_aor_code},
                    success:function(result){

                        var returnedData = JSON.parse(result);

                        if(returnedData.err == 0){
                            $('#sr_adv_div_not_found').show();
                            $('#sr_adv_div').hide();
                        }else{
                            $('#sr_adv_div').show();
                            $('#sr_adv_div_not_found').hide();
                        }

                        console.log(returnedData[0].name);

                        $("#adv_mobile_sear").html(returnedData[0].mobile);
                        $("#adv_email_sear").html(returnedData[0].email);

                        if(returnedData[0].if_aor=='Y'){
                            var labelAor = 'AOR';
                            $("#aor_code_hide_show").show();
                            $("#adv_aor_code_sear").html(returnedData[0].aor_code);
                        }
                        else if(returnedData[0].if_aor=='N'){
                            var labelAor = 'NON-AOR';
                            $("#adv_aor_code_sear").html('');
                            $("#aor_code_hide_show").hide();
                        }
                        else{
                            var labelAor = '';
                        }

                        $("#adv_aor_sear").html(labelAor);
                        $("#adv_name_sear").html(returnedData[0].name);
                        
                        $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        });
                    },
                    error: function () {
                        $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        });
                    }
                });

            updateCSRFToken();

        });

    </script>
 <?=view('sci_main_footer');?>
