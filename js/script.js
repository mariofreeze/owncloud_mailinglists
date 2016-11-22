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
//				newNote: $('#new-note-string').text()
		};

		// this MailingList object holds all data of a MailingList
		var MailingList = function (name) {
			this._name = name;
			this._prefix = '';
			this._subscribers = [];
			this._allow = [];
			this._mod = [];
			this._active = false;
		};

		// this MailingLists object holds all our MailingLists
		var MailingLists = function (baseUrl) {
			this._baseUrl = baseUrl;
			this._mailingLists = [];
			this._active = undefined;
			this._currentUsersEmail = undefined;
			this._isListAdmin = undefined;
		};

		MailingLists.prototype = {
				loadAll: function () {
					// Loads all MailingList
					var deferred = $.Deferred();
					var self = this;

					var url = this._baseUrl + '/isListAdmin'
					$.ajax({
						url: url,
						method: 'GET'
					}).done(function (isListAdmin) {
						self._isListAdmin = isListAdmin;
					});
					
					$.ajax({
						url: this._baseUrl + '/list',
						method: 'GET'
					}).done(function (mailingLists) {
						if (mailingLists.length > 0) {
							self._active = mailingLists[0];
						} else {
							self._active = undefined;
						}
						self._mailingLists = [];
						$.each(mailingLists, function( index, value ) {
							self._mailingLists.push(new MailingList(value))
						});
						deferred.resolve();
					}).fail(function () {
						deferred.reject();
					});

					return deferred.promise();
				},
				getAll: function () {
					return this._mailingLists;
				},
				getActive: function () {
					return this._active;
				},
				// Loads all Members etc of a MailingList
				load: function (name) {
					var deferred = $.Deferred();
					var self = this;
					$.each(self._mailingLists, function( index, mailingList ) {
						if (mailingList._name === name) {
							mailingList._active = true;
							self._active = mailingList;
						} else {
							mailingList._active = false;
						}
					});

					var url = this._baseUrl + '/list/' + name;
//					var url = this._baseUrl + '/list';
					$.ajax({
						url: url,
						method: 'GET',
						//data: JSON.stringify(name)
					}).done(function (data) {
						var listData = data[0];
						self._active._prefix = listData.prefix;
						self._active._mod = listData.mod;
						self._active._subscribers = listData.subscribers;
						self._active._allow = listData.allow;
						self._currentUsersEmail = '';  // erst ab 9.1
						deferred.resolve();
					}).fail(function () {
						deferred.reject();
					});

					return deferred.promise();
				},
				addRemoveModerator: function(eMail, add) {
					var deferred = $.Deferred();
					var self = this;
					var url = this._baseUrl + '/list/' + self._active._name + '/' + eMail;
					var method = add ? 'POST' : 'DELETE';					
					$.ajax({
						url: url,
						method: method
					}).done(function (data) {
						deferred.resolve();
					}).fail(function () {
						deferred.reject();
					});
					return deferred.promise();
				},
		};

		// this will be the view that is used to update the html
		var View = function (mailingLists) {
			this._mailingLists = mailingLists;
		};

		View.prototype = {
				renderContent: function () {
					var self = this;
					
					var header = $('#header-tpl').html();
					var headerTemplate = Handlebars.compile(header);
					var headerHtml = headerTemplate({mailingList: self._mailingLists.getActive()});
					$('#ml-header').html(headerHtml);
					if (self._mailingLists._isListAdmin) {
						$('#ml-header').find('#ml-moderator-subscribe-email').first().on('keypress', function (e) {
							if(e.which === 13){
								e.preventDefault();
								var eMail = this.value;
								self._mailingLists.addRemoveModerator(eMail, true).done(function () {
									self._mailingLists._active._mod.push(eMail);
									self.renderContent();
								}).fail(function () {
									$('#ml-feedback-moderator').html('Error occured adding the moderator '+eMail);
									$('#ml-feedback-moderator').removeClass('ml-hidden').addClass('ml-flex ml-red');
								});
							}
						});
						$('#ml-header').find('img').click(function (event) {
							var eMail = event.target.attributes['data-id'].value;
							self._mailingLists.addRemoveModerator(eMail, false).done(function () {
								var index = self._mailingLists._active._mod.indexOf(eMail);
								self._mailingLists._active._mod.splice(index, 1);
								self.renderContent();
							}).fail(function () {
								$('#ml-feedback-moderator').html('Error occured removing the moderator '+eMail);
								$('#ml-feedback-moderator').removeClass('ml-hidden').addClass('ml-flex ml-red');
							});
						});
					} else {
						$('#ml-header').find('#ml-moderator-subscribe-email').addClass('ml-hidden');
						$('#ml-header').find('img').addClass('ml-hidden');
					}					
					var list = $('#member-list-tpl').html();
					var listTemplate = Handlebars.compile(list);
					renderMemberLists('Empfaenger der Liste', listTemplate, '#ml-subscribers', self._mailingLists.getActive()._subscribers, null);
					renderMemberLists('Zusaetzlich erlaubte Absender', listTemplate, '#ml-allow', self._mailingLists.getActive()._allow, 'allow');
					
					function renderMemberLists(heading, listTemplate, targetElement, subcribers, subMemberList) {
						var data = {};
						data.elements = [];
						data.listName = self._mailingLists.getActive()._name;
						if (subcribers != null) {
							for (i = 0; i < subcribers.length; i++) {
								var subscriber = {};
								subscriber.email = subcribers[i];
								subscriber.unsubscribeEMail = self._mailingLists.getActive()._name + (subMemberList != null ? '-'+subMemberList : '') + "-unsubscribe-" + subcribers[i].replace("@", "=") + "@freieschulefrankfurt.de";
								data.elements.push(subscriber);
							}
						}
						data.heading = Handlebars.Utils.escapeExpression(heading);
						var subscriberHtml = listTemplate({data : data});
						$(targetElement).html(subscriberHtml);

						$(targetElement).find('#ml-member-subscribe-email').first().on('keypress', function (e) {
							if(e.which === 13){
								e.preventDefault();
								var email =  $('#ml-member-listname').val() + (subMemberList != null ? '-'+subMemberList : '') + "-subscribe-" +  this.value.replace("@", "=") + "@freieschulefrankfurt.de";
								var subject = 'New Subscription';
								var emailBody = 'Not important';
								window.location = 'mailto:' + email + '?subject=' + subject + '&body=' +   emailBody;
							}
						});
					};
				},

				renderNavigation: function () {
					var source = $('#navigation-tpl').html();
					var template = Handlebars.compile(source);
					var html = template({mailingLists: this._mailingLists.getAll()});

					$('#app-navigation ul').html(html);
					var self = this;
					/*
				// create a new note
				var self = this;
				$('#new-note').click(function () {
					var note = {
						title: translations.newNote,
						content: ''
					};

					self._notes.create(note).done(function() {
						self.render();
						$('#editor textarea').focus();
					}).fail(function () {
						alert('Could not create note');
					});
				});
					 */
					// show app menu
					$('#app-navigation .app-navigation-entry-utils-menu-button').click(function () {
						var entry = $(this).closest('.note');
						entry.find('.app-navigation-entry-menu').toggleClass('open');
					});
					// load the members of the mailinglist
					$('#app-navigation .mailingList > a').click(function () {
						var name = $(this).text();
						self._mailingLists.load(name).done(function () {
							self.render();
						}).fail(function () {
							alert('Could not load list members');
						});
					});
				},

				render: function () {
					this.renderNavigation();
					this.renderContent();
				}
		};

		var mailingLists = new MailingLists(OC.generateUrl('/apps/mailinglists'));
		mailingLists.loadAll().done(function () {
			var view = new View(mailingLists);
			view.render();
		}).fail(function () {
			alert('Could not load MailingList');
		});

		/*		$('#hello').click(function () {
                    alert('Hello from your script file');
                });

                $('#echo').click(function () {
                    var url = OC.generateUrl('/apps/mailinglists/echo');
                    var data = {
                        echo: $('#echo-content').val()
                    };

                    $.post(url, data).success(function (response) {
                        $('#echo-result').text(response.echo);
                    });

                });
		 */

	});

})(OC, window, jQuery);