<?php
/**
 * Used any time that get_search_form() is called.
 *
 * @package file-manager
 */
$bookmark_unique_id = wp_unique_id('search-');
?>
<form  id="<?php echo esc_attr($bookmark_unique_id); ?>"  action="<?php echo esc_url(home_url( '/' )); ?>" method="GET" class="search-form">
    <div class="search-form-box flex">
    	<input type="text"  name="s"  placeholder="<?php echo esc_attr_x( 'Type to search', 'placeholder', 'bookmark' ); ?>" value="<?php echo get_search_query(); ?>" class="search-input" id="search-input" aria-label="Type to search" role="searchbox">
    	<button class="search-btn" type="submit" aria-label="Submit search"><svg class="search-icon" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" role="img" aria-label="Search"><path d="M11.4 10l4.6 4.6-1.4 1.4-4.5-4.6v-.7l-.3-.2c-1.1.9-2.4 1.4-3.9 1.4-1.6 0-3-.6-4.2-1.7C.6 9 0 7.6 0 6s.6-3 1.7-4.2C2.9.6 4.3 0 5.9 0s3 .6 4.2 1.8C11.3 3 11.8 4.4 11.8 6c0 1.5-.5 2.8-1.4 3.9l.3.2h.7V10zM3 8.9c.8.8 1.8 1.1 2.9 1.1S8 9.6 8.8 8.9C9.6 8.1 10 7.1 10 6s-.4-2.2-1.2-3C8 2.2 7.1 1.8 5.9 1.8 4.8 1.8 3.8 2.2 3 3c-.8.8-1.2 1.8-1.2 3 0 1.1.4 2.1 1.2 2.9z"></path></svg></button>
    </div>
</form>