<!-- lesson style -->
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/lessonsStyle.css" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/lectureStyles.css" />

<!-- lesson style -->
<!-- Підсвітка синтаксису-->
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/scripts/syntaxhighlighter/prettify.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/syntaxhighlighter/prettify.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/syntaxhighlighter/prettify.init.js"></script>
<!-- Підсвітка синтаксису -->
<!-- Підключення BBCode WysiBB -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/wysibb/jquery.wysibb.min.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/scripts/wysibb/theme/default/wbbtheme.css" type="text/css" />
<script src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/wysibb/lang/ua.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/wysibb/BBCode.js"></script>
<!-- Підключення BBCode WysiBB -->
<!-- Spoiler -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/SpoilerContent.js"></script>
<!-- Spoiler -->
<!--Sidebar-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/SidebarLesson.js"></script>
<!--Sidebar-->
<!--Font Awesome-->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css">
<!--Font Awesome-->
<!--Load Redactor-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/loadRedactor.js"></script>
<!--Load Redactor-->
<script type="text/javascript">
    idLecture = <?php echo $lecture->id;?>;
    order = 1;
</script>
<?php
/* @var $this LessonController */

$this->pageTitle = 'INTITA';
$this->breadcrumbs=array(
    Yii::t('breadcrumbs', '0050')=>Yii::app()->request->baseUrl."/courses",$lecture->getCourseInfoById()['courseTitle']=>Yii::app()->createUrl('course/index', array('id' => 1)),$lecture->getModuleInfoById()['moduleTitle']=>Yii::app()->createUrl('module/index', array('idModule' => $lecture['idModule'])),$lecture['title'],
);
?>

<div class="lectureMainBlock" >
    <?php $this->renderPartial('_lectureInfo', array('lecture'=>$lecture));?>
    <?php $this->renderPartial('_teacherInfo', array('lecture'=>$lecture));?>
</div>

<div class="lessonBlock" id="lessonBlock">
    <?php $this->renderPartial('_sidebar', array('lecture'=>$lecture));?>
    <div class="lessonText">
        <h1 class="lessonTheme"><?php echo $lecture['title']?></h1>
        <span class="listTheme">Зміст </span><span class="spoilerLinks"><span class="spoilerClick">(показати)</span><span class="spoilerTriangle"> &#9660;</span></span>

        <div class="spoilerBody">
            <p><a href="#Частина 1: Типи змінних та перемінних">Частина 1: Типи змінних та перемінних</a></p>
            <p><a href="#Частина 7: Типи данних та математичний аналіз">Частина 7: Типи данних та математичний аналіз</a></p>
        </div>
        <!-- Lesson content-->
        <?php

        $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_content',
            'summaryText' => '',
            'viewData' => array('editMode' => $editMode),
            'emptyText' => 'В данной лекции еще ничего нет (<br><br><br><br><br>',
            'pagerCssClass'=>'YiiPager',
        ));
        ?>
    </div>
<!--<table ><tr><td>-->
<!--        <div class="download" id="do4">  <a  href="#"><img style="" src="--><?php //echo Yii::app()->request->baseUrl; ?><!--/css/images/000zav-yrok.png">Завантажити урок</a></div>-->
<!--            </td><td>-->
<!--            <div class="download" id="do3"> <a href="#"><img style="" src="--><?php //echo Yii::app()->request->baseUrl; ?><!--/css/images/000zav-ysi-vid.png">Завантажити всі відео</a></div>-->
<!--            </td><td>-->
<!--                <div class="download" id="do1">  <a href="#"><img style="" src="--><?php //echo Yii::app()->request->baseUrl; ?><!--/css/images/000zav-ysi-vid2.png">Завантажити всі відео</a></div>-->
<!--</td></tr></table>-->
<!--</div>-->
<?php if($editMode){?>
        <div id="textBlockForm">
            <form id="addTextBlock" action="<?php echo Yii::app()->createUrl('lesson/createNewBlock');?>" method="post">
                <br>
                <span id="formLabel">Новий текстовий блок:</span>
                <br>
                <input name="idLecture" value="<?php echo $lecture->id;?>" hidden="hidden">
                <input name="order" value="<?php echo ($countBlocks + 1);?>" hidden="hidden">
                <textarea name="newTextBlock" id="newTextBlock" cols="108"
                          placeholder="Введіть текст нового блока" required form="addTextBlock" rows="10">
                </textarea>
                <br><br>
                <input type="submit"  value="Додати" id="submitButton">
            </form>
        </div>
    <br>
    <br>
<?php }?>
    <!-- lesson footer ----congratulations-->
<?php $this->renderPartial('_lectureFooter', array('lecture'=>$lecture));?>
<!--modal task -->
<?php
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
//    'id' => 'mydialog2',
//    'themeUrl'=>Yii::app()->request->baseUrl.'/css',
//    'cssFile'=>'jquery-ui2.css',
//    'theme'=>'my',
//    'options' => array(
//        'width'=>540,
//        'autoOpen' => false,
//        'modal' => true,
//        'resizable'=> false,
//    ),
//));
//$this->renderPartial('/lesson/_modalTask');
//$this->endWidget('zii.widgets.jui.CJuiDialog');
//?>
<!--<!--modal task ---congratulations-->
<!---->
<!---->
<!---->
<!---->
<!---->
<!--<!--modal task ---error1--->
<?php
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
//    'id' => 'mydialog3',
//    'themeUrl'=>Yii::app()->request->baseUrl.'/css',
//    'cssFile'=>'jquery-ui3.css',
//    'theme'=>'my',
//    'options' => array(
//        'width'=>540,
//        'autoOpen' => false,
//        'modal' => true,
//        'resizable'=> false
//    ),
//));
//$this->renderPartial('/lesson/_modalTask2');
//$this->endWidget('zii.widgets.jui.CJuiDialog');
//?>
<!--<!--modal task ---error-->
</div>

