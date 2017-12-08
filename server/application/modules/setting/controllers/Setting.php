<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends Common_Controller {

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
        $this->data['parent'] = "Settings";
        $this->data['title'] = "Settings";
        $this->load->admin_render('add', $this->data, 'inner_script');
    }

    /**
     * @method setting_add
     * @description add dynamic rows
     * @return array
     */
    public function setting_add() {

        $allOptions = is_options();
        $image = $this->input->post('site_logo_url');
        $image_login = $this->input->post('loginBackgroud');
        if (!empty($_FILES['user_image']['name'])) {
            $this->filedata = $this->commonUploadImage($_POST, 'app', 'user_image');
            if ($this->filedata['status'] == 1) {
                $image = 'uploads/app/' . $this->filedata['upload_data']['file_name'];
                delete_file($this->input->post('site_logo_url'), FCPATH);
            }
        }
         if (!empty($_FILES['login_background']['name'])) {
            $this->filedata = $this->commonUploadImage($_POST, 'app', 'login_background');
            if ($this->filedata['status'] == 1) {
                $image_login = 'uploads/app/' . $this->filedata['upload_data']['file_name'];
            }
        }
        foreach ($allOptions as $rows) {
            $option = array('table' => SETTING,
                'where' => array('option_name' => $rows, 'status' => 1),
                'single' => true,
            );
            $is_value = $this->common_model->customGet($option);
            if (!empty($is_value)) {
                $options = array('table' => SETTING,
                    'data' => array(
                        'option_value' => (isset($_POST[$rows])) ? $_POST[$rows] : "",
                    ),
                    'where' => array('option_name' => $rows)
                );
                if (!empty($image) && $rows == 'site_logo') {
                    $options['data']['option_value'] = $image;
                }
                if (!empty($image_login) && $rows == 'login_background') {
                    $options['data']['option_value'] = $image_login;
                }
                $this->common_model->customUpdate($options);
            } else {

                $options = array('table' => SETTING,
                    'data' => array(
                        'option_value' => (isset($_POST[$rows])) ? $_POST[$rows] : "",
                        'option_name' => $rows
                    )
                );
                if (!empty($image) && $rows == 'site_logo') {
                    $options['data']['option_value'] = $image;
                }
                if (!empty($image_login) && $rows == 'login_background') {
                    $options['data']['option_value'] = $image_login;
                }
                $this->common_model->customInsert($options);
            }
        }
        $response = array('status' => 1, 'message' => lang('setting_success_message'), 'url' => "");
        echo json_encode($response);
    }

}
