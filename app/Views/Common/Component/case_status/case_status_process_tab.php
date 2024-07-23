

    <!--<h5 align="center">Diary No.-  - </h5>
    <h5 align="center"> vs. </h5>-->

    <input type="hidden" name="diaryno1" id="diaryno1" value="<?php echo $diary_number;?>">
    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
    <div class="row" style="margin-left: 1%">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs text-lg bg-success">
                <li class="active"><a href="101" data-parent="#accordion1" data-toggle="tab" aria-expanded="false"><strong>Case Details</strong></a></li><li class=""><a href="102" data-parent="#accordion1" data-toggle="tab" aria-expanded="false"><strong>Earlier Court Details</strong></a></li>                        <li class=""><a href="103" data-parent="#accordion1" data-toggle="tab" aria-expanded="true"><strong>Tagged Matters</strong></a></li>                        <li class=""><a href="104" data-parent="#accordion1" data-toggle="tab" aria-expanded="true"><strong>Listing Dates</strong></a></li>                        <li class=""><a href="105" data-parent="#accordion1" data-toggle="tab" aria-expanded="true"><strong>Interlocutory Application / Documents</strong></a></li>                        <li class=""><a href="106" data-parent="#accordion1" data-toggle="tab" aria-expanded="true"><strong>Court Fees</strong></a></li>                        <li class=""><a href="107" data-parent="#accordion1" data-toggle="tab" aria-expanded="true"><strong>Notices</strong></a></li>                        <li class=""><a href="108" data-parent="#accordion1" data-toggle="tab" aria-expanded="true"><strong>Defects</strong></a></li>                        <li class=""><a href="109" data-parent="#accordion1" data-toggle="tab" aria-expanded="true"><strong>Judgement/Orders</strong></a></li>                        <li class=""><a href="110" data-parent="#accordion1" data-toggle="tab" aria-expanded="true"><strong>Mention Memo</strong></a></li>                        <li class=""><a href="111" data-parent="#accordion1" data-toggle="tab" aria-expanded="true"><strong>Restoration Details</strong></a></li>                        <li class=""><a href="112" data-parent="#accordion1" data-toggle="tab" aria-expanded="true"><strong>DropNote</strong></a></li>                        <li class=""><a href="113" data-parent="#accordion1" data-toggle="tab" aria-expanded="true"><strong>Appearance</strong></a></li>                        <li class=""><a href="114" data-parent="#accordion1" data-toggle="tab" aria-expanded="true"><strong>Office Report</strong></a></li>                        <li class=""><a href="115" data-parent="#accordion1" data-toggle="tab" aria-expanded="true"><strong>Similarities</strong></a></li>                        <li class=""><a href="116" data-parent="#accordion1" data-toggle="tab" aria-expanded="true"><strong>Caveat</strong></a></li>                        <li class=""><a href="117" data-parent="#accordion1" data-toggle="tab" aria-expanded="true"><strong>Gate Information</strong></a></li>
            </ul>
            <div class="tab-content">
                <div id="caseSearchPanel"></div>
                <div class="tab-pane active" id="part1">
                    <br>
                    <div class="col-md-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div align="left">
        <input type="button" id="btn" value="Print" onclick="printDiv();">
    </div>

    <div id="divPrint">
        <h5 align="center" style="color:green;">Diary No.- <?php echo substr($diary_details['diary_no'],0,-4).' - '.substr($diary_details['diary_no'],-4); ?>                  <!--<img src="../images/qr-code.png" width="40px" height="40px" align="right" id="myBtn"style="cursor: pointer;margin-right:20px;">-->

            <div id="myModal" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">×</span>
                    </div>
                    <div class="modal-body">
                        <object id="qr-object" data="" width="100%" height="100%"></object>
                    </div>
                </div>
            </div>
        </h5><?//print_r($diary_details);?>
        <h5 align="center"><?php echo $diary_details['pet_name'].' <span style="color:red;">vs</span> '.$diary_details['res_name']?></h5>

        <h5 align="right">                 </h5>
        <div id="collapse118">
            <div id="result118"></div>

        </div>
        <div id="caseDetails"><table border="0" align="left" width="100%" class="table table-bordered table-striped"><tbody>
                <?php if(!empty($filing_stage) && $diary_details['c_status']!='D'):?>
                <tr>
                    <td width="140px">Filing Stage</td>
                    <td><div width="100%"><font color="#006400" style="font-size:12px;font-weight:bold;"><?php echo $filing_stage?></font> </div></td>
                </tr>
                <?php endif;?>
                <tr>
                    <?php

                    $diary_recieved_date = date_create($diary_details['diary_no_rec_date']);
                    $diary_recieved_date= date_format($diary_recieved_date, "d-m-Y h:i A");
                    $u_name = $last_updated_by=$act_sec_des = $act_section = $act_sec_des=$sect ="";
                    if(!empty($diary_section_details['section_name'])){
                        $d_name = "<font color='blue'>" . $diary_section_details["name"] . " [" . $diary_section_details["section_name"] . "]</font>";
                        $u_name = " by <font color='blue'>" . $diary_section_details["name"] . "</font>";
                        $u_name .= "<font> [SECTION: </font><font color='red'>" . $diary_section_details["section_name"] . "</font><font style='font-size:12px;font-weight:bold;'>]</font>";
                    }
                    if (!empty($main_case))
                        $main_case = "<br>&nbsp;&nbsp;<font color='red' >[Connected with : " . $main_case . "</font>]";

                    if ($diary_details['if_sclsc'] == 1)
                        $status = 'SCLSC ';
                    elseif ($diary_details['nature'] == 6)
                        $status = 'JAIL PETITION ';
                    else
                        $status = '';

                    if(!empty($no_of_defect_days['no_of_days']) && $no_of_defect_days['no_of_days'] < 90 ){
                        $status .= "Cases under Defect List valid for 90 Days";
                        $main_status = "<div style='float:right;text-align:center;padding-right:5px;'><span class='blink_me'><font color='red' style='font-size:20px;font-weight:bold;'>" . $status . "</font></span></div>";
                    }elseif (!empty($no_of_defect_days['no_of_days']) && $no_of_defect_days['no_of_days'] >= 90) {
                        $status .= "Defective Matters Not Re-filed after 90 Days";
                        $main_status = "<div style='float:right;text-align:center;padding-right:5px;'><span class='blink_me'><font color='red' style='font-size:20px;font-weight:bold;'>" . $status . "</font></span></div>";
                    }else if ($diary_details['c_status'] == 'P') {
                        if($recalled_matters != '"false"'){
                            $status .= "PENDING(RECALLED)";
                            $main_status = "<div style='float:right;text-align:center;padding-right:5px;'><span class='blink_me'><font color='red' style='font-size:20px;font-weight:bold;'>" . $status . "</font></span></div>";
                        }else{
                            $status .= "PENDING";
                            $main_status = "<div style='float:right;text-align:center;padding-right:5px;'><span class='blink_me'><font color='blue' style='font-size:20px;font-weight:bold;'>" . $status . "</font></span></div>";
                        }
                    }

                    if ($diary_details['c_status'] == 'D') {
                        $status .= "DISPOSED";
                        $main_status = "<div style='float:right;text-align:center;padding-right:5px;'><span class='blink_me'><font color='red' style='font-size:20px;font-weight:bold;'>" . $status . "</font></span></div>";
                    }
                   $consign_status=$efiled_status='';
                    if(!empty($consignment_status)) {
                        foreach ($consignment_status as $row_consigned) {
                            $consignment_date = date_create($row_consigned['consignment_date']);
                            $consignment_date= date_format($consignment_date, "d-m-Y");

                            $consign_status = "<span style='float:right;text-align:center;padding-right:5px;padding-right:10px;'><span class='blink_me'><font color='red' style='font-size:15px;font-weight:bold;'>Consigned On : " .$consignment_date . "</font></span></span>";
                        }
                    }
                    if($diary_details['ack_id']>0 || !empty($efiled_cases)){
                        $efiled_status = "<span style='float:right;text-align:center;padding-right:5px;padding-right:10px;'><span class='blink_me'><font color='red' style='font-size:15px;font-weight:bold;'>E-Filed Matter</font></span></span>";
                    }

                    if (!empty($acts_sections)) {

                        foreach ($acts_sections as $act_section_array) {
                            if ($act_section_array['section'] != '')
                                $t_as = $act_section_array['act_name'] . '-' . $act_section_array['section'];
                            else
                                $t_as = $act_section_array['act_name'];

                            $act_sec_des .= $act_section_array['act_name'];


                            if ($act_section == '')
                                $act_section = $t_as;
                            else
                                $act_section = $act_section . ', ' . $t_as;
                        }
                        $act_sec_des = rtrim($act_sec_des, ',');
                        $act_sec_des = trim($sect) . ' ' . $act_sec_des;
                    }

                    ?>
                    <td width="140px">Diary No.</td>
                    <td><div width="100%"><font color="blue" style="font-size:12px;font-weight:bold;"><?php echo substr($diary_details['diary_no'],0,-4).'/'.substr($diary_details['diary_no'],-4); ?></font> Received on <?php echo $diary_recieved_date;?> <?php echo $u_name . $main_case . $main_status . $consign_status .$efiled_status ?></td></tr><tr>
                    <td width="140px">Case No.</td>
                    <td><div width="100%"><font color="#043fff" style=" white-space: nowrap;">SLP(Crl) No. 001110 / 2023</font>&nbsp;&nbsp;(Reg.Dt.21-01-2023)<br></div></td></tr>
                    <tr>
                    <td width="140px">IB- DA Name</td>
                    <td><?php echo $IB_da_name;?></td></tr><tr>
                    <tr>
                    <td width="140px">Section -  DA Name</td>
                    <td><?php echo $section_da_name;?></td></tr><tr>
                    <td width="140px">Last Updated By</td>
                    <td style="font-size:12px;font-weight:100;"><?php echo $last_updated_by?></td></tr><tr>
                    <td width="140px">Last Listed On</td>
                    <td style="font-size:12px;font-weight:bold;"><b>-----</b></td></tr><tr>
                    <td width="140px">Last Order</td>
                    <td style="font-size:12px;font-weight:100;"></td></tr><tr>
                    <td width="140px">Status</td>
                    <td style="font-size:12px;font-weight:100;"><font color="red" style="font-size:12px;font-weight:100;"></font></td></tr><tr>
                    <td width="140px">Disp.Type</td>
                    <td style="font-size:12px;font-weight:100;"><font color="red" style="font-size:12px;font-weight:100;"></font></td></tr><tr>
                    <td width="140px">Stage</td><td style="font-size:12px;font-weight:100;"></td></tr><tr>
                    <td width="140px">Statutory Info.</td>
                    <td style="font-size:12px;font-weight:100;"></td></tr><tr>
                    <td width="140px">Bench</td>
                    <td></td></tr><tr>
                    <td width="140px">Old Category</td>
                    <td><?php echo $old_category_name;?></td></tr><tr>
                    <td width="140px"><font color="red">New Category</font></td>
                    <td><font color="red"></font></td></tr><tr>
                    <td width="140px">Act</td>
                    <td><?php echo $act_section;?>
                    </td></tr><tr>
                    <td width="140px">Petitioner(s)</td>
                    <td><?php echo $petitioner_name;?>      </td></tr><tr>
                    <td width="140px">Respondent(s)</td>
                    <td><?php echo $respondent_name;?></td></tr><tr>
                    <td width="140px">Impleader(s)</td>
                    <td><?php echo $impleader;?></td></tr><tr>
                    <td width="140px">Intervenor(s)</td>
                    <td><?php echo $intervenor;?></td></tr><tr>
                    <td width="140px">Amicus Curie(For Court Assistance)</td>
                    <td><?php echo $ac_court;?></td></tr><tr>
                    <td width="140px">Pet. Advocate(s)</td>
                    <td><?php echo $padvname;?></td></tr><tr>
                    <td width="140px">Resp. Advocate(s)</td>
                    <td><?php echo $radvname;?></td></tr><tr>
                <?php  if ($iadvname != '') {?>
                <tr>
                    <td width="140px">Impleaders Advocate(s)</td>
                    <td><?php echo $iadvname;?></td></tr><tr>
        <?php } if ($nadvname != '') {?>
                    <tr>
                    <td width="140px">Intervenor Advocate(s)</td>
                    <td><?php echo $nadvname;?></td></tr><tr>
<?php }?>
                    <td width="140px">U/Section</td>
                    <td><?php echo $act_sec_des;?>
                    </td></tr>
                <?php if(!empty($file_movement_data)){
                        ?>
                <tr><td width="140px">File Movement</td><td><table class="table_tr_th_w_clr c_vertical_align" width="100%"><tbody>
                            <tr><th align="center"><b>Dispatch By</b></th><th><b>Dispatch On</b></th><th><b>Remarks</b></th><th><b>Dispatch to</b></th><th align="center"><b>Receive by</b></th><th align="center"><b>Receive On</b></th><th><b>Completed On</b></th></tr>
                          <?php  foreach($file_movement_data as $fil_mov_r){
                              if ($fil_mov_r['comp_dt'] == '' || $fil_mov_r['comp_dt'] == null || $fil_mov_r['comp_dt'] == "0000-00-00 00:00:00")
                                  $fil_mov_r['comp_dt'] = "0000-00-00 00:00:00";
                              else
                                  $fil_mov_r['comp_dt'] = date('d-m-Y h:i:s A', strtotime($fil_mov_r['comp_dt']));
                              if ($fil_mov_r['rece_dt'] == '' || $fil_mov_r['rece_dt'] == null || $fil_mov_r['rece_dt'] == "0000-00-00 00:00:00")
                                  $fil_mov_r['rece_dt'] = '0000-00-00 00:00:00';
                              else
                                  $fil_mov_r['rece_dt'] = date('d-m-Y h:i:s A', strtotime($fil_mov_r['rece_dt']));
                              if ($fil_mov_r['disp_dt'] == '' || $fil_mov_r['disp_dt'] == null || $fil_mov_r['disp_dt'] == "0000-00-00 00:00:00")
                                  $fil_mov_r['disp_dt'] = '0000-00-00 00:00:00';
                              else
                                  $fil_mov_r['disp_dt'] = date('d-m-Y h:i:s A', strtotime($fil_mov_r['disp_dt']));
                              ?>
                            <tr>
                                <td align="center"><?php echo $fil_mov_r['d_by_name'];?></td><td><?php echo $fil_mov_r['disp_dt'];?></td><td><?php echo $fil_mov_r['remarks'];?></td><td><?php echo $fil_mov_r['d_to_name'];?></td>
                                <td align="center"><?php echo $fil_mov_r['r_by_name'];?></td><td align="center"><?php echo $fil_mov_r['rece_dt'];?></td>
                                <td align="center"><?php echo $fil_mov_r['comp_dt'];?></td></tr>
                    <?php }?></tbody></table></td></tr>
                <?php }?>
                </tbody></table></div>
    </div>
    <div id="newb" style="display:none;">
        <table width="100%" border="0" style="border-collapse: collapse">
            <tbody><tr style="background-color: #A9A9A9;">
                <td align="center">
                    <b>
                        <font color="black" style="font-size:14px;">Case Status</font>
                    </b>
                </td>
                <td>
                    <input style="float:right;" type="button" name="close_b" id="close_b" value="CLOSE WINDOW" onclick="close_w();">
                </td>

            </tr>
            </tbody></table>
        <div id="newb123" style="overflow:auto; background-color: #FFF;">
        </div>
        <div id="newb1" align="center">
            <table border="0" width="100%">
                <tbody><tr>
                    <td align="center" width="250px">
                    </td>
                </tr>
                </tbody></table>
        </div>
    </div>
    <script>
        $(".nav-tabs li").click(function(event) {
            updateCSRFToken();
            var url = "";
            var activeTab = $(this).find('a').attr('href').split('#')[0];
            var accname = $(this).find('a').attr('data-parent');
            var accname1 = accname.replace("#accordion", "");
            var diaryno = document.getElementById('diaryno' + accname1).value;
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

            //var diaryno = document.getElementById('diaryno').value;
            //alert(diaryno);

            if (activeTab == 102) url = "case_status/EarlierCourt";
            if (activeTab == 103) url = "get_connected.php";
            if (activeTab == 104) url = "get_listings.php";
            if (activeTab == 105) url = "get_ia.php";
            if (activeTab == 106) url = "get_court_fees.php";
            if (activeTab == 107) url = "get_notices.php";
            if (activeTab == 108) url = "get_default.php";
            if (activeTab == 109) url = "get_judgement_order.php";
            /*if(activeTab==110) url="get_adjustment.php";*/
            if (activeTab == 110) url = "get_mention_memo.php";
            if (activeTab == 111) url = "get_restore.php";
            if (activeTab == 112) url = "get_drop.php";
            if (activeTab == 113) url = "get_appearance.php";
            if (activeTab == 114) url = "get_office_report.php";
            if (activeTab == 115) url = "get_similarities.php";
            if (activeTab == 116) url = "get_caveat.php";
            if (activeTab == 117) url = "get_gateinfo.php";



            if (activeTab != 101) {
                $("#caseDetails").hide();

                $.ajax({
                    type: 'POST',
                    url: url,
                    beforeSend: function(xhr) {
                        $("#collapse" + 118).html("<div style='margin:0 auto;margin-top:20px;width:15%'><img src='../images/load.gif'></div>");
                    },
                    data: {
                        diaryno: diaryno,
                        CSRF_TOKEN: CSRF_TOKEN_VALUE
                    }
                })
                    .done(function(response) {
                        updateCSRFToken();
                        $("#collapse" + 118).show();
                        $("#collapse" + 118).html('');
                        $("#collapse" + 118).html(response);
                    })
                    .fail(function() {
                        updateCSRFToken();
                        alert("ERROR, Please Contact Server Room");
                    });

            } else {
                $("#collapse" + 118).hide();
                $("#caseDetails").show();
                updateCSRFToken();
            }

        });

        // Get the modal
        var modal = document.getElementById("myModal");
        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");
        /* var diaryNo = document.getElementById("myBtn").value;
         alert(diaryNo);*/

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
            $("#qr-object").attr('data', '');
            $("#qr-object").attr('data', 'https://10.25.78.69:44434/api/safe_transit/qr_code/generate/case_file?caseIdCsv=1232023&afterHook=print')
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
