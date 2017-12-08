<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contest extends Common_Controller {

    public $data = array();
    public $file_data = "";

    public function __construct() {
        parent::__construct();
        $this->is_auth_admin();
    }

    /**
     * @method index
     * @description listing display
     * @return array
     */
    public function index($matchId = "") {
        $this->data['parent'] = "Contest";
        $this->data['title'] = "Contest";
        $todayDate = date('Y-m-d');
        $options = array(
            'table' => 'matches',
            'where' => array('date(match_date)>' => $todayDate),
            'order' => array('match_date' => 'asc')
        );
        $matchDetails = $this->common_model->customGet($options);
        if (!empty($matchDetails)) {
            $this->data['match_details'] = $matchDetails;
        }
        if (!empty($matchId)) {
            $this->data['matchId'] = $matchId;
        }
        $this->load->admin_render('list', $this->data, 'inner_script');
    }

    /**
     * @method open_model
     * @description load model box
     * @return array
     */
    function add_contest() {
        $this->data['parent'] = "Contest";
        $this->data['title'] = "Contest";
        if ($this->input->post()) {
            $this->form_validation->set_rules('total_winning_amount', lang('total_winning_amount'), 'required|trim');
            $this->form_validation->set_rules('contest_sizes', lang('contest_size'), 'required|trim');
            $this->form_validation->set_rules('match_type', lang('match_type'), 'required|trim');
            $this->form_validation->set_rules('matches[]', lang('select_matches'), 'required|trim');
            $this->form_validation->set_rules('entry_fee', "Entry Fee", 'required|trim');
            if ($this->form_validation->run() == true) {

                $entry_fee = $this->input->post('entry_fee');
                if ($entry_fee >= 5) {
                    $insertData['contest_name'] = $this->input->post('contest_name');
                    $insertData['total_winning_amount'] = $this->input->post('total_winning_amount');
                    $insertData['contest_size'] = $this->input->post('contest_sizes');
                    $insertData['match_type'] = $this->input->post('match_type');
                    if ($this->input->post('multi_entry'))
                        $insertData['is_multientry'] = 1;
                    else
                        $insertData['is_multientry'] = 0;
                    if ($this->input->post('customize_winnings'))
                        $insertData['customize_winning'] = 1;
                    else
                        $insertData['customize_winning'] = 0;
                    if ($this->input->post('mega_contest'))
                        $insertData['mega_contest'] = 1;
                    else
                        $insertData['mega_contest'] = 0;

                    if ($this->input->post('confirmed_contest'))
                        $insertData['confirm_contest'] = 1;
                    else
                        $insertData['confirm_contest'] = 0;

                    $insertData['team_entry_fee'] = $this->input->post('entry_fee');

                    if ($this->input->post('no_of_winners'))
                        $insertData['number_of_winners'] = $this->input->post('no_of_winners');
                    $insertData['create_date'] = date('Y-m-d H:i:s');
                    $contestID = $this->common_model->insertData(CONTEST, $insertData);
                    $matches = $this->input->post('matches');
                    if (!empty($matches)) {
                        foreach ($matches as $match) {
                            $insert[] = array('contest_id' => $contestID,
                                'match_id' => $match);
                        }
                        $this->db->insert_batch(CONTEST_MATCHES, $insert);
                    }

                    if ($this->input->post('select')) {
                        $contestWinners = $this->input->post('select');
                        foreach ($contestWinners as $row) {
                            $winnersInsert[] = array('contest_id' => $contestID,
                                'from_winner' => $row[0],
                                'to_winner' => $row[1],
                                'percentage' => $row[2],
                                'amount' => $row[3],
                                'created_date' => date('Y-m-d H:i:s')
                            );
                        }
                        $this->db->insert_batch(CONTEST_DETAILS, $winnersInsert);
                    }
                    if ($contestID)
                        $this->session->set_flashdata('success', "Contest added successfully");
                    else
                        $this->session->set_flashdata('error', "Problem adding contest ! Please try again later.");
                    redirect('contest');
                }else {
                    $this->data['error'] = "Entry Fee not less than 5";
                    $todayDate = date('Y-m-d');
                    $options = array(
                        'table' => 'matches',
                        'where' => array('date(match_date)>' => $todayDate),
                        'order' => array('match_date' => 'asc')
                    );
                    $matchDetails = $this->common_model->customGet($options);
                    if (!empty($matchDetails)) {
                        $this->data['match_details'] = $matchDetails;
                    }
                }
            }
        } else {

            $todayDate = date('Y-m-d');
            $options = array(
                'table' => 'matches',
                'where' => array('date(match_date)>' => $todayDate),
                'order' => array('match_date' => 'asc')
            );
            $matchDetails = $this->common_model->customGet($options);
            if (!empty($matchDetails)) {
                $this->data['match_details'] = $matchDetails;
            }
        }
        $this->load->admin_render('add', $this->data, 'inner_script');
    }

    /**
     * @method get_contest_list
     * @description listing display of match
     * @return array
     */
    public function get_contest_list() {
        $columns = array('s_no',
            'contest_name',
//            'match_type',
            'total_winning_amount',
            'contest_size',
            'number_of_winners',
            'team_entry_fee',
            'create_date',
            'status',
            'action',
        );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $where = ' contest.user_id = 0 AND contest.id IS NOT NULL';
        if (!empty($this->input->post('search')['value'])) {
            $search = $this->input->post('search')['value'];
            $where.= ' and (date(create_date) like "%' . $search . '%" or contest_name like "%' . $search . '%" or total_winning_amount like "%' . $search . '%" or contest_size like "%' . $search . '%" or number_of_winners like "%' . $search . '%" or team_entry_fee like "%' . $search . '%")';
        }

        if ($this->input->post('match') != '') {
            $where.= ' and contest_matches.match_id=' . $this->input->post('match');
        }

        if ($this->input->post('contest_type') != '') {
            if ($this->input->post('contest_type') == 'mega') {
                $where.= ' and contest.mega_contest=1';
            } else if ($this->input->post('contest_type') == 'cancel') {
                $where.= ' and contest.status=1';
            } else if ($this->input->post('contest_type') == 'complete') {
                $where.= ' and contest.status=2';
            } else if ($this->input->post('contest_type') == 'current') {
                $where.= ' and date(create_date)="' . date('Y-m-d') . '"';
            } else if ($this->input->post('contest_type') == 'running') {
                $where.= ' and contest.status=0';
            }
        }

        $data = array();
        $totalData = 0;
        $totalFiltered = 0;
        $contestDetails = $this->common_model->GetJoinRecord(CONTEST, 'id', CONTEST_MATCHES, 'contest_id', 'contest.*', $where);

        if (!empty($contestDetails) && $contestDetails['total_count'] != 0) {
            $contestIDs = array();
            $totalData = $contestDetails['total_count'];
            $totalFiltered = $totalData;
            $contestDetails = $this->common_model->GetJoinRecord(CONTEST, 'id', CONTEST_MATCHES, 'contest_id', 'contest.*', $where, '', $order, $dir, $limit, $start);
            if (!empty($contestDetails['result'])) {
                foreach ($contestDetails['result'] as $contest) {
                    if (!in_array($contest->id, $contestIDs)) {
                        $contestIDs[] = $contest->id;
                        $start++;
                        $nestedData['s_no'] = $start;
                        $nestedData['contest_name'] = isset($contest->contest_name) ? $contest->contest_name : '';
                        //if (isset($contest->match_type) && $contest->match_type == 0)
                        // $nestedData['match_type'] = 'Practice';
                        //else
                        //$nestedData['match_type'] = 'Live';

                        $nestedData['total_winning_amount'] = isset($contest->total_winning_amount) ? '<i class="fa fa-inr" aria-hidden="true"></i> ' . $contest->total_winning_amount : '';
                        $nestedData['contest_size'] = isset($contest->contest_size) ? $contest->contest_size : '';
                        $nestedData['number_of_winners'] = isset($contest->number_of_winners) ? $contest->number_of_winners : '';
                        $nestedData['team_entry_fee'] = isset($contest->team_entry_fee) ? '<i class="fa fa-inr" aria-hidden="true"></i> ' . $contest->team_entry_fee : '';
                        $nestedData['create_date'] = isset($contest->create_date) ? date("Y-m-d", strtotime($contest->create_date)) : '';

                        $multipleJoin = "No";
                        if (isset($contest->is_multientry) && $contest->is_multientry == 1)
                            $multipleJoin = "Yes";

                        $confirmContest = "No";
                        if (isset($contest->confirm_contest) && $contest->confirm_contest == 1)
                            $confirmContest = "Yes";

                        $megaContest = "No";
                        if (isset($contest->mega_contest) && $contest->mega_contest == 1)
                            $megaContest = "Yes";

                        $matchType = 'Practice';
                        if (isset($contest->match_type) && $contest->match_type == 1)
                            $matchType = 'Live';




                        $nestedData['status'] = "<div class='text-success'>Join Multiple Teams: <span class='text-danger'>$multipleJoin</span></div>"
                                . "<div class='text-success'>Mega Contest: <span class='text-danger'>$megaContest</span></div>"
                                . "<div class='text-success'>Confirm Contest: <span class='text-danger'>$confirmContest</span></div>"
                                . "<div class='text-success'>Match Type: <span class='text-danger'>$matchType</span></div>";


                        $statusArray = array();
                        $deleteArguments = "'contest','id','" . encoding($contest->id) . "','contest',''";
                        $action = '<select class="form-control" onchange="changeContestStatus(' . $contest->id . ',this)">
                                <option value="0"';
                        if ($contest->status == 0) {
                            $action.='selected';
                        }
                        $action.='>Running</option>
                                <option value="1"';
                        if ($contest->status == 1) {
                            $action.='selected';
                        }
                        $action.='>Cancelled</option>
                                <option value="2"';
                        if ($contest->status == 2) {
                            $action.='selected';
                        }
                        $action.='>Completed</option>                                
                            </select>
                            <a href="javascript:void(0)" onclick="deleteFn(' . $deleteArguments . ')" class="on-default edit-row text-danger"><img width="20" src="' . base_url() . DELETE_ICON . '" /></a>

                            <a href="' . base_url() . 'contest/edit_contest/' . encoding($contest->id) . '" class="on-default edit-row text-danger"><img width="20" src="' . base_url() . EDIT_ICON . '" /></a>


                            <a href="' . base_url() . 'contest/edit_contest/' . encoding($contest->id) . '/view" class="on-default edit-row text-danger"><img width="20" src="' . base_url() . VIEW_ICON . '" /></a>';

                        $nestedData['action'] = $action;
                        $data[] = $nestedData;
                    }
                }
            }
        }
        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /**
     * @method change_contest_status
     * @description changing contest status
     * @return array
     */
    public function change_contest_status() {
        $option = $this->input->post('option');
        $contestID = $this->input->post('contest_id');
        $where = ' id=' . $contestID;
        $this->common_model->updateFields(CONTEST, array('status' => $option), $where);
        echo json_encode(array('status' => 1));
    }

    /**
     * @method edit_contest
     * @description editing contest details
     * @return array
     */
    public function edit_contest($contestID) {
        $this->data['encoded_id'] = $contestID;
        $contestID = decoding($contestID);
        $this->data['parent'] = "Contest";
        $this->data['title'] = "Contest";
        $this->data['contestDetails'] = $this->common_model->GetJoinRecord(CONTEST, 'id', CONTEST_MATCHES, 'contest_id', 'contest.*,group_concat(contest_matches.match_id) as matches_id', array('contest.id' => $contestID));
        $this->data['contestWinners'] = $this->common_model->getAllwhere(CONTEST_DETAILS, array('contest_id' => $contestID));
        $todayDate = date('Y-m-d');
        $options = array(
            'table' => 'matches',
            'where' => array('date(match_date)>' => $todayDate),
            'order' => array('match_date' => 'asc')
        );
        $matchDetails = $this->common_model->customGet($options);
        if (!empty($matchDetails)) {
            $this->data['match_details'] = $matchDetails;
        }
        if ($this->uri->segment(4)) {
            $this->load->admin_render('view', $this->data, 'inner_script');
        } else {
            $this->load->admin_render('edit', $this->data, 'inner_script');
        }
    }

    /**
     * @method update_contest
     * @description for updating cotest_details
     * @return array
     */
    function update_contest() {
        $this->data['parent'] = "Contest";
        $this->data['title'] = "Contest";
        if ($this->input->post()) {
            $this->form_validation->set_rules('total_winning_amount', lang('total_winning_amount'), 'required|trim');
            $this->form_validation->set_rules('contest_sizes', lang('contest_size'), 'required|trim');
            $this->form_validation->set_rules('match_type', lang('match_type'), 'required|trim');
            $this->form_validation->set_rules('matches[]', lang('select_matches'), 'required|trim');
            $this->form_validation->set_rules('match_type', lang('match_type'), 'required|trim');
            if ($this->form_validation->run() == true) {
                $updateData['contest_name'] = $this->input->post('contest_name');
                $updateData['total_winning_amount'] = $this->input->post('total_winning_amount');
                $updateData['contest_size'] = $this->input->post('contest_sizes');
                $updateData['match_type'] = $this->input->post('match_type');
                if ($this->input->post('multi_entry'))
                    $updateData['is_multientry'] = 1;
                else
                    $updateData['is_multientry'] = 0;
                if ($this->input->post('customize_winnings'))
                    $updateData['customize_winning'] = 1;
                else
                    $updateData['customize_winning'] = 0;
                if ($this->input->post('mega_contest'))
                    $updateData['mega_contest'] = 1;
                else
                    $updateData['mega_contest'] = 0;

                if ($this->input->post('confirmed_contest'))
                    $updateData['confirm_contest'] = 1;
                else
                    $updateData['confirm_contest'] = 0;

                $updateData['team_entry_fee'] = $this->input->post('entry_fee');
                if ($this->input->post('no_of_winners'))
                    $updateData['number_of_winners'] = $this->input->post('no_of_winners');
                $updateData['update_date'] = date('Y-m-d H:i:s');
                $contestID = decoding($this->input->post('contest_id'));
                $this->common_model->updateFields(CONTEST, $updateData, array('id' => $contestID));
                $matches = $this->input->post('matches');
                $this->common_model->deleteData(CONTEST_MATCHES, array('contest_id' => $contestID));
                $this->common_model->deleteData(CONTEST_DETAILS, array('contest_id' => $contestID));
                if (!empty($matches)) {
                    foreach ($matches as $match) {
                        $insert[] = array('contest_id' => $contestID,
                            'match_id' => $match);
                    }
                    $this->db->insert_batch(CONTEST_MATCHES, $insert);
                }

                if ($this->input->post('select')) {
                    $contestWinners = $this->input->post('select');
                    foreach ($contestWinners as $row) {
                        $winnersInsert[] = array('contest_id' => $contestID,
                            'from_winner' => $row[0],
                            'to_winner' => $row[1],
                            'percentage' => $row[2],
                            'amount' => $row[3],
                            'created_date' => date('Y-m-d H:i:s')
                        );
                    }
                    $this->db->insert_batch(CONTEST_DETAILS, $winnersInsert);
                }
                if ($contestID)
                    $this->session->set_flashdata('success', "Contest updated successfully");
                else
                    $this->session->set_flashdata('error', "Problem updating contest ! Please try again later.");
                redirect('contest');
            }
        }
    }

}
