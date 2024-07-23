<?= $this->extend('header_login') ?>
<?= $this->section('content') ?>
<?php  //echo $_SESSION["captcha"];
$attribute = array('class' => 'login01-form bg-white p-4 rounded shadow mt-3', 'name' => 'sign_in', 'id' => 'sign_in','accept-charset'=>'utf-8', 'autocomplete' => 'off' ,'onsubmit'=>'enableSubmit();');
echo form_open(base_url('Login/checkLogin/'), $attribute);
?>
    <span class="alert-danger"><?=\Config\Services::validation()->listErrors()?></span>

<?php if(session()->getFlashdata('error')){ ?>
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?= session()->getFlashdata('error')?>
    </div>
<?php } else if(session()->has("message_error")){ ?>
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?=session("message_error")?>
        </div>
<?php } else if(session()->has("message_success")){ ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?=session("message_success")?>
    </div>
    <?php } else{?>
    <span class="login01-form-title my-3 primary-text">Sign in to start your session</span>
    <?php }?>



  <div class="wrap-input01">
    <input class="input01" type="number" id="txtuname" name="txtuname" autocomplete="off" placeholder="<?=env('Userid')?>" >
    <span class="focus-input01"></span>
    <span class="symbol-input01">
      <i class="fa fa-envelope" aria-hidden="true"></i>
    </span>
  </div>
  <div class="wrap-input01">
    <input class="input01 " type="password" id="txtpass" name="txtpass" placeholder="<?=env('Password')?>">
    <span class="focus-input01"></span>
    <span class="symbol-input01">
      <i class="fa fa-lock" aria-hidden="true"></i>
    </span>
  </div>
  <div class="container-login01-form-btn">
    <button class="login01-form-btn border-0" type="submit">Sign In</button>
  </div>
  <div class="text-center pt-2">
    <a class="text-dark" href="#">Forgot Password?</a>
  </div>

<!--</form>-->
    <script src="<?= base_url('assets/libs/js/sha256.js'); ?>" type="text/javascript"></script>
<?= form_close() ?>
    <script>
        function enableSubmit() {
            var form = this;
            var password= $('[name="txtpass"]').val();
            $('[name="txtpass"]').val(sha256($('[name="txtpass"]').val()) + '<?= $_SESSION['login_salt'] ?>');
            if (password !='') {
                var pwd=sha256(password);
                var pwd2=pwd+'<?=$_SESSION['login_salt'] ?>';
            }
        }

    </script>
<?= $this->endSection() ?>