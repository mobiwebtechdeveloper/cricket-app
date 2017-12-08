<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as REST API for Match
 * @package   CodeIgniter
 * @category  Controller
 * @author    MobiwebTech Team
 */
class Match extends Common_API_Controller {

    function __construct() {
        parent::__construct();
        $tables = $this->config->item('tables', 'ion_auth');
        $this->lang->load('en', 'english');
    }

    /**
     * Function Name: matches
     * Description:   To recent matches list
     */
    function matches_post() {
        $data = @file_get_contents("php://input");
        $data = json_decode($data);
        $return['code'] = 200;
        $return['response'] = new stdClass();
        // $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        // if ($this->form_validation->run() == FALSE) {
        //     $error = $this->form_validation->rest_first_error_string();
        //     $return['status'] = 0;
        //     $return['message'] = $error;
        // } else {
            $options = array(
                'table' => 'matches',
                'select' => 'match_id,series_id,match_date,match_time,match_type,match_num,localteam_id,localteam,visitorteam_id,visitorteam,status',
                'limit' => 25
            );
            $matches = $this->common_model->customGet($options);
            if (empty($matches)) {
                $return['status'] = 0;
                $return['message'] = 'Matches not found';
            } else {
                $return['response'] = $matches;
                $return['status'] = 1;
                $return['message'] = 'Matches found successfully';
            }
       // }
        $this->response($return);
    }

    /**
     * Function Name: match_player
     * Description:   To get match palyers
     */
    function match_player_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        $this->form_validation->set_rules('series_id', 'Series Id', 'trim|required|numeric');
        $this->form_validation->set_rules('localteam_id', 'Localteam Id', 'trim|required|numeric');
        $this->form_validation->set_rules('visitorteam_id', 'Visitorteam Id', 'trim|required|numeric');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArr = array();
            $series_id = extract_value($data, 'series_id', '');
            $localteam_id = extract_value($data, 'localteam_id', '');
            $visitorteam_id = extract_value($data, 'visitorteam_id', '');
            $options = array(
                'table' => 'match_player',
                'select' => 'match_player.*',
                'where' => array('match_player.series_id' => $series_id),
                'where_in' => array('team_id' => array($localteam_id, $visitorteam_id))
            );
            $matchPlayer = $this->common_model->customGet($options);
            if (empty($matchPlayer)) {
                $return['status'] = 0;
                $return['message'] = 'Players not found';
            } else {
                $return['response'] = $matchPlayer;
                $return['status'] = 1;
                $return['message'] = 'Players found successfully';
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: create_team
     * Description:   To create team
     */
    function create_team_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required|numeric');
        $this->form_validation->set_rules('match_id', 'Match Id', 'trim|required|numeric');
        $this->form_validation->set_rules('player_id', 'Player Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArr = array();
            $user_id = extract_value($data, 'user_id', '');
            $match_id = extract_value($data, 'match_id', '');
            $player_id = extract_value($data, 'player_id', '');
            $player_id = json_decode($player_id);
            if (is_array($player_id)) {
                if (count($player_id) == 6) {
                    $options = array(
                        'table' => 'user_team',
                        'data' => array(
                            'name' => 'Team',
                            'user_id' => $user_id,
                            'match_id' => $match_id,
                            'create_date' => date('Y-m-d H:i:s')
                        )
                    );
                    $team_id = $this->common_model->customInsert($options);
                    if (!empty($team_id)) {
                        
                        
                        foreach ($player_id as $player) {
                            $options = array(
                                'table' => 'user_team_player',
                                'data' => array(
                                    'user_team_id' => $team_id,
                                    'player_id' => $player->id,
                                    'player_position' => $player->position
                                )
                            );
                            $this->common_model->customInsert($options);
                        }
                    } else {
                        $return['status'] = 0;
                        $return['message'] = 'Error in team create';
                    }
                    $return['status'] = 1;
                    $return['message'] = 'Successfully team created';
                } else {
                    $return['status'] = 0;
                    $return['message'] = 'Player list cannot be less than 6 or greater than 6';
                }
            } else {
                $return['status'] = 0;
                $return['message'] = 'Error in team create';
            }
        }
        $this->response($return);
    }

}

/* End of file User.php */
/* Location: ./application/controllers/api/v1/User.php */
?>