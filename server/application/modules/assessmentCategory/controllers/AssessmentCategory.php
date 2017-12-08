<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AssessmentCategory extends Common_Controller {

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
        $this->data['parent'] = "Assessment Category";
        $this->data['title'] = "Assessment Category";

        $option = array('table' => ASSESSMENT_CATEGORY,
            'order' => array('id' => 'ASC'));

        $this->data['list'] = $this->common_model->customGet($option);
        $this->load->admin_render('list', $this->data, 'inner_script');
    }

    /**
     * @method open_model
     * @description load model box
     * @return array
     */
    function open_model() {
        $this->data['title'] = lang("add_category");
        $this->load->view('add', $this->data);
    }

    /**
     * @method category_add
     * @description add dynamic rows
     * @return array
     */
    public function category_add() {

        // validate form input
        $this->form_validation->set_rules('category_name', lang('category_name'), 'required|trim|xss_clean');


        if ($this->form_validation->run() == true) {

            $category_name = $this->input->post('category_name');
            $assess_cat_exists = $this->common_model->customGet(array('table' => ASSESSMENT_CATEGORY ,'where' =>array('category_name' => $category_name)));
         if(empty($assess_cat_exists)){

            $options_data = array(
                'category_name' => $this->input->post('category_name'),
                'active' => 1,
                'create_date' => datetime()
            );
            $option = array('table' => ASSESSMENT_CATEGORY, 'data' => $options_data);
            if ($this->common_model->customInsert($option)) {
                $response = array('status' => 1, 'message' => lang('category_success'), 'url' => base_url('assessmentCategory'));
            } else {
                $response = array('status' => 0, 'message' => lang('category_failed'));
            }
         }else{
              $response = array('status' => 0, 'message' => lang('category_exist'));
         }
        } else {
            $messages = (validation_errors()) ? validation_errors() : '';
            $response = array('status' => 0, 'message' => $messages);
        }
        echo json_encode($response);
    }

    /**
     * @method category_edit
     * @description edit dynamic rows
     * @return array
     */
    public function category_edit() {
        $this->data['title'] = lang("edit_category");
        $id = decoding($this->input->post('id'));
        if (!empty($id)) {
            $option = array(
                'table' => ASSESSMENT_CATEGORY,
                'where' => array('id' => $id),
                'single' => true
            );
            $results_row = $this->common_model->customGet($option);
            if (!empty($results_row)) {
                $this->data['results'] = $results_row;
                $this->load->view('edit', $this->data);
            } else {
                $this->session->set_flashdata('error', lang('not_found'));
                redirect('assessmentCategory');
            }
        } else {
            $this->session->set_flashdata('error', lang('not_found'));
            redirect('assessmentCategory');
        }
    }

    /**
     * @method category_update
     * @description update dynamic rows
     * @return array
     */
    public function category_update() {

        $this->form_validation->set_rules('category_name', lang('category_name'), 'required|trim|xss_clean');


        $where_id = $this->input->post('id');
        if ($this->form_validation->run() == FALSE):
            $messages = (validation_errors()) ? validation_errors() : '';
            $response = array('status' => 0, 'message' => $messages);
        else:
            $category_name = $this->input->post('category_name');
            $assess_cat_exists = $this->common_model->customGet(array('table' => ASSESSMENT_CATEGORY ,'where' =>array('id!='=>$where_id,'category_name' => $category_name)));
         if(empty($assess_cat_exists)){

            $options_data = array(
                'category_name' => $this->input->post('category_name'),
            );

            $option = array(
                'table' => ASSESSMENT_CATEGORY,
                'data' => $options_data,
                'where' => array('id' => $where_id)
            );
            $update = $this->common_model->customUpdate($option);
            $response = array('status' => 1, 'message' => lang('category_success_update'), 'url' => base_url('assessmentCategory'));
        }else{
             $response = array('status' => 0, 'message' => lang('category_exist'));
        }

        endif;

        echo json_encode($response);
    }

    function delCategory() {
        $response = "";
        $id = decoding($this->input->post('id')); // delete id
        $table = $this->input->post('table'); //table name
        $id_name = $this->input->post('id_name'); // table field name
        if (!empty($table) && !empty($id) && !empty($id_name)) {
            
            $option = array(
                'table' => ASS_CATEGORY,
                'where' => array('category_id' => $id)
            );
            $exists = $this->common_model->customGet($option);
            if(empty($exists)){
                $option = array(
                    'table' => $table,
                    'where' => array($id_name => $id)
                );
                $delete = $this->common_model->customDelete($option);
            if ($delete) {
                $response = 200;
            } else
                $response = 400;
            }else{
                $response = 400; 
            }
        }else {
            $response = 400;
        }
        echo $response;
    }

}
