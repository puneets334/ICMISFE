<?=view('header'); ?>
 
<style>
    .row {
        margin-right: 15px;
        margin-left: 15px;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header heading">
                        <div class="row">
                            <div class="col-sm-10"> <h3 class="card-title">Filing >> Master</h3> </div>
                            <div class="col-sm-2"></div>
                        </div>
                    </div>
                    <?=view('Filing/Master/filing_master_breadcrumb');?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <span class="alert-danger"><?=\Config\Services::validation()->listErrors()?></span>

                                    <?php if(session()->getFlashdata('error')){ ?>
                                        <div class="alert alert-danger text-white ">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <?= session()->getFlashdata('error')?>
                                        </div>
                                    <?php } else if(session("message_error")){ ?>
                                        <div class="alert alert-danger">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <?=session()->getFlashdata("message_error")?>
                                        </div>
                                    <?php } else if(session("message_success")){ ?>
                                        <div class="alert alert-success">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <?=session()->getFlashdata("message_success")?>
                                        </div>
                                    <?php }else{?>
                                        <br/>
                                    <?php }?>

                                    <?php  //echo $_SESSION["captcha"];
                                    $attribute = array('class' => 'form-horizontal','name' => 'diary_search', 'id' => 'diary_search', 'autocomplete' => 'off');
                                    echo form_open(base_url('Filing/Master/DistrictMaster/'), $attribute);
                                    ?>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-4 diary_section">
                                            <div class="form-group row">
                                                <label for="state_id" class="col-sm-4 col-form-label">State<span class="text-red">*</span> :</label>
                                                <div class="col-sm-8">
                                                    <select name="state_id" id="state_id" class="custom-select" required>
                                                        <option value=" ">Select a option</option>
                                                        <?php
                                                        foreach ($state_list as $row) {?>
                                                            <option value="<?php echo $row['state_code'] ?>" <?php if(!empty($param) && $row['state_code']==$param['state_id']) { ?> selected="selected" <?php } ?>><?php echo strtoupper($row['agency_state']); ?></option>

                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                      <div class="col-md-4 diary_section">
                                            <div class="form-group row">
                                                <label for="district_name" class="col-sm-4 col-form-label">District Name<span class="text-red">*</span> :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="district_name" name="district_name" value="<?php if(!empty($param) && $param['district_name']) { echo $param['district_name']; } ?>" onkeyup="this.value=this.value.replace(/[^a-z,^A-Z\s]/g,'');" placeholder="Enter district name" required>
                                                </div>
                                            </div>
                                        </div>





                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <?php form_close();?>


                                    <div id="query_builder_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                        <table id="datatable" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>District Name</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i=1;  foreach($data_list as $row) {?>
                                                <tr>
                                                    <td><?=$i++;?></td>
                                                    <td><?=$row['name'];?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <script>
        $(function () {
            $("#datatable").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel",{extend: 'pdfHtml5',orientation: 'landscape',pageSize: 'LEGAL' },
                    { extend: 'colvis',text: 'Show/Hide'}],"bProcessing": true,"extend": 'colvis',"text": 'Show/Hide'
            }).buttons().container().appendTo('#query_builder_wrapper .col-md-6:eq(0)');

        });

    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.search_type', function() {
            //alert('dddd');
            var search_type = $("input[name=search_type]:checked").val();
            if (search_type=='C'){
                $('.casetype_section').show();
                $('.diary_section').hide();
            }else {
                $('.casetype_section').hide();
                $('.diary_section').show();
            }
            //alert('search_type='+search_type);
        });
        });
        </script>
 <?=view('sci_main_footer');?>