<div class="element">
    <?php $this->renderPartial('/revision/_editToolbarCKE', array(
        'idEl' =>  $data['id'],
        'editMode' => $editMode,
    ));?>

<div edit-block class="codeExample" id="<?php echo "t" .  $data['block_order'];?>" >
    <div ng-non-bindable>
        <?php echo $data['html_block'];?>
    </div>
</div>
</div>
