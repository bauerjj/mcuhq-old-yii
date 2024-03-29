<?php

class TagCloud extends CWidget {

    public $title = 'Popular Tags';
    private $maxTags = 20;

    public function init() {
        $criteria = new CDbCriteria();
        $criteria->limit = $this->maxTags;
        $criteria->select = 'name';

        $tags = Tag::model()->findAll($criteria);

        $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => $this->title,
            'headerIcon' => '',
            'htmlOptions' => array('class' => '')
        ));


        echo '<ul class="unstyled">';
        foreach ($tags as $tag) {
            $link = CHtml::link(CHtml::encode($tag->name), array('post/index', 'tag' => $tag->name));
            echo '<li>' . '<a href="#"><span class="label label-info">' . $tag->name . '</span></a>'.
                    '<span class="item-multiplier">x 1</span>'. '</li>';
        }
        echo '</ul>';

        $this->endWidget();

    }

}