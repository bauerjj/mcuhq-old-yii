<?php

/**
 * This is the model class for table "post_vote".
 *
 * The followings are the available columns in table 'post_vote':
 * @property integer $id
 * @property integer $postId
 * @property integer $userId
 * @property integer $up
 * @property integer $down
 */
class PostVote extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PostVote the static model class
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
		return 'post_vote';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('postId, userId', 'required'),
			array('postId, userId, up, down', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, postId, userId, up, down', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'postId' => 'Post',
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
		$criteria->compare('postId',$this->postId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('up',$this->up);
		$criteria->compare('down',$this->down);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}