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

namespace OCA\MailingLists\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;

use OCA\MailingLists\Service\IListService;
use OCA\MailingLists\Service\SettingsService;

class ListController extends Controller {


	private $userId;
	private $groupManager;
	private $listService;
	
 	public function __construct($AppName, IRequest $request, IListService $service, $UserId){
		parent::__construct($AppName, $request);
// 		throw new \Exception ( "ListController constructor called" );
 		$this->userId = $UserId;
		if ($service === null) {
		    throw new \Exception( "$service is null" );
		}
		$this->listService = $service;
	}

	/**
	 * CAUTION: the @Stuff turns off security checks; for this page no admin is
	 *          required and no CSRF check. If you don't know what CSRF is, read
	 *          it up in the docs or you might create a security hole. This is
	 *          basically the only required method to add this exemption, don't
	 *          add it to any other method if you don't exactly know what it does
	 *
	 * @NoAdminRequired
	 */
	public function loadAll() {
		return new DataResponse($this->listService->loadAll());
	}

     /**
      * @NoAdminRequired
      *
      * @param string $name
      */
    public function load($name) {
    	 $result = new DataResponse(
			[
				$this->listService->load($name), 
//				$this->userManager->get($this->userId)->getEMailAddress()		// geht erst ab OC 9.0
			]
		);
		return $result;
	}

	public function checkAdminGroup() {
// 		throw new \Exception( 'Result of checkAdminGroup: ' . $this->internalCheckAdminGroup() );
		return new DataResponse($this->internalCheckAdminGroup());
	}
	
	private function internalCheckAdminGroup() {
		$adminGroupName = (string)\OC::$server->getConfig()->getAppValue($this->appName, KEY_ADMIN_GROUP, 'admin');
		$adminGroup = \OC::$server->getGroupManager()->get($adminGroupName);
		if (isset($adminGroup)) {
			return $adminGroup->inGroup(\OC::$server->getUserManager()->get($this->userId));
		}
		return false;
	}
     /**
      * @NoAdminRequired
      *
      * @param string $name
      * @param string $member
      */
	public function removeModerator($name, $moderator) {
		if ($this->internalCheckAdminGroup()) {
    		return new DataResponse($this->listService->removeModerator($name, $moderator));
		} else {
			throw new \Exception( "You do not have the permission to call removeModerator." );
		}
	}

     /**
      * @NoAdminRequired
      *
      * @param string $name
      * @param string $member
      */
	public function addModerator($name, $moderator) {
		if ($this->internalCheckAdminGroup()) {
			return new DataResponse($this->listService->addModerator($name, $moderator));
		} else {
			throw new \Exception( "You do not have the permission to call addModerator." );
		}
	}

}