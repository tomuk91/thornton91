<?php require_once('../../private/initialize.php'); ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<?php
/*PAGE ACCESS CONTROL*/
if(!$session->is_admin()) {
    header("Location: ../index.php");
}

$id = $_GET['id'];
$user = users::find_by_id($id);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $result = $user->delete();
    header("Location: /index.php");
}

?>


<div class="form_container form_template">
    <form  action="<?php echo site_url('admin/delete.php?id=' . htmlentities($id)); ?>" method="post">
        <h2>Are you sure you want to delete this User?</h2>
        <h2><?php echo htmlspecialchars($user->username); ?></h2>
        <p>Note: This action cannot be undone.</p>
        <input class="submit" type="submit" name="submit" value="Delete User" />
    </form>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>