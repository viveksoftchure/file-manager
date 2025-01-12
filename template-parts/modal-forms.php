<?php
$unique_key = isset($_GET['folder']) ? $_GET['folder'] : '';
?>

<div id="update_bookmark_modal" class="hidden">
    <div class="hidden">
        <div class="form-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z"/></svg></div>
        <div class="form-title">Update Bookmark</div>
        <div class="button-title">Update</div>
        <input type="hidden" name="action" id="action" value="update_bookmark">
        <input type="hidden" name="id" id="id" value="">
        <?php wp_nonce_field('form_submit', 'form_nonce'); ?>
    </div>
    <div class="form-row">
        <input type="text" name="title" id="title" class="form-control" placeholder="Title">
    </div>
    <div class="form-row">
        <input type="text" name="site_name" id="site_name" class="form-control" placeholder="Site Name">
    </div>
    <div class="form-row">
        <input type="url" name="image" id="image" class="form-control" placeholder="Image url">
    </div>
    <div class="form-row">
        <textarea name="description" id="description" class="form-control" rows="2" placeholder="Description"></textarea>
    </div>
    <div class="form-row">
        <textarea name="note" id="note" class="form-control" rows="2" placeholder="Note"></textarea>
    </div>
</div>

<div id="add_folder_modal" class="hidden">
    <div class="hidden">
        <div class="form-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0 96C0 43 43 0 96 0h96V190.7c0 13.4 15.5 20.9 26 12.5L272 160l54 43.2c10.5 8.4 26 .9 26-12.5V0h32 32c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32v64c17.7 0 32 14.3 32 32s-14.3 32-32 32H384 96c-53 0-96-43-96-96V96zM64 416c0 17.7 14.3 32 32 32H352V384H96c-17.7 0-32 14.3-32 32z"/></svg></div>
        <div class="form-title">New Folder</div>
        <div class="button-title">Create</div>
        <input type="hidden" name="action" id="action" value="add_folder">
        <input type="hidden" name="id" value="<?= $unique_key ?>">
        <?php wp_nonce_field('form_submit', 'form_nonce'); ?>
    </div>

    <div class="form-row">
        <input type="text" name="title" id="title" class="form-control" value="Untitled folder">
    </div>
</div>

<div id="add_to_collection_modal" class="hidden">
    <div class="hidden">
        <div class="form-icon"></div>
        <div class="form-title">Add To collection</div>
        <div class="button-title">Save To collection</div>
        <input type="hidden" name="action" id="action" value="add_to_collection">
        <input type="hidden" name="id" id="id" value="">
        <?php wp_nonce_field('form_submit', 'form_nonce'); ?>
    </div>
    <div class="form-row">
        <select name="collection" id="collection" class="form-control">
            <option value="">Select Folder</option>
            <?php foreach (user_folders() as $key => $item): ?>
                <option value="<?= $item['id_collection'] ?>"><?= $item['title'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div id="file-uploader-wrap">
    <div class="file-uploader-header">
        <h2 data-file-count="0">File Uploading</h2>
    </div>
    <div class="file-uploader-body">
        
    </div>
</div>
<?php /*/ ?>