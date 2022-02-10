<?php require_once('../../private/initialize.php'); ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<?php
$id = $_GET['id'];

/*PAGE ACCESS CONTROL*/
if(!$session->is_admin() or !isset($id)) {
    header("Location: ../index.php");
}

$category = categories::find_by_id($id);
    if($category == false) {
        header("Location: index.php");
    }

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $values = $_POST['post'];
    $category->merge_object_values($values);
    $result = $category->save();

    if($result === true) {
        $session->message('The Category was successfully edited');
        header("Location: ../admin/index.php");
    } else {
        echo $database->error;
        echo $database->errno;
    }
} else {
    
}
?>
<div class="form_container">
    <h2>Update Category</h2>
    <p>Update the details below to update category details</p>

<form class="form_template" action="<?php echo site_url('/blog/edit_category.php?id=' . htmlspecialchars($id));?>" 
    method="post">
    <dl>
        <dt>Title</dt>
        <dd><input type="text" required="required" name="post[title]" value="<?php echo htmlspecialchars($category->title);?>
        "></dd>
    </dl>
    <dl>
        <dt>MetaTitle</dt>
        <dd><input type="text" required="required" name="post[metaTitle]" value="<?php echo htmlspecialchars
        ($category->metaTitle);?>"></dd>
    </dl>
    <dl>
        <dt>Content</dt>
        <dd><input type="text" required="required" name="post[content]" value="<?php echo htmlspecialchars
        ($category->content);?>"></dd>
    </dl>
    <input class="submit" type="submit" value="Update Category">
</form>


<?php include(SHARED_PATH . '/footer.php'); ?>