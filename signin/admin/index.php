<?php
define('SCRIPT_DEBUG', true);
include '../includes/tools.php';

//authentication stuff
if ($_SESSION['adminpass'] == null) {
    redirect('admin/login.php');
}

if (md5($_SESSION['adminpass']) != $adminpassword) {
    redirect('admin/login.php?error=wp');
}

$result = mysqli_query($con,"SELECT NAME FROM students");

while($row = mysqli_fetch_array($result)){
    $names[] = $row[0];
}

$list = implode(",",$names);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>MidKnight Inventors</title>

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

    <link rel="stylesheet" href="../css/style.css" media="screen" type="text/css"/>
    <link rel="stylesheet" href="../css/easy-autocomplete.min.css" media="screen" type="text/css"/>

    <link rel="shortcut icon" type="../image/png" href="/images/favicon.png"/>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../js/jquery.easy-autocomplete.min.js"></script>


    <script>


        $( function() {
            var listofnames = "<?php echo($list); ?>";
            var namearray = listofnames.split(",");

            var options = {
                data: namearray,
                theme: "dark",
                list: {
                    match: {
                        enabled: true
                    },
                    showAnimation: {
                        type: "fade", //normal|slide|fade
                        time: 300,
                        callback: function() {}
                    },

                    hideAnimation: {
                        type: "slide", //normal|slide|fade
                        time: 300,
                        callback: function() {}
                    }
                },
                cssClasses: "center",
            };
            $("#name").easyAutocomplete(options);
        } );
    </script>

</head>
<body>
<div class="container">
    <h1>Search for a user</h1>
    <h2>Start by typing a name below</h2>
    <form action="userinfo.php" method="post">
        <input id="name" name="user" type="text" placeholder="Full Name" required autofocus>
        <br>
        <button id="submit" type="submit" class="button">Submit</button>
    </form>
    <br>
    <button class="button" onclick="window.location.href='login.php?a=o'">Back</button>
    <button class="button" onclick="window.location.href='login.php?a=d'">Deactivate</button>

    <h3>Deactivation prevents anyone else from using this device</h3>


</div>
</body>
</html>