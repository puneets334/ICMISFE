<?=view('header'); ?>
 

<style>
#wrapper_1:after {
    content: "";
    background-color: #000;
    position: absolute;
    width: 0.2%;
    height: 100%;
    top: 0;
    left: 100%;
    display: block;
}
#wrapper_2:after {
    content: "";
    background-color: #000;
    position: absolute;
    width: 0.2%;
    height: 100%;
    top: 0;
    left: 100%;
    display: block;
}
</style>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header heading">

                            <div class="row">
                                <div class="col-sm-10">
                                    <h3 class="card-title">Filing</h3>
                                </div>
                                <div class="col-sm-2">
                                    <div class="custom_action_menu">
                                        <a href="<?= base_url() ?>/Filing/Diary"><button class="btn btn-success btn-sm" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button></a>
                                        <a href="<?= base_url() ?>/Filing/Diary/search"><button class="btn btn-primary btn-sm" type="button"><i class="fas fa-pen	" aria-hidden="true"></i></button></a>
                                        <a href="<?= base_url() ?>/Filing/Diary/deletion"><button class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?=view('Filing/filing_breadcrumb'); ?>
                        <!-- /.card-header -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header p-2" style="background-color: #fff;">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#add_party_tab_panel" data-toggle="tab">Party Details</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#copy_party_tab_panel" data-toggle="tab">Copy Party Details</a></li>
                                        </ul>
                                        <?php
                                        $attribute = array('class' => 'form-horizontal', 'name' => 'party_view_form', 'id' => 'party_view_form', 'autocomplete' => 'off');
                                        echo form_open('Filing/Party/save_party_details', $attribute);
                                        ?>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">

                                            <div class="active tab-pane" id="add_party_tab_panel">


                                                <div>
                                                    <?php
                                                    //echo "<pre>"; print_r($_SESSION['filing_details']['pet_name']); die;
                                                    ?>
                                                    <div class="row ml-4">
                                                        <label class="col-sm-12 col-form-label text-center" >
                                                            <b>Diary Number :</b><?= substr_replace($_SESSION['filing_details']['diary_no'], '/', -4, 0) ?>  &nbsp;&nbsp;&nbsp;

                                                            <?php if($_SESSION['filing_details']['reg_no_display'] != ''){ ?>
                                                                <b>Case Number :</b> <?= $_SESSION['filing_details']['reg_no_display'] ?>  &nbsp;&nbsp;&nbsp;
                                                            <?php } ?>

                                                            <?php 
                                                                if($_SESSION['filing_details']['c_status'] == 'D'){ echo '<b>Case Title :</b> '.$_SESSION['filing_details']['pet_name'].' <b>Vs</b> '.$_SESSION['filing_details']['res_name']; }
                                                                if($_SESSION['filing_details']['c_status'] == 'P'){ echo '<b>Case Title :</b>'.$get_petResCaseTitle['pet_name'].' <b> Vs </b> '. $get_petResCaseTitle['res_name']; } 
                                                            ?>
                                                             
                                                            
                                                            &nbsp;&nbsp;&nbsp;
                                                            <b>Filing Date : </b><?= date("d-m-Y", strtotime($_SESSION['filing_details']['diary_no_rec_date'])) ?> &nbsp;&nbsp;&nbsp;                                                            
                                                            <?php 
                                                                if($_SESSION['filing_details']['c_status'] == 'D'){ echo '<span class="text-red">Disposed</span>'; }
                                                                if($_SESSION['filing_details']['c_status'] == 'P'){ echo '<span class="text-blue">Pending</span>'; } 
                                                            ?>
                                                            </span>        
                                                        </label>
                                                    </div>
                                                </div>

                                                <input type='hidden' value="<?php echo $diary_no;?>" id='hdfno'>
                                                <input type="hidden" value="I" name="controllerValue" id="controllerValue" />
                                                <input type="hidden" value="0" name="set_auto_generated_id" id="set_auto_generated_id" />

                                                <!-- Add / Edit Form -->
                                                <div style="padding: 1.4rem;border: 1px solid #000;">
                                                    <div class="row mt-5 caseDet" >
                                                        <div class="col-md-3">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Add:</label>
                                                                <div class="col-sm-7">
                                                                    <select id="pri_action" class="custom-select rounded-0">
                                                                        <option value="P">Party</option>
                                                                        <option value="L">LR's</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 selectLR" style="display:none;" >
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Selecting LR: </label>
                                                                <div class="col-sm-9">
                                                                    <select id="for_selecting_lrs" class="custom-select rounded-0 select2">
                                                                        <option value="">Select</option>
                                                                        <?php foreach ($lr_list as $select_for_lrs_row) { ?>
                                                                            <option value="<?php echo $select_for_lrs_row['pet_res'].'~'.$select_for_lrs_row['sr_no'].'~'.$select_for_lrs_row['sr_no_show']; ?>"><?php echo $select_for_lrs_row['pet_res'].'-'.$select_for_lrs_row['sr_no_show'].' = '.$select_for_lrs_row['partyname']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row md-12" >
                                                        <div class="col-md-3">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Order 1: </label>
                                                                <div class="col-sm-7">
                                                                    <select id="order1" class="custom-select rounded-0">
                                                                        <option value="S" selected="">State</option>
                                                                        <option value="D">Department</option>
                                                                        <option value="P">Post</option>
                                                                    </select></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Order 2: </label>
                                                                <div class="col-sm-7">
                                                                    <select id="order2" class="custom-select rounded-0">
                                                                        <option value="S">State</option>
                                                                        <option value="D" selected="">Department</option>
                                                                        <option value="P">Post</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Order 3: </label>
                                                                <div class="col-sm-7">
                                                                    <select id="order3" class="custom-select rounded-0">
                                                                        <option value="S">State</option>
                                                                        <option value="D">Department</option>
                                                                        <option value="P" selected="">Post</option>
                                                                    </select></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-2 mb-3">
                                                        <span style="border: none;color: #ff6666; font-style: italic;">IF YOU WANT TO ADD ANY PARTY BETWEEN THE RANGE CLICK THE BUTTON [REMEMBER THAT THIS WILL SHIFT FURTHER NUMBERS BY 1 FOR EXISTING PARTY NO.ADDITION] </span>&nbsp;
                                                        <input type="button" class="btn btn-primary" value="ENABLE PARTY NO." id="enable_party">
                                                    </div>
                                                    <div class="row md-12" >
                                                        <div class="col-md-3">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Party Type: </label>
                                                                <div class="col-sm-7">
                                                                    <select id="party_flag" class="custom-select rounded-0">
                                                                        <option value="">Select</option>
                                                                        <option value="P">Petitioner</option>
                                                                        <option value="R">Respondent</option>
                                                                        <option value="I">Impleading</option>
                                                                        <option value="N">Intervenor</option>
                                                                    </select></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Party No.: </label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" class="form-control" disabled id="pno" placeholder="Party Number" onkeypress="return onlynumbers(event)">
                                                                    <input type="hidden" id="hd_party_flag">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-4 col-form-label">Individual/Dept: </label>
                                                                <div class="col-sm-7">
                                                                    <select id="party_type" onchange="activate_extra(this.value)" class="custom-select rounded-0">
                                                                        <option value="I">Individual</option>
                                                                        <option value="D1">State Department</option>
                                                                        <option value="D2">Central Department</option>
                                                                        <option value="D3">Other Organization</option>
                                                                    </select></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Con/Pro: </label>
                                                                <div class="col-sm-7">
                                                                    <select id="p_cntpro" class="custom-select rounded-0">
                                                                        <option value="C">Contested</option>
                                                                        <option value="P">Proforma</option>
                                                                    </select></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                        


                                                    <div class=" mt-3 " id="individ">
                                                        <div class="row md-12" >
                                                            <div class="col-md-4">
                                                                <div class="form-group row clearfix">
                                                                    <label class="col-sm-3 col-form-label">Name: </label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" id="p_name" class="form-control" onkeypress="return onlyalphab(event)" onblur="remove_apos(this.value,this.id)"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group row clearfix">
                                                                    <label class="col-sm-3 col-form-label">Relation: </label>
                                                                    <div class="col-sm-7">
                                                                        <select id="p_rel" class="custom-select rounded-0 ">
                                                                            <option value="">Select</option>
                                                                            <option value="S">Son of</option>
                                                                            <option value="D">Daughter of</option>
                                                                            <option value="W">Wife of</option>
                                                                            <option value="Z">Widow of</option>
                                                                            <option value="F">Father of</option>
                                                                            <option value="M">Mother of</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group row clearfix">
                                                                    <label class="col-sm-3 col-form-label">Father/Husb. Name:</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control" id="p_rel_name" onkeypress="return onlyalphab(event)" onblur="remove_apos(this.value,this.id)">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row md-12" >
                                                            <div class="col-md-4">
                                                                <div class="form-group row clearfix">
                                                                    <label class="col-sm-3 col-form-label">Gender: </label>
                                                                    <div class="col-sm-7">
                                                                        <select id="p_sex" class="custom-select rounded-0">
                                                                            <option value="">Select</option>
                                                                            <option value="M">Male</option>
                                                                            <option value="F">Female</option>
                                                                            <option value="N">N.A.</option>
                                                                        </select></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group row clearfix">
                                                                    <label class="col-sm-3 col-form-label">Age: </label>
                                                                    <div class="col-sm-7">
                                                                        <input maxlength="3" class="form-control" type="text" id="p_age" onkeypress="return onlynumbers(event)"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group row clearfix">
                                                                    <label class="col-sm-3 col-form-label">Caste: </label>
                                                                    <div class="col-sm-7">
                                                                        <input class="form-control" type="text" id="p_caste" onblur="remove_apos(this.value,this.id)"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row md-12" >
                                                            <div class="col-md-4">
                                                                <div class="form-group row clearfix">
                                                                    <label class="col-sm-3 col-form-label">Occupation: </label>
                                                                    <div class="col-sm-7">
                                                                        <!-- <input onkeypress="return onlyalphab(event)" onblur="remove_apos(this.value,this.id)" type="text" id="p_occ"  class="ui-autocomplete-input form-control" autocomplete="off"> -->
                                                                        <select id="p_occ" class="custom-select rounded-0 ">
                                                                            <option value="">Select</option>
                                                                            <?php foreach ($occ_list as $key => $occ) { ?>
                                                                                <option value="<?= $occ['id'] ?>"><?= $occ['occ_desc'] ?></option>
                                                                            <?php } ?>
                                                                        </select>

                                                                        <input type="hidden" id="p_occ_hd_code"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group row clearfix">
                                                                    <label class="col-sm-3 col-form-label">Education/Qualification:</label>
                                                                    <div class="col-sm-7">
                                                                        <!-- <input onkeypress="return onlyalphab(event)" onblur="remove_apos(this.value,this.id)"
                                                                        type="text" id="p_edu"  class="ui-autocomplete-input form-control" autocomplete="off"> -->
                                                                        <select id="p_edu" class="custom-select rounded-0 ">
                                                                            <option value="">Select</option>
                                                                            <?php foreach ($edu_list as $key => $edu) { ?>
                                                                                <option value="<?= $edu['id'] ?>"><?= $edu['edu_desc'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <input type="hidden" id="p_edu_hd_code"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row md-12 mt-2 mb-2" style="display:none;" id="stateCentral">
                                                        <div class="col-md-4">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">State Name:</label>
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" id="s_causetitle">
                                                                    <label for="s_causetitle"></label>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="text" list="pStateList" id="p_statename" class="form-control" onkeypress="return onlyalphabnum(event)" onblur="remove_apos(this.value,this.id)">
                                                                    <datalist id="pStateList">
                                                                        <?php
                                                                            if(!empty($get_only_state_name)){
                                                                                foreach ($get_only_state_name as $val) { ?>
                                                                                    <option value="<?= $val['value'] ?>">        
                                                                        <?php   }
                                                                            }
                                                                         ?>
                                                                    </datalist>
                                                                    <input type="hidden" id="p_statename_hd">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Department:</label>
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" id="d_causetitle">
                                                                    <label for="d_causetitle"></label>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="text" list="pDepttList" id="p_deptt" class="form-control" onkeypress="return onlyalphabnum(event)" onblur="remove_apos(this.value,this.id)">
                                                                    <datalist id="pDepttList"></datalist>
                                                                    <input type="hidden" id="p_deptt_hd">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Post:</label>
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" id="p_causetitle">
                                                                    <label for="p_causetitle"></label>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="text" list="pDeptList" id="p_post" class="form-control" onkeypress="return onlyalphabnum(event)" onblur="remove_apos(this.value,this.id)">
                                                                    <datalist id="pDeptList">
                                                                        <?php
                                                                            if(!empty($get_only_post)){
                                                                                foreach ($get_only_post as $val) { ?>
                                                                                    <option value="<?= $val['value'] ?>">        
                                                                        <?php   }
                                                                            }
                                                                         ?>
                                                                    </datalist>
                                                                    <input type="hidden" id="post_code">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row md-12 mt-2 mb-2" style="display:none;" id="othrOrgan">
                                                        <div class="col-md-6">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Department:</label>
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" id="d_causetitle">
                                                                    <label for="d_causetitle"></label>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="text" list="pDepttList" id="p_deptt" class="form-control p_deptt2" onkeypress="return onlyalphabnum(event)" onblur="remove_apos(this.value,this.id)">
                                                                    <datalist id="pDepttList"></datalist>
                                                                    <input type="hidden" id="p_deptt_hd" class="p_deptt_hd2">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Post:</label>
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" id="p_causetitle">
                                                                    <label for="p_causetitle"></label>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="text" list="pDeptList" id="p_post" class="form-control p_post2" onkeypress="return onlyalphabnum(event)" onblur="remove_apos(this.value,this.id)">
                                                                    <datalist id="pDeptList">
                                                                        <?php
                                                                            if(!empty($get_only_post)){
                                                                                foreach ($get_only_post as $val) { ?>
                                                                                    <option value="<?= $val['value'] ?>">        
                                                                        <?php   }
                                                                            }
                                                                         ?>
                                                                    </datalist>
                                                                    <input type="hidden" id="post_code" class="post_code2" >
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row md-12" >
                                                        <div class="col-md-4">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Address:</label>
                                                                <div class="col-sm-7">
                                                                    <textarea class="form-control" rows="4" id="p_add" onblur="remove_apos(this.value,this.id)" maxlength="250"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Tehsil/Place/City:</label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" id="p_city" class="form-control" onblur="remove_apos(this.value,this.id)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Country: </label>
                                                                <div class="col-sm-7">
                                                                    <select id="p_cont" class="custom-select rounded-0 ">
                                                                        <?php if(!empty($country_list)){
                                                                            foreach ($country_list as $country) { ?>
                                                                                <option value="<?= $country['id'] ?>" <?php if($country['id']=='96') echo "Selected"; ?> ><?= $country['country_name'] ?></option>
                                                                        <?php }
                                                                        }  ?>
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row md-12" >
                                                        <div class="col-md-4">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">State:</label>
                                                                <div class="col-sm-7">
                                                                    <select id="p_st" class="custom-select rounded-0 " >
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                        $sel ='';
                                                                        $stateArr = array();
                                                                        if (count($state_list)) {
                                                                            foreach ($state_list as $dataRes) { ?>
                                                                                <option <?php echo $sel; ?> value="<?= sanitize(trim($dataRes['cmis_state_id'])); ?>"><?=sanitize(strtoupper($dataRes['agency_state'])); ?> </option>
                                                                                <?php
                                                                                $tempArr = array();
                                                                                $tempArr['id'] = sanitize(trim($dataRes['cmis_state_id']));
                                                                                $tempArr['state_name'] = strtoupper(trim($dataRes['agency_state']));
                                                                                $stateArr[] = (object)$tempArr;
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">District:</label>
                                                                <div class="col-sm-7">
                                                                    <select id="p_dis" class="custom-select rounded-0 ">
                                                                        <!-- <option value="">Select</option> -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Pin:</label>
                                                                <div class="col-sm-7">
                                                                    <input maxlength="6" type="text" class="form-control" id="p_pin" onkeypress="return onlynumbers(event)" onblur="remove_apos(this.value,this.id)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row md-12" >
                                                        <div class="col-md-4">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Phone:</label>
                                                                <div class="col-sm-7">
                                                                    <input class="form-control" type="text" id="p_mob" maxlength="10" onkeypress="return onlynumbers(event)" onblur="remove_apos(this.value,this.id)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Email:</label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" id="p_email" class="form-control" onblur="remove_apos(this.value,this.id)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Lower Court Case:</label>
                                                                <div class="col-sm-7">
                                                                    <select id="p_lowercase" class="form-control" multiple="" size="6">
                                                                        <?php foreach ($lowercase as $rowLower) { ?>
                                                                            <option value="<?php echo $rowLower['lower_court_id']; ?>" title="<?php echo $rowLower['type_sname'].'/'.$rowLower['lct_caseno'].'/'.$rowLower['lct_caseyear'].' - '.$rowLower['agency_name']; ?>" >
                                                                                <?php echo $rowLower['type_sname'].'/'.$rowLower['lct_caseno'].'/'.$rowLower['lct_caseyear'].' - '.$rowLower['agency_name']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>

                                                                    <input type="hidden" id="hd_casetype" value="<?= !empty($casetypeDetails) ? $casetypeDetails[0]['casetype_id'] : ''  ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group row clearfix">
                                                            <label class="col-sm-3 col-form-label">Remark For Add Party/LRs:</label>
                                                            <div class="col-sm-7">
                                                                <input type="text" id="remark_lrs" class="form-control" onblur="remove_apos(this.value,this.id)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row md-12" >
                                                        <div class="col-md-4" id="pStatus" style="display:none;">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Status:</label>
                                                                <div class="col-sm-7">
                                                                    <select id="p_status" class="custom-select rounded-0 ">
                                                                        <option value="P">Pending</option>
                                                                        <option value="T">Delete as Wrongly Entered [No. Will Shift]</option>
                                                                        <option value="O">Delete by Order [No. Will Not Shift]</option>
                                                                        <option value="D">Dispose</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" id="pStatusrem" style="display:none;">
                                                            <div class="form-group row clearfix">
                                                                <label class="col-sm-3 col-form-label">Deletion/Disposal Remark:</label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" id="remark_delete" class="form-control" onblur="remove_apos(this.value,this.id)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mt-5 mb-3">
                                                        <div style="text-align: center;font-weight: bold;cursor: pointer;width: 15%;margin: 0 auto;border: 1px dotted #000;" id="sp_add_add">Add Additional Address</div>
                                                    </div>

                                                    <hr>

                                                    <!--extra address respondend-->
                                                    <div id="add_adres" style=" width:100%; display:none;" class="multi-field-wrapper mb-4">
                                                        <div class="multi-fields" >
                                                            <div class="multi-field">
                                                                <span id="addRowOther" class="add-field_heading btn btn-outline-success float-sm-right mt-4"><i class='fas fa-plus-circle'></i></span>
                                                                <!-- <button type="button"  class="remove_in_row_heading remove-field_heading d-none btn btn-outline-danger mt-4 float-sm-right" value="1"><i class='fas fa-minus-circle'></i></button> -->
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label>Address : </label>
                                                                        <textarea class="form-control" rows="1" id="add_1" placeholder="Enter Address"></textarea>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label>Country : </label>
                                                                        <select id="cont_1" name="cont_1" class="custom-select rounded-0 ">
                                                                            <!-- <option value="96" selected="">India</option> -->
                                                                            <?php if(!empty($country_list)){
                                                                                foreach ($country_list as $country) { ?>
                                                                                    <option value="<?= $country['id'] ?>" <?php if($country['id']=='96') echo "Selected"; ?> ><?= $country['country_name'] ?></option>
                                                                            <?php }
                                                                            }  ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label>State: </label>
                                                                        <select id="st_1" name="st_1" class="custom-select rounded-0 ">
                                                                            <option>Select</option>
                                                                            <?php
                                                                            $sel1 ='';
                                                                            $stateArr1 = array();
                                                                            if (count($state_list)) {
                                                                                foreach ($state_list as $dataRes) { ?>
                                                                                    <option <?php echo $sel1; ?> value="<?= sanitize(trim($dataRes['cmis_state_id'])); ?>"><?=sanitize(strtoupper($dataRes['agency_state'])); ?> </option>
                                                                                    <?php
                                                                                    $tempArr = array();
                                                                                    $tempArr['id'] = sanitize(trim($dataRes['cmis_state_id']));
                                                                                    $tempArr['state_name'] = strtoupper(trim($dataRes['agency_state']));
                                                                                    $stateArr1[] = (object)$tempArr;
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label>District: </label>
                                                                        <select id="dis_1" name="dis_1" class="custom-select rounded-0 ">
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- <div class="11uploadedFile" style="display: inline-grid;width: 100%;margin-bottom: 1%;"></div> -->
                                                        <div id="newRowOther"></div>

                                                    </div>
                                                    <!--end extra Address respondent-->

                                                    <div class="col-md-12 mb-4 mt-2 text-center befSubmt">
                                                        <button onclick="call_save_extra()" id="get_case_details"  class="btn btn-primary" type="button">Save</button>
                                                        <button onclick="location.reload()"   class="btn btn-primary" type="button">Cancel</button>
                                                    </div>

                                                </div>
                                                <!-- /.row -->


                                                <!-- Edit table -->
                                                <div class="row mt-5">
                                                    <div id="wrapper_1" class="col-md-6">
                                                        <h3 class="card-title mb-5" style="float: none !important; text-align: center;">Party Details - Petitioner</h3>
                                                        <table id="example1" class="table table-hover showData">
                                                            <thead>
                                                                <tr>
                                                                    <th>Action</th>
                                                                    <th>S.No.</th>
                                                                    <!-- <th>Party Type</th> -->
                                                                    <th>Name</th>
                                                                    <th>Relation Of</th>
                                                                    <!-- <th>Age</th> -->
                                                                    <th>Address</th>
                                                                    <th>Lower Court</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    if(!empty($party_list)){
                                                                    foreach ($party_list as $ky => $list) {
                                                                        // echo "<pre>"; print_r($list); die; // sr_no // sr_no_show
                                                                        if($list['pet_res'] == 'P'){  ?>
                                                                    <tr style="<?php if($list['pflag'] == 'O'){ echo 'color:red;'; } else if($list['pflag'] == 'D'){ echo 'color:#9932CC;'; }else{ echo ""; }  ?> " >
                                                                        <td>
                                                                            <span onclick='editParty(<?= json_encode($list) ?>)' class="btn btn-info btn-sm"><i class="fas fa-edit" aria-hidden="true"></i></span>

                                                                            <!-- <span onclick="deleteParty('<?= $list['auto_generated_id'] ?>')" class="btn btn-danger btn-sm"><i class="fas fa-trash" aria-hidden="true"></i></span> -->
                                                                        </td>
                                                                        <td><?= $list['sr_no_show'] ?></td>
                                                                        <!-- <td><?= $list['pet_res'] == 'P' ? 'Petitioner' : 'Respondant' ?></td> -->
                                                                        <td><?= $list['partyname'] ?></td>
                                                                        <td><?php  if($list['sonof'] == 'D') { echo 'Daughter'; }
                                                                            if($list['sonof'] == 'S') { echo 'Son'; }
                                                                            if($list['sonof'] == 'W') { echo 'Wife'; }
                                                                            if($list['sonof'] == 'F') { echo 'Father'; }
                                                                            if($list['sonof'] == 'M') { echo 'Mother'; }
                                                                            ?></td>
                                                                        <!-- <td><?= $list['age'] ?></td> -->
                                                                        <td>
                                                                            <?= $list['addr1'] != '' ? $list['addr1'].', '.$list['addr2'] : $list['addr2'] ?>
                                                                        </td>
                                                                        <td><?= $list['lowercase_id'] ?></td>
                                                                    </tr>
                                                                <?php } } } ?>
                                                                   
                                                            </tbody>
                                                            </table>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <h3 class="card-title mb-5" style="float: none !important; text-align: center;">Party Details - Respondant</h3>
                                                        <table id="example2" class="table table-hover showData">
                                                            <thead>
                                                                <tr>
                                                                    <th>Action</th>
                                                                    <th>S.No.</th>
                                                                    <!-- <th>Party Type</th> -->
                                                                    <th>Name</th>
                                                                    <th>Relation Of</th>
                                                                    <!-- <th>Age</th> -->
                                                                    <th>Address</th>
                                                                    <th>Lower Court</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    if(!empty($party_list)){
                                                                    foreach ($party_list as $ky => $list) {
                                                                        if($list['pet_res'] == 'R'){  ?>
                                                                    <tr style="<?php if($list['pflag'] == 'O'){ echo 'color:red;'; } else if($list['pflag'] == 'D'){ echo 'color:#9932CC;'; }else{ echo ""; }  ?> " >
                                                                        <td>
                                                                            <span onclick='editParty(<?= json_encode($list) ?>)' class="btn btn-info btn-sm"><i class="fas fa-edit" aria-hidden="true"></i></span>

                                                                            <!-- <span onclick="deleteParty('<?= $list['auto_generated_id'] ?>')" class="btn btn-danger btn-sm"><i class="fas fa-trash" aria-hidden="true"></i></span> -->
                                                                        </td>
                                                                        <td><?= $list['sr_no_show'] ?></td>
                                                                        <!-- <td><?= $list['pet_res'] == 'P' ? 'Petitioner' : 'Respondant' ?></td> -->
                                                                        <td><?= $list['partyname'] ?></td>
                                                                        <td><?php  if($list['sonof'] == 'D') { echo 'Daughter'; }
                                                                            if($list['sonof'] == 'S') { echo 'Son'; }
                                                                            if($list['sonof'] == 'W') { echo 'Wife'; }
                                                                            if($list['sonof'] == 'F') { echo 'Father'; }
                                                                            if($list['sonof'] == 'M') { echo 'Mother'; }
                                                                            ?></td>
                                                                        <!-- <td><?= $list['age'] ?></td> -->
                                                                        <td>
                                                                            <?= $list['addr1'] != '' ? $list['addr1'].', '.$list['addr2'] : $list['addr2'] ?>
                                                                        </td>
                                                                        <td><?= $list['lowercase_id'] ?></td>
                                                                    </tr>
                                                                <?php } } } ?>
                                                                   
                                                            </tbody>
                                                            </table>
                                                    </div>
                                                </div>


                                                <!-- Modal -->
                                                <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Delete Party</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body" style="margin: 0 auto;">
                                                                <div class="row mt-5" >
                                                                    <div class="col-md-12">
                                                                        <div class="form-group clearfix">
                                                                            <h4>Are you sure to delete party ?</h4>
                                                                            <!-- <label><strong> Action:</strong></label> &nbsp;&nbsp; -->
                                                                            <!-- <div class="icheck-primary d-inline">
                                                                                <input type="radio" id="radio_delete_D" name="radio_delete_act" value="D" >
                                                                                <label for="radio_delete_D"><strong>Dispose By Court Order</strong></label>
                                                                            </div>&nbsp;&nbsp;
                                                                            <div class="icheck-primary d-inline">
                                                                                <input type="radio" id="radio_delete_O" name="radio_delete_act" value="O">
                                                                                <label for="radio_delete_O"><strong>Delete By Court Order</strong></label>
                                                                            </div>&nbsp;&nbsp;
                                                                            <div class="icheck-primary d-inline">
                                                                                <input type="radio" id="radio_delete_T" name="radio_delete_act" value="T">
                                                                                <label for="radio_delete_T"><strong>Delete as Wrongly Entered</strong></label>
                                                                            </div>&nbsp;&nbsp; -->
                                                                        </div>
                                                                        <input type="hidden" name="autoIdParty" id="autoIdParty" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button onclick="deleteActionParty()" type="button" class="btn btn-primary">Submit</button>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <!-- Modify Copied parties table -->
                                                <div class="row mt-5">
                                                    <div id="wrapper_2" class="col-md-6">
                                                        <h2 class="card-title mb-5" style="float: none !important; text-align: center;">Copied Party Details - Petitioner</h2>
                                                        <table id="example11" class="table table-hover showData">
                                                            <thead>
                                                                <tr>
                                                                    <th>Action</th>
                                                                    <th>S.No.</th>
                                                                    <!-- <th>Party Type</th> -->
                                                                    <th>Name</th>
                                                                    <th>Relation Of</th>
                                                                    <!-- <th>Age</th> -->
                                                                    <th>Address</th>
                                                                    <th>Lower Court</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    if(!empty($copied_party_list)){
                                                                    foreach ($copied_party_list as $ky => $list) { 
                                                                        if($list['pet_res'] == 'P'){ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <span onclick='editParty(<?= json_encode($list) ?>)' class="btn btn-info btn-sm"><i class="fas fa-edit" aria-hidden="true"></i></span>

                                                                            <!-- <span onclick="deleteParty('<?= $list['auto_generated_id'] ?>')" class="btn btn-danger btn-sm"><i class="fas fa-trash" aria-hidden="true"></i></span> -->
                                                                        </td>
                                                                        <td><?= $list['sr_no_show'] ?></td>
                                                                        <!-- <td><?= $list['pet_res'] == 'P' ? 'Petitioner' : 'Respondant' ?></td> -->
                                                                        <td><?= $list['partyname'] ?></td>
                                                                        <td><?php  if($list['sonof'] == 'D') { echo 'Daughter'; }
                                                                            if($list['sonof'] == 'S') { echo 'Son'; }
                                                                            if($list['sonof'] == 'W') { echo 'Wife'; }
                                                                            if($list['sonof'] == 'F') { echo 'Father'; }
                                                                            if($list['sonof'] == 'M') { echo 'Mother'; }
                                                                            ?></td>
                                                                        <!-- <td><?= $list['age'] ?></td> -->
                                                                        <td>
                                                                            <?= $list['addr1'] != '' ? $list['addr1'].', '.$list['addr2'] : $list['addr2'] ?>
                                                                        </td>
                                                                        <td><?= $list['lowercase_id'] ?></td>
                                                                    </tr>
                                                                <?php } } } ?>
                                                                   
                                                            </tbody>
                                                            </table>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <h2 class="card-title mb-5" style="float: none !important; text-align: center;">Copied Party Details - Respondant</h2>
                                                        <table id="example22" class="table table-hover showData">
                                                            <thead>
                                                                <tr>
                                                                    <th>Action</th>
                                                                    <th>S.No.</th>
                                                                    <!-- <th>Party Type</th> -->
                                                                    <th>Name</th>
                                                                    <th>Relation Of</th>
                                                                    <!-- <th>Age</th> -->
                                                                    <th>Address</th>
                                                                    <th>Lower Court</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    if(!empty($copied_party_list)){
                                                                    foreach ($copied_party_list as $ky => $list) { 
                                                                        if($list['pet_res'] == 'R'){ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <span onclick='editParty(<?= json_encode($list) ?>)' class="btn btn-info btn-sm"><i class="fas fa-edit" aria-hidden="true"></i></span>

                                                                            <!-- <span onclick="deleteParty('<?= $list['auto_generated_id'] ?>')" class="btn btn-danger btn-sm"><i class="fas fa-trash" aria-hidden="true"></i></span> -->
                                                                        </td>
                                                                        <td><?= $list['sr_no_show'] ?></td>
                                                                        <!-- <td><?= $list['pet_res'] == 'P' ? 'Petitioner' : 'Respondant' ?></td> -->
                                                                        <td><?= $list['partyname'] ?></td>
                                                                        <td><?php  if($list['sonof'] == 'D') { echo 'Daughter'; }
                                                                            if($list['sonof'] == 'S') { echo 'Son'; }
                                                                            if($list['sonof'] == 'W') { echo 'Wife'; }
                                                                            if($list['sonof'] == 'F') { echo 'Father'; }
                                                                            if($list['sonof'] == 'M') { echo 'Mother'; }
                                                                            ?></td>
                                                                        <!-- <td><?= $list['age'] ?></td> -->
                                                                        <td>
                                                                            <?= $list['addr1'] != '' ? $list['addr1'].', '.$list['addr2'] : $list['addr2'] ?>
                                                                        </td>
                                                                        <td><?= $list['lowercase_id'] ?></td>
                                                                    </tr>
                                                                <?php } } } ?>
                                                                   
                                                            </tbody>
                                                            </table>
                                                    </div>
                                                </div>


                                            </div>
                                            <!-- /.add_party_tab_panel -->


                                            <div class="tab-pane" id="copy_party_tab_panel">
                                                <!-- <h4 class="basic_heading mt-3"> <strong>Copy Party Details</strong> </h4> -->

                                                <div class="row mt-5 mb-3">
                                                    <!-- <div class="col-md-6">
                                                        <label>From Diary No.</label>
                                                        <input type="text" class="form-control frmCpy" id="dno" name="dno" placeholder="Enter From Diary Number">
                                                    </div> -->

                                                    <!-- <div class="col-md-6">
                                                        <label>From Year</label>
                                                        <input type="text" class="form-control frmCpy" id="dyr" name="dyr" placeholder="Enter From Year">
                                                    </div> -->

                                                    <div class="col-md-6">
                                                        <div class="form-group row clearfix">
                                                            <label class="col-sm-3 col-form-label"><strong>From Diary No.</strong></label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control frmCpy" id="dno" name="dno" placeholder="Enter From Diary Number">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group row clearfix">
                                                            <label class="col-sm-3 col-form-label"><strong>From Year</strong></label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control frmCpy" id="dyr" name="dyr" placeholder="Enter From Year">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    

                                                    <div id="div_result" class="col-md-12 text-center"></div>
                                                </div>
                                                <div class="row mt-3 mb-3">
                                                    <!-- <div class="col-md-6">
                                                        <label>To Diary No.</label>
                                                        <input type="text" class="form-control toCpy" id="dno1" name="dno1" placeholder="Enter To Diary Number">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>To Year</label>
                                                        <input type="text" class="form-control toCpy" id="dyr1" name="dyr1"  placeholder="Enter Enter To Year">
                                                    </div> -->
                                                    <div class="col-md-6">
                                                        <div class="form-group row clearfix">
                                                            <label class="col-sm-3 col-form-label"><strong>To Diary No.</strong></label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control toCpy" id="dno1" name="dno1" placeholder="Enter To Diary Number">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group row clearfix">
                                                            <label class="col-sm-3 col-form-label"><strong>To Year</strong></label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control toCpy" id="dyr1" name="dyr1"  placeholder="Enter Enter To Year">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="div_result1" class="col-md-12 text-center"></div>
                                                </div>

                                                <div class="col-md-12 mb-3 mt-5 text-center">
                                                    <button class="btn btn-primary" onclick="copy_details()" type="button">Copy Party Details</button>
                                                </div>


                                            </div>
                                            <!-- /.copy_party_tab_panel -->

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

    <script>
        $('.col-sm-12.col-form-label.ml-4').hide()

        var state_Arr = '<?php echo json_encode($stateArr)?>';

        $('.remove_in_row').click(function() {
            var v = $(this).val();
            $('.delete_out_row_'+v).click();
        });


        function updateCSRFToken() {
            $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
            });
        }
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })

        $(document).on("blur","#p_occ",function(){
            if(this.value.indexOf('~') != '-1'){
                var htht = this.value.split('~');
                $("#p_occ").val(htht[1]);
                $("#p_occ_hd_code").val(htht[0]);
            }
        });

        $(document).on("blur","#p_edu",function(){
            if(this.value.indexOf('~') != '-1'){
                var htht = this.value.split('~');
                $("#p_edu").val(htht[1]);
                $("#p_edu_hd_code").val(htht[0]);
            }
        });

        $(document).on("blur","#p_statename",function(){
            if(this.value.indexOf('~') != '-1'){
                var htht = this.value.split('~');
                $("#p_statename").val(htht[1]);
                $("#p_statename_hd").val(htht[0]);
            }
        });

        $(document).on("blur","#p_post",function(){
            if(this.value.indexOf('~') != '-1'){
                var htht = this.value.split('~');
                $("#p_post").val(htht[1]);
                $("#post_code").val(htht[0]);
            }
        });

        $(document).on("blur","#p_deptt",function(){
            if(this.value.indexOf('~') != '-1'){
                var htht = this.value.split('~');
                $("#p_deptt").val(htht[1]);
                $("#p_deptt_hd").val(htht[0]);
            }
        });

        
        $(document).on("blur",".p_deptt2",function(){
            if(this.value.indexOf('~') != '-1'){
                var htht = this.value.split('~');
                $(".p_deptt2").val(htht[1]);
                $(".p_deptt_hd2").val(htht[0]);
            }
        });
        
        $(document).on("blur",".p_post2",function(){
            if(this.value.indexOf('~') != '-1'){
                var htht = this.value.split('~');
                $(".p_post2").val(htht[1]);
                $(".post_code2").val(htht[0]);
            }
        });

        function getParty_status(value,flag){
            updateCSRFToken();

            var totalval= '';
            if($("#pri_action").val()=='L' && flag==''){
                totalval=$("#for_selecting_lrs").val().split('~');
            }else{
                totalval = '';
            }
            if(value == "" && flag==''){
                $("#pno").val("");
            }else{
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

                let dataObj = { fno:$("#hdfno").val(), val: value, add_selector: $("#pri_action").val(), srno: totalval[1], srnoshow: totalval[2], flag }

                $.ajax({
                    type: 'POST',
                    url:"<?php echo base_url('Filing/Party/set_party_status'); ?>",
                    data: { CSRF_TOKEN: CSRF_TOKEN_VALUE, data: dataObj }
                })
                    .done(function(msg){
                        if(msg.indexOf('~')>0){
                            var msg2 = msg.split('~');
                            $("#pno").val(msg2[0]);
                            if(msg2[1] != 0 && msg2[1] != ''){
                                $("#p_lowercase option").each(function()
                                {
                                    $(this).removeProp('selected');
                                });
                                var lowerids = msg2[1].split(',');

                                for(var i=0;i<lowerids.length;i++){
                                    $("#p_lowercase option").each(function()
                                    {
                                        // Add $(this).val() to your list
                                        if($(this).val()==lowerids[i])
                                            $(this).prop('selected', true);
                                    });
                                }
                                // $("#p_lowercase").prop("disabled",true); 
                            }else{
                                $("#p_lowercase").removeProp('disabled');
                            }
                        }else{
                            $("#pno").val(msg);
                            $("#p_lowercase").removeProp('disabled');
                        }
                        updateCSRFToken();
                    })
                    .fail(function(){
                        alert("ERROR, Please Contact Server Room");
                        updateCSRFToken();
                    });
            }
        }

        $(document).on('change','#party_flag',function(){
            getParty_status(this.value,'');
            $("#p_cntpro").val("C");
            if(this.value=='P')
                $("#p_cntpro").prop('disabled',true);
            else
                $("#p_cntpro").removeProp('disabled');

        });

        $(document).on('change','#pri_action',function(){
            if($(this).val()=='P'){
                $("#for_selecting_lrs").css('display','none');
                $("#party_flag").prop('disabled',false);
                $("#p_lowercase").removeProp('disabled');
                $("#sel_lrstolrs").html("<option value=''>No Data For LRs to LRs</option>");
            }
            else if($(this).val()=='L'){
                $("#for_selecting_lrs").css('display','inline');
                $("#for_selecting_lrs").val("");
                $("#party_flag").prop('disabled',true);
            }
            $("#remark_lrs").val("");
            $("#party_flag").val("");
            $("#pno").val("");
        });

        $(document).on('change','#for_selecting_lrs',function(){
            var totalval=$(this).val().split('~');
            $("#party_flag").val(totalval[0]);
            getParty_status(totalval[0],'');
            //     $("#party_flag").change();
        });

        $(document).on('change','#p_cont',function(){
            if(this.value != "96"){
                $("#p_st").prop("disabled",true);
                $("#p_st").val("");
                $("#p_dis").prop("disabled",true);
                $("#p_dis").val("");
            }
            else{
                $("#p_st").removeProp("disabled");
                $("#p_dis").removeProp("disabled");
            }
        });

        $(document).on("change","#p_rel",function(){
            if(this.value == 'S' || this.value == 'F')
                $("#p_sex").val("M");
            else if(this.value == 'D' || this.value == 'W' || this.value == 'M')
                $("#p_sex").val("F");
        });


        function onlynumbers(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            // alert(charCode);
            if ((charCode >= 48 && charCode<= 57)||charCode==9||charCode==8|| charCode == 37 || charCode == 39 || charCode== 46) {
                return true;
            }
            return false;
        }

        function onlyalpha(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            //alert(charCode);
            if ((charCode >= 65 && charCode<= 90)||(charCode >= 97 && charCode<= 122)||charCode==9||charCode==8||
                charCode==127||charCode==32||charCode==46||charCode==47||charCode==64|| charCode == 37 || charCode == 39) {
                return true;
            }
            return false;
        }

        function activate_extra(value){

            // alert(value)
            // if(value=="I")
            // {
            //     document.getElementById('p_post').value="";
            //     document.getElementById('p_deptt').value="";
            //     document.getElementById('p_statename').value="";
            //     document.getElementById('for_I_1').style.display='table-row';
            //     document.getElementById('for_I_2').style.display='table-row';
            //     document.getElementById('for_I_3').style.display='table-row';
            //     document.getElementById('for_I_4').style.display='table-row';
            //     document.getElementById('tr_d').style.display='none';
            //     document.getElementById('tr_d0').style.display='none';
            //     //document.getElementById('tr_d1').style.display='none';
            //     //document.getElementById('state_department_in').value='';
            // }
            // else if(value!="I")
            // {
            //     document.getElementById('p_name').value="";
            //     document.getElementById('p_rel').value="";
            //     document.getElementById('p_rel_name').value="";
            //     document.getElementById('p_sex').value="";
            //     document.getElementById('p_age').value="";
            //     document.getElementById('p_occ').value="";
            //     document.getElementById('p_caste').value="";
            //     document.getElementById('p_edu').value="";
            //     document.getElementById('for_I_1').style.display='none';
            //     document.getElementById('for_I_2').style.display='none';
            //     document.getElementById('for_I_3').style.display='none';
            //     document.getElementById('for_I_4').style.display='none';
            //     document.getElementById('tr_d').style.display='table-row';
            //     if(value=='D3')
            //         document.getElementById('tr_d0').style.display='none';
            //     else
            //         document.getElementById('tr_d0').style.display='table-row';
                
            // }
        }

        function onlyalphabnum(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            // alert(charCode);
            if ((charCode >= 48 && charCode<= 57) || (charCode >= 65 && charCode<= 90)||(charCode >= 48 && charCode<= 57)||(charCode >= 97 && charCode<= 122)||charCode==9||charCode==8||
                charCode==127||charCode==32||charCode==46||charCode==47||charCode==64||charCode==40||charCode==41
                || charCode == 37 || charCode == 39||charCode==44) {
                return true;
            }
            return false;
        }

        function onlyalphab(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            //alert(charCode);
            if ((charCode >= 65 && charCode<= 90)||(charCode >= 97 && charCode<= 122)||(charCode >= 48 && charCode<= 57)
                ||charCode==9||charCode==8||charCode==127||charCode==32||charCode==46||charCode==47||charCode==64||
                charCode==40||charCode==41|| charCode == 37 || charCode == 39||charCode==44) {
                return true;
            }
            return false;
        }

        function remove_apos(value,id){
            var string = value.replace("'","");
            string = string.replace("#","No");
            string = string.replace("&","and");
            $("#"+id).val(string);
        }


        function call_save_extra(){

            updateCSRFToken()


            alert("Registry is directed not to accept any application or petition on behalf of:- \n 1) Suraj India Trust or Mr. Rajiv Daiya as per Hon'ble Court Order dated. 08-02-2018 in MA no. 1158/2017(Suraj India Trust Vs UOI) \n 2) ASOK PANDE as per Hon'ble Court Order dated. 26-10-2018 in WP(C) No. 965/2018 (ASOK PANDE Vs UOI) \n 3) MANOHAR LAL SHARMA  as per Hon'ble Court Order dated. 07-12-2018 in WP(CRL) No. 315/2018 (MANOHAR LAL SHARMA Vs ARUN JAITLEY (AT PRESENT FINANCE MINISTER))\n" +
                " 4) P1-SURAJ MISHRA and P2-ROHIT GUPTA  as per Hon'ble Court Order dated. 08-05-2019 in WP(C) No. 1328/2018 (SURAJ MISHRA AND ANR VS. UNION OF INDIA AND ANR)");

            // return false;


            var party_type = document.getElementById('party_type').value;
            var party_flag = document.getElementById('party_flag');

            var p_name,p_rel,p_rel_name,p_sex,p_age,p_post,p_deptt,p_occ,p_edu;

            if($("#pri_action").val()=='L'){
                if($("#for_selecting_lrs").val()==''){
                    alert('Please Select Party to Insert LRs');
                    $("#for_selecting_lrs").focus();
                    return false;
                }
            }
            if(party_flag.value==""){
                alert('Please Select Party Type');
                setTimeout(() => {
                    party_flag.focus();
                }, 300);
                return false;
            }
            if(party_type=="I")
            {
                p_name = document.getElementById('p_name');
                p_rel = document.getElementById('p_rel');
                p_rel_name = document.getElementById('p_rel_name');
                p_sex = document.getElementById('p_sex');
                p_age = document.getElementById('p_age');
                p_occ = document.getElementById('p_occ');
                p_edu = document.getElementById('p_edu');

                if(p_name.value==''){
                    alert('Please Enter Party Name');p_name.focus();return false;
                }

            }
            if(party_type!="I")
            {
                p_post = document.getElementById('p_post');
                p_deptt = document.getElementById('p_deptt');

                if(p_statename.value=='' && document.getElementById('s_causetitle').checked )
                {
                    alert('Please Enter State Name');p_statename.focus();return false;
                }
                if(p_post.value=='' &&   document.getElementById('p_causetitle').checked )
                {
                    alert('Please Enter Party Post');p_post.focus();return false;
                }
                //if(p_deptt.value=='' || (p_deptt.value=='' && document.getElementById('d_causetitle').checked &&  party_no=='1' ))
                if(p_deptt.value=='' &&  document.getElementById('d_causetitle').checked )
                {
                    alert('Please Enter Party Department');p_deptt.focus();return false;
                }

                if((document.getElementById('p_statename').value=='' )&&(document.getElementById('p_post').value=='' )&& (document.getElementById('p_deptt').value==''))
                {
                    alert('Please Enter either State/Department/Post');p_deptt.focus();return false;
                }
            }
            if(document.getElementById('p_add').value=="")
            {
                alert('Please Enter Party Address');document.getElementById('p_add').focus();return false;
            }
            if(document.getElementById('p_city').value=="")
            {
                alert('Please Enter Party City');document.getElementById('p_city').focus();return false;
            }
            if(document.getElementById('p_cont').value=='96'){
                if(document.getElementById('p_st').value=="")
                {
                    alert('Please Enter Party State');document.getElementById('p_st').focus();return false;
                }
                if(document.getElementById('p_dis').value=="")
                {
                    alert('Please Enter Party District');document.getElementById('p_dis').focus();return false;
                }
            }

            if(document.getElementById('p_cont').value=="")
            {
                alert('Please Enter Party Country');document.getElementById('p_cont').focus();return false;
            }
            if(document.getElementById('p_email').value!='')
            {
                var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if(document.getElementById('p_email').value.match(mailformat))
                {
                    //return true;
                }
                else
                {
                    alert('Please enter valid email');
                    document.getElementById('p_email').focus();
                    return false;
                }
            }

            if(document.getElementById("p_lowercase").value == "" && (document.getElementById("hd_casetype").value!=5 && document.getElementById("hd_casetype").value!=6 && document.getElementById("hd_casetype").value!='24'  && document.getElementById("hd_casetype").value!='17' && document.getElementById("hd_casetype").value!='22' && document.getElementById("hd_casetype").value!='27' && document.getElementById("hd_casetype").value!='34'  && document.getElementById("hd_casetype").value!='35'&& document.getElementById("hd_casetype").value!='37' && document.getElementById("hd_casetype").value!='36' && document.getElementById("hd_casetype").value!='38' && document.getElementById("hd_casetype").value!='32' && document.getElementById("hd_casetype").value!='33'))
            {
                alert('Please Select Lower Court Case');
                p_lowercase.focus();return false;
            }
            var remark_lrs = $("#remark_lrs").val();
            if($("#pri_action").val()=='L'){
                if(remark_lrs==''){
                    alert('Please Enter Remarks for Adding LRs');
                    $("#remark_lrs").focus();
                    return false;
                }
            }


            var add_addresses = '';
            if($('#add_adres').css('display') != 'none'){
                var add_add_count = $('.multi-fields').length
                if(add_add_count>0){
                    for(var i=1;i<=add_add_count;i++){
                        // if($("#add-add_table_"+i)){
                        if($("#add_"+i).val()==''){
                            alert('Please Fill this Additional Address');
                            $("#add_"+i).focus();
                            return false;
                        }
                        if($("#cont_"+i).val()=='96'){
                            if($("#st_"+i).val()==''){
                                alert('Please Select Additional Address State');
                                $("#st_"+i).focus();
                                return false;
                            }
                            if($("#dis_"+i).val()==''){
                                alert('Please Select Additional Address District');
                                $("#dis_"+i).focus();
                                return false;
                            }
                        }
                        if($("#add_"+i).length > 0){
                            add_addresses = add_addresses+"^"+$("#add_"+i).val()+"~"+$("#cont_"+i).val()+"~"+$("#st_"+i).val()+"~"+$("#dis_"+i).val();
                        }
                        // }
                    }
                }
            }


            if($("#pno").val()=='0'){
                alert('Party No. Can not be 0');
                return false;
            }

            if($("#party_flag")!='I'){
                if($("#order1").val() == $("#order2").val() == $("#order3").val()){
                    alert('All Orders Can not be same');
                    return false;
                }
                else{
                    if($("#order1").val() == $("#order2").val()){
                        alert('Order1 and Order2 Can not be same');
                        return false;
                    }
                    else if($("#order2").val() == $("#order3").val()){
                        alert('Order2 and Order3 Can not be same');
                        return false;
                    }
                    else if($("#order1").val() == $("#order3").val()){
                        alert('Order1 and Order3 Can not be same');
                        return false;
                    }
                }
            }

            let obj = {}

            if(party_type=="I"){
                obj = {
                    "p_type": party_type,
                    "p_name": p_name.value,
                    "p_rel": p_rel.value,
                    "p_rel_name": p_rel_name.value,
                    "p_sex":p_sex.value,
                    "p_age": p_age.value,
                    "p_occ": document.getElementById('p_occ').value,
                    "p_edu": document.getElementById('p_edu').value,
                    "p_caste": document.getElementById('p_caste').value,
                    "p_occ_code": document.getElementById('p_occ_hd_code').value,
                    "p_edu_code": document.getElementById('p_edu_hd_code').value
                }
            }

            if(party_type!="I"){
                s_ct = document.getElementById('s_causetitle').checked;
                d_ct = document.getElementById('d_causetitle').checked;
                p_ct = document.getElementById('p_causetitle').checked;

                obj = {
                    "s_causetitle": s_ct,
                    "d_causetitle": d_ct,
                    "p_causetitle": p_ct,
                    "p_type": party_type,
                    "p_post": p_post.value,
                    "p_deptt": p_deptt.value,
                    "p_statename": $("#p_statename").val(),
                    "p_statename_hd": $("#p_statename_hd").val(),
                    "d_code": $("#p_deptt_hd").val(),
                    "p_code": document.getElementById('post_code').value
                };
            }

            var remark_del='';
            if($("#p_status").val()=='O' || $("#p_status").val()=='D'){
                remark_del = $("#remark_delete").val();
                if(remark_del==''){
                    alert('Please Enter Remark for Deletion/Disposal of Party');
                    $("#remark_delete").focus();
                    return false;
                }
            }

            let controlVal = $('#controllerValue').val()
            let auto_generated_id = $('#set_auto_generated_id').val()
            let hdpf = document.getElementById('hd_party_flag').value
            // let stObj = { "p_sta": "P", "hd_p_f": hdpf, "remark_del": remark_del }
            let stObj = { "p_sta": $("#p_status").val(), "hd_p_f": hdpf, "remark_del": remark_del }


            let party_num_edited = $('#enable_party').val() == 'ENABLE PARTY NO.' ? '0' : '1' 

            let comObj = {
                "controller": controlVal,
                "auto_generated_id": auto_generated_id,
                "fno": document.getElementById('hdfno').value,
                "p_f": party_flag.value,
                "p_add": document.getElementById('p_add').value,
                "p_city": document.getElementById('p_city').value,
                "p_pin": document.getElementById('p_pin').value,
                "p_dis": document.getElementById('p_dis').value,
                "p_st": document.getElementById('p_st').value,
                "p_cont": document.getElementById('p_cont').value,
                "p_mob": document.getElementById('p_mob').value,
                "p_email": document.getElementById('p_email').value ,
                "p_no": document.getElementById('pno').value ,
                "lowercase": $('#p_lowercase').val(),
                "remark_lrs": remark_lrs,
                "add_add": add_addresses,
                "cont_pro_info": $("#p_cntpro").val() ,
                "order1": $("#order1").val(),
                "order2": $("#order2").val(),
                "order3": $("#order3").val(),
                "party_num_edited": party_num_edited
            }

            let dataObj = {}
            if(controlVal == 'U'){
                dataObj = {...obj, ...comObj, ...stObj};
            }else{
                dataObj = {...obj, ...comObj};
            }
            // console.log("obj: ", dataObj)
            // return


            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

            $.ajax({
                type: "POST",
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, data: dataObj},
                url: "<?php echo base_url('Filing/Party/save_party_details'); ?>",
                success: function (data) {

                    // console.log("data:: ", data)
                    // return

                    if(data != ''){
                        data = JSON.parse(data);
                        alert(data.message)
                        updateCSRFToken();
                        location.reload();
                    }
                },
                error: function () {
                    alert("Error while saving data.")
                    updateCSRFToken();
                }
            });


        }


        var addrowCount = 1
        $("#addRowOther").click(function () {

            addrowCount = addrowCount + 1
            var html = '';
            html += '<div class="multi-fields" id="inputFormRow">'
            html += '<div class="multi-field">'
            html += '<span class="remove_in_row_heading remove-field_heading btn btn-outline-danger mt-4 float-sm-right removeRowOther"><i class="fas fa-minus-circle"></i></span>'
            html += '<div class="row">'
            html += '<div class="col-md-3">'
            html += '<label>Address : </label>'
            html += '<textarea class="form-control" rows="1" id="add_'+addrowCount+'" placeholder="Enter Address"></textarea></div>'
            html += '<div class="col-md-3">'
            html += '<label>Country : </label>'
            html += '<select id="cont_'+addrowCount+'" name="cont_'+addrowCount+'" class="custom-select rounded-0 ">'

            //html += '<option value="96" selected="">India</option>'
            <?php if(!empty($country_list)){
                foreach ($country_list as $country) { ?>
                    html += '<option value="<?= $country['id'] ?>" <?php if($country['id']=='96') echo "Selected"; ?> ><?= $country['country_name'] ?></option>'
            <?php }
            }  ?>
            
            html += '</select></div>'
            html += '<div class="col-md-3">'
            html += '<label>State: </label>'
            html += '<select  id="st_'+addrowCount+'" name="st_'+addrowCount+'" class="getdistOther custom-select rounded-0 ">'
            html += '<option>Select</option>'
            <?php $stateArr1 = array();
            if (count($state_list)) {
            foreach ($state_list as $dataRes) { ?>

            html += '<option value="<?= sanitize(trim($dataRes["cmis_state_id"])); ?>"><?=sanitize(strtoupper($dataRes["agency_state"])); ?> </option>'

            <?php
            $tempArr = array();
            $tempArr['id'] = sanitize(trim($dataRes['cmis_state_id']));
            $tempArr['state_name'] = strtoupper(trim($dataRes['agency_state']));
            $stateArr1[] = (object)$tempArr;
            }}?>

            html += '</select></div>'
            html += '<div class="col-md-3">'
            html += '<label>District: </label>'
            html += '<select id="dis_'+addrowCount+'" name="dis_'+addrowCount+'" class="custom-select rounded-0 ">'
            html += '</select></div></div></div></div>'

            $('#newRowOther').append(html);

            $('.getdistOther').on('change', function(e){
                let strId = e.target.id
                let val = e.target.value
                let id = strId.replace('st_', '')
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                $('#dis_'+id).val('');

                var get_state_id = val;
                if (get_state_id !='') {
                    $.ajax({
                        type: "GET",
                        data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: get_state_id},
                        url: "<?php echo base_url('Common/Ajaxcalls/get_districts'); ?>",
                        success: function (data) {
                            $('#dis_'+id).html(data);
                            updateCSRFToken();
                        },
                        error: function () {
                            updateCSRFToken();
                        }
                    });
                }
            })


        });

        $(document).on('click', '.removeRowOther', function () {
            $(this).closest('#inputFormRow').remove();
        });



        $(document).ready(function() {

            

            $("#example1").DataTable({
              "responsive": true, "lengthChange": false, "autoWidth": false,
              "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            
            $("#example2").DataTable({
              "responsive": true, "lengthChange": false, "autoWidth": false,
              "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

            $("#example11").DataTable({
              "responsive": true, "lengthChange": false, "autoWidth": false,
              "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example11_wrapper .col-md-6:eq(0)');

            $("#example22").DataTable({
              "responsive": true, "lengthChange": false, "autoWidth": false,
              "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example22_wrapper .col-md-6:eq(0)');


            $('#get_court_details').append('<hr />');
            $('.aftersubm').append('<hr />');
            $('.befSubmt').prepend('<hr />');


            $('#sp_add_add').click(function(){
                $('#add_adres').show()

                $('#st_1').change(function () {
                    var CSRF_TOKEN = 'CSRF_TOKEN';
                    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                    $('#dis_1').val('');

                    var get_state_id = $(this).val();
                    if (get_state_id !='') {
                        $.ajax({
                            type: "GET",
                            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: get_state_id},
                            url: "<?php echo base_url('Common/Ajaxcalls/get_districts'); ?>",
                            success: function (data) {
                                $('#dis_1').html(data);
                                updateCSRFToken();
                            },
                            error: function () {
                                updateCSRFToken();
                            }
                        });
                    }
                });

            })

            // pri_action
            $("#pri_action").change(function() {
                let valOpt = $("option:selected", this).val();
                // alert(valOpt)
                if(valOpt == 'L'){
                    $('.selectLR').show()
                }else{
                    $('.selectLR').hide()
                }
            })

            $('#enable_party').click(function(){
                if($('#enable_party').val() == 'ENABLE PARTY NO.'){
                    $('#pno').removeAttr('disabled', true)
                    $('#enable_party').val('DISABLE PARTY NO.')
                }else{
                    $('#pno').attr('disabled', true)
                    $('#enable_party').val('ENABLE PARTY NO.')
                }
            })

            $('#party_flag').change(function() {
                let valOpt = $("option:selected", this).val();
                if(valOpt == 'P'){
                    $('#p_cntpro').attr('disabled', true)
                }else{
                    $('#p_cntpro').removeAttr('disabled', true)
                }
            })


            $('#party_type').change(function() {
                updateCSRFToken();
                let valOpt = $("option:selected", this).val();
                if(valOpt == 'I'){
                    $('#individ').show()
                    $('#stateCentral').hide()
                    $('#othrOrgan').hide()
                }else if(valOpt == 'D1' || valOpt == 'D2'){
                    $('#stateCentral').show()
                    $('#individ').hide()
                    $('#othrOrgan').hide()
                }
                else if(valOpt == 'D3'){
                    $('#othrOrgan').show()
                    $('#individ').hide()
                    $('#stateCentral').hide()
                }

                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

                $.ajax({
                    type: "POST",
                    data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, deptt: valOpt},
                    url: "<?php echo base_url('Filing/Party/getDepttList'); ?>",
                    success: function (data) {
                        data = JSON.parse(data)
                        // console.log(data)
                        if(data.length){
                            let html = ''
                            data.forEach(el => {
                                html += '<option value="'+el.value+'">'
                            })
                            $('#pDepttList').append(html)
                        }else{
                            $('#pDepttList').html('')
                        }
                        updateCSRFToken();
                       
                    },
                    error: function () {
                        updateCSRFToken();
                    }
                });
            })



            //----------Get District List----------------------//
            $('#p_st').change(function () {
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                $('#p_dis').val('');

                var get_state_id = $(this).val();
                if (get_state_id !='') {
                    $.ajax({
                        type: "GET",
                        data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: get_state_id},
                        url: "<?php echo base_url('Common/Ajaxcalls/get_districts'); ?>",
                        success: function (data) {
                            $('#p_dis').html(data);
                            updateCSRFToken();
                        },
                        error: function () {
                            updateCSRFToken();
                        }
                    });
                }
            });


        });


        function deleteParty(id){
            $('#autoIdParty').val(id);
            $('#deletemodal').modal('toggle')
        }

        // Delete Row
        function deleteActionParty(){
            updateCSRFToken();


            $('#deletemodal').modal('toggle')

            // let selectedAction = $('input[name=radio_delete_act]:checked').val()
            let selectedAction = 'T'
            let autoId = $('#autoIdParty').val()
            let diary_no = $('#hdfno').val()

            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

            let dataObj = { selectedAction, id: autoId, diary_no }

            $.ajax({
                type: 'POST',
                url:"<?php echo base_url('Filing/Party/deleteAction'); ?>",
                data: { CSRF_TOKEN: CSRF_TOKEN_VALUE, data: dataObj }
            })
            .done(function(msg){
                console.log("msg:: ", msg)
                if(msg == '1' || msg == 1){
                    alert('Action updated successfully.')
                    location.reload();
                }else if(msg == '2' || msg == 2){
                    alert('Please add more parties before deleting this party.')
                }
                else{
                    alert('Error while updating action.')
                }
                updateCSRFToken();
            })
            .fail(function(){
                alert("ERROR, Please Contact Server Room");
                updateCSRFToken();
            });

        }

        function isFloat(n){
            return Number(n) === n && n % 1 !== 0;
        }


        $('#p_pin').blur(function(){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            var pincode = $("#p_pin").val();
            if(pincode){
                // var stateObj = JSON.parse(state_Arr);
                // var options = '';
                // options +='<option value="">Select State</option>';
                // stateObj.forEach((response)=> options +='<option value="'+response.id+'">'+response.state_name+'</option>');
                // $('#p_state').html(options).select2().trigger("change");
                $.ajax({
                    type: "GET",
                    data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, pincode : pincode},
                    url: "<?php echo base_url('Common/Ajaxcalls/getAddressByPincode'); ?>",
                    success: function (response){
                        var taluk_name;
                        if(response){
                            var resData = JSON.parse(response);
                            // console.log("resData:: ", resData)
                            if(resData){
                                taluk_name = resData[0]['taluk_name'].trim().toUpperCase();
                            }
                            if(taluk_name){
                                $("#p_city").val('');
                                $("#p_city").val(taluk_name);
                            }else{
                                $("#p_city").val('');
                            }
                        }
                        updateCSRFToken();
                    },
                    error: function () {
                        updateCSRFToken();
                    }
                });
            }
        });

        function editParty(dataset){
            // console.log("dataset: ", dataset)

            let diaryNo = dataset.diary_no
            let flag = dataset.pet_res
            let sr_no = dataset.sr_no_show
            let type = dataset.ind_dep
            type = type.replace(/^\s+|\s+$/g, '');
            let auto_generated_id = dataset.auto_generated_id

            updateCSRFToken();


            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

            let dataObj = { diaryNo, flag, sr_no,type, auto_generated_id }

            $.ajax({
                type: 'POST',
                url:"<?php echo base_url('Filing/Party/getUpdateData'); ?>",
                data: { CSRF_TOKEN: CSRF_TOKEN_VALUE, data: dataObj }
            })
                .done(function(msg){
                    // console.log("msg:: ", msg)

                    if(msg){
                        // window.scrollTo(0, 0);
                        $('html').animate({scrollTop:0}, 'slow');//IE, FF
                        $('body').animate({scrollTop:0}, 'slow');//chrome, don't know if Safari works

                        let resp_data = JSON.parse(msg)
                        console.log("resp_data: ", resp_data)                        
                        if(resp_data.length){

                            updateCSRFToken();

                            $("#remark_lrs").val(resp_data[0]['remark_lrs']);
                            $("#party_flag").val(flag);
                            $("#pno").val(sr_no);
                            if(isFloat(sr_no)){ ////LR
                                $("#for_selecting_lrs").css('display','inline');
                                $("#for_selecting_lrs").val("");
                                $("#party_flag").prop('disabled',true);
                            }else{  ////Party
                                $("#for_selecting_lrs").css('display','none');
                                $("#party_flag").removeProp('disabled');
                                $("#p_lowercase").removeProp('disabled');
                                $("#sel_lrstolrs").html("<option value=''>No Data For LRs to LRs</option>");
                            }

                          
                            if(type == 'I'){
                                $('#individ').show()
                                $('#stateCentral').hide()
                                $('#othrOrgan').hide()

                                $('#p_name').val(resp_data[0]['partyname'])
                                $('#p_rel').val(resp_data[0]['sonof'])
                                $('#select2-p_rel-container').text($("#p_rel option:selected").text())

                                $('#p_rel_name').val(resp_data[0]['prfhname'])
                                $('#p_sex').val(resp_data[0]['sex'])
                                $('#p_age').val(resp_data[0]['age'])
                                $('#p_caste').val(resp_data[0]['caste'])

                                $('#p_occ').val(resp_data[0]['occ_code'])
                                $('#select2-p_occ-container').text($("#p_occ option:selected").text())

                                $('#p_edu').val(resp_data[0]['edu_code'])
                                $('#select2-p_edu-container').text($("#p_edu option:selected").text())
                            }else if(type == 'D1' || type == 'D2'){
                                $('#stateCentral').show()
                                $('#individ').hide()
                                $('#othrOrgan').hide()

                                $("#p_statename").val(resp_data[0]['deptname']);
                                $("#p_statename_hd").val(resp_data[0]['state_in_name']);

                                $("#p_post").val(resp_data[0]['addr1']);
                                $("#post_code").val(resp_data[0]['authcode']);
                                
                                setTimeout(() => {
                                    updateCSRFToken();
                                    var CSRF_TOKEN = 'CSRF_TOKEN';
                                    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                                    $.ajax({
                                        type: "POST",
                                        data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, deptt: type},
                                        url: "<?php echo base_url('Filing/Party/getDepttList'); ?>",
                                        success: function (data) {
                                            data = JSON.parse(data)
                                            // console.log(data)
                                            if(data.length){
                                                let html = ''
                                                data.forEach(el => {
                                                    html += '<option value="'+el.value+'">'
                                                })
                                                $('#pDepttList').append(html)

                                                setTimeout(() => {
                                                    let partysuff = resp_data[0]['partysuff']  
                                                    let deptName = partysuff.replace(resp_data[0]['deptname'], "");
                                                    // console.log("deptName:", typeof  deptName)
                                                    deptName = deptName.replace(/^\s+/g, '')
                                                    $("#p_deptt").val(deptName);
                                                    $("#p_deptt_hd").val(resp_data[0]['deptcode']);
                                                }, 200);
                                            }else{
                                                $('#pDepttList').html('')
                                            }
                                            updateCSRFToken();                                        
                                        },
                                        error: function () {
                                            updateCSRFToken();
                                        }
                                    });    
                                }, 300);

                            }
                            else if(type == 'D3'){
                                $('#othrOrgan').show()
                                $('#individ').hide()
                                $('#stateCentral').hide()

                                $("#p_post").val(resp_data[0]['addr1']);
                                $("#post_code").val(resp_data[0]['authcode']);
                                
                                setTimeout(() => {
                                    updateCSRFToken();
                                    var CSRF_TOKEN = 'CSRF_TOKEN';
                                    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                                    $.ajax({
                                        type: "POST",
                                        data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, deptt: type},
                                        url: "<?php echo base_url('Filing/Party/getDepttList'); ?>",
                                        success: function (data) {
                                            data = JSON.parse(data)
                                            // console.log(data)
                                            if(data.length){
                                                let html = ''
                                                data.forEach(el => {
                                                    html += '<option value="'+el.value+'">'
                                                })
                                                $('#pDepttList').append(html)

                                                setTimeout(() => {
                                                    let partysuff = resp_data[0]['partysuff']  
                                                    let deptName = partysuff.replace(resp_data[0]['deptname'], "");
                                                    // console.log("deptName:", typeof  deptName)
                                                    deptName = deptName.replace(/^\s+/g, '')
                                                    $("#p_deptt").val(deptName);
                                                    $("#p_deptt_hd").val(resp_data[0]['deptcode']);
                                                }, 200);
                                            }else{
                                                $('#pDepttList').html('')
                                            }
                                            updateCSRFToken();                                        
                                        },
                                        error: function () {
                                            updateCSRFToken();
                                        }
                                    });    
                                }, 300);

                            }
                            


                            $('#p_add').val(resp_data[0]['addr2'])
                            $('#p_city').val(resp_data[0]['dstname'])

                            $('#p_cont').val(resp_data[0]['country'])

                            $('#p_st').val(resp_data[0]['state'])
                            $('#select2-p_st-container').text($("#p_st option:selected").text())


                            var CSRF_TOKEN = 'CSRF_TOKEN';
                            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                            $('#p_dis').val('');

                            var get_state_id = resp_data[0]['state'];
                            if (get_state_id !='') {
                                $.ajax({
                                    type: "GET",
                                    data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: get_state_id},
                                    url: "<?php echo base_url('Common/Ajaxcalls/get_districts'); ?>",
                                    success: function (data) {
                                        $('#p_dis').html(data);
                                        updateCSRFToken();
                                        setTimeout(() => {
                                            $('#p_dis').val(resp_data[0]['city'])
                                            $('#select2-p_dis-container').text($("#p_dis option:selected").text())
                                        }, 150);
                                    },
                                    error: function () {
                                        updateCSRFToken();
                                    }
                                });
                            }

                            if(resp_data[0]['add_add'] != '0'){
                                $('#sp_add_add').click()

                                setTimeout(() => {
                                    let additional_add = resp_data[0]['con_addition']
                                    additional_add = additional_add.replace(/[{}]/g, "");
                                    let add_arr = additional_add.split(',')
                                    let cntLength = add_arr.length 
                                    let cnt = 1;
                                    let ppAr = []
                                    add_arr.forEach(e=> {                                        
                                        
                                        e = e.replace(/[""]/g, "");
                                        let val = e.split('~')
                                        ppAr.push(val)
                                        // console.log("cnt: ",cnt, val)
                                        setTimeout(() => {
                                            if((cnt == cntLength) && (cntLength != 1)){
                                                $('#addRowOther').click()
                                            }
                                            // console.log( '#add_'+cnt )
                                            $('#add_'+cnt).val(val[3])  
                                            $('#cont_'+cnt).val(val[0])  
                                            $('#st_'+cnt).val(val[1]) 
                                            $('#st_'+cnt).trigger("change");
                                             
                                            cnt = cnt + 1;
                                            
                                        }, 200);                                        
                                    })

                                    setTimeout(() => {
                                        for (let i = 0; i < cntLength; i++) {
                                            let id = (i+1)
                                            // console.log('#dis_'+id, ppAr[i][2] )
                                            $('#dis_'+id).val(ppAr[i][2])
                                        }
                                    }, 400);

                                }, 500);

                            }


                            $('#p_pin').val(resp_data[0]['pin'])
                            $('#p_mob').val(resp_data[0]['contact'])
                            $('#p_email').val(resp_data[0]['email'])


                            let lowerCourtArr =  resp_data[0]['lowercase_id']
                            lowerCourtArr = lowerCourtArr.replace(/[{}]/g, "");
                            let newlwrCrt = lowerCourtArr.split(',')
                            // console.log("newlwrCrt: ", newlwrCrt)
                            if(newlwrCrt.length){
                                $("#p_lowercase").val( newlwrCrt );
                            }
                             
                            // $('#p_lowercase').val(resp_data[0][''])

                            $('#set_auto_generated_id').val(auto_generated_id)
                            

                            $('#controllerValue').val('U')
                            $('#get_case_details').text('Update')
                            $('#hd_party_flag').val(flag)
                            $('#pStatus').show()
                            $('#pStatusrem').show()

                        }
                    }else{
                        // alert('Error while updating action.')
                    }
                    updateCSRFToken();
                })
                .fail(function(){
                    alert("ERROR, Please Contact Server Room");
                    updateCSRFToken();
                });

        }



        ////// Copy Party Details ////////
        // function gct(){
        $('.frmCpy').on("focusout",function(){    
            dno=document.getElementById('dno').value;
            dyr=document.getElementById('dyr').value;

            if(dno != '' && dyr !=''){
                d1=dno+dyr;

                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

                let obj = {d_no: dno, d_yr: dyr };
                $.ajax({
                    url: "<?php echo base_url('Filing/Party/get_cause_title'); ?>",
                    cache: false,
                    async: true,
                    data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, data: obj},
                    type: 'POST',
                    success: function(data, status) {
                        $('#div_result').html(data);
                        updateCSRFToken();
                    },
                    error: function(xhr) {
                        alert("Error");
                        updateCSRFToken();
                    }
                });
            }

        })


        // function gct1(){
        $('.toCpy').on("focusout",function(){ 
            dno=document.getElementById('dno1').value;
            dyr=document.getElementById('dyr1').value;

            if(dno != '' && dyr !=''){
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                let obj = {d_no: dno, d_yr: dyr };

                $.ajax({
                    url: "<?php echo base_url('Filing/Party/get_cause_title'); ?>",
                    cache: false,
                    async: true,
                    data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, data: obj},
                    type: 'POST',
                    success: function(data, status) {
                        $('#div_result1').html(data);
                        updateCSRFToken();
                    },
                    error: function(xhr) {
                        alert("Error ");
                        updateCSRFToken();
                    }
                });
            }

        })


        function copy_details(){
            // alert("this is copy function");
            // return;

            var dno1=document.getElementById('dno').value;
            var dyr1=document.getElementById('dyr').value;
            var d1=dno1+dyr1;
            var dno2=document.getElementById('dno1').value;
            var dyr2=document.getElementById('dyr1').value;
            var d2=dno2+dyr2;
            //   alert(d1+''+d2);

            if((dno1 =='') || (dyr1=='')){
                alert("diary no/ diary year can't be blank");
                document.getElementById('dno').focus();
                return;
            }
            if((dno2 =='') || (dyr2=='')){
                alert("diary no/ diary year can't be blank");
                document.getElementById('dno1').focus();
                return;
            }

            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            let obj = {d1, d2 };

            $.ajax({
                url: "<?php echo base_url('Filing/Party/copy_party_details'); ?>",
                cache: false,
                async: true,
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, data: obj},
                type: 'POST',
                success: function(data, status) {
                    alert(data);
                    updateCSRFToken();
                    location.reload()
                },
                error: function(xhr) {
                    alert("Error ");
                    updateCSRFToken();
                }
            });

        }



    </script>


 <?=view('sci_main_footer');?>