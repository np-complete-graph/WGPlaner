<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WG Main Menu</title>
        <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
        <!-- Angular Material requires Angular.js Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>

        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Angular Material Library -->
        <script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>

        <link href="../css/style.css" rel="stylesheet" type="text/css">

        <script type="text/javascript">
            var app = angular.module('wgplaner', ['ngMaterial', 'ngMessages']);
            app.controller('userController', function($scope, $http, $window, $mdDialog) {
                $scope.users ={}; 
                $scope.editingUser = {}

                $scope.fetchUsers = function(){
                    var token = localStorage.getItem('token');
                    $http({
                        method: 'GET',
                        url: 'http://localhost:8080/api/users',
                        headers:{
                            "token": token
                        }
                    }).then(function successCallback(response) {
                        console.log(response);
                        $scope.users = response.data;

                        for (var i = 0; i < $scope.users.length; i++) {
                            $scope.editingUser[$scope.users[i]._id] = false;
                        }

                    }, function errorCallback(response) {
                        $scope.lastError = response.data;
                        console.log(response);
                    });
                }

                $scope.confirmRemoveUser = function(user){
                    var confirm = $mdDialog.confirm()
                    .title('Would you like to delete user '+user.Username)
                    .textContent('The user profile of '+user.Username+" will get removed, but the issued transactions remain.")
                    .clickOutsideToClose(true)
                    .ok('Remove')
                    .cancel('Abort');

                    $mdDialog.show(confirm).then(function() {
                        //TODO
                        console.log("Remove");
                    }, function() {
                        //TODO
                        console.log("Abort");
                    });
                }

                $scope.showAddUserDialog = function(){
                    $mdDialog.show({
                        controller: DialogController,
                        templateUrl: 'dialog1.tmpl.html',
                        parent: angular.element(document.body),
                        targetEvent: ev,
                        clickOutsideToClose:true,
                        fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
                    })
                        .then(function(answer) {
                        $scope.status = 'You said the information was "' + answer + '".';
                    }, function() {
                        $scope.status = 'You cancelled the dialog.';
                    });
                }

                $scope.fetchUsers();
            });

            app.controller('baseController', function($scope){

                $scope.showErrorAlert = function(text){
                    $("#error-dialog").hide();
                    $("#error-dialog .dialog-text").html(text);
                    $("#error-dialog").fadeTo(2000, 500).fadeOut(500, function(){
                        $("#error-dialog").fadeOut(500);
                    }); 
                }

                $scope.showSuccessAlert = function(text){
                    $("#success-dialog").hide();
                    $("#success-dialog .dialog-text").html(text);
                    $("#success-dialog").fadeTo(2000, 500).slideUp(500, function(){
                        $("#success-dialog").slideUp(500);
                    }); 
                }
            });
        </script>
    </head>
    <body ng-app="wgplaner" ng-controller="userController">

        <?php include_once("navbar.html") ?>

        <div class="container" align="center">

            <!-- Page Content -->
            <div class="page-content">
                <h1>Registrierte Benutzer</h1>

                <pre>{{users}}</pre>
                <pre>{{editingUser}}</pre>

                <md-button class="md-raised md-success">Benutzer hinzufügen</md-button>

                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <tr ng-repeat="user in users">
                            <td>{{user._id}}</td>

                            <td>
                                <div ng-hide="editingUser[user._id]">
                                    {{user.Username}}
                                </div>
                                <div ng-show="editingUser[user._id]">
                                    <md-input-container md-no-float="" class="md-block">
                                        <input ng-model="user.Username" placeholder="Username">
                                    </md-input-container>
                                </div>
                            </td>

                            <td>{{user.Password}}</td>
                            <td>
                                <div ng-hide="editingUser[user._id]">
                                    <md-menu>
                                        <md-button aria-label="Open phone interactions menu" class="md-icon-button" ng-click="$mdOpenMenu()">
                                            <md-icon md-font-set="material-icons" style="color: white">more_horiz</md-icon>
                                        </md-button>
                                        <md-menu-content width="4">
                                            <md-menu-item>
                                                <md-button ng-click="confirmRemoveUser(user)">
                                                    <md-icon md-font-set="material-icons" style="color: #c0392b">remove_circle_outline</md-icon>
                                                    Remove
                                                </md-button>
                                            </md-menu-item>
                                            <md-menu-item>
                                                <md-button ng-click="editingUser[user._id] = true">
                                                    <md-icon md-font-set="material-icons" style="color: #2980b9">create</md-icon>
                                                    Edit
                                                </md-button>
                                            </md-menu-item>
                                        </md-menu-content>
                                    </md-menu>
                                </div>

                                <div ng-show="editingUser[user._id]">
                                    <md-menu>
                                        <md-button aria-label="" class="md-icon-button" ng-click="$mdOpenMenu()">
                                            <md-icon md-font-set="material-icons" style="color: white">more_horiz</md-icon>
                                        </md-button>
                                        <md-menu-content width="4">
                                            <md-menu-item>
                                                <md-button ng-click="">
                                                    <md-icon md-font-set="material-icons" style="color: #27ae60">check_circle</md-icon>
                                                    Save
                                                </md-button>
                                            </md-menu-item>
                                            <md-menu-item>
                                                <md-button ng-click="editingUser[user._id] = false">
                                                    <md-icon md-font-set="material-icons" style="color: #f39c12">clear</md-icon>
                                                    Abort
                                                </md-button>
                                            </md-menu-item>
                                        </md-menu-content>
                                    </md-menu>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <!-- /#page-content-wrapper -->
    </body>
</html>
