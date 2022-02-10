<?php require_once('../../private/initialize.php'); ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<?php

$errors = [];
$username = '';
$password = '';


if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username)) {
        $errors[] = "Username Cannot be empty";
    }
    if(empty($password)) {
        $errors[] = "Password Cannot be empty";
    }

    if(empty($errors)) {
        
        $user = users::find_by_username($username);

        if(!$user) {
            $errors[] = "Please check your username and password";
        }
        elseif($user->verify_password($password) === false) {
            $errors[] = "Please check your username and password";
        }

        if($user !== false && $user->verify_password($password)) {
            $session->login($user);
            if($user->check_admin() == true) {
                header("Location: ../admin/index.php");
            } else {
                header("Location: ../index.php");
            }
        }
    }
}

?>

<?php echo display_errors($errors); ?>

<div class="form_container">
    
    <h2> Login </h2>


    <form class="form_template" action="<?php echo site_url('/users/login.php'); ?>" method="post" />
        <dl>
            <dt>Username</dt>
            <dd><input type="text" name="username" required="required"</dd>
        </dl>
        <dl>
            <dt>Password</dt>
            <dd><input type="password" name="password" required="required"</dd>
        </dl>
        <input class="submit" type="submit" value="Login">
        <p>Not registered? Sign up <a href="<?php echo site_url('/users/register.php'); ?>">here</a></p>
    </form>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>

















