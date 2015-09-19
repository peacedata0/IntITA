<?php

class CoursePath extends Path{
    public $course;
    public $module;
    public $lecture;
    public $lang;

    function init(){
        $course = null;
        $module = null;
        $lecture = null;
        $lang = null;
    }

    public function parseUrl(){

        $this->getCourse();
        if($this->course != null) {
            $this->getModule();
            if($this->module != null) {
                $this->getLecture();
            }
        }

        return $this;
    }

    private function getCourse(){
        if (!in_array($this->pathArray[1], array('ru', 'ua', 'en'))){
            $this->course = Course::model()->find(array(
                'condition' => 'alias = :alias',
                'params' => array('alias' => $this->pathArray[1]),
            ));
        } else {
            $this->lang = $this->pathArray[1];
            $this->course = Course::model()->find(array(
                'condition' => 'alias = :alias',
                'params' => array('alias' => $this->pathArray[2]),
            ));
        }
    }

    private function getModule(){
        $moduleAlias = $this->getModuleAlias();
        if (!is_null($moduleAlias)) {
            $this->module = Module::getModuleByAlias($moduleAlias, $this->course->course_ID);
        }
    }

    private function getLecture(){
        $lectureOrder = $this->getLectureOrder();

        if (!is_null($lectureOrder)) {
            $this->lecture = Lecture::getLectureIdByModuleOrder($this->module->module_ID, $lectureOrder);
        }
    }

    private function getModuleAlias(){
        if (is_null($this->lang)){
            if (isset($this->pathArray[2])) {
                return $this->pathArray[2];
            }
        } else {
            if (isset($this->pathArray[3])) {
                return $this->pathArray[3];
            }
        }
        return null;
    }

    private function getLectureOrder(){
        if (is_null($this->lang)){
            if (isset($this->pathArray[3])) {
                return $this->pathArray[3];
            }
        } else {
            if (isset($this->pathArray[4])) {
                return $this->pathArray[4];
            }
        }
        return null;
    }

    public function getType(){
        return 'course';
    }
}