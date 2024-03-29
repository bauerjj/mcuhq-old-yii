<?php
$this->breadcrumbs = array(
    'Posts' => array('index'),
    $model->title,
);

$this->menu = array(
    array('label' => 'List Post', 'url' => array('index')),
    array('label' => 'Create Post', 'url' => array('create')),
    array('label' => 'Update Post', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Post', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Post', 'url' => array('admin')),
);
?>

<h1>View Post #<?php echo $model->id; ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'title',
        'content',
       // 'statusId',
       array(
            'name' => 'status',
            'value' => $model->status->status
        ),
        //'userId',
        array(
            'name' => 'user',
            'value' => $model->user->username
        ),
        //'categoryId',
        array(
            'name' => 'category',
            'value' => $model->category->name
        ),
        array(
            'name' => 'tags',
            'value' => $model->getTags()
        ),
        'created',
        'updated'
    ),
));
?>
