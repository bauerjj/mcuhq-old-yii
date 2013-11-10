<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property integer $id
 * @property string $content
 * @property integer $postId
 * @property integer $userId
 * @property integer $statusId
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Status $status
 * @property User $user
 * @property Post $post
 */
class Comment extends CActiveRecord {

    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;
    const VOTE_UP = 1;
    const VOTE_DOWN = 2;

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
            array('content', 'required'),
            //  array('author, email', 'length', 'max' => 50),
            // array('email', 'email'), // 'email' row must be a valid email entry
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, content, postId, userId, statusId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'votes' => array(self::HAS_MANY, 'CommentVote', 'commentId'),
            'voteUpCount' => array(self::STAT, 'CommentVote', 'commentId', 'condition' => 'up = 1'),
            'voteDownCount' => array(self::STAT, 'CommentVote', 'commentId', 'condition' => 'down = 1'),
            'status' => array(self::BELONGS_TO, 'Status', 'statusId'),
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
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
            'statusId' => 'Status',
            'created' => 'Created',
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
        $criteria->compare('userId', $this->userId);
        $criteria->compare('statusId', $this->statusId);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    // CUSTOM for the esaverelatedbehavior extension
//    public function behaviors() {
//        return array(
//            'withRelated' => array(
//                'class' => 'ext.wr.WithRelatedBehavior',
//            ),
//        );
//    }

    protected function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord)
                $this->created = date("Y-m-d H:i:s");
            return true;
        }
        else
            return false;
    }

    /**
     * @param Post the post that this comment belongs to. If null, the method
     * will query for the post.
     * @return string the permalink URL for this comment
     */
    public function getUrl($post = null) {
        if ($post === null)
            $post = $this->post;
        return $post->url . '#c' . $this->id;
    }

    /**
     * Adds a vote either up or down to a certain comment. User must be
     * logged in for the voting mechanism to function properly
     *
     * @param int $commentId Comment to vote on
     * @return boolean if added or not
     */
    public function addVote($commentId, $up = true) {
       return Vote::addVote(CommentVote::model(), $commentId, $up);
    }

    /**
     * Checks to see if the user has voted up already for a given comment
     * @todo may want to optimize this with a query instead of looping through all of the votes
     */
    public function hasVotedUp() {
        return Vote::hasVotedUp($this->votes, $this->id);
    }

    /**
     * Checks to see if the user has voted down already for a given comment
     * @todo may want to optimize this with a query instead of looping through all of the votes
     */
    public function hasVotedDown() {
       return Vote::hasVotedDown($this->votes, $this->id);
    }

}