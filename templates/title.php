<header class="header">
    <div class="header__login">
        <?php if (isLoggedIn()): ?>
           <p>
                <p class="header__name">Hello, <?php echo htmlEscape(getAuthUser()) ?>.</p>
                <a href="logout.php" class="btn"><span>Log out</span></a>
           </p>
        <?php elseif (!checkURL('/blog/login.php')): ?>
            <p><a href="login.php" class="btn"><span>Log in</span></a></p>
        <?php endif ?>
    </div>
    <h1 class="header__title"><a href="index.php" class="header__link">PHP Blog Tutorial</a></h1>
    <p class="header__summary">Blog about making a blog in PHP. The followed tutorial was created by <a href="https://ilovephp.jondh.me.uk/en/tutorial/make-your-own-blog" class="summary__link" target="__blank">John</a>.</p>
</header>