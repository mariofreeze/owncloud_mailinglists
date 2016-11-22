<?php
/**
 * ownCloud - mailinglists
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Mario Frese <mariofreeze@users.noreply.github.com>
 * @copyright Mario Frese 2016
 */

/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\MailingLists\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */

namespace OCA\MailingLists\AppInfo;

$application = new MailingListApplication();

$application->registerRoutes(
	$this,
	[
		'routes' => [
			['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
			['name' => 'list#loadAll', 'url' => '/list', 'verb' => 'GET'],
			['name' => 'list#checkAdminGroup', 'url' => '/isListAdmin', 'verb' => 'GET'],
			['name' => 'list#load', 'url' => '/list/{name}', 'verb' => 'GET'],
			['name' => 'list#removeModerator', 'url' => '/list/{name}/{moderator}', 'verb' => 'DELETE'],
			['name' => 'list#addModerator', 'url' => '/list/{name}/{moderator}', 'verb' => 'POST'],
			['name' => 'settings#get', 'url' => '/settings', 'verb' => 'GET'],
			['name' => 'settings#set', 'url' => '/settings/{key}/{value}', 'verb' => 'POST'],
				
		]
	]
);
