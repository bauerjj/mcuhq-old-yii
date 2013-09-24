<?php

class Categories extends CWidget {

    public $title = 'Categories';
    private $maxCat = 20;

    public function init() {
        $criteria = new CDbCriteria();
        $criteria->limit = $this->maxCat;
        $criteria->select = 'name, count';

        $categories = Category::model()->findAll($criteria);

        $this->beginWidget('bootstrap.widgets.TbBox', array(
            'title' => 'Categories',
            'headerIcon' => '',
            'htmlOptions' => array('class' => '')
        ));

        echo '<ul class="unstyled">';
        foreach ($categories as $cat) {
            $link = CHtml::link(CHtml::encode($cat->name), array('post/index', 'tag' => $cat->name));
            echo '<li>' . '<a href="#"><span class="label label-info">' . $cat->name . '</span></a>' .
            '<span class="item-multiplier">x ' . $cat->count . '</span>' . '</li>';
        }
        echo '</ul>';

        $this->endWidget();
    }

}