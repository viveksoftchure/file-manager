<?php
$user_info = get_userdata(get_current_user_id());
$user_id = $user_info->ID;
?>
<div class="dashboard-header list-individual">
    <h1 class="page-title">Password & Security</h1>
    <p class="pt-1">Manage your password settings and secure your account.</p>
</div>

<div class="personal-info-block">
    <form method="post" id="changePassword" data-disable="false">
        <div class="row align-items-end mb-2">
            <div class="col-sm-6 mb-2">
                <label for="account-password" class="form-label">Current password</label>
                <div class="password-toggle">
                    <input type="password" name="current_pass" id="account-password" class="form-control" required>
                    <i class="toggle-password cc-eye-on"></i>
                </div>
            </div>
            <div class="col-sm-6 mb-2">
                <!-- <a href="javascript:void(0);" class="d-inline-block mb-2">Forgot password?</a> -->
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-sm-6 mb-3">
                <label for="account-password-new" class="form-label">New password</label>
                <div class="password-toggle">
                    <input type="password" name="pass1" class="form-control" placeholder="<?php echo esc_html__("New Password", 'dwt-listing'); ?>" required>
                    <i class="toggle-password cc-eye-on"></i>
                </div>
            </div>
            <div class="col-sm-6 mb-3">
                <label for="account-password-confirm" class="form-label">Confirm password</label>
                <div class="password-toggle">
                    <input type="password" name="pass2" class="form-control" placeholder="<?php echo esc_html__("Confirm New Password", 'dwt-listing'); ?>" required>
                    <i class="toggle-password cc-eye-on"></i>
                </div>
            </div>
        </div>
        <?php wp_nonce_field( 'account-update-password' ); ?>

        <button type="submit" class="btn btn-primary"  data-label="Update password"><?php echo esc_html__("Update password", 'dwt-listing'); ?></button>
    </form>
</div>
