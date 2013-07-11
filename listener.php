<?php

	session_start();
	include('connect.php'); 
	//newSession();
	$json = file_get_contents(JOIN_URL);

	$obj = json_decode($json);
	//echo $obj[0]->sessionId;
	//echo $obj[0]->token;
	$_SESSION['sessions'] = $obj;
?>


<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src='https://swww.tokbox.com/webrtc/v2.0/js/TB.min.js'></script>
</head>

<body>
	<div id="listener"></div>
	<script type="text/javascript">

	  // Initialize session, set up event listeners, and connect
	  var sessionId = <?php echo "'".end($_SESSION['sessions'])->sessionId."'"; ?>;
	  var token = <?php echo "'".end($_SESSION['sessions'])->token."'"; ?>;
	  console.log(sessionId);
	  console.log(token);
	  var session = TB.initSession(sessionId);
	  session.addEventListener('sessionConnected', sessionConnectedHandler);
	  session.connect(<?php echo API_KEY; ?>, token);
	  
	  function sessionConnectedHandler(event) {
	  	console.log(event);
	  	console.log("subscribe");
	  	subscribeToStreams(event.streams);
	  }

	  function subscribeToStreams(streams) {
	  	console.log(streams);
		  if (streams.length > 0) {
		  	console.log('subscribing');
		    session.subscribe(streams[0]);
		    var obj = $("*[id*='listener']");
		    obj.width(window.innerWidth);
		    obj.height(window.innerHeight);
		  }
		}
	</script>
</body>