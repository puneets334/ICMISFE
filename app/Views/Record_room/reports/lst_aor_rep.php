<?= view('header') ?>
 

<link rel="stylesheet" type="text/css" href="<?= base_url('/css/aor.css') ?>">
<div class="card-header heading">
    <div class="row">
        <div class="col-sm-10">
            <h3 class="card-title">Report >>&nbsp; A.O.R. Details</h3>
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
            <h4><strong><span class="glyphicon glyphicon-list glyphicon-lg"></span>&nbsp; Report >>&nbsp;A.O.R. Details</strong></h4>
        </div>
    </div>

    <?php if (empty($records)) : ?>
        <div class='well well-lg'>
            <div class='col-md-12'>
                <a class='btn btn-success btn-xs' href='#'>Results Found---<span class='badge'><?= count($records) ?></span></a>
            </div>
        </div>
    <?php else : ?>
        <div id="query_builder_wrapper" class="query_builder_wrapper dataTables_wrapper dt-bootstrap4">
            <div id="printable">
                <table id="query_builder_report" class="query_builder_report table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="{sorter: false}">SNo</th>
                    <th>AOR CODE</th>
                    <th>AOR NAME</th>
                    <th>Mobile</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php $sno = 1; ?>
                <?php foreach ($records as $record): ?>
                    <tr>
                        <td><?= $sno++ ?></td>
                        <td><?= $record['bar_id'] ?></td>
                        <td><?= $record['title'].  $record['name'] ?></td>
                        <td><?= $record['mobile'] ?></td>
                        <td><?= $record['caddress'] ?></td>
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