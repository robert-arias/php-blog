<?php
require_once 'lib/common.php';
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
$notFound = isset($_GET['not-found']);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/index.css">
        <script src="https://kit.fontawesome.com/463141b2af.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php require 'templates/title.php' ?>
        <?php if ($notFound): ?>
            <div style="border: 1px solid #ff6666; padding: 6px;">
                Error: cannot find the requested blog post
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
                <p class="post__btn">
                    <a href="view-post.php?post_id=<?php echo $row['id'] ?>" class="post__link">
                    <i class="fas fa-link"></i>
                        Read more
                    </a>
                </p>
            </div>
        <?php endwhile ?>

    </body>
</html>
