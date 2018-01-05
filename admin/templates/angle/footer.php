<!-- Page footer-->
	<footer>
		<span>&copy; <?php print date('Y'); ?> - Sintic Bolivia</span>
	</footer>
</div><!-- end class="wrapper" -->
<!-- =============== VENDOR SCRIPTS ===============-->
<!-- MODERNIZR-->
<script src="<?php print TEMPLATE_URL; ?>/vendor/modernizr/modernizr.js"></script>
<!-- STORAGE API-->
<script src="<?php print TEMPLATE_URL; ?>/vendor/jQuery-Storage-API/jquery.storageapi.js"></script>
<!-- JQUERY EASING-->
<script src="<?php print TEMPLATE_URL; ?>/vendor/jquery.easing/js/jquery.easing.js"></script>
<!-- ANIMO-->
<script src="<?php print TEMPLATE_URL; ?>/vendor/animo.js/animo.js"></script>
<!-- SLIMSCROLL-->
<script src="<?php print TEMPLATE_URL; ?>/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<!-- SCREENFULL-->
<script src="<?php print TEMPLATE_URL; ?>/vendor/screenfull/dist/screenfull.js"></script>
<!-- LOCALIZE-->
<script src="<?php print TEMPLATE_URL; ?>/vendor/jquery-localize-i18n/dist/jquery.localize.js"></script>
<!-- RTL demo-->
<script src="<?php print TEMPLATE_URL; ?>/js/demo/demo-rtl.js"></script>
<!-- =============== PAGE VENDOR SCRIPTS ===============-->
<!-- SPARKLINE-->
<script src="<?php print TEMPLATE_URL; ?>/vendor/sparklines/jquery.sparkline.min.js"></script>
<!-- FLOT CHART-->
<script src="<?php print TEMPLATE_URL; ?>/vendor/Flot/jquery.flot.js"></script>
<script src="<?php print TEMPLATE_URL; ?>/vendor/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="<?php print TEMPLATE_URL; ?>/vendor/Flot/jquery.flot.resize.js"></script>
<script src="<?php print TEMPLATE_URL; ?>/vendor/Flot/jquery.flot.pie.js"></script>
<script src="<?php print TEMPLATE_URL; ?>/vendor/Flot/jquery.flot.time.js"></script>
<script src="<?php print TEMPLATE_URL; ?>/vendor/Flot/jquery.flot.categories.js"></script>
<script src="<?php print TEMPLATE_URL; ?>/vendor/flot-spline/js/jquery.flot.spline.min.js"></script>
<!-- CLASSY LOADER-->
<script src="<?php print TEMPLATE_URL; ?>/vendor/jquery-classyloader/js/jquery.classyloader.min.js"></script>
<!-- MOMENT JS-->
<script src="<?php print TEMPLATE_URL; ?>/vendor/moment/min/moment-with-locales.min.js"></script>
<!-- SKYCONS-->
<script src="<?php print TEMPLATE_URL; ?>/vendor/skycons/skycons.js"></script>
<!-- DEMO-->
<script src="<?php print TEMPLATE_URL; ?>/js/demo/demo-flot.js"></script>
<!-- =============== APP SCRIPTS ===============-->
<script src="<?php print TEMPLATE_URL; ?>/js/app.js"></script>
<?php lt_footer(); ?>
<script>
//##fix modal issue
document.querySelectorAll('.modal').forEach(function(modal)
{
	var obj = modal.cloneNode();
	obj.innerHTML = modal.innerHTML;
	modal.remove();
	document.body.appendChild(obj);
});
</script>
</body>
</html>