<?php

include_once 'config.php';

$con = mysqli_connect("localhost", $dbuser, $dbpass, $dbname);
// Verify connection with database
    if (mysqli_connect_errno())
        fancydie('Couldn\'t connect to the database. Reason: ' . mysqli_connect_error());


function getName($ID){
	global $con;

	//get all data
    $query = "SELECT NAME FROM students WHERE ID = '$ID'";
    $result = mysqli_query($con, $query);
    if (!$result)
        fancydie('Could not fetch user data from database, ' . mysqli_error($con));
    if (mysqli_num_rows($result) == 0)  //check if the ID exists
       return null;

    $row = mysqli_fetch_array($result); //get the data into an array

    return $row['NAME']; // get the user's name
}

function getActive($ID){

	global $con;

	//get all data
    $query = "SELECT ACTIVE FROM students WHERE ID = '$ID'";
    $result = mysqli_query($con, $query);
    if (!$result)
        fancydie('Could not fetch user data from database, ' . mysqli_error($con));
    if (mysqli_num_rows($result) == 0)  //check if the ID exists
       return null;

    $row = mysqli_fetch_array($result); //get the data into an array

    return $row['ACTIVE'] == 1; // get the user's name
}

/**
 * Logs the user in
 */
function login($ID)
{
	global $con;

    $active = getActive($ID); //boolean - if the user is active
    $name = getName($ID); // get the user's name

    if ($active) { //if user is signed in
        $_SESSION['loginerror'] = "alreadysignedin";
        redirect("index.php");
    } else {

		//if user is signed out
        $result = mysqli_query($con, "UPDATE students SET ACTIVE = 1 WHERE ID = '$ID'");
        if (!$result)
            fancydie('Could not set active to true, ' . mysqli_error($con));

        $result = mysqli_query($con, "INSERT INTO logs (ID, NAME, DATEIN) VALUES ('$ID', '$name', now())");
        if (!$result)
            fancydie('Could not update logs, ' . mysqli_error($con));
}
}

/**
 * Logs the user out
 */
function logout($ID, $notime = false)
{
    global $con;

	$active = getActive($ID); //boolean - if the user is active
    $name = getName($ID); // get the user's name


    if (!$active) {
        $_SESSION['loginerror'] = "alreadysignedout";
        redirect();
    } //if user is signed in
    else {

        $result = mysqli_query($con, "UPDATE students SET ACTIVE = 0 WHERE ID = '$ID'");
        if (!$result)
            fancydie('Could not set active to false, ' . mysqli_error($con));

        $result = mysqli_query($con, "UPDATE logs SET DATEOUT = now() WHERE DATEOUT = '0000-00-00 00:00:00' AND ID = '$ID'");
        if (!$result)
            fancydie('Could not update logs, ' . mysqli_error($con));
        if(!$notime){
        $result = mysqli_query($con, "SELECT DATEIN,DATEOUT FROM logs WHERE ID = '$ID' ORDER BY NUM desc");
        if (!$result)
            fancydie('Could not fetch log data, ' . mysqli_error($con));

        $row = mysqli_fetch_array($result);
        $datein = ($row['DATEIN']);
        $dateout = ($row['DATEOUT']);

        $sessiontime = strtotime($dateout) - strtotime($datein);

        //get current time spent on team
        $result = mysqli_query($con, "SELECT TOTALTIME FROM students WHERE ID = '$ID'");
        if (!$result)
            fancydie('Could not get total time, ' . mysqli_error($con));

        $row = mysqli_fetch_array($result);
        $totaltime = $row['TOTALTIME'] + $sessiontime; //new total time

        $result = mysqli_query($con, "UPDATE students SET TOTALTIME = '$totaltime' WHERE ID = '$ID'");
        if (!$result)
            fancydie('Could not set total time, ' . mysqli_error($con));
        }
    }
}

function logoutall($force = false)
{
    global $con;
	$query = "SELECT * FROM students WHERE ACTIVE = '1'";
        $result = mysqli_query($con, $query);
        if (!$result)
            fancydie('Could not fetch user data from database, ' . mysqli_error($con));
	$count = 0;
	while($row = mysqli_fetch_array($result)){
   	 	logout($row["id"] , $row["FULLNAME"] , 1, false);
   	 	$count++;
	}
	if ($force)
		message("Successfully force logged out ". $count ." student(s)");
	else
		message("Successfully logged out ". $count ." student(s)");
}