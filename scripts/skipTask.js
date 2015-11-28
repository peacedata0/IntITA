
function cancelSkipTask() {
    location.reload();
}
function editSkipTask() {
    var header = document.getElementById('header').value;
    var etalon = document.getElementById('etalon').value;
    var taskFooter = document.getElementById('taskFooter').value;
    var condition = document.getElementById('condition').value;

    if(condition.trim()=='' || header.trim()=='' || etalon.trim()=='' || taskFooter.trim()==''){
        alert('Поля з "*" повинні бути заповнені');
        return false;
    }
    document.getElementById('addTask').style.display = 'none';

    var lang = $('select[name="lang"]').val();
    var name = document.getElementById('name').value;
    condition = condition.trim();
    var editTask = {
        "task": 210,
        "lang": "c++",
        "operation": "edittask",
        "name": name,
        "header": header,
        "etalon": etalon,
        "footer": taskFooter
    };
    var jqxhr = $.post("http://ii.itatests.com", JSON.stringify(editTask), function () {
    })
        .done(function (data) {
            var serverResponse = jQuery.parseJSON(data);
            if (serverResponse.status == 'success') {
                editTaskToLecture(condition, idTeacher, idLecture, lang, serverResponse.id, serverResponse.table, task);
            }
        })
        .fail(function () {
            alert("Вибачте, але на сайті виникла помилка і редагувати задачу до заняття наразі неможливо. " +
            "Спробуйте додати пізніше або зв'яжіться з адміністратором сайту.");
            location.reload();
        })
        .always(function () {
        });

}
function editSkipTaskToLecture(condition, idTeacher, idLecture, lang, id, table, taskType) {
    $.ajax({
        type: "POST",
        url: "/task/editTask",
        data: {
            'condition': condition,
            'author': idTeacher,
            'lecture': idLecture,
            'language': lang,
            'assignment': id,
            'table' : table,
            'taskType' : taskType
        },
        cache: false,
        success: function(){location.reload();
        }
    });
}


function unableSkipTask(pageId){
    if (confirm('Ви впевнені, що хочете видалити задачу?')) {
        $.ajax({
            type: "POST",
            url: "/task/unableTask",
            data: {'pageId':pageId},
            success: function(){
                $('div[name="lecturePage"]').html(response);
                return false;
            }
        });
    }
    location.reload();
}

function sendSkipTaskAnswer(id){

    var text = skipTaskQuestion.getElementsByTagName('input');
    var answers = [];
    var check = true;
    for(var i = 0; i < text.length;i++)
    {
        if(text[i].value == '')
        {
            check = false;
            alert('Заповніть поле ' + ++i);
        }
    }
    if(!check)
        return check;
    for(var i = 1; i<text.length + 1 ;i++)
    {
        var name = 'skipTask' + i;
        var skipBlock = document.getElementById(name);

        var skipText = skipBlock.value;
        var caseInsensitive = skipBlock.getAttribute('caseinsensitive');

        var arr = [];
        arr.push(skipText);
        arr.push(i);
        arr.push(caseInsensitive);

        answers.push(arr);
    }
    var url = "/skipTask/saveSkipAnswer";
    $.ajax({
        type: "POST",
        url:  url,
        data: {answers: answers,
            id : id  },
        cache: false,
        success: function(response) {

            if (response) {
                jQuery('#skipTaskDialog').dialog({
                    'width': '540px',
                    'height': 'auto',
                    'modal': true,
                    'autoOpen': false
                });
                $("#skipTaskDialog").dialog().dialog("open");
                $("#skipTaskDialog").parent().css('border', '4px solid #339900');
            }
            else
            {
                jQuery('#skipTaskCancel').dialog({'width':'540px','height':'auto','modal':true,'autoOpen':false});
                $("#skipTaskCancel").dialog().dialog("open");
                $("#skipTaskCancel").parent().css('border', '4px solid #cc0000');
                return false;
            }
        }
    });

}

