<?=view('header'); ?>
 

<?php //print_r($success); exit(); 
?>
<!-- Main content -->
<?php //var_dump($fd);  exit();
?>
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
                                    <a href="<?= base_url('Filing/Diary'); ?>"><button class="btn btn-success btn-sm" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button></a>
                                    <a href="<?= base_url('Filing/Diary/search'); ?>"><button class="btn btn-primary btn-sm" type="button"><i class="fas fa-pen	" aria-hidden="true"></i></button></a>
                                    <a href="<?= base_url('Filing/Diary/deletion'); ?>"><button class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?= view('Filing/filing_breadcrumb'); ?>
                    <!-- /.card-header -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header p-2" style="background-color: #fff;">
                                    <h4 class="basic_heading"> Limitation Details </h4>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">

                                        <table class="table_tr_th_w_clr c_vertical_align" cellpadding="5" cellspacing="5" width="100%">
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Court</th>
                                                <th>State</th>
                                                <th>Bench</th>
                                                <th>Case No.</th>
                                                <th>Order Date</th>
                                                <th>Petition in Time</th>
                                                <th>Generate</th>
                                            </tr>

                                            <?php $sno = 1;
                                            foreach ($result as $row) :  ?>

                                                <tr>
                                                    <td><?= $sno; ?></td>
                                                    <td><?php
                                                        switch ($row->ct_code) {
                                                            case '1':
                                                                echo "High Court";
                                                                break;
                                                            case '2':
                                                                echo "Other";
                                                                break;
                                                            case '3':
                                                                echo "District Court";
                                                                break;
                                                            case '4':
                                                                echo "Supreme Court";
                                                                break;
                                                            case '5':
                                                                echo "State Agency";
                                                                break;
                                                            default:
                                                                echo "";
                                                        }
                                                        ?></td>

                                                    <td><?= $row->name; ?></td>
                                                    <td><?= $row->agency_name; ?></td>
                                                    <td><?= $row->type_sname . '-' . $row->lct_caseno . '-' . $row->lct_caseyear; ?></td>
                                                    <td><?= (!empty($row->lct_dec_dt)) ? date('d-m-Y', strtotime($row->lct_dec_dt)) : 'N/A'; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($row->limit_days != '') {
                                                            if ($row->limit_days <= 0) {
                                                                echo "Yes";
                                                            } else  if ($row->limit_days > 0) {
                                                                echo "No";
                                                            }
                                                        } else {
                                                            echo "-";
                                                        }
                                                        ?>
                                                    </td>


                                                    <td>
                                                        <input type="checkbox" value="Generate" id="check" name="check" class="cl_generate" data-form="form<?= $sno; ?>" />
                                                    </td>
                                                </tr>
                                            <?php $sno++;
                                            endforeach; ?>
                                        </table>

                                        <br><br>
                                        <?php
                                        if ($getcasestatus == null) {
                                            echo "Nature of matters not found for calculating limitation";
                                        } else {
                                            $sno = 1;
                                            foreach ($result as $row) :
                                                $formId = 'form' . $sno;
                                                $attribute = array('class' => 'form-horizontal', 'id' => $formId, 'autocomplete' => 'off');
                                                echo form_open(base_url('Filing/Limitation/InsertAction'), $attribute);
                                        ?>
                                                <form id="<?= $formId; ?>" style="display: none;">
                                                    <?= csrf_field(); ?>
                                                    <div class="container">
                                                        <table class="table table-borderless">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Nature of the Matter</td>
                                                                    <td><?= $casename->casename ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Claimed From</td>
                                                                    <td>
                                                                        <?php if (!empty($s_c_t)) : ?>
                                                                            <?php foreach ($s_c_t as $index => $row1) : ?>
                                                                                <?php
                                                                                if ($row1['order_cof'] == 'O') {
                                                                                    $o_cof = 'rdn_o';
                                                                                    $o_c = 'Order';
                                                                                    $o_period = $row1['limitation'];
                                                                                } elseif ($row1['order_cof'] == 'C') {
                                                                                    $o_cof = 'rdn_c';
                                                                                    $o_c = 'Certificate of fitness';
                                                                                }
                                                                                ?>
                                                                                <div>
                                                                                    <input type="radio" name="rdn_o_cof" id="<?= $o_cof . '_' . $index ?>" value="<?= $row1['order_cof'] ?>" <?= $row1['order_cof'] == 'O' || $no_rws == 0 ? 'checked' : '' ?> class="c_o_cof" />
                                                                                    <label for="<?= $o_cof . '_' . $index ?>"><?= $o_c ?></label>
                                                                                    <div class="input-group">
                                                                                        <?php
                                                                                        if ($o_d !== null) {
                                                                                            $formatted_date1 = date("d-m-Y", strtotime($o_d));
                                                                                        } else {
                                                                                            $formatted_date1 = '';
                                                                                        }
                                                                                        $formatted_date = $row1['order_cof'] == 'O' && $no_rws == 0 ? date('d-m-Y', strtotime($row->lct_dec_dt)) : '';
                                                                                        ?>
                                                                                        <div class="input-group date" id="government_notification_year" data-target-input="nearest">
                                                                                            <input type="text" class="form-control datetimepicker-input" data-target="#government_notification_year" name="txt_order_dt<?= $row1['order_cof'] ?>" id="txt_order_dt<?= $row1['order_cof'] ?>" maxlength="10" size="9" <?php if (($row1['order_cof'] != 'O' && $no_rws == 0 && $no_rws == 0) || ($no_rws != 0 && $row1['order_cof'] != $row1['order_cof'])) { ?> disabled="true" <?php } ?> value="<?= $row1['order_cof'] == 'O' ? $formatted_date1 : '' ?>" />
                                                                                            <div class="input-group-append" data-target="#government_notification_year" data-toggle="datetimepicker">
                                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" name="hd_limitation<?= $row1['order_cof']; ?>" id="hd_limitation<?= $row1['order_cof']; ?>" value="<?= $row1['limitation']; ?>" />
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>



                                                                <tr>
                                                                    <td>Period of Limitation</td>
                                                                    <td><input type="text" class="form-control" name="climit" id="climit" value="<?= isset($getcasestatus->pol) ? $getcasestatus->pol : '' ?>" readonly /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Date of Filing</td>
                                                                    <td>
                                                                        <div class="input-group date" id="impugned_date10" data-target-input="nearest">
                                                                            <?php
                                                                            // Assuming $fd contains a date in YYYY-MM-DD format
                                                                            // Convert it to DD-MM-YYYY format
                                                                            if ($fd !== null) {
                                                                                $formatted_date = date("d-m-Y", strtotime($fd));
                                                                            } else {
                                                                                $formatted_date = '';
                                                                            }
                                                                            ?>
                                                                            <input type="text" name="filing_dt" id="filing_dt" class="form-control datetimepicker-input" value="<?php echo $formatted_date; ?>" placeholder="DD-MM-YYYY" />
                                                                            <div class="input-group-append" data-target="#impugned_date10" data-toggle="datetimepicker">
                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Copy applied on</td>
                                                                    <td>
                                                                        <div class="input-group date" id="impugned_date3" data-target-input="nearest">
                                                                            <?php
                                                                            // Assuming $fd contains a date in YYYY-MM-DD format
                                                                            // Convert it to DD-MM-YYYY format
                                                                            if ($c_d_a !== null) {
                                                                                $formatted_date = date("d-m-Y", strtotime($c_d_a));
                                                                            } else {
                                                                                $formatted_date = '';
                                                                            }
                                                                            ?>
                                                                            <input type="text" name="copy_aply_dt" id="copy_aply_dt" class="form-control datetimepicker-input" value="<?php echo $formatted_date; ?>" placeholder="DD-MM-YYYY" />
                                                                            <div class="input-group-append" data-target="#impugned_date3" data-toggle="datetimepicker">
                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Copy ready on</td>
                                                                    <td>
                                                                        <div class="input-group date" id="impugned_date4" data-target-input="nearest">
                                                                            <?php
                                                                            // Assuming $fd contains a date in YYYY-MM-DD format
                                                                            // Convert it to DD-MM-YYYY format
                                                                            if ($d_o_d !== null) {
                                                                                $formatted_date = date("d-m-Y", strtotime($d_o_d));
                                                                            } else {
                                                                                $formatted_date = '';
                                                                            }
                                                                            ?>
                                                                            <input type="text" name="copy_dlvr_dt" id="copy_dlvr_dt" class="form-control datetimepicker-input" value="<?php echo $formatted_date; ?>" placeholder="DD-MM-YYYY" />
                                                                            <div class="input-group-append" data-target="#impugned_date4" data-toggle="datetimepicker">
                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Attestation</td>
                                                                    <td>
                                                                        <div class="input-group date" id="impugned_date5" data-target-input="nearest">
                                                                            <?php
                                                                            // Assuming $fd contains a date in YYYY-MM-DD format
                                                                            // Convert it to DD-MM-YYYY format
                                                                            if ($d_o_a !== null) {
                                                                                $formatted_date = date("d-m-Y", strtotime($d_o_a));
                                                                            } else {
                                                                                $formatted_date = '';
                                                                            }                                                                            ?>
                                                                            <input type="text" name="txt_attestation" id="txt_attestation" class="form-control datetimepicker-input" value="<?php echo $formatted_date; ?>" placeholder="DD-MM-YYYY" />
                                                                            <div class="input-group-append" data-target="#impugned_date5" data-toggle="datetimepicker">
                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>


                                                            </tbody>
                                                        </table>

                                                        <?php if (isset($success_message)) : ?>
                                                            <div class="alert alert-success"><?= $session->getFlashdata('success_message') ?></div>
                                                        <?php endif; ?>
                                                        <?php if (isset($error_message)) : ?>
                                                            <div class="alert alert-danger"><?= $session->getFlashdata('error_messagex') ?></div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div style="text-align: center;">
                                                        <strong>
                                                            <?php
                                                            if ($getcasestatus !== null) {
                                                            } else {
                                                                echo '<span style="display: inline-block; text-align: center;">Nature of matters not found for calculating limitation</span>';
                                                            }
                                                            ?>
                                                        </strong>
                                                    </div>
                                                    <div id="limitationDiv" style="text-align: center;">
                                                        <strong>
                                                            <?php
                                                            $descr = explode(" ", $getcasestatus->descr);
                                                            echo '<span style="display: inline-block;">' . $descr[0] . '</span>';
                                                            echo implode(" ", array_slice($descr, 1));
                                                            ?>
                                                        </strong>
                                                    </div>

                                                </form>



                                            <?php
                                                $sno++;
                                            endforeach;
                                            ?>
                                            <div id="submitButtons" style="display: flex; justify-content: center;">
                                                <button type="submit" class="btn btn-primary" id="submit" onclick="save_check()">Submit</button> &nbsp;
                                                <button type="submit" class="btn btn-primary" id="del_check" onclick="del_check_vb()">Delete</button>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <script>
                                            // Function to hide the div when the submit button is clicked
                                            function hideDiv() {
                                                document.getElementById("limitationDiv").style.display = "none";
                                            }

                                            // Add event listeners to the submit buttons to hide the div
                                            document.getElementById("submit").addEventListener("click", hideDiv);
                                            document.getElementById("del_check").addEventListener("click", hideDiv);
                                        </script>

                                        <script>
                                            $('#impugned_date,#impugned_date1,#impugned_date2,#impugned_date3,#government_notification_year,#impugned_date5').datetimepicker({
                                                format: 'DD-MM-YYYY',
                                            });
                                        </script>




                                    </div>

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
        </div>
</section>


<style>
    .green-text {
        color: green;
    }

    .green-text1 {
        color: blue;
    }

    .red-text {
        color: red;
    }
</style>
<style>
    #tableBody {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #tableBody td,
    #tableBody th {
        border: 1px solid #ddd;
        padding: 8px;
    }



    #tableBody tr:hover {
        background-color: #ddd;
    }

    #tableBody th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        color: black;
    }

    #descrContainer {
        font-weight: bold;
        text-align: center;
    }
</style>
<script>
    $(document).ready(function() {
        var initialClimitValue = $('#climit').val();


        $('#cof').on('click', function() {
            $('#climit').val('60');
        });

        $('input').on('blur', function() {
            $('#climit').val(initialClimitValue);
        });
    });
</script>
<span>
    <div id="descrContainer"></div>
</span>

<div id="reportDiv" style="display: none;">

    <?php
    $asdesc = "";
    $offset = 5.5 * 60 * 60;
    $c_date = gmdate('d-m-Y g:i a', time() + $offset);
    echo "<br><center><b><span style='color: black;'><u> Supreme Court of India </u></span></b></center>";
    echo "<center><b><span style='color: black;'><u> Section I-B </u></span></b></center>";
    echo "<br><center><b><span style='color: green;'><u> Limitation Report  - Generated on : " . $c_date . " </u></span><div align=right></b></center><br>";
    echo $asdesc = "Diary No.-" . substr($diary_no, 0, strlen($diary_no) - 4) . '-' . substr($diary_no, -4) . '<br/>';

    ?>
    <table style="margin-left: auto; margin-right: auto; border-collapse: collapse; width: 60%; table {
    border-collapse: collapse;
    width: 70%;
    margin-left: auto;
    margin-right: auto;
}

table, th, td {
    border: 1px solid black;
}

thead {
    background-color: lightgray;
}

tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

tbody tr:hover {
    background-color: #ddd;
}
" border="1" cellspacing="3" cellpadding="3">

        </thead>

        <tbody id="tableBody">
        </tbody>
    </table>
    <table> <br><br><br><br><br>
        <div align="left">( Dealing Assistant) </div>
        <div align="left"><?php echo ($c_date) ?></div><br><br>
        <div align="right">(Branch Officer)</div>
    </table>

    <div style="display: flex; justify-content: center;">
        <button class="btn btn-primary" id="printButton" onclick="printReport()">Print Report</button>
    </div>
</div>


<script>
    function printReport() {
        var printButton = document.getElementById('printButton');
        printButton.style.display = 'none'; // Hide print button
        var printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write('<html><head><title></title></head><body>');
        printWindow.document.write(document.getElementById('reportDiv').innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>
<script>
    $(document).ready(function() {
        $('#impugned_date4').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#impugned_date1').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#impugned_date2').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#impugned_date3').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#impugned_date5').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#impugned_date6').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#impugned_date').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#impugned_date7').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#impugned_date9').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#impugned_date10').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#impugned_date').datetimepicker({
            format: 'DD-MM-YYYY'
        });

    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const generateCheckboxes = document.querySelectorAll('.cl_generate');

        generateCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const formId = this.getAttribute('data-form');
                const form = document.getElementById(formId);

                if (this.checked) {
                    form.style.display = 'block';
                } else {
                    form.style.display = 'none';
                }
            });

            if (!checkbox.checked) {
                const formId = checkbox.getAttribute('data-form');
                const form = document.getElementById(formId);
                form.style.display = 'none';
            }
        });
    });
</script>




<script>
    function save_check() {

        var t_h_cno = $('#t_h_cno').val();
        var t_h_cyt = $('#t_h_cyt').val();

        var txt_order_dtO = '';
        var v_val = '';
        var idd = '';
        $('.c_o_cof').each(function() {
            if ($(this).is(':checked')) {
                v_val = $(this).val();
                txt_o_cof = $('#txt_order_dt' + v_val).val();
                idd = $(this).attr('id');
            }
        });
        if ($("#filing_dt").val() == "") {
            alert("Please Enter Filing Date");
            $("#filing_dt").focus();
            return false;
        }
        if (txt_o_cof == "") {
            if (v_val == 'O') {
                alert("Please enter Order Date");
                $("#" + idd).focus();
            } else if (v_val == 'C') {
                alert("Please enter Certificate of fitness Date");
                $("#" + idd).focus();
            }
            return false;
        }
        var order_dt = txt_o_cof;

        var copy_aply_dt = $("#copy_aply_dt").val();
        var copy_dlvr_dt = $("#copy_dlvr_dt").val();


        var filing_dt = document.getElementById('filing_dt').value;
        var climit = document.getElementById('climit').value;

        var txt_attestation = $("#txt_attestation").val();
        var order_cof = $('input[name="rdn_o_cof"]:checked').val();

        var dt1 = parseInt(filing_dt.substring(0, 2), 10);
        var mon1 = parseInt(filing_dt.substring(3, 5), 10) - 1;
        var yr1 = parseInt(filing_dt.substring(6, 10), 10);
        var date1 = new Date(yr1, mon1, dt1);
        var dt2 = parseInt(order_dt.substring(0, 2), 10);
        var mon2 = parseInt(order_dt.substring(3, 5), 10) - 1;
        var yr2 = parseInt(order_dt.substring(6, 10), 10);
        var date2 = new Date(yr2, mon2, dt2);
        var dt3 = parseInt(copy_dlvr_dt.substring(0, 2), 10);
        var mon3 = parseInt(copy_dlvr_dt.substring(3, 5), 10) - 1;
        var yr3 = parseInt(copy_dlvr_dt.substring(6, 10), 10);
        var date3 = new Date(yr3, mon3, dt3);
        var dt4 = parseInt(copy_aply_dt.substring(0, 2), 10);
        var mon4 = parseInt(copy_aply_dt.substring(3, 5), 10) - 1;
        var yr4 = parseInt(copy_aply_dt.substring(6, 10), 10);
        var date4 = new Date(yr4, mon4, dt4);


        if (date1 < date2) {
            alert("Filing Date should be greater or equal to Date of Order");
            return false;
        }
        if (date3 < date4) {
            alert("Date of delivery should be greater than or equal to Copying Date of Applied");
            return false;
        }
        var csrfToken = '<?= csrf_hash() ?>';
        $('#check').attr('disabled', true);
        var hd_l_c_id = $('#hd_l_c_id').val();
        $.ajax({
            url: "<?php echo base_url('Filing/Limitation/InsertAction'); ?>",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                climit: climit,
                t_h_cyt: t_h_cyt,
                filing_dt: filing_dt,
                copy_aply_dt: copy_aply_dt,
                copy_dlvr_dt: copy_dlvr_dt,
                txt_attestation: txt_attestation,
                order_cof: order_cof,
                order_dt: order_dt,


            },
            success: function(data) {
                try {
                    var responseData = JSON.parse(data);
                    var tableBody = $('#tableBody');
                    tableBody.empty();

                    if (responseData && Object.keys(responseData).length > 0) {
                        var isTotalDays2Negative = parseInt(responseData.totaldays) <= 0;
                        var isTotalDays2Negative1 = parseInt(responseData.totaldays) > 0;


                        var newRow = '';

                        if (responseData.descr) {
                            var descrContainer = document.getElementById("descrContainer");
                            descrContainer.innerHTML = responseData.descr;
                        }
                        var newRow = '<tr>' +
                            '<th>Cause Title</th><td class="green-text1">' + (responseData.cause_title ? responseData.cause_title : '') + '</td></tr>' +
                            '<tr><th>Date of Order: (A)</th><td>' + formatDate(responseData.order_dt ? responseData.order_dt : '') + '</td></tr>' +
                            '<tr><th>Date of Filing: (B)</th><td>' + formatDate(responseData.f_d) + '</td></tr>' +
                            '<tr><th>Total Days : (C) = (B-A)</th><td class="green-text1">' + (responseData.days ? responseData.days : '') + '</td></tr>' +
                            '<tr><th>Copy Ready on : (D)</th><td>' + formatDate(responseData.d_o_d) + '</td></tr>' +
                            '<tr><th>Copy Applied on : (E)</th><td>' + formatDate(responseData.c_d_a) + '</td></tr>' +
                            '<tr><th>Total Days (D-E) : (F)</th><td class="red-text">' + (responseData.cdays ? responseData.cdays : '') + '</td></tr>' +
                            '<tr><th>Total Holidays : (G)</th><td>' + (responseData.totalHolidays ? responseData.totalHolidays : '') + '</td></tr>' +
                            '</tr>';
                        if (isTotalDays2Negative1) {
                            newRow += '<tr><th>Total Days : [ C-(F+G+H)]</th><td class="red-text">' + (responseData.totaldays ? responseData.totaldays : '') + '</td></tr>';
                        }


                        if (isTotalDays2Negative) {
                            newRow += '<tr><th>Limitation days : (H)</th><td class="red-text">' + (responseData.pol ? responseData.pol : '') + '</td></tr>' + '<tr><th>Total Days : [ C-(F+G+H)]</th><td class="red-text">' + (responseData.totaldays ? responseData.totaldays : '') + '</td></tr>' +
                                '<tr><th>Limitation</th><td class="green-text">PETITION HAS BEEN FILED WITHIN ' + (responseData.climit ? responseData.climit : '') + ' DAYS</td></tr>';
                            '<tr><th></th><td class="green-text">PETITION HAS BEEN FILED WITHIN ' + (responseData.climit ? responseData.climit : '') + ' DAYS PETITION IS WITHIN TIME</td></tr>';
                        } else {
                            newRow += '<tr><th>Limitation days : (H)</th><td class="red-text">' + (responseData.pol ? responseData.pol : '') + '</td></tr>' + '<tr><td><b>(J) - (H)</b></td><td><font color="red">' + (responseData.totaldays ? responseData.totaldays : '') + '</font></td></tr>' +
                                '<tr><td><b>Limitation</b></td><td><font color="red"><b>PETITION IS TIME BARRED BY ' + (responseData.totaldays ? responseData.totaldays : '') + ' DAYS</b></font></td></tr>';
                        }



                        tableBody.append(newRow);

                    } else {
                        tableBody.html('<tr><td colspan="2">No data available</td></tr>');
                    }

                    $('#check').prop('disabled', false);
                    alert('Successfully Updated');
                    updateCSRFToken();
                } catch (e) {
                    console.error('Error parsing JSON: ' + e.message);
                    alert('Error: Failed to parse data');
                    updateCSRFToken();
                }
            },



            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + xhr.responseText);
                alert('Error: Failed to load data');
                updateCSRFToken();

            }
        });

        $(document).on('click', '.delete-row', function() {
            deleteRow(this);
        });


        document.getElementById("reportDiv").style.display = "block";


    }

    function deleteRow(row) {
        $(row).closest('tr').remove();
    }

    function formatDate(dateString) {
        if (!dateString) return '';
        var dateParts = dateString.split("-");
        return dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
    }


    $(document).on('click', '.c_o_cof', function() {
        var v_val = $(this).val();
        $('.c_o_cof').each(function() {
            var s_val = $(this).val();
            $('#txt_order_dt' + s_val).attr('disabled', true)
        });
        $('#txt_order_dt' + v_val).attr('disabled', false);
        var hd_limitation = $('#hd_limitation' + v_val).val();
        $('#climit').val(hd_limitation);
    });

    function del_check_vb() {
        var insertId = <?= json_encode($insert_id) ?>;
        var cn_con = confirm("Are you sure you want to delete record");
        if (cn_con == true) {
            $('#del_check').attr('disabled', true);
            var csrfToken = '<?= csrf_hash() ?>';
            $.ajax({
                url: "<?= base_url('Filing/Limitation/del_limit') ?>",
                cache: false,
                async: true,
                data: {
                    insert_id: insertId,
                    <?= csrf_token() ?>: csrfToken
                },
                type: 'POST',
                success: function(data, status) {
                    alert(data);
                    $('#del_check').attr('disabled', false);
                    closeData();
                    get_lower_court_details();
                    updateCSRFToken();
                },
                error: function(xhr) {
                    alert("Error: " + xhr.status + " " + xhr.statusText);
                    updateCSRFToken();
                }
            });
        }
    }
</script>

 <?=view('sci_main_footer');?>