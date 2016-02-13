<?php
/**
 * @var $agreements array
 * @var $agreement UserAgreements
 */
if (!empty($agreements)) { ?>
    Список користувачів по e-mail користувача
    <?php
    foreach ($agreements as $agreement) { ?>
        <div>
            <input type="radio" name="user" value="<?php echo $agreement->user->id ?>"
                   onchange="getAgreementsListByUser('<?php echo Yii::app()->createUrl("/_teacher/_accountancy/operation/getAgreementsByUser"); ?>')">
            Користувач :<?php echo $agreement->user->userNameWithEmail(); ?>
            Договір : <?php echo $agreement->id; ?>
        </div>
    <?php } ?>
<?php } ?>