<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model {

    /*******************************************************************
     * PRIVATE VARS
     *******************************************************************/

    private $units = array(
        "year"   => 29030400, // seconds in a year   (12 months)
        "month"  => 2419200,  // seconds in a month  (4 weeks)
        "week"   => 604800,   // seconds in a week   (7 days)
        "day"    => 86400,    // seconds in a day    (24 hours)
        "hour"   => 3600,     // seconds in an hour  (60 minutes)
        "minute" => 60,       // seconds in a minute (60 seconds)
        "second" => 1         // 1 second
    );
    //------------------------------------------------------------------

    // This is the sort/grouping we will use accross the whole search
    private $order_by = array('owls.owl_name', 'categories.parent_id', 'categories.id', 'uploads.file_type', 'license.name');
    //------------------------------------------------------------------


    /*******************************************************************
     * PUBLIC FUNCTIONS
     *******************************************************************/

    /**
     * public search_all()
     */
    public function search_all($keyword = FALSE, $offset = 0, $limit = 7, $where = array())
    {
        if (!$keyword)
            return FALSE;

        return $this->search($keyword, $offset, $limit, $where);
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :PRIVATE FUNCTIONS
    //=================================================================================


    /**
     * private search()
     */
    private function search($keyword = NULL, $offset = 0, $limit = FALSE, $where = FALSE)
    {
        // what do we want?
        $this->db->select('
                owls.id AS owl_id,
                owls.owl_name,
                owls.owl_name_short,
                categories.parent_id AS cat_pid,
                categories.id AS cat_id,
                categories.name AS cat_name,
                uploads.id AS up_id,
                uploads.file_type,
                uploads.file_name,
                uploads.file_ext,
                license.id AS lic_id,
                license.name AS lic_name,
                license.url AS lic_url
            ');

        // join the tables by the id's
        $this->db->join('users', 'uploads.upload_user = users.id', 'inner');
        $this->db->join('owls', 'uploads.owl = owls.id', 'inner');
        $this->db->join('categories', 'uploads.upload_category = categories.id', 'inner');
        $this->db->join('license', 'uploads.upload_license = license.id', 'inner');

        // find by keyword
        $this->db->like('uploads.file_name', $keyword);
        // $this->db->or_like('owls.owl_name', $keyword);
        // $this->db->or_like('owls.owl_name_short', $keyword);
        // $this->db->or_like('categories.name', $keyword);
        // $this->db->or_like('uploads.file_type', $keyword);
        // $this->db->or_like('license.name', $keyword);
        // $this->db->or_like('license.short_description', $keyword);

        // don't show deleted files
        $this->db->where('uploads.deleted', 'false');

        // if extra where items are set, include them
        if($where != FALSE)
        {
            print '<pre>';
            foreach ($where as $key => $value) {
                $this->db->where($key, $value);
                print "{$key} = {$value}\n";
            }
            print '</pre>';
        }

        // order the data
        foreach ($this->order_by as $sort) {
            $this->db->order_by($sort, 'ASC');
        }

        // fetch this thing
        if($limit != FALSE)
            $query = $this->db->get('uploads', $limit, $offset);
        else
            $query = $this->db->get('uploads');

        print '<pre>' . print_r($this->db->last_query(), TRUE) . '</pre>';

        // do we have any results?
        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    //------------------------------------------------------------------


}
