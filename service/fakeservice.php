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

class FakeService implements IListService {

    public function __construct(){
    }

    public function loadAll() {
		$output = [];
		exec('cd ~/ocdev/core; ls -d -1 */', $output);
		foreach ($output as $key => $value) {
			if (substr($value, 0, 4 ) != "test") {
				$output[$key] = trim(rtrim($value, "/"));
			}
		}
		return $output;
    }

    public function load($name) {
    	$output = ( object ) [
    			'prefix' => '',
    			'subscribers' => [ ],
    			'allow' => [ ],
    			'mod' => ['test1@home.de', 'test2@home.de'],
    	];
		exec('ls -p1 ' . $name . '/ | grep -v /', $subscribers);
		sort($subscribers);
		foreach ($subscribers as $key => $value) {
			$output->subscribers[$key] = rtrim($value, "/") . "@home.de";
		}

		exec('ls -1d ' . $name . '/*/', $allow);
		sort($allow);
		foreach ($allow as $key => $value) {
			$output->allow[$key] = rtrim($value, "/");
		}

        return $output;
    }

    public function removeModerator($name, $moderator) {
    	return true;
    }
    
    public function addModerator($name, $moderator) {
    	return true;
    }
}