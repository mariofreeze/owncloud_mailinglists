<!-- translation strings -->
<!--div style="display:none" id="new-note-string"><?php p($l->t('New note')); ?></div-->

<script id="navigation-tpl" type="text/x-handlebars-template">
	{{#each mailingLists}}
		<li class="mailingList {{#if this._active}}active{{/if}}"  data-id="{{this._name}}">
			<a href="#">{{this._name}}</a>
<!--
			<div class="app-navigation-entry-utils">
				<ul>
					<li class="app-navigation-entry-utils-menu-button svg"><button></button></li>
				</ul>
			</div>
-->
		</li>
    {{/each}}
<!--
	<li><a href="#">First level entry</a></li>
	<li>
		<a href="#">First level container</a>
		<ul>
			<li><a href="#">Second level entry</a></li>
			<li><a href="#">Second level entry</a></li>
		</ul>
	</li>
-->
</script>

<ul></ul>