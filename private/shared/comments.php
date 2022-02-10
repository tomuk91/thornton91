<?php /* COMMENTS */ ?>
    <table class="comments_table">
        <caption>Comments</caption>
        <tr>
            <th class="first_column">User</th>
            <th>Comment</th>
        </tr>

        <?php foreach($comments as $comment) { ?>
            <tr>
                <td><?php echo htmlentities($comment->username) ?></td>
                <td><?php echo htmlentities($comment->content) . "<br>" . htmlentities($comment->created_at)  ?></td>
            </tr>
        <?php } ?>
    </table>
    <?php if(isset($_SESSION['user_id'])) { ?>
        <form class="form" action="<?php echo site_url('/blog/show_post.php?id=' . htmlentities($id));?>" method="post">
            <dl class="add_comment">
                <dt>Add Comment</dt>
                <textarea cols="180" rows="5" required="required"  name="post[content]"></textarea>
                <input type="hidden" name="post[user_id]" value="<?php echo $_SESSION['user_id']?>">
                <input type="hidden" name="post[post_id]" value="<?php echo $id; ?>" />
                <input class="btn" type="submit" name="submit" value="Post Comment">
            </dl>
        </div>
    <?php } else { ?>
        <?php echo "<center>" . "<b>You must be logged in to post comments.</b>" . "</center>"; ?>
    <?php } ?>
