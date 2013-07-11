<?php 
	require_once 'opentok/API_Config.php';
	require_once 'opentok/OpenTokSDK.php';

	include('config.php');

	session_start();



	function connect() {

		//Connect to mysql server
		$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if(!$link) {
			die('Failed to connect to server: ' . mysql_error());
		}
		
		//Select database
		$db = mysql_select_db(DB_DATABASE);
		if(!$db) {
			die("Unable to select database");
		}

	}
	
	
	function newSession() {

		$apiObj = new OpenTokSDK( API_KEY, API_SECRET );

		// Creating Simple Session object, passing IP address to determine closest production server
		// Passing IP address to determine closest production server
		$session = $apiObj->createSession( $_SERVER["REMOTE_ADDR"] );
		// $session = $apiObj->createSession( $_SERVER["REMOTE_ADDR"], array(SessionPropertyConstants::P2P_PREFERENCE=> "enabled") );

		// Getting sessionId from Sessions
		// Option 1: Call getSessionId()
		$sessionId = $session->getSessionId();


		// After creating a session, call generateToken()
		$token = $apiObj->generateToken($sessionId);
		echo json_encode(array("sessionId"=>$sessionId, "token"=>$token));
	  
	  // Insert into db
		$query = "INSERT INTO ".DB_TABLE."(sessionId, token) 
		VALUES('$sessionId', '$token')";
		$result=mysql_query($query);
		//echo $result; 
	}

	function getSessions() {
		$query = 'SELECT * FROM '.DB_TABLE;
		$result = mysql_query($query) or die('Query failed: ' . mysql_error());

		$sessions = array();
		if($result) {
			while($s = mysql_fetch_array($result)) {
				$sessions[] = $s;//array('sessionId'=>$s['sessionId'], 'token'=>$s['token'], 'hi'=>3333);
			}
			echo json_encode($sessions);
		}
	}
	
	
	connect();
	
	if ($_GET['new']) {
		newSession();
	}

	if ($_GET['join']) {
		getSessions();
	}


?>