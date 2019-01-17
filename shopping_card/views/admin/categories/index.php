
<div class="row">
    <div class="col-lg-7">
        <?php foreach($this->categories as $categori) : ?>
            <div class="btn btn-default" style="margin-bottom: 10px;">
                <?php echo $categori['name']; ?>
                <a href="/categories/show/<?php echo $categori['id']; ?>/0/5">[view]</a>
                <a href="/admin/categories/edit/<?php echo $categori['id']; ?>">[edit]</a>
                <a style="color:red;" href="/admin/categories/delete/<?php echo $categori['id']; ?>">[delete]</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="row row-eq-height">
    <div class="panel panel-primary col-sm-4 col-sm-offset-1">
        <h1 class="text-center">Add Category</h1>
        <?php
        \FW\FormViewHelper::init()
            ->initForm('/admin/categories/add', ['class' => 'form-group'], 'post')
            ->initLabel()->setValue("Category")->setAttribute('for', 'category')->create()
            ->initTextBox()->setName('category')->setAttribute('id', 'category')->setAttribute('class', 'form-control input-md')->create()
            ->initSubmit()->setAttribute('value', 'Add')->setAttribute('class', 'btn btn-primary btn-lg col-sm-4 col-sm-offset-4')->create()
            ->render(); ?>
    </div>
</div>
