<?php require_once('../../private/initialize.php'); ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<?php
/*PAGE ACCESS CONTROL*/
if(!$session->is_admin()) {
    header("Location: ../index.php");
}

$id = $_GET['id'];
$category = categories::find_by_id($id);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $result = $category->delete();
    if($result) {
        $session->message('The category was successfully deleted');
        header("Location: ../admin/index.php");
    }
}

?>

<div class="form_container form_template">
    <form  action="<?php echo site_url('blog/delete_category.php?id=' . htmlentities($id)); ?>" method="post">
        <h2>Are you sure you want to delete this Category?</h2>
        <h2><?php echo htmlspecialchars($category->title); ?></h2>
        <p>Note: This action cannot be undone.</p>
        <input class="submit" type="submit" name="submit" value="Delete Category" />
    </form>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>