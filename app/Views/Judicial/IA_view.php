<?= view('header') ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header heading">

                            <div class="row">
                                <div class="col-sm-10">
                                    <h3 class="card-title">Judicial >> IA >> Update</h3>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
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

                                        <?php
                                        $attribute = array('class' => 'form-horizontal','name' => 'component_search', 'id' => 'component_search', 'autocomplete' => 'off');
                                        echo form_open(base_url('#'), $attribute);
                                        ?>
                                        <?php echo component_html();?>

                                        <center> <button type="submit" class="btn btn-primary" id="submit">Submit</button></center>
                                        <?php form_close();?>
                                        <br/><br/>
                                        <center><span id="loader"></span> </center>
                                        <span class="alert alert-error" style="display: none; color: red;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <span class="form-response"> </span>
                                    </span>
                                        <div id="record" class="record"></div>

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
    <script src="<?php echo base_url('plugins/jquery-validation/additional-methods.js'); ?>"></script>
    <script>
        $(document).ready(function() {
            $('#component_search').on('submit', function () {
                var search_type = $("input[name='search_type']:checked").val();
                if (search_type.length == 0) {
                    alert("Please select case type");
                    validationError = false;
                    return false;
                }
                var diary_number = $("#diary_number").val();
                var diary_year =$('#diary_year :selected').val();

                var case_type =$('#case_type :selected').val();
                var case_number = $("#case_number").val();
                var case_year =$('#case_year :selected').val();

                if (search_type=='D') {
                    if (diary_number.length == 0) {
                        alert("Please enter diary number");
                        validationError = false;
                        return false;
                    }else if (diary_year.length == 0) {
                        alert("Please select diary year");
                        validationError = false;
                        return false;
                    }
                }else if (search_type=='C') {

                    if (case_type.length == 0) {
                        alert("Please select case type");
                        validationError = false;
                        return false;
                    }else if (case_number.length == 0) {
                        alert("Please enter case number");
                        validationError = false;
                        return false;
                    }else if (case_year.length == 0) {
                        alert("Please select case year");
                        validationError = false;
                        return false;
                    }

                }

                if ($('#component_search').valid()) {
                    var validateFlag = true;
                    var form_data = $(this).serialize();
                    if(validateFlag){
                        var CSRF_TOKEN = 'CSRF_TOKEN';
                        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                        $('.alert-error').hide(); $(".form-response").html("");
                        $("#loader").html('');
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('Filing/Diary/search'); ?>",
                            data: form_data,
                            beforeSend: function () {
                                $("#loader").html("<div style='margin:0 auto;margin-top:20px;width:15%'><img src='<?php echo base_url('images/load.gif'); ?>'></div>");
                            },
                            success: function (data) {
                                $("#loader").html('');
                                updateCSRFToken();
                                var resArr = data.split('@@@');
                                if (resArr[0] == 1) {
                                    //window.location.reload();
                                    // window.location.href =resArr[1];
                                    search_ia(resArr[1]);
                                } else if (resArr[0] == 3) {
                                    $('.alert-error').show();
                                    $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "</p>");
                                }
                            },
                            error: function() {
                                updateCSRFToken();
                                alert('Something went wrong! please contact computer cell');
                            }
                        });
                        return false;
                    }
                } else {
                    return false;
                }
            });
        });

        function search_ia(url) {

            $('#record').html('');

            var radio = $("input[type='radio'][name='search_type']:checked").val();

            var ia_search = "<?=base_url('Judicial/IA/get_content_list')?>";
            //alert('url'+url+'radio='+radio+'ia_search='+ia_search);
            $('#record').html('');
            $.ajax({
                type: "GET",
                url: ia_search,
                data:{radio: radio,option: 1},
                beforeSend: function () {
                    $("#loader").html("<div style='margin:0 auto;margin-top:20px;width:15%'><img src='<?php echo base_url('images/load.gif'); ?>'></div>");
                },
                success: function (data) {
                    updateCSRFToken();
                    $("#loader").html('');
                    $("#record").html(data);
                },

                error: function () {
                    updateCSRFToken();
                    alert('Something went wrong! please contact computer cell');
                }
            });

        }

    </script>
<?=view('sci_main_footer') ?>