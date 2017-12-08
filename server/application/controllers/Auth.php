<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as user management
 * @package   CodeIgniter
 * @category  Controller
 * @author    MobiwebTech Team
 */
class Auth extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * Function Name: user
     * Description:   To user verification
     */
    public function verifyuser() {
        if ($this->input->get('email') && $this->input->get('token')) {
            $email = $this->input->get('email');
            $token = $this->input->get('token');
            $where = array('email' => $email, 'user_token' => $token);
            $result = $this->common_model->getsingle(USERS, $where);
            if (!empty($result)) {
                /* Update user status */
                $Status = $this->common_model->updateFields(USERS, array('user_token' => NULL, 'email_verify' => 1), array('id' => $result->id));
                if ($Status) {
                    $this->session->set_flashdata('user_verify', $notification_message);
                    $this->load->view('verification');
                } else {
                    $this->session->set_flashdata('user_verify', GENERAL_ERROR);
                }
            } else {
                $this->session->set_flashdata('user_verify', GENERAL_ERROR);
                $this->load->view('verification');
            }
        } else {
            $this->session->set_flashdata('user_verify', GENERAL_ERROR);
            $this->load->view('verification');
        }
    }

    /**
     * Function Name: resetpassword
     * Description:   To user forgot password view
     */
    public function resetpassword() {
        if ($this->input->get('email') && $this->input->get('token')) {
            $email = $this->input->get('email');
            $token = $this->input->get('token');
            $where = array('email' => $email, 'user_token' => $token);
            $result = $this->common_model->getsingle(USERS, $where);
            if (!empty($result)) {
                $data['details'] = $result;
                $this->load->view('resetpassword', $data);
            } else {
                $this->session->set_flashdata('user_verify', GENERAL_ERROR);
                $this->load->view('verification');
            }
        } else {
            $this->session->set_flashdata('user_verify', GENERAL_ERROR);
            $this->load->view('verification');
        }
    }

    /**
     * Function Name: _verify_token
     * Description:   To verify user token
     */
    public function _verify_token($token) {
        $result = $this->common_model->getsingle(USERS, array('user_token' => $token));
        if (!empty($result)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('_verify_token', 'Invalid user token');
            return FALSE;
        }
    }

    /**
     * Function Name: pswd_regex_check
     * Description:   For Password Regular Expression
     */
    public function pswd_regex_check($str) {
        $ci = &get_instance();
        if (1 !== preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/", $str)) {
            $ci->form_validation->set_message('pswd_regex_check', 'Password must contain at least 6 characters, including UPPER/lower case & numbers & at-least a special character');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Function Name: do_forgot_password
     * Description:   To change user password
     */
    public function do_forgot_password() {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('user_token', 'User Token', 'trim|required|callback__verify_token');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[14]|callback_pswd_regex_check');
            $this->form_validation->set_rules('cnfm_password', 'Confirm Password', 'trim|required|min_length[6]|max_length[14]|callback_pswd_regex_check|matches[new_password]');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();

                /* Update user password */
                $updateArr = array();
                $updateArr['password'] = md5($data['new_password']);
                $updateArr['user_token'] = NULL;

                $updateStatus = $this->common_model->updateFields(USERS, $updateArr, array('user_token' => $data['user_token']));
                if ($updateStatus) {
                    echo json_encode(array('type' => 'success', 'msg' => 'Password changed successfully'));
                    exit;
                } else {
                    echo json_encode(array('type' => 'failed', 'msg' => GENERAL_ERROR));
                    exit;
                }
            } else {
                $error = array(
                    'user_token' => form_error('user_token'),
                    'new_password' => form_error('new_password'),
                    'cnfm_password' => form_error('cnfm_password')
                );
                echo json_encode(array('type' => 'validation_err', 'msg' => $error));
                exit;
            }
        }
    }

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */
?>