<?php


abstract class Role
{

    abstract function tableName();

    abstract function checkRoleSql();

    abstract function title();

    abstract function getErrorMessage();

    abstract function getMembers();

    abstract function attributes(StudentReg $user, $organization);

    abstract function addRoleFormList($query, $organization);

    abstract function checkBeforeDeleteRole(StudentReg $user, $organization);

    abstract function checkBeforeSetRole(StudentReg $user, $organization);

    abstract function cancelAttribute(StudentReg $user, $attribute, $value);

    public static function getInstance($role){
        switch($role){
            case "director":
                $model = new Director();
                break;
            case "auditor":
                $model = new Auditor();
                break;
            case "super_admin":
                $model = new SuperAdmin();
                break;
            case "admin":
                $model = new Admin();
                break;
            case "accountant":
                $model = new Accountant();
                break;
            case "trainer":
                $model = new Trainer();
                break;
            case "student":
                $model = new Student();
                break;
            case "author":
                $model = new Author();
                break;
            case "content_manager":
                $model = new ContentManager();
                break;
            case "teacher_consultant":
                $model = new TeacherConsultant();
                break;
            case "tenant":
                $model = new Tenant();
                break;
            case "supervisor":
                $model = new SuperVisor();
                break;
            default :
                $model = null;
        }
        return $model;
    }
    
    public static function getLocalInstance($role){
        switch($role){
            case "accountant":
                $model = new Accountant();
                break;
            case "trainer":
                $model = new Trainer();
                break;
            case "student":
                $model = new Student();
                break;
            case "author":
                $model = new Author();
                break;
            case "content_manager":
                $model = new ContentManager();
                break;
            case "teacher_consultant":
                $model = new TeacherConsultant();
                break;
            case "tenant":
                $model = new Tenant();
                break;
            case "supervisor":
                $model = new SuperVisor();
                break;
            default :
                $model = null;
        }
        return $model;
    }
    
    public static function getGlobalInstance($role){
        switch($role){
            case "director":
                $model = new Director();
                break;
            case "auditor":
                $model = new Auditor();
                break;
            case "super_admin":
                $model = new SuperAdmin();
                break;
            default :
                $model = null;
        }
        return $model;
    }
    
    public function setRole(StudentReg $user, $organization)
    {
        if(!$user->isOrganizationTeacher($organization)){
            throw new \application\components\Exceptions\IntItaException(403, "Користувач не є співробітником");
        }
        if(Yii::app()->db->createCommand()->
        insert($this->tableName(), array(
            'id_user' => $user->id,
            'assigned_by'=>Yii::app()->user->getId(),
            'id_organization'=>$organization,
        ))){
            $this->notifyAssignRole($user, $organization);
            $this->updateRolesRoom();
            return true;
        }
        return false;
    }

    public function cancelRole(StudentReg $user, $organization)
    {
        if(!$this->checkBeforeDeleteRole($user, $organization)){
            return false;
        }

        if(Yii::app()->db->createCommand()->
        update($this->tableName(), array(
            'end_date'=>date("Y-m-d H:i:s"),
            'cancelled_by'=>Yii::app()->user->id
        ), 'id_user=:id and id_organization=:organization', array(':id'=>$user->id,':organization'=>$organization))){
            $this->notifyCancelRole($user, $organization);
            $this->updateRolesRoom();
            return true;
        }
        return false;
    }

    public function setAttribute(StudentReg $user, $attribute, $value){
        return Yii::app()->db->createCommand()->
        update($this->tableName(), array(
            $attribute=>$value,
        ), 'id_user=:id', array(':id'=>$user->id));
    }

    public function notifyAssignRole(StudentReg $user, $organization=null){
        $user->notify('_assignRole', array($this->title(), $organization), 'Призначено роль', Yii::app()->user->getId());
    }

    public function notifyCancelRole(StudentReg $user, $organization=null){
        $user->notify('_cancelRole', array($this->title(), $organization), 'Скасовано роль', Yii::app()->user->getId());
    }

    public function getOrganizations()
    {
        return Yii::app()->db->createCommand()
            ->selectDistinct('id_organization')
            ->from($this->tableName())
            ->where('id_user=:id and end_date IS NULL', array(':id'=>Yii::app()->user->model->registrationData->id))
            ->queryAll();
    }

    public function updateRolesRoom(){
        $url=Config::getFullChatPath()."/roles_operations/update?table=".$this->tableName();
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
//        curl_setopt($curl, CURLOPT_COOKIE, "JSESSIONID=14ui0n0kjocfi4b5t9lpdp2i61;MYSESSIONID=D5380283934C3784F28ED4CFC2B6628A");
//        $out = curl_exec($curl);
//        curl_close($curl);


//        $ch = curl_init();
//        $session=new CHttpSession;
//        $session->open();
//        $headers = array(
//            'Content-type: application/json',
//            'Cookie: JSESSIONID='.'14ui0n0kjocfi4b5t9lpdp2i61',
//        );
//        var_dump($session->getSessionID());
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: JSESSIONID=14ui0n0kjocfi4b5t9lpdp2i61"));
////        curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
//
//        curl_setopt($ch, CURLOPT_URL, 'https://qa.intita.com/crmChat/roles_operations/update?table=user_admin');
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//        curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
//        // $output contains the output string
//        $output = curl_exec($ch);
//        var_dump($output);
//        // close curl resource to free up system resources
//        curl_close($ch);
    }
}