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
			<input type="radio" class="" name="backend" id="backend_fake" value="Development" checked>
			Development
		</label>
		<label>
			<input type="radio" class="" name="backend" id="backend_ezmlm" value="Ezmlm">
			Ezmlm
		</label>
		<label>
			<input type="radio" class="" name="backend" id="backend_mailman" value="MailMan"> 
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

		<div id="ezmlm_settings" class="ml-hidden">
			<h3><?php p($l->t('ezmlm Settings')); ?></h3>
			<table>
				<tr>
					<td>
						<label><?php p($l->t('Please enter the ezmlm home directory')); ?></label>
					</td>
					<td>
						<input type="text" id="ezmlm_home_dir" value="" placeholder="~/ezmlm" class="" style="width: 100%">
					</td>
				</tr>
				<tr>
					<td>
						<label><?php p($l->t('Please enter the domain of the list')); ?></label>
					</td>
					<td>
						<input type="text" id="ezmlm_domain" value="" placeholder="mydomain.org" class="" style="width: 100%">
					</td>
				</tr>
				<tr>
					<td colspan="2" class="descr">
						<em>
						<?php p($l->t('This will be appended to all generated mails to the list (i.e. subscribe/unsubscribe mails). The @ will be appended, so you can omit it.')); ?>.
						</em>
					</td>
				</tr>
			</table>
<!-- 			<br/>
			<label>
				<?php p($l->t('Please enter the domain of the list')); ?>
				<input type="text" class="" id="ezmlm_domain" value="" placeholder="mydomain.org">
			</label>
			<p class="descr">
				<em>
				<?php p($l->t('This will be appended to all generated mails to the list (i.e. subscribe/unsubscribe mails). The @ will be appended, so you can omit it.')); ?>.
				</em>
			</p>
-->			
		</div>

	</div>

	<span class="ml-msg" id="ml-msg"></span>

</div>