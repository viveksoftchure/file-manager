<?php
$unique_key = isset($_GET['folder']) ? $_GET['folder'] : '';
$folder_data = $unique_key != '' ? user_folder_by_key($unique_key) : [];
$id_folder = isset($folder_data['id_folder']) ? $folder_data['id_folder'] : '';

$folders = user_folders($id_folder);
$files = user_files($id_folder);

$breadcrumb = get_folder_breadcrumb($id_folder);

?>

<div class="dashboard-header">
    <h1 class="page-title">Saves</h1>
</div>

<nav class="flex items-center justify-start space-x-2 text-sm w-full">
    <?= $breadcrumb ?>
</nav>
<div class="folder-list grid grid-cols-7 gap-15">
    <?php if ($folders): ?>
        <?php foreach ($folders as $key => $item): ?>
            <?= folder_template($item) ?>
        <?php endforeach; ?>
    <?php else: ?>

    <?php endif; ?>
    <?php if ($files): ?>
        <?php foreach ($files as $key => $item): ?>
            <?= file_template($item) ?>
        <?php endforeach; ?>
    <?php else: ?>

    <?php endif; ?>
</div>