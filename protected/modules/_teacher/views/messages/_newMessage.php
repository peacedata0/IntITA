<?php
/* @var $user integer */
?>

<link type="text/css" rel="stylesheet" href="<?php echo StaticFilesHelper::fullPathTo('css', '_teacher/messages.css'); ?>"/>

<div class="panel panel-primary">
    <div class="panel-heading">
        Написати листа
    </div>
    <div class="panel-body">
        <form role="form" name="message">
            <input class="form-control" name="id" id="hidden" value="<?=$user?>">
            <input type="number" hidden="hidden" id="receiverId" value="0"/>

            <div class="form-group" id="receiver">
                <label>Кому</label>
                <br>
                <input id="typeahead" type="text" class="form-control" name="receiver" placeholder="Отримувач" size="135"
                required autofocus>
            </div>

            <div class="form-group">
                <label>Тема</label>
                <input class="form-control" name="subject" placeholder="Тема листа">
            </div>

            <div class="form-group">
                <label>Лист</label>
                <textarea class="form-control" rows="6" id="text" placeholder="Лист" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary"
                    onclick="sendMessage('<?php echo Yii::app()->createUrl('/_teacher/messages/sendUserMessage'); ?>'); return false;">
                Написати
            </button>

            <button type="reset" class="btn btn-default"
                    onclick="load('<?=Yii::app()->createUrl("/_teacher/messages/index")?>')">
                Скасувати
            </button>
        </form>
    </div>
</div>
<script src="<?= StaticFilesHelper::fullPathTo('js', 'typeahead.js'); ?>"></script>
<script>
    var users = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: basePath + '/_teacher/messages/usersByQuery?query=%QUERY&id=' + user,
            wildcard: '%QUERY',
            filter: function (users) {
                return $jq.map(users.results, function (user) {
                    return {
                        id: user.id,
                        value: user.value
                    };
                });
            }
        }
    });

    users.initialize();

    $jq('#typeahead').typeahead(null, {
        name: 'users',
        display: 'value',
        source: users,
        templates: {
            suggestion: function(item) {
                return "<p><em>" + item.value + "</em></p>"; }
        }
    });

    $jq('#typeahead').on('typeahead:selected', function (e, item) {
        $jq("#receiverId").val(item.id);
    });
</script>