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
                                    <h3 class="card-title">R & I >> Receipt </h3>
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

                        <?= view('RI/RIReceiptHeading'); ?>

                        <div class="container-fluid">
                            <h3 class="page-header" style="margin-left: 1%">Add/Update:</h3>
                            <br>

                            <?php
                            $attribute = array('class' => 'form-horizontal', 'name' => 'frmGetRIDetail', 'id' => 'frmGetRIDetail', 'autocomplete' => 'off', 'method' => 'POST');
                            echo form_open(base_url('RI/ReceiptController/getRIDetailByDiaryNumber'), $attribute);
                            ?>

                            <br>
                            <div class="row col-md-12 ">

                                <div class="col-md-3">
                                    <button type="button" class="btn btn-success" onclick="addEditReceiptDetail(0, '<?=base_url()?>');"><i class="fa fa-plus"></i> Receive Postal</button>
                                </div>
                                <div class="col-md-3" id="divDiaryNo">
                                    <label style="display: flex;margin-left: -13%;"><h5>Search by R&I Diary Number</h5></label>
                                    <input type="text" class="form-control" placeholder="Diary No"  id="diaryNo" name="diaryNo" style="margin-left: 54%;margin-top: -11%;">

                                </div>

                                <div class="col-md-3">
                                    <select class="form-control" id="diaryYear" name="diaryYear" style="margin-left: 53%;">
                                        <?php
                                        for($year=date('Y'); $year>=1950; $year--)
                                            echo '<option value="'.$year.'">'.$year.'</option>';
                                        ?>

                                    </select>
                                </div>

                                <div class="input-group-btn" style="text-align:center ">
                                    <button type="button" name="search" id="search-btn" class="btn btn-flat bg-red" onclick="checkDiarynumber()" style="margin-left: 278%;">Search </button>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 pull-right">
                                        <span style="color: red"><?php echo !empty($msg)?$msg:'';?></span>
                                    </div>
                                </div>

                            </div>

                            <?php form_close(); ?>


                            <br><br>
                            <br><br>

                            <div >
                                <h4 align="center" style="color: #dc3545">Postal Received</h4>
                                <br>
                                <?php
                                $i = 0;
                                $sno=1;
                                if(!empty($riData))
                                {

                                ?>
                            <div id="query_builder_wrapper" class="dataTables_wrapper dt-bootstrap4 query_builder_wrapper">
                                 <table  id="add_update_data"  class="table table-bordered table-striped datatable_report">

                                    <thead>
                                    <tr>
                                        <th width="7%">SNo.</th>
                                        <th width="10%">Diary No.</th>
                                        <th width="15%">Postal No.</th>
                                        <th width="15%">Postal Date</th>
                                        <th width="10%">Sender Name</th>
                                        <th width="10%">Receipt Mode</th>
                                        <th width="20%">Address To</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                     <tr>
                                     <?php
                                     foreach ($riData as $result){

 //                                        $i++;
 //                                        if ($i % 2 == 0)
 //                                            $rowserial = "even";
 //                                        else {
 //                                            $rowserial = "odd";
 //                                        }
                                     ?>

                                            <td><?= $sno++; ?></td>

                                            <td><button type="button" class="btn btn-primary" onclick="addEditReceiptDetail(<?=$result['id']?>, '<?=base_url()?>')"><?=$result['postal_diary_no']?></button></td>
                                            <td><?=$result['postal_no']?></td>
                                            <td><?=!empty($result['postal_date'])?date("d-m-Y", strtotime($result['postal_date'])):null?></td>
                                            <td><?=$result['sender_name']?>
                                                <?php
                                                if(!empty($result['address'])){
                                                    echo "<br/> Address: ".$result['address'];
                                                }
                                                ?></td>
                                            <td><?=$result['postal_type_description']?></td>
                                            <td><?=$result['address_to']?></td>

                                        </tr>
                                        <?php
                                        }
                                    }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                            </div>

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


    $(function () {
        $(".datatable_report").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel",{extend: 'pdfHtml5',orientation: 'landscape',pageSize: 'LEGAL' },
                { extend: 'colvis',text: 'Show/Hide'}],"bProcessing": true,"extend": 'colvis',"text": 'Show/Hide'
        }).buttons().container().appendTo('.query_builder_wrapper .col-md-6:eq(0)');

    });

    function checkDiarynumber()
    {
        var diaryNo=document.getElementById("diaryNo").value;
        var diaryYear=document.getElementById("diaryYear").value;
        if(diaryNo==""){
            alert("Please Enter Diary Number");
            document.getElementById("diaryNo").focus();
            return false;
        }
        if(diaryYear==""){
            alert("Please Enter Diary Year");
            document.getElementById("diaryYear").focus();
            return false;
        }
        //alert("Test");
        document.getElementById("frmGetRIDetail").submit();
    }

    function addEditReceiptDetail(ecRIId, basePath){
        //alert(basePath);
        window.location.href = basePath+"/RI/ReceiptController/editReceiptData/"+ ecRIId ;
        //$("select#actionTaken").change();
    }
</script>



 <?=view('sci_main_footer') ?>