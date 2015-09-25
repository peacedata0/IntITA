<?php //$this->renderPartial('/site/_shareMetaTag', array(
//    'url'=>Yii::app()->createAbsoluteUrl(Yii::app()->request->url),
//    'title'=>Yii::t('graduates', '0297'),
//    'description'=>'Бажаєте стати висококласним програмістом і гарантовано отримати престижну, високооплачувану роботу? INTITA - те, що ви шукали',
//    'image'=>StaticFilesHelper::createPath('image', 'mainpage', 'intitaLogo.jpg')));
//?>
<div id="sharing">
    <div class="share42init" data-top1="75" data-top2="110" data-margin="15"
         data-url="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->request->url) ?>"
         data-title="<?php echo Yii::t('graduates', '0297')?>"
         data-image='<?php StaticFilesHelper::createPath('image', 'mainpage', 'intitaLogo.jpg'); ?>'
         data-description="Бажаєте стати висококласним програмістом і гарантовано отримати престижну, високооплачувану роботу? INTITA - те, що ви шукали"
         data-path="<?php echo Config::getBaseUrl(); ?>/scripts/share42/"
         data-zero-counter="1">
    </div>
</div>
<script type="text/javascript" src="<?php echo Config::getBaseUrl(); ?>/scripts/share42/share42.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo Config::getBaseUrl(); ?>/css/GraduatesStyle.css" />

<div class="subNavBlockGraduates">
    <?php
    $this->pageTitle = 'INTITA';
    $this->breadcrumbs=array(
        Yii::t('breadcrumbs', '0296'),
    );
     ?>
</div>
<div class="graduateBlock">
    <div  class="graduates">
        <h1><?php echo Yii::t('graduates', '0297')?></h1>
        <?php echo $this->renderPartial('_graduateFilter'); ?>
    </div>
    <div id="graduateBlock">
        <?php echo $this->renderPartial('_graduatesList', array('dataProvider'=>$dataProvider)); ?>
    </div>
</div>