<?php

$msg = '<div class="wpwg-message">' . sprintf( __( 'This page is restricted. Please <a href="#" class="site-login" >Log in</a> to view this page.' )) . '</div>';
echo wp_kses_post( apply_filters( 'wpwg_account_unauthorized', $msg ) );