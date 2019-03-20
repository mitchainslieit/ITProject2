
	<div id="footer">
		<div class="row">
			<p class="copy">&copy 2019. Bakakeng National Highschool, Baguio City</p>
		</div>
	</div>
</div>
</div>
<script>
$('[name=opener]').each(function () {
  var panel = $(this).siblings('[name=dialog]');
  $(this).click(function () {
      panel.dialog('open');
      $('.ui-widget-overlay').addClass('custom-overlay');
  });
});

$('[name=dialog]').dialog({
  autoOpen: false,
  modal: true
});
</script>
<script src="<?php echo URL; ?>public/libs/sidebar-menu/sidebar-menu.js"></script>
<script> $.sidebarMenu($('.sidebar-menu')); </script>
<script src="<?php echo URL; ?>public/scripts/responsive-menu.js"></script>
<script src="<?php echo URL; ?>public/scripts/sitescripts.js"></script>
<?php if( $this->siteInfo['cookie'] ): ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
<?php endif; ?>
</body>
</html>


