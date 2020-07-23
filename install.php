<?php
require_once 'lib/common.php';
require_once 'lib/install.php';

// We store stuff in the session, to survive the redirect to self
session_start();
// Only run the installer when we're responding to the form
if ($_POST) {
    // Here's the install
    $pdo = getPDO();
    list($rowCounts, $error) = installBlog($pdo);
    $password = '';
    if (!$error) {
        $username = 'admin';
        list($password, $error) = createUser($pdo, $username);
    }
    $_SESSION['count'] = $rowCounts;
    $_SESSION['error'] = $error;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['try-install'] = true;
    
    // ... and here we redirect from POST to GET
    redirectAndExit('install.php');
}
// Let's see if we've just installed
$attempted = false;
if (isset($_SESSION['try-install'])) {
    $attempted = true;
    $count = $_SESSION['count'];
    $error = $_SESSION['error'];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    // Unset session variables, so we only report the install/failure once
    unset($_SESSION['count']);
    unset($_SESSION['error']);
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['try-install']);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Blog installer</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/install.css">
        <script src="https://kit.fontawesome.com/463141b2af.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php if ($attempted): ?>
            <?php if ($error): ?>
                <div class="error">
                    <p class="error__icon">⚠️</p>
                    <div class="container">
                        <h2 class="error__title">An error has occurred.</h2>
                        <p class="error__message"><?php echo $error ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="success box">
                    The database and demo data was created OK.
                    <?php // Report the counts for each table ?>
                    <?php foreach (array('post', 'comment') as $tableName): ?>
                        <?php if (isset($count[$tableName])): ?>
                            <?php // Prints the count ?>
                            <?php echo $count[$tableName] ?> new
                            <?php // Prints the name of the thing ?>
                            <?php echo $tableName ?>s
                            were created.
                        <?php endif ?>
                    <?php endforeach ?>
                    <?php // Report the new password ?>
                    The new '<?php echo htmlEscape($username) ?>' password is
                    <span style="font-size: 1.2em;"><?php echo htmlEscape($password) ?></span>
                    (copy it to clipboard if you wish).
                    <p>
                        <a href="index.php">View the blog</a>,
                        or <a href="install.php">install again</a>.
                    </p>
                </div>
            <?php endif ?>
        <?php else: ?>
        <div class="install">
            <h1 class="install__title">Click the install button to reset the database.</h1>
            <div class="install__arrow">
                <svg xmlns="http://www.w3.org/2000/svg" class="install__svg"><path d="M7.5 0a.5.5 0 01.5.5v16.17l4.44-4.45a.5.5 0 01.71 0l.7.71a.5.5 0 010 .71l-6.13 6.14a.75.75 0 01-.53.22h-.38a.77.77 0 01-.53-.22L.15 13.64a.5.5 0 010-.71l.7-.71a.49.49 0 01.7 0L6 16.67V.5a.5.5 0 01.5-.5z"></path></svg>
            </div>
            <form method="post" class="install__form">
                <button class="install__btn" name="install" type="submit"><span>Install</span></button>
            </form>
        </div>
        <?php endif ?>
    </body>
</html>