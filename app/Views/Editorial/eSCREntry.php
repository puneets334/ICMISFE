<?= view('header') ?>

    <style xmlns="http://www.w3.org/1999/html">

    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header heading">

                            <div class="row">
                                <div class="col-sm-10">
                                    <h3 class="card-title">Editorial >> Update Gist</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="card-body">
                                    <span class="alert-danger"><?= \Config\Services::validation()->listErrors() ?></span>

                                    <?php if (session()->getFlashdata('message_error')) { ?>
                                        <div class="alert alert-danger">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong> <?= session()->getFlashdata('message_error') ?></strong>
                                        </div>

                                    <?php } ?>
                                    <?php if (session()->getFlashdata('success_msg')) : ?>
                                        <div class="alert alert-success alert-dismissible">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong> <?= session()->getFlashdata('success_msg') ?></strong>
                                        </div>
                                    <?php endif; ?>

                                </div>
                                <?php
                                $attribute = array('class' => 'form-horizontal', 'name' => 'editorial', 'id' => 'escr_page', 'autocomplete' => 'off', 'method' => 'POST');
                                echo form_open(base_url('Editorial/ESCR'), $attribute);
                                ?>

                                <div class="row">
                                    <div class="col-sm-8">
                                           <span style="float: left;">
                                            <h5 class="box-title">Search Option : </h5>
                                        </span>&nbsp;&nbsp;&nbsp;
                                        <label class="radio-inline"><input type="radio" name="optradio" value="1" checked>Case Type</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label class="radio-inline"><input type="radio" name="optradio" value="2">Diary Number</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </div>
                                </div><br>


                                <div class="rowww">
                                    <!--start 2 section-->
                                    <div id="caseTypeWise" >
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group row " >
                                                    <label for="from" class="col-sm-4 col-form-label">Case Type: </label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control" name="caseType" id="caseType">
                                                            <option value="0">Select</option>
                                                            <?php
                                                            if(!empty($caseTypes)) {
                                                                foreach ($caseTypes as $caseType) {
                                                                    echo '<option value="' . $caseType['casecode'] . '">' . $caseType['short_description'] . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label for="caseNo" class="col-sm-4 col-form-label">Case Number:</label>
                                                    <div class="col-sm-7">
                                                        <input type="number" id="caseNo" name="caseNo" class="form-control" placeholder="Case Number" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label for="caseYear" class="col-sm-4 col-form-label">Case Year:</label>
                                                    <div class="col-sm-7">
                                                        <select id="caseYear" name="caseYear" class="form-control">
                                                            <?php
                                                            for($i=date("Y");$i>1949;$i--){
                                                                echo "<option value=".$i.">$i</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!--end 2 section-->

                                    <!--start 3 section-->
                                    <div id="diaryNoWise" >
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group row " >
                                                    <label for="diaryNumber" class="col-sm-4 col-form-label">Diary Number: </label>
                                                    <div class="col-sm-7">
                                                        <input type="number" id="diaryNumber" name="diaryNumber" class="form-control" placeholder="Diary Number" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label for="diaryYear" class="col-sm-4 col-form-label">Diary Year:</label>
                                                    <div class="col-sm-7">
                                                        <select id="diaryYear" name="diaryYear" class="form-control">
                                                            <?php
                                                            for($i=date("Y");$i>1949;$i--){
                                                                echo "<option value=".$i.">$i</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!--end 3 section-->

                                    <div id="judgement_dt" >
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label for="to_date" class="col-sm-4 col-form-label">Judgement Date:</label>
                                                    <div class="col-sm-7">
                                                        <input type="date" id="judgmentDate"  name="judgmentDate" class="form-control"  placeholder="Judgment Date" required="required">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <br>

                                    <div style="display:flex;justify-content:center" >
                                        <button type="submit" style="width:10%; text-align:center" id="view" name="view" class="btn btn-block btn-primary">View</button>

                                    </div>
                                    <br>
                                    <br>

                                </div>


                                <?php form_close(); ?>

                            </div>
                        </div>


                        <!-------------Result Section ------------>
                        <?php
                        if (!empty($caseInfo))
                        {
                        //                 echo "<pre>";print_r($caseInfo);
                        //                 die;

                        ?>
                        <div class="col-12">
                            <h4 class="box-title"><center>Case Details</center></h4>
                            </br>

                            <div >
                                <div class="row ">

                                    <div class="col-sm-3">
                                        <label><strong>Case No.</strong></label>&nbsp;
                                        <dd class="my_B"> <?= $caseInfo['reg_no_display'] ?>&nbsp;(D No.<?= $caseInfo['diary_no'] ?>-<?= $caseInfo['diary_year'] ?>)</dd>
                                    </div>
                                    <div class="col-sm-3">
                                        <label><strong>Cause Title</strong></label>&nbsp;
                                        <dd class="my_B"><?php echo $caseInfo['pet_name'];?><b> VS </b><?php echo $caseInfo['res_name']; ?></dd>
                                    </div>
                                    <div class="col-sm-1">
                                        <label><strong> Status</strong></label>
                                        <dd class="my_B">
                                            <?php if ($caseInfo['mainhead'] == 'M')
                                                echo "Misc";
                                            elseif ($caseInfo['mainhead'] == 'F')
                                                echo "Regular";
                                            if ($caseInfo['c_status'] == 'P')
                                                echo '(Pending)';
                                            elseif ($caseInfo['c_status'] == 'D')
                                                echo '(Disposed)';
                                            ?>
                                        </dd>
                                    </div>
                                    <div class="col-sm-3">
                                        <label><strong>Advocates </strong></label>

                                        <dd class="my_B"><?= $caseInfo['pet_adv_name'] ?>-<?= $caseInfo['pet_aor_code'] ?><b> VS </b><?= $caseInfo['res_adv_name'] ?>-<?= $caseInfo['res_aor_code'] ?></dd>
                                    </div>
                                    <div class="col-sm-2">
                                        <label><strong> Dealing Assistant</strong></label>
                                        <dd><span class="my_G" style="color:#008000"><?= $caseInfo['alloted_to_da'] ?>[</span><SPAN class="my_Bl" style="color:#0000ff"><?= $caseInfo['user_section'] ?>]</SPAN></dd>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!---------------- Next Section ---------------->

                        <div class="row">
                            <div class="col-sm-12">

                                <?php
                                $attribute = array('class' => 'form-horizontal', 'name' => 'gist', 'id' => 'save', 'autocomplete' => 'off', 'method' => 'POST');
                                echo form_open(base_url('#'), $attribute);
                                ?>


                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="remark" class="col-sm-3 control-label"><strong>Gist of the case</strong></label>
                                            <div class="col-sm-6">
                                                        <textarea class="form-control" name="remarks" id="remarks" rows="5" maxlength="1000" onkeypress="return alpha(event)" placeholder="Remarks.......">
                                                        <?php
                                                        if(!empty($remarksInfo))
                                                        {
                                                            echo trim($remarksInfo['summary']);
                                                        }
                                                        ?>
                                                        </textarea>
                                                <font color="red">[max 1000 characters allowed including space and dot only]</font>
                                                <span style="float:right;"><a onclick="clearGist();">Clear Gist</a></span><br />
                                                <span><span id="chars">
                                                                        <?php
                                                                        $remarksLength=0;
                                                                        if(!empty($remarksInfo))
                                                                        {
                                                                            $remarksLength = strlen($remarksInfo['summary']);
                                                                            echo 1000-$remarksLength;
                                                                        }
                                                                        else
                                                                        {
                                                                            echo 1000-$remarksLength;
                                                                        }
                                                                        ?></span> characters remaining</span>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <?php
                                if(!empty($userrole))
                                {
                                    if ($userrole == 2) {
                                        ?>
                                        <div class="col-sm-7">
                                            <center><button type="button" id="verifyButton" onclick="funcSaveVerify()" value="Verify" style="width:15%;float:right" class="btn btn-block btn-primary">Verify</button></center>
                                        </div><br><br>
                                        <?php
                                    }
                                    if ($userrole == 1) {
                                        ?>

                                        <div class="col-sm-7">
                                            <center><button type="button" id="saveButton" onclick="funcSaveVerify()" value="Save" style="width:15%;float:right" class="btn btn-block btn-primary">Save</button></center>
                                        </div><br><br>
                                    <?php }
                                }?>
                                <!-- </form> -->

                                <?php form_close(); ?>
                            </div><br>
                        </div><br>
                        <!-- DIV FOR GIST FORM CLOSE HERE -->
                    </div>

                    <?php
                    } else {
                    }
                    ?>
                </div>
            </div><br><br>
        </div>
        </div>




        </div>
    </section>
    <script src="<?php echo base_url('plugins/jquery-validation/jquery.validate.js'); ?>"></script>
    <script src="<?php echo base_url('plugins/jquery-validation/additional-methods.js'); ?>"></script>
    <script>

        function updateCSRFToken() {
            $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
            });
        }
        function funcSaveVerify()
        {

            // alert("SFDF");return false;
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

            var remarks = document.getElementById('remarks').value;
            // alert(remarks);
            $.ajax({
                type:"POST",
                data: {
                    CSRF_TOKEN: CSRF_TOKEN_VALUE,
                    'remark':remarks,

                },
                url: "<?php echo base_url('Editorial/ESCR/saveSummary'); ?>",
                success: function(data) {
                    updateCSRFToken();
                    // console.log(data);return false;
                    // alert(data);
                    if(data == 'Cases is not available for verification !!!' || data == 'Data is saved successfully !!!')
                    {
                        document.getElementById("saveButton").disabled = true;
                        document.getElementById("verifyButton").disabled = true;
                    }else{
                      $('.container-fluid').html(data);

                    }
                },
                error: function(data) {
                    alert(data);
                    updateCSRFToken();
                }
            });
        }

    </script>
    <script>
        function alpha(e) {
            var k;
            document.all ? k = e.keyCode : k = e.which;
            return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 44 || k == 45 || k == 59 || k == 47 || k == 40 || k == 41 || k == 39 || k == 34 || k == 8 || k == 32 || k == 46 || (k >= 48 && k <= 57));
        }

        var maxLength = 1000;
        $('textarea').keyup(function() {
            var length = $(this).val().length;
            var length = maxLength - length;
            $('#chars').text(length);
        });


        $(".alert").delay(6000).slideUp(200, function() {
            $(this).alert('close');
        });

        function clearGist() {
            $('#remarks').val('');
        }
        $(document).ready(function() {
            $('#diaryNumber').prop("disabled", 'disabled');
            $('#diaryYear').prop("disabled", 'disabled');
            $('#diaryNoWise').hide();


            $("input[name$='optradio']").click(function() {
                var searchValue = $(this).val();
                if (searchValue == 1) {
                    $('#caseType').removeAttr('disabled');
                    $('#caseNo').removeAttr('disabled');
                    $('#caseYear').removeAttr('disabled');

                    $('#diaryNumber').prop("disabled", 'disabled');
                    $('#diaryYear').prop("disabled", 'disabled');

                    $('#diaryNoWise').hide();
                    $('#caseTypeWise').show();
                } else {
                    $('#caseType').prop("disabled", 'disabled');
                    $('#caseNo').prop("disabled", 'disabled');
                    $('#caseYear').prop("disabled", 'disabled');

                    $('#caseTypeWise').hide();

                    $('#diaryNumber').removeAttr('disabled');
                    $('#diaryYear').removeAttr('disabled');

                    $('#diaryNoWise').show();
                }

            });

            var userrole = '<?php print_r($userrole); ?>';
            if (userrole == 1)
                $('#verifyButton').hide();
            else if (userrole == 2)
                $('#saveButton').hide();
            // document.getElementById('saveButton').hidden = true;
        });
    </script>

<?=view('sci_main_footer') ?>