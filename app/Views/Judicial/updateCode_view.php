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
                                    <h3 class="card-title">Judicial > Update DA Code</h3>
                                </div>
                                <div class="col-sm-2">
                                    <div class="custom_action_menu">                                        
                                        <a href="<?= base_url() ?>/Judicial/UpdateDACode"><button class="btn btn-primary btn-sm" type="button"><i class="fas fa-pen	" aria-hidden="true"></i></button></a>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?// view('Filing/filing_breadcrumb'); ?>
                        <!-- /.card-header -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header p-2" style="background-color: #fff;">
                                        
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">

                                            <div class="active tab-pane" id="">

                                                <div class="mt-2" >
                                                    
                                                <?php if(!empty($casedesc)){
                                                    
                                                    $filing_details= session()->get('filing_details');
                                                    if (!empty($filing_details)){?>
                                                        <div class="row text-center">
                                                            <label class="col-sm-12 col-form-label ml-4">
                                                                <b>Diary Number :</b> <?=substr($filing_details['diary_no'], 0, -4).'/'.substr($filing_details['diary_no'],-4);?> &nbsp;&nbsp;&nbsp;
                                                                <?php if (!empty($filing_details['reg_no_display'])){?><b>Case Number :</b> <?=$filing_details['reg_no_display'];?> <?php } ?> &nbsp;&nbsp;&nbsp;
                                                                <b>Case Title :</b> <?=$filing_details['pet_name'].'  <b>Vs</b>  '.$filing_details['res_name'];?> &nbsp;&nbsp;&nbsp;
                                                                <b>Filing Date : </b><?=(!empty($filing_details['diary_no_rec_date'])) ? date('d-m-Y',strtotime($filing_details['diary_no_rec_date'])): NULL ?> &nbsp;&nbsp;&nbsp;
                                                                <?php if ($filing_details['c_status'] =='P'){ echo '<span class="text-blue">Pending</span>';}else{echo '<span class="text-red">Disposed</span>';} ?>
                                                            </label>
                                                        </div>
                                                    <?php } ?>
                                                    
                                                    <div class="text-center">
                                                        <strong>Current DA:</strong>&nbsp; <?= $casedesc['name'].' [Empid- '.$casedesc['empid'].'] [Section- '.$casedesc['section_name'].']' ?>
                                                        
                                                        
                                                        <?php  //echo $_SESSION["captcha"];
                                                        $attribute = array('class' => 'form-horizontal','name' => 'updateDaCode', 'id' => 'updateDaCode', 'autocomplete' => 'off');
                                                        echo form_open(base_url('Judicial/UpdateDACode/set_dacode'), $attribute);
                                                        ?>

                                                            <div class="mt-4">
                                                                New DA: <input type="text" id="newdacode" name="newdacode" placeholder="TYPE NAME OR EMPID"  />
                                                                <input type="hidden" id="newdacode_hd">
                                                                <input type="hidden" value="<?= $dno ?>" id="hdfno">
                                                                <span onclick="save_code()" style="width: 10%;display: block;margin: 0 auto;margin-top: 1rem;" id="savebtn_Da" class="btn btn-primary ">Update </span>
                                                            </div>

                                                        <?php form_close();?>
                                                    </div>                                                   

                                                <?php }else{ ?>
                                                    <p style="text-align: center;color: red;font-size: 20px;">Case Not Found<p>
                                                <?php } ?>
                                                   
                                                </div>
                                                <!-- /.row -->

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

    <link href="<?php echo base_url('autocomplete/autocomplete.css');?>" rel="stylesheet">
    <script src="<?php echo base_url('autocomplete/autocomplete-ui.min.js'); ?>"></script>
    <script src="<?php echo base_url('filing/diary_add_filing.js'); ?>"></script>
<script>
   
   function updateCSRFToken() {
        $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
        });
    }

    $(document).on("focus","#newdacode",function(){
        $("#newdacode").autocomplete({
            source: "../../Common/Ajaxcalls/get_da_name",
            width: 450,
            matchContains: true,	
            minChars: 1,
            selectFirst: false,
            select: function (event, ui){
                // Set autocomplete element to display the label
                this.value = ui.item.label;
                // Store value in hidden field
                $('#newdacode_hd').val(ui.item.value);
                // Prevent default behaviour
                return false;
            },
            focus: function( event, ui){
                $("#newdacode").val(ui.item.label);
                return false;  
            }
        });    
    });


    function save_code(){
        var dacode = $("#newdacode_hd").val();
        // alert(dacode);
        if(dacode==''){
            alert('Please select DA code to update');
            $("#newdacode").focus;
            return false;
        }

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

        $.ajax({
            type: 'POST',
            data: { CSRF_TOKEN: CSRF_TOKEN_VALUE, dacode, dno:$("#hdfno").val() },
            url:"<?php echo base_url('Judicial/UpdateDACode/set_dacode'); ?>",
            success: function (data) {
                // console.log("data:: ", data)
                // return
                if(data == '1'){
                    // data = JSON.parse(data);
                    alert('DACODE CHANGE SUCCESSFULLY')
                    location.reload();
                }else{
                    alert("Error while saving data.")    
                }
                updateCSRFToken();
            },
            error: function () {
                alert("Error while saving data.")
                updateCSRFToken();
            }
        })
       
    } 

</script>


 <?=view('sci_main_footer') ?>