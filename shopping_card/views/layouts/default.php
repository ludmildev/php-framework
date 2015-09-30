<html>
    <head>
        <title><?php echo!empty($title) ? $title : ''; ?></title>
        <link rel="stylesheet" href="/css/bootstrap.css">
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="/">Home</a></li>
                        <li><a href="/products/">All Products</a></li>
                        <li><a href="/categories/">All Categories</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (!$this->isLogged) { ?>
                            <li><a href="/signin">Link / Register</a></li>
                        <?php } else { ?>
                            <li><a href="/card">Card</a></li>
                            <li><a href="/profile"><?php echo $this->username;?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>

        <?php echo $this->getLayoutData('body'); ?>
    </body>
    
    <footer>
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="/js/bootstrap.js"></script>
    </footer>
</html>
