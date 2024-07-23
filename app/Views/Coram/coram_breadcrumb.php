<?php
/**
 * Created by Sublime Text.
 * User: MOHAMMAD FARHAN
 * Date: 12/12/23
 * Time: 11:15 AM
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
$url_coram_aor=$url_coram_query = $url_retired_remove_coram = $url_coram_dept = $url_coram_list_before_not_before = $url_coram_list_before_not_before_delete = $url_coram_registrar_coram_shifting = '#';
$uri = current_url(true); ?>
<ul class="nav-breadcrumb">
    <li>
        <?php
         if ($uri->getSegment(2) == 'Aor'){
                $ColorCode = 'background-color: #01ADEF';
                $status_color = 'btn-primary';
             $url_coram_aor = base_url('Coram/Aor');
            }else{
                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                $status_color = 'btn-outline-primary';
             $url_coram_aor = base_url('Coram/Aor');
            }
        ?>
        <!-- <a href="<?= $url_coram_aor; ?>" class="<?php echo $status_color; ?>" style="z-index:15;"><span style="<?php echo $ColorCode; ?>"></span>Aor </a> -->
        <a href="<?= $url_coram_aor; ?>"><button  class="btn btn-block <?php echo $status_color; ?>">Aor</button> </a>
    </li>

    <li>
        <?php
       if ($uri->getSegment(2) == 'Coram_query') {
               $ColorCode = 'background-color: #01ADEF';
               $status_color = 'btn-primary';
           $url_coram_query = base_url('Coram/Coram_query');
           } else{
               $ColorCode = 'background-color: #169F85;color:#ffffff;';
               $status_color = 'btn-outline-primary';
           $url_coram_query = base_url('Coram/Coram_query');
           }
        ?>
        <!-- <a href="<?= $url_coram_query; ?>" class="<?php echo $status_color; ?>" style="z-index:14"><span style="<?php echo $ColorCode; ?>"></span> Coram Query </a> -->
        <a href="<?= $url_coram_query; ?>"><button  class="btn btn-block <?php echo $status_color; ?>">Coram Query</button> </a>

    </li>

    <li>
        <?php
         if ($uri->getSegment(2) == 'RetiredRemoveCoram') {
                $ColorCode = 'background-color: #01ADEF';
                $status_color = 'btn-primary';
             $url_retired_remove_coram = base_url('Coram/RetiredRemoveCoram');
            } else{
                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                $status_color = 'btn-outline-primary';
             $url_retired_remove_coram = base_url('Coram/RetiredRemoveCoram');
            }
        ?>
        <!-- <a href="<?= $url_retired_remove_coram; ?>" class="<?php echo $status_color; ?>" style="z-index:13"><span style="<?php echo $ColorCode; ?>"></span>Coram Remove on Retired </a> -->
        <a href="<?= $url_retired_remove_coram; ?>"><button  class="btn btn-block <?php echo $status_color; ?>">Coram Remove on Retired</button> </a>

    </li>
    <li>
        <?php
        if ($uri->getSegment(2) == 'Dept') {
                $ColorCode = 'background-color: #01ADEF';
                $status_color = 'btn-primary';
            $url_coram_dept = base_url('Coram/Dept');
            } else{
                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                $status_color = 'btn-outline-primary';
            $url_coram_dept = base_url('Coram/Dept');
            }
         ?>
        <!-- <a href="<?= $url_coram_dept; ?>" class="<?php echo $status_color; ?>" style="z-index:12;"><span style="<?php echo $ColorCode; ?>"></span> Dept </a> -->
        <a href="<?= $url_coram_dept; ?>"><button  class="btn btn-block <?php echo $status_color; ?>">Dept</button> </a>

    </li>
    <li>
        <?php
         if ($uri->getSegment(2) == 'Coram') {
                $ColorCode = 'background-color: #01ADEF';
                $status_color = 'btn-primary';
             $url_coram_list_before_not_before = base_url('Filing/Coram/coram_add');
            } else{
                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                $status_color = 'btn-outline-primary';
             $url_coram_list_before_not_before = base_url('Filing/Coram/coram_add');
            }
        ?>
        <!-- <a href="<?= $url_coram_list_before_not_before; ?>" class="<?php echo $status_color; ?>" style="z-index:1;"><span style="<?php echo $ColorCode; ?>"></span>  List before/Not Before/Coram </a> -->
        <a href="<?= $url_coram_list_before_not_before; ?>"><button  class="btn btn-block <?php echo $status_color; ?>">List before/Not Before/Coram</button> </a>

    </li>
    <li>
        <?php
         if ($uri->getSegment(2) == 'Coram') {
                $ColorCode = 'background-color: #01ADEF';
                $status_color = 'btn-primary';
             $url_coram_list_before_not_before = base_url('Filing/Coram');
            } else{
                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                $status_color = 'btn-outline-primary';
             $url_coram_list_before_not_before = base_url('Filing/Coram');
            }
        ?>
        <!-- <a href="<?= $url_coram_list_before_not_before; ?>" class="<?php echo $status_color; ?>" style="z-index:1;"><span style="<?php echo $ColorCode; ?>"></span>  List before/Not Before/Coram </a> -->
        <a href="<?= $url_coram_list_before_not_before; ?>"><button  class="btn btn-block <?php echo $status_color; ?>">List before/Not Before/Coram (Delete)</button> </a>

    </li>
    <li>
        <?php
         if ($uri->getSegment(2) == 'RegistrarCoramShifting') {
                $ColorCode = 'background-color: #01ADEF';
                $status_color = 'btn-primary';
             $url_coram_registrar_coram_shifting = base_url('Coram/RegistrarCoramShifting');
            } else{
                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                $status_color = 'btn-outline-primary';
             $url_coram_registrar_coram_shifting = base_url('Coram/RegistrarCoramShifting');
            }
        ?>
        <!-- <a href="<?= $url_coram_registrar_coram_shifting; ?>" class="<?php echo $status_color; ?>" style="z-index:1;"><span style="<?php echo $ColorCode; ?>"></span>  Registrar Coram Shifting </a> -->
        <a href="<?= $url_coram_registrar_coram_shifting; ?>"><button  class="btn btn-block <?php echo $status_color; ?>">Registrar Coram Shifting</button> </a>

    </li>
</ul>
<div class="clearfix"></div>
