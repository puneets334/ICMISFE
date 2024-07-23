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
                                    <h3 class="card-title">Court Master</h3>
                                </div>
                                <div class="col-sm-2">
                                    <div class="custom_action_menu">
                                        <button class="btn btn-success btn-sm" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                        <button class="btn btn-primary btn-sm" type="button"><i class="fas fa-pen	" aria-hidden="true"></i></button>
                                        <button class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?=view('Court/CourtMaster/courtMaster_breadcrumb'); ?>
                        <!-- /.card-header -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header p-2" style="background-color: #fff;">                                        
                                        <?php
                                            $attribute = array('class' => 'form-horizontal', 'name' => 'courtMaster', 'id' => 'courtMaster', 'autocomplete' => 'off', 'enctype'=> 'multipart/form-data');
                                            echo form_open('Court/CourtMasterController/generate', $attribute);

                                        ?>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">

                                            <div class="active tab-pane">
                                                <h3 class="basic_heading"> Embed QR Code </h3><br>
                                            <div class="row ">
                                                <input type="hidden" name="usercode" id="usercode" value="<?= $usercode ?>">
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Causelist Date</label>
                                                        <div class="col-sm-6">
                                                            <input type="date" name="causelistDate" id="causelistDate" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Select Files (PDF Only*)</label>
                                                        <div class="col-sm-6">
                                                            <input type="file" name="fileROPList[]" id="fileROPList" class="form-control" multiple required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <input type="submit" name="sub" id="" class="btn btn-success" value="Upload & Embed QR">
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


 <?=view('sci_main_footer') ?>