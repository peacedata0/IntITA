<?php
/* @var $model Course*/
$lessonsCount = Course::getLessonsCount($model->course_ID);?>
<script>
    course = "<?php echo $model->course_ID;?>";
</script>
<img class="courseImg" style="display: inline-block;margin-bottom:30px; "
     src="<?php echo StaticFilesHelper::createPath('image', 'course', $model->course_img); ?>"/>
<div class="courseShortInfoTable">
    <table class="courseLevelInfo">
        <tr>
            <td>
                <span class="colorP"><b><?php echo Yii::t('course', '0193'); ?></b></span>&nbsp;
                <span class="courseLevel">
                    <?php echo $model->level(); ?>
                </span>
            </td>
            <td class="courseLevel">
                <div>
                    <?php
                    $rate = $model->getRate();
                    for ($i = 0; $i < $rate; $i++) {
                        ?>
                        <img src="<?php echo StaticFilesHelper::createPath('image', 'common', 'ratIco1.png'); ?>">
                    <?php
                    }
                    for ($j = $rate; $j < 5; $j++) {
                        ?>
                        <img src="<?php echo StaticFilesHelper::createPath('image', 'common', 'ratIco0.png'); ?>">
                    <?php
                    }
                    ?>
                </div>
            </td>
        </tr>
    </table>
    <div class="courseDetail">
        <div>
            <?php if ($lessonsCount > 0) { ?>
                <span id="demo">
                <?php if (isset($_SESSION['lg']) ? $lg = $_SESSION['lg'] : $lg = 'ua') ; ?>
                    <a href='<?php echo Yii::app()->createUrl('course/schema', ['id' => $model->course_ID]);
                    ?>'><?php echo Yii::t('course', '0662'); ?></a>
            </span>
                <br>
            <?php } ?>
            <span class="colorP"><?php echo Yii::t('course', '0194'); ?></span>
            <b><?php echo $lessonsCount . ' ' . Yii::t('module', '0216'); ?></b>
            <?php if ($lessonsCount != 0) {
                echo ', ' . Yii::t('course', '0209'); ?>
                -<b>
                    <?php echo ceil($lessonsCount / 36); ?><?php echo Yii::t('course', '0664'); ?>
                </b>
                <?php echo '(3 ' . Yii::t('module', '0219'); ?>, 3 <?php echo Yii::t('module', '0220') . ')';
            } ?>
        </div>
        <?php $this->renderPartial('_paymentsForm', array('model' => $model)); ?>
    </div>
</div>

<script type="text/javascript" src="<?php echo StaticFilesHelper::fullPathTo('js', 'jquery.cookie.js'); ?>"></script>
