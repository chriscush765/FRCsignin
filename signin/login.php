<?php
include("includes/tools.php");

if($_POST['pass'] != null){
    $_SESSION['pass'] = $_POST['pass'];
    redirect("index");
    die();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css"/>

    <link rel="shortcut icon" type="../image/png" href="/images/favicon.png"/>

    <title>MidKnight Inventors</title>
</head>
<body>
<div class="container">
		<h1>Team 1923 Sign In</h1>
        <h2>Authentication required</h2>
        <?
        if($_GET['a'] == "wp")
        	echo('<h3 style="color: red">Incorrect Password</h3>');
		if($_GET['a'] == "d")
        	echo('<h3  style="color: red">Succesfully deactivated</h3>');
        $_SESSION['pass'] = null;
        ?>
        <form name="input" action="login.php" method="post">
            <input type="password" class="glow" autocomplete="off" placeholder="Password" name="pass" required autofocus> <br>
            <input type="submit" class="button" value="Submit" name="submit">
			<h3>You must enter the password before you can access the sign in page.</h3>
            <br>

</div>
</body>
</html>