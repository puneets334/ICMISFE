<?= view('header') ?>
 
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header heading">

                            <div class="row">
                                <div class="col-sm-10">
                                    <h3 class="card-title">Coram</h3>
                                </div>
                                <div class="col-sm-2">
                                    <div class="custom_action_menu">
                                        <a href="<?= base_url() ?>/Filing/Diary"><button class="btn btn-success btn-sm" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button></a>
                                        <a href="<?= base_url() ?>/Filing/Diary/search"><button class="btn btn-primary btn-sm" type="button"><i class="fas fa-pen  " aria-hidden="true"></i></button></a>
                                        <a href="<?= base_url() ?>/Filing/Diary/deletion"><button class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?=view('Coram/coram_breadcrumb'); ?>
                        <!-- /.card-header -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header p-2" style="background-color: #fff;">                                        
                                        <?php
                                            $attribute = array('class' => 'form-horizontal', 'name' => 'coram', 'id' => 'coram', 'autocomplete' => 'off');
                                            echo form_open('#', $attribute);

                                        ?>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">

                                            <div class="active tab-pane">
                                                <h3 class="basic_heading"> Judge Not go before Department MODULE </h3><br>
                                            <div class="row ">

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Judge</label>
                                                        <div class="col-sm-10">
                                                            <select id="judge" name="judge" class="custom-select rounded-0">
                                                                <option value="">Select Judge</option>
                                                                <?php foreach($judge_list as $judge_val): ?>
                                                                    <option value="<?php echo $judge_val['jcode'];?>"><?php echo $judge_val['jname'];?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Department</label>
                                                        <div class="col-sm-10">
                                                            <select id="dept" name="dept" class="custom-select rounded-0">
                                                                <option value="">Select</option>
                                                                <?php foreach($get_department as $get_department_val): ?>
                                                                    <option value="<?php echo $get_department_val['deptcode']?>"><?php echo $get_department_val['deptname']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <center><input type="button" name="btngetr" id="btngetr" class="btn btn-primary" value="Submit"></center>
                                                </div>
                                            </div>
                                            </div>

                                            <hr><br>
                                            <div id class="">
                                                <h3 class="basic_heading"> DEPARTMENT CASES NOT GO BEFORE JUDGE<br>(As on <?php echo date('d-m-Y');?>) </h3><br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table id="example1" class="table table-hover showData">
                                                            <thead>
                                                              <tr>
                                                                <th>Action</th>
                                                                <th>SrNo.</th>
                                                                <th>Judge</th>
                                                                <th>Department</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                              <?php
                                                                $sno = 1;
                                                                foreach($get_ntl_judge_dept as $get_ntl_judge_dept_val):

                                                                    $sno1 = $sno % 2;
                                                                    $jd_adv = $get_ntl_judge_dept_val['org_judge_id']."_".$get_ntl_judge_dept_val['dept_id'];
                                                                ?>  
                                                                  <tr>
                                                                    <td><a onclick="javascript:deleteRecord('<?php echo $jd_adv; ?>')" href="javascript:void(0)"><button class="btn btn-danger btn-sm" type="button"><i class="fas fa-trash" aria-hidden="true"></i></button></a></td>
                                                                    <td><?php echo $sno; ?></td>
                                                                    <td><?php echo $get_ntl_judge_dept_val['jname']; ?></td>
                                                                    <td><?php echo $get_ntl_judge_dept_val['deptname']; ?></td>
                                                                  </tr>
                                                              <?php $sno++; endforeach; ?>
                                                            </tbody>
                                                          </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.tab-content -->
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
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
    <!-- /.content -->


    <script type="text/javascript">

        $(document).on("click","#btngetr",function(){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var csrf = $("input[name='CSRF_TOKEN']").val();

            var judge = $("#judge").val();
            var dept = $("#dept").val();

            if(judge == 0){
                alert("Please Select Judge Name")
                $("#judge").focus()
                return false
            }
            if(dept == 0){
                alert("Please Select Department")
                $("#dept").focus()
                return false
            }

            $.ajax({
                url:"<?php echo base_url('Coram/Dept/insert_dept/');?>",
                type: "post",
                data: {CSRF_TOKEN:csrf,judge: judge,dept:dept},
                success:function(result){
                    alert(result);
                    updateCSRFToken();
                    window.location.href='';
                },
                error: function () {
                    alert('Error while saving data.');
                    updateCSRFToken();
                }
            });
        });

        function deleteRecord(dno){

            var CSRF_TOKEN = 'CSRF_TOKEN';
            var csrf = $("input[name='CSRF_TOKEN']").val();

            var r = confirm("Are you Sure, Record to be Delete.");
            if(r == true){
                $.ajax({
                    url:"<?php echo base_url('Coram/Dept/ntl_judge_dept_delete_response/');?>",
                    type: "post",
                    data: {CSRF_TOKEN:csrf,dno: dno},
                    success:function(result){
                        if(result==1){
                            alert('Deleted Successfully');
                            window.location.href='';
                        }else{
                            alert('Not Deleted');
                            window.location.href='';
                        }
                        updateCSRFToken();
                    },
                    error: function () {
                        alert('Error while saving data.');
                        updateCSRFToken();
                    }
                });
            }
        }

        $(function () {
            $("#example1").DataTable({
              "responsive": true, "lengthChange": false, "autoWidth": false,
              "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });


    </script>


 <?=view('sci_main_footer') ?>