<?= view('header') ?>
 
    <style>
        .custom-radio {
            float: left;
            display: inline-block;
            margin-left: 10px;
        }

        .custom_action_menu {
            float: left;
            display: inline-block;
            margin-left: 10px;
        }

        .basic_heading {
            text-align: center;
            color: #31B0D5
        }

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
        a {color:darkslategrey}      /* Unvisited link  */

        a:hover {color:black}    /* Mouse over link */
        a:active {color:#0000FF;}  /* Selected link   */

        .box.box-success {
            border-top-color: #00a65a;
        }
        .box {
            position: relative;
            border-radius: 3px;
            background: #ffffff;
            border-top: 3px solid #d2d6de;
            margin-bottom: 20px;
            width: 100%;
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        }

        .box-header {
            color: #444;
            display: block;
            padding: 10px;
            position: relative;
        }
        .box-header.with-border {
            border-bottom: 1px solid #f4f4f4;
        }
        .box.box-danger {
            border-top-color: #dd4b39;
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
                                    <h3 class="card-title">R & I >> E-copy </h3>
                                </div>
                            </div>
                            <br><br>

                            <?php if (session()->getFlashdata('infomsg')) { ?>
                                <div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong> <?= session()->getFlashdata('infomsg') ?></strong>
                                </div>

                            <?php } ?>
                            <?php if (session()->getFlashdata('success_msg')) : ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong> <?= session()->getFlashdata('success_msg') ?></strong>
                                </div>
                            <?php endif; ?>



                        </div>


                        <span class="alert alert-error" style="display: none;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <span class="form-response"> </span>
                                </span>

                        <?= view('RI/Ecopy/EcopyHeading'); ?>


                        <!--  <div class="container-fluid">
                              <h3 class="page-header" style="margin-left: 1%">Add/Update:</h3>
                              <br>-->


                        <?php
                        $attribute = array('class' => 'form-horizontal', 'name' => 'ecopy', 'id' => 'ecopy', 'autocomplete' => 'off', 'method' => 'POST');
                        echo form_open(base_url('#'), $attribute);
                        ?>

                        <p id="show_error"></p> <!-- This Segment Displays The Validation Rule -->

                            <div class="card-header bg-info text-white font-weight-bolder">Envelope Receive Module </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div>
                                                <br>
                                                <input id="btn_search" name="btn_search" type="button" class="btn btn-success" value="Envelopes to Receive">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br> <br>
                                <div class="col-md-12 " id="result"></div>
                            </div>







                        <?php form_close(); ?>


                        <br><br>
                        <br><br>



                        <!-- /.content -->
                        <!--</div>-->
                        <!-- /.container -->
                    </div>
                    <br>
                    <br>
                    <br>

                </div> <!-- card div -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.section -->
    <script>

        $("#btn_search").click(function(){
            // alert("fdf");
            // return false;
            $('#show_error').html("");
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.ajax({
                type: 'POST',
                url:'<?=base_url('/RI/EcopyController/get_envelope_movement');?>',
                cache: false,
                async: true,
                data: { CSRF_TOKEN: CSRF_TOKEN_VALUE},
                beforeSend:function(){
                    $('#result').html('<table widht="100%" align="center"><tr><td><img src="../images/load.gif"/></td></tr></table>');
                },
                success: function(data, status) {
                    $("#result").html(data);
                    updateCSRFToken();

                },
                error: function(xhr) {
                    alert("Error: " + xhr.status + " " + xhr.statusText);
                }
            });
        });

        $(document).on('click', '.btn_consume', function () {
            var barcode = $(this).data('barcode');
            $(".validation").remove(); // remove it
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

            $('#show_error').html("");
            $.ajax({
                url:'<?=base_url('/RI/EcopyController/envelope_movement_save');?>',
                cache: false,
                async: true,
                context: this,
                data:{
                    barcode:barcode,
                    CSRF_TOKEN: CSRF_TOKEN_VALUE
                },
                type: 'POST',

                success: function(data) {
                    updateCSRFToken();
                    // alert(data);
                    var response = JSON.parse(data);
                    console.log(response.status);
                    if(response.status == 'success'){
                        // alert("FFF");
                        // return false;
                        $(this).parents('.cell_tr').replaceWith('<td class="validation alert alert-success alert-dismissible p-1 m-1">'+response.status+'</td>');
                    }
                    else{
                        // alert("EEE");
                        // return false;
                        $(this).closest('tr').find(".btn_consume").after('<strong class="validation alert alert-danger alert-dismissible p-1 m-1">'+response .status+'</strong>');
                    }
                },
                error: function(xhr) {
                    alert("Error: " + xhr.status + " " + xhr.statusText);
                }
            });

        });
    </script>



 <?=view('sci_main_footer') ?>