<?php
session_start(); //open up a session with the user
include_once 'includes/tools.php';



/*
 * Process the posted variables / check if they are valid
 */

    //assign and cleanup the id
    $ID = trim(strtolower($_POST['id']));

    //did the user even type an id?
    if ($ID == null) //numeric and nonzero
        fancydie('You did not enter an ID.');

    //get id
    if(strpos($ID,'drop') !== false)
        fancydie('Stop trying to hack my website!');

    if (!is_numeric($ID)) //numeric and >0
        fancydie('"'. $ID .'" is an invalid ID.');

	//check what the last page told this page to do
    if ($_POST["login"])
		login($ID);
    else if ($_POST["logout"])
        logout($ID);
    else
        fancydie('This page was told neither to login nor logout the user' . mysqli_error($query));

    $action = $_POST["login"] ? "in" : "out";
	redirect("confirmation.php?a=". $action ."&u=". getName($ID));
