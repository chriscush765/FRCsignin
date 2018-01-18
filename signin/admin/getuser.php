<?php
include '../includes/tools.php';

//authentication stuff
if($_SESSION['adminpass'] == null){
    redirect('admin/login.php');
}

if (md5($_SESSION['adminpass']) != $adminpassword){
    redirect('login.php?error=wp');
}

// Verify connection with database
    if (mysqli_connect_errno()) {
        die("Couldn't connect to the database. Reason: " . mysqli_connect_error());
    }
    
$result = mysqli_query($con,"SELECT NAME FROM students");

while($row = mysqli_fetch_array($result)){
    $names[] = $row[0];
}


$list = implode(",", $names);

echo($list);