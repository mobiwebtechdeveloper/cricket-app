<?php

defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * [get user ]
 */
if (!function_exists('getUser')) {

    function getUser($id = "") {
        $CI = & get_instance();
        return $CI->common_model->customGet(array('table' => 'users', 'where' => array('id' => $id), 'single' => true));
    }

}

/**
 * [common query ]
 */
if (!function_exists('commonGetHelper')) {

    function commonGetHelper($option) {
        $ci = get_instance();
        return $ci->common_model->customGet($option);
    }

}

/**
 * [common query ]
 */
if (!function_exists('commonCountHelper')) {

    function commonCountHelper($option) {
        $ci = get_instance();
        return $ci->common_model->customCount($option);
    }

}


/**
 * [get common configure ]
 */
if (!function_exists('getConfig')) {

    function getConfig($key) {
        $ci = get_instance();
        $option = array('table' => SETTING,
            'where' => array('option_name' => $key, 'status' => 1),
            'single' => true,
        );
        $is_result = $ci->common_model->customGet($option);
        if (!empty($is_result)) {
            return $is_result->option_value;
        } else {
            return false;
        }
    }

}

/**
 * [Multidimensional Array Searching (Find key by specific value)]
 */
if (!function_exists('matchKeyValue')) {

    function matchKeyValue($products, $field, $value) {
        foreach ($products as $key => $product) {
            if ($product->$field === $value)
                return true;
        }
        return false;
    }

}

/**
 * [get role ]
 */
if (!function_exists('getRole')) {

    function getRole($id = "") {
        $CI = & get_instance();
        $option = array('table' => USERS . ' as user',
            'select' => 'group.name as group_name',
            'join' => array(array(USER_GROUPS . ' as ugroup', 'ugroup.user_id=user.id', 'left'),
                array(GROUPS . ' as group', 'group.id=ugroup.group_id', 'left')),
            'where' => array('user.id' => $id),
            'single' => true
        );
        $user = $CI->common_model->customGet($option);
        if (!empty($user)) {
            return ucwords($user->group_name);
        } else {
            return false;
        }
    }

}

/**
 * [get role position ]
 */
if (!function_exists('getRolePosition')) {

    function getRolePosition($organization_id, $limit, $offset) {
        $CI = & get_instance();
        $option = array('table' => HIERARCHY_ROLE_ORDER . ' as roles',
            'select' => 'role_id',
            'where' => array('roles.organization_id' => $organization_id
            ),
            'order' => array('roles.id' => 'desc'),
            'single' => true,
            'limit' => array($limit => $offset),
            'group_by' => array('roles.id')
        );

        $roles = $CI->common_model->customGet($option);
        if (!empty($roles)) {
            return $roles->role_id;
        } else {
            return false;
        }
    }

}


/**
 * [get common configure ]
 */
if (!function_exists('is_options')) {

    function is_options() {
        $options = array(
            'admin_email',
            'site_name', 
            'date_foramte',
            'site_meta_title',
            'site_meta_description',
            'site_logo',
            'google_captcha',
            'data_sitekey',
            'secret_key',
            'login_background',
            'paytm_environment',
            'paytm_merchant_key',
            'paytm_merchant_mid',
            'paytm_merchant_website'
        );
        return $options;
    }

}


/**
 * [print pre ]
 */
if (!function_exists('dump')) {

    function dump($data) {
        echo"<pre>";
        print_r($data);
        echo"</pre>";
        exit;
    }

}

/**
 * [Get year between Two Dates ]
 */
if (!function_exists('getYearBtTwoDate')) {

    function getYearBtTwoDate($datetime1, $datetime2) {
        //$datetime1 = new DateTime("$datetime1");
        //$datetime2 = new DateTime("$datetime2");

        $startDate = new DateTime($datetime1);
        $endDate = new DateTime($datetime2);

        $difference = $endDate->diff($startDate);

        return $difference->d; // This will print '12' die();
    }

}

/**
 * [To print last query]
 */
if (!function_exists('lq')) {

    function lq() {
        $CI = & get_instance();
        echo $CI->db->last_query();
        die;
    }

}

/**
 * [To get database error message]
 */
if (!function_exists('db_err_msg')) {

    function db_err_msg() {
        $CI = & get_instance();
        $error = $CI->db->error();
        if (isset($error['message']) && !empty($error['message'])) {
            return 'Database error - ' . $error['message'];
        } else {
            return FALSE;
        }
    }

}

/**
 * [To parse html]
 * @param string $str
 */
if (!function_exists('parseHTML')) {

    function parseHTML($str) {
        $str = str_replace('src="//', 'src="https://', $str);
        return $str;
    }

}

/**
 * [To get current datetime]
 */
if (!function_exists('datetime')) {

    function datetime($default_format = 'Y-m-d H:i:s') {
        $datetime = date($default_format);
        return $datetime;
    }

}

/**
 * [To convert date time format]
 * @param datetime $datetime
 * @param string $format
 */
if (!function_exists('convertDateTime')) {

    function convertDateTime($datetime, $format = 'd M Y h:i A') {
        $convertedDateTime = date($format, strtotime($datetime));
        return $convertedDateTime;
    }

}

/**
 * [To encode string]
 * @param string $str
 */
if (!function_exists('encoding')) {

    function encoding($str) {
        $one = serialize($str);
        $two = @gzcompress($one, 9);
        $three = addslashes($two);
        $four = base64_encode($three);
        $five = strtr($four, '+/=', '-_.');
        return $five;
    }

}

/**
 * [To decode string]
 * @param string $str
 */
if (!function_exists('decoding')) {

    function decoding($str) {
        $one = strtr($str, '-_.', '+/=');
        $two = base64_decode($one);
        $three = stripslashes($two);
        $four = @gzuncompress($three);
        if ($four == '') {
            return "z1";
        } else {
            $five = unserialize($four);
            return $five;
        }
    }

}
/**
 * [To generate random token]
 * @param string $length
 */
if (!function_exists('generateToken')) {

    function generateToken($length) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[crypto_rand_secure(0, $max)];
        }
        return $token;
    }

}

/**
 * [To check null value]
 * @param string $value
 */
if (!function_exists('null_checker')) {

    function null_checker($value, $custom = "") {
        $return = "";
        if ($value != "" && $value != NULL) {
            $return = ($value == "" || $value == NULL) ? $custom : $value;
            return $return;
        } else {
            return $return;
        }
    }

}

/**
 * [To get default image if file not exist]
 * @param  [string] $filename
 * @param  [string] $filepath
 */
if (!function_exists('display_image')) {

    function display_image($filename, $filepath) {
        /* Send image path last slash */
        $file_path_name = $filepath . $filename;
        if (!empty($filename) && @file_exists($file_path_name)) {
            return urlencode(base_url() . $file_path_name);
        } else {
            return urlencode(base_url() . DEFAULT_NO_IMG_PATH);
        }
    }

}

/**
 * [To delete file from directory]
 * @param  [string] $filename
 * @param  [string] $filepath
 */
if (!function_exists('unlink_file')) {

    function unlink_file($filename, $filepath) {
        /* Send file path last slash */
        $file_path_name = $filepath . $filename;
        if (!empty($filename) && @file_exists($file_path_name) && @unlink($file_path_name)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
/**
 * [To auto generate password]
 * @param  [string] $filename
 */
if (!function_exists('randomPassword')) {

    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ#@&!';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $pass[] = rand(1, 100);
        return implode($pass); //turn the array into a string
    }

}

/**
 * [To add point]
 */
if (!function_exists('all_points')) {

    function all_points($point = 5, $value = "") {
        $htm = "";
        for ($i = 1; $i <= $point; $i +=0.5) {
            $select = (!empty($value)) ? ($value == $i) ? "selected" : "" : "";
            $htm .= "<option value='" . $i . "' " . $select . ">" . $i . "</option>";
        }
        return $htm;
    }

}

/**
 * [To add point]
 */
if (!function_exists('search_exif')) {

    function search_exif($exif, $field, $val) {
        if (!empty($exif)) {
            foreach ($exif as $data) {
                if ($data->$field == $val) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

}

/**
 * [To add point]
 */
if (!function_exists('search_exif_return')) {

    function search_exif_return($exif, $field, $val) {
        if (!empty($exif)) {
            foreach ($exif as $key => $data) {
                if ($data->$field == $val) {
                    return $data->id;
                }
            }
        } else {
            return false;
        }
    }

}



/**
 * [To generate random string]
 */
if (!function_exists('generateRandomString')) {

    function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

}

/**
 * [Fantasy Icon]
 */
if (!function_exists('Icon')) {

    function Icon() {
       echo '<img width="18" src="'.base_url().CRICKET_ICON_COLOR.'" />';
    }

}

/**
 * [Fantasy Point Dynamic input]
 */
if (!function_exists('fantasyPointInput')) {

    function fantasyPointInput() {
       $inputField = array();
       $inputField['main']['starting_xi'] = "For being part of the Starting XI";
       $inputField['main']['run'] = "For every run scored";
       $inputField['main']['wicket_run_out'] = "Wicket (excluding run-out)";
       $inputField['main']['catch'] = "Catch";
       $inputField['main']['caught_bowled'] = "Caught & Bowled";
       $inputField['main']['stumping_run_out_direct'] = "Stumping / Run-out (direct)";
       $inputField['main']['run_out_thrower_catcher'] = "Run-out (thrower/catcher)";
       $inputField['main']['duck'] = "Dismissal for duck (batsmen, wicket-keeper and all-rounders)";
       
       $inputField['bonus']['every_fours'] = "Every boundary hit";
       $inputField['bonus']['every_six'] = "Every six hit";
       $inputField['bonus']['half_century'] = "Half century";
       $inputField['bonus']['century'] = "Century";
       $inputField['bonus']['maiden_over'] = "Maiden over";
       $inputField['bonus']['4_wickets'] = "4 wickets";
       $inputField['bonus']['5_wickets'] = "5 wickets";
       
       return $inputField;
    }

}

