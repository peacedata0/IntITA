/**
 * Created by Ivanna on 22.07.2015.
 */
task = 'plain';

function saveNewBlock() {
    source = $('#newTextBlock').code.get;
    document.getElementById('newTextBlock').innerHTML = source;
}
function hideForm(id, title) {
    $form = document.getElementById(id);
    $form.style.display = 'none';
    document.getElementById(title).innerHTML = '';
}
function showAddTaskForm(taskType){
    task = taskType;
    document.getElementById('addTask').style.display = 'block';
    document.getElementById('addBlockForm').style.display = 'none';
    document.getElementById('cancelButton').style.display = 'none';
}
function showAddTestForm(testType){
    document.getElementById('testType').value = testType;
    document.getElementById('addTest').style.display = 'block';
    document.getElementById('addBlockForm').style.display = 'none';
    document.getElementById('cancelButton').style.display = 'none';
}
