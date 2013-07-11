<?php

	session_start();
	include('connect.php'); 
	//newSession();
	$json = file_get_contents(NEW_URL);

	$obj = json_decode($json);
	
	//echo $obj->sessionId;
	//echo $obj->token;
	$_SESSION['sessionId'] = $obj->sessionId;
	$_SESSION['token'] = $obj->token;
	echo $_SESSION['sessionId'].'<br>'.$_SESSION['token'];
?>


<head>
	<script src='https://swww.tokbox.com/webrtc/v2.0/js/TB.min.js'></script>
</head>

<body>
	<div id="publisher"></div>
	<script type="text/javascript">


	  // Initialize session, set up event listeners, and connect
	  var sessionId = <?php echo "'".$_SESSION['sessionId']."'"; ?>;
		var session = TB.initSession(sessionId);

	  session.addEventListener('sessionConnected', sessionConnectedHandler);
	  var token = <?php echo "'".$_SESSION['token']."'"; ?>;
	  session.connect(<?php echo API_KEY; ?>, token);
		  
	  function sessionConnectedHandler(event) {
	    var publisher = TB.initPublisher(<?php echo API_KEY; ?>, 'publisher');
	    session.publish(publisher);
	  }
	</script>
</body>