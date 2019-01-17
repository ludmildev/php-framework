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
                        <li><a href="/admin/orders">Orders</a></li>
                        <li><a href="/admin/categories">Categories</a></li>
                        <li><a href="/admin/products">Products</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/">Home</a></li>
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
