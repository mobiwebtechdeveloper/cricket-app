<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/* application development all constants */

switch ($_SERVER['SERVER_NAME']) {
    case 'fantasy-cricket.mobi96.com':
        define('MW_DB_HOST', 'localhost');
        define('MW_DB_USERNAME', 'mobi96_fantasy-c');
        define('MW_DB_PASSWORD', 'szoqI9sG%te7');
        define('MW_DB_DATABASE_NAME', 'mobi96_fantasy-cricket');
        break;
    default:
        define('MW_DB_HOST', 'localhost');
        define('MW_DB_USERNAME', 'root');
        define('MW_DB_PASSWORD', 'root');
        define('MW_DB_DATABASE_NAME', 'mobi96_fantasy_cricket');
}
define('DIRECTOR_ROLE', 2);
define('THEME_COLOR', 'success'); // success, primary, info
define('THEME_BUTTON', 'btn btn-warning');
define('THEME', 'skin-3'); // skin-1, skin-2, skin-3
define('FROM_EMAIL', 'support@site.com');
define('SUPPORT_EMAIL', 'support@site.com');
define('SITE_NAME', 'Fantasy Cricket');
define('DEFAULT_USER_IMG', 'default-148.png');
define('DEFAULT_USER_IMG_PATH', 'backend_asset/images/default-148.png');
define('DEFAULT_NO_IMG', 'noimagefound.jpg');
define('DEFAULT_NO_IMG_PATH', 'backend_asset/images/no_image.jpg');
define('EDIT_ICON', 'backend_asset/images/edit1.png');
define('DELETE_ICON', 'backend_asset/images/delete.png');
define('ACTIVE_ICON', 'backend_asset/images/active.png');
define('INACTIVE_ICON', 'backend_asset/images/inactive.png');
define('VIEW_ICON', 'backend_asset/images/eye.png');
define('PASSWORD_ICON', 'backend_asset/images/key.png');
define('SITE_TITLE','Self Assessment');
define('COPYRIGHT','Self Assessment &copy; 2017-2018');
define('ADMIN_EMAIL', 'admin@site.com');
define('CRICKET_ICON', 'backend_asset/images/battsman-miss.png');
define('CRICKET_ICON_COLOR', 'backend_asset/images/cric.png');
/* IOS push notification */
define('APNS_GATEWAY_URL', 'ssl://gateway.push.apple.com:2195');
define('APNS_CERTIFICATE_PATH', '/third_party/site.certi.pem');

/* Android push notification */
define('ANDROID_SERVER_KEY', 'AIzaSyDEiGNYzs9FYa9M7L7u6dOTM9vtdukLTJg');
define('ANDROID_NOTIFICATION_URL', 'https://android.googleapis.com/gcm/send');

/* Messages constants */
define('GENERAL_ERROR', 'We are unable to process your request. Please contact customer support.');
define('EMAIL_SEND_FAILED', 'Failed to sending a mail');
define('NO_CHANGES', 'We didn`t find any changes');
define('USER_VERIFICATION', 'Currently your profile is not verified, please verfiy your email id');
define('BLOCK_USER', 'Your profile has been blocked. Please contact to our support team');
define('DEACTIVATE_USER', 'Currently your profile is deactivated. Please contact to our support team');

/* Database tables */
define("USERS", 'users');
define("SETTING", 'setting');
define('USERS_DEVICE_HISTORY', 'users_device_history');
define('COUNTRY', 'countries');
define('ADMIN_NOTIFICATIONS', 'admin_notifications');
define('NOTIFICATIONS','notifications');
define("GROUPS", 'groups');
define("USER_GROUPS", 'users_groups');
define("ORGANIZATION", 'organization');
define("HIERARCHY", 'hierarchy');
define("ASSESSMENT_CATEGORY", 'category');
define("ASSESSMENT", 'assessment');
define("HIERARCHY_ROLE_ORDER", 'hierarchy_role_order');
define("QUESTIONS", 'questions');
define("QUESTIONS_OPTION", 'questions_option');
define("ASS_CATEGORY", 'assessment_category');
define("USER_ASSESSMENT", 'user_assessment');
define("USER_ASSESSMENT_QUESTION", 'user_assessment_question');
define("CMS", 'cms');
define("CONTACTS", 'contacts');
define("USER_HIERARCHY", 'user_hierarchy');
define("USER_ASSESSMENT_QUESTION_SUBMISSION", 'assessment_submission');
define("DAILY_ASSESSMENT_SUBMISSION", 'daily_assessment_submission');
define("MATCHES", 'matches');
define("MATCH_PLAYER", 'match_player');
define("PLAYERS", 'players');
define("CONTEST", 'contest');
define("CONTEST_MATCHES", 'contest_matches');
define("CONTEST_DETAILS", 'contest_details');

/* Admin fee percentage */
define('FEE_PERCENT' ,'10');
