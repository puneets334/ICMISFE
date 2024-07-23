<?= view('header') ?>

<style>
    .top1 {
        margin: 0 auto;
        text-align: center;
        overflow: hidden;
        width: 70%;
    }

    .inner_1 {
        margin-left: 30px;
        float: left;
        margin-bottom: 5px;
    }

    select {
        display: block;
        height: 25px;
        width: 130px;
    }



    .cl_manage {
        cursor: pointer;
    }

    #sar div table,
    #sar div table tr,
    #sar div table tr td,
    #sar div table tr th {
        font-size: 16px;
        padding: 5px;
        /*border: 1px solid black;
                border-collapse: collapse;*/
        border: none;
    }



    .cl_chk_case {
        background-color: #EFFBF2;
        /*height:10px;*/
        padding: 2px;
        margin: 5px;
        display: inline-block;
    }

    table,
    td,
    th,
    tr {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
</head>

<body>
    <form method="post" action="">
        <div id="dv_content1">
            <?php

            ?>
            <div class="top1">
                <div style="font-size: 18px;font-weight: bold;margin-bottom: 5px">RECORD ROOM USER/HALL CASE ALLOTMENT</div>
                <br>
                <div class="inner_1">
                    <div class="inner_1">
                        <label> Select Allotment Category :</label>
                        <label><input type="radio" name="allottment_type" id="allottment_type" value="1" checked /> Hallwise</label>
                        <label><input type="radio" name="allottment_type" id="allottment_type" value="2" /> Userwise </label>
                    </div>
                </div>
                <br>
                <div class="inner_1" id="userCases">
                    <div class="inner_1">
                        <label class="cl_wh">DEPARTMENT</label>
                        <?php
                        // $dept = "SELECT distinct dept_name,udept FROM users a LEFT JOIN userdept b ON a.udept=b.id WHERE b.id=3";
                        //echo $dept;
                        // $dept = mysql_query($dept) or die(__LINE__ . '->' . mysql_error());

                        ?>

                        <!-- <select id="department">

                            <option value="0">SELECT</option>


                        </select> -->

                        <select name="ddl_priority" id="ddl_priority" class="form-control">
                            <option value="0">Select</option>
                            <?php
                            foreach ($records as $row) {
                                echo '<option value="' . $row['dept_name'] . '">' . $row['dept_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="inner_1">
                        <label class="cl_wh">SECTION</label>
                        <select name="section" id="section" class="form-control">
                        <?php
                                if ($user['usertype'] == 1 || $user['usertype'] == 57 || $user['usercode'] == 2506) { ?>
                                    <option value="ALL">ALL</option>
                                <?php
                                } else {
                                ?>
                                    <option value="0">SELECT</option>
                                <?php
                                }
                                ?>
                            </select>
                    </div>
                    <div class="inner_1">
                        <label class="cl_wh">DESIGNATION</label>
                        <select id="designation">
                            <option value="ALL">ALL</option>
                        </select>
                    </div>


                </div>
                <div class="form-group row">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="button" id="btnShow" value="Show" class="btn btn-info" style="margin-top:10px" />


                        </button>
                    </div>
                </div>

            </div>
            <div id="result_main_um"></div>
        </div>
    </form>
     <?=view('sci_main_footer') ?>