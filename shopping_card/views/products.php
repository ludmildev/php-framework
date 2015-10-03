<div class="container siteContainer">
    <?php if (count($this->products)<1) { ?>
        No Products Found
    <?php } else {
    foreach($this->products as $product) : ?>
    <div class="panel panel-success col-lg-4" style="margin-right: 10px;">
        <div class="panel-heading">
            <h3 class="panel-title">
                <a href="/product/<?php echo $product['id']; ?>/show"><?php echo $product['name']; ?></a>
            </h3>
        </div>
        <div class="panel-body">
            <div><?php echo $product['description']; ?></div>
            <div>Price: <?php echo $product['price']; ?>lv.</div>
            <div>Quantity: <?php echo $product['quantity']; ?> remaining</div>
            <div>
                <a href="/categories/show/<?php echo $product['categoryId']; ?>/0/3">
                    Category: <?php echo $product['categoryName']; ?>
                </a>
            </div>
            <?php if($this->isLogged) { ?>
                <a href="javascript:void(0);" onclick="alert('added to card');" class="btn btn-info">Add to cart!</a>
            <?php } else { ?>
                <a href="/signin" class="btn btn-info">Login to add to cart!</a>
            <?php } ?>
        </div>
    </div>
    <?php endforeach; ?>
    <?php } ?>
</div>
    