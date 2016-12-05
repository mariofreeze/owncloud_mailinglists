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

namespace OCA\MailingLists\Service;

class EzmlmService implements IListService {

	private $homeDir;
	
    public function __construct($homeDir, $domain){
    	$this->homeDir = $homeDir;
    	$this->domain = $domain;
    }

    public function loadAll() {
		$output = [];
		$result = [];
		exec('cd '.$this->homeDir.'; ls -d -1 */', $output);
		foreach ($output as $key => $value) {
			if (substr($value, 0, 4 ) != "test") {
				$result[$key] = trim(rtrim($value, "/"));
			}
		}
		return $result;
    }

    public function load($name) {
    	try {
    		$output = ( object ) [ 
					'prefix' => '',
    				'domain' => $this->domain,
					'subscribers' => [ ],
					'allow' => [ ],
					'mod' => [ ],
			];
			exec('ezmlm-list '.$this->homeDir.'/' . $name, $subscribers);
			sort($subscribers);
			foreach ($subscribers as $key => $value) {
				$output->subscribers[$key] = rtrim($value, "/");
			}
				
			exec('ezmlm-list '.$this->homeDir.'/' . $name . ' allow', $allow);
			sort($allow);
			foreach ($allow as $key => $value) {
				$output->allow[$key] = rtrim($value, "/");
			}
				
			exec('ezmlm-list '.$this->homeDir.'/' . $name . ' mod', $mod);
			sort($mod);
			foreach ($mod as $key => $value) {
				$output->mod[$key] = rtrim($value, "/");
			}
				
			exec('cat '.$this->homeDir.'/' . $name . '/prefix', $prefix);
			foreach ($prefix as $key => $value) {
				$output->prefix = rtrim(ltrim($value, "["),"]");		// can only be one
			}
				
	        return $output;	
        } catch (Exception $e) {
        	throw new \Exception( 'Exception abgefangen: ' .  $e->getMessage() );
        }
    }

	public function removeModerator($name, $moderator) {
		exec('ezmlm-unsub '.$this->homeDir.'/' . $name . ' mod ' . $moderator, $prefix);
		return true;
	}

	public function addModerator($name, $moderator) {
		$command = 'ezmlm-sub '.$this->homeDir.'/' . $name . ' mod ' . $moderator;
		exec($command, $result, $returncode);
		if ($returncode === 0) {
			return true;
		} else {
			throw new \Exception( "Executed: " . $command . ' with returncode:' . $returncode . ' and message: ' . implode(",", $result));
		}
	}
	
	
}