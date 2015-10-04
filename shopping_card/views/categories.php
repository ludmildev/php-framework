
<div class="row">
    <div class="col-lg-7">
        <?php foreach($this->categories as $categori) : ?>
            <a class="col-sm-3 col-sm-offset-1 btn btn-default text-center" style="margin-bottom: 10px;"
               href="/categories/show/<?php echo $categori['id']; ?>/0/5"><?php echo $categori['name']; ?></a>
        <?php endforeach; ?>
    </div>
</div>