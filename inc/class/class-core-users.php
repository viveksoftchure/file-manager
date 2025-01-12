<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dashboard class
 *
 */
class FM_Core_Users {

    /**
     * Class constructor
     */
    public function __construct() {
        add_shortcode( 'fm_account', array( $this, 'my_account' ) );

        add_action( 'fm_account_content_dashboard', array( $this, 'dashboard_section' ), 10, 2 );
        add_action( 'fm_account_content_drive', array( $this, 'drive_section' ), 10, 2 );
        add_action( 'fm_account_content_trash', array( $this, 'trash_section' ), 10, 2 );
        add_action( 'fm_account_content_bookmark', array( $this, 'bookmark_section' ), 10, 2 );
        add_action( 'fm_account_content_archive', array( $this, 'archive_section' ), 10, 2 );
        add_action( 'fm_account_content_collections', array( $this, 'collections_section' ), 10, 2 );

        add_action( 'fm_account_content_change-password', array( $this, 'change_password_section' ), 10, 2 );

        add_action( 'fm_account_content_edit-profile', array( $this, 'edit_profile_section' ), 10, 2 );

        // Ajax login
        add_action( 'wp_ajax_nopriv_login_user', array( $this, 'ajax_login_user' ) );

        // Ajax registration
        add_action( 'wp_ajax_nopriv_register_user', array( $this, 'ajax_do_register_user' ) );

        // Ajax registration
        add_action( 'wp_ajax_add_folder', array( $this, 'add_folder' ) );
        add_action( 'wp_ajax_add_file', array( $this, 'add_file') );
        add_action( 'wp_ajax_update_collection', array( $this, 'update_collection' ) );
        add_action( 'wp_ajax_delete_collection', array( $this, 'delete_collection' ) );
        add_action( 'wp_ajax_get_bookmark', array( $this, 'get_bookmark' ) );
        add_action( 'wp_ajax_add_bookmark', array( $this, 'add_bookmark' ) );
        add_action( 'wp_ajax_delete_bookmark', array( $this, 'delete_bookmark' ) );
        add_action( 'wp_ajax_delete_item', array( $this, 'delete_item' ) );
        add_action( 'wp_ajax_refresh_bookmark', array( $this, 'refresh_bookmark' ) );
        add_action( 'wp_ajax_update_bookmark', array( $this, 'update_bookmark' ) );
        add_action( 'wp_ajax_add_to_collection', array( $this, 'add_to_collection' ) );
        add_action( 'wp_ajax_upload_user_pic', array( $this, 'user_profile_pic') );
        add_action( 'wp_ajax_user_profile_update', array( $this, 'user_profile_update' ));
        add_action( 'wp_ajax_update_user_password', array( $this, 'update_user_password' ), 10 );
        
        add_action( 'wp_logout', array( $this, 'auto_redirect_after_logout') );

        add_action( 'admin_init', array( $this, 'redirect_subscribers_to_dashboard') );

        add_action( 'wp_body_open',array($this, 'site_forms'));
    }


    public function auto_redirect_after_logout() {
        wp_safe_redirect( site_url('login') );
        exit;
    }

    public function redirect_subscribers_to_dashboard() {
        if (is_user_logged_in() && current_user_can('subscriber') && !is_page('account')) {
            if (is_admin()) {
                // wp_redirect(site_url('account'));
            }
            // exit;
        }
    }

    /**
     * Display the login form
     */
    public function site_forms() {
        if( is_page('dashboard') ) :
        // if( is_page_template( 'account.php' ) ) :
            get_template_part( 'template-parts/modal-forms' ); 
        endif;
    } 

    /**
     * Handle's user account functionality
     *
     * Insert shortcode [fm_account] in a page to
     * show the user account
     */
    public function my_account( $atts ) {
        //phpcs:ignore
        extract( shortcode_atts( [], $atts ) );

        ob_start();

        if ( is_user_logged_in() ) {
            $default_active_tab = 'dashboard';
            $section            = isset( $_REQUEST['section'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['section'] ) ) : $default_active_tab;

            $sections = apply_filters( 'fm_my_account_tab_links', fm_get_account_sections() );

            $current_section    = [];

            foreach ( $sections as $slug => $label ) {
                if ( $section === $slug ) {
                    $current_section = $slug;
                    break;
                }
            }

            fm_load_template(
                'account.php', [
                    'sections' => $sections,
                    'current_section' => $current_section,
                ]
            );
        } else {
            $message = 'fm_dashboard';
            fm_load_template( 'unauthorized.php', [ 'message' => $message ] );
        }

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * Display the dashboard section
     *
     * @param array  $sections
     * @param string $current_section
     *
     * @return void
     */
    public function dashboard_section( $sections, $current_section ) {
        fm_load_template(
            'dashboard/dashboard.php',
            [
                'sections' => $sections,
                'current_section' => $current_section,
            ]
        );
    }

    /**
     * Display the drive section
     *
     * @param array  $sections
     * @param string $current_section
     *
     * @return void
     */
    public function drive_section( $sections, $current_section ) {
        fm_load_template(
            'dashboard/drive.php',
            [
                'sections' => $sections,
                'current_section' => $current_section,
            ]
        );
    }

    /**
     * Display the drive section
     *
     * @param array  $sections
     * @param string $current_section
     *
     * @return void
     */
    public function trash_section( $sections, $current_section ) {
        fm_load_template(
            'dashboard/trash.php',
            [
                'sections' => $sections,
                'current_section' => $current_section,
            ]
        );
    }

    /**
     * Display the edit profile section
     *
     * @param array  $sections
     * @param string $current_section
     *
     * @return void
     */
    public function edit_profile_section( $sections, $current_section ) {
        fm_load_template(
            'dashboard/edit-profile.php',
            [
                'sections' => $sections,
                'current_section' => $current_section,
            ]
        );
    }

    /**
     * Display the change password section
     *
     * @param array  $sections
     * @param string $current_section
     *
     * @return void
     */
    public function change_password_section( $sections, $current_section ) {
        fm_load_template(
            'dashboard/change-password.php',
            [
                'sections' => $sections,
                'current_section' => $current_section,
            ]
        );
    }
    
    /**
     * Redirect the user to the custom login page instead of wp-login.php.
     */
    public function redirect_to_custom_login() {
        if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
            $redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : null;
         
            if ( is_user_logged_in() ) {
                $this->redirect_logged_in_user( $redirect_to );
                exit;
            }
     
            // The rest are redirected to the login page
            $login_url = get_permalink(get_page_by_path( 'dashboard' ));
            if ( ! empty( $redirect_to ) ) {
                $login_url = add_query_arg( 'redirect_to', $redirect_to, $login_url );
            }
     
            wp_redirect( $login_url );
            exit;
        }
    }

    /**
     * Redirects the user to the custom registration page instead
     * of wp-login.php?action=register.
     */
    public function redirect_to_custom_register() {
        if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
            if ( is_user_logged_in() ) {
                $this->redirect_logged_in_user();
            } else {
                wp_redirect( get_permalink(get_page_by_path( 'dashboard' )) );
            }
            exit;
        }
    }

    /**
     * Ajax login
     *
     * @return json
     */
    public function ajax_login_user() {

        // First check the nonce, if it fails the function will break
        //check_ajax_referer( 'ajax-login-nonce', 'security' );
        if( !check_ajax_referer( 'login_user_nonce', 'login_security', false) ) :
            echo json_encode(
                array(
                    'success'=>false, 
                    'msg'=> __('Session token has expired, please reload the page and try again')
                )
            );
            die();
        endif;

        // Nonce is checked, get the POST data and sign user on
        $info = array();
        $info['user_login'] = sanitize_text_field(trim($_POST['email']));
        $info['user_password'] = sanitize_text_field(trim($_POST['password']));
        $info['remember'] = isset($_POST['remember-me']) ? true : false;

        if(empty($info['user_login'])) {
             echo json_encode(
                array(
                    'success'=>false, 
                    'msg'=> esc_html__( 'You do have an email address, right?' )
                )
             );
             die();
        } 
        if(empty($info['user_password'])) {
            echo json_encode(
                array(
                    'success'=>false, 
                    'msg'=> esc_html__( 'You need to enter a password to login.' )
                )
            );
            die();
        }

        // $user_signon = wp_signon( $info, is_ssl() );
        $user_signon = wp_signon( $info, '' );
        if ( is_wp_error($user_signon) ){
            
            echo json_encode(
                array(
                    'success'=>false, 
                    'msg'=>esc_html__('Wrong username or password.')
                )
            );

        } else {
            wp_clear_auth_cookie();
            wp_set_current_user($user_signon->ID);
            wp_set_auth_cookie($user_signon->ID, true);
            echo json_encode(
                array(
                    'success'  =>  true, 
                    'msg'   =>  esc_html__('Login successful, redirecting...'),
                    'redirect' => site_url('account'),
                
                )
            );
        }

        die();
    }

    /**
     * Ajax register
     *
     * @return json
     */
    public function ajax_do_register_user() {
        $google_api_secret = '';
        $g_recaptcha_response = '';
        $remote_addr = '';
        $enable_captcha = false;
        $new_user_email_verification = false;

        $first_name = sanitize_text_field( $_POST['first_name'] );
        $last_name = sanitize_text_field( $_POST['last_name'] );
        $user_email = sanitize_email( $_POST['user_email'] );
        $user_password = sanitize_text_field( $_POST['user_password'] );
        $user_cpassword = sanitize_text_field( $_POST['user_cpassword'] );

        if( !check_ajax_referer( 'register_user_nonce', 'register_user_nonce', false) ) :
            echo json_encode(
                array(
                    'registered'=>false, 
                    'msg'=> __('Session token has expired, please reload the page and try again')
                )
            );
            die();
        endif;

        if(empty($first_name)) {
            echo json_encode(
                array(
                    'registered'=>false, 
                    'msg'=> esc_html__( 'Please provide your first name', 'apnatask' )
                )
            );
            die();
        }  

        if(empty($last_name)) {
            echo json_encode(
                array(
                    'registered'=>false, 
                    'msg'=> esc_html__( 'Please provide your last name', 'apnatask' )
                )
            );
            die();
        }

        if ( !$user_email ) {
            echo json_encode(
                array(
                    'registered'=>false, 
                    'msg'=> __('Please fill email address', 'apnatask')
                )
            );
            die();
        }

        if ( !is_email($user_email)  ) {
            echo json_encode(
                array(
                    'registered'=>false, 
                    'msg'=> __('This is not valid email address', 'apnatask')
                )
            );
            die();
        }

        if(empty($user_password)) {
            echo json_encode(
                array(
                    'registered'=>false, 
                    'msg'=> esc_html__( 'Please provide password', 'apnatask' )
                )
            );
            die();
        }
        
        if(empty($user_cpassword)) {
            echo json_encode(
                array(
                    'registered'=>false, 
                    'msg'=> esc_html__( 'Please confirm password', 'apnatask' )
                )
            );
            die();
        }
        
        if($user_cpassword != $user_cpassword) {
            echo json_encode(
                array(
                    'registered'=>false, 
                    'msg'=> esc_html__( 'Password is not matched with confirm password', 'apnatask' )
                )
            );
            die();
        }

        $uppercase = preg_match('@[A-Z]@', $user_password);
        $lowercase = preg_match('@[a-z]@', $user_password);
        $number    = preg_match('@[0-9]@', $user_password);
        $specialChars = preg_match('@[^\w]@', $user_password);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($user_password) < 8) {
            
            echo json_encode(
                array(
                    'registered'=>false, 
                    'msg'=> esc_html__( 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.', 'apnatask' )
                )
            );
            die();
        }

        if( email_exists($user_email) == false ) {
            $remote_addr = $_SERVER['REMOTE_ADDR'];

            $user_name = explode( '@', $user_email);
            $u_name = check_user_name( $user_name[0] );

            $user_data = array(
                'first_name'    => $first_name,
                'last_name'     => $last_name,
                'user_login'    => $u_name,
                'user_email'    => $user_email,
                'user_pass'     => $user_password,
            );

            $user_id = wp_insert_user( $user_data );

            // echo '<pre>'; print_r($user_data); echo '</pre>'; exit();

            // Email for new user
            // $this->chaksucity_email_on_new_user($user_id, '');

            if($new_user_email_verification) {
                $user = new WP_User($user_id);
                // Remove all user roles after registration
                foreach($user->roles as $role){
                    $user->remove_role($role);
                }
                echo json_encode(
                    array(
                        'success' => false, 
                        'msg' => esc_html__('Verification Required! Registered successfully. An activation email has been sent to your provided email address.')
                    )
                );
            } else {
                $this->chaksucity_auto_login($user_email, $user_password, true );
                echo json_encode(
                    array(
                        'success' => true, 
                        'redirect' => site_url('account'),
                        'msg' => esc_html__('You have successfully logged in. Redirecting please wait....')
                    )
                );
                die();
            }
        } else {
            echo json_encode(
                array(
                    'success' => false, 
                    'msg' => esc_html__( 'Email already exist, please try other one.' )
                )
            );
        }

        die();
    }

    /**
     * Auto login
     *
     * @param string $username
     * @param string $password
     * @param bool $remember
     * @return bool
     */
    public function chaksucity_auto_login($username, $password, $remember )
    {
        $creds = array();
        $creds['user_login'] = $username;
        $creds['user_password'] = $password;
        $creds['remember'] = $remember;

        $user = wp_signon( $creds, '' );

        if ( is_wp_error($user) ) {
            return false;
        } else {
            wp_clear_auth_cookie();
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID, true);
            return true;
        }
    }

    /**
     * Send Email On New User Registration
     *
     * @param int $user_id
     * @param string $social
     * @param bool $admin_email
     * @return bool
     */
    public function chaksucity_email_on_new_user($user_id, $social = '', $admin_email = true) {
        $new_user_admin_message = '';
        $new_user_admin_message_from = '';
        $new_user_admin_message_subject = '';

        $new_user_message = '';
        $new_user_message_from = '';
        $new_user_message_subject = '';

        $new_user_email_verification = 0;

        if ($new_user_admin_message != "" && $new_user_admin_message_from != "") {
            $to = get_option('admin_email');
            $subject = $new_user_admin_message_subject;
            $from = $new_user_admin_message_from;
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            // User info
            $user_info = get_userdata($user_id);
            $msg_keywords = array('%site_name%', '%display_name%', '%email%');
            $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, $user_info->user_email);
            $body = str_replace($msg_keywords, $msg_replaces, $new_user_admin_message);
            wp_mail($to, $subject, $body, $headers);
        }

        if ($new_user_message != "" && $new_user_message_from != "") {
            // User info
            $user_info = get_userdata($user_id);
            $to = $user_info->user_email;
            $subject = $new_user_message_subject;
            $from = $new_user_message_from;
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            $user_name = $user_info->user_email;
            if ($social != '')
                $user_name .= "(Password: $social )";
            $verification_link = '';

            if ($new_user_email_verification == '1') {
                $token = get_user_meta($user_id, 'user_email_verification_token', true);
                if ($token == "") {
                    $token = chaksucity_randomString(50);
                }

                $verification_link = trailingslashit(get_home_url()) . '?verification_key=' . $token . '-chaksucity_uid-' . $user_id;
                update_user_meta($user_id, 'user_email_verification_token', $token);
            }
            $msg_keywords = array('%site_name%', '%user_name%', '%display_name%', '%verification_link%');
            $msg_replaces = array(get_bloginfo('name'), $user_name, $user_info->display_name, $verification_link);

            $body = str_replace($msg_keywords, $msg_replaces, $new_user_message);
            wp_mail($to, $subject, $body, $headers);
        }
    }


    /**
     * Returns the URL to which the user should be redirected after the (successful) login.
     *
     * @param string           $redirect_to           The redirect destination URL.
     * @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
     * @param WP_User|WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
     *
     * @return string Redirect URL
     */
    public function redirect_after_login( $redirect_to, $requested_redirect_to, $user ) {
        $redirect_url = home_url();

        if ( ! isset( $user->ID ) ) {
            return $redirect_url;
        }
     
        if ( user_can( $user, 'manage_options' ) ) {
            $redirect_url = admin_url();
        } else {
            $redirect_url = get_permalink(get_page_by_path( 'dashboard' ));
        }
     
        return wp_validate_redirect( $redirect_url, home_url() );
    }

    /**
     * Redirects the user to the correct page depending on whether he / she
     * is an admin or not.
     *
     * @param string $redirect_to   An optional redirect_to URL for admin users
     */
    private function redirect_logged_in_user( $redirect_to = null ) {
        $user = wp_get_current_user();
        if ( user_can( $user, 'manage_options' ) ) {
            if ( $redirect_to ) {
                wp_safe_redirect( $redirect_to );
            } else {
                wp_redirect( admin_url() );
            }
        } else {
            wp_redirect( home_url( get_permalink(get_page_by_path( 'dashboard' )) ) );
        }
    }

    /**
     * Validates and then completes the new user signup process if all went well.
     *
     * @param string $email         The new user's email address
     * @param string $user_login    The new user's username
     * @param string $password      The new user's password
     *
     * @return int|WP_Error         The id of the user that was created, or error if failed.
     */
    private function register_user( $email, $user_login, $password ) {
        $errors = new WP_Error();
     
        // Email address is used as both username and email. It is also the only
        // parameter we need to validate
        if ( ! is_email( $email ) ) {
            $errors->add( 'email', $this->get_error_message( 'email' ) );
            return $errors;
        }
     
        if ( email_exists( $email ) ) {
            $errors->add( 'email_exists', $this->get_error_message( 'email_exists') );
            return $errors;
        }

        if ( username_exists( $user_login ) ) {
            $errors->add( 'username_exists', $this->get_error_message( 'username_exists') );
            return $errors;
        }

        $user_data = array(
            'user_login'    => $user_login,
            'user_email'    => $email,
            'user_pass'     => $password,
        );
     
        $user_id = wp_insert_user( $user_data );

        if ( ! is_wp_error( $user_id ) ) {
            wp_set_current_user($user_id); // set the current wp user
            wp_set_auth_cookie($user_id);   
        }
        
        return $user_id;
    }

    public function user_profile_pic() {
        
        /* img upload */
        if (!empty($_FILES["profile_pic"])) {

            // require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            $file = $_FILES["profile_pic"];

            // Allow certain file formats
            $imageFileType = end(explode('.', $file['name']));
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo '2';
                die();
            }

            $attach_id = media_handle_upload('profile_pic', 0);
            $image_link = wp_get_attachment_image_src($attach_id, 'chaksucity_user-profile');
        }

        /* img upload */
        $user_info = get_userdata(get_current_user_id());
        $uid = $user_info->ID;
        update_user_meta($uid, 'chaksucity_user_pic', $attach_id);
        echo '1|' . $image_link[0];
        die();
    }

    /**
     * Save user account info
     *
     * @return void
     */
    public function user_profile_update() {
        $params = array();
        parse_str($_POST['collect_data'], $params);

        $first_name     = !empty($params['first_name']) ? sanitize_text_field(wp_unslash($params['first_name'])) : '';
        $last_name      = !empty($params['last_name']) ? sanitize_text_field(wp_unslash($params['last_name'])) : '';
        $nickname       = !empty($params['username']) ? sanitize_text_field(wp_unslash($params['username'])) : '';
        $user_birth     = !empty($params['user_birth']) ? sanitize_text_field(($params['user_birth'])) : '';
        $user_phone     = !empty($params['user_phone']) ? sanitize_text_field(wp_unslash($params['user_phone'])) : '';
        $user_location  = !empty($params['user_location']) ? sanitize_text_field($params['user_location']) : '';
        $description    = !empty($params['description']) ? sanitize_textarea_field(wp_unslash($params['description'])) : '';
        
        //social links
        $facebook       = !empty($params['social-facebook']) ? sanitize_text_field($params['social-facebook']) : '';
        $twitter        = !empty($params['social-twitter']) ? sanitize_text_field($params['social-twitter']) : '';
        $linkedin       = !empty($params['social-linkedin']) ? sanitize_text_field($params['social-linkedin']) : '';
        $youtube        = !empty($params['social-youtube']) ? sanitize_text_field($params['social-youtube']) : '';
        $instagram      = !empty($params['social-instagram']) ? sanitize_text_field($params['social-instagram']) : '';

        $nonce          = isset($params['_wpnonce']) ? sanitize_key(wp_unslash($params['_wpnonce'])) : '';

        if ( isset( $nonce ) && ! wp_verify_nonce( $nonce, 'account-update-profile' ) ) {
            echo json_encode(['success' => false, 'msg' => 'Session Expired!']);
            die();
        }

        if (empty($first_name ) ) {
            echo json_encode(['success' => false, 'msg' => 'First Name is a required field.']);
            die();
        }

        if (empty($last_name ) ) {
            echo json_encode(['success' => false, 'msg' => 'Last Name is a required field.']);
            die();
        }

        $user_info = get_userdata(get_current_user_id());
        $uid = $user_info->ID;

        $user               = new stdClass();
        $user->ID           = $uid;
        $user->first_name   = $first_name;
        $user->last_name    = $last_name;
        $user->nickname     = $nickname;
        $user->display_name = $nickname;
        $user->user_birth   = $user_birth;
        $user->user_phone   = $user_phone;
        $user->description  = $description;

        if ($email) {
            if (!is_email($email)) {
                echo json_encode(['success' => false, 'msg' => 'Please provide a valid email address.']);
                die();
            } elseif (email_exists($email) && $email !== $user_info->user_email) {
                echo json_encode(['success' => false, 'msg' => 'This email address is already registered.']);
                die();
            }
            $user->user_email = $email;
        }

        $result = wp_update_user( $user );

        update_user_meta($uid, 'user_birth', $user_birth);
        update_user_meta($uid, 'user_phone', $user_phone);
        update_user_meta($uid, 'user_location', $user_location);
        update_user_meta($uid, 'd_fb_link', $facebook);
        update_user_meta($uid, 'd_twitter_link', $twitter);
        update_user_meta($uid, 'd_linked_link', $linkedin);
        update_user_meta($uid, 'd_youtube_link', $youtube);
        update_user_meta($uid, 'd_insta_link', $instagram);

        if (is_wp_error($result)) {
            echo json_encode(['success' => false, 'msg' => $result]);
            die();
        }
        if (!is_wp_error($result)) {
            echo json_encode(['success' => true, 'msg' => 'You profile has been updated successfully.']);
            die();
        }
    }

    /**
     * Update user password
     *
     * @return json
     */
    public function update_user_password(){
        //get user id
        $current_user = wp_get_current_user();
        $params = array();
        parse_str($_POST['collect_data'], $params);

        $current_pass   = sanitize_text_field($params['current_pass']);
        $pass1          = sanitize_text_field($params['pass1']);
        $pass2          = sanitize_text_field($params['pass2']);
        $nonce          = isset($params['_wpnonce']) ? sanitize_key(wp_unslash($params['_wpnonce'])) : '';

        if ( isset( $nonce ) && ! wp_verify_nonce( $nonce, 'account-update-password' ) ) {
            echo json_encode(['success' => false, 'msg' => 'Session Expired!']);
            die();
        }

        // wp_set_password($new_password, $uid);

        $current_user = wp_get_current_user();
        if (!empty($current_pass) && !empty($pass1) && !empty($pass2)) {
            if ( !wp_check_password($current_pass, $current_user->user_pass, $current_user->ID) ) {
                echo json_encode(['success' => false, 'msg' => 'Your current password does not match. Please retry.']);
                die();
            } elseif ($pass1 != $pass2) {
                echo json_encode(['success' => false, 'msg' => 'The passwords do not match. Please retry.']);
                die();
            } elseif (strlen($pass1) < 4) {
                echo json_encode(['success' => false, 'msg' => 'A bit short as a password, don\'t you think?']);
                die();
            } elseif (false !== strpos(wp_unslash($pass1), "\\")) {
                echo json_encode(['success' => false, 'msg' => 'Password may not contain the character "\\" (backslash).']);
                die();
            } else {
                $user_id  = wp_update_user(array(
                    'ID' => $current_user->ID, 
                    'user_pass' => esc_attr($pass1)
                ));

                if (is_wp_error($user_id)) {
                    echo json_encode(['success' => false, 'msg' => 'An error occurred while updating your profile. Please retry.']);
                    die();
                } else {
                    echo json_encode(['success' => true, 'msg' => 'Your password has been updated.']);
                    die();
                }
            }
        } else {
            echo json_encode(['success' => false, 'msg' => 'Please fill password fields.']);
            die();
        }
    }

    /**
     * Finds and returns a matching error message for the given error code.
     *
     * @param string $error_code    The error code to look up.
     *
     * @return string               An error message.
     */
    private function get_error_message( $error_code ) {
        switch ( $error_code ) {
            case 'email_exists':
                return __( 'This email is already registered', 'listeo_core' );
            break;
            case 'username_exists':
                return __( 'This username already exists', 'listeo_core' );
            break;
            case 'empty_username':
                return __( 'You do have an email address, right?', 'listeo_core' );
            break;
            case 'empty_password':
                return __( 'You need to enter a password to login.', 'listeo_core' );
            break;
            case 'invalid_username':
                return __(
                    "We don't have any users with that email address. Maybe you used a different one when signing up?", 'listeo_core' );
            break;
            case 'incorrect_password':
                $err = __(
                    "The password you entered wasn't quite right. <a href='%s'>Did you forget your password</a>?",
                    'listeo_core'
                );
                return sprintf( $err, wp_lostpassword_url() );
            break;
            default:
                break;
        }
         
        return __( 'An unknown error occurred. Please try again later.', 'listeo_core' );
    }

    /**
     * Returns value by key from array if set
     *
     * @param array $array
     * @param string $key
     * @param mixed $default
     * @param bool $strict
     * @return mixed
     */
    public function ifset($array, $key, $default = null) {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    /**
     * Add folder of user
     *
     * @return array
     */
    public function add_folder() {
        // Check nonce
        if ( !isset($_POST['form_nonce']) || !wp_verify_nonce($_POST['form_nonce'], 'form_submit') ) {
            wp_send_json_error('Invalid nonce');
        }

        // Sanitize and validate form input
        $title          = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
        $unique_key     = isset($_POST['id']) ? sanitize_text_field($_POST['id']) : '';
        // $description    = isset($_POST['description']) ? sanitize_text_field($_POST['description']) : '';
        // $bg_color       = generateLighterHexColor();
        // $back_color     = generateRandomHexColor();

        $error = '';
        $show_error = false;

        if ($title=='') {
            $show_error = true;
            $error.= 'Folder Title is required.';
        }

        if ($show_error) {
            echo json_encode(array(
                'success' => true,
                'msg' => $error
            ));
        }

        $current_user = wp_get_current_user();
        $id_user = $current_user->ID;

        // Insert into database
        global $wpdb;
        $table_name = $wpdb->prefix . 'fm_folder';

        $folder_data = $unique_key != '' ? user_folder_by_key($unique_key) : [];
        $id_folder = isset($folder_data['id_folder']) ? $folder_data['id_folder'] : 'NULL';

        $data = [
            'id_user' => $id_user,
            'id_parent' => $id_folder,
            'unique_key' => generateUniqueKey(),
            'status' => 'private',
            'title' => $title,
            // 'description' => $description,
            // 'bg_color' => $bg_color,
            // 'back_color' => $back_color
        ];

        $result = $wpdb->insert($table_name, $data);
        
        // get inserted id
        $row_id = $wpdb->insert_id;

        $data['id_folder'] = $row_id;

        if ($result === false) {
            echo json_encode(array(
                'success' => false,
                'msg' => 'Folder can not be added.'
            ));
        } else {
            echo json_encode(array(
                'success' => true,
                'msg' => 'Folder added successfully.',
                // 'data' => $data,
                'html' => folder_template($data),
            ));
        }

        exit;
    }

    /**
     * Add file of user
     *
     * @return array
     */
    public function add_file() {
        // Check nonce
        // if ( !isset($_POST['form_nonce']) || !wp_verify_nonce($_POST['form_nonce'], 'form_submit') ) {
        //     wp_send_json_error('Invalid nonce');
        // }

        // Sanitize and validate form input
        $unique_key     = isset($_POST['id']) ? sanitize_text_field($_POST['id']) : '';
        $title = $ext = '';
        // $description    = isset($_POST['description']) ? sanitize_text_field($_POST['description']) : '';
        // $bg_color       = generateLighterHexColor();
        // $back_color     = generateRandomHexColor();

        $current_user = wp_get_current_user();
        $id_user = $current_user->ID;

        // Insert into database
        global $wpdb;
        $table_name = $wpdb->prefix . 'fm_file';
        
        $folder_data = $unique_key != '' ? user_folder_by_key($unique_key) : [];
        $id_folder = isset($folder_data['id_folder']) ? $folder_data['id_folder'] : 'NULL';
        $folder_dir = get_folder_nav_array($id_folder);

        $dir = [];
        if ($folder_dir) {
            foreach ($folder_dir as $key => $item) {
                $dir[] = $item['title'];
            }
        }

        /* img upload */
        if (!empty($_FILES["file"])) {
            $file = $_FILES["file"];

            // Allow certain file formats
            $imageFileType = explode('.', $file['name']);
            $title = isset($imageFileType[0]) ? $imageFileType[0] : '';
            $ext = end($imageFileType);

            $upload_dir = wp_upload_dir();
            $target_dir = $upload_dir['basedir'] . '/' . $id_user . '/' . implode('/', $dir);            

            // Create user directory if it doesn't exist
            if (!file_exists($target_dir)) {
                wp_mkdir_p($target_dir);
            }

            $target_file = $target_dir . '/' . basename($file['name']);

            $data = [
                'id_user' => $id_user,
                'id_folder' => $id_folder,
                'status' => 'private',
                'title' => $title,
                'ext' => $ext
            ];

            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                $wpdb->insert($table_name, $data);
                // get inserted id
                $row_id = $wpdb->insert_id;

                $data['id_file'] = $row_id;

                $result = true;
            } else {
                $result = false;
            }
            
        }        

        if ($result === false) {
            echo json_encode(array(
                'success' => false,
                'msg' => 'File can not be added.'
            ));
        } else {
            echo json_encode(array(
                'success' => true,
                'msg' => 'File added successfully.',
                // 'data' => $data,
                // 'html' => folder_template($data),
            ));
        }

        exit;
    }

    /**
     * Update collection
     *
     * @return array
     */
    public function update_collection() {
        // Check nonce
        if ( !isset($_POST['form_nonce']) || !wp_verify_nonce($_POST['form_nonce'], 'form_submit') ) {
            wp_send_json_error('Invalid nonce');
        }

        // Sanitize and validate form input
        $id_collection  = isset($_POST['id']) ? sanitize_text_field($_POST['id']) : '';
        $title          = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
        $description    = isset($_POST['description']) ? sanitize_text_field($_POST['description']) : '';

        $error = '';
        $show_error = false;

        if ($title=='') {
            $show_error = true;
            $error.= 'Collection title Field is required.';
        }

        if ($show_error) {
            echo json_encode(array(
                'success' => true,
                'msg' => $error
            ));
            exit();
        }

        $current_user = wp_get_current_user();
        $id_user = $current_user->ID;

        // Insert into database
        global $wpdb;
        $table_name = $wpdb->prefix . 'bookmark_collections';

        $data = [
            'title' => $title,
            'description' => $description
        ];

        // Run the update query
        $result = $wpdb->update(
            $table_name, // Table Name
            array(
                'title' => $data['title'],
                'description' => $data['description']
            ), // Data array
            array('id_collection' => $id_collection), //Where array
            array('%s','%s'), // Data format: integer
        );

        $data['id_collection'] = $id_collection;

        if ($result === false) {
            echo json_encode(array(
                'success' => false,
                'msg' => 'Collection can not be updated.'
            ));
        } else {
            echo json_encode(array(
                'success' => true,
                'msg' => 'Collection updated successfully.',
                'data' => $data,
            ));
        }

        exit;
    }

    /**
     * Archive item of user by id
     *
     * @return array
     */
    public function delete_item() {
        
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $type = isset($_POST['type']) ? $_POST['type'] : '';

        if ($type=='file') {
            $old_data = user_file_by_id($id);
        } else {
            $old_data = user_folder_by_id($id);
        }

        $current_user = wp_get_current_user();
        $id_user = $current_user->ID;

        if (isset($old_data['id_user']) && $old_data['id_user'] != $id_user) {
            echo json_encode(['success' => false, 'msg' => 'Don\'t have access']);
            exit;
        }
        
        global $wpdb;

        if ($type=='file') {
            // Run the update query
            $result = $wpdb->update(
                $wpdb->prefix . 'fm_file',
                array('trash' => 1),
                array('id_file' => $id),
                array('%d'), // Data format: integer
                array('%d') // Data format: integer
            );
        } else {
            // Run the update query
            $result = $wpdb->update(
                $wpdb->prefix . 'fm_folder',
                array('trash' => 1),
                array('id_folder' => $id),
                array('%d'), // Data format: integer
                array('%d') // Data format: integer
            );
        }

        if ($result === false) {
            echo json_encode(array(
                'success' => false,
                'msg' => 'Item can not be deleted.'
            ));
        } else {
            echo json_encode(array(
                'success' => true,
                'msg' => 'Item deleted.'
            ));
        }

        exit;
    }
}
new FM_Core_Users();