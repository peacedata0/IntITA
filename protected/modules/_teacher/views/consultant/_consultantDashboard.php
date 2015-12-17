<?php
/**
 * Created by PhpStorm.
 * User: Quicks
 * Date: 10.12.2015
 * Time: 17:40
 * @var $user StudentReg
 * @var $teacher Teacher
 *
 */
?>
<div class="row">
    <div class="col-lg-12">
        <h3>Консультант</h3>
    </div>
</div>
<hr>
<!--<div class="row" id="dashboard">-->
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $teacher->countNotCheckedPlainTask(); ?></div>
                        <div>Задачі до перегляду</div>
                    </div>
                </div>
            </div>
            <a href="#"
               onclick="showPlainTaskAnswer('<?php echo Yii::app()->createUrl('/_teacher/teacher/showTeacherPlainTaskList')?>',
                   <?php echo $teacher->teacher_id ?>)">
                <div class="panel-footer">
                    <span class="pull-left">Продивитись</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>