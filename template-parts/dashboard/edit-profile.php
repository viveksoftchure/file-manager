<?php
$user_info = get_userdata(get_current_user_id());
$user_id = $user_info->ID;
$get_user_dp = get_user_dp($user_id, 'chaksucity_user-dp');
chaksucity_google_locations();
wp_enqueue_script("google-map-callback");

// echo '<pre>'; print_r($user_info); echo '</pre>';
?>

<div class="dashboard-header list-individual">
    <h1 class="page-title">Personal Info</h1>
    <p class="pt-1">Manage your profile settings and social accounts.</p>
</div>

<label for="account-bio" class="form-label pt-2">Short bio</label>

<form method="post" id="profile-update">
    <div class="row pb-2">
        <div class="col-lg-9 col-sm-8 mb-4">
            <textarea name="description" id="account-bio" rows="6" placeholder="Write your bio here. It will be displayed on your public profile." class="form-control"><?php echo esc_textarea($user_info->description); ?></textarea>
        </div>
        <div class="col-lg-3 col-sm-4 mb-4">
            <div class="avatar-upload">
                <div class="avatar-edit">
                    <div class="p-image">
                        <input class="profile-file-upload" name="my_file_upload" type="file" accept="image/*">
                        <i class="cc-camera-plus profile-upload-button" title="<?php echo esc_html__('Upload profile image', 'dwt-listing'); ?>"></i>
                    </div>
                </div>
                <div class="avatar-preview">
                    <?php $hide = $get_user_dp ? 'style="display:none"' : ''; ?>
                    <div class="dz-text" <?= $hide ?>>Click or drag files to upload</div>
                    <div id="imagePreview" style="background-image: url(<?php echo esc_url($get_user_dp); ?>);"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="personal-info-block">
        <div class="accordion-field-item">
            <div class="accordion-field-header">
                <div class="field-info">
                    <label class="form-label"><?php echo esc_html__('First name', 'dwt-listing'); ?></label>
                    <div class="form-value"><?php echo esc_attr($user_info->first_name); ?></div>
                </div>
                <div class="field-btn-box">
                    <i class="cc-edit"></i>
                </div>
            </div>
            <div class="accordion-field-body">
                <div class="field-block">
                    <input type="text" name="first_name" placeholder="<?php echo esc_html__('City or Write your complete name', 'dwt-listing'); ?>" value="<?php echo esc_attr($user_info->first_name); ?>" class="form-control" id="">
                </div>
            </div>
        </div>

        <div class="accordion-field-item">
            <div class="accordion-field-header">
                <div class="field-info">
                    <label class="form-label"><?php echo esc_html__('Last name', 'dwt-listing'); ?></label>
                    <div class="form-value"><?php echo esc_attr($user_info->last_name); ?></div>
                </div>
                <div class="field-btn-box">
                    <i class="cc-edit"></i>
                </div>
            </div>
            <div class="accordion-field-body">
                <div class="field-block">
                    <input type="text" name="last_name" placeholder="<?php echo esc_html__('City or Write your complete name', 'dwt-listing'); ?>" value="<?php echo esc_attr($user_info->last_name); ?>" class="form-control" id="">
                </div>
            </div>
        </div>

        <div class="accordion-field-item">
            <div class="accordion-field-header">
                <div class="field-info">
                    <label class="form-label"><?php echo esc_html__('Nickname (Display Name)', 'dwt-listing'); ?></label>
                    <div class="form-value"><?php echo esc_attr($user_info->nickname); ?></div>
                </div>
                <div class="field-btn-box">
                    <i class="cc-edit"></i>
                </div>
            </div>
            <div class="accordion-field-body">
                <div class="field-block">
                    <input type="text" name="username" placeholder="<?php echo esc_html__('Nickname (Display Name)', 'dwt-listing'); ?>" value="<?php echo esc_attr($user_info->nickname); ?>" class="form-control" id="">
                </div>
            </div>
        </div>
        
        <div class="accordion-field-item">
            <div class="accordion-field-header">
                <div class="field-info">
                    <label class="form-label"><?php echo esc_html__('Email', 'dwt-listing'); ?></label>
                    <div class="form-value"><?php echo esc_attr($user_info->user_email); ?></div>
                </div>
            </div>
        </div>

        <div class="accordion-field-item">
            <div class="accordion-field-header">
                <div class="field-info">
                    <label class="form-label"><?php echo esc_html__('Date of birth', 'dwt-listing'); ?></label>
                    <div class="form-value"><?php echo esc_attr($user_info->user_birth); ?></div>
                </div>
                <div class="field-btn-box">
                    <i class="cc-edit"></i>
                </div>
            </div>
            <div class="accordion-field-body">
                <div class="field-block">
                    <input type="date" name="user_birth" placeholder="<?php echo esc_html__('Date of birth', 'dwt-listing'); ?>" value="<?php echo esc_attr($user_info->user_birth); ?>" class="form-control" id="">
                </div>
            </div>
        </div>
        
        <div class="accordion-field-item">
            <div class="accordion-field-header">
                <div class="field-info">
                    <label class="form-label"><?php echo esc_html__('Phone No.', 'dwt-listing'); ?></label>
                    <div class="form-value"><?php echo esc_attr($user_info->user_phone); ?></div>
                </div>
                <div class="field-btn-box">
                    <i class="cc-edit"></i>
                </div>
            </div>
            <div class="accordion-field-body">
                <div class="field-block">
                    <input type="tel" class="form-control" name="user_phone" placeholder="<?php echo esc_html__('Contact number', 'dwt-listing'); ?>" value="<?php echo esc_attr($user_info->user_phone); ?>">
                </div>
            </div>
        </div>
        
        <div class="accordion-field-item">
            <div class="accordion-field-header">
                <div class="field-info">
                    <label class="form-label"><?php echo esc_html__('Location', 'dwt-listing'); ?></label>
                    <div class="form-value"><?php echo esc_attr($user_info->user_location); ?></div>
                </div>
                <div class="field-btn-box">
                    <i class="cc-edit"></i>
                </div>
            </div>
            <div class="accordion-field-body">
                <div class="field-block">
                    <input type="text" id="address_location" class="form-control" name="user_location" placeholder="<?php echo esc_html__('Your Location', 'dwt-listing'); ?>" value="<?php echo esc_attr($user_info->user_location); ?>">
                </div>
            </div>
        </div>

        <div class="pt-4">
            <label class="form-label fw-bold mb-3">Socials</label>
        </div>

        <div class="d-flex align-items-center mt-3 mb-3">
            <div class="btn btn-icon btn-light btn-xs shadow-sm rounded-circle pe-none flex-shrink-0 mr-3">
                <i class="cc-facebook"></i>
            </div>
            <input type="text" name="social-facebook" placeholder="<?php echo esc_html__('Your Facebook account', 'dwt-listing'); ?>" class="form-control" value="<?php echo esc_attr($user_info->d_fb_link); ?>">
        </div>

        <div class="d-flex align-items-center mb-3">
            <div class="btn btn-icon btn-light btn-xs shadow-sm rounded-circle pe-none flex-shrink-0 mr-3">
                <i class="cc-twitter"></i>
            </div>
            <input type="text" name="social-twitter" placeholder="<?php echo esc_html__('Your Twitter account', 'dwt-listing'); ?>" class="form-control" value="<?php echo esc_attr($user_info->d_twitter_link); ?>">
        </div>

        <div class="d-flex align-items-center mb-3">
            <div class="btn btn-icon btn-light btn-xs shadow-sm rounded-circle pe-none flex-shrink-0 mr-3">
                <i class="cc-linkedin"></i>
            </div>
            <input type="text" name="social-linkedin" placeholder="<?php echo esc_html__('Your LinkedIn account', 'dwt-listing'); ?>" class="form-control" value="<?php echo esc_attr($user_info->d_linked_link); ?>">
        </div>

        <div class="d-flex align-items-center mb-3">
            <div class="btn btn-icon btn-light btn-xs shadow-sm rounded-circle pe-none flex-shrink-0 mr-3">
                <i class="cc-youtube"></i>
            </div>
            <input type="text" name="social-youtube" placeholder="<?php echo esc_html__('Your Youtube account', 'dwt-listing'); ?>" class="form-control" value="<?php echo esc_attr($user_info->d_youtube_link); ?>">
        </div>

        <div class="d-flex align-items-center mb-3">
            <div class="btn btn-icon btn-light btn-xs shadow-sm rounded-circle pe-none flex-shrink-0 mr-3">
                <i class="cc-instagram"></i>
            </div>
            <input type="text" name="social-instagram" placeholder="<?php echo esc_html__('Your Instagram account', 'dwt-listing'); ?>" class="form-control" value="<?php echo esc_attr($user_info->d_insta_link); ?>">
        </div>

        <div class="d-flex align-items-center justify-content-between border-top mt-4 pt-4 pb-1">
            <button type="submit" id="p_up" class="btn btn-primary" data-label="Save changes"><?php echo esc_html__("Save changes", 'dwt-listing'); ?></button>
            <a href="javascript:void(0)" data-userid="<?php echo esc_attr($user_id); ?>" class="btn btn-outline-primary delete-my-account"><i class="cc-trash"></i> <?php echo esc_html__('Delete My Account', 'dwt-listing'); ?></a> 
        </div>
    </div>
    <?php wp_nonce_field( 'account-update-profile' ); ?>
</form>