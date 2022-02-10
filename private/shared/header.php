<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=New+Tegomin&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">  
    <link rel="stylesheet" href="<?php echo site_url('/stylesheets/stylesheet.css');?>" />
</head>

<?php
    $categories = categories::find_all_data();
?>

<nav>
    <h1><a href="<?php echo site_url('/index.php'); ?>">Thornton91</a></h1>
    <?php if($session->is_admin() && $_SERVER['REQUEST_URI'] != site_url('/admin/index.php')) { ?>
    <li><a href="<?php echo site_url('/admin/index.php'); ?>">Admin Home</a></li>
    <?php } ?>
    <li><a href="<?php echo site_url('/index.php'); ?>">Home</a></li>
    <div class="dropdown">
        <li class="dropbtn">Categories</li>
        <div class="dropdown-content">
           <?php foreach($categories as $category) { ?>
            <a href="<?php echo site_url('/blog/categories.php?id=' . htmlentities($category->id)); ?>"><?php echo 
            htmlentities($category->title);?></a>
        <?php } ?>
        </div>
    </div>
    <?php if($session->currently_logged_in()) { ?>
    <li><a href="<?php echo site_url('/users/logout.php'); ?>">Logout</a></li>
    <?php } else { ?>
    <li><a href="<?php echo site_url('/users/login.php'); ?>">Login</a></li>
    <?php } ?> 
</nav>
<?php echo display_session_message(); ?>
<body>