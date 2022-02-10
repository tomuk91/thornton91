<?php require_once('../../private/initialize.php'); ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<?php

$cat_id = $_GET['id'];

$current_page = $_GET['page'] ?? 1;
$per_page = 10;
$posts_total_count = blog::count_by_cat_id($cat_id);

$posts_pagination = new pagination($current_page, $per_page, $posts_total_count);

$sql = "SELECT * FROM posts ";
$sql .= "WHERE category_id='" . $database->escape_string($cat_id) . "' ";
$sql .= "ORDER BY posts.created_at DESC ";
$sql .= "LIMIT {$posts_pagination->per_page} ";
$sql .= "OFFSET {$posts_pagination->offset()}";
$posts = blog::sql_query($sql);

?>

<section class="cat_posts">
    <?php foreach($posts as $post) { ?>
        <div class="cat_post_boxes">
            <img src="<?php echo htmlspecialchars($post->image_url); ?>">
            <h1><?php echo htmlspecialchars($post->title); ?></h1>
            <p><?php echo htmlspecialchars($post->summary); ?></p>
            <h1><a href="<?php echo site_url('/blog/show_post.php?id=' . htmlspecialchars(urlencode($post->id))); ?>"
            >Read More</a></h1>
        </div>
    <?php } ?>
    <?php 
        if($posts_pagination->total_pages() > 1) { 
            echo "<div class=\"pagination\">";

            $url = site_url('/blog/categories.php');
            echo $users_pagination->previous_link($url);
            echo $users_pagination->next_link($url);
            echo "</div>";
        }
        ?>
</section>

<?php include(SHARED_PATH . '/footer.php'); ?>