<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as REST API for Live
 * @package   CodeIgniter
 * @category  Controller
 * @author    MobiwebTech Team
 */
class Live extends Common_API_Controller {

    function __construct() {
        parent::__construct();
    }

    function getSeries_get() {
        $return['code'] = 200;
        $return['response'] = new stdClass();

        $url = 'http://www.goalserve.com/getfeed/d241be5811104a1b9d823be750cbd730/cricketfixtures/tours/tours';
        $xml = simplexml_load_string(file_get_contents($url));
        for ($i = 0; $i < count($xml); $i++) {
            $options = array(
                'table' => 'series',
                'where' => array(
                    'sid' => $xml->category[$i]['id']
                )
            );
            $isSeries = $this->common_model->customGet($options);
            if (empty($isSeries)) {
                $options = array(
                    'table' => 'series',
                    'data' => array(
                        'sid' => $xml->category[$i]['id'],
                        'name' => $xml->category[$i]['name'],
                        'file_path' => $xml->category[$i]['file_path'],
                        'squads_file' => $xml->category[$i]['squads_file'],
                    )
                );
                $this->common_model->customInsert($options);
            }
        }
        $return['status'] = 1;
        $this->response($return);
    }

    function getMatch_get() {
        
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $url = 'http://www.goalserve.com/getfeed/d241be5811104a1b9d823be750cbd730/cricket/schedule';
        $xml = simplexml_load_string(file_get_contents($url));
        for ($i = 1; $i < count($xml); $i++) {
            $options = array(
                'table' => 'matches',
                'where' => array(
                    'match_id' => $xml->category[$i]->match['id'],
                )
            );
            $isMatch = $this->common_model->customGet($options);
            if (empty($isMatch)) {
                $options = array(
                    'table' => 'matches',
                    'data' => array(
                        'match_id' => $xml->category[$i]->match['id'],
                        'series_id' => $xml->category[$i]['id'],
                        'match_date' => date('Y-m-d',  strtotime(($xml->category[$i]->match['date']))),
                        'match_time' => $xml->category[$i]->match['time'],
                        'match_type' => $xml->category[$i]->match['type'],
                        'match_num' => $xml->category[$i]->match['match_num'],
                        'localteam_id' => $xml->category[$i]->match->localteam['id'],
                        'localteam' => $xml->category[$i]->match->localteam['name'],
                        'visitorteam_id' => $xml->category[$i]->match->visitorteam['id'],
                        'visitorteam' => $xml->category[$i]->match->visitorteam['name'],
                        'squads_file' => $xml->category[$i]['squads_file'],
                    )
                );
                $this->common_model->customInsert($options);
            }
        }
        $return['status'] = 1;
        $this->response($return);
    }

    function getMatchPlayer_get() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $options = array(
            'table' => 'series',
            'select' => 'squads_file'
        );
        $series = $this->common_model->customGet($options);
        if (!empty($series)) {
            foreach ($series as $rows) {
                if (!empty($rows->squads_file)) {
                    $url = 'http://www.goalserve.com/getfeed/d241be5811104a1b9d823be750cbd730/cricketfixtures/' . $rows->squads_file;
                    $xml = simplexml_load_string(file_get_contents($url));
                    if (!empty($xml)) {
                        for ($i = 0; $i < count($xml->category->team); $i++) {
                            
                            $option = array(
                                    'table' => 'team',
                                    'where' => array(
                                        'id' => $xml->category->team[$i]['id'],
                                    )
                                );
                            $isTeam = $this->common_model->customGet($option);
                            if(empty($isTeam)){
                                $option = array(
                                    'table' => 'team',
                                    'data' => array(
                                        'id' => $xml->category->team[$i]['id'],
                                        'team_name' => $xml->category->team[$i]['name'],
                                    )
                                );
                               $this->common_model->customInsert($option);
                            }
                            for ($j = 0; $j < count($xml->category->team[$i]->player); $j++) {
                                $option = array(
                                    'table' => 'match_player',
                                    'where' => array(
                                        'series_id' => $xml->category['id'],
                                        'team_id' => $xml->category->team[$i]['id'],
                                        'player_id' => $xml->category->team[$i]->player[$j]['name'],
                                    )
                                );
                                $isMatchPlayer = $this->common_model->customGet($option);
                                if (empty($isMatchPlayer)) {

                                    $url = 'http://www.goalserve.com/getfeed/d241be5811104a1b9d823be750cbd730/cricket/profile?id='.$xml->category->team[$i]->player[$j]['name'];
                                    $xmlParse = simplexml_load_string(file_get_contents($url));
                                    $plyRole = "";
                                    if(!empty($xmlParse)){
                                        $Roles = trim($xmlParse->player->playing_role);
                                        if(!empty($Roles)){
                                            $RolesArray = explode(" ", $Roles);
                                            if (count($RolesArray) > 1) {
                                                if (strtolower($RolesArray[0]) == 'wicketkeeper') {
                                                    $plyRole = $RolesArray[0];
                                                } else {
                                                    $plyRole = $RolesArray[1];
                                                }
                                            } else {
                                                $plyRole = $RolesArray[0];
                                            }
                                        }else{
                                           $plyRole = "Batsman";
                                        }
                                    }
                                    $options = array(
                                        'table' => 'match_player',
                                        'data' => array(
                                            'series_id' => $xml->category['id'],
                                            'team_id' => $xml->category->team[$i]['id'],
                                            'team' => $xml->category->team[$i]['name'],
                                            'player_id' => $xml->category->team[$i]->player[$j]['name'],
                                            'player_name' => $xml->category->team[$i]->player[$j]['id'],
                                            'play_role' => strtoupper($plyRole),
                                            'test' => (isset($xml->category->team[$i]->player[$j]['test'])) ? ($xml->category->team[$i]->player[$j]['test'] == 'True') ? 1 : 0 : 1,
                                            'odi' => (isset($xml->category->team[$i]->player[$j]['odi'])) ? ($xml->category->team[$i]->player[$j]['odi'] == 'True') ? 1 : 0 : 1,
                                            't20' => (isset($xml->category->team[$i]->player[$j]['t20'])) ? ($xml->category->team[$i]->player[$j]['t20'] == 'True') ? 1 : 0 : 1
                                        )
                                    );
                                    $this->common_model->customInsert($options);
                                }
                            }
                        }
                    }
                }
            }
        }
        $return['status'] = 1;
        $this->response($return);
    }

}
