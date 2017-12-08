<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Custom Helper
* Author: Sorav Garg
* Author Email: soravgarg123@gmail.com
* version: 1.0
*/

/**
 * [To print array]
 * @param array $arr
*/
if ( ! function_exists('pr')) {
  function pr($arr)
  {
    echo '<pre>'; 
    print_r($arr);
    echo '</pre>';
    die;
  }
}

/**
 * [To print last query]
*/
if ( ! function_exists('lq')) {
  function lq()
  {
    $CI = & get_instance();
    echo $CI->db->last_query();
    die;
  }
}

/**
 * [To get database error message]
*/
if ( ! function_exists('db_err_msg')) {
  function db_err_msg()
  {
    $CI = & get_instance();
    $error = $CI->db->error();
    if(isset($error['message']) && !empty($error['message'])){
      return 'Database error - '.$error['message'];
    }else{
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
 * [To create directory]
 * @param string $folder_path
*/
if (!function_exists('make_directory')) {
  function make_directory($folder_path) {
    if (!file_exists($folder_path)) {
        mkdir($folder_path, 0777, true);
    }
  }
}

/**
* [To save notifications]
* @param  [int] $user_id
* @param  [int] $sender_id
* @param  [string] $noti_type
* @param  [string] $message
* @param  [string] $params
*/
if(! function_exists('save_notification')){
  function save_notification($user_id,$sender_id,$noti_type,$message,$params = array()){
    $CI = & get_instance();
      $notification_arr = array(
                    'user_id'          => $user_id,
                    'sender_id'        => $sender_id,
                    'noti_type'        => $noti_type,
                    'message'          => $message,
                    'params'           => (!empty($params)) ? serialize($params) : '',
                    'sent_time'        => datetime()
                  );
      $lid = $CI->common_model->insertData(NOTIFICATIONS,$notification_arr);
      if($lid)
      {
        return TRUE;
      }else{
        return FALSE;
      }
  }
}

/**
 * [To send push notifications]
 * @param string $msg
 * @param int $user_id
 * @param array $params
*/
if ( ! function_exists('send_push_notifications')) {
  function send_push_notifications($msg,$user_id,$params)
  {
    $CI = & get_instance();

    /*  To Get Friend Details  */
    $friend_details = $CI->common_model->getsingle(USERS,array('id' => $user_id));
    if(!empty($friend_details) && $friend_details->is_blocked == 0 && $friend_details->is_deactivated == 0 && $friend_details->is_logged_out == 0){

      /* Get Friends Device History */
      $device_history = $CI->common_model->getAllwhere(USERS_DEVICE_HISTORY,array('user_id' => $user_id));
      if(!empty($device_history))
      {
        /* To update user badges */
        $device_badges = (int) $friend_details->badges + 1;
        $CI->common_model->updateFields(USERS, array('badges' => $device_badges), array('id' => $user_id));

        /* Send notification to all devices */
        foreach($device_history as $dh)
        {
          $device_token   = $dh->device_token;
          $device_type    = $dh->device_type;

          if(!empty($device_token) && !empty($device_type))
          {
            /* Send IOS notifications */
            if($device_type == "IOS"){
                send_ios_notification($device_token,$msg,$params,$device_badges);
            }

             /* Send Android notifications */
            if($device_type == "ANDROID"){
                $noti_data = array('body' => $msg,'params' => $params);
                send_android_notification($noti_data,$device_token,$device_badges);
            }
          }
        }
      }
      else
      {
        /* To update user badges */
        $device_badges = (int) $friend_details->badges + 1;
        $CI->common_model->updateFields(USERS, array('badges' => $device_badges), array('id' => $user_id));

          $device_token   = $friend_details->device_token;
          $device_type    = $friend_details->device_type;

          if(!empty($device_token) && !empty($device_type))
          {
            /* Send IOS notifications */
            if($device_type == "IOS"){
                send_ios_notification($device_token,$msg,$params,$device_badges);
            }

            /* Send Android notifications */
            if($device_type == "ANDROID"){
                $noti_data = array('body' => $msg,'params' => $params);
                send_android_notification($noti_data,$device_token,$device_badges);
            }
          }
      }
    }
  }
}

/**
 * [To get data row count]
 * @param string $table
 * @param array $where
*/
if ( ! function_exists('getAllCount')) {
  function getAllCount($table,$where="")
  {
    $CI = & get_instance();
    if(!empty($where)){
      $CI->db->where($where);
    }
    $q = $CI->db->count_all_results($table);
    return addZero($q);
  }
}

/**
 * [To get previous dates]
 * @param int $no_of_days
*/
if ( ! function_exists('get_previous_dates')) {
  function get_previous_dates($no_of_days)
  {
    $dates_arr = array(); 
    $timestamp = time();
    for ($i = 0 ; $i < (int) $no_of_days ; $i++) {
        $dates_arr[] = date('Y-m-d', $timestamp);
        $timestamp -= 24 * 3600;
    }
    return $dates_arr;
  }
}

/**
 * [To print number in standard format with 0 prefix]
 * @param int $no
*/
if ( ! function_exists('addZero')) {
  function addZero($no)
  {
    if($no >= 10){
      return $no;
    }else{
      return "0".$no;
    }
  }
}

/**
 * [To get current datetime]
*/
if ( ! function_exists('datetime')) {
  function datetime($default_format='Y-m-d H:i:s')
  {
    $datetime = date($default_format);
    return $datetime;
  }
}

/**
 * [To sort multi-dimensional array]
 * @param array $response
 * @param string $column
 * @param string $type
*/
if ( ! function_exists('sortarr')) {
  function sortarr($response,$column,$type)
  {
    $arr =array();
    foreach ($response as $r) {
      $arr[] = $r->$column; // In Object
    }
    if($type == 'ASC'){
      array_multisort($arr,SORT_ASC,$response);
    }else{
      array_multisort($arr,SORT_DESC,$response);
    }
    return $response;
  }
}

/**
 * [To convert date time format]
 * @param datetime $datetime
 * @param string $format
*/
if ( ! function_exists('convertDateTime')) {
  function convertDateTime($datetime,$format='d F Y, h:i A')
  {
    $convertedDateTime = date($format,strtotime($datetime));
    return $convertedDateTime;
  }
}


/**
 * [To encode string]
 * @param string $str
*/
if ( ! function_exists('encoding')) {
  function encoding($str){
      $one = serialize($str);
      $two = @gzcompress($one,9);
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
if ( ! function_exists('decoding')) {
  function decoding($str){
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
 * [To export csv file from array]
 * @param string $fileName
 * @param array $assocDataArray
 * @param array $headingArr
*/
if ( ! function_exists('exportCSV')) {
  function exportCSV($fileName,$assocDataArray,$headingArr)
  {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$fileName);
    $output = fopen('php://output', 'w');
    fputcsv($output, $headingArr);
    foreach ($assocDataArray as $key => $value) {
        fputcsv($output, $value);
    }
     exit;
  }
}

/**
 * [To check number is digit or not]
 * @param int $element
*/
if ( ! function_exists('is_digits')) {
  function is_digits($element){ // for check numeric no without decimal
      return !preg_match ("/[^0-9]/", $element);
  }
}

/**
 * [To get all months list]
*/
if ( ! function_exists('getMonths')) {
  function getMonths(){
    $monthArr = array('January','February','March','April','May','June','July','August','September','October','November','December');
    return $monthArr ;
  }
}

/**
 * [To upload all files]
 * @param string $subfolder
 * @param string $ext
 * @param int $size
 * @param int $width
 * @param int $height
 * @param string $filename
*/
if ( ! function_exists('fileUploading')) {
  function fileUploading($subfolder,$ext,$size="",$width="",$height="",$filename)
  {
      $CI = & get_instance();
      $config['upload_path']   = 'uploads/'.$subfolder.'/'; 
      $config['allowed_types'] = $ext; 
      if($size){
        $config['max_size']   = 100; 
      }
      if($width){
        $config['max_width']  = 1024; 
      }
      if($height){
        $config['max_height'] = 768;  
      }
      $CI->load->library('upload', $config);
      if (!$CI->upload->do_upload($filename)) {
        $error = array('error' => strip_tags($CI->upload->display_errors())); 
        return $error;
      }
     else { 
        $data = array('upload_data' => $CI->upload->data()); 
        return $data;
     } 
  }
}

/**
 * [To check autorized user]
 * @param string $return_uri
*/
if ( ! function_exists('is_logged_in')) {
  function is_logged_in($return_uri = '') {
      $ci =&get_instance();
    $user_login = $ci->session->userdata('user_id');
    if(!isset($user_login) || $user_login != true) {
      if($return_uri) {
        $ci->session->set_flashdata('blog_token',time());
        redirect('?return_uri='.urlencode(base_url().$return_uri));  
      } else {
        $ci->session->set_flashdata('blog_token',time());
        redirect("/");  
      }   
    }   
  }
}

/**
 * [To excecute CURL]
 * @param string $Url
 * @param array $jsondata
 * @param array $post
 * @param array $headerData
*/
if (!function_exists('ExecuteCurl'))
{

    function ExecuteCurl($url, $jsondata = '', $post = '', $headerData = [])
    {
        $ch = curl_init();
        $headers = array('Accept: application/json', 'Content-Type: application/json');
        if (!empty($headerData) && is_array($headerData))
        {
            foreach ($headerData as $key => $value)
            {
                $headers[$key] = $value;
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($jsondata != '')
        {
            curl_setopt($ch, CURLOPT_POST, count($jsondata));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata);
        }

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 50);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        if ($post != '')
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $post);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}

/**
 * [To send mail]
 * @param string $from
 * @param string $to
 * @param string $subject
 * @param string $message
*/
if ( ! function_exists('send_mail')) {
  function send_mail($message,$subject,$to_email,$from_email="",$attach="")
  {
      $ci = &get_instance();
      $config['mailtype'] = 'html';
      $ci->email->initialize($config);
      if(!empty($from_email)){
        $ci->email->from($from_email,SITE_NAME);
      }else{
        $ci->email->from(FROM_EMAIL,SITE_NAME);
      }
      $ci->email->to($to_email);
      $ci->email->subject($subject);
      $ci->email->message($message);
      if(!empty($attach))
      {
        $ci->email->attach($attach);
      }
      if($ci->email->send()) {  
        return true;
      } else {
        return false;
      }
  }
}

/**
 * extract_value
 * @return string
 */
if (!function_exists('extract_value'))
{

    function extract_value($array, $key, $default = "")
    {
        $CI = & get_instance();
        if(isset($array[$key])){
          return @trim(strip_tags($array[$key]));
        }else{
          return @trim($default);
        }
    }

}

if (!function_exists('allModules')) {

        function allModules($data = NULL) {
            $modules = array(
                'about' => "About Us",
                'contact' => "Contact Us",
                'terms_condition' => "Terms and condition",
                'FAQs' => "FAQs",
                'privacy_policy' => "Privacy Policy"
            );
            if ($data != NULL)
                return $modules[$data];
            else
                return $modules;
        }

    }

if ( ! function_exists('crypto_rand_secure')) {
  function crypto_rand_secure($min, $max) 
  {
      $range = $max - $min;
      if ($range < 1) return $min;
      $log = ceil(log($range, 2));
      $bytes = (int) ($log / 8) + 1;
      $bits = (int) $log + 1;
      $filter = (int) (1 << $bits) - 1;
      do {
          $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
          $rnd = $rnd & $filter;
      } while ($rnd >= $range);
      return $min + $rnd;
  }
}

/**
 * [To generate random token]
 * @param string $length
*/
if ( ! function_exists('generateToken')) {
  function generateToken($length) 
  {
      $token = "";
      $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
      $codeAlphabet.= "0123456789";
      $max = strlen($codeAlphabet) - 1;
      for ($i=0; $i < $length; $i++) {
          $token .= $codeAlphabet[crypto_rand_secure(0, $max)];
      }
      return $token;
  }
}

/**
 * [To get live videos thumb Youtube,Vimeo]
 * @param string $videoString
*/
if ( ! function_exists('getVideoThumb')) {
  function getVideoThumb($videoString = null){
      // return data
      $videos = array();
      if (!empty($videoString)) {
          // split on line breaks
          $videoString = stripslashes(trim($videoString));
          $videoString = explode("\n", $videoString);
          $videoString = array_filter($videoString, 'trim');
          // check each video for proper formatting
          foreach ($videoString as $video) {
              // check for iframe to get the video url
              if (strpos($video, 'iframe') !== FALSE) {
                  // retrieve the video url
                  $anchorRegex = '/src="(.*)?"/isU';
                  $results = array();
                  if (preg_match($anchorRegex, $video, $results)) {
                      $link = trim($results[1]);
                  }
              } else {
                  // we already have a url
                  $link = $video;
              }
              // if we have a URL, parse it down
              if (!empty($link)) {
                  // initial values
                  $video_id = NULL;
                  $videoIdRegex = NULL;
                  $results = array();
                  // check for type of youtube link
                  if (strpos($link, 'youtu') !== FALSE) {
                      if (strpos($link, 'youtube.com') !== FALSE) {
                          // works on:
                          // http://www.youtube.com/embed/VIDEOID
                          // http://www.youtube.com/embed/VIDEOID?modestbranding=1&amp;rel=0
                          // http://www.youtube.com/v/VIDEO-ID?fs=1&amp;hl=en_US
                          $videoIdRegex = '/youtube.com\/(?:embed|v){1}\/([a-zA-Z0-9_]+)\??/i';
                      } else if (strpos($link, 'youtu.be') !== FALSE) {
                          // works on:
                          // http://youtu.be/daro6K6mym8
                          $videoIdRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
                      }
                      if ($videoIdRegex !== NULL) {
                          if (preg_match($videoIdRegex, $link, $results)) {
                              $video_str = 'http://www.youtube.com/v/%s?fs=1&amp;autoplay=1';
                              $thumbnail_str = 'http://img.youtube.com/vi/%s/2.jpg';
                              $fullsize_str = 'http://img.youtube.com/vi/%s/0.jpg';
                              $video_id = $results[1];
                          }
                      }
                  }
                  // handle vimeo videos
                  else if (strpos($video, 'vimeo') !== FALSE) {
                      if (strpos($video, 'player.vimeo.com') !== FALSE) {
                          // works on:
                          // http://player.vimeo.com/video/37985580?title=0&amp;byline=0&amp;portrait=0
                          $videoIdRegex = '/player.vimeo.com\/video\/([0-9]+)\??/i';
                      } else {
                          // works on:
                          // http://vimeo.com/37985580
                          $videoIdRegex = '/vimeo.com\/([0-9]+)\??/i';
                      }
                      if ($videoIdRegex !== NULL) {
                          if (preg_match($videoIdRegex, $link, $results)) {
                              $video_id = $results[1];
                              // get the thumbnail
                              try {
                                  $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
                                  if (!empty($hash) && is_array($hash)) {
                                      $video_str = 'http://vimeo.com/moogaloop.swf?clip_id=%s';
                                      $thumbnail_str = $hash[0]['thumbnail_small'];
                                      $fullsize_str = $hash[0]['thumbnail_large'];
                                  } else {
                                      // don't use, couldn't find what we need
                                      unset($video_id);
                                  }
                              } catch (Exception $e) {
                                  unset($video_id);
                              }
                          }
                      }
                  }
                  // check if we have a video id, if so, add the video metadata
                  if (!empty($video_id)) {
                      // add to return
                      $videos[] = array(
                          'url' => sprintf($video_str, $video_id),
                          'thumbnail' => sprintf($thumbnail_str, $video_id),
                          'fullsize' => sprintf($fullsize_str, $video_id)
                      );
                  }
              }
          }
      }
      // return array of parsed videos
      return $videos;
  }
}

if ( ! function_exists('getVimeoVideoIdFromUrl')) {
  function getVimeoVideoIdFromUrl($url = '') {
      $regs = array();
      $id = '';
      if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs)) {
          $id = $regs[3];
      }
      return $id;
  }
}

/**
 * [To get embedded live video url]
 * @param string $url
 * @param string $type
*/
if ( ! function_exists('parseLiveVideo')) {
  function parseLiveVideo($url,$type = 'youtube') {
    $parsedURL = '';
    switch ($type) {
      case 'youtube':
        $parsedURL = str_replace('watch?v=', 'embed/', $url);
        break;
      case 'vimeo':
        $vid  = getVimeoVideoIdFromUrl($url);
        $parsedURL = 'https://player.vimeo.com/video/'.$vid;
        break;
      default:
        $parsedURL = '';
        break;
    }
    return $parsedURL;
  }
}

/**
 * [To export DOC file]
 * @param string $html
 * @param string $filename
*/
if ( ! function_exists('exportDOCFile')) {
  function exportDOCFile($html,$filename = ''){
    $$filename = (!empty($filename)) ? $filename : 'document';
    header("Content-type: application/vnd.ms-word");
    header("Content-Disposition: attachment;Filename=".$filename.".doc");
    echo $html;
  }
}

/**
 * [To get user ip address]
*/
if (!function_exists('getRealIpAddr'))
{
    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip = $_SERVER['REMOTE_ADDR']; //'103.15.66.178';//
        }
        return $ip;
    }
}

/**
 * [Create GUID]
 * @return string
 */
if (!function_exists('get_guid'))
{
    function get_guid()
    {
        if (function_exists('com_create_guid'))
        {
            return strtolower(com_create_guid());
        }
        else
        {
            mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = substr($charid, 0, 8) . $hyphen
                    . substr($charid, 8, 4) . $hyphen
                    . substr($charid, 12, 4) . $hyphen
                    . substr($charid, 16, 4) . $hyphen
                    . substr($charid, 20, 12);
            return strtolower($uuid);
        }
    }
}

/**
 * [get_domain Get domin based on given url]
 * @param  string $url
 */
if ( ! function_exists('get_domain')) 
{ 
    function get_domain($url)
    {
      $pieces = parse_url($url);
      $domain = isset($pieces['host']) ? $pieces['host'] : '';
      if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
      }
      return false;
    }
}

/**
 * [to check url is 404 or not]
 * @param  string $url
 */
if ( ! function_exists('get_domain')) 
{ 
  function is_404($url) {
      $handle = curl_init($url);
      curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

      /* Get the HTML or whatever is linked in $url. */
      $response = curl_exec($handle);

      /* Check for 404 (file not found). */
      $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
      curl_close($handle);

      /* If the document has loaded successfully without any redirection or error */
      if ($httpCode >= 200 && $httpCode < 300) {
          return false;
      } else {
          return true;
      }
  }
}

/**
 * [get_ip_location_details Get location details based on given IP Address]
 * @param  [string] $ip_address [IP Adress]
 * @return [array]           [location details]
 */
if ( ! function_exists('get_ip_location_details')) 
{    
    function get_ip_location_details($ip_address) 
    {
        $url = "http://api.ipinfodb.com/v3/ip-city/?key=" . IPINFODBKEY . "&ip=" . $ip_address . "&timezone=true&format=json";
        $location_data = json_decode(ExecuteCurl($url), true);
        return $location_data;
    }
}

/**
* [geocoding_location_details Get location details based on given geo coordinate]
* @param  [string] $latitude  [latitude]
* @param  [string] $longitude [longitude]
* @return [array]            [location details]
*/
if(!function_exists('geocoding_location_details'))
{    
    function geocoding_location_details($latitude, $longitude)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$latitude.",".$longitude;
        $details = json_decode(file_get_contents($url));
        return $details;
    }
}

/**
* [To Format Bytes]
* @param  [integer] $bytes
*/
if (!function_exists('formatSizeUnits'))
{
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = NumberFormat($bytes / 1073741824) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = NumberFormat($bytes / 1048576) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = NumberFormat($bytes / 1024) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = NumberFormat($bytes) . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = NumberFormat($bytes) . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}

/**
* [To Get offset using page no, limit]
* @param  [integer] $PageNo
* @param  [integer] $Limit
*/
if (!function_exists('getOffset'))
{
    function getOffset($PageNo, $Limit)
    {
        if (empty($PageNo))
        {
            $PageNo = 1;
        }
        $offset = ($PageNo - 1) * $Limit;
        return $offset;
    }
}

/**
* [To create seo friendly string]
* @param  [string] $str
*/
if (!function_exists('get_seo_url'))
{
  function get_seo_url($str){
    if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
    $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
    $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
    $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
    $str = strtolower( trim($str, '-') );
    return $str;
  }
}

/**
* [To save user devices history]
* @param  [int] $user_id
* @param  [string] $device_token
* @param  [string] $device_type
* @param  [string] $device_id
*/
if (!function_exists('save_user_device_history'))
{
  function save_user_device_history($user_id,$device_token,$device_type,$device_id){
    $CI = & get_instance();

    /* Check device details already exist or not */
    $device_arr = array(
                    'device_id'   => $device_id,
                    'device_type' => $device_type
                  );
    $status = $CI->common_model->getsingle(USERS_DEVICE_HISTORY,$device_arr);
    if(empty($status)){
      /* Insert device history */
      $device_arr['user_id']      = $user_id;// Used to send push notifications
      $device_arr['device_token'] = $device_token;// Used to send push notifications
      $device_arr['added_date']   = datetime();
      $lid = $CI->common_model->insertData(USERS_DEVICE_HISTORY,$device_arr);
      if($lid){
        return TRUE;
      }else{
        return FALSE;
      }
    }else{
      $CI->common_model->updateFields(USERS_DEVICE_HISTORY,array('user_id' => $user_id,'device_token' => $device_token),array('id' => $status->id));
    }
  }
}

/**
* [To upload files using core php]
* @param  [string] $name
* @param  [string] $subfolder
*/
function corefileUploading($name,$subfolder){    
  $f_name1 = $_FILES[$name]['name'];    
  $f_tmp1  = $_FILES[$name]['tmp_name'];    
  $f_size1 = $_FILES[$name]['size'];    
  $f_extension1 = explode('.',$f_name1);     
  $f_extension1 = strtolower(end($f_extension1));    
  $f_newfile1="";    
  if($f_name1){      
    $f_newfile1 = rand()."-".SITE_NAME."-".time().'.'.$f_extension1;      
    $store1 = "uploads/".$subfolder."/". urlencode($f_newfile1);     
    if(move_uploaded_file($f_tmp1,$store1)){        
      chmod($store1, 0777);       
      return $store1;     
    }else{       
      return "";      
    }
  }else{
    return "";    
  }    
}

if (!function_exists('fileUpload')) {

    function fileUpload($filename, $subfolder, $ext, $size = "", $width = "", $height = "") {
        $CI = & get_instance();
        $config['upload_path'] = 'uploads/' . $subfolder . '/';
        $config['allowed_types'] = $ext;
        if ($size) {
            $config['max_size'] = 10000;
        }
        if ($width) {
            $config['max_width'] = 102400;
        }
        if ($height) {
            $config['max_height'] = 76800;
        }
        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);
        if (!$CI->upload->do_upload($filename)) {
            $error = array('error' => $CI->upload->display_errors());
            return $error;
        } else {
            $data = array('upload_data' => $CI->upload->data());
            return $data;
        }
    }

}
/**
 * [To check null value]
 * @param string $value
*/
if ( ! function_exists('null_checker')) {
  function null_checker($value,$custom="")
  {
    $return = "";
    if($value != "" && $value != NULL){
      $return = ($value == "" || $value == NULL) ? $custom : $value;
      return $return;
    }else{
      return $return;
    }
  }
}

/**
* [To get user image thumb]
* @param  [string] $filepath
* @param  [string] $subfolder
* @param  [int] $width
* @param  [int] $height
* @param  [int] $min_width
* @param  [int] $min_height
*/
if (!function_exists('get_image_thumb'))
{
  function get_image_thumb($filepath,$subfolder,$width,$height,$min_width="",$min_height="")
  {

    if(empty($min_width))
    {
      $min_width = $width;
    }
    if(empty($min_height))
    {
      $min_height = $height;
    }
    /* To get image sizes */
    $image_sizes = getimagesize($filepath);
    if(!empty($image_sizes))
    {
      $img_width  = $image_sizes[0];
      $img_height = $image_sizes[1];
      if($img_width <= $min_width && $img_height <= $min_height)
      {
        return $filepath;
      }
    }

    $ci   = &get_instance();
    /* Get file info using file path */
    $file_info = pathinfo($filepath);
    if(!empty($file_info)){
      $filename = $file_info['basename'];
      $ext      = $file_info['extension'];
      $dirname  = $file_info['dirname'].'/';
      $path     = $dirname.$filename;
      $file_status = @file_exists($path);
      if($file_status){
          $config['image_library']  = 'gd2';
          $config['source_image']   = $path;
          $config['create_thumb']   = TRUE;
          $config['maintain_ratio'] = TRUE;
          $config['width']          = $width;
          $config['height']         = $height;
          $ci->load->library('image_lib', $config);
          $ci->image_lib->initialize($config);
          if(!$ci->image_lib->resize()) {
              return $path;
          } else {
            @chmod($path, 0777);
            $thumbnail = preg_replace('/(\.\w+)$/im', '', urlencode($filename)) . '_thumb.' . $ext;
              return 'uploads/'.$subfolder.'/'.$thumbnail;
          }
      }else{
        return $filepath;
      }
    }else{
      return $filepath;
    }
  }
}

/**
* [To get default image if file not exist]
* @param  [string] $filename
* @param  [string] $filepath
*/
if (!function_exists('display_image'))
{
  function display_image($filename,$filepath)
  {
    /* Send image path last slash */
    $file_path_name = $filepath.$filename;
    if(!empty($filename) && @file_exists($file_path_name)){
      return base_url().$filepath.urlencode($filename);
    }else{
      return base_url().'assets/img/'.urlencode(DEFAULT_NO_IMG);
    }
  }
}

/**
* [To delete file from directory]
* @param  [string] $filename
* @param  [string] $filepath
*/
if (!function_exists('delete_file'))
{
  function delete_file($filename,$filepath)
  {
    /* Send file path last slash */
    $file_path_name = $filepath.$filename;
    if(!empty($filename) && @file_exists($file_path_name) && @unlink($file_path_name)){
      return TRUE;
    }else{
      return FALSE;
    }
  }
}

/**
* [To get all dates betweeb start date & end date]
* @param  [string] $strDateFrom
* @param  [string] $strDateTo
*/
if (!function_exists('get_date_range'))
{
  function get_date_range($strDateFrom,$strDateTo)
  {
      $aryRange=array();

      $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
      $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

      if ($iDateTo>=$iDateFrom)
      {
          array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
          while ($iDateFrom<$iDateTo)
          {
              $iDateFrom+=86400; // add 24 hours
              array_push($aryRange,date('Y-m-d',$iDateFrom));
          }
      }
      return $aryRange;
  }
}

/**
* [To get ordinal of particular number]
* @param  [int] $number
*/
if(!function_exists('ordinal'))
{
  function ordinal($number) {
      $ends = array('th','st','nd','rd','th','th','th','th','th','th');
      if ((($number % 100) >= 11) && (($number%100) <= 13))
          return $number. 'th';
      else
          return $number. $ends[$number % 10];
  }
}

/**
* [To get time ago string]
* @param  [datetime] $datetime
*/
if(!function_exists('time_ago'))
{
  function time_ago($datetime, $full = false)
  {
      $now     = new DateTime;
      $ago     = new DateTime($datetime);
      $diff    = $now->diff($ago);
      $diff->w = floor($diff->d / 7);
      $diff->d -= $diff->w * 7;
      
      $string = array(
          'y' => 'year',
          'm' => 'month',
          'w' => 'week',
          'd' => 'day',
          'h' => 'hour',
          'i' => 'minute',
          's' => 'second'
      );
      foreach ($string as $k => &$v) {
          if ($diff->$k) {
              $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
          } else {
              unset($string[$k]);
          }
      }
      
      if (!$full)
          $string = array_slice($string, 0, 1);
      return $string ? implode(', ', $string) . ' ago' : 'just now';
  }
}

/**
* [To save file from another server to own server]
* @param  [string] $file
* @param  [string] $subfolder
*/
if(!function_exists('save_file_from_server'))
{
  function save_file_from_server($file,$subfolder)
  {
    $explode_file = explode(".", $file);
    if(!empty($explode_file) && !is_404($file)){
      $ext      = end($explode_file);
      $pic      = file_get_contents($file);
      $filename = time().uniqid().'.'.$ext;
      $path     = 'uploads/'.$subfolder."/".$filename;
      file_put_contents($path, $pic);
      chmod($path, 0777);
      return $filename;
    }else{
      return DEFAULT_NO_IMG_PATH;
    }
  }
}

/* End of file custom_helper.php */
/* Location: ./system/application/helpers/custom_helper.php */

?>