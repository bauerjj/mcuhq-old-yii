<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $statusId
 * @property integer $userId
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property Status $status
 * @property User $user
 * @property TagPost[] $tagPosts
 */
class Post extends CActiveRecord {

    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_ARCHIVED = 3;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Post the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getUrl() {
        return Yii::app()->createUrl('post/view', array(
                    'id' => $this->id,
                    'title' => $this->title,
        ));
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'post';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('statusId, userId', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('content', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, content, statusId, userId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'comments' => array(self::HAS_MANY, 'Comment', 'postId'),
            'status' => array(self::BELONGS_TO, 'Status', 'statusId'),
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
            'tagPosts' => array(self::HAS_MANY, 'TagPost', 'postId'),
            //  'tags' => array(self::HAS_MANY, 'Tag', 'tagId', 'through' => 'tagPosts'), // CUSTOM
            'tags' => array(self::MANY_MANY, 'Tag', 'tag_post(postId, tagId)'), // CUSTOM
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'statusId' => 'Status',
            'userId' => 'User',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('statusId', $this->statusId);
        $criteria->compare('userId', $this->userId);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    // CUSTOM for the esaverelatedbehavior extension
    public function behaviors() {
        return array(
            'withRelated' => array(
                'class' => 'ext.wr.WithRelatedBehavior',
            ),
        );
    }

}