<?php

class People extends CWidget {

    public $title = 'Top Contributers';
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
        echo CHtml::link('List of Users', Yii::app()->createUrl('user'));

        echo '<ul class="unstyled">';
        foreach ($tags as $tag) {
            $link = CHtml::link(CHtml::encode($tag->name), array('post/index', 'tag' => $tag->name));
            echo '<li>' .CHtml::tag('span', array('class' => 'label',),'<i class="icon-white icon-user"></i>'. $link ).'</a></li>';
       //     echo '<li><a href="/admin.php">Admin CP <span class="badge badge-inverse">1</span> </a></li>';
//            echo CHtml::tag('span', array(
//                'class' => 'tag',
//                    ), $link) . "\n";
        }
        echo '</ul>';

        $this->endWidget();

    }

}