<?php
/**
 * Created by PhpStorm.
 * User: Ivanna
 * Date: 04.06.2015
 * Time: 16:04
 */
/* @var $this PayController */
$this->pageTitle=Yii::app()->name;
$this->breadcrumbs=array(
    'Сплатити зараз',
);
?>


<div id="addAccess">
    <br>
    <a name="form"></a>
    <form action="<?php echo Yii::app()->createUrl('pay/payNow');?>" method="POST" name="add-access">
        <fieldset>
            <legend id="label">Оплатити модуль:</legend>
            Курс:<br>
            <select name="course" placeholder="(Виберіть курс)" onchange="javascript:selectModule();">
                <option value="">Всі курси</option>
                <optgroup label="Виберіть курс">
                    <?php $courses = AccessHelper::generateCoursesList();
                    $count = count($courses);
                    for($i = 0; $i < $count; $i++){
                        ?>
                        <option value="<?php echo $courses[$i]['id'];?>"><?php echo $courses[$i]['alias'];?></option>
                    <?php
                    }
                    ?>
            </select>
            <br>
            <br>

            Модуль:<br>
            <div name="selectModule" style="float:left;"></div>
            <br>
            <br>

            <fieldset id="rights">
                <legend>Права</legend>
                <input type="checkbox" name="read" value="1" />READ<br />
                <input type="checkbox" name="edit" value="2" />EDIT<br />
                <input type="checkbox" name="create" value="3" />CREATE<br />
                <input type="checkbox" name="delete" value="4" />DELETE<br/>
            </fieldset>
            <input type="submit" value="Сплатити зараз">
    </form>
</div>




<script type="text/javascript">
    function selectModule(){
        var course = $('select[name="course"]').val();
        if(!course){
            $('div[name="selectModule"]').html('');
            $('div[name="selectLecture"]').html('');
        }else{
            $.ajax({
                type: "POST",
                url: "/IntITA/permissions/showModules",
                data: {course: course},
                cache: false,
                success: function(response){ $('div[name="selectModule"]').html(response); }
            });
        }
    }
</script>