<?php
$user_info = get_userdata(get_current_user_id());
$user_id = $user_info->ID;
$get_user_dp = get_user_dp($user_id, 'chaksucity_user-dp');
?>
<div class="user-account-container">
    <div class="user-account-sidebar">
        <div class="user-profile-header">
            <img src="<?php echo esc_url($get_user_dp); ?>" width="48" alt="<?php echo esc_attr($user_info->display_name); ?>" class="rounded-circle">
            <div class="profile-info">
                <h2 class="profile-title"><?php echo esc_attr($user_info->display_name); ?></h2>
                <ul class="profile-list">
                    <?php if($user_info->d_user_contact): ?>
                        <li>
                            <a href="tel:<?php echo esc_attr($user_info->d_user_contact); ?>" class="">
                                <i class="cc-phone opacity-60 me-2"></i><?php echo esc_attr($user_info->d_user_contact); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if($user_info->user_email): ?>
                        <li>
                            <a href="mailto:<?php echo esc_attr($user_info->user_email); ?>" class="">
                                <i class="cc-mail opacity-60 me-2"></i><?php echo esc_attr($user_info->user_email); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="dropdown-wrap">
            <button class="btn btn-primary btn-lg w-100 mb-3 dropdown-button">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 256 256" class="h-4 w-4" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M228,128a12,12,0,0,1-12,12H140v76a12,12,0,0,1-24,0V140H40a12,12,0,0,1,0-24h76V40a12,12,0,0,1,24,0v76h76A12,12,0,0,1,228,128Z"></path></svg>Add New
            </button>

            <div class="dropdown-menu hidden" role="menu">
                <button type="button" class="dropdown-item upload-file">
                    <span class="" aria-label="Upload File Button">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="w-[18px] me-2 text-steel-400 h-auto" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M3 19H21V21H3V19ZM13 5.82843V17H11V5.82843L4.92893 11.8995L3.51472 10.4853L12 2L20.4853 10.4853L19.0711 11.8995L13 5.82843Z"></path></svg>Upload File
                    </span>
                </button>
                <button type="button" class="dropdown-item">
                    <span class="open-modal" data-modal="#modal" data-form="#add_folder_modal" aria-label="Create Folder Button">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="w-[18px] me-2 text-steel-400 h-auto" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM4 5V19H20V7H11.5858L9.58579 5H4ZM11 12V9H13V12H16V14H13V17H11V14H8V12H11Z"></path></svg>Create Folder
                    </span>
                </button>
            </div>
            <form method="post" id="file_form" class="hidden">
                <input type="hidden" name="action" id="action" value="add_file">
                <input type="hidden" name="id" value="<?= $unique_key ?>">
                <?php wp_nonce_field('form_submit', 'form_nonce'); ?>
                <input class="file-upload-input" name="file" type="file" multiple="multiple">
            </form>
        </div>

        <?php //echo '<pre>'; print_r($sections); echo '</pre>'; exit; ?>
        <ul class="dashboard-menu">
            <?php
            foreach ( $sections as $section => $item ) {
                // backward compatibility
                $label  = $item['label'];
                $icon   = isset($item['icon']) ? $item['icon'] : '';
                $type   = isset($item['type']) ? $item['type'] : '';

                $default_active_tab = 'dashboard' ;
                $active_tab         = false;

                if ( ( isset( $_GET['section'] ) && $_GET['section'] == $section ) || ( !isset( $_GET['section'] ) && $default_active_tab == $section ) ) {
                    $active_tab = true;
                }

                $active = $active_tab ? $section . ' active' : $section;

                if ($type=='heading') {
                    echo sprintf(
                        '<li class="profile-dash"><h4 class="user-menu-item menu-heading %s">%s</h4></li>',
                        esc_attr( $active ),
                        esc_attr( $label )
                    );
                } else {
                    echo sprintf(
                        '<li class="profile-dash"><a class="user-menu-item menu-link %s" href="%s"><i class="nav-icon %s"></i>%s</a></li>',
                        esc_attr( $active ),
                        esc_attr( add_query_arg( [ 'section' => $section ], get_permalink() ) ),
                        esc_attr( $icon ),
                        esc_attr( $label )
                    );
                }
            }
            echo sprintf(
                '<li class="profile-dash"><a class="user-menu-item menu-link" href="%s"><i class="nav-icon fa-solid fa-right-from-bracket"></i>%s</a></li>',
                esc_url( wp_logout_url(get_permalink()) ),
                esc_attr( 'Logout' )
             );
            ?>
        </ul>
    </div>

    <div class="user-account-content <?php echo ( !empty( $current_section ) ) ? esc_attr( $current_section ) : ''; ?>">

        <div class="alert alert-success hidden" role="alert">
            <i class="cc-check-circle lead mr-2 mr-sm-3"></i>
            <div class="alert-desc"></div>
        </div>

        <?php
            if ( !empty( $current_section ) && is_user_logged_in() ) {
                do_action( "fm_account_content_{$current_section}", $sections, $current_section );
            }
        ?>
    </div>
</div>
