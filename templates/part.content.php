<script id="header-tpl" type="text/x-handlebars-template">
	<h1>
		<?php p($l->t('Mailing Liste')); ?>: <b>{{mailingList._name}} [{{mailingList._prefix}}]</b>
	</h1>

	<div class="ml-flex ml-thin-border-bottom">
		<h2 class="ml-flex ml-vertical-middle">
			Moderatoren
		</h2>
		<div class="ml-flex ml-vertical-middle">
			<div id="ml-feedback-moderator" class="ml-hidden ml-vertical-middle">Text is hidden</div>
			<input id="ml-moderator-subscribe-email" type="email" placeholder="Neue Moderator EMail Adresse" />
		</div>
	</div>

	<div class="ml-list">
	{{#each mailingList._mod}}
		<div class="ml-flex">
			<div id="ml-moderator-unsub" class="ml-member ml-flex-minimum">
				<img id="ml-moderator-unsub-img" data-id="{{this}}" class="ml-icon" src="<?php p(\OC::$server->getURLGenerator()->imagePath('core', 'actions/checkbox-mixed.svg')); ?>">
			</div>
			<div id="ml-member-email" class="ml-member">{{this}}</div>
		</div>
    {{/each}}
	</div>
</script>

<script id="member-list-tpl" type="text/x-handlebars-template">
	<input id="ml-member-listname" type="hidden" value="{{data.listName}}"/>

	<div class="ml-flex ml-thin-border-bottom">
		<h2 class="ml-flex ml-vertical-middle">
			{{data.heading}}
		</h2>
		<div class="ml-flex ml-vertical-middle">
			<input id="ml-member-subscribe-email" type="email" placeholder="Neue EMail Adresse"/>
		</div>
	</div>
	

	<div class="ml-list">
	{{#each data.elements}}
		<div class="ml-flex" id="{{this.email}}">
			<div id="ml-member-unsub" class="ml-member ml-flex-minimum">
				<a href="mailto:{{this.unsubscribeEMail}}">
					<img class="ml-icon" src="<?php p(\OC::$server->getURLGenerator()->imagePath('core', 'actions/checkbox-mixed.svg')); ?>">
				</a>
			</div>
			<div id="ml-member-email" class="ml-member">{{this.email}}</div>
		</div>
    {{/each}}
	</div>
</script>


<div class="ml-flex">
	<div id="ml-header" class="ml-header" />
	Header
</div>
<!-- div id="ml-listMenu" class="ml-listMenu ml-flex-minimum">Cog</div-->
</div>
<div class="ml-flex">
	<div id="ml-subscribers" class="ml-list">Subscribers</div>
	<div id="ml-allow" class="ml-list">Allowed</div>
</div>
