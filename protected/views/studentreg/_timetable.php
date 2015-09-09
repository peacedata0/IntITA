<p class="tabHeader"><?php echo Yii::t('profile', '0109'); ?></p>
<table class="exmCons">
    <tr>
        <td>
            <img src="<?php echo StaticFilesHelper::createPath('image', 'icons', 'timetable.png');?>"/>
        </td>
        <td>
            <?php
            echo CHtml::ajaxLink(
                "<span >" .Yii::t('profile', '0608'). "</span>",
                Yii::app()->createUrl('studentreg/timetableprovider', array('user' => $user->id, 'tab' => 1)),
                array(
                    'update' => '#timetablecontent'
                ),
                array('class'=>'unselectedTab', 'onclick'=>'selectTab(this)')
            );
            ?>
        </td>
        <td>
            <img src="<?php echo StaticFilesHelper::createPath('image', 'icons', 'exam.png');?>"/>
        </td>
        <td>
            <?php
            echo CHtml::ajaxLink(
                "<span >" . Yii::t('profile', '0111') . "</span>",
                Yii::app()->createUrl('studentreg/timetableprovider', array('user' => $user->id, 'tab' => 2)),
                array(
                    'update' => '#timetablecontent'
                ),
                array('class'=>'unselectedTab', 'onclick'=>'selectTab(this)')
            );
            ?>
        </td>
        <td>
            <img src="<?php echo StaticFilesHelper::createPath('image', 'icons', 'consultation.png');?>"/>
        </td>
        <td>
            <?php
            echo CHtml::ajaxLink(
                "<span>" . Yii::t('profile', '0110') . "</span>",
                Yii::app()->createUrl('studentreg/timetableprovider', array('user' => $user->id, 'tab' => 3)),
                array(
                    'update' => '#timetablecontent'
                ),
                array('class'=>'unselectedTab', 'onclick'=>'selectTab(this)')
            );
            ?>
        </td>
        <td>
            <img src="<?php echo StaticFilesHelper::createPath('image', 'icons', 'imp.png');?>"/>
        </td>
        <td>
            <?php
            echo CHtml::ajaxLink(
                "<span>" . Yii::t('profile', '0124') . "</span>",
                Yii::app()->createUrl('studentreg/timetableprovider', array('user' => $user->id, 'tab' => 4)),
                array(
                    'update' => '#timetablecontent'
                ),
                array('class'=>'unselectedTab', 'onclick'=>'selectTab(this)')
            );
            ?>
        </td>
        <td>
            <img src="<?php echo StaticFilesHelper::createPath('image', 'icons', 'kdp.png');?>"/>
        </td>
        <td>
            <?php
            echo CHtml::ajaxLink(
                "<span>" . Yii::t('profile', '0125') . "</span>",
                Yii::app()->createUrl('studentreg/timetableprovider', array('user' => $user->id, 'tab' => 5)),
                array(
                    'update' => '#timetablecontent'
                ),
                array('class'=>'unselectedTab', 'onclick'=>'selectTab(this)')
            );
            ?>
        </td>
    </tr>
</table>
<div class="consult" id="timetablecontent">
    <div style="display: none">
        <?php $this->renderPartial('_timetableprovider', array('dataProvider' => $dataProvider, 'userId' => $user->id)); ?>
    </div>
</div>
<script>
    function selectTab(n) {
        $('.unselectedTab').removeClass('selectedTab');
        $(n).addClass('selectedTab');
    }
</script>
