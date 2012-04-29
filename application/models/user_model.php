<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {


    //=================================================================================
    // :public
    //=================================================================================


    /**
     * public get_user_by_id()
     * function will pull needed user info based on the passed int user id.
     *
     * @param int $user_id - user id
     */
    public function get_user_by_id($user_id)
    {
        if (!$user_id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_all_users()
     * function will get all user info for all users
     */
    public function get_all_users()
    {
        $this->db->select('*');
        $this->db->order_by("id", "ASC");
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_unverified_users()
     * function will get all user info for all unverified users
     */
    public function get_unverified_users()
    {
        $this->db->select('*');
        $this->db->where('user_active', 'no');
        $this->db->order_by("id", "ASC");
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_user()
     * function will get needed user info via the passed username or email address
     *
     * @param string $user_name - this can be the user's username OR email address.
     */
    public function get_user($user_name = FALSE)
    {
        if (!$user_name)
            return FALSE;

        $this->db->select('*');
        $this->db->where('user_name', $user_name);
        $this->db->or_where('user_email', $user_name);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public add_user()
     * function will begin the user registration process, and will add the user into the database,
     * however users will still need to confirm their email address.
     *
     * @param string $user_name - requested username
     * @param string $user_password - users password sha1 hashed with salt
     * @param string $user_email - users email address
     * @param string $user_salt - randomly generated user salt
     * @param string $user_activation - the randomly generated user activation code
     */
    public function add_user($user_name = FALSE, $user_password = FALSE, $user_email = FALSE, $user_salt = FALSE, $user_activation = FALSE, $firstname = FALSE, $lastname = FALSE, $owl_id = FALSE)
    {
        if (!$user_name || !$user_password || !$user_email || !$user_salt || !$user_activation || !$firstname || !$lastname || !$owl_id)
            return FALSE;

        if ($owl_id == 'new')   // Are we looking at a user with no Owl?
            $owl_id = 0;        // 0 means that the user has no owl.

        $insert_data = array(
            'user_name'                 => $user_name,
            'user_first_name'           => $firstname,
            'user_last_name'            => $lastname,
            'user_email'                => $user_email,
            'user_salt'                 => $user_salt,
            'user_password'             => $user_password,
            'user_activation'           => $user_activation,
            'user_registration_date'    => time(),
            'user_owl_id'               => $owl_id
        );

        $this->db->insert('users', $insert_data);
    }
    //------------------------------------------------------------------


    /**
     * public activate_user()
     * function will activate a users account via their emailed code
     *
     * @param string $user_activation - the users activation code
     */
    public function activate_user($user_activation)
    {
        if (!$user_activation)
            return FALSE;

        $where = array(
            'user_active'       => 'no',
            'user_activation'   => $user_activation
        );

        $update_data = array(
            'user_active'       => 'yes',
            'user_activation'   => ''
        );

        $this->db->where($where);
        $this->db->update('users', $update_data);
    }
    //------------------------------------------------------------------


    /**
     * public add_reset_data()
     * function add the reset data to the database for autherization later
     *
     * @param string $user_name         - the users name
     * @param string $user_email        - the users email address
     * @param string $user_activation   - the users activation code
     */
    public function add_reset_data($user_name, $user_email, $user_activation)
    {
        if (!$user_name || !$user_email  || !$user_activation)
            return FALSE;

        $where = array(
            'user_name'         => $user_name,
            'user_email'        => $user_email
        );

        $update_data = array(
            'user_activation'   => $user_activation
        );

        $this->db->where($where);
        $this->db->update('users', $update_data);
    }
    //------------------------------------------------------------------


    /**
     * public auth_reset()
     * function will authenticate users password change request via their emailed code
     *
     * @param string $user_activation   - the users activation code
     * @param string $user_password     - the users new password
     * @param string $user_salt         - the users new salt
     */
    public function auth_reset($user_activation, $user_password, $user_salt)
    {
        if (!$user_activation)
            return FALSE;

        $update_data = array(
            'user_active'       => 'yes',
            'user_activation'   => '',
            'user_salt'         => $user_salt,
            'user_password'     => $user_password
        );

        $this->db->where('user_activation', $user_activation);
        $this->db->update('users', $update_data);
    }
    //------------------------------------------------------------------


    /**
     * public login_time()
     * function will set last login time
     *
     * @param string $user - the username
     */
    public function login_time($user)
    {
        $this->db->set('user_lastlogin', time());
        $this->db->where('user_name', $user);
        $this->db->update('users');
    }
    //------------------------------------------------------------------


    /**
     * public add_owl()
     * function will begin the owl registration process, and will add the owl into the database,
     * however users will still need to confirm their owl email address.
     *
     * @param string $name          - Organization Name
     * @param string $acronym       - Organization Acronym
     * @param string $type          - Owl Type (Clinic/Hospital)
     * @param string $address       - 1st line of address
     * @param string $province      - Province
     * @param string $city          - City
     * @param string $zip           - Postal Code
     * @param string $tel           - Telephone Number      (OPTIONAL)
     * @param string $www           - Website               (OPTIONAL)
     * @param string $email         - Administrator Email
     * @param string $activation    - Activation Code
     */
    public function add_owl($name = FALSE, $acronym = FALSE, $type = FALSE, $address = FALSE, $province = FALSE, $city = FALSE, $zip = FALSE, $tel = FALSE, $www = FALSE, $email = FALSE, $activation = FALSE)
    {
        if (!$name || !$acronym || !$type || !$address || !$province || !$city || !$zip || !$email || !$activation)
        {
            print "something is false!";
            print "<pre>\nname: {$name}\nacronym: {$acronym}\ntype: {$type}\naddress: {$address}\nprovince: {$province}\ncity: {$city}\nzip: {$zip}\ntel: {$tel}\nwww: {www}\nemail: {$email}\nactivation: {$activation}\n</pre>";
            die();
            return FALSE;
        }
        else
        {
            print "everything should have worked!";
            print "<pre>\nname: {$name}\nacronym: {$acronym}\ntype: {$type}\naddress: {$address}\nprovince: {$province}\ncity: {$city}\nzip: {$zip}\ntel: {$tel}\nwww: {www}\nemail: {$email}\nactivation: {$activation}\n</pre>";
            die();
        }

        $insert_data = array(
            'owl_name'          => $name,
            'owl_name_short'    => $acronym,
            'owl_type'          => $type,
            'owl_address'       => $address,
            'owl_province'      => $province,
            'owl_city'          => $city,
            'owl_postal_code'   => $zip,
            'owl_tel'           => $tel,
            'owl_site'          => $www,
            'owl_email'         => $email,
            'owl_activation'    => $activation
        );

        $this->db->insert('users', $insert_data);
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :validation callbacks
    //=================================================================================


    /**
     * public validate_authcode()
     * function will return a bool value if the auth code is valid and the user acccount
     * needs to be adcivated.
     *
     * @param string $auth_code  - user auth code
     * @param string $pass_reset - are we checking a password reset?
     */
    public function validate_authcode($auth_code, $pass_reset = FALSE)
    {
        $this->db->select('id');

        if ($pass_reset)
            $this->db->where('user_activation', $auth_code);
        else
            $this->db->where(array('user_activation' => $auth_code, 'user_active' => 'no'));

        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return TRUE;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public validate_username()
     * function will make sure that the provided username does NOT already exists, and will return a
     * bool value. FALSE if the username does exists, TRUE otherwise.
     *
     * @param string $user_name - username to validate.
     */
    public function validate_username($user_name)
    {
        $this->db->select('id');
        $this->db->where('user_name', $user_name);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return FALSE;

        return TRUE;
    }
    //------------------------------------------------------------------


    /**
     * public validate_email()
     * function will check and make sure the provided email does not already exists in our database.
     * will then return a bool value, FALSE if the email does exists, TRUE otherwise.
     *
     * @param string $user_email - email to validate.
     */
    public function validate_email($user_email)
    {
        $this->db->select('id');
        $this->db->where('user_email', $user_email);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return FALSE;

        return TRUE;
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :private
    //=================================================================================


}
