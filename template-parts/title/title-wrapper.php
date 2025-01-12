<?php
/**
 * Template part for displaying header page title
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wpwebguru
 */


if ( is_home() ) 
{
    //get_template_part('/template-parts/title/blog-title');
} 
elseif( is_search() ) 
{
    get_template_part('/template-parts/title/blog-title');
} 
elseif( !is_front_page() && is_page() ) 
{
    get_template_part('/template-parts/title/layout', '1');
}  
elseif(is_author()) 
{
    get_template_part('/template-parts/title/author');
} 
elseif(is_archive()) 
{
    get_template_part('/template-parts/title/blog-title');
} 
elseif(is_single()) 
{
    // get_template_part('/template-parts/title/single-post-title');
} 
else {
    // Nothing
}