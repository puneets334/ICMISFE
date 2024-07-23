<div class="card">
    <div class="card-body" >
        <div id="query_builder_wrapper" class="dataTables_wrapper dt-bootstrap4">

            <?php if(!empty($Elimination_list)):?>
                <table  id="ReportCaveat" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="text-align: center;">Sr.No.</th>
                        <th width="" style="text-align: left;">Diary No</th>
                        <th>List Order</th>
                        <th width="">CauseList</th>
                        <th width="">Name</th>
                        <th width="">Section Name</th>
                        <th> Main Key</th>
                        <th width="">Short description </th>
                        <th>Reg No </th>
                        <th width="">Date</th>
                        <!--<th width="10%">State/Lower Court Information</th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sno = 1;
                    foreach($Elimination_list as $row): //print_r($row); exit;?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= '<b>'.$row->diary_no .'</b>'?></td>
                            <td><?=$row->listorder_new ?></td>

                            <td><?= $row->pet_name ?> Vs. <?= $row->res_name ?></td>
                            <td><?= $row->name?></td>
                            <td><?= $row->section_name?></td>
                            <td><?= $row->main_key ?> </td>
                            <td><?= $row->short_description ?></td>
                            <!-- <td><?= $row->active_fil_no?></td> -->
                            <!-- <td><?= $row->active_reg_year?></td> -->
                            <td><?= $row->reg_no_display?></td>
                            <td><?= $row->date ?></td>
                            

                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>
            <?php else : ?>
                <div class="text-center align-items-center"><i class="fas fa-info"> </i> No Record Found</div>
            <?php endif ?>

        </div>
        <script>

            $(function () {
                $("#ReportCaveat").DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": ["copy", "csv", "excel",{extend: 'pdfHtml5',orientation: 'landscape',pageSize: 'LEGAL' },
                        { extend: 'colvis',text: 'Show/Hide'}],"bProcessing": true,"extend": 'colvis',"text": 'Show/Hide'
                }).buttons().container().appendTo('#query_builder_wrapper .col-md-6:eq(0)');

            });


        </script>
