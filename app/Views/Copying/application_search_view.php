<?= view('header') ?>
 
<style>
    .item {
        border: 1px solid #eee;
        box-shadow: 0 0 10px -3px #ccc;
        border-radius: 5px;
        margin-bottom: 30px;
        padding: 25px;
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
                                <h3 class="card-title">Online Applications - Verification Module </h3>
                            </div>
                        </div>
                    </div>
                    <?= view('Copying/copying_breadcrumb'); ?>
                    <div class="card-header p-2" style="background-color: #fff; border-bottom:none;">
                        <h4 class="basic_heading">Online Applications - Verification Module </h4>
                    </div>
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <span class="alert-danger"><?= \Config\Services::validation()->listErrors() ?></span>

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
                                    <span id="show_error" class="ml-4 mr-4"></span> <!-- This Segment Displays The Validation Rule -->
                                    <div class="row">

                                        <div class="col-sm-2">
                                            <div class="form-group row">
                                                <label for="From" class="col-sm-4 col-form-label"> From Date</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" id="from_date" name="from_date" placeholder="Order Date" value="<?php if (!empty($formdata['from_date'])) {
                                                                                                                                                                echo $formdata['from_date'];
                                                                                                                                                            } ?>" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group row">
                                                <label for="From" class="col-sm-4 col-form-label">To Date</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" id="to_date" name="to_date" placeholder="To Date" value="<?php if (!empty($formdata['to_date'])) {
                                                                                                                                                            echo $formdata['to_date'];
                                                                                                                                                        } ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group row">
                                                <label for="From" class="col-sm-3 col-form-label">Application Type</label>
                                                <div class="col-sm-9">
                                                    <select class="select2bs4" multiple="multiple" name="application_type[]" style="width: 100%;" id="application_type" data-placeholder="Select Application Type">
                                                        <!--<option value="">Select Application Type</option>-->
                                                        <?php
                                                        foreach ($copy_category as $row) {
                                                        ?>
                                                            <option value="<?= $row['id'] ?>"><?= $row['code'] . '-' . $row['description'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group row">
                                                <label for="From" class="col-sm-3 col-form-label">Applicant Type</label>
                                                <div class="col-sm-9">
                                                    <select class="select2bs4" multiple="multiple" name="applicant_type[]" style="width: 100%;" id="applicant_type" data-placeholder="Select Applicant Type">
                                                        <option value="1">Advocate on Record</option>
                                                        <option value="2">Party/Party-in-person</option>
                                                        <option value="3">Appearing Counsel</option>
                                                        <option value="6">Authenticated By AOR</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="input-group-append">
                                                <input type="submit" name="application_search" id="application_search" class="application_search btn btn-primary" value="Search">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>

                    </div>

                </div>
                <div id="result_data"></div>
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
<script>

$(document).on('click', '#pdf_link', function() {
            $("#pdf_actions, #pdf_result").html("");
            var application_no = $(this).data('application_no');
            var path = $(this).data('path');
            var crn = $(this).data('crn');
            var court_fee = $(this).data('court_fee');
            var applicant_name = $(this).data('applicant_name');
            var application_id_id = $(this).data('application_id_id');
            var number_of_pages_in_pdf = $(this).data('number_of_pages_in_pdf');
            var delivery_mode = $(this).data('delivery_mode');
            $.ajax({
                url: 'qr_embed.php',
                cache: false,
                async: true,
                data: {
                    crn: crn,
                    application_id_id: application_id_id,
                    application_no: application_no,
                    path: path,
                    court_fee: court_fee,
                    applicant_name: applicant_name,
                    number_of_pages_in_pdf: number_of_pages_in_pdf,
                    delivery_mode: delivery_mode
                },
                beforeSend: function() {
                    $('#pdf_result').html('<table widht="100%" align="center"><tr><td>Loading...</td></tr></table>');
                },
                type: 'POST',
                success: function(data, status) {
                    $('#qr_related_data').html(data);
                    var qr_data = $(".abcd").html();
                    $.ajax({
                        url: 'pdf_result.php',
                        cache: false,
                        async: true,
                        data: {
                            application_id_id: application_id_id,
                            application_no: application_no,
                            path: path,
                            court_fee: court_fee,
                            applicant_name: applicant_name,
                            delivery_mode: delivery_mode,
                            qr_data: qr_data
                        },
                        type: 'POST',
                        success: function(data, status) {
                            $("#pdf_result").html(data);
                            if (delivery_mode == 3) {
                                pdf_actions_show(application_id_id);
                            }

                        },
                        error: function(xhr) {
                            alert("Error: " + xhr.status + " " + xhr.statusText);
                        }
                    });
                    //pdf_actions_show(application_id_id);
                },
                error: function(xhr) {
                    alert("Error: " + xhr.status + " " + xhr.statusText);
                }
            });
        });
        
    $("#application_search").click(function() {
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val();
        var application_type = $("#application_type").val();
        var applicant_type = $("#applicant_type").val();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

        $('#show_error').html("");
        if (from_date.length == 0) {
            $('#show_error').append('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Application From Date Required* </strong></div>');
            $("#from_date").focus();
            return false;
        } else if (to_date.length == 0) {
            $('#show_error').append('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Application To Date Required* </strong></div>');
            $("#to_date").focus();
            return false;
        } else if (application_type == "") {
            $('#show_error').append('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Application Type Required* </strong></div>');
            $("#application_type").focus();
            return false;
        } else if (applicant_type == "") {
            $('#show_error').append('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Applicant Type Required* </strong></div>');
            $("#applicant_type").focus();
            return false;
        } else {
            $.ajax({
                url: '<?php echo base_url('Copying/Copying/get_application_search'); ?>',
                cache: false,
                async: true,
                data: {
                    from_date: from_date,
                    to_date: to_date,
                    application_type: application_type,
                    applicant_type: applicant_type,
                    CSRF_TOKEN: CSRF_TOKEN_VALUE
                },
                beforeSend: function() {
                    // $('.application_search').val('Please wait...');
                    // $('.application_search').prop('disabled', true);
                },
                type: 'POST',
                success: function(data) {
                    // $('.application_search').prop('disabled', false);
                    // $('.application_search').val('Search');
                    $("#result_data").html(data);
                    updateCSRFToken();
                },
                error: function(xhr) {
                    updateCSRFToken();
                }
            });

        }

    });
</script>
 <?=view('sci_main_footer') ?>