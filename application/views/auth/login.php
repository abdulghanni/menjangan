

<div class="login-box">



  <div class="login-logo">
    <img src="<?php echo base_url($this->layout->get_logo()) ?>" height="100px">
    <br>
    <a href="<?php echo site_url() ?>"><?php echo $this->layout->get_title('true') ?></a>
  </div><!-- /.login-logo -->

<div class="callout callout-info">
    <h4>Untuk Masuk Gunakan</h4>
    <p>Email : <strong>tamu@tamu.php</strong><br>Password : <strong>tamu</strong></p>
  </div>
  <br>

  <div class="login-box-body">
    <p class="login-box-msg"><?php echo lang('login_desc') ?></p>
    <?php echo $message;?>
    <?php echo form_open('login','','id="loginForm"'); ?>
    <div class="form-group has-feedback">
      <label><?php echo lang('login_identity_label') ?></label>
      <input type="email" name="identity" class="form-control" placeholder="tamu@tamu.com" required="required" autofocus />
      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <label><?php echo lang('login_password_label') ?></label>
      <input type="password" id="password" data-toggle="password" name="password" class="form-control" placeholder="tamu" required="required" />
    </div>
    <?php if ($features['google_recaptcha']): ?>
      <div class="row">
        <div class="col-xs-12">
          <input type="hidden" name="google_rechapatcha" id="googleRechapatcha" value=""/>
          <div class="g-recaptcha" data-sitekey="<?php echo $google_recaptcha['site_key'] ?>"></div>    
          <br/>
        </div><!-- /.col -->
      </div>
    <?php endif ?>
    <div class="row">
      <div class="col-xs-8">
        <div class="checkbox icheck">
          <label>
            <input name="remember" type="checkbox" value="1"> <?php echo lang('login_remember_label') ?>
          </label>
        </div>                    
      </div><!-- /.col -->
      <div class="col-xs-4">
        <input type="submit" class="btn btn-primary btn-block btn-flat" id="loginBtn" value="<?php echo lang('login_submit_btn') ?>" />
      </div><!-- /.col -->
    </div>
    
    <?php echo form_close(); ?>
    <a href="<?php echo site_url('forgot-password') ?>" title="Sign Up"><?php echo lang('login_forgot_password') ?></a><br>
    <a href="<?php echo site_url('register') ?>" title="Sign Up"><?php echo lang('register_new') ?></a>
  </div><!-- /.login-box-body -->
  <br>
  
</div><!-- /.login-box -->
