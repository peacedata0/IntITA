<?php
/**
 * Created by PhpStorm.
 * User: Ivanna
 * Date: 12.08.2015
 * Time: 1:47
 */
$pagesList = LectureHelper::getPagesList($idLecture);?>
<div name="lecturePage" class="pagesList">
<h1 class="lessonPartEdit">
<?php
for($i = 0, $count = count($pagesList); $i < $count; $i++){
    ?>
    <div class="labelBlock" >
        <p>
            <img src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'up.png');?>" class="editIco"
                 onclick="upPage(<?php echo $idLecture;?>, <?php echo $pagesList[$i]["page_order"];?>);">
            <img src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'down.png');?>" class="editIco"
                 onclick="downPage(<?php echo $idLecture;?>, <?php echo $pagesList[$i]["page_order"];?>);">
            <img src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'delete.png');?>" class="editIco"
             onclick="deletePage(<?php echo $idLecture;?>, <?php echo $pagesList[$i]["page_order"];?>, <?php echo $idCourse;?>);">
       <a href="<?php echo Yii::app()->createURL('lesson/index', array('id' => $idLecture, 'idCourse' => $idCourse));?>/?page=<?php echo $pagesList[$i]["page_order"]?>&editPage=<?php echo $pagesList[$i]["page_order"]?>">
   <?php echo 'Частина '.$pagesList[$i]["page_order"].'. '.$pagesList[$i]["page_title"];
?>
  </a></p></div>
<?php }?>
</h1>
<br>
<h1 class="lessonPartEdit"><p>
<a href="<?php echo Yii::app()->createUrl('lesson/addNewPage', array('lecture' => $idLecture, 'page' => $i));?>"> Додати нову частину </a>
</p></h1>
</div>