<script>
function removeFromCard(productId)
{
    $.ajax({
        method: "GET",
        url: "/cart/remove/" + productId,
        data: {}
    }).done(
        function () {
            alert('Product removed from cart');
            window.location.reload();
        }
    );
}
</script>
<?php
if (count($this->products) == 0) {
    echo 'Cart is empty.';
} else {
    foreach($this->products as $product) {
        echo 'Product Id : '.$product.' <a href="javascript:void(0);" onclick="removeFromCard('.$product.');">[remove]</a><br />';
    }
}