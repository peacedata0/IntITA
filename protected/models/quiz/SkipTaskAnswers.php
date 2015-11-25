<?php

/**
 * This is the model class for table "skip_task_answers".
 *
 * The followings are the available columns in table 'skip_task_answers':
 * @property integer $id
 * @property integer $id_task
 * @property string $answer
 * @property integer $answer_order
 *
 * The followings are the available model relations:
 * @property SkipTask $idTask
 */
class SkipTaskAnswers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'skip_task_answers';
	}

    public function __construct($task, $answer, $answerOrder){
        $this->id_task = $task;
        $this->answer = $answer;
        $this->answer_order = $answerOrder;
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_task, answer, answer_order', 'required'),
			array('id_task, answer_order', 'numerical', 'integerOnly'=>true),
			array('answer', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_task, answer, answer_order', 'safe', 'on'=>'search'),
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
			'idTask' => array(self::BELONGS_TO, 'SkipTask', 'id_task'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_task' => 'Id Task',
			'answer' => 'Answer',
			'answer_order' => 'Answer Order',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_task',$this->id_task);
		$criteria->compare('answer',$this->answer,true);
		$criteria->compare('answer_order',$this->answer_order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SkipTaskAnswers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function addAnswers($task, $answers){
        if (!empty($answers)){
            foreach($answers as $answer){
                $model = new SkipTaskAnswers($task, $answer['text'], $answer['order']);
                $model->save();
            }
        }
    }
}