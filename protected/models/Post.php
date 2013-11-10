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
 * @property integer $categoryId
 * @property string $created
 * @property string $updated
 * @property integer $views
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property Status $status
 * @property User $user
 * @property Category $category
 * @property TagPost[] $tagPosts
 */
class Post extends CActiveRecord {

    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_ARCHIVED = 3;
    const STATUS_PENDING = 4;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Post the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
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
            array('categoryId', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
           // array('content', 'safe'),
            array('title, content, categoryId', 'required'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, content, statusId, userId, categoryId, created, updated', 'safe', 'on' => 'search'),

            //These are NOT user inputs - Place these in 'beforeSave' method
           // array('userId', 'default', 'value' => Yii::app()->user->id),
           // array('statusId', 'default', 'value' => '1')
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
            'commentCount' => array(self::STAT, 'Comment', 'postId', 'condition'=>'statusId='.Comment::STATUS_APPROVED),
            'status' => array(self::BELONGS_TO, 'Status', 'statusId'),
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
            'category' => array(self::BELONGS_TO, 'Category', 'categoryId'),
            'tagPosts' => array(self::HAS_MANY, 'TagPost', 'postId'),
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
            'categoryId' => 'Category',
            'created' => 'Created',
	    'updated' => 'Updated',
	    'views' => 'Views',
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
        $criteria->compare('categoryId', $this->categoryId);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('updated',$this->updated,true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('post/view', array(
            'id'=>$this->id,
            'title'=>$this->title,
        ));
    }

    //CUSTOM
    protected function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->created = $this->updated = date("Y-m-d H:i:s");
                $this->userId = Yii::app()->user->id; // Default value
            }
            else
                $this->updated = date("Y-m-d H:i:s");

            $this->statusId = STATUS_PUBLISHED; // Default value

            return true;
        }
        else
            return false;
    }

    /**
     * Adds a new comment to this post.
     * This method will set status and post_id of the comment accordingly.
     * @param Comment the comment to be added with attributes already added!!!
     * @return boolean whether the comment is saved successfully
     */
    public function addComment($comment){
        if(Yii::app()->params['commentNeedApproval'])
            $comment->statusId = Comment::STATUS_PENDING;
        else
            $comment->statusId = Comment::STATUS_APPROVED;

        $comment->postId = $this->id; // Save postID to currently viewed post
        $comment->userId = Yii::app()->user->id;

        return $comment->save();
    }

    public function getTags($class = false){
        $tags = array();
        foreach($this->tags as $tag){
            if($class)
                $tags[]= CHtml::link('<span class="label label-info">'.CHtml::encode($tag->name), '#');
            else
                $tags[]= CHtml::encode($tag->name);
        }

        return implode(', ',$tags);
    }

    // CUSTOM for the esaverelatedbehavior extension
//    public function behaviors() {
//        return array(
//            'withRelated' => array(
//                'class' => 'ext.wr.WithRelatedBehavior',
//            ),
//        );
//    }

}