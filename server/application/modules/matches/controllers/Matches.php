<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Matches extends Common_Controller {

    public $data = array();
    public $file_data = "";

    public function __construct() {
        parent::__construct();
        $this->is_auth_admin();
    }

    /**
     * @method index
     * @description loading view of match list
     * @return array
     */
    public function index() {
        $this->data['parent'] = "Matches";
        $this->data['title'] = "Matches";
        $options = array(
            'table' => 'series',
        );
        $this->data['series'] = $this->common_model->customGet($options);
        $this->load->admin_render('match_list', $this->data, 'inner_script');
    }

    /**
     * @method get_matches_list
     * @description listing display of match
     * @return array
     */
    public function get_matches_list() {
        $columns = array('id',
            'localteam',
            'match_num',
            'match_type',
            'match_date',
            'status',
            'action',
        );
        $series_id = $this->input->post('series_id');
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $where = ' id IS NOT NULL';
        if(!empty($series_id)){
            $where .= " AND series_id = $series_id ";
        }
        if (!empty($this->input->post('search')['value'])) {
            $search = $this->input->post('search')['value'];
            $where.= ' and (date(match_date) like "%' . $search . '%" or localteam like "%' . $search . '%" or visitorteam like "%' . $search . '%" or match_type like "%' . $search . '%" or status like "%' . $search . '%")';
        }

        $data = array();
        $totalData = 0;
        $totalFiltered = 0;
        $matchDetails = $this->common_model->getAllwhere(MATCHES, $where);
        if (!empty($matchDetails) && $matchDetails['total_count'] != 0) {
            $totalData = $matchDetails['total_count'];
            $totalFiltered = $totalData;
            $matchDetails = $this->common_model->getAllwhere(MATCHES, $where, $order, $dir, 'all', $limit, $start);
            if (!empty($matchDetails['result'])) {
                foreach ($matchDetails['result'] as $match) {
                    $start++;
                    $nestedData['id'] = $start;
                    $nestedData['localteam'] = isset($match->localteam) ? $match->localteam.' vs '.$match->visitorteam : '';
                    $nestedData['match_num'] = isset($match->match_num) ? $match->match_num : '';
                    $nestedData['match_type'] = isset($match->match_type) ? $match->match_type : '';
                    $nestedData['match_date'] = isset($match->match_date) ? date("d-m-Y", strtotime($match->match_date)).' '.$match->match_time : '';
                    $nestedData['status'] = isset($match->status) ? ($match->status == "open") ? "<p class='text-success'>".strtoupper($match->status)."</p>" : "<p class='text-danger'>".  strtoupper($match->status)."</p>" : '';
                    
                    $nestedData['action'] = '<a href="' . base_url() . 'matches/cricketers_list/' . $match->series_id . '/' . $match->localteam_id . '/' . $match->visitorteam_id. '" title="Players" class="btn btn-info"> <img width="18" src="'.base_url().CRICKET_ICON.'" /> Players</a>';
                                         // . '<a href="' . base_url() . 'contest/index/' . $match->match_id . '" title="Contests" class="btn btn-warning"> <img width="18" src="'.base_url().CRICKET_ICON.'" /> Contests</a>';
                    $data[] = $nestedData;
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
     * @method index
     * @description loading view of match list
     * @return array
     */
    public function cricketers_list($series_id='',$localteam_id='',$visitorteam_id='') {
        if(empty($series_id) && empty($localteam_id) && empty($visitorteam_id)){
            redirect('matches');
        }
        if (isset($series_id)) {
            $this->data['parent'] = "Matches";
            $this->data['title'] = "Matches";
            $this->data['series_id'] = $series_id;
            $this->data['localteam_id'] = $localteam_id;
            $this->data['visitorteam_id'] = $visitorteam_id;
            $matchName = $this->common_model->fetchSingleData('localteam,visitorteam', MATCHES, array('series_id' => $series_id));
            if(empty($matchName)){
               redirect('matches'); 
            }
            $this->data['match_name'] = isset($matchName->localteam) ? $matchName->localteam.' Vs '.$matchName->visitorteam : '';
        }
        $this->load->admin_render('cricketers_list', $this->data, 'inner_script');
    }

    /**
     * @method get_cricketers_list
     * @description listing display of cricketers
     * @return array
     */
    public function get_cricketers_list() {
        $columns = array('s_no',
            'team',
            'player_name',
            'play_role',
            'test',
            'odi',
            't20',
        );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $matchID = $this->input->post('match_id');
        $localteam_id = $this->input->post('localteam_id');
        $visitorteam_id = $this->input->post('visitorteam_id');
        $where = ' match_player.series_id=' . $matchID;
        $where .= " AND match_player.team_id IN ('".$localteam_id."','".$visitorteam_id."') ";
        if (!empty($this->input->post('search')['value'])) {
            $search = $this->input->post('search')['value'];
            $where.= ' and (team like "%' . $search . '%" or player_name like "%' . $search . '%")';
        }

        $data = array();
        $totalData = 0;
        $totalFiltered = 0;
        $cricketDetails = $this->common_model->getAllwhere(MATCH_PLAYER, $where);
        if (!empty($cricketDetails) && $cricketDetails['total_count'] != 0) {
            $totalData = $cricketDetails['total_count'];
            $totalFiltered = $totalData;
            $cricketDetails = $this->common_model->getAllwhere(MATCH_PLAYER, $where, $order, $dir, 'all', $limit, $start);
            if (!empty($cricketDetails['result'])) {
                foreach ($cricketDetails['result'] as $cricketers) {
                    $start++;
                    $nestedData['s_no'] = $start;
                    $nestedData['team'] = isset($cricketers->team) ? $cricketers->team : '';
                    $nestedData['player_name'] = isset($cricketers->player_name) ? $cricketers->player_name : '';
                    $nestedData['play_role'] = isset($cricketers->play_role) ? $cricketers->play_role : '';
                    $nestedData['test'] = isset($cricketers->test) ? ($cricketers->test == 1) ? "<div class='text-success'>Play</div>" : "" : '';
                    $nestedData['odi'] = isset($cricketers->odi) ? ($cricketers->odi == 1) ? "<div class='text-success'>Play</div>" : "" : '';
                    $nestedData['t20'] = isset($cricketers->t20) ? ($cricketers->t20 == 1) ? "<div class='text-success'>Play</div>" : "" : '';
                    $data[] = $nestedData;
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

}
