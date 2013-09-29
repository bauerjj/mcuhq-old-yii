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
    public function behaviors() {
        return array(
            'withRelated' => array(
                'class' => 'ext.wr.WithRelatedBehavior',
            ),
        );
    }

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
        $userId = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->condition = "commentId = $commentId";
        $criteria->addCondition("userId = $userId");
        $criteria->limit = 1; // Only need 1 record to search for
        $row = CommentVote::model()->find($criteria);


        if (!$row) { // Check if existance of a vote
            // Add vote if row does not exist
            $cm = new CommentVote();
            $cm->userId = $userId;
            $cm->commentId = $commentId;
            if ($up) {
                $cm->up = 1;
                $cm->down = 0;
            } else {
                $cm->up = 0;
                $cm->down = 1;
            }
            return $cm->save();
        } else {
            if (($up && $row->up == 1) || (!$up && $row->down == 1)) {
                // Enter here when user wishes to toggle the vote (pressed thumbs up after previously voted up)
                // Reset votes
                $row->up = 0;
                $row->down = 0;
            } else {
                // Enter here when user has changed previous vote from Up to Down or vice versa
                if ($up) {
                    $row->up = 1;
                    $row->down = 0;
                } else {
                    $row->up = 0;
                    $row->down = 1;
                }
            }
            return $row->save();
        }
    }

    /**
     * Checks to see if the user has voted up already for a given comment
     * @todo may want to optimize this with a query instead of looping through all of the votes
     */
    public function hasVotedUp() {
         if(Yii::app()->user->isGuest)
            return false;
        foreach ($this->votes as $votes) {
            if ($votes->commentId == $this->id && $votes->userId == Yii::app()->user->id && $votes->up == 1)
                return true;
        }

        return false;
    }

    /**
     * Checks to see if the user has voted down already for a given comment
     * @todo may want to optimize this with a query instead of looping through all of the votes
     */
    public function hasVotedDown() {
        if(Yii::app()->user->isGuest)
            return false;
        foreach ($this->votes as $votes) {
            if ($votes->commentId == $this->id && $votes->userId == Yii::app()->user->id && $votes->down == 1)
                return true;
        }
        return false;
    }

}