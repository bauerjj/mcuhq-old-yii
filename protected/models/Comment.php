<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property integer $id
 * @property string $content
 * @property integer $postId
 * @property string $author
 * @property string $email
 * @property integer $statusId
 *
 * The followings are the available model relations:
 * @property Status $status
 * @property Post $post
 */
class Comment extends CActiveRecord {

    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Comment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'comment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('postId, statusId', 'numerical', 'integerOnly' => true),
            array('author, email', 'length', 'max' => 50),
            array('content', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, content, postId, author, email, statusId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'status' => array(self::BELONGS_TO, 'Status', 'statusId'),
            'post' => array(self::BELONGS_TO, 'Post', 'postId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'content' => 'Content',
            'postId' => 'Post',
            'author' => 'Author',
            'email' => 'Email',
            'statusId' => 'Status',
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
        $criteria->compare('content', $this->content, true);
        $criteria->compare('postId', $this->postId);
        $criteria->compare('author', $this->author, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('statusId', $this->statusId);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    // CUSTOM for the esaverelatedbehavior extension
    public function behaviors() {
        return array('ESaveRelatedBehavior' => array(
                'class' => 'application.components.ESaveRelatedBehavior')
        );
    }

}