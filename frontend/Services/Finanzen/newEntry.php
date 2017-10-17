<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WG Main Menu</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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

        <!-- Angular Material Library -->
        <script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>

        <link href="../../css/style.css" rel="stylesheet" type="text/css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
        <script type="text/javascript" src="./js/drawGraph.js"></script>
        
        <script type="text/javascript">
            var app = angular.module('wgplaner', ['ngMaterial']);
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
    <body ng-app="wgplaner">

        <div class="container">
            <div class="row-fluid">

                <div class="col-md-2">
                    <!-- Sidebar -->
                    <?php include_once("navbar.html") ?>
                    <!-- /#sidebar-wrapper -->
                </div>

                <!-- Page Content -->
                <div class="col-md-10" align="center">
                    <h1>Neuer Eintrag</h1>
                    <md-progress-circular md-mode="indeterminate" aria-valuemin="0" aria-valuemax="100" role="progressbar" class="" style="width: 50px; height: 50px;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" style="width: 50px; height: 50px; transform-origin: 25px 25px 25px;stroke: red !important"><path fill="none" stroke-width="5" stroke-linecap="square" d="M25,2.5A22.5,22.5 0 1 1 2.5,25" stroke-dasharray="106.02875205865553" stroke-dashoffset="316.53928919976585" transform="rotate(-270 25 25)" style="stroke: red !important"></path></svg></md-progress-circular>
                </div>
            </div>
            <!-- /#page-content-wrapper -->

        </div>
    </body>
</html>
