<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends Common_Controller {

    public $data = "";

    function __construct() {
        parent::__construct();
        $this->load->library(array('ion_auth'));
        $this->load->helper(array('language'));
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
    }

   

   public function about_us() {
         $this->data['title'] = 'About Us';
        
        $option = array('table' => 'cms',
                        'where'=>array('page_id'=>'about',
                                        'active' => 1),
                        'single' => true
                        );
        $this->data['response'] = $this->common_model->customGet($option);

         $this->load->view('about_us', $this->data);
         
        
    }
     public function privacyPolicy() {
         $this->data['title'] = 'Privacy Policy';
        
        $option = array('table' => 'cms',
                        'where'=>array('page_id'=>'privacy_policy',
                                        'active' => 1),
                        'single' => true
                        );
        $this->data['response'] = $this->common_model->customGet($option);

         $this->load->view('privacy_policy', $this->data);
         
        
    }


}
