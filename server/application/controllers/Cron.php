<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as cron management
 * @package   CodeIgniter
 * @category  Controller
 * @author    MobiwebTech Team
 */
class Cron extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('UTC');
    }

    /**
     * Function Name: update_match
     * Description:   To update match status after change date
     */
    public function update_match() {
        $sql = 'UPDATE matches SET status = "closed" WHERE match_date < CURDATE()';
        $this->db->query($sql);
    }

    /**
     * Function Name: delete_notifications
     * Description:   To Delete 30 Days Old Notifications
     */
    public function delete_notifications() {
        $sql = 'DELETE FROM ' . NOTIFICATIONS . ' WHERE sent_time + INTERVAL 30 DAY <= NOW()';
        $this->db->query($sql);
    }

    /**
     * Function Name: send_notifications
     * Description:   To Send Admin Notifications
     */
    public function send_notifications() {
        ini_set('max_execution_time', 1800); // 30 minutes

        /* Get notification request */
        $request = $this->common_model->getsingle(ADMIN_NOTIFICATIONS, array('status' => 'PENDING'));
        if (!empty($request)) {
            $where = array('is_verified' => 1, 'is_blocked' => 0, 'is_deactivated' => 0, 'is_logged_out' => 0, 'user_type' => 'NORMAL_USER', 'id >' => $request->last_user_id);
            $users = $this->common_model->getAllwhere(USERS, $where, 'id', 'ASC', '', 50);
            if (!empty($users)) {

                /* Get admin details */
                $admin_details = $this->common_model->getsingle(USERS, array('email' => ADMIN_EMAIL));

                /* To get total users */
                $total_users = count($users);

                /* Send notifications */
                $i = 1;
                foreach ($users as $u) {
                    $devices = $this->common_model->getAllwhere(USERS_DEVICE_HISTORY, array('user_id' => $u->id));
                    if (!empty($devices)) {
                        /* To update user badges */
                        $device_badges = (int) $u->badges + 1;
                        $this->common_model->updateFields(USERS, array('badges' => $device_badges), array('id' => $u->id));

                        foreach ($devices as $d) {
                            if (!empty($d->device_token) && !empty($d->device_type)) {
                                $device_token = $d->device_token;
                                $message = $request->message;
                                $params = array('notification_type' => 'admin_notification');
                                $device_badges = $u->badges;
                                if ($d->device_type == 'ANDROID') {
                                    $noti_data = array('body' => $message, 'title' => $request->title, 'params' => $params);
                                    send_android_notification($noti_data, $device_token, $device_badges);
                                } else {
                                    send_ios_notification($device_token, $message, $params, $device_badges);
                                }
                            }
                        }
                    }
                    if ($i++ == $total_users) {
                        /* update notification request last user id */
                        $this->common_model->updateFields(ADMIN_NOTIFICATIONS, array('last_user_id' => $u->id), array('id' => $request->id));
                    }

                    /* To send notification details */
                    save_notification($u->id, $admin_details->id, 'admin_notification', $message);
                }
            } else {

                /* update notification request status */
                $this->common_model->updateFields(ADMIN_NOTIFICATIONS, array('status' => 'COMPLETED'), array('id' => $request->id));
            }
        }
    }

}

/* End of file Cron.php */
/* Location: ./application/controllers/Cron.php */
?>