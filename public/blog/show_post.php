<?php require_once('../../private/initialize.php'); ?>


<?php include(SHARED_PATH . '/header.php'); ?>

<?php

$id = $_GET['id'];

$post = blog::find_by_post_id($id);
$date = $post->created_at;
$comments = comments::find_comments($id);
$errors = [];
$banned_syntax = ['<div>', '<p>', '<em>', '<b>', 'class', '<>', '<h1>'];

?>

<?php 
if($_SERVER['REQUEST_METHOD']  == 'POST') {

    $values = $_POST['post'];
    $comment = new comments($values);

    // VALIDATION // 
    if(empty($comment->content)) {
        $errors[] = "Comment cannot be blank";
    } 
    if(strlen($comment->content) > 255) {
        $errors[] = "Comment cannot be longer than 255 characters";
    }
    if($comment->content) {
        $comment->content = filter_var($comment->content, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    }
    $result = $comment->save();
    if(!$result) {
        echo "There was an error posting the comment";
        echo $database->errno;
        echo $database->error;
    } else {
        $session->message('The comment was successfully posted');
        header("Location: show_post.php?id=" . $id);
    }

}

?>

<div class="post_container">
    <div class="display_post">
        <img src="<?php echo htmlspecialchars($post->image_url); ?>">
        <h1><?php echo htmlspecialchars($post->title); ?></h1>
        <hr>
        <h2>Written by <?php echo htmlspecialchars(strtoupper($post->username)); ?></h2>
        <h3><?php echo date_format(new DateTime($date), 'y-m-d');?></h3>
        <p><?php echo htmlspecialchars_decode(html_entity_decode(($post->content))); ?></p>;
    </div>
</div>

<?php echo display_errors($errors); ?>
<?php include(SHARED_PATH . '/comments.php'); ?>

<?php include(SHARED_PATH . '/footer.php'); ?>

