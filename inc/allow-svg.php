<?php
// Allow SVG
/**
 * Add Mime Types
 */
function theme_svgs_upload_mimes( $mimes = array() ) 
{
    // allow SVG file upload
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'theme_svgs_upload_mimes', 99 );


/**
 * Check Mime Types
 */
function theme_svgs_upload_check( $checked, $file, $filename, $mimes ) 
{
    if ( ! $checked['type'] ) 
    {
        $check_filetype     = wp_check_filetype( $filename, $mimes );
        $ext                = $check_filetype['ext'];
        $type               = $check_filetype['type'];
        $proper_filename    = $filename;

        if ( $type && 0 === strpos( $type, 'image/' ) && $ext !== 'svg' ) 
        {
            $ext = $type = false;
        }
        $checked = compact( 'ext','type','proper_filename' );
    }
    return $checked;
}
add_filter( 'wp_check_filetype_and_ext', 'theme_svgs_upload_check', 10, 4 );


/**
 * Display SVG in attachment modal
 */
function theme_svgs_response_for_svg( $response, $attachment, $meta ) 
{
    if ( $response['mime'] == 'image/svg+xml' && empty( $response['sizes'] ) ) 
    {
        $svg_path = get_attached_file( $attachment->ID );

        if ( ! file_exists( $svg_path ) ) 
        {
            // If SVG is external, use the URL instead of the path
            $svg_path = $response['url'];
        }

        $dimensions = theme_svgs_get_dimensions( $svg_path );

        $response['sizes'] = array(
            'full' => array(
                'url' => $response['url'],
                'width' => $dimensions->width,
                'height' => $dimensions->height,
                'orientation' => $dimensions->width > $dimensions->height ? 'landscape' : 'portrait'
            )
        );
    }
    return $response;
}
add_filter( 'wp_prepare_attachment_for_js', 'theme_svgs_response_for_svg', 10, 3 );

/**
 * Get SVG Dimensions
 */
function theme_svgs_get_dimensions( $svg ) 
{
    $svg = simplexml_load_file( $svg );

    if ( $svg === FALSE ) 
    {
        $width = '0';
        $height = '0';

    } 
    else 
    {
        $attributes = $svg->attributes();
        $width = (string) $attributes->width;
        $height = (string) $attributes->height;
    }
    return (object) array( 'width' => $width, 'height' => $height );
}