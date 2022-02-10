<?php require_once('../../private/initialize.php'); ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<?php
/*PAGE ACCESS CONTROL*/
if(!$session->is_admin()) {
    header("Location: ../index.php");
}

$id = $_GET['id'];
$post = blog::find_by_id($id);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $result = $post->delete();
    if($result) {
        $session->message('The post was successfully deleted');
        header("Location: ../admin/index.php");
    }
}

?>

<div class="form_container form_template">
    <form  action="<?php echo site_url('blog/delete_post.php?id=' . $id); ?>" method="post">
        <h2>Are you sure you want to delete this Post?</h2>
        <h2><?php echo htmlspecialchars($post->title); ?></h2>
        <p>Note: This action cannot be undone.</p>
        <input class="submit" type="submit" name="submit" value="Delete Post" />
    </form>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>