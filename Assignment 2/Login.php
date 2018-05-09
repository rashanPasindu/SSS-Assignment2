<!DOCTYPE HTML>
<html>
<?php
	session_start();

	if (isset ($_SESSION['views']))
	{
		$_SESSION['views'] = $_SESSION['views'] +1;
	}
	else {
		$_SESSION['views'] = 1;
	}

	$expire = time()+60*60*24;
	$id = session_id();
	$cookiename = "session"; 
	
	setcookie ($cookiename, $id, $expire, "","localhost", FALSE, TRUE);

	if(empty($_SESSION['key']))
	{
		$_SESSION['key']=bin2hex(random_bytes(32));
	}

	$token = hash_hmac('sha256',"CSRF Token:Login.php",$_SESSION['key']); // creating the token
	
	$id1 = $token;
	$cookiename1 = "CSRF_Token"; 
	
	setcookie ($cookiename1, $id1, $expire, "","localhost", FALSE, TRUE); // setting the token into a cookie

	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		header("Location: success.php");
	}

	if(isset($_COOKIE[$cookiename]) && $_COOKIE[$cookiename1]) //checking whether the cookie is set
		 {
		 $msg = "Cookies Created";
		 echo "<script type='text/javascript'>alert('$msg')</script>";
		 }
		 else 
		 {
		 $msg = "Cookie not Created";
		 echo "<script type='text/javascript'>alert('$msg')</script>";
		 }
	
?>
<title>
Login
</title>
<body>

	<form method="post" action="serverside.php">
		Username:<br/>
		<input type="text" name="username"><br/>
		Password:<br/>
		<input type="password" name="password"><br/><br/>

		<input type="hidden" id="CSRF" name="csrfToken">

		<input type="submit" name="submit" value="Login"/> 
		
	</form>
<br/><br/>

<p> Page Views: <?php echo $_SESSION['views']; ?></p>

</body>
<script>
	document.getElementById("CSRF").value = '<?php echo $token; ?>';
	console.log("CSRF Token" +'<?php echo $token; ?>');
</script>
</html>