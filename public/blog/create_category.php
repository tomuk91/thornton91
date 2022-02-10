<?php require_once('../../private/initialize.php'); ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<?php
/*PAGE ACCESS CONTROL*/
if(!$session->is_admin()) {
    header("Location: ../index.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $values = $_POST['post'];
    $category = new categories($values);
    $result = $category->create();
    if($result) {
        $session->message('The category was successfully created');
        header('Location: ../admin/index.php');
    } else {
        echo "There was a problem creating the category";
        echo $database->error;
    }

}

?>


<div class="form_container">
    <h2>Create Category</h2>
    <p>Fill in the details below to create a new category</p>

<form class="form_template" action="<?php echo site_url('/blog/create_category.php');?>" 
    method="post">

    <dl>
        <dt>Title</dt>
        <dd><input type="text" required="required" name="post[title]"></dd>
    </dl>
    <dl>
        <dt>MetaTitle</dt>
        <dd><input type="text" required="required" name="post[metaTitle]"></dd>
    </dl>
    <dl>
        <dt>Content</dt>
        <dd><input type="text" required="required" name="post[content]"></dd>
    </dl>
    <input class="submit" type="submit" value="Create Category">
</form>



</div>





<?php include(SHARED_PATH . '/footer.php'); ?>