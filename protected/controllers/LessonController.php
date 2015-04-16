<?php
/* @var $lecture Lecture*/

class LessonController extends Controller{

    public function init($id=1)
    {
        if(Yii::app()->user->isGuest){
            throw new CHttpException(403, 'Sorry, you couldn\'t view this lecture.
            Please login for getting access to this material.');
        }
        else{
            $permission = new Permissions();
            if ($permission->checkPermission(Yii::app()->user->getId(), $id, array('read'))){

            } else {
                throw new CHttpException(403, 'Sorry, you couldn\'t view this lecture.
                You don\'t have access to this lecture.
                Please go to your profile and pay access.');
            }
        }
    }

    public function actionIndex($id = 1){
        $dataProvider = new CActiveDataProvider('LectureElement');
//        $dataProvider->setPagination(array(
//                'pageSize' => count($dataProvider),
//            )
//        );
        $lecture = Lecture::model()->findByPk($id);

        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'lecture' => $lecture,
        ));
    }
}