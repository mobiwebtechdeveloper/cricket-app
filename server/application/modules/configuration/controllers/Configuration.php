<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Configuration extends Common_Controller {

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
    public function index() {
        $this->data['parent'] = "Configuration";
        $this->data['title'] = "Point Configuration";
        $this->load->admin_render('add', $this->data, 'inner_script');
    }

    /**
     * @method setting_add
     * @description add dynamic rows
     * @return array
     */
    public function configuration_add() {
        $allOptions = fantasyPointInput();
        $matchType = array('_t20', '_odi', '_test');
        foreach ($allOptions as $opt) {
            foreach ($opt as $key => $rows) {
                foreach ($matchType as $type) {
                    $option = array('table' => SETTING,
                        'where' => array('option_name' => $key . $type, 'status' => 1),
                        'single' => true,
                    );
                    $is_value = $this->common_model->customGet($option);
                    if (!empty($is_value)) {
                        $options = array('table' => SETTING,
                            'data' => array(
                                'option_value' => (isset($_POST[$key . $type])) ? $_POST[$key . $type] : "",
                            ),
                            'where' => array('option_name' => $key . $type)
                        );
                        $this->common_model->customUpdate($options);
                    } else {

                        $options = array('table' => SETTING,
                            'data' => array(
                                'option_value' => (isset($_POST[$key . $type])) ? $_POST[$key . $type] : "",
                                'option_name' => $key . $type
                            )
                        );
                        $this->common_model->customInsert($options);
                    }
                }
            }
        }

        $response = array('status' => 1, 'message' => lang('setting_success_message'), 'url' => "");
        echo json_encode($response);
    }

}
