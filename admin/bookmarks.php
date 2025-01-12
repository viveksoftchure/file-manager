<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Invalid request.' );
}

/*=============================================================================
====================== Buy requests page callback
=============================================================================*/
function all_bookmarks_page() {
    
    ?>
    <div class="wrap">
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . 'bookmarks';

        // Define pagination parameters
        // $per_page = 5; // Number of rows per page
        // $page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Current page number

        // Calculate the starting row for the current page
        // $start = ($page - 1) * $per_page;

        // Retrieve all data
        // $data = $wpdb->get_results("SELECT * FROM $table_name LIMIT $start, $per_page", ARRAY_A);
        $data = $wpdb->get_results("SELECT * FROM $table_name order by id_bookmark desc", ARRAY_A);

        // Query to count total number of rows
        // $total_rows = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

        // Calculate total number of pages
        // $total_pages = ceil($total_rows / $per_page);
        ?>
        <h1 class="wp-heading-inline">Bookmarks</h1>

        <?php

        // list($min, $max) = getPageRange($page, $total_pages);
        ?>

        <?php /*if($pageCount) { ?>
            <div class="pagination-container mb-custom-2">
                <div class="btn-group">
                    <a href="#" data-page="1" type="button" class="btn btn-white pagination-btn"><i class="fa fa-chevron-left"></i></a>
                    <?php foreach (range($min, $max) as $number): ?>
                        <a href="#" data-page="<?= $number ?>" class="btn btn-white pagination-btn <?= $page==$number?'active':'' ?>"><?= $number ?></a>
                    <?php endforeach; ?>
                    <a href="#" data-page="<?= $pageCount ?>" type="button" class="btn btn-white pagination-btn"><i class="fa fa-chevron-right"></i> </a>
                </div>
            </div>
        <?php }*/ ?>

        <table class="wp-list-table widefat fixed striped table-view-list posts">
            <thead>
                <tr>
                    <th class="manage-column" style="width: 60px;">ID</th>
                    <th class="manage-column">Title</th>
                    <th class="manage-column">Type</th>
                    <th class="manage-column">List</th>
                    <th class="manage-column">Status</th>
                    <th class="manage-column">Date</th>
                    <th class="manage-column">Action</th>
                </tr>
            </thead>

            <tbody id="the-list">
                <?php if($data): ?>
                    <?php foreach($data as $key => $item): ?>
                        <?php
                        $edit_link = '?page=edit-bookmark&id_bookmark='.$item['id_bookmark'].'&action=edit';
                        ?>
                        <tr id="request_<?= $item['id_bookmark'] ?>" class="request-<?= $item['id_bookmark'] ?>">
                            <td><?= $item['id_bookmark'] ?></td>
                            <td><a href="<?= $edit_link ?>"><?= $item['title'] ?></a></td>
                            <td><?= ucfirst($item['type']) ?></td>
                            <td><?= $item['list'] ?></td>
                            <td class="column-status"><?= $item['status'] != '' ? ($item['status'] ? 'Accepted' : 'Rejected') : 'Pending' ?></td>
                            <td><?= date('Y/m/d g:i A', strtotime($item['created_at'])) ?></td>
                            <td>
                                <a class="edit-bookmark btn-success" href="<?= $edit_link ?>">Edit</a>
                                <a class="delete-bookmark btn-danger" style="margin-top:5px" href="">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="no-items"><td class="colspanchange" colspan="7">Not found</td></tr>
                <?php endif; ?>
            </tbody>

            <tfoot>
                <tr>
                    <th class="manage-column">ID</th>
                    <th class="manage-column">Title</th>
                    <th class="manage-column">Type</th>
                    <th class="manage-column">List</th>
                    <th class="manage-column">Status</th>
                    <th class="manage-column">Date</th>
                    <th class="manage-column">Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php
}