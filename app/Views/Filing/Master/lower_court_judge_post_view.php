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
                                    echo form_open(base_url('Filing/Master/LowerCourtJudgePost/'), $attribute);
                                    ?>

                                    <div class="row">
                                        <div class="col-md-1"></div>

                                      <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="designation" class="col-sm-4 col-form-label">Designation<span class="text-red">*</span> :</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="designation" name="designation" value="<?php if(!empty($param) && $param['designation']) { echo $param['designation']; } ?>" onkeyup="this.value=this.value.replace(/[^a-z,^A-Z,&()-/.\s]/g,'');" placeholder="Enter designation" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary" id="submit">Add</button>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>

                                    <?php form_close();?>
                                    <div id="query_builder_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                    <table id="datatable" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Post Code</th>
                                            <th>Designation Name</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=1;  foreach($data_list as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$row['post_code'];?></td>
                                            <td><?=$row['post_name'];?></td>
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
 <?=view('sci_main_footer');?>