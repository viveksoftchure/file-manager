<?php
/**
 * Template Name: Register Template
 * Template Post Type: page
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

if(is_user_logged_in()) {
    wp_redirect( site_url('account') );
}

get_header();
?>
<div class="main">
    <section class="inner-page bg2 py-5">
        <div class="user-auth-box card" style="max-width: 940px;">
            <div class="row mx-0 align-items-center">
                <div class="col-md-6 border-end-md p-2 p-sm-5">
                    <h2 class="h3 mb-4 mb-sm-5">BookMark.<br>Get premium benefits:</h2>
                    <ul class="list-unstyled mb-4 mb-sm-5">
                        <li class="d-flex mb-2">
                            <i class="fi-check-circle text-primary mt-1 me-2"></i>
                            <span>Add and promote your listings</span>
                        </li>
                        <li class="d-flex mb-2">
                            <i class="fi-check-circle text-primary mt-1 me-2"></i>
                            <span>Easily manage your wishlist</span>
                        </li>
                        <li class="d-flex mb-0">
                            <i class="fi-check-circle text-primary mt-1 me-2"></i>
                            <span>Leave reviews</span>
                        </li>
                    </ul>
                    <img src="<?= ASSETS_DIR ?>/signup.svg" width="344" alt="Illustartion" class="d-block mx-auto" />
                    <div class="mt-4 mt-sm-5">Already have an account? <a href="<?= site_url('login') ?>">Sign in</a></div>
                </div>
                <div class="col-md-6 px-2 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">
                    <div class="alert alert-success" role="alert">
                        <i class="cc-check-circle lead me-2 me-sm-3"></i>
                        <div class="alert-desc"></div>
                    </div>

                    <?php
                    $gmail_api_key = '';
                    $fb_api_key = '';

                    //if ($gmail_api_key != ""):
                        ?>
                        <a id="google_login" href="javascript:void(0)" class="btn btn-outline-info w-100 mb-3 google" onclick="hello('google').login({scope: 'email'})">
                            <i class="cc-google fs-lg me-1"></i>Sign in with Google
                        </a>
                    <?php //endif; ?>
                    <?php
                    //if ($fb_api_key != ""):
                        ?>
                        <a id="facebook_login" href="javascript:void(0)" class="btn btn-outline-info w-100 facebook" onclick="hello('facebook').login({scope: 'email'})">
                            <i class="cc-facebook fs-lg me-1"></i>Sign in with Facebook
                        </a>
                    <?php //endif; ?>

                    <div class="d-flex align-items-center py-3 mb-3">
                        <hr class="w-100" />
                        <div class="px-3">Or</div>
                        <hr class="w-100" />
                    </div>
                    <form class="register-form" id="register-form" action="" method="post">
                        <div class="mb-4">
                            <label for="first_name" class="form-label mb-2">First Name</label>
                            <input
                                type="text"
                                name="first_name"
                                id="first_name"
                                value=""
                                class="form-control input-lg"
                                pattern="[A-Za-z]+"
                                maxlength="50"
                                title="Please enter only letters"
                                placeholder="First Name"
                                required=""
                            />
                        </div>
                        <div class="mb-4">
                            <label for="last_name" class="form-label mb-2">Last Name</label>
                            <input type="text" name="last_name" id="last_name" value="" class="form-control input-lg" pattern="[A-Za-z]+" maxlength="50" title="Please enter only letters" placeholder="Last Name" required="" />
                        </div>
                        <div class="mb-4">
                            <label for="user_email" class="form-label mb-2">Email address</label>
                            <input
                                type="email"
                                name="user_email"
                                id="user_email"
                                value=""
                                class="form-control input-lg"
                                pattern="[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,4}"
                                placeholder="Email Address"
                                title="Please enter valid email address(eg. xyz@domain.com)"
                                required=""
                            />
                        </div>
                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label for="user_password" class="form-label mb-0">Password</label>
                            </div>
                            <div class="password-toggle">
                                <input type="password" name="user_password" id="user_password" class="form-control input-lg" placeholder="Enter password" required="" />
                                <i class="toggle-password cc-eye-on"></i>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label for="user_cpassword" class="form-label mb-0">Cofirm Password</label>
                            </div>
                            <div class="password-toggle">
                                <input type="password" name="user_cpassword" id="user_cpassword" class="form-control input-lg" placeholder="Confirm password" required="" />
                                <i class="toggle-password cc-eye-on"></i>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="col-xs-12 col-sm-7">
                                <span><input type="checkbox" class="custom-checkbox" name="is_remember" id="is_remember"></span>
                                <label for="is_remember"><?php echo esc_html__('Remember Me'); ?></label>
                            </div>
                        </div>
                        <?php wp_nonce_field('register_user_nonce', 'register_user_nonce'); ?>
                        <button type="submit" class="btn btn-primary submit-btn btn-lg w-100">Sign up</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();