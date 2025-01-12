<?php

function theme_dynamic_css()
{
    wp_enqueue_style(
        'theme-style',
        get_stylesheet_uri(),
        array(),
        time()
    );
    $site_title_color = get_theme_mod( 'bs_site_title_color_option', '#222' );
    $site_title_size = get_theme_mod( 'bs_site_title_size', '30' );
    $logo_size = absint( $site_title_size * 2 );
    $site_identity_font_family = get_theme_mod( 'bs_site_identity_font_family', 'Merriweather' );
    $bc_image_for_testimonial = get_theme_mod( 'bc_image_for_testimonial', '' );
    $primary_color = get_theme_mod( 'primary_color', '#328af1' );
    $secondary_color = get_theme_mod( 'secondary_color', '#D93E40' );
    $light_color = theme_hex_to_rgba( '#ffffff' );
    $dark_color = theme_hex_to_rgba( '#000000' );
    $text_color = theme_hex_to_rgba( '#757575' );
    $body_font_family = esc_attr( get_theme_mod( 'body_font_family', 'Nunito' ) );
    $font_size = esc_attr( get_theme_mod( 'font_size', '16px' ) );
    $body_font_weight = esc_attr( get_theme_mod( 'body_font_weight', 400 ) );
    $body_line_height = get_theme_mod( 'body_line_height', '1.5' );
    $heading_font_family = esc_attr( get_theme_mod( 'heading_font_family', 'Merriweather' ) );

    $theme_color_mode = esc_attr( get_theme_mod( 'color_mode' ) );

    $dynamic_css = "\r\n:root {\r\n                
                            --color-primary: {$primary_color};
                            --color-secondary: {$secondary_color};
                            --color-secondary-alt: #f7f8fc;
                            --color-header : #fff;
                            --logo-header-height: 40px;
                            --dark-color: {$dark_color};
                            --light-color: {$light_color};
                            --text-color: {$text_color};
                            --color-tertiary: #050505;
                            --color-heading: #000000;
                            --color-body: #000000;
                            --color-gray: #65676B;
                            --color-midgray: #878787;
                            --color-light: #E4E6EA;
                            --color-lighter: #CED0D4;
                            --color-lightest: #F0F2F5;
                            --color-border: #E6E6E6;
                            --color-white: #ffffff;
                            --color-success: #3EB75E;
                            --color-danger: #FF0003;
                            --color-warning: #FF8F3C;
                            --color-info: #1BA2DB;
                            --color-facebook: #3B5997;
                            --color-twitter: #1BA1F2;
                            --color-youtube: #ED4141;
                            --color-linkedin: #0077B5;
                            --color-pinterest: #E60022;
                            --color-instagram: #C231A1;
                            --color-vimeo: #00ADEF;
                            --color-twitch: #6441A3;
                            --color-discord: #7289da;
                            --color-extra01: #666666;
                            --color-extra02: #606770;
                            --color-extra03: #FBFBFD;
                            --color-extra04: #1A1A1A;
                            --color-extra05: #242424;
                            --radius: 10px;
                            --radius-big: 15px;
                            --radius-small: 6px;
                            --border-width: 2px;
                            --p-light: 300;
                            --p-regular: 400;
                            --p-medium: 500;
                            --p-semi-bold: 600;
                            --p-bold: 700;
                            --p-extra-bold: 800;
                            --p-black: 900;
                            --s-light: 300;
                            --s-regular: 400;
                            --s-medium: 500;
                            --s-bold: 700;
                            --s-black: 900;
                            --shadow-primary: 0px 4px 10px rgba(37, 47, 63, 0.1);
                            --shadow-light: 0 2px 6px 0 rgba(0, 0, 0, 0.05);
                            --shadow-dark: 0 2px 6px 0 rgba(0, 0, 0, 0.2);
                            --transition: 0.3s;
                            --font-primary: {$body_font_family};
                            --secondary-font: {$heading_font_family};
                            --font-size-b1: 18px;
                            --font-size-b2: 16px;
                            --font-size-b3: 14px;
                            --font-size-b4: 12px;
                            --line-height-b1: 1.67;
                            --line-height-b2: 1.5;
                            --line-height-b3: 1.6;
                            --line-height-b4: 1.3;
                            --h1: 44px;
                            --h2: 36px;
                            --h3: 30px;
                            --h4: 24px;
                            --h5: 18px;
                            --h6: 16px;
                        }\r\n
                        /* site title size */\r\n
                        .site-title a { 
                            font-size: {$site_title_size}" . "px; 
                            font-family: {$site_identity_font_family}; 
                            color: {$site_title_color}; 
                        }\r\n\r\n
                        header .custom-logo-link img { 
                            height: {$logo_size}" . "px; 
                        }\r\n\r\n
                        /* font family */\r\n
                        html,:root {
                            font-size: {$font_size};
                        }\r\n\r\n
                        body {
                            line-height: {$body_line_height};  
                            font-weight:{$body_font_weight}; 
                        }\r\n\r\n
                        .testimonial:before {\r\n
                            background-image: url({$bc_image_for_testimonial});\r\n
                        }\r\n";

    if ($theme_color_mode=='orange') 
    {
        $dynamic_css.= "\r\n.header-gradient::before {\r\n
                                content: '';
                                background: var(--bs-primary);
                                background: linear-gradient(0deg,rgba(223,35,30,0) 0,#fef1cd 100%);
                                position: absolute;
                                top: 0;
                                left: 0;
                                right: 0;
                                display: block;
                                height: 800px;
                                z-index: -1;
                                transition: all .3s ease-in-out;
                            }\r\n\r\n
                            .footer-gradient::before {\r\n
                                content: '';
                                background: linear-gradient(180deg,rgba(223,35,30,0) 0,#fef1cd 100%);
                                position: absolute;
                                bottom: 0;
                                left: 0;
                                right: 0;
                                display: block;
                                height: 800px;
                                z-index: -1;
                            }\r\n
                            .footer-top {
                                padding-top: 4rem;
                                padding-bottom: 8rem;
                            }\r\n
                            .footer-bottom {
                                border-top: 1px solid rgba(0,0,0,.12);
                                padding-top: 30px;
                            }\r\n";
    }
    if ($theme_color_mode=='blue') 
    {
        $dynamic_css.= "\r\n.header-gradient::before {\r\n
                                content: '';
                                background: var(--bs-primary);
                                background-image: radial-gradient(circle at 2% 0,#365280,#080e17 106%);
                                position: absolute;
                                top: 0;
                                left: 0;
                                right: 0;
                                display: block;
                                height: 630px;
                                z-index: -1;
                                transition: all .3s ease-in-out;
                            }\r\n\r\n
                            footer#colophon {
                                background-image: radial-gradient(circle at 15% -3%,#365280,#080e17 116%);
                                background-position: 50%;
                                background-repeat: no-repeat;
                                background-size: auto;
                                overflow: hidden;
                                position: relative;
                                color: #fff;
                                padding-bottom: 1rem;
                                border-top: none;
                            }\r\n
                            .footer-top {
                                padding-top: 4rem;
                                padding-bottom: 4rem;
                            }\r\n
                            .footer-bottom {
                                border-top: 1px solid rgb(255 255 255 / 10%);
                                padding-top: 30px;
                            }\r\n
                            .logo-wrap .logo-img img {
                                max-height: 68px;
                            }\r\n
                            .secondary-nav .widget-title {
                                text-transform: uppercase;
                            }\r\n
                            .secondary-nav .menu-item {
                                margin-bottom: 8px;
                                line-height: 20px;
                            }\r\n
                            .secondary-nav a {
                                color: rgb(255 255 255 / 50%) !important;
                            }\r\n
                            .secondary-nav a:hover {
                                color: rgb(255 255 255 / 100%) !important;
                            }\r\n
                            .banner-content {
                                color: #fff;
                            }\r\n
                            .banner-image img {
                                /*mix-blend-mode: luminosity;*/
                            }\r\n
                            .header-top .blog-main-nav {
                                border-bottom: none;
                            }
                            .section-title {
                                font-size: 33px;
                                letter-spacing: 0.3px;
                                color: rgb(34 41 47);
                                margin: 0;
                                line-height: 1.5;
                            }
                            .section-desc {
                                font-size: 18px;
                                color: rgb(34 41 47);
                                font-weight: 400;
                            }
                            .post-card {
                                background: #fff;
                            }";
    }


    wp_add_inline_style( 'theme-style', $dynamic_css );
}

add_action( 'wp_enqueue_scripts', 'theme_dynamic_css' );