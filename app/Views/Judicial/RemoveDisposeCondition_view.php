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
                                <h3 class="card-title">Judicial > Remove Conditional Dispose</h3>
                            </div>                            
                        </div>
                    </div>
                    <? //view('Filing/filing_breadcrumb'); ?>
                    <!-- /.card-header -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="tab-content">

                                        <?php
                                            $attribute = array('class' => 'form-horizontal','name' => 'removedispose', 'id' => 'removedispose', 'autocomplete' => 'off');
                                            echo form_open(base_url(''), $attribute);
                                        ?>
                                            <div class="active tab-pane" id="">
                                                <div class="well">

                                                    <div class="row">
                                                        <label class="col-sm-6"><font style="font-weight: bold;font-size: 20px;">Case to be Remove from Disposal Condition</font></label>
                                                        <input type="hidden" name="usercode" id="usercode" value="<?= $user_idd ?>"/>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-1">
                                                            <input type="radio" name="rdbt_select_list" id="radiocase_list" value="1" onchange="checkData(this.value);" checked>&nbsp; <b>Case Detail</b>
                                                        </div>

                                                        <div class="col-sm-2">
                                                            <div class="input-group input-group-sm">
                                                                <select  class="form-control" id="case_type_list" name="case_type_list" onchange="get_detail()">
                                                                    <?php
                                                                    echo '<option value="">Select Case Type</option>';
                                                                    foreach($case_types as $case_type)
                                                                        echo '<option value="'.$case_type['casecode'].'">'.$case_type['casename'].'</option>';
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-2">
                                                            <div class="input-group input-group-sm">
                                                                <input  type="text" class="form-control" id="case_number_list" name="case_number_list" placeholder="Case number" onchange="get_detail()">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-2">
                                                            <div class="input-group input-group-sm">
                                                                <select  class="form-control" id="case_year_list" name="case_year_list" onchange="get_detail()">
                                                                    <?php
                                                                    echo '<option value="">Select </option>';
                                                                    for($year=date('Y'); $year>=1950; $year--)
                                                                        echo '<option value="'.$year.'">'.$year.'</option>';
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-1">
                                                            <input type="radio" name="rdbt_select_list" id="radiodiary_list" value="2" onchange="checkData(this.value);">&nbsp;&nbsp;<b>Diary Detail</b>
                                                        </div>

                                                        <div class="col-sm-2">
                                                            <div class="input-group input-group-sm">
                                                                <input type="text"  class="form-control" id="diary_number_list" name="diary_number_list"  placeholder="Enter Diary number" onchange="get_detail()">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-2">
                                                            <select  class="form-control" id="diary_year_list" name="diary_year_list" onchange="get_detail()">
                                                                <?php
                                                                echo '<option value="">Select </option>';
                                                                for($year=date('Y'); $year>=1950; $year--)
                                                                    echo '<option value="'.$year.'">'.$year.'</option>';
                                                                ?>
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <br/>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-addon">Cause Title</span>&nbsp;&nbsp;
                                                                <label class="form-control" id="case_title_list" name="case_title_list"></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-addon">No. of Connected Matters</span>&nbsp;&nbsp;
                                                                <label class="form-control" id="conn_list" name="conn_list"></label>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" class="form-control" id="case_diary_list" name="case_diary_list">
                                                    </div>

                                                    <br/>

                                                    <div class="row">
                                                        <input type="hidden" class="form-control" id="case_diary_disp" name="case_diary_disp">
                                                    </div>

                                                    <br/>

                                                    <div class="row">
                                                        <div class="col-xs-offset-1 col-xs-6 col-xs-offset-3">
                                                            <button type="button" id="btn-update" class="btn bg-olive btn-flat pull-right" onclick="getAllNotices();"><i class="fa fa-save"></i> Submit </button>
                                                        </div>
                                                    </div>

                                                </div> 


                                                <div id="display" class="box box-danger">
                                                    <table width="100%" id="reportTable1" class="table table-striped table-hover">
                                                        <thead>
                                                            <h3 style="text-align: center;"> Conditional Dispose Cases</h3>
                                                            <tr>
                                                                <th>S No.</th>
                                                                <th>Restricted Case</th>
                                                                <th>After Disposal of Case</th>
                                                                <th>Court Type</th>
                                                                <th><i class="glyphicon glyphicon-tags"></i></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="alert alert-info alert-dismissable fade in mt-4" id="info-alert">
                                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                                    <strong>Info! </strong>
                                                    No Record Found.
                                                </div>

                                            </div>   
                                    
                                            <!-- Modal -->

                                        <?php form_close();?>
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
    </div>
</section>
    <!-- /.content -->

<script>
      
    function updateCSRFToken() {
        $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
        });
    }

    $(document).ready(function(){
        $('#diary_number_list').prop('disabled', true);
        $('#diary_year_list').prop('disabled', true);
        $("#display").hide();
        $('#info-alert').hide();
    })
    
    function checkData($option){
        if($option==1)
        {
            $('#diary_year_list').prop('disabled',true);
            $('#diary_number_list').prop('disabled',true);
            $('#case_number_list').prop('disabled',false);
            $('#case_type_list').prop('disabled',false);
            $('#case_year_list').prop('disabled',false);
        }
      else  if($option==2){
            $('#diary_year_list').prop('disabled',false);
            $('#diary_number_list').prop('disabled',false);
            $('#case_number_list').prop('disabled',true);
            $('#case_type_list').prop('disabled',true);
            $('#case_year_list').prop('disabled',true);
        }

    }
       
    function get_detail() {
        //    alert("inside");
        //debugger;
        updateCSRFToken();
        var option_list=$('input:radio[name=rdbt_select_list]:checked').val();
        var caseNumber_list=$('#case_number_list').val();
        var caseType_list=$('#case_type_list').val();
        var case_year_list=$('#case_year_list').val();
        var diaryNo_list=$('#diary_number_list').val();
        var diary_year_list=$('#diary_year_list').val();

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

        if(option_list==1 && !isEmpty(caseNumber_list) && !isEmpty(caseType_list) && !isEmpty(case_year_list)){
            $.post("<?=base_url('Judicial/RemoveDisposeCondition/get_details');?>", {CSRF_TOKEN: CSRF_TOKEN_VALUE, case_number_list:caseNumber_list, case_type_list:caseType_list, case_year_list:case_year_list}, function (result) {
                var obj =$.parseJSON(result);
                var case_status=obj.case_detail[0]['c_status'];
                if(obj.case_detail==false)
                {
                    alert("The searched case is not found!");
                }else{
                    if(case_status=='P') {
                        $('#case_diary_list').val(obj.case_detail[0]['case_diary']);
                        $('#case_title_list').text(obj.case_detail[0]['case_title']);
                        $('#conn_list').text(obj.conn_details[0]['conn']);
                    }else if(case_status=='D'){
                        if(!alert("The searched case is disposed!")){ 
                            //$('#btn-update').prop('disabled',true);
                            // location.reload();
                            $('#case_type_list').val('');
                            $('#case_number_list').val('');
                            $('#case_year_list').val('');
                            $('#case_diary_list').val('');
                            $('#case_title_list').text('');
                            $('#conn_list').text('');
                        }
                    }
                }
                updateCSRFToken();
            });
        }
        else if(option_list==2 && !isEmpty(diaryNo_list)&& !isEmpty(diary_year_list)){
           
            $.post("<?=base_url('Judicial/RemoveDisposeCondition/get_details');?>", { CSRF_TOKEN: CSRF_TOKEN_VALUE, diary_number_list:diaryNo_list, diary_year_list:diary_year_list}, function (result) {
                    var obj =$.parseJSON(result);
                    var case_status=obj.case_detail[0]['c_status'];
                    if(obj.case_detail==false){
                        alert("The searched case is not found!");
                    }else{
                        if(case_status=='P') {
                            $('#case_diary_list').val(obj.case_detail[0]['case_diary']);
                            $('#case_title_list').text(obj.case_detail[0]['case_title']);
                            $('#conn_list').text(obj.conn_details[0]['conn']);
                        }
                        else if(case_status=='D'){  
                            if(!alert("The searched case is disposed!")){
                                $('#diary_number_list').val('');
                                $('#diary_year_list').val('');
                                $('#case_diary_list').val('');
                                $('#case_title_list').text('');
                                $('#conn_list').text('');
                            }
                        }
                    }
                    updateCSRFToken();
                });
        }
    }

    function getAllNotices(){
       // debugger;
       updateCSRFToken();
        var list_diary=$('#case_diary_list').val();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

        setTimeout(() => {
            $.ajax({
                url: '<?=base_url('Judicial/RemoveDisposeCondition/get_Restrict_Cases_History');?>',
                type: "POST",
                data: { CSRF_TOKEN: CSRF_TOKEN_VALUE, list_diary:list_diary},
                cache:  false,
                dataType: 'json',
                success: function(data){
                    // console.log("data: ", data)
                    if(data != false){
                        if(data.length > 0){
                            $("#display").show();
                            $('#reportTable1 tbody').empty();
                            sno = 1;
                            $.each(data, function (index) {
                                //alert (data[index].court_type);
                                if(data[index].court_type!='S' && data[index].court_type!=null)
                                    $('#reportTable1 tbody').append("<tr><td>" + sno + "</td><td>" + data[index].mcaseno + "</td><td>" + data[index].lc_casetype + " No. " + data[index].lc_caseno + "/" + data[index].lc_caseyear + "</td><td>Lower Court</td><td><a id='del_button'  onclick='delete_case();'  <i class='fa fa-trash'></i></a></td></tr>");
                                else
                                    $('#reportTable1 tbody').append("<tr><td>" + sno + "</td><td>" + data[index].mcaseno + "</td><td>" + data[index].sc_caseno + "</td><td>Supreme Court</td><td><a id='del_button' onclick='delete_case();'><i class='fa fa-trash'></i></a></td></tr>");
                                sno++;
                            });

                            $('#reportTable1').DataTable({
                                "bSort": true,
                                dom: 'Bfrtip',
                                "scrollX": true,
                                iDisplayLength: 8,
                                buttons: [
                                    {
                                        extend: 'print',
                                        orientation: 'landscape',
                                        pageSize: 'A4'
                                    }
                                ]
                            });

                            updateCSRFToken();

                        }else{
                            $("#display").hide();
                            $("#info-alert").show();
                            $("#info-alert").fadeTo(2000, 500).slideUp(500, function(){
                                $("#info-alert").slideUp(500);
                            });
                            updateCSRFToken();
                        }
                    }else{
                        $("#display").hide();
                        $("#info-alert").show();
                        $("#info-alert").fadeTo(2000, 500).slideUp(500, function(){
                            $("#info-alert").slideUp(500);
                        });
                        updateCSRFToken();
                    }

                },
                error: function() {
                    alert("error");
                }
                //error: function(ts) { alert(ts.responseText) }
            });    
        }, 500);
        
    }      


    function delete_case(){
        //debugger;
        updateCSRFToken();
        $("#display").show();
        var list_diary = $('#case_diary_list').val();
        var usercode=$('#usercode').val();
        if(confirm('Do you want to Remove this case?')) {

            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();


            $.ajax({
                url: '<?=base_url('Judicial/RemoveDisposeCondition/delete_Restricted_Case');?>',
                data: { CSRF_TOKEN:CSRF_TOKEN_VALUE ,list_diary: list_diary, usercode:usercode},
              // dataType: 'json',
                type: "POST",
                success: function (data) {
                    console.log("data: ", data)
                    if(data != '' ) {
                        data = JSON.parse(data)
                        //alert(data);
                        if(data.Remove_Case == 'Deleted') {
                            alert("Case Removed Successfully.");
                            location.reload();
                        }else{
                            alert("Unable to process.  Please contact Computer Cell.")
                        }

                    }
                },
                error: function () {
                    console.log('error');
                }
            });
        }

    }

    
    
    function isEmpty(obj) {
        if (obj == null) return true;
        if (obj.length > 0)    return false;
        if (obj.length === 0)  return true;
        if (typeof obj !== "object") return true;

        // Otherwise, does it have any properties of its own?
        // Note that this doesn't handle
        // toString and valueOf enumeration bugs in IE < 9
        for (var key in obj) {
            if (hasOwnProperty.call(obj, key)) return false;
        }

        return true;
    }

</script>


 <?=view('sci_main_footer') ?>