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
                                            $attribute = array('class' => 'form-horizontal', 'name' => 'courtMaster', 'id' => 'courtMaster', 'autocomplete' => 'off');
                                            echo form_open('Court/CourtMasterController/generateRop', $attribute);

                                        ?>
                                        <div class="tab-content">

                                            <div class="active tab-pane">
                                                <h3 class="basic_heading"> Generate Proceedings </h3><br>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="hidden" name="usercode" id="usercode" value="<?= $usercode ?>">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Causelist Date</label>
                                                        <div class="col-sm-6">
                                                            <input type="date" name="causelistDate" id="causelistDate" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Presiding Judge</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" id="pJudge" name="pJudge">
                                                                <option value="">Select Presiding Judge</option>
                                                                <?php 
                                                                    foreach($judge as $key => $j1):
                                                                        if($j1['jtype'] == 'J'){
                                                                            echo '<option value="' . $j1['jcode'] . '" >' . $j1['jcode'] . ' - ' . $j1['jname'] . '</option>';
                                                                        }
                                                                        else{
                                                                            echo '<option value="' . $j1['jcode'] . '" >' . $j1['jcode'] . ' - ' . $j1['first_name'].' '.$j1['sur_name'].' '.$j1['jname'] . '</option>';
                                                                        }
                                                                    endforeach;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Causelist Type</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="causelistType" tabindex="1" id="causelistType" onchange="getBenches()">
                                                                <option value="">Select Causelist</option>
                                                                <option value="1">Regular List</option>
                                                                <option value="3">Misc. List</option>
                                                                <option value="5">Chamber List</option>
                                                                <option value="7">Registrar List</option>
                                                                <option value="9">Review/Curative List</option>
                                                                <option value="11">Single Judge List</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Bench</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control"  name="bench" tabindex="1" id="bench">
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <input type="button" id="btnGetCases" class="btn btn-primary" onclick="getCasesForGeneration()" value="Get Cases">
                                                </div>
                                            </div>
                                            </div>

                                            <hr><br>
                                            <div id="divCasesForGeneration">
                                                
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
    function getBenches() {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var csrf = $("input[name='CSRF_TOKEN']").val();

        var causelistDate = $('#causelistDate').val();
        var pJudge = $('#pJudge').val();
        var causelistType = $('#causelistType').val();
        if(causelistDate == ""){
            alert("Please fill Causelist Date..");
            return false;
        }
        if(pJudge == ""){
            alert("Please Select Presiding Judge..");
            return false;
        }
        if(causelistType == ""){
            alert("Please Select Type of Causelist..");
            return false;
        }
        if (causelistDate != "" && pJudge != "" && causelistType!=""){

            $.ajax({
                url:"<?php echo base_url('Court/CourtMasterController/getBench');?>",
                type: "get",
                data: {CSRF_TOKEN:csrf,causelistDate: causelistDate, pJudge:pJudge, causelistType:causelistType},
                success:function(result){
                    $("#bench").html(result);
                    updateCSRFToken();
                    //window.location.href='';
                },
                error: function () {
                    alert('Error');
                    updateCSRFToken();
                }
            });

        }
    }


    function getCasesForGeneration() {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var csrf = $("input[name='CSRF_TOKEN']").val();

        var causelistDate = $('#causelistDate').val();
        var pJudge = $('#pJudge').val();
        var causelistType = $('#causelistType').val();
        var bench = $('#bench').val();
        var usercode=$('#usercode').val();
        if(causelistDate == ""){
            alert("Please Select Causelist Date..");
            $('#causelistDate').focus();
            return false;
        }
        if(pJudge == ""){
            alert("Please Select Presiding Judge..");
            $('#pJudge').focus();
            return false;
        }
        if(causelistType == ""){
            alert("Please Select Type of Causelist..");
            $('#causelistType').focus();
            return false;
        }
        if(bench == ""){
            alert("Please Select Bench..");
            return false;
        }

        if (causelistDate != "" && pJudge != "" && causelistType!="" & bench!=""){

            $.ajax({
                url:"<?php echo base_url('Court/CourtMasterController/getCasesForGeneration');?>",
                type: "get",
                data: {CSRF_TOKEN:csrf,causelistDate: causelistDate, pJudge:pJudge, causelistType:causelistType,bench:bench,usercode:usercode},
                success:function(result){
                    $('#divCasesForGeneration').html(result);
                    updateCSRFToken();
                    //window.location.href='';
                },
                error: function () {
                    alert('Error');
                    updateCSRFToken();
                }
            });
        }
    }

</script>

 <?=view('sci_main_footer') ?>