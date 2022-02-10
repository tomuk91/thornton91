<?php require_once('../../private/initialize.php'); ?>

<?php include(SHARED_PATH . '/header.php'); ?>


<?php
/*ACCESS CONTROL FOR ADMIN PAGE*/
if(!$session->is_admin()) {
    header("Location: ../index.php");
}

/*PAGINATION FOR USERS AND BLOGS TABLES*/

$current_page = $_GET['page'] ?? 1;
$per_page = 5;
$blog_total_count = blog::count_all_data();
$users_total_count = users::count_all_data();

$blog_pagination = new Pagination($current_page, $per_page, $blog_total_count);
$users_pagination = new Pagination($current_page, $per_page, $users_total_count);

$sql = "SELECT * FROM posts ";
$sql .= "ORDER BY posts.created_at DESC ";
$sql .= "LIMIT {$blog_pagination->per_page} ";
$sql .= "OFFSET {$blog_pagination->offset()}";
$posts = blog::sql_query($sql);


$sql = "SELECT * FROM users ";
$sql .= "LIMIT {$users_pagination->per_page} ";
$sql .= "OFFSET {$users_pagination->offset()}";
$users = users::sql_query($sql);

/*END OF PAGINATION*/

$categories = categories::find_all_data();
$admins = users::list_admins();
$comments_total_count = comments::count_all_data();

?>

<!-- QUICK STATS FOR CONSOLE PAGE -->

<div class="grid">
    <div class="quick_stats">

        <div class="container">
            <div class="counter">
            <div class="counter">
                <div class="box">
                <h3>No. Posts:</h3>
                <h1><?php echo htmlspecialchars($blog_total_count); ?></h1>
            </div>
            <div class="counter">
                <div class="box">
                <h3>No. Comments:</h3>
                <h1><?php echo htmlspecialchars($comments_total_count); ?></h1>
            </div>
            </div>
            <div class="counter">
                <div class="box">
                    <h3>No. Users:</h3>
                   <h1><?php echo htmlspecialchars($users_total_count); ?></h1>
                </div>
            </div>
            <div class="counter">
            <h2>Quick Links</h2>
                <div class="box">
                    <h3>Create<br>Post</h3>
                    <a style="color:white;" href="<?php echo site_url('/blog/create_post.php'); ?>">Click Here</a>
                </div>
                <div class="box">
                    <h3>Create Category</h3>
                    <a style="color:white;" href="<?php echo site_url('/blog/create_category.php'); ?>">Click Here</a>
                </div>
            </div>
        </div>
    </div>
    

        <hr>
        
        <!-- START OF TABLES DISPLAYING ADMINS AND POSTS -->
        
    <div class="tables">
        <section class="table">
        
        <h1 >Admins & Users</h1>
        
        <!-- ADMINS TABLE -->
        
            <table class="table_wrapper">
                <caption>Admins</caption>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Registered</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
        
                    <?php foreach($admins as $admin) { ?>
                    <tr>
                        <td><?php echo htmlentities($admin->id); ?></td>
                        <td><?php echo htmlentities($admin->username); ?></td>
                        <td><?php echo htmlentities($admin->first_name); ?></td>
                        <td><?php echo htmlentities($admin->last_name); ?></td>
                        <td><?php echo htmlentities($admin->registered); ?></td>
                        <td><a href="<?php echo site_url('/admin/edit.php?id=' . htmlspecialchars($admin->id)); ?>">Edit</a></td>
                        <td><a href="<?php echo site_url('/admin/delete.php?id=' . htmlspecialchars($admin->id)); ?>">Delete</a></td>
                    </tr>
                    <?php } ?>
            </table>
        
        <!-- USERS TABLE -->
        
            <table class="table_wrapper">
                <caption>Users</caption>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Registered</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
            
                    <?php foreach($users as $user) { ?>
                    <tr>
                        <td><?php echo htmlentities($user->id); ?></td>
                        <td><?php echo htmlentities($user->username); ?></td>
                        <td><?php echo htmlentities($user->first_name); ?></td>
                        <td><?php echo htmlentities($user->last_name); ?></td>
                        <td><?php echo htmlentities($user->registered); ?></td>
                        <td><a href="<?php echo site_url('/admin/edit.php?id=' . htmlspecialchars($user->id));?>">Edit</a></td>
                        <td><a href="<?php echo site_url('/admin/delete.php?id=' . htmlspecialchars($user->id)); ?>">Delete</a></td>
                        
                    </tr>
                    <?php } ?>
            </table>
            <?php 
            if($users_pagination->total_pages() > 1) { 
                echo "<div class=\"pagination\">";

                $url = site_url('/admin/index.php');
                echo $users_pagination->previous_link($url);
                echo $users_pagination->next_link($url);
                echo "</div>";
            }
            ?>
        
        <!-- POSTS TABLE -->

            <h1>Posts</h1>
        
            <table class="table_wrapper">
                <caption>Posts</caption>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Summary</th>
                        <th>Created Date</th>
                        <th>Published</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
            
                    <?php foreach($posts as $post) { ?>
                    <tr>
                        <td><?php echo htmlentities($post->id); ?></td>
                        <td><?php echo htmlentities($post->title); ?></td>
                        <td><?php echo htmlentities($post->summary); ?></td>
                        <td><?php echo htmlentities($post->created_at); ?></td>
                        <td><?php echo htmlentities($post->published ? 'Yes' : 'No'); ?></td>
                        <td><a href="<?php echo site_url('/blog/edit.php?id=' . htmlspecialchars($post->id));?>">Edit</a></td>
                        <td><a href="<?php echo site_url('/blog/delete_post.php?id=' . htmlspecialchars($post->id)); ?>">Delete</a></td>
                        
                    </tr>
                    <?php } ?>
            </table>
        <?php 
        if($blog_pagination->total_pages() > 1) { 
            echo "<div class=\"pagination\">";

            $url = site_url('/admin/index.php');
            echo $blog_pagination->previous_link($url);
            echo $blog_pagination->next_link($url);
            echo "</div>";
        }
        ?>
            <h1>Categories</h1>

            <table class="table_wrapper">
                <caption>Admins</caption>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>MetaTitle</th>
                        <th>Content</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
        
                    <?php foreach($categories as $category) { ?>
                    <tr>
                        <td><?php echo htmlentities($category->id); ?></td>
                        <td><?php echo htmlentities($category->title); ?></td>
                        <td><?php echo htmlentities($category->metaTitle); ?></td>
                        <td><?php echo htmlentities($category->content); ?></td>
                        <td><a href="<?php echo site_url('/blog/edit_category.php?id=' . htmlspecialchars($category->id)); ?>">Edit</a></td>
                        <td><a href="<?php echo site_url('/blog/delete_category.php?id=' . htmlspecialchars($category->id)); ?>">Delete</a></td>
                    </tr>
                    <?php } ?>
            </table>
        
    </div>
    </section>

</div>


