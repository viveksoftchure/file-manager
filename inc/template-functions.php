<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package file-manager
 */

// Add a pingback url auto-discovery header for single posts, pages, or attachments
function theme_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action('wp_head', 'theme_pingback_header');


/**
* get content estimated reading time
*/
if (!function_exists('theme_content_estimated_reading_time')) 
{
    /**
     * Function that estimates reading time for a given $content.
     * @param string $content Content to calculate read time for.
     * @paramint $wpm Estimated words per minute of reader.
     * @returns int $time Esimated reading time.
     */
    function theme_content_estimated_reading_time($content = '', $wpm = 200)
    {
        $clean_content = strip_shortcodes($content);
        $clean_content = strip_tags($clean_content);
        $word_count = str_word_count($clean_content);
        $time = ceil($word_count / $wpm);
        $output = $time . esc_attr__(' min read', 'wpwebguru');
        return $output;
    }
}

/**
 * Short Title
 */
if (!function_exists('theme_short_title'))
{
    function theme_short_title($title, $length = 30) 
    {
        if (strlen($title) > $length) 
        {
            return substr($title, 0, $length) . ' ...';
        }
        else 
        {
            return $title;
        }
    }
}

/**
* Comment navigation
*/
function theme_get_post_navigation()
{
    if (get_comment_pages_count() > 1 && get_option('page_comments')):
        require(get_template_directory() . '/inc/comment-nav.php');
    endif;
}

require get_template_directory() . '/inc/comment-form.php';


/**
 * Include a template file
 *
 * @param string $file file name or path to file
 */
function fm_load_template( $file, $args = [] ) {
    if ( $args && is_array( $args ) ) {
        extract( $args );
    }

    $template_dir = FM_ROOT . '/template-parts/';

    include $template_dir . $file;
}

/**
 * Get account dashboard's sections
 *
 * @return array
 */
function fm_get_account_sections() {
    $sections = [
        'dashboard'         => ['type' => 'link', 'label' => __( 'Dashboard' ), 'icon' => 'fa-solid fa-house'],
        'drive'             => ['type' => 'link', 'label' => __( 'My Drive' ), 'icon' => 'fa-solid fa-hard-drive'],
        'favourites'        => ['type' => 'link', 'label' => __( 'Favourites' ), 'icon' => 'fa-solid fa-star'],
        'trash'             => ['type' => 'link', 'label' => __( 'Trash' ), 'icon' => 'fa-solid fa-trash-can'],
        'options'           => ['type' => 'heading', 'label' => __( 'Options' )],
        'edit-profile'      => ['type' => 'link', 'label' => __( 'Edit Profile' ), 'icon' => 'fa-solid fa-user-pen'],
        'change-password'   => ['type' => 'link', 'label' => __( 'Change Password' ), 'icon' => 'fa-solid fa-key'],
    ];

    return apply_filters( 'fm_account_sections', $sections );
}


add_action('template_redirect', function () {
    ob_start();
});

/**
 * Returns value by key from array if set
 *
 * @param array $array
 * @param string $key
 * @param mixed $default
 * @param bool $strict
 * @return mixed
 */
function ifset($array, $key, $default = null, $strict = false) {
    if ($strict) {
        return !empty($array[$key]) ? $array[$key] : $default;
    }
    return isset($array[$key]) ? $array[$key] : $default;
}

/**
 * Save alert message to the current user session
 *
 * @param string $message
 * @param string $type
 * @return mixed
 */
function alert_push($message, $type = 'success') {
    $_SESSION['alert'][$type] = $message;
}

/**
 * Retrieve alert messages from current user session
 *
 * @return array
 */
function alert_shift() {
    $result = [];
    $types = ['success', 'info', 'warning', 'danger'];

    foreach($types as $k => $type) {
        if (isset($_SESSION['alert'][$type])) {
            $result[$k] = $_SESSION['alert'][$type];
            unset($_SESSION['alert'][$type]);
        } else {
            $result[$k] = '';
        }
    }
    return array_combine($types, $result);
}

/**
 * start and end session on login and logout
 *
 * @return array
 */
add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

function myEndSession() {
    session_destroy ();
}

/**
* WP Custom Excerpt Length Function
* Place in functions.php
* This example returns ten words, then [...]
* Manual excerpts will override this
*/
add_filter( 'excerpt_length', 'wp_custom_excerpt_length', 999 );
function wp_custom_excerpt_length( $length ) {
    return 24;
}

/*
* Get Excerpt length by count
*/
function get_excerpt( $count ) {
    $permalink = get_permalink($post->ID);
    $excerpt = get_the_content();
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $count);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = $excerpt.'...';
    return $excerpt;
}

/**
 * Show/hide admin bar to the permitted user level
 *
 * @return void
 */
add_filter( 'show_admin_bar', 'show_admin_bar_user' );
function show_admin_bar_user( $val ) {
    // if ( ! is_user_logged_in() ) {
        return false;
    // }

    $roles        = [ 'administrator', 'editor', 'author', 'contributor' ];
    $roles        = $roles && is_string( $roles ) ? [ strtolower( $roles ) ] : $roles;
    $current_user = wp_get_current_user();

    if ( ! empty( $current_user->roles ) && ! empty( $current_user->roles[0] ) ) {
        if ( ! in_array( $current_user->roles[0], $roles ) ) {
            return false;
        }
    }

    return $val;
}

/**
 * Get Terms by texonomy
 * 
 * @param string $taxonomy
 * @param int $parent_of
 * @param int $child_of
 * @return array
 */
function get_user_dp($user_id, $size = '') {
    $user_info = '';
    $user_pic = trailingslashit(get_template_directory_uri()) . 'assets/images/member-avatar.png';

    $user_info = get_userdata($user_id);
    if ($user_info == true) {
        $image_link = array();
        if (get_user_meta($user_id, 'chaksucity_user_pic', true) != "") {
            $attach_id = get_user_meta($user_id, 'chaksucity_user_pic', true);
            $image_link = wp_get_attachment_image_src($attach_id, $size);
        }

        if (isset($image_link[0]) && $image_link[0] != "") {
            return $image_link[0];
        } else {
            return $user_pic;
        }
    } else {
        return $user_pic;
    }
}

/**
 * Check user name
 * 
 * @param string $username
 * @return string
 */
function check_user_name($username = '') {
    if (username_exists($username)) {
        $random = rand(10,100);
        $username   =   $username . '-' . $random;
        check_user_name($username);     
    }
    return $username;
}

/**
* generate pagination for given counts
*
* @param int $current current page number
* @param int $num_pages total pages
* @param int $edge_number_count count of pages to show before and after current page
* @return array
*/
function getPageRange($current_page, $num_pages, $edge_number_count = 5) {
    $start_number = $current_page - $edge_number_count;
    $end_number = $current_page + $edge_number_count;
    
    // Minus one so that we don't split the start number unnecessarily, eg: "1 ... 2 3" should start as "1 2 3"
    if ( ($start_number - 1) < 1 ) {
        $start_number = 1;
        $end_number = min($num_pages, $start_number + ($edge_number_count*2));
    }
    
    // Add one so that we don't split the end number unnecessarily, eg: "8 9 ... 10" should stay as "8 9 10"
    if ( ($end_number + 1) > $num_pages ) {
        $end_number = $num_pages;
        $start_number = max(1, $num_pages - ($edge_number_count*2));
    }
    
    if ( $end_number == $num_pages && (($edge_number_count*2) + 1) > ($end_number - $start_number) && $start_number > 1 ) {
        $start_number = $end_number - ($edge_number_count*2);
    }
    
    return array( $start_number, $end_number );
}

/**
 * Get Terms by texonomy
 * 
 * @param string $taxonomy
 * @param int $parent_of
 * @param int $child_of
 * @return array
 */
function chaksucity_google_locations($action_on_complete = '') {
    $stricts = "";

    echo "<script>
        function chaksucity_location() {
            var componentForm = {
                street_number: 'short_name',
                route: 'long_name',
                locality: 'long_name',
                administrative_area_level_1: 'long_name',
                administrative_area_level_3: 'long_name',
                country: 'long_name',
                postal_code: 'short_name'
            };

            var input = document.getElementById('address_location');
            var options = {" . $stricts . "};
            var autocomplete = new google.maps.places.Autocomplete(input, options);

            new google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                console.log(place);
                document.getElementById('d_latt').value = place.geometry.location.lat();
                document.getElementById('d_long').value = place.geometry.location.lng();

                for (var component in componentForm) {
                    if (!!jQuery('#' + component)) {
                        jQuery('#' + component).val('');
                    }
                }
                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    if (componentForm[addressType] && jQuery('#' + addressType)) {
                        var val = place.address_components[i][componentForm[addressType]];
                        jQuery('#' + addressType).val(val);
                    }
                }

                var markers = [{
                    'title': '',
                    'lat': place.geometry.location.lat(),
                    'lng': place.geometry.location.lng(),
                }];

                my_g_map(markers);
            });
        }
    </script>";
}

function generateLighterHexColor() {
    // Generate random RGB values
    $red = rand(150, 255); // Increase minimum value
    $green = rand(150, 255); // Increase minimum value
    $blue = rand(150, 255); // Increase minimum value

    // Convert RGB to hex
    $hex = sprintf("#%02x%02x%02x", $red, $green, $blue);

    return $hex;
}

function generateRandomHexColor() {
    // Generate random RGB values
    $red = rand(0, 255);
    $green = rand(0, 255);
    $blue = rand(0, 255);

    // Convert RGB to hex
    $hex = sprintf("#%02x%02x%02x", $red, $green, $blue);

    return $hex;
}

function generateUniqueKey($length = 26) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * Return icon based on file type
 *
 * @param string $ext
 * @return string
 */
function getIcon($ext) {
    $ext = strtolower($ext);

    if ($ext == 'mp3') {
        return ASSETS_DIR . 'icons/music.svg';
    }
    if ($ext == 'pdf') {
        return ASSETS_DIR . 'icons/pdf.svg';
    }
    if ($ext == 'txt') {
        return ASSETS_DIR . 'icons/txt.svg';
    }
    if ($ext == 'zip') {
        return ASSETS_DIR . 'icons/zip.svg';
    }
    if ($ext == 'json') {
        return ASSETS_DIR . 'icons/json.svg';
    }
    if (in_array($ext, ['jpg','jpeg','gif','png','svg'])) {
        return ASSETS_DIR . 'icons/image.svg';
    }
    if (in_array($ext, ['doc','docx'])) {
        return ASSETS_DIR . 'icons/doc.svg';
    }
    if (in_array($ext, ['xls','xlsx','csv'])) {
        return ASSETS_DIR . 'icons/xls.svg';
    }
    if (in_array($ext, ['mp4','avi','mpeg','mpg','mkv','mka'])) {
        return ASSETS_DIR . 'icons/video.svg';
    }
    if (in_array($ext, ['html'])) {
        return ASSETS_DIR . 'icons/file.svg';
    }
}

/**
 * get user folders by user id
 *
 * @param int $id_folder
 * @return array
 */
function user_folders($id_folder = '') {
    global $current_user;
    global $wpdb;
    $table_name = $wpdb->prefix . 'fm_folder';

    if ($id_folder!='') {
        $query = $wpdb->prepare("
            SELECT * 
            FROM $table_name 
            WHERE `id_user`= %s 
            AND `id_parent`= %s 
            AND `trash` != 1
            order by id_folder desc ",
            $current_user->ID,
            $id_folder
        );
    } else {
        $query = $wpdb->prepare("
            SELECT * 
            FROM $table_name 
            WHERE `id_user` = %s 
            AND `id_parent` IS NULL 
            AND `trash` != 1
            order by id_folder desc ",
            $current_user->ID
        );
    }
          
    $data = $wpdb->get_results($query, ARRAY_A);

    // echo '<pre>'; print_r($wpdb->last_query); echo '</pre>'; exit();

    return $data;
}

/**
 * get user folders by user id
 *
 * @param int $id_folder
 * @return array
 */
function user_trash_folders($id_folder = '') {
    global $current_user;
    global $wpdb;
    $table_name = $wpdb->prefix . 'fm_folder';

    if ($id_folder!='') {
        $query = $wpdb->prepare("
            SELECT * 
            FROM $table_name 
            WHERE `id_user`= %s 
            AND `id_parent`= %s 
            AND `trash` = 1
            order by id_folder desc ",
            $current_user->ID,
            $id_folder
        );
    } else {
        $query = $wpdb->prepare("
            SELECT * 
            FROM $table_name 
            WHERE `id_user` = %s 
            AND `id_parent` IS NULL 
            AND `trash` = 1
            order by id_folder desc ",
            $current_user->ID
        );
    }
          
    $data = $wpdb->get_results($query, ARRAY_A);

    // echo '<pre>'; print_r($wpdb->last_query); echo '</pre>'; exit();

    return $data;
}

/**
 * get user folder by id_folder
 *
 * @param int $id_folder
 * @return array
 */
function user_folder_by_id($id_folder) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'fm_folder';

    $data = $wpdb->get_row($wpdb->prepare("
        SELECT * 
        FROM $table_name 
        WHERE `id_folder`= $id_folder"
    ), ARRAY_A);
          
    return $data;
}

/**
 * get user folder by unique_key
 *
 * @param string $unique_key
 * @return array
 */
function user_folder_by_key($unique_key) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'fm_folder';

    $data = $wpdb->get_row($wpdb->prepare("
        SELECT * 
        FROM $table_name 
        WHERE `unique_key`= %s",
        $unique_key
    ), ARRAY_A);
          
    return $data;
}

/**
 * get user folders by user id
 *
 * @param int $id_folder
 * @return array
 */
function user_files($id_folder = '') {
    global $current_user;
    global $wpdb;
    $table_name = $wpdb->prefix . 'fm_file';

    if ($id_folder!='') {
        $query = $wpdb->prepare("
            SELECT * 
            FROM $table_name 
            WHERE `id_user`= %s 
            AND `id_folder`= %s 
            AND `trash` != 1
            order by title asc ",
            $current_user->ID,
            $id_folder
        );
    } else {
        $query = $wpdb->prepare("
            SELECT * 
            FROM $table_name 
            WHERE `id_user` = %s  
            AND `trash` != 1
            order by title asc ",
            $current_user->ID
        );
    }
          
    $data = $wpdb->get_results($query, ARRAY_A);

    // echo '<pre>'; print_r($wpdb->last_query); echo '</pre>'; exit();

    return $data;
}

/**
 * get user folders by user id
 *
 * @param int $id_folder
 * @return array
 */
function user_trash_files($id_folder = '') {
    global $current_user;
    global $wpdb;
    $table_name = $wpdb->prefix . 'fm_file';

    if ($id_folder!='') {
        $query = $wpdb->prepare("
            SELECT * 
            FROM $table_name 
            WHERE `id_user`= %s 
            AND `id_folder`= %s 
            AND `trash` = 1
            order by title asc ",
            $current_user->ID,
            $id_folder
        );
    } else {
        $query = $wpdb->prepare("
            SELECT * 
            FROM $table_name 
            WHERE `id_user` = %s  
            AND `trash` = 1
            order by title asc ",
            $current_user->ID
        );
    }
          
    $data = $wpdb->get_results($query, ARRAY_A);

    // echo '<pre>'; print_r($wpdb->last_query); echo '</pre>'; exit();

    return $data;
}

/**
 * get user file by id_file
 *
 * @param int $id_file
 * @return array
 */
function user_file_by_id($id_file) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'fm_file';

    $data = $wpdb->get_row($wpdb->prepare("
        SELECT * 
        FROM $table_name 
        WHERE `id_file`= $id_file"
    ), ARRAY_A);
          
    return $data;
}

/**
 * get folder template
 *
 * @param array $data
 * @return string
 */
function folder_template($data, $trash = false) {

    $id_folder      = isset($data['id_folder']) ? $data['id_folder'] : '';
    $unique_key     = isset($data['unique_key']) ? $data['unique_key'] : '';
    $status         = isset($data['status']) ? $data['status'] : '';
    $title          = isset($data['title']) ? $data['title'] : '';
    $description    = isset($data['description']) ? $data['description'] : '';
    $bg_color       = isset($data['bg_color']) ? $data['bg_color'] : '';
    $back_color     = isset($data['back_color']) ? $data['back_color'] : '';

    $html = '<div class="folder-item" id="folder_'.$id_folder.'">';
        $html.= '
        <label class="folder-item-select">
            <input class="checkbox-input invisible" type="checkbox">
            <span class="checkbox_box"></span>
            <span class=""></span>
        </label>';

        $html.= '
        <a class="folder-item-link" href="'.site_url('dashboard/?section=drive&folder='.$unique_key).'">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80" fill="none" class=""><path fill="#FFA000" d="M64.65 12H15.19c-4.007-.007-7.26 3.195-7.267 7.15 0 .322.02.644.064.963a1.451 1.451 0 0 0 1.63 1.24c.194-.025.38-.088.55-.186a4.161 4.161 0 0 1 2.114-.552H22.64c1.869.005 3.53 1.179 4.137 2.924l.247.786c1 2.925 3.776 4.897 6.904 4.905H67.56a4.407 4.407 0 0 1 2.173.575c.224.128.478.195.736.195.803 0 1.455-.643 1.455-1.436V19.18c0-3.965-3.257-7.179-7.274-7.179Z"></path><path fill="#FFC107" d="M71.363 27.622a7.316 7.316 0 0 0-3.655-.975H33.992a4.395 4.395 0 0 1-4.148-2.934l-.248-.79C28.593 19.988 25.81 18.01 22.675 18H12.292a7.043 7.043 0 0 0-3.57.931A7.175 7.175 0 0 0 5 25.206v34.588C5 63.774 8.265 67 12.292 67h55.416C71.735 67 75 63.774 75 59.794v-25.94a7.141 7.141 0 0 0-3.637-6.232Z"></path></svg>
            <p class="folder-item-title">'.$title.'</p>
        </a>';

        $html.= '<div class="dropdown-wrap">';
            $html.= '
            <button type="button" class="dropdown-button" aria-label="Folder Action Button">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0.5" viewBox="0 0 24 24" height="20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M12 3C11.175 3 10.5 3.675 10.5 4.5C10.5 5.325 11.175 6 12 6C12.825 6 13.5 5.325 13.5 4.5C13.5 3.675 12.825 3 12 3ZM12 18C11.175 18 10.5 18.675 10.5 19.5C10.5 20.325 11.175 21 12 21C12.825 21 13.5 20.325 13.5 19.5C13.5 18.675 12.825 18 12 18ZM12 10.5C11.175 10.5 10.5 11.175 10.5 12C10.5 12.825 11.175 13.5 12 13.5C12.825 13.5 13.5 12.825 13.5 12C13.5 11.175 12.825 10.5 12 10.5Z"></path></svg>
            </button>';

            if ($trash) {
                $html.= '
                <div class="dropdown-menu hidden">
                    <button type="button" class="dropdown-item btn-restore" data-type="folder" data-id="'.$id_folder.'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-steel-400 me-1.5"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path><path d="M12 7v5l4 2"></path></svg>Restore
                    </button>
                    <button type="button" class="dropdown-item btn-delete-forever" data-type="folder" data-id="'.$id_folder.'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-steel-400 me-1.5"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>Delete Forever
                    </button>
                </div>';
            } else {
                $html.= '
                <div class="dropdown-menu hidden">
                    <button type="button" class="dropdown-item btn-favourite" data-type="folder" data-id="'.$id_folder.'">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="text-steel-400 me-1.5" height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z"></path></svg>Add to Favourite
                    </button>
                    <button type="button" class="dropdown-item btn-move" data-type="folder" data-id="'.$id_folder.'">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="text-steel-400 me-1.5" height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM4 5V19H20V7H11.5858L9.58579 5H4ZM12 12V9L16 13L12 17V14H8V12H12Z"></path></svg>Move to
                    </button>
                    <button type="button" class="dropdown-item btn-rename" data-type="folder" data-id="'.$id_folder.'">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="text-steel-400 me-1.5" height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33365L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6474L14.435 2.21233C14.8256 1.8218 15.4587 1.8218 15.8492 2.21233L18.6777 5.04075C19.0682 5.43128 19.0682 6.06444 18.6777 6.45497L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z"></path></svg>Rename
                    </button>
                    <button type="button" class="dropdown-item btn-delete" data-type="folder" data-id="'.$id_folder.'">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="text-steel-400 me-1.5" height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM9 11H11V17H9V11ZM13 11H15V17H13V11ZM9 4V6H15V4H9Z"></path></svg>Move to trash
                    </button>
                </div>';
            }

        $html.= '</div>';
    $html.= '</div>';

    return $html;
}

/**
 * get folder template
 *
 * @param array $data
 * @return string
 */
function file_template($data, $trash = false) {

    $id_file        = isset($data['id_file']) ? $data['id_file'] : '';
    $id_folder      = isset($data['id_folder']) ? $data['id_folder'] : '';
    $status         = isset($data['status']) ? $data['status'] : '';
    $title          = isset($data['title']) ? $data['title'] : '';
    $ext            = isset($data['ext']) ? $data['ext'] : '';
    $description    = isset($data['description']) ? $data['description'] : '';

    $file_icon      = getIcon($ext);

    $html = '<div class="folder-item" id="file_'.$id_file.'">';
        $html.= '
        <label class="folder-item-select">
            <input class="checkbox-input invisible" type="checkbox">
            <span class="checkbox_box"></span>
            <span class=""></span>
        </label>';

        $html.= '
        <a class="folder-item-link" href="#">
            <img src="'.$file_icon.'" class="folder-icon">
            <p class="folder-item-title">'.$title.'</p>
        </a>';

        $html.= '<div class="dropdown-wrap">';
            $html.= '
            <button type="button" class="dropdown-button" aria-label="Folder Action Button">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0.5" viewBox="0 0 24 24" height="20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M12 3C11.175 3 10.5 3.675 10.5 4.5C10.5 5.325 11.175 6 12 6C12.825 6 13.5 5.325 13.5 4.5C13.5 3.675 12.825 3 12 3ZM12 18C11.175 18 10.5 18.675 10.5 19.5C10.5 20.325 11.175 21 12 21C12.825 21 13.5 20.325 13.5 19.5C13.5 18.675 12.825 18 12 18ZM12 10.5C11.175 10.5 10.5 11.175 10.5 12C10.5 12.825 11.175 13.5 12 13.5C12.825 13.5 13.5 12.825 13.5 12C13.5 11.175 12.825 10.5 12 10.5Z"></path></svg>
            </button>';

            if ($trash) {
                $html.= '
                <div class="dropdown-menu hidden">
                    <button type="button" class="dropdown-item btn-restore" data-type="file" data-id="'.$id_file.'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-steel-400 me-1.5"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path><path d="M12 7v5l4 2"></path></svg>Restore
                    </button>
                    <button type="button" class="dropdown-item btn-delete-forever" data-type="file" data-id="'.$id_file.'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-steel-400 me-1.5"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>Delete Forever
                    </button>
                </div>';
            } else {
                $html.= '
                <div class="dropdown-menu hidden">
                    <button type="button" class="dropdown-item btn-share" data-type="file" data-id="'.$id_file.'">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="text-steel-400 me-1.5" height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M13.1202 17.0228L8.92129 14.7324C8.19135 15.5125 7.15261 16 6 16C3.79086 16 2 14.2091 2 12C2 9.79086 3.79086 8 6 8C7.15255 8 8.19125 8.48746 8.92118 9.26746L13.1202 6.97713C13.0417 6.66441 13 6.33707 13 6C13 3.79086 14.7909 2 17 2C19.2091 2 21 3.79086 21 6C21 8.20914 19.2091 10 17 10C15.8474 10 14.8087 9.51251 14.0787 8.73246L9.87977 11.0228C9.9583 11.3355 10 11.6629 10 12C10 12.3371 9.95831 12.6644 9.87981 12.9771L14.0788 15.2675C14.8087 14.4875 15.8474 14 17 14C19.2091 14 21 15.7909 21 18C21 20.2091 19.2091 22 17 22C14.7909 22 13 20.2091 13 18C13 17.6629 13.0417 17.3355 13.1202 17.0228ZM6 14C7.10457 14 8 13.1046 8 12C8 10.8954 7.10457 10 6 10C4.89543 10 4 10.8954 4 12C4 13.1046 4.89543 14 6 14ZM17 8C18.1046 8 19 7.10457 19 6C19 4.89543 18.1046 4 17 4C15.8954 4 15 4.89543 15 6C15 7.10457 15.8954 8 17 8ZM17 20C18.1046 20 19 19.1046 19 18C19 16.8954 18.1046 16 17 16C15.8954 16 15 16.8954 15 18C15 19.1046 15.8954 20 17 20Z"></path></svg>Share & Get Link
                    </button>
                    <button type="button" class="dropdown-item btn-favourite" data-type="file" data-id="'.$id_file.'">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="text-steel-400 me-1.5" height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z"></path></svg>Add to Favourite
                    </button>
                    <button type="button" class="dropdown-item btn-move" data-type="file" data-id="'.$id_file.'">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="text-steel-400 me-1.5" height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM4 5V19H20V7H11.5858L9.58579 5H4ZM12 12V9L16 13L12 17V14H8V12H12Z"></path></svg>Move to
                    </button>
                    <button type="button" class="dropdown-item btn-download" data-type="file" data-id="'.$id_file.'">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="mr-1.5 text-steel-400" height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M3 19H21V21H3V19ZM13 13.1716L19.0711 7.1005L20.4853 8.51472L12 17L3.51472 8.51472L4.92893 7.1005L11 13.1716V2H13V13.1716Z"></path></svg>Download
                    </button>
                    <button type="button" class="dropdown-item btn-rename" data-type="file" data-id="'.$id_file.'">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="text-steel-400 me-1.5" height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33365L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6474L14.435 2.21233C14.8256 1.8218 15.4587 1.8218 15.8492 2.21233L18.6777 5.04075C19.0682 5.43128 19.0682 6.06444 18.6777 6.45497L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z"></path></svg>Rename
                    </button>
                    <button type="button" class="dropdown-item btn-duplicate" data-type="file" data-id="'.$id_file.'">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="text-steel-400 me-1.5" height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M6 7V4C6 3.44772 6.44772 3 7 3H13.4142L15.4142 5H21C21.5523 5 22 5.44772 22 6V16C22 16.5523 21.5523 17 21 17H18V20C18 20.5523 17.5523 21 17 21H3C2.44772 21 2 20.5523 2 20V8C2 7.44772 2.44772 7 3 7H6ZM6 9H4V19H16V17H6V9ZM8 5V15H20V7H14.5858L12.5858 5H8Z"></path></svg>Duplicate
                    </button>
                    <button type="button" class="dropdown-item btn-delete" data-type="file" data-id="'.$id_file.'">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="text-steel-400 me-1.5" height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM9 11H11V17H9V11ZM13 11H15V17H13V11ZM9 4V6H15V4H9Z"></path></svg>Move to trash
                    </button>
                </div>';
            }

        $html.= '</div>';
    $html.= '</div>';

    return $html;
}

function get_folder_nav_array($id_folder, $add_home = false) {
    global $wpdb;

    $breadcrumb = [];
    
    while ($id_folder != null) {
        $folder = user_folder_by_id($id_folder);

        if ($folder) {
            array_unshift($breadcrumb, ['key' => $folder['unique_key'], 'title' => $folder['title']]); // Add the folder name to the beginning of the breadcrumb array
            $id_folder = $folder['id_parent']; // Set the current folder id to its parent id
        } else {
            break; // If no more parent folders, break the loop
        }
    }

    if ($add_home) {
        array_unshift($breadcrumb, ['key' => '', 'title' => 'Home']); // Add the root folder to the beginning of the breadcrumb array
    }
    
    return $breadcrumb; // Convert the breadcrumb array to a string with '->' separator
}

function get_folder_breadcrumb($id_folder) {
    $breadcrumb = get_folder_nav_array($id_folder, true);

    $data = [];
    foreach ($breadcrumb as $key => $item) {
        $folder_link = $item['key'] != '' ? site_url("dashboard/?section=drive&folder=".$item["key"]) : site_url("dashboard/?section=drive");
        $data[] = '<a class="" href="'.$folder_link.'">'.$item["title"].'</a>';
    }
    
    return implode('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="text-steel-500 dark:text-steel-400"><path d="m9 18 6-6-6-6"></path></svg>', $data); // Convert the breadcrumb array to a string with '->' separator
}