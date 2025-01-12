<?php

// Register Custom Post Type
function bookmark_post_type() {

    $labels = array(
        'name'                  => _x( 'Bookmarks', 'Post Type General Name', 'bookmark' ),
        'singular_name'         => _x( 'Bookmark', 'Post Type Singular Name', 'bookmark' ),
        'menu_name'             => __( 'Bookmarks', 'bookmark' ),
        'name_admin_bar'        => __( 'Bookmark', 'bookmark' ),
        'archives'              => __( 'Item Archives', 'bookmark' ),
        'attributes'            => __( 'Item Attributes', 'bookmark' ),
        'parent_item_colon'     => __( 'Parent Item:', 'bookmark' ),
        'all_items'             => __( 'All Items', 'bookmark' ),
        'add_new_item'          => __( 'Add New Item', 'bookmark' ),
        'add_new'               => __( 'Add New', 'bookmark' ),
        'new_item'              => __( 'New Item', 'bookmark' ),
        'edit_item'             => __( 'Edit Item', 'bookmark' ),
        'update_item'           => __( 'Update Item', 'bookmark' ),
        'view_item'             => __( 'View Item', 'bookmark' ),
        'view_items'            => __( 'View Items', 'bookmark' ),
        'search_items'          => __( 'Search Item', 'bookmark' ),
        'not_found'             => __( 'Not found', 'bookmark' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'bookmark' ),
        'featured_image'        => __( 'Featured Image', 'bookmark' ),
        'set_featured_image'    => __( 'Set featured image', 'bookmark' ),
        'remove_featured_image' => __( 'Remove featured image', 'bookmark' ),
        'use_featured_image'    => __( 'Use as featured image', 'bookmark' ),
        'insert_into_item'      => __( 'Insert into item', 'bookmark' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'bookmark' ),
        'items_list'            => __( 'Items list', 'bookmark' ),
        'items_list_navigation' => __( 'Items list navigation', 'bookmark' ),
        'filter_items_list'     => __( 'Filter items list', 'bookmark' ),
    );
    $args = array(
        'label'                 => __( 'Bookmark', 'bookmark' ),
        'description'           => __( 'Bookmark Description', 'bookmark' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions', 'post-formats' ),
        'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-paperclip',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'bookmarks', $args );

}
add_action( 'init', 'bookmark_post_type', 0 );


/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function add_bookmark_meta_box() {


    add_meta_box(
        'meta_info', // $id
        'Meta Information', // $title 
        'show_bookmark_meta_box', // $callback
        'bookmarks', // $page
        'normal', // $context
        'high' // $priority
    );
}
add_action( 'add_meta_boxes', 'add_bookmark_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function show_bookmark_meta_box( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'bookmark', 'bookmark_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $meta_title         = get_post_meta( $post->ID, 'meta_title', true );
    $meta_description   = get_post_meta( $post->ID, 'meta_description', true );
    $meta_type          = get_post_meta( $post->ID, 'meta_type', true );
    $meta_url           = get_post_meta( $post->ID, 'meta_url', true );
    $meta_image         = get_post_meta( $post->ID, 'meta_image', true );

    ?>
    <div class="meta-field">
        <div class="meta-label">
            <label for="meta_title"><?= _e('Meta Title') ?></label>
        </div>
        <div class="meta-input">
            <div class="meta-input-wrap">
                <input type="text" id="meta_title" name="meta_title" class="meta-control" value="<?= esc_attr( $meta_title ) ?>">
            </div>
        </div>
    </div>

    <div class="meta-field">
        <div class="meta-label">
            <label for="meta_description"><?= _e('Meta Description') ?></label>
        </div>
        <div class="meta-input">
            <div class="meta-input-wrap">
                <input type="text" id="meta_description" name="meta_description" class="meta-control" value="<?= esc_attr( $meta_description ) ?>">
            </div>
        </div>
    </div>

    <div class="meta-field">
        <div class="meta-label">
            <label for="meta_type"><?= _e('Meta Type') ?></label>
        </div>
        <div class="meta-input">
            <div class="meta-input-wrap">
                <input type="text" id="meta_type" name="meta_type" class="meta-control" value="<?= esc_attr( $meta_type ) ?>">
            </div>
        </div>
    </div>

    <div class="meta-field">
        <div class="meta-label">
            <label for="meta_url"><?= _e('Meta Url') ?></label>
        </div>
        <div class="meta-input">
            <div class="meta-input-wrap">
                <input type="text" id="meta_url" name="meta_url" class="meta-control" value="<?= esc_attr( $meta_url ) ?>">
            </div>
        </div>
    </div>

    <div class="meta-field">
        <div class="meta-label">
            <label for="meta_image"><?= _e('Meta Image') ?></label>
        </div>
        <div class="meta-input">
            <div class="meta-input-wrap">
                <input type="text" id="meta_image" name="meta_image" class="meta-control" value="<?= esc_attr( $meta_image ) ?>">
            </div>
        </div>
    </div>
    <?php
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
add_action( 'save_post', 'save_bookmark_meta_box_data' );
function save_bookmark_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['bookmark_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['bookmark_nonce'], 'bookmark' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'bookmarks' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if ( ! isset( $_POST['meta_title'] ) ) {
        return;
    }

    // Update the meta field in the database.
    update_post_meta( $post_id, 'meta_title', sanitize_text_field( $_POST['meta_title'] ) );
    update_post_meta( $post_id, 'meta_description', sanitize_text_field( $_POST['meta_description'] ) );
    update_post_meta( $post_id, 'meta_type', sanitize_text_field( $_POST['meta_type'] ) );
    update_post_meta( $post_id, 'meta_url', sanitize_text_field( $_POST['meta_url'] ) );
    update_post_meta( $post_id, 'meta_image', sanitize_text_field( $_POST['meta_image'] ) );
}