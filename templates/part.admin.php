<script id="group-tpl" type="text/x-handlebars-template">
	{{#each groups}}
		<option id="ml-admin_group-option-{{this}}">
			<p>{{this}}</p>
		</option>
    {{/each}}
</script>

<div class="section" id="mailinglists-admin">
<h2><?php p($l->t('MailingLists')); ?></h2>

	<br>
	<div>
		<h3><?php p($l->t('General')); ?></h3>

		<p><?php p($l->t('Select which mailing list backend you are using')); ?>.</p>
		<label>
			<input type="radio" class="radio" name="backend" id="backend_fake" value="Development" checked>
			Development
		</label>
		<label>
			<input class="radio" type="radio" name="backend" id="backend_ezmlm" value="Ezmlm">
			Ezmlm
		</label>
		<label>
			<input class="radio" type="radio" name="backend" id="backend_mailman" value="MailMan"> 
			MailMan
		</label>
		<p class="descr">
			<em class="https_warning">
			<?php p($l->t('Select Development for development purpose')); ?>.
			</em>
		</p>
<!-- in 9.0 we can get the email of the user
		<h3><?php p($l->t('Security')); ?></h3>

		<label>
			<input class="check" type="checkbox" id="allow_view_members"> 
			<?php p($l->t('Allow non members to view members of a mailing list')); ?>.
		</label>
		<p class="descr">
			<em>
			<?php p($l->t('If disabled members will still see all mailing lists that are created an can subscribe to them')); ?>.
			</em>
		</p>
-->
		<label>
			<?php p($l->t('Group membership required for administrative actions')); ?>:
			<select class="select" id="ml-admin_group">
			</select>
		</label>
		<p class="descr">
			<em>
			<?php p($l->t('Only members of this group can change the moderators.')); ?>.
			</em>
		</p>

	</div>

	<span class="msg-mailinglists"></span>

</div>