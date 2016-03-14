<?php

/**
 * This is the model class for table "messages_author_request".
 *
 * The followings are the available columns in table 'messages_author_request':
 * @property integer $id_message
 * @property integer $id_module
 * @property string $date_approved
 * @property integer $user_approved
 * @property integer cancelled
 *
 * The followings are the available model relations:
 * @property Module $idModule
 * @property StudentReg $userApproved
 * @property Messages $message0
 */
class MessagesAuthorRequest extends Messages implements IMessage
{
    private $template = '_newAuthorModuleRequest';
    const TYPE = 3;
    private $receivers = array();
    private $module;
    private $author;
    private $message;

    const DELETED = 1;
    const ACTIVE = 0;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'messages_author_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_module', 'required'),
			array('id_module, user_approved, cancelled', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			array('id_module, date_approved, user_approved, cancelled', 'safe', 'on'=>'search'),
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
			'idModule' => array(self::BELONGS_TO, 'Module', 'id_module'),
            'message0' => array(self::BELONGS_TO, 'Messages', 'id_message'),
			'userApproved' => array(self::BELONGS_TO, 'StudentReg', 'user_approved'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id_message' => 'Id message',
			'id_module' => 'Id Module',
			'date_approved' => 'Date Approved',
			'user_approved' => 'User Approved',
            'cancelled' => 'Cancelled'
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
		$criteria=new CDbCriteria;

        $criteria->compare('id_message',$this->id_message);
		$criteria->compare('id_module',$this->id_module);
		$criteria->compare('date_approved',$this->date_approved,true);
		$criteria->compare('user_approved',$this->user_approved);
        $criteria->compare('cancelled',$this->cancelled);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MessagesAuthorRequest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function primaryKey()
	{
		return 'id_message';
	}

	public function build(Module $module, StudentReg $user, $chained = null, $original = null)
	{
        //create and init parent model
        $this->message = new Messages();
        $this->message->build($user->id, self::TYPE, $chained, $original);

        $this->module = $module;
        $this->id_module = $module->module_ID;
        $this->author = $user;
        $this->receivers = UserAdmin::adminsArray();
	}

	public function create(){
		$this->message->save();
        $this->id_message =  $this->message->id;

        $this->save();
		return $this;
	}

	public function send(IMailSender $sender){
        $sender = new MailTransport();
        $sender->renderBodyTemplate($this->template, array($this->module, $this->author));

        foreach ($this->receivers as $receiver) {
			if ($this->addReceiver($receiver->user)) {
				$sender->send($receiver->user->email, '', 'Запит на редагування модуля', '');
			}
        }

        $this->message->draft = 0;
        return $this->message->save();
	}

	public function read(StudentReg $receiver){
        if (Yii::app()->db->createCommand()->update('message_receiver', array('read' => date("Y-m-d H:i:s")),
                'id_message=:message and id_receiver=:receiver',
                array(':message' => $this->id_message, ':receiver' => $receiver->id)) == 1
        )
            return true;
        else {
            return false;
        }
	}

	public function deleteMessage(StudentReg $receiver){
        if (Yii::app()->db->createCommand()->update('message_receiver', array('deleted' => date("Y-m-d H:i:s")),
                'id_message=:message and id_receiver=:receiver',
                array(':message' => $this->id_message, ':receiver' => $receiver->id)) == 1
        )
            return true;
        else {
            return false;
        }
	}

	public function reply(StudentReg $receiver){
        return false;
	}

	public function forward(StudentReg $receiver){
        return false;
	}

    public static function notApprovedRequests(){
        $criteria = new CDbCriteria();
        $criteria->addCondition('date_approved IS NULL');
		$criteria->addCondition('cancelled='.MessagesAuthorRequest::ACTIVE);

        return MessagesAuthorRequest::model()->findAll($criteria);
    }

    public static function listAllRequests(){
        $criteria = new CDbCriteria();
        $criteria->condition = 'cancelled='.MessagesAuthorRequest::ACTIVE;
        $requests = MessagesAuthorRequest::model()->findAll($criteria);
        $return = array('data' => array());

        foreach ($requests as $record) {
            $row = array();

            $row["user"] = $record->message0->sender0->userNameWithEmail();
            $row["module"]["title"] = $record->idModule->getTitle();
            $row["module"]["link"] = "'".Yii::app()->createUrl("/_teacher/_admin/request/request", array(
                    "message" => $record->id_message,
                    "module" => $record->id_module))."'";
            $row["dateCreated"] = date("d-m-Y", strtotime($record->message0->create_date));
            $row["userApproved"] = ($record->userApproved)?$record->userApproved->userNameWithEmail():"";
            $row["dateApproved"] = ($record->date_approved)?date("d-m-Y", strtotime($record->date_approved)):"";

            array_push($return['data'], $row);
        }

        return json_encode($return);
    }

    public function setDeleted(){
        $this->cancelled = MessagesAuthorRequest::DELETED;

        return $this->save();
    }

    public function approve($userApprove){
        $user = RegisteredUser::userById($this->message0->sender);
        //add rights to edit module
        if($user->setRoleAttribute(UserRoles::AUTHOR, 'module', $this->id_module)) {
            //update current request, set approved status
            $this->user_approved = $userApprove;
            $this->date_approved = date("Y-m-d H:i:s");
            return $this->save();
        } else {
            return false;
        }
    }
}