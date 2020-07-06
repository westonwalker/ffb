<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class UtilsController extends AppController
{


    public function home()
    {
    	$games = array();
    	$isCurrent = false;
    	
    	// If a get param of week is set, pull that weeks games instead of the current weeks games.
    	if (!empty($_GET['week'])) {
    		$week = in_array($_GET['week'], $this->weeks) ? $_GET['week'] : $this->currentWeek; // Test if the week we are pulling is a valid week. If not set it to the default current week. 
    	} else {
    		$week = $this->currentWeek;
    	} 
    	
    	if ($week == $this->currentWeek) { 
    		$isCurrent = true;
    	}
    	
    	// Get array of valid weeks for the nfl season 
    	$weeks = $this->weeks; 
    	
    	// Get the weeks games
    	$games = $this->getAllWeeksGames($this->currentYear, $week, 'REG', $isCurrent);
    	 
        $this->set(compact('games', 'weeks'));
    } 
    
    public function gameDetails() {
    	
    	if (!empty($_GET['gameId'])) {
    		$gameId = $_GET['gameId'];
    	} else {
    		$gameId = null;
    	} 
    	
    	if (!empty($_GET['scoreType'])) {
    		$scoringType = in_array($_GET['scoreType'], $this->scoreTypes) ? $_GET['scoreType'] : 'REG';
    	} else {
    		$scoringType = 'REG';
    	} 
    	
    	$game = $this->getGame($gameId);
		//$this->echoPrint($game);
    	
        $this->set(compact('game'));
    }
    
    public function getGame($id) {
    	$return = array();
    	if (!empty($id)) { 
    		// Get specific game 
	    	$jsonGame = @file_get_contents('http://www.nfl.com/liveupdate/game-center/' . $id . '/' . $id . '_gtd.json');
	    	
	    	$data = json_decode($jsonGame, true); // Json to array
	    	
	    	$gameData = $data[$id];  
	    	 
			if ($gameData['qtr'] == 'Final') {
				$status = 'Final';
			} else if ($gameData['qtr'] == 'Halftime') {
				$status = 'Halftime';
			} else if ($gameData['qtr'] == 'Pregame') {
				$status = 'Pregame';
			} else if ($gameData['qtr'] == 'final overtime') {
				$status = 'Final Overtime';
			} else {
				$status = 'Quarter ' . $gameData['qtr'];
			}
			
	    	// General stats  
	    	$return['qtr'] = $status;
	    	$return['clock'] = $return['qtr'] == 'Final' || $return['qtr'] == 'Final Overtime' || $return['qtr'] == 'Pregame' || $return['qtr'] == 'Halftime' ? '' : $gameData['clock'] . ' - ';
	    	$return['down'] = $gameData['down'];
	    	$return['togo'] = $gameData['togo'];
	    	$return['yl'] = !empty($gameData['yl']) ? $gameData['yl']: 0;
	    	$return['in_redzone'] = $gameData['redzone'];
	    	$return['posession'] = $gameData['posteam'];
	    	
	    	// Home team stats
	    	$return['home'] = array(
	    		'abbr' => $gameData['home']['abbr'],
	    		'name' => !empty($this->teams[$gameData['home']['abbr']]) ? $this->teams[$gameData['home']['abbr']]: '',
	    		'score' => $gameData['home']['score'],
	    		'timeouts' => $gameData['home']['to'],
	    		//'team_stats' => $gameData['home']['stats']['team'],
    		);
    		
    		$return['home']['passing'] = $this->getStats($gameData['home']['stats'], 'passing');
    		$return['home']['rushing'] = $this->getStats($gameData['home']['stats'], 'rushing');
    		$return['home']['receiving'] = $this->getStats($gameData['home']['stats'], 'receiving');
    		$return['home']['kicking'] = $this->getStats($gameData['home']['stats'], 'kicking');
    		$return['home']['fumbles'] = $this->getStats($gameData['home']['stats'], 'fumbles');
    		$return['home']['kickret'] = $this->getStats($gameData['home']['stats'], 'kickret');
    		$return['home']['puntret'] = $this->getStats($gameData['home']['stats'], 'puntret');
    		$return['home']['defense'] = $this->getStats($gameData['home']['stats'], 'defense');
	    	
	    	// Away team stats
	    	$return['away'] = array(
	    		'abbr' => $gameData['away']['abbr'],
	    		'name' => !empty($this->teams[$gameData['away']['abbr']]) ? $this->teams[$gameData['away']['abbr']]: '',
	    		'score' => $gameData['away']['score'],
	    		'timeouts' => $gameData['away']['to'],
	    		//'team_stats' => $gameData['away']['stats']['team'],
    		);
    		
    		$return['away']['passing'] = $this->getStats($gameData['away']['stats'], 'passing');
    		$return['away']['rushing'] = $this->getStats($gameData['away']['stats'], 'rushing');
    		$return['away']['receiving'] = $this->getStats($gameData['away']['stats'], 'receiving');
    		$return['away']['kicking'] = $this->getStats($gameData['away']['stats'], 'kicking');
    		$return['away']['fumbles'] = $this->getStats($gameData['away']['stats'], 'fumbles');
    		$return['away']['kickret'] = $this->getStats($gameData['away']['stats'], 'kickret');
    		$return['away']['puntret'] = $this->getStats($gameData['away']['stats'], 'puntret');
    		$return['away']['defense'] = $this->getStats($gameData['away']['stats'], 'defense');
	    	
	    	
	    	// Drives  
	    	// TO DO
    	} 
    	
    	return $return;
    }
    
    public function getAllWeeksGames($year, $week, $type, $isCurrent = true) {
    	$return = array(
    		'week_info' => array(),
    		'games' => array(),
		);
    	
    	// Get xml from nfl.com displaying all games for the week/year/type provided. Parse xml into object.
    	if ($isCurrent) { 
    		$xmlGames = @file_get_contents('http://www.nfl.com/liveupdate/scorestrip/ss.xml');
    	} else {
    		$xmlGames = @file_get_contents('http://www.nfl.com/ajax/scorestrip?season=' . $year . '&seasonType=' . $type . '&week=' . $week);
    	}
    	
    	$data = simplexml_load_string($xmlGames); 
    	$weekInfo = $data->gms->attributes();
    	$gameData = $data->gms->xpath('g');
    	
    	// Get the general week/year info
    	$return['week_info'] = array(
    		'week' => (string)$weekInfo['w'],
    		'year' => (string)$weekInfo['y'],
		);   
		 
		foreach ($gameData as $game) {
			$status = $game['q'];
			$day = (string)$game['d'];
			$time = (string)$game['t'];
			if ($status == 'F') {
				$status = 'Final';
			} else if ($status == 'P') {
				$status = $day . ' ' . $time;
			} else if ($status == 'H') {
				$status = 'Halftime';
			} else if ($status == 'FO') {
				$status = 'Final Overtime';
			} else {
				$status = 'Quarter ' . $status;
			}
			
			$return['games'][] = array(
				// 'game_key' => (string)$game['gsis'],
				'date_id' => (string)$game['eid'], 
				'status' => $status, 
				'day' => $day,
				'time' => $time,
				'quarter' => (string)$game['q'],
				'home_city' => (string)$game['h'],
				'home_team' => ucfirst((string)$game['hnn']),
				'home_score' => (string)$game['hs'],
				'visitor_city' => (string)$game['v'],
				'visitor_team' => ucfirst((string)$game['vnn']),
				'visitor_score' => (string)$game['vs'],
			);
		}  
    	
    	return $return;
    }
    
    public function getStats($stats, $statType) {
    	$return = array();
    	
    	// Depending on the stat type (rushing, passing, etc) parse the data and calculate fantasy points.
    	switch ($statType) {
    		case 'passing':
    			if (!empty($stats['passing'])) {
	    			foreach ($stats['passing'] as $passer) {
	    				$return[] = array(
	    					'name' => $passer['name'],
	    					'att' => $passer['att'],
	    					'cmp' => $passer['cmp'], 
	    					'yds' => $passer['yds'],
	    					'tds' => $passer['tds'],
	    					'ints' => $passer['ints'],
	    					'twoptm' => $passer['twoptm'],
	    					'fp' => ($passer['yds'] / 25) + ($passer['tds'] * 4) + ($passer['twoptm'] * 2),
    					);
	    			}
    			} 
    			break;
    		case 'rushing':
    			if (!empty($stats['rushing'])) {
	    			foreach ($stats['rushing'] as $rusher) {
	    				$return[] = array(
	    					'name' => $rusher['name'],
	    					'att' => $rusher['att'],
	    					'yds' => $rusher['yds'],
	    					'tds' => $rusher['tds'],
	    					'lng' => $rusher['lng'],
	    					'lngtd' => $rusher['lngtd'],
	    					'twoptm' => $rusher['twoptm'],
	    					'fp' => ($rusher['yds'] / 10) + ($rusher['tds'] * 6) + ($rusher['twoptm'] * 2),
    					);
	    			}
    			} 
    			break;
    		case 'receiving':
    			if (!empty($stats['receiving'])) {
	    			foreach ($stats['receiving'] as $receiver) {
	    				$return[] = array(
	    					'name' => $receiver['name'],
	    					'rec' => $receiver['rec'],
	    					'yds' => $receiver['yds'],
	    					'tds' => $receiver['tds'],
	    					'lng' => $receiver['lng'],
	    					'lngtd' => $receiver['lngtd'],
	    					'twoptm' => $receiver['twoptm'],
	    					'fp' => ($receiver['yds'] / 10) + ($receiver['tds'] * 6) + ($receiver['twoptm'] * 2),
    					);
	    			}
    			} 
    			break;
    		case 'kicking':
    			if (!empty($stats['kicking'])) {
	    			foreach ($stats['kicking'] as $kicker) {
	    				$return[] = array(
	    					'name' => $kicker['name'],
	    					'fgm' => $kicker['fgm'],
	    					'fga' => $kicker['fga'],
	    					'long' => $kicker['fgyds'],
    					);
	    			}
    			}  
    			break;
    		case 'fumbles':
    			if (!empty($stats['fumbles'])) {
	    			foreach ($stats['fumbles'] as $fumbler) {
	    				$return[] = array(
	    					'name' => $fumbler['name'],
	    					'tot' => $fumbler['tot'],
	    					'lost' => $fumbler['lost'],
    					);
	    			}
    			}  
    			break;
    		case 'kickret':
    			if (!empty($stats['kickret'])) {
	    			foreach ($stats['kickret'] as $returner) {
	    				$return[] = array(
	    					'name' => $returner['name'],
	    					'lng' => $returner['lng'],
	    					'tds' => $returner['tds'],
    					);
	    			}
    			}  
    			break;
    		case 'puntret':
    			if (!empty($stats['puntret'])) {
	    			foreach ($stats['puntret'] as $returner) {
	    				$return[] = array(
	    					'name' => $returner['name'],
	    					'lng' => $returner['lng'],
	    					'tds' => $returner['tds'],
    					);
	    			}
    			}  
    			break;
    		case 'defense':
    			if (!empty($stats['defense'])) {
	    			foreach ($stats['defense'] as $returner) {
	    				if (!empty($returner['sk']) || !empty($returner['int']) ||!empty($returner['ffum'])) {
		    				$return[] = array(
		    					'name' => $returner['name'],
		    					'sk' => $returner['sk'],
		    					'int' => $returner['int'],
		    					'ffum' => $returner['ffum'],
	    					);
	    				} 
	    			}
    			}  
    			break;
			default:
    	} 
    		
		return $return;
    }
     
    public function getDisplayDown($down) {
		if ($down == 1) {
			$displayDown = '1st';
		} else if ($down == 2) {
			$displayDown = '2nd';
		} else if ($down == 3) {
			$displayDown = '3rd';
		} else if ($down == 4) {
			$displayDown = '4th';
		} else {
			$displayDown = 'Unknown';
		}
		
		return $displayDown;
    	
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
