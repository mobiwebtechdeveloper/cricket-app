<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class On404 extends Common_Controller {

    public $data = "";
    public $file_data = "";

    function __construct() {
        parent::__construct();

    }

    /**
     * @method index
     * @description  datatable show list
     * @return boolean
     */
    function index() {
        $this->output->set_status_header('404'); 
        $this->data['heading'] = "404 Page Not Found";
        $this->load->view('error_404', $this->data);
    }


}