<?php require_once('../private/initialize.php'); ?>

<?php include(SHARED_PATH . '/header.php'); ?>


    <!--HOMEPAGE BANNER-->

<section class="intro">
<img src="images/phoenix.png">
    <div class="welcome">

        

        <div class="welcome_text">
            <h2>Welcome to Thornton reviews</h2>
            <br>
            <p>Website and content created by Tom Thornton</p>
        </div>
    </div>

    <div class="register">
        <div class="reg_text">
            <?php /* IF CURRENTLY LOGGED IN - SHOW LOGGED IN MESSAGE */ ?>
            <?php if(!empty($_SESSION['user_id'])) { ?>
                <h2>Currently Logged in</h2>
                <h3>User: <?php echo $_SESSION['username'];?></h3>
                <a href="<?php echo site_url('/users/logout.php'); ?>"><button class="btn" type="button">Logout</a></button> 
                <?php /* ELSE SHOW REGISTER MESSAGE */ ?>
            <?php } else { ?>
                <h2>Not registered?</h2>
                <p>Sign up to contribute to the websites reviews!</p>
                <a href="<?php echo site_url('/users/register.php'); ?>"><button class="btn" type="button">Register!</a></button> 
            <?php } ?>
        </div>
    </div>

</section>

    <!--START OF RECENT POSTS ON HOMEPAGE-->

    <h1 id="headings">Latest posts</h1>
<section class="posts">

<?php $posts = blog::limit4_find_published_posts();?>
    
    <?php foreach($posts as $post) { ?>
        <div class="post_boxes">
            <img src="<?php echo htmlspecialchars($post->image_url); ?>">
            <h1><?php echo htmlspecialchars($post->title); ?></h1>
            <h4>by <?php echo htmlspecialchars($post->username);?> | <?php echo htmlspecialchars($post->created_at);?></h4>
            <p><?php echo htmlspecialchars($post->summary); ?></p>
            <h1><a href="<?php echo site_url('/blog/show_post.php?id=' . htmlspecialchars(urlencode($post->id))); ?>"
            >Read More</a></h1>
        </div>
    <?php } ?>
</section>

<section>
    <div class="banner">
        <div class="banner_info">
            <div class="banner_left">
                <h1>I work on...</h1>
                <img src="<?php echo site_url('/images/arrow.png');?>">
            </div>
            <div class="banner_right">
            <ul>
                <li>Web Development</li>
                <li>PHP</li>
                <li>JavaScript</li>
                <li>HTML & CSS</li>
                <li>AND writing articles!</li>
            </ul>
            </div>
        </div>
    </div>
</section>


<?php include(SHARED_PATH . '/footer.php'); ?>
    
