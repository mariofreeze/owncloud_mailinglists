<?php
script('mailinglists', 'handlebars-v4.0.5');
script('mailinglists', 'script');
style('mailinglists', 'style');
?>

<script>
	var baseUrl = OC.generateUrl('/apps/mailinglists');
</script>


<div id="app">
	<div id="app-navigation">
		<?php print_unescaped($this->inc('part.navigation')); ?>
		<?php print_unescaped($this->inc('part.settings')); ?>
	</div>

	<div id="app-content">
		<div id="app-content-wrapper">
			<?php print_unescaped($this->inc('part.content')); ?>
		</div>
	</div>
</div>
