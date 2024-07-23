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
                                    <button class="btn btn-primary btn-sm" type="button"><i class="fas fa-pen" aria-hidden="true"></i></button>
                                    <button class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?=view('Filing/filing_breadcrumb'); ?>
                    <!-- /.card-header -->

                    <br> <h4 class="basic_heading"> Defect Details </h4>
                    <br><br>
                    <br><br>
                    <br><br>
                    <br><br>

                    <div class="alert alert-danger col-md-12">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <span style="text-align:center;color: black"> <?php if(!empty($message)) print_r($message); ?></span>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>



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
