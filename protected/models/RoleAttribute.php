<?php

/**
 * This is the model class for table "role_attribute".
 *
 * The followings are the available columns in table 'role_attribute':
 * @property integer $id
 * @property string $name
 * @property integer $role
 * @property string $type
 * @property string $name_ru
 * @property string $name_ua
 *
 * The followings are the available model relations:
 * @property AttributeValue[] $attributeValues
 * @property Roles $role0
 */
class RoleAttribute extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'role_attribute';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, role, type, name_ru, name_ua', 'required'),
			array('role', 'numerical', 'integerOnly'=>true),
			array('name, name_ru, name_ua', 'length', 'max'=>30),
			array('type', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, role, type, name_ru, name_ua', 'safe', 'on'=>'search'),
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
			'attributeValues' => array(self::HAS_MANY, 'AttributeValue', 'attribute'),
			'role0' => array(self::BELONGS_TO, 'Roles', 'role'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Назва атрибута українською',
			'role' => 'Роль',
			'type' => 'Тип',
			'name_ru' => 'Назва атрибута російською',
			'name_ua' => 'Назва атрибута українською',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('role',$this->role);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('name_ru',$this->name_ru,true);
		$criteria->compare('name_ua',$this->name_ua,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RoleAttribute the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /** scope
     * @param $role
     * @return RoleAttribute
     */
    public function type($role)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition' => 't.role=:type',
            'params'=>array(':type'=>$role),
        ));
        return $this;
    }
}
