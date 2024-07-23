<?php  $uri = current_url(true); ?>
<?= view('header') ?>
 
<div class="card">
    <div class="card-body" >
        <div id="query_builder_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <?php
            if(!empty($section_wise_dak_data1)):?>
                <table  id="ReportFileTrap" class="table table-bordered table-striped">
                    <thead>
                    <?php $on_date=$for_date ?>
                    <h3 style="text-align: center;"> Section wise DAK for  <?php echo date('d-m-Y', strtotime($on_date));?></h3>
                    <tr>
                        <th rowspan='1'>SNo.</th>
                        <th rowspan='1'>Sectoin</th>
                        <th rowspan='1'>Total DAK</th>
                    </tr></thead><tbody>
                    <?php $sno = 1;  $total_dak=0; foreach($section_wise_dak_data1 as $row):?>
                        <tr>
                            <td ><?php echo $sno;?></td>
                            <td><?php echo  $row->section; ?></td>
                            <td>
                                <?php
                                $url= base_url().'/index.php/Reports/Filing/Report/getSectionWiseDAKCaseDetails/'.$row->dak_date.'/'.$row->section;
                                if(!empty($is_excluded_flag)) // for casetype exclude
                                {
                                    $url.='/'.$is_excluded_flag;
                                }
                                if(!empty($section)) // for section
                                {
                                    $url.='/'.$section;
                                }
                                //echo $url;
                                ?>
                                <a target="_self" href="<?=$url;?>"><?=$row->total;?></a>
                            </td>
                        </tr>
                    <?php $sno++; $total_dak+=$row->total; endforeach; ?>
                    <tr style="font-weight: bold;"><td colspan="2">Total</td><td><?= $total_dak?></tr>
                    </tbody>
                </table>
            <?php else: { echo "Record Not Found"; } endif; ?>
            <!-- end of fileTrap -->
        </div>
    </div>
</div>
        <script>
            $(function () {
                $("#ReportFileTrap").DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": ["copy", "csv", "excel",{extend: 'pdfHtml5',orientation: 'landscape',pageSize: 'LEGAL' },
                        { extend: 'colvis',text: 'Show/Hide'}],"bProcessing": true,"extend": 'colvis',"text": 'Show/Hide'
                }).buttons().container().appendTo('#query_builder_wrapper .col-md-6:eq(0)');

                });
        </script>
 <?=view('sci_main_footer') ?>
