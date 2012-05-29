<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Browse extends CI_Controller {

    //=================================================================================
    // :private vars
    //=================================================================================



    //=================================================================================
    // :public
    //=================================================================================


    /**
     * public construct
     */
    public function __construct()
    {
        // init parent
        parent::__construct();

        // loads
        $this->load->model('upload_model');
    }
    //------------------------------------------------------------------


    /**
     * public remap
     */
    public function _remap($method, $params = array())
    {
        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }
        show_404();
    }
    //------------------------------------------------------------------


    /**
     * public index()
     */
    public function index($offset = 0, $limit = 10)
    {
        // Do we need to login??
        #if (!$this->login_check('browse'))
        #    return;

        $page_data = array();
        $page_data['page_title'] = 'File Browser';

        $uploads = $this->upload_model->get_all_uploads(FALSE, $limit, $offset);

        $this->load->library('table');
        $tmpl = array (
            'table_open'          => '<table>',

            'heading_row_start'   => '<tr>',
            'heading_row_end'     => '</tr>',
            'heading_cell_start'  => '<th>',
            'heading_cell_end'    => '</th>',

            'row_start'           => '<tr>',
            'row_end'             => '</tr>',
            'cell_start'          => '<td>',
            'cell_end'            => '</td>',

            'row_alt_start'       => '<tr>',
            'row_alt_end'         => '</tr>',
            'cell_alt_start'      => '<td>',
            'cell_alt_end'        => '</td>',

            'table_close'         => '</table>'
        );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Owl', 'Category', 'Filename', 'License', 'File Type', 'Download', 'Info');
        $this->table->set_empty("N/A");

        if($uploads)
        {
            foreach($uploads->result() as $row)
            {
                $lic = $this->miowl_model->get_license($row->upload_license);
                $this->table->add_row(
                    '<a href="' . site_url('browse/owl/' . $row->owl) . '">' . $this->owl_model->get_owl_by_id($row->owl)->row()->owl_name . '</a>',
                    $this->cat_model->get_category($row->upload_category)->row()->name,
                    $row->file_name,
                    '<a href="' . $lic->row()->url . '" target="_BLANK">' . $lic->row()->name . '</a>',
                    $row->file_type,
                    '<a href="' . site_url('download/' . $row->id) . '" title="Downlaod this file!" target="_BLANK" class="icon_font">F</a>',
                    '<a href="' . site_url('browse/info/' . $row->id) . '" title="More info for this file!" class="icon_font">,</a>'
                );
            }
        }

        $page_data['table'] = $this->table->generate();

        // setup pagination lib
        $config['base_url']         = site_url('browse/index');
        $config['total_rows']       = $this->upload_model->total_uploads();
        $config['per_page']         = $limit;
        $config['anchor_class']     = 'class="button" ';
        $config['cur_tag_open']     = '&nbsp;<div class="button danger current">';
        $config['cur_tag_close']    = '</div>';

        // init pagination
        $this->pagination->initialize($config);

        // load our view
        $this->load->view('pages/browse', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public index()
     */
    public function owl($owl = FALSE, $offset = 0, $limit = 10)
    {
        $page_data = array();
        $page_data['page_title'] = 'File Browser | by owl (' . $this->owl_model->get_owl_by_id($owl)->row()->owl_name . ')';
        $page_data['browse_by_owl'] = TRUE;

        $uploads = $this->upload_model->get_upload_by_owl($owl, $limit, $offset);

        $this->load->library('table');
        $tmpl = array (
            'table_open'          => '<table width="100%" cellspacing="0" cellpadding="4" border="1">',

            'heading_row_start'   => '<tr>',
            'heading_row_end'     => '</tr>',
            'heading_cell_start'  => '<th>',
            'heading_cell_end'    => '</th>',

            'row_start'           => '<tr>',
            'row_end'             => '</tr>',
            'cell_start'          => '<td>',
            'cell_end'            => '</td>',

            'row_alt_start'       => '<tr>',
            'row_alt_end'         => '</tr>',
            'cell_alt_start'      => '<td>',
            'cell_alt_end'        => '</td>',

            'table_close'         => '</table>'
        );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Timestamp (GMT)', 'Filename', 'Category', 'License', 'File Type', 'Owl', 'Download', 'Info');
        $this->table->set_empty("N/A");

        if($uploads)
        {
            foreach($uploads->result() as $row)
            {
                $lic = $this->miowl_model->get_license($row->upload_license);
                $this->table->add_row(
                    date("H:i:s d/m/Y", $row->upload_time),
                    $row->file_name,
                    $this->cat_model->get_category($row->upload_category)->row()->name,
                    '<a href="' . $lic->row()->url . '" target="_BLANK">' . $lic->row()->name . '</a>',
                    $row->file_type,
                    $this->owl_model->get_owl_by_id($row->owl)->row()->owl_name,
                    '<center><a href="' . site_url('download/' . $row->id) . '" title="Downlaod this file!" target="_BLANK" class="icon_font">F</a></center>',
                    '<center><a href="' . site_url('browse/info/' . $row->id) . '" title="More info for this file!" class="icon_font">,</a></center>'
                );
            }
        }

        $page_data['table'] = $this->table->generate();

        // setup pagination lib
        $config['base_url']         = site_url('browse/owl/' . $owl);
        $config['uri_segment']      = 4;
        $config['total_rows']       = $this->upload_model->total_owl_uploads($owl);
        $config['per_page']         = $limit;
        $config['anchor_class']     = 'class="button" ';
        $config['cur_tag_open']     = '&nbsp;<div class="button danger current">';
        $config['cur_tag_close']    = '</div>';

        // init pagination
        $this->pagination->initialize($config);

        // load our view
        $this->load->view('pages/browse', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public download()
     */
    public function download($file_id = FALSE)
    {
        if(!$file_id)
            redirect(site_url('browse'), 'location');

        // Get the file info for this ID
        $upload_info = $this->upload_model->get_upload_by_id($file_id);

        // Check the file has an ext, if not add it.
        $file_name = $upload_info->row()->file_name;
        $file_ext  = $upload_info->row()->file_ext;
        if (!$this->endswith($file_name, $file_ext))
            $file_name = $file_name . $file_ext;

        $data = array();
        $data['file_path'] = $upload_info->row()->full_path;
        $data['file_name'] = $file_name;
        $this->load->view('pages/download_file', $data);
    }
    //------------------------------------------------------------------


    /**
     * public info()
     */
    public function info($file_id = FALSE, $deleted = FALSE)
    {
        if(!$file_id)
            redirect(site_url('browse'), 'location');

        // Get the file info for this ID
        $upload_info = $this->upload_model->get_upload_by_id($file_id, $deleted);

        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "File Info | " . $upload_info->row()->file_name;
        $page_data['info']          = $upload_info;
        $page_data['deleted']       = $deleted;

        // load the approp. page view
        $this->load->view('pages/file_info', $page_data);
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :private
    //=================================================================================


    /**
     * private login_check()
     */
    private function login_check($location = FALSE, $redirect = FALSE)
    {
        if ($this->session->userdata('authed'))
        {
            if($redirect)
            {
                $location = str_replace('-', '/', "" . $location);
                redirect('/' . $location, 'location');
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
        else
        {
            redirect('/user/login/' . $location, 'location');
            return FALSE;
        }
    }
    //------------------------------------------------------------------


    /**
     * private endswith()
     *
     * This function is used to check if a string ends with another string
     *
     * @param $string - This is the string we are wanting to check against
     * @param $test   - This is the string we wish to find in $string
     *
     * @return bool
     */
    private function endswith($string, $test)
    {
        $strlen = strlen($string);
        $testlen = strlen($test);
        if ($testlen > $strlen) return false;
        return substr_compare($string, $test, -$testlen) === 0;
    }
    //------------------------------------------------------------------


}

