<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="row">
  <div class="col-md-4 col-md-offset-4" id="title-side">
    <p id="sub-title">Pengembangan Model
    </p>
    <h1>KARTU KINERJA <span style="color:#ea6227">ASN</span></h1>
    <p>
      <b><i style="color:#ea6227">"Berbasis Networking Smarthpone System"</i></b>
    </p>
    <p>
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-mobile fa-stack-1x fa-inverse"></i>
      </span>
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-desktop fa-stack-1x fa-inverse"></i>
      </span>
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-user fa-stack-1x fa-inverse"></i>
      </span>
    </p>
  </div>
  <div class="col-md-4" id="login-side">
    <div class="row">
      <div class="login-box">
        <div class="login-logo">

        </div>
        <div class="login-box-body">
            <div  id="logo">
              <img src="<?php echo base_url();?>assets/images/logo-sultra.png" alt="" />
              <p>
                Badan Penelitian dan Pengembangan
              </p>
              <div id="logo-sub">Provinsi Sulawesi Tenggara</div>
            </div>
          </br>

            <p class="login-box-msg"><?php echo lang('auth_sign_session'); ?></p>
            <?php echo $message;?>

            <?php echo form_open('auth/login');?>
                <div class="form-group has-feedback">
                    <?php echo form_input($identity);?>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_input($password);?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?><?php echo lang('auth_remember_me'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <?php echo form_submit('submit', lang('auth_login'), array('class' => 'btn btn-block btn-flat','style' => 'background-color:#ea6227;color:#fff'));?>
                    </div>
                </div>
            <?php echo form_close();?>
            <?php if ($auth_social_network == TRUE): ?>
            <div class="social-auth-links text-center">
                <p>- <?php echo lang('auth_or'); ?> -</p>
                <?php echo anchor('#', '<i class="fa fa-facebook"></i>' . lang('auth_sign_facebook'), array('class' => 'btn btn-block btn-social btn-facebook btn-flat')); ?>
                <?php echo anchor('#', '<i class="fa fa-google-plus"></i>' . lang('auth_sign_google'), array('class' => 'btn btn-block btn-social btn-google btn-flat')); ?>
            </div>
            <?php endif; ?>
            <?php if ($forgot_password == TRUE): ?>
                    <?php echo anchor('#', lang('auth_forgot_password')); ?><br />
            <?php endif; ?>
            <?php if ($new_membership == TRUE): ?>
                    <?php echo anchor('#', lang('auth_new_member')); ?><br />
            <?php endif; ?>
        </div>

      </div>

    </div>
  </div>
</div>
