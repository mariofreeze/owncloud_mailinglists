/**
 * ownCloud - mailinglists
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Mario Frese <mariofreeze@users.noreply.github.com>
 * @copyright Mario Frese 2016
 */

(function (OC, window, $, undefined) {
	'use strict';

	$(document).ready(function () {
		var translations = {
//		newNote: $('#new-note-string').text()
		};

		// this MailingList object holds all data of a MailingList
		var MailingListsSettings = function (baseUrl) {
			this._baseUrl = baseUrl;
			this._settings = [];
		};


		MailingListsSettings.prototype = {
			load: function () {
				// Loads all MailingList
				var deferred = $.Deferred();
				var self = this;
				$.ajax({
					url: this._baseUrl,
					method: 'GET'
				}).done(function (settings) {
					self._settings = settings;
					deferred.resolve();
				}).fail(function () {
					deferred.reject();
				});
				return deferred.promise();
			},
			
			setAdminKey: function(key, value) {
				var deferred = $.Deferred();
				var data = {
					key: key,
					value: value
				};
//				var url = this._baseUrl + '/' + key + '/' + encodeURIComponent(value);
				var url = this._baseUrl;
				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function( data ) {
					$('#ml-msg').addClass("ml-msg-success");
					$('#ml-msg').text(t('MailingLists', 'Successfully set ') + ' ' + key + ' to ' + value);
					deferred.resolve(data);
				}).fail(function() {
					$('#ml-msg').addClass("ml-msg-error");
					$('#ml-msg').text(t('MailingLists', 'Error while saving field') + ' ' + key + '!');
					deferred.reject();
				});
			},
			getKey: function(key) {
				for (var k in this._settings)
				{
					if (k == key)
						return this._settings[k];
				}
			},
		};

		// this will be the view that is used to update the html
		var View = function (settings) {
			this._settings = settings;
		};

		View.prototype = {
			render: function () {
				// fill the boxes
				if (settings.getKey('backend').toLowerCase() == 'ezmlm') {
					$('#ezmlm_settings').removeClass('ml-hidden');
				}
				$('#ezmlm_home_dir').val(settings.getKey('ezmlm_home'));
				$('#ezmlm_home_dir').change(function () {
					settings.setAdminKey('ezmlm_home', $(this).val().replace(/\/*\s*$/, ""));
				});
				$('#ezmlm_domain').val(settings.getKey('ezmlm_domain'));
				$('#ezmlm_domain').change(function () {
					settings.setAdminKey('ezmlm_domain', $(this).val().trim().replace(/^@*/, ""));
				});

				
				$('#backend_fake').prop('checked', (settings.getKey('backend').toLowerCase() == 'development'));
				$('#backend_fake').change(function () {
					settings.setAdminKey('backend', $(this).val());
					$('#ezmlm_settings').addClass('ml-hidden');
				});
				
				$('#backend_ezmlm').prop('checked', (settings.getKey('backend').toLowerCase() == 'ezmlm'));
				$('#backend_ezmlm').change(function () {
					settings.setAdminKey('backend', $(this).val());
					$('#ezmlm_settings').removeClass('ml-hidden');
				});
				
				$('#backend_mailman').prop('checked', (settings.getKey('backend').toLowerCase() == 'mailman'));
				$('#backend_mailman').change(function () {
					settings.setAdminKey('backend', $(this).val());
					$('#ezmlm_settings').addClass('ml-hidden');
				});
				
				var groups = $('#group-tpl').html();
				var groupsTemplate = Handlebars.compile(groups);
				var groupsHtml = groupsTemplate({groups: settings.getKey('groups')});
				$('#ml-admin_group').html(groupsHtml);
				$('#ml-admin_group-option-'+settings.getKey('admin_group')).prop('selected', true);
				$('#ml-admin_group').change(function () {
					settings.setAdminKey('admin_group', $(this).val());
				});
//				alert('MailingList rendering completed');
			},
		};

		var settings = new MailingListsSettings(OC.generateUrl('/apps/mailinglists/settings'));
//		alert('MailingList loading with settings from ' + settings._baseUrl);
		settings.load().done(function () {
			var view = new View(settings);
			view.render();
		}).fail(function () {
			alert('Could not load MailingList Settings');
		});

	});

})(OC, window, jQuery);