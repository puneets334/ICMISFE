
<?php
/**
 * Created by PhpStorm.
 * User: Anshu Gupta
 * Date: 20/10/23
 * Time: 8:55 AM
 */
?>
<style>
    .custom-radio{float: left; display: inline-block; margin-left: 10px; }
    .custom_action_menu{float: left; display: inline-block; margin-left: 10px; }
    .basic_heading{text-align: center;color: #31B0D5}
    .btn-sm {
        padding: 0px 8px;
        font-size: 14px;
    }
    .card-header {
        padding: 5px;
    }
    h4 {
        line-height: 0px;
    }
    .nav-breadcrumb li a {
        background-image: none;
        background-repeat: no-repeat;
        background-position: 100% 3px;
        position: relative;
    }
    .nav-breadcrumb li a, .nav-breadcrumb li a:link, .nav-breadcrumb li a:visited {
        margin-left: -70px;
    }
</style>
<?php
$url_check_documents=$url_docs_from_sc_diary_no = $url_old_refiling_refiledcases=$url_transactions_by_refID = $url_pipreport = $url_refiled_documents=$url_transactions_by_date = '#';
$uri = current_url(true); ?>
<ul class="nav-breadcrumb">
    <li>
        <?php
        if ($uri->getSegment(3) == 'check_documents') {
            $ColorCode = 'background-color: #01ADEF';
            $status_color = 'btn-primary';
            $url_check_documents = base_url('Filing/Efiling/check_documents');
        } else{
            $ColorCode = 'background-color: #169F85;color:#ffffff;';
            $status_color = 'btn-outline-primary';
            $url_check_documents = base_url('Filing/Efiling/check_documents');
        }
        ?>
        <a href="<?= $url_check_documents; ?>"><button type="button" class="btn btn-block <?php echo $status_color; ?>">Check Docs</button> </a>

    </li>
    <li>
        <?php
         if ($uri->getSegment(3) == 'docs_from_sc_diary_no'){
                $ColorCode = 'background-color: #01ADEF';
                $status_color = 'btn-primary';
             $url_docs_from_sc_diary_no = base_url('Filing/Efiling/docs_from_sc_diary_no');
            }else{
                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                $status_color = 'btn-outline-primary';
             $url_docs_from_sc_diary_no = base_url('Filing/Efiling/docs_from_sc_diary_no');
            }
        ?>
        <a href="<?= $url_docs_from_sc_diary_no; ?>"><button  class="btn btn-block <?php echo $status_color; ?>">Docs By Diary Number</button> </a>
    </li>



    <li>
        <?php
         if ($uri->getSegment(3) == 'pipreport') {
                $ColorCode = 'background-color: #01ADEF';
                $status_color = 'btn-primary';
             $url_pipreport = base_url('Filing/Efiling/pipreport');
            } else{
                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                $status_color = 'btn-outline-primary';
             $url_pipreport = base_url('Filing/Efiling/pipreport');
            }
        ?>
        <a href="<?= $url_pipreport; ?>"><button  class="btn btn-block <?php echo $status_color; ?>">Filing by Petitioner-in person</button> </a>

    </li>
    <li>
        <?php
        if ($uri->getSegment(3) == 'old_refiling_refiledcases') {
                $ColorCode = 'background-color: #01ADEF';
                $status_color = 'btn-primary';
            $url_old_refiling_refiledcases = base_url('Filing/Efiling/old_refiling_refiledcases');
            } else{
                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                $status_color = 'btn-outline-primary';
            $url_old_refiling_refiledcases = base_url('Filing/Efiling/old_refiling_refiledcases');
            }
         ?>
        <a href="<?= $url_old_refiling_refiledcases; ?>"><button  class="btn btn-block <?php echo $status_color; ?>">Old EFiling ReFiled Cases</button> </a>

    </li>
    <!--<li>
        <?php
/*        if ($uri->getSegment(3) == 'refiled_documents') {
            $ColorCode = 'background-color: #01ADEF';
            $status_color = 'btn-primary';
            $url_refiled_documents = base_url('Filing/Efiling/refiled_documents');
        } else{
            $ColorCode = 'background-color: #169F85;color:#ffffff;';
            $status_color = 'btn-outline-primary';
            $url_refiled_documents = base_url('Filing/Efiling/refiled_documents');
        }
        */?>
        <a href="<?php /*= $url_refiled_documents; */?>"><button  class="btn btn-block <?php /*echo $status_color; */?>">Refiling /Addiditonal documents report for srcutiny assistants</button> </a>

    </li>-->
    <li>
        <?php
         if ($uri->getSegment(3) == 'transactions_by_date') {
                $ColorCode = 'background-color: #01ADEF';
                $status_color = 'btn-primary';
             $url_transactions_by_date = base_url('Filing/Efiling/transactions_by_date');
            } else{
                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                $status_color = 'btn-outline-primary';
             $url_transactions_by_date = base_url('Filing/Efiling/transactions_by_date');
            }
        ?>
        <a href="<?= $url_transactions_by_date; ?>"><button  class="btn btn-block <?php echo $status_color; ?>">Transaction by Date</button> </a>

    </li>
    <li>
        <?php
        if ($uri->getSegment(3) == 'transactions_by_refID') {
            $ColorCode = 'background-color: #01ADEF';
            $status_color = 'btn-primary';
            $url_transactions_by_refID = base_url('Filing/Efiling/transactions_by_refID');
        } else{
            $ColorCode = 'background-color: #169F85;color:#ffffff;';
            $status_color = 'btn-outline-primary';
            $url_transactions_by_refID = base_url('Filing/Efiling/transactions_by_refID');
        }
        ?>
        <a href="<?= $url_transactions_by_refID; ?>"><button  class="btn btn-block <?php echo $status_color; ?>">Transaction by RefID</button> </a>

    </li>
</ul>
<div class="clearfix"></div>
