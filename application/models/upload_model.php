<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload_model extends CI_Model {


    //=================================================================================
    // :public
    //=================================================================================


    /**
     * public get_upload_by_id()
     * function will pull needed upload info based on the passed int upload id.
     *
     * @param int $upload_id - upload id
     */
    public function get_upload_by_id($upload_id)
    {
        if (!$upload_id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('id', $upload_id);
        $query = $this->db->get('uploads');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_upload_by_ext()
     */
    public function get_upload_by_ext($ext)
    {
        if (!$ext)
            return FALSE;

        $this->db->select('*');
        $this->db->where('file_ext', '.' . $ext);
        $query = $this->db->get('uploads');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_upload_by_owl()
     */
    public function get_upload_by_owl($owl)
    {
        if (!$upload_id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('client_name', $owl);
        $query = $this->db->get('uploads');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_all_uploads()
     * function will get all upload info for all uploads
     */
    public function get_all_uploads()
    {
        $this->db->select('*');
        $this->db->order_by("id", "ASC");
        $query = $this->db->get('uploads');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public add_upload()
     */
    public function add_upload(
                                $upload_user        = FALSE,
                                $owl                = FALSE,
                                $file_name          = FALSE,
                                $full_path          = FALSE,
                                $upload_catagory    = FALSE,
                                $file_type          = FALSE,
                                $client_name        = FALSE,
                                $file_size          = FALSE,
                                $file_ext           = FALSE,
                                $description        = FALSE
                              )
    {
        if (!$upload_user || !$owl || !$file_name || !$full_path || !$upload_catagory || !$file_type || !$client_name || !$file_size || !$file_ext || !$description)
            return FALSE;

        $insert_data = array(
            'upload_time'       => time(),
            'upload_user'       => $upload_user,
            'owl'               => $owl,
            'file_name'         => $file_name,
            'full_path'         => $full_path,
            'upload_catagory'   => $upload_catagory,
            'file_type'         => $file_type,
            'client_name'       => $client_name,
            'file_size'         => $file_size,
            'file_ext'          => $file_ext,
            'description'       => $description
        );

        $this->db->insert('uploads', $insert_data);
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :private
    //=================================================================================


}