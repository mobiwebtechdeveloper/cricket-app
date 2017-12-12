<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as REST API for user
 * @package   CodeIgniter
 * @category  Controller
 * @author    MobiwebTech Team
 */
class User extends Common_API_Controller {

    function __construct() {
        parent::__construct();
        $tables = $this->config->item('tables', 'ion_auth');
        $this->lang->load('en', 'english');
    }

    /**
     * Function Name: socialSignIn
     * Description:   To User Social SignIn
     */
    function socialSignIn_post() {

        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $signUpType = $this->input->post('social_signup_type');
        $this->form_validation->set_rules('social_signup_type', 'Social Sign Up Type', 'trim|required|in_list[FACEBOOK,GOOGLE]');
        $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArr = array();
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;
            $dataArr['signup_type'] = extract_value($data, 'social_signup_type', '');
            $dataArr['social_id'] = extract_value($data, 'social_id', '');
            $email = extract_value($data, 'email', '');
            $dataArr['first_name'] = extract_value($data, 'full_name', '');
            $dataArr['email_verify'] = 1;
            $username = explode('@', $email);
            $dataArr['username'] = $username[0];
            $dataArr['email'] = $email;
            $dataArr['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $dataArr['password'] = "";
            $dataArr['active'] = 1;
            $dataArr['created_on'] = time();
            $login_session_key = get_guid();
            $digits = 5;
            $dataArr['team_code'] = strtoupper(substr(preg_replace('/[^A-Za-z0-9\-]/', '', $username[0]), 0, 5)) . rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $options = array(
                'table' => 'users',
                'select' => 'id',
                'where' => array('email' => $email)
            );
            $isEmailLogin = $this->common_model->customGet($options);
            $flag = false;
            if (!empty($isEmailLogin)) {
                $options = array(
                    'table' => 'users',
                    'data' => array(
                        'first_name' => extract_value($data, 'full_name', ''),
                        'signup_type' => extract_value($data, 'social_signup_type', ''),
                        'social_id' => extract_value($data, 'social_id', '')
                    ),
                    'where' => array('email' => $email)
                );
                $this->common_model->customUpdate($options);
                $flag = true;
            } else {
                $options = array(
                    'table' => 'users',
                    'data' => $dataArr
                );
                $flag = $insertId = $this->common_model->customInsert($options);
                $option = array(
                    'table' => 'users_groups',
                    'data' => array('user_id' => $insertId,
                        'group_id' => 2)
                );
                $this->common_model->customInsert($option);
            }
            if ($flag) {
                $isLogin = $this->common_model->getsingle(USERS, array('email' => $email));
                $option = array(
                    'table' => 'login_session',
                    'data' => array(
                        'login_session_key' => $login_session_key,
                        'user_id' => $isLogin->id,
                        'login_ip' => $_SERVER['REMOTE_ADDR'],
                        'last_login' => time()
                    ),
                );
                $this->common_model->customInsert($option);
                $response = array();
                $response['user_id'] = null_checker($isLogin->id);
                $response['name'] = null_checker($isLogin->first_name) . ' ' . null_checker($isLogin->last_name);
                $response['email'] = null_checker($isLogin->email);
                $response['login_session_key'] = null_checker($login_session_key);
                $response['team_code'] = null_checker($isLogin->team_code);
                $response['date_of_birth'] = null_checker($isLogin->date_of_birth);
                $response['mobile'] = null_checker($isLogin->phone);
                $response['city'] = null_checker($isLogin->city);
                $response['pin_code'] = null_checker($isLogin->pin_code);
                $response['state'] = null_checker($isLogin->state);
                $response['country'] = null_checker($isLogin->country);
                $response['address'] = null_checker($isLogin->street);
                $response['email_verify'] = null_checker($isLogin->email_verify);
                $response['verify_mobile'] = null_checker($isLogin->verify_mobile);
                $response['gender'] = null_checker($isLogin->gender);
                $response['active'] = null_checker($isLogin->active);
                $return['response'] = $response;

                $return['status'] = 1;
                $return['message'] = 'User registered successfully';
            } else {
                $return['status'] = 0;
                $return['message'] = 'User social authentication failed';
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: signup
     * Description:   To User Registration
     */
    function signup_post() {

        $data = @file_get_contents("php://input");
        $post = json_decode($data);
        $return['code'] = 200;
        $return['response'] = new stdClass();

        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;
        $identity = $post->email;
        $password = $post->password;
        $email = strtolower($post->email);
        $option = array('table' => 'users','where' => array('email' => $email));
        $isExists = $this->common_model->customGet($option);
        if(empty($isExists)){
        $identity = ($identity_column === 'email') ? $email :$post->email;
        $dataArr = array();
        $dataArr['first_name'] = $post->full_name;
        $dataArr['date_of_birth'] = date('Y-m-d');
        $dataArr['is_pass_token'] = $password;
        $dataArr['email_verify'] = 0;
        $username = explode('@', $identity);
        $dataArr['username'] = $username[0];
        $digits = 5;
        $dataArr['team_code'] = strtoupper(substr(preg_replace('/[^A-Za-z0-9\-]/', '', $username[0]), 0, 5)) . rand(pow(10, $digits - 1), pow(10, $digits) - 1);

        $lid = $this->ion_auth->register($identity, $password, $email, $dataArr, array(2));
        if ($lid) {
            /* Return success response */
            $return['status'] = 1;
            $return['message'] = 'User registered successfully';
        } else {
            $is_error = db_err_msg();
            if ($is_error == FALSE) {
                $return['status'] = 1;
                $return['message'] = 'User registered successfully';
            } else {
                $return['status'] = 0;
                $return['message'] = $is_error;
            }
        }
    }else{
        $return['status'] = 0;
        $return['message'] = "Email already exists, Please login"; 
    }
        
        $this->response($return);
    }

    /**
     * Function Name: login
     * Description:   To User Login
     */
    function login_post() {

        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $signUpType = $this->input->post('signup_type');
        $this->form_validation->set_rules('signup_type', 'Sign Up Type', 'trim|required|in_list[WEB,APP]');
        $this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($signUpType == 'APP') {
            $this->form_validation->set_rules('device_type', 'Device Type', 'trim|required|in_list[ANDROID,IOS]');
            $this->form_validation->set_rules('device_token', 'Device Token', 'trim|required');
            $this->form_validation->set_rules('device_id', 'Device Id', 'trim|required');
        }
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArr = array();
            $email = extract_value($data, 'email', '');
            $password = extract_value($data, 'password', '');
            $dataArr['email'] = extract_value($data, 'email', '');
            /* Get User Data From Users Table */
            $isLogin = $this->ion_auth->login($email, $password, FALSE);
            if ($isLogin) {
                $isLogin = $this->common_model->getsingle(USERS, $dataArr);
            }
            if (empty($isLogin)) {
                $return['status'] = 0;
                $return['message'] = 'Invalid Email-id or Password';
            } else if ($isLogin->active != 1) {
                $return['status'] = 0;
                $return['message'] = DEACTIVATE_USER;
            } else {
                /* Update User Data */
                $UpdateData = array();
                if ($signUpType == 'APP') {
                    $UpdateData['device_type'] = extract_value($data, 'device_type', NULL);
                    $UpdateData['device_token'] = extract_value($data, 'device_token', NULL);
                    $UpdateData['device_id'] = extract_value($data, 'device_id', NULL);
                }
                $login_session_key = get_guid();
                /* $UpdateData['is_logged_out'] = 0;
                  $UpdateData['login_session_key'] = $login_session_key;
                  $UpdateData['last_login'] = time();
                  $this->common_model->updateFields(USERS, $UpdateData, array('id' => $isLogin->id)); */
                $option = array(
                    'table' => 'login_session',
                    'data' => array(
                        'login_session_key' => $login_session_key,
                        'user_id' => $isLogin->id,
                        'login_ip' => $_SERVER['REMOTE_ADDR'],
                        'last_login' => time()
                    ),
                );
                $this->common_model->customInsert($option);
                if ($signUpType == 'APP') {
                    save_user_device_history($isLogin->id, $UpdateData['device_token'], $UpdateData['device_type'], $UpdateData['device_id']);
                }
                $response = array();
                $response['user_id'] = null_checker($isLogin->id);
                $response['name'] = null_checker($isLogin->first_name) . ' ' . null_checker($isLogin->last_name);
                $response['email'] = null_checker($isLogin->email);
                $response['login_session_key'] = null_checker($login_session_key);
                $response['team_code'] = null_checker($isLogin->team_code);
                $response['date_of_birth'] = null_checker($isLogin->date_of_birth);
                $response['mobile'] = null_checker($isLogin->phone);
                $response['city'] = null_checker($isLogin->city);
                $response['pin_code'] = null_checker($isLogin->pin_code);
                $response['state'] = null_checker($isLogin->state);
                $response['country'] = null_checker($isLogin->country);
                $response['address'] = null_checker($isLogin->street);
                $response['email_verify'] = null_checker($isLogin->email_verify);
                $response['verify_mobile'] = null_checker($isLogin->verify_mobile);
                $response['gender'] = null_checker($isLogin->gender);
                $response['active'] = null_checker($isLogin->active);
                $return['response'] = $response;
                $return['status'] = 1;
                $return['message'] = 'User logged in successfully';
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: countries
     * Description:   To Get All Countries
     */
    function countries_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = array();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $countries = $this->common_model->customGet(array('table' => COUNTRY));
            if ($countries) {
                $return['status'] = 1;
                $return['response'] = $countries;
                $return['message'] = 'Successfully records found';
            } else {
                $return['status'] = 0;
                $return['message'] = 'Records not found';
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: countries
     * Description:   To Get All Countries
     */
    function states_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = array();
        $this->form_validation->set_rules('country_id', 'Country Id', 'trim|required|numeric');
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $states = $this->common_model->customGet(array('table' => 'states', 'select' => 'id,name', 'where' => array('country_id' => $this->input->post('country_id'))));
            if ($states) {
                $return['status'] = 1;
                $return['response'] = $states;
                $return['message'] = 'Successfully records found';
            } else {
                $return['status'] = 0;
                $return['message'] = 'Records not found';
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: update_profile
     * Description:   To Update User Profile
     */
    function update_profile_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();

        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required');
        $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required|callback__validate_birthdate_format');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('pin_code', 'Pin Code', 'trim|required|numeric|min_length[5]|max_length[6]');
        $this->form_validation->set_rules('state', 'State', 'trim|required|numeric');
        $this->form_validation->set_rules('country', 'Country', 'trim|required|numeric');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required|in_list[MALE,FEMALE]');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric|min_length[10]|max_length[11]');

        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArr = array();
            $dateOfBirth = date('Y-m-d', strtotime(extract_value($data, 'date_of_birth', '')));
            $dataArr['first_name'] = extract_value($data, 'full_name', '');
            $dataArr['city'] = extract_value($data, 'city', '');
            $dataArr['pin_code'] = extract_value($data, 'pin_code', '');
            $dataArr['state'] = extract_value($data, 'state', '');
            $dataArr['country'] = extract_value($data, 'country', '');
            $dataArr['street'] = extract_value($data, 'address', '');
            $dataArr['gender'] = extract_value($data, 'gender', '');
            $dataArr['phone'] = extract_value($data, 'mobile', '');
            $dataArr['date_of_birth'] = $dateOfBirth;
            /* Update User Data Into Users Table */
            $status = $this->common_model->updateFields(USERS, $dataArr, array('id' => $this->user_details->id));
            if ($status) {
                /* Return success response */
                $return['status'] = 1;
                $return['message'] = 'Profile updated successfully';
            } else {
                $is_error = db_err_msg();
                $return['status'] = 0;
                if ($is_error == FALSE) {
                    $return['message'] = NO_CHANGES;
                } else {
                    $return['message'] = $is_error;
                }
            }
        }
        $this->response($return);
    }

    /*
     * Function Name: profile_details
     * Description:   To Get User Profile Details
     */

    function profile_details_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            /* Return Response */
            $response = array();

            if (!empty($this->user_details->profile_pic)) {
                $image = base_url() . $this->user_details->profile_pic;
            } else {
                /* set default image if empty */
                $image = base_url() . DEFAULT_NO_IMG_PATH;
            }
            $response['login_session_key'] = null_checker($this->user_details->login_session_key);
            $response['first_name'] = null_checker($this->user_details->first_name);
            $response['team_code'] = null_checker($this->user_details->team_code);
            $response['email'] = null_checker($this->user_details->email);
            $response['mobile'] = null_checker($this->user_details->phone);
            $response['gender'] = null_checker($this->user_details->gender);
            $response['date_of_birth'] = null_checker($this->user_details->date_of_birth);
            $response['city'] = null_checker($this->user_details->city);
            $response['state'] = null_checker($this->user_details->state);
            $response['country'] = null_checker($this->user_details->country);
            $response['street'] = null_checker($this->user_details->street);
            $response['pin_code'] = null_checker($this->user_details->pin_code);
            $response['user_image'] = $image;
            $return['status'] = 1;
            $return['response'] = $response;
            $return['message'] = 'success';
        }
        $this->response($return);
    }

    /**
     * Function Name: change_password
     * Description:   To Change User Password
     */
    function change_password_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('login_session_key', 'Login Session Key', 'trim|required');
        $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[14]|callback_is_secure_pass');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[6]|max_length[14]|matches[new_password]');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $current_password = extract_value($data, 'current_password', "");
            $new_password = extract_value($data, 'new_password', "");
            $confirm_password = extract_value($data, 'confirm_password', "");

            /* To check user current password */
            $identity = $this->user_details->email;
            $change = $this->ion_auth->change_password($identity, $current_password, $new_password);
            if (!empty($change)) {
                $options = array('table' => USERS,
                    'data' => array('is_pass_token' => $this->input->post('new_password')),
                    'where' => array('email' => $identity));
                $this->common_model->customUpdate($options);
                $return['status'] = 1;
                $return['message'] = 'The new password has been saved successfully';
            } else {
                $return['status'] = 0;
                $return['message'] = 'The old password you entered was incorrect';
            }
        }
        $this->response($return);
    }

    /*
     * Function Name: logout
     * Description:   To User Logout
     */

    function logout_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('login_session_key', 'Login Session Key', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $login_session_key = extract_value($data, 'login_session_key', NULL);
            $option = array(
                'table' => 'login_session',
                'where' => array('login_session_key' => $login_session_key)
            );
            $this->common_model->customDelete($option);
            /* Update User logout status */
            /* $this->common_model->updateFields(USERS, array('is_logged_out' => 1, 'login_session_key' => ""), array('id' => $this->user_details->id)); */
            $return['status'] = 1;
            $return['message'] = 'User logout successfully';
        }
        $this->response($return);
    }

    /**
     * Function Name: update_profile
     * Description:   To Update User Profile
     */
    function verify_pan_card_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();

        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required');
        $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required|callback__validate_birthdate_format');
        $this->form_validation->set_rules('pan_number', 'Pan Number', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required|numeric');
        if (empty($_FILES['pan_card_file']['name'])) {
            $this->form_validation->set_rules('pan_card_file', 'Pan Card File', 'required');
        }
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArr = array();
            $dateOfBirth = date('Y-m-d', strtotime(extract_value($data, 'date_of_birth', '')));
            $dataArr['full_name'] = extract_value($data, 'full_name', '');
            $dataArr['pan_number'] = extract_value($data, 'pan_number', '');
            $dataArr['state'] = extract_value($data, 'state', '');
            $dataArr['date_of_birth'] = $dateOfBirth;
            $dataArr['user_id'] = $this->user_details->id;
            $dataArr['create_date'] = date('Y-m-d H:i:s');
            $panCardFile = fileUpload('pan_card_file', 'users', 'png|jpg|jpeg|gif|pdf');
            $dataArr['pan_card_file'] = 'uploads/users/' . $panCardFile['upload_data']['file_name'];
            if (isset($panCardFile['error'])) {
                $return['status'] = 0;
                $return['message'] = strip_tags($panCardFile['error']);
            } else {
                /* Update User Data Into Users Table */
                $option = array(
                    'table' => 'user_pan_card',
                    'data' => $dataArr
                );
                $status = $this->common_model->customInsert($option);
                if ($status) {
                    /* Return success response */
                    $return['status'] = 1;
                    $return['message'] = 'Your PAN Card detail successfully submitted,We will verified with in 4-5 working days';
                } else {
                    $is_error = db_err_msg();
                    $return['status'] = 0;
                    if ($is_error == FALSE) {
                        $return['message'] = "Your PAN Card detail incorrect,Please try again";
                    } else {
                        $return['message'] = $is_error;
                    }
                }
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: resend_verification_link
     * Description:   To Re-send User Verification Link
     */
    function email_verification_link_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArr = array();
            $dataArr['email'] = extract_value($data, 'email', '');

            /* Get User Data From Users Table */
            $result = $this->common_model->getsingle(USERS, $dataArr);

            if (empty($result)) {
                $return['status'] = 0;
                $return['message'] = 'Email-id does not exist';
            } else {
                if ($result->email_verify == 0) {
                    if ($result->signup_type == "WEB") {
                        $user_id = $result->id;
                        $user_email = $result->email;
                        /* Update user token */
                        //$token = encoding($user_email . "-" . $user_id . "-" . time());
                        $token = mt_rand(100000, 999999);
                        $tokenArr = array('user_token' => $token);
                        $update_status = $this->common_model->updateFields(USERS, $tokenArr, array('id' => $user_id));
                        //$link = base_url() . 'auth/verifyuser?email=' . $user_email . '&token=' . $token;
                        /* $message = "";
                          $message .= "<img style='width:200px' src='" . base_url() . getConfig('site_logo') . "' class='img-responsive'></br></br>";
                          $message .= "<br><br> Hello ".  ucwords($result->firest_name).",<br/><br/>";
                          $message .= "Your " . getConfig('site_name') . " profile has been created. Please click on below link to verify your account. <br/><br/>";
                          $message .= "Click here : <a href='" . $link . "'>Verify Your Email</a>";
                          $status = send_mail($message, '[' . getConfig('site_name') . '] Email verification', $user_email, getConfig('admin_email')); */

                        $html = array();
                        $html['token'] = $token;
                        $html['logo'] = base_url() . getConfig('site_logo');
                        $html['site'] = getConfig('site_name');
                        $html['user'] = ucwords($result->first_name);
                        $email_template = $this->load->view('email/email_verification_tpl', $html, true);
                        $status = send_mail($email_template, '[' . getConfig('site_name') . '] Email verification', $user_email, getConfig('admin_email'));

                        if ($status) {
                            $return['status'] = 1;
                            $return['message'] = 'An email has been sent verification Code. Please check your inbox';
                        } else {
                            $return['status'] = 0;
                            $return['message'] = EMAIL_SEND_FAILED;
                        }
                    } else {
                        $return['status'] = 0;
                        $return['message'] = 'Social User can not make request';
                    }
                } else {
                    $return['status'] = 0;
                    $return['message'] = 'Email already verified';
                }
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: user
     * Description:   To user verification email
     */
    public function verify_code_email_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('vCode', 'Verification Code', 'trim|required|numeric');
        $this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $vCode = extract_value($data, 'vCode', '');
            $email = extract_value($data, 'email', '');
            ;
            $where = array('email' => $email, 'user_token' => $vCode);
            $isUser = $this->common_model->getsingle(USERS, $where);
            if (!empty($isUser)) {
                $Status = $this->common_model->updateFields(USERS, array('user_token' => NULL, 'email_verify' => 1), array('id' => $isUser->id));
                if ($Status) {
                    $return['status'] = 1;
                    $return['message'] = 'Your email has been verified';
                } else {
                    $return['status'] = 0;
                    $return['message'] = GENERAL_ERROR;
                }
            } else {
                $return['status'] = 0;
                $return['message'] = 'Invalid Verification Code,Please resend again';
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: forgot_password
     * Description:   To User Forgot Password
     */
    function forgot_password_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArr = array();
            $dataArr['email'] = extract_value($data, 'email', '');
            /* Get User Data From Users Table */
            $result = $this->common_model->getsingle(USERS, $dataArr);
            if (empty($result)) {
                $return['status'] = 0;
                $return['message'] = 'Email-id does not exist';
            } else {
                $user_email = $result->email;
                $user_id = $result->id;
                $identity_column = $this->config->item('identity', 'ion_auth');
                $identity = $this->ion_auth->where($identity_column, $this->input->post('email'))->users()->row();
                if (empty($identity)) {
                    if ($this->config->item('identity', 'ion_auth') != 'email') {
                        $error = "No record of that email address";
                    } else {
                        $error = "No record of that email address";
                    }
                    $return['status'] = 0;
                    $return['message'] = $error;
                    $this->response($return);
                    exit;
                }
                $token = mt_rand(100000, 999999);
                $tokenArr = array('user_token' => $token);
                $update_status = $this->common_model->updateFields(USERS, $tokenArr, array('id' => $user_id));

                $html = array();
                $html['token'] = $token;
                $html['logo'] = base_url() . getConfig('site_logo');
                $html['site'] = getConfig('site_name');
                $html['user'] = ucwords($result->first_name);
                $email_template = $this->load->view('email/forgot_password_code_tpl', $html, true);
                $status = send_mail($email_template, '[' . getConfig('site_name') . '] Forgot Password Code', $user_email, getConfig('admin_email'));
                // $forgotten = $this->ion_auth->forgotten_password_app($identity->{$this->config->item('identity', 'ion_auth')});
                if ($status) {
                    $return['status'] = 1;
                    $return['message'] = "An email has been sent Forgot Password verification Code. Please check your inbox";
                } else {
                    $return['status'] = 0;
                    $return['message'] = "Unable to Send Verification Code Email,Please try again";
                }
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: user
     * Description:   To user reset password
     */
    public function reset_password_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('vCode', 'Verification Code', 'trim|required|numeric');
        $this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[14]|callback_is_secure_pass');
        $this->form_validation->set_rules('cnfm_password', 'Confirm Password', 'trim|required|min_length[6]|max_length[14]|matches[new_password]');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $vCode = extract_value($data, 'vCode', '');
            $email = extract_value($data, 'email', '');
            $new_password = extract_value($data, 'new_password', '');
            $where = array('email' => $email, 'user_token' => $vCode);
            $isUser = $this->common_model->getsingle(USERS, $where);
            if (!empty($isUser)) {
                $change = $this->ion_auth->reset_password($email, $this->input->post('new_password'));
                if ($change) {
                    $Status = $this->common_model->updateFields(USERS, array('user_token' => NULL, 'is_pass_token' => $this->input->post('new_password')), array('id' => $isUser->id));
                    $return['status'] = 1;
                    $return['message'] = 'Your Password Successfully Reset';
                } else {
                    $return['status'] = 0;
                    $return['message'] = GENERAL_ERROR;
                }
            } else {
                $return['status'] = 0;
                $return['message'] = 'Invalid Verification Code,Please resend again';
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: deactivate_account
     * Description:   To Deactivate User Account
     */
    function deactivate_account_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            if ($this->user_details->active == 0) {
                $return['status'] = 0;
                $return['message'] = 'Account already deactivated';
            } else if ($this->user_details->active == 1) {
                /* Update User Details */
                $status = $this->common_model->updateFields(USERS, array('is_deactivated' => 1), array('id' => $this->user_details->id));
                if ($status) {
                    $return['status'] = 1;
                    $return['message'] = 'Account deactivated successfully';
                } else {
                    $is_error = db_err_msg();
                    $return['status'] = 0;
                    if ($is_error == FALSE) {
                        $return['message'] = NO_CHANGES;
                    } else {
                        $return['message'] = $is_error;
                    }
                }
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: change_profile_image
     * Description:   To Change User Profile Image
     */
    function change_profile_image_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required');
        if (empty($_FILES['user_image']['name'])) {
            $this->form_validation->set_rules('user_image', 'User Image', 'required');
        }
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArr = array();

            /* Upload user image */
            $image = fileUpload('user_image', 'users', 'png|jpg|jpeg|gif');
            if (isset($image['error'])) {
                $return['status'] = 0;
                $return['message'] = $image['error'];
            } else {
                $dataArr['profile_pic'] = 'uploads/users/' . $image['upload_data']['file_name'];

                /* Create user image thumb */
                //$dataArr['user_image_thumb'] = get_image_thumb($dataArr['profile_pic'], 'users', 250, 250);

                /* Update User Details */
                $status = $this->common_model->updateFields(USERS, $dataArr, array('id' => $this->user_details->id));
                if ($status) {
                    /* Return Response */
                    $response = array();
                    $response['user_original_image'] = base_url() . $dataArr['profile_pic'];
                    $return['response'] = $response;
                    $return['status'] = 1;
                    $return['message'] = 'Profile image updated successfully';
                } else {
                    $is_error = db_err_msg();
                    $return['status'] = 0;
                    if ($is_error == FALSE) {
                        $return['message'] = NO_CHANGES;
                    } else {
                        $return['message'] = $is_error;
                    }
                }
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: clear_badges
     * Description:   To Clear Notification Badges
     */
    function clear_badges_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('login_session_key', 'Login Session Key', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            /* Update user badges */
            $this->common_model->updateFields(USERS, array('badges' => 0), array('id' => $this->user_details->id));

            $return['status'] = 1;
            $return['message'] = 'Badges cleared successfully';
        }
        $this->response($return);
    }

    /**
     * Function Name: get_badges
     * Description:   To Get Notification Badges
     */
    function get_badges_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('login_session_key', 'Login Session Key', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            /* To get user badges */
            $badges = $this->common_model->getsingle(USERS, array('id' => $this->user_details->id));
            if (!empty($badges)) {
                $return['response'] = array('badges' => (int) null_checker($badges->badges));
            } else {
                $return['response'] = array('badges' => 0);
            }
            $return['status'] = 1;
            $return['message'] = 'Success';
        }
        $this->response($return);
    }

    /**
     * Function Name: forgot_password
     * Description:   To User Forgot Password
     */
    function forgot_password_post_OLD() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArr = array();
            $dataArr['email'] = extract_value($data, 'email', '');

            /* Get User Data From Users Table */
            $result = $this->common_model->getsingle(USERS, $dataArr);
            if (empty($result)) {
                $return['status'] = 0;
                $return['message'] = 'Email-id does not exist';
            } else {

                $identity_column = $this->config->item('identity', 'ion_auth');
                $identity = $this->ion_auth->where($identity_column, $this->input->post('email'))->users()->row();

                if (empty($identity)) {

                    if ($this->config->item('identity', 'ion_auth') != 'email') {
                        $error = "No record of that email address";
                    } else {
                        $error = "No record of that email address";
                    }
                    $return['status'] = 0;
                    $return['message'] = $error;
                    $this->response($return);
                    exit;
                }


                $forgotten = $this->ion_auth->forgotten_password_app($identity->{$this->config->item('identity', 'ion_auth')});

                if ($forgotten) {

                    $return['status'] = 1;
                    $return['message'] = strip_tags($this->ion_auth->messages());
                } else {
                    $return['status'] = 0;
                    $return['message'] = strip_tags($this->ion_auth->errors());
                }
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: page
     * Description:   To get pages
     */
    function page_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('page_id', 'Page Id', 'trim|required|in_list[ABOUT,CONTACT,TERMS_CONDITION,FAQS,PRIVACY_POLICY]');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $page_id = extract_value($data, 'page_id', '');
            $content = $this->common_model->getsingle('cms', array('page_id' => $page_id));
            if (empty($content)) {
                $return['status'] = 0;
                $return['message'] = 'Page not found';
            } else {
                $return['response'] = $content;
                $return['status'] = 1;
                $return['message'] = 'Page found successfully';
            }
        }
        $this->response($return);
    }

    public function isAuth_post() {

        $data = @file_get_contents("php://input");
        $post = json_decode($data);
        $email = $post->email;
        $password = $post->password;
        $signUpType = $post->signup_type;
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $dataArr = array();
        $dataArr['email'] = $email;
        /* Get User Data From Users Table */
        $isLogin = $this->ion_auth->login($email, $password, FALSE);
        if ($isLogin) {
            $isLogin = $this->common_model->getsingle(USERS, $dataArr);
        }
        if (empty($isLogin)) {
            $return['status'] = 0;
            $return['message'] = 'Invalid Email-id or Password';
        } else if ($isLogin->active != 1) {
            $return['status'] = 0;
            $return['message'] = DEACTIVATE_USER;
        } else {
            /* Update User Data */
            $UpdateData = array();
            if ($signUpType == 'APP') {
                $UpdateData['device_type'] = extract_value($data, 'device_type', NULL);
                $UpdateData['device_token'] = extract_value($data, 'device_token', NULL);
                $UpdateData['device_id'] = extract_value($data, 'device_id', NULL);
            }
            $login_session_key = get_guid();
            /* $UpdateData['is_logged_out'] = 0;
              $UpdateData['login_session_key'] = $login_session_key;
              $UpdateData['last_login'] = time();
              $this->common_model->updateFields(USERS, $UpdateData, array('id' => $isLogin->id)); */
            $option = array(
                'table' => 'login_session',
                'data' => array(
                    'login_session_key' => $login_session_key,
                    'user_id' => $isLogin->id,
                    'login_ip' => $_SERVER['REMOTE_ADDR'],
                    'last_login' => time()
                ),
            );
            $this->common_model->customInsert($option);
            if ($signUpType == 'APP') {
                save_user_device_history($isLogin->id, $UpdateData['device_token'], $UpdateData['device_type'], $UpdateData['device_id']);
            }
            $response = array();
            $response['user_id'] = null_checker($isLogin->id);
            $response['name'] = null_checker($isLogin->first_name) . ' ' . null_checker($isLogin->last_name);
            $response['email'] = null_checker($isLogin->email);
            $response['login_session_key'] = null_checker($login_session_key);
            $response['team_code'] = null_checker($isLogin->team_code);
            $response['date_of_birth'] = null_checker($isLogin->date_of_birth);
            $response['mobile'] = null_checker($isLogin->phone);
            $response['city'] = null_checker($isLogin->city);
            $response['pin_code'] = null_checker($isLogin->pin_code);
            $response['state'] = null_checker($isLogin->state);
            $response['country'] = null_checker($isLogin->country);
            $response['address'] = null_checker($isLogin->street);
            $response['email_verify'] = null_checker($isLogin->email_verify);
            $response['verify_mobile'] = null_checker($isLogin->verify_mobile);
            $response['gender'] = null_checker($isLogin->gender);
            $response['active'] = null_checker($isLogin->active);
            $return['response'] = $response;
            $return['status'] = 1;
            $return['message'] = 'User logged in successfully';
        }

        $this->response($return);
    }

}

/* End of file User.php */
/* Location: ./application/controllers/api/v1/User.php */
?>