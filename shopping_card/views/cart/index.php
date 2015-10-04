<?php

if (count($this->products) == 0) {
    echo 'Cart is empty.';
} else {
    foreach($this->products as $product) {
        echo 'Product Id : '.$product.'<br />';
    }
}