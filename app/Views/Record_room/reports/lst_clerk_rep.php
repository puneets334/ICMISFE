<?= view('header') ?>
 
<link rel="stylesheet" type="text/css" href="<?= base_url('/css/aor.css') ?>">

<div class="card-header heading">
    <div class="row">
        <div class="col-sm-10">
            <h3 class="card-title">Report >>&nbsp; Clerk Details</h3>
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
            <h4><strong><span class="fa fa-list"></span>&nbsp; Report >>&nbsp;Clerk Details</strong></h4>
        </div>
    </div>

    <?php if (empty($clerkDetails)) : ?>
        <div class='well well-lg'>
            <div class='col-md-12'>
                <a class='btn btn-success btn-xs' href='#'>Results Found---<span class='badge'>0 </span></a>
            </div>
        </div>
    <?php else : ?>


        <div id="query_builder_wrapper" class="query_builder_wrapper dataTables_wrapper dt-bootstrap4">
            <div id="printable">
                <table id="query_builder_report" class="query_builder_report table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="{sorter: false}">SNo</th>
                            <th>AOR Code</th>
                            <th>AOR Name</th>
                            <th>Clerk Name</th>
                            <th>Clerks Father's Name</th>
                            <th>Clerk Id No.</th>
                            <th>Clerk Mobile No.</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $a = 1; ?>
                        <?php foreach ($clerkDetails as $row) : ?>
                            <tr>
                                <td><?= $a++ ?></td>
                                <td><?= $row['aor_code'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['cname'] ?></td>
                                <td><?= $row['cfname'] ?></td>
                                <td><?= $row['eino'] ?></td>
                                <td><?= $row['cmobile'] ?></td>
                                <td><?= $row['formatted_regdate'] ?></td>
                            </tr>
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
            "buttons": ["copy", "csv", "excel", {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide'
                }
            ],
            "bProcessing": true,
            "extend": 'colvis',
            "text": 'Show/Hide'
        }).buttons().container().appendTo('#query_builder_wrapper .col-md-6:eq(0)');

    });
</script>
<div id="div_print">
    <div id="header" style="background-color:White;"></div>
    <div id="footer" style="background-color:White;"></div>
</div>
 <?=view('sci_main_footer') ?>