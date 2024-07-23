<?=view('header'); ?>
 
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
                                        <a href="<?=base_url('Filing/Diary');?>"><button class="btn btn-success btn-sm" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button></a>
                                        <a href="<?=base_url('Filing/Diary/search');?>"><button class="btn btn-primary btn-sm" type="button"><i class="fas fa-pen	" aria-hidden="true"></i></button></a>
                                        <a href="<?=base_url('Filing/Diary/deletion');?>"><button class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button></a>

                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">

                                    <?php if (session()->getFlashdata('error')) { ?>
                                        <div class="alert alert-danger">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong> <?= session()->getFlashdata('error') ?></strong>
                                        </div>

                                    <?php } ?>
                                    <?php if (session()->getFlashdata('success_msg')) : ?>
                                        <div class="alert alert-success alert-dismissible">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong> <?= session()->getFlashdata('success_msg') ?></strong>
                                        </div>
                                    <?php endif; ?>

                                    <div class="card-header p-2" style="background-color: #fff;"><br>
                                        <h4 class="basic_heading"> Diary Deletion </h4>
                                    </div>
                                    <?php
                                    $attribute = array('class' => 'form-horizontal diary_generation_form', 'name' => 'frm', 'id' => 'frm', 'autocomplete' => 'off');
                                    echo form_open('#', $attribute);

                                    ?>
                                    <?php echo component_html('D') ?>
                                        <div id="dv_content1"   >
                                            <div id="main" >
                                                <table align ="center" >

                                                    <!--<tr>
                                                        <td align="center" valign="center"><br> <b>Diary no. </b> </td>
                                                        <td align="center"> <input type="text" id="cavno" name=cavno" placeholder="Enter Diary No" onkeypress="return onlynumbers(event)" />
                                                            <input type="text" id="cavyr" name="cavyr"  id="1" onblur="check(1)"  placeholder="Enter Diary Year" onkeypress="return onlynumbers(event)" /> </td>
                                                    </tr>-->
                                                    <tr> <td align="center" colspan=3><div id = 'div_result'> </div></td> </tr>


                                                    <tr><td><b>Enter Remarks for deletion :</b></td> <td><input type ="text" size ="50" id="remarks"</td></tr>

                                                    <tr>
                                                        <td align="center" colspan=3> <input type="button" id="button" value="Delete Diary Number" onClick="insert_advocate()" name="btn" style="display: none;"> </td>
                                                    </tr>

                                                </table>

                                                <br>

                                            </div>	<!--END div main-->

                                            <b><div id="txtHint" align="center" color="blue" style="font-size:180%;color:green;"><b></b></div>

                                                <?=form_close(); ?>


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
    <style>
        input[type=text], select {
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[id=button] {
            background-color: #017ebc;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        }


        div {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }
        .cl_add
        {
            color: blue;
        }
        .cl_add:hover
        {
            cursor: pointer;
        }
        .cl_sp_del
        {
            color: blue;
        }
        .cl_sp_del:hover
        {
            cursor: pointer;
        }
    </style>
    <script type="text/javascript">

        function insert_advocate()
        {
            //alert("Are you sure to delete this diary number?");
            var cavno=document.getElementById('diary_number').value;
            var cavyr=document.getElementById('diary_year').value;
            //var advocate_id=document.getElementById('aorcode').value;
            var remarks=document.getElementById('remarks').value;
            if(remarks=='' || (remarks.length < 25))
            {
                alert("Remarks cannot be empty or cannot be less than 25 characters");
                return;
            }
            // alert(advocate_id);
            var caveatno=cavno+cavyr;
            if(cavno =='')
            {
                alert("Enter Diary  no.");
                document.getElementById('diary_number').focus();
                return;
            }
            if(cavyr=='')
            {
                alert("Enter Diary year");
                document.getElementById('diary_year').focus();
                return;
            }
            var result = confirm("Are you sure to delete this diary number?");
            if (result) {
                $('#button').attr('disabled',true);
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        //   alert(this.responseText);
                        document.getElementById('txtHint').innerHTML = this.responseText;
                        document.getElementById('diary_number').value='';
                        document.getElementById('diary_year').value='';
                        document.getElementById('remarks').value='';
                        $('#div_result').html('');
                        $('#button').attr('disabled',false);

                    }
                };
                var url = "<?=base_url('Filing/Diary/get_diary_delete')?>?d1=" + caveatno +'&remarks='+remarks;
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
            }
        }

        /*function check(id) {

        }*/

        function onlynumbers(evt)
        {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            //alert(charCode);
            if ((charCode >= 48 && charCode <= 57) || charCode == 9 || charCode == 8 || charCode == 37 || charCode == 39 ) {
                return true;
            }
            return false;
        }
    </script>
    <script>
        $(document).ready(function () {
        $('#diary_year').change(function () {

            $('#diary_number').val();
            $('#txtHint').html('');
            $('#div_result').html('');
            $('#button').attr('disabled',false);
                var cav_no =$('#diary_number').val();
                var cav_yr =$('#diary_year').val();
                if(cav_no =='')
                {
                    alert("Enter Diary no.");
                    document.getElementById('diary_number').focus();
                    return;
                }
                if(cav_yr=='')
                {
                    alert("Enter Diary year");
                    document.getElementById('diary_year').focus();
                    return;
                }
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

                $.ajax({
                    url: '<?=base_url('Filing/Diary/get_diary_info')?>',

                    data: {CSRF_TOKEN: CSRF_TOKEN_VALUE,cav_no: cav_no, cav_yr: cav_yr},

                    type: 'GET',
                    success: function (data, status) {
                        if(data=='Case not found!!'){
                            $('#button').attr('disabled',true);
                        }
                        else {
                            $('#div_result').html(data);
                            var c_status= $('#c_status').val();
                            if (c_status=='D'){
                                $('#button').hide();
                            }else if (c_status=='P') {
                                $('#button').show();
                            }
                            if(document.getElementById('hd_renew').value>0){
                                $('#button').attr('disabled',true);
                            }
                        }
                        updateCSRFToken();
                    }

                });

        });
        });
    </script>
 <?=view('sci_main_footer');?>