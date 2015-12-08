<?php
/**
 * Created by PhpStorm.
 * User: Wizlight
 * Date: 04.12.2015
 * Time: 10:56
 */
$enabledLessonOrder = Lecture::getLastEnabledLessonOrder($lecture->idModule);
?>
<div id="sidebarLesson">
    <div class="titlesBlock" id="titlesBlock">
        <ul><?php if ($idCourse != 0) { ?>
                <li>
                    <?php echo Yii::t('lecture', '0070'); ?>
                    <a href="<?php echo Yii::app()->createUrl('course/index', array('id' => $idCourse)) ?>"><?php echo $lecture->getCourseInfoById($idCourse)['courseTitle']; ?></a>(<?php echo Yii::t('lecture', '0071') . strtoupper($lecture->getCourseInfoById($idCourse)['courseLang']); ?>
                    )
                </li>
                <li>
                    <?php echo Yii::t('lecture', '0072'); ?>
                    <a href="<?php echo Yii::app()->createUrl('module/index', array('idModule' => $lecture['idModule'], 'idCourse' => $idCourse)) ?>"><?php echo Module::getModuleName($lecture->idModule); ?></a>
                </li>
            <?php } else { ?>
                <li>
                    <?php echo Yii::t('lecture', '0072'); ?>
                    <a href="<?php echo Yii::app()->createUrl('module/index', array('idModule' => $lecture['idModule'])) ?>"><?php echo Module::getModuleName($lecture->idModule); ?></a>
                </li>
            <?php } ?>
            <li><?php echo Yii::t('lecture', '0073') . " " . $lecture->order . ': '; ?>
                <?php
                $browser = CommonHelper::detectBrowser($_SERVER['HTTP_USER_AGENT']);
                $cmp = CommonHelper::checkForBrowserVersion($browser, array(
                    'Internet Explorer' => array(9, 0)
                ));
                if ($cmp < 0) {
                    $this->renderPartial('_chaptersList', array('idLecture' => $lecture->id, 'isFree' => $lecture->isFree, 'passedPages' => $passedPages, 'editMode' => $editMode, 'idCourse' => $idCourse));
                }else {
                    $this->renderPartial('_jsChaptersListTemplate', array('idLecture' => $lecture->id, 'isFree' => $lecture->isFree, 'passedPages' => $passedPages, 'editMode' => $editMode, 'idCourse' => $idCourse));
                }
                ?>
            </li>
            <li style="margin-bottom: 0"><?php echo Yii::t('lecture', '0074'); ?>
                <div id="lectionTypeText"><?php echo $lecture->getTypeInfo()['text']; ?></div>
                <div id="lectionTypeImage"><img
                        src="<?php echo StaticFilesHelper::createPath('image', 'lecture', $lecture->getTypeInfo()['image']); ?>">
                </div>
            </li>
            <li>
                <div id="subTitle"><?php echo Yii::t('lecture', '0075'); ?></div>
                <div id="lectureTimeText"><?php echo $lecture->durationInMinutes . Yii::t('lecture', '0076'); ?></div>
                <div id="lectureTimeImage">
                    <img src="<?php echo StaticFilesHelper::createPath('image', 'lecture', 'timeIco.png'); ?>">
                </div>
            </li>
            <li style="margin-bottom:0;margin-top: 20px">
                <?php echo '(' . $lecture->order . ' / ' . Module::getLessonsCount($lecture->idModule) . ' ' . Yii::t('lecture', '0616') . ')'; ?>
            </li>
            <div id="counter">
                <?php
                if ($editMode || StudentReg::isAdmin()) {
                    for ($i = 0; $i < Module::getLessonsCount($lecture->idModule); $i++) {
                        $lectureId = Lecture::getLectureIdByModuleOrder($lecture->idModule, $i + 1)->id;
                        ?>
                        <a href="<?php echo Yii::app()->createUrl("lesson/index", array("id" => $lectureId, "idCourse" => $idCourse)) ?>"
                           tooltip-html-unsafe="<?php echo Lecture::getLectureTitle($lectureId); ?>">
                            <div class="lectureAccess" id="<?php if($i+1==$lecture->order) echo 'thisLecture'?>"></div>
                        </a>
                    <?php }
                } else {
                    for ($i = 0; $i < Module::getLessonsCount($lecture->idModule); $i++) {
                        $lectureId = Lecture::getLectureIdByModuleOrder($lecture->idModule, $i + 1)->id;
                        $lectureOrder = Lecture::getLectureIdByModuleOrder($lecture->idModule, $i + 1)->order;
                        if (Lecture::accessLecture($lectureId, $lectureOrder, $enabledLessonOrder)) { ?>
                            <a href="<?php echo Yii::app()->createUrl("lesson/index", array("id" => $lectureId, "idCourse" => $idCourse)) ?>"
                               tooltip-html-unsafe="<?php echo Lecture::getLectureTitle($lectureId); ?>">
                                <div class="lectureAccess" id="<?php if($i+1==$lecture->order) echo 'thisLecture'?>"></div>
                            </a>
                        <?php } else { ?>
                            <a
                                tooltip-html-unsafe="<span class='titleNoAccessMin'><?php echo Lecture::getLectureTitle($lectureId); ?></span><span class='noAccessMin'> (<?php echo Yii::t('lecture', '0638'); ?>)</span>">
                                <div class="lectureDisabled"></div>
                            </a>
                        <?php }
                    } ?>
                    <div id="iconImage">
                        <img
                            src="<?php echo StaticFilesHelper::createPath('image', 'lecture', 'medalIcoFalse.png'); ?>">
                    </div>
                <?php } ?>
            </div>
        </ul>
    </div>
    <br>

    <div class="helpHeader"><?php echo Yii::t('lecture', '0660'); ?></div>
    <div style="clear: both;margin-left: 15px;">
        <div style="display: inline-block; margin-right: 10px;">
            <!-- mibew button -->
            <a id="mibew-agent-button"
               href="<?php echo Config::getBaseUrl(); ?>/mibew/chat?locale=<?php echo CommonHelper::getLanguage(); ?>;style=default"
               target="_blank" onclick="Mibew.Objects.ChatPopups['55bf44d367c197db'].open();return false;">
                <img class='consultationButtons'
                     src="<?php echo Config::getBaseUrl(); ?>/mibew/b?i=mblue&amp;lang=<?php echo CommonHelper::getLanguage(); ?>"
                     border="0" alt=""/>
            </a>
            <script type="text/javascript"
                    src="<?php echo Config::getBaseUrl(); ?>/mibew/js/compiled/chat_popup.js"></script>
            <script type="text/javascript">Mibew.ChatPopup.init({
                    "id": "55bf44d367c197db",
                    "url": "http:\/\/<?php echo Config::getBaseUrlWithoutSchema(); ?>\/mibew\/chat?locale=<?php echo CommonHelper::getLanguage(); ?>&style=default<?php echo StudentReg::getNameEmail(); ?>",
                    "preferIFrame": true,
                    "modSecurity": false,
                    "width": 640,
                    "height": 480,
                    "resizable": true,
                    "styleLoader": "http:\/\/<?php echo Config::getBaseUrlWithoutSchema(); ?>\/mibew\/chat\/style\/popup"
                });
            </script>
            <!-- / mibew button -->
        </div>
        <div style="display: inline-block">
            <a class='consultationButtons' href="skype:<?php echo '#' ?>?chat">
                <div id="skypeAssistance">
                    <img class="consultationLogos" src="<?php echo StaticFilesHelper::createPath('image', 'lecture', 'skypeLogo.png'); ?>">
                    <div class="consultationText"><?php echo Yii::t('lecture', '0665'); ?></div>
                </div>
            </a>
        </div>
    </div>

    <div id="discussionHeader"><?php echo Yii::t('lecture', '0617'); ?></div>

    <div id="discussion"></div>
    <?php if (StudentReg::canAddConsultation()) { ?>
        <div style="display: inline-block;margin-left: 15px">
            <a class='consultationButtons' href="<?php echo Yii::app()->createUrl('/consultationscalendar/index', array('lectureId' => $lecture->id, 'idCourse' => $idCourse)); ?>">
                <div id="consultationAssistance">
                    <img class="consultationLogos" src="<?php echo StaticFilesHelper::createPath('image', 'lecture', 'consultationLogo.png'); ?>">
                    <div class="consultationText"><?php echo Yii::t('lecture', '0079') ?></div>
                </div>
            </a>
        </div>
    <?php } ?>
</div>
<!--navigation vertical-->
<script>
    $("#send-message").click(function (e) {
        var mibewMessage = $('[name="message"]');
        mibewMessage.val($.trim(mibewMessage.val()));
    });
</script>