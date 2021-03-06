<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>

    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css"/>

    <link rel="shortcut icon" type="image/png" href="/images/favicon.png"/>

    <title>MidKnight Inventors</title>
</head>
<body>
	<div class="container">

    <h1>Team 1923 MidKnight Inventors</h1>

    <?php
    include 'includes/config.php';
    // connect to DB
    $con = mysqli_connect("localhost", $dbuser, $dbpass, $dbname);

    // get all users who are "logged in" (1 indicates logged in, 0 is logged out)
    $result = mysqli_query($con, "SELECT name FROM students WHERE ACTIVE = '1'");

    // create a table
    $counts = mysqli_num_rows($result); 

    if($counts == 1)
    	echo('<h2>There is <b>1</b> person signed in.</h2>');
    else if ($counts == 0)
        echo('<h2>No one is signed in at the moment.</h2>');
    else
   		echo('<h2>There are <b>'. $counts .'</b> people signed in.</h2>');
    
    if($counts > 0){
    	echo <<<EOT
   			 	<table border='1'>
        		<tr bgcolor="#ff007d">
            <th style="color: #eee">Name</th>
        </tr>
EOT;

        // add names and ids in
        while($row = mysqli_fetch_assoc($result)){
			echo "<tr>";
	        echo "<th>" . ucwords($row['fullname']) . "</th>";
            echo "</tr>";
		}
        echo "</table><br>";
    }
     echo '<button class="button" onclick="window.location.href=\'index\'">Back</button>';
    
    mysqli_close($con);
   
    
    ?>
    


</div>
</body>
</html>
