<!-- Main content -->
<section class="content">
    
    <br />
    <?php
    if (isset($tagged_result) && sizeof($tagged_result) > 0) {
    ?>
    <div id="query_builder_wrapper" class="query_builder_wrapper dataTables_wrapper dt-bootstrap4">
        <div id="printable">
        <table  id="query_builder_report" class="query_builder_report table table-bordered table-striped">
                <thead>
                    <tr>
                        <h2>List of Pending matters where Main Case is Regular Hearing Matter<br />
                            or Subject Category 1900,2000 and are connected with Fresh Matter</h2>
                    </tr>
                    <tr>
                        <th>Sr.No.</th>
                        <th>Main Case</th>
                        <th>Connected Case</th>
                        <th>Connected/Linked</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($tagged_result as $result) {
                        $i++;
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo substr($result->main_case, 0, -4) . '/' . substr($result->main_case, -4); ?></td>
                            <td><?php echo substr($result->connected_case, 0, -4) . '/' . substr($result->connected_case, -4); ?></td>
                            <td><?php echo  $result->connected; ?></td>
                        </tr>

                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>

            $(function () {
                $("#query_builder_report").DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": ["copy", "csv", "excel",{extend: 'pdfHtml5',orientation: 'landscape',pageSize: 'LEGAL' },
                        { extend: 'colvis',text: 'Show/Hide'}],"bProcessing": true,"extend": 'colvis',"text": 'Show/Hide'
                }).buttons().container().appendTo('#query_builder_wrapper .col-md-6:eq(0)');

            });

        </script>
    <?php
    }

    ?>
</section>
</div>
</div>
<div id="div_print">
    <div id="header" style="background-color:White;"></div>
    <div id="footer" style="background-color:White;"></div>
</div>
</div>

