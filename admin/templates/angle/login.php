<?php
lt_add_js('jquery');
//lt_add_js('bootstrap');
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
   <meta name="description" content="Bootstrap Admin App + jQuery" />
   <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
   <title><?php lt_title(); ?></title>
   <?php lt_head(); ?>
   <!-- =============== VENDOR STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="<?php print TEMPLATE_URL; ?>/vendor/fontawesome/css/font-awesome.min.css">
   <!-- SIMPLE LINE ICONS-->
	<link rel="stylesheet" href="<?php print TEMPLATE_URL; ?>/vendor/simple-line-icons/css/simple-line-icons.css">
	<link rel="stylesheet" href="<?php print TEMPLATE_URL; ?>/css/bootstrap.css" id="maincss">
	<!-- =============== APP STYLES ===============-->
	<link rel="stylesheet" href="<?php print TEMPLATE_URL; ?>/css/app.css" id="maincss">
</head>
<body>
<div class="wrapper">
	<div class="block-center mt-xl wd-xl">
		<!-- START panel-->
		<div class="panel panel-dark panel-flat">
			<div class="panel-heading text-center">
               <a href="#">
                  <img src="<?php print TEMPLATE_URL; ?>/img/logo.png" alt="Image" class="block-center img-rounded">
               </a>
            </div>
            <div class="panel-body">
				<?php SB_MessagesStack::ShowMessages(); ?>
				<p class="text-center pv"><?php _e('SIGN IN TO CONTINUE.', 'angle'); ?></p>
				<form action="" method="post" role="form" data-parsley-validate="" novalidate="" class="mb-lg">
					<input type="hidden" name="mod" value="users" />
					<input type="hidden" name="task" value="do_login" />
					<?php if( isset($_SERVER['HTTP_REFERER']) ): ?>
					<input type="hidden" name="redirect" value="<?php print $_SERVER['HTTP_REFERER']; ?>" />
					<?php endif; ?>
					<div class="form-group has-feedback">
						<input id="exampleInputEmail1" type="text" name="username" placeholder="<?php _e('Enter username', 'angle'); ?>" 
							autocomplete="off" required class="form-control">
						<span class="fa fa-envelope form-control-feedback text-muted"></span>
					</div>
					<div class="form-group has-feedback">
						<input id="exampleInputPassword1" type="password" name="pwd"
							placeholder="<?php _e('Password', 'angle'); ?>" required class="form-control" />
						<span class="fa fa-lock form-control-feedback text-muted"></span>
					</div>
					<div class="clearfix">
						<div class="checkbox c-checkbox pull-left mt0">
							<label>
								<input type="checkbox" value="" name="remember">
								<span class="fa fa-check"></span><?php _e('Remember Me', 'angle'); ?></label>
						</div>
						<div class="pull-right">
							<a href="recover.html" class="text-muted">
								<?php _e('Forgot your password?', 'angle'); ?>
							</a>
						</div>
					</div>
					<button type="submit" class="btn btn-block btn-primary mt-lg"><?php _e('Login', 'angle'); ?></button>
               </form>
               <p class="pt-lg text-center"><?php _e('Need to Signup?', 'angle'); ?></p>
			   <a href="<?php print SB_Route::_('index.php?mod=users&view=register'); ?>" 
					class="btn btn-block btn-default">
					<?php _e('Register Now', 'angle'); ?>
				</a>
            </div>
         </div>
         <!-- END panel-->
         <div class="p-lg text-center">
            <span>&copy;</span>
            <span><?php print date('Y'); ?></span>
            <span>-</span>
            <span><a href="http://sinticbolivia.net" target="_blank">SinticBolivia</span>
            <br>
            <span>Bootstrap Admin Template</span>
         </div>
      </div>
   </div>
   <!-- =============== VENDOR SCRIPTS ===============-->
   <!-- MODERNIZR-->
   <script src="<?php print TEMPLATE_URL; ?>/vendor/modernizr/modernizr.js"></script>
   <!-- STORAGE API-->
   <script src="<?php print TEMPLATE_URL; ?>/vendor/jQuery-Storage-API/jquery.storageapi.js"></script>
   <!-- PARSLEY-->
   <script src="<?php print TEMPLATE_URL; ?>/vendor/parsleyjs/dist/parsley.min.js"></script>
   <!-- =============== APP SCRIPTS ===============-->
   <script src="<?php print TEMPLATE_URL; ?>/js/app.js"></script>
   <?php lt_footer(); ?>
</body>
</html>