<?php error_reporting(2);
//header("X-Frame-Options: DENY");
//header("X-XSS-Protection: 1; mode=block");
//header("X-Content-Type-Options: nosniff");
//header("Strict-Transport-Security: max-age=31536000");
//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
//header("Cache-Control: post-check=0, pre-check=0", false);
//header("Pragma: no-cache");
Header ("set X-Content-Security-Policy default-src * 'self'");

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Sushant">
    <meta http-equiv="Content-Security-Policy" content="default-src *; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline' 'unsafe-eval' http://10.40.186.150:92/">
  <title>Supreme Court of India - Integrated Case Management & Information System</title>

  <link href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/libs/css/login.css') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/vendor/font-awesome/css/font-awesome.css') ?>" rel="stylesheet" type="text/css">



</head>

<body class="d-flex flex-column h-100">

  <header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
      <div class="container-fluid p-0">
        <div class="bg-light px-2 p-1 shadow" style="border-radius:0 40px 40px 0">
          <img src="<?php echo base_url('assets/images/sc-logo.png') ?>" class="me-3 float-start" alt="Supreme Court of India Logo">
          <a class="navbar-brand float-end" href="#">
            <h1 class='primary-text h4'>Supreme Court of India</h1><span class='small m-0 text-dark'>Integrated Case Management & Information System</span>
          </a>
        </div>
        <span class="ms-auto text-white">&nbsp;</span>
      </div>
    </nav>
  </header>

  <!-- Begin page content -->
  <main class="mainDiv">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Latest Updates</button>
            </div>
          </nav>
          <div class="tab-content bg-white shadow p-3 rounded-bottom shadow" style="height:350px;" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
              <ul class="updatesLi">
                <li>E-Committee, Supreme Court of India is launching various applications for the benefit of the litigants and lawyers</li>
                <li>Conference on national initiative to reduce pendency and delay in judicial system</li>
                <li>E-Committee, Supreme Court of India is launching various applications for the benefit of the litigants and lawyers</li>
                <li>Conference on national initiative to reduce pendency and delay in judicial system</li>
                <li>E-Committee, Supreme Court of India is launching various applications for the benefit of the litigants and lawyers</li>
                <li>Conference on national initiative to reduce pendency and delay in judicial system</li>
                <li>E-Committee, Supreme Court of India is launching various applications for the benefit of the litigants and lawyers</li>
                <li>Conference on national initiative to reduce pendency and delay in judicial system</li>
              </ul>
            </div>
          </div>

        </div>
        <div class="col-md-5 offset-md-1 d-flex justify-content-end">
          <?= $this->renderSection('content') ?>
        </div>
      </div>
    </div>
  </main>

  <footer class="footer mt-auto py-3" style="position: fixed;bottom: 0;width: 100%;">
    <div class="container text-center">
        <span class="text-white "><b>Version</b> 2.0 Copyright &copy; 2023 <strong><a href="<?=base_url()?>" class="text-white ">Supreme Court of India</a></strong></span>
    </div>
  </footer>
  <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
</body>

</html>