<?php

/**
 * This is the model class for table "comment_vote".
 *
 * The followings are the available columns in table 'comment_vote':
 * @property integer $id
 * @property integer $commentId
 * @property integer $userId
 * @property integer $up
 * @property integer $down
 *
 * The followings are the available model relations:
 * @property User $id0
 * @property Comment $comment
 */
class CommentVote extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CommentVote the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comment_vote';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('commentId, userId, up, down', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, commentId, userId, up, down', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'id0' => array(self::BELONGS_TO, 'User', 'id'),
			'comment' => array(self::BELONGS_TO, 'Comment', 'commentId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'commentId' => 'Comment',
			'userId' => 'User',
			'up' => 'Up',
			'down' => 'Down',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('commentId',$this->commentId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('up',$this->up);
		$criteria->compare('down',$this->down);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}