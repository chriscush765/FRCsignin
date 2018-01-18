<?php
include("../includes/tools.php");

if($_POST['adminpass'] != null){
    $_SESSION['adminpass'] = $_POST['adminpass'];
    redirect("admin/index.php");
}

if($_GET['a'] == "o"){ // o is for log Out
	$_SESSION['adminpass'] = null;
	redirect();
}

if($_GET['a'] == "d"){ // d is for deactivate
	$_SESSION['adminpass'] = null;
	$_SESSION['pass'] = null;
	redirect("login.php?a=d");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

    <link rel="stylesheet" href="../css/style.css" media="screen" type="text/css"/>

    <link rel="shortcut icon" type="../image/png" href="/images/favicon.png"/>



    <title>MidKnight Inventors</title>
</head>
<body>
<div class="container">
		<h1>Admin panel</h1>
        <h2>Authentication required</h2>
        <?php
        if($_GET['error'] == "wp")
        echo("<h3 style=\"color: red\">Incorrect Password</h3>");
        $_SESSION['adminpass'] = null;
        ?>
        <form name="input" action="login.php" method="post">
            <input type="password" class="glow" autocomplete="off" placeholder="Password" name="adminpass" required autofocus> <br>
            <input type="submit" class="button" value="Submit" name="submit">
        </form>
            <br>
    <button class="button" onclick="window.location.href='../index.php'">Back</button>

</div>
</body>
</html>