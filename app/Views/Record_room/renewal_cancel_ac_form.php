<?= view('header') ?>
 
<link rel="stylesheet" type="text/css" href="<?= base_url('/css/aor.css') ?>">
<script>
    $(function() {
        $("#crd1").datepicker({
            dateFormat: "dd-mm-yy"
        }).val();
    });

    $(document).ready(function() {

        $('#mdd').hide();
        $('#data').hide();
        $('#sbtn1').hide();
        $('#register').hide();
        $('#cein').focus();
        $("#crd1").change(function() {
            $('#register').show();
        });
        $("#md").click(function() {
            $('#mdd').toggle();
        });

        $("#search").click(function() {
            var cein = $("#cein").val();
            var tvap = '';;
            tvap = cein;
            if (!cein) {
                alert("Please Enter Mandatory Values");
                return false;
            }

            var dataString = 'tvap=' + tvap;
            var res;
            var sres;
            $('#rslt').html("<img src='img/loading.gif' width='50px' hight='50px' />");
            $.ajax({
                type: "get",
                url: "http://10.40.186.139:92/Record_room/Record/getAorOptions",
                data: dataString,
                cache: false,
                success: function(result) {
                    res = result;
                    if (res) {
                        rres = res.split("#");
                        $('#sbtn').hide();
                        $('#sbtn1').show();
                        $('#data').hide();
                        $('#afc').html(rres[0]);
                        $('#vadvc').focus();
                        vac = $('#vadvc').val();
                        $('#rslt').html("<h4> </h4>");

                    } else
                        $('#rslt').html("<h4>Record Not found</h4>");
                }
            });
            return false;
        });

        $("#search1").click(function() {
            var tvap = $("#cein").val();
            var vadvc = $("#vadvc").val();
            if (!tvap) {
                alert("Please Enter Mandatory Values");
                return false;
            }

            var dataString = 'tvap=' + tvap + '&vadvc=' + vadvc;
            var res;
            var sres;
            $('#rslt').html("<img src='img/loading.gif' width='50px' hight='50px' />");
            $.ajax({
                type: "get",
                url: "http://10.40.186.139:92/Record_room/Record/getAorOptions1",
                data: dataString,
                cache: false,
                success: function(result) {
                    res = result;
                    if (res) {
                        rres = res.split("#");
                        $('#acn').val(rres[2]);
                        $('#cfn').val(rres[3]);
                        $('#cmobile').val(rres[15]);
                        $('#cpal1').val(rres[4]);
                        $('#cpal2').val(rres[5]);
                        $('#cpad').val(rres[6]);
                        $('#cpapin').val(rres[7]);
                        $('#cppal1').val(rres[8]);
                        $('#cppal2').val(rres[9]);
                        $('#cppad').val(rres[10]);
                        $('#cppapin').val(rres[11]);
                        $('#cdob').val(rres[12]);
                        $('#cpob').val(rres[13]);
                        $('#cn').val(rres[14]);
                        $('#cx').val(rres[16]);
                        $('#cxii').val(rres[17]);
                        $('#cug').val(rres[18]);
                        $('#cpg').val(rres[19]);
                        $('#crno').val(rres[21]);
                        $('#rslt').html("<h4> </h4>");
                        $('#data').show();
                        fetchtds();
                    } else
                        $('#rslt').html("<h4>Record Not found</h4>");
                }
            });
            return false;
        });



        function fetchtds() {
            var tdid;
            tid = $('#crno').val();
            var dataString = 'tid=' + tid;
            $.ajax({
                type: "get",
                url: "fetch_tran_dat.php",
                data: dataString,
                cache: false,
                success: function(result) {
                    res = result;
                    if (res) {
                        $('#history').html("<span style='color:#E74C3C;'>" + result + "</span>");
                    } else
                        $('#history').html("<h4>Record Not found</h4>");
                }
            });
        }

        $("#register").click(function() {
            var action = $("#action").val();
            var crd1 = $("#crd1").val();
            var accr = $("#accr").val();
            var crno = $("#crno").val();
            var tvap;
            tvap = action + ";" + crd1 + ";" + accr + ";" + crno;
            // alert(tvap);
            var dataString = 'tvap=' + tvap;
            if (action > 0) {
                $.ajax({
                    type: "get",
                    url: "tran_register.php",
                    data: dataString,
                    cache: false,
                    success: function(result) {
                        $('#rslt1').html("<img src='img/loading.gif' width='50px' hight='50px'/>");
                        $('#rslt1').html(result);
                        fetchtds();
                        $('#cein').val("");
                        $('#cein').focus();
                        $('#register').hide();
                        $('#sbtn').show();
                    }
                });
            } else {
                alert("Please Select Action");
                return false;
            }
            return false;
        });

    });

    $(document).ready(function() {
        $("#vadvc").change(function() {
            alert("Ok");
            vadvc = $('#vadvc').val();
            alert(vadvc);
        });
    });
</script>
</head>

<body>
    <?php {

    ?><section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header heading">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h3 class="card-title">RENEW / CANCEL >>&nbsp; Advocate Clerk Registration</h3>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="custom_action_menu">
                                            <button class="btn btn-success btn-sm" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                            <button class="btn btn-primary btn-sm" type="button"><i class="fas fa-pen   " aria-hidden="true"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="container">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">

                                                <h4><strong><span class="fas fa-search "></span>&nbsp; RENEW / CANCEL >>&nbsp; Advocate Clerk Registration</strong></h4>

                                            </div>
                                            <div class="panel-body" id="frm">
                                                <form class="form-horizontal" role="form" name="form1" autocomplete="off">

                                                    <div class="form-group ">
                                                        <label class="control-label col-sm-2" for="anumber">Existing Icard No. *</label>
                                                        <div class="col-sm-2">
                                                            <input class="form-control " name="cein" type="text" id="cein" placeholder="ICard Number">
                                                        </div>
                                                        <div class="col-sm-2" id="sbtn">
                                                            <button type="submit" class="btn btn-warning" name="submit" id="search" onclick="">
                                                                <span class="glyphicon glyphicon-plus"></span> Search
                                                            </button>
                                                        </div>

                                                    </div>


                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="atitle">AOR/Firm Code *</label>
                                                        <div class="col-sm-4" id="afc">
                                                            <select class="form-control" name="aorn" id="aorn">
                                                                <option value="0">-select-</option>
                                                                <?php if (!empty($options) && is_array($options)) : ?>
                                                                    <?php foreach ($options as $option) : ?>
                                                                        <option value="<?= $option['aor_code'] ?>"><?= $option['aor_code'] . ' ' . $option['name'] ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2" id="sbtn1">
                                                            <button type="submit" class="btn btn-warning" name="submit" id="search1">
                                                                <span class="glyphicon glyphicon-plus"></span> Search
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div id="data">
                                                        <div class="form-group ">
                                                            <label class="control-label col-sm-2" for="anumber">Name *</label>
                                                            <div class="col-sm-10"><input class="form-control " name="acn" type="text" id="acn" placeholder="Name" disabled> </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label class="control-label col-sm-2" for="anumber">Father Name *</label>
                                                            <div class="col-sm-6"> <input class="form-control " name="cfn" type="text" id="cfn" placeholder="Father Name" disabled> </div>
                                                        </div>


                                                        <div class="form-group ">
                                                            <label class="control-label col-sm-2" for="anumber">Mobile Number</label>
                                                            <div class="col-sm-2">
                                                                <input class="form-control " name="cmobile" type="text" id="cmobile" placeholder="Mobile Number" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <label class="control-label col-sm-2" for="anumber">Record Number</label>
                                                            <div class="col-sm-2">
                                                                <input class="form-control " name="crno" type="text" id="crno" placeholder="Record Number" disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12" id='md' style="text-align:right;color:blue;font:strong 10px Gothic;">view more details</div>
                                                        <div id='mdd'>
                                                            <div class="form-group ">
                                                                <label class="control-label col-sm-2" for="anumber">Present Address</label>
                                                                <div class="col-sm-3"><input class="form-control " name="cpal1" type="text" id="cpal1" placeholder="Address Line1" disabled></div>
                                                                <div class="col-sm-3"><input class="form-control " name="cpal2" type="text" id="cpal2" placeholder="Address Line2" disabled></div>
                                                                <div class="col-sm-2"><input class="form-control " name="cpad" type="text" id="cpad" placeholder="District" disabled></div>
                                                                <div class="col-sm-2"><input class="form-control " name="cpapin" type="text" id="cpapin" placeholder="Pincode" disabled></div>
                                                            </div>

                                                            <div class="form-group ">
                                                                <label class="control-label col-sm-2" for="anumber">Permanent Address</label>
                                                                <div class="col-sm-3"><input class="form-control " name="cppal1" type="text" id="cppal1" placeholder="Address Line1" disabled></div>
                                                                <div class="col-sm-3"><input class="form-control " name="cppal2" type="text" id="cppal2" placeholder="Address Line2" disabled></div>
                                                                <div class="col-sm-2"><input class="form-control " name="cppad" type="text" id="cppad" placeholder="District" disabled></div>

                                                                <div class="col-sm-2"><input class="form-control " name="cppapin" type="text" id="cppapin" placeholder="Pincode" disabled></div>
                                                            </div>

                                                            <div class="form-group ">
                                                                <label class="control-label col-sm-2" for="anumber">Date of Birth</label>
                                                                <div class="col-sm-2"><input class="form-control " name="cdob" type="text" id="cdob" placeholder="DOB" disabled></div>
                                                            </div>

                                                            <div class="form-group ">
                                                                <label class="control-label col-sm-2" for="anumber">Place of Birth</label>
                                                                <div class="col-sm-3"> <input class="form-control " name="cpob" type="text" id="cpob" placeholder="Birth Place" disabled> </div>
                                                            </div>

                                                            <div class="form-group ">
                                                                <label class="control-label col-sm-2" for="anumber">Nationality</label>
                                                                <div class="col-sm-2">
                                                                    <input class="form-control " name="cn" type="text" id="cn" placeholder="Nationality" disabled>
                                                                </div>
                                                            </div>


                                                            <div class="form-group ">
                                                                <label class="control-label col-sm-2" for="anumber">Educational Qualifications</label>
                                                                <div class="col-sm-2"><input class="form-control " name="cx" type="text" id="cx" placeholder="X" disabled></div>
                                                                <div class="col-sm-2"><input class="form-control " name="cxii" type="text" id="cxii" placeholder="XII" disabled></div>
                                                                <div class="col-sm-2"><input class="form-control " name="cug" type="text" id="cug" placeholder="UG" disabled></div>
                                                                <div class="col-sm-2"><input class="form-control " name="cpg" type="text" id="cpg" placeholder="PG" disabled></div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-2" for="anumber">History</label>
                                                            <div class="col-sm-10" id="history"> </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label class="control-label col-sm-2" for="anumber">Action</label>
                                                            <div class="col-sm-2">
                                                                <select class="form-control" id="action">
                                                                    <option value=0>Action</option>
                                                                    <option value=1>Register</option>
                                                                    <option value=2>Renew</option>
                                                                    <option value=3>Cancel</option>
                                                                    <option value=4>Deletion</option>
                                                                </select>
                                                            </div>
                                                            <label class="control-label col-sm-2" for="anumber">Dated: </label>
                                                            <div class="col-sm-2"><input class="form-control " name="crd1" type="text" id="crd1" placeholder="Dated"> </div>
                                                            <label class="control-label col-sm-1" for="atitle">Remarks</label>
                                                            <div class="col-sm-3 "><input class="form-control" name="accr" type="text" id="accr" placeholder="Remarks"></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-offset-2 col-sm-10">
                                                                <button type="submit" class="btn btn-info" name="submit" id="register" onclick="">
                                                                    <span class="glyphicon glyphicon-plus"></span> Submit
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (isset($success_message)) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= $success_message ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php

    }
    ?>
     <?=view('sci_main_footer') ?>