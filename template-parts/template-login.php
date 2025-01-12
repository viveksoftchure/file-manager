<?php
/**
 * Template Name: Login Template
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
                    <h2 class="h3 mb-4 mb-sm-5">
                        Hey there!<br />
                        Welcome back.
                    </h2>
                    <img src="<?= ASSETS_DIR ?>/signin.svg" width="344" alt="Illustartion" class="d-block mx-auto" />
                    <div class="mt-4 mt-sm-5">Don't have an account? <a href="<?= site_url('register') ?>">Sign up here</a></div>
                </div>
                <div class="col-md-6 px-2 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">
                    <div class="alert alert-success" role="alert">
                        <i class="cc-check-circle lead me-2 me-sm-3"></i>
                        <div class="alert-desc"></div>
                    </div>

                    <a href="#" class="btn btn-outline-info w-100 mb-3"><i class="cc-google fs-lg me-1"></i>Sign in with Google</a>
                    <a href="#" class="btn btn-outline-info w-100 mb-3"><i class="cc-facebook fs-lg me-1"></i>Sign in with Facebook</a>
                    <div class="d-flex align-items-center py-3 mb-3">
                        <hr class="w-100" />
                        <div class="px-3">Or</div>
                        <hr class="w-100" />
                    </div>
                    <form class="login-form" id="login-form" action="" method="post">
                        <div class="mb-4">
                            <label for="signin-email" class="form-label mb-2">Email address</label>
                            <input type="email" name="emailAddress" id="emailAddress" class="form-control input-lg" pattern="[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,4}" placeholder="Email Address" required=""/>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label for="signin-password" class="form-label mb-0">Password</label>
                                <a href="#" class="fs-sm">Forgot password?</a>
                            </div>
                            <div class="password-toggle">
                                <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Enter password" tabindex="5" required="" />
                                <i class="toggle-password cc-eye-on"></i>
                            </div>
                        </div>
                        <?php wp_nonce_field('login_user_nonce', 'login_user_nonce'); ?>
                        <button type="submit" class="btn btn-primary submit-btn btn-lg w-100">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();