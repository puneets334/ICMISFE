<?=view('header'); ?>
 
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header heading">

                            <div class="row">
                                <div class="col-sm-10">
                                    <h3 class="card-title">Filing</h3>
                                </div>
                                <div class="col-sm-2">
                                    <div class="custom_action_menu">
                                        <button class="btn btn-success btn-sm" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                        <a href="<?=base_url('Filing/Diary/search');?>"><button class="btn btn-primary btn-sm" type="button"><i class="fas fa-pen" aria-hidden="true"></i></button></a>
                                        <button class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?=view('Filing/filing_breadcrumb'); ?>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header p-2" style="background-color: #fff;"><br>
                                        <h4 class="basic_heading"> Refiling Details </h4>
                                    </div><!-- /.card-header -->

                                    <div class="alert alert-danger col-md-12">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <span style="text-align:center;color: black"> <?php if(!empty($message)) print_r($message); ?></span>
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

 <?=view('sci_main_footer');?>