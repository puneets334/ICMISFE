//Function Autocomplete start pet post------------------------------------------------

$(function() {
    $("#pet_post").autocomplete({
        source: "../Common/Ajaxcalls/new_filing_autocomp_post",
        width: 450,
        matchContains: true,
        minChars: 1,
        selectFirst: false,
        autoFocus: true
    });
});

$(document).on("blur","#pet_post",function(){
    if(this.value.indexOf('~') != '-1'){
        var htht = this.value.split('~');
        $("#pet_post").val(htht[1]);
        $("#pet_post_code").val(htht[0]);
    }
});


$(function() {
    $("#pet_statename").autocomplete({
        source: "../Common/Ajaxcalls/get_only_state_name",
        width: 450,
        matchContains: true,
        minChars: 1,
        selectFirst: false,
        autoFocus: true
    });
});

$(document).on("blur","#pet_statename",function(){
    if(this.value.indexOf('~') != '-1'){
        var htht = this.value.split('~');
        $("#pet_statename").val(htht[1]);
        $("#pet_statename_hd").val(htht[0]);
    }
});


$(function() {
    $("#res_statename").autocomplete({
        source: "../Common/Ajaxcalls/get_only_state_name",
        width: 450,
        matchContains: true,
        minChars: 1,
        selectFirst: false,
        autoFocus: true
    });
});

$(document).on("blur","#res_statename",function(){
    if(this.value.indexOf('~') != '-1'){
        var htht = this.value.split('~');
        $("#res_statename").val(htht[1]);
        $("#res_statename_hd").val(htht[0]);
    }
});

//Function Autocomplete end--------------------------------------------------
//var selpt= $('#selpt :selected').val();
//Function Autocomplete start pet deptt------------------------------------------------
$(document).on("focus","#pet_deptt",function(){
    $("#pet_deptt").autocomplete({
        source:"../Common/Ajaxcalls/new_filing_autocomp_deptt?type="+$("#selpt").val(),
        width: 450,
        matchContains: true,
        minChars: 1,
        selectFirst: false,
        autoFocus: true
    });
});


$(document).on("blur","#pet_deptt",function(){
    if(this.value.indexOf('~') != '-1'){
        var htht = this.value.split('~');
        $("#pet_deptt").val(htht[1]);
        $("#pet_deptt_code").val(htht[0]);
    }
});
//Function Autocomplete end--------------------------------------------------

//Function Autocomplete start pet post------------------------------------------------
$(function() {
    $("#res_post").autocomplete({
        //source: "../filing/new_filing_autocomp_post.php",
        source: "../Common/Ajaxcalls/new_filing_autocomp_post",
        width: 450,
        matchContains: true,
        minChars: 1,
        selectFirst: false,
        autoFocus: true
    });
});

$(document).on("blur","#res_post",function(){
    if(this.value.indexOf('~') != '-1'){
        var htht = this.value.split('~');
        $("#res_post").val(htht[1]);
        $("#res_post_code").val(htht[0]);
    }
});
//Function Autocomplete end--------------------------------------------------

//Function Autocomplete start pet deptt------------------------------------------------
$(document).on("focus","#res_deptt",function(){
    $("#res_deptt").autocomplete({
        source:"../Common/Ajaxcalls/new_filing_autocomp_deptt?type="+$("#selrt").val(),
        width: 450,
        matchContains: true,
        minChars: 1,
        selectFirst: false,
        autoFocus: true
    });
});

$(document).on("blur","#res_deptt",function(){
    if(this.value.indexOf('~') != '-1'){
        var htht = this.value.split('~');
        $("#res_deptt").val(htht[1]);
        $("#res_deptt_code").val(htht[0]);
    }
});
//Function Autocomplete end--------------------------------------------------

function setCountry_state_dis(id,value){
    var string1 = id.split('_cont');
    if(value != "96"){
        $("#sel"+string1[0]+'st'+string1[1]).prop("disabled",true);
        $("#sel"+string1[0]+'dis'+string1[1]).prop("disabled",true);
        $("#sel"+string1[0]+'st'+string1[1]).val("");
        $("#sel"+string1[0]+'dis'+string1[1]).val("");
    }
    else{
        $("#sel"+string1[0]+'st'+string1[1]).removeProp("disabled");
        $("#sel"+string1[0]+'dis'+string1[1]).removeProp("disabled");
    }
}

function chkM(val)
{
    if (val == '52')
        document.getElementById('mcrc_rw').style.display = 'table-row';
    else
        document.getElementById('mcrc_rw').style.display = 'none';
}

function changeAdvocate(id, val)
{
    if (id == 'padvt')
    {
        $('#ddl_pet_adv_state').val('');
        $('#padvno').val('');
        $('#padvyr').val('');
        $('#padvname').val('');
        $('#padvmob').val('');
        if(val == 'S')
        {
            document.getElementById('padvno').style.display = 'inline';
            document.getElementById('padvno_').style.display = 'inline';
            document.getElementById('padvyr').style.display = 'inline';
            document.getElementById('padvyr_').style.display = 'inline';
            document.getElementById('padvmob').style.display = "inline";
            document.getElementById('padvmob_').style.display = "inline";
            document.getElementById('padvemail').style.display = 'inline';
            document.getElementById('padvemail_').style.display = 'inline';
            document.getElementById('padvname').disabled = true;
            document.getElementById('padvname').value = '';
            document.getElementById('padvmob').value = '';
            document.getElementById('padvemail').value = '';
            $('#padvyr').attr('disabled',false);
            $('#ddl_pet_adv_state').attr('disabled',false);
        }
        else if(val=='A')
        {
            $('#ddl_pet_adv_state').val('');
            $('#ddl_pet_adv_state').attr('disabled',true);
            $('#padvno').val('');
            $('#padvyr').val('');
            $('#padvno').attr('disabled',false);
            $('#padvyr').attr('disabled',true);

        }
        else if (val != 'S')
        {
            if(val=='SS'){
                document.getElementById('padvno').style.display = 'none';
                document.getElementById('padvno_').style.display = 'none';
                document.getElementById('padvno').value = '';
                document.getElementById('padvyr').style.display = 'none';
                document.getElementById('padvyr_').style.display = 'none';
                document.getElementById('padvyr').value = '';
                document.getElementById('padvname').disabled = false;
                document.getElementById('padvname').value =" (SELF)";
                /*if (document.getElementById('selpt').value == 'I')
                    document.getElementById('padvname').value = document.getElementById('pet_name').value + " (SELF)";*/
            }
            else if(val=='C'){
                $('#padvno').prop('disabled',true);
                $('#padvyr').prop('disabled',true);
                $('#padvname').prop('disabled',true);
                document.getElementById('padvno').value = '7777';
                document.getElementById('padvyr').value = '2014';
                //document.getElementById('padvname').disabled = false;
                //document.getElementById('padvname').value = "Assistant Solicitor General";
                document.getElementById('padvname').value = "ATTORNEY GENERAL";
            }
            document.getElementById('padvmob').value = '';
            document.getElementById('padvmob').style.display = "none";
            document.getElementById('padvmob_').style.display = "none";
            document.getElementById('padvemail').value = '';
            document.getElementById('padvemail').style.display = 'none';
            document.getElementById('padvemail_').style.display = 'none';
            if (val == 'C')
            {

            }
            else if (val == 'SS')
            {

            }
            $('#ddl_pet_adv_state').attr('disabled',true);
        }

    }
    else if (id == 'radvt')
    {
        $('#ddl_res_adv_state').val('');
        $('#radvno').val('');
        $('#radvyr').val('');
        $('#radvname').val('');
        $('#radvmob').val('');
        if (val == 'S')
        {
            document.getElementById('radvno').style.display = 'inline';
            document.getElementById('radvno_').style.display = 'inline';
            document.getElementById('radvyr').style.display = 'inline';
            document.getElementById('radvyr_').style.display = 'inline';
            document.getElementById('radvname').disabled = true;
            document.getElementById('radvname').value = '';
            document.getElementById('radvmob').value = '';
            document.getElementById('radvmob').style.display = 'inline';
            document.getElementById('radvmob_').style.display = 'inline';
            document.getElementById('radvemail').value = '';
            document.getElementById('radvemail').style.display = 'inline';
            document.getElementById('radvemail_').style.display = 'inline';
            $('#radvyr').attr('disabled',false);
            $('#ddl_res_adv_state').attr('disabled',false);
        }

        else if(val=='A')
        {
            $('#ddl_res_adv_state').val('');
            $('#ddl_res_adv_state').attr('disabled',true);
            $('#radvno').val('');
            $('#radvyr').val('');
            $('#radvno').attr('disabled',false);
            $('#radvyr').attr('disabled',true);

        }
        else if (val != 'S')
        {
            if(val=='SS'){
                document.getElementById('radvno').style.display = 'none';
                document.getElementById('radvno_').style.display = 'none';
                document.getElementById('radvno').value = '';
                document.getElementById('radvyr').style.display = 'none';
                document.getElementById('radvyr_').style.display = 'none';
                document.getElementById('radvyr').value = '';
                document.getElementById('radvname').disabled = false;
                document.getElementById('radvname').value =" (SELF)";
                /*if (document.getElementById('selrt').value == 'I')
                    document.getElementById('radvname').value = document.getElementById('res_name').value + " (SELF)";*/
            }
            else if(val=='C'){
                $('#radvno').prop('disabled',true);
                $('#radvyr').prop('disabled',true);
                $('#radvname').prop('disabled',true);
                document.getElementById('radvno').value = '7777';
                document.getElementById('radvyr').value = '2014';
                //document.getElementById('radvname').disabled = false;
                //document.getElementById('radvname').value = "Assistant Solicitor General";
                document.getElementById('radvname').value = "ATTORNEY GENERAL";
            }

            document.getElementById('radvmob').value = '';
            document.getElementById('radvmob').style.display = 'none';
            document.getElementById('radvmob_').style.display = 'none';
            document.getElementById('radvemail').value = '';
            document.getElementById('radvemail').style.display = 'none';
            document.getElementById('radvemail_').style.display = 'none';
            if (val == 'C')
            {

            }
            else if (val == 'SS')
            {

            }
            $('#ddl_res_adv_state').attr('disabled',true);
        }
    }
}


function activate_main(id)
{
    var selpt= $('#selpt :selected').val();
    //alert('selpt='+selpt);
    if (id == "selpt")
    {
        if (document.getElementById(id).value == "I")
        {
            document.getElementById('pet_post').value = "";
            document.getElementById('pet_deptt').value = "";
            document.getElementById('pet_statename').value = "";
            document.getElementById('paddd').value = "";
            document.getElementById('pcityd').value = "";
            document.getElementById('ppind').value = "";
            document.getElementById('selpdisd').value = "";
            document.getElementById('selpstd').value = "23";
            document.getElementById('pmobd').value = "";
            document.getElementById('pemaild').value = "";
            document.getElementById('for_I_p').style.display = 'block';
            document.getElementById('for_D_p').style.display = 'none';
            //$('#state_department_in_pet').val("");
        }
        else if (document.getElementById(id).value != "I")
        {
            document.getElementById('pet_name').value = "";
            document.getElementById('selprel').value = "";
            document.getElementById('prel').value = "";
            document.getElementById('psex').value = "";
            document.getElementById('page').value = "";
            document.getElementById('pocc').value = "";
            document.getElementById('paddi').value = "";
            document.getElementById('pcityi').value = "";
            document.getElementById('ppini').value = "";
            document.getElementById('selpdisi').value = "";
            document.getElementById('selpsti').value = "23";
            document.getElementById('pmobi').value = "";
            document.getElementById('pemaili').value = "";
            document.getElementById('for_I_p').style.display = 'none';
            document.getElementById('for_D_p').style.display = 'block';

            /*if (document.getElementById(id).value == 'D1')
                $('.state_p').css('display', 'table-cell');
            else
            {
                $('.state_p').css('display', 'none');
                $('#state_department_in_pet').val("");
            }*/
        }
    }
    else if (id == "selrt")
    {
        if (document.getElementById(id).value == "I")
        {
            document.getElementById('res_post').value = "";
            document.getElementById('res_deptt').value = "";
            document.getElementById('res_statename').value = "";
            document.getElementById('raddd').value = "";
            document.getElementById('rcityd').value = "";
            document.getElementById('rpind').value = "";
            document.getElementById('selrdisd').value = "";
            document.getElementById('selrstd').value = "23";
            document.getElementById('rmobd').value = "";
            document.getElementById('remaild').value = "";
            document.getElementById('for_I_r').style.display = 'block';
            document.getElementById('for_D_r').style.display = 'none';
            $('#state_department_in_res').val("");
        }
        else if (document.getElementById(id).value != "I")
        {
            document.getElementById('res_name').value = "";
            document.getElementById('selrrel').value = "";
            document.getElementById('rrel').value = "";
            document.getElementById('rsex').value = "";
            document.getElementById('rage').value = "";
            document.getElementById('rocc').value = "";
            document.getElementById('raddi').value = "";
            document.getElementById('rcityi').value = "";
            document.getElementById('rpini').value = "";
            document.getElementById('selrdisi').value = "";
            document.getElementById('selrsti').value = "23";
            document.getElementById('rmobi').value = "";
            document.getElementById('remaili').value = "";
            document.getElementById('for_I_r').style.display = 'none';
            document.getElementById('for_D_r').style.display = 'block';

            if (document.getElementById(id).value == 'D1')
                $('.state_r').css('display', 'table-cell');
            else
            {
                $('.state_r').css('display', 'none');
                $('#state_department_in_res').val("");
            }
        }
    }
}

function getAdvocate_for_main(flag)
{
//   alert(flag);

    if (flag == 'P')
    {
        var ddl_pet_adv_state=$('#ddl_pet_adv_state').val();
        var padvt=$('#padvt').val();

        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        //document.getElementById('container').innerHTML = '<table widht="100%" align="center"><tr><td style=color:red><blink>Please Wait<blink></td></tr></table>';
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                var vcal = xmlhttp.responseText;
//                 alert(vcal);
                //document.getElementById('padvname').value=vcal;
                if (vcal != 0)
                {
                    vcal = vcal.split('~');
                    document.getElementById('padvname').value = vcal[0];
                    document.getElementById('padvmob').value = vcal[1];
                    document.getElementById('padvemail').value = vcal[2];
                    document.getElementById('padvyr').value = vcal[4];
                    $('#hd_p_barid').val(vcal[3]);
                }
                else
                    document.getElementById('padvname').value = vcal;
                /*document.getElementById('padvname').value = "";
                document.getElementById('padvmob').value ="";
                document.getElementById('padvemail').value = "";
                document.getElementById('padvyr').value = "";*/
            }
        }
        // ulr=" ../filing/get_adv_name.php" old
        var url = "Generation/get_adv_name"+"?advno=" + document.getElementById('padvno').value + "&advyr=" +
            document.getElementById('padvyr').value+"&ddl_pet_adv_state="+ddl_pet_adv_state+"&flag="+flag+'&padvt='+padvt;
        xmlhttp.open("GET", url, false);
//        if (document.getElementById('padvyr').value != '')
        xmlhttp.send(null);
    }
    else if (flag == 'R')
    {
        var ddl_res_adv_state=$('#ddl_res_adv_state').val();
        var radvt=$('#radvt').val();
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        //document.getElementById('container').innerHTML = '<table widht="100%" align="center"><tr><td style=color:red><blink>Please Wait<blink></td></tr></table>';
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                var vcal = xmlhttp.responseText;

                if (vcal != 0)
                {
                    vcal = vcal.split('~');
                    document.getElementById('radvname').value = vcal[0];
                    document.getElementById('radvmob').value = vcal[1];
                    document.getElementById('radvemail').value = vcal[2];
                    document.getElementById('radvyr').value = vcal[4];
                    $('#hd_r_barid').val(vcal[3]);
                }
                else
                    document.getElementById('radvname').value = vcal;
                /*document.getElementById('radvname').value = "";
                document.getElementById('radvmob').value ="";
                document.getElementById('radvemail').value = "";
                document.getElementById('radvyr').value = "";*/
            }
        }
        var url = "Generation/get_adv_name" + "?advno=" + document.getElementById('radvno').value + "&advyr=" +
            document.getElementById('radvyr').value+"&ddl_res_adv_state="+ddl_res_adv_state+"&flag="+flag+'&radvt='+radvt;
        xmlhttp.open("GET", url, false);
//        if (document.getElementById('radvyr').value != '')
        xmlhttp.send(null);
    }
}

function get_a_d_code(id)
{
    var id2 = id.split("_");
    //alert(id2[1]);
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    //document.getElementById('container').innerHTML = '<table widht="100%" align="center"><tr><td style=color:red><blink>Please Wait<blink></td></tr></table>';
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById(id + "_code").value = xmlhttp.responseText;
        }
    }
    var url = "new_filing_autocomp_" + id2[1] + ".php?falagofpost=code&val=" + document.getElementById(id).value;
    xmlhttp.open("GET", url, false);
    xmlhttp.send(null);
}

function onlynumbers(evt)
{
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    //alert(charCode);
    if ((charCode >= 48 && charCode <= 57) || charCode == 9 || charCode == 8) {
        return true;
    }
    return false;
}

function onlynumbersadv(evt)
{
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    //alert(charCode);
    if ((charCode >= 48 && charCode <= 57) || (charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122)
        || charCode == 9 || charCode == 8 || charCode == 45) {
        return true;
    }
    return false;
}
function remove_apos(value,id){
    var string = value.replace("'","");
    string = string.replace("#","No");
    string = string.replace("&","and");
    $("#"+id).val(string);
}
function onlyalpha(evt)
{
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    //alert(charCode);
    if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode == 9 || charCode == 8 ||
        charCode == 127 || charCode == 32 || charCode == 46 || charCode == 47 || charCode == 64) {
        return true;
    }
    return false;
}

function onlyalphab(evt)
{
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    //alert(charCode);
    if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || (charCode >= 48 && charCode <= 57)
        || charCode == 9 || charCode == 8 || charCode == 127 || charCode == 32 || charCode == 46 || charCode == 47 || charCode == 64
        || charCode == 40 || charCode == 41 || charCode == 37 || charCode == 39) {
        return true;
    }
    return false;
}

function noinput(evt)
{
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    //alert(charCode);
//    if (charCode==9) {
//    return true;
//    }
    return false;
}

function call_save_main(st_status)
{

//    var case_type = document.getElementById('selct');

    var pet_type = document.getElementById('selpt').value;
    var pet_name, pet_rel, pet_rel_name, pet_sex, pet_age, pet_post, pet_deptt, pet_add, pcity, pdis, pst, tpet,pcont;

    var res_type = document.getElementById('selrt').value;
    var res_name, res_rel, res_rel_name, res_sex, res_age, res_post, res_deptt, res_add, rcity, rdis, rst, tres,rcont;

//    if(case_type.value=='-1')
//    {
//        alert('Please Select Case Type');case_type.focus();return false;
//    }
//var chk_undertaking='N';
    var ddl_st_agncy=$('#ddl_st_agncy').val();
    var ddl_bench=$('#ddl_bench').val();
    var ddl_court=$('#ddl_court').val();
//var ddl_doc_u=$('#ddl_doc_u').val();
//var txt_undertakig=$('#txt_undertakig').val();
    var ddl_nature=$('#ddl_nature').val();
    var ddl_pet_adv_state=$('#ddl_pet_adv_state').val();
    var ddl_res_adv_state=$('#ddl_res_adv_state').val();
    if(ddl_court=='')
    {
        alert("Please select Court");
        $('#ddl_court').focus();
        return false;
    }
    if(ddl_st_agncy=='')
    {
        alert("Please select State");
        $('#ddl_st_agncy').focus();
        return false;
    }
    if(ddl_bench=='')
    {
        alert("Please select Bench");
        $('#ddl_bench').focus();
        return false;
    }
//if($('#chk_undertaking').is(':checked') && ddl_doc_u=='')
//    {
//        alert("Please select reason of Undertaking");
//        $('#txt_undertakig').focus();
//         return false;
//    }
//if($('#chk_undertaking').is(':checked') && ddl_doc_u=='10' && txt_undertakig=='')
//    {
//        alert("Please enter reason of Undertaking");
//        $('#txt_undertakig').focus();
//         return false;
//    }
    if(ddl_nature=='')
    {
        alert("Please select Case Type");
        return false;
    }
//    if($('#chk_undertaking').is(':checked'))
//    {
//        chk_undertaking='Y';
//    }
    var rmobi_full_mobile=$('#rmobi').val();
    var rmobd_full_mobile=$('#rmobd').val();

    var pmobi_full_mobile=$('#pmobi').val();
    var pmobd_full_mobile=$('#pmobd').val();

    if(pmobi_full_mobile.length != 0) {
        var full_mobile =pmobi_full_mobile;
        var is_mobile=pmobi_full_mobile.slice(0,1);
        var mailformat=is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile;
        if (document.getElementById('pmobi').value.match(mailformat))
        {
            alert('Please enter valid petitioner mobile no.');
            document.getElementById('pmobi').focus();
            return false;
        }
    }else if(pmobd_full_mobile.length != 0) {
        var full_mobile =pmobd_full_mobile;
        var is_mobile=pmobd_full_mobile.slice(0,1);
        var mailformat=is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile;
        if (document.getElementById('pmobd').value.match(mailformat))
        {
            alert('Please enter valid petitioner mobile no.');
            document.getElementById('pmobd').focus();
            return false;
        }
    }else if(rmobi_full_mobile.length != 0) {
        var full_mobile =rmobi_full_mobile;
        var is_mobile=rmobi_full_mobile.slice(0,1);
        var mailformat=is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile;
        if (document.getElementById('rmobi').value.match(mailformat))
        {
            alert('Please enter valid respondent mobile no.');
            document.getElementById('rmobi').focus();
            return false;
        }
    }else if(rmobd_full_mobile.length != 0) {
        var full_mobile =rmobd_full_mobile;
        var is_mobile=rmobd_full_mobile.slice(0,1);
        var mailformat=is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile+''+is_mobile;

        if (document.getElementById('rmobd').value.match(mailformat))
        {
            alert('Please enter valid respondent mobile no.');
            document.getElementById('rmobd').focus();
            return false;
        }
    }
    var hd_mn='';
    var cs_tp='';
    var txtFNo='';
    var txtYear='';
    if($('#hd_mn').length && $('#cs_tp').length && $('#txtFNo').length && $('#txtYear').length)
    {
        hd_mn=$('#hd_mn').val();
        cs_tp=$('#cs_tp').val();
        txtFNo=$('#txtFNo').val();
        txtYear=$('#txtYear').val();
    }

    if (pet_type == "I")
    {
        pet_name = document.getElementById('pet_name');
        pet_rel = document.getElementById('selprel');
        pet_rel_name = document.getElementById('prel');
        pet_sex = document.getElementById('psex');
        pet_age = document.getElementById('page');
        pet_add = document.getElementById('paddi');
        pcity = document.getElementById('pcityi');
        pdis = document.getElementById('selpdisi');
        pst = document.getElementById('selpsti');
        pcont = document.getElementById('p_conti');
        tpet = document.getElementById('p_noi');

       /* if(document.getElementById(pmobi).value.length != 0) {

        }*/


        if (pet_name.value == '')
        {
            alert('Please Enter Petitioner Name');
            pet_name.focus();
            return false;
        }
        /*if (pet_rel.value == '')
        {
            alert('Please Select Petitioner Relation');
            pet_rel.focus();
            return false;
        }
        if (pet_rel_name.value == '')
        {
            alert('Please Enter Petitioner Father/Husband Name');
            pet_rel_name.focus();
            return false;
        }
        if (pet_sex.value == '')
        {
            alert('Please Select Petitioner Gender');
            pet_sex.focus();
            return false;
        }*/
//        if(pet_age.value=='')
//        {
//            alert('Please Enter Petitioner Age');pet_age.focus();return false;
//        }
        if (pet_add.value == '')
        {
            alert('Please Enter Petitioner Address');
            pet_add.focus();
            return false;
        }
        if (pcity.value == '')
        {
            alert('Please Enter Petitioner City');
            pcity.focus();
            return false;
        }
        if(pcont.value=='96'){
            if (pst.value == '')
            {
                alert('Please Select Petitioner State');
                pst.focus();
                return false;
            }
            if (pdis.value == '')
            {
                alert('Please Select Petitioner District');
                pdis.focus();
                return false;
            }
        }
        if(pcont.value=="")
        {
            alert('Please Enter Petitioner Country');pcont.focus();return false;
        }

        if (document.getElementById('pemaili').value != '')
        {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (document.getElementById('pemaili').value.match(mailformat))
            {
                //return true;
            }
            else
            {
                alert('Please enter valid email');
                document.getElementById('pemaili').focus();
                return false;
            }
        }
        if (tpet.value == '' || tpet.value == 0)
        {
            alert('Total Pet(s) could not be null or zero');
            tpet.focus();
            return false;
        }
    }
    if (pet_type != "I")
    {
        pet_post = document.getElementById('pet_post');
        pet_deptt = document.getElementById('pet_deptt');
        pet_add = document.getElementById('paddd');
        pcity = document.getElementById('pcityd');
        pdis = document.getElementById('selpdisd');
        pst = document.getElementById('selpstd');
        pcont = document.getElementById('p_contd');
        tpet = document.getElementById('p_nod');
        if (pet_post.value == '')
        {
            alert('Please Enter Petitioner Post');
            pet_post.focus();
            return false;
        }
        if (pet_deptt.value == '')
        {
            alert('Please Enter Petitioner Department');
            pet_deptt.focus();
            return false;
        }
        if (pet_add.value == '')
        {
            alert('Please Enter Petitioner Address');
            pet_add.focus();
            return false;
        }
        if (pcity.value == '')
        {
            alert('Please Enter Petitioner City');
            pcity.focus();
            return false;
        }
        if(pcont.value=='96'){
            if (pst.value == '')
            {
                alert('Please Select Petitioner State');
                pst.focus();
                return false;
            }
            if (pdis.value == '')
            {
                alert('Please Select Petitioner District');
                pdis.focus();
                return false;
            }
        }
        if(pcont.value=="")
        {
            alert('Please Enter Petitioner Country');pcont.focus();return false;
        }
        if (document.getElementById('pemaild').value != '')
        {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (document.getElementById('pemaild').value.match(mailformat))
            {
                //return true;
            }
            else
            {
                alert('Please enter valid email');
                document.getElementById('pemaild').focus();
                return false;
            }
        }
        if (tpet.value == '' || tpet.value == 0)
        {
            alert('Total Pet(s) could not be null or zero');
            tpet.focus();
            return false;
        }


    }

    if (res_type == "I")
    {
        res_name = document.getElementById('res_name');
        res_rel = document.getElementById('selrrel');
        res_rel_name = document.getElementById('rrel');
        res_sex = document.getElementById('rsex');
        res_age = document.getElementById('rage');
        res_add = document.getElementById('raddi');
        rcity = document.getElementById('rcityi');
        rdis = document.getElementById('selrdisi');
        rst = document.getElementById('selrsti');
        rcont = document.getElementById('r_conti');
        tres = document.getElementById('r_noi');
        if (res_name.value == '')
        {
            alert('Please Enter Respondent Name');
            res_name.focus();
            return false;
        }
        /*if (res_rel.value == '')
        {
            alert('Please Select Respondent Relation');
            res_rel.focus();
            return false;
        }
        if (res_rel_name.value == '')
        {
            alert('Please Enter Respondent Father/Husband Name');
            res_rel_name.focus();
            return false;
        }
        if (res_sex.value == '')
        {
            alert('Please Select Respondent Gender');
            res_sex.focus();
            return false;
        }*/
//        if(res_age.value=='')
//        {
//            alert('Please Enter Respondent Age');res_age.focus();return false;
//        }
        if (res_add.value == '')
        {
            alert('Please Enter Respondent Address');
            res_add.focus();
            return false;
        }
        if (rcity.value == '')
        {
            alert('Please Enter Respondent City');
            rcity.focus();
            return false;
        }
        if(rcont.value=='96'){
            if (rst.value == '')
            {
                alert('Please Select Respondent State');
                rst.focus();
                return false;
            }
            if (rdis.value == '')
            {
                alert('Please Select Respondent District');
                rdis.focus();
                return false;
            }
        }
        if(rcont.value=="")
        {
            alert('Please Enter Respondent Country');rcont.focus();return false;
        }
        if (document.getElementById('remaili').value != '')
        {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (document.getElementById('remaili').value.match(mailformat))
            {
                //return true;
            }
            else
            {
                alert('Please enter valid email');
                document.getElementById('remaili').focus();
                return false;
            }
        }
        if (tres.value == '' || tres.value == 0)
        {
            alert('Total Res(s) could not be null or zero');
            tres.focus();
            return false;
        }
    }
    if (res_type != "I")
    {
        res_post = document.getElementById('res_post');
        res_deptt = document.getElementById('res_deptt');
        res_add = document.getElementById('raddd');
        rcity = document.getElementById('rcityd');
        rdis = document.getElementById('selrdisd');
        rst = document.getElementById('selrstd');
        rcont = document.getElementById('r_contd');
        tres = document.getElementById('r_nod');
        if (res_post.value == '')
        {
            alert('Please Enter Respondent Post');
            res_post.focus();
            return false;
        }
        if (res_deptt.value == '')
        {
            alert('Please Enter Respondent Department');
            res_deptt.focus();
            return false;
        }
        if (res_add.value == '')
        {
            alert('Please Enter Respondent Address');
            res_add.focus();
            return false;
        }
        if (rcity.value == '')
        {
            alert('Please Enter Respondent City');
            rcity.focus();
            return false;
        }
        if(rcont.value=='96'){
            if (rst.value == '')
            {
                alert('Please Select Respondent State');
                rst.focus();
                return false;
            }
            if (rdis.value == '')
            {
                alert('Please Select Respondent District');
                rdis.focus();
                return false;
            }
        }
        if(rcont.value=="")
        {
            alert('Please Enter Respondent Country');rcont.focus();return false;
        }
        if (document.getElementById('remaild').value != '')
        {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (document.getElementById('remaild').value.match(mailformat))
            {
                //return true;
            }
            else
            {
                alert('Please enter valid email');
                document.getElementById('remaild').focus();
                return false;
            }
        }
        if (tres.value == '' || tres.value == 0)
        {
            alert('Total Res(s) could not be null or zero');
            tres.focus();
            return false;
        }
    }

//    if(document.getElementById('padvname').value==''||document.getElementById('padvname').value==0)
//    {
//        alert('Please Enter Petitioner Advocate No and Year Properly');
//        document.getElementById('padvno').focus();return false;
//    }
//    if(document.getElementById('radvname').value==''||document.getElementById('radvname').value==0)
//    {
//        alert('Please Enter Respondent Advocate No and Year Properly');
//        document.getElementById('radvno').focus();return false;
//    }

    /*
        if (document.getElementById('padvemail').value != '')
        {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (document.getElementById('padvemail').value.match(mailformat))
            {
                //return true;
            }
            else
            {
                alert('Please enter valid email');
                document.getElementById('padvemail').focus();
                return false;
            }
        }

        if (document.getElementById('radvemail').value != '')
        {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (document.getElementById('radvemail').value.match(mailformat))
            {
                //return true;
            }
            else
            {
                alert('Please enter valid email');
                document.getElementById('radvemail').focus();
                return false;
            }
        }
    */
    document.getElementById('svbtn').disabled = 'true';
    var hd_r_barid=$('#hd_r_barid').val();
    var hd_p_barid= $('#hd_p_barid').val();
    var txt_court_fee=$('#txt_court_fee').val();

    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    //document.getElementById('container').innerHTML = '<table widht="100%" align="center"><tr><td style=color:red><blink>Please Wait<blink></td></tr></table>';
    xmlhttp.onreadystatechange = function()
    {  //document.getElementById('svbtn').disabled = 'false';
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var res = xmlhttp.responseText;

            res = res.split('!~!');
            //alert('hello '+res[0]);
            //alert('bye'+res[1]);
            document.getElementById('show_fil').innerHTML = res[1];
            //document.getElementById('show_fil_Ajaxcall').innerHTML = res[1];
        }
    }
//    var url = "save_new_filing.php?controller=I"  + "&st_status=" + st_status+
//            "&ddl_st_agncy="+ddl_st_agncy+"&ddl_bench="+ddl_bench+"&hd_mn="+hd_mn+"&cs_tp="+cs_tp+"&txtFNo="+txtFNo+"&txtYear="+txtYear+
//            "&ddl_court="+ddl_court+"&chk_undertaking="+chk_undertaking+"&txt_undertakig="+txt_undertakig+"&ddl_nature="+ddl_nature+"&ddl_doc_u="+
//            ddl_doc_u+"&ddl_pet_adv_state="+ddl_pet_adv_state+"&ddl_res_adv_state="+ddl_res_adv_state;

    var url = "/Caveat/Generation/save_caveat?controller=I"  + "&st_status=" + st_status+
        "&ddl_st_agncy="+ddl_st_agncy+"&ddl_bench="+ddl_bench+"&hd_mn="+hd_mn+"&cs_tp="+cs_tp+"&txtFNo="+txtFNo+"&txtYear="+txtYear+
        "&ddl_court="+ddl_court+"&ddl_nature="+ddl_nature+"&ddl_pet_adv_state="+ddl_pet_adv_state+
        "&ddl_res_adv_state="+ddl_res_adv_state+"&hd_r_barid="+hd_r_barid+"&hd_p_barid="+hd_p_barid+"&txt_court_fee="+txt_court_fee;

    if (pet_type == "I")
        url = url + "&pname=" + pet_name.value + "&pet_rel=" + pet_rel.value + "&pet_rel_name=" + pet_rel_name.value + "&p_sex=" + pet_sex.value
            + "&p_age=" + pet_age.value + "&pocc=" + document.getElementById('pocc').value + "&pp=" + document.getElementById('ppini').value
            + "&pmob=" + document.getElementById('pmobi').value + "&pemail=" + document.getElementById('pemaili').value;
    if (pet_type != "I")
        url = url + "&pet_post=" + pet_post.value + "&pet_deptt=" + pet_deptt.value + "&pp=" + document.getElementById('ppind').value
            + "&pmob=" + document.getElementById('pmobd').value + "&pemail=" + document.getElementById('pemaild').value
            +"&pet_statename=" + document.getElementById('pet_statename').value+"&pet_statename_hd=" + document.getElementById('pet_statename_hd').value;

    url = url + "&padd=" + pet_add.value + "&pcity=" + pcity.value + "&pdis=" + pdis.value + "&pst=" + pst.value + "&p_type=" + pet_type+ "&p_cont=" + pcont.value;


    if (res_type == "I")
        url = url + "&rname=" + res_name.value + "&res_rel=" + res_rel.value + "&res_rel_name=" + res_rel_name.value + "&r_sex=" + res_sex.value
            + "&r_age=" + res_age.value + "&rocc=" + document.getElementById('rocc').value + "&rp=" + document.getElementById('rpini').value
            + "&rmob=" + document.getElementById('rmobi').value + "&remail=" + document.getElementById('remaili').value;
    if (res_type != "I")
        url = url + "&res_post=" + res_post.value + "&res_deptt=" + res_deptt.value + "&rp=" + document.getElementById('rpind').value
            + "&rmob=" + document.getElementById('rmobd').value + "&remail=" + document.getElementById('remaild').value
            +"&res_statename=" + document.getElementById('res_statename').value+"&res_statename_hd=" + document.getElementById('res_statename_hd').value;

    url = url + "&radd=" + res_add.value + "&rcity=" + rcity.value + "&rdis=" + rdis.value + "&rst=" + rst.value + "&r_type=" + res_type+ "&r_cont=" + rcont.value;

    if (document.getElementById('padvt').value == 'S')
        url = url + "&padvno=" + document.getElementById('padvno').value + "&padvyr=" + document.getElementById('padvyr').value
            + "&padvmob=" + document.getElementById('padvmob').value + "&padvemail=" + document.getElementById('padvemail').value;

    if (document.getElementById('padvt').value == 'C')
        url = url + "&padvno=" + document.getElementById('padvno').value + "&padvyr=" + document.getElementById('padvyr').value;

    url = url + "&padvname=" + document.getElementById('padvname').value;

    if (document.getElementById('radvt').value == 'S')
        url = url + "&radvno=" + document.getElementById('radvno').value + "&radvyr=" + document.getElementById('radvyr').value
            + "&radvmob=" + document.getElementById('radvmob').value + "&radvemail=" + document.getElementById('radvemail').value;

    if (document.getElementById('radvt').value == 'C')
        url = url + "&radvno=" + document.getElementById('radvno').value + "&radvyr=" + document.getElementById('radvyr').value;

    url = url + "&radvname=" + document.getElementById('radvname').value;

    url = url + "&padtype=" + document.getElementById('padvt').value + "&radtype=" + document.getElementById('radvt').value;

    url = url + "&pp_code=" + document.getElementById('pet_post_code').value + "&rp_code=" + document.getElementById('res_post_code').value
        + "&t_pet=" + tpet.value + "&t_res=" + tres.value
        +"&pd_code=" + document.getElementById('pet_deptt_code').value + "&rd_code=" + document.getElementById('res_deptt_code').value;

    /*+ "&type_special=" + document.getElementById('type_special').value
    var state_department_in_pet = $("#state_department_in_pet").val().split('->');
    var state_department_in_res = $("#state_department_in_res").val().split('->');

    url = url + "&pd_code=" + state_department_in_pet[0] + "&rd_code=" + state_department_in_res[0];*/


    // alert(url);
    alert('Do you want to save data');
    url = encodeURI(url);
    xmlhttp.open("GET", url, false);
    xmlhttp.send(null);
}

function call_fullReset_main()
{
    if (document.getElementById('selpt').value == 'I')
    {
        document.getElementById('pet_name').value = "";
        document.getElementById('selprel').value = "";
        document.getElementById('prel').value = "";
        document.getElementById('psex').value = "";
        document.getElementById('page').value = "";
        document.getElementById('pocc').value = "";
        document.getElementById('paddi').value = "";
        document.getElementById('pcityi').value = "";
        document.getElementById('ppini').value = "";
        document.getElementById('selpdisi').value = "";
        document.getElementById('selpsti').value = "23";
        document.getElementById('pmobi').value = "";
        document.getElementById('pemaili').value = "";
        document.getElementById('p_noi').value = "1";
    }
    else if (document.getElementById('selpt').value != 'I')
    {
        document.getElementById('pet_post').value = "";
        document.getElementById('pet_deptt').value = "";
        document.getElementById('pet_statename').value = "";
        document.getElementById('paddd').value = "";
        document.getElementById('pcityd').value = "";
        document.getElementById('ppind').value = "";
        document.getElementById('selpdisd').value = "";
        document.getElementById('selpstd').value = "23";
        document.getElementById('pmobd').value = "";
        document.getElementById('pemaild').value = "";
        document.getElementById('p_nod').value = "1";
    }
    if (document.getElementById('selrt').value == 'I')
    {
        document.getElementById('res_name').value = "";
        document.getElementById('selrrel').value = "";
        document.getElementById('rrel').value = "";
        document.getElementById('rsex').value = "";
        document.getElementById('rage').value = "";
        document.getElementById('rocc').value = "";
        document.getElementById('raddi').value = "";
        document.getElementById('rcityi').value = "";
        document.getElementById('rpini').value = "";
        document.getElementById('selrdisi').value = "";
        document.getElementById('selrsti').value = "23";
        document.getElementById('rmobi').value = "";
        document.getElementById('remaili').value = "";
        document.getElementById('r_noi').value = "1";
    }
    else if (document.getElementById('selrt').value != 'I')
    {
        document.getElementById('res_post').value = "";
        document.getElementById('res_deptt').value = "";
        document.getElementById('res_statename').value = "";
        document.getElementById('raddd').value = "";
        document.getElementById('rcityd').value = "";
        document.getElementById('rpind').value = "";
        document.getElementById('selrdisd').value = "";
        document.getElementById('selrstd').value = "23";
        document.getElementById('rmobd').value = "";
        document.getElementById('remaild').value = "";
        document.getElementById('r_nod').value = "1";
    }
    document.getElementById('selpt').value = 'I';
    document.getElementById('selrt').value = 'I';
//    document.getElementById('selct').value='-1'
//    document.getElementById('case_doc').value='';
    document.getElementById('padvno').value = "";
    document.getElementById('padvyr').value = "";
    document.getElementById('padvname').value = "";
    document.getElementById('padvmob').value = "";
    document.getElementById('padvemail').value = "";
    document.getElementById('radvno').value = "";
    document.getElementById('radvyr').value = "";
    document.getElementById('radvname').value = "";
    document.getElementById('radvmob').value = "";
    document.getElementById('radvemail').value = "";
    document.getElementById('for_I_p').style.display = 'block';
    document.getElementById('for_D_p').style.display = 'none';
    document.getElementById('for_I_r').style.display = 'block';
    document.getElementById('for_D_r').style.display = 'none';
}

function chk_cat_low(lst_case, txtcaseno, txtyear, fil_no)
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            // var txtAdeshika="txtAdeshika"+rowCount;
            document.getElementById('hdd_low_cc').innerHTML = xmlhttp.responseText;
            var s_op = '';
            var ccl = document.getElementById('hd_low_ca').value;
            if (ccl <= 0)
            {
                s_op = 'spsubsubmenu_1';
            }
            else if (ccl > 0)
            {
                s_op = 'spsubsubmenu_2';
            }
            h1_bak('spsubmenu_2', s_op, lst_case, txtcaseno, txtyear, fil_no, '', '1');
        }
    }
// xmlhttp.open("GET","getReport51-II.php?seljudgename="+seljudgename+"&frm="+frm+"&toDate="+toDate,true);
    xmlhttp.open("GET", "get_chk_cat_low.php?fil_no_bak_cc=" + fil_no, true);
    xmlhttp.send(null);
}

function check_for_right_selection(id)
{
    var input_string = $("#" + id).val().split('->');
    if (!isNaN(input_string[0]))
    {
        $("#" + id).focus();
        $("#" + id).get(0).setSelectionRange(0, 0);
    }
    else
    {
        alert("Proper Department was Not Selected, the Box will gone Empty");
        $("#" + id).val("");
    }
}

function getDistrict(side, id, val,hd_city) { //return true;//SCI
    if (val==''){return true;}
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (side == 'P') {
                if (id == 'selpsti')
                {
                    document.getElementById('selpdisi').innerHTML = xmlhttp.responseText;
                    document.getElementById('selpdisi').value=hd_city;
                }
                else if (id == 'selpstd')
                {
                    document.getElementById('selpdisd').innerHTML = xmlhttp.responseText;
                    document.getElementById('selpdisd').value=hd_city;
                }
            }
            else if (side == 'R') {
                if (id == 'selrsti')
                {
                    document.getElementById('selrdisi').innerHTML = xmlhttp.responseText;
                    document.getElementById('selrdisi').value=hd_city;
                }
                else if (id == 'selrstd')
                {
                    document.getElementById('selrdisd').innerHTML = xmlhttp.responseText;
                    document.getElementById('selrdisd').value=hd_city;
                }
            }
        }
    }
    //xmlhttp.open("GET", "../filing/get_district.php?state=" + val, true);
    xmlhttp.open("GET", "/Common/Ajaxcalls/get_districts?state_id=" + val, true);
    xmlhttp.send(null);
}



function get_case_no()
{
    $('.dv_nw_efi_no').css('display', 'none');

    var txt_p_no = $('#txt_p_no').val();
    var txt_yr = $('#txt_yr').val();
    if (txt_p_no == '' || txt_yr == '')
    {
        if (txt_p_no == '')
        {
            alert("Please enter Provisional No.");
            $('#txt_p_no').focus();
        }
        else if (txt_yr == '')
        {
            alert("Please enter Provisional Year");
            $('#txt_yr').focus();
        }

    }
    else
    {
        call_getDetails(txt_p_no, txt_yr)
//    $.ajax({
//                            url:'get_case_no.php',
//                            type:"GET",
//                            cache:false,
//                            async:true,
//                            beforeSend:function(){
//                                $('#show_fil').html('<table widht="100%" align="center"><tr><td><img src="preloader.gif"/></td></tr></table>');
//                            },
//                            data:{txt_p_no:txt_p_no,txt_yr:txt_yr},
//                            success:function(data,status){
//
//                            $('#dv_efiling').html(data);
//                            var hd_f_f_no=$('#hd_f_f_no').val();
//                            if(hd_f_f_no==1)
//                                {
//                                    var hd_res_e_fil=$('#hd_res_e_fil').val();
//                                      call_getDetails(hd_res_e_fil);
//                                        alert(hd_res_e_fil);
//                                }
//                            else  if(hd_f_f_no==0)
//                                {
//                                      $('#show_fil').css('text-align','center');
//                                     $('#show_fil').html('<b>No Record Found</b>');
//
//                                }
//
////                                if(data=='No Record Found')
////                                    {
////                                         $('#show_fil').html(data);
////                                    }
////                                    else
////                                        {
////                                            call_getDetails(data)
////                                        }
//                            },
//                            error:function(xhr){
//                                alert("Error: "+xhr.status+' '+xhr.statusText);
//                            }
//                        });
    }
}

function call_getDetails(txt_p_no, txt_yr)
{
//    var ct = document.getElementById('selct').value;
//    var cn = document.getElementById('case_no').value;
//    var cy = document.getElementById('case_yr').value;
//    var bench = document.getElementById('bench').value;
//    if(ct=="-1")
//    {
//        alert('Please Select Case Type');document.getElementById('selct').focus();return false;
//    }
//    if(ct.length=='1')
//        ct = '00'+ct;
//    else if(ct.length=='2')
//        ct = '0'+ct;
//    if(cn=="")
//    {
//        alert('Please Enter Case No.');document.getElementById('case_no').focus();return false;
//    }
//    if(cy=="")
//    {
//        alert('Please Enter Case Year');document.getElementById('case_yr').focus();return false;
//    }
//    var fno = bench+ct+cn+cy;
//    var fno =data;
//    var bench=data.substr(0, 2);
//    alert(fno);
//    alert(bench);
//    document.getElementById('fil_hd').value=fno;
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    //document.getElementById('container').innerHTML = '<table widht="100%" align="center"><tr><td style=color:red><blink>Please Wait<blink></td></tr></table>';
    $('#show_fil').html('<table widht="100%" align="center"><tr><td><img src="preloader.gif"/></td></tr></table>');
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById('show_fil').innerHTML = xmlhttp.responseText;
//           $('#selct').attr('disabled',true);
        }
    }
    var url = "get_filing_mod_efil.php?txt_p_no=" + txt_p_no + "&txt_yr=" + txt_yr;
    xmlhttp.open("GET", url, false);
    xmlhttp.send(null);
}



function call_save_main_efil(st_status)
{
    var txt_p_no = document.getElementById('txt_p_no').value;
    var txt_yr = document.getElementById('txt_yr').value;

//    var case_type = document.getElementById('selct');

    var pet_type = document.getElementById('selpt').value;
    var pet_name, pet_rel, pet_rel_name, pet_sex, pet_age, pet_post, pet_deptt, pet_add, pcity, pdis, pst, tpet;

    var res_type = document.getElementById('selrt').value;
    var res_name, res_rel, res_rel_name, res_sex, res_age, res_post, res_deptt, res_add, rcity, rdis, rst, tres;

//    if(case_type.value=='-1')
//    {
//        alert('Please Select Case Type');case_type.focus();return false;
//    }
    if (pet_type == "I")
    {
        pet_name = document.getElementById('pet_name');
        pet_rel = document.getElementById('selprel');
        pet_rel_name = document.getElementById('prel');
        pet_sex = document.getElementById('psex');
        pet_age = document.getElementById('page');
        pet_add = document.getElementById('paddi');
        pcity = document.getElementById('pcityi');
        pdis = document.getElementById('selpdisi');
        pst = document.getElementById('selpsti');
        tpet = document.getElementById('p_noi');
        if (pet_name.value == '')
        {
            alert('Please Enter Petitioner Name');
            pet_name.focus();
            return false;
        }
        if (pet_rel.value == '')
        {
            alert('Please Select Petitioner Relation');
            pet_rel.focus();
            return false;
        }
        if (pet_rel_name.value == '')
        {
            alert('Please Enter Petitioner Father/Husband Name');
            pet_rel_name.focus();
            return false;
        }
        if (pet_sex.value == '')
        {
            alert('Please Select Petitioner Sex');
            pet_sex.focus();
            return false;
        }
//        if(pet_age.value=='')
//        {
//            alert('Please Enter Petitioner Age');pet_age.focus();return false;
//        }
        if (pet_add.value == '')
        {
            alert('Please Enter Petitioner Address');
            pet_add.focus();
            return false;
        }
        if (pcity.value == '')
        {
            alert('Please Enter Petitioner City');
            pcity.focus();
            return false;
        }
        if (pdis.value == '')
        {
            alert('Please Select Petitioner District');
            pdis.focus();
            return false;
        }
        if (pst.value == '')
        {
            alert('Please Select Petitioner State');
            pst.focus();
            return false;
        }
        if (document.getElementById('pemaili').value != '')
        {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (document.getElementById('pemaili').value.match(mailformat))
            {
                //return true;
            }
            else
            {
                alert('Please enter valid email');
                document.getElementById('pemaili').focus();
                return false;
            }
        }
        if (tpet.value == '' || tpet.value == 0)
        {
            alert('Total Pet(s) could not be null or zero');
            tpet.focus();
            return false;
        }
    }
    if (pet_type != "I")
    {
        pet_post = document.getElementById('pet_post');
        pet_deptt = document.getElementById('pet_deptt');
        pet_add = document.getElementById('paddd');
        pcity = document.getElementById('pcityd');
        pdis = document.getElementById('selpdisd');
        pst = document.getElementById('selpstd');
        tpet = document.getElementById('p_nod');
        if (pet_post.value == '')
        {
            alert('Please Enter Petitioner Post');
            pet_post.focus();
            return false;
        }
        if (pet_deptt.value == '')
        {
            alert('Please Enter Petitioner Department');
            pet_deptt.focus();
            return false;
        }
        if (pet_add.value == '')
        {
            alert('Please Enter Petitioner Address');
            pet_add.focus();
            return false;
        }
        if (pcity.value == '')
        {
            alert('Please Enter Petitioner City');
            pcity.focus();
            return false;
        }
        if (pdis.value == '')
        {
            alert('Please Select Petitioner District');
            pdis.focus();
            return false;
        }
        if (pst.value == '')
        {
            alert('Please Select Petitioner State');
            pst.focus();
            return false;
        }
        if (document.getElementById('pemaild').value != '')
        {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (document.getElementById('pemaild').value.match(mailformat))
            {
                //return true;
            }
            else
            {
                alert('Please enter valid email');
                document.getElementById('pemaild').focus();
                return false;
            }
        }
        if (tpet.value == '' || tpet.value == 0)
        {
            alert('Total Pet(s) could not be null or zero');
            tpet.focus();
            return false;
        }
    }


    if (res_type == "I")
    {
        res_name = document.getElementById('res_name');
        res_rel = document.getElementById('selrrel');
        res_rel_name = document.getElementById('rrel');
        res_sex = document.getElementById('rsex');
        res_age = document.getElementById('rage');
        res_add = document.getElementById('raddi');
        rcity = document.getElementById('rcityi');
        rdis = document.getElementById('selrdisi');
        rst = document.getElementById('selrsti');
        tres = document.getElementById('r_noi');
        if (res_name.value == '')
        {
            alert('Please Enter Respondent Name');
            res_name.focus();
            return false;
        }
        if (res_rel.value == '')
        {
            alert('Please Select Respondent Relation');
            res_rel.focus();
            return false;
        }
        if (res_rel_name.value == '')
        {
            alert('Please Enter Respondent Father/Husband Name');
            res_rel_name.focus();
            return false;
        }
        if (res_sex.value == '')
        {
            alert('Please Select Respondent Sex');
            res_sex.focus();
            return false;
        }
//        if(res_age.value=='')
//        {
//            alert('Please Enter Respondent Age');res_age.focus();return false;
//        }
        if (res_add.value == '')
        {
            alert('Please Enter Respondent Address');
            res_add.focus();
            return false;
        }
        if (rcity.value == '')
        {
            alert('Please Enter Respondent City');
            rcity.focus();
            return false;
        }
        if (rdis.value == '')
        {
            alert('Please Select Respondent District');
            rdis.focus();
            return false;
        }
        if (rst.value == '')
        {
            alert('Please Select Respondent State');
            rst.focus();
            return false;
        }
        if (document.getElementById('remaili').value != '')
        {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (document.getElementById('remaili').value.match(mailformat))
            {
                //return true;
            }
            else
            {
                alert('Please enter valid email');
                document.getElementById('remaili').focus();
                return false;
            }
        }
        if (tres.value == '' || tres.value == 0)
        {
            alert('Total Res(s) could not be null or zero');
            tres.focus();
            return false;
        }
    }
    if (res_type != "I")
    {
        res_post = document.getElementById('res_post');
        res_deptt = document.getElementById('res_deptt');
        res_add = document.getElementById('raddd');
        rcity = document.getElementById('rcityd');
        rdis = document.getElementById('selrdisd');
        rst = document.getElementById('selrstd');
        tres = document.getElementById('r_nod');
        if (res_post.value == '')
        {
            alert('Please Enter Respondent Post');
            res_post.focus();
            return false;
        }
        if (res_deptt.value == '')
        {
            alert('Please Enter Respondent Department');
            res_deptt.focus();
            return false;
        }
        if (res_add.value == '')
        {
            alert('Please Enter Respondent Address');
            res_add.focus();
            return false;
        }
        if (rcity.value == '')
        {
            alert('Please Enter Respondent City');
            rcity.focus();
            return false;
        }
        if (rdis.value == '')
        {
            alert('Please Select Respondent District');
            rdis.focus();
            return false;
        }
        if (rst.value == '')
        {
            alert('Please Select Respondent State');
            rst.focus();
            return false;
        }
        if (document.getElementById('remaild').value != '')
        {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (document.getElementById('remaild').value.match(mailformat))
            {
                //return true;
            }
            else
            {
                alert('Please enter valid email');
                document.getElementById('remaild').focus();
                return false;
            }
        }
        if (tres.value == '' || tres.value == 0)
        {
            alert('Total Res(s) could not be null or zero');
            tres.focus();
            return false;
        }
    }

//    if(document.getElementById('padvname').value==''||document.getElementById('padvname').value==0)
//    {
//        alert('Please Enter Petitioner Advocate No and Year Properly');
//        document.getElementById('padvno').focus();return false;
//    }
//    if(document.getElementById('radvname').value==''||document.getElementById('radvname').value==0)
//    {
//        alert('Please Enter Respondent Advocate No and Year Properly');
//        document.getElementById('radvno').focus();return false;
//    }

    if (document.getElementById('padvemail').value != '')
    {
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (document.getElementById('padvemail').value.match(mailformat))
        {
            //return true;
        }
        else
        {
            alert('Please enter valid email');
            document.getElementById('padvemail').focus();
            return false;
        }
    }
    if (document.getElementById('radvemail').value != '')
    {
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (document.getElementById('radvemail').value.match(mailformat))
        {
            //return true;
        }
        else
        {
            alert('Please enter valid email');
            document.getElementById('radvemail').focus();
            return false;
        }
    }

    document.getElementById('svbtn').disabled = 'true';


    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    //document.getElementById('container').innerHTML = '<table widht="100%" align="center"><tr><td style=color:red><blink>Please Wait<blink></td></tr></table>';
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var res = xmlhttp.responseText;
            res = res.split('!~!');
            document.getElementById('show_fil').innerHTML = res[1];
        }
    }
    var url = "save_new_filing.php?controller=I" + '&txt_p_no=' + txt_p_no + '&txt_yr=' + txt_yr + "&st_status=" + st_status;

    if (pet_type == "I")
        url = url + "&pname=" + pet_name.value + "&pet_rel=" + pet_rel.value + "&pet_rel_name=" + pet_rel_name.value + "&p_sex=" + pet_sex.value
            + "&p_age=" + pet_age.value + "&pocc=" + document.getElementById('pocc').value + "&pp=" + document.getElementById('ppini').value
            + "&pmob=" + document.getElementById('pmobi').value + "&pemail=" + document.getElementById('pemaili').value;
    if (pet_type != "I")
        url = url + "&pet_post=" + pet_post.value + "&pet_deptt=" + pet_deptt.value + "&pp=" + document.getElementById('ppind').value
            + "&pmob=" + document.getElementById('pmobd').value + "&pemail=" + document.getElementById('pemaild').value
            +"&pet_statename=" + document.getElementById('pet_statename').value+"&pet_statename_hd=" + document.getElementById('pet_statename_hd').value;

    url = url + "&padd=" + pet_add.value + "&pcity=" + pcity.value + "&pdis=" + pdis.value + "&pst=" + pst.value + "&p_type=" + pet_type;


    if (res_type == "I")
        url = url + "&rname=" + res_name.value + "&res_rel=" + res_rel.value + "&res_rel_name=" + res_rel_name.value + "&r_sex=" + res_sex.value
            + "&r_age=" + res_age.value + "&rocc=" + document.getElementById('rocc').value + "&rp=" + document.getElementById('rpini').value
            + "&rmob=" + document.getElementById('rmobi').value + "&remail=" + document.getElementById('remaili').value;
    if (res_type != "I")
        url = url + "&res_post=" + res_post.value + "&res_deptt=" + res_deptt.value + "&rp=" + document.getElementById('rpind').value
            + "&rmob=" + document.getElementById('rmobd').value + "&remail=" + document.getElementById('remaild').value
            +"&res_statename=" + document.getElementById('res_statename').value+"&res_statename_hd=" + document.getElementById('res_statename_hd').value;

    url = url + "&radd=" + res_add.value + "&rcity=" + rcity.value + "&rdis=" + rdis.value + "&rst=" + rst.value + "&r_type=" + res_type;

    if (document.getElementById('padvt').value == 'S')
        url = url + "&padvno=" + document.getElementById('padvno').value + "&padvyr=" + document.getElementById('padvyr').value
            + "&padvmob=" + document.getElementById('padvmob').value + "&padvemail=" + document.getElementById('padvemail').value;

    url = url + "&padvname=" + document.getElementById('padvname').value;

    if (document.getElementById('radvt').value == 'S')
        url = url + "&radvno=" + document.getElementById('radvno').value + "&radvyr=" + document.getElementById('radvyr').value
            + "&radvmob=" + document.getElementById('radvmob').value + "&radvemail=" + document.getElementById('radvemail').value;

    url = url + "&radvname=" + document.getElementById('radvname').value;

    url = url + "&padtype=" + document.getElementById('padvt').value + "&radtype=" + document.getElementById('radvt').value;

    url = url + "&pp_code=" + document.getElementById('pet_post_code').value + "&rp_code=" + document.getElementById('res_post_code').value
        + "&t_pet=" + tpet.value + "&t_res=" + tres.value
        + "&type_special=" + document.getElementById('type_special').value;

    /*var state_department_in_pet = $("#state_department_in_pet").val().split('->');
    var state_department_in_res = $("#state_department_in_res").val().split('->');

    url = url + "&pd_code=" + state_department_in_pet[0] + "&rd_code=" + state_department_in_res[0];*/

//    if(case_type.value=='52')
//    {
//        url = url+"&bailno="+document.getElementById('bno').value+"&subcat1=";
//        if(document.getElementById('rbtn4').checked)
//            url = url+"4";
//        else if(document.getElementById('rbtn5').checked)
//            url = url+"5";
//        else
//            url = url+"0";
//    }
    //alert(url);
    url = encodeURI(url);
    xmlhttp.open("GET", url, false);
    xmlhttp.send(null);
}

$(document).ready(function() {
    $(document).on('change', '#ddl_st_agncy,#ddl_court', function() {
        get_benches('0');
        get_casetype();
    });
    $(document).on('change', '#ddl_bench', function() {
        var ddl_st_agncy = $('#ddl_st_agncy').val();
        var ddl_bench = $('#ddl_bench').val();
        var ddl_court=$('#ddl_court').val();return true;
        $.ajax({
            url: '../filing/get_case_strc.php',
            cache: false,
            async: true,
            data: {ddl_st_agncy: ddl_st_agncy, ddl_bench: ddl_bench,ddl_court:ddl_court},
            beforeSend: function() {
                $('#dv_ent_z').html('<table widht="100%" align="center"><tr><td><img src="../images/preloader.gif"/></td></tr></table>');
            },
            type: 'POST',
            success: function(data, status) {

                $('#dv_case_no').html(data);


            },
            error: function(xhr) {
                alert("Error: " + xhr.status + " " + xhr.statusText);
            }

        });
    });

    $(document).on('click', '.cl_rdn_p', function() {

        var idd = $(this).attr('id');

        var sp_idd = idd.split('rdn_p');
        var hd_state = $('#hd_state' + sp_idd[1]).val();
        var hd_city = $('#hd_city' + sp_idd[1]).val();
        var hd_ind_dep = $('#hd_ind_dep' + sp_idd[1]).val();
        var dis_id='';
        if(hd_ind_dep=='I')
            dis_id="selpsti";
        else
            dis_id="selpstd";

        getDistrict('P', dis_id, hd_state,hd_city);

        var rdn_p_r = $('#rdn_p' + sp_idd[1]).val();
//        alert('sdsdsd' + rdn_p_r);
        var f_no = $('#hd_fil_no' + sp_idd[1]).val();
        var hd_pet_res = $('#hd_pet_res' + sp_idd[1]).val();
        var hd_sr_no = $('#hd_sr_no' + sp_idd[1]).val();
        var sp_partyname = $('#sp_partyname' + sp_idd[1]).html();

        var hd_sonof = $('#hd_sonof' + sp_idd[1]).val();
        var hd_prfhname = $('#hd_prfhname' + sp_idd[1]).val();
        var hd_sex = $('#hd_sex' + sp_idd[1]).val();
        var hd_age = $('#hd_age' + sp_idd[1]).val();
        var hd_addr1 = $('#hd_addr1' + sp_idd[1]).val();
        var hd_addr2 = $('#hd_addr2' + sp_idd[1]).val();
        var hd_dstname = $('#hd_dstname' + sp_idd[1]).val();
        var hd_pin = $('#hd_pin' + sp_idd[1]).val();
//        var hd_state = $('#hd_state' + sp_idd[1]).val();
//        var hd_city = $('#hd_city' + sp_idd[1]).val();
        var hd_contact = $('#hd_contact' + sp_idd[1]).val();
        var hd_email = $('#hd_email' + sp_idd[1]).val();
        var hd_deptcode=$('#hd_deptcode'+ sp_idd[1]).val();
        var hd_authcode=$('#hd_authcode'+ sp_idd[1]).val();
        $('.cl_rdn_p').each(function() {
            if (idd == $(this).attr('id'))
                $(this).prop('checked', true);
            else
                $(this).prop('checked', false);
        });
        get_part_detail(f_no, hd_pet_res, hd_sr_no, sp_partyname, rdn_p_r, hd_ind_dep, hd_sonof, hd_prfhname, hd_sex, hd_age, hd_addr1, hd_addr2,
            hd_dstname, hd_pin, hd_state, hd_city, hd_contact, hd_email,hd_deptcode,hd_authcode);

    });
    $(document).on('click', '.cl_rdn_r', function() {
        var idd = $(this).attr('id');
        var sp_idd = idd.split('rdn_r');

        var hd_state = $('#hd_state' + sp_idd[1]).val();
        var hd_city = $('#hd_city' + sp_idd[1]).val();
        var hd_ind_dep = $('#hd_ind_dep' + sp_idd[1]).val();
        var dis_id='';
        if(hd_ind_dep=='I')
            dis_id="selrsti";
        else
            dis_id="selrstd";

        getDistrict('R', dis_id, hd_state,hd_city);

        var rdn_p_r = $('#rdn_r' + sp_idd[1]).val();
        var f_no = $('#hd_fil_no' + sp_idd[1]).val();
        var hd_pet_res = $('#hd_pet_res' + sp_idd[1]).val();
        var hd_sr_no = $('#hd_sr_no' + sp_idd[1]).val();
        var sp_partyname = $('#sp_partyname' + sp_idd[1]).html();

        var hd_sonof = $('#hd_sonof' + sp_idd[1]).val();
        var hd_prfhname = $('#hd_prfhname' + sp_idd[1]).val();
        var hd_sex = $('#hd_sex' + sp_idd[1]).val();
        var hd_age = $('#hd_age' + sp_idd[1]).val();
        var hd_addr1 = $('#hd_addr1' + sp_idd[1]).val();
        var hd_addr2 = $('#hd_addr2' + sp_idd[1]).val();
        var hd_dstname = $('#hd_dstname' + sp_idd[1]).val();
        var hd_pin = $('#hd_pin' + sp_idd[1]).val();
//        var hd_state = $('#hd_state' + sp_idd[1]).val();
//        var hd_city = $('#hd_city' + sp_idd[1]).val();
        var hd_contact = $('#hd_contact' + sp_idd[1]).val();
        var hd_email = $('#hd_email' + sp_idd[1]).val();
        var hd_deptcode=$('#hd_deptcode'+ sp_idd[1]).val();
        var hd_authcode=$('#hd_authcode'+ sp_idd[1]).val();
        $('.cl_rdn_r').each(function() {
            if (idd == $(this).attr('id'))
                $(this).prop('checked', true);
            else
                $(this).prop('checked', false);
        });
        get_part_detail(f_no, hd_pet_res, hd_sr_no, sp_partyname, rdn_p_r, hd_ind_dep, hd_sonof, hd_prfhname, hd_sex, hd_age, hd_addr1, hd_addr2,
            hd_dstname, hd_pin, hd_state, hd_city, hd_contact, hd_email,hd_deptcode,hd_authcode);
    });


    $(document).on('change', '#ddl_court', function() {

        var idd= $(this).val();

        if(idd=='4')
        {
            $('#ddl_st_agncy').val('490506');

            get_benches('1');
        }
    });
//      $(document).on('click','#chk_undertaking',function(){
//
//          if($(this).is(':checked'))
//              {
////                  $('#txt_undertakig').attr('disabled',false);
//                  $('#ddl_doc_u').attr('disabled',false);
//              }
//              else
//                  {
////                       $('#txt_undertakig').attr('disabled',true);
//                        $('#ddl_doc_u').attr('disabled',true);
//                  }
//                  $('#txt_undertakig').val('');
//                  $('#ddl_doc_u').val('');
//      });

//      $(document).on('change','#ddl_doc_u',function(){
//          var ddl_doc_u=$('#ddl_doc_u').val();
//          if(ddl_doc_u=='10')
//              {
//              $('#txt_undertakig').attr('disabled',false);
//               $('#txt_undertakig').focus();
//              }
//          else
//             $('#txt_undertakig').attr('disabled',true);
//          $('#txt_undertakig').val('');
//      });
    $(document).on('change','#ddl_pet_adv_state,#ddl_res_adv_state',function(){
        var idd=  $(this).attr('id');
        if(idd=='ddl_pet_adv_state')
        {
            $('#padvno').val('');
            $('#padvyr').val('');
            $('#padvname').val('');
            $('#padvmob').val('');
            $('#padvemail').val('');
            if( $(this).val()=='')
            {
                $('#padvno').attr('disabled',true);
                $('#padvyr').attr('disabled',true);
                $('#padvname').attr('disabled',true);
                $('#padvmob').attr('disabled',true);
                $('#padvemail').attr('disabled',true);
            }
            else
            {
                $('#padvno').attr('disabled',false);
                $('#padvyr').attr('disabled',false);
                $('#padvname').attr('disabled',false);
                $('#padvmob').attr('disabled',false);
                $('#padvemail').attr('disabled',false);
            }
        }
        else if(idd=='ddl_res_adv_state')
        {
            $('#radvno').val('');
            $('#radvyr').val('');
            $('#radvname').val('');
            $('#radvmob').val('');
            $('#radvemail').val('');
            if( $(this).val()=='')
            {
                $('#radvno').attr('disabled',true);
                $('#radvyr').attr('disabled',true);
                $('#radvname').attr('disabled',true);
                $('#radvmob').attr('disabled',true);
                $('#radvemail').attr('disabled',true);
            }
            else
            {
                $('#radvno').attr('disabled',false);
                $('#radvyr').attr('disabled',false);
                $('#radvname').attr('disabled',false);
                $('#radvmob').attr('disabled',false);
                $('#radvemail').attr('disabled',false);
            }
        }
    });
});

function  get_casetype(){
    var ddl_court=$('#ddl_court').val();
    var CSRF_TOKEN = 'CSRF_TOKEN';
    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
    $.ajax({
        //url: '../filing/get_casetype.php',
        url: '/Common/Ajaxcalls/get_casetype',
        cache: false,
        async: true,
        data: {ddl_court:ddl_court,CSRF_TOKEN: CSRF_TOKEN_VALUE},
        type: 'POST',
        success: function(data, status) {
            $('#ddl_nature').html(data);
            updateCSRFToken();
        }

    });

}
function get_benches(str)
{
    var CSRF_TOKEN = 'CSRF_TOKEN';
    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
    var ddl_st_agncy = $('#ddl_st_agncy').val();
    var ddl_court=$('#ddl_court').val();
    if(ddl_st_agncy!='' && ddl_court!='')

    {

        $.ajax({
            url: '/Common/Ajaxcalls/get_bench',
            cache: false,
            async: true,
            //data: {ddl_st_agncy: ddl_st_agncy,ddl_court:ddl_court},
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, high_court_id: ddl_st_agncy, court_type: ddl_court},
            type: 'GET',
            success: function(data, status) {

                $('#ddl_bench').html(data);
                if(str==1)
                {
                    $('#ddl_bench').val('10000');
                    $('#ddl_st_agncy').attr('disabled',true);
                }
                else
                {
                    $('#ddl_bench').val('');
                    $('#ddl_st_agncy').attr('disabled',false);
                }
                updateCSRFToken();
            }

        });
    }
}

function getDetails()
{
    call_fullReset_main();
    var hd_mn = $('#hd_mn').val();
    var cs_tp = $('#cs_tp').val();
    var txtFNo = $('#txtFNo').val();
    var txtYear = $("#txtYear").val();
    $.ajax({
        url: '../filing/get_parties.php',
        cache: false,
        async: true,
        data: {hd_mn: hd_mn, txtFNo: txtFNo, txtYear: txtYear, cs_tp: cs_tp},
        beforeSend: function() {
            $('#dv_ent_z').html('<table widht="100%" align="center"><tr><td><img src="../images/preloader.gif"/></td></tr></table>');
        },
        type: 'POST',
        success: function(data, status) {

            $('#dv_parties').html(data);
        },
        error: function(xhr) {
            alert("Error: " + xhr.status + " " + xhr.statusText);
        }

    });
}
function com_filingNo()
{
    var txtNo = document.getElementById('txtFNo').value;
    if (txtNo.length == "1")
    {
        txtNo = "0000" + txtNo;
    }
    else if (txtNo.length == "2")
    {
        txtNo = "000" + txtNo;
    }
    else if (txtNo.length == "3")
    {
        txtNo = "00" + txtNo;
    }
    else if (txtNo.length == "4")
    {
        txtNo = "0" + txtNo;
    }
    document.getElementById('txtFNo').value = txtNo;
}

function get_part_detail(f_no, hd_pet_res, hd_sr_no, sp_partyname, rdn_p_r, hd_ind_dep, hd_sonof, hd_prfhname, hd_sex,
                         hd_age, hd_addr1, hd_addr2, hd_dstname, hd_pin, hd_state, hd_city, hd_contact, hd_email,hd_deptcode,hd_authcode)
{

    var sp_hd_deptcode=hd_deptcode.split('->');
    if (rdn_p_r == 'P')
    {

        $('#selpt').val(hd_ind_dep);
        activate_main('selpt');
        if(hd_ind_dep=='I')
        {
            $('#pet_name').val(sp_partyname);

            $('#selprel').val(hd_sonof);
            $('#prel').val(hd_prfhname);
            $('#psex').val(hd_sex);
            $('#page').val(hd_age);
            $('#pocc').val(hd_addr1);


            $('#paddi').val(hd_addr2);
            $('#pcityi').val(hd_dstname);
            $('#ppini').val(hd_pin);
            $('#selpsti').val(hd_state);
            $('#selpdisi').val(hd_city);
            $('#pmobi').val(hd_contact);
            $('#pemaili').val(hd_email);
        }
        else  if(hd_ind_dep=='D1' || hd_ind_dep=='D2' || hd_ind_dep=='D3')
        {
            $('#pet_deptt').val(sp_partyname);
            if(hd_addr1=='')
                hd_addr1=sp_partyname;
            $('#pet_post').val(hd_addr1);
            //if(hd_ind_dep=='D1')
            //$('#state_department_in_pet').val(hd_deptcode);
            $('#pet_deptt_code').val(sp_hd_deptcode[0]);
            $('#pes_post_code').val(hd_authcode);
            $('#paddd').val(hd_addr2);
            $('#pcityd').val(hd_dstname);
            $('#ppind').val(hd_pin);
            $('#selpstd').val(hd_state);
            $('#selpdisd').val(hd_city);
            $('#pmobd').val(hd_contact);
            $('#pemaild').val(hd_email);
        }
    }
    else if (rdn_p_r == 'R')
    {
        $('#selrt').val(hd_ind_dep);
        activate_main('selrt');
        if(hd_ind_dep=='I')
        {
            $('#res_name').val(sp_partyname);

            $('#selrrel').val(hd_sonof);
            $('#rrel').val(hd_prfhname);
            $('#rsex').val(hd_sex);
            $('#rage').val(hd_age);
            $('#rocc').val(hd_addr1);
            $('#raddi').val(hd_addr2);
            $('#rcityi').val(hd_dstname);
            $('#rpini').val(hd_pin);
            $('#selrstd').val(hd_state);
            $('#selrdisi').val(hd_city);
            $('#rmobi').val(hd_contact);
            $('#remaili').val(hd_email);
        }
        else  if(hd_ind_dep=='D1' || hd_ind_dep=='D2' || hd_ind_dep=='D3')
        {
            $('#res_deptt').val(sp_partyname);
            if(hd_addr1=='')
                hd_addr1=sp_partyname;
            $('#res_post').val(hd_addr1);
            if(hd_ind_dep=='D1')
                $('#state_department_in_res').val(hd_deptcode);

            $('#res_deptt_code').val(sp_hd_deptcode[0]);
            $('#res_post_code').val(hd_authcode);

            $('#raddd').val(hd_addr2);
            $('#rcityd').val(hd_dstname);
            $('#rpind').val(hd_pin);
            $('#selrstd').val(hd_state);
            $('#selrdisd').val(hd_city);
            $('#rmobd').val(hd_contact);
            $('#remaild').val(hd_email);
        }
    }
}

function OnlyNumbersTalwana(event,str)
{
    var key;
    if(window.event)
    {
        key=event.keyCode;
    }
    else if(event.which)
    {
        key=event.which;
    }

    var ln_val=$('#'+str).val().length;
//alert(ln_val);

    if((key>=48 && key<=57) || key==8 || ((key==77 || key==109) && ln_val==0) ||  ((key==80 || key==112) && ln_val==1) )
    {

        return true;
    }
    else if(key==undefined)
    {
        //  alert("Anshul");
        return true;
    }
    else
    {


        return false;

    }

}