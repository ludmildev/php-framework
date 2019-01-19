<div class="row row-eq-height">
    <div class="panel panel-primary col-sm-4 col-sm-offset-1">
        <h1 class="text-center">Edit Category</h1>
        <?php
        \FW\FormViewHelper::init()
            ->initForm('/admin/categories/save/'.$this->category[0]['id'], ['class' => 'form-group'], 'post')
            ->initLabel()->setValue("Category")->setAttribute('for', 'category')->create()
            ->initTextBox($this->category[0]['name'])
                ->setName('category')
                ->setAttribute('id', 'category')
                ->setAttribute('class', 'form-control input-md')
                ->create()
            ->initSubmit()->setAttribute('value', 'Edit')->setAttribute('class', 'btn btn-primary btn-lg col-sm-4 col-sm-offset-4')->create()
            ->render(); ?>
    </div>
</div>