<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as REST API for Contest
 * @package   CodeIgniter
 * @category  Controller
 * @author    MobiwebTech Team
 */
class Contest extends Common_API_Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * Function Name: contest
     * Description:   To get contest list
     */
    function contests_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        $this->form_validation->set_rules('match_id', 'Match Id', 'trim|required|numeric');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required|numeric');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $matchId = extract_value($data, 'match_id', '');
            $user_id = extract_value($data, 'user_id', '');
            $options = array(
                'table' => 'contest as ct',
                'select' => 'ct.id,ct.match_type,ct.contest_name,ct.total_winning_amount,ct.contest_size,'
                . 'ct.team_entry_fee,ct.number_of_winners,ct.is_multientry,ct.confirm_contest,ct.mega_contest',
                'join' => array('contest_matches as cm' => 'cm.contest_id=ct.id'),
                'where' => array('cm.match_id' => $matchId)
            );
            $contestsList = $this->common_model->customGet($options);
            if (!empty($contestsList)) {
                $contestResponse = array();
                foreach ($contestsList as $constant) {
                    $temp['id'] = $constant->id;
                    $temp['match_type'] = $constant->match_type;
                    $temp['contest_name'] = $constant->contest_name;
                    $temp['total_winning_amount'] = $constant->total_winning_amount;
                    $temp['contest_size'] = $constant->contest_size;
                    $temp['team_entry_fee'] = $constant->team_entry_fee;
                    $temp['number_of_winners'] = $constant->number_of_winners;
                    $temp['is_multientry'] = $constant->is_multientry;
                    $temp['confirm_contest'] = $constant->confirm_contest;
                    $temp['mega_contest'] = $constant->mega_contest;
                    $options = array(
                        'table' => 'join_contest',
                        'select' => 'id',
                        'where' => array('contest_id' => $constant->id, 'user_id' => $user_id)
                    );
                    $isJoined = $this->common_model->customGet($options);
                    $temp['is_user_joined'] = (!empty($isJoined)) ? 1 : 0;
                    $options = array(
                        'table' => 'contest_details',
                        'select' => 'from_winner,to_winner,amount',
                        'where' => array('contest_id' => $constant->id)
                    );
                    $rank = $this->common_model->customGet($options);
                    $temp['winners_rank'] = array();
                    if (!empty($rank)) {
                        foreach ($rank as $rows) {
                            $temp2['rank'] = ($rows->from_winner == $rows->to_winner) ? $rows->from_winner : $rows->from_winner . ' - ' . $rows->to_winner;
                            $temp2['prize'] = $rows->amount;
                            $temp['winners_rank'][] = $temp2;
                        }
                    }
                    $contestResponse[] = $temp;
                }
                $return['response'] = $contestResponse;
                $return['status'] = 1;
                $return['message'] = 'Contest found successfully';
            } else {
                $return['status'] = 0;
                $return['message'] = 'Contest not found';
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: join_contest
     * Description:   To join contest
     */
    function join_contest_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required|numeric');
        $this->form_validation->set_rules('contest_id', 'Contest Id', 'trim|required|numeric');
        $this->form_validation->set_rules('joining_amount', 'Amount', 'trim|required');
        $this->form_validation->set_rules('team_id', 'Team Id', 'trim|required|numeric');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArray = array();
            $dataArray['user_id'] = extract_value($data, 'user_id', '');
            $dataArray['contest_id'] = extract_value($data, 'contest_id', '');
            $dataArray['joining_amount'] = extract_value($data, 'joining_amount', '');
            $dataArray['team_id'] = extract_value($data, 'team_id', '');
            $dataArray['joining_date'] = date('Y-m-d H:i:s');

            $options = array(
                'table' => 'join_contest',
                'data' => $dataArray
            );
            $joined = $this->common_model->customInsert($options);
            if (!empty($joined)) {
                $return['status'] = 1;
                $return['message'] = 'Successfully Contest Joined';
            } else {
                $return['status'] = 0;
                $return['message'] = 'Failed Contest Join, Please try again';
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: create_contest
     * Description:   To user create contest
     */
    function create_contest_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required|numeric');
        $this->form_validation->set_rules('match_id', 'Match Id', 'trim|required|numeric');
        $this->form_validation->set_rules('total_winning_amount', lang('total_winning_amount'), 'required|trim');
        $this->form_validation->set_rules('contest_sizes', lang('contest_size'), 'required|trim');
        $this->form_validation->set_rules('team_entry_fee', 'Entry Fee', 'required|trim');
        $this->form_validation->set_rules('number_of_winners', 'Number Of Winners', 'required|trim');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $team_entry_fee = extract_value($data, 'team_entry_fee', '');
            if ($team_entry_fee < 5) {
                $return['status'] = 0;
                $return['message'] = 'Entry Fee not less than 5';
                $this->response($return);
            }
            $contest_sizes = extract_value($data, 'contest_sizes', '');
            $number_of_winners = extract_value($data, 'number_of_winners', '');
            if ($contest_sizes < $number_of_winners) {
                $return['status'] = 0;
                $return['message'] = 'No. of winners should be less than or equal to contest size';
                $this->response($return);
            }

            $dataArr = array();
            $matchId = extract_value($data, 'match_id', '');
            $user_id = extract_value($data, 'user_id', '');
            $dataArr['user_id'] = $user_id;
            $contest_name = extract_value($data, 'contest_name', '');
            $dataArr['contest_name'] = (!empty($contest_name)) ? $contest_name : "Fabulous6 " . generateRandomString(6);
            $dataArr['total_winning_amount'] = extract_value($data, 'total_winning_amount', '');
            $dataArr['contest_size'] = extract_value($data, 'contest_sizes', '');
            $dataArr['match_type'] = 1;
            $dataArr['is_multientry'] = extract_value($data, 'is_multientry', '');
            $dataArr['customize_winning'] = 1;
            $dataArr['mega_contest'] = 0;
            $dataArr['confirm_contest'] = 1;
            $dataArr['team_entry_fee'] = extract_value($data, 'team_entry_fee', '');
            $dataArr['number_of_winners'] = extract_value($data, 'number_of_winners', '');
            $dataArr['create_date'] = date('Y-m-d');
            $options = array(
                'table' => 'contest',
                'data' => $dataArr
            );
            $contestId = $this->common_model->customInsert($options);
            if (!empty($contestId)) {
                $options = array(
                    'table' => 'contest_matches',
                    'data' => array(
                        'contest_id' => $contestId,
                        'match_id' => $matchId
                    )
                );
                $this->common_model->customInsert($options);
                $winning_rank = extract_value($data, 'winning_rank', '');
                $winning_rank = json_decode($winning_rank);
                foreach ($winning_rank as $row) {
                    $winnersInsert[] = array('contest_id' => $contestId,
                        'from_winner' => $row[0],
                        'to_winner' => $row[1],
                        'percentage' => $row[2],
                        'amount' => $row[3],
                        'created_date' => date('Y-m-d H:i:s')
                    );
                }
                $this->db->insert_batch(CONTEST_DETAILS, $winnersInsert);
                $return['status'] = 1;
                $return['message'] = 'Contest Created successfully';
            } else {
                $return['status'] = 0;
                $return['message'] = 'Contest creation failed';
            }
        }
        $this->response($return);
    }

}
