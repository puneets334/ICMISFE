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
        .row {
             margin-right: 15px;
             margin-left: 15px;
         }
        .nav-breadcrumb li a {
            background-image: none;
            background-repeat: no-repeat;
            background-position: 100% 3px;
            position: relative;
        }
        .nav-breadcrumb li a, .nav-breadcrumb li a:link, .nav-breadcrumb li a:visited {
            margin-left: -70px;
        }
    </style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header heading">

                        <div class="row">
                            <div class="col-sm-10">
                                <h3 class="card-title">Filing >> Efiling >> Admin</h3>
                            </div>
                            <div class="col-sm-2">
                              
                            </div>
                        </div>
                    </div>

                    <?=view('Filing/Efiling/Efiling_breadcrumb');?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                     <span class="alert alert-error" style="display: none; color: red;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <span class="form-response"> </span>
                                    </span>
                                    <span class="alert-danger"><?=\Config\Services::validation()->listErrors()?></span>

                                    <?php if(session()->getFlashdata('error')){ ?>
                                        <div class="alert alert-danger text-white ">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <?= session()->getFlashdata('error')?>
                                        </div>
                                    <?php } else if(session("message_error")){ ?>
                                        <div class="alert alert-danger">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <?=session()->getFlashdata("message_error")?>
                                        </div>
                                    <?php }else{?>
                                        <br/>
                                    <?php }?>
                                   <h5 class="box-title">FILING/REFILING/ADDITIONAL DOCUMENT REPORT RELATED TO IN - PERSONS MATTERS </h5>
                                    <br/>
                                    <?php
                                    $attribute = array('class' => 'form-horizontal','name' => 'report', 'id' => 'report', 'autocomplete' => 'off');
                                    echo form_open(base_url('#'), $attribute);
                                    ?>

                                    <div class="row">
                                        <div class="form-group col-sm-2">
                                            <label for="causelistDate">From Date:</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control pickDate" id="from_date" name="from_date" placeholder="dd-mm-yyyy" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <label for="causelistDate">To Date:</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control pickDate" id="to_date" name="to_date"  placeholder="dd-mm-yyyy" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <label for="causelistDate">Transaction Status:</label>
                                            <div class="input-group">
                                                <select class="form-control" id="status" name="status"  required>
                                                    <option value="">Select</option>
                                                    <option value="1">Complete</option>
                                                    <option value="2">Failed Transactions</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <label for="causelistDate">Document Type:</label>
                                            <div class="input-group">
                                                <select class="form-control" id="app_type" name="app_type" required>
                                                    <option value="">Select</option>
                                                    <option value="1">All(except additional documents)</option>
                                                    <option value="2">Filing</option>
                                                    <option value="3">Additional Documents</option>
                                                    <option value="4">Deficit</option>
                                                    <option value="5">Deficit_DN</option>
                                                    <option value="6">Add Doc Sp</option>
                                                    <option value="7">Refiling</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <label>&nbsp;</label>
                                            <button type="submit" id="btn-shift-assign" class="btn btn-block  btn-flat pull-right btn btn-primary"><i class="fa fa-save"></i> Search </button>
                                            </button>
                                        </div>

                                    </div>




                                    <?php form_close();?>
                                      <br/>
                                    <div id="result_data"></div>

                                    <center><span id="loader"></span> </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <script src="<?php echo base_url('plugins/jquery-validation/jquery.validate.js'); ?>"></script>
    <script src="<?php echo base_url('plugins/jquery-validation/additional-methods.min.js'); ?>"></script>
    <script>
        $('#report').on('submit', function () {
            var from_date = $("#from_date").val();
            var to_date = $("#to_date").val();
            var date1 = new Date(from_date.split('-')[0], from_date.split('-')[1] - 1, from_date.split('-')[2]);
            var date2 = new Date(to_date.split('-')[0], to_date.split('-')[1] - 1, to_date.split('-')[2]);
            if (date1 > date2) {
                alert("To Date must be greater than From date");
                $("#to_date").focus();
                validationError = false;
                return false;
            } else {
                if (from_date.length == 0) {
                    alert("Please select from date.");
                    $("#from_date").focus();
                    validationError = false;
                    return false;
                }
                else if (to_date.length == 0) {
                    alert("Please select to date.");
                    $("#to_date").focus();
                    validationError = false;
                    return false;
                }
            }


            if ($('#report').valid()) {
                var validateFlag = true;
                var form_data = $(this).serialize();
                if(validateFlag){
                    $('.alert-error').hide();
                    $("#loader").html('');
                    $('#result_data').html('');
                    $('#reqResult').append('')
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('Filing/Efiling/pipreport'); ?>",
                        data: form_data,
                        beforeSend: function () {
                            $("#loader").html("<div style='margin:0 auto;margin-top:20px;width:15%'><img src='<?php echo base_url('images/load.gif'); ?>'></div>");
                        },
                        success: function (response) {
                            $("#loader").html('');
                            updateCSRFToken();
                            var resArr = response.split('@@@');
                            if (resArr[0] == 1) {
                                $('.alert-error').hide();
                                $(".form-response").html("");
                                $('#result_data').html(resArr[1]);
                            }else if (resArr[0] == 3) {
                                $('#result_data').html('');
                                $('.alert-error').show();
                                $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "</p>");
                            }
                        },
                        error: function() {
                            updateCSRFToken();
                            $('#result_data').html('');
                            alert('Something went wrong! please contact computer cell');
                        }
                    });
                    return false;

                }
            } else {
                return false;
            }
        });

    </script>
 <?=view('sci_main_footer');?>