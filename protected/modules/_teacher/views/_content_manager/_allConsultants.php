<div class="col-lg-12">
    <br>
    <ul class="list-inline">
        <li>
            <button class="btn btn-primary" ng-click="changeView('/admin/users/addrole/consultant')">
                Призначити консультанта
            </button>
        </li>
        <li>
            <button class="btn btn-primary" ng-click="changeView('content_manager/addConsultantModule')">
                Призначити модуль
            </button>
        </li>
    </ul>
    <div class="panel panel-default" ng-controller="consultantsTableCtrl">
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table ng-table="consultantsTableParams" class="table table-bordered table-striped table-condensed">
                    <tr ng-repeat="row in $data track by $index">
                        <td data-title="'ПІБ'" filter="{'idUser.fullName': 'text'}" sortable="'idUser.fullName'">
                            <a ng-href="#/content_manager/showUser/{{row.id_user}}">{{row.idUser.firstName}} {{row.idUser.middleName}} {{row.idUser.secondName}}</a>
                        </td>
                        <td data-title="'Email'" sortable="'idUser.email'" filter="{'email': 'text'}" sortable="'email'">
                            <a ng-href="##/content_manager/showUser/{{row.id_user}}">{{row.idUser.email}}</a>
                        </td>
                        <td data-title="'Призначено'" filter="{'start_date': 'text'}" sortable="'start_date'">{{row.start_date}}</td>
                        <td data-title="'Відмінено'" filter="{'end_date': 'text'}" sortable="'end_date'">{{row.end_date}}</td>
                        <td data-title="'Скасувати роль'"><a ng-if="!row.end_date" ng-click="cancelRole('/_teacher/_admin/users/cancelRole','consultant',row.id_user)">Скасувати </i></a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
