<?php
$this->breadcrumbs = array(
    $model->category->name => array('index'),
    $model->title,
);

// Add Admin sidepanel
if (Yii::app()->user->name == 'admin') {
    $this->menu = array(
        array('label' => 'List Post', 'url' => array('index')),
        array('label' => 'Create Post', 'url' => array('create')),
        array('label' => 'Update Post', 'url' => array('update', 'id' => $model->id)),
        array('label' => 'Delete Post', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
        array('label' => 'Manage Post', 'url' => array('admin')),
    );
}

// Add article info
$this->beginClip('articleInfo');
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Article',
    'headerIcon' => 'book',
    'htmlOptions' => array('class' => 'article-info')
));
?>

<table>
    <tr>
        <td>
            <div class="vote-box">
                <div>
                    <i class="icon-chevron-up vote-up " title="+1 Vote Up"></i>
                </div>
                <div id="voteCount" title="Number of user votes (likes)" style="color:#737373; text-align: center;">5</div>
                <div>
                    <i class="icon-chevron-down vote-down " title="-1 Vote Down"></i>
                </div>
            </div>
        </td>
        <td>
            <div class="fav-box">
                <a class="pull-right" title="Report this" href="#" style="text-decoration: none; ">
                    <i class="icon-flag-alt icon-1x flag"></i>
                    Report It
                </a>
                <br>
            </div>
        </td>
    </tr>
</table>


<ul class="article-meta unstyled">
    <li><b>Author: </b><?php echo CHtml::link(CHtml::encode($model->user->username), '#') ?></li>
    <li><b>Category: </b><?php echo CHtml::link(CHtml::encode($model->category->name), '#') ?></li>
    <li><b>Views: </b><?php echo CHtml::decode($model->views) ?></li>
    <li><b>Created: </b><?php echo date('F j, Y', strtotime($model->created)) ?></li>
    <li><b>Updated: </b><?php echo date('F j, Y', strtotime($model->updated)) ?></li>
    <li><b>Tags: </b><?php echo $model->getTags(true) ?></li>


    <li><b>Micro: </b><?php echo CHtml::link('pic16lf1947', '#') ?></li>



</ul>

<?php
$this->endWidget();
$this->endClip();

// Article Content
$this->renderPartial('home/_view', array(
    'model' => $model,
));

// Comments section
?>
<div id="comments">
    <?php if ($model->commentCount >= 1): ?>
        <h3>
            <?php echo $model->commentCount > 1 ? $model->commentCount . ' comments' : 'One comment'; ?>
        </h3>
    <ul id="comments-filter" class="inline">
        <li><b>Order by:</b></li>
        <li><a href="#" style="text-decoration: none; "><i class="icon-time" title="Latest First" ></i><strong>Latest First</strong></a></li>
        <li><a href="#" style="text-decoration: none; "><i class="icon-thumbs-up vote-up" title="Highest Rated First"></i><strong>Highest Rated</strong></a></li>
        <li><a href="#" style="text-decoration: none; "><i class="icon-thumbs-down vote-down" title="Lowest Rated First"></i><strong>Lowest Rated</strong></a></li>
    </ul>

        <?php
        $this->renderPartial('home/_comments', array(
            'post' => $model,
            'comments' => $model->comments,
        ));
        ?>
<?php endif; ?>

    <h3>Leave a Comment</h3>

    <?php if (Yii::app()->user->isGuest): ?>
        Please <?php echo CHtml::link('login', array('/site/login')) ?> to leave your comment.

    <?php else: ?>

         <?php
        Yii::app()->user->setFlash('warning', 'Please only use comments to help explain the above article.
If you have any questions, please ask in the '.CHtml::link('forum',array('/forum')).' instead.');
        // Render them all with single `TbAlert`
        $this->widget('bootstrap.widgets.TbAlert', array(
            'block' => true,
            'fade' => true,
            'closeText' => '&times;', // false equals no close link
            'events' => array(),
            'htmlOptions' => array(),
            'userComponentId' => 'user',
            'alerts' => array(// configurations per alert type
                // success, info, warning, error or danger
                'warning' => array('block' => true, 'closeText' => false),
            )
        ));
        ?>

            <?php if (Yii::app()->user->hasFlash('commentSubmitted')): ?>
            <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
            </div>
        <?php else: ?>
            <?php
            $this->renderPartial('/comment/_form', array(
                'model' => $comment,
            ));
            ?>
    <?php endif; ?>

<?php endif ?>

<?php
echo '<div id="test">foo bar</div>';

echo CHtml::ajaxLink ("Update data",
   CController::createUrl('post/vote'),
   array(
       'type' => 'POST',
       'data' =>array(
           'crAction'=>'updateShareFlag'
       ),
       'update' => '#test'
       )
  );

?>
</div><!-- comments -->