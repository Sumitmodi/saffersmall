<?php
	/*
	 * Please visit www.TalksOnWeb.com for more web related tutorials
	 * Author: Adil K.
	 * Description: This daemon/service will allow the flash file (part of the web-socket-js) to
	 * 				connect to the server and get the neccessary info it needs (on line 39).  
	 */
	
	// allow the daemon to run without being timed out
	set_time_limit(0);
	
	// Warning: Please don't change the port number. This is the port number the flash file will try to connect to.
	$ip = "127.0.0.1";
	$port = 843;
	
	// set the protocols
	if( !$socket = socket_create(AF_INET,SOCK_STREAM,0) ){
		showError();	
	}

	echo "The socket's protocol info was set \n";
	
	// bind the socket
	if( !socket_bind($socket,$ip,$port) ){
		showError($socket);
	}
	echo "The socket has been bound to a specific port now ! \n";
	
	// start listening on this port
	if( !socket_listen($socket) ){
		showError();
	}
	echo "Now listening for connections @ @ @ \n";
	
	do{
		$client = socket_accept($socket);
		echo "new connection with client established !! \n";
			
		$message = '<cross-domain-policy><allow-access-from domain="*" to-ports="8080" /></cross-domain-policy>';
		socket_write($client, $message, strlen($message));
		echo "the message was sent \n";
		socket_close($client);
		echo "the client connection has been closed\n----------------------------------------------\n";
	}while(true);
	
		
	// show error details
	function showError( $theSocket ){
		if( empty($theSocket) )
			$theSocket = NULL;
		$errorcode = socket_last_error($theSocket);
	    $errormsg = socket_strerror($errorcode);
	    
	    die("Couldn't create socket: [$errorcode] $errormsg");
	}
?>