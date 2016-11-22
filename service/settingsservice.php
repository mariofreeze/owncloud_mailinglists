<?php
namespace OCA\MailingLists\Service;

use OCP\IConfig;
use OCP\IGroupManager;

class SettingsService {

	private $userId;
	private $config;
	private $groupManager;
	private $appName;

	
	
	public function __construct($UserId, $AppName, IConfig $config, IGroupManager $groupManager) {
		$this->userId = $UserId;
		$this->config = $config;
		$this->appName = $AppName;
		$this->groupManager = $groupManager;
//  		throw new \Exception ( "SettingsService created config=" . get_class($config) . ", UserID " . $UserId . ", AppName=" . $AppName);
	}

	
	/**
	 * get the current settings
	 *
	 * @return array
	 */
	public function get() {

		$groups = $this->groupManager->search('');
		$group_id_list = array();
		foreach ( $groups as $group ) {
			$group_id_list[] = $group->getGid();
		}
		
		$settings = array(
				// admin settings
				KEY_BACKEND => (string)$this->config->getAppValue($this->appName, KEY_BACKEND, KEY_BACKEND_DEV),
				KEY_ADMIN_GROUP => (string)$this->config->getAppValue($this->appName, KEY_ADMIN_GROUP, 'admin'),
				KEY_GROUPS => $group_id_list,
				// user settings
				//				'hide_attributes' => (string)$this->settings->getUserValue($this->userId, $this->appName, 'hide_attributes', 'false'),
		);
		return $settings;
	}

	public function getKey($key) {
		return get().$key;
	}

	/**
	 * set user setting
	 *
	 * @param $setting
	 * @param $value
	 * @return bool
	 */
	public function set($setting, $value) {
// 		throw new \Exception ( "SettingsService set " . $setting . " to " . $value);
		return $this->config->setAppValue($this->appName, $setting, $value);
	}

}
