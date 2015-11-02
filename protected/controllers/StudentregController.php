<?php

class StudentRegController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function filters()
    {
        return array(
            'accessControl',
        );
    }
    public function accessRules()
    {
        return array(
            array('deny',
                'actions'=>array('profile', 'edit'),
                'users'=>array('?'),
            ),
            array('deny',
                'actions'=>array('index', 'registration'),
                'users'=>array('@'),
                'deniedCallback'=>function() { Yii::app()->controller->redirect(array ('/site/index')); },
            ),
        );
    }
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new StudentReg;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['StudentReg'])) {
            $model->attributes = $_POST['StudentReg'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['StudentReg'])) {
            $model->attributes = $_POST['StudentReg'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */

    public function actionIndex($email = '')
    {
        $model = new StudentReg('reguser');
        $this->render("studentreg", array('model' => $model, 'email' => $email));
    }

    public function actionRegistration()
    {
        $model = new StudentReg('reguser');

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['StudentReg'])) {
            if (isset($_POST['educformOff']) && $_POST['educformOff'] == '1')
                $_POST['StudentReg']['educform'] = 'Онлайн/Офлайн';
            else $_POST['StudentReg']['educform'] = 'Онлайн';

            $model->attributes = $_POST['StudentReg'];

            $getToken = rand(0, 99999);
            $getTime = date("Y-m-d H:i:s");
            $model->token = sha1($getToken . $getTime);

            if (isset($model->avatar)) $model->avatar = CUploadedFile::getInstance($model, 'avatar');
            if ($model->validate()) {
                if (isset($model->avatar)) {
                    $fileName = FileUploadHelper::getFileName($model->avatar);
                    $model->avatar->saveAs(Yii::getpathOfAlias('webroot') . "/images/avatars/" . $fileName);
                    $model->avatar = $fileName;
                }

                if (Yii::app()->session['lg']) $lang = Yii::app()->session['lg'];
                else $lang = 'ua';
                $model->save();
                if ($model->avatar == Null) {
                    $thisModel = new StudentReg();
                    $thisModel->updateByPk($model->id, array('avatar' => 'noname.png'));
                }
                $subject = Yii::t('activeemail', '0298');
                $headers = "Content-type: text/plain; charset=utf-8 \r\n" . "From: no-reply@" . Config::getBaseUrlWithoutSchema();
                $text = Yii::t('activeemail', '0299') .
                    " " . Config::getBaseUrl() . "/index.php?r=site/AccActivation/view&token=" . $model->token . "&email=" . $model->email . "&lang=" . $lang;;
                mail($model->email, $subject, $text, $headers);
                $this->redirect(Yii::app()->createUrl('/site/activationinfo', array('email' => $model->email)));
            } else {
                $this->render("studentreg", array('model' => $model));
            }
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new StudentReg('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StudentReg']))
            $model->attributes = $_GET['StudentReg'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return StudentReg the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = StudentReg::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param StudentReg $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'student-profile-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function checkAccess($id = 1, $right, $code1, $code2)
    {
        if (Yii::app()->user->isGuest) {
            throw new CHttpException(403, Yii::t('errors', $code1));
        } else {
            $permission = new Permissions();
            if (!$permission->checkPermission(Yii::app()->user->getId(), $id, array($right))) {
                throw new CHttpException(403, Yii::t('errors', $code2));
            }
        }
    }

    public function actionProfile($idUser=0)
    {
        if ($idUser == 0){
            $idUser = Yii::app()->request->getPost('idUser', '0');
        }
        $idCourse = Yii::app()->request->getPost('course', '0');
        $idModule = Yii::app()->request->getPost('module', '0');
        $schema = Yii::app()->request->getPost('schema', '1');

        $model = StudentReg::model()->findByPk($idUser);
        if ($idUser !== Yii::app()->user->getId())
            throw new CHttpException(403, Yii::t('error', '0612'));
        $letter = new Letters();

        $dataProvider = StudentReg::getDataProfile($idUser);

        $sentLettersProvider = Letters::getSentLettersData($idUser);

        $receivedLettersProvider = Letters::getReceivedLettersData($idUser);

        $paymentsCourses = PayCourses::getPaymentsCourses($idUser);

        $paymentsModules = Modules::getPaymentsModules($idUser);

        $markProvider = StudentReg::getMarkProviderData($idUser);

        $this->render("studentprofile", array(
            'dataProvider' => $dataProvider,
            'post' => $model,
            'letter' => $letter,
            'sentLettersProvider' => $sentLettersProvider,
            'receivedLettersProvider' => $receivedLettersProvider,
            'paymentsCourses' => $paymentsCourses,
            'paymentsModules' => $paymentsModules,
            'markProvider' => $markProvider,
            'course' => $idCourse,
            'schema' => $schema,
            'module' => $idModule,
        ));

    }

    public function actionSendletter()
    {
        $model = StudentReg::model()->findByPk(1);

        if ($_POST['submit']) {
            if (!empty($_POST['send_letter'])) {
                $title = $_POST['letterTheme'];
                $mess = $_POST['send_letter'];
                // $to - кому отправляем
                $to = 'Wizlightdragon@gmail.com';
                // $from - от кого
                $from = $model->email;
                // функция, которая отправляет наше письмо.
                mail($to, $title, $mess, "Content-type: text/html; charset=utf-8 \r\n" . "From:" . $from . "\r\n");
                Yii::app()->user->setFlash('messagemail', 'Ваше повідомлення відправлено');
            }
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function actionEdit()
    {
        if (Yii::app()->user->isGuest)
            throw new CHttpException(403, 'Вибачте, перед редагуванням свого профіля авторизуйтеся.');
        $model = new StudentReg('edit');

        $this->render("studentprofileedit", array('model' => $model));

    }

    public function actionRewrite()
    {
        $id = Yii::app()->user->id;
        $model = $this->loadModel($id);
        $model->setScenario('edit');

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'editProfile-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['educformOff']) && $_POST['educformOff'] == '1')
            $_POST['StudentReg']['educform'] = 'Онлайн/Офлайн';
        else $_POST['StudentReg']['educform'] = 'Онлайн';

        $model->attributes = $_POST['StudentReg'];
        if (isset($model->avatar)) $model->avatar = CUploadedFile::getInstance($model, 'avatar');
        if ($model->validate()) {
            if (isset($model->avatar)) {
                $fileName = FileUploadHelper::getFileName($model->avatar);
                $model->avatar->saveAs(Yii::getpathOfAlias('webroot') . "/images/avatars/" . $fileName);
                $model->updateByPk($id, array('avatar' => $fileName));
            }
            $model->updateByPk($id, array('firstName' => $_POST['StudentReg']['firstName']));
            $model->updateByPk($id, array('secondName' => $_POST['StudentReg']['secondName']));
            $model->updateByPk($id, array('nickname' => $_POST['StudentReg']['nickname']));
            $model->updateByPk($id, array('birthday' => $_POST['StudentReg']['birthday']));
            $model->updateByPk($id, array('phone' => $_POST['StudentReg']['phone']));
            $model->updateByPk($id, array('address' => $_POST['StudentReg']['address']));
            $model->updateByPk($id, array('education' => $_POST['StudentReg']['education']));
            $model->updateByPk($id, array('educform' => $_POST['StudentReg']['educform']));
            $model->updateByPk($id, array('interests' => $_POST['StudentReg']['interests']));
            $model->updateByPk($id, array('aboutUs' => $_POST['StudentReg']['aboutUs']));
            $model->updateByPk($id, array('aboutMy' => $_POST['StudentReg']['aboutMy']));
            $model->updateByPk($id, array('facebook' => $_POST['StudentReg']['facebook']));
            $model->updateByPk($id, array('googleplus' => $_POST['StudentReg']['googleplus']));
            $model->updateByPk($id, array('linkedin' => $_POST['StudentReg']['linkedin']));
            $model->updateByPk($id, array('vkontakte' => $_POST['StudentReg']['vkontakte']));
            $model->updateByPk($id, array('twitter' => $_POST['StudentReg']['twitter']));

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if (!empty($_POST['StudentReg']['password']) && sha1($_POST['StudentReg']['password']) == sha1($_POST['StudentReg']['password_repeat']))
                $model->updateByPk($id, array('password' => sha1($_POST['StudentReg']['password'])));

            $this->redirect(Yii::app()->createUrl('/studentreg/profile', array('idUser' => Yii::app()->user->id)));
        } else
            $this->render("studentprofileedit", array('model' => $model));
    }

    public function actionChangepass()
    {
        $modeltest = new StudentReg('changepass');
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'change-form') {
            echo CActiveForm::validate($modeltest);
            Yii::app()->end();
        }
        $id = Yii::app()->user->id;
        $model = StudentReg::model()->findByPk($id);
        $atr = Yii::app()->request->getPost('StudentReg');
        $pass = $atr ['password'];
        if ($model->password == sha1($pass)) {
            if (isset($_POST['StudentReg'])) {
                $model->updateByPk($id, array('password' => sha1($_POST['StudentReg']['new_password'])));
                $this->redirect(Yii::app()->createUrl('studentreg/profile', array('idUser' => Yii::app()->user->getId())));
            }
        }
    }

    public function actionDeleteavatar()
    {
        $id = Yii::app()->user->id;
        $model = StudentReg::model()->findByPk(Yii::app()->user->id);
        if ($model->avatar !== 'noname.png') {
            unlink(Yii::getpathOfAlias('webroot') . '/images/avatars/' . $model->avatar);
            $model->updateByPk($id, array('avatar' => 'noname.png'));
            $this->redirect(Yii::app()->createUrl('studentreg/edit'));
        } else {
            $this->redirect(Yii::app()->createUrl('studentreg/edit'));
        }

    }

    public function actionTimetableProvider($user, $tab)
    {
        $teacher = Teacher::model()->find("user_id=:user_id", array(':user_id' => $user));

        $data = Teacher::getTeacherSchedule($teacher,$user,$tab);

        $this->renderPartial('_timetableprovider', array('dataProvider' => $data, 'userId' => $user));
    }
}
