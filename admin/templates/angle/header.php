<?php 
$user = sb_get_current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta name="description" content="Bootstrap Admin App + jQuery">
	<meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
	<title><?php lt_title(); ?></title>
	<script src="<?php print BASEURL; ?>/js/jquery.min.js"></script>
	<?php lt_head(); ?>
   <!-- =============== VENDOR STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="<?php print TEMPLATE_URL; ?>/vendor/fontawesome/css/font-awesome.min.css">
   <!-- SIMPLE LINE ICONS-->
   <link rel="stylesheet" href="<?php print TEMPLATE_URL; ?>/vendor/simple-line-icons/css/simple-line-icons.css">
   <!-- ANIMATE.CSS-->
   <link rel="stylesheet" href="<?php print TEMPLATE_URL; ?>/vendor/animate.css/animate.min.css">
   <!-- WHIRL (spinners)-->
   <link rel="stylesheet" href="<?php print TEMPLATE_URL; ?>/vendor/whirl/dist/whirl.css">
   <!-- =============== PAGE VENDOR STYLES ===============-->
   <!-- WEATHER ICONS-->
   <link rel="stylesheet" href="<?php print TEMPLATE_URL; ?>/vendor/weather-icons/css/weather-icons.min.css">
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="<?php print TEMPLATE_URL; ?>/css/bootstrap.css" id="bscss" />
   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="<?php print TEMPLATE_URL; ?>/css/app.css" id="maincss" />
   <link rel="stylesheet" href="<?php print TEMPLATE_URL; ?>/style.css" />
   <script src="<?php print BASEURL; ?>/js/bootstrap-3.3.5/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="<?php print BASEURL; ?>/js/bootstrap-datepicker-1.4.0/css/bootstrap-datepicker.min.css" />
	<script src="<?php print BASEURL; ?>/js/bootstrap-datepicker-1.4.0/js/bootstrap-datepicker.min.js"></script>
	<script src="<?php print BASEURL; ?>/js/bootstrap-datepicker-1.4.0/locales/bootstrap-datepicker.es.min.js"></script>
	<script>
	jQuery(function()
	{
		jQuery('.datepicker').datepicker({
			format: lt.dateformat,
			weekStart: 0,
			//todayBtn: true,
			autoclose: true,
			todayHighlight: true,
			language: "es"
			//clearBtn: true,
			//startDate: 2015//'3d'
		});
	});
	</script>
	<?php if( $user->_angle_colors ): ?>
	<link id="autoloaded-stylesheet" rel="stylesheet" href="<?php print TEMPLATE_URL; ?>/css/<?php print $user->_angle_colors; ?>" />
	<?php endif; ?>
</head>
<body <?php lt_body_id(); ?> <?php lt_body_class(); ?>>
	<div class="wrapper">
		<?php if( !defined('MOD_TEMPLATE') ): ?>
		<!-- top navbar-->
		<header class="topnavbar-wrapper">
			<!-- START Top Navbar-->
			<nav role="navigation" class="navbar topnavbar">
            <!-- START navbar header-->
            <div class="navbar-header">
               <a href="" class="navbar-brand">
                  <div class="brand-logo">
                     <img src="<?php print TEMPLATE_URL; ?>/img/logo.png" alt="App Logo" class="img-responsive">
                  </div>
                  <div class="brand-logo-collapsed">
                     <img src="<?php print TEMPLATE_URL; ?>/img/logo-single.png" alt="App Logo" class="img-responsive">
                  </div>
               </a>
            </div>
            <!-- END navbar header-->
            <!-- START Nav wrapper-->
            <div class="nav-wrapper">
               <!-- START Left navbar-->
               <ul class="nav navbar-nav">
                  <li>
                     <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                     <a href="#" data-toggle-state="aside-collapsed" class="hidden-xs">
                        <em class="fa fa-navicon"></em>
                     </a>
                     <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                     <a href="#" data-toggle-state="aside-toggled" data-no-persist="true" class="visible-xs sidebar-toggle">
                        <em class="fa fa-navicon"></em>
                     </a>
                  </li>
                  <!-- START User avatar toggle-->
                  <li>
                     <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                     <a id="user-block-toggle" href="#user-block" data-toggle="collapse">
                        <em class="glyphicon glyphicon-user"></em>
                     </a>
                  </li>
                  <!-- END User avatar toggle-->
                  <!-- START lock screen-->
                  <li>
                     <a href="lock.html" title="Lock screen">
                        <em class="glyphicon glyphicon-lock"></em>
                     </a>
                  </li>
				  <li>
					<a href="<?php print SB_Route::_('index.php?mod=users&task=logout'); ?>" 
						title="<?php _e('Logout', 'angle'); ?>">
						<span class="glyphicon glyphicon-log-out"></span></a>
				  </li>
                  <!-- END lock screen-->
               </ul>
               <!-- END Left navbar-->
               <!-- START Right Navbar-->
               <ul class="nav navbar-nav navbar-right">
                  <!-- Search icon-->
                  <li>
                     <a href="#" data-search-open="">
                        <em class="glyphicon glyphicon-search"></em>
                     </a>
                  </li>
                  <!-- Fullscreen (only desktops)-->
                  <li class="visible-lg">
                     <a href="#" data-toggle-fullscreen="">
                        <em class="fa fa-expand"></em>
                     </a>
                  </li>
                  <!-- START Alert menu-->
                  <li class="dropdown dropdown-list">
                     <a href="#" data-toggle="dropdown">
                        <em class="glyphicon glyphicon-bell"></em>
                        <div class="label label-danger">11</div>
                     </a>
                     <!-- START Dropdown menu-->
                     <ul class="dropdown-menu animated flipInX">
                        <li>
                           <!-- START list group-->
                           <div class="list-group">
                              <!-- list item-->
                              <a href="#" class="list-group-item">
                                 <div class="media-box">
                                    <div class="pull-left">
                                       <em class="fa fa-twitter fa-2x text-info"></em>
                                    </div>
                                    <div class="media-box-body clearfix">
                                       <p class="m0">New followers</p>
                                       <p class="m0 text-muted">
                                          <small>1 new follower</small>
                                       </p>
                                    </div>
                                 </div>
                              </a>
                              <!-- list item-->
                              <a href="#" class="list-group-item">
                                 <div class="media-box">
                                    <div class="pull-left">
                                       <em class="fa fa-envelope fa-2x text-warning"></em>
                                    </div>
                                    <div class="media-box-body clearfix">
                                       <p class="m0">New e-mails</p>
                                       <p class="m0 text-muted">
                                          <small>You have 10 new emails</small>
                                       </p>
                                    </div>
                                 </div>
                              </a>
                              <!-- list item-->
                              <a href="#" class="list-group-item">
                                 <div class="media-box">
                                    <div class="pull-left">
                                       <em class="fa fa-tasks fa-2x text-success"></em>
                                    </div>
                                    <div class="media-box-body clearfix">
                                       <p class="m0">Pending Tasks</p>
                                       <p class="m0 text-muted">
                                          <small>11 pending task</small>
                                       </p>
                                    </div>
                                 </div>
                              </a>
                              <!-- last list item -->
                              <a href="#" class="list-group-item">
                                 <small>More notifications</small>
                                 <span class="label label-danger pull-right">14</span>
                              </a>
                           </div>
                           <!-- END list group-->
                        </li>
                     </ul>
                     <!-- END Dropdown menu-->
                  </li>
                  <!-- END Alert menu-->
                  <!-- START Contacts button-->
                  <li>
                     <a href="#" data-toggle-state="offsidebar-open" data-no-persist="true">
                        <em class="glyphicon glyphicon-option-vertical"></em>
                     </a>
                  </li>
                  <!-- END Contacts menu-->
               </ul>
               <!-- END Right Navbar-->
            </div>
            <!-- END Nav wrapper-->
            <!-- START Search form-->
            <form role="search" action="search.html" class="navbar-form">
               <div class="form-group has-feedback">
                  <input type="text" placeholder="Type and hit enter ..." class="form-control">
                  <div data-search-dismiss="" class="fa fa-times form-control-feedback"></div>
               </div>
               <button type="submit" class="hidden btn btn-default">Submit</button>
            </form>
            <!-- END Search form-->
         </nav>
         <!-- END Top Navbar-->
      </header>
      <!-- sidebar-->
      <?php lt_get_sidebar(); ?>
	  <?php endif; ?>