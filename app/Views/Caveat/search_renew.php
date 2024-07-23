<?= view('header') ?>
 
<style>
 
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <?=view('Caveat/caveat_breadcrumb');?>
                    <div class="card-header heading">
                        <div class="row">
                            <div class="col-sm-10"> <h3 class="card-title">Caveat >> Search</h3></div>
                            <div class="col-sm-2">
                                <a href="<?=base_url('Caveat/Generation');?>"><button class="btn btn-success btn-sm" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button></a>
                                <a href="<?=base_url('Caveat/Search');?>"><button class="btn btn-primary btn-sm" type="button"><i class="fas fa-pen	" aria-hidden="true"></i></button></a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <span class="alert alert-error" style="display: none;">
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

                                    <?php  //echo $_SESSION["captcha"];
                                    $attribute = array('class' => 'form-horizontal caveat_search','name' => 'caveat_search', 'id' => 'caveat_search', 'autocomplete' => 'off');
                                    echo form_open(base_url('Caveat/Search/'), $attribute);
                                    ?>
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                      <div class="col-md-3">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-5 col-form-label">Caveat No</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="caveat_number" name="caveat_number" placeholder="Enter Caveat No" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-5 col-form-label">Caveat Year</label>
                                                <div class="col-sm-7">
                                                   <!-- <input type="text" class="form-control" id="caveat_year" name="caveat_year" placeholder="Enter Caveat Year" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">-->
                                                    <select name="caveat_year" id="caveat_year" class="custom-select">
                                                        <?php $year = 1950; $current_year = date('Y');
                                                        for ($x = $current_year; $x >= $year; $x--) { ?>
                                                            <option><?php echo $x; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                         </div>

                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary" id="submit">Search</button>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <?php form_close();?>

                                    <center><div id ='div_result'> </div></center>
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
        $('#caveat_search').on('submit', function () {
            var caveat_number = $("#caveat_number").val();
            //var caveat_year = $("#caveat_year").val();
            var caveat_year = $('#caveat_year').find(":selected").val();

                    if (caveat_number.length == 0) {
                        alert("Please enter caveat number");
                        $("#caveat_number").focus();
                        validationError = false;
                        return false;
                    }else if (caveat_year.length == 0) {
                        alert("Please select caveat year");
                        $("#caveat_year").focus();
                        validationError = false;
                        return false;
                    }

            if ($('#caveat_search').valid()) {
                var validateFlag = true;
                var form_data = $(this).serialize();
                if(validateFlag){
                    var CSRF_TOKEN = 'CSRF_TOKEN';
                    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                    $('.alert-error').hide();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('Caveat/Renew/get_caveat_info'); ?>",
                        data: form_data,
                        beforeSend: function () {
                            $('.dak_submit').val('Please wait...');
                            $('.dak_submit').prop('disabled', true);
                        },
                        success: function (data) {
                            updateCSRFToken();
                            var resArr = data.split('@@@');
                            if (resArr[0] == 1) {
                                $('.alert-error').hide();
                                $(".form-response").html("");
                                $('#div_result').html(resArr[1]);
                            } else if (resArr[0] == 3) {
                                $('#div_result').html('');
                                $('.alert-error').show();
                                $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "</p>");
                            }
                        },
                        error: function () {
                            updateCSRFToken();
                        }
                    });
                    return false;
                }
            } else {
                return false;
            }
        });
        function copy_details()
        { //alert('test ');
            var caveat_number = $("#caveat_number").val();
            //var caveat_year = $("#caveat_year").val();
            var caveat_year = $('#caveat_year').find(":selected").val();

            if (caveat_number.length == 0) {
                alert("Please enter caveat number");
                $("#caveat_number").focus();
                validationError = false;
                return false;
            }else if (caveat_year.length == 0) {
                alert("Please select caveat year");
                $("#caveat_year").focus();
                validationError = false;
                return false;
            }
            var result = confirm("Are you sure to renew caveat?");
            if(result){
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                //var form_data = $(this).serialize();
                $('.alert-error').hide();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('Caveat/Renew/copy_caveat'); ?>",
                    //data: form_data,
                    data: {CSRF_TOKEN:CSRF_TOKEN_VALUE,caveat_number: caveat_number, caveat_year: caveat_year},
                    beforeSend: function () {
                        $('.dak_submit').val('Please wait...');
                        $('.dak_submit').prop('disabled', true);
                    },
                    success: function (data) {
                        updateCSRFToken();
                        var resArr = data.split('@@@');
                        if (resArr[0] == 1) {
                            $('.alert-error').hide();
                            $(".form-response").html("");
                            $('#div_result').html(resArr[1]);
                        } else if (resArr[0] == 3) {
                            $('#div_result').html('');
                            $('.alert-error').show();
                            $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "</p>");
                        }
                    },
                    error: function () {
                        updateCSRFToken();
                    }
                });
                return false;
            }

        }

    </script>
 <?=view('sci_main_footer') ?>