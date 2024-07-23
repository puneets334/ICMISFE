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
                                    <h3 class="card-title">Judicial > Direct Disposal of Case - Conditional Dispose</h3>
                                </div>
                            
                            </div>
                        </div>
                        <? //view('Filing/filing_breadcrumb'); ?>
                        <!-- /.card-header -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header p-2" style="background-color: #fff;">
                                        
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">
                                                <div class="">
                                                    <div class="">
                                                        <!-- Main content -->
                                                        <section class="content">
                                                            <?php
                                                                $attribute = array('class' => '','name' => '', 'role' => 'form', 'id' => 'disposal-form', 'autocomplete' => 'off');
                                                                echo form_open(base_url(''), $attribute);
                                                            ?>
                                                                <!-- <form role="form" id="disposal-form"> -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" >
                                                                            <div class="col-sm-12 d-flex">
                                                                                <div class="col-sm-2">
                                                                                    <label><input type="radio" id="court_type" name="court_type" value="S" checked />&nbsp;&nbsp;Supreme Court</label>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <label><input type="radio" id="court_type" name="court_type" value="H"/>&nbsp;&nbsp;High Court</label>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <label><input type="radio" id="court_type" name="court_type" value="L"/>&nbsp;&nbsp;&nbsp;District Court</label>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <label><input type="radio" id="court_type" name="court_type" value="A"/>&nbsp;&nbsp;State Agency</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="well">

                                                                            <div class="row">
                                                                                <label class="col-sm-6"><font style="font-weight: bold;font-size: 20px;">Case To Restrict from Listing</font></label>
                                                                                <input type="hidden" name="usercode" id="usercode" value="<?= $user_idd ?>"/>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-sm-1">
                                                                                    <input type="radio" name="rdbt_select_list" id="radiocase_list" value="1" onchange="checkData(this.value);" checked>&nbsp;&nbsp;
                                                                                    <b>Case Detail</b>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="input-group input-group-sm">
                                                                                        <select  class="form-control" id="case_type_list" name="case_type_list" onchange="get_detail('1')">
                                                                                            <?php
                                                                                            echo '<option value="">Select Case Type</option>';
                                                                                            foreach($case_types as $case_type)
                                                                                                echo '<option value="'.$case_type['casecode'].'">'.$case_type['casename'].'</option>';
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="input-group input-group-sm">
                                                                                        <input  type="text" class="form-control" id="case_number_list" name="case_number_list" placeholder="Case number" onchange="get_detail('1')">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="input-group input-group-sm">
                                                                                        <select  class="form-control" id="case_year_list" name="case_year_list" onchange="get_detail('1')">
                                                                                            <?php
                                                                                            echo '<option value="">Select </option>';
                                                                                            for($year=date('Y'); $year>=1950; $year--)
                                                                                                echo '<option value="'.$year.'">'.$year.'</option>';
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-1">
                                                                                    <input type="radio" name="rdbt_select_list" id="radiodiary_list" value="2" onchange="checkData(this.value);">&nbsp;&nbsp;
                                                                                    <b>Diary Detail</b>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="input-group input-group-sm">
                                                                                        <input type="text"  class="form-control" id="diary_number_list" name="diary_number_list"  placeholder="Enter Diary number" onchange="get_detail('2')">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <select  class="form-control" id="diary_year_list" name="diary_year_list" onchange="get_detail('2')">
                                                                                        <?php
                                                                                        echo '<option value="">Select </option>';
                                                                                        for($year=date('Y'); $year>=1950; $year--)
                                                                                            echo '<option value="'.$year.'">'.$year.'</option>';
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <br/>
                                                                            
                                                                            <div class="row">
                                                                                <div class="col-sm-7">
                                                                                    <div class="input-group input-group-sm">
                                                                                        <span class="input-group-addon">Cause Title</span>&nbsp;&nbsp;
                                                                                    <label class="form-control" id="case_title_list" name="case_title_list"></label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <div class="input-group input-group-sm">
                                                                                    <span class="input-group-addon">No. of Connected Matters</span>&nbsp;&nbsp;
                                                                                        <label class="form-control" id="conn_list" name="conn_list"></label>
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" class="form-control" id="case_diary_list" name="case_diary_list">
                                                                            </div>

                                                                            <br/>
                                                                            <div id="div_supremecourt">
                                                                                <div class="row">
                                                                                    <label class="col-sm-6"><font style="font-weight: bold;font-size: 20px;">Case to be Disposed</font></label>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-sm-1">
                                                                                        <input type="radio" name="rdbt_select_disp" id="radiocase_disp" value="3" onchange="checkData(this.value);" checked>&nbsp;&nbsp;
                                                                                        <b>Case Detail</b>
                                                                                    </div>
                                                                                    <div class="col-sm-2">
                                                                                        <div class="input-group input-group-sm">
                                                                                            <select  class="form-control" id="case_type_disp" name="case_type_disp" onchange="get_detail('3')">
                                                                                                <?php
                                                                                                echo '<option value="">Select Case Type</option>';
                                                                                                foreach($case_types as $case_type)
                                                                                                    echo '<option value="'.$case_type['casecode'].'">'.$case_type['casename'].'</option>';
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-2">
                                                                                        <div class="input-group input-group-sm">
                                                                                            <input  type="text" class="form-control" id="case_number_disp" name="case_number_disp" placeholder="Case number" onchange="get_detail('3')">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-2">
                                                                                        <div class="input-group input-group-sm">
                                                                                            <select  class="form-control" id="case_year_disp" name="case_year_disp" onchange="get_detail('3')">
                                                                                                <?php
                                                                                                echo '<option value="">Select </option>';
                                                                                                for($year=date('Y'); $year>=1950; $year--)
                                                                                                    echo '<option value="'.$year.'">'.$year.'</option>';
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-1">
                                                                                        <input type="radio" name="rdbt_select_disp" id="radiodiary_disp" value="4" onchange="checkData(this.value);">&nbsp;&nbsp;
                                                                                        <b>Diary Detail</b>
                                                                                    </div>
                                                                                    <div class="col-sm-2">
                                                                                        <div class="input-group input-group-sm">
                                                                                            <input type="text"  class="form-control" id="diary_number_disp" name="diary_number_disp"  placeholder="Enter Diary number" onchange="get_detail('4')">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-2">
                                                                                        <select  class="form-control" id="diary_year_disp" name="diary_year_disp" onchange="get_detail('4')">
                                                                                            <?php
                                                                                            echo '<option value="">Select </option>';
                                                                                            for($year=date('Y'); $year>=1950; $year--)
                                                                                                echo '<option value="'.$year.'">'.$year.'</option>';
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                    <br/>
                                                                                </div>
                                                                                <br/>

                                                                            <div class="row">
                                                                                <div class="col-sm-7"><div class="input-group input-group-sm"><span class="input-group-addon">Cause Title</span>&nbsp;&nbsp;
                                                                                <label class="form-control" id="case_title_disp" name="case_title_disp"></label></div></div>
                                                                                <div class="col-sm-3"><div class="input-group input-group-sm"><span class="input-group-addon">No. of Connected Matters</span>&nbsp;&nbsp;
                                                                                <label class="form-control" id="conn_disp" name="conn_disp"></label></div></div>
                                                                                <input type="hidden" class="form-control" id="case_diary_disp" name="case_diary_disp"></div>

                                                                            </div>
                                                                            <div id="div_highcourt">
                                                                                <div class="">
                                                                                    <label for="state" id="lbl_state" class=""><font style="font-weight: bold;font-size: 20px;">High Court:</font></label><br/>
                                                                                </div>
                                                                                <div class="row col-sm-12">
                                                                                <div class="col-sm-3">
                                                                                    <div class="input-group input-group-sm">
                                                                                        <select class="form-control" id="state" name="state" onchange="get_HighCourt_bench()" placeholder="state">
                                                                                            <!--<option value="0">All</option>-->
                                                                                            <?php
                                                                                            $states = $a_states;
                                                                                            foreach($states as $state)
                                                                                                echo '<option value="'. $state['id_no'].'" >' . $state['name'] . '</option>';
                                                                                            ?>
                                                                                        </select>
                                                                                        <input type='hidden' id='mystate' value=''>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-sm-6">
                                                                                    <div class="input-group input-group-sm">
                                                                                        <select class="form-control" id="state_bench" name="state_bench" placeholder="state_bench">
                                                                                            <option value="0">No Bench</option>
                                                                                        </select>
                                                                                        <input type='hidden' id='mystate_bench' value=''>
                                                                                    </div>
                                                                                </div>
                                                                                </div><br/><br/>
                                                                                <div class="row col-sm-12">
                                                                                    <div class="">
                                                                                        <label for="state" id="lbl_state" class=""><font style="font-weight: bold;">Case No:</font></label>
                                                                                    </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="input-group input-group-sm">
                                                                                        <select class="form-control" id="case_type" name="case_type" placeholder="case_type">
                                                                                            <option value="0">No Case Type</option>
                                                                                        </select>
                                                                                        <input type='hidden' id='mycase_type' value=''>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-sm-3">
                                                                                    <div class="input-group input-group-sm">
                                                                                        <input type='text' id='h_case_no' name='h_case_no' placeholder="Case Number" class="form-control"/>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-sm-3">
                                                                                    <div class="input-group input-group-sm">
                                                                                        <select  class="form-control" id="h_case_year" name="h_case_year" onchange="get_detail()">
                                                                                            <?php
                                                                                            echo '<option value="">Select</option>';
                                                                                            for($year=date('Y'); $year>=1900; $year--)
                                                                                                echo '<option value="'.$year.'">'.$year.'</option>';
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                                <br/><br/><br/>
                                                                            </div>

                                                                            <div id="div_districtcourt">
                                                                                <div class="row ">
                                                                                    <label for="dstate" id="lbl_dstate" class="col-sm-6"><font style="font-weight: bold;font-size: 20px;">District Court:</font></label><br/>
                                                                                </div>
                                                                                <div class="row col-sm-12">
                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group input-group-sm">
                                                                                            <select class="form-control" id="dstate" name="dstate" onchange="get_DistrictCourt_bench()" placeholder="dstate" required="required">
                                                                                                <!--<option value="0">All</option>-->
                                                                                                <?php
                                                                                                $dstates= $a_states;
                                                                                                foreach($dstates as $dstate)
                                                                                                    echo '<option value="'. $dstate['id_no'].'" >' . $dstate['name'] . '</option>';
                                                                                                ?>
                                                                                            </select>
                                                                                            <input type='hidden' id='mystate' value=''>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-sm-6">
                                                                                        <div class="input-group input-group-sm">
                                                                                            <select class="form-control" id="district" name="district" placeholder="district" required="required">
                                                                                                <option value="0">No District</option>
                                                                                            </select>
                                                                                            <input type='hidden' id='mydistrict' value=''>
                                                                                        </div>
                                                                                    </div>
                                                                                </div><br/><br/>
                                                                                <div class="row col-sm-12">
                                                                                    <div class="">
                                                                                        <label for="d_caseno" id="lbl_d_caseno" class=""><font style="font-weight: bold;">Case No:</font></label>
                                                                                    </div>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group input-group-sm">
                                                                                            <select class="form-control" id="dcase_type" name="dcase_type" placeholder="dcase_type" required="required">
                                                                                                <option value="0">No Case Type</option>
                                                                                            </select>
                                                                                            <input type='hidden' id='mydcase_type' value=''>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group input-group-sm">
                                                                                            <input type='text' id='dcase_no' name='dcase_no' placeholder="Case Number" class="form-control" required="required"/>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group input-group-sm">
                                                                                            <select  class="form-control" id="dcase_year" name="dcase_year" onchange="get_detail()" required="required">
                                                                                                <?php
                                                                                                echo '<option value="">Select</option>';
                                                                                                for($year=date('Y'); $year>=1900; $year--)
                                                                                                    echo '<option value="'.$year.'">'.$year.'</option>';
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <br/><br/><br/>
                                                                            </div>
                                                                            <div id="div_agency">
                                                                                <div class="row ">
                                                                                    <label for="agency" id="lbl_agency" class="col-sm-6"><font style="font-weight: bold;font-size: 20px;">State Agency:</font></label><br/>
                                                                                </div>
                                                                                <div class="row col-sm-12">
                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group input-group-sm">
                                                                                            <select class="form-control" id="a_state" name="a_state" onchange="get_Tribunal_bench(); get_CaseType_Tribunal();" placeholder="a_state">
                                                                                                <!--<option value="0">All</option>-->
                                                                                                <?php
                                                                                                
                                                                                                foreach($a_states as $a_state)
                                                                                                    echo '<option value="'. $a_state['id_no'].'" >' . $a_state['name'] . '</option>';
                                                                                                ?>
                                                                                            </select>
                                                                                            <input type='hidden' id='my$a_state' value=''>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-sm-6">
                                                                                        <div class="input-group input-group-sm">
                                                                                            <select class="form-control" id="tribunal" name="tribunal" placeholder="tribunal">
                                                                                                <option value="0">Agency</option>
                                                                                            </select>
                                                                                            <input type='hidden' id='mytribunal' value=''>
                                                                                        </div>
                                                                                    </div>
                                                                                </div><br/><br/>
                                                                                <div class="row col-sm-12">
                                                                                    <div class="">
                                                                                        <label for="a_caseno" id="lbl_a_caseno" class=""><font style="font-weight: bold;">Case No:</font></label>
                                                                                    </div>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group input-group-sm">
                                                                                            <select class="form-control" id="acase_type" name="acase_type" placeholder="acase_type">
                                                                                                <option value="0">No Case Type</option>
                                                                                            </select>
                                                                                            <input type='hidden' id='myacase_type' value=''>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group input-group-sm">
                                                                                            <input type='text' id='acase_no' name='acase_no' placeholder="Case Number" class="form-control"/>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group input-group-sm">
                                                                                            <select  class="form-control" id="acase_year" name="acase_year" onchange="get_detail()">
                                                                                                <?php
                                                                                                echo '<option value="">Select</option>';
                                                                                                for($year=date('Y'); $year>=1900; $year--)
                                                                                                    echo '<option value="'.$year.'">'.$year.'</option>';
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <br/><br/><br/>
                                                                            </div>
                                                                            <br/>
                                                                            <div id="div_button">
                                                                                <div class="row">
                                                                                    <div class="col-xs-offset-1 col-xs-6 col-xs-offset-3"><button type="button" id="btn-update" class="btn bg-olive btn-flat pull-right" onclick="check_case();"><i class="fa fa-save"></i> Update Case </button></div>
                                                                                </div>
                                                                            </div>

                                                                    </div>
                                                                <!-- </form> -->
                                                            <?php form_close();?>
                                                        </section>

                                                    </div>
                                                    <div>
                                                        <div class="well">
                                                            <div class="box-header">
                                                                <center><h3>Previous Entries</h3></center>
                                                            </div>
                                                            <div class="box-body no-padding">
                                                                <table id="example" class="table table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <td colspan="3"><b><center>Case to Restrict from Listing</center></b></td><td colspan="4"><b><center>Case to Dispose First</center></b></td></tr>
                                                                        <tr>
                                                                            <th style="width: 10px">#</th>
                                                                            <th>Case Number</th>
                                                                            <th>Cause Title</th>
                                                                            <th>DA</th>
                                                                            <th>Case Number</th>
                                                                            <th>Cause Title</th>
                                                                            <th>DA</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    $i=0;
                                                                    foreach($prev_cases as $result)
                                                                    {
                                                                        $i++;
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $i; ?></td>
                                                                            <td><?php echo substr($result['listafter'],0,strlen($result['listafter']) - 4)."/".substr($result['listafter'], - 4)."<br/>". $result['reg_no_after']; ?></td>
                                                                            <td><?php echo $result['title_after']; ?></td>
                                                                            <td><?php echo $result['user_after']."[".$result['section_after']."]"; ?></td>

                                                                            <td><?php echo substr($result['disposefirst'],0,strlen($result['disposefirst']) - 4)."/".substr($result['disposefirst'], - 4)."<br/>". $result['reg_no_first']; ?></td>
                                                                            <td><?php echo $result['title_first']; ?></td>
                                                                            <td><?php echo $result['user_first']."[".$result['section_first']."]"; ?></td>
                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            


                                            <?php //form_close();?>
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

<script>
        
    function updateCSRFToken() {
        $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
        });
    }


    function isEmpty(obj) {
        if (obj == null) return true;
        if (obj.length > 0)    return false;
        if (obj.length === 0)  return true;
        if (typeof obj !== "object") return true;

        // Otherwise, does it have any properties of its own?
        // Note that this doesn't handle
        // toString and valueOf enumeration bugs in IE < 9
        for (var key in obj) {
            if (hasOwnProperty.call(obj, key)) return false;
        }

        return true;
    }
    $(document).ready(function(){


        $("#example").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');

        $('#diary_number_list').prop('disabled', true);
        $('#diary_year_list').prop('disabled', true);
        $('#diary_number_disp').prop('disabled', true);
        $('#diary_year_disp').prop('disabled', true);

        disableAllElements();

        if($("input[name='court_type']:checked").val()=='S'){
            disableAllElements();
            enableElements($('#div_supremecourt').children());
            $('#div_supremecourt').show();
        }

        else if($("input[name='court_type']:checked").val()=='H'){
            disableAllElements();
            enableElements($('#div_highcourt').children());
            $('#div_highcourt').show();
        }
        else if($("input[name='court_type']:checked").val()=='L'){
            disableAllElements();

            enableElements($('#div_districtcourt').children());
            $('#div_districtcourt').show();
        }
        else if($("input[name='court_type']:checked").val()=='A'){
            disableAllElements();

            enableElements($('#div_agency').children());
            $('#div_agency').show();
        }

        $("input[name$='court_type']").click(function() {

            var searchValue = $(this).val();
            if(searchValue=='S')
            {
                disableAllElements();
                enableElements($('#div_supremecourt').children());
                $('#div_supremecourt').show();
            }
            else if(searchValue=='H')
            {
                disableAllElements();
                enableElements($('#div_highcourt').children());
                $('#div_highcourt').show();

            }
            else if(searchValue=='L')
            {
                disableAllElements();

                enableElements($('#div_districtcourt').children());
                $('#div_districtcourt').show();
            }
            else if(searchValue=='A')
            {
                disableAllElements();

                enableElements($('#div_agency').children());
                $('#div_agency').show();
            }
            else
            {
                disableAllElements();
            }


        });
    });

    function checkData($option){
        if($option==1)
        {
            $('#diary_year_list').prop('disabled',true);
            $('#diary_number_list').prop('disabled',true);
            $('#case_number_list').prop('disabled',false);
            //$('#case_number').attr('required', true);
            $('#case_type_list').prop('disabled',false);
            $('#case_year_list').prop('disabled',false);
        }
        else  if($option==2)
        {
            $('#diary_year_list').prop('disabled',false);
            $('#diary_number_list').prop('disabled',false);
            $('#case_number_list').prop('disabled',true);
            $('#case_type_list').prop('disabled',true);
            $('#case_year_list').prop('disabled',true);
        }
        else  if($option==3)
        {
            $('#diary_year_disp').prop('disabled',true);
            $('#diary_number_disp').prop('disabled',true);
            $('#case_number_disp').prop('disabled',false);
            //$('#case_number').attr('required', true);
            $('#case_type_disp').prop('disabled',false);
            $('#case_year_disp').prop('disabled',false);
        }
        else if($option==4)
        {
            $('#diary_year_disp').prop('disabled',false);
            $('#diary_number_disp').prop('disabled',false);
            $('#case_number_disp').prop('disabled',true);
            $('#case_type_disp').prop('disabled',true);
            $('#case_year_disp').prop('disabled',true);
        }
    }

    function get_detail(selected){
       
        updateCSRFToken()

        var option_list=$('input:radio[name=rdbt_select_list]:checked').val();
        var option_disp=$('input:radio[name=rdbt_select_disp]:checked').val();
        var usercode=$('#usercode').val();

        // alert(option_list)
        // alert(option_disp)

        var caseNumber_list=$('#case_number_list').val();
        var caseType_list=$('#case_type_list').val();
        var case_year_list=$('#case_year_list').val();
        var diaryNo_list=$('#diary_number_list').val();
        var diary_year_list=$('#diary_year_list').val();

        var caseNumber_disp=$('#case_number_disp').val();
        var caseType_disp=$('#case_type_disp').val();
        var case_year_disp=$('#case_year_disp').val();
        var diaryNo_disp=$('#diary_number_disp').val();
        var diary_year_disp=$('#diary_year_disp').val();


        // console.log("option_list:: ", option_list)
        // console.log("option_disp:: ", option_disp)
        // console.log("usercode:: ", usercode)
        // console.log("caseNumber_list:: ", caseNumber_list)
        // console.log("caseType_list:: ", caseType_list)
        // console.log("case_year_list:: ", case_year_list)
        // console.log("diaryNo_list:: ", diaryNo_list)
        // console.log("diary_year_list:: ", diary_year_list)
        // console.log("caseNumber_disp:: ", caseNumber_disp)
        // console.log("caseType_disp:: ", caseType_disp)
        // console.log("case_year_disp:: ", case_year_disp)
        // console.log("diaryNo_disp:: ", diaryNo_disp)
        // console.log("diary_year_disp:: ", diary_year_disp)
        // return 

        if( (selected == option_list) && option_list==1 && !isEmpty(caseNumber_list) && !isEmpty(caseType_list) && !isEmpty(case_year_list)){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.post("<?php echo base_url('Judicial/Conditional_Dispose/get_details'); ?>", 
                    {  CSRF_TOKEN: CSRF_TOKEN_VALUE, case_number_list:caseNumber_list, case_type_list:caseType_list, case_year_list:case_year_list }, function (result) {
                var obj =$.parseJSON(result);
                var case_status=obj.case_detail[0]['c_status'];
                if(obj.case_detail==false)
                {
                    alert("The searched case is not found!");
                }else{
                    if(case_status=='P') {
                        if(usercode==obj.case_detail[0]['dacode']) {
                            $('#case_diary_list').val(obj.case_detail[0]['case_diary']);
                            $('#case_title_list').text(obj.case_detail[0]['case_title']);
                            $('#conn_list').text(obj.conn_details[0]['conn']);
                        }
                        else{
                            alert("Only DA is authorized to enter the case for Conditional Dispose");
                            $('#case_type_list').val('');
                            $('#case_number_list').val('');
                            $('#case_year_list').val('');
                            $('#case_diary_list').val('');
                            $('#case_title_list').text('');
                            $('#conn_list').text('');
                        }
                    }else if(case_status=='D'){  
                        if(!alert("The searched case is disposed!")){ 
                            //$('#btn-update').prop('disabled',true);
                            // location.reload();
                            $('#case_type_list').val('');
                            $('#case_number_list').val('');
                            $('#case_year_list').val('');
                            $('#case_diary_list').val('');
                            $('#case_title_list').text('');
                            $('#conn_list').text('');
                        }
                    }

                }
                updateCSRFToken()
            });
        }
        if((selected == option_list) && option_list==2 && !isEmpty(diaryNo_list) && !isEmpty(diary_year_list)){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.post("<?php echo base_url('Judicial/Conditional_Dispose/get_details'); ?>", { CSRF_TOKEN: CSRF_TOKEN_VALUE, diary_number_list:diaryNo_list, diary_year_list:diary_year_list}, function (result) {
                var obj =$.parseJSON(result);
                var case_status=obj.case_detail[0]['c_status'];
                if(obj.case_detail==false){
                    alert("The searched case is not found!");
                }else{
                    if(case_status=='P') {
                        if(usercode==obj.case_detail[0]['dacode']) {
                            $('#case_diary_list').val(obj.case_detail[0]['case_diary']);
                            $('#case_title_list').text(obj.case_detail[0]['case_title']);
                            $('#conn_list').text(obj.conn_details[0]['conn']);
                        }
                        else{
                            alert("Only DA is authorized to enter the case for Conditional Dispose");
                            $('#case_type_list').val('');
                            $('#case_number_list').val('');
                            $('#case_year_list').val('');
                            $('#case_diary_list').val('');
                            $('#case_title_list').text('');
                            $('#conn_list').text('');
                        }
                    }else if(case_status=='D'){
                        if(!alert("The searched case is disposed!")){
                            $('#diary_number_list').val('');
                            $('#diary_year_list').val('');
                            $('#case_diary_list').val('');
                            $('#case_title_list').text('');
                            $('#conn_list').text('');
                        }
                    }
                }
                updateCSRFToken()
            });
        }
        if( (selected == option_disp) && option_disp==3 && !isEmpty(caseNumber_disp) && !isEmpty(caseType_disp) && !isEmpty(case_year_disp)){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.post("<?php echo base_url('Judicial/Conditional_Dispose/get_details'); ?>", { CSRF_TOKEN: CSRF_TOKEN_VALUE, case_number_disp:caseNumber_disp, case_type_disp:caseType_disp, case_year_disp:case_year_disp}, function (result) {
                var obj =$.parseJSON(result);
                var case_status=obj.case_detail[0]['c_status'];
                if(obj.case_detail==false){
                    alert("The searched case is not found!");
                }else{
                    if(case_status=='P') {
                            $('#case_diary_disp').val(obj.case_detail[0]['case_diary']);
                            $('#case_title_disp').text(obj.case_detail[0]['case_title']);
                            $('#conn_disp').text(obj.conn_details[0]['conn']);
                    }
                    else if(case_status=='D'){
                        if(!alert("The searched case is disposed!")){ 
                            //$('#btn-update').prop('disabled',true);
                            // location.reload();
                            $('#case_type_disp').val('');
                            $('#case_number_disp').val('');
                            $('#case_year_disp').val('');
                            $('#case_diary_disp').val('');
                            $('#case_title_disp').text('');
                            $('#conn_disp').text('');
                        }
                    }
                }
                updateCSRFToken()
            });
        }
        if( (selected == option_disp) && option_disp==4 && !isEmpty(diaryNo_disp)&& !isEmpty(diary_year_disp)){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.post("<?php echo base_url('Judicial/Conditional_Dispose/get_details'); ?>", { CSRF_TOKEN: CSRF_TOKEN_VALUE, diary_number_disp:diaryNo_disp, diary_year_disp:diary_year_disp}, function (result) {
                var obj =$.parseJSON(result);
                var case_status=obj.case_detail[0]['c_status'];
                if(obj.case_detail==false){
                    alert("The searched case is not found!");
                }else{
                    if(case_status=='P') {
                        $('#case_diary_disp').val(obj.case_detail[0]['case_diary']);
                        $('#case_title_disp').text(obj.case_detail[0]['case_title']);
                        $('#conn_disp').text(obj.conn_details[0]['conn']);
                    }
                    else if(case_status=='D'){
                        if(!alert("The searched case is disposed!")){
                            $('#diary_number_disp').val('');
                            $('#diary_year_disp').val('');
                            $('#case_diary_disp').val('');
                            $('#case_title_disp').text('');
                            $('#conn_disp').text('');
                        }
                    }
                }
                updateCSRFToken()
            });
        }
    }

    function update_case(){   // alert("inside");
        updateCSRFToken()
        $('#btn-update').prop('disabled',true);
        var list_diary=$('#case_diary_list').val();
        var dispose_diary=$('#case_diary_disp').val();
        var connected=$('#conn_list').text();
        var usercode=$('#usercode').val();
        // alert(list_diary+" "+dispose_diary+" "+connected);
        if(!isEmpty(list_diary) && !isEmpty(dispose_diary)  && !isEmpty(connected) &&!isEmpty(usercode)) {
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.post("<?php echo base_url('Judicial/Conditional_Dispose/update_case'); ?>", {
                CSRF_TOKEN: CSRF_TOKEN_VALUE, 
                list_diary: list_diary,
                dispose_diary: dispose_diary,
                connected: connected,
                usercode:usercode
            }, function (result) {
                if(!alert(result))
                {
                    location.reload();
                }
            });
        }
        else {
            if (!alert("Enter Case Details"))
            {
                $('#case_type_list').focus();
                $('#btn-update').prop('disabled',false);
            }
        }

    }

    function update_case_HighCourt(){
        updateCSRFToken()
        $('#btn-update').prop('disabled',true);
        var list_diary=$('#case_diary_list').val();
        var court_type=$("input[name='court_type']:checked").val();
        var dispose_hCourt='';
        if(court_type =='S')
            var dispose_hCourt=$('#case_diary_disp').val();
        if(court_type=='H')
            dispose_hCourt=$("#state option:selected").val()+'~'+$("#state_bench option:selected").val()+'~'+$("#case_type option:selected").val()+'~'+$("#h_case_no").val()+'~'+$("#h_case_year option:selected").val();
        else if(court_type=='L')
            dispose_hCourt=$("#dstate option:selected").val()+'~'+$("#district option:selected").val()+'~'+$("#dcase_type option:selected").val()+'~'+$("#dcase_no").val()+'~'+$("#dcase_year option:selected").val();
        else if(court_type=='A')
            dispose_hCourt=$("#a_state option:selected").val()+'~'+$("#tribunal option:selected").val()+'~'+$("#acase_type option:selected").val()+'~'+$("#acase_no").val()+'~'+$("#acase_year option:selected").val();
        var connected=$('#conn_list').text();
        var usercode=$('#usercode').val();

        if(!isEmpty(list_diary) && !isEmpty(dispose_hCourt)  && !isEmpty(connected) &&!isEmpty(usercode)) {
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.post("<?=base_url('Judicial/Conditional_Dispose/update_HighCourt_case');?>", {
                CSRF_TOKEN: CSRF_TOKEN_VALUE, 
                list_diary: list_diary,
                dispose_hCourt: dispose_hCourt,
                court_type:court_type,
                connected: connected,
                usercode:usercode
            }, function (result) {
                if(!alert(result)){
                    location.reload();
                }
                updateCSRFToken()
            });
        }
        else {
            if (!alert("Enter Case Details"))
            {
                $('#case_type_list').focus();
                $('#btn-update').prop('disabled',false);
            }
        }

    }

    function check_case() {
        if (check_validation() == true) {
            updateCSRFToken()

            var list_diary = $('#case_diary_list').val();
            var connected = $('#conn_list').text();
            var usercode = $('#usercode').val();
            // alert(list_diary+" "+dispose_diary+" "+connected);
            if (!isEmpty(list_diary) && !isEmpty(connected) && !isEmpty(usercode)) {
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                $.post("<?=base_url('Judicial/Conditional_Dispose/check_case');?>", { CSRF_TOKEN: CSRF_TOKEN_VALUE, list_diary: list_diary}, function (result) {
                    var obj = $.parseJSON(result);
                    //console.log(obj.case_detail);
                    if (Object.keys(obj).length > 0 && obj.case_detail != false) {
                        var court_type = obj.case_detail[0]['court_type'];
                        var hcourt_no = obj.case_detail[0]['hcourt_no'];
                        var after_dispose_case = obj.case_detail[0]['fil_no2'];
                        var ent_dt = obj.case_detail[0]['ent_dt'];
                        var updated_by = obj.case_detail[0]['rgo_updated_by'];
                        var r = confirm("Case already inserted. Do you want to enter new case!");
                        if (r == true) {
                            setTimeout(() => {
                                update_case_HighCourt();
                            }, 300);
                        } else {
                            location.reload();
                        }
                    }else {
                        setTimeout(() => {
                            update_case_HighCourt();
                        }, 300);
                    }
                    updateCSRFToken()
                });
            }
         }

    }

    function get_DistrictCourt_bench() {
        updateCSRFToken()
        var dstate =$("#dstate option:selected").val();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax
        ({
            url: '<?=base_url('Judicial/Conditional_Dispose/get_District_State');?>',
            type: "POST",
            data: { CSRF_TOKEN: CSRF_TOKEN_VALUE, dstate:dstate},
            cache: false,
            dataType:"json",
            success: function(data)
            {
                console.log(data);
                console.log(data.length);
                var options = '';
                if(data==false)
                    options = '<option value="0">No District</option>';
                else {
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].id + '">' + data[i].agency_name + '</option>';
                    }
                }
                $("#district").html(options);

                updateCSRFToken()
                setTimeout(() => {
                    get_CaseType_DistrictCourt();
                }, 500);
            },
            error: function () {
                alert('ERRO');
            }
        });

    }

    function get_HighCourt_bench() {
        updateCSRFToken()
        var state =$("#state option:selected").val();
        var agency_court=1;
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax
        ({
            url: '<?=base_url('Judicial/Conditional_Dispose/get_HighCourt_State_bench');?>',
            type: "POST",
            data: { CSRF_TOKEN: CSRF_TOKEN_VALUE, state:state,agency_court:agency_court},
            cache: false,
            dataType:"json",
            success: function(data)
            {
                console.log(data);
                console.log(data.length);
                var options = '';
                if(data==false)
                    options = '<option value="0">No Bench</option>';
                else {
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].id + '">' + data[i].agency_name + '::' + data[i].short_agency_name + '</option>';
                    }
                }
                $("#state_bench").html(options);

                updateCSRFToken()

                setTimeout(() => {
                    get_CaseType_HighCourt();
                }, 500);
            },
            error: function () {
                alert('ERRO');
            }
        });

    }

    function get_Tribunal_bench() {
        updateCSRFToken()
        var a_state =$("#a_state option:selected").val();
        var agency_court=2;
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax
        ({
            url: '<?=base_url('Judicial/Conditional_Dispose/get_HighCourt_State_bench');?>',
            type: "POST",
            data: { CSRF_TOKEN: CSRF_TOKEN_VALUE, state:a_state,agency_court:agency_court},
            cache: false,
            dataType:"json",
            success: function(data)
            {
                console.log(data);
                console.log(data.length);
                var options = '';
                if(data==false)
                    options = '<option value="0">No Bench</option>';
                else {
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].id + '">' + data[i].agency_name + '::' + data[i].short_agency_name + '</option>';
                    }
                }
                $("#tribunal").html(options);
            },
            error: function () {
                alert('ERRO');
            }
        });

    }

    function get_CaseType_HighCourt() {
        updateCSRFToken()
        var state =$("#state option:selected").val();
       // var a_state=$("#a_state option:selected").val();
        var court_type= 'H';
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax
        ({
            url: '<?=base_url('Judicial/Conditional_Dispose/get_CaseType_State_bench');?>',
            type: "POST",
            data: { CSRF_TOKEN: CSRF_TOKEN_VALUE, state:state,court_type:court_type},
            cache: false,
            dataType:"json",
            success: function(data)
            {
                console.log(data);
                console.log(data.length);
                var options = '';
                if(data==false)
                    options = '<option value="0">Select</option>';

                else {
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].lccasecode + '">' + data[i].lccasename + '</option>';
                    }
                }
                $("#case_type").html(options);
            },
            error: function () {
                alert('ERRO');
            }
        });

    }

    function get_CaseType_DistrictCourt() {
        updateCSRFToken()
        var dstate =$("#dstate option:selected").val();
        // var a_state=$("#a_state option:selected").val();
        var court_type= 'L';
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax
        ({
            url: '<?=base_url('Judicial/Conditional_Dispose/get_CaseType_State_bench');?>',
            type: "POST",
            data: { CSRF_TOKEN: CSRF_TOKEN_VALUE, state:dstate,court_type:court_type},
            cache: false,
            dataType:"json",

            success: function(data)
            {
                console.log(data);
                console.log(data.length);
                var options = '';
                if(data==false)
                    options = '<option value="0">Select</option>';

                else {
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].lccasecode + '">' + data[i].lccasename + '</option>';
                    }
                }
                $("#dcase_type").html(options);
            },
            error: function () {
                alert('ERRO');
            }
        });

    }

    function get_CaseType_Tribunal() {
        updateCSRFToken()
        var a_state=$("#a_state option:selected").val();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax
        ({
            url: '<?=base_url('Judicial/Conditional_Dispose/get_CaseType_Tribunal');?>',
            type: "POST",
            data: { CSRF_TOKEN: CSRF_TOKEN_VALUE, state:a_state},
            cache: false,
            dataType:"json",

            success: function(data)
            {
                console.log(data);
                console.log(data.length);
                var options = '';
                if(data==false)
                    options = '<option value="0">Select</option>';

                else {
                    for (var i = 0; i < data.length; i++) {

                        options += '<option value="' + data[i].lccasecode + '">' + data[i].lccasename + '</option>';

                    }
                }

                $("#acase_type").html(options);
            },
            error: function () {
                alert('ERRO');
            }
        });

    }

    function disableAllElements(){
        disableElements($('#div_supremecourt').children());
        $('#div_supremecourt').hide();


        disableElements($('#div_highcourt').children());
        $('#div_highcourt').hide();

        disableElements($('#div_districtcourt').children());
        $('#div_districtcourt').hide();

        disableElements($('#div_agency').children());
        $('#div_agency').hide();

    }

    function enableAllElements(){
        enableElements($('#div_supremecourt').children());
        $('#div_supremecourt').show();

        enableElements($('#div_highcourt').children());
        $('#div_highcourt').show();

        enableElements($('#div_districtcourt').children());
        $('#div_districtcourt').show();

        enableElements($('#div_agency').children());
        $('#div_agency').show();

    }

    function disableElements(el) {
        for (var i = 0; i < el.length; i++) {
            el[i].disabled = true;
            disableElements(el[i].children);
        }
        //el.hide();
    }

    function enableElements(el) {
        for (var i = 0; i < el.length; i++) {
            el[i].disabled = false;
            enableElements(el[i].children);
        }
    }

    function check_validation(){
        // debugger;
        var court_type=$("input[name='court_type']:checked").val();
        var list_diary=$('#case_diary_list').val();
        if(list_diary=='' || list_diary==null)
        {
            alert("Please enter case to be restrict from listing.");
            return false;
        }
        if(court_type=='S')
        {
            var disp_diary=$('#case_diary_disp').val();
            if(disp_diary=='' || disp_diary==null)
            {
                alert("Please enter case to be Disposed");
                return false
            }
        }
        else if(court_type=='H')
        {

            var h_case_no=$('#h_case_no').val();
            var h_case_year= $("#h_case_year option:selected").val();
            if((h_case_no=='' || h_case_no==null) || h_case_year=='')
            {
                alert("Please enter High Court case details.");
                return false;
            }

        }
        else if(court_type=='L')
        {
            var dcase_no=$('#dcase_no').val();
            var dcase_year= $("#dcase_year option:selected").val();

            if((dcase_no=='' || dcase_no==null) || dcase_year=='')
            {
                alert("Please enter District Court case details.");
                return false;
            }
        }
        else if(court_type=='A')
        {
            var acase_no=$('#acase_no').val();
            var acase_year= $("#acase_year option:selected").val();

            if((acase_no=='' || acase_no==null) || acase_year=='')
            {
                alert("Please enter State Agency case details.");
                return false;
            }
        }
           return true;
    }

</script>


 <?=view('sci_main_footer') ?>