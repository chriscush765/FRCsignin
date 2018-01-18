<?php
include_once '../includes/tools.php';

//authentication stuff
if ($_SESSION['adminpass'] == null) {
    redirect('admin/login.php');
}

if (md5($_SESSION['adminpass']) != $adminpassword) {
    redirect('login.php?error=wp');
}

if (isset($_POST["numlogs"]))
    $numlogs = $_POST["numlogs"];
else
    $numlogs = "5"; //number of log files to fetch


$name = $_POST["user"];

if (!isset($_POST["id"])) {
    if ($stmt = $con->prepare("SELECT * FROM students WHERE NAME=?")) {
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->fetch();
        $stmt->close();
    }
    $ID = $result['ID'];
    $active = $result['ACTIVE'];
    $totaltime = $result['TOTALTIME'];
} else {
    $ID = $_POST['id'];
    $active = $_POST['active'];
    $totaltime = $_POST['totaltime'];
}


$datein = array();
$dateout = array();

if ($stmt = $con->prepare("SELECT DATEIN,DATEOUT FROM LOGS where ID = ? order by DATEIN desc limit ?")) {
    $stmt->bind_param("ii", $ID, $numlogs);
    if (!$stmt->execute())
        fancydie(mysqli_error($con));
    $stmt->bind_result($argdatein, $argdateout);
    while ($stmt->fetch()) {
        $datein[] = $argdatein;
        $dateout[] = $argdateout;
    }
    $stmt->close();
}

$con->close();


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


    <title>MidKnight Inventors</title>
</head>
<body>
<div class="container fade-in one">
    <div class="mini red">
        <h1><?php echo ucwords($name);?></h1>
    </div>
    <div class="mini white">
        <h2>User Information</h2>
        <h2>ID: <?php echo $ID; ?></h2>
        <h2><?php echo($active == 1 ? "Currently logged in" : "Currently not logged in"); ?></h2>
    </div>
    <br>
    <?php printf("<h2>Here are the last %s sign-ins</h2>", $numlogs);
    foreach (array_combine($datein, $dateout) as $in => $out) {
        $seconds = round(strtotime($out) - strtotime($in));
        $sessiontime = sprintf('%02d:%02d:%02d', ($seconds / 3600), ($seconds / 60 % 60), $seconds % 60);


        echo("<div class=\"date\">");
        echo("<div class='datetop'>" . date('n-j-Y', strtotime($in)) . "</div>");
        echo($sessiontime . "</div>");
    }
    ?>

    <form action="userinfo.php" method="post">
        <?php
        printf('<input type="hidden" name="user" value="%s">', $name);
        printf('<input type="hidden" name="id" value="%s">', $ID);
        printf('<input type="hidden" name="active" value="%s">', $active);
        printf('<input type="hidden" name="totaltime" value="%s">', $totaltime);
        printf('<input type="text" autocomplete="off" pattern="^[0-9]*$" name="numlogs" placeholder="show %s entries"', $numlogs);
        ?>
        <br>
        <input class="button" type="submit" value="Update">
    </form>

    <button class="button fade-in five" onclick="window.location.href='index.php'">Back</button>

</div>
</body>
</html>