<?php
$text_ch=[];
$text_checked=[];

if(!empty($checkbox_text)){
    $text_ch = explode("_",$checkbox_text);
}
if(!empty($checkbox_checked_value))
{
    $text_checked = explode("_",$checkbox_checked_value);
}
$text_ch = array_filter($text_ch);
$text_checked = array_filter($text_checked);


if(!empty($text_ch)){
    $p_cnt=1;
    ?>
    <div class="cl_center" style="text-align: center">
        <b>Connected Cases</b></div>
    <?php
    for ($i = 0; $i < count($text_ch); $i++)
    {
        ?>

        <div>
        <div class="cl_center" style="text-align: center">


        <table align="center">
        <tbody>

        <tr>
            <td>
                <input type="checkbox" name="chk_cnt_case<?php echo $p_cnt; ?><!--" id="chk_cnt_case<?php echo $p_cnt; ?>" value="<?php if(!empty($connected_cases))echo $connected_cases[$i]; ?>"
                       class="cl_chk_cnt_case"<?php if(!empty($text_checked)) { ?> checked="checked" <?php } ?>

            </td>
            <td>
                        <span id="sp_dname<?php echo $p_cnt; ?>">
                            <?php
                            print_r($text_ch[$i]);
                            ?>
                        </span>
            </td>
        </tr>
        <?php
        $p_cnt++;
    }
    ?>
    </tbody>
    </table>
    </div>
    </div>
    <?php
}
?>
<br>
<div class="col-sm-5">
    <textarea placeholder="Enter Summary" class="btn-block summary" cols="24" rows="4" maxlength="500" style=" color:red;" name="summary" id="summary"></textarea></div>
<br>
<div style="text-align: center;background-color: white;clear: both;" id="dv_edi">

    <div style="text-align: center;background-color: white;clear: both;" id="dv_edi" >
        <input type="button" name="btnItalic" id="btnItalic" value="I" onclick="getItalic()"/>
        <input type="button" name="btnBold" id="btnBold" value="B" onclick="getBold()"/>
        <input type="button" name="btnUnderline" id="btnUnderline" value="U" onclick="getUnderline()"/>
        <b>Font Size</b><select name="ddlFS" id="ddlFS" onchange="getFS(this.value)">
            <?php
            for($i=1;$i<=6;$i++)
            {
                ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php
            }
            ?>
        </select>
        <input type="button" name="btnJustify" id="btnJustify" value="Center" onclick="jus_cen()"/>
        <input type="button" name="btnAliLeft" id="btnAliLeft" value="Align Left" onclick="jus_left()"/>
        <input type="button" name="btnAliRight" id="btnAliRight" value="Align Right" onclick="jus_right()"/>
        <input type="button" name="btnFull" id="btnFull" value="Justify" onclick="jus_full()"/>

        <input type="button" name="btnPrintable" id="btnPrintable" value="Print and Save" onclick="save_caveat_notice()"/>

        <select name="ddlFontFamily" id="ddlFontFamily" onchange="getFonts(this.value)">
            <option value="Times New Roman">Times New Roman</option>
            <option value="'Kruti Dev 010'">Kruti Dev</option>
        </select>
        <input type="button" name="btnIndent" id="btnIndent" value="Indent" onclick="get_intent()"/>
        <input type="button" name="btnsupScr" id="btnsupScr" value="Superscript" onclick="get_supScr()"/>

        <input type="button" name="txtRedo" id="txtRedo" onclick="gt_redo()" value="Redo"/>
        <input type="text" name="txtReplace" id="txtReplace" />
        <input type="button" name="btnReplace" id="btnReplace" onclick="fin_rep()" value="Replace All"/>

        <input type="button" name="btn_sign" id="btn_sign" value="Sign" onclick="sign()" style="display:none"/>

        <input type="button" name="btn_publish" id="btn_publish" value="Publish" onclick="publish_fun()" />

        <input type="button" name="btn_prnt" id="btn__prnt" value="Print"  onclick="draft_record1()"/>


    </div>
</div>

<input type="hidden" name="hd_next_dt" id="hd_next_dt" value="<?php if(!empty($heardt_date)) print_r($heardt_date); ?>"/>
<input type="hidden" name="dno" id="dno" value="<?php if(!empty($d_no)) print_r($d_no); ?>"/>


<div contenteditable="true" style="width: auto;margin-left: 40px;margin-right: 40px;margin-bottom: 25px;margin-top: 10px;padding-left: 10px;padding-right: 10px;word-wrap: break-word;border: 1px solid black" width="100%" id="ggg" onkeypress="return  nb(event)" onmouseup="checkStat()">
    

    <div style="width: 30%;float: right">
        <table>
            <tr>
                <td>
                   <b> <font style="font-size: 13pt"  face= "Times New Roman ">Listed On</font> </b>
                </td>
                <td>
                   <b> <font style="font-size: 13pt"  face= "Times New Roman "><?= $listed_on != '' ? date('d-m-Y',strtotime($listed_on)) : '' ?></font> </b>
                </td>
            </tr>
            <tr>
                <td>
                   <b> <font style="font-size: 13pt"  face= "Times New Roman ">Court No.</font> </b>
                </td>
                <td>
                   <b> <font style="font-size: 13pt"  face= "Times New Roman "><font style="font-size: 13pt"  face= "Times New Roman ">
            <?php
             echo $court_no ;
            ?></font> </b>
                </td>
            </tr>
            <tr>
                <td>
                   <b> <font style="font-size: 13pt"  face= "Times New Roman ">Item No.</font> </b>
                </td>
                <td>
                   <b> <font style="font-size: 13pt"  face= "Times New Roman "><?php echo $item_no; ?></font> </b>
                </td>
            </tr>
        </table>
    </div>


    <p align="center" style='margin: 0px;padding: 2px 0px 0px 0px;'>
        <b> <font style="font-size: 13pt"  face="Times New Roman"  >IN THE SUPREME COURT OF INDIA</font> </b>
    </p>
    <p align="center" style='margin: 0px;padding: 2px 0px 0px 0px;'>
        <font><b style="font-size: 13pt"  face= "Times New Roman ">
               
                <?php  $ct = $fil_details['casetype_id'];
                if($ct==1 or $ct==2 ){
                    echo "EXTRA-ORDINARY APPELLATE JURISDICTION";
                }else if($ct==7 || $ct==11 || $ct==24 )
                {
                    echo "CIVIL ORIGINAL JURISDICTION";
                }
                else{
                    echo "CIVIL/CRIMINAL APPELLATE JURISDICTION";
                }?>
            </b></font>
    </p>


    <p align="center" style='margin: 0px;padding: 10px 0px 0px 0px;width:100%' >
        <u><b><font style="font-size: 13pt"  face= "Times New Roman " id="append_data"><?php echo $fil_details['casename'] ?>  <?= $fil_details['fil_no'] != '' ?  ' No. '.intval(substr($fil_details['fil_no'], 3)) : '' ?>  <?= $fil_details['fil_dt'] != '' ? ' OF '. date('Y',strtotime($fil_details['fil_dt'])) : '' ?></font></b></u>
    </p>
    <p align="center" style='margin: 0px;padding: 1px 0px 0px 0px;' >
        <u><b><font style="font-size: 13pt"  face= "Times New Roman " >   WITH PRAYER FOR INTERIM RELIEF   </font></b></u>
    </p>
     <p align="center" style='margin: 0px;padding: 10px 0px 0px 0px;' >
        <u><b><font style="font-size: 13pt"  face= "Times New Roman " id="append_data"></font></b></u>
    </p>


    <p align="left" style="margin: 0px;padding: 0px 0px 0px 2px;width: 50%;float: left" ><b><font  style="font-size: 13pt"  face="Times New Roman">Process Id: <?php if(!empty($process_id)) echo $process_id; ?></font></b></p>


    <div align="center" style="width: 100%;clear: both">
        <table cellpadding="10" cellspacing="10" style="width: 100%" >
            <tr>
                <td style="font-size: 13pt;text-align: left"><?php echo $pet_names; ?></td>
                <td rowspan="2" style="vertical-align: middle;font-size: 13pt"  face= "Times New Roman ;text-align: center; width: 45%">Versus</td>
                <!-- <td style="font-size: 13pt"  face= "Times New Roman ;text-align: right ; width: 45%">... Petitioner</td> -->
                <td style="font-size: 13pt"  face= "Times New Roman ;text-align: right ; width: 45%">
                    <?php
                        if(($fil_details['casetype_id'] == 3 ) or ($fil_details['casetype_id'] == 4 )){
                            echo "... Appellant";
                        }else{
                            echo "... Petitioner";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td style="font-size: 13pt"  face= "Times New Roman ;text-align: left ; width: 45%"><?php echo $res_names; ?></td>
                <td style="font-size: 13pt"  face= "Times New Roman ;text-align: right ; width: 45%">... Respondent</td>
            </tr>
        </table>
    </div>

    <p style="color: #000000;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px;clear: both;text-align: center" align="justify">
        <font><b style="font-size: 13pt"  face="Times New Roman">OFFICE REPORT</b></font>
    </p>



    <p style="color: #000000;text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 20px 0px;clear: both" align="justify">
        <font  style="font-size: 13pt"  face= "Times New Roman ">
        This Hon'ble Court, on <b><?php echo $civilData['listed_dt_lst']; ?></b>, was pleased to pass the following order:

        </font>
     </p>
     

    <p style="text-indent: 80px;padding: 0px 2px 0px 2px;margin: 5px 60px 0px 60px;" align="justify">
         <b><font  style="font-size: 13pt"  face= "Times New Roman" >
           "<?php
            if(isset($civilData['fil_nm'])){
                if($civilData['fil_nm'] != ''){
                    echo $civilData['fil_nm'];
                }else{
                    echo "";
                }
            }
            ?>"
         </font></b>
    </p>


    <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
         <font  style="font-size: 13pt"  face= "Times New Roman ">
         The advocate has not filed spare copies/furnished fresh address in respect of
         Respondent No(s) and, hence, notice could not be issued to Respondent No(s)Spare copies were
         filed on .............. and show cause notice was issued on .............
         through ...(mode of service) in respect of respondent No(s)......
      </font>
    </p>
     <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
         <font  style="font-size: 13pt"  face= "Times New Roman ">
        The counsel for the petitioner has not filed spare copies/furnished fresh address in
        respect of Respondent No(s) ...... Hence, notice could not be issued to
        Respondent No(s)................
      </font>
    </p>
    <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
         <font  style="font-size: 13pt"  face= "Times New Roman ">
       Pursuant to Court's order dated           Advocate for the petitioner(s)/respondent(s) No(s) has
       deposited/has not deposited costs in the Registry.  There is delay of           days in depositing
       costs and Advocate has filed/has not filed application for condonation of delay in depositing costs.
      </font>
    </p>

    <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 20px 0px" align="justify">
         <font  style="font-size: 13pt"  face= "Times New Roman ">
      The service having not been complete/spare copies having not been filed within time/fresh address
      having not been furnished/sufficient number of spare copies having not been filed, the petition
      was listed before the Hon'ble Judge in <b style="font-size: 13pt"  face= "Times New Roman "><?php echo $civilData['fil_nm2']['board_type']; ?></b> and the following order was passed
      on <b style="font-size: 13pt"  face= "Times New Roman "><?php echo $civilData['fil_nm2']['l_date']; ?></b>
        </font>
    </p>

     <p style="text-indent: 80px;padding: 0px 2px 0px 2px;margin: 5px 60px 0px 60px" align="justify">
         <b><font style="font-size: 13pt"  face= "Times New Roman " >
           " <?php //echo $civilData['fil_nm2']['fil_nm2']; ?>"
         </font></b>
    </p>


    <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
        <font  style="font-size: 13pt"  face= "Times New Roman "> The status as regards service position is an under:
            <table style="width: 100%;border-collapse: collapse" border='1' cellpadding="5" cellspacing="5">
                <tr>
                    <th style="font-size: 13pt"  face= "Times New Roman ">
                        SNo.
                    </th>
                    <th style="font-size: 13pt"  face= "Times New Roman ">
                        PID
                    </th>
                    <th style="font-size: 13pt"  face= "Times New Roman ">
                    Party Name
                    </th >
                    <th style="font-size: 13pt"  face= "Times New Roman ">
                    Issue Date
                    </th>
                    <th style="font-size: 13pt"  face= "Times New Roman ">
                    Returnable Date, if any
                    </th>
                    <th style="font-size: 13pt"  face= "Times New Roman ">
                    Dispatch Date
                    </th>
                    <th style="font-size: 13pt"  face= "Times New Roman ">
                    Serve Date / Ack. Date
                    </th>
                    <th style="font-size: 13pt"  face= "Times New Roman ">
                        Serve Status
                        </th>
                </tr>
                <?php
                
                if(!empty($civilData['serve_status'])){
                    $t_sno=1;
                    $serve_status = $civilData['serve_status'];
                    foreach ($serve_status as $row4) {
                    //  while ($row4 = mysql_fetch_array($serve_status)) {
                        ?>
                <tr>
                    <td style="font-size: 13pt"  face= "Times New Roman ">
                        <?php echo $t_sno; ?>
                    </td>
                    <td style="font-size: 13pt"  face= "Times New Roman ">
                        <?php echo $row4['process_id']; ?>
                    </td>

                    <td style="font-size: 13pt"  face= "Times New Roman ">
                        <?php
                        if($row4['name']!=''){
                            echo $row4['name'];
                        }
                        if($row4['name']!='' && $row4['tw_sn_to']!=0){
                            echo "Through ";
                        }
                        if($row4['tw_sn_to']!=0){
                            $send_to_name= send_to_name($row4['send_to_type'],$row4['tw_sn_to']);
                        }
                        echo $send_to_name;
                        ?>
                    </td>

                    <td style="font-size: 13pt"  face= "Times New Roman ">
                        <?php
                            if($row4['rec_dt']!='0000-00-00'){
                            echo date('d-m-Y',strtotime($row4['rec_dt']));
                            }
                        ?>
                    </td>
                    <td style="font-size: 13pt"  face= "Times New Roman ">
                        <?php
                            if($row4['fixed_for']!='0000-00-00'){
                            echo date('d-m-Y',strtotime($row4['fixed_for']));
                            }
                        ?>
                    </td>
                    <td style="font-size: 13pt"  face= "Times New Roman ">
                        <?php
                            if($row4['dispatch_dt']!='0000-00-00 00:00:00'){
                            echo date('d-m-Y',strtotime($row4['dispatch_dt']));
                            }
                        ?>
                    </td>
                    <td style="font-size: 13pt"  face= "Times New Roman ">
                        <?php
                            if($row4['ser_date']!='0000-00-00'){
                            echo date('d-m-Y',strtotime($row4['ser_date']));
                            }
                        ?>
                    </td>
                    <td style="font-size: 13pt"  face= "Times New Roman ">
                        <?php
                        //$serve_status=serve_status($row4['serve']);
                        //echo $serve_status;
                        ?>
                    </td>
                </tr>
                <?php
                $t_sno++;
                    }
                }else{     ?>
                    <tr>
                        <th style="font-size: 13pt"  face= "Times New Roman ">
                            &nbsp;
                        </th>
                        <th style="font-size: 13pt"  face= "Times New Roman ">
                            &nbsp;
                        </th>
                        <th style="font-size: 13pt"  face= "Times New Roman ">
                            &nbsp;
                        </th>
                        <th style="font-size: 13pt"  face= "Times New Roman ">
                        &nbsp;
                        </th>
                        <th style="font-size: 13pt"  face= "Times New Roman ">
                        &nbsp;
                        </th>
                        <th style="font-size: 13pt"  face= "Times New Roman ">
                            &nbsp;
                        </th>
                        <th style="font-size: 13pt"  face= "Times New Roman ">
                        &nbsp;
                        </th>
                        <th style="font-size: 13pt"  face= "Times New Roman ">
                        &nbsp;
                        </th>

                    </tr>
                <?php } ?>
            </table>
        </font>
    </p>

    <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
         <font  style="font-size: 13pt"  face= "Times New Roman ">
            Respondent No(s) made parties in their official capacities have entered appearance
            through Mr...... Advocate.
        </font>
    </p>
     <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
         <font  style="font-size: 13pt"  face= "Times New Roman ">
                Respondent No(s) .. are proforma respondents and have been served/not respondent.  They have
                entered appearance through Mr..... Advocate.
        </font>
    </p>
     <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
         <font  style="font-size: 13pt"  face= "Times New Roman ">
                Caveat             is represented through          , Advocate, on behalf of respondent No(s)
        </font>
    </p>
    <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
         <font  style="font-size: 13pt"  face= "Times New Roman ">
                Mr.........., Advocate has died/designated as Sr. Advocate.  Notice for alternative arrangement
                issued on ....... and served/not served on parties ....... .  Mr.    Advocate has filed
                fresh Vakalatnama  on behalf of petitioner/respondent by ...... , Advocate
        </font>
    </p>
    <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
         <font  style="font-size: 13pt"  face= "Times New Roman ">
                Pursuant to Court's order, the amount of Rs.        has been/has not been deposited in the Registry
                by the petitioner(s)/respondent(s) No(s)
        </font>
    </p>
    <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
         <font  style="font-size: 13pt"  face= "Times New Roman ">
                Pursuant to Court's order dated                Bank Guarantee for a sum of Rs.
                has been filed by petitioner(s)/respondent(s) No(s) ..           and the same has been accepted.
                The advocate has taken/has not taken steps for renewal of the Bank Guarantee.
        </font>
    </p>
    <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
        <font  style="font-size: 13pt"  face= "Times New Roman ">
        The Interlocutory Application for modification/ clarification/ substitution/ impleadment/
        intervention/ substituted service/ Vakalatnama/ Counter Affidavit/ Rejoinder Affidavit is/are
        defective for the following reasons:
        </font>
    </p>
    

    <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px;text-align: center" align="justify">
        <font style="font-size: 13pt"  face= "Times New Roman " >
            <u><b style="font-size: 15px;">Status of the case</b></u>
            <table style="width: 100%;border-collapse: collapse;margin-top: 10px" border='1' cellpadding="5" cellspacing="5">
                <tr>
                    <th style="font-size: 13pt"  face= "Times New Roman ">
                        S.No.
                    </th>
                    <th style="font-size: 13pt"  face= "Times New Roman ">
                        Parties to the petition [both petitioner and respondents]
                    </th>
                    <th style="font-size: 13pt"  face= "Times New Roman ">
                    Advocate's name
                    </th>
                    <th style="font-size: 13pt"  face= "Times New Roman ">
                    Counter/rejoinder/ I.As/documents filed
                    </th>
                    <th style="font-size: 13pt"  face= "Times New Roman ">
                    Page Nos.
                    </th>
                    <th style="font-size: 13pt"  face= "Times New Roman ">
                    Remarks
                    </th>

                </tr>
                <?php
                if(!empty($civilData['doc_case_status'])){
                    $d_sno=1;
                    $documents = $civilData['doc_case_status'];
                    foreach ($documents as $row1) { ?>
                <tr>
                    <td style="font-size: 13pt"  face= "Times New Roman ">
                        <?php echo $d_sno; ?>
                    </td>
                    <td style="font-size: 13pt"  face= "Times New Roman ">
                <?php
                if(!empty($row1['party_details'])){
                        $parties = $row1['party_details']; ?>
                            <table>
                                <tr>
                                    <td>
                                        <?php echo $parties['pet_res'].'['.$parties['sr_no'].']'.' '.$parties['partyname']; ?>
                                    </td>
                                </tr>
                            </table>
                    <?php } ?>

                    </td>
                    <td style="font-size: 13pt"  face= "Times New Roman ">
                    <?php
                    if(!empty($row1['filed_by'])){
                        $r_filed_by=  $row1['filed_by'];
                        echo $r_filed_by['aor_code'].'-'.$r_filed_by['name'];
                    }?>
                    </td>
                    <td style="font-size: 13pt"  face= "Times New Roman ">
                    <?php
                    $other1='';
                        if($row1['other1']!=''){
                            $other1=" ".$row1['other1'];
                        }
                        echo $row1['docnum'].'/'.$row1['docyear'].'- '.$row1['docdesc'].$other1;
                    ?>
                    </td>
                    <td style="font-size: 13pt"  face= "Times New Roman ">
                        <?php
                            if(!empty($row1['indexing'])){
                                $r_indexing = $row1['indexing'];
                                echo $r_indexing['fp'].'-'.$r_indexing['tp'];
                            } 
                        ?>
                    </td>

                    <td style="font-size: 13pt"  face= "Times New Roman ">
                    </td>

                </tr>
                <?php
                $d_sno++;
                    }
                }else{
                ?>
                    <tr>
                        <th style="font-size: 13pt"  face= "Times New Roman ">
                            &nbsp;
                        </th>
                        <th style="font-size: 13pt"  face= "Times New Roman ">
                            &nbsp;
                        </th>
                        <th style="font-size: 13pt"  face= "Times New Roman ">
                        &nbsp;
                        </th>
                        <th style="font-size: 13pt"  face= "Times New Roman ">
                        &nbsp;
                        </th>
                        <th style="font-size: 13pt"  face= "Times New Roman ">
                            &nbsp;
                        </th>
                        <th style="font-size: 13pt"  face= "Times New Roman ">
                        &nbsp;
                        </th>
                    </tr>
                <?php } ?>
            </table>
        </font>
    </p>
   
   
    <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
        <font  style="font-size: 13pt"  face= "Times New Roman ">
            Mediation Report/Report has been received pursuant to Court's Order dated ......
        </font>
    </p>
    <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
        <font style="font-size: 13pt"  face= "Times New Roman " >
            It is submitted that original record from the High Court has/has not been received.
        </font>
    </p>
    <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
        <font style="font-size: 13pt"  face= "Times New Roman " >
            The appeal is listed for pre-final hearing before the Court of Ld. Registrar with this Office Report.
        </font>
    </p>
      <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
        <font style="font-size: 13pt"  face= "Times New Roman " >
            The Petition above-mentioned is listed before the Hon'ble Court/ Hon'ble Judge in Chamber/
            Court of Ld. Registrar with this Office Report.
        </font>
    </p>
      <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
        <font style="font-size: 13pt"  face= "Times New Roman " >
            The Office Report for directions/on Default is listed before the Hon'ble Court seeking directions
            regarding.......
        </font>
    </p>
    <p style="text-indent: 40px;padding: 0px 2px 0px 2px;margin: 10px 0px 0px 0px" align="justify">
        <font style="font-size: 13pt"  face= "Times New Roman " >
            Dated :
                <b><?php echo date('F d, Y'); ?></b>
        </font>
    </p>
   
   

    <?php if($court_no=='21' || $court_no=='22' || $court_no=='61' || $court_no=='62'){ ?>
          <div align="right" style="padding:50px 2px 0px 0px;">
            <span>  <strong><font style="font-size: 13pt"  face= "Times New Roman " >BRANCH OFFICER</font></strong></span>
          </div>
        <?php } else{?>
    <div align="right" style="padding:50px 2px 0px 0px;">
      <span>  <strong><font style="font-size: 13pt"  face= "Times New Roman " >ASSISTANT REGISTRAR</font></strong></span>
    </div>
        <?php }?>

    <p style="padding: 4px 0px 0px 2px;margin: 0px;" align="justify">
        <font style="font-size: 13pt"  face= "Times New Roman " >
            Copy to :-
        </font>
    </p>

    <p style="text-indent: 40px;padding: 4px 0px 0px 2px;margin: 0px;" align="justify"><font style="font-size: 13pt"  face="Times New Roman" >

        <div style="margin-left: 30px">
            <?php
            $c_sno=1;
            $send_to_advocate= $civilData['send_to_advocate_z'];  ?>
            <table>
                <?php
                for ($index = 0; $index < count($send_to_advocate); $index++) {
                    $title='';
                    $t_name='';
                    $t_address='';
                    $city='';
                    $title=$send_to_advocate[$index][0];
                    $t_name=$send_to_advocate[$index][1];
                    $t_address=$send_to_advocate[$index][2];
                    $city=$send_to_advocate[$index][3];
                    ?>

                    <tr>
                        <td style="font-size: 13pt;vertical-align: top">
                            <?php echo $c_sno; ?>
                        </td>
                        <td >
                            <div style="font-size: 13pt"  face="Times New Roman">
                                <?php echo $title.' '. ucwords(strtolower($t_name)).' '.ucwords(strtolower($t_address)).' '.ucwords(strtolower($city));?>
                            </div>
                        </td>
                    </tr>
                    <?php
                    $c_sno++;
                }
                ?>
            </table>
        </div>

        </font>
    </p>


    <div>
        <?php
        if($court_no=='21' || $court_no=='22' || $court_no=='61' || $court_no=='62')
            {?>
        <p align="right" style="padding: 13px 2px 0px 0px;margin: 0px"><b><font style="font-size: 13pt"  face= "Times New Roman " >BRANCH OFFICER</font></b></p>
        <?php } else {?>
        <p align="right" style="padding: 13px 2px 0px 0px;margin: 0px"><b><font style="font-size: 13pt"  face= "Times New Roman " >ASSISTANT REGISTRAR</font></b></p>
        <?php } ?>
    </div>




   
</div>

<input type="hidden" name="hd_or_id" id="hd_or_id" value=" <?= !(empty($res_max_o_r)) ? $res_max_o_r : '' ?> ">
<input type="hidden" name="sp_listed_on" id="sp_listed_on" value=" <?= $listed_on != '' ? $listed_on : '' ?> ">
<script src="<?php echo base_url('plugins/jquery-validation/jquery.validate.js'); ?>"></script>
<script src="<?php echo base_url('plugins/jquery-validation/additional-methods.js'); ?>"></script>
<script>
    $(document).on('click','.cl_chk_cnt_case',function(){
        var idd=$(this).attr('id');
        var sp_idd=idd.split('chk_cnt_case');
        var cnt_checked_case=0;
        $('.cl_chk_cnt_case').each(function(){
            if($(this).is(':checked'))
            {
                cnt_checked_case++;
            }
        });
        if($(this).is(':checked')){
            var sp_dname=$('#sp_dname'+sp_idd[1]).html();
            $('#append_data').append('<p id="dvytr_'+sp_idd[1]+'" style="margin-top:0px;text-align:center;">'+sp_dname+'</p>');
        }
        else if ($(this).is(':not(:checked)')){
            $('#dvytr_'+sp_idd[1]).remove();
        }

    });


    function updateCSRFToken() {
        $.getJSON("<?php echo base_url('Csrftoken'); ?>", function (result) {
            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
        });
    }


    function save_caveat_notice() {

        var dno = $('#dno').val()
        var dyr = dno.substr(dno.length - 4);
        let d_no = dno.replace(dyr, "");

        var t_h_cno = d_no;
        var t_h_cyt = dyr;
        var hd_or_id=$('#hd_or_id').val();
        var sp_listed_on=$('#sp_listed_on').val();
        var ggg=encodeURIComponent($('#ggg').html());
        var hd_next_dt=$('#hd_next_dt').val();
        var ddl_rt = $('#ddl_rt').val();
        ddl_rt = ddl_rt.replace(/^\s+/g, '')
        var connected_case='';
        var summary=$('#summary').val();
        $('.cl_chk_cnt_case').each(function(){
            if($(this).is(':checked')){
                if(connected_case=='')
                    connected_case=$(this).val();
                else
                    connected_case=connected_case+','+$(this).val();
            }
        });

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

        let obj =  {CSRF_TOKEN: CSRF_TOKEN_VALUE, d_no: t_h_cno, d_yr: t_h_cyt,hd_or_id:hd_or_id,sp_listed_on:sp_listed_on,ggg:ggg,hd_next_dt:hd_next_dt,ddl_rt:ddl_rt,connected_case:connected_case,summary:summary}
        // console.log("obj:: ", obj)
        // return false

        $.ajax({
            url: "<?php echo base_url('Extension/OfficeReport/save_office_report'); ?>",
            cache: false,
            async: true,
            data: obj,

            type: 'POST',
            success: function(data, status) {
                updateCSRFToken();
                // console.log("data: ", JSON.parse(data)  )
                // return
                data = JSON.parse(data)
                if(data.msg != '1' && data.msg != 2){
                    alert(data.msg)
                }else{

                    data = data['msg']
                    $('#hd_chk_status').val(data)

                    // $('#chk_status').html(data);
                    // var hd_chk_status=$('#hd_chk_status').val();
                    var hd_chk_status = data
                    if(hd_chk_status=='1'){
                        alert('Record Save Successfully');
                    }
                    else if(hd_chk_status=='2'){
                        alert('Record Update Successfully');
                        var prtContent = document.getElementById('ggg');

                        var WinPrint = window.open('','','letf=100,top=0,width=800,height=1200,toolbar=1,scrollbars=1,status=1,menubar=1');
                        WinPrint.document.write('<link rel="stylesheet" href="../css/menu_css.css">'+'<style>'+$('#pnt_rec').html()+'</style>'+prtContent.innerHTML);
                        WinPrint.print();
                        get_report();
                    }
                }


                updateCSRFToken();
            },
            error: function(xhr) {
                alert("Error: " + xhr.status + " " + xhr.statusText);
            }

        });
    }


    function publish_fun(){
        updateCSRFToken();
        // alert("RRR");
        // console.log("AAA");
        // return false;
        var dno = $('#dno').val();
        var hd_next_dt=$('#hd_next_dt').val();
        var connected_case='';
        $('.cl_chk_cnt_case').each(function(){

            if($(this).is(':checked'))
            {
                // alert($(this).val());
                if(connected_case=='')
                    connected_case=$(this).val();
                else
                    connected_case=connected_case+','+$(this).val();
            }
        });



        setTimeout(function(){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

            $.ajax({
                type: "POST",
                data: {
                    CSRF_TOKEN: CSRF_TOKEN_VALUE,
                    connected_case:connected_case,
                    hd_next_dt: hd_next_dt,
                    dno:dno
                },
                url: "<?php echo base_url('Extension/OfficeReport/publish_office_report'); ?>",
                success: function (data) {
                    updateCSRFToken();
                    console.log(data);
                    // return false;
                    if(data==1)
                    {
                        alert("Record Publish Successfully");
                    }
                    else if(data==2)
                    {
                        alert("Please save data before Publishing record");
                    }
                    else
                    {
                        alert("Problem in publishing Record");
                    }

                },
                error: function (data) {
                    alert(data);
                    updateCSRFToken();
                }
            });
        }, 1500)

    }

</script>