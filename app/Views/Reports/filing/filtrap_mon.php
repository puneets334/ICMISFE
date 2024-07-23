<?= view('header') ?>

 

    <link rel="stylesheet" type="text/css" href="<?= base_url('/css/aor.css') ?>">

    <div class="card-header heading">
        <div class="row">
            <div class="col-sm-10">
            </div>
            <div class="col-sm-2">
                <div class="custom_action_menu">
                    <button class="btn btn-success btn-sm" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                    <button class="btn btn-primary btn-sm" type="button"><i class="fas fa-pen" aria-hidden="true"></i></button>
                    <button class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>

    <br>

    <body>
    <script>
        $(document).ready(function() {
            $('#impugned_date10').datetimepicker({
                format: 'DD-MM-YYYY', // Use capital 'MM' for month and 'DD' for day
                icons: {
                    time: 'fa fa-clock-o',
                    date: 'fa fa-calendar',
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down',
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-crosshairs',
                    clear: 'fa fa-trash',
                    close: 'fa fa-times'
                },
                showClear: true, // Show clear button
                showTodayButton: true, // Show "Today" button
                useCurrent: false, // Do not set the date to current date by default
                // Other configuration options...
            });

            // Button click event
            $('#btnreport').click(function() {
                // Get the selected date
                var selectedDate = $('#date_for').val();
                // Submit the form with the selected date
                $('form').submit();
            });
        });
    </script>
    <form method="post" action="<?= base_url('Reports/Filing/Filing_Reports/filtrap_mon') ?>">
        <?= csrf_field() ?>

        <div id="dv_content1">
            <div style="font-weight: bold; display: flex; align-items: center;">
                <p  style="margin-left:24%">CONSOLIDATED FILING-TRAP REPORT FOR THE DATE</p>

                <div class="input-group date" id="impugned_date10" data-target-input="nearest" style="margin-left:-6%;width:18%">
                    <input type="text" name="filing_dt" id="date_for" class="form-control datetimepicker-input" value="<?= date('d-m-Y'); ?>" style="margin-left: 49%;" />
                    <div class="input-group-append" data-target="#impugned_date10" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                &nbsp;&nbsp;

                <input type="button" class="btn btn-primary" value="SHOW REPORT" id="btnreport" />
            </div>
            <div id="result_main">
            </div>
        </div>




    </form>
    </body>
    <br><br>


<?php if (!empty($trapData)) : ?>
    <table style="margin-left: auto;margin-right: auto;border-collapse: collapse" border="1" cellspacing="5" cellpadding="5">
        <thead>
        <tr>
            <th>SNo.</th>
            <th>User</th>
            <th>Dispatched</th>
            <th>Completed</th>
            <th>Total Pending</th>
        </tr>
        </thead>
        <tbody>
        <?php $sno = 1; ?>
        <?php foreach ($trapData as $row) :  ?>
            <tr>
                <th><?php echo $sno; ?></th>
                <td><?php echo $row->name; ?></td>
                <td><?php echo $row->sent; ?></td>
                <td><?php echo $row->comp; ?></td>
                <td><?php echo $row->pending; ?></td>
            </tr>
            <?php $sno++; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <div style="text-align: center;font-size: 17px;color: red">SORRY, NO RECORD FOUND!!!</div>
<?php endif; ?>



    <script>
        $(document).ready(function() {
            $("#btnreport").click(function() {
                var date_for = $("#date_for").val();
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url('Reports/Filing/Report/filtrap_mon1') ?>",
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', '<?= csrf_hash() ?>');
                        $("#result_main").html("<div style='margin:0 auto;margin-top:20px;width:15%'><img src='../images/load.gif'></div>");
                    },
                    data: {

                        date: date_for,
                    }
                })
                    .done(function(msg_new) {
                        $("#result_main").html(msg_new);
                        updateCSRFToken();
                    })
                    .fail(function() {
                        alert("ERROR, Please Contact Server Room");
                        updateCSRFToken();
                    });
            });
        });
    </script>


 <?=view('sci_main_footer') ?>