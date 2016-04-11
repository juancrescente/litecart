<style>
html, body {
  background: #f8f8f8;
}

html {
  display: table;
  width: 100%;
  height: 100%;
}

body {
  display: table-row;
}

#loader img {
  position: absolute;
  top: 50%;
  left: 50%;
  margin-top: -44px;
  margin-left: -44px;
  
  -webkit-animation-name: spin;
  -webkit-animation-duration: 4000ms;
  -webkit-animation-iteration-count: infinite;
  -webkit-animation-timing-function: linear;
  -moz-animation-name: spin;
  -moz-animation-duration: 4000ms;
  -moz-animation-iteration-count: infinite;
  -moz-animation-timing-function: linear;
  -ms-animation-name: spin;
  -ms-animation-duration: 4000ms;
  -ms-animation-iteration-count: infinite;
  -ms-animation-timing-function: linear;
  animation-name: spin;
  animation-duration: 4000ms;
  animation-iteration-count: infinite;
  animation-timing-function: linear;
}
@-ms-keyframes spin {
  from { -ms-transform: rotate(0deg); }
  to { -ms-transform: rotate(360deg); }
}
@-moz-keyframes spin {
  from { -moz-transform: rotate(0deg); }
  to { -moz-transform: rotate(360deg); }
}
@-webkit-keyframes spin {
  from { -webkit-transform: rotate(0deg); }
  to { -webkit-transform: rotate(360deg); }
}
@keyframes spin {
  from { transform:rotate(0deg); }
  to { transform:rotate(360deg); }
}

#box-login-wrapper {
  position: relative;
  display: table-cell;
  height: 100%;
  vertical-align: middle;
  padding: 30px;
}

#box-login {  
  max-width: 360px;
  margin: auto;
  
  padding: 0px;
  
  background: #ffffff;
  background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJod…EiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
  background: -moz-linear-gradient(top, #ffffff 0%, #f9f9f9 100%);
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#f9f9f9));
  background: -webkit-linear-gradient(top, #ffffff 0%,#f9f9f9 100%);
  background: -o-linear-gradient(top, #ffffff 0%,#f9f9f9 100%);
  background: -ms-linear-gradient(top, #ffffff 0%,#f9f9f9 100%);
  background: linear-gradient(to bottom, #ffffff 0%,#f9f9f9 100%);
  
  text-align: center;
  
  border-radius: 0px 25px 0px 25px;
  
  box-shadow: 0px 0px 60px rgba(0,0,0,0.25);
}

#box-login .header {
  padding: 10px;
}
#box-login .header img {
  margin: 1em;
  max-width: 250px;
  max-height: 100px;
}

#box-login .content {
  padding: 0 30px;
  margin: 0 auto;
  border-bottom: 1px solid rgba(0,0,0,0.1);
}

#box-login .footer {
  border-top: 1px solid rgba(255,255,255,0.8);
  background: #f6f6f6;
  padding: 10px;
  text-align: right;
  border-radius: 0px 0px 0px 25px;
}
</style>

<div id="loader">
  <img src="{snippet:template_path}images/loader.png" alt="" />
</div>

<div id="box-login-wrapper">

  <div id="box-login" class="">
    
    <div class="header">
      <a href="<?php echo document::href_ilink(''); ?>"><img src="<?php echo WS_DIR_IMAGES; ?>logotype.png" alt="<?php echo settings::get('store_name'); ?>" /></a>
    </div>
    
    <?php echo functions::form_draw_form_begin('login_form', 'post'); ?>
    
      <div class="content">
        <?php echo functions::form_draw_hidden_field('redirect_url', $action); ?>
        
        <!--snippet:notices-->
        
        <div class="form-group">
          <?php echo functions::form_draw_fonticon_field('username', true, 'text', 'fa-user', 'placeholder="'. language::translate('title_username', 'Username') .'"'); ?>
        </div>
        
        <div class="form-group">
          <?php echo functions::form_draw_password_field('password', '', 'placeholder="'. language::translate('title_password', 'Password') .'"'); ?>
        </div>
        
        <div class="checkbox">
          <label><?php echo functions::form_draw_checkbox('remember_me', '1'); ?> <?php echo language::translate('title_remember_me', 'Remember Me'); ?></label>
        </div>
      </div>
      
      <div class="footer">
        <?php echo functions::form_draw_button('login', language::translate('title_login', 'Login')); ?>
      </div>
      
    <?php echo functions::form_draw_form_end(); ?>
  </div>
  
</div>

<script>
  if ($("input[name='username']").val() == '') {
    $("input[name='username']").focus();
  } else {
    $("input[name='password']").focus();
  }
  
  $("form[name='login_form']").submit(function(e) {
    $("#box-login-wrapper").fadeOut(100);
  });
</script>