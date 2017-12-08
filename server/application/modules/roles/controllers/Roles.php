<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends Common_Controller {

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
        $this->data['parent'] = "Role";
        $this->data['title'] = "Role";
        $option = array('table' => GROUPS,
                    'where_not_in' => array('id' => array(1)),
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
        $this->data['title'] = lang("add_role");
        $this->load->view('add', $this->data);
    }

    /**
     * @method roles_add
     * @description add dynamic rows
     * @return array
     */
    public function roles_add() {
        
        // validate form input
       $this->form_validation->set_rules('role_name', lang('role_name'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('description', lang('description'), 'required|trim|xss_clean');
        
        if ($this->form_validation->run() == true) {
                $role_name = $this->input->post('role_name');
                $option_role = array(
                    'table' => GROUPS,
                    'where' => array('name' => $role_name)
                );
                $is_exists = $this->common_model->customGet($option_role);
                /* check condition if role already exist or not */
                if(empty($is_exists)){
                    $options_data = array(
                        'name' => $this->input->post('role_name'),
                        'description' => $this->input->post('description'),
                        'active' =>1
                        
                    );
                $option = array('table' => GROUPS, 'data' => $options_data);
                 if ($this->common_model->customInsert($option)) {
                    $response = array('status' => 1, 'message' => lang('role_success'), 'url' => base_url('roles'));
                } else {
                    $response = array('status' => 0, 'message' => lang('role_failed'));
                }
             }else {
                    $response = array('status' => 0, 'message' => lang('role_exist'));
                }
            }
         else {
            $messages = (validation_errors()) ? validation_errors() : '';
            $response = array('status' => 0, 'message' => $messages);
        }
        echo json_encode($response);
    }

    /**
     * @method user_edit
     * @description edit dynamic rows
     * @return array
     */
    public function roles_edit() {
        $this->data['title'] = lang("edit_role");
        $id = decoding($this->input->post('id'));
        if (!empty($id)) {
            $option = array(
                'table' => GROUPS,
                'where' => array('id' => $id),
                'single' => true
            );
            $results_row = $this->common_model->customGet($option);
            if (!empty($results_row)) {
                $this->data['results'] = $results_row;
                $this->load->view('edit', $this->data);
            } else {
                $this->session->set_flashdata('error', lang('not_found'));
                redirect('roles');
            }
        } else {
            $this->session->set_flashdata('error', lang('not_found'));
            redirect('roles');
        }
    }

    /**
     * @method roles_update
     * @description update dynamic rows
     * @return array
     */
    public function roles_update() {

        $this->form_validation->set_rules('role_name', lang('role_name'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('description', lang('description'), 'required|trim|xss_clean');
        

        $where_id = $this->input->post('id');
        if ($this->form_validation->run() == FALSE):
            $messages = (validation_errors()) ? validation_errors() : '';
            $response = array('status' => 0, 'message' => $messages);
        else:

              $role_name = $this->input->post('role_name');
                $option_role = array(
                    'table' => GROUPS,
                    'where' => array('id!='=>$where_id,'name' => $role_name)
                );
                $is_exists = $this->common_model->customGet($option_role);
                /* check condition if role already exist or not */
              if(empty($is_exists)){
                $options_data = array(
                    'name' => $this->input->post('role_name'),
                    'description' => $this->input->post('description')
                    
                );
                
                $option = array(
                'table' => GROUPS,
                'data' => $options_data,
                'where' => array('id' => $where_id)
               );
                $update = $this->common_model->customUpdate($option);
                $response = array('status' => 1, 'message' => lang('role_success_update'), 'url' => base_url('roles'));
            }else{
                $response = array('status' => 0, 'message' => lang('role_exist'));
            }
            
        endif;

        echo json_encode($response);
    }

    

}
