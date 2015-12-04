<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css"/>

    <link rel="shortcut icon" type="image/png" href="/images/favicon.png"/>

    <title>MidKnight Inventors</title>
</head>
<body>
<div class="container">

    <?php
    if ($_POST['name'] == null) {
        ?>
        <h2>Forgot your ID? Enter your FULL NAME below!</h2>
        <h3>Case insensitive :)</h3>
        <br>
        <form name="input" action="forgot.php" method="post">
            <input type="text" class="glow" autocomplete="off" placeholder="Full Name" name="name" autofocus required> <br>
            <input type="submit" class="button" value="Submit" name="submit">
        </form>
            <br>
    <button class="button" onclick="window.location.href='index.php'">Back</button>

    <?
    }
    else {
		include 'includes/config.php';
        $name = trim(strtolower($_POST['name']));
        // connect to DB
        $con = mysqli_connect("localhost", $dbuser, $dbpass, $dbname);
        // select the database once connected

        // get all users who are "logged in" (1 indicates logged in, 0 is logged out)
        $result = mysqli_query($con, "SELECT id FROM students WHERE fullname = '$name'");
        $row = mysqli_fetch_array($result);

        if ($row['id'] == null){
        echo "<h1>There wasn't a user found named <i>" . $name . "</i>.</h1><h2>We use the name that you entered when you sign up for the team. Try using your nickname, for example: <br><i>Christopher Cushman</i> -> <i>Chris Cushman</i></h2>";

	}
	   else{
		   	echo "<h1>" . ucwords($name) . "</h1>";
            echo "<h1>ID: " . $row['id'] . "</h1>";
			        echo "";

		}
	   mysqli_close($con);
    }
    ?>

	<br>
	<h2>Hope that helped!</h2>
	<br> <button class="button" onclick="window.location.href='index.php'">Back</button>
</div>
</body>
</html>
