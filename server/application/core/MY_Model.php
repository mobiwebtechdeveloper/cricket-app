<?php

//Developed by: Rajmander
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class My_model extends CI_Model {

    public $configCustomData = array();

    public function __construct() {
        parent::__construct();
        // set config custom data in array
        $this->configCustomData = $this->config->item('customData');
    }

    //Function for update
    public function customUpdate($options) {
        $table = false;
        $where = false;
        $orwhere = false;
        $data = false;

        extract($options);

        if (!empty($where)) {
            $this->db->where($where);
        }

        // using or condition in where  
        if (!empty($orwhere)) {
            $this->db->or_where($orwhere);
        }
        $this->db->update($table, $data);

        return $this->db->affected_rows();
    }

    //Function for delete
    public function customDelete($options) {
        $table = false;
        $where = false;
        $where_not_in = false;

        extract($options);

        if (!empty($where))
            $this->db->where($where);
        
        if ($where_not_in != false) {
            foreach ($where_not_in as $key => $win) {
                $this->db->where_not_in($key, $win);
            }
        }
        
        $this->db->delete($table);

        return $this->db->affected_rows();
    }

    //Function for insert
    public function customInsert($options) {
        $table = false;
        $data = false;

        extract($options);

        $this->db->insert($table, $data);

        return $this->db->insert_id();
    }

    //Function for get
    public function customGet($options) {

        $select = false;
        $table = false;
        $join = false;
        $order = false;
        $limit = false;
        $offset = false;
        $where = false;
        $or_where = false;
        $single = false;
        $group_by = false;
        $like = false;
        $where_in = false;
        $where_not_in = false;
        $between = false;

        extract($options);

        if ($select != false)
            $this->db->select($select);

        if ($table != false)
            $this->db->from($table);

        if ($where != false)
            $this->db->where($where);
        
        if ($between != false)
            $this->db->where($between);

        if ($or_where != false)
            $this->db->or_where($or_where);

        if ($where_in != false) {
            foreach ($where_in as $key => $win) {
                $this->db->where_in($key, $win);
            }
        }
        
        if ($where_not_in != false) {
            foreach ($where_not_in as $key => $win) {
                $this->db->where_not_in($key, $win);
            }
        }

        if ($limit != false) {

            if (!is_array($limit)) {
                $this->db->limit($limit);
            } else {
                foreach ($limit as $limitval => $offset) {
                    $this->db->limit($limitval, $offset);
                }
            }
        }

        if ($like != false)
            $this->db->like($like);

        if ($group_by != false) {

            $this->db->group_by($group_by);
        }


        if ($order != false) {

            if (is_array($order)) {
                foreach ($order as $key => $value) {

                    if (is_array($value)) {
                        foreach ($order as $orderby => $orderval) {
                            $this->db->order_by($orderby, $orderval);
                        }
                    } else {
                        $this->db->order_by($key, $value);
                    }
                }
            } else {
                $this->db->order_by($order);
            }
        }




        if ($join != false) {

            foreach ($join as $key => $value) {

                if (is_array($value)) {
                    if (count($value) == 3) {
                        $this->db->join($value[0], $value[1], $value[2]);
                    } else {
                        foreach ($value as $key1 => $value1) {
                            $this->db->join($key1, $value1);
                        }
                    }
                } else {
                    $this->db->join($key, $value);
                }
            }
        }


        $query = $this->db->get();

        if ($single) {
            return $query->row();
        }


        return $query->result();
    }

    public function customQuery($query, $single = false, $updDelete = false, $noReturn = false) {
        $query = $this->db->query($query);

        if ($single) {
            return $query->row();
        } elseif ($updDelete) {
            return $this->db->affected_rows();
        } elseif (!$noReturn) {
            return $query->result();
        } else {
            return true;
        }
    }

    public function customQueryCount($query) {
        return $this->db->query($query)->num_rows();
    }

    function customCount($options) {
        $table = false;
        $join = false;
        $order = false;
        $limit = false;
        $offset = false;
        $where = false;
        $or_where = false;
        $single = false;

        extract($options);

        if ($table != false)
            $this->db->from($table);

        if ($where != false)
            $this->db->where($where);

        if ($or_where != false)
            $this->db->or_where($or_where);

        if ($limit != false) {

            if (!is_array($limit)) {
                $this->db->limit($limit);
            } else {
                foreach ($limit as $limitval => $offset) {
                    $this->db->limit($limitval, $offset);
                }
            }
        }


        if ($order != false) {

            foreach ($order as $key => $value) {

                if (is_array($value)) {
                    foreach ($order as $orderby => $orderval) {
                        $this->db->order_by($orderby, $orderval);
                    }
                } else {
                    $this->db->order_by($key, $value);
                }
            }
        }


        if ($join != false) {

            foreach ($join as $key => $value) {

                if (is_array($value)) {
                    if (count($value) == 3) {
                        $this->db->join($value[0], $value[1], $value[2]);
                    } else {
                        foreach ($value as $key1 => $value1) {
                            $this->db->join($key1, $value1);
                        }
                    }
                } else {
                    $this->db->join($key, $value);
                }
            }
        }

        return $this->db->count_all_results();
    }

    //Send Mail 
    function customMail($data = false) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1'; // or utf-8 for html mail
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['wordwrap'] = TRUE;
        $config['validation'] = TRUE; // bool whether to validate email or not  
        $config['charset'] = "utf-8";

        $this->load->library('email', $config);

        if (!$data)
            return FALSE;

        $cc = '';

        if (isset($data['cc']) && (!empty($data['cc']))) {
            $cc = $data['cc'];
        }

        $this->email->from($this->configCustomData['verif_email'], $this->configCustomData['verif_name']);
        $this->email->to($data['toEmail']);
        $this->email->cc($cc);
        $this->email->subject($data['subject']);
        //$this->email->message('Testing the email class. <br /> TEST Again <br /> <h1> H1 Heading </h1>');
        $this->email->message($data['message'] . $data['body']);
        $status = (bool) $this->email->send();
        return $status;
    }

    function getData($tbl = null, $select = null, $con = null, $orderBy = null, $limit = null, $join = null, $between = null, $multiple = TRUE) {
//        pre($this->db->database);

        if ($select != null) {
            $this->db->select($select);
        } else {
            $this->db->select('*');
        }

        $this->db->from($tbl);

        if ($join != null) {
            foreach ($join as $j) {
                $type = 'inner';
                if (isset($j['type']))
                    $type = $j['type'];

                $this->db->join($j['table'], $j['relation'], $type);
            }
        }

        if ($con != null)
            $this->db->where($con);

        if ($between != null)
            $this->db->where($between);

        if ($orderBy != null) //$this->db->order_by('title desc, name asc'); 
            $this->db->order_by($orderBy);

        if ($limit != null) //$this->db->order_by('title desc, name asc'); 
            $this->db->limit($limit);

        $query = $this->db->get();
//        echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            if ($multiple) {
                return $query->result();
            } else {
                return $query->row();
            }
        } else
            return FALSE;
    }

    public function user_check($where = '', $select = '*') {
        if (empty($where)) {
            return FALSE;
        }

        return $this->db->select($select)->where($where)
                        ->order_by("users_id", "ASC")
                        ->limit(1)
                        ->get('users')->row();
    }

}
