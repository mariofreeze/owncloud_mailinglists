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
namespace OCA\MailingLists\AppInfo;

use OCP\AppFramework\App;
use OCA\MailingLists\Controller\ListController;
use OCA\MailingLists\Controller\SettingsController;
use OCA\MailingLists\Service\SettingsService;
use OCA\MailingLists\Service\EzmlmService;
use OCA\MailingLists\Service\FakeService;

define('KEY_BACKEND', 'backend');
define('KEY_ADMIN_GROUP', 'admin_group');
define('KEY_GROUPS', 'groups');

define('KEY_BACKEND_DEV', 'Development');
define('KEY_BACKEND_EZMLM', 'Ezmlm');
define('KEY_BACKEND_MAILMAN', 'MailMan');

require_once __DIR__ . '/autoload.php';
class MailingListApplication extends App {
	
	/**
	 * Define your dependencies in here
	 */
	public function __construct(array $urlParams = array()) {
		parent::__construct ( 'mailinglists', $urlParams );
		
		$container = $this->getContainer ();
		$urlGenerator = $container->query ( 'OCP\IURLGenerator' );
		$l10n = $container->query ( 'OCP\IL10N' );

		/**
		 * Controllers
		 */
		$container->registerService ( 'ListController', function ($c) {
			return new ListController ( 
					$c->query ( 'AppName' ), 
					$c->query ( 'Request' ), 
					$c->query ( 'ListService' ),
					$c->query ( 'UserId' )
			);
		} );

		$container->registerService ( 'SettingsController', function ($c) {
			return new SettingsController (
					$c->query ( 'AppName' ),
					$c->query ( 'Request' ),
					$c->query ( 'SettingsService' ),
					$c->query ( 'UserId' )
					);
		} );
			
		/**
		 * Services
		 */
		$container->registerService ( 'ListService', function ($c) {
			$backend = \OC::$server->getConfig()->getAppValue($c->query ( 'AppName' ), KEY_BACKEND);
			switch ($backend) {
				case KEY_BACKEND_DEV:
					return new FakeService();
					break;
				case KEY_BACKEND_EZMLM:
					return new EzmlmService();
					break;
				default:
					throw new \Exception ( "Backend Service " . $backend . " not yet implemented." );
			}
		} );

		$container->registerService('UserService', function($c) {
			return new UserService(
					$c->query('UserSession')
					);
		});
		
		$container->registerService('UserSession', function($c) {
			return $c->query('ServerContainer')->getUserSession();
		});

		// currently logged in user, userId can be gotten by calling the
		// getUID() method on it
		$container->registerService('UserManager', function($c) {
			return \OC::$server->getUserManager();
		});
			
	}
}
