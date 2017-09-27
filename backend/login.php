<?php
//TODO check user authentication

	$loginData = json_decode($_POST['loginData']);

	$authenticationSuccess = false;
	$data;
	//TODO sync from database
	$numRetries = 3;

	define("LOGIN_WRONG_ERROR", "Falscher Benutzername oder Passwort. %d Versuche verbleiben");

	if ($authenticationSuccess){
		http_response_code(200);
		$data = ["username" => $loginData['username']];
	} else {
		http_response_code(401);
		$data = ["errorMessage" => sprintf(LOGIN_WRONG_ERROR, $numRetries)];
	}

	//if successfull start session

	
	echo json_encode($data);
?>

