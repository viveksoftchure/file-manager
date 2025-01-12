<div class="dashboard-header">
    <h1 class="page-title">Archive</h1>
</div>
<?php
$page = isset($_GET['pg']) ? $_GET['pg'] : 1;

$bookmarks = user_archive(true, $page, 9);
$bookmarks_count = user_archive();

$pageCount = ceil(count($bookmarks_count) / 9);
list($min, $max) = getPageRange($page, $pageCount);
?>
<?php if($pageCount) { ?>
    <div class="pagination-container mb-4">
        <ul class="pagination">
            <li class="page-item">
                <a href="<?= site_url('account') . '/?section=archive&pg=1' ?>" class="page-link"><i class="fa fa-chevron-left"></i> Prev</a>
            </li>
            <?php foreach (range($min, $max) as $number): ?>
                <li class="page-item <?= $page==$number?'active':'' ?>">
                    <a href="<?= site_url('account') . '/?section=archive&pg='. $number ?>" class="page-link"><?= $number ?></a>
                </li>
            <?php endforeach; ?>
            <li class="page-item">
                <a href="<?= site_url('account') . '/?section=archive&pg='. $pageCount ?>" class="page-link">Next <i class="fa fa-chevron-right"></i></a>
            </li>
        </ul>
    </div>
<?php } ?>

<?php
if ($bookmarks) {
    echo '<div id="scrap-data" class="grid grid-cols-3 gap-15">';
    foreach ($bookmarks as $key => $item) {

        echo bookmark_grid_template($item);

    }
    echo '</div>';
} else {
    // no posts found
}
?>

<?php if($pageCount) { ?>
    <div class="pagination-container mt-4">
        <ul class="pagination">
            <li class="page-item">
                <a href="<?= site_url('account') . '/?section=archive&pg=1' ?>" class="page-link"><i class="fa fa-chevron-left"></i> Prev</a>
            </li>
            <?php foreach (range($min, $max) as $number): ?>
                <li class="page-item <?= $page==$number?'active':'' ?>">
                    <a href="<?= site_url('account') . '/?section=archive&pg='. $number ?>" class="page-link"><?= $number ?></a>
                </li>
            <?php endforeach; ?>
            <li class="page-item">
                <a href="<?= site_url('account') . '/?section=archive&pg='. $pageCount ?>" class="page-link">Next <i class="fa fa-chevron-right"></i></a>
            </li>
        </ul>
    </div>
<?php } ?>