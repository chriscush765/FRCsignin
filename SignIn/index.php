<?php
session_start();
include 'includes/tools.php';
include 'includes/secure.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css"/>
    <link rel="shortcut icon" type="image/png" href="/images/favicon.png"/>

    <title><?php echo $teamname ?></title>

</head>

<body>
	<div id="container" class="container fade-in one">
        <h1><?php echo $teamname ?> Sign In</h1>
     	<h2>Please sign in below.</h2>
    <?php
    if ($_SESSION['loginerror'] == "alreadysignedin")
        echo("<h2 class=\"fade-in three\" style=\"color: red;\">You are already signed in</h2>");
    if ($_SESSION['loginerror'] == "alreadysignedout")
        echo("<h2 class=\"fade-in three\" style=\"color: red;\">You are already signed out</h2>");
    $_SESSION['loginerror'] = null;
    ?>

    	<form name="input" id="form" action="handle.php" method="post">
       		<input type="text" autocomplete="off" placeholder="ID" name="id" autofocus> 
			<br>
       		<input class="button" id="submit" type="submit" value="Log In" name="login">
        	<input class="button" id="submit" type="submit" value="Log Out" name="logout">
		</form>

        <button class="button" onclick="window.location.href='list'">Who is online?</button>
        <button class="button" onclick="window.location.href='forgot'">Forgot your ID?</button>
		
		<button class="button" onclick="window.location.href='admin/'">Settings</button>

        <br>
        <h2>By Chris</h2>

	</div>

</body>

</html>
