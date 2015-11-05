<?php

/**
 * This is the model class for table "tests".
 *
 * The followings are the available columns in table 'tests':
 * @property integer $id
 * @property integer $block_element
 * @property integer $author
 *
 * The followings are the available model relations:
 */
class Tests extends Quiz
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('author, block_element', 'required'),
			array('id, block_element, author', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, block_element, author', 'safe', 'on'=>'search'),
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
			'block_element' => 'Block Element',
			'author' => 'Author',
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
		$criteria->compare('block_element',$this->block_element);
		$criteria->compare('author',$this->author);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tests the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function addNewTest($blockElement, $title, $author, $pageId){
        $model = new Tests();

        $model->block_element = $blockElement;
        $model->author = $author;

        if ($model->save()){
            LecturePage::addQuiz($pageId, $blockElement);
        }
    }
	public static function isLastTest($testId)
	{
		$quiz = Tests::model()->findByPk($testId)->block_element;
		$lecturePage=LecturePage::model()->findByAttributes(array('quiz' => $quiz));
		$pageOrder = $lecturePage->page_order;
		$lectureId = $lecturePage->id_lecture;

		$criteria=new CDbCriteria;
		$criteria->alias='lecture_page';
		$criteria->select='page_order';
		$criteria->condition = 'id_lecture = '.$lectureId;
		$criteria->order = 'page_order DESC';
		$lastPage=LecturePage::model()->find($criteria)->page_order;

		if($pageOrder!=$lastPage) return 0;
		else return 1;
	}
}
