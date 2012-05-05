<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Miowl_model extends CI_Model {

    /*******************************************************************
     * PRIVATE VARS
     *******************************************************************/

    private $extend_error = NULL;

    private $units = array
                      (
                       "year"   => 29030400, // seconds in a year   (12 months)
                       "month"  => 2419200,  // seconds in a month  (4 weeks)
                       "week"   => 604800,   // seconds in a week   (7 days)
                       "day"    => 86400,    // seconds in a day    (24 hours)
                       "hour"   => 3600,     // seconds in an hour  (60 minutes)
                       "minute" => 60,       // seconds in a minute (60 seconds)
                       "second" => 1         // 1 second
                      );

    //------------------------------------------------------------------


    /*******************************************************************
     * PUBLIC FUNCTIONS
     *******************************************************************/

    /**
     * public get_owl_members()
     */
    public function get_owl_members($owl_id = FALSE, $inclue_inactive = FALSE)
    {
        if (!$owl_id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('user_owl_id', $owl_id);

        if (!$inclue_inactive)
            $this->db->where('user_owl_verified', 'false');

        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_image()
     */
    public function get_image($id = FALSE)
    {
        if (!$id)
            return FALSE;

        $this->db->select('id, upload_time, upload_user, upload_path, upload_keep_duration, upload_visible, upload_password');
        $this->db->where('id', $id);
        $query = $this->db->get('uploads');

        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_last_public()
     */
    public function get_last_public()
    {
        $this->db->select('id, upload_time, upload_user, upload_path');
        $this->db->order_by("upload_time", "desc");
        $query = $this->db->get_where('uploads', array('upload_visible' => 'public'), 5, 0);

        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public function remove_upload()
     */
    public function remove_upload($id = FALSE, $user = FALSE)
    {
        if(!$id || !$user)
        {
            $this->extend_error = "ID or Length is NULL";
            return FALSE;
        }

        $this->db->set('upload_keep_duration', 0);
        $where = array(
            'upload_user'     => $user,
            'id'             => $id
        );
        $this->db->where($where);
        $this->db->update('uploads');

        if ($this->db->affected_rows() > 0)
            return TRUE;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public function extend_upload()
     * @param id             This is the id of the drop you want to extend.
     * @param length         This is the length in days to be added to the extend time.
     * @return bool         True if it has worked, False if failed.
     * @see extend_error     This will return the error if any set when extending.
     */
    public function extend_upload($id = FALSE, $length = FALSE, $user = FALSE, $admin = FALSE)
    {
        if(!$id || !$length || !$user)
        {
            $this->extend_error = "ID or Length or Username is NULL";
            return FALSE;
        }

        // Convert the lengh from days into unix time
        $amount     = (int)$this->units["day"];
        $amount_h     = (int)$this->units["hour"];

        if ($length == 0.5)
            $length = $amount_h * 12;
        else
            $length = $amount * $length;

        // Used by SQL
        $where = array(
            'upload_user'     => $user,
            'id'             => $id
        );

        // Extend the upload
        $this->db->set('upload_keep_duration', 'upload_keep_duration+' . $length, FALSE);

        // Remove a bump if not an admin
        if(!$admin) $this->db->set('upload_bumps', 'upload_bumps-1', FALSE);

        $this->db->where($where);
        $this->db->update('uploads');

        if ($this->db->affected_rows() > 0)
            return TRUE;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public extend_error()
     * @return string         This will return the error if any set when extending.
     */
    public function extend_error()
    {
        return $this->extend_error;
    }
    //------------------------------------------------------------------


    /**
     * public function get_user_images()
     */
    public function get_user_images($username = FALSE)
    {
        if(!$username)
            return FALSE;

        $this->db->select('*');
        $this->db->order_by("upload_time", "ASC");
        #$query = $this->db->get_where('uploads', array('upload_user' => $username), 5, 0);
        $query = $this->db->get_where('uploads', array('upload_user' => $username));

        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public function get_images()
     */
    public function get_images()
    {
        $this->db->select('*');
        $this->db->order_by("upload_time", "ASC");
        #$query = $this->db->get('uploads', 5, 0);
        $query = $this->db->get('uploads');

        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    //------------------------------------------------------------------


}