<?php require_once('../../private/initialize.php'); ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<?php
/*PAGE ACCESS CONTROL*/
if(!$session->is_admin()) {
    header("Location: ../index.php");
}

$catergories = categories::find_all_data();
$user_id = $_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $values = $_POST['post'];
    $post = new blog($values);
    $result = $post->save();
    echo '<pre>' , var_dump($post) , '</pre>';
    if($result) {
        $session->message('The posted was successfully created');
        header('Location: ../admin/index.php');
    } else {
        echo "There was an error creating the post";
        echo $database->errno;
        echo $database->error;
    }

}

?>

<div class="form_container">
    <h2>Create Post</h2>
    <p>Fill in the required fields below to sumbit a post</p>

    <form class="form_template" action="<?php echo site_url('/blog/create_post.php');?>" method="post">
        <dl>
            <dt>Title</dt>
            <dd><input type="text" id="title" required="required" name="post[title]"></dd>
        </dl>
        <dl>
            <dt>Summary</dt>
            <dd><input type="text" id="summary" required="required" name="post[summary]"></dd>
        </dl>
        <dl>
            <dt>Category</dt>
            <select id="category" name="post[category_id]">
            <?php foreach($catergories as $category) { ?>
            <option value="<?php echo htmlspecialchars($category->id);?>"><?php echo $category->title;?></option>
            <?php } ?>
            </select>

        </dl>
        <dl>
            <dt>Content</dt>
            <textarea cols="60" rows="10" required="required" name="post[content]"></textarea>
        </dl>
        <dl>
            <dt>Publish On Sumbit?</dt>
            <dd><input type="radio" id="r1" value="0" name='post[published]'></dd>
            <label for="r1">No</label><br>
            <dd><input type="radio" id="r2" value="1" name="post[published]"></dd>
            <label for="r2">Yes</label><br>
        </dl>
        <dl>
            <dt>Main Post Picture - Add URL</dt>
            <dd><input type="url" id="url" value="http://www." name="post[image_url]"></dd>
        </dl>
        <dl>
            <!--Gets user_id from session to input into the author_id -->
            <dd><input type="hidden" value="<?php echo htmlspecialchars($user_id);?>" name="post[author_id]"></dd>
        </dl>
        <input class="submit" type="submit" value="Create Post">
    </form>
</div>


<?php include(SHARED_PATH . '/footer.php'); ?>