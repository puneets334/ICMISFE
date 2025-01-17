<?= view('header') ?>

    <link rel="stylesheet" type="text/css" href="<?= base_url('/css/aor.css') ?>">

    <div class="card-header heading">
        <div class="row">
            <div class="col-sm-10">
                <h3 class="card-title">Report >>&nbsp; AORs having Clerks more than 2</h3>
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
    <br>
    <div class="container">
        <div class="panel panel-info">
            <div class="panel-heading panel-success">
                <h4><strong><span class="fa fa-list"></span>&nbsp; Report >>&nbsp;AORs having Clerks more than 2</strong></h4>
            </div>
        </div>

        <?php if (empty($records)) : ?>
            <div class='well well-lg'>
                <div class='col-md-12'>
                    <a class='btn btn-success btn-xs' href='#'>Results Found---<span class='badge'>0 </span></a>
                </div>
            </div>
        <?php else : ?>

            <div class='well well-lg'>
                <div class='col-md-12'>
                    <a class='btn btn-success ' href='#'>Results Found <span class='badge'><?= count($records) ?></span></a>
                </div>
            </div> <br>

            <div id="query_builder_wrapper" class="query_builder_wrapper dataTables_wrapper dt-bootstrap4">
                <div id="printable">
                    <table id="query_builder_report" class="query_builder_report table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>SNo</th>
                            <th>Clerk Code</th>
                            <th>Clerk Name</th>
                            <th>Clerks Father's Name</th>
                            <th>Action Details</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sno = 0;
                        foreach ($records as $record) : ?>
                            <tr style="color: green;">
                                <td><?= ++$sno ?></td>
                                <td>AOR NAME</td>
                                <td><?= $record['name'] . ' (' . $record['aor_code'] . ')' ?></td>
                                <td>CLERKS ATTACHED</td>
                                <td><?= count($clerks[$record['aor_code']]) ?></td>
                            </tr>

                            <?php
                            // Reset $sno to start counting from 1 for each AOR
                            $sno1 = 0;
                            foreach ($clerks[$record['aor_code']] as $clerk) : ?>
                                <tr>
                                    <td><?= ++$sno1 ?></td>
                                    <td><?= $clerk['eino'] ?></td>
                                    <td><?= $clerk['cname'] ?></td>
                                    <td><?= $clerk['cfname'] ?></td>
                                    <td>
                                        <?php foreach ($model->getTransactions($clerk['id']) as $transaction) : ?>
                                            <?= $transaction['event_name'] ?> ON : <?= $transaction['formatted_event_date'] ?> <?= $transaction['remarks'] ?><br>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php endforeach; ?>



                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <script>
        $(function() {
            $("#query_builder_report").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [
                    "copy", "csv", "excel", {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide'
                    }
                ],
                "processing": true, // Changed "bProcessing" to "processing"
                "ordering": false, // Added to disable sorting
                "paging": false // Added to disable pagination

            }).buttons().container().appendTo('#query_builder_wrapper .col-md-6:eq(0)');
        });
    </script>

    <div id="div_print">
        <div id="header" style="background-color:White;"></div>
        <div id="footer" style="background-color:White;"></div>
    </div>
<?=view('sci_main_footer') ?>