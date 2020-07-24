<div style="float: right; position: relative; z-index: 99;">
<?php if (isLoggedIn()): ?>
        Hello <?php echo htmlEscape(getAuthUser()) ?>.
        <a href="logout.php">Log out</a>
    <?php else: ?>
        <a href="login.php">Log in</a>
    <?php endif ?>
</div>
<header class="header">
    <h1 class="header__title"><a href="index.php" class="header__link">PHP Blog Tutorial</a></h1>
    <p class="header__summary">Blog about making a blog in PHP. The followed tutorial was created by <a href="https://ilovephp.jondh.me.uk/en/tutorial/make-your-own-blog" class="summary__link" target="__blank">John</a>.</p>
</header>