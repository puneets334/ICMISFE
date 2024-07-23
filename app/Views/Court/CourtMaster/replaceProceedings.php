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
                                    <h3 class="card-title">Court Master</h3>
                                </div>
                                <div class="col-sm-2">
                                    <div class="custom_action_menu">
                                        <button class="btn btn-success btn-sm" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                        <button class="btn btn-primary btn-sm" type="button"><i class="fas fa-pen	" aria-hidden="true"></i></button>
                                        <button class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?=view('Court/CourtMaster/courtMaster_breadcrumb'); ?>
                        <!-- /.card-header -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header p-2" style="background-color: #fff;">                                         
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <?php
                                            $attribute = array('class' => 'form-horizontal', 'name' => 'courtMaster', 'id' => 'courtMaster', 'autocomplete' => 'off', 'enctype'=> 'multipart/form-data');
                                            echo form_open('Court/CourtMasterController/replaceROP', $attribute);

                                        ?>
                                        <div class="tab-content">

                                            <div class="active tab-pane">
                                                <h3 class="basic_heading"> Upload One By One </h3><br>
                                            <?php if(!empty($caseDetails)){ ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="hidden" name="usercode" id="usercode" value="<?=$usercode?>">
                                                    <div class="form-group row">
                                                        <label class="col-sm-12 col-form-label" style="font-weight:bold;"><span class="text-primary">Case No : </span> <?=$caseDetails[0]['reg_no_display']?>&nbsp;(D No.<?=$caseDetails[0]['diary_no']?>)</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-12 col-form-label" style="font-weight:bold;"><span class="text-primary">Causetitle : </span> <?=$caseDetails[0]['pet_name']?> Vs. <?=$caseDetails[0]['res_name']?></label>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label" style="font-weight:bold;"><span class="text-primary">Order Date : </span></label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" id="listingDates" name="listingDates" placeholder="listingDates" onchange="getListedDetails(this);">
                                                                <option value="0">Select Listing Date</option>
                                                                    <?php
                                                                        foreach ($caseDetails as $detail):

                                                                            $courtNo="0";
                                                                            if($detail['courtno']==21){
                                                                                $courtNo="R1";
                                                                            }
                                                                            elseif ($detail['courtno']==22){
                                                                                $courtNo="R2";
                                                                            }
                                                                            else if($detail['courtno'] == 31){
                                                                                $courtNo="VC- 1";
                                                                            }                                   
                                                                            else if($detail['courtno'] == 32){
                                                                                $courtNo="VC- 2";                            
                                                                            }
                                                                            else if($detail['courtno'] == 33){
                                                                                $courtNo="VC- 3";                            
                                                                            }
                                                                            else if($detail['courtno'] == 34){
                                                                                    $courtNo="VC 4";
                                                                            }
                                                                            else if($detail['courtno'] == 35){
                                                                                    $courtNo="VC- 5";
                                                                            }
                                                                            else{
                                                                                $courtNo=$detail['courtno'];
                                                                            }
                                                                            $value=$detail['diary_no'].'#'.$detail['next_dt'].'#'.$detail['roster_id'].'#'.$detail['courtno'].'#'.$detail['item_number'];
                                                                            $text=date('d-m-Y', strtotime($detail['next_dt']))." in Court ".$courtNo.' as Item Number '.$detail['item_number'];
                                                                            echo '<option value="'.$value.'" >' .$text. '</option>';

                                                                        endforeach;
                                                                    ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }else{ echo '<center><b>No record found!!</b></center>'; } ?>
                                            </div>

                                            <hr><br>
                                            <div id="showData">
                                                
                                            </div>

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

<script type="text/javascript">
    
    function getListedDetails(id) {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var csrf = $("input[name='CSRF_TOKEN']").val();
        var usercode=$('#usercode').val();

        if(id.value!=0){

            $.post("<?=base_url('Court/CourtMasterController/getListedDetails')?>", {CSRF_TOKEN:csrf,id: id.value,usercode: usercode},function(result){
                $("#showData").html(result);
                updateCSRFToken();
            });
            updateCSRFToken();
        }
    }

    function validateData() {
        if($('#fileROPList').val()==""){
            alert("Please select pdf file to upload!!");
            return false;
        }
    }

</script>

 <?=view('sci_main_footer') ?>