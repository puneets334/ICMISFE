<div class="tab-content">
            <div id="load_search_view"><!-- DEBUG-VIEW START 1 APPPATH/Views/Reports/court/gist_module_search_view.php -->

<div class="active tab-pane" id="Refiling">
    <form action="http://10.40.186.169:92" class="form-horizontal Elimination_list_form" name="Elimination_list_form" id="Elimination_list_form" autocomplete="off" method="post" accept-charset="utf-8">
<!-- <input type="hidden" name="CSRF_TOKEN" value="44463e12aa543eae72b2dd8cd209aa2ca3abea5c61528f5da895fbe51ca4fea5">    <div class="row"> -->
        <div class="col-md-12">
        <center><span style="font-weight: bold; color:#4141E0; text-decoration: underline;">ELEMINATION LIST</span></center>
            <div class="card card-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group row">
                                <label for="From" class="col-sm-5 col-form-label">Board Type</label>
                                <div class="col-sm-7">
                                <td>
        <select name="board_type" id="board_type" class="form-control">            
            <option value="J">Court</option>
<!--            <option value="C">Chamber</option>
            <option value="R">Registrar</option>-->
        </select>
    </td>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-3">
                        <div class="form-group row">
                                <label for="From" class="col-sm-5 col-form-label">Dates</label>
                                <div class="col-sm-7">
                                    <input type="date" class="form-control" id="listing_dts" name="listing_dts" placeholder="From Date" value="">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group row">
                                <label for="Year" class="col-sm-5 col-form-label">Section Name</label>
                                <div class="col-sm-7">
                                <select name="sec_id" id="sec_id" class="form-control">
                            <option value="0">-ALL-</option>
                            <?php foreach($section as $sec) :?>
                            <option value="<?php echo $sec->id; ?>" > <?php echo $sec->section_name; ?></option>
                            <?php endforeach ?>
              
        </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                        <span class="input-group-append">
                        <input type="button" name="Elimination_list" id="Eliminationlist" class="Elimination_list btn btn-primary" value="Submit">
                          </span>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

    </div>
       </form>
 </div>
         <div id="result_data"></div>

<script>
    $('#Eliminationlist').on('click', function () {
        //alert('hi');


            var form_data = $('#Elimination_list_form').serialize();
            if(form_data){ //alert('readt post form');
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                $('.alert-error').hide();
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url('Reports/Judicial/Report/Elimination_list'); ?>",
                    data: form_data,
                    beforeSend: function () {
                        $('#Eliminationlist').val('Please wait...');
                        $('#Eliminationlist').prop('disabled', true);
                    },
                    success: function (data) {
                        //alert(data);
                        $('#Eliminationlist').prop('disabled', false);
                        $('#Eliminationlist').val('Submit');
                        $("#result_data").html(data);

                        updateCSRFToken();
                    },
                    error: function () {
                        updateCSRFToken();
                    }

                });
                return false;
            }
    });

</script>



<!-- DEBUG-VIEW ENDED 1 APPPATH/Views/Reports/court/gist_module_search_view.php -->
</div>

   </div>