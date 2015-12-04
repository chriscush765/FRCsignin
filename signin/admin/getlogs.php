<?php
include '../includes/tools.php';

//authentication stuff
if($_SESSION['adminpass'] == null){
    redirect('admin/login');
}

if (md5($_SESSION['adminpass']) != $adminpassword){
    redirect('login.php?error=wp');
}

// Verify connection with database
    if (mysqli_connect_errno()) {
        die("Couldn't connect to the database. Reason: " . mysqli_connect_error());
    }
    
$result = mysqli_query($con,"SELECT datein,dateout FROM `logs` where id = '$' order by datein desc limit 5"); 

    while($row = mysqli_fetch_array($result)){
        $datein[] = $row[0];
        $dateout[] = $row[1];
    }
    
    for($x = 0; $x < count($datein); $x++){
        $sessiontime = strtotime($dateout[x]) - strtotime($datein[x]);
        echo("<h3>Signed in for ". ($sessiontime /3600) ." hours on ".$datein[x]." and signed out on ".$dateout[x]."</h3>");
    }

