<?php
include_once '../includes/tools.php';

//authentication stuff
if($_SESSION['adminpass'] == null){
    redirect('admin/login');
}

if (md5($_SESSION['adminpass']) != $adminpassword){
    redirect('login.php?error=wp');
}

// Verify connection with database
    if (mysqli_connect_errno()) {
        fancydie("Couldn't connect to the database. Reason: " . mysqli_connect_error());
    }

$user = urldecode($_GET['user']);
$result = mysqli_query($con,"SELECT * FROM students WHERE fullname = '$user'"); 
$row = mysqli_fetch_array($result);
$ID = $row['id'];
$active = $row['active'];
$totaltime = $row['totaltime'];
$name = $row['name'];


if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'login':
            signIn($ID);
            die();
        case 'logout':
            signOut($ID);
            die();
		case 'flogout':
            select();
            die;
        default:
        	die();
    }
}
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

    <link rel="stylesheet" href="../css/style.css" media="screen" type="text/css"/>

    <link rel="shortcut icon" type="../image/png" href="/images/favicon.png"/>
    		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
    $('button').click(function(){
        var clickBtnValue = $(this).val();
        var ajaxurl = 'userinfo.php',
        data =  {'login': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            alert("Action performed successfully.");
    	  });
		 });

		});
	</script>


    <title>MidKnight Inventors</title>
</head>
<body>
<div class="container fade-in one">
        <h2 class="fade-in two">User Information for <?php echo ucwords($user); ?></h2>
		<h3>ID: <?php echo $ID; ?></h3>
        <h3><?php echo ($active == 1 ? "Currently logged in" : "Currently not logged in");?></h3>   
		<br>
		<h2>Here are the last three sign-ins</h2>
		<?php
		
		$result = mysqli_query($con,"SELECT datein,dateout FROM `logs` where id = '". $ID ."' order by datein desc limit 5"); 

    while($row = mysqli_fetch_array($result)){
        $datein[] = $row[0];
        
        $dateout[] = $row[1];
    }
            
    for($x = 0; $x < count($datein); $x++){
        $sessiontime = strtotime($dateout[$x]) - strtotime($datein[$x]);
        echo("<div class=\"longbutton\">". gmdate("H", $sessiontime) ." hours ".gmdate("i", $sessiontime)." minutes <br>". date('Y-n-j', strtotime($datein[$x])) ." - ".date('Y-n-j', strtotime($dateout[$x]))."</div>");
    }
		?>
		
        
    <button class="button fade-in five" onclick="window.location.href='index.php'">Back</button>

</div>
</body>
</html>