<?php
require_once 'lib/common.php';
// We need to test for a minimum version of PHP, because earlier versions have bugs that affect security
if (version_compare(PHP_VERSION, '5.3.7') < 0) {
    throw new Exception(
        'This system needs PHP 5.3.7 or later'
    );
}

session_start();
// Handle the form posting
$username = '';
if ($_POST) {
    // Init the database
    $pdo = getPDO();
    // We redirect only if the password is correct
    $username = $_POST['username'];
    $ok = tryLogin($pdo, $username, $_POST['password']);
    if ($ok) {
        login($username);
        redirectAndExit('index.php');
    }
}

if (getAuthUser() !== null) {
    $_SESSION['errormsg'] = 'Username already logged in.';
    redirectAndExit('index.php');
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            A blog application | Login
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/login.css">
    </head>
    <body>
        <?php require 'templates/title.php' ?>
        <?php // If we have a username, then the user got something wrong, so let's have an error ?>
        <?php if ($username): ?>
            <div style="border: 1px solid #ff6666; padding: 6px;">
                The username or password is incorrect, try again
            </div>
        <?php endif ?>
        <main class="main">
            <h1 class="main__title">Login</h1>
            <form method="post" class="main__form">
                <div class="form__box">
                    <input class="form__input" type="text" name="username" placeholder="Username" value="<?php echo htmlEscape($username) ?>">
                    <label class="form__label" for="username">Username</label>
                </div>
                <div class="form__box">
                    <input class="form__input" type="password" name="password" placeholder="Password">
                    <label class="form__label" for="username">Password</label>
                </div>
                <button class="form__button btn" type="submit"><span>Login</span></button>
            </form>
        </main>
    </body>
</html>