
<?php require_once('../../private/initialize.php'); ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<?php
/*PAGE ACCESS CONTROL*/
if(!$session->is_admin()) {
    header("Location: ../index.php");
}

$id = $_GET['id'];

if(!isset($id)) {
    header("Location: index.php");
}

$user = users::find_by_id($id);
    if($user == false) {
        header("Location: index.php");
    }

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $values = $_POST['user'];
    $user->merge_object_values($values);
    $result = $user->save();

    if($result === true) {
        header("Location: index.php");
    } else {

    }

} else {
    
}

?>

<div class="form_container">
    <h2>Edit Post</h2>

    <?php echo display_errors($user->errors); ?>

    <form class="form_template" action="<?php echo site_url('/blog/edit.php?id=' . htmlspecialchars($id)); ?>" method="post" />
        <dl>
            <dt>Username</dt>
            <dd><input type="text" name="user[username]" required="required" value="<?php echo htmlspecialchars
            ($user->username); ?>"</dd>
        </dl>
        <dl>
            <dt>First Name</dt>
            <dd><input type="text" name="user[first_name]" required="required" value="<?php echo htmlspecialchars
            ($user->first_name); ?>"</dd>
        </dl>
        <dl>
            <dt>Last Name</dt>
            <dd><input type="text" name="user[last_name]" required="required" value="<?php echo htmlspecialchars
            ($user->last_name); ?>"</dd>
        </dl>
        <dl>
            <dt>Email</dt>
            <dd><input type="email" name="user[email]" required="required" value="<?php echo htmlspecialchars
            ($user->email); ?>"/dd>
        </dl>
        <dl>
            <dt>Password</dt>
            <dd><input type="password" name="user[password]" required="required"</dd>
        </dl>
        <dl>
            <dt>Confirm Password</dt>
            <dd><input type="password" name="user[confirm_password]" required="required"</dd>
        </dl>
        <input class="submit" type="submit" value="Update" />
    </form>
</div>