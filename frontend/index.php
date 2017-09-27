<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<link rel="shortcut icon" href="./img/favicon.png">	
	<title>WGPlaner</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>

<link href="css/index.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
	var app = angular.module('wgplaner', []);
app.controller('loginController', function($scope, $http) {
	$scope.loginData = {
		username : "",
		password : "",
		rememberMe : false,
		numRetriesLeft: 3
	}

    $scope.doLogin = function(){
    	//TODO
    	console.log($scope.loginData.username);
    	console.log($scope.loginData.password);
    	console.log($scope.loginData.rememberMe);

    	$http({
  method: 'POST',
  url: './../backend/login.php',
  data: {'loginData': $scope.loginData}
}).then(function successCallback(response) {
    // this callback will be called asynchronously
    // when the response is available
    console.log(response);
  }, function errorCallback(response) {
    // called asynchronously if an error occurs
    // or server returns response with an error status.
    console.log(response);
    $scope.showErrorAlert(response.data.errorMessage);
    $scope.loginData.numRetriesLeft--;
  });
    }

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
<body ng-app="wgplaner" ng-controller="baseController" style="padding-top: 200px;">
	 <div class="container">
	<?php 	session_start();
	$cookie_name = "rememberWGFinanzen";
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']){
					header("Location: home.php");	//Redirect if user already loggedin
					die();
				}?>

				<div class="alerts" align="center">
									<div class="alert alert-success alert-dismissable" style="display:none;" id="success-dialog">
										<button type="button" class="close" data-dismiss="alert">x</button>
  <p><strong>Erfolg!</p></span> <p class="dialog-text">Indicates a successful or positive action.</p>
</div>

<div class="form-container">
									<div class="alert alert-danger alert-dismissable" style="display:none;"  id="error-dialog">
										<button type="button" class="close" data-dismiss="alert">x</button>
  <p><strong>Fehler!</strong></p> <p class="dialog-text">Indicates a successful or positive action.</p>
</div>

				<div class="form-container" ng-controller="loginController">
				<!-- Login Form -->
				<form class="form-signin" ng-submit="doLogin()" align="center">

					<!-- Login Fail Dialog -->
					<div id="loginFailAlert" style="display: none;">
						<p class="red">Anmeldung fehlgeschlagen! Benutzername oder Passwort falsch.</p>
					</div>			
					<h2 align="center">Bitte anmelden</h2>
						<input ng-model="loginData.username" type="text" class="flat-input" name="username" placeholder="Username or Email Address" required autofocus ng-value="<?php if (isset($_COOKIE[$cookie_name])) echo $_COOKIE[$cookie_name];?>"/>
					<br>
						<input ng-model="loginData.password" type="password" class="flat-input" name="password" id="passwordBox" placeholder="Password" required ng-value="" autofill="false"/>
	                    <p><input ng-model="loginData.rememberMe" type="checkbox" id="rememberMe" name="remember" checked/>
	                    <label for="rememberMe" class="switch"></label>Merke meinen Benutzernamen</p>
	                    <p ng-model="loginData.numRetriesLeft" ng-show="loginData.numRetriesLeft < 3" class="label label-danger">{{loginData.numRetriesLeft}} attempts left.</p>
					<button class="flat-button" type="submit">Login</button>   
				</form>
			</div>
		</div>
		</body>
	</html>
