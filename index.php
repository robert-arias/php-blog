<?php
require_once 'lib/common.php';
session_start();
// Connect to the database, run a query, handle errors
$pdo = getPDO();
$stmt = $pdo->query(
    'SELECT
        id, title, created_at, body
    FROM
        post
    ORDER BY
        created_at ASC'
);
if (!$stmt) {
    throw new Exception('There was a problem running this query');
}
//Error message if user tries to go to login when user's already logged in.
$forbidden = isset($_GET['forbidden']);
//Error when a post is not found.
$notFound = isset($_GET['not-found']);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <?php require 'templates/title.php' ?>
        <?php if ($forbidden): ?>
            <div class="alert alert--warning">
                <span class="alert__closeBtn" onclick="this.parentElement.style.display='none';">&times;</span>
                🚫 Forbidden: An username is already logged in.
            </div> 
        <?php endif ?>
        <?php if ($notFound): ?>
            <div class="alert alert--error">
                <span class="alert__closeBtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ❌ Error: Cannot find the requested blog post.
            </div>
        <?php endif ?>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="post">
                <h2 class="post__title">
                    <?php echo htmlEscape($row['title']) ?>
                </h2>
                <p class="post__date">
                    <?php echo convertSqlDate($row['created_at']) ?> •
                    (<?php echo countCommentsForPost($row['id']) ?> comments)
                </p>
                <p class="post__summary">
                    <?php echo htmlEscape($row['body']) ?>
                </p>
                <a href="view-post.php?post_id=<?php echo $row['id'] ?>" class="post__link btn"><span>Read more</span></a>
            </div>
        <?php endwhile ?>

    </body>
</html>
