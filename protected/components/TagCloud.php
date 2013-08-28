<?php

Yii::import('zii.widgets.CPortlet');

class TagCloud extends CPortlet
{
    public $title = 'Tags';
    private $maxTags = 20;

    protected function renderContent() {
        $criteria = new CDbCriteria();
        $criteria->limit = $this->maxTags;
        $criteria->select = 'name';

        $tags = Tag::model()->findAll($criteria);

        foreach($tags as $tag){
            $link = CHtml::link(CHtml::encode($tag->name), array('post/index', 'tag' => $tag->name));
            echo CHtml::tag('span', array(
                'class' => 'tag',
                ),$link)."\n";
        }
    }
}