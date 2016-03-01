<?php
/**
 * @var $module Module
 * @var $data Lecture
 */
$enabledLessonOrder = Lecture::getLastEnabledLessonOrder($module->module_ID);
?>

<div class="lessonModule" id="lectures">
    <?php if ($canEdit){?>
        <a href="<?php echo Yii::app()->createUrl("module/edit", array("idModule" => $module->module_ID, "idCourse" => $idCourse)); ?>">
            <img src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'edt_30px.png'); ?>"
                 id="editIco" title="<?php echo Yii::t('module', '0373'); ?>"/>
        </a>
    <?php } ?>
    <h2><?php echo Yii::t('module', '0225'); ?></h2>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'lectures-grid',
    'dataProvider' => $dataProvider,
    'emptyText' => Yii::t('module', '0375'),
    'columns' => array(
        array(
            'class'=>'DataColumn',
            'name' => 'alias',
            'type' => 'raw',
            'value' =>function($data) use ($enabledLessonOrder,$idCourse) {
                if (Lecture::accessLecture($data->id,$data->order,$enabledLessonOrder,$idCourse))
                    $img=CHtml::image(StaticFilesHelper::createPath('image', 'module', 'enabled.png'));
                else $img=CHtml::image(StaticFilesHelper::createPath('image', 'module', 'disabled.png'));
                $data->order == 0 ? $value="Виключено":$value=$img.Yii::t('module', '0381').' '.$data->order.'.';
                return $value;
            },
            'header'=>false,
            'htmlOptions'=>array('class'=>'aliasColumn'),
            'headerHtmlOptions'=>array('style'=>'width:0%; display:none'),
        ),
        array(
            'name' => 'title',
            'type' => 'raw',
            'header'=>false,
            'htmlOptions'=>array('class'=>'titleColumn'),
            'headerHtmlOptions'=>array('style'=>'width:0%; display:none'),
            'value' => function($data) use ($idCourse,$enabledLessonOrder) {
                $titleParam = 'title_'.CommonHelper::getLanguage();
                if($data->$titleParam == ''){
                    $titleParam = 'title_ua';
                }
            if (Lecture::accessLecture($data->id,$data->order,$enabledLessonOrder,$idCourse)) {
                return CHtml::link(CHtml::encode($data->$titleParam), Yii::app()->createUrl("lesson/index",
                    array("id" => $data->id, "idCourse" => $idCourse)));
            }
            else
                return CHtml::encode($data->$titleParam);
            }
        ),
    ),
    'summaryText' => '',
    ));
    ?>
</div>