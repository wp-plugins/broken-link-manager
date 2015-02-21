<div id="wrapper">
	<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo admin_url('admin.php?page=wblm-dashboard'); ?>">
                <?php echo WBLM_NAME; ?> <span> Ver <?php echo WBLM_VERSION; ?></span>
                </a>
            </div>
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                   <h3 class="page-header"><?php _e('Settings', 'wblm') ?></h3>
                   <?php get_wblmTopNavi(); ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>            
            <form class="form-horizontal" role="form" action="admin.php?page=wblm-settings&settingsSave=on" method="post">
            <!-- General Settings -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                       
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
                            
<p class="bg-success" style="padding:10px; margin-top:0; font-size:16px; font-weight: bold; "><?php _e('General Settings', 'wblm') ?></p>

<div class="form-inline">
<div class="form-group">
	<div class="checkbox col-sm-offset-3">
		<div class="checkbox">
			<label><input type="checkbox" name="send_email" <?php if(SEND_EMAIL  == 'on'){echo 'checked';} ?>> <?php _e('Send E-mail', 'wblm') ?></label>
      </div>
    </div>
</div>
  
  <div class="form-group">
	<div class="checkbox col-sm-offset-3">
		<div class="checkbox">
			<label><input type="checkbox" name="save_broken_urls" <?php if(SAVE_BROKEN_URLS == 'on'){echo 'checked';} ?>> <?php _e('Save the broken URLs', 'wblm') ?></label>
      </div>
    </div>
</div>
  
  
  <div class="form-group">
	<div class="checkbox col-sm-offset-3">
		<div class="checkbox">
			<label><input type="checkbox" name="save_url_stats" <?php if(SAVE_URL_STATS  == 'on'){echo 'checked';} ?>> <?php _e('Save URL hit', 'wblm') ?></label>
      </div>
    </div>
</div>

<div class="form-group">
	<div class="checkbox col-sm-offset-3">
		<div class="checkbox">
			<label><input type="checkbox" name="save_url_log" <?php if(SAVE_URL_LOG  == 'on'){echo 'checked';} ?>> <?php _e('Save URL Log', 'wblm') ?></label>
      </div>
    </div>
</div>


<div class="form-group">
	<div class="checkbox col-sm-offset-3">
		<div class="checkbox">
			<label><input type="checkbox" name="redirect_default_url" <?php if(REDIRECT_DEFAULT_URL  == 'on'){echo 'checked';} ?>> <?php _e('Redirect default URL', 'wblm') ?></label>
      </div>
    </div>
</div>

  
<div class="bnc-clearer"></div>

</div><!-- form-inline -->

                            
                            
                             
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
             <!-- //General Settings -->
            
            
            
            
            
            
             <!-- Email Settings -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                       
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            

<p class="bg-warning" style="padding:10px; margin-top:0; font-size:16px; font-weight: bold; "><?php _e('E-mail Settings', 'wblm') ?></p>

<div class="form-horizontal">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-1 control-label"><?php _e('From E-mail', 'wblm') ?></label>
    <div class="col-sm-5">
      <div class="input-group">
      <div class="input-group-addon">@</div>
      <input class="form-control" type="email" name="from_email" placeholder="From email" value="<?php echo FROM_EMAIL; ?>">
    </div>
    </div>
  </div>
  
  
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-1 control-label"><?php _e('To E-mail', 'wblm') ?></label>
    <div class="col-sm-5">
      <div class="input-group">
      <div class="input-group-addon">@</div>
      <input class="form-control" type="email" name="to_email" placeholder="From email" value="<?php echo TO_EMAIL; ?>">
    </div>
    </div>
  </div>
  
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-1 control-label"><?php _e('CC', 'wblm') ?></label>
    <div class="col-sm-5">
      <div class="input-group">
      <div class="input-group-addon">@</div>
      <input class="form-control" type="email" name="cc_email" value="<?php echo CC_EMAIL; ?>" placeholder="<?php _e('Copy to e-mail adress (Optimal)', 'wblm') ?>">
    </div>
    </div>
  </div>
  
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-1 control-label"><?php _e('BCC', 'wblm') ?></label>
    <div class="col-sm-5">
      <div class="input-group">
      <div class="input-group-addon">@</div>
      <input class="form-control" type="email" name="bcc_email" value="<?php echo BCC_EMAIL; ?>" placeholder="<?php _e('Hidden copy to e-mail adress (Optimal)', 'wblm') ?>">
    </div>
    </div>
  </div>

</div><!-- form-horizontal -->

                            
                            
                             
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div> 
            <!-- //Email Settings -->
            
            
            <!-- Default URL -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                       
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
<p class="bg-info" style="padding:10px; margin-top:0; font-size:16px; font-weight: bold; "><?php _e('Default URL', 'wblm') ?></p>

<div class="form-horizontal">
  <div class="form-group">
    <label for="default_url" class="col-sm-1 control-label"><?php _e('Default URL', 'wblm') ?></label>
    <div class="col-sm-5">
      <div class="input-group">
      <div class="input-group-addon"><?php _e('URL', 'wblm') ?></div>
      <input class="form-control" type="text" name="default_url" placeholder="<?php _e('Default URL', 'wblm') ?>" value="<?php echo DEFAULT_URL; ?>">
    </div>
    </div>
  </div>

</div><!-- form-horizontal -->

                            
                            
                             
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div> 
            <!-- //Default URL -->
            
            
<div class="row">
	<div class="col-lg-12" style="text-align:right;">
	<button type="submit" class="btn btn-primary"> <?php _e('SAVE', 'wblm') ?> </button>
	</div>
</div>
               
</form>
    <br /><br />      
                   
        </div>
        <!-- /#page-wrapper -->
		<?php get_wblmFooter(); ?>
</div>
<!-- /#wrapper -->