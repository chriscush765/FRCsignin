<?php
include '../includes/tools.php';

//authentication stuff
if($_SESSION['adminpass'] == null){
    redirect('admin/login');
}

if (md5($_SESSION['adminpass']) != $adminpassword){
    redirect('admin/login.php?error=wp');
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

    <script>
function showHint(str) {
    if (str.length == 0) { 
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            	if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "getuser.php?q=" + str, true);
        xmlhttp.send();
    }
}
</script>

</head>
<body>
	<div class="container">
        <h1>Search for a user</h1>
        <h3>Start by typing a name below</h3>
	<form>
		<input type="text" placeholder="Full Name" onkeyup="showHint(this.value)" autofocus>
	</form>

	<span id="txtHint"></span>

	<button class="button" onclick="window.location.href='login.php?a=o'">Back</button>
	<button class="button" onclick="window.location.href='login.php?a=d'">Deactivate</button>
	
	<h3>Deactivation prevents anyone else from using this device</h3>


</div>
</body>
</html>