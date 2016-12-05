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
use OCA\MailingLists\Service\SettingsService;

class SettingsController extends Controller {


	private $userId;
	private $settingsService;

	public function __construct($AppName, IRequest $request, SettingsService $service, $UserId){
		parent::__construct($AppName, $request);
		$this->userId = $UserId;
		$this->settingsService = $service;
	}

	/**
	 * CAUTION: the @Stuff turns off security checks; for this page no admin is
	 *          required and no CSRF check. If you don't know what CSRF is, read
	 *          it up in the docs or you might create a security hole. This is
	 *          basically the only required method to add this exemption, don't
	 *          add it to any other method if you don't exactly know what it does
	 *
	 * @NoCSRFRequired
	 */
	public function get(){
		$result = $this->settingsService->get();
// 		throw new \Exception ( "SettingsController get called with result: " . serialize($result) );
		return new DataResponse( $result );
	}

	public function set($key, $value) {
// 		throw new \Exception ( "SettingsController set called for key ".$key." and value ".$value );
		return new DataResponse( $this->settingsService->set($key, $value) );
	}
	
}