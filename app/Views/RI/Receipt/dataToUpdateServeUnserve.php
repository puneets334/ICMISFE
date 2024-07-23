<?php
if(!empty($dataToUpdateServeStatus)){
?>

<div class="form-group col-sm-6 pull-right">
    <label>&nbsp;</label>
    <button type="button" id="btnReceiveTop" name="btnReceive" class="btn btn-primary pull-right" onclick="return doUpdateServeUnserve();">
        <i class="fa fa-fw fa-download"></i>&nbsp;Update Serve Status
    </button>
</div>
<table id="tblUpdateServeUnserve" style="width: 100%" class="table table-striped table-hover">
    <thead>
    <tr>
        <th width="3%">#</th>
        <th width="30%">Letter Detail</th>
        <th width="15%">Serve Stage</th>
        <th width="15%">Serve Type</th>
        <th width="15%">Remarks</th>
        <th width="10%"><label><input type="checkbox" id="allCheck" name="allCheck" onclick="selectallMe()">Select All</label></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $s_no = 1;
    //var_dump($dataToUpdateServeStatus);
    foreach ($dataToUpdateServeStatus as $case) {
        ?>
        <tr>
            <td><?= $s_no ?></td>
            <td>
                <?php if ($case['is_with_process_id'] == 1) { ?>
                    <b>Process Id: <?= $case['process_id'] ?>/<?= $case['process_id_year'] ?></b>
                <?php } else { ?>
                    <b>Reference No.: <?= $case['reference_number'] ?></b>
                <?php } ?>
                <br/>
                <?php if ($case['is_case'] == 1) { ?>
                    <?= $case['case_no'] ?><br/>
                <?php } ?>
                <?= trim($case['send_to_name']) ?><br/>
                <?= (trim($case['send_to_address']) != '') ? '<b>Address: </b>' . trim($case['send_to_address']) : '' ?>
                <?= (trim($case['district_name']) != '') ? ' ,' . trim($case['district_name']) : '' ?>
                <?= (trim($case['state_name']) != '') ? ' ,' . trim($case['state_name']) : '' ?>
                <?= ($case['pincode'] != 0) ? ' ,' . $case['pincode'] : '' ?> <br/>
                <b>Document Type: </b> <?= $case['doc_type'] ?>

            </td>

            <td>
                <select class="form-control" id="serveStage_<?= $case['ec_postal_dispatch_id'] ?>" onchange="getServeType(<?= $case['ec_postal_dispatch_id'] ?>)">
                    <option value="0">Select Serve Stage</option>
                    <?php
                    if(!empty($serveStage)) {
                        foreach ($serveStage as $stage) {
                            echo '<option value="' . $stage['serve_stage'] . '">' . $stage['name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </td>
            <td id="tdServeType_<?= $case['ec_postal_dispatch_id'] ?>">

            </td>
            <td>
                <input type="text" id="remarks_<?= $case['ec_postal_dispatch_id'] ?>" name="remarks"
                       class="form-control" placeholder="Remarks" value="">
            </td>

            <td><input type="checkbox" id="daks" name="daks[]" value="<?= $case['ec_postal_dispatch_id'] ?>">
            </td>
        </tr>
        <?php
        $s_no++;
    }
    ?>
    </tbody>
    <?php
    }
    else{
        echo "<br><div class='col-sm-12'><h4 class='text-danger'>No Data Found!</h4></div>";
    }
    ?>
    <script type="text/javascript">
        $('.number').keypress(function(event) {
            if(event.which == 8 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46)
                return true;
            else if((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57))
                event.preventDefault();
        });

        function getServeType(id){
            stage=$("#serveStage_"+id).val();

            //$.get("<?//=base_url('RI/ReceiptController/getServeType')?>//", {'stage':stage,'id':id}, function (result) {
            //
            //    $("#tdServeType_"+id).html(result);
            //});

            $.ajax({
                type: 'POST',
                url:'<?=base_url('RI/ReceiptController/getServeType')?>',
                data: {'stage':stage,'id':id},
                success: function (result) {

                    $("#tdServeType_"+id).html(result);
                },
                error: function() {
                    alert("Error, Something Went Wrong!!");
                    updateCSRFToken();
                }

            });


        }

        //function getServeType(id){
        //    stage=$("#serveStage_"+id).val();
        //    $.get("<?//=base_url()?>//index.php/RIController/getServeType", {'stage':stage,'id':id}, function (result) {
        //
        //        $("#tdServeType_"+id).html(result);
        //    });
        //}
    </script>
