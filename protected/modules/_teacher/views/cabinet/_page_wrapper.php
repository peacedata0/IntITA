<?php
/* @var $model StudentReg */
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header" id="pageTitle">Особистий кабінет</h1>
        </div>
    </div>
    <div id="pageContainer">
        <div class="row">
            <div class="col-lg-12">
    <?php echo $this->renderPartial('_dashboard',array(
            'model' => $model,
    )) ?>
            </div>
         </div>
    </div>
</div>

