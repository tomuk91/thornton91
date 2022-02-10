<?php require_once('../../private/initialize.php'); ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $values = $_POST['user'];
    $user = new users($values);
    $user->set_hashed_password();
    $result = $user->create();
    if($result) {
        $session->message('Your account was successfully created');
        header('Location: ../../public/index.php');
    } else {

    }
    
} else {
    $user = new users;
}

?>




<div class="form_container">
    <h2>Register</h2>

    <?php echo display_errors($user->errors); ?>

    <form class="form_template" action="<?php echo site_url('/users/register.php'); ?>" method="post" />
        <dl>
            <dt>Username</dt>
            <dd><input type="text" name="user[username]" required="required"</dd>
        </dl>
        <dl>
            <dt>First Name</dt>
            <dd><input type="text" name="user[first_name]" required="required"</dd>
        </dl>
        <dl>
            <dt>Last Name</dt>
            <dd><input type="text" name="user[last_name]" required="required"</dd>
        </dl>
        <dl>
            <dt>Email</dt>
            <dd><input type="email" name="user[email]" required="required"</dd>
        </dl>
        <dl>
            <dt>Password</dt>
            <dd><input type="password" name="user[password]" required="required"</dd>
        </dl>
        <dl>
            <dt>Confirm Password</dt>
            <dd><input type="password" name="user[confirm_password]" required="required"</dd>
        </dl>
        <input class="submit" type="submit" value="Register" />
    </form>
</div>






<?php include(SHARED_PATH . '/footer.php'); ?>