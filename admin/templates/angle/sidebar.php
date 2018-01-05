<?php
$themes = array(
	array(
		'href' => TEMPLATE_URL  . '/css/theme-a.css',
		'class'	=> 'bg-info',
		'bg'	=> 'bg-white'
	),
	array(
		'href' => TEMPLATE_URL  . '/css/theme-b.css',
		'class'	=> 'bg-green',
		'bg'	=> 'bg-white'
	),
	array(
		'href' => TEMPLATE_URL  . '/css/theme-c.css',
		'class'	=> 'bg-purple',
		'bg'	=> 'bg-white'
	),
	array(
		'href' => TEMPLATE_URL  . '/css/theme-d.css',
		'class'	=> 'bg-danger',
		'bg'	=> 'bg-white'
	),
	array(
		'href' => TEMPLATE_URL  . '/css/theme-e.css',
		'class'	=> 'bg-info',
		'bg'	=> 'bg-gray-dark'
	),
	array(
		'href' => TEMPLATE_URL  . '/css/theme-f.css',
		'class'	=> 'bg-green',
		'bg'	=> 'bg-gray-dark'
	),
	array(
		'href' => TEMPLATE_URL  . '/css/theme-g.css',
		'class'	=> 'bg-purple',
		'bg'	=> 'bg-gray-dark'
	),
	array(
		'href' => TEMPLATE_URL  . '/css/theme-h.css',
		'class'	=> 'bg-danger',
		'bg'	=> 'bg-gray-dark'
	),
);
?>
<aside class="aside">
	<!-- START Sidebar (left)-->
	<div class="aside-inner">
		<nav data-sidebar-anyclick-close="" class="sidebar">
		<!-- START sidebar nav-->
			<ul class="nav">
				<!-- START user info-->
				<li class="has-user-block">
					<div id="user-block" class="collapse">
						<div class="item user-block">
							<!-- User picture-->
							<div class="user-block-picture">
								<div class="user-block-status">
									<img src="<?php print sb_get_user_image_url(sb_get_current_user()->user_id); ?>" 
											alt="Avatar" width="60" height="60" class="img-thumbnail img-circle" />
									<div class="circle circle-success circle-lg"></div>
								</div>
							</div>
							<!-- Name and Job-->
							<div class="user-block-info">
								<span class="user-block-name">
									<?php printf(__('Hello %s', 'lb'), sb_get_current_user()->first_name); ?>
								</span>
								<span class="user-block-role"><?php print sb_get_current_user()->role->role_name ?></span>
							</div>
						</div>
					</div>
				</li>
				<!-- END user info-->
				<!-- Iterates over all sidebar items-->
				<li class="nav-heading ">
					<span data-localize="sidebar.heading.HEADER"><?php _e('Main Navigation', 'angle'); ?></span>
				</li>
			</ul>
			<?php SB_Menu::rederMenu('backend', array('class' => 'nav', 
															'class_submenu' => 'nav sidebar-subnav collapse')); ?>
			<!-- END sidebar nav-->
		</nav>
	</div>
</aside><!-- END Sidebar (left)-->
<!-- offsidebar-->
      <aside class="offsidebar hide">
         <!-- START Off Sidebar (right)-->
         <nav>
            <div role="tabpanel">
               <!-- Nav tabs-->
               <ul role="tablist" class="nav nav-tabs nav-justified">
                  <li role="presentation" class="active">
                     <a href="#app-settings" aria-controls="app-settings" role="tab" data-toggle="tab">
                        <em class="icon-equalizer fa-lg"></em>
                     </a>
                  </li>
                  <li role="presentation">
                     <a href="#app-chat" aria-controls="app-chat" role="tab" data-toggle="tab">
                        <em class="icon-users fa-lg"></em>
                     </a>
                  </li>
               </ul>
               <!-- Tab panes-->
               <div class="tab-content">
                  <div id="app-settings" role="tabpanel" class="tab-pane fade in active">
                     <h3 class="text-center text-thin">Settings</h3>
                     <div class="p">
                        <h4 class="text-muted text-thin">Themes</h4>
                        <div class="container-fluid">
							<div class="row">
								<?php foreach($themes as $t): ?>
								<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 mb">
									<div class="setting-color">
                                 <label data-load-css="<?php print $t['href']; ?>">
                                    <input type="radio" name="setting-theme" checked="checked">
                                    <span class="icon-check"></span>
                                    <span class="split">
                                       <span class="color <?php print $t['class']; ?>"></span>
                                       <span class="color <?php print $t['class']; ?>-light"></span>
                                    </span>
                                    <span class="color <?php print $t['bg'] ?>"></span>
                                 </label>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
                        </div>
                     </div>
                     <div class="p">
                        <h4 class="text-muted text-thin"><?php _e('Layout', 'angle'); ?></h4>
                        <div class="clearfix">
                           <p class="pull-left"><?php _e('Fixed', 'angle'); ?></p>
                           <div class="pull-right">
                              <label class="switch">
                                 <input id="chk-fixed" type="checkbox" data-toggle-state="layout-fixed">
                                 <span></span>
                              </label>
                           </div>
                        </div>
                        <div class="clearfix">
                           <p class="pull-left"><?php _e('Boxed', 'angle'); ?></p>
                           <div class="pull-right">
                              <label class="switch">
                                 <input id="chk-boxed" type="checkbox" data-toggle-state="layout-boxed">
                                 <span></span>
                              </label>
                           </div>
                        </div>
                        <div class="clearfix">
                           <p class="pull-left">RTL</p>
                           <div class="pull-right">
                              <label class="switch">
                                 <input id="chk-rtl" type="checkbox">
                                 <span></span>
                              </label>
                           </div>
                        </div>
                     </div>
                     <div class="p">
                        <h4 class="text-muted text-thin">Aside</h4>
                        <div class="clearfix">
                           <p class="pull-left">Collapsed</p>
                           <div class="pull-right">
                              <label class="switch">
                                 <input id="chk-collapsed" type="checkbox" data-toggle-state="aside-collapsed">
                                 <span></span>
                              </label>
                           </div>
                        </div>
                        <div class="clearfix">
                           <p class="pull-left">Float</p>
                           <div class="pull-right">
                              <label class="switch">
                                 <input id="chk-float" type="checkbox" data-toggle-state="aside-float">
                                 <span></span>
                              </label>
                           </div>
                        </div>
                        <div class="clearfix">
                           <p class="pull-left">Hover</p>
                           <div class="pull-right">
                              <label class="switch">
                                 <input id="chk-hover" type="checkbox" data-toggle-state="aside-hover">
                                 <span></span>
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div id="app-chat" role="tabpanel" class="tab-pane fade">
                     <h3 class="text-center text-thin">Connections</h3>
                     <ul class="nav">
                        <!-- START list title-->
                        <li class="p">
                           <small class="text-muted">ONLINE</small>
                        </li>
                        <!-- END list title-->
                        <li>
                           <!-- START User status-->
                           <a href="#" class="media-box p mt0">
                              <span class="pull-right">
                                 <span class="circle circle-success circle-lg"></span>
                              </span>
                              <span class="pull-left">
                                 <!-- Contact avatar-->
                                 <img src="<?php print TEMPLATE_URL; ?>/img/user/05.jpg" alt="Image" class="media-box-object img-circle thumb48">
                              </span>
                              <!-- Contact info-->
                              <span class="media-box-body">
                                 <span class="media-box-heading">
                                    <strong>Juan Sims</strong>
                                    <br>
                                    <small class="text-muted">Designeer</small>
                                 </span>
                              </span>
                           </a>
                           <!-- END User status-->
                           <!-- START User status-->
                           <a href="#" class="media-box p mt0">
                              <span class="pull-right">
                                 <span class="circle circle-success circle-lg"></span>
                              </span>
                              <span class="pull-left">
                                 <!-- Contact avatar-->
                                 <img src="<?php print TEMPLATE_URL; ?>/img/user/06.jpg" alt="Image" class="media-box-object img-circle thumb48">
                              </span>
                              <!-- Contact info-->
                              <span class="media-box-body">
                                 <span class="media-box-heading">
                                    <strong>Maureen Jenkins</strong>
                                    <br>
                                    <small class="text-muted">Designeer</small>
                                 </span>
                              </span>
                           </a>
                           <!-- END User status-->
                           <!-- START User status-->
                           <a href="#" class="media-box p mt0">
                              <span class="pull-right">
                                 <span class="circle circle-danger circle-lg"></span>
                              </span>
                              <span class="pull-left">
                                 <!-- Contact avatar-->
                                 <img src="<?php print TEMPLATE_URL; ?>/img/user/07.jpg" alt="Image" class="media-box-object img-circle thumb48">
                              </span>
                              <!-- Contact info-->
                              <span class="media-box-body">
                                 <span class="media-box-heading">
                                    <strong>Billie Dunn</strong>
                                    <br>
                                    <small class="text-muted">Designeer</small>
                                 </span>
                              </span>
                           </a>
                           <!-- END User status-->
                           <!-- START User status-->
                           <a href="#" class="media-box p mt0">
                              <span class="pull-right">
                                 <span class="circle circle-warning circle-lg"></span>
                              </span>
                              <span class="pull-left">
                                 <!-- Contact avatar-->
                                 <img src="<?php print TEMPLATE_URL; ?>/img/user/08.jpg" alt="Image" class="media-box-object img-circle thumb48">
                              </span>
                              <!-- Contact info-->
                              <span class="media-box-body">
                                 <span class="media-box-heading">
                                    <strong>Tomothy Roberts</strong>
                                    <br>
                                    <small class="text-muted">Designer</small>
                                 </span>
                              </span>
                           </a>
                           <!-- END User status-->
                        </li>
                        <!-- START list title-->
                        <li class="p">
                           <small class="text-muted">OFFLINE</small>
                        </li>
                        <!-- END list title-->
                        <li>
                           <!-- START User status-->
                           <a href="#" class="media-box p mt0">
                              <span class="pull-right">
                                 <span class="circle circle-lg"></span>
                              </span>
                              <span class="pull-left">
                                 <!-- Contact avatar-->
                                 <img src="<?php print TEMPLATE_URL; ?>/img/user/09.jpg" alt="Image" class="media-box-object img-circle thumb48">
                              </span>
                              <!-- Contact info-->
                              <span class="media-box-body">
                                 <span class="media-box-heading">
                                    <strong>Lawrence Robinson</strong>
                                    <br>
                                    <small class="text-muted">Developer</small>
                                 </span>
                              </span>
                           </a>
                           <!-- END User status-->
                           <!-- START User status-->
                           <a href="#" class="media-box p mt0">
                              <span class="pull-right">
                                 <span class="circle circle-lg"></span>
                              </span>
                              <span class="pull-left">
                                 <!-- Contact avatar-->
                                 <img src="<?php print TEMPLATE_URL; ?>/img/user/10.jpg" alt="Image" class="media-box-object img-circle thumb48">
                              </span>
                              <!-- Contact info-->
                              <span class="media-box-body">
                                 <span class="media-box-heading">
                                    <strong>Tyrone Owens</strong>
                                    <br>
                                    <small class="text-muted">Designer</small>
                                 </span>
                              </span>
                           </a>
                           <!-- END User status-->
                        </li>
                        <li>
                           <div class="p-lg text-center">
                              <!-- Optional link to list more users-->
                              <a href="#" title="See more contacts" class="btn btn-purple btn-sm">
                                 <strong>Load more..</strong>
                              </a>
                           </div>
                        </li>
                     </ul>
                     <!-- Extra items-->
                     <div class="p">
                        <p>
                           <small class="text-muted">Tasks completion</small>
                        </p>
                        <div class="progress progress-xs m0">
                           <div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-success progress-80">
                              <span class="sr-only">80% Complete</span>
                           </div>
                        </div>
                     </div>
                     <div class="p">
                        <p>
                           <small class="text-muted">Upload quota</small>
                        </p>
                        <div class="progress progress-xs m0">
                           <div role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-warning progress-40">
                              <span class="sr-only">40% Complete</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </nav>
         <!-- END Off Sidebar (right)-->
      </aside>