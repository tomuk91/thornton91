
<?php require_once('../../private/initialize.php'); ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<?php
$id = $_GET['id'];

/*PAGE ACCESS CONTROL*/
if(!$session->is_admin() or !isset($id)) {
    header("Location: ../index.php");
}

$catergories = categories::find_all_data();
$blog = blog::find_by_id($id);
    if($blog == false) {
        header("Location: index.php");
    }

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $values = $_POST['post'];
    $blog->merge_object_values($values);
    $result = $blog->save();

    if($result === true) {
        $session->message('The post was successfully edited');
        header("Location: ../admin/index.php");
    } else {
        echo "problem edtiing post";
        echo $database->error;
        echo $database->errno;
    }

} else {
    
}

?>

<div class="form_container">
    <h2>Edit Post</h2>

    <?php echo display_errors($blog->errors); ?>

    <form class="form_template" action="<?php echo site_url('/blog/edit.php?id=' . $id); ?>" method="post" />
        <dl>
            <dt>Title</dt>
            <dd><input type="text" name="post[title]" value="<?php echo htmlspecialchars($blog->title); ?>"></dd>
        </dl>
        <dl>
            <dt>Summary</dt>
            <dd><input type="text" name="post[summary]" value="<?php echo htmlspecialchars($blog->summary); ?>"></dd>
        </dl>
        <dl>
            <dt>Category</dt>
            <select id="category" name="post[category_id]">
            <?php foreach($catergories as $category) { ?>
            <option value="<?php echo htmlspecialchars($category->id);?>"<?php if($blog->category_id == $category->id) { echo ' selected'; } 
            ?>><?php echo $category->title;?> </option>
            <?php } ?>
            </select>

        </dl>
        <dl>
            <dt>Content</dt>
            <textarea cols="60" rows="10" name="post[content]"><?php echo htmlspecialchars($blog->content);?></textarea>
        </dl>
        <dl>
            <dt>Publish?</dt>
            <dd><input type="radio" id="r1" value="0" name='post[published]'></dd>
            <label for="r1">No</label><br>
            <dd><input type="radio" id="r2" value="1" name="post[published]"></dd>
            <label for="r2">Yes</label><br>
        </dl>
        <dl>
            <dt>Main Post Picture - Add URL</dt>
            <dd><input type="url" id="url" value="<?php echo htmlspecialchars($blog->image_url);?>" name="post[image_url]"></dd>
        </dl>
        <dl>
            <!--Gets user_id from session to input into the author_id -->
            <dd><input type="hidden" value="<?php echo htmlspecialchars($blog->author_id);?>" name="post[author_id]"></dd>
        </dl>
        <input class="submit" type="submit" value="Update" />
    </form>
</div>
    