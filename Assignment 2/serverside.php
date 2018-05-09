<?php
	
	session_start();


	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		header("Location: success.php");
	}

	$page = $_SERVER['PHP_SELF'];
 	$sec = "0";
 	header("Refresh: $sec; url=$page");

	if(isset($_POST['submit']))
		 {
		 ob_end_clean(); //cleaning previous echoed
		
		 validatelogin($_POST['csrfToken'],$_COOKIE['CSRF_Token'],$_COOKIE['session'],$_POST['username'],$_POST['password']); 
		 
		 }

	function validatelogin($user_CSRF,$csrf_cookieValue,$user_sessionID,$user,$pwd)
	{
	if($user == "user" && $pwd == "password" && $user_sessionID == session_id())
	{
	if ($user_CSRF == $csrf_cookieValue )
	{
	echo "<script> alert('Successful: Tokens Matched'+<?;?>) </script>";
	//echo $_SESSION['CSRF_TOKEN'];
	//echo $user_CSRF;
	$_SESSION['loggedin'] = true;
	}
	else
	{ 
	 echo "<script> alert('Un-Successful: Tokens Un-Matched'+ <?;?>)</script>";
	 //echo "<script> alert()</script>";
	 echo $_SESSION['CSRF_TOKEN']; echo " ";
	 echo $user_CSRF;
	}
	}
	else
	{
	 echo "<script> alert('Unsuccessful: Invalid Credentials & Session') </script>";
	}
	}

	
?>