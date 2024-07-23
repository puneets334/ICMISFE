<hr/>
<div class="row">
    <div class="col-12">
        <center><h3>Supreme Court of India</h3></center>
        <?php $check_for_regular_case="";
        if (!empty($dno_data)) { $sno = 0;?>
            <center><h4> <p><b class="pdiv">Diary No. - </b> <?=substr($dno_data['diary_no'], 0, -4).' - '.substr($dno_data['diary_no'],-4);?></p></h4> </center>

            <?php if (!empty($row_fl)){ ?>

                <?php if (!empty($result)){
                    $grp_pet_res = '';
                    $pet_name = $res_name = "";
                    $temp_var = "";
                    if (!empty($result)) {

                        foreach ($result as $row) {
                            $temp_var = "";
                            $temp_var .= $row['partyname'];
                            if ($row['sonof'] != '') {
                                $temp_var .= $row['sonof'] . "/o " . $row['prfhname'];
                            }
                            if ($row['deptname'] != "") {
                                $temp_var .= "<br>Department : " . $row['deptname'];
                            }
                            $temp_var .= "<br>";
                            if ($row['addr1'] == ''){
                                $temp_var .= $row['addr2'];
                            }else{
                                $temp_var .= $row['addr1'] . ', ' . $row['addr2'];
                            }

                            if (!empty($row['state']) && !empty($row['city'])){
                                $district = is_data_from_table('master.state', ['state_code' => $row['state'],'district_code' => $row['city'],'sub_dist_code' => 0,'village_code' => 0, 'display' => 'Y'],'name','R');
                                if (!empty($district)){
                                    if (!empty($district['name'])){
                                        $temp_var .= ", District : " . $district['name'];
                                    }
                                }

                            }

                            if ($row['pet_res'] == 'P') {
                                $pet_name = $temp_var;
                            } else {
                                $res_name = $temp_var;
                            }

                        }
                    }
                } ?>


            <?php }?>


            <h4> <b>Case Details</b></h4><br/>
            <div class="row">

                <div class="col-sm-1"></div>
                <div class="col-sm-8" style="text-align: left !important;">
                    <?php  $t_fil_no=get_case_nos($diary_no,'&nbsp;&nbsp;'); ?>
                    <p><b class="pdiv">Case No. : </b> <?=$t_fil_no;?></p>
                    <p><b class="pdiv">Cause Title : </b> <?=$dno_data['pet_name'].'  <b>Vs</b>  '.$dno_data['res_name'];?></p>
                    <p><b class="pdiv">Registration No. : </b> <?=$dno_data['reg_no_display'];?></p>
                    <p><b class="pdiv">Status. :</b> <?php if($dno_data['c_status']=='D'){echo 'Disposed';}else{echo 'Pending';} ?></p>
                </div>

                <br/>
            </div>


        <?php } else { ?>
            <div class="alert alert-danger">
                <strong>Fail!</strong> No disposed IA(s) found.
            </div>
        <?php }?>


    </div>
</div>
